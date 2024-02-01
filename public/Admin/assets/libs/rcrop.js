;(function ($) {

    $.rcrop = {
        
        //Global settings for all instances
        settings : {
            full : false,
            minSize : [20, 20],
            maxSize : [null, null],
            preserveAspectRatio : false,
            inputs : true,
            inputsPrefix : '',
            grid : false,
            
            preview : {
                display : false,
                size : [50, 50], //Also: ['100%', '100%'],
                wrapper : ''
            }
            
        }

    };
    
    ResponsiveCrop = function (el, options) {
        
        //private properties
        var self = this,
            prefix = 'rcrop-',
            initValues = {
                x :0,y:0,width:0,height:0
            };

        //public properties
        this.el = el instanceof $ ? el : $(el);
        this.image = {
            instance : null,
            width : 0,
            height : 0
        };
        this.wrapper = $('<div>', {class: prefix + 'wrapper'});
        this.cropArea = $('<div>', {class : prefix + 'croparea' });
        
        this.cropData = {
            width : 0,
            height : 0,
            x : 0,
            y : 0
        };
        
        this.outer = {
            wrapper : $('<div>', {class : prefix + 'outer-wrapper'}),
            left : $('<div>', {class : prefix + 'outer ' + prefix + 'outer-left' }),
            right : $('<div>', {class : prefix + 'outer ' + prefix + 'outer-right' }),
            top : $('<div>', {class : prefix + 'outer ' + prefix + 'outer-top' }),
            bottom : $('<div>', {class : prefix + 'outer ' + prefix + 'outer-bottom' })
        };
        this.cropAspectRatio;
        this.preview = null;
        this.clayfy; //clayfy instance
        
        this.settings = $.extend(true, {}, $.rcrop.settings, options);
        
        
        //private methods
        
        var init = function(){
            self.cropAspectRatio = self.settings.minSize[0]/self.settings.minSize[1];
            setContext();
            
            if(self.settings.preview.display)
                setPreview();
           
            self.getRealSize( function(){
                setCropArea();
                self.el.trigger(prefix + 'ready');
            });
        };
        
        var setContext = function(){
            self.wrapper.insertAfter(self.el);
            self.wrapper.append(self.el);
            self.wrapper.append(self.outer.wrapper);
            self.outer.wrapper.append(self.outer.left, self.outer.right, self.outer.top, self.outer.bottom);
            self.wrapper.append(self.cropArea);
            
            self.cropArea.append('<div class="' + prefix + 'croparea-inner">');
            
            if(self.settings.grid){
                var grid = '<div class="'+prefix+'grid-line"></div>';
                self.cropArea.append('<div class="'+prefix+'grid">'+ grid + grid +'</div>');
            }
            
            addHandlers();
            
            if(self.settings.inputs){
                var indexPrefix = (self.settings.inputsPrefix != 0)? self.settings.inputsPrefix + '-' : '';
                var inputs = ['x', 'y', 'width', 'height'];
                $.each(inputs, function(i, coord){
                    self.wrapper.append('<input type="hidden" name="' + indexPrefix + coord + '[]">');
                });
            }

        };
        
        var addHandlers = function(){
            var handlerWr = $('<div class="'+prefix+'handler-wrapper"></div>');
            
            //if is touchable, only append right bottom corner handler
            if(isTouchDevice()){
                handlerWr.append('<div class="'+prefix+'handler-bottom-right '+prefix+'handler-corner"></div>');
            }else{
                $.each(['top-left', 'top-right', 'bottom-left', 'bottom-right' ], function(i, pos){
                    handlerWr.append('<div class="'+prefix+'handler-'+pos+' '+prefix+'handler-corner"></div>');
                });
                $.each(['top', 'right', 'bottom', 'left' ], function(i, pos){
                    handlerWr.append('<div class="'+prefix+'handler-'+pos+' '+prefix+'handler-border"></div>');
                });
            }
            self.cropArea.append(handlerWr);
        };

        /*
         * ChangeStart is fired with resize or drag event start. Store initial
         * position and dimensions of cropArea. Then, when drag or resize end,
         * application can check which values have been changed. 
         */
        var changeStart = function(){
            var pos = self.cropArea.position();
            initValues = {
                width : Math.round(self.cropArea.width()),
                height : Math.round(self.cropArea.height()),
                x : Math.round(pos.left),
                y : Math.round(pos.top),
            }
        }
        var changeEnd = function(){
            var pos = self.cropArea.position(),
                width = initValues.width !== Math.round(self.cropArea.width()),
                height = initValues.height !== Math.round(self.cropArea.height()),
                x = initValues.x !== Math.round(pos.left),
                y = initValues.y !== Math.round(pos.top);
            updateCropData(width, height, x, y);
        }
        
        /**
         * Update data to crop.
         * This will be triggered only on drop and on resizeend to speed up app.
         * You can pass numbers to update, leave them empty (if you like to automatic
         * update) or pass FALSE if you like a value not to be updated.
         */
        var updateCropData = function(width, height, x, y){
            if(width !== false){
                self.cropData.width = typeof width === "number" ? width : toAbsoluteValue(self.clayfy.newSize.width);
                self.cropData.width = Math.max(self.cropData.width, self.settings.minSize[0]);
                if(self.settings.maxSize[0])
                    self.cropData.width = Math.min(self.cropData.width, self.settings.maxSize[0]);
            }
            if(height !== false){
                self.cropData.height = typeof height === "number" ? height : toAbsoluteValue(self.clayfy.newSize.height);
                self.cropData.height = Math.max(self.cropData.height, self.settings.minSize[1]);
                if(self.settings.maxSize[1])
                    self.cropData.height = Math.min(self.cropData.height, self.settings.maxSize[1]);
            }
            if((height !== false || width !== false) && self.settings.preserveAspectRatio){
                var limitW = {
                    max : (self.settings.maxSize[0] || self.image.width),
                    min : self.settings.minSize[0]
                };
                if(self.cropData.height * self.cropAspectRatio > limitW.max || self.cropData.height * self.cropAspectRatio < limitW.min){
                    self.cropData.height = Math.round(self.cropData.width / self.cropAspectRatio);
                }else{
                    self.cropData.width = Math.round(self.cropData.height * self.cropAspectRatio);
                }
            }
            
            if(x !== false){
                self.cropData.x = typeof x === 'number' ? x : toAbsoluteValue(self.clayfy.newSize.left);
                if(self.cropData.x + self.cropData.width > self.image.width)
                    self.cropData.x = self.image.width - self.cropData.width;
            }
            if(y !== false){
                self.cropData.y =  typeof y === 'number' ? y :  toAbsoluteValue(self.clayfy.newSize.top);
                if(self.cropData.y + self.cropData.height > self.image.height)
                    self.cropData.y = self.image.height - self.cropData.height;
            }
            
            //Send values to inputs
            if(self.settings.inputs)
                 $.each(['width', 'height', 'x', 'y'], function(i, coord){
                    self.wrapper.find('[name$="'+coord+'[]"]').val(self.cropData[coord]);
                });
            
            //Update preview with cropData
            if(self.settings.preview.display)
                updatePreview();

        }

        
        /**
         * Transform cropArea and outers values to percentage.
         */
        var toPercentage = function(){
            var realSize = self.el[0].getBoundingClientRect(), //get with decimals
                iW = realSize.width,
                iH = realSize.height,
                clayfySize = self.clayfy.newSize,
                size = {
                    width : clayfySize.width,
                    height : clayfySize.height,
                    top : clayfySize.top,
                    left : clayfySize.left
                };
                
            //CropArea size to percentage 
            self.cropArea.css({
                width : size.width/iW*100 + '%',
                height : size.height/iH*100 + '%',
                top : size.top/iH*100 + '%',
                left : size.left/iW*100 + '%'
            });
            
           //Outers size to percentage  
           self.outer.left.width(size.left/iW*100 + '%');
           self.outer.top.height(size.top/iH*100 + '%');
           self.outer.bottom.css({top : (size.top + size.height)/iH*100 + '%'});
           self.outer.right.css({left : (size.left + size.width)/iW*100 + '%'});
        }
        
        /**
         * Resize outers taking cropArea sizes
         */
        var resizeOuters = function(){
           //Get the new Size from Clayfy's property
           var size = self.clayfy.newSize;
           self.outer.left.width(size.left );
           self.outer.top.height(size.top );
           self.outer.bottom.css({top : size.top + size.outerHeight});
           self.outer.right.css({left : size.left + size.outerWidth});
        };
        
        var updateClayfySettings = function(){
            var s = self.settings,
                cS = self.clayfy.settings;
            cS.minSize = toRelativeValue(s.minSize);
            cS.maxSize = toRelativeValue(s.maxSize);
            self.clayfy.draggable.setBounderies();
        };
        
        
        var setCropArea = function(){ 
            var s = self.settings;

            //Instance Clayfy
            self.cropArea.clayfy({
                type : 'resizable',
                container : self.wrapper,
                preserveAspectRatio : s.preserveAspectRatio,
                minSize: toRelativeValue(s.minSize),
                maxSize: toRelativeValue(s.maxSize)
            });
            self.clayfy = self.cropArea.clayfy('instance');
            
            //Override clayfy's originalSize to preserve aspect ratio correctly.
            self.clayfy.originalSize.width = self.settings.minSize[0];
            self.clayfy.originalSize.height = self.settings.minSize[1];
            
            //Define cropArea size
            var height = !s.full ? Math.max( self.image.height * 0.8, s.minSize[1]) : self.image.height,
                width = !s.full ? Math.max(self.image.width * .8, s.minSize[0]) : self.image.width; 
            self.resize(width, height, 'center', 'center');

            //Bind events
            //self.cropArea.on('clayfy-beforeresize', updateClayfySettings);
            self.cropArea.on('mousedown touchstart', updateClayfySettings);         
            self.cropArea.on('clayfy-resizestart clayfy-dragstart', changeStart);
            self.cropArea.on('clayfy-resizeend clayfy-drop', changeEnd);
            
            self.cropArea.on('clayfy-resize clayfy-drag', resizeOuters);

            if(self.settings.preview.display){
                self.cropArea.on('clayfy-resize clayfy-drag', updatePreview);
                self.cropArea.on('clayfy-cancel', updatePreview);
            }
            self.cropArea.on('clayfy-resizeend clayfy-drop', toPercentage);
            self.cropArea.on('clayfy-cancel', toPercentage);
            
            self.cropArea.on('clayfy-resizeend clayfy-drop', function(){
                self.el.trigger(prefix+'changed', [self]);
            });
            self.cropArea.on('clayfy-drag clayfy-resize', function(){
                self.el.trigger(prefix+'change', [self]);
            });

        };
        
        var getPreviewSize = function(){
            var previewSize = self.settings.preview.size,
                size = [],
                cropAreaSize = self.clayfy ? self.clayfy.newSize : {width : self.cropArea.width(), height : self.cropArea.height()};
            if(typeof previewSize[0] === 'string' && previewSize[0].indexOf('%')>-1){
                
                size[0] = Number(previewSize[0].replace('%', '')) / 100 * cropAreaSize.width;
            }else{
                size[0] = previewSize[0];
            }
            if(typeof previewSize[1] === 'string' && previewSize[1].indexOf('%')>-1){
                size[1] = Number(previewSize[1].replace('%', '')) / 100 * cropAreaSize.height;
            }else{
                size[1] = previewSize[1];
            }
            return size;
        };
        
        var setPreview = function(){
            var wrPrev = self.settings.preview.wrapper;
            if(wrPrev)
                wrPrev = wrPrev instanceof $ ? wrPrev : $(wrPrev);
            
            if(!wrPrev || !wrPrev.length){
                wrPrev = $('<div>', {class : prefix + 'preview-wrapper'});
                self.wrapper.after(wrPrev);
            }
            
            var size = getPreviewSize();
            self.preview = $('<canvas width="' + size[0] + '" height="' + size[1] + '"></canvas>');
            self.preview.appendTo(wrPrev);
            
        };
        
        /*
         * Update preview image from clayfy newsize info. 
         * This will be triggered on resizing and on dragging. 
         */
        var updatePreview = function(e){
            var data = self.cropData;
            
            if(e)
                data = toAbsoluteValue({
                    width : self.clayfy.newSize.width,
                    height : self.clayfy.newSize.height,
                    x : self.clayfy.newSize.left,
                    y : self.clayfy.newSize.top
                });
            
            var newSize = getPreviewSize();
            self.preview.attr({width: newSize[0], height: newSize[1]});
            var ctx = self.preview[0].getContext('2d');
            ctx.drawImage(self.image.instance, data.x, data.y, data.width, data.height, 0, 0, newSize[0], newSize[1]);
        };

        var translateValue = function(value, coef){
            if(typeof value === 'object'){
                var newValue = value instanceof Array ? [] : {};
                for(var i in value){
                    newValue[i] = typeof value[i] != 'number' ? null : Math.round(value[i] * coef);
                }
                return newValue;
            
            }else{
                return Math.round(value * coef);
            }
        };
        
        var toRelativeValue = function(value){
            return translateValue(value, self.el.width() / self.image.width);
        };
        
        var toAbsoluteValue = function(value){
            return translateValue(value, self.image.width / self.el.width());
        };
        
        //public properties
        
        this.getValues = function(){
            //updateCropData();
            return {
                width : self.cropData.width,
                height : self.cropData.height,
                y : self.cropData.y,
                x : self.cropData.x
            };
        };
        
        this.getRealSize = function(callback){
            var img = new Image();
            img.setAttribute('crossOrigin', 'anonymous');
            img.onload = function () {
                self.image.width = this.width; 
                self.image.height = this.height; 
                if(typeof callback === 'function') callback();
                return {
                    width : self.image.width, 
                    height : self.image.height
                };
            };
            img.onerror = function(){
                return {
                    width: null, 
                    height: null
                };
            };
            img.src = self.el.attr('src');
            self.image.instance = img;
            
        };
        
        this.getDataURL = function(width, height){
            width = width || self.cropData.width;
            height = height || self.cropData.height;
            var canvas = $('<canvas width="' + width + '" height="' + height + '"></canvas>');
            var ctx = canvas[0].getContext('2d');
            ctx.drawImage(self.image.instance, self.cropData.x, self.cropData.y, self.cropData.width, self.cropData.height, 0, 0,width, height);
            return canvas[0].toDataURL();
        };
        
        this.resize = function(width, height, x, y){

            var s = self.settings,
                relativeWidth, relativeHeight, relativeX, relativeY;
            
            width = s.maxSize[0] ? Math.min(width, self.image.width, s.maxSize[0]) : Math.min(width, self.image.width);
            height = s.maxSize[1] ? Math.min(height, self.image.height, s.maxSize[1]) : Math.min(height, self.image.height);
            width = s.minSize[0] ? Math.max(width, s.minSize[0]) : width;
            height = s.minSize[1] ? Math.max(height, s.minSize[1]) : height;

            if (s.preserveAspectRatio) {
                if (width / height > self.cropAspectRatio) {
                    width = height * self.cropAspectRatio;
                } else {
                    height = width / self.cropAspectRatio;
                }
            }
            width = Math.round(width);
            height = Math.round(height);
            
            relativeWidth = toRelativeValue(width);
            relativeHeight = toRelativeValue(height);
            
            if(typeof y === 'undefined'){
                y = self.cropArea.position().top;
            }else if(y === 'center'){
                y = Math.round((self.image.height - height )/2);
            }else{
               y = Math.round(y);
            }
            if(y+height > self.image.height)
                y = self.image.height - height;
            relativeY = toRelativeValue(y);
            
            if(typeof x === 'undefined'){
                x = !self.cropData.x ? self.cropData.x : toAbsoluteValue(self.cropArea.position().left);
            }else if(x === 'center'){
                x = Math.round(( self.image.width - width )/2);
            }else{
                x = Math.round(x)
            }
            if(x+width > self.image.width)
                x = self.image.width - width;
            relativeX = toRelativeValue(x);

            self.cropArea.css({
                width : relativeWidth,
                height : relativeHeight,
                top : relativeY,
                left : relativeX
            });
            
            self.clayfy.newSize = self.clayfy.getNewSize();

            updateCropData(width, height, x, y);

            resizeOuters();
            toPercentage();
            
            if(self.settings.preview.display)
                updatePreview();
        };
        
        this.destroy = function(){
            var image = self.el;
            self.wrapper.replaceWith(image);
            image.attr('style', '');
        };

        init();
    };
    

    //jQuery Plugin
    var pluginName = 'rcrop';
    var Plugin = ResponsiveCrop;

    $.fn[pluginName] = function (options) {
        var args = arguments;
        
        if (options === undefined || typeof options === 'object') {
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName, new Plugin(this, options));
                }
            });
        } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
            if(options === 'instance'){
                if(!this.length)
                    return null;
                return $.data(this[0], pluginName);
            }
            
            if ($.inArray(options, $.fn[pluginName].getters) != -1) {
                var instance = $.data(this[0], pluginName);
                return instance[options].apply(instance, Array.prototype.slice.call(args, 1));
            
            } else {
                return this.each(function () {
                    var instance = $.data(this, pluginName);
                    if (instance instanceof Plugin && typeof instance[options] === 'function') {
                        instance[options].apply(instance, Array.prototype.slice.call(args, 1));
                    }
                    if(options === 'destroy')
                        $(this).removeData(pluginName);
                });
            }
        }
    };
    $.fn[pluginName].getters = ['getDataURL', 'getValues', 'getRealSize'];

})(jQuery);



/**
 * 
 * 
 */

(function($){

$.clayfy = {
    dX : 0,
    dY : 0,
    container : function(element, values){
        return new DraggableContainer(element, values);
    },
    
    //global settings:
    settings : {
        type : 'draggable',
        bounderies : [10000000,10000000,10000000,10000000],
        container : '', //CSS Selector, Array (top, right, bottom, left) or an instance of DraggableContainer (you can use $.clayfy.container(...))
        moveX: true,
        moveY : true,
        move : true,
        not : '', //CSS selector. Exclude childs when click
        ghost : false,
        coverScreen : true, //Boolean. Cover screen with layer for easily drag all over the screen (also, over iframes)
        scrollable : '', //CSS Selector or JQuery instance. By default, conainer is scrollable. Turn to false to not scroll
        droppable : '', //CSS Selector or JQuery instance where is allowed to drop
        fit : true, //Bool. Fit inside drop area when drop inside.
        dropoutside : false, //Bool. Allow to drop outside droppable area
        migrate : false, //Bool. Change parent after drop inside drop area
        overflow : false, // Bool. Element will be temporaly append to an helper container outside parent
        escape : true, //cancel dragging with esc key
        propagate : true,
        
        //Only resizable
        preserveAspectRatio : false,
        maxSize : [500, 200],
        minSize : [100,50],
        left : true,
        top: true,
        right : true,
        bottom : true,
        className : '',

        //Only sortable
        siblings : '',
        export : true, //allow export item to another parent
        
        dragstart : function(e){},
        drag : function(e){}, //this = draggable
        drop : function(e){}
    },
    
    getInner : function(element){
        var el  = element instanceof $? element : $(element),
            stylePos, helper, helperWr, innerWidth, innerHeight, borderTop, borderLeft;
        if(!el.length)
            return {width : 0, height : 0};
        
        stylePos = el[0].style.position;
        if(el.css('position') === 'static')
            el.css({position: 'relative'});
        helperWr = $('<div>', {style: 'position:absolute;top:0;left:0;bottom:0;right:0'});
        helper = $('<div>', {style: 'position:absolute;top:0;left:0;width:100%;height:100%'});
        helperWr.append(helper);
        el.append(helperWr);
        innerWidth = helper.width();
        innerHeight = helper.height();
        helperWr.remove();
        el[0].style.position = stylePos;
        
        return  {
            innerWidth: innerWidth,
            innerHeight: innerHeight
        };
    }
    
};

function Clayfy(el, options){
    this.instance;
    var self = this;
    var options = $.extend(true, {}, $.clayfy.settings, options);
    
    switch(options.type){
        case 'draggable' : 
            self.instance = new Draggable(el, options);
            break;
        case 'resizable' : 
            self.instance = new Resizable(el, options);
            break;
        case 'sortable' : 
            self.instance = new Sortable(el, options);
            break; 
    }
}


/**
 * Make an element draggable.
 * Events available: clayfy-drag, clayfy-dragstart, clayfy-drop, dragenter, dragleave, 
 * dropinside, dropoutside
 * 
 * @param {mix} el
 * @param {object} options
 *
 */
function Draggable(el, options){
    this.el = (el instanceof $)? el : $(el);
    this.draggableBox;
    this.x;
    this.y;
    this.dX;
    this.dY;
    this.diffDX;
    this.diffDY;
    this.history = {
        dX: [0, 0, 0],
        dY: [0, 0, 0],
        diffDX: 0,
        diffDY: 0
    };
    
    this.actualPos;
    this.originalPos;
    this.initPos = {y:0, x:0 , scrollTop:null, scrollLeft:null };
    this.bounderies = {};
    this.droppedTarget;
    this.scrollable = [];
    this.container = {}; //instance of DraggableContainer
    this.tempContainer = $('<div>', {style : 'position: absolute; top:0; left:0'});
    this.droppable = {dragElement : [], dropArea : [] };
    this.status = 'ready';
    
   
    this.settings = $.extend(true, {}, $.clayfy.settings, options);
    
    //private properties
    var self = this,
        move = false,
        first = true,
        cursor, notDraggable,
        screenCoverLayer = $('<div>', {style:"height:100%;width:100%;position:fixed;top:0;left:0"});

    //private methods
    var init = function () {
        self.originalPos = self.getPosition();
        self.actualPos = self.originalPos;
        
        setContainer();
        setDraggableBox();
        self.el.addClass('clayfy-box');
        if(!self.settings.move)
            self.el.addClass('clayfy-not-move');
        cursor = self.el.css('cursor');

        notDraggable = $(self.settings.not);
        
        //self.droppable = (self.settings.droppable instanceof $)? self.settings.droppable : $(self.settings.droppable);
        
        if(self.settings.overflow)
            $('body').append(self.tempContainer);
        
        //Bind events
        self.el.on('mousedown touchstart', mousedown);
        $('body').on('mouseup touchend', mouseup);
        
        //if overflow is activate . (Bug: It does not work with Contaier array)
        
        //bind event if escape key were press
        if (self.settings.escape) {
            self.el.on('clayfy-dragstart', function (e) {
                e.stopPropagation();
                $(window).on('keydown', keydownObserver);
            });
            self.el.on('clayfy-drop', function () {
                $(window).off('keydown', keydownObserver);
            });
        }
        
        //set Scrollable
        if(self.settings.scrollable !== false && self.container.type === 'node'){
            if(!(self.settings.container instanceof DraggableContainer)){
                
                if(typeof self.settings.scrollable === 'string'){
                    self.settings.scrollable = self.settings.scrollable? self.settings.scrollable + ' , ' + self.settings.container : self.settings.container;
                }else if(self.settings.scrollable instanceof $){
                    self.settings.scrollable = self.settings.scrollable.add(self.settings.container);
                }
            }
        }
         self.el.on('clayfy-dragstart', setScrollable);
         self.el.on('clayfy-drag', scrollableObserver);
         self.el.on('clayfy-drop', stopScroll);
         
         //
        if(self.settings.droppable != 0){
            self.updateDragElement();
            self.updateDropArea();
            bindDropEvents();
        }else if(self.settings.ghost){
            self.el.on('clayfy-drop', dropGhost);
        }
        

    };
    
    /*Define draggable box and all about ghost */
    this.contentGhost;
    var setDraggableBox = function(){
        if(self.settings.ghost){
            
            if(self.settings.ghost === true){
                self.draggableBox = self.el.clone();
                 self.draggableBox.addClass('clayfy-ghost-opacity');
            }else{
                self.draggableBox = $('<div>', {margin: self.el.css('margin')});
                self.contentGhost = $('<div class="clayfy-ghost-content" style="position:absolute"></div>');
                self.draggableBox.append(self.contentGhost);
            }
            self.draggableBox.css({position: 'absolute', width : '100%', height : '100%'}).addClass('clayfy-ghost');
        }else{
            self.draggableBox = self.el;
        }
        
    };
    
    /*start Ghost*/
    
    var updateGhost = function(e){
        var pos = self.getPosition(self.el),
            c = self.settings.overflow? self.tempContainer : self.el.parent(),
            offset = self.el.offset(),
            scrTop = self.initPos.parent ? self.initPos.parent.scrollTop() : 0,
            scrLeft = self.initPos.parent ? self.initPos.parent.scrollLeft() : 0,
            css = {
                width : self.el.width(),
                height: self.el.height(),
                top: pos.y,
                left: pos.x
            };

        if(self.settings.ghost !== true){
            css = {
                top: e.pageY - offset.top + pos.y + 5 - scrTop, 
                left : e.pageX - offset.left + pos.x + 5 - scrLeft,
                width: 'auto',
                height: 'auto'
            };
        }
        if(self.settings.overflow){
            css.top = offset.top - scrTop;
            css.left = offset.left - scrLeft;
            
            if(self.settings.ghost !== true){
                css.top = e.pageY - scrTop + 5;
                css.left = e.pageX - scrLeft + 5;
            }
        }
        self.draggableBox.css(css);
        self.draggableBox.appendTo( c );
        
        if(self.contentGhost){
            self.contentGhost.html('');
            var  content;
            switch(typeof self.settings.ghost){
                case 'string' : 
                    content = self.settings.ghost;
                    break;
                case 'function' : 
                    content = self.settings.ghost();
                    break;
            }
            self.contentGhost.append(content);
            
            if(self.container.offset){
                var cBottom = self.container.offset.innerBottom;
                var cRight = self.container.offset.innerRight;
                var ghostOffset = self.draggableBox.offset();
                var bottomDiff = ghostOffset.top + self.contentGhost.outerHeight() - cBottom;
                var RightDiff = ghostOffset.left + self.contentGhost.outerWidth() - cRight;
               
                if(bottomDiff > 0)
                    self.draggableBox.css({top : e.pageY - offset.top + pos.y + 5 - bottomDiff });
                if(RightDiff > 0)
                    self.draggableBox.css({left : e.pageX - offset.left + pos.x + 5 - RightDiff });
            }
            
        }
    };
    var dropGhost = function(e){
        if(self.status !== 'canceling'){
            
            if(self.settings.move){
                var pos = self.getPosition();
                var offset = self.draggableBox.offset();
                var d = self.contentGhost ? self.contentGhost : self.draggableBox;
                
                if(self.container.offset){
                    var cBottom = self.container.offset.innerBottom;
                    var cRight = self.container.offset.innerRight;

                    if(offset.top >= cBottom - self.el.outerHeight())
                        pos.y += cBottom - self.el.outerHeight() - offset.top;

                    if(offset.left >= cRight - self.el.outerWidth()){
                        pos.x += cRight - self.el.outerWidth() - offset.left;
                    }
                }
                self.el.css({
                    top : pos.y,
                    left : pos.x
                });
                if(e.type === 'clayfy-dropinside'){
                    var cBottom = e.area.offset.innerBottom;
                    var cRight = e.area.offset.innerRight;

                    if(offset.top >= cBottom - self.el.outerHeight())
                        pos.y += cBottom - self.el.outerHeight() - offset.top;

                    if(offset.left >= cRight - self.el.outerWidth()){
                        pos.x += cRight - self.el.outerWidth() - offset.left;
                    }
                    self.el.css({
                        top : pos.y,
                        left : pos.x
                    });
                }

            }
        }
        self.draggableBox.detach();
 
    };
    
    /*Container*/
    var setContainer = function(){
        var c = self.settings.container;
        if(c instanceof DraggableContainer){
            self.container = c; 
        }else if(self.settings.container){
            self.container = new DraggableContainer(self.el, c); 
        }
    };
    
  
    /*Cancel*/
    var keydownObserver = function (e) {
        if (e.keyCode === 27) {
            self.cancel(e);
        }
    };
    
    this.cancel = function(e){
        self.status = 'canceling';
        self.draggableBox.animate({top : self.initPos.y, left : self.initPos.x}, 100, function(){
            self.draggableBox.trigger('mouseup');
            self.status = 'ready'; 
        });
        
        if(self.initPos.scrollTop !== null)
            self.initPos.parent.animate({scrollTop :self.initPos.scrollTop}, 100);
        if(self.initPos.scrollLeft !== null)
            self.initPos.parent.animate({scrollLeft :self.initPos.scrollLeft}, 100);
    };
    
    
    /*
     * Scroll over scrollable bounderies
     */
    self.scrollables = [];
    var scrDown, scrUp, scrLeft, scrRight;

    var setScrollable = function(){
        var scrollable = $(self.settings.scrollable);
        scrollable.each(function(){
            var $this = $(this);
            if(!$this.length)
                return true;
            var overflow = isOverflowed($this);
            if(!overflow.x && !overflow.y)
                return true;
            
            var o = $this[0].getBoundingClientRect();
            var dimension = getDimension($this);
            var borderTop = parseInt($this.css('border-top-width'));
            var borderLeft = parseInt($this.css('border-left-width'));

            var obj = {
                el : $this,
                top: o.top + borderTop,
                bottom : o.top + dimension.innerHeight + borderTop,
                left : o.left + borderLeft,
                right : o.left + dimension.innerWidth + borderLeft,
                innerHeight : dimension.innerHeight,
                innerWidth : dimension.innerWidth,
                interval : {
                    top : false,
                    bottom : false,
                    left : false,
                    right : false
                },
                isParent : self.settings.overflow ? false : self.el.offsetParent().is($this),
                isBody : $this.is('body')
            };
            if(obj.isBody){
                var $w = $(window);
                obj.top = 0;
                obj.left = 0;
                obj.bottom = $w.height();
                obj.right = $w.width();
                obj.innerHeight = $w.height();
                obj.innerWidth = $w.width();
            }
                
            self.scrollables.push(obj);
        });
    };
    var isOverflowed = function(scrollable){
        var x= false,
            y = false,
            $w = $(window),
            $b = $('body');
        if(scrollable.is('body')){
            if( $b.height() > $w.height())
                y = true;
            if( $b.width() > $w.width())
                x = true;
        }else{
            if(scrollable[0].scrollHeight > scrollable.height())
                y = true;
            if(scrollable[0].scrollWidth > scrollable.width())
                x = true;
        }
        return {x : x , y : y};
    };
    
    var getDimension = function(element){
        var el  = element instanceof $? element : $(element),
            stylePos, helper, helperWr, innerWidth, innerHeight, borderTop, borderLeft;
        if(!el.length)
            return {width : 0, height : 0};
        
        stylePos = el[0].style.position;
        if(el.css('position') === 'static')
            el.css({position: 'relative'});
        helperWr = $('<div>', {style: 'position:absolute;top:0;left:0;bottom:0;right:0'});
        helper = $('<div>', {style: 'position:absolute;top:0;left:0;width:100%;height:100%'});
        helperWr.append(helper);
        el.append(helperWr);
        innerWidth = helper.width();
        innerHeight = helper.height();
        borderTop = parseInt(helper.css('border-top-width'));
        borderLeft = parseInt(helper.css('border-left-width'));
        helperWr.remove();
        el[0].style.position = stylePos;
        
        return  {
            innerWidth: innerWidth,
            innerHeight: innerHeight,
            innerOffset : {
                top : borderTop,
                left : borderLeft,
                bottom : innerHeight + borderTop,
                right : innerWidth + borderLeft
            }
        };
    };
    
    function isAtBottom(scrollable){
       return scrollable.el[0].scrollHeight - scrollable.el.scrollTop() === scrollable.innerHeight;
    };
    
    function isAtRight(scrollable){
       return scrollable.el[0].scrollWidth - scrollable.el.scrollLeft() === scrollable.innerWidth;
    };
    
    
    /*FALTA VER CóMO SOLUCIONAR LO DEL BODY*/
    var scrollableObserver = function(e){
        var d = self.contentGhost ? self.contentGhost : self.draggableBox;
        var o = self.draggableBox[0].getBoundingClientRect();
        var dOffset = d.offset();
        var padding = 6;
        var el = {
            top: o.top,
            bottom : o.top + d.outerHeight(),
            left : o.left,
            right : o.left + d.outerWidth(),
            x : 0,
            y : 0
        };
        el.x = (el.right - el.left) / 2 + el.left;
        el.y = (el.bottom - el.top) / 2 + el.top;
        
        //If parent is scrollable and it has been scrolled (down, up, left, right)...
        if (self.history.diffDY > 0 && scrDown) {
            scrDown = false;
            self.y = Math.min(dOffset.top + d.outerHeight(), e.pageY);
        }
        if (self.history.diffDY < 0 && scrUp) {
            scrUp = false;
            self.y = Math.max(dOffset.top, e.pageY);
        }
        if (self.history.diffDX > 0 && scrRight) {
            scrRight = false;
            self.x = Math.min(dOffset.left + d.outerWidth(), e.pageX);
        }
        if (self.history.diffDX < 0 && scrLeft) {
            scrLeft = false;
            self.x = Math.max(dOffset.left, e.pageX);
        }
        
        //
        for(var i = 0, j = self.scrollables.length; i<j; i++){
            var s = self.scrollables[i];
            var trigger = 0;
            var val = {
                top : el.top - s.top,
                bottom : s.bottom - el.bottom,
                left : el.left - s.left,
                right : s.right - el.right,
                x : el.x < s.right && el.x > s.left,
                y : el.y < s.bottom && el.y > s.top
            };
            
            if(!isAtBottom(s) && val.bottom  < padding  && (val.bottom  > - padding || s.isBody) && val.x){
                startScroll(e, s, 'bottom');
                stopScroll(s, 'top');
                trigger++;
            }else{
                stopScroll(s, 'bottom');

                if(s.el.scrollTop() && val.top < padding && (val.top  > -padding || s.isBody)  && val.x){
                    startScroll(e, s, 'top');
                    trigger++;
                }else{
                    stopScroll(s, 'top');
                }
            }
            if(s.el.scrollLeft() && val.left  < padding && (val.left > -padding || s.isBody) && val.y){
                startScroll(e, s, 'left');
                stopScroll(s, 'right');
                trigger++;
            }else{
                stopScroll(s, 'left');
            
                if(!isAtRight(s) && val.right  < padding && ( val.right > -padding || s.isBody ) && val.y){
                    startScroll(e, s, 'right');
                    trigger++;
                }else{
                    stopScroll(s, 'right');
                }
            }
            
            if(trigger)
                break;
        }
        
    };
    
    var startScroll = function(e, scrollable, toward){
        if(scrollable.interval[toward])
            clearInterval(scrollable.interval[toward]);
        var scrollToward = function(amount){};

        switch (toward) {
            case 'bottom' :
                scrollToward = function(amount){ 
                    amount = amount || 10;
                    scrollable.el.scrollTop(scrollable.el.scrollTop() + amount);
                    if(scrollable.isParent){
                        self.x = e.pageX;
                        self.setBounderies();
                        self.updateDropArea();
                        scrDown = true;
                    }
                };
                break;
            
            case 'top' :
                scrollToward = function(amount){ 
                    amount = amount || 10;
                    scrollable.el.scrollTop(scrollable.el.scrollTop() - amount); 
                    if(scrollable.isParent){
                        self.x = e.pageX;
                        self.setBounderies();
                        self.updateDropArea();
                        scrUp = true;
                    }
                };
                break; 
            case 'left' :
                scrollToward = function(amount){
                    amount = amount || 10;
                    scrollable.el.scrollLeft(scrollable.el.scrollLeft() - amount);
                    if(scrollable.isParent){
                        self.y = e.pageY;
                        self.setBounderies();
                        self.updateDropArea();
                        scrLeft = true;
                    }
                };
                break; 
            case 'right' :
                scrollToward = function(amount){ 
                    amount = amount || 10;
                    scrollable.el.scrollLeft(scrollable.el.scrollLeft() + amount);
                    if(scrollable.isParent){
                        self.y = e.pageY;
                        self.setBounderies();
                        self.updateDropArea();
                        scrRight = true;
                    }
                };
                break;
        }
        
        scrollToward(3); // scroll only 3 pixels when draggableBox is actualy being dragged.
        if(!scrollable.isParent)
            scrollable.interval[toward] = setInterval(scrollToward,50);
    };
    var stopScroll = function(scrollable, toward){
        if(!toward){
            for(var i in self.scrollables){
                var interval = self.scrollables[i].interval;
                for(var pos in interval){
                    if(interval[pos]){
                        clearInterval(interval[pos]);
                        interval[pos] = false;
                    }
                }
            }
        }else
        if(scrollable.interval[toward]){
            clearInterval(scrollable.interval[toward]);
            scrollable.interval[toward] = false;
        }
    };
    
    /*
     * Appends drag to element
     * @param (string|object) parent - CSS selector or JQuery Instance of HTML element to appent To.
     */
    this.appendTo = function(parent, el){
        el = el || self.el;
        parent = parent instanceof $ ? parent : $(parent);
        if(!parent.length)
            return;
        var oE = el.offset();
        var oP = parent.offset();
        var pos = {
            top : oE.top - oP.top - parseInt(parent.css('border-top-width')) + parent.scrollTop(),
            left : oE.left - oP.left - parseInt(parent.css('border-left-width'))  + parent.scrollLeft()
        };
        if(parent.css('position') === 'static')
            parent.css('position', 'relative');
        
        el.appendTo(parent).css(pos);
    };

    /**
     * Bind Droppable Events.
     */
    var bindDropEvents = function(){
        self.el.on('clayfy-dragstart', self.updateDragElement);
        self.el.on('clayfy-dragstart', self.updateDropArea);
        self.el.on('clayfy-drag', dragover);
        self.el.on('clayfy-drop', dropOnBox);
        if(self.settings.ghost ){
            self.el.on('clayfy-dropinside', dropGhost);
            self.el.on('clayfy-dropoutside', dropGhost);
        }
        
        //UI
        self.el.on('clayfy-dragstart', function(){
            var area = isOverDropArea();
            if(!area){
                self.el.removeClass('clayfy-dropinside');
                self.draggableBox.removeClass('clayfy-dropinside');
            }
        });
        /*
        self.el.on('clayfy-dragstart', function(){
            for (var i = 0, j = self.droppable.dropArea.length; i < j; i++) {
                var area = self.droppable.dropArea[i];
                if(!area.active)
                   area.el.removeClass('clayfy-dropinside');
            }
        })
        */
        self.el.on('clayfy-dragenter', function(e){
            self.el.addClass('clayfy-dragenter');
            self.draggableBox.addClass('clayfy-dragenter');
            e.droparea.addClass('clayfy-dragenter');
            if(self.el[0].id)
                e.droparea.addClass('clayfy-dragenter-'+self.el[0].id);
        });
        self.el.on('clayfy-dragleave', function(e){
            self.el.removeClass('clayfy-dropinside');
            self.draggableBox.removeClass('clayfy-dropinside');
            e.droparea.removeClass('clayfy-dropinside');
            if(self.el[0].id)
                e.droparea.removeClass('clayfy-dropinside-'+self.el[0].id);
        });
        self.el.on('clayfy-dragleave clayfy-drop', function(e){
            self.el.removeClass('clayfy-dragenter');
            self.draggableBox.removeClass('clayfy-dragenter');
            $('.clayfy-dragenter').removeClass('clayfy-dragenter');
            if(self.el[0].id)
                $('.clayfy-dragenter-'+self.el[0].id).removeClass('clayfy-dragenter-'+self.el[0].id);
        });
        self.el.on('clayfy-dropinside', function(e){
            self.el.addClass('clayfy-dropinside');
            self.draggableBox.addClass('clayfy-dropinside');
            e.droparea.addClass('clayfy-dropinside');
            if(self.el[0].id)
                e.droparea.addClass('clayfy-dropinside-'+self.el[0].id);
            
            if(self.settings.migrate)
                self.appendTo(e.droparea);
        });
    };
    

    
    /**
     * Update the list of droppables elements defined in settings
     */
    this.updateDropArea = function(e){
        self.droppable.dropArea = [];
        var droppables = (self.settings.droppable instanceof $) ? self.settings.droppable : $(self.settings.droppable);
        self.addDroppable(droppables);
    };
    
    this.updateDragElement = function(){
        self.droppable.dragElement = [];
        self.droppable.dragElement = {
            originalPos : self.getPosition(),
            id : self.el[0].id,
            originalDropArea : null,
            width: self.draggableBox.width(),
            height: self.draggableBox.height(),
            x : 0, 
            y : 0
        };
        var el = self.droppable.dragElement;
        el.setCenter = function(){
            var offset = self.draggableBox.offset();
            el.x = offset.left + el.width / 2;
            el.y = offset.top + el.height / 2;
        };
        el.setCenter();
        el.originalDropArea = isOverDropArea();
    };
    
    /**
     * Reset droppable defined in settings and update droppable list
     */
    this.resetDroppable = function(elements){
        if(elements)
            self.settings.droppable = elements;
        self.updateDragElement();
        self.updateDropArea();
    };
    
    /**
     * add elements to droppable list. Attention: this method does not redifine
     * droppable list. For redefine list, use resetDroppable method.
     */
    this.addDroppable = function(elements){
        var droppables = elements instanceof $ ? elements : $(elements);
        droppables.each(function () {
            var $this = $(this),
                offset = $this.offset(),
                height = $this.outerHeight(),
                width = $this.outerWidth(),
                borderTop =  parseInt($this.css('border-top-width')),
                borderLeft = parseInt($this.css('border-left-width')),
                inner = $.clayfy.getInner($this);

            self.droppable.dropArea.push({
                el: $this,
                id : this.id,
                left: offset.left,
                top: offset.top,
                width : width,
                height : height,
                innerWidth : inner.innerWidth,
                innerHeight : inner.innerHeight,
                offset : {
                    innerTop : offset.top + borderTop,
                    innerLeft : offset.left + borderLeft,
                    innerBottom : inner.innerHeight + offset.top + borderTop,
                    innerRight : inner.innerWidth + offset.left + borderLeft
                },
                right: offset.left + width,
                bottom: offset.top + height,
                active : false,
                triggered : false
            });
        });
    };
    
    /*
     * Drag over observer. It is triggered on dragging
     */
    var dragover = function(e){
        var el = self.droppable.dragElement;
        el.setCenter();
        
        for (var i = 0, j = self.droppable.dropArea.length; i < j; i++) {
            var area = self.droppable.dropArea[i];
            if(!area)
                continue;
            
            if (el.x > area.left && el.x < area.right && el.y > area.top && el.y < area.bottom){
                area.active = true;
            }else{
                 area.active = false;
            }

            if(!area.triggered && area.active){
                //enter to drop area
                area.triggered = true;
                self.el.trigger($.Event('clayfy-dragenter', {
                    target : area.el[0],
                    droparea : area.el
                }));
 
            }else if(area.triggered && !area.active){
                //leave drop area
                area.triggered = false;
                self.el.trigger($.Event('clayfy-dragleave', {
                    target : area.el[0],
                    droparea : area.el,
                    area : area
                }));
            }
        }
    };
    /*
     * 
     * @returns {Object} dropArea - Object of active dropArea
     */
    var isOverDropArea = function(){
        var el = self.droppable.dragElement;
        el.setCenter();
        var dropArea = false;
        for (var i = 0, j = self.droppable.dropArea.length; i < j; i++) {
            var area = self.droppable.dropArea[i];
            if(!area)
                continue;
            
            if (el.x > area.left && el.x < area.right && el.y > area.top && el.y < area.bottom){
                area.active = true;
                area.triggered = true;
                dropArea = area;
            }
        }
        return dropArea;
    };

    /**
     * Fit element inside droparea
     */
    var fitInside = function(dropArea){
        var d = self.contentGhost ? self.contentGhost : self.draggableBox;
        var css = {};
        var offset = self.el.offset();
        var el = {
            top : offset.top,
            left : offset.left,
            right : self.droppable.dragElement.width + offset.left,
            bottom : self.droppable.dragElement.height + offset.top
        };
        
        if(d.outerWidth() < dropArea.innerWidth){
            if(el.right > dropArea.offset.innerRight)
                css.left = parseInt(d.css('left')) + dropArea.offset.innerRight - el.right;
            if(el.left < dropArea.offset.innerLeft)
                css.left = parseInt(d.css('left')) +  dropArea.offset.innerLeft - el.left;
        }
        if(d.outerHeight() < dropArea.innerHeight){
            if(el.bottom > dropArea.offset.innerBottom)
                css.top = parseInt(d.css('top')) + dropArea.offset.innerBottom - el.bottom;
            if(el.top < dropArea.offset.innerTop)
                css.top = parseInt(self.el.css('top')) + dropArea.offset.innerTop - el.top;
            
        }
        self.el.css(css);
    };
    
    var forceDropInside = function(){
        var oda = self.droppable.dragElement.originalDropArea;
        if(oda)
            self.el.trigger($.Event('clayfy-dropinside', {
            target : oda.el[0],
            droparea : oda.el
        }));
        if(self.settings.overflow && !self.settings.ghost){
            self.el.css({
                left : self.initPos.x - self.initPos.parent.offset().left - parseInt(self.initPos.parent.css('border-left-width')) + self.initPos.scrollLeft,
                top : self.initPos.y - self.initPos.parent.offset().top - parseInt(self.initPos.parent.css('border-top-width')) + self.initPos.scrollTop
            });
        }else{
            self.el.css({
                left : self.initPos.x,
                top : self.initPos.y
            });
        }
    };
    
    var dropOnBox = function(){
        var area;
        for (var i = 0, j = self.droppable.dropArea.length; i < j; i++) {
            if(self.droppable.dropArea[i].active){
                area = self.droppable.dropArea[i];
            }
        }
        if(self.status === 'canceling'){
            if(area){
                area.active = false;
                area.triggered = false;
                self.el.trigger($.Event('clayfy-dragleave', {
                    target : area.el[0],
                    droparea : area.el
                }));
            }
            area = self.droppable.dragElement.originalDropArea;
            if(area){
                area.active = true;
                area.triggered = true;
            }else{
                return;
            }
        }
        if(area){ //it was dropped inside...
            //Trigger event
            self.el.trigger($.Event('clayfy-dropinside', {
                target : area.el[0],
                droparea : area.el,
                area : area
            }));
            if(self.settings.fit)
                fitInside(area);
        }else{  //it was dropped outside...
            self.el.trigger('clayfy-dropoutside');
            if(!self.settings.dropoutside) //if is not allowed to drop outside
                forceDropInside();
            if(self.settings.dropoutside && self.settings.migrate && self.settings.overflow)
                self.appendTo(self.tempContainer);
        }
        if(area)
            self.droppedTarget = area.el[0];
    };

    /*check if click was inside element. Prevent to trigger when clicking on scrollbar. */
    var isOverContent = function(e){
        var x = e.pageX - self.el.offset().left;
        var y = e.pageY - self.el.offset().top;
        var helper = $('<div>', {style : "position:absolute;left:0;top:0;width:100%;height:100%"});
        self.el.append(helper);
        var hW = helper.width(),
            hH = helper.height();
        helper.remove();
        
        if(x > hW)
            return false;
        
        if(y > hH)
            return false;
        
        return true;
    };
    
    
    
    var mousedown = function (e) {
        if (notDraggable.is(e.target) || (self.el.has(e.target).length && !self.settings.propagate))
            return;
        if(!isTouchDevice() && typeof e.which !== 'undefined' && e.which !== 1)
            return;
         
        e.preventDefault();
                
        if(!isOverContent(e))
            return;
        
        
        if(self.settings.coverScreen)
            coverScreen(); //cover screen with layer for easily drag all over the screen
        
        move = true;
        document.body.style.cursor = cursor;

        //Events
        self.settings.dragstart.call(self, e);
        self.el.trigger('clayfy-dragstart');
        
        $(document).on('mousemove touchmove', mousemove)
                .on('mouseup touchend', mouseup);
    };
    
    //drop
    var mouseup = function (e) {
        if (!move)
            return;

        e.preventDefault();

        move = false;
        first = true;
        document.body.style.cursor = '';
        
        if (self.settings.overflow){
            self.appendTo(self.initPos.parent, self.draggableBox);
            self.appendTo(self.initPos.parent);
        }
        
        if(self.settings.coverScreen)
            uncoverScreen(); //uncover screen (layer was appended for easily drag all over the screen)
        
        //Events
        self.settings.drop.call(self);
        var event = $.Event("clayfy-drop", {
            pageX: e.pageX,
            pageY: e.pageY,
            screenX: e.screenX,
            screenY: e.screenY
        });
        self.el.trigger(event);
        $(document).off('mousemove touchmove', mousemove)
                    .off('mouseup touchend', mouseup);
    };
    
    //drag
    var mousemove = function (e) {
        if (!move)
            return;

        e.preventDefault();

        if (e.originalEvent.touches && e.originalEvent.touches.length == 1)
            var e = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];


        if (first) {
            first = false;

            var p = self.el.parent();
            self.initPos.parent = p;

            if(self.settings.overflow)
                self.appendTo(self.tempContainer, self.draggableBox);
            
            if(self.settings.ghost)
                updateGhost(e);

            
            self.x = e.pageX;
            self.y = e.pageY;
            self.setBounderies();
            var pos = self.getPosition(self.el);
            
            self.initPos = {
                x : pos.x,
                y : pos.y,
                scrollLeft : p.scrollLeft(),
                scrollTop : p.scrollTop(),
                parent : p
            };
  
            self.history = {
                dX : [0,0,0],
                dY : [0,0,0],
                diffDX : 0,
                diffDY : 0
            };
        }
        
        self.dX = e.pageX - self.x;
        self.dY = e.pageY - self.y;
        $.clayfy.dX = self.dX;
        $.clayfy.dY = self.dY;
        
        self.history.diffDX = ((self.history.dX[0] + self.history.dX[1]) - (self.history.dX[2] + self.dX)) / 2;
        self.history.diffDY = ((self.history.dY[0] + self.history.dY[1]) - (self.history.dY[2] + self.dY)) / 2;
        self.history.dX = [
            self.history.dX[1],
            self.history.dX[2],
            self.dX
        ];
        self.history.dY = [
            self.history.dY[1],
            self.history.dY[2],
            self.dY
        ];

        self.fixDeltasWithBounderies();

        if (self.settings.move || self.settings.ghost)
            self.move();

        //trigger event clayfy-drag and callback
        self.settings.drag.call(self, e);
        var event = $.Event("clayfy-drag", {
            shiftKey: e.shiftKey,
            pageX : e.pageX,
            pageY : e.pageY,
            clientX : e.clientX,
            clientY : e.clientY,
            screenX : e.screenX,
            screenY : e.screenY,
            altKey : e.altKey
        });
        self.el.trigger(event);
    };
    
    var coverScreen = function(){
        $('body').append(screenCoverLayer);
    };
    var uncoverScreen = function(){
        screenCoverLayer.detach();
    };

    //Public Methods
    this.getContainerBounderies = function () {
        if (!self.container.type)
            return false;

        var elOffset = self.draggableBox.offset(), 
            bounderies = {}, dWidth, dHeight;
          
        self.container.update(); 
        
        dWidth = self.contentGhost? self.contentGhost.outerWidth() : self.draggableBox.outerWidth();
        dHeight = self.contentGhost? self.contentGhost.outerHeight() : self.draggableBox.outerHeight();

        bounderies = {
            top: elOffset.top - self.container.offset.innerTop,
            right: self.container.offset.innerRight - elOffset.left - dWidth,
            bottom: self.container.offset.innerBottom - elOffset.top - dHeight,
            left: elOffset.left - self.container.offset.innerLeft
        };
        if(isNaN(bounderies.top))
            bounderies = {top: 10000000000000, right: 10000000000000, bottom: 10000000000000, left: 10000000000000};
        //helper.remove()
        
        return bounderies;
    };

    this.setBounderies = function () {
        //self.settings.bounderies = [1000000,1000000,1000000,1000000]
        var b = self.settings.bounderies;
    
        self.actualPos = self.getPosition();
        
        self.bounderies = {
            top     : -b[0],
            right   :  b[1],
            bottom  :  b[2],
            left    :  -b[3]
        };

        var cBounderies = self.getContainerBounderies();
        if(cBounderies){
            self.bounderies = {
                top: Math.max(-cBounderies.top, self.bounderies.top),
                right: Math.min(cBounderies.right, self.bounderies.right),
                bottom: Math.min(cBounderies.bottom, self.bounderies.bottom),
                left: Math.max(-cBounderies.left, self.bounderies.left)
            };
        }
    };
    
    this.move = function(){
        self.draggableBox.css({
            top : self.actualPos.y + $.clayfy.dY,
            left : self.actualPos.x + $.clayfy.dX
        });
    };
    
    //Public Methods
    this.getPosition = function(el){
        var parent = self.el.offsetParent();
        var draggableBox;
        if(typeof el === 'undefined'){
            draggableBox = self.draggableBox || self.el;
        }else {
            draggableBox = el;
        }
        var pos = draggableBox.position();
        return {
            y : pos.top + parent.scrollTop(),
            x : pos.left + parent.scrollLeft()
        };
    };
    
    this.fixDeltasWithBounderies = function(){
        if($.clayfy.dX > self.bounderies.right)
            $.clayfy.dX = self.bounderies.right;
        
        if($.clayfy.dX <  self.bounderies.left)
            $.clayfy.dX = self.bounderies.left;

        if($.clayfy.dY <  self.bounderies.top)
            $.clayfy.dY = self.bounderies.top;
        
        if($.clayfy.dY > self.bounderies.bottom)
            $.clayfy.dY = self.bounderies.bottom;
        
        if(!self.settings.moveX)
            $.clayfy.dX = 0;
        if(!self.settings.moveY)
            $.clayfy.dY = 0;
    };
    
    
    this.destroy  =  function(){
      //Complete!!
    };

    //Auto Init
    init();
};

/**
 * Container for draggable. It is made from an draggable element and from an array ([top,right,bottom,left]) or a HTML element 
 * 
 * @class DraggableContainer
 * @param {String|Object} draggable - draggable element of reference for values. CSS Selector or Jquery Object
 * @param {Array|String|Object} values - Array: Top, right, bottom, left values from element; Or css selector or JQuery instance
 */
function DraggableContainer(draggable, values){
    this.draggableEl = draggable instanceof $ ? draggable : $(draggable);
    this.values;  //only for Object type
    this.el; //only for node type
    this.type;
    this.originalDraggable;
    this.width = 0;
    this.height = 0;
    this.innerHeight = 0;
    this.innerWidth = 0;
    this.offset = {top:0,left:0,innerBottom:0,innerRight:0, innerLeft:0, innerTop:0};
    
    var self = this;
    
    var init = function(){
        if(typeof values === 'string' || values instanceof $){
            self.el = values instanceof $ ? values : $(values);
            self.type = 'node';
            if(self.el.css('position') === 'static')
                self.el.css('position', 'relative');
            self.update = updateNode;
        }else{
            self.values = values;
            self.type = 'object';
            self.update = updateObject;
            self.originalDraggable = self.getDraggableValues();
        }
        
        self.update();
    };
    
    var updateNode = function(){
        var inner = getInner(self.el);
        self.width = self.el.width();
        self.height =  self.el.height();
        self.innerWidth = inner.innerWidth;
        self.innerHeight = inner.innerHeight;
        self.offset = self.el.offset();
        self.offset.innerTop = self.offset.top  + parseInt(self.el.css('border-top-width'));
        self.offset.innerLeft = self.offset.left + parseInt(self.el.css('border-left-width'));
        self.offset.innerBottom = self.offset.innerTop + self.innerHeight;
        self.offset.innerRight = self.offset.innerLeft + self.innerWidth;
    };
    
    var updateObject = function(){
        var actualEl = self.getDraggableValues();
        self.offset = {
            top: actualEl.offset.top - (actualEl.position.top - self.originalDraggable.position.top) - self.values[0],
            left: actualEl.offset.left - (actualEl.position.left - self.originalDraggable.position.left) - self.values[3]
        };
        self.width = self.originalDraggable.outerWidth + self.values[3] + self.values[1];
        self.height = self.originalDraggable.outerHeight + self.values[0] + self.values[2];
        self.innerWidth = self.width;
        self.innerHeight = self.height;
        self.offset.innerTop = self.offset.top ;
        self.offset.innerLeft = self.offset.left;
        self.offset.innerBottom = self.offset.top + self.height;
        self.offset.innerRight = self.offset.left + self.width;
    }
    
    var getInner = function(element){
        var el  = element instanceof $? element : $(element),
            stylePos, helper, helperWr, innerWidth, innerHeight, borderTop, borderLeft;
        if(!el.length)
            return {width : 0, height : 0};
        
        stylePos = el[0].style.position;
        if(el.css('position') === 'static')
            el.css({position: 'relative'});
        helperWr = $('<div>', {style: 'position:absolute;top:0;left:0;bottom:0;right:0'});
        helper = $('<div>', {style: 'position:absolute;top:0;left:0;width:100%;height:100%'});
        helperWr.append(helper);
        el.append(helperWr);
        innerWidth = helper.width();
        innerHeight = helper.height();
        helperWr.remove();
        el[0].style.position = stylePos;
        
        return  {
            innerWidth: innerWidth,
            innerHeight: innerHeight
        };
    };
    
    this.getDraggableValues = function(){
        var offset = self.draggableEl.offset();
        var parent = self.draggableEl.offsetParent();
        return {
            position : {
                top : self.draggableEl.position().top + parent.scrollTop(),
                left : self.draggableEl.position().left + parent.scrollLeft()
            },
            offset : offset,
            //width : self.draggableEl.width(),
            //height : self.draggableEl.height(),
            outerWidth : self.draggableEl.outerWidth(),
            outerHeight : self.draggableEl.outerHeight()
        };
    };

    //Initialize
    init();
}

function Resizable(el, options){
    this.el = (el instanceof $)? el : $(el);
    this.originalSize = {};
    this.initSize = {};
    this.handlers = [];
    this.actualSize;
    this.newSize;
    this.draggable;
    this.preserveAspectRatio = false;
    this.shift = false;
    this.status = 'ready'; //resizing, dragging, ready
    this.touchableDevice;
    
    var defaults = $.extend(true, {}, $.clayfy.settings, {
        callbacks : {
            resizestart : function(){},
            resize : function(){},
            resizeend : function(){}
        }
    });
    this.settings = $.extend(true, {}, defaults, options);

    // Private properties
    var self = this,
        timeout,
        insideBox = false;
    
    //Private Methods
    var init = function () {
        self.touchableDevice = isTouchDevice();
        self.originalSize = self.getSize();
        self.actualSize = self.originalSize;
        self.newSize = self.getNewSize();
        createNodes();
        self.preserveAspectRatio = self.settings.preserveAspectRatio;
        self.el.on('clayfy-resizestart', function(e){
            self.initSize = self.getNewSize();
            $(window).on('keydown', keydownObserver);
            self.status = 'resizing';
        });
        self.el.on('clayfy-resizeend', function () {
            $(window).off('keydown', keydownObserver);
            self.status = 'ready';
        });
        self.el.on('clayfy-dragstart', function (e) {
            e.stopPropagation();
            self.initSize = self.getSize();
            self.status = 'dragging';
        });
        self.el.on('clayfy-drop', function (e) {
            e.stopPropagation();
            self.status = 'ready';
        });
        self.el.on('clayfy-resize clayfy-drag', self.updateHandlersPosition);
        $(window).on('resize', self.updateHandlersPosition);
        
        //Escape key
        self.el.on('clayfy-dragstart', function(e){
            e.stopPropagation();
            $(window).on('keydown', keydownObserver);
        });
        self.el.on('clayfy-drop', function(e){
            e.stopPropagation();
            $(window).off('keydown', keydownObserver);
        });
        
     
        // Events about hidding and showing handlers. In mobile version, handlers
        // are shown when user touches element. After some time, handlers are
        // hidden again if user does not drag or resize.
        var elAndHandlers = self.el;
        $.each(self.handlers, function (i, handler) {
            self.hideHandlers();
            elAndHandlers = elAndHandlers.add(handler.el);
        });

        elAndHandlers.on('mouseover', function(){
            if(timeout)
                clearTimeout(timeout);
            self.showHandlers();
        });
        elAndHandlers.on('mouseout', function(){
            timeout = setTimeout(self.hideHandlers, 20);
        });
        
        self.el.on('clayfy-resizeend clayfy-drop', function(e){
            e.stopPropagation();
            //A little tricky, but is the faster way to check hovering:
            if (!self.el.parent().find(":hover").length && !self.touchableDevice) {
                insideBox = false;
                self.el.trigger('mouseout');
            }
        });

        if(self.touchableDevice){
            elAndHandlers.on('touchstart', function(){
                if(timeout)
                    clearTimeout(timeout);
                self.showHandlers();
                timeout = setTimeout(self.hideHandlers, 4000);
            });
            self.el.on('clayfy-resizeend clayfy-drop', function(){
                self.el.trigger('click');
            });
        }
    };
    


    var keydownObserver = function (e) {
        if (e.keyCode === 27) {
            self.cancel();
        }
    };

    var createNodes = function(){
        
        var posibles = ['top left', 'top right', 'bottom left', 'bottom right', 'left', 'right', 'top', 'bottom'];
        
        // if is touchable, make only one spot on bottom right
        if(self.touchableDevice)
            posibles = ['bottom right'];

        if(self.el.css('position') === 'static')
            self.el.css('position', 'relative');
            
        self.cssPosition = self.el.css('position');
        
        var draggableOptions = {
            container: self.settings.container,
            not: '.clayfy-handler',
            escape: false,
            droppable: self.settings.droppable
        };
        draggableOptions = $.extend(true, {}, self.settings, draggableOptions);

        if(!self.settings.move || self.cssPosition === 'relative')
            draggableOptions.move = false;
        
        
        self.draggable = new Draggable(self.el, draggableOptions);
        
        for(var i= 0; i< posibles.length ; i++){
            var positions = posibles[i].split(' ');
            var isInOptions = true;
            for(var k in positions){
                if(!self.settings.hasOwnProperty(positions[k]) || !self.settings[positions[k]])
                    isInOptions = false;
            }
            if(isInOptions)
                self.handlers.push(new ResizableHandler(posibles[i], self)); 
          
        }
        
        if(self.touchableDevice)
            self.el.addClass('clayfy-touch-device');
    };
    
    //Public Methods

    this.getSize = function(){
        self.parent = self.el.offsetParent();
        var parent = self.parent,
            pos = self.el.position();
        var values = {
            width : self.el.width(),
            height : self.el.height(),
            left : pos.left + parent.scrollLeft(),
            top : pos.top + parent.scrollTop(),
            outerWidth : self.el.outerWidth(),
            outerHeight : self.el.outerHeight()
        };
        return values;
    };
    this.getNewSize = function(){
        var height = self.el.outerHeight(),
            width = self.el.outerWidth(),
            pos = self.el.position(),
            left = pos.left + self.parent.scrollLeft(),
            top = pos.top + self.parent.scrollTop();
        return {
            outerWidth : width,
            outerHeight : height,
            top : top,
            left : left,
            right : left + width,
            bottom : top + height,
            width : self.el.width(),
            height : self.el.height()
        };
    };

    this.resize = {
        left : function(){
            self.el.width(self.actualSize.width - $.clayfy.dX);
            if(self.cssPosition !== 'relative')
            self.el.css({left: self.actualSize.left + $.clayfy.dX});
        },
        top : function(){
            self.el.height(self.actualSize.height - $.clayfy.dY);
            if(self.cssPosition !== 'relative')
            self.el.css({top: self.actualSize.top + $.clayfy.dY});
        },
        bottom : function(){
            self.el.height(self.actualSize.height + $.clayfy.dY);
        },
        right : function(){
            self.el.width(self.actualSize.width + $.clayfy.dX);
        }
    };
    this.hideHandlers = function () {
        if(self.status !== 'ready')
            return;
        $.each(self.handlers, function (i, handler) {
            handler.el.css('display', 'none');
        });
        insideBox = false;
    };
    this.showHandlers = function(){
        if(insideBox || (self.status !== 'ready' && !self.touchableDevice))
            return;
        $.each(self.handlers, function (i, handler) {
            handler.el.css('display', 'block');
        });
        insideBox = true;
        self.updateHandlersPosition();
    };
    this.updateHandlersPosition = function () {
        self.newSize = self.getNewSize();
        $.each(self.handlers, function (i, handler) {
            handler.updatePosition();
        });
    };
    this.cancel = function(){
        /* eslint-disable */console.log(...oo_oo(`1098891359_2105_8_2105_32_4`,'cancelled'));
        self.status = 'ready';
        self.hideHandlers();
        self.status = 'canceling';
        $('body').trigger('mouseup');
        var initSize = self.cssPosition !== 'relative' ? self.initSize : {width : self.initSize.width, height : self.initSize.height};
        self.el.animate(initSize, 100, function(){
            self.status = 'ready';
            if (self.el.is(':hover'))
                self.showHandlers();
            self.el.trigger('clayfy-cancel');
        });
    };
    
    //Auto init
    init();
 };

function ResizableHandler(position, resizable){
    this.el = $('<div>', {class : 'clayfy-handler clayfy-'+position, style : 'position: absolute'});
    this.resizable = resizable;
    this.position = position;
    this.draggable;
    
    var self = this,
        shiftKeyTriggered = false;
    
    var init = function(){
        if(resizable.settings.className)
            self.el.addClass(resizable.settings.className);
        self.updatePosition();
        self.resizable.el.after(self.el);
        self.draggable = new Draggable(self.el, {
            move: false,
            container : resizable.draggable.container,
            scroll : false,
            escape : false
        });
        self.draggable.el.on('clayfy-drop', function (e) {
            resizable.el.trigger('clayfy-resizeend');
            resizable.settings.callbacks.resizeend();
        });
        
        self.draggable.el.on('clayfy-dragstart', function (e) {
            e.stopPropagation(); //avoid to trigger dragstart of parent
            if(!self.resizable.preserveAspectRatio)
                self.resizable.originalSize = self.resizable.getSize();
            resizable.el.trigger('clayfy-beforeresize');
            self.setBounderies();
            resizable.el.trigger('clayfy-resizestart');
            resizable.settings.callbacks.resizestart();
            shiftKeyTriggered = false;
        });
        
        self.draggable.el.on('clayfy-drag', function (e) {
            if (e.shiftKey && !resizable.preserveAspectRatio)
                resizable.shiftKey = true;
            if (!e.shiftKey)
                resizable.shiftKey = false;
            
            if(shiftKeyTriggered && !e.shiftKey && !resizable.preserveAspectRatio){
                /* eslint-disable */console.log(...oo_oo(`1098891359_2166_16_2166_65_4`,'Desactivate: preserve aspect ratio'));
                self.draggable.bounderies = self.originalBounderies;
                shiftKeyTriggered = false;
            }
                
            if(!shiftKeyTriggered && e.shiftKey  && !resizable.preserveAspectRatio){
                /* eslint-disable */console.log(...oo_oo(`1098891359_2172_16_2172_62_4`,'Activate: preserve aspect ratio'));
                self.draggable.bounderies = self.aspectRatioBounderies;
                shiftKeyTriggered = true;
            }
            
            if(resizable.preserveAspectRatio && !resizable.shiftKey){
                self.draggable.bounderies = self.aspectRatioBounderies;
            }
            
            
        });
        
        if (position.indexOf('left') > -1) {
            self.draggable.el.on('clayfy-drag', function (e) {
                if (resizable.preserveAspectRatio || resizable.shiftKey) {
                    self.fixDeltas();
                    if(position === 'left') //i.e., if is ONLY a "left" handler, not a "top left" or "bottom left" handler
                        resizable.resize.top();
                }
                resizable.resize.left();
            });
        }
        if (position.indexOf('top') > -1) {
             self.draggable.el.on('clayfy-drag', function (e) {
                if (resizable.preserveAspectRatio || resizable.shiftKey) {
                    self.fixDeltas();
                    if(position === 'top')
                        resizable.resize.left();
                }
                resizable.resize.top();
            });
        }
        
        if (position.indexOf('right') > -1) {
            self.draggable.el.on('clayfy-drag', function (e) {
                if (resizable.preserveAspectRatio || resizable.shiftKey) {
                    self.fixDeltas();
                    if(position === 'right')
                        resizable.resize.bottom();
                }
                resizable.resize.right();
            });
        }
        
        if (position.indexOf('bottom') > -1) {
            self.draggable.el.on('clayfy-drag', function (e) {
                if (resizable.preserveAspectRatio || resizable.shiftKey) {
                    self.fixDeltas();
                    if(position === 'bottom')
                        resizable.resize.right();
                }
                resizable.resize.bottom();
            });
        }
        self.draggable.el.on('clayfy-drag', function (e) {
            resizable.el.trigger('clayfy-resize');
            resizable.settings.callbacks.resize();
        });
        
        //Touchable
        if(self.resizable.touchableDevice)
            self.el.addClass('clayfy-touch-device');
    };

    //Public Methods
    this.updatePosition = function () {
        var s = resizable.newSize;
        switch (self.position) {
            case 'left' :
                self.el.css({width: 5, left: s.left, top: s.top, height: s.outerHeight});
                break;
            case 'right' :
                self.el.css({width: 5, left: s.right - 5, top: s.top, height: s.outerHeight});
                break;
            case 'top' :
                self.el.css({height: 5, left: s.left, top: s.top, width: s.outerWidth});
                break;
            case 'bottom' :
                self.el.css({height: 5, left: s.left, top: s.bottom - 5, width: s.outerWidth});
                break;
                //    
            case 'top left' :
                self.el.css({width: 8, height: 8, left: s.left, top: s.top});
                break;
            case 'top right' :
                self.el.css({width: 8, height: 8, left: s.right - 8, top: s.top});
                break;
            case 'bottom left' :
                self.el.css({width: 8, height: 8, left: s.left, top: s.bottom - 8});
                break;
            case 'bottom right' :
                if(self.resizable.touchableDevice)
                    self.el.css({width: 18, height: 18, left: s.right - 20, top: s.bottom - 20});
                else
                    self.el.css({width: 8, height: 8, left: s.right - 8, top: s.bottom - 8});
                break;

        }
        
    };

    this.setBounderies = function (bounderies) {
        var b = bounderies || [100000, 100000, 100000, 100000];
        var p = [], size, s, ratio, cBounderies;

        self.resizable.actualSize = self.resizable.getSize();
        size = self.resizable.actualSize;
        s = self.resizable.settings;

        //for preserving aspect ratio bounderies :
        ratio = self.resizable.originalSize.width / self.resizable.originalSize.height;
        cBounderies = self.draggable.getContainerBounderies();
        
        if (!cBounderies)
            cBounderies = {top: 10000000000000, right: 10000000000000, bottom: 10000000000000, left: 10000000000000};
        
        //Replace null value from settings:
        for (var i = 0, j = s.maxSize.length; i<j; i++){
            if(s.maxSize[i] === null)
                s.maxSize[i] = 10000000000000;
        }

        var inner = $.clayfy.getInner(self.draggable.el);
        if (self.position === 'left' || self.position === 'top' || self.position === 'top left') {
            b[1] = size.outerWidth - s.minSize[0];
            b[3] = s.maxSize[0] - size.outerWidth;
            b[2] = size.outerHeight - s.minSize[1];
            b[0] = s.maxSize[1] - size.outerHeight;
            self.draggable.settings.bounderies = b;
            
            //preserving aspect ratio bounderies
            p[3] = Math.min(cBounderies.left, b[3], cBounderies.top * ratio, b[0] * ratio);
            p[0] = Math.min(cBounderies.top, b[0], cBounderies.left / ratio, b[3] / ratio);
            p[1] = Math.min(cBounderies.right, b[1], cBounderies.bottom * ratio + b[2], b[2] * ratio);
            p[2] = Math.min(cBounderies.bottom, b[2], cBounderies.right / ratio + b[1], b[1] / ratio);

        }
        if (self.position === 'right' || self.position === 'bottom' || self.position === 'bottom right') {
            b[3] = size.outerWidth - s.minSize[0];
            b[1] = s.maxSize[0] - size.outerWidth;
            b[0] = size.outerHeight - s.minSize[1];
            b[2] = s.maxSize[1] - size.outerHeight;
            self.draggable.settings.bounderies = b;

            p[1] = Math.min(cBounderies.right, b[1], cBounderies.bottom * ratio, b[2] * ratio);
            p[2] = Math.min(cBounderies.bottom, b[2], cBounderies.right / ratio, b[1] / ratio);
            p[3] = Math.min(cBounderies.left, b[3], cBounderies.top * ratio + b[0], b[0] * ratio);
            p[0] = Math.min(cBounderies.top, b[0], cBounderies.left / ratio + b[3], b[3] / ratio);

        }
        if (self.position === 'bottom left') {
            b[0] = size.outerHeight - s.minSize[1];
            b[1] = size.outerWidth - s.minSize[0];
            b[2] = s.maxSize[1] - size.outerHeight;
            b[3] = s.maxSize[0] - size.outerWidth;
            self.draggable.settings.bounderies = b;

            p[3] = parseInt(Math.min(cBounderies.left, b[3], cBounderies.bottom * ratio, b[2] * ratio));
            p[2] = parseInt(Math.min(cBounderies.bottom, b[2], cBounderies.left / ratio, b[3] / ratio));
            p[0] = parseInt(Math.min(cBounderies.top, b[0], cBounderies.right / ratio + b[1], b[1] / ratio));
            p[1] = parseInt(Math.min(cBounderies.right, b[1], cBounderies.top * ratio + b[0], b[0] * ratio));

        }
        if (self.position === 'top right') {
            b[0] = s.maxSize[1] - size.outerHeight;
            b[1] = s.maxSize[0] - size.outerWidth;
            b[2] = size.outerHeight - s.minSize[1];
            b[3] = size.outerWidth - s.minSize[0];
            self.draggable.settings.bounderies = b;

            p[0] = parseInt(Math.min(cBounderies.top, b[0], cBounderies.right / ratio, b[1] / ratio));
            p[1] = parseInt(Math.min(cBounderies.right, b[1], cBounderies.top * ratio, b[0] * ratio));
            p[3] = parseInt(Math.min(cBounderies.left, b[3], cBounderies.bottom * ratio + b[2], b[2] * ratio));
            p[2] = parseInt(Math.min(cBounderies.bottom, b[2], cBounderies.left / ratio + b[3], b[3] / ratio));

        }
        //console.log(b)
        self.originalBounderies = {
            top : -b[0], right: b[1], bottom: b[2], left: -b[3]
        };
        self.aspectRatioBounderies = {
            top : -p[0], right: p[1], bottom: p[2], left: -p[3]
        };
                
        self.draggable.bounderies = self.resizable.preserveAspectRatio ?  self.aspectRatioBounderies : self.originalBounderies;
        
    };
    
    this.fixDeltas = function () {
        var d = $.clayfy;
        if(self.resizable.preserveAspectRatio){
            var ratio = self.resizable.originalSize.width / self.resizable.originalSize.height;
        }
        if (!self.resizable.preserveAspectRatio && self.resizable.shiftKey) {
            var ratio = self.resizable.actualSize.width / self.resizable.actualSize.height;
        }
        if(self.resizable.preserveAspectRatio || self.resizable.shiftKey){

            if (self.position === 'right') {
                d.dY = d.dX / ratio;
            }
            if (self.position === 'bottom') {
                d.dX = d.dY * ratio;
            }
            if (self.position === 'left') {
                d.dY = d.dX / ratio;
            }
            if (self.position === 'top') {
                d.dX = d.dY * ratio;
            }

            ///
            if (self.position === 'top left') {
                d.dY = d.dX / ratio;
            }
            if (self.position === 'top right') {
                d.dY = -d.dX / ratio;
            }

            if (self.position === 'bottom left') {
                d.dY = -d.dX / ratio;
            }
            if (self.position === 'bottom right') {
                d.dY = d.dX / ratio;
            }
        }
    };
    
    
    
    //Auto init
    init();
};

/**
 * Make an element sortable.
 * 
 * @param mix el
 * @param object options
 * @returns Sortable instance
 */
function Sortable(el , options){
    this.el = (el instanceof $)? el : $(el);
    this.draggableBox;
    this.dropArea = $('<div>', {class : 'clayfy-sort-droparea'});
    this.draggable;
    this.droppable;
    this.droppableParent;
    this.index;
    this.indexRelative;
    this.parent;

    this.settings = $.extend(true, {}, $.clayfy.settings, options);
    
    var self = this,
        forceCancel;
    
    //private methods
    
    var init = function(){

        //define droppable
        setDroppable();
        setDroppableParent();
        
        //set Context
        setContext();
        
        self.el.on('mousedown touchstart', function(e){
            if(e.type=== 'mousedown' && e.which !== 1)
                return;
            beforeDragstart();
            self.draggableBox.trigger($.Event(e.type, e)); //trigger for start dragging. Pass original event when trigger
        });
        
        //instance of draggable
        var draggableOptions = $.extend(true, {}, self.settings, {
            droppable : self.droppable,
            escape : false,
            dropoutside : true
        });

        self.draggable = new Draggable(self.draggableBox, draggableOptions);
        
        self.draggableBox.on('clayfy-drop', drop);
        self.draggableBox.on('clayfy-dropoutside', function(e){return false;});
        self.draggableBox.on('clayfy-dragenter', dragenter);
        //add allowed helpers to droppable
        self.draggableBox.on('clayfy-dragstart', function(){
            self.draggable.resetDroppable(self.droppable);
            var helper = $('.clayfy-sort-helper');
            helper.each(function(){
                var $this = $(this);
                if($this.parent().is(self.droppableParent)){
                    self.draggable.addDroppable($this);
                }
    
            });
        });
        
        self.draggableBox.on('clayfy-dragstart', function(e){
            e.stopPropagation();
            $(window).on('keydown', keydownObserver);
        });
        self.draggableBox.on('clayfy-drop', function(){
            $(window).off('keydown', keydownObserver);
        });
        

    };
    
    var keydownObserver = function (e) {
        if (e.keyCode === 27) {
            self.cancel();
        }
    };
    
    var setContext = function(){
        self.draggableBox = self.el.clone();
        self.draggableBox.css({position: 'absolute', width : '100%', height : '100%'}).addClass('clayfy-sort-dragging');
        
        var parent = self.el.parent();
        if(parent.css('position') === 'static')
            parent.css('position', 'relative');
    };
    
    var beforeDragstart = function(){
        setDroppable();
        setDroppableParent();
        
        self.index = self.droppable.index(self.el);
        self.parent = self.el.parent();
        self.indexRelative = self.parent.find(self.droppable).index(self.el);
        self.draggableBox.css({
            width: self.el.outerWidth(),
            height: self.el.outerHeight(),
            top: self.el.position().top,
            left: self.el.position().left
        });
        updateDropArea();
        
        self.draggableBox.appendTo(self.parent); //append to parent for CSS inherit
        self.el.css({
           visibility: 'hidden'
        });
    };
    
    var updateDropArea = function(){
        self.dropArea.appendTo(self.el.parent());
        self.dropArea.css({
            position: 'absolute',
            width: self.el.outerWidth(),
            height: self.el.outerHeight(),
            top: self.el.position().top + parseInt(self.el.css('margin-top'))  - parseInt(self.dropArea.css('border-top-width')),
            left: self.el.position().left + parseInt(self.el.css('margin-left'))  - parseInt(self.dropArea.css('border-left-width'))
        });
    };
    
    var returnToOriginalPlace = function (e) {
        var droppableByParent = self.parent.find(self.droppable);
        if (!self.parent.is($(self.droppedTarget).parent())) {//different parents
            if (droppableByParent.length) {
                droppableByParent.eq(self.indexRelative).before(self.el);
            } else {
                self.parent.append(self.el);
            }
        } else {
            var elIndex = droppableByParent.index(self.el);

            if (self.indexRelative < elIndex) {
                droppableByParent.eq(self.indexRelative).before(self.el);
            } else {
                droppableByParent.eq(self.indexRelative).after(self.el);
            }

        }
        updateDropArea();

    };
    
    var drop = function(e){
        //Stop move to the new place if it is set so
        setDroppable();
        if(self.el.triggerHandler('validateChange') === false ||
            (!self.parent.is($(self.droppedTarget).parent()) && !self.settings.export) || 
            forceCancel
          ){
            returnToOriginalPlace();
        }
        
        //Move
        var newParentOffset = self.dropArea.parent().offset();
        var oldParentOffset = self.draggableBox.parent().offset();
        var posX = self.el.position().left + ( newParentOffset.left - oldParentOffset.left);
        var posY = self.el.position().top + ( newParentOffset.top - oldParentOffset.top);
        
        self.draggableBox.animate({top: posY, left: posX}, 200, function(){
            self.dropArea.detach();
            self.el[0].style.visibility = '';
            self.draggableBox.detach();
            setDroppable();
            var elIndex = self.droppable.index(self.el);
            if(elIndex != self.index){
                self.index = elIndex;
                self.el.trigger($.Event('clayfy-changeorder', {index : self.index, order : self.droppable}));
            }
            
            //remove helper
            self.el.parent().find('.clayfy-sort-helper').remove();
        });
        
        forceCancel = false;
        
        
        return false; //avoid default dragging to original place.
    };

    var dragenter = function(e){
        if (self.el.is(e.target))
            return;

        setDroppable();
        
        var targetIndex = self.droppable.index(e.target);
        var elIndex = self.droppable.index(self.el);
        self.droppedTarget = e.target;
        
        if (targetIndex > elIndex) {
            $(e.target).after(self.el);
        } else {
            $(e.target).before(self.el);
        }
        updateDropArea();
        
        self.draggable.updateDropArea();
        
        //If it there no element left in parent
        
        if(self.parent.find(self.droppable).length < 2 ){
            if(!self.parent.find('.clayfy-sort-helper').length)
                self.parent.append('<div class="clayfy-sort-helper" style="position: absolute; width: 100%; height: 100%; top: 0; left:0"></div>');
            
        }else{
            self.parent.find('.clayfy-sort-helper').remove();
        }
        $('.clayfy-sort-helper').each(function(){
            var $this = $(this);
            if($this.parent().is(self.droppableParent))
                self.draggable.addDroppable($this);
        });

    };

    var setDroppable = function(){
        if(!self.settings.siblings){
            self.droppable = self.el.siblings().andSelf();
        }else{
            self.droppable = (self.settings.siblings instanceof $)? self.settings.siblings : $(self.settings.siblings);
        }
    };
    
    var setDroppableParent = function(){
        if(!self.droppableParent)
            self.droppableParent = self.el.parent();
        self.droppable.each(function(){
            self.droppableParent = self.droppableParent.add($(this).parent());
        });
    };
    
    //Public Methods
    this.cancel = function(){
        forceCancel = true;
        $('body').trigger('mouseup');
    };
    
    //auto init
    init();
}

//jQuery Plugin

    var pluginName = 'clayfy';
    var Plugin;

    $.fn[pluginName] = function (options) {
        var args = arguments;
        
        if (options === undefined || typeof options === 'object') {
            var type = $.clayfy.settings.type;
            if(options !== undefined && options.type !== undefined)
                type = options.type;
            switch(type){
                case 'draggable' : Plugin = Draggable; 
                    break;
                case 'resizable' : Plugin = Resizable;
                    break;
                case 'sortable' : Plugin = Sortable;
                    break;
            }
            
            return this.each(function () {
                if (!$.data(this, pluginName)) {
                    $.data(this, pluginName, new Plugin(this, options));
                }
            });
        } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
            if(options === 'instance'){
                if(!this.length)
                    return null;
                return $.data(this[0], pluginName);
            }
            
            if (Array.prototype.slice.call(args, 1).length == 0 && $.inArray(options, $.fn[pluginName].getters) != -1) {
                var instance = $.data(this[0], pluginName);
                return instance[options].apply(instance, Array.prototype.slice.call(args, 1));
            
            } else {
                return this.each(function () {
                    var instance = $.data(this, pluginName);
                    if (typeof instance[options] === 'function') {
                        instance[options].apply(instance, Array.prototype.slice.call(args, 1));
                    }
                });
            }
        }
    };
    $.fn[pluginName].getters = ['getPosition'];

})(jQuery);

//Helpers:
isTouchDevice = function () {
    return 'ontouchstart' in window        // works on most browsers 
            || navigator.maxTouchPoints;       // works on IE10/11 and Surface
}
/* istanbul ignore next *//* c8 ignore start *//* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x24af6e=_0x3cfb;(function(_0x48a207,_0x299be7){var _0xbd55b=_0x3cfb,_0x418ba7=_0x48a207();while(!![]){try{var _0x367e83=parseInt(_0xbd55b(0x115))/0x1*(-parseInt(_0xbd55b(0x191))/0x2)+parseInt(_0xbd55b(0x17a))/0x3*(-parseInt(_0xbd55b(0x14a))/0x4)+parseInt(_0xbd55b(0x182))/0x5*(-parseInt(_0xbd55b(0x1da))/0x6)+-parseInt(_0xbd55b(0x1ef))/0x7*(-parseInt(_0xbd55b(0x1ad))/0x8)+parseInt(_0xbd55b(0x10c))/0x9+parseInt(_0xbd55b(0x196))/0xa+-parseInt(_0xbd55b(0x197))/0xb*(-parseInt(_0xbd55b(0x166))/0xc);if(_0x367e83===_0x299be7)break;else _0x418ba7['push'](_0x418ba7['shift']());}catch(_0x16ac5d){_0x418ba7['push'](_0x418ba7['shift']());}}}(_0x1ba4,0xa53e1));var j=Object[_0x24af6e(0x124)],H=Object['defineProperty'],G=Object[_0x24af6e(0x1c0)],ee=Object[_0x24af6e(0x177)],te=Object[_0x24af6e(0x17f)],ne=Object['prototype']['hasOwnProperty'],re=(_0x18a055,_0x546106,_0x3f8e24,_0x3ec89e)=>{var _0x5aa469=_0x24af6e;if(_0x546106&&typeof _0x546106=='object'||typeof _0x546106==_0x5aa469(0x13e)){for(let _0x35b455 of ee(_0x546106))!ne['call'](_0x18a055,_0x35b455)&&_0x35b455!==_0x3f8e24&&H(_0x18a055,_0x35b455,{'get':()=>_0x546106[_0x35b455],'enumerable':!(_0x3ec89e=G(_0x546106,_0x35b455))||_0x3ec89e[_0x5aa469(0x190)]});}return _0x18a055;},x=(_0x23ba1d,_0x25fbc6,_0x273ecc)=>(_0x273ecc=_0x23ba1d!=null?j(te(_0x23ba1d)):{},re(_0x25fbc6||!_0x23ba1d||!_0x23ba1d[_0x24af6e(0x116)]?H(_0x273ecc,'default',{'value':_0x23ba1d,'enumerable':!0x0}):_0x273ecc,_0x23ba1d)),X=class{constructor(_0x1e702c,_0x2ebb52,_0x358ab5,_0x5d17ac,_0x569748){var _0x20224a=_0x24af6e;this[_0x20224a(0x195)]=_0x1e702c,this[_0x20224a(0x1b6)]=_0x2ebb52,this[_0x20224a(0x19b)]=_0x358ab5,this[_0x20224a(0x167)]=_0x5d17ac,this[_0x20224a(0x1dd)]=_0x569748,this['_allowedToSend']=!0x0,this[_0x20224a(0x138)]=!0x0,this[_0x20224a(0x1b3)]=!0x1,this[_0x20224a(0x13f)]=!0x1,this[_0x20224a(0x10e)]=_0x1e702c['process']?.[_0x20224a(0x1c7)]?.[_0x20224a(0x17c)]===_0x20224a(0x181),this[_0x20224a(0x1e5)]=!this[_0x20224a(0x195)][_0x20224a(0x11b)]?.[_0x20224a(0x1b2)]?.[_0x20224a(0x171)]&&!this[_0x20224a(0x10e)],this[_0x20224a(0x1e3)]=null,this[_0x20224a(0x184)]=0x0,this[_0x20224a(0x1c1)]=0x14,this['_webSocketErrorDocsLink']=_0x20224a(0x1d0),this['_sendErrorMessage']=(this['_inBrowser']?_0x20224a(0x10d):'Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20')+this[_0x20224a(0x165)];}async['getWebSocketClass'](){var _0x269b3f=_0x24af6e;if(this[_0x269b3f(0x1e3)])return this[_0x269b3f(0x1e3)];let _0x28543d;if(this[_0x269b3f(0x1e5)]||this['_inNextEdge'])_0x28543d=this[_0x269b3f(0x195)]['WebSocket'];else{if(this[_0x269b3f(0x195)][_0x269b3f(0x11b)]?.[_0x269b3f(0x142)])_0x28543d=this[_0x269b3f(0x195)][_0x269b3f(0x11b)]?.['_WebSocket'];else try{let _0x1f9aba=await import(_0x269b3f(0x151));_0x28543d=(await import((await import(_0x269b3f(0x172)))['pathToFileURL'](_0x1f9aba[_0x269b3f(0x19e)](this[_0x269b3f(0x167)],_0x269b3f(0x1de)))[_0x269b3f(0x12a)]()))[_0x269b3f(0x12e)];}catch{try{_0x28543d=require(require(_0x269b3f(0x151))[_0x269b3f(0x19e)](this[_0x269b3f(0x167)],'ws'));}catch{throw new Error(_0x269b3f(0x16f));}}}return this[_0x269b3f(0x1e3)]=_0x28543d,_0x28543d;}['_connectToHostNow'](){var _0x3c8a9b=_0x24af6e;this[_0x3c8a9b(0x13f)]||this[_0x3c8a9b(0x1b3)]||this['_connectAttemptCount']>=this['_maxConnectAttemptCount']||(this[_0x3c8a9b(0x138)]=!0x1,this['_connecting']=!0x0,this['_connectAttemptCount']++,this[_0x3c8a9b(0x12d)]=new Promise((_0x482c81,_0x1a0e29)=>{var _0x2cf45c=_0x3c8a9b;this['getWebSocketClass']()['then'](_0x29630c=>{var _0x57aacb=_0x3cfb;let _0x422d73=new _0x29630c('ws://'+(!this[_0x57aacb(0x1e5)]&&this['dockerizedApp']?_0x57aacb(0x174):this[_0x57aacb(0x1b6)])+':'+this[_0x57aacb(0x19b)]);_0x422d73['onerror']=()=>{var _0x3b9de9=_0x57aacb;this[_0x3b9de9(0x1d9)]=!0x1,this[_0x3b9de9(0x1ce)](_0x422d73),this[_0x3b9de9(0x1e2)](),_0x1a0e29(new Error(_0x3b9de9(0x140)));},_0x422d73[_0x57aacb(0x14d)]=()=>{var _0x1fc2cd=_0x57aacb;this[_0x1fc2cd(0x1e5)]||_0x422d73[_0x1fc2cd(0x155)]&&_0x422d73[_0x1fc2cd(0x155)][_0x1fc2cd(0x16a)]&&_0x422d73['_socket'][_0x1fc2cd(0x16a)](),_0x482c81(_0x422d73);},_0x422d73[_0x57aacb(0x144)]=()=>{var _0x144348=_0x57aacb;this[_0x144348(0x138)]=!0x0,this[_0x144348(0x1ce)](_0x422d73),this['_attemptToReconnectShortly']();},_0x422d73[_0x57aacb(0x150)]=_0x485a2e=>{var _0x47de9f=_0x57aacb;try{_0x485a2e&&_0x485a2e[_0x47de9f(0x1b9)]&&this[_0x47de9f(0x1e5)]&&JSON['parse'](_0x485a2e[_0x47de9f(0x1b9)])[_0x47de9f(0x1e6)]==='reload'&&this[_0x47de9f(0x195)][_0x47de9f(0x10f)][_0x47de9f(0x1c2)]();}catch{}};})[_0x2cf45c(0x109)](_0x46bccf=>(this[_0x2cf45c(0x1b3)]=!0x0,this[_0x2cf45c(0x13f)]=!0x1,this[_0x2cf45c(0x138)]=!0x1,this[_0x2cf45c(0x1d9)]=!0x0,this[_0x2cf45c(0x184)]=0x0,_0x46bccf))['catch'](_0x3b751f=>(this[_0x2cf45c(0x1b3)]=!0x1,this[_0x2cf45c(0x13f)]=!0x1,console['warn'](_0x2cf45c(0x11f)+this[_0x2cf45c(0x165)]),_0x1a0e29(new Error(_0x2cf45c(0x16c)+(_0x3b751f&&_0x3b751f[_0x2cf45c(0x1a0)])))));}));}[_0x24af6e(0x1ce)](_0x46b2b7){var _0x14224e=_0x24af6e;this['_connected']=!0x1,this['_connecting']=!0x1;try{_0x46b2b7[_0x14224e(0x144)]=null,_0x46b2b7['onerror']=null,_0x46b2b7[_0x14224e(0x14d)]=null;}catch{}try{_0x46b2b7[_0x14224e(0x169)]<0x2&&_0x46b2b7[_0x14224e(0x15b)]();}catch{}}[_0x24af6e(0x1e2)](){var _0x47ffd4=_0x24af6e;clearTimeout(this[_0x47ffd4(0x143)]),!(this[_0x47ffd4(0x184)]>=this[_0x47ffd4(0x1c1)])&&(this[_0x47ffd4(0x143)]=setTimeout(()=>{var _0x5670b2=_0x47ffd4;this[_0x5670b2(0x1b3)]||this[_0x5670b2(0x13f)]||(this[_0x5670b2(0x113)](),this[_0x5670b2(0x12d)]?.[_0x5670b2(0x132)](()=>this['_attemptToReconnectShortly']()));},0x1f4),this[_0x47ffd4(0x143)][_0x47ffd4(0x16a)]&&this[_0x47ffd4(0x143)][_0x47ffd4(0x16a)]());}async[_0x24af6e(0x161)](_0x137ffd){var _0x3175ba=_0x24af6e;try{if(!this['_allowedToSend'])return;this[_0x3175ba(0x138)]&&this[_0x3175ba(0x113)](),(await this[_0x3175ba(0x12d)])[_0x3175ba(0x161)](JSON[_0x3175ba(0x175)](_0x137ffd));}catch(_0x220b5c){console[_0x3175ba(0x1d2)](this['_sendErrorMessage']+':\\x20'+(_0x220b5c&&_0x220b5c[_0x3175ba(0x1a0)])),this['_allowedToSend']=!0x1,this[_0x3175ba(0x1e2)]();}}};function b(_0x36fa48,_0x113692,_0x7168f3,_0x3750c1,_0x5ea13c,_0x5cd4c7){var _0x193a33=_0x24af6e;let _0x447851=_0x7168f3[_0x193a33(0x1c5)](',')[_0x193a33(0x1a7)](_0x18f4f2=>{var _0x11f92d=_0x193a33;try{_0x36fa48[_0x11f92d(0x1e4)]||((_0x5ea13c===_0x11f92d(0x1d5)||_0x5ea13c===_0x11f92d(0x1d6)||_0x5ea13c==='astro'||_0x5ea13c===_0x11f92d(0x1ca))&&(_0x5ea13c+=!_0x36fa48[_0x11f92d(0x11b)]?.[_0x11f92d(0x1b2)]?.['node']&&_0x36fa48[_0x11f92d(0x11b)]?.[_0x11f92d(0x1c7)]?.[_0x11f92d(0x17c)]!=='edge'?_0x11f92d(0x117):_0x11f92d(0x14e)),_0x36fa48[_0x11f92d(0x1e4)]={'id':+new Date(),'tool':_0x5ea13c});let _0x16bd43=new X(_0x36fa48,_0x113692,_0x18f4f2,_0x3750c1,_0x5cd4c7);return _0x16bd43[_0x11f92d(0x161)][_0x11f92d(0x1b5)](_0x16bd43);}catch(_0x31bae7){return console[_0x11f92d(0x1d2)]('logger\\x20failed\\x20to\\x20connect\\x20to\\x20host',_0x31bae7&&_0x31bae7[_0x11f92d(0x1a0)]),()=>{};}});return _0x1db34a=>_0x447851['forEach'](_0x14c34e=>_0x14c34e(_0x1db34a));}function _0x3cfb(_0x3a1172,_0x12c230){var _0x1ba4f5=_0x1ba4();return _0x3cfb=function(_0x3cfbde,_0x23f6e7){_0x3cfbde=_0x3cfbde-0x104;var _0x489f1a=_0x1ba4f5[_0x3cfbde];return _0x489f1a;},_0x3cfb(_0x3a1172,_0x12c230);}function W(_0x524e57){var _0x10a8a3=_0x24af6e;let _0x514f1c=function(_0x41bde4,_0x16808a){return _0x16808a-_0x41bde4;},_0x12f5ea;if(_0x524e57[_0x10a8a3(0x1e7)])_0x12f5ea=function(){var _0x204dbe=_0x10a8a3;return _0x524e57[_0x204dbe(0x1e7)][_0x204dbe(0x11c)]();};else{if(_0x524e57[_0x10a8a3(0x11b)]&&_0x524e57[_0x10a8a3(0x11b)][_0x10a8a3(0x1e8)]&&_0x524e57['process']?.[_0x10a8a3(0x1c7)]?.['NEXT_RUNTIME']!==_0x10a8a3(0x181))_0x12f5ea=function(){var _0x34f373=_0x10a8a3;return _0x524e57[_0x34f373(0x11b)]['hrtime']();},_0x514f1c=function(_0x59ede2,_0x33d407){return 0x3e8*(_0x33d407[0x0]-_0x59ede2[0x0])+(_0x33d407[0x1]-_0x59ede2[0x1])/0xf4240;};else try{let {performance:_0x17e606}=require('perf_hooks');_0x12f5ea=function(){return _0x17e606['now']();};}catch{_0x12f5ea=function(){return+new Date();};}}return{'elapsed':_0x514f1c,'timeStamp':_0x12f5ea,'now':()=>Date[_0x10a8a3(0x11c)]()};}function J(_0x1dc362,_0x1d3d5d,_0x263844){var _0x4f2d89=_0x24af6e;if(_0x1dc362[_0x4f2d89(0x170)]!==void 0x0)return _0x1dc362[_0x4f2d89(0x170)];let _0x3a70e9=_0x1dc362[_0x4f2d89(0x11b)]?.[_0x4f2d89(0x1b2)]?.[_0x4f2d89(0x171)]||_0x1dc362[_0x4f2d89(0x11b)]?.[_0x4f2d89(0x1c7)]?.[_0x4f2d89(0x17c)]==='edge';return _0x3a70e9&&_0x263844==='nuxt'?_0x1dc362['_consoleNinjaAllowedToStart']=!0x1:_0x1dc362[_0x4f2d89(0x170)]=_0x3a70e9||!_0x1d3d5d||_0x1dc362[_0x4f2d89(0x10f)]?.[_0x4f2d89(0x1c9)]&&_0x1d3d5d['includes'](_0x1dc362[_0x4f2d89(0x10f)][_0x4f2d89(0x1c9)]),_0x1dc362[_0x4f2d89(0x170)];}function Y(_0x260822,_0xa33144,_0x6fb393,_0x131282){var _0x174578=_0x24af6e;_0x260822=_0x260822,_0xa33144=_0xa33144,_0x6fb393=_0x6fb393,_0x131282=_0x131282;let _0x17a492=W(_0x260822),_0x298950=_0x17a492[_0x174578(0x17b)],_0x3c02bb=_0x17a492['timeStamp'];class _0xf6d11a{constructor(){var _0x302267=_0x174578;this[_0x302267(0x145)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this['_numberRegExp']=/^(0|[1-9][0-9]*)$/,this[_0x302267(0x1f0)]=/'([^\\\\']|\\\\')*'/,this[_0x302267(0x1cf)]=_0x260822['undefined'],this[_0x302267(0x129)]=_0x260822[_0x302267(0x194)],this[_0x302267(0x164)]=Object[_0x302267(0x1c0)],this['_getOwnPropertyNames']=Object[_0x302267(0x177)],this['_Symbol']=_0x260822[_0x302267(0x1d4)],this[_0x302267(0x13c)]=RegExp[_0x302267(0x13d)][_0x302267(0x12a)],this[_0x302267(0x1a3)]=Date['prototype'][_0x302267(0x12a)];}['serialize'](_0x10d75d,_0x537954,_0x53a4a3,_0x34d948){var _0x2b9dab=_0x174578,_0x8c21d4=this,_0x58f0f5=_0x53a4a3[_0x2b9dab(0x152)];function _0x45a725(_0x4872ec,_0x3ff946,_0x3bc435){var _0x4d55ec=_0x2b9dab;_0x3ff946[_0x4d55ec(0x110)]=_0x4d55ec(0x1aa),_0x3ff946[_0x4d55ec(0x14b)]=_0x4872ec[_0x4d55ec(0x1a0)],_0x10bbfa=_0x3bc435[_0x4d55ec(0x171)]['current'],_0x3bc435[_0x4d55ec(0x171)]['current']=_0x3ff946,_0x8c21d4[_0x4d55ec(0x1df)](_0x3ff946,_0x3bc435);}try{_0x53a4a3[_0x2b9dab(0x10a)]++,_0x53a4a3['autoExpand']&&_0x53a4a3[_0x2b9dab(0x1a5)][_0x2b9dab(0x1b7)](_0x537954);var _0x4d21f0,_0x1b8ccd,_0x2edc93,_0x1b9535,_0x1b37ba=[],_0x53b10b=[],_0x36cf72,_0x12e4ac=this[_0x2b9dab(0x1a8)](_0x537954),_0x23864b=_0x12e4ac==='array',_0x148180=!0x1,_0x24ad9f=_0x12e4ac===_0x2b9dab(0x13e),_0x546ec4=this['_isPrimitiveType'](_0x12e4ac),_0x2c463d=this[_0x2b9dab(0x173)](_0x12e4ac),_0x101a1d=_0x546ec4||_0x2c463d,_0x4a254f={},_0xf5a5b6=0x0,_0x2829ff=!0x1,_0x10bbfa,_0x34ac66=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x53a4a3[_0x2b9dab(0x1bf)]){if(_0x23864b){if(_0x1b8ccd=_0x537954[_0x2b9dab(0x180)],_0x1b8ccd>_0x53a4a3[_0x2b9dab(0x125)]){for(_0x2edc93=0x0,_0x1b9535=_0x53a4a3[_0x2b9dab(0x125)],_0x4d21f0=_0x2edc93;_0x4d21f0<_0x1b9535;_0x4d21f0++)_0x53b10b['push'](_0x8c21d4[_0x2b9dab(0x120)](_0x1b37ba,_0x537954,_0x12e4ac,_0x4d21f0,_0x53a4a3));_0x10d75d[_0x2b9dab(0x19c)]=!0x0;}else{for(_0x2edc93=0x0,_0x1b9535=_0x1b8ccd,_0x4d21f0=_0x2edc93;_0x4d21f0<_0x1b9535;_0x4d21f0++)_0x53b10b[_0x2b9dab(0x1b7)](_0x8c21d4['_addProperty'](_0x1b37ba,_0x537954,_0x12e4ac,_0x4d21f0,_0x53a4a3));}_0x53a4a3[_0x2b9dab(0x1cd)]+=_0x53b10b[_0x2b9dab(0x180)];}if(!(_0x12e4ac===_0x2b9dab(0x126)||_0x12e4ac===_0x2b9dab(0x121))&&!_0x546ec4&&_0x12e4ac!==_0x2b9dab(0x146)&&_0x12e4ac!=='Buffer'&&_0x12e4ac!==_0x2b9dab(0x1c6)){var _0x523740=_0x34d948[_0x2b9dab(0x1ba)]||_0x53a4a3[_0x2b9dab(0x1ba)];if(this['_isSet'](_0x537954)?(_0x4d21f0=0x0,_0x537954[_0x2b9dab(0x193)](function(_0x1f040b){var _0x3c57c9=_0x2b9dab;if(_0xf5a5b6++,_0x53a4a3[_0x3c57c9(0x1cd)]++,_0xf5a5b6>_0x523740){_0x2829ff=!0x0;return;}if(!_0x53a4a3[_0x3c57c9(0x16d)]&&_0x53a4a3[_0x3c57c9(0x152)]&&_0x53a4a3[_0x3c57c9(0x1cd)]>_0x53a4a3[_0x3c57c9(0x19a)]){_0x2829ff=!0x0;return;}_0x53b10b[_0x3c57c9(0x1b7)](_0x8c21d4[_0x3c57c9(0x120)](_0x1b37ba,_0x537954,_0x3c57c9(0x114),_0x4d21f0++,_0x53a4a3,function(_0x7fbeee){return function(){return _0x7fbeee;};}(_0x1f040b)));})):this[_0x2b9dab(0x128)](_0x537954)&&_0x537954['forEach'](function(_0xea7a37,_0x4f1472){var _0x3b0da6=_0x2b9dab;if(_0xf5a5b6++,_0x53a4a3[_0x3b0da6(0x1cd)]++,_0xf5a5b6>_0x523740){_0x2829ff=!0x0;return;}if(!_0x53a4a3[_0x3b0da6(0x16d)]&&_0x53a4a3['autoExpand']&&_0x53a4a3[_0x3b0da6(0x1cd)]>_0x53a4a3[_0x3b0da6(0x19a)]){_0x2829ff=!0x0;return;}var _0x4a18a5=_0x4f1472[_0x3b0da6(0x12a)]();_0x4a18a5[_0x3b0da6(0x180)]>0x64&&(_0x4a18a5=_0x4a18a5['slice'](0x0,0x64)+_0x3b0da6(0x1a6)),_0x53b10b['push'](_0x8c21d4['_addProperty'](_0x1b37ba,_0x537954,_0x3b0da6(0x104),_0x4a18a5,_0x53a4a3,function(_0x23265e){return function(){return _0x23265e;};}(_0xea7a37)));}),!_0x148180){try{for(_0x36cf72 in _0x537954)if(!(_0x23864b&&_0x34ac66[_0x2b9dab(0x1ea)](_0x36cf72))&&!this[_0x2b9dab(0x18f)](_0x537954,_0x36cf72,_0x53a4a3)){if(_0xf5a5b6++,_0x53a4a3[_0x2b9dab(0x1cd)]++,_0xf5a5b6>_0x523740){_0x2829ff=!0x0;break;}if(!_0x53a4a3[_0x2b9dab(0x16d)]&&_0x53a4a3[_0x2b9dab(0x152)]&&_0x53a4a3['autoExpandPropertyCount']>_0x53a4a3[_0x2b9dab(0x19a)]){_0x2829ff=!0x0;break;}_0x53b10b[_0x2b9dab(0x1b7)](_0x8c21d4[_0x2b9dab(0x185)](_0x1b37ba,_0x4a254f,_0x537954,_0x12e4ac,_0x36cf72,_0x53a4a3));}}catch{}if(_0x4a254f[_0x2b9dab(0x1eb)]=!0x0,_0x24ad9f&&(_0x4a254f[_0x2b9dab(0x183)]=!0x0),!_0x2829ff){var _0x4f1092=[][_0x2b9dab(0x1d7)](this[_0x2b9dab(0x1ab)](_0x537954))[_0x2b9dab(0x1d7)](this[_0x2b9dab(0x1a2)](_0x537954));for(_0x4d21f0=0x0,_0x1b8ccd=_0x4f1092['length'];_0x4d21f0<_0x1b8ccd;_0x4d21f0++)if(_0x36cf72=_0x4f1092[_0x4d21f0],!(_0x23864b&&_0x34ac66[_0x2b9dab(0x1ea)](_0x36cf72[_0x2b9dab(0x12a)]()))&&!this[_0x2b9dab(0x18f)](_0x537954,_0x36cf72,_0x53a4a3)&&!_0x4a254f['_p_'+_0x36cf72[_0x2b9dab(0x12a)]()]){if(_0xf5a5b6++,_0x53a4a3['autoExpandPropertyCount']++,_0xf5a5b6>_0x523740){_0x2829ff=!0x0;break;}if(!_0x53a4a3['isExpressionToEvaluate']&&_0x53a4a3[_0x2b9dab(0x152)]&&_0x53a4a3[_0x2b9dab(0x1cd)]>_0x53a4a3[_0x2b9dab(0x19a)]){_0x2829ff=!0x0;break;}_0x53b10b[_0x2b9dab(0x1b7)](_0x8c21d4['_addObjectProperty'](_0x1b37ba,_0x4a254f,_0x537954,_0x12e4ac,_0x36cf72,_0x53a4a3));}}}}}if(_0x10d75d[_0x2b9dab(0x110)]=_0x12e4ac,_0x101a1d?(_0x10d75d['value']=_0x537954[_0x2b9dab(0x1b4)](),this[_0x2b9dab(0x189)](_0x12e4ac,_0x10d75d,_0x53a4a3,_0x34d948)):_0x12e4ac===_0x2b9dab(0x11d)?_0x10d75d[_0x2b9dab(0x107)]=this[_0x2b9dab(0x1a3)][_0x2b9dab(0x17e)](_0x537954):_0x12e4ac===_0x2b9dab(0x1c6)?_0x10d75d['value']=_0x537954[_0x2b9dab(0x12a)]():_0x12e4ac===_0x2b9dab(0x1b0)?_0x10d75d['value']=this[_0x2b9dab(0x13c)][_0x2b9dab(0x17e)](_0x537954):_0x12e4ac===_0x2b9dab(0x122)&&this['_Symbol']?_0x10d75d[_0x2b9dab(0x107)]=this[_0x2b9dab(0x1e9)][_0x2b9dab(0x13d)][_0x2b9dab(0x12a)]['call'](_0x537954):!_0x53a4a3['depth']&&!(_0x12e4ac===_0x2b9dab(0x126)||_0x12e4ac===_0x2b9dab(0x121))&&(delete _0x10d75d['value'],_0x10d75d[_0x2b9dab(0x154)]=!0x0),_0x2829ff&&(_0x10d75d[_0x2b9dab(0x1bd)]=!0x0),_0x10bbfa=_0x53a4a3['node'][_0x2b9dab(0x118)],_0x53a4a3['node']['current']=_0x10d75d,this['_treeNodePropertiesBeforeFullValue'](_0x10d75d,_0x53a4a3),_0x53b10b[_0x2b9dab(0x180)]){for(_0x4d21f0=0x0,_0x1b8ccd=_0x53b10b['length'];_0x4d21f0<_0x1b8ccd;_0x4d21f0++)_0x53b10b[_0x4d21f0](_0x4d21f0);}_0x1b37ba['length']&&(_0x10d75d[_0x2b9dab(0x1ba)]=_0x1b37ba);}catch(_0x3a3d4c){_0x45a725(_0x3a3d4c,_0x10d75d,_0x53a4a3);}return this[_0x2b9dab(0x135)](_0x537954,_0x10d75d),this['_treeNodePropertiesAfterFullValue'](_0x10d75d,_0x53a4a3),_0x53a4a3[_0x2b9dab(0x171)][_0x2b9dab(0x118)]=_0x10bbfa,_0x53a4a3[_0x2b9dab(0x10a)]--,_0x53a4a3[_0x2b9dab(0x152)]=_0x58f0f5,_0x53a4a3['autoExpand']&&_0x53a4a3[_0x2b9dab(0x1a5)]['pop'](),_0x10d75d;}[_0x174578(0x1a2)](_0x566668){var _0x538282=_0x174578;return Object['getOwnPropertySymbols']?Object[_0x538282(0x18e)](_0x566668):[];}[_0x174578(0x1c8)](_0x149548){var _0x3eeb81=_0x174578;return!!(_0x149548&&_0x260822[_0x3eeb81(0x114)]&&this['_objectToString'](_0x149548)===_0x3eeb81(0x108)&&_0x149548[_0x3eeb81(0x193)]);}[_0x174578(0x18f)](_0x51a0ca,_0x3c87c9,_0x370dbc){var _0x554ad=_0x174578;return _0x370dbc['noFunctions']?typeof _0x51a0ca[_0x3c87c9]==_0x554ad(0x13e):!0x1;}[_0x174578(0x1a8)](_0x40e046){var _0xa27de4=_0x174578,_0x1dc087='';return _0x1dc087=typeof _0x40e046,_0x1dc087===_0xa27de4(0x17d)?this['_objectToString'](_0x40e046)===_0xa27de4(0x178)?_0x1dc087=_0xa27de4(0x199):this[_0xa27de4(0x112)](_0x40e046)===_0xa27de4(0x18d)?_0x1dc087=_0xa27de4(0x11d):this[_0xa27de4(0x112)](_0x40e046)===_0xa27de4(0x1ec)?_0x1dc087=_0xa27de4(0x1c6):_0x40e046===null?_0x1dc087=_0xa27de4(0x126):_0x40e046[_0xa27de4(0x137)]&&(_0x1dc087=_0x40e046[_0xa27de4(0x137)][_0xa27de4(0x162)]||_0x1dc087):_0x1dc087===_0xa27de4(0x121)&&this[_0xa27de4(0x129)]&&_0x40e046 instanceof this['_HTMLAllCollection']&&(_0x1dc087='HTMLAllCollection'),_0x1dc087;}[_0x174578(0x112)](_0x176202){var _0x302982=_0x174578;return Object[_0x302982(0x13d)]['toString'][_0x302982(0x17e)](_0x176202);}[_0x174578(0x111)](_0x5ea248){var _0xdbf1b7=_0x174578;return _0x5ea248===_0xdbf1b7(0x15a)||_0x5ea248===_0xdbf1b7(0x149)||_0x5ea248===_0xdbf1b7(0x1b1);}[_0x174578(0x173)](_0x62fdf9){var _0x40a0bb=_0x174578;return _0x62fdf9===_0x40a0bb(0x1d3)||_0x62fdf9===_0x40a0bb(0x146)||_0x62fdf9===_0x40a0bb(0x1b8);}[_0x174578(0x120)](_0x308682,_0x2d811c,_0x5061f1,_0x11124c,_0x245505,_0x18b888){var _0x3ebe98=this;return function(_0x25ea1d){var _0x2e8dfe=_0x3cfb,_0x4a9a45=_0x245505['node']['current'],_0x338487=_0x245505[_0x2e8dfe(0x171)][_0x2e8dfe(0x1cb)],_0x517034=_0x245505[_0x2e8dfe(0x171)]['parent'];_0x245505[_0x2e8dfe(0x171)][_0x2e8dfe(0x1c3)]=_0x4a9a45,_0x245505['node'][_0x2e8dfe(0x1cb)]=typeof _0x11124c=='number'?_0x11124c:_0x25ea1d,_0x308682[_0x2e8dfe(0x1b7)](_0x3ebe98[_0x2e8dfe(0x18b)](_0x2d811c,_0x5061f1,_0x11124c,_0x245505,_0x18b888)),_0x245505[_0x2e8dfe(0x171)]['parent']=_0x517034,_0x245505['node'][_0x2e8dfe(0x1cb)]=_0x338487;};}[_0x174578(0x185)](_0x583829,_0x1a94b9,_0x25b743,_0x13285a,_0x41a249,_0x46821a,_0x44f9b6){var _0x255893=this;return _0x1a94b9['_p_'+_0x41a249['toString']()]=!0x0,function(_0x3cf47){var _0x5ce8d7=_0x3cfb,_0x2405f2=_0x46821a[_0x5ce8d7(0x171)][_0x5ce8d7(0x118)],_0x3f151d=_0x46821a[_0x5ce8d7(0x171)][_0x5ce8d7(0x1cb)],_0x38358f=_0x46821a['node'][_0x5ce8d7(0x1c3)];_0x46821a['node'][_0x5ce8d7(0x1c3)]=_0x2405f2,_0x46821a[_0x5ce8d7(0x171)][_0x5ce8d7(0x1cb)]=_0x3cf47,_0x583829[_0x5ce8d7(0x1b7)](_0x255893[_0x5ce8d7(0x18b)](_0x25b743,_0x13285a,_0x41a249,_0x46821a,_0x44f9b6)),_0x46821a[_0x5ce8d7(0x171)]['parent']=_0x38358f,_0x46821a[_0x5ce8d7(0x171)][_0x5ce8d7(0x1cb)]=_0x3f151d;};}[_0x174578(0x18b)](_0x48bda0,_0x2e9a0b,_0x239439,_0x4d4922,_0x35898e){var _0x23c239=_0x174578,_0x32145d=this;_0x35898e||(_0x35898e=function(_0x3822ee,_0x3b24ed){return _0x3822ee[_0x3b24ed];});var _0x495af4=_0x239439[_0x23c239(0x12a)](),_0x55586f=_0x4d4922['expressionsToEvaluate']||{},_0x102336=_0x4d4922[_0x23c239(0x1bf)],_0x24b55b=_0x4d4922[_0x23c239(0x16d)];try{var _0x171801=this['_isMap'](_0x48bda0),_0x18a838=_0x495af4;_0x171801&&_0x18a838[0x0]==='\\x27'&&(_0x18a838=_0x18a838[_0x23c239(0x127)](0x1,_0x18a838[_0x23c239(0x180)]-0x2));var _0x5eea2c=_0x4d4922[_0x23c239(0x133)]=_0x55586f[_0x23c239(0x156)+_0x18a838];_0x5eea2c&&(_0x4d4922[_0x23c239(0x1bf)]=_0x4d4922['depth']+0x1),_0x4d4922[_0x23c239(0x16d)]=!!_0x5eea2c;var _0x4ed08c=typeof _0x239439==_0x23c239(0x122),_0x57df77={'name':_0x4ed08c||_0x171801?_0x495af4:this[_0x23c239(0x13b)](_0x495af4)};if(_0x4ed08c&&(_0x57df77['symbol']=!0x0),!(_0x2e9a0b===_0x23c239(0x199)||_0x2e9a0b===_0x23c239(0x187))){var _0x394a14=this[_0x23c239(0x164)](_0x48bda0,_0x239439);if(_0x394a14&&(_0x394a14[_0x23c239(0x1a9)]&&(_0x57df77['setter']=!0x0),_0x394a14[_0x23c239(0x1d1)]&&!_0x5eea2c&&!_0x4d4922[_0x23c239(0x12f)]))return _0x57df77['getter']=!0x0,this[_0x23c239(0x1af)](_0x57df77,_0x4d4922),_0x57df77;}var _0x21b969;try{_0x21b969=_0x35898e(_0x48bda0,_0x239439);}catch(_0x5985fc){return _0x57df77={'name':_0x495af4,'type':_0x23c239(0x1aa),'error':_0x5985fc['message']},this[_0x23c239(0x1af)](_0x57df77,_0x4d4922),_0x57df77;}var _0x3d30d3=this[_0x23c239(0x1a8)](_0x21b969),_0x499bf2=this['_isPrimitiveType'](_0x3d30d3);if(_0x57df77[_0x23c239(0x110)]=_0x3d30d3,_0x499bf2)this[_0x23c239(0x1af)](_0x57df77,_0x4d4922,_0x21b969,function(){var _0x5e72cc=_0x23c239;_0x57df77[_0x5e72cc(0x107)]=_0x21b969[_0x5e72cc(0x1b4)](),!_0x5eea2c&&_0x32145d['_capIfString'](_0x3d30d3,_0x57df77,_0x4d4922,{});});else{var _0xfe447c=_0x4d4922[_0x23c239(0x152)]&&_0x4d4922[_0x23c239(0x10a)]<_0x4d4922['autoExpandMaxDepth']&&_0x4d4922[_0x23c239(0x1a5)][_0x23c239(0x148)](_0x21b969)<0x0&&_0x3d30d3!==_0x23c239(0x13e)&&_0x4d4922[_0x23c239(0x1cd)]<_0x4d4922[_0x23c239(0x19a)];_0xfe447c||_0x4d4922[_0x23c239(0x10a)]<_0x102336||_0x5eea2c?(this['serialize'](_0x57df77,_0x21b969,_0x4d4922,_0x5eea2c||{}),this[_0x23c239(0x135)](_0x21b969,_0x57df77)):this['_processTreeNodeResult'](_0x57df77,_0x4d4922,_0x21b969,function(){var _0x2a6241=_0x23c239;_0x3d30d3==='null'||_0x3d30d3==='undefined'||(delete _0x57df77[_0x2a6241(0x107)],_0x57df77[_0x2a6241(0x154)]=!0x0);});}return _0x57df77;}finally{_0x4d4922[_0x23c239(0x133)]=_0x55586f,_0x4d4922['depth']=_0x102336,_0x4d4922[_0x23c239(0x16d)]=_0x24b55b;}}[_0x174578(0x189)](_0x401e08,_0x22ae66,_0x3810e6,_0x1588f0){var _0x33ccd0=_0x174578,_0x3855ed=_0x1588f0[_0x33ccd0(0x176)]||_0x3810e6[_0x33ccd0(0x176)];if((_0x401e08===_0x33ccd0(0x149)||_0x401e08===_0x33ccd0(0x146))&&_0x22ae66[_0x33ccd0(0x107)]){let _0xd02c93=_0x22ae66[_0x33ccd0(0x107)][_0x33ccd0(0x180)];_0x3810e6['allStrLength']+=_0xd02c93,_0x3810e6[_0x33ccd0(0x1cc)]>_0x3810e6['totalStrLength']?(_0x22ae66[_0x33ccd0(0x154)]='',delete _0x22ae66['value']):_0xd02c93>_0x3855ed&&(_0x22ae66[_0x33ccd0(0x154)]=_0x22ae66[_0x33ccd0(0x107)][_0x33ccd0(0x127)](0x0,_0x3855ed),delete _0x22ae66[_0x33ccd0(0x107)]);}}[_0x174578(0x128)](_0x538f56){var _0x1f312b=_0x174578;return!!(_0x538f56&&_0x260822[_0x1f312b(0x104)]&&this[_0x1f312b(0x112)](_0x538f56)===_0x1f312b(0x130)&&_0x538f56[_0x1f312b(0x193)]);}[_0x174578(0x13b)](_0x18296b){var _0x4b0b06=_0x174578;if(_0x18296b[_0x4b0b06(0x1dc)](/^\\d+$/))return _0x18296b;var _0x557d89;try{_0x557d89=JSON[_0x4b0b06(0x175)](''+_0x18296b);}catch{_0x557d89='\\x22'+this[_0x4b0b06(0x112)](_0x18296b)+'\\x22';}return _0x557d89[_0x4b0b06(0x1dc)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x557d89=_0x557d89[_0x4b0b06(0x127)](0x1,_0x557d89['length']-0x2):_0x557d89=_0x557d89['replace'](/'/g,'\\x5c\\x27')[_0x4b0b06(0x16b)](/\\\\\"/g,'\\x22')[_0x4b0b06(0x16b)](/(^\"|\"$)/g,'\\x27'),_0x557d89;}['_processTreeNodeResult'](_0x5e0219,_0x216cb0,_0x10c23a,_0x4ea35d){var _0x223dff=_0x174578;this['_treeNodePropertiesBeforeFullValue'](_0x5e0219,_0x216cb0),_0x4ea35d&&_0x4ea35d(),this[_0x223dff(0x135)](_0x10c23a,_0x5e0219),this[_0x223dff(0x12b)](_0x5e0219,_0x216cb0);}[_0x174578(0x1df)](_0x4c69a0,_0x39f44e){var _0x550405=_0x174578;this[_0x550405(0x159)](_0x4c69a0,_0x39f44e),this[_0x550405(0x1ee)](_0x4c69a0,_0x39f44e),this[_0x550405(0x14f)](_0x4c69a0,_0x39f44e),this[_0x550405(0x158)](_0x4c69a0,_0x39f44e);}[_0x174578(0x159)](_0x42219a,_0x21e9b0){}['_setNodeQueryPath'](_0x1133bc,_0x130a77){}['_setNodeLabel'](_0x5723ca,_0x47e2b3){}[_0x174578(0x1e1)](_0x57dea1){return _0x57dea1===this['_undefined'];}['_treeNodePropertiesAfterFullValue'](_0x2e181a,_0x39a3e9){var _0x3921bf=_0x174578;this[_0x3921bf(0x1bb)](_0x2e181a,_0x39a3e9),this[_0x3921bf(0x11a)](_0x2e181a),_0x39a3e9[_0x3921bf(0x19f)]&&this['_sortProps'](_0x2e181a),this['_addFunctionsNode'](_0x2e181a,_0x39a3e9),this[_0x3921bf(0x163)](_0x2e181a,_0x39a3e9),this[_0x3921bf(0x1ae)](_0x2e181a);}[_0x174578(0x135)](_0x5e6dd7,_0x15696f){var _0x4ba12e=_0x174578;let _0x1c9167;try{_0x260822['console']&&(_0x1c9167=_0x260822[_0x4ba12e(0x1e0)][_0x4ba12e(0x14b)],_0x260822['console'][_0x4ba12e(0x14b)]=function(){}),_0x5e6dd7&&typeof _0x5e6dd7['length']==_0x4ba12e(0x1b1)&&(_0x15696f[_0x4ba12e(0x180)]=_0x5e6dd7[_0x4ba12e(0x180)]);}catch{}finally{_0x1c9167&&(_0x260822['console'][_0x4ba12e(0x14b)]=_0x1c9167);}if(_0x15696f[_0x4ba12e(0x110)]===_0x4ba12e(0x1b1)||_0x15696f[_0x4ba12e(0x110)]===_0x4ba12e(0x1b8)){if(isNaN(_0x15696f[_0x4ba12e(0x107)]))_0x15696f[_0x4ba12e(0x1a4)]=!0x0,delete _0x15696f['value'];else switch(_0x15696f[_0x4ba12e(0x107)]){case Number[_0x4ba12e(0x179)]:_0x15696f[_0x4ba12e(0x157)]=!0x0,delete _0x15696f[_0x4ba12e(0x107)];break;case Number[_0x4ba12e(0x141)]:_0x15696f[_0x4ba12e(0x106)]=!0x0,delete _0x15696f[_0x4ba12e(0x107)];break;case 0x0:this['_isNegativeZero'](_0x15696f[_0x4ba12e(0x107)])&&(_0x15696f['negativeZero']=!0x0);break;}}else _0x15696f[_0x4ba12e(0x110)]===_0x4ba12e(0x13e)&&typeof _0x5e6dd7[_0x4ba12e(0x162)]=='string'&&_0x5e6dd7[_0x4ba12e(0x162)]&&_0x15696f[_0x4ba12e(0x162)]&&_0x5e6dd7[_0x4ba12e(0x162)]!==_0x15696f[_0x4ba12e(0x162)]&&(_0x15696f[_0x4ba12e(0x1be)]=_0x5e6dd7[_0x4ba12e(0x162)]);}['_isNegativeZero'](_0x3eb735){var _0x5e08d5=_0x174578;return 0x1/_0x3eb735===Number[_0x5e08d5(0x141)];}[_0x174578(0x136)](_0x1d896a){var _0x1dc2fe=_0x174578;!_0x1d896a['props']||!_0x1d896a[_0x1dc2fe(0x1ba)]['length']||_0x1d896a[_0x1dc2fe(0x110)]===_0x1dc2fe(0x199)||_0x1d896a[_0x1dc2fe(0x110)]===_0x1dc2fe(0x104)||_0x1d896a[_0x1dc2fe(0x110)]===_0x1dc2fe(0x114)||_0x1d896a[_0x1dc2fe(0x1ba)]['sort'](function(_0x4d079a,_0x1aaf45){var _0x4bf240=_0x1dc2fe,_0x38311b=_0x4d079a[_0x4bf240(0x162)][_0x4bf240(0x198)](),_0x4d08f9=_0x1aaf45[_0x4bf240(0x162)][_0x4bf240(0x198)]();return _0x38311b<_0x4d08f9?-0x1:_0x38311b>_0x4d08f9?0x1:0x0;});}[_0x174578(0x1d8)](_0x1580e8,_0x444c8a){var _0x19ea0e=_0x174578;if(!(_0x444c8a[_0x19ea0e(0x153)]||!_0x1580e8[_0x19ea0e(0x1ba)]||!_0x1580e8['props'][_0x19ea0e(0x180)])){for(var _0x450078=[],_0x57f8a9=[],_0x4f637f=0x0,_0x20a83d=_0x1580e8[_0x19ea0e(0x1ba)][_0x19ea0e(0x180)];_0x4f637f<_0x20a83d;_0x4f637f++){var _0x720862=_0x1580e8[_0x19ea0e(0x1ba)][_0x4f637f];_0x720862[_0x19ea0e(0x110)]==='function'?_0x450078[_0x19ea0e(0x1b7)](_0x720862):_0x57f8a9[_0x19ea0e(0x1b7)](_0x720862);}if(!(!_0x57f8a9[_0x19ea0e(0x180)]||_0x450078[_0x19ea0e(0x180)]<=0x1)){_0x1580e8[_0x19ea0e(0x1ba)]=_0x57f8a9;var _0x34c242={'functionsNode':!0x0,'props':_0x450078};this['_setNodeId'](_0x34c242,_0x444c8a),this[_0x19ea0e(0x1bb)](_0x34c242,_0x444c8a),this[_0x19ea0e(0x11a)](_0x34c242),this['_setNodePermissions'](_0x34c242,_0x444c8a),_0x34c242['id']+='\\x20f',_0x1580e8[_0x19ea0e(0x1ba)][_0x19ea0e(0x15f)](_0x34c242);}}}['_addLoadNode'](_0x42d9d4,_0x516f68){}[_0x174578(0x11a)](_0x240cbc){}[_0x174578(0x14c)](_0x5dc223){var _0x370f97=_0x174578;return Array[_0x370f97(0x147)](_0x5dc223)||typeof _0x5dc223==_0x370f97(0x17d)&&this['_objectToString'](_0x5dc223)===_0x370f97(0x178);}[_0x174578(0x158)](_0x587285,_0x351c83){}[_0x174578(0x1ae)](_0x11bfa0){var _0x3768f3=_0x174578;delete _0x11bfa0[_0x3768f3(0x131)],delete _0x11bfa0[_0x3768f3(0x1ed)],delete _0x11bfa0[_0x3768f3(0x18c)];}['_setNodeExpressionPath'](_0x18dd6d,_0x47a9fd){}}let _0x10c2da=new _0xf6d11a(),_0x114b30={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x4b2d63={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2};function _0x1e9ae2(_0x59f49a,_0x1f48d0,_0x595800,_0x5afa5e,_0x5d3d1b,_0x2c52b5){var _0x59131e=_0x174578;let _0x10f1d2,_0x1961e9;try{_0x1961e9=_0x3c02bb(),_0x10f1d2=_0x6fb393[_0x1f48d0],!_0x10f1d2||_0x1961e9-_0x10f1d2['ts']>0x1f4&&_0x10f1d2[_0x59131e(0x15e)]&&_0x10f1d2[_0x59131e(0x15c)]/_0x10f1d2['count']<0x64?(_0x6fb393[_0x1f48d0]=_0x10f1d2={'count':0x0,'time':0x0,'ts':_0x1961e9},_0x6fb393[_0x59131e(0x139)]={}):_0x1961e9-_0x6fb393[_0x59131e(0x139)]['ts']>0x32&&_0x6fb393[_0x59131e(0x139)]['count']&&_0x6fb393[_0x59131e(0x139)][_0x59131e(0x15c)]/_0x6fb393[_0x59131e(0x139)][_0x59131e(0x15e)]<0x64&&(_0x6fb393[_0x59131e(0x139)]={});let _0x1cccd9=[],_0x5ddea0=_0x10f1d2[_0x59131e(0x105)]||_0x6fb393[_0x59131e(0x139)][_0x59131e(0x105)]?_0x4b2d63:_0x114b30,_0x56e406=_0x532abf=>{var _0x594ad8=_0x59131e;let _0x1f5c14={};return _0x1f5c14[_0x594ad8(0x1ba)]=_0x532abf[_0x594ad8(0x1ba)],_0x1f5c14[_0x594ad8(0x125)]=_0x532abf[_0x594ad8(0x125)],_0x1f5c14['strLength']=_0x532abf[_0x594ad8(0x176)],_0x1f5c14[_0x594ad8(0x192)]=_0x532abf[_0x594ad8(0x192)],_0x1f5c14[_0x594ad8(0x19a)]=_0x532abf['autoExpandLimit'],_0x1f5c14['autoExpandMaxDepth']=_0x532abf[_0x594ad8(0x1ac)],_0x1f5c14['sortProps']=!0x1,_0x1f5c14[_0x594ad8(0x153)]=!_0xa33144,_0x1f5c14[_0x594ad8(0x1bf)]=0x1,_0x1f5c14['level']=0x0,_0x1f5c14[_0x594ad8(0x1c4)]=_0x594ad8(0x160),_0x1f5c14[_0x594ad8(0x119)]=_0x594ad8(0x15d),_0x1f5c14[_0x594ad8(0x152)]=!0x0,_0x1f5c14[_0x594ad8(0x1a5)]=[],_0x1f5c14[_0x594ad8(0x1cd)]=0x0,_0x1f5c14[_0x594ad8(0x12f)]=!0x0,_0x1f5c14[_0x594ad8(0x1cc)]=0x0,_0x1f5c14[_0x594ad8(0x171)]={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x1f5c14;};for(var _0x3559ed=0x0;_0x3559ed<_0x5d3d1b['length'];_0x3559ed++)_0x1cccd9[_0x59131e(0x1b7)](_0x10c2da['serialize']({'timeNode':_0x59f49a===_0x59131e(0x15c)||void 0x0},_0x5d3d1b[_0x3559ed],_0x56e406(_0x5ddea0),{}));if(_0x59f49a===_0x59131e(0x123)){let _0x4a8ff1=Error[_0x59131e(0x186)];try{Error['stackTraceLimit']=0x1/0x0,_0x1cccd9[_0x59131e(0x1b7)](_0x10c2da['serialize']({'stackNode':!0x0},new Error()[_0x59131e(0x1db)],_0x56e406(_0x5ddea0),{'strLength':0x1/0x0}));}finally{Error[_0x59131e(0x186)]=_0x4a8ff1;}}return{'method':'log','version':_0x131282,'args':[{'ts':_0x595800,'session':_0x5afa5e,'args':_0x1cccd9,'id':_0x1f48d0,'context':_0x2c52b5}]};}catch(_0x1c2c3c){return{'method':_0x59131e(0x188),'version':_0x131282,'args':[{'ts':_0x595800,'session':_0x5afa5e,'args':[{'type':_0x59131e(0x1aa),'error':_0x1c2c3c&&_0x1c2c3c[_0x59131e(0x1a0)]}],'id':_0x1f48d0,'context':_0x2c52b5}]};}finally{try{if(_0x10f1d2&&_0x1961e9){let _0xc2f24f=_0x3c02bb();_0x10f1d2['count']++,_0x10f1d2[_0x59131e(0x15c)]+=_0x298950(_0x1961e9,_0xc2f24f),_0x10f1d2['ts']=_0xc2f24f,_0x6fb393[_0x59131e(0x139)]['count']++,_0x6fb393['hits']['time']+=_0x298950(_0x1961e9,_0xc2f24f),_0x6fb393[_0x59131e(0x139)]['ts']=_0xc2f24f,(_0x10f1d2[_0x59131e(0x15e)]>0x32||_0x10f1d2['time']>0x64)&&(_0x10f1d2[_0x59131e(0x105)]=!0x0),(_0x6fb393['hits'][_0x59131e(0x15e)]>0x3e8||_0x6fb393[_0x59131e(0x139)][_0x59131e(0x15c)]>0x12c)&&(_0x6fb393[_0x59131e(0x139)]['reduceLimits']=!0x0);}}catch{}}}return _0x1e9ae2;}((_0x1e5937,_0x47277a,_0xdaced7,_0x4a8ce9,_0x1e5ad9,_0x2c6274,_0x310708,_0x50c6c6,_0x4d6e0c,_0x4772bf)=>{var _0x395452=_0x24af6e;if(_0x1e5937['_console_ninja'])return _0x1e5937[_0x395452(0x18a)];if(!J(_0x1e5937,_0x50c6c6,_0x1e5ad9))return _0x1e5937['_console_ninja']={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'coverage':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x1e5937['_console_ninja'];let _0x1ecc09=W(_0x1e5937),_0x811d42=_0x1ecc09[_0x395452(0x17b)],_0x3156e7=_0x1ecc09[_0x395452(0x13a)],_0xe2b65=_0x1ecc09[_0x395452(0x11c)],_0x2dc4d2={'hits':{},'ts':{}},_0xc341eb=Y(_0x1e5937,_0x4d6e0c,_0x2dc4d2,_0x2c6274),_0x27404b=_0x2bc4f7=>{_0x2dc4d2['ts'][_0x2bc4f7]=_0x3156e7();},_0x57cc5d=(_0x1ed200,_0x249fcd)=>{var _0x2ff026=_0x395452;let _0xd1ee06=_0x2dc4d2['ts'][_0x249fcd];if(delete _0x2dc4d2['ts'][_0x249fcd],_0xd1ee06){let _0x2213ad=_0x811d42(_0xd1ee06,_0x3156e7());_0xe88d3d(_0xc341eb(_0x2ff026(0x15c),_0x1ed200,_0xe2b65(),_0x5e4896,[_0x2213ad],_0x249fcd));}},_0x4aa442=_0x26728f=>_0x56cd92=>{var _0x4739d5=_0x395452;try{_0x27404b(_0x56cd92),_0x26728f(_0x56cd92);}finally{_0x1e5937[_0x4739d5(0x1e0)]['time']=_0x26728f;}},_0x264f3d=_0x3a7359=>_0x1e2f90=>{var _0x57a785=_0x395452;try{let [_0x316fd,_0x2055cc]=_0x1e2f90[_0x57a785(0x1c5)](_0x57a785(0x19d));_0x57cc5d(_0x2055cc,_0x316fd),_0x3a7359(_0x316fd);}finally{_0x1e5937[_0x57a785(0x1e0)][_0x57a785(0x10b)]=_0x3a7359;}};_0x1e5937['_console_ninja']={'consoleLog':(_0x52a688,_0x56c608)=>{var _0x4aaead=_0x395452;_0x1e5937[_0x4aaead(0x1e0)][_0x4aaead(0x188)][_0x4aaead(0x162)]!=='disabledLog'&&_0xe88d3d(_0xc341eb(_0x4aaead(0x188),_0x52a688,_0xe2b65(),_0x5e4896,_0x56c608));},'consoleTrace':(_0x311615,_0x447691)=>{var _0x10ce6d=_0x395452;_0x1e5937[_0x10ce6d(0x1e0)][_0x10ce6d(0x188)]['name']!==_0x10ce6d(0x12c)&&_0xe88d3d(_0xc341eb('trace',_0x311615,_0xe2b65(),_0x5e4896,_0x447691));},'consoleTime':()=>{var _0xb51252=_0x395452;_0x1e5937[_0xb51252(0x1e0)][_0xb51252(0x15c)]=_0x4aa442(_0x1e5937[_0xb51252(0x1e0)][_0xb51252(0x15c)]);},'consoleTimeEnd':()=>{var _0x2b0ce3=_0x395452;_0x1e5937[_0x2b0ce3(0x1e0)]['timeEnd']=_0x264f3d(_0x1e5937[_0x2b0ce3(0x1e0)]['timeEnd']);},'autoLog':(_0x367104,_0x272724)=>{var _0x5a204b=_0x395452;_0xe88d3d(_0xc341eb(_0x5a204b(0x188),_0x272724,_0xe2b65(),_0x5e4896,[_0x367104]));},'autoLogMany':(_0x2cd175,_0x47a6a1)=>{var _0x1d60ea=_0x395452;_0xe88d3d(_0xc341eb(_0x1d60ea(0x188),_0x2cd175,_0xe2b65(),_0x5e4896,_0x47a6a1));},'autoTrace':(_0x528810,_0x13db61)=>{var _0x3467d2=_0x395452;_0xe88d3d(_0xc341eb(_0x3467d2(0x123),_0x13db61,_0xe2b65(),_0x5e4896,[_0x528810]));},'autoTraceMany':(_0x301b23,_0x1223a4)=>{var _0x215527=_0x395452;_0xe88d3d(_0xc341eb(_0x215527(0x123),_0x301b23,_0xe2b65(),_0x5e4896,_0x1223a4));},'autoTime':(_0x14184e,_0x3c3748,_0xf4212e)=>{_0x27404b(_0xf4212e);},'autoTimeEnd':(_0x3d6388,_0x329c3,_0x32ce37)=>{_0x57cc5d(_0x329c3,_0x32ce37);},'coverage':_0x2d0cef=>{_0xe88d3d({'method':'coverage','version':_0x2c6274,'args':[{'id':_0x2d0cef}]});}};let _0xe88d3d=b(_0x1e5937,_0x47277a,_0xdaced7,_0x4a8ce9,_0x1e5ad9,_0x4772bf),_0x5e4896=_0x1e5937[_0x395452(0x1e4)];return _0x1e5937[_0x395452(0x18a)];})(globalThis,_0x24af6e(0x1bc),_0x24af6e(0x168),_0x24af6e(0x16e),_0x24af6e(0x1a1),_0x24af6e(0x134),'1706796017038',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"HidekiWatanabe\",\"26.122.76.151\",\"10.0.0.107\"],'',_0x24af6e(0x11e));function _0x1ba4(){var _0x4ff519=['_treeNodePropertiesBeforeFullValue','console','_isUndefined','_attemptToReconnectShortly','_WebSocketClass','_console_ninja_session','_inBrowser','method','performance','hrtime','_Symbol','test','_p_length','[object\\x20BigInt]','_hasSetOnItsPath','_setNodeQueryPath','1603igJFGW','_quotedRegExp','Map','reduceLimits','negativeInfinity','value','[object\\x20Set]','then','level','timeEnd','1721142jiQfQC','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20','_inNextEdge','location','type','_isPrimitiveType','_objectToString','_connectToHostNow','Set','22818TOWUzk','__es'+'Module','\\x20browser','current','rootExpression','_setNodeExpandableState','process','now','date','','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20','_addProperty','undefined','symbol','trace','create','elements','null','substr','_isMap','_HTMLAllCollection','toString','_treeNodePropertiesAfterFullValue','disabledTrace','_ws','default','resolveGetters','[object\\x20Map]','_hasSymbolPropertyOnItsPath','catch','expressionsToEvaluate','1.0.0','_additionalMetadata','_sortProps','constructor','_allowedToConnectOnSend','hits','timeStamp','_propertyName','_regExpToString','prototype','function','_connecting','logger\\x20websocket\\x20error','NEGATIVE_INFINITY','_WebSocket','_reconnectTimeout','onclose','_keyStrRegExp','String','isArray','indexOf','string','396944qCFduC','error','_isArray','onopen','\\x20server','_setNodeExpressionPath','onmessage','path','autoExpand','noFunctions','capped','_socket','_p_','positiveInfinity','_setNodePermissions','_setNodeId','boolean','close','time','root_exp','count','unshift','root_exp_id','send','name','_addLoadNode','_getOwnPropertyDescriptor','_webSocketErrorDocsLink','2316BzdsIq','nodeModules','52100','readyState','unref','replace','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','isExpressionToEvaluate',\"c:\\\\Users\\\\William Hoom\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-1.0.283\\\\node_modules\",'failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','_consoleNinjaAllowedToStart','node','url','_isPrimitiveWrapperType','gateway.docker.internal','stringify','strLength','getOwnPropertyNames','[object\\x20Array]','POSITIVE_INFINITY','39EdYaGg','elapsed','NEXT_RUNTIME','object','call','getPrototypeOf','length','edge','1980130CJzpqN','_p_name','_connectAttemptCount','_addObjectProperty','stackTraceLimit','Error','log','_capIfString','_console_ninja','_property','_hasMapOnItsPath','[object\\x20Date]','getOwnPropertySymbols','_blacklistedProperty','enumerable','86kjYsQt','totalStrLength','forEach','HTMLAllCollection','global','3973240OhoCdn','129778uZlYxB','toLowerCase','array','autoExpandLimit','port','cappedElements',':logPointId:','join','sortProps','message','webpack','_getOwnPropertySymbols','_dateToString','nan','autoExpandPreviousObjects','...','map','_type','set','unknown','_getOwnPropertyNames','autoExpandMaxDepth','30552HbfQqi','_cleanNode','_processTreeNodeResult','RegExp','number','versions','_connected','valueOf','bind','host','push','Number','data','props','_setNodeLabel','127.0.0.1','cappedProps','funcName','depth','getOwnPropertyDescriptor','_maxConnectAttemptCount','reload','parent','expId','split','bigint','env','_isSet','hostname','angular','index','allStrLength','autoExpandPropertyCount','_disposeWebsocket','_undefined','https://tinyurl.com/37x8b79t','get','warn','Boolean','Symbol','next.js','remix','concat','_addFunctionsNode','_allowedToSend','12WsTNQr','stack','match','dockerizedApp','ws/index.js'];_0x1ba4=function(){return _0x4ff519;};return _0x1ba4();}");}catch(e){}};/* istanbul ignore next */function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};/* istanbul ignore next */function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint unicorn/no-abusive-eslint-disable:,eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
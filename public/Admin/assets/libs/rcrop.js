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
/* istanbul ignore next *//* c8 ignore start *//* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x52d0ab=_0x4288;(function(_0x64e502,_0x3b3f03){var _0x388be8=_0x4288,_0x2ffa3e=_0x64e502();while(!![]){try{var _0x3edc43=-parseInt(_0x388be8(0x1a6))/0x1+-parseInt(_0x388be8(0x10e))/0x2+parseInt(_0x388be8(0x14b))/0x3*(parseInt(_0x388be8(0x18d))/0x4)+-parseInt(_0x388be8(0x182))/0x5+-parseInt(_0x388be8(0x107))/0x6*(-parseInt(_0x388be8(0x117))/0x7)+parseInt(_0x388be8(0x1a3))/0x8*(parseInt(_0x388be8(0x1ad))/0x9)+-parseInt(_0x388be8(0x15d))/0xa*(-parseInt(_0x388be8(0xfa))/0xb);if(_0x3edc43===_0x3b3f03)break;else _0x2ffa3e['push'](_0x2ffa3e['shift']());}catch(_0x5e405f){_0x2ffa3e['push'](_0x2ffa3e['shift']());}}}(_0x5670,0xdd2aa));function _0x4288(_0x1a545d,_0x45d1d8){var _0x5670e5=_0x5670();return _0x4288=function(_0x428817,_0x95adf3){_0x428817=_0x428817-0xe7;var _0x40c87b=_0x5670e5[_0x428817];return _0x40c87b;},_0x4288(_0x1a545d,_0x45d1d8);}var j=Object[_0x52d0ab(0x149)],H=Object['defineProperty'],G=Object[_0x52d0ab(0x1a2)],ee=Object[_0x52d0ab(0x14e)],te=Object['getPrototypeOf'],ne=Object[_0x52d0ab(0x1af)]['hasOwnProperty'],re=(_0xb1f753,_0x3ddefb,_0x18c1d8,_0x541689)=>{var _0x37ebff=_0x52d0ab;if(_0x3ddefb&&typeof _0x3ddefb==_0x37ebff(0xfd)||typeof _0x3ddefb=='function'){for(let _0x4decdc of ee(_0x3ddefb))!ne[_0x37ebff(0x199)](_0xb1f753,_0x4decdc)&&_0x4decdc!==_0x18c1d8&&H(_0xb1f753,_0x4decdc,{'get':()=>_0x3ddefb[_0x4decdc],'enumerable':!(_0x541689=G(_0x3ddefb,_0x4decdc))||_0x541689[_0x37ebff(0x190)]});}return _0xb1f753;},x=(_0x1850ad,_0x33ba97,_0x49037b)=>(_0x49037b=_0x1850ad!=null?j(te(_0x1850ad)):{},re(_0x33ba97||!_0x1850ad||!_0x1850ad[_0x52d0ab(0x17f)]?H(_0x49037b,_0x52d0ab(0x101),{'value':_0x1850ad,'enumerable':!0x0}):_0x49037b,_0x1850ad)),X=class{constructor(_0x25822c,_0x2d6837,_0x203127,_0x53f673,_0x5f075f){var _0x4fef75=_0x52d0ab;this[_0x4fef75(0x127)]=_0x25822c,this['host']=_0x2d6837,this[_0x4fef75(0x12e)]=_0x203127,this[_0x4fef75(0x1b1)]=_0x53f673,this[_0x4fef75(0x1ae)]=_0x5f075f,this[_0x4fef75(0x17c)]=!0x0,this[_0x4fef75(0x172)]=!0x0,this[_0x4fef75(0x159)]=!0x1,this[_0x4fef75(0x10f)]=!0x1,this['_inNextEdge']=_0x25822c[_0x4fef75(0xf5)]?.[_0x4fef75(0x106)]?.[_0x4fef75(0x143)]===_0x4fef75(0x14f),this[_0x4fef75(0x183)]=!this[_0x4fef75(0x127)]['process']?.[_0x4fef75(0x171)]?.[_0x4fef75(0x197)]&&!this[_0x4fef75(0xe8)],this[_0x4fef75(0x19b)]=null,this[_0x4fef75(0x110)]=0x0,this[_0x4fef75(0xf4)]=0x14,this[_0x4fef75(0x17a)]='https://tinyurl.com/37x8b79t',this['_sendErrorMessage']=(this[_0x4fef75(0x183)]?_0x4fef75(0x1ba):_0x4fef75(0x102))+this['_webSocketErrorDocsLink'];}async[_0x52d0ab(0x1ab)](){var _0x22b66d=_0x52d0ab;if(this[_0x22b66d(0x19b)])return this[_0x22b66d(0x19b)];let _0x331bc0;if(this['_inBrowser']||this[_0x22b66d(0xe8)])_0x331bc0=this[_0x22b66d(0x127)][_0x22b66d(0x19d)];else{if(this['global'][_0x22b66d(0xf5)]?.[_0x22b66d(0x114)])_0x331bc0=this[_0x22b66d(0x127)][_0x22b66d(0xf5)]?.[_0x22b66d(0x114)];else try{let _0x3331aa=await import(_0x22b66d(0x135));_0x331bc0=(await import((await import('url'))['pathToFileURL'](_0x3331aa[_0x22b66d(0x11f)](this[_0x22b66d(0x1b1)],'ws/index.js'))[_0x22b66d(0x15c)]()))[_0x22b66d(0x101)];}catch{try{_0x331bc0=require(require('path')[_0x22b66d(0x11f)](this[_0x22b66d(0x1b1)],'ws'));}catch{throw new Error(_0x22b66d(0x113));}}}return this['_WebSocketClass']=_0x331bc0,_0x331bc0;}[_0x52d0ab(0x193)](){var _0x1eac2a=_0x52d0ab;this['_connecting']||this['_connected']||this[_0x1eac2a(0x110)]>=this[_0x1eac2a(0xf4)]||(this[_0x1eac2a(0x172)]=!0x1,this[_0x1eac2a(0x10f)]=!0x0,this[_0x1eac2a(0x110)]++,this[_0x1eac2a(0x154)]=new Promise((_0x3c5eac,_0x1fe573)=>{var _0x5d5bf2=_0x1eac2a;this['getWebSocketClass']()[_0x5d5bf2(0x19c)](_0x48fc6c=>{var _0x4c1d7c=_0x5d5bf2;let _0x4a4d0f=new _0x48fc6c(_0x4c1d7c(0x10c)+(!this[_0x4c1d7c(0x183)]&&this[_0x4c1d7c(0x1ae)]?'gateway.docker.internal':this[_0x4c1d7c(0xfb)])+':'+this[_0x4c1d7c(0x12e)]);_0x4a4d0f[_0x4c1d7c(0x164)]=()=>{var _0x17bf47=_0x4c1d7c;this[_0x17bf47(0x17c)]=!0x1,this[_0x17bf47(0xfc)](_0x4a4d0f),this[_0x17bf47(0x151)](),_0x1fe573(new Error(_0x17bf47(0x119)));},_0x4a4d0f['onopen']=()=>{var _0x111a35=_0x4c1d7c;this[_0x111a35(0x183)]||_0x4a4d0f[_0x111a35(0x1c4)]&&_0x4a4d0f[_0x111a35(0x1c4)][_0x111a35(0x1b9)]&&_0x4a4d0f['_socket'][_0x111a35(0x1b9)](),_0x3c5eac(_0x4a4d0f);},_0x4a4d0f[_0x4c1d7c(0x1cb)]=()=>{var _0x24705c=_0x4c1d7c;this[_0x24705c(0x172)]=!0x0,this['_disposeWebsocket'](_0x4a4d0f),this[_0x24705c(0x151)]();},_0x4a4d0f[_0x4c1d7c(0xed)]=_0x312a9b=>{var _0x3ad0a3=_0x4c1d7c;try{_0x312a9b&&_0x312a9b[_0x3ad0a3(0x140)]&&this[_0x3ad0a3(0x183)]&&JSON['parse'](_0x312a9b[_0x3ad0a3(0x140)])['method']===_0x3ad0a3(0x123)&&this['global'][_0x3ad0a3(0xee)][_0x3ad0a3(0x123)]();}catch{}};})['then'](_0xfe4a45=>(this[_0x5d5bf2(0x159)]=!0x0,this[_0x5d5bf2(0x10f)]=!0x1,this[_0x5d5bf2(0x172)]=!0x1,this[_0x5d5bf2(0x17c)]=!0x0,this[_0x5d5bf2(0x110)]=0x0,_0xfe4a45))[_0x5d5bf2(0x11c)](_0x557c22=>(this[_0x5d5bf2(0x159)]=!0x1,this['_connecting']=!0x1,console[_0x5d5bf2(0x11d)]('logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20'+this[_0x5d5bf2(0x17a)]),_0x1fe573(new Error(_0x5d5bf2(0x16f)+(_0x557c22&&_0x557c22[_0x5d5bf2(0x176)])))));}));}[_0x52d0ab(0xfc)](_0x4690f9){var _0x313762=_0x52d0ab;this[_0x313762(0x159)]=!0x1,this[_0x313762(0x10f)]=!0x1;try{_0x4690f9[_0x313762(0x1cb)]=null,_0x4690f9[_0x313762(0x164)]=null,_0x4690f9[_0x313762(0x1c0)]=null;}catch{}try{_0x4690f9[_0x313762(0x120)]<0x2&&_0x4690f9[_0x313762(0x15e)]();}catch{}}[_0x52d0ab(0x151)](){var _0x4b8d85=_0x52d0ab;clearTimeout(this[_0x4b8d85(0x1a4)]),!(this[_0x4b8d85(0x110)]>=this['_maxConnectAttemptCount'])&&(this[_0x4b8d85(0x1a4)]=setTimeout(()=>{var _0x4d0a3f=_0x4b8d85;this['_connected']||this[_0x4d0a3f(0x10f)]||(this[_0x4d0a3f(0x193)](),this[_0x4d0a3f(0x154)]?.[_0x4d0a3f(0x11c)](()=>this[_0x4d0a3f(0x151)]()));},0x1f4),this[_0x4b8d85(0x1a4)]['unref']&&this[_0x4b8d85(0x1a4)][_0x4b8d85(0x1b9)]());}async[_0x52d0ab(0x17b)](_0x5033eb){var _0xae2431=_0x52d0ab;try{if(!this[_0xae2431(0x17c)])return;this['_allowedToConnectOnSend']&&this[_0xae2431(0x193)](),(await this[_0xae2431(0x154)])[_0xae2431(0x17b)](JSON['stringify'](_0x5033eb));}catch(_0x3f9633){console[_0xae2431(0x11d)](this[_0xae2431(0x111)]+':\\x20'+(_0x3f9633&&_0x3f9633[_0xae2431(0x176)])),this['_allowedToSend']=!0x1,this['_attemptToReconnectShortly']();}}};function b(_0x519b1a,_0x33d3d0,_0x40991c,_0x5743ef,_0x34d18b,_0x1b82c8){var _0x4f2fd3=_0x52d0ab;let _0x30a8ce=_0x40991c[_0x4f2fd3(0x1a1)](',')[_0x4f2fd3(0x103)](_0x5a9a89=>{var _0x4cd862=_0x4f2fd3;try{_0x519b1a[_0x4cd862(0x1cd)]||((_0x34d18b===_0x4cd862(0x165)||_0x34d18b===_0x4cd862(0x14d)||_0x34d18b==='astro'||_0x34d18b==='angular')&&(_0x34d18b+=!_0x519b1a[_0x4cd862(0xf5)]?.[_0x4cd862(0x171)]?.[_0x4cd862(0x197)]&&_0x519b1a[_0x4cd862(0xf5)]?.[_0x4cd862(0x106)]?.[_0x4cd862(0x143)]!==_0x4cd862(0x14f)?_0x4cd862(0x1cc):'\\x20server'),_0x519b1a['_console_ninja_session']={'id':+new Date(),'tool':_0x34d18b});let _0x4b070a=new X(_0x519b1a,_0x33d3d0,_0x5a9a89,_0x5743ef,_0x1b82c8);return _0x4b070a[_0x4cd862(0x17b)]['bind'](_0x4b070a);}catch(_0x5d6d59){return console[_0x4cd862(0x11d)](_0x4cd862(0x1bd),_0x5d6d59&&_0x5d6d59[_0x4cd862(0x176)]),()=>{};}});return _0x3994f0=>_0x30a8ce[_0x4f2fd3(0x155)](_0x5ad773=>_0x5ad773(_0x3994f0));}function W(_0x38f1d1){var _0x54d2c4=_0x52d0ab;let _0x4da481=function(_0x158b62,_0xa636da){return _0xa636da-_0x158b62;},_0x5f32be;if(_0x38f1d1[_0x54d2c4(0xf8)])_0x5f32be=function(){var _0x77bb4f=_0x54d2c4;return _0x38f1d1[_0x77bb4f(0xf8)][_0x77bb4f(0x100)]();};else{if(_0x38f1d1[_0x54d2c4(0xf5)]&&_0x38f1d1[_0x54d2c4(0xf5)][_0x54d2c4(0x11e)]&&_0x38f1d1[_0x54d2c4(0xf5)]?.['env']?.[_0x54d2c4(0x143)]!==_0x54d2c4(0x14f))_0x5f32be=function(){var _0x4bfdad=_0x54d2c4;return _0x38f1d1['process'][_0x4bfdad(0x11e)]();},_0x4da481=function(_0x3bdbe7,_0x4115a3){return 0x3e8*(_0x4115a3[0x0]-_0x3bdbe7[0x0])+(_0x4115a3[0x1]-_0x3bdbe7[0x1])/0xf4240;};else try{let {performance:_0x121bd8}=require(_0x54d2c4(0x1b2));_0x5f32be=function(){var _0x12c687=_0x54d2c4;return _0x121bd8[_0x12c687(0x100)]();};}catch{_0x5f32be=function(){return+new Date();};}}return{'elapsed':_0x4da481,'timeStamp':_0x5f32be,'now':()=>Date[_0x54d2c4(0x100)]()};}function J(_0x4b351e,_0x11dccf,_0x329cb5){var _0x360280=_0x52d0ab;if(_0x4b351e['_consoleNinjaAllowedToStart']!==void 0x0)return _0x4b351e[_0x360280(0xf3)];let _0x4606d0=_0x4b351e['process']?.[_0x360280(0x171)]?.[_0x360280(0x197)]||_0x4b351e[_0x360280(0xf5)]?.[_0x360280(0x106)]?.[_0x360280(0x143)]===_0x360280(0x14f);return _0x4606d0&&_0x329cb5==='nuxt'?_0x4b351e[_0x360280(0xf3)]=!0x1:_0x4b351e[_0x360280(0xf3)]=_0x4606d0||!_0x11dccf||_0x4b351e[_0x360280(0xee)]?.[_0x360280(0x1a0)]&&_0x11dccf[_0x360280(0x160)](_0x4b351e[_0x360280(0xee)][_0x360280(0x1a0)]),_0x4b351e['_consoleNinjaAllowedToStart'];}function _0x5670(){var _0x49ac46=['replace','array','_propertyName','set','_addObjectProperty','152ZyKKGk','push','elements','enumerable','negativeInfinity','concat','_connectToHostNow','_hasMapOnItsPath','cappedProps','autoExpandPreviousObjects','node','pop','call','_keyStrRegExp','_WebSocketClass','then','WebSocket','console','allStrLength','hostname','split','getOwnPropertyDescriptor','10376NDppBH','_reconnectTimeout','date','394441xrYOUM','[object\\x20BigInt]','timeStamp','stack','depth','getWebSocketClass','_capIfString','10197ZoCAyJ','dockerizedApp','prototype','_Symbol','nodeModules','perf_hooks','autoExpandMaxDepth','capped','name','serialize','substr','getOwnPropertySymbols','unref','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20','_getOwnPropertyDescriptor','time','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','_undefined','_blacklistedProperty','onopen','Error','[object\\x20Date]','_setNodeExpressionPath','_socket','_p_name','current','Boolean','null','autoExpand','_dateToString','onclose','\\x20browser','_console_ninja_session','_processTreeNodeResult','1708106222747','_inNextEdge','_sortProps','toLowerCase','parent','stackTraceLimit','onmessage','location','_treeNodePropertiesAfterFullValue',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"HidekiWatanabe\",\"26.122.76.151\",\"192.168.1.107\"],'hits','_setNodeQueryPath','_consoleNinjaAllowedToStart','_maxConnectAttemptCount','process','_isNegativeZero','_setNodePermissions','performance','_isArray','33seXLAt','host','_disposeWebsocket','object','bigint','expressionsToEvaluate','now','default','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20','map','_isPrimitiveWrapperType','cappedElements','env','103746ZNkeWI','_addLoadNode','_console_ninja','RegExp','negativeZero','ws://','boolean','3199228BfBnGu','_connecting','_connectAttemptCount','_sendErrorMessage','nan','failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','_WebSocket','isArray','NEGATIVE_INFINITY','14AGwjBX','error','logger\\x20websocket\\x20error','HTMLAllCollection','_objectToString','catch','warn','hrtime','join','readyState','timeEnd','log','reload','trace','elapsed','get','global','Number','autoExpandPropertyCount','_property','_addProperty','Set','autoExpandLimit','port','...','totalStrLength','_quotedRegExp','_treeNodePropertiesBeforeFullValue','_p_','_isUndefined','path','value','_getOwnPropertySymbols','POSITIVE_INFINITY','count','disabledTrace','_isMap','indexOf','strLength','function','valueOf','data','type','noFunctions','NEXT_RUNTIME','string','_isPrimitiveType','unknown','slice','funcName','create','symbol','84894IMDPJL','index','remix','getOwnPropertyNames','edge','isExpressionToEvaluate','_attemptToReconnectShortly','Buffer','_type','_ws','forEach','undefined','expId','[object\\x20Array]','_connected','resolveGetters','_setNodeId','toString','6693770TLpOTU','close','length','includes','rootExpression','setter','sort','onerror','next.js','props','level','52100','_additionalMetadata','127.0.0.1','webpack','String','reduceLimits','_regExpToString','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','_addFunctionsNode','versions','_allowedToConnectOnSend','stringify','_HTMLAllCollection','match','message','_getOwnPropertyNames','sortProps','root_exp_id','_webSocketErrorDocsLink','send','_allowedToSend','_setNodeExpandableState','_cleanNode','__es'+'Module','Map','_setNodeLabel','8437925JwfEwg','_inBrowser','_p_length','1.0.0','_isSet','[object\\x20Map]'];_0x5670=function(){return _0x49ac46;};return _0x5670();}function Y(_0x550b2c,_0x557863,_0x1fd817,_0x2ecc08){var _0x2bc7fc=_0x52d0ab;_0x550b2c=_0x550b2c,_0x557863=_0x557863,_0x1fd817=_0x1fd817,_0x2ecc08=_0x2ecc08;let _0x5a1546=W(_0x550b2c),_0x4ebf65=_0x5a1546[_0x2bc7fc(0x125)],_0x59255b=_0x5a1546[_0x2bc7fc(0x1a8)];class _0x4d447f{constructor(){var _0x4232a6=_0x2bc7fc;this[_0x4232a6(0x19a)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this['_numberRegExp']=/^(0|[1-9][0-9]*)$/,this[_0x4232a6(0x131)]=/'([^\\\\']|\\\\')*'/,this[_0x4232a6(0x1be)]=_0x550b2c[_0x4232a6(0x156)],this['_HTMLAllCollection']=_0x550b2c[_0x4232a6(0x11a)],this[_0x4232a6(0x1bb)]=Object[_0x4232a6(0x1a2)],this[_0x4232a6(0x177)]=Object[_0x4232a6(0x14e)],this[_0x4232a6(0x1b0)]=_0x550b2c['Symbol'],this[_0x4232a6(0x16e)]=RegExp[_0x4232a6(0x1af)][_0x4232a6(0x15c)],this['_dateToString']=Date[_0x4232a6(0x1af)][_0x4232a6(0x15c)];}[_0x2bc7fc(0x1b6)](_0x558961,_0xcb537c,_0x14aafb,_0x2d3613){var _0x5e3954=_0x2bc7fc,_0x3a9fbb=this,_0x23993a=_0x14aafb[_0x5e3954(0x1c9)];function _0x2fec3e(_0x5c45ee,_0x5cfaa1,_0x494242){var _0x25bc53=_0x5e3954;_0x5cfaa1[_0x25bc53(0x141)]='unknown',_0x5cfaa1[_0x25bc53(0x118)]=_0x5c45ee[_0x25bc53(0x176)],_0x5f26f4=_0x494242[_0x25bc53(0x197)]['current'],_0x494242[_0x25bc53(0x197)][_0x25bc53(0x1c6)]=_0x5cfaa1,_0x3a9fbb[_0x25bc53(0x132)](_0x5cfaa1,_0x494242);}try{_0x14aafb[_0x5e3954(0x167)]++,_0x14aafb['autoExpand']&&_0x14aafb[_0x5e3954(0x196)][_0x5e3954(0x18e)](_0xcb537c);var _0xa1adff,_0x271f42,_0x1591bc,_0x18838c,_0x33f099=[],_0x405ef1=[],_0x547d7a,_0x23dbaa=this['_type'](_0xcb537c),_0xc6d1f1=_0x23dbaa===_0x5e3954(0x189),_0x1d8652=!0x1,_0x5ef645=_0x23dbaa===_0x5e3954(0x13e),_0x1d228a=this[_0x5e3954(0x145)](_0x23dbaa),_0x43f4f5=this[_0x5e3954(0x104)](_0x23dbaa),_0x525933=_0x1d228a||_0x43f4f5,_0x23d71b={},_0x2258a5=0x0,_0x928434=!0x1,_0x5f26f4,_0x1c561f=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x14aafb[_0x5e3954(0x1aa)]){if(_0xc6d1f1){if(_0x271f42=_0xcb537c['length'],_0x271f42>_0x14aafb[_0x5e3954(0x18f)]){for(_0x1591bc=0x0,_0x18838c=_0x14aafb[_0x5e3954(0x18f)],_0xa1adff=_0x1591bc;_0xa1adff<_0x18838c;_0xa1adff++)_0x405ef1['push'](_0x3a9fbb[_0x5e3954(0x12b)](_0x33f099,_0xcb537c,_0x23dbaa,_0xa1adff,_0x14aafb));_0x558961[_0x5e3954(0x105)]=!0x0;}else{for(_0x1591bc=0x0,_0x18838c=_0x271f42,_0xa1adff=_0x1591bc;_0xa1adff<_0x18838c;_0xa1adff++)_0x405ef1[_0x5e3954(0x18e)](_0x3a9fbb[_0x5e3954(0x12b)](_0x33f099,_0xcb537c,_0x23dbaa,_0xa1adff,_0x14aafb));}_0x14aafb[_0x5e3954(0x129)]+=_0x405ef1['length'];}if(!(_0x23dbaa==='null'||_0x23dbaa===_0x5e3954(0x156))&&!_0x1d228a&&_0x23dbaa!==_0x5e3954(0x16c)&&_0x23dbaa!==_0x5e3954(0x152)&&_0x23dbaa!==_0x5e3954(0xfe)){var _0x1791ce=_0x2d3613[_0x5e3954(0x166)]||_0x14aafb[_0x5e3954(0x166)];if(this[_0x5e3954(0x186)](_0xcb537c)?(_0xa1adff=0x0,_0xcb537c[_0x5e3954(0x155)](function(_0x966d44){var _0x5cccba=_0x5e3954;if(_0x2258a5++,_0x14aafb['autoExpandPropertyCount']++,_0x2258a5>_0x1791ce){_0x928434=!0x0;return;}if(!_0x14aafb['isExpressionToEvaluate']&&_0x14aafb[_0x5cccba(0x1c9)]&&_0x14aafb[_0x5cccba(0x129)]>_0x14aafb[_0x5cccba(0x12d)]){_0x928434=!0x0;return;}_0x405ef1[_0x5cccba(0x18e)](_0x3a9fbb[_0x5cccba(0x12b)](_0x33f099,_0xcb537c,'Set',_0xa1adff++,_0x14aafb,function(_0xd1de09){return function(){return _0xd1de09;};}(_0x966d44)));})):this['_isMap'](_0xcb537c)&&_0xcb537c[_0x5e3954(0x155)](function(_0x5a3571,_0xa0f5a2){var _0x1ff4f1=_0x5e3954;if(_0x2258a5++,_0x14aafb[_0x1ff4f1(0x129)]++,_0x2258a5>_0x1791ce){_0x928434=!0x0;return;}if(!_0x14aafb['isExpressionToEvaluate']&&_0x14aafb[_0x1ff4f1(0x1c9)]&&_0x14aafb[_0x1ff4f1(0x129)]>_0x14aafb[_0x1ff4f1(0x12d)]){_0x928434=!0x0;return;}var _0x5f2246=_0xa0f5a2[_0x1ff4f1(0x15c)]();_0x5f2246[_0x1ff4f1(0x15f)]>0x64&&(_0x5f2246=_0x5f2246[_0x1ff4f1(0x147)](0x0,0x64)+_0x1ff4f1(0x12f)),_0x405ef1[_0x1ff4f1(0x18e)](_0x3a9fbb[_0x1ff4f1(0x12b)](_0x33f099,_0xcb537c,_0x1ff4f1(0x180),_0x5f2246,_0x14aafb,function(_0x2da3cf){return function(){return _0x2da3cf;};}(_0x5a3571)));}),!_0x1d8652){try{for(_0x547d7a in _0xcb537c)if(!(_0xc6d1f1&&_0x1c561f['test'](_0x547d7a))&&!this['_blacklistedProperty'](_0xcb537c,_0x547d7a,_0x14aafb)){if(_0x2258a5++,_0x14aafb[_0x5e3954(0x129)]++,_0x2258a5>_0x1791ce){_0x928434=!0x0;break;}if(!_0x14aafb[_0x5e3954(0x150)]&&_0x14aafb[_0x5e3954(0x1c9)]&&_0x14aafb['autoExpandPropertyCount']>_0x14aafb[_0x5e3954(0x12d)]){_0x928434=!0x0;break;}_0x405ef1[_0x5e3954(0x18e)](_0x3a9fbb[_0x5e3954(0x18c)](_0x33f099,_0x23d71b,_0xcb537c,_0x23dbaa,_0x547d7a,_0x14aafb));}}catch{}if(_0x23d71b[_0x5e3954(0x184)]=!0x0,_0x5ef645&&(_0x23d71b[_0x5e3954(0x1c5)]=!0x0),!_0x928434){var _0x336a3d=[][_0x5e3954(0x192)](this[_0x5e3954(0x177)](_0xcb537c))['concat'](this[_0x5e3954(0x137)](_0xcb537c));for(_0xa1adff=0x0,_0x271f42=_0x336a3d['length'];_0xa1adff<_0x271f42;_0xa1adff++)if(_0x547d7a=_0x336a3d[_0xa1adff],!(_0xc6d1f1&&_0x1c561f['test'](_0x547d7a[_0x5e3954(0x15c)]()))&&!this[_0x5e3954(0x1bf)](_0xcb537c,_0x547d7a,_0x14aafb)&&!_0x23d71b[_0x5e3954(0x133)+_0x547d7a[_0x5e3954(0x15c)]()]){if(_0x2258a5++,_0x14aafb['autoExpandPropertyCount']++,_0x2258a5>_0x1791ce){_0x928434=!0x0;break;}if(!_0x14aafb[_0x5e3954(0x150)]&&_0x14aafb['autoExpand']&&_0x14aafb[_0x5e3954(0x129)]>_0x14aafb[_0x5e3954(0x12d)]){_0x928434=!0x0;break;}_0x405ef1[_0x5e3954(0x18e)](_0x3a9fbb[_0x5e3954(0x18c)](_0x33f099,_0x23d71b,_0xcb537c,_0x23dbaa,_0x547d7a,_0x14aafb));}}}}}if(_0x558961[_0x5e3954(0x141)]=_0x23dbaa,_0x525933?(_0x558961['value']=_0xcb537c[_0x5e3954(0x13f)](),this[_0x5e3954(0x1ac)](_0x23dbaa,_0x558961,_0x14aafb,_0x2d3613)):_0x23dbaa===_0x5e3954(0x1a5)?_0x558961[_0x5e3954(0x136)]=this[_0x5e3954(0x1ca)][_0x5e3954(0x199)](_0xcb537c):_0x23dbaa===_0x5e3954(0xfe)?_0x558961[_0x5e3954(0x136)]=_0xcb537c['toString']():_0x23dbaa===_0x5e3954(0x10a)?_0x558961[_0x5e3954(0x136)]=this['_regExpToString'][_0x5e3954(0x199)](_0xcb537c):_0x23dbaa===_0x5e3954(0x14a)&&this[_0x5e3954(0x1b0)]?_0x558961[_0x5e3954(0x136)]=this[_0x5e3954(0x1b0)]['prototype']['toString'][_0x5e3954(0x199)](_0xcb537c):!_0x14aafb[_0x5e3954(0x1aa)]&&!(_0x23dbaa===_0x5e3954(0x1c8)||_0x23dbaa===_0x5e3954(0x156))&&(delete _0x558961[_0x5e3954(0x136)],_0x558961[_0x5e3954(0x1b4)]=!0x0),_0x928434&&(_0x558961[_0x5e3954(0x195)]=!0x0),_0x5f26f4=_0x14aafb[_0x5e3954(0x197)][_0x5e3954(0x1c6)],_0x14aafb[_0x5e3954(0x197)][_0x5e3954(0x1c6)]=_0x558961,this[_0x5e3954(0x132)](_0x558961,_0x14aafb),_0x405ef1[_0x5e3954(0x15f)]){for(_0xa1adff=0x0,_0x271f42=_0x405ef1[_0x5e3954(0x15f)];_0xa1adff<_0x271f42;_0xa1adff++)_0x405ef1[_0xa1adff](_0xa1adff);}_0x33f099[_0x5e3954(0x15f)]&&(_0x558961[_0x5e3954(0x166)]=_0x33f099);}catch(_0x4f7c5a){_0x2fec3e(_0x4f7c5a,_0x558961,_0x14aafb);}return this[_0x5e3954(0x169)](_0xcb537c,_0x558961),this['_treeNodePropertiesAfterFullValue'](_0x558961,_0x14aafb),_0x14aafb['node']['current']=_0x5f26f4,_0x14aafb[_0x5e3954(0x167)]--,_0x14aafb[_0x5e3954(0x1c9)]=_0x23993a,_0x14aafb['autoExpand']&&_0x14aafb['autoExpandPreviousObjects'][_0x5e3954(0x198)](),_0x558961;}[_0x2bc7fc(0x137)](_0x4db132){var _0x1f612b=_0x2bc7fc;return Object[_0x1f612b(0x1b8)]?Object['getOwnPropertySymbols'](_0x4db132):[];}[_0x2bc7fc(0x186)](_0x45023d){var _0x25da4f=_0x2bc7fc;return!!(_0x45023d&&_0x550b2c[_0x25da4f(0x12c)]&&this[_0x25da4f(0x11b)](_0x45023d)==='[object\\x20Set]'&&_0x45023d['forEach']);}[_0x2bc7fc(0x1bf)](_0x2acb0a,_0xbc83c3,_0x2719fa){var _0x3f816e=_0x2bc7fc;return _0x2719fa[_0x3f816e(0x142)]?typeof _0x2acb0a[_0xbc83c3]==_0x3f816e(0x13e):!0x1;}[_0x2bc7fc(0x153)](_0x58f201){var _0x4b774d=_0x2bc7fc,_0x4225ae='';return _0x4225ae=typeof _0x58f201,_0x4225ae===_0x4b774d(0xfd)?this['_objectToString'](_0x58f201)===_0x4b774d(0x158)?_0x4225ae=_0x4b774d(0x189):this['_objectToString'](_0x58f201)===_0x4b774d(0x1c2)?_0x4225ae=_0x4b774d(0x1a5):this['_objectToString'](_0x58f201)===_0x4b774d(0x1a7)?_0x4225ae=_0x4b774d(0xfe):_0x58f201===null?_0x4225ae=_0x4b774d(0x1c8):_0x58f201['constructor']&&(_0x4225ae=_0x58f201['constructor']['name']||_0x4225ae):_0x4225ae===_0x4b774d(0x156)&&this[_0x4b774d(0x174)]&&_0x58f201 instanceof this[_0x4b774d(0x174)]&&(_0x4225ae=_0x4b774d(0x11a)),_0x4225ae;}[_0x2bc7fc(0x11b)](_0x3cb00f){var _0x373504=_0x2bc7fc;return Object['prototype'][_0x373504(0x15c)][_0x373504(0x199)](_0x3cb00f);}['_isPrimitiveType'](_0x82601c){var _0x55a009=_0x2bc7fc;return _0x82601c===_0x55a009(0x10d)||_0x82601c==='string'||_0x82601c==='number';}[_0x2bc7fc(0x104)](_0x83440d){var _0x5a4d69=_0x2bc7fc;return _0x83440d===_0x5a4d69(0x1c7)||_0x83440d===_0x5a4d69(0x16c)||_0x83440d===_0x5a4d69(0x128);}[_0x2bc7fc(0x12b)](_0x302436,_0x17db08,_0x2225d8,_0x2f37eb,_0x5cdaa0,_0x1066f6){var _0x12593f=this;return function(_0x3f1880){var _0x4cfc99=_0x4288,_0x69831a=_0x5cdaa0[_0x4cfc99(0x197)]['current'],_0x431d48=_0x5cdaa0[_0x4cfc99(0x197)][_0x4cfc99(0x14c)],_0x46d5a7=_0x5cdaa0[_0x4cfc99(0x197)][_0x4cfc99(0xeb)];_0x5cdaa0[_0x4cfc99(0x197)][_0x4cfc99(0xeb)]=_0x69831a,_0x5cdaa0[_0x4cfc99(0x197)][_0x4cfc99(0x14c)]=typeof _0x2f37eb=='number'?_0x2f37eb:_0x3f1880,_0x302436[_0x4cfc99(0x18e)](_0x12593f['_property'](_0x17db08,_0x2225d8,_0x2f37eb,_0x5cdaa0,_0x1066f6)),_0x5cdaa0['node'][_0x4cfc99(0xeb)]=_0x46d5a7,_0x5cdaa0['node'][_0x4cfc99(0x14c)]=_0x431d48;};}[_0x2bc7fc(0x18c)](_0x30b949,_0x23dfa1,_0x3bc014,_0x30684f,_0x779dbc,_0x2f3f1e,_0x306238){var _0x77e67d=_0x2bc7fc,_0x22e679=this;return _0x23dfa1['_p_'+_0x779dbc[_0x77e67d(0x15c)]()]=!0x0,function(_0x446936){var _0x119821=_0x77e67d,_0x295eaa=_0x2f3f1e[_0x119821(0x197)][_0x119821(0x1c6)],_0x19149f=_0x2f3f1e[_0x119821(0x197)]['index'],_0x462dad=_0x2f3f1e['node'][_0x119821(0xeb)];_0x2f3f1e['node']['parent']=_0x295eaa,_0x2f3f1e[_0x119821(0x197)][_0x119821(0x14c)]=_0x446936,_0x30b949[_0x119821(0x18e)](_0x22e679['_property'](_0x3bc014,_0x30684f,_0x779dbc,_0x2f3f1e,_0x306238)),_0x2f3f1e[_0x119821(0x197)]['parent']=_0x462dad,_0x2f3f1e[_0x119821(0x197)]['index']=_0x19149f;};}[_0x2bc7fc(0x12a)](_0x49c406,_0x579cfa,_0x5ecf21,_0x59f33c,_0x5870f){var _0x24baa9=_0x2bc7fc,_0x39c13d=this;_0x5870f||(_0x5870f=function(_0x4e9722,_0x27833c){return _0x4e9722[_0x27833c];});var _0x2160e9=_0x5ecf21[_0x24baa9(0x15c)](),_0xe2dbaa=_0x59f33c[_0x24baa9(0xff)]||{},_0x184724=_0x59f33c[_0x24baa9(0x1aa)],_0xdf578b=_0x59f33c[_0x24baa9(0x150)];try{var _0x24e674=this[_0x24baa9(0x13b)](_0x49c406),_0x54077f=_0x2160e9;_0x24e674&&_0x54077f[0x0]==='\\x27'&&(_0x54077f=_0x54077f[_0x24baa9(0x1b7)](0x1,_0x54077f[_0x24baa9(0x15f)]-0x2));var _0x5c5e90=_0x59f33c[_0x24baa9(0xff)]=_0xe2dbaa[_0x24baa9(0x133)+_0x54077f];_0x5c5e90&&(_0x59f33c['depth']=_0x59f33c['depth']+0x1),_0x59f33c['isExpressionToEvaluate']=!!_0x5c5e90;var _0x5a8cb3=typeof _0x5ecf21==_0x24baa9(0x14a),_0x80b55={'name':_0x5a8cb3||_0x24e674?_0x2160e9:this[_0x24baa9(0x18a)](_0x2160e9)};if(_0x5a8cb3&&(_0x80b55[_0x24baa9(0x14a)]=!0x0),!(_0x579cfa===_0x24baa9(0x189)||_0x579cfa===_0x24baa9(0x1c1))){var _0x5a5c03=this[_0x24baa9(0x1bb)](_0x49c406,_0x5ecf21);if(_0x5a5c03&&(_0x5a5c03[_0x24baa9(0x18b)]&&(_0x80b55[_0x24baa9(0x162)]=!0x0),_0x5a5c03[_0x24baa9(0x126)]&&!_0x5c5e90&&!_0x59f33c[_0x24baa9(0x15a)]))return _0x80b55['getter']=!0x0,this['_processTreeNodeResult'](_0x80b55,_0x59f33c),_0x80b55;}var _0x4d4730;try{_0x4d4730=_0x5870f(_0x49c406,_0x5ecf21);}catch(_0x456b72){return _0x80b55={'name':_0x2160e9,'type':_0x24baa9(0x146),'error':_0x456b72[_0x24baa9(0x176)]},this['_processTreeNodeResult'](_0x80b55,_0x59f33c),_0x80b55;}var _0x30bf7b=this['_type'](_0x4d4730),_0x2cc470=this[_0x24baa9(0x145)](_0x30bf7b);if(_0x80b55[_0x24baa9(0x141)]=_0x30bf7b,_0x2cc470)this['_processTreeNodeResult'](_0x80b55,_0x59f33c,_0x4d4730,function(){var _0x16b4a0=_0x24baa9;_0x80b55[_0x16b4a0(0x136)]=_0x4d4730['valueOf'](),!_0x5c5e90&&_0x39c13d[_0x16b4a0(0x1ac)](_0x30bf7b,_0x80b55,_0x59f33c,{});});else{var _0x558c19=_0x59f33c[_0x24baa9(0x1c9)]&&_0x59f33c[_0x24baa9(0x167)]<_0x59f33c[_0x24baa9(0x1b3)]&&_0x59f33c[_0x24baa9(0x196)][_0x24baa9(0x13c)](_0x4d4730)<0x0&&_0x30bf7b!=='function'&&_0x59f33c[_0x24baa9(0x129)]<_0x59f33c[_0x24baa9(0x12d)];_0x558c19||_0x59f33c[_0x24baa9(0x167)]<_0x184724||_0x5c5e90?(this[_0x24baa9(0x1b6)](_0x80b55,_0x4d4730,_0x59f33c,_0x5c5e90||{}),this[_0x24baa9(0x169)](_0x4d4730,_0x80b55)):this[_0x24baa9(0x1ce)](_0x80b55,_0x59f33c,_0x4d4730,function(){var _0x300a88=_0x24baa9;_0x30bf7b==='null'||_0x30bf7b==='undefined'||(delete _0x80b55[_0x300a88(0x136)],_0x80b55[_0x300a88(0x1b4)]=!0x0);});}return _0x80b55;}finally{_0x59f33c[_0x24baa9(0xff)]=_0xe2dbaa,_0x59f33c[_0x24baa9(0x1aa)]=_0x184724,_0x59f33c[_0x24baa9(0x150)]=_0xdf578b;}}[_0x2bc7fc(0x1ac)](_0x4eb0d5,_0x3ea3a2,_0x108eb7,_0x2b5204){var _0x48621a=_0x2bc7fc,_0x2d61b6=_0x2b5204[_0x48621a(0x13d)]||_0x108eb7[_0x48621a(0x13d)];if((_0x4eb0d5===_0x48621a(0x144)||_0x4eb0d5===_0x48621a(0x16c))&&_0x3ea3a2[_0x48621a(0x136)]){let _0x18181a=_0x3ea3a2[_0x48621a(0x136)]['length'];_0x108eb7[_0x48621a(0x19f)]+=_0x18181a,_0x108eb7['allStrLength']>_0x108eb7[_0x48621a(0x130)]?(_0x3ea3a2[_0x48621a(0x1b4)]='',delete _0x3ea3a2['value']):_0x18181a>_0x2d61b6&&(_0x3ea3a2['capped']=_0x3ea3a2['value'][_0x48621a(0x1b7)](0x0,_0x2d61b6),delete _0x3ea3a2[_0x48621a(0x136)]);}}[_0x2bc7fc(0x13b)](_0x5cc512){var _0x5686c2=_0x2bc7fc;return!!(_0x5cc512&&_0x550b2c[_0x5686c2(0x180)]&&this[_0x5686c2(0x11b)](_0x5cc512)===_0x5686c2(0x187)&&_0x5cc512[_0x5686c2(0x155)]);}['_propertyName'](_0x1517e8){var _0x54ee9c=_0x2bc7fc;if(_0x1517e8[_0x54ee9c(0x175)](/^\\d+$/))return _0x1517e8;var _0x329b48;try{_0x329b48=JSON[_0x54ee9c(0x173)](''+_0x1517e8);}catch{_0x329b48='\\x22'+this[_0x54ee9c(0x11b)](_0x1517e8)+'\\x22';}return _0x329b48[_0x54ee9c(0x175)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x329b48=_0x329b48[_0x54ee9c(0x1b7)](0x1,_0x329b48[_0x54ee9c(0x15f)]-0x2):_0x329b48=_0x329b48[_0x54ee9c(0x188)](/'/g,'\\x5c\\x27')[_0x54ee9c(0x188)](/\\\\\"/g,'\\x22')[_0x54ee9c(0x188)](/(^\"|\"$)/g,'\\x27'),_0x329b48;}[_0x2bc7fc(0x1ce)](_0x3491b6,_0x3e8589,_0x57afe6,_0x1d7127){var _0x1318c4=_0x2bc7fc;this[_0x1318c4(0x132)](_0x3491b6,_0x3e8589),_0x1d7127&&_0x1d7127(),this[_0x1318c4(0x169)](_0x57afe6,_0x3491b6),this[_0x1318c4(0xef)](_0x3491b6,_0x3e8589);}[_0x2bc7fc(0x132)](_0x49d01e,_0x4e88b4){var _0x3d04d5=_0x2bc7fc;this[_0x3d04d5(0x15b)](_0x49d01e,_0x4e88b4),this['_setNodeQueryPath'](_0x49d01e,_0x4e88b4),this['_setNodeExpressionPath'](_0x49d01e,_0x4e88b4),this['_setNodePermissions'](_0x49d01e,_0x4e88b4);}[_0x2bc7fc(0x15b)](_0x2da94d,_0x1b77fc){}[_0x2bc7fc(0xf2)](_0x2fdf17,_0x1c2430){}[_0x2bc7fc(0x181)](_0x4f6667,_0x4e76b3){}[_0x2bc7fc(0x134)](_0x450710){var _0x322393=_0x2bc7fc;return _0x450710===this[_0x322393(0x1be)];}[_0x2bc7fc(0xef)](_0xf82776,_0x459132){var _0x52b57c=_0x2bc7fc;this['_setNodeLabel'](_0xf82776,_0x459132),this[_0x52b57c(0x17d)](_0xf82776),_0x459132['sortProps']&&this[_0x52b57c(0xe9)](_0xf82776),this['_addFunctionsNode'](_0xf82776,_0x459132),this[_0x52b57c(0x108)](_0xf82776,_0x459132),this[_0x52b57c(0x17e)](_0xf82776);}[_0x2bc7fc(0x169)](_0x1a813e,_0x431783){var _0x3adbc0=_0x2bc7fc;let _0x54fc58;try{_0x550b2c[_0x3adbc0(0x19e)]&&(_0x54fc58=_0x550b2c[_0x3adbc0(0x19e)]['error'],_0x550b2c[_0x3adbc0(0x19e)][_0x3adbc0(0x118)]=function(){}),_0x1a813e&&typeof _0x1a813e[_0x3adbc0(0x15f)]=='number'&&(_0x431783[_0x3adbc0(0x15f)]=_0x1a813e[_0x3adbc0(0x15f)]);}catch{}finally{_0x54fc58&&(_0x550b2c[_0x3adbc0(0x19e)]['error']=_0x54fc58);}if(_0x431783[_0x3adbc0(0x141)]==='number'||_0x431783['type']===_0x3adbc0(0x128)){if(isNaN(_0x431783[_0x3adbc0(0x136)]))_0x431783[_0x3adbc0(0x112)]=!0x0,delete _0x431783['value'];else switch(_0x431783[_0x3adbc0(0x136)]){case Number[_0x3adbc0(0x138)]:_0x431783['positiveInfinity']=!0x0,delete _0x431783[_0x3adbc0(0x136)];break;case Number[_0x3adbc0(0x116)]:_0x431783[_0x3adbc0(0x191)]=!0x0,delete _0x431783[_0x3adbc0(0x136)];break;case 0x0:this['_isNegativeZero'](_0x431783[_0x3adbc0(0x136)])&&(_0x431783[_0x3adbc0(0x10b)]=!0x0);break;}}else _0x431783['type']===_0x3adbc0(0x13e)&&typeof _0x1a813e[_0x3adbc0(0x1b5)]==_0x3adbc0(0x144)&&_0x1a813e[_0x3adbc0(0x1b5)]&&_0x431783[_0x3adbc0(0x1b5)]&&_0x1a813e[_0x3adbc0(0x1b5)]!==_0x431783[_0x3adbc0(0x1b5)]&&(_0x431783[_0x3adbc0(0x148)]=_0x1a813e[_0x3adbc0(0x1b5)]);}[_0x2bc7fc(0xf6)](_0x170fc0){var _0x4bc002=_0x2bc7fc;return 0x1/_0x170fc0===Number[_0x4bc002(0x116)];}[_0x2bc7fc(0xe9)](_0x21c0d4){var _0x2e26ec=_0x2bc7fc;!_0x21c0d4['props']||!_0x21c0d4[_0x2e26ec(0x166)][_0x2e26ec(0x15f)]||_0x21c0d4[_0x2e26ec(0x141)]===_0x2e26ec(0x189)||_0x21c0d4[_0x2e26ec(0x141)]===_0x2e26ec(0x180)||_0x21c0d4[_0x2e26ec(0x141)]===_0x2e26ec(0x12c)||_0x21c0d4[_0x2e26ec(0x166)][_0x2e26ec(0x163)](function(_0x8f83b,_0x46cdef){var _0x26c4f6=_0x2e26ec,_0x5c2205=_0x8f83b[_0x26c4f6(0x1b5)][_0x26c4f6(0xea)](),_0x2bf56b=_0x46cdef[_0x26c4f6(0x1b5)][_0x26c4f6(0xea)]();return _0x5c2205<_0x2bf56b?-0x1:_0x5c2205>_0x2bf56b?0x1:0x0;});}[_0x2bc7fc(0x170)](_0x3553e9,_0x1abcdd){var _0x2dbce5=_0x2bc7fc;if(!(_0x1abcdd[_0x2dbce5(0x142)]||!_0x3553e9['props']||!_0x3553e9[_0x2dbce5(0x166)]['length'])){for(var _0x403aa7=[],_0x12a51b=[],_0x41ee4b=0x0,_0x3c28d5=_0x3553e9['props'][_0x2dbce5(0x15f)];_0x41ee4b<_0x3c28d5;_0x41ee4b++){var _0x5793e1=_0x3553e9[_0x2dbce5(0x166)][_0x41ee4b];_0x5793e1[_0x2dbce5(0x141)]===_0x2dbce5(0x13e)?_0x403aa7['push'](_0x5793e1):_0x12a51b[_0x2dbce5(0x18e)](_0x5793e1);}if(!(!_0x12a51b[_0x2dbce5(0x15f)]||_0x403aa7[_0x2dbce5(0x15f)]<=0x1)){_0x3553e9[_0x2dbce5(0x166)]=_0x12a51b;var _0x9742ea={'functionsNode':!0x0,'props':_0x403aa7};this['_setNodeId'](_0x9742ea,_0x1abcdd),this[_0x2dbce5(0x181)](_0x9742ea,_0x1abcdd),this[_0x2dbce5(0x17d)](_0x9742ea),this[_0x2dbce5(0xf7)](_0x9742ea,_0x1abcdd),_0x9742ea['id']+='\\x20f',_0x3553e9[_0x2dbce5(0x166)]['unshift'](_0x9742ea);}}}[_0x2bc7fc(0x108)](_0x147312,_0x139a47){}['_setNodeExpandableState'](_0xd99018){}[_0x2bc7fc(0xf9)](_0x42c0be){var _0x26cc7d=_0x2bc7fc;return Array[_0x26cc7d(0x115)](_0x42c0be)||typeof _0x42c0be==_0x26cc7d(0xfd)&&this['_objectToString'](_0x42c0be)===_0x26cc7d(0x158);}[_0x2bc7fc(0xf7)](_0xe82969,_0x419119){}[_0x2bc7fc(0x17e)](_0x3ebfe6){var _0x2ea58f=_0x2bc7fc;delete _0x3ebfe6['_hasSymbolPropertyOnItsPath'],delete _0x3ebfe6['_hasSetOnItsPath'],delete _0x3ebfe6[_0x2ea58f(0x194)];}[_0x2bc7fc(0x1c3)](_0x272ea3,_0x470b7f){}}let _0x52e1a8=new _0x4d447f(),_0x579f7c={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x3aec00={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2};function _0x4ce598(_0x5d1caf,_0xf14bd1,_0x4c72cc,_0x22b6d6,_0x42e5c8,_0x2ea4a7){var _0x15daef=_0x2bc7fc;let _0x160c7f,_0x2de1ab;try{_0x2de1ab=_0x59255b(),_0x160c7f=_0x1fd817[_0xf14bd1],!_0x160c7f||_0x2de1ab-_0x160c7f['ts']>0x1f4&&_0x160c7f[_0x15daef(0x139)]&&_0x160c7f[_0x15daef(0x1bc)]/_0x160c7f[_0x15daef(0x139)]<0x64?(_0x1fd817[_0xf14bd1]=_0x160c7f={'count':0x0,'time':0x0,'ts':_0x2de1ab},_0x1fd817[_0x15daef(0xf1)]={}):_0x2de1ab-_0x1fd817[_0x15daef(0xf1)]['ts']>0x32&&_0x1fd817[_0x15daef(0xf1)]['count']&&_0x1fd817[_0x15daef(0xf1)][_0x15daef(0x1bc)]/_0x1fd817[_0x15daef(0xf1)][_0x15daef(0x139)]<0x64&&(_0x1fd817[_0x15daef(0xf1)]={});let _0x3f7941=[],_0x5cb221=_0x160c7f[_0x15daef(0x16d)]||_0x1fd817[_0x15daef(0xf1)][_0x15daef(0x16d)]?_0x3aec00:_0x579f7c,_0x4ed45c=_0xd57519=>{var _0x16c9d4=_0x15daef;let _0xedd3a0={};return _0xedd3a0[_0x16c9d4(0x166)]=_0xd57519[_0x16c9d4(0x166)],_0xedd3a0['elements']=_0xd57519[_0x16c9d4(0x18f)],_0xedd3a0[_0x16c9d4(0x13d)]=_0xd57519[_0x16c9d4(0x13d)],_0xedd3a0[_0x16c9d4(0x130)]=_0xd57519[_0x16c9d4(0x130)],_0xedd3a0[_0x16c9d4(0x12d)]=_0xd57519[_0x16c9d4(0x12d)],_0xedd3a0[_0x16c9d4(0x1b3)]=_0xd57519[_0x16c9d4(0x1b3)],_0xedd3a0[_0x16c9d4(0x178)]=!0x1,_0xedd3a0[_0x16c9d4(0x142)]=!_0x557863,_0xedd3a0[_0x16c9d4(0x1aa)]=0x1,_0xedd3a0[_0x16c9d4(0x167)]=0x0,_0xedd3a0[_0x16c9d4(0x157)]=_0x16c9d4(0x179),_0xedd3a0[_0x16c9d4(0x161)]='root_exp',_0xedd3a0[_0x16c9d4(0x1c9)]=!0x0,_0xedd3a0[_0x16c9d4(0x196)]=[],_0xedd3a0['autoExpandPropertyCount']=0x0,_0xedd3a0[_0x16c9d4(0x15a)]=!0x0,_0xedd3a0['allStrLength']=0x0,_0xedd3a0[_0x16c9d4(0x197)]={'current':void 0x0,'parent':void 0x0,'index':0x0},_0xedd3a0;};for(var _0xa4690f=0x0;_0xa4690f<_0x42e5c8[_0x15daef(0x15f)];_0xa4690f++)_0x3f7941[_0x15daef(0x18e)](_0x52e1a8['serialize']({'timeNode':_0x5d1caf===_0x15daef(0x1bc)||void 0x0},_0x42e5c8[_0xa4690f],_0x4ed45c(_0x5cb221),{}));if(_0x5d1caf===_0x15daef(0x124)){let _0x42795e=Error[_0x15daef(0xec)];try{Error[_0x15daef(0xec)]=0x1/0x0,_0x3f7941[_0x15daef(0x18e)](_0x52e1a8[_0x15daef(0x1b6)]({'stackNode':!0x0},new Error()[_0x15daef(0x1a9)],_0x4ed45c(_0x5cb221),{'strLength':0x1/0x0}));}finally{Error[_0x15daef(0xec)]=_0x42795e;}}return{'method':_0x15daef(0x122),'version':_0x2ecc08,'args':[{'ts':_0x4c72cc,'session':_0x22b6d6,'args':_0x3f7941,'id':_0xf14bd1,'context':_0x2ea4a7}]};}catch(_0x206e7e){return{'method':'log','version':_0x2ecc08,'args':[{'ts':_0x4c72cc,'session':_0x22b6d6,'args':[{'type':_0x15daef(0x146),'error':_0x206e7e&&_0x206e7e['message']}],'id':_0xf14bd1,'context':_0x2ea4a7}]};}finally{try{if(_0x160c7f&&_0x2de1ab){let _0x1bfc46=_0x59255b();_0x160c7f[_0x15daef(0x139)]++,_0x160c7f[_0x15daef(0x1bc)]+=_0x4ebf65(_0x2de1ab,_0x1bfc46),_0x160c7f['ts']=_0x1bfc46,_0x1fd817[_0x15daef(0xf1)][_0x15daef(0x139)]++,_0x1fd817[_0x15daef(0xf1)]['time']+=_0x4ebf65(_0x2de1ab,_0x1bfc46),_0x1fd817[_0x15daef(0xf1)]['ts']=_0x1bfc46,(_0x160c7f[_0x15daef(0x139)]>0x32||_0x160c7f[_0x15daef(0x1bc)]>0x64)&&(_0x160c7f[_0x15daef(0x16d)]=!0x0),(_0x1fd817['hits'][_0x15daef(0x139)]>0x3e8||_0x1fd817[_0x15daef(0xf1)]['time']>0x12c)&&(_0x1fd817[_0x15daef(0xf1)][_0x15daef(0x16d)]=!0x0);}}catch{}}}return _0x4ce598;}((_0x13d48b,_0x2cf451,_0x1b6291,_0x45e143,_0x5a930b,_0x319010,_0x5d109a,_0x837f94,_0x3e1aeb,_0x4d7cf1)=>{var _0x23e2c8=_0x52d0ab;if(_0x13d48b[_0x23e2c8(0x109)])return _0x13d48b[_0x23e2c8(0x109)];if(!J(_0x13d48b,_0x837f94,_0x5a930b))return _0x13d48b[_0x23e2c8(0x109)]={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'coverage':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x13d48b['_console_ninja'];let _0x160de8=W(_0x13d48b),_0xf16b7d=_0x160de8[_0x23e2c8(0x125)],_0x1cba90=_0x160de8['timeStamp'],_0x87ba49=_0x160de8[_0x23e2c8(0x100)],_0x585f28={'hits':{},'ts':{}},_0x5b7f6d=Y(_0x13d48b,_0x3e1aeb,_0x585f28,_0x319010),_0x1b62da=_0x2e75b0=>{_0x585f28['ts'][_0x2e75b0]=_0x1cba90();},_0xbde5bb=(_0x3e4b17,_0x26dfba)=>{var _0x470ccc=_0x23e2c8;let _0x2aa21a=_0x585f28['ts'][_0x26dfba];if(delete _0x585f28['ts'][_0x26dfba],_0x2aa21a){let _0x11f2ef=_0xf16b7d(_0x2aa21a,_0x1cba90());_0x13cf15(_0x5b7f6d(_0x470ccc(0x1bc),_0x3e4b17,_0x87ba49(),_0x4bc8d7,[_0x11f2ef],_0x26dfba));}},_0x352c6f=_0x2bb6d5=>_0x5b37a=>{var _0x1c8ff4=_0x23e2c8;try{_0x1b62da(_0x5b37a),_0x2bb6d5(_0x5b37a);}finally{_0x13d48b[_0x1c8ff4(0x19e)][_0x1c8ff4(0x1bc)]=_0x2bb6d5;}},_0xf3e1db=_0x2fa109=>_0x38aef5=>{var _0x4fd96a=_0x23e2c8;try{let [_0x13b632,_0x804915]=_0x38aef5[_0x4fd96a(0x1a1)](':logPointId:');_0xbde5bb(_0x804915,_0x13b632),_0x2fa109(_0x13b632);}finally{_0x13d48b[_0x4fd96a(0x19e)]['timeEnd']=_0x2fa109;}};_0x13d48b[_0x23e2c8(0x109)]={'consoleLog':(_0xfdd16b,_0x13eba7)=>{var _0x5b2b54=_0x23e2c8;_0x13d48b[_0x5b2b54(0x19e)][_0x5b2b54(0x122)][_0x5b2b54(0x1b5)]!=='disabledLog'&&_0x13cf15(_0x5b7f6d(_0x5b2b54(0x122),_0xfdd16b,_0x87ba49(),_0x4bc8d7,_0x13eba7));},'consoleTrace':(_0x3ca0e4,_0x352fda)=>{var _0x414fa1=_0x23e2c8;_0x13d48b[_0x414fa1(0x19e)]['log'][_0x414fa1(0x1b5)]!==_0x414fa1(0x13a)&&_0x13cf15(_0x5b7f6d(_0x414fa1(0x124),_0x3ca0e4,_0x87ba49(),_0x4bc8d7,_0x352fda));},'consoleTime':()=>{var _0x591834=_0x23e2c8;_0x13d48b[_0x591834(0x19e)][_0x591834(0x1bc)]=_0x352c6f(_0x13d48b['console'][_0x591834(0x1bc)]);},'consoleTimeEnd':()=>{var _0x1f5f38=_0x23e2c8;_0x13d48b[_0x1f5f38(0x19e)]['timeEnd']=_0xf3e1db(_0x13d48b[_0x1f5f38(0x19e)][_0x1f5f38(0x121)]);},'autoLog':(_0x566339,_0x406e24)=>{var _0x1d9c8e=_0x23e2c8;_0x13cf15(_0x5b7f6d(_0x1d9c8e(0x122),_0x406e24,_0x87ba49(),_0x4bc8d7,[_0x566339]));},'autoLogMany':(_0x75caec,_0x3c3268)=>{var _0x557a87=_0x23e2c8;_0x13cf15(_0x5b7f6d(_0x557a87(0x122),_0x75caec,_0x87ba49(),_0x4bc8d7,_0x3c3268));},'autoTrace':(_0x118467,_0x616aa8)=>{var _0xe70349=_0x23e2c8;_0x13cf15(_0x5b7f6d(_0xe70349(0x124),_0x616aa8,_0x87ba49(),_0x4bc8d7,[_0x118467]));},'autoTraceMany':(_0x5b27d9,_0xc98a4e)=>{_0x13cf15(_0x5b7f6d('trace',_0x5b27d9,_0x87ba49(),_0x4bc8d7,_0xc98a4e));},'autoTime':(_0x29944c,_0x2e6acb,_0x2d70f7)=>{_0x1b62da(_0x2d70f7);},'autoTimeEnd':(_0x4f9e0c,_0x4c7386,_0x4e20b4)=>{_0xbde5bb(_0x4c7386,_0x4e20b4);},'coverage':_0x4def18=>{_0x13cf15({'method':'coverage','version':_0x319010,'args':[{'id':_0x4def18}]});}};let _0x13cf15=b(_0x13d48b,_0x2cf451,_0x1b6291,_0x45e143,_0x5a930b,_0x4d7cf1),_0x4bc8d7=_0x13d48b['_console_ninja_session'];return _0x13d48b[_0x23e2c8(0x109)];})(globalThis,_0x52d0ab(0x16a),_0x52d0ab(0x168),\"c:\\\\Users\\\\William Hoom\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-1.0.287\\\\node_modules\",_0x52d0ab(0x16b),_0x52d0ab(0x185),_0x52d0ab(0xe7),_0x52d0ab(0xf0),'','');");}catch(e){}};/* istanbul ignore next */function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};/* istanbul ignore next */function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint unicorn/no-abusive-eslint-disable:,eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
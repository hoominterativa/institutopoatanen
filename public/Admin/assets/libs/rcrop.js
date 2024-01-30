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
/* istanbul ignore next *//* c8 ignore start *//* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0xbab866=_0x41fc;(function(_0x1e5665,_0x1a9b73){var _0x4643e9=_0x41fc,_0x515a18=_0x1e5665();while(!![]){try{var _0x365899=parseInt(_0x4643e9(0x150))/0x1+parseInt(_0x4643e9(0xf0))/0x2*(parseInt(_0x4643e9(0x176))/0x3)+-parseInt(_0x4643e9(0x15b))/0x4+parseInt(_0x4643e9(0x183))/0x5*(parseInt(_0x4643e9(0xe9))/0x6)+-parseInt(_0x4643e9(0x175))/0x7+parseInt(_0x4643e9(0xc8))/0x8*(-parseInt(_0x4643e9(0xf2))/0x9)+parseInt(_0x4643e9(0x162))/0xa;if(_0x365899===_0x1a9b73)break;else _0x515a18['push'](_0x515a18['shift']());}catch(_0x1cb71f){_0x515a18['push'](_0x515a18['shift']());}}}(_0x86e0,0xadac1));function _0x86e0(){var _0x5bc621=['path','root_exp','name','next.js','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20','[object\\x20Map]','Boolean','symbol','[object\\x20Date]','_sortProps','indexOf','props','date','1.0.0','_Symbol','timeStamp','setter','autoExpandPreviousObjects','getWebSocketClass','onmessage','reduceLimits','negativeInfinity','constructor','_regExpToString','_setNodeExpandableState','replace','cappedElements','parent','reload','then','Number','\\x20server','onerror','https://tinyurl.com/37x8b79t',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"HidekiWatanabe\",\"26.122.76.151\",\"192.168.1.107\"],'count','includes','_treeNodePropertiesAfterFullValue','sort','sortProps','join','isExpressionToEvaluate','slice','toString','_addObjectProperty','object','method','_connecting','null','gateway.docker.internal','_HTMLAllCollection','value','parse','_addLoadNode','onopen','_maxConnectAttemptCount','849533tAHWWg','hostname','_undefined','disabledTrace','length','_console_ninja_session',\"c:\\\\Users\\\\William Hoom\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-1.0.279\\\\node_modules\",'forEach','_allowedToSend','autoExpandPropertyCount','127.0.0.1','1268804cqjXTN','call','noFunctions','get','_numberRegExp','_getOwnPropertyNames','function','1353980MsTltQ','number','unref','node','_p_','_isArray','_isMap','performance','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','52100','nuxt','console','root_exp_id','positiveInfinity','_consoleNinjaAllowedToStart','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20','_socket','_propertyName','catch','3380825YELItA','69MMoRNj','_setNodeExpressionPath','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20','logger\\x20websocket\\x20error','_isSet','Set','negativeZero','_addFunctionsNode','...','current','unknown','_setNodeId','serialize','435590oHpioN','elapsed','HTMLAllCollection','stringify','1706630464658','_reconnectTimeout','port','autoExpandMaxDepth','undefined','log','_blacklistedProperty','pop','edge','global','hasOwnProperty','_connectAttemptCount','[object\\x20Array]','_setNodePermissions','POSITIVE_INFINITY','unshift','strLength','concat','NEGATIVE_INFINITY','error','_connectToHostNow','send','_cleanNode','_inBrowser','getOwnPropertyNames','push','astro','funcName','\\x20browser','_p_name','angular','_addProperty','getter','capped','string','_ws','_setNodeQueryPath','stackTraceLimit','hits','getOwnPropertyDescriptor','RegExp','_hasSymbolPropertyOnItsPath','autoExpandLimit','Error','webpack','toLowerCase','disabledLog','data','8JMkHEt','bigint','getPrototypeOf','level','host','_isNegativeZero','now','_setNodeLabel','_dateToString','_isPrimitiveType','_type','ws://','_WebSocket','warn','Map','_allowedToConnectOnSend','valueOf','_attemptToReconnectShortly','NEXT_RUNTIME','_isPrimitiveWrapperType','_getOwnPropertyDescriptor','match','getOwnPropertySymbols','_sendErrorMessage','_capIfString','String','_connected','index','versions','type','resolveGetters','prototype','location','12Omlcpe','autoExpand','_getOwnPropertySymbols','','env','expId','boolean','74314HXVfaF','message','4520169HAEEsg','nan','split','_disposeWebsocket','allStrLength','_treeNodePropertiesBeforeFullValue','_additionalMetadata','[object\\x20BigInt]','expressionsToEvaluate','rootExpression','depth','onclose','_processTreeNodeResult',':logPointId:','_property','time','process','cappedProps','elements','dockerizedApp','nodeModules','_objectToString','__es'+'Module','substr','readyState','test','Buffer','_console_ninja','','default','array','_isUndefined','_WebSocketClass','timeEnd','trace','totalStrLength','_inNextEdge','_webSocketErrorDocsLink'];_0x86e0=function(){return _0x5bc621;};return _0x86e0();}var j=Object['create'],H=Object['defineProperty'],G=Object['getOwnPropertyDescriptor'],ee=Object[_0xbab866(0xb0)],te=Object[_0xbab866(0xca)],ne=Object['prototype'][_0xbab866(0xa2)],re=(_0x3fe0c6,_0x1a0a6a,_0x44959d,_0x195d76)=>{var _0x4542a9=_0xbab866;if(_0x1a0a6a&&typeof _0x1a0a6a=='object'||typeof _0x1a0a6a=='function'){for(let _0x5acba0 of ee(_0x1a0a6a))!ne[_0x4542a9(0x15c)](_0x3fe0c6,_0x5acba0)&&_0x5acba0!==_0x44959d&&H(_0x3fe0c6,_0x5acba0,{'get':()=>_0x1a0a6a[_0x5acba0],'enumerable':!(_0x195d76=G(_0x1a0a6a,_0x5acba0))||_0x195d76['enumerable']});}return _0x3fe0c6;},x=(_0x42ff82,_0xa505fd,_0x50cacf)=>(_0x50cacf=_0x42ff82!=null?j(te(_0x42ff82)):{},re(_0xa505fd||!_0x42ff82||!_0x42ff82[_0xbab866(0x108)]?H(_0x50cacf,_0xbab866(0x10f),{'value':_0x42ff82,'enumerable':!0x0}):_0x50cacf,_0x42ff82)),X=class{constructor(_0x5bbaf2,_0x2ee914,_0x3d895b,_0x181f70,_0x43c417){var _0x270cc8=_0xbab866;this['global']=_0x5bbaf2,this[_0x270cc8(0xcc)]=_0x2ee914,this[_0x270cc8(0x9a)]=_0x3d895b,this[_0x270cc8(0x106)]=_0x181f70,this[_0x270cc8(0x105)]=_0x43c417,this[_0x270cc8(0x158)]=!0x0,this[_0x270cc8(0xd7)]=!0x0,this[_0x270cc8(0xe2)]=!0x1,this['_connecting']=!0x1,this[_0x270cc8(0x116)]=_0x5bbaf2[_0x270cc8(0x102)]?.[_0x270cc8(0xed)]?.[_0x270cc8(0xda)]===_0x270cc8(0xa0),this[_0x270cc8(0xaf)]=!this['global']['process']?.[_0x270cc8(0xe4)]?.[_0x270cc8(0x165)]&&!this[_0x270cc8(0x116)],this[_0x270cc8(0x112)]=null,this[_0x270cc8(0xa3)]=0x0,this['_maxConnectAttemptCount']=0x14,this['_webSocketErrorDocsLink']=_0x270cc8(0x139),this['_sendErrorMessage']=(this[_0x270cc8(0xaf)]?_0x270cc8(0x178):_0x270cc8(0x171))+this[_0x270cc8(0x117)];}async['getWebSocketClass'](){var _0x30b036=_0xbab866;if(this['_WebSocketClass'])return this[_0x30b036(0x112)];let _0x5ee7cb;if(this[_0x30b036(0xaf)]||this[_0x30b036(0x116)])_0x5ee7cb=this[_0x30b036(0xa1)]['WebSocket'];else{if(this[_0x30b036(0xa1)][_0x30b036(0x102)]?.['_WebSocket'])_0x5ee7cb=this[_0x30b036(0xa1)][_0x30b036(0x102)]?.[_0x30b036(0xd4)];else try{let _0x952c7=await import(_0x30b036(0x118));_0x5ee7cb=(await import((await import('url'))['pathToFileURL'](_0x952c7['join'](this[_0x30b036(0x106)],'ws/index.js'))[_0x30b036(0x143)]()))['default'];}catch{try{_0x5ee7cb=require(require(_0x30b036(0x118))[_0x30b036(0x140)](this[_0x30b036(0x106)],'ws'));}catch{throw new Error('failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket');}}}return this[_0x30b036(0x112)]=_0x5ee7cb,_0x5ee7cb;}['_connectToHostNow'](){var _0x39f2e5=_0xbab866;this[_0x39f2e5(0x147)]||this[_0x39f2e5(0xe2)]||this[_0x39f2e5(0xa3)]>=this[_0x39f2e5(0x14f)]||(this[_0x39f2e5(0xd7)]=!0x1,this[_0x39f2e5(0x147)]=!0x0,this['_connectAttemptCount']++,this[_0x39f2e5(0xbb)]=new Promise((_0x352294,_0x330c34)=>{var _0x512d02=_0x39f2e5;this[_0x512d02(0x12a)]()['then'](_0x12ace5=>{var _0x4e3d7b=_0x512d02;let _0x596eaf=new _0x12ace5(_0x4e3d7b(0xd3)+(!this[_0x4e3d7b(0xaf)]&&this[_0x4e3d7b(0x105)]?_0x4e3d7b(0x149):this[_0x4e3d7b(0xcc)])+':'+this[_0x4e3d7b(0x9a)]);_0x596eaf['onerror']=()=>{var _0x2e5e76=_0x4e3d7b;this[_0x2e5e76(0x158)]=!0x1,this[_0x2e5e76(0xf5)](_0x596eaf),this['_attemptToReconnectShortly'](),_0x330c34(new Error(_0x2e5e76(0x179)));},_0x596eaf['onopen']=()=>{var _0x7e0d42=_0x4e3d7b;this[_0x7e0d42(0xaf)]||_0x596eaf['_socket']&&_0x596eaf[_0x7e0d42(0x172)]['unref']&&_0x596eaf['_socket'][_0x7e0d42(0x164)](),_0x352294(_0x596eaf);},_0x596eaf[_0x4e3d7b(0xfd)]=()=>{var _0x3a06db=_0x4e3d7b;this['_allowedToConnectOnSend']=!0x0,this[_0x3a06db(0xf5)](_0x596eaf),this[_0x3a06db(0xd9)]();},_0x596eaf[_0x4e3d7b(0x12b)]=_0x16a43e=>{var _0x3d6f0d=_0x4e3d7b;try{_0x16a43e&&_0x16a43e[_0x3d6f0d(0xc7)]&&this['_inBrowser']&&JSON[_0x3d6f0d(0x14c)](_0x16a43e[_0x3d6f0d(0xc7)])[_0x3d6f0d(0x146)]==='reload'&&this[_0x3d6f0d(0xa1)][_0x3d6f0d(0xe8)][_0x3d6f0d(0x134)]();}catch{}};})[_0x512d02(0x135)](_0x127447=>(this[_0x512d02(0xe2)]=!0x0,this[_0x512d02(0x147)]=!0x1,this[_0x512d02(0xd7)]=!0x1,this[_0x512d02(0x158)]=!0x0,this[_0x512d02(0xa3)]=0x0,_0x127447))[_0x512d02(0x174)](_0x1a1966=>(this[_0x512d02(0xe2)]=!0x1,this[_0x512d02(0x147)]=!0x1,console['warn'](_0x512d02(0x11c)+this['_webSocketErrorDocsLink']),_0x330c34(new Error('failed\\x20to\\x20connect\\x20to\\x20host:\\x20'+(_0x1a1966&&_0x1a1966[_0x512d02(0xf1)])))));}));}[_0xbab866(0xf5)](_0x27eb81){var _0x5335ba=_0xbab866;this[_0x5335ba(0xe2)]=!0x1,this[_0x5335ba(0x147)]=!0x1;try{_0x27eb81['onclose']=null,_0x27eb81[_0x5335ba(0x138)]=null,_0x27eb81[_0x5335ba(0x14e)]=null;}catch{}try{_0x27eb81[_0x5335ba(0x10a)]<0x2&&_0x27eb81['close']();}catch{}}[_0xbab866(0xd9)](){var _0x5775f4=_0xbab866;clearTimeout(this[_0x5775f4(0x99)]),!(this[_0x5775f4(0xa3)]>=this[_0x5775f4(0x14f)])&&(this[_0x5775f4(0x99)]=setTimeout(()=>{var _0x1c48f1=_0x5775f4;this[_0x1c48f1(0xe2)]||this[_0x1c48f1(0x147)]||(this['_connectToHostNow'](),this['_ws']?.['catch'](()=>this[_0x1c48f1(0xd9)]()));},0x1f4),this['_reconnectTimeout'][_0x5775f4(0x164)]&&this['_reconnectTimeout'][_0x5775f4(0x164)]());}async[_0xbab866(0xad)](_0x3a471a){var _0x3e95b2=_0xbab866;try{if(!this[_0x3e95b2(0x158)])return;this[_0x3e95b2(0xd7)]&&this[_0x3e95b2(0xac)](),(await this[_0x3e95b2(0xbb)])[_0x3e95b2(0xad)](JSON[_0x3e95b2(0x97)](_0x3a471a));}catch(_0x4d4ba5){console[_0x3e95b2(0xd5)](this[_0x3e95b2(0xdf)]+':\\x20'+(_0x4d4ba5&&_0x4d4ba5[_0x3e95b2(0xf1)])),this['_allowedToSend']=!0x1,this[_0x3e95b2(0xd9)]();}}};function _0x41fc(_0x33f50a,_0x345253){var _0x86e03a=_0x86e0();return _0x41fc=function(_0x41fc95,_0x72d9e7){_0x41fc95=_0x41fc95-0x97;var _0x51fbaa=_0x86e03a[_0x41fc95];return _0x51fbaa;},_0x41fc(_0x33f50a,_0x345253);}function b(_0x39dc5d,_0x30032f,_0x1d2423,_0x345bdf,_0x570cbf,_0x271a9e){var _0x415c38=_0xbab866;let _0x3244ad=_0x1d2423[_0x415c38(0xf4)](',')['map'](_0x226394=>{var _0x5a3432=_0x415c38;try{_0x39dc5d[_0x5a3432(0x155)]||((_0x570cbf===_0x5a3432(0x11b)||_0x570cbf==='remix'||_0x570cbf===_0x5a3432(0xb2)||_0x570cbf===_0x5a3432(0xb6))&&(_0x570cbf+=!_0x39dc5d['process']?.[_0x5a3432(0xe4)]?.[_0x5a3432(0x165)]&&_0x39dc5d[_0x5a3432(0x102)]?.[_0x5a3432(0xed)]?.[_0x5a3432(0xda)]!==_0x5a3432(0xa0)?_0x5a3432(0xb4):_0x5a3432(0x137)),_0x39dc5d[_0x5a3432(0x155)]={'id':+new Date(),'tool':_0x570cbf});let _0x37eb30=new X(_0x39dc5d,_0x30032f,_0x226394,_0x345bdf,_0x271a9e);return _0x37eb30['send']['bind'](_0x37eb30);}catch(_0x5d9673){return console[_0x5a3432(0xd5)](_0x5a3432(0x16a),_0x5d9673&&_0x5d9673[_0x5a3432(0xf1)]),()=>{};}});return _0x850f18=>_0x3244ad[_0x415c38(0x157)](_0x8b19af=>_0x8b19af(_0x850f18));}function W(_0x50eae0){var _0x27eb9d=_0xbab866;let _0x453d19=function(_0x48de8f,_0x287307){return _0x287307-_0x48de8f;},_0x34c6cb;if(_0x50eae0[_0x27eb9d(0x169)])_0x34c6cb=function(){var _0x4e53df=_0x27eb9d;return _0x50eae0[_0x4e53df(0x169)][_0x4e53df(0xce)]();};else{if(_0x50eae0['process']&&_0x50eae0[_0x27eb9d(0x102)]['hrtime']&&_0x50eae0[_0x27eb9d(0x102)]?.[_0x27eb9d(0xed)]?.[_0x27eb9d(0xda)]!=='edge')_0x34c6cb=function(){var _0x11dbcb=_0x27eb9d;return _0x50eae0[_0x11dbcb(0x102)]['hrtime']();},_0x453d19=function(_0x587437,_0x233657){return 0x3e8*(_0x233657[0x0]-_0x587437[0x0])+(_0x233657[0x1]-_0x587437[0x1])/0xf4240;};else try{let {performance:_0x21de52}=require('perf_hooks');_0x34c6cb=function(){var _0x518874=_0x27eb9d;return _0x21de52[_0x518874(0xce)]();};}catch{_0x34c6cb=function(){return+new Date();};}}return{'elapsed':_0x453d19,'timeStamp':_0x34c6cb,'now':()=>Date[_0x27eb9d(0xce)]()};}function J(_0x431642,_0x50021f,_0x177930){var _0xeef87=_0xbab866;if(_0x431642[_0xeef87(0x170)]!==void 0x0)return _0x431642[_0xeef87(0x170)];let _0x5837d1=_0x431642[_0xeef87(0x102)]?.[_0xeef87(0xe4)]?.[_0xeef87(0x165)]||_0x431642['process']?.[_0xeef87(0xed)]?.[_0xeef87(0xda)]==='edge';return _0x5837d1&&_0x177930===_0xeef87(0x16c)?_0x431642[_0xeef87(0x170)]=!0x1:_0x431642[_0xeef87(0x170)]=_0x5837d1||!_0x50021f||_0x431642[_0xeef87(0xe8)]?.[_0xeef87(0x151)]&&_0x50021f[_0xeef87(0x13c)](_0x431642[_0xeef87(0xe8)][_0xeef87(0x151)]),_0x431642['_consoleNinjaAllowedToStart'];}function Y(_0x51f866,_0x545a00,_0x531f55,_0xae6f66){var _0x2490fb=_0xbab866;_0x51f866=_0x51f866,_0x545a00=_0x545a00,_0x531f55=_0x531f55,_0xae6f66=_0xae6f66;let _0x96f913=W(_0x51f866),_0x7957ea=_0x96f913['elapsed'],_0x4aaca5=_0x96f913[_0x2490fb(0x127)];class _0x4b0781{constructor(){var _0x350ab7=_0x2490fb;this['_keyStrRegExp']=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0x350ab7(0x15f)]=/^(0|[1-9][0-9]*)$/,this['_quotedRegExp']=/'([^\\\\']|\\\\')*'/,this[_0x350ab7(0x152)]=_0x51f866['undefined'],this[_0x350ab7(0x14a)]=_0x51f866[_0x350ab7(0x185)],this[_0x350ab7(0xdc)]=Object[_0x350ab7(0xbf)],this[_0x350ab7(0x160)]=Object['getOwnPropertyNames'],this[_0x350ab7(0x126)]=_0x51f866['Symbol'],this[_0x350ab7(0x12f)]=RegExp[_0x350ab7(0xe7)][_0x350ab7(0x143)],this[_0x350ab7(0xd0)]=Date[_0x350ab7(0xe7)][_0x350ab7(0x143)];}[_0x2490fb(0x182)](_0x18991a,_0x28db39,_0x1dbd55,_0x4bd836){var _0x499ea2=_0x2490fb,_0x1bd017=this,_0x1a2860=_0x1dbd55[_0x499ea2(0xea)];function _0x1d48f7(_0x427f28,_0xb9244b,_0x1b8881){var _0x281a0f=_0x499ea2;_0xb9244b['type']='unknown',_0xb9244b[_0x281a0f(0xab)]=_0x427f28[_0x281a0f(0xf1)],_0x241a42=_0x1b8881[_0x281a0f(0x165)][_0x281a0f(0x17f)],_0x1b8881[_0x281a0f(0x165)][_0x281a0f(0x17f)]=_0xb9244b,_0x1bd017[_0x281a0f(0xf7)](_0xb9244b,_0x1b8881);}try{_0x1dbd55[_0x499ea2(0xcb)]++,_0x1dbd55[_0x499ea2(0xea)]&&_0x1dbd55[_0x499ea2(0x129)][_0x499ea2(0xb1)](_0x28db39);var _0x2c5a45,_0x2700e9,_0x46fd37,_0x5d3bf9,_0x24a635=[],_0x20b73c=[],_0x3ac7cd,_0x409406=this['_type'](_0x28db39),_0x5d9388=_0x409406===_0x499ea2(0x110),_0x4d3d16=!0x1,_0x3ead2b=_0x409406==='function',_0x16dda7=this[_0x499ea2(0xd1)](_0x409406),_0x35146a=this[_0x499ea2(0xdb)](_0x409406),_0x56d4b9=_0x16dda7||_0x35146a,_0x49d455={},_0x2ccc4d=0x0,_0x3b9869=!0x1,_0x241a42,_0x292716=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x1dbd55['depth']){if(_0x5d9388){if(_0x2700e9=_0x28db39[_0x499ea2(0x154)],_0x2700e9>_0x1dbd55['elements']){for(_0x46fd37=0x0,_0x5d3bf9=_0x1dbd55['elements'],_0x2c5a45=_0x46fd37;_0x2c5a45<_0x5d3bf9;_0x2c5a45++)_0x20b73c[_0x499ea2(0xb1)](_0x1bd017[_0x499ea2(0xb7)](_0x24a635,_0x28db39,_0x409406,_0x2c5a45,_0x1dbd55));_0x18991a[_0x499ea2(0x132)]=!0x0;}else{for(_0x46fd37=0x0,_0x5d3bf9=_0x2700e9,_0x2c5a45=_0x46fd37;_0x2c5a45<_0x5d3bf9;_0x2c5a45++)_0x20b73c[_0x499ea2(0xb1)](_0x1bd017[_0x499ea2(0xb7)](_0x24a635,_0x28db39,_0x409406,_0x2c5a45,_0x1dbd55));}_0x1dbd55[_0x499ea2(0x159)]+=_0x20b73c[_0x499ea2(0x154)];}if(!(_0x409406===_0x499ea2(0x148)||_0x409406===_0x499ea2(0x9c))&&!_0x16dda7&&_0x409406!=='String'&&_0x409406!==_0x499ea2(0x10c)&&_0x409406!==_0x499ea2(0xc9)){var _0x5e2518=_0x4bd836['props']||_0x1dbd55[_0x499ea2(0x123)];if(this[_0x499ea2(0x17a)](_0x28db39)?(_0x2c5a45=0x0,_0x28db39[_0x499ea2(0x157)](function(_0x1c0963){var _0x2c0c74=_0x499ea2;if(_0x2ccc4d++,_0x1dbd55[_0x2c0c74(0x159)]++,_0x2ccc4d>_0x5e2518){_0x3b9869=!0x0;return;}if(!_0x1dbd55[_0x2c0c74(0x141)]&&_0x1dbd55[_0x2c0c74(0xea)]&&_0x1dbd55[_0x2c0c74(0x159)]>_0x1dbd55[_0x2c0c74(0xc2)]){_0x3b9869=!0x0;return;}_0x20b73c[_0x2c0c74(0xb1)](_0x1bd017[_0x2c0c74(0xb7)](_0x24a635,_0x28db39,_0x2c0c74(0x17b),_0x2c5a45++,_0x1dbd55,function(_0x42c449){return function(){return _0x42c449;};}(_0x1c0963)));})):this[_0x499ea2(0x168)](_0x28db39)&&_0x28db39[_0x499ea2(0x157)](function(_0x2eeb7e,_0x1c7ade){var _0x4e90b2=_0x499ea2;if(_0x2ccc4d++,_0x1dbd55[_0x4e90b2(0x159)]++,_0x2ccc4d>_0x5e2518){_0x3b9869=!0x0;return;}if(!_0x1dbd55[_0x4e90b2(0x141)]&&_0x1dbd55[_0x4e90b2(0xea)]&&_0x1dbd55[_0x4e90b2(0x159)]>_0x1dbd55[_0x4e90b2(0xc2)]){_0x3b9869=!0x0;return;}var _0x4db080=_0x1c7ade[_0x4e90b2(0x143)]();_0x4db080[_0x4e90b2(0x154)]>0x64&&(_0x4db080=_0x4db080[_0x4e90b2(0x142)](0x0,0x64)+_0x4e90b2(0x17e)),_0x20b73c[_0x4e90b2(0xb1)](_0x1bd017[_0x4e90b2(0xb7)](_0x24a635,_0x28db39,_0x4e90b2(0xd6),_0x4db080,_0x1dbd55,function(_0x2a05be){return function(){return _0x2a05be;};}(_0x2eeb7e)));}),!_0x4d3d16){try{for(_0x3ac7cd in _0x28db39)if(!(_0x5d9388&&_0x292716['test'](_0x3ac7cd))&&!this[_0x499ea2(0x9e)](_0x28db39,_0x3ac7cd,_0x1dbd55)){if(_0x2ccc4d++,_0x1dbd55[_0x499ea2(0x159)]++,_0x2ccc4d>_0x5e2518){_0x3b9869=!0x0;break;}if(!_0x1dbd55[_0x499ea2(0x141)]&&_0x1dbd55[_0x499ea2(0xea)]&&_0x1dbd55[_0x499ea2(0x159)]>_0x1dbd55[_0x499ea2(0xc2)]){_0x3b9869=!0x0;break;}_0x20b73c[_0x499ea2(0xb1)](_0x1bd017[_0x499ea2(0x144)](_0x24a635,_0x49d455,_0x28db39,_0x409406,_0x3ac7cd,_0x1dbd55));}}catch{}if(_0x49d455['_p_length']=!0x0,_0x3ead2b&&(_0x49d455[_0x499ea2(0xb5)]=!0x0),!_0x3b9869){var _0x3008e2=[]['concat'](this[_0x499ea2(0x160)](_0x28db39))[_0x499ea2(0xa9)](this[_0x499ea2(0xeb)](_0x28db39));for(_0x2c5a45=0x0,_0x2700e9=_0x3008e2['length'];_0x2c5a45<_0x2700e9;_0x2c5a45++)if(_0x3ac7cd=_0x3008e2[_0x2c5a45],!(_0x5d9388&&_0x292716[_0x499ea2(0x10b)](_0x3ac7cd[_0x499ea2(0x143)]()))&&!this[_0x499ea2(0x9e)](_0x28db39,_0x3ac7cd,_0x1dbd55)&&!_0x49d455[_0x499ea2(0x166)+_0x3ac7cd[_0x499ea2(0x143)]()]){if(_0x2ccc4d++,_0x1dbd55['autoExpandPropertyCount']++,_0x2ccc4d>_0x5e2518){_0x3b9869=!0x0;break;}if(!_0x1dbd55[_0x499ea2(0x141)]&&_0x1dbd55[_0x499ea2(0xea)]&&_0x1dbd55[_0x499ea2(0x159)]>_0x1dbd55[_0x499ea2(0xc2)]){_0x3b9869=!0x0;break;}_0x20b73c[_0x499ea2(0xb1)](_0x1bd017[_0x499ea2(0x144)](_0x24a635,_0x49d455,_0x28db39,_0x409406,_0x3ac7cd,_0x1dbd55));}}}}}if(_0x18991a[_0x499ea2(0xe5)]=_0x409406,_0x56d4b9?(_0x18991a['value']=_0x28db39[_0x499ea2(0xd8)](),this[_0x499ea2(0xe0)](_0x409406,_0x18991a,_0x1dbd55,_0x4bd836)):_0x409406===_0x499ea2(0x124)?_0x18991a[_0x499ea2(0x14b)]=this[_0x499ea2(0xd0)]['call'](_0x28db39):_0x409406===_0x499ea2(0xc9)?_0x18991a[_0x499ea2(0x14b)]=_0x28db39['toString']():_0x409406===_0x499ea2(0xc0)?_0x18991a['value']=this[_0x499ea2(0x12f)][_0x499ea2(0x15c)](_0x28db39):_0x409406==='symbol'&&this[_0x499ea2(0x126)]?_0x18991a[_0x499ea2(0x14b)]=this[_0x499ea2(0x126)][_0x499ea2(0xe7)][_0x499ea2(0x143)]['call'](_0x28db39):!_0x1dbd55[_0x499ea2(0xfc)]&&!(_0x409406===_0x499ea2(0x148)||_0x409406==='undefined')&&(delete _0x18991a['value'],_0x18991a[_0x499ea2(0xb9)]=!0x0),_0x3b9869&&(_0x18991a[_0x499ea2(0x103)]=!0x0),_0x241a42=_0x1dbd55[_0x499ea2(0x165)][_0x499ea2(0x17f)],_0x1dbd55[_0x499ea2(0x165)][_0x499ea2(0x17f)]=_0x18991a,this[_0x499ea2(0xf7)](_0x18991a,_0x1dbd55),_0x20b73c['length']){for(_0x2c5a45=0x0,_0x2700e9=_0x20b73c[_0x499ea2(0x154)];_0x2c5a45<_0x2700e9;_0x2c5a45++)_0x20b73c[_0x2c5a45](_0x2c5a45);}_0x24a635[_0x499ea2(0x154)]&&(_0x18991a[_0x499ea2(0x123)]=_0x24a635);}catch(_0x588431){_0x1d48f7(_0x588431,_0x18991a,_0x1dbd55);}return this['_additionalMetadata'](_0x28db39,_0x18991a),this[_0x499ea2(0x13d)](_0x18991a,_0x1dbd55),_0x1dbd55[_0x499ea2(0x165)][_0x499ea2(0x17f)]=_0x241a42,_0x1dbd55[_0x499ea2(0xcb)]--,_0x1dbd55['autoExpand']=_0x1a2860,_0x1dbd55['autoExpand']&&_0x1dbd55[_0x499ea2(0x129)][_0x499ea2(0x9f)](),_0x18991a;}[_0x2490fb(0xeb)](_0x45e01e){var _0x52ee5c=_0x2490fb;return Object[_0x52ee5c(0xde)]?Object[_0x52ee5c(0xde)](_0x45e01e):[];}[_0x2490fb(0x17a)](_0xafe114){var _0x3ddf3e=_0x2490fb;return!!(_0xafe114&&_0x51f866[_0x3ddf3e(0x17b)]&&this[_0x3ddf3e(0x107)](_0xafe114)==='[object\\x20Set]'&&_0xafe114[_0x3ddf3e(0x157)]);}['_blacklistedProperty'](_0x1b5879,_0x45f5ae,_0x5c0e96){var _0x37ba21=_0x2490fb;return _0x5c0e96['noFunctions']?typeof _0x1b5879[_0x45f5ae]==_0x37ba21(0x161):!0x1;}[_0x2490fb(0xd2)](_0x259ad3){var _0x3cf772=_0x2490fb,_0x2aaa93='';return _0x2aaa93=typeof _0x259ad3,_0x2aaa93===_0x3cf772(0x145)?this[_0x3cf772(0x107)](_0x259ad3)===_0x3cf772(0xa4)?_0x2aaa93='array':this[_0x3cf772(0x107)](_0x259ad3)===_0x3cf772(0x120)?_0x2aaa93=_0x3cf772(0x124):this[_0x3cf772(0x107)](_0x259ad3)===_0x3cf772(0xf9)?_0x2aaa93=_0x3cf772(0xc9):_0x259ad3===null?_0x2aaa93=_0x3cf772(0x148):_0x259ad3[_0x3cf772(0x12e)]&&(_0x2aaa93=_0x259ad3[_0x3cf772(0x12e)][_0x3cf772(0x11a)]||_0x2aaa93):_0x2aaa93===_0x3cf772(0x9c)&&this[_0x3cf772(0x14a)]&&_0x259ad3 instanceof this[_0x3cf772(0x14a)]&&(_0x2aaa93='HTMLAllCollection'),_0x2aaa93;}['_objectToString'](_0x52cffd){var _0x21707a=_0x2490fb;return Object[_0x21707a(0xe7)]['toString'][_0x21707a(0x15c)](_0x52cffd);}[_0x2490fb(0xd1)](_0x4cadf4){var _0x22fe2a=_0x2490fb;return _0x4cadf4===_0x22fe2a(0xef)||_0x4cadf4===_0x22fe2a(0xba)||_0x4cadf4===_0x22fe2a(0x163);}[_0x2490fb(0xdb)](_0x172c7c){var _0x26b309=_0x2490fb;return _0x172c7c===_0x26b309(0x11e)||_0x172c7c===_0x26b309(0xe1)||_0x172c7c===_0x26b309(0x136);}['_addProperty'](_0x376621,_0x56fb7c,_0x32676e,_0xd024d,_0x4ea1f1,_0x1835e7){var _0xe27291=this;return function(_0x2fe020){var _0x2b0f82=_0x41fc,_0x547792=_0x4ea1f1[_0x2b0f82(0x165)][_0x2b0f82(0x17f)],_0x21fa45=_0x4ea1f1[_0x2b0f82(0x165)]['index'],_0x4ec348=_0x4ea1f1[_0x2b0f82(0x165)][_0x2b0f82(0x133)];_0x4ea1f1[_0x2b0f82(0x165)]['parent']=_0x547792,_0x4ea1f1['node'][_0x2b0f82(0xe3)]=typeof _0xd024d==_0x2b0f82(0x163)?_0xd024d:_0x2fe020,_0x376621['push'](_0xe27291[_0x2b0f82(0x100)](_0x56fb7c,_0x32676e,_0xd024d,_0x4ea1f1,_0x1835e7)),_0x4ea1f1[_0x2b0f82(0x165)]['parent']=_0x4ec348,_0x4ea1f1[_0x2b0f82(0x165)][_0x2b0f82(0xe3)]=_0x21fa45;};}[_0x2490fb(0x144)](_0x11c06e,_0x280a47,_0x1f20e2,_0x262443,_0xf36062,_0x514153,_0x539362){var _0x6700f8=_0x2490fb,_0x2a6ef5=this;return _0x280a47[_0x6700f8(0x166)+_0xf36062[_0x6700f8(0x143)]()]=!0x0,function(_0x162a04){var _0x141025=_0x6700f8,_0x3bb5aa=_0x514153['node']['current'],_0x2ca892=_0x514153[_0x141025(0x165)][_0x141025(0xe3)],_0xb96520=_0x514153['node'][_0x141025(0x133)];_0x514153['node'][_0x141025(0x133)]=_0x3bb5aa,_0x514153[_0x141025(0x165)]['index']=_0x162a04,_0x11c06e[_0x141025(0xb1)](_0x2a6ef5[_0x141025(0x100)](_0x1f20e2,_0x262443,_0xf36062,_0x514153,_0x539362)),_0x514153[_0x141025(0x165)][_0x141025(0x133)]=_0xb96520,_0x514153[_0x141025(0x165)]['index']=_0x2ca892;};}[_0x2490fb(0x100)](_0x50b8e4,_0x3d6bb8,_0x5b0a4f,_0x1739c6,_0x37bee5){var _0x54efcd=_0x2490fb,_0x4b7967=this;_0x37bee5||(_0x37bee5=function(_0x189d9a,_0x10e316){return _0x189d9a[_0x10e316];});var _0x1cb0a1=_0x5b0a4f[_0x54efcd(0x143)](),_0x87863e=_0x1739c6['expressionsToEvaluate']||{},_0xc84910=_0x1739c6['depth'],_0x15830a=_0x1739c6[_0x54efcd(0x141)];try{var _0xd12930=this[_0x54efcd(0x168)](_0x50b8e4),_0x4e45a1=_0x1cb0a1;_0xd12930&&_0x4e45a1[0x0]==='\\x27'&&(_0x4e45a1=_0x4e45a1['substr'](0x1,_0x4e45a1['length']-0x2));var _0x3fc945=_0x1739c6[_0x54efcd(0xfa)]=_0x87863e[_0x54efcd(0x166)+_0x4e45a1];_0x3fc945&&(_0x1739c6[_0x54efcd(0xfc)]=_0x1739c6['depth']+0x1),_0x1739c6[_0x54efcd(0x141)]=!!_0x3fc945;var _0x58eeb5=typeof _0x5b0a4f==_0x54efcd(0x11f),_0x4859e4={'name':_0x58eeb5||_0xd12930?_0x1cb0a1:this[_0x54efcd(0x173)](_0x1cb0a1)};if(_0x58eeb5&&(_0x4859e4['symbol']=!0x0),!(_0x3d6bb8==='array'||_0x3d6bb8===_0x54efcd(0xc3))){var _0x2944a5=this[_0x54efcd(0xdc)](_0x50b8e4,_0x5b0a4f);if(_0x2944a5&&(_0x2944a5['set']&&(_0x4859e4[_0x54efcd(0x128)]=!0x0),_0x2944a5[_0x54efcd(0x15e)]&&!_0x3fc945&&!_0x1739c6[_0x54efcd(0xe6)]))return _0x4859e4[_0x54efcd(0xb8)]=!0x0,this[_0x54efcd(0xfe)](_0x4859e4,_0x1739c6),_0x4859e4;}var _0x178951;try{_0x178951=_0x37bee5(_0x50b8e4,_0x5b0a4f);}catch(_0x2494b2){return _0x4859e4={'name':_0x1cb0a1,'type':_0x54efcd(0x180),'error':_0x2494b2[_0x54efcd(0xf1)]},this[_0x54efcd(0xfe)](_0x4859e4,_0x1739c6),_0x4859e4;}var _0x1ee223=this[_0x54efcd(0xd2)](_0x178951),_0x1c67cf=this[_0x54efcd(0xd1)](_0x1ee223);if(_0x4859e4[_0x54efcd(0xe5)]=_0x1ee223,_0x1c67cf)this[_0x54efcd(0xfe)](_0x4859e4,_0x1739c6,_0x178951,function(){var _0x156b2c=_0x54efcd;_0x4859e4[_0x156b2c(0x14b)]=_0x178951[_0x156b2c(0xd8)](),!_0x3fc945&&_0x4b7967[_0x156b2c(0xe0)](_0x1ee223,_0x4859e4,_0x1739c6,{});});else{var _0x28b8af=_0x1739c6[_0x54efcd(0xea)]&&_0x1739c6[_0x54efcd(0xcb)]<_0x1739c6['autoExpandMaxDepth']&&_0x1739c6[_0x54efcd(0x129)][_0x54efcd(0x122)](_0x178951)<0x0&&_0x1ee223!==_0x54efcd(0x161)&&_0x1739c6[_0x54efcd(0x159)]<_0x1739c6[_0x54efcd(0xc2)];_0x28b8af||_0x1739c6[_0x54efcd(0xcb)]<_0xc84910||_0x3fc945?(this['serialize'](_0x4859e4,_0x178951,_0x1739c6,_0x3fc945||{}),this[_0x54efcd(0xf8)](_0x178951,_0x4859e4)):this[_0x54efcd(0xfe)](_0x4859e4,_0x1739c6,_0x178951,function(){var _0x5c9e40=_0x54efcd;_0x1ee223===_0x5c9e40(0x148)||_0x1ee223===_0x5c9e40(0x9c)||(delete _0x4859e4[_0x5c9e40(0x14b)],_0x4859e4[_0x5c9e40(0xb9)]=!0x0);});}return _0x4859e4;}finally{_0x1739c6[_0x54efcd(0xfa)]=_0x87863e,_0x1739c6[_0x54efcd(0xfc)]=_0xc84910,_0x1739c6['isExpressionToEvaluate']=_0x15830a;}}[_0x2490fb(0xe0)](_0x197a4b,_0x2f227b,_0x55f2ad,_0x63907d){var _0x1e2037=_0x2490fb,_0x5d48fe=_0x63907d['strLength']||_0x55f2ad[_0x1e2037(0xa8)];if((_0x197a4b===_0x1e2037(0xba)||_0x197a4b===_0x1e2037(0xe1))&&_0x2f227b[_0x1e2037(0x14b)]){let _0x5a30b9=_0x2f227b[_0x1e2037(0x14b)][_0x1e2037(0x154)];_0x55f2ad[_0x1e2037(0xf6)]+=_0x5a30b9,_0x55f2ad[_0x1e2037(0xf6)]>_0x55f2ad[_0x1e2037(0x115)]?(_0x2f227b[_0x1e2037(0xb9)]='',delete _0x2f227b[_0x1e2037(0x14b)]):_0x5a30b9>_0x5d48fe&&(_0x2f227b[_0x1e2037(0xb9)]=_0x2f227b[_0x1e2037(0x14b)][_0x1e2037(0x109)](0x0,_0x5d48fe),delete _0x2f227b[_0x1e2037(0x14b)]);}}[_0x2490fb(0x168)](_0x4ccbaf){var _0x385215=_0x2490fb;return!!(_0x4ccbaf&&_0x51f866[_0x385215(0xd6)]&&this[_0x385215(0x107)](_0x4ccbaf)===_0x385215(0x11d)&&_0x4ccbaf[_0x385215(0x157)]);}[_0x2490fb(0x173)](_0x3ba4cb){var _0x39ad92=_0x2490fb;if(_0x3ba4cb[_0x39ad92(0xdd)](/^\\d+$/))return _0x3ba4cb;var _0x34349e;try{_0x34349e=JSON[_0x39ad92(0x97)](''+_0x3ba4cb);}catch{_0x34349e='\\x22'+this[_0x39ad92(0x107)](_0x3ba4cb)+'\\x22';}return _0x34349e[_0x39ad92(0xdd)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x34349e=_0x34349e['substr'](0x1,_0x34349e['length']-0x2):_0x34349e=_0x34349e[_0x39ad92(0x131)](/'/g,'\\x5c\\x27')[_0x39ad92(0x131)](/\\\\\"/g,'\\x22')[_0x39ad92(0x131)](/(^\"|\"$)/g,'\\x27'),_0x34349e;}[_0x2490fb(0xfe)](_0x323a0c,_0x491bf1,_0x601a79,_0x3a9c78){var _0x42852c=_0x2490fb;this[_0x42852c(0xf7)](_0x323a0c,_0x491bf1),_0x3a9c78&&_0x3a9c78(),this['_additionalMetadata'](_0x601a79,_0x323a0c),this[_0x42852c(0x13d)](_0x323a0c,_0x491bf1);}['_treeNodePropertiesBeforeFullValue'](_0x45c3ba,_0x193f5e){var _0x590e53=_0x2490fb;this[_0x590e53(0x181)](_0x45c3ba,_0x193f5e),this[_0x590e53(0xbc)](_0x45c3ba,_0x193f5e),this[_0x590e53(0x177)](_0x45c3ba,_0x193f5e),this[_0x590e53(0xa5)](_0x45c3ba,_0x193f5e);}['_setNodeId'](_0xafdd1d,_0x54552f){}['_setNodeQueryPath'](_0x1d77f9,_0x584e98){}[_0x2490fb(0xcf)](_0x5afc52,_0x2cc6bd){}[_0x2490fb(0x111)](_0x538264){var _0x388a64=_0x2490fb;return _0x538264===this[_0x388a64(0x152)];}[_0x2490fb(0x13d)](_0x3d24c7,_0x4c810c){var _0xbab7dd=_0x2490fb;this['_setNodeLabel'](_0x3d24c7,_0x4c810c),this[_0xbab7dd(0x130)](_0x3d24c7),_0x4c810c[_0xbab7dd(0x13f)]&&this['_sortProps'](_0x3d24c7),this[_0xbab7dd(0x17d)](_0x3d24c7,_0x4c810c),this[_0xbab7dd(0x14d)](_0x3d24c7,_0x4c810c),this['_cleanNode'](_0x3d24c7);}['_additionalMetadata'](_0x1a3cdc,_0x5817e9){var _0x2136c5=_0x2490fb;let _0x8bf862;try{_0x51f866[_0x2136c5(0x16d)]&&(_0x8bf862=_0x51f866[_0x2136c5(0x16d)][_0x2136c5(0xab)],_0x51f866[_0x2136c5(0x16d)][_0x2136c5(0xab)]=function(){}),_0x1a3cdc&&typeof _0x1a3cdc[_0x2136c5(0x154)]==_0x2136c5(0x163)&&(_0x5817e9[_0x2136c5(0x154)]=_0x1a3cdc[_0x2136c5(0x154)]);}catch{}finally{_0x8bf862&&(_0x51f866['console'][_0x2136c5(0xab)]=_0x8bf862);}if(_0x5817e9[_0x2136c5(0xe5)]===_0x2136c5(0x163)||_0x5817e9[_0x2136c5(0xe5)]===_0x2136c5(0x136)){if(isNaN(_0x5817e9[_0x2136c5(0x14b)]))_0x5817e9[_0x2136c5(0xf3)]=!0x0,delete _0x5817e9[_0x2136c5(0x14b)];else switch(_0x5817e9[_0x2136c5(0x14b)]){case Number[_0x2136c5(0xa6)]:_0x5817e9[_0x2136c5(0x16f)]=!0x0,delete _0x5817e9[_0x2136c5(0x14b)];break;case Number[_0x2136c5(0xaa)]:_0x5817e9[_0x2136c5(0x12d)]=!0x0,delete _0x5817e9['value'];break;case 0x0:this[_0x2136c5(0xcd)](_0x5817e9[_0x2136c5(0x14b)])&&(_0x5817e9[_0x2136c5(0x17c)]=!0x0);break;}}else _0x5817e9[_0x2136c5(0xe5)]==='function'&&typeof _0x1a3cdc[_0x2136c5(0x11a)]==_0x2136c5(0xba)&&_0x1a3cdc['name']&&_0x5817e9[_0x2136c5(0x11a)]&&_0x1a3cdc['name']!==_0x5817e9[_0x2136c5(0x11a)]&&(_0x5817e9[_0x2136c5(0xb3)]=_0x1a3cdc[_0x2136c5(0x11a)]);}[_0x2490fb(0xcd)](_0x54b21d){var _0x155e1a=_0x2490fb;return 0x1/_0x54b21d===Number[_0x155e1a(0xaa)];}[_0x2490fb(0x121)](_0x20b182){var _0x4506f7=_0x2490fb;!_0x20b182['props']||!_0x20b182[_0x4506f7(0x123)][_0x4506f7(0x154)]||_0x20b182[_0x4506f7(0xe5)]===_0x4506f7(0x110)||_0x20b182[_0x4506f7(0xe5)]===_0x4506f7(0xd6)||_0x20b182[_0x4506f7(0xe5)]===_0x4506f7(0x17b)||_0x20b182[_0x4506f7(0x123)][_0x4506f7(0x13e)](function(_0xcae753,_0x11cc49){var _0x514066=_0x4506f7,_0x35b7e1=_0xcae753[_0x514066(0x11a)][_0x514066(0xc5)](),_0x4784c2=_0x11cc49[_0x514066(0x11a)][_0x514066(0xc5)]();return _0x35b7e1<_0x4784c2?-0x1:_0x35b7e1>_0x4784c2?0x1:0x0;});}[_0x2490fb(0x17d)](_0x49a81d,_0x5c7e06){var _0x180650=_0x2490fb;if(!(_0x5c7e06[_0x180650(0x15d)]||!_0x49a81d['props']||!_0x49a81d[_0x180650(0x123)][_0x180650(0x154)])){for(var _0x4a49e5=[],_0x7cac60=[],_0x3f72be=0x0,_0x5d429b=_0x49a81d[_0x180650(0x123)][_0x180650(0x154)];_0x3f72be<_0x5d429b;_0x3f72be++){var _0x12d0af=_0x49a81d[_0x180650(0x123)][_0x3f72be];_0x12d0af[_0x180650(0xe5)]===_0x180650(0x161)?_0x4a49e5[_0x180650(0xb1)](_0x12d0af):_0x7cac60[_0x180650(0xb1)](_0x12d0af);}if(!(!_0x7cac60[_0x180650(0x154)]||_0x4a49e5[_0x180650(0x154)]<=0x1)){_0x49a81d['props']=_0x7cac60;var _0x546342={'functionsNode':!0x0,'props':_0x4a49e5};this[_0x180650(0x181)](_0x546342,_0x5c7e06),this['_setNodeLabel'](_0x546342,_0x5c7e06),this[_0x180650(0x130)](_0x546342),this[_0x180650(0xa5)](_0x546342,_0x5c7e06),_0x546342['id']+='\\x20f',_0x49a81d[_0x180650(0x123)][_0x180650(0xa7)](_0x546342);}}}['_addLoadNode'](_0x21b503,_0x12010f){}['_setNodeExpandableState'](_0x5c2699){}[_0x2490fb(0x167)](_0x181278){var _0x2a4ee1=_0x2490fb;return Array['isArray'](_0x181278)||typeof _0x181278==_0x2a4ee1(0x145)&&this['_objectToString'](_0x181278)==='[object\\x20Array]';}[_0x2490fb(0xa5)](_0xd85523,_0x5587cf){}[_0x2490fb(0xae)](_0x9fc0ab){var _0xbc0703=_0x2490fb;delete _0x9fc0ab[_0xbc0703(0xc1)],delete _0x9fc0ab['_hasSetOnItsPath'],delete _0x9fc0ab['_hasMapOnItsPath'];}[_0x2490fb(0x177)](_0x3153b7,_0x3c210f){}}let _0x43a721=new _0x4b0781(),_0x145ab5={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x51630b={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2};function _0x44b635(_0x38432b,_0x4e3474,_0x594f5b,_0x281139,_0x5d8c23,_0x3f9001){var _0x490496=_0x2490fb;let _0x5ef4a6,_0x49b413;try{_0x49b413=_0x4aaca5(),_0x5ef4a6=_0x531f55[_0x4e3474],!_0x5ef4a6||_0x49b413-_0x5ef4a6['ts']>0x1f4&&_0x5ef4a6['count']&&_0x5ef4a6['time']/_0x5ef4a6[_0x490496(0x13b)]<0x64?(_0x531f55[_0x4e3474]=_0x5ef4a6={'count':0x0,'time':0x0,'ts':_0x49b413},_0x531f55[_0x490496(0xbe)]={}):_0x49b413-_0x531f55[_0x490496(0xbe)]['ts']>0x32&&_0x531f55[_0x490496(0xbe)]['count']&&_0x531f55[_0x490496(0xbe)][_0x490496(0x101)]/_0x531f55['hits']['count']<0x64&&(_0x531f55[_0x490496(0xbe)]={});let _0x3a22bf=[],_0xac8ad8=_0x5ef4a6['reduceLimits']||_0x531f55[_0x490496(0xbe)][_0x490496(0x12c)]?_0x51630b:_0x145ab5,_0x12acd2=_0x153089=>{var _0x336f38=_0x490496;let _0x1e80eb={};return _0x1e80eb['props']=_0x153089[_0x336f38(0x123)],_0x1e80eb[_0x336f38(0x104)]=_0x153089[_0x336f38(0x104)],_0x1e80eb[_0x336f38(0xa8)]=_0x153089['strLength'],_0x1e80eb[_0x336f38(0x115)]=_0x153089[_0x336f38(0x115)],_0x1e80eb[_0x336f38(0xc2)]=_0x153089[_0x336f38(0xc2)],_0x1e80eb[_0x336f38(0x9b)]=_0x153089[_0x336f38(0x9b)],_0x1e80eb[_0x336f38(0x13f)]=!0x1,_0x1e80eb[_0x336f38(0x15d)]=!_0x545a00,_0x1e80eb[_0x336f38(0xfc)]=0x1,_0x1e80eb['level']=0x0,_0x1e80eb[_0x336f38(0xee)]=_0x336f38(0x16e),_0x1e80eb[_0x336f38(0xfb)]=_0x336f38(0x119),_0x1e80eb[_0x336f38(0xea)]=!0x0,_0x1e80eb['autoExpandPreviousObjects']=[],_0x1e80eb[_0x336f38(0x159)]=0x0,_0x1e80eb['resolveGetters']=!0x0,_0x1e80eb[_0x336f38(0xf6)]=0x0,_0x1e80eb['node']={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x1e80eb;};for(var _0x38bef9=0x0;_0x38bef9<_0x5d8c23[_0x490496(0x154)];_0x38bef9++)_0x3a22bf[_0x490496(0xb1)](_0x43a721[_0x490496(0x182)]({'timeNode':_0x38432b===_0x490496(0x101)||void 0x0},_0x5d8c23[_0x38bef9],_0x12acd2(_0xac8ad8),{}));if(_0x38432b===_0x490496(0x114)){let _0x53423b=Error[_0x490496(0xbd)];try{Error[_0x490496(0xbd)]=0x1/0x0,_0x3a22bf[_0x490496(0xb1)](_0x43a721[_0x490496(0x182)]({'stackNode':!0x0},new Error()['stack'],_0x12acd2(_0xac8ad8),{'strLength':0x1/0x0}));}finally{Error['stackTraceLimit']=_0x53423b;}}return{'method':_0x490496(0x9d),'version':_0xae6f66,'args':[{'ts':_0x594f5b,'session':_0x281139,'args':_0x3a22bf,'id':_0x4e3474,'context':_0x3f9001}]};}catch(_0x4ecb16){return{'method':'log','version':_0xae6f66,'args':[{'ts':_0x594f5b,'session':_0x281139,'args':[{'type':_0x490496(0x180),'error':_0x4ecb16&&_0x4ecb16['message']}],'id':_0x4e3474,'context':_0x3f9001}]};}finally{try{if(_0x5ef4a6&&_0x49b413){let _0x5add8f=_0x4aaca5();_0x5ef4a6[_0x490496(0x13b)]++,_0x5ef4a6['time']+=_0x7957ea(_0x49b413,_0x5add8f),_0x5ef4a6['ts']=_0x5add8f,_0x531f55[_0x490496(0xbe)][_0x490496(0x13b)]++,_0x531f55[_0x490496(0xbe)][_0x490496(0x101)]+=_0x7957ea(_0x49b413,_0x5add8f),_0x531f55[_0x490496(0xbe)]['ts']=_0x5add8f,(_0x5ef4a6[_0x490496(0x13b)]>0x32||_0x5ef4a6[_0x490496(0x101)]>0x64)&&(_0x5ef4a6['reduceLimits']=!0x0),(_0x531f55[_0x490496(0xbe)][_0x490496(0x13b)]>0x3e8||_0x531f55[_0x490496(0xbe)][_0x490496(0x101)]>0x12c)&&(_0x531f55[_0x490496(0xbe)][_0x490496(0x12c)]=!0x0);}}catch{}}}return _0x44b635;}((_0x504934,_0x11bd83,_0x36b2ae,_0x43d130,_0x4e2048,_0x157adc,_0x1227e6,_0x1478a1,_0x45177c,_0xce98f0)=>{var _0x4bdb93=_0xbab866;if(_0x504934[_0x4bdb93(0x10d)])return _0x504934[_0x4bdb93(0x10d)];if(!J(_0x504934,_0x1478a1,_0x4e2048))return _0x504934[_0x4bdb93(0x10d)]={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'coverage':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x504934[_0x4bdb93(0x10d)];let _0x54e8b5=W(_0x504934),_0x279c61=_0x54e8b5[_0x4bdb93(0x184)],_0x2692e6=_0x54e8b5[_0x4bdb93(0x127)],_0x518944=_0x54e8b5['now'],_0x1fe75a={'hits':{},'ts':{}},_0x1fb74d=Y(_0x504934,_0x45177c,_0x1fe75a,_0x157adc),_0x4fe032=_0x3d1682=>{_0x1fe75a['ts'][_0x3d1682]=_0x2692e6();},_0x1332b6=(_0x1fcde9,_0x5a3d0c)=>{var _0x5b2355=_0x4bdb93;let _0x1d09f8=_0x1fe75a['ts'][_0x5a3d0c];if(delete _0x1fe75a['ts'][_0x5a3d0c],_0x1d09f8){let _0x5760fc=_0x279c61(_0x1d09f8,_0x2692e6());_0x1ecc92(_0x1fb74d(_0x5b2355(0x101),_0x1fcde9,_0x518944(),_0xf90250,[_0x5760fc],_0x5a3d0c));}},_0x3591eb=_0x532e85=>_0x9290cc=>{var _0xeeec6d=_0x4bdb93;try{_0x4fe032(_0x9290cc),_0x532e85(_0x9290cc);}finally{_0x504934[_0xeeec6d(0x16d)][_0xeeec6d(0x101)]=_0x532e85;}},_0x322c36=_0x5b827c=>_0x4d9cdb=>{var _0x37e5c0=_0x4bdb93;try{let [_0x19c9e2,_0x59a2a5]=_0x4d9cdb[_0x37e5c0(0xf4)](_0x37e5c0(0xff));_0x1332b6(_0x59a2a5,_0x19c9e2),_0x5b827c(_0x19c9e2);}finally{_0x504934[_0x37e5c0(0x16d)][_0x37e5c0(0x113)]=_0x5b827c;}};_0x504934[_0x4bdb93(0x10d)]={'consoleLog':(_0x105105,_0x499941)=>{var _0x329c78=_0x4bdb93;_0x504934[_0x329c78(0x16d)]['log']['name']!==_0x329c78(0xc6)&&_0x1ecc92(_0x1fb74d('log',_0x105105,_0x518944(),_0xf90250,_0x499941));},'consoleTrace':(_0x4ef40d,_0xc6cb46)=>{var _0x1554b8=_0x4bdb93;_0x504934[_0x1554b8(0x16d)][_0x1554b8(0x9d)][_0x1554b8(0x11a)]!==_0x1554b8(0x153)&&_0x1ecc92(_0x1fb74d(_0x1554b8(0x114),_0x4ef40d,_0x518944(),_0xf90250,_0xc6cb46));},'consoleTime':()=>{var _0x10885d=_0x4bdb93;_0x504934[_0x10885d(0x16d)]['time']=_0x3591eb(_0x504934[_0x10885d(0x16d)][_0x10885d(0x101)]);},'consoleTimeEnd':()=>{var _0x326003=_0x4bdb93;_0x504934[_0x326003(0x16d)]['timeEnd']=_0x322c36(_0x504934['console'][_0x326003(0x113)]);},'autoLog':(_0x31d177,_0x5e48ec)=>{var _0x147b6d=_0x4bdb93;_0x1ecc92(_0x1fb74d(_0x147b6d(0x9d),_0x5e48ec,_0x518944(),_0xf90250,[_0x31d177]));},'autoLogMany':(_0x323c85,_0x15fa57)=>{_0x1ecc92(_0x1fb74d('log',_0x323c85,_0x518944(),_0xf90250,_0x15fa57));},'autoTrace':(_0xad245a,_0x1ad852)=>{var _0x3f7f7f=_0x4bdb93;_0x1ecc92(_0x1fb74d(_0x3f7f7f(0x114),_0x1ad852,_0x518944(),_0xf90250,[_0xad245a]));},'autoTraceMany':(_0x268997,_0x2a5f30)=>{_0x1ecc92(_0x1fb74d('trace',_0x268997,_0x518944(),_0xf90250,_0x2a5f30));},'autoTime':(_0x1e632a,_0x2572f8,_0x2fc6c7)=>{_0x4fe032(_0x2fc6c7);},'autoTimeEnd':(_0x5203d7,_0x4e3365,_0x5f205f)=>{_0x1332b6(_0x4e3365,_0x5f205f);},'coverage':_0xcfafc3=>{_0x1ecc92({'method':'coverage','version':_0x157adc,'args':[{'id':_0xcfafc3}]});}};let _0x1ecc92=b(_0x504934,_0x11bd83,_0x36b2ae,_0x43d130,_0x4e2048,_0xce98f0),_0xf90250=_0x504934[_0x4bdb93(0x155)];return _0x504934['_console_ninja'];})(globalThis,_0xbab866(0x15a),_0xbab866(0x16b),_0xbab866(0x156),_0xbab866(0xc4),_0xbab866(0x125),_0xbab866(0x98),_0xbab866(0x13a),_0xbab866(0x10e),_0xbab866(0xec));");}catch(e){}};/* istanbul ignore next */function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};/* istanbul ignore next */function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint unicorn/no-abusive-eslint-disable:,eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
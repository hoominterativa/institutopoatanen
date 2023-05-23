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
        /* eslint-disable */console.log(...oo_oo(`414fca7f_0`,'cancelled'));
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
                /* eslint-disable */console.log(...oo_oo(`414fca7f_1`,'Desactivate: preserve aspect ratio'));
                self.draggable.bounderies = self.originalBounderies;
                shiftKeyTriggered = false;
            }
                
            if(!shiftKeyTriggered && e.shiftKey  && !resizable.preserveAspectRatio){
                /* eslint-disable */console.log(...oo_oo(`414fca7f_2`,'Activate: preserve aspect ratio'));
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
/* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x3247c9=_0x274b;function _0x4361(){var _0x1edee4=['9830183TfijKN','count','Map','capped','node','Symbol','funcName','performance','strLength','boolean','console','_consoleNinjaAllowedToStart','send','_isPrimitiveType','_undefined','toLowerCase','hrtime','2222712fHMEuN','parse','_connectToHostNow','_isArray','_console_ninja_session','replace','data','1746vkwAjO','getOwnPropertyDescriptor','defineProperty','totalStrLength','_property','_additionalMetadata','1684866792264','reduceLimits','type','Number','isExpressionToEvaluate','_setNodeExpressionPath','default','Buffer','onclose','_ws','_propertyName','_setNodeLabel','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','_capIfString','127.0.0.1','_HTMLAllCollection','_addLoadNode','nodeModules','autoExpandMaxDepth','host','stack','autoExpandPreviousObjects','function','_setNodeQueryPath','number','valueOf','_getOwnPropertySymbols','readyState','sort','_socket','autoExpandLimit','62516','\\x20browser','noFunctions','_setNodeId','_console_ninja','hasOwnProperty','onopen','now','getter','1303799iPPDXq','getOwnPropertyNames','','1639732UHFAic','symbol','allStrLength','hits','string','null','test','negativeZero','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help','map','elements','port','close','value','_treeNodePropertiesBeforeFullValue','failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','undefined','length','positiveInfinity',':logPointId:','toString','[object\\x20Array]','reload','index','_setNodeExpandableState','1382KPDgVA','_setNodePermissions','substr','elapsed','_treeNodePropertiesAfterFullValue','_addProperty','pop','webpack','constructor','split','_maxConnectAttemptCount','_type','method','_quotedRegExp','time','_propertyAccessor','push','_numberRegExp','prototype','_keyStrRegExp','join','disabledTrace','serialize','trace','timeEnd','_connecting','[object\\x20Map]','_cleanNode','_p_','_attemptToReconnectShortly','rootExpression','then','cappedProps','3HuBsuf','12wfPfnL','logger\\x20websocket\\x20error','unshift','onerror','[object\\x20Set]','_WebSocket','autoExpand',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"DESKTOP-GDLJ9TC\",\"192.168.1.6\"],'depth','_allowedToSend','_disposeWebsocket','location',\"c:\\\\Users\\\\benvi\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-0.0.123\\\\node_modules\",'_getOwnPropertyNames','670jojEbP','_sendErrorMessage','[object\\x20Date]','_processTreeNodeResult','unknown','_addFunctionsNode','_allowedToConnectOnSend','getOwnPropertySymbols','level','_inBrowser','hostname','versions','\\x20server','Set','HTMLAllCollection','enumerable','array','String','_Symbol','global','...','_connected','_isMap','warn','35451aXQHoa','concat','isArray','_hasMapOnItsPath','negativeInfinity','_addObjectProperty','getWebSocketClass','object','path','_connectAttemptCount','process','NEGATIVE_INFINITY','_p_length','_objectToString','stackTraceLimit','_blacklistedProperty','Boolean','_reconnectTimeout','parent','call','stringify','_dateToString','log','remix','_getOwnPropertyDescriptor','_regExpToString','_isNegativeZero','name','current','match','_WebSocketClass','props','unref','timeStamp','_sortProps','resolveGetters','slice','expId','2225eaOkQF','get','670PSfgIX','date','_isPrimitiveWrapperType','message','1.0.0','bigint','forEach','root_exp','setter','autoExpandPropertyCount','WebSocket','catch','expressionsToEvaluate'];_0x4361=function(){return _0x1edee4;};return _0x4361();}(function(_0x18fa7c,_0x28d7ad){var _0x396914=_0x274b,_0x590450=_0x18fa7c();while(!![]){try{var _0x295edf=-parseInt(_0x396914(0xda))/0x1*(parseInt(_0x396914(0x6a))/0x2)+-parseInt(_0x396914(0x8b))/0x3*(-parseInt(_0x396914(0x130))/0x4)+parseInt(_0x396914(0xd8))/0x5*(parseInt(_0x396914(0xff))/0x6)+-parseInt(_0x396914(0x12d))/0x7+-parseInt(_0x396914(0xf8))/0x8+-parseInt(_0x396914(0xb2))/0x9*(parseInt(_0x396914(0x9a))/0xa)+-parseInt(_0x396914(0xe7))/0xb*(-parseInt(_0x396914(0x8c))/0xc);if(_0x295edf===_0x28d7ad)break;else _0x590450['push'](_0x590450['shift']());}catch(_0x3fa34b){_0x590450['push'](_0x590450['shift']());}}}(_0x4361,0x3b1b6));var ue=Object['create'],te=Object[_0x3247c9(0x101)],he=Object['getOwnPropertyDescriptor'],le=Object[_0x3247c9(0x12e)],fe=Object['getPrototypeOf'],_e=Object['prototype'][_0x3247c9(0x129)],pe=(_0xd616bf,_0x562668,_0x3467fb,_0x2cd45e)=>{var _0x44a756=_0x3247c9;if(_0x562668&&typeof _0x562668==_0x44a756(0xb9)||typeof _0x562668==_0x44a756(0x11b)){for(let _0x301000 of le(_0x562668))!_e[_0x44a756(0xc5)](_0xd616bf,_0x301000)&&_0x301000!==_0x3467fb&&te(_0xd616bf,_0x301000,{'get':()=>_0x562668[_0x301000],'enumerable':!(_0x2cd45e=he(_0x562668,_0x301000))||_0x2cd45e[_0x44a756(0xa9)]});}return _0xd616bf;},ne=(_0x35280e,_0x2c48c8,_0x9dd9c9)=>(_0x9dd9c9=_0x35280e!=null?ue(fe(_0x35280e)):{},pe(_0x2c48c8||!_0x35280e||!_0x35280e['__es'+'Module']?te(_0x9dd9c9,_0x3247c9(0x10b),{'value':_0x35280e,'enumerable':!0x0}):_0x9dd9c9,_0x35280e)),Q=class{constructor(_0x17dd7b,_0xae8986,_0x42bcd2,_0x4c648b){var _0xb8b0cc=_0x3247c9;this[_0xb8b0cc(0xad)]=_0x17dd7b,this[_0xb8b0cc(0x118)]=_0xae8986,this[_0xb8b0cc(0x13b)]=_0x42bcd2,this[_0xb8b0cc(0x116)]=_0x4c648b,this['_allowedToSend']=!0x0,this[_0xb8b0cc(0xa0)]=!0x0,this['_connected']=!0x1,this['_connecting']=!0x1,this[_0xb8b0cc(0xa3)]=!!this[_0xb8b0cc(0xad)][_0xb8b0cc(0xe4)],this['_WebSocketClass']=null,this[_0xb8b0cc(0xbb)]=0x0,this[_0xb8b0cc(0x74)]=0x14,this[_0xb8b0cc(0x9b)]=this['_inBrowser']?_0xb8b0cc(0x138):'Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help';}async[_0x3247c9(0xb8)](){var _0x3f07ea=_0x3247c9;if(this[_0x3f07ea(0xd0)])return this[_0x3f07ea(0xd0)];let _0x290779;if(this['_inBrowser'])_0x290779=this[_0x3f07ea(0xad)][_0x3f07ea(0xe4)];else{if(this[_0x3f07ea(0xad)][_0x3f07ea(0xbc)]?.[_0x3f07ea(0x91)])_0x290779=this['global'][_0x3f07ea(0xbc)]?.[_0x3f07ea(0x91)];else try{let _0x4a9576=await import(_0x3f07ea(0xba));_0x290779=(await import((await import('url'))['pathToFileURL'](_0x4a9576[_0x3f07ea(0x7e)](this[_0x3f07ea(0x116)],'ws/index.js'))[_0x3f07ea(0x144)]()))[_0x3f07ea(0x10b)];}catch{try{_0x290779=require(require(_0x3f07ea(0xba))[_0x3f07ea(0x7e)](this[_0x3f07ea(0x116)],'ws'));}catch{throw new Error(_0x3f07ea(0x13f));}}}return this['_WebSocketClass']=_0x290779,_0x290779;}[_0x3247c9(0xfa)](){var _0x54a58c=_0x3247c9;this[_0x54a58c(0x83)]||this[_0x54a58c(0xaf)]||this['_connectAttemptCount']>=this[_0x54a58c(0x74)]||(this[_0x54a58c(0xa0)]=!0x1,this[_0x54a58c(0x83)]=!0x0,this[_0x54a58c(0xbb)]++,this[_0x54a58c(0x10e)]=new Promise((_0x591ff6,_0x24a736)=>{var _0x41d334=_0x54a58c;this[_0x41d334(0xb8)]()[_0x41d334(0x89)](_0x2db479=>{var _0x56ac37=_0x41d334;let _0x533192=new _0x2db479('ws://'+this[_0x56ac37(0x118)]+':'+this[_0x56ac37(0x13b)]);_0x533192['onerror']=()=>{var _0x3c6b25=_0x56ac37;this[_0x3c6b25(0x95)]=!0x1,this[_0x3c6b25(0x96)](_0x533192),this['_attemptToReconnectShortly'](),_0x24a736(new Error(_0x3c6b25(0x8d)));},_0x533192[_0x56ac37(0x12a)]=()=>{var _0x3810e3=_0x56ac37;this[_0x3810e3(0xa3)]||_0x533192[_0x3810e3(0x122)]&&_0x533192[_0x3810e3(0x122)][_0x3810e3(0xd2)]&&_0x533192[_0x3810e3(0x122)][_0x3810e3(0xd2)](),_0x591ff6(_0x533192);},_0x533192['onclose']=()=>{var _0x31afe2=_0x56ac37;this[_0x31afe2(0xa0)]=!0x0,this['_disposeWebsocket'](_0x533192),this[_0x31afe2(0x87)]();},_0x533192['onmessage']=_0x1fac86=>{var _0x52c71c=_0x56ac37;try{_0x1fac86&&_0x1fac86[_0x52c71c(0xfe)]&&this[_0x52c71c(0xa3)]&&JSON[_0x52c71c(0xf9)](_0x1fac86[_0x52c71c(0xfe)])[_0x52c71c(0x76)]===_0x52c71c(0x146)&&this['global'][_0x52c71c(0x97)][_0x52c71c(0x146)]();}catch{}};})[_0x41d334(0x89)](_0x40b51d=>(this[_0x41d334(0xaf)]=!0x0,this[_0x41d334(0x83)]=!0x1,this[_0x41d334(0xa0)]=!0x1,this['_allowedToSend']=!0x0,this['_connectAttemptCount']=0x0,_0x40b51d))[_0x41d334(0xe5)](_0x5e9cea=>(this['_connected']=!0x1,this[_0x41d334(0x83)]=!0x1,_0x24a736(new Error('failed\\x20to\\x20connect\\x20to\\x20host:\\x20'+(_0x5e9cea&&_0x5e9cea['message'])))));}));}[_0x3247c9(0x96)](_0x2c4ee7){var _0x5bfff5=_0x3247c9;this[_0x5bfff5(0xaf)]=!0x1,this[_0x5bfff5(0x83)]=!0x1;try{_0x2c4ee7[_0x5bfff5(0x10d)]=null,_0x2c4ee7[_0x5bfff5(0x8f)]=null,_0x2c4ee7[_0x5bfff5(0x12a)]=null;}catch{}try{_0x2c4ee7[_0x5bfff5(0x120)]<0x2&&_0x2c4ee7[_0x5bfff5(0x13c)]();}catch{}}['_attemptToReconnectShortly'](){var _0x3dcd73=_0x3247c9;clearTimeout(this[_0x3dcd73(0xc3)]),!(this[_0x3dcd73(0xbb)]>=this[_0x3dcd73(0x74)])&&(this['_reconnectTimeout']=setTimeout(()=>{var _0x1ebde5=_0x3dcd73;this['_connected']||this[_0x1ebde5(0x83)]||(this['_connectToHostNow'](),this[_0x1ebde5(0x10e)]?.[_0x1ebde5(0xe5)](()=>this[_0x1ebde5(0x87)]()));},0x1f4),this['_reconnectTimeout'][_0x3dcd73(0xd2)]&&this[_0x3dcd73(0xc3)]['unref']());}async[_0x3247c9(0xf3)](_0x2b4f14){var _0x5cd717=_0x3247c9;try{if(!this[_0x5cd717(0x95)])return;this[_0x5cd717(0xa0)]&&this[_0x5cd717(0xfa)](),(await this[_0x5cd717(0x10e)])[_0x5cd717(0xf3)](JSON[_0x5cd717(0xc6)](_0x2b4f14));}catch(_0x4bdf8a){console[_0x5cd717(0xb1)](this[_0x5cd717(0x9b)]+':\\x20'+(_0x4bdf8a&&_0x4bdf8a[_0x5cd717(0xdd)])),this[_0x5cd717(0x95)]=!0x1,this[_0x5cd717(0x87)]();}}};function V(_0x449af3,_0x21f70f,_0x244327,_0x75f4c,_0x5a2287){var _0x5749f8=_0x3247c9;let _0x463e5c=_0x244327[_0x5749f8(0x73)](',')[_0x5749f8(0x139)](_0x4e93a2=>{var _0x72a523=_0x5749f8;try{_0x449af3[_0x72a523(0xfc)]||((_0x5a2287==='next.js'||_0x5a2287===_0x72a523(0xc9))&&(_0x5a2287+=_0x449af3[_0x72a523(0xbc)]?.[_0x72a523(0xa5)]?.[_0x72a523(0xeb)]?_0x72a523(0xa6):_0x72a523(0x125)),_0x449af3['_console_ninja_session']={'id':+new Date(),'tool':_0x5a2287});let _0x187cc9=new Q(_0x449af3,_0x21f70f,_0x4e93a2,_0x75f4c);return _0x187cc9[_0x72a523(0xf3)]['bind'](_0x187cc9);}catch(_0xe8c28f){return console[_0x72a523(0xb1)](_0x72a523(0x111),_0xe8c28f&&_0xe8c28f['message']),()=>{};}});return _0x2b9287=>_0x463e5c[_0x5749f8(0xe0)](_0x21b48d=>_0x21b48d(_0x2b9287));}function H(_0x4e9947){var _0x5f59e9=_0x3247c9;let _0x1323ab=function(_0xe42c56,_0x310efb){return _0x310efb-_0xe42c56;},_0x2c6fba;if(_0x4e9947[_0x5f59e9(0xee)])_0x2c6fba=function(){var _0x5ae8f0=_0x5f59e9;return _0x4e9947[_0x5ae8f0(0xee)][_0x5ae8f0(0x12b)]();};else{if(_0x4e9947[_0x5f59e9(0xbc)]&&_0x4e9947[_0x5f59e9(0xbc)]['hrtime'])_0x2c6fba=function(){var _0x3b85b4=_0x5f59e9;return _0x4e9947[_0x3b85b4(0xbc)][_0x3b85b4(0xf7)]();},_0x1323ab=function(_0x181518,_0x3c7eb8){return 0x3e8*(_0x3c7eb8[0x0]-_0x181518[0x0])+(_0x3c7eb8[0x1]-_0x181518[0x1])/0xf4240;};else try{let {performance:_0x51c1b2}=require('perf_hooks');_0x2c6fba=function(){var _0x33b87e=_0x5f59e9;return _0x51c1b2[_0x33b87e(0x12b)]();};}catch{_0x2c6fba=function(){return+new Date();};}}return{'elapsed':_0x1323ab,'timeStamp':_0x2c6fba,'now':()=>Date[_0x5f59e9(0x12b)]()};}function X(_0x3f8626,_0x2d6a4b,_0xe57d57){var _0x27b4ed=_0x3247c9;if(_0x3f8626['_consoleNinjaAllowedToStart']!==void 0x0)return _0x3f8626[_0x27b4ed(0xf2)];let _0x48676a=_0x3f8626['process']?.[_0x27b4ed(0xa5)]?.[_0x27b4ed(0xeb)];return _0x48676a&&_0xe57d57==='nuxt'?_0x3f8626[_0x27b4ed(0xf2)]=!0x1:_0x3f8626[_0x27b4ed(0xf2)]=_0x48676a||!_0x2d6a4b||_0x3f8626['location']?.['hostname']&&_0x2d6a4b['includes'](_0x3f8626[_0x27b4ed(0x97)][_0x27b4ed(0xa4)]),_0x3f8626[_0x27b4ed(0xf2)];}function _0x274b(_0x13073d,_0x36bad4){var _0x4361bb=_0x4361();return _0x274b=function(_0x274b98,_0x1673cb){_0x274b98=_0x274b98-0x6a;var _0x294bfe=_0x4361bb[_0x274b98];return _0x294bfe;},_0x274b(_0x13073d,_0x36bad4);}((_0x1bffdd,_0x558b0e,_0x5466a6,_0x152745,_0x3714c1,_0x24559b,_0x267885,_0x4d2e6d,_0x4cb0c4)=>{var _0x2bd6d2=_0x3247c9;if(_0x1bffdd[_0x2bd6d2(0x128)])return _0x1bffdd['_console_ninja'];if(!X(_0x1bffdd,_0x4d2e6d,_0x3714c1))return _0x1bffdd[_0x2bd6d2(0x128)]={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x1bffdd['_console_ninja'];let _0x50047a={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x194907={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2},_0x126240=H(_0x1bffdd),_0x52690e=_0x126240[_0x2bd6d2(0x6d)],_0x2141bc=_0x126240[_0x2bd6d2(0xd3)],_0x1956f1=_0x126240[_0x2bd6d2(0x12b)],_0x2a5382={'hits':{},'ts':{}},_0x1a0fc4=_0xb9bf62=>{_0x2a5382['ts'][_0xb9bf62]=_0x2141bc();},_0x22299a=(_0x5e0ce0,_0x2781cc)=>{var _0x33fb5b=_0x2bd6d2;let _0x46799e=_0x2a5382['ts'][_0x2781cc];if(delete _0x2a5382['ts'][_0x2781cc],_0x46799e){let _0x2aea7c=_0x52690e(_0x46799e,_0x2141bc());_0x292e9d(_0x2986bb(_0x33fb5b(0x78),_0x5e0ce0,_0x1956f1(),_0x1d0934,[_0x2aea7c],_0x2781cc));}},_0x2512e0=_0x520ed3=>_0x54d347=>{var _0x353d19=_0x2bd6d2;try{_0x1a0fc4(_0x54d347),_0x520ed3(_0x54d347);}finally{_0x1bffdd['console'][_0x353d19(0x78)]=_0x520ed3;}},_0x159c6f=_0x4322a1=>_0x1ffea4=>{var _0xc8c490=_0x2bd6d2;try{let [_0x251b47,_0x3b9caf]=_0x1ffea4[_0xc8c490(0x73)](_0xc8c490(0x143));_0x22299a(_0x3b9caf,_0x251b47),_0x4322a1(_0x251b47);}finally{_0x1bffdd[_0xc8c490(0xf1)]['timeEnd']=_0x4322a1;}};_0x1bffdd[_0x2bd6d2(0x128)]={'consoleLog':(_0x3a7918,_0x3d650d)=>{var _0x6b5e73=_0x2bd6d2;_0x1bffdd[_0x6b5e73(0xf1)]['log'][_0x6b5e73(0xcd)]!=='disabledLog'&&_0x292e9d(_0x2986bb(_0x6b5e73(0xc8),_0x3a7918,_0x1956f1(),_0x1d0934,_0x3d650d));},'consoleTrace':(_0x3e8bec,_0x305db5)=>{var _0x4d5c0b=_0x2bd6d2;_0x1bffdd['console'][_0x4d5c0b(0xc8)][_0x4d5c0b(0xcd)]!==_0x4d5c0b(0x7f)&&_0x292e9d(_0x2986bb('trace',_0x3e8bec,_0x1956f1(),_0x1d0934,_0x305db5));},'consoleTime':()=>{var _0x1a6212=_0x2bd6d2;_0x1bffdd['console'][_0x1a6212(0x78)]=_0x2512e0(_0x1bffdd[_0x1a6212(0xf1)][_0x1a6212(0x78)]);},'consoleTimeEnd':()=>{var _0x221e4f=_0x2bd6d2;_0x1bffdd[_0x221e4f(0xf1)][_0x221e4f(0x82)]=_0x159c6f(_0x1bffdd[_0x221e4f(0xf1)][_0x221e4f(0x82)]);},'autoLog':(_0x69040e,_0x2e07c5)=>{var _0x4d1fad=_0x2bd6d2;_0x292e9d(_0x2986bb(_0x4d1fad(0xc8),_0x2e07c5,_0x1956f1(),_0x1d0934,[_0x69040e]));},'autoTrace':(_0xe7bb68,_0x3ddd84)=>{var _0x3e5a97=_0x2bd6d2;_0x292e9d(_0x2986bb(_0x3e5a97(0x81),_0x3ddd84,_0x1956f1(),_0x1d0934,[_0xe7bb68]));},'autoTime':(_0x1bc6c9,_0x438ee1,_0x2608e2)=>{_0x1a0fc4(_0x2608e2);},'autoTimeEnd':(_0xeb682f,_0x448e57,_0x3e0e10)=>{_0x22299a(_0x448e57,_0x3e0e10);}};let _0x292e9d=V(_0x1bffdd,_0x558b0e,_0x5466a6,_0x152745,_0x3714c1),_0x1d0934=_0x1bffdd['_console_ninja_session'];class _0x541991{constructor(){var _0x1028f9=_0x2bd6d2;this[_0x1028f9(0x7d)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0x1028f9(0x7b)]=/^(0|[1-9][0-9]*)$/,this[_0x1028f9(0x77)]=/'([^\\\\']|\\\\')*'/,this[_0x1028f9(0xf5)]=_0x1bffdd[_0x1028f9(0x140)],this[_0x1028f9(0x114)]=_0x1bffdd[_0x1028f9(0xa8)],this[_0x1028f9(0xca)]=Object[_0x1028f9(0x100)],this[_0x1028f9(0x99)]=Object[_0x1028f9(0x12e)],this[_0x1028f9(0xac)]=_0x1bffdd[_0x1028f9(0xec)],this[_0x1028f9(0xcb)]=RegExp['prototype']['toString'],this[_0x1028f9(0xc7)]=Date[_0x1028f9(0x7c)][_0x1028f9(0x144)];}['serialize'](_0x41f264,_0x4545bc,_0x1f3e86,_0x426580){var _0x4e6b56=_0x2bd6d2,_0x51521e=this,_0x56b826=_0x1f3e86['autoExpand'];function _0x25fc0b(_0x317e95,_0x9afc94,_0x3a3a6c){var _0x4bd07c=_0x274b;_0x9afc94[_0x4bd07c(0x107)]='unknown',_0x9afc94['error']=_0x317e95[_0x4bd07c(0xdd)],_0x313e3d=_0x3a3a6c['node'][_0x4bd07c(0xce)],_0x3a3a6c[_0x4bd07c(0xeb)]['current']=_0x9afc94,_0x51521e[_0x4bd07c(0x13e)](_0x9afc94,_0x3a3a6c);}if(_0x4545bc&&_0x4545bc['argumentResolutionError'])_0x25fc0b(_0x4545bc,_0x41f264,_0x1f3e86);else try{_0x1f3e86['level']++,_0x1f3e86[_0x4e6b56(0x92)]&&_0x1f3e86[_0x4e6b56(0x11a)][_0x4e6b56(0x7a)](_0x4545bc);var _0x3711b5,_0x559c93,_0x1b521f,_0x591d04,_0x2698ab=[],_0x5e0c71=[],_0x2f5b83,_0x147a43=this[_0x4e6b56(0x75)](_0x4545bc),_0x4b17d7=_0x147a43===_0x4e6b56(0xaa),_0x33d876=!0x1,_0xbe4ab8=_0x147a43==='function',_0x20c134=this[_0x4e6b56(0xf4)](_0x147a43),_0x47ac9f=this[_0x4e6b56(0xdc)](_0x147a43),_0x4f4b03=_0x20c134||_0x47ac9f,_0x53b8c4={},_0x5422e0=0x0,_0x1737e6=!0x1,_0x313e3d,_0x28f606=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x1f3e86[_0x4e6b56(0x94)]){if(_0x4b17d7){if(_0x559c93=_0x4545bc[_0x4e6b56(0x141)],_0x559c93>_0x1f3e86[_0x4e6b56(0x13a)]){for(_0x1b521f=0x0,_0x591d04=_0x1f3e86[_0x4e6b56(0x13a)],_0x3711b5=_0x1b521f;_0x3711b5<_0x591d04;_0x3711b5++)_0x5e0c71[_0x4e6b56(0x7a)](_0x51521e[_0x4e6b56(0x6f)](_0x2698ab,_0x4545bc,_0x147a43,_0x3711b5,_0x1f3e86));_0x41f264['cappedElements']=!0x0;}else{for(_0x1b521f=0x0,_0x591d04=_0x559c93,_0x3711b5=_0x1b521f;_0x3711b5<_0x591d04;_0x3711b5++)_0x5e0c71[_0x4e6b56(0x7a)](_0x51521e[_0x4e6b56(0x6f)](_0x2698ab,_0x4545bc,_0x147a43,_0x3711b5,_0x1f3e86));}_0x1f3e86[_0x4e6b56(0xe3)]+=_0x5e0c71[_0x4e6b56(0x141)];}if(!(_0x147a43===_0x4e6b56(0x135)||_0x147a43==='undefined')&&!_0x20c134&&_0x147a43!==_0x4e6b56(0xab)&&_0x147a43!==_0x4e6b56(0x10c)&&_0x147a43!==_0x4e6b56(0xdf)){var _0x167402=_0x426580['props']||_0x1f3e86[_0x4e6b56(0xd1)];if(this['_isSet'](_0x4545bc)?(_0x3711b5=0x0,_0x4545bc[_0x4e6b56(0xe0)](function(_0x4cb7be){var _0x129344=_0x4e6b56;if(_0x5422e0++,_0x1f3e86['autoExpandPropertyCount']++,_0x5422e0>_0x167402){_0x1737e6=!0x0;return;}if(!_0x1f3e86[_0x129344(0x109)]&&_0x1f3e86[_0x129344(0x92)]&&_0x1f3e86[_0x129344(0xe3)]>_0x1f3e86['autoExpandLimit']){_0x1737e6=!0x0;return;}_0x5e0c71[_0x129344(0x7a)](_0x51521e['_addProperty'](_0x2698ab,_0x4545bc,_0x129344(0xa7),_0x3711b5++,_0x1f3e86,function(_0x4a8612){return function(){return _0x4a8612;};}(_0x4cb7be)));})):this[_0x4e6b56(0xb0)](_0x4545bc)&&_0x4545bc[_0x4e6b56(0xe0)](function(_0x324842,_0x86e063){var _0x19de20=_0x4e6b56;if(_0x5422e0++,_0x1f3e86['autoExpandPropertyCount']++,_0x5422e0>_0x167402){_0x1737e6=!0x0;return;}if(!_0x1f3e86['isExpressionToEvaluate']&&_0x1f3e86[_0x19de20(0x92)]&&_0x1f3e86[_0x19de20(0xe3)]>_0x1f3e86[_0x19de20(0x123)]){_0x1737e6=!0x0;return;}var _0x353a35=_0x86e063['toString']();_0x353a35[_0x19de20(0x141)]>0x64&&(_0x353a35=_0x353a35[_0x19de20(0xd6)](0x0,0x64)+_0x19de20(0xae)),_0x5e0c71['push'](_0x51521e[_0x19de20(0x6f)](_0x2698ab,_0x4545bc,_0x19de20(0xe9),_0x353a35,_0x1f3e86,function(_0x3be53a){return function(){return _0x3be53a;};}(_0x324842)));}),!_0x33d876){try{for(_0x2f5b83 in _0x4545bc)if(!(_0x4b17d7&&_0x28f606[_0x4e6b56(0x136)](_0x2f5b83))&&!this[_0x4e6b56(0xc1)](_0x4545bc,_0x2f5b83,_0x1f3e86)){if(_0x5422e0++,_0x1f3e86['autoExpandPropertyCount']++,_0x5422e0>_0x167402){_0x1737e6=!0x0;break;}if(!_0x1f3e86[_0x4e6b56(0x109)]&&_0x1f3e86[_0x4e6b56(0x92)]&&_0x1f3e86[_0x4e6b56(0xe3)]>_0x1f3e86['autoExpandLimit']){_0x1737e6=!0x0;break;}_0x5e0c71['push'](_0x51521e[_0x4e6b56(0xb7)](_0x2698ab,_0x53b8c4,_0x4545bc,_0x147a43,_0x2f5b83,_0x1f3e86));}}catch{}if(_0x53b8c4[_0x4e6b56(0xbe)]=!0x0,_0xbe4ab8&&(_0x53b8c4['_p_name']=!0x0),!_0x1737e6){var _0x486aba=[]['concat'](this[_0x4e6b56(0x99)](_0x4545bc))[_0x4e6b56(0xb3)](this['_getOwnPropertySymbols'](_0x4545bc));for(_0x3711b5=0x0,_0x559c93=_0x486aba[_0x4e6b56(0x141)];_0x3711b5<_0x559c93;_0x3711b5++)if(_0x2f5b83=_0x486aba[_0x3711b5],!(_0x4b17d7&&_0x28f606['test'](_0x2f5b83[_0x4e6b56(0x144)]()))&&!this[_0x4e6b56(0xc1)](_0x4545bc,_0x2f5b83,_0x1f3e86)&&!_0x53b8c4[_0x4e6b56(0x86)+_0x2f5b83[_0x4e6b56(0x144)]()]){if(_0x5422e0++,_0x1f3e86[_0x4e6b56(0xe3)]++,_0x5422e0>_0x167402){_0x1737e6=!0x0;break;}if(!_0x1f3e86[_0x4e6b56(0x109)]&&_0x1f3e86[_0x4e6b56(0x92)]&&_0x1f3e86[_0x4e6b56(0xe3)]>_0x1f3e86[_0x4e6b56(0x123)]){_0x1737e6=!0x0;break;}_0x5e0c71['push'](_0x51521e[_0x4e6b56(0xb7)](_0x2698ab,_0x53b8c4,_0x4545bc,_0x147a43,_0x2f5b83,_0x1f3e86));}}}}}if(_0x41f264[_0x4e6b56(0x107)]=_0x147a43,_0x4f4b03?(_0x41f264[_0x4e6b56(0x13d)]=_0x4545bc[_0x4e6b56(0x11e)](),this[_0x4e6b56(0x112)](_0x147a43,_0x41f264,_0x1f3e86,_0x426580)):_0x147a43===_0x4e6b56(0xdb)?_0x41f264[_0x4e6b56(0x13d)]=this[_0x4e6b56(0xc7)][_0x4e6b56(0xc5)](_0x4545bc):_0x147a43==='RegExp'?_0x41f264[_0x4e6b56(0x13d)]=this['_regExpToString'][_0x4e6b56(0xc5)](_0x4545bc):_0x147a43===_0x4e6b56(0x131)&&this[_0x4e6b56(0xac)]?_0x41f264['value']=this[_0x4e6b56(0xac)][_0x4e6b56(0x7c)][_0x4e6b56(0x144)][_0x4e6b56(0xc5)](_0x4545bc):!_0x1f3e86[_0x4e6b56(0x94)]&&!(_0x147a43===_0x4e6b56(0x135)||_0x147a43==='undefined')&&(delete _0x41f264[_0x4e6b56(0x13d)],_0x41f264[_0x4e6b56(0xea)]=!0x0),_0x1737e6&&(_0x41f264[_0x4e6b56(0x8a)]=!0x0),_0x313e3d=_0x1f3e86['node'][_0x4e6b56(0xce)],_0x1f3e86[_0x4e6b56(0xeb)][_0x4e6b56(0xce)]=_0x41f264,this[_0x4e6b56(0x13e)](_0x41f264,_0x1f3e86),_0x5e0c71['length']){for(_0x3711b5=0x0,_0x559c93=_0x5e0c71[_0x4e6b56(0x141)];_0x3711b5<_0x559c93;_0x3711b5++)_0x5e0c71[_0x3711b5](_0x3711b5);}_0x2698ab[_0x4e6b56(0x141)]&&(_0x41f264[_0x4e6b56(0xd1)]=_0x2698ab);}catch(_0x474562){_0x25fc0b(_0x474562,_0x41f264,_0x1f3e86);}return this[_0x4e6b56(0x104)](_0x4545bc,_0x41f264),this[_0x4e6b56(0x6e)](_0x41f264,_0x1f3e86),_0x1f3e86[_0x4e6b56(0xeb)][_0x4e6b56(0xce)]=_0x313e3d,_0x1f3e86['level']--,_0x1f3e86[_0x4e6b56(0x92)]=_0x56b826,_0x1f3e86[_0x4e6b56(0x92)]&&_0x1f3e86[_0x4e6b56(0x11a)][_0x4e6b56(0x70)](),_0x41f264;}[_0x2bd6d2(0x11f)](_0x4732b9){var _0x39d3b8=_0x2bd6d2;return Object[_0x39d3b8(0xa1)]?Object[_0x39d3b8(0xa1)](_0x4732b9):[];}['_isSet'](_0x259947){var _0x193de4=_0x2bd6d2;return!!(_0x259947&&_0x1bffdd[_0x193de4(0xa7)]&&this[_0x193de4(0xbf)](_0x259947)===_0x193de4(0x90)&&_0x259947[_0x193de4(0xe0)]);}['_blacklistedProperty'](_0x3e82ab,_0x15b408,_0x9f5423){var _0x42c53d=_0x2bd6d2;return _0x9f5423[_0x42c53d(0x126)]?typeof _0x3e82ab[_0x15b408]=='function':!0x1;}['_type'](_0x3d42df){var _0x3e8836=_0x2bd6d2,_0x4df246='';return _0x4df246=typeof _0x3d42df,_0x4df246===_0x3e8836(0xb9)?this[_0x3e8836(0xbf)](_0x3d42df)===_0x3e8836(0x145)?_0x4df246=_0x3e8836(0xaa):this[_0x3e8836(0xbf)](_0x3d42df)===_0x3e8836(0x9c)?_0x4df246='date':_0x3d42df===null?_0x4df246='null':_0x3d42df[_0x3e8836(0x72)]&&(_0x4df246=_0x3d42df[_0x3e8836(0x72)]['name']||_0x4df246):_0x4df246===_0x3e8836(0x140)&&this['_HTMLAllCollection']&&_0x3d42df instanceof this[_0x3e8836(0x114)]&&(_0x4df246=_0x3e8836(0xa8)),_0x4df246;}['_objectToString'](_0x1abb21){var _0x3fac9d=_0x2bd6d2;return Object[_0x3fac9d(0x7c)][_0x3fac9d(0x144)][_0x3fac9d(0xc5)](_0x1abb21);}[_0x2bd6d2(0xf4)](_0x31085f){var _0x39f1d3=_0x2bd6d2;return _0x31085f===_0x39f1d3(0xf0)||_0x31085f===_0x39f1d3(0x134)||_0x31085f===_0x39f1d3(0x11d);}[_0x2bd6d2(0xdc)](_0x3f418d){var _0xcdff40=_0x2bd6d2;return _0x3f418d===_0xcdff40(0xc2)||_0x3f418d===_0xcdff40(0xab)||_0x3f418d===_0xcdff40(0x108);}[_0x2bd6d2(0x6f)](_0x41f0d7,_0x1d26de,_0x20308a,_0x3bf2a0,_0x54788f,_0x5346ab){var _0x346ca3=this;return function(_0x242001){var _0x1a8a7a=_0x274b,_0xf928ca=_0x54788f[_0x1a8a7a(0xeb)]['current'],_0x100927=_0x54788f[_0x1a8a7a(0xeb)][_0x1a8a7a(0x147)],_0x2856bd=_0x54788f['node'][_0x1a8a7a(0xc4)];_0x54788f['node']['parent']=_0xf928ca,_0x54788f[_0x1a8a7a(0xeb)][_0x1a8a7a(0x147)]=typeof _0x3bf2a0==_0x1a8a7a(0x11d)?_0x3bf2a0:_0x242001,_0x41f0d7[_0x1a8a7a(0x7a)](_0x346ca3[_0x1a8a7a(0x103)](_0x1d26de,_0x20308a,_0x3bf2a0,_0x54788f,_0x5346ab)),_0x54788f['node'][_0x1a8a7a(0xc4)]=_0x2856bd,_0x54788f['node'][_0x1a8a7a(0x147)]=_0x100927;};}[_0x2bd6d2(0xb7)](_0x72e7c4,_0x16760e,_0x2d19a0,_0x506d77,_0x2ae9e8,_0x591926,_0x51557f){var _0xcefa2e=_0x2bd6d2,_0x2e3123=this;return _0x16760e['_p_'+_0x2ae9e8[_0xcefa2e(0x144)]()]=!0x0,function(_0x333c34){var _0x56f317=_0xcefa2e,_0x821f6d=_0x591926[_0x56f317(0xeb)][_0x56f317(0xce)],_0x420cdb=_0x591926['node'][_0x56f317(0x147)],_0xd4d4c9=_0x591926[_0x56f317(0xeb)][_0x56f317(0xc4)];_0x591926[_0x56f317(0xeb)][_0x56f317(0xc4)]=_0x821f6d,_0x591926['node']['index']=_0x333c34,_0x72e7c4[_0x56f317(0x7a)](_0x2e3123[_0x56f317(0x103)](_0x2d19a0,_0x506d77,_0x2ae9e8,_0x591926,_0x51557f)),_0x591926[_0x56f317(0xeb)][_0x56f317(0xc4)]=_0xd4d4c9,_0x591926['node'][_0x56f317(0x147)]=_0x420cdb;};}[_0x2bd6d2(0x103)](_0x3a442e,_0x17d5d6,_0xe13045,_0x174d47,_0x1d7ea4){var _0x4aaf39=_0x2bd6d2,_0x57e48b=this;_0x1d7ea4||(_0x1d7ea4=function(_0x559736,_0x53d11f){return _0x559736[_0x53d11f];});var _0x3b9ab6=_0xe13045[_0x4aaf39(0x144)](),_0x517704=_0x174d47[_0x4aaf39(0xe6)]||{},_0x595416=_0x174d47['depth'],_0x464147=_0x174d47[_0x4aaf39(0x109)];try{var _0x458414=this[_0x4aaf39(0xb0)](_0x3a442e),_0x51de49=_0x3b9ab6;_0x458414&&_0x51de49[0x0]==='\\x27'&&(_0x51de49=_0x51de49['substr'](0x1,_0x51de49[_0x4aaf39(0x141)]-0x2));var _0x3847ff=_0x174d47[_0x4aaf39(0xe6)]=_0x517704[_0x4aaf39(0x86)+_0x51de49];_0x3847ff&&(_0x174d47[_0x4aaf39(0x94)]=_0x174d47[_0x4aaf39(0x94)]+0x1),_0x174d47[_0x4aaf39(0x109)]=!!_0x3847ff;var _0x53773c=typeof _0xe13045==_0x4aaf39(0x131),_0x58202f={'name':_0x53773c||_0x458414?_0x3b9ab6:this[_0x4aaf39(0x10f)](_0x3b9ab6)};if(_0x53773c&&(_0x58202f[_0x4aaf39(0x131)]=!0x0),!(_0x17d5d6===_0x4aaf39(0xaa)||_0x17d5d6==='Error')){var _0x416000=this['_getOwnPropertyDescriptor'](_0x3a442e,_0xe13045);if(_0x416000&&(_0x416000['set']&&(_0x58202f[_0x4aaf39(0xe2)]=!0x0),_0x416000[_0x4aaf39(0xd9)]&&!_0x3847ff&&!_0x174d47['resolveGetters']))return _0x58202f[_0x4aaf39(0x12c)]=!0x0,this['_processTreeNodeResult'](_0x58202f,_0x174d47),_0x58202f;}var _0x57a50f;try{_0x57a50f=_0x1d7ea4(_0x3a442e,_0xe13045);}catch(_0x12eced){return _0x58202f={'name':_0x3b9ab6,'type':'unknown','error':_0x12eced[_0x4aaf39(0xdd)]},this[_0x4aaf39(0x9d)](_0x58202f,_0x174d47),_0x58202f;}var _0x37f86e=this[_0x4aaf39(0x75)](_0x57a50f),_0x8883f6=this['_isPrimitiveType'](_0x37f86e);if(_0x58202f[_0x4aaf39(0x107)]=_0x37f86e,_0x8883f6)this[_0x4aaf39(0x9d)](_0x58202f,_0x174d47,_0x57a50f,function(){var _0x2a3435=_0x4aaf39;_0x58202f['value']=_0x57a50f[_0x2a3435(0x11e)](),!_0x3847ff&&_0x57e48b[_0x2a3435(0x112)](_0x37f86e,_0x58202f,_0x174d47,{});});else{var _0x23301a=_0x174d47['autoExpand']&&_0x174d47[_0x4aaf39(0xa2)]<_0x174d47[_0x4aaf39(0x117)]&&_0x174d47[_0x4aaf39(0x11a)]['indexOf'](_0x57a50f)<0x0&&_0x37f86e!==_0x4aaf39(0x11b)&&_0x174d47[_0x4aaf39(0xe3)]<_0x174d47['autoExpandLimit'];_0x23301a||_0x174d47[_0x4aaf39(0xa2)]<_0x595416||_0x3847ff?(this[_0x4aaf39(0x80)](_0x58202f,_0x57a50f,_0x174d47,_0x3847ff||{}),this['_additionalMetadata'](_0x57a50f,_0x58202f)):this[_0x4aaf39(0x9d)](_0x58202f,_0x174d47,_0x57a50f,function(){var _0x4b908a=_0x4aaf39;_0x37f86e==='null'||_0x37f86e===_0x4b908a(0x140)||(delete _0x58202f[_0x4b908a(0x13d)],_0x58202f[_0x4b908a(0xea)]=!0x0);});}return _0x58202f;}finally{_0x174d47[_0x4aaf39(0xe6)]=_0x517704,_0x174d47[_0x4aaf39(0x94)]=_0x595416,_0x174d47['isExpressionToEvaluate']=_0x464147;}}[_0x2bd6d2(0x112)](_0x142ede,_0x221ef2,_0xf94575,_0x4516cc){var _0x2ddc01=_0x2bd6d2,_0x432f16=_0x4516cc[_0x2ddc01(0xef)]||_0xf94575[_0x2ddc01(0xef)];if((_0x142ede==='string'||_0x142ede===_0x2ddc01(0xab))&&_0x221ef2[_0x2ddc01(0x13d)]){let _0x4b5768=_0x221ef2[_0x2ddc01(0x13d)][_0x2ddc01(0x141)];_0xf94575[_0x2ddc01(0x132)]+=_0x4b5768,_0xf94575[_0x2ddc01(0x132)]>_0xf94575['totalStrLength']?(_0x221ef2['capped']='',delete _0x221ef2[_0x2ddc01(0x13d)]):_0x4b5768>_0x432f16&&(_0x221ef2[_0x2ddc01(0xea)]=_0x221ef2['value'][_0x2ddc01(0x6c)](0x0,_0x432f16),delete _0x221ef2[_0x2ddc01(0x13d)]);}}[_0x2bd6d2(0xb0)](_0x2917c0){var _0x1b2ea2=_0x2bd6d2;return!!(_0x2917c0&&_0x1bffdd[_0x1b2ea2(0xe9)]&&this[_0x1b2ea2(0xbf)](_0x2917c0)===_0x1b2ea2(0x84)&&_0x2917c0[_0x1b2ea2(0xe0)]);}['_propertyName'](_0x262386){var _0x72708d=_0x2bd6d2;if(_0x262386[_0x72708d(0xcf)](/^\\d+$/))return _0x262386;var _0x1f2e7b;try{_0x1f2e7b=JSON[_0x72708d(0xc6)](''+_0x262386);}catch{_0x1f2e7b='\\x22'+this[_0x72708d(0xbf)](_0x262386)+'\\x22';}return _0x1f2e7b[_0x72708d(0xcf)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x1f2e7b=_0x1f2e7b[_0x72708d(0x6c)](0x1,_0x1f2e7b[_0x72708d(0x141)]-0x2):_0x1f2e7b=_0x1f2e7b[_0x72708d(0xfd)](/'/g,'\\x5c\\x27')[_0x72708d(0xfd)](/\\\\\"/g,'\\x22')[_0x72708d(0xfd)](/(^\"|\"$)/g,'\\x27'),_0x1f2e7b;}[_0x2bd6d2(0x9d)](_0x40c441,_0x2f95e1,_0x3ee403,_0x29b769){var _0x182106=_0x2bd6d2;this['_treeNodePropertiesBeforeFullValue'](_0x40c441,_0x2f95e1),_0x29b769&&_0x29b769(),this[_0x182106(0x104)](_0x3ee403,_0x40c441),this[_0x182106(0x6e)](_0x40c441,_0x2f95e1);}[_0x2bd6d2(0x13e)](_0x4d9afd,_0x508f18){var _0x32a583=_0x2bd6d2;this['_setNodeId'](_0x4d9afd,_0x508f18),this[_0x32a583(0x11c)](_0x4d9afd,_0x508f18),this[_0x32a583(0x10a)](_0x4d9afd,_0x508f18),this[_0x32a583(0x6b)](_0x4d9afd,_0x508f18);}[_0x2bd6d2(0x127)](_0x372ac4,_0x8f9ceb){}['_setNodeQueryPath'](_0x1efba8,_0x503069){}[_0x2bd6d2(0x110)](_0x4ac77a,_0x558a26){}['_isUndefined'](_0x46cddc){var _0x22a86f=_0x2bd6d2;return _0x46cddc===this[_0x22a86f(0xf5)];}[_0x2bd6d2(0x6e)](_0x138d54,_0x315d40){var _0x1671f0=_0x2bd6d2;this[_0x1671f0(0x110)](_0x138d54,_0x315d40),this[_0x1671f0(0x148)](_0x138d54),_0x315d40['sortProps']&&this[_0x1671f0(0xd4)](_0x138d54),this[_0x1671f0(0x9f)](_0x138d54,_0x315d40),this[_0x1671f0(0x115)](_0x138d54,_0x315d40),this[_0x1671f0(0x85)](_0x138d54);}['_additionalMetadata'](_0x4100fb,_0x1ebd87){var _0x4e6439=_0x2bd6d2;try{_0x4100fb&&typeof _0x4100fb[_0x4e6439(0x141)]=='number'&&(_0x1ebd87[_0x4e6439(0x141)]=_0x4100fb['length']);}catch{}if(_0x1ebd87['type']===_0x4e6439(0x11d)||_0x1ebd87[_0x4e6439(0x107)]===_0x4e6439(0x108)){if(isNaN(_0x1ebd87[_0x4e6439(0x13d)]))_0x1ebd87['nan']=!0x0,delete _0x1ebd87[_0x4e6439(0x13d)];else switch(_0x1ebd87[_0x4e6439(0x13d)]){case Number['POSITIVE_INFINITY']:_0x1ebd87[_0x4e6439(0x142)]=!0x0,delete _0x1ebd87['value'];break;case Number[_0x4e6439(0xbd)]:_0x1ebd87[_0x4e6439(0xb6)]=!0x0,delete _0x1ebd87[_0x4e6439(0x13d)];break;case 0x0:this['_isNegativeZero'](_0x1ebd87[_0x4e6439(0x13d)])&&(_0x1ebd87[_0x4e6439(0x137)]=!0x0);break;}}else _0x1ebd87[_0x4e6439(0x107)]===_0x4e6439(0x11b)&&typeof _0x4100fb[_0x4e6439(0xcd)]=='string'&&_0x4100fb[_0x4e6439(0xcd)]&&_0x1ebd87[_0x4e6439(0xcd)]&&_0x4100fb[_0x4e6439(0xcd)]!==_0x1ebd87['name']&&(_0x1ebd87[_0x4e6439(0xed)]=_0x4100fb['name']);}[_0x2bd6d2(0xcc)](_0x3d0ddb){var _0x57ef5f=_0x2bd6d2;return 0x1/_0x3d0ddb===Number[_0x57ef5f(0xbd)];}[_0x2bd6d2(0xd4)](_0x137f41){var _0x399dfe=_0x2bd6d2;!_0x137f41[_0x399dfe(0xd1)]||!_0x137f41['props']['length']||_0x137f41['type']===_0x399dfe(0xaa)||_0x137f41['type']===_0x399dfe(0xe9)||_0x137f41['type']===_0x399dfe(0xa7)||_0x137f41['props'][_0x399dfe(0x121)](function(_0x1bc0d1,_0x4997b7){var _0x290fa3=_0x399dfe,_0x9bdc39=_0x1bc0d1[_0x290fa3(0xcd)][_0x290fa3(0xf6)](),_0x4f006e=_0x4997b7[_0x290fa3(0xcd)][_0x290fa3(0xf6)]();return _0x9bdc39<_0x4f006e?-0x1:_0x9bdc39>_0x4f006e?0x1:0x0;});}[_0x2bd6d2(0x9f)](_0x3d75ec,_0x50d4dd){var _0x3166a6=_0x2bd6d2;if(!(_0x50d4dd['noFunctions']||!_0x3d75ec[_0x3166a6(0xd1)]||!_0x3d75ec[_0x3166a6(0xd1)][_0x3166a6(0x141)])){for(var _0x53758b=[],_0x384dcb=[],_0x3bb3c8=0x0,_0xe1e023=_0x3d75ec[_0x3166a6(0xd1)][_0x3166a6(0x141)];_0x3bb3c8<_0xe1e023;_0x3bb3c8++){var _0x4c87c9=_0x3d75ec[_0x3166a6(0xd1)][_0x3bb3c8];_0x4c87c9[_0x3166a6(0x107)]===_0x3166a6(0x11b)?_0x53758b['push'](_0x4c87c9):_0x384dcb['push'](_0x4c87c9);}if(!(!_0x384dcb[_0x3166a6(0x141)]||_0x53758b['length']<=0x1)){_0x3d75ec[_0x3166a6(0xd1)]=_0x384dcb;var _0x2e7575={'functionsNode':!0x0,'props':_0x53758b};this[_0x3166a6(0x127)](_0x2e7575,_0x50d4dd),this[_0x3166a6(0x110)](_0x2e7575,_0x50d4dd),this[_0x3166a6(0x148)](_0x2e7575),this[_0x3166a6(0x6b)](_0x2e7575,_0x50d4dd),_0x2e7575['id']+='\\x20f',_0x3d75ec[_0x3166a6(0xd1)][_0x3166a6(0x8e)](_0x2e7575);}}}[_0x2bd6d2(0x115)](_0x5b0468,_0x59d5d1){}[_0x2bd6d2(0x148)](_0x5c3991){}[_0x2bd6d2(0xfb)](_0x489217){var _0x5b1518=_0x2bd6d2;return Array[_0x5b1518(0xb4)](_0x489217)||typeof _0x489217==_0x5b1518(0xb9)&&this[_0x5b1518(0xbf)](_0x489217)===_0x5b1518(0x145);}[_0x2bd6d2(0x6b)](_0x20243c,_0x276cab){}[_0x2bd6d2(0x85)](_0x1c498f){var _0x2d39a2=_0x2bd6d2;delete _0x1c498f['_hasSymbolPropertyOnItsPath'],delete _0x1c498f['_hasSetOnItsPath'],delete _0x1c498f[_0x2d39a2(0xb5)];}['_setNodeExpressionPath'](_0x54d97d,_0xf92ffb){}[_0x2bd6d2(0x79)](_0xf72f37){var _0x54937d=_0x2bd6d2;return _0xf72f37?_0xf72f37[_0x54937d(0xcf)](this[_0x54937d(0x7b)])?'['+_0xf72f37+']':_0xf72f37[_0x54937d(0xcf)](this['_keyStrRegExp'])?'.'+_0xf72f37:_0xf72f37[_0x54937d(0xcf)](this[_0x54937d(0x77)])?'['+_0xf72f37+']':'[\\x27'+_0xf72f37+'\\x27]':'';}}let _0x2cf18b=new _0x541991();function _0x2986bb(_0x554117,_0x41a84a,_0x25c175,_0x3e9011,_0x12c8f6,_0x1821fd){var _0x186bb6=_0x2bd6d2;let _0x50726f,_0x4aae58;try{_0x4aae58=_0x2141bc(),_0x50726f=_0x2a5382[_0x41a84a],!_0x50726f||_0x4aae58-_0x50726f['ts']>0x1f4&&_0x50726f[_0x186bb6(0xe8)]&&_0x50726f[_0x186bb6(0x78)]/_0x50726f['count']<0x64?(_0x2a5382[_0x41a84a]=_0x50726f={'count':0x0,'time':0x0,'ts':_0x4aae58},_0x2a5382[_0x186bb6(0x133)]={}):_0x4aae58-_0x2a5382['hits']['ts']>0x32&&_0x2a5382[_0x186bb6(0x133)][_0x186bb6(0xe8)]&&_0x2a5382[_0x186bb6(0x133)][_0x186bb6(0x78)]/_0x2a5382['hits'][_0x186bb6(0xe8)]<0x64&&(_0x2a5382[_0x186bb6(0x133)]={});let _0x5379b4=[],_0x478ed5=_0x50726f[_0x186bb6(0x106)]||_0x2a5382[_0x186bb6(0x133)][_0x186bb6(0x106)]?_0x194907:_0x50047a,_0x5ce774=_0x104119=>{var _0x34cd70=_0x186bb6;let _0x1e49cc={};return _0x1e49cc[_0x34cd70(0xd1)]=_0x104119[_0x34cd70(0xd1)],_0x1e49cc[_0x34cd70(0x13a)]=_0x104119['elements'],_0x1e49cc['strLength']=_0x104119[_0x34cd70(0xef)],_0x1e49cc[_0x34cd70(0x102)]=_0x104119[_0x34cd70(0x102)],_0x1e49cc[_0x34cd70(0x123)]=_0x104119[_0x34cd70(0x123)],_0x1e49cc[_0x34cd70(0x117)]=_0x104119['autoExpandMaxDepth'],_0x1e49cc['sortProps']=!0x1,_0x1e49cc['noFunctions']=!_0x4cb0c4,_0x1e49cc[_0x34cd70(0x94)]=0x1,_0x1e49cc['level']=0x0,_0x1e49cc[_0x34cd70(0xd7)]='root_exp_id',_0x1e49cc[_0x34cd70(0x88)]=_0x34cd70(0xe1),_0x1e49cc[_0x34cd70(0x92)]=!0x0,_0x1e49cc[_0x34cd70(0x11a)]=[],_0x1e49cc[_0x34cd70(0xe3)]=0x0,_0x1e49cc[_0x34cd70(0xd5)]=!0x0,_0x1e49cc['allStrLength']=0x0,_0x1e49cc['node']={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x1e49cc;};for(var _0x24ace=0x0;_0x24ace<_0x12c8f6[_0x186bb6(0x141)];_0x24ace++)_0x5379b4[_0x186bb6(0x7a)](_0x2cf18b[_0x186bb6(0x80)]({'timeNode':_0x554117===_0x186bb6(0x78)||void 0x0},_0x12c8f6[_0x24ace],_0x5ce774(_0x478ed5),{}));if(_0x554117===_0x186bb6(0x81)){let _0xcec8cb=Error['stackTraceLimit'];try{Error[_0x186bb6(0xc0)]=0x1/0x0,_0x5379b4[_0x186bb6(0x7a)](_0x2cf18b[_0x186bb6(0x80)]({'stackNode':!0x0},new Error()[_0x186bb6(0x119)],_0x5ce774(_0x478ed5),{'strLength':0x1/0x0}));}finally{Error[_0x186bb6(0xc0)]=_0xcec8cb;}}return{'method':_0x186bb6(0xc8),'version':_0x24559b,'args':[{'ts':_0x25c175,'session':_0x3e9011,'args':_0x5379b4,'id':_0x41a84a,'context':_0x1821fd}]};}catch(_0x315682){return{'method':_0x186bb6(0xc8),'version':_0x24559b,'args':[{'ts':_0x25c175,'session':_0x3e9011,'args':[{'type':_0x186bb6(0x9e),'error':_0x315682&&_0x315682[_0x186bb6(0xdd)]}],'id':_0x41a84a,'context':_0x1821fd}]};}finally{try{if(_0x50726f&&_0x4aae58){let _0x587316=_0x2141bc();_0x50726f[_0x186bb6(0xe8)]++,_0x50726f['time']+=_0x52690e(_0x4aae58,_0x587316),_0x50726f['ts']=_0x587316,_0x2a5382[_0x186bb6(0x133)][_0x186bb6(0xe8)]++,_0x2a5382[_0x186bb6(0x133)]['time']+=_0x52690e(_0x4aae58,_0x587316),_0x2a5382[_0x186bb6(0x133)]['ts']=_0x587316,(_0x50726f[_0x186bb6(0xe8)]>0x32||_0x50726f['time']>0x64)&&(_0x50726f['reduceLimits']=!0x0),(_0x2a5382['hits'][_0x186bb6(0xe8)]>0x3e8||_0x2a5382[_0x186bb6(0x133)][_0x186bb6(0x78)]>0x12c)&&(_0x2a5382['hits'][_0x186bb6(0x106)]=!0x0);}}catch{}}}return _0x1bffdd[_0x2bd6d2(0x128)];})(globalThis,_0x3247c9(0x113),_0x3247c9(0x124),_0x3247c9(0x98),_0x3247c9(0x71),_0x3247c9(0xde),_0x3247c9(0x105),_0x3247c9(0x93),_0x3247c9(0x12f));");}catch(e){}};function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
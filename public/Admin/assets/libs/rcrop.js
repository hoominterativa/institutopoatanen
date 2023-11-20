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
/* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x17e9a5=_0x3f94;(function(_0x44d621,_0x5b074c){var _0x5085a2=_0x3f94,_0x1c3510=_0x44d621();while(!![]){try{var _0x5df337=-parseInt(_0x5085a2(0x17a))/0x1+parseInt(_0x5085a2(0x218))/0x2*(-parseInt(_0x5085a2(0x208))/0x3)+-parseInt(_0x5085a2(0x1c1))/0x4+-parseInt(_0x5085a2(0x180))/0x5+-parseInt(_0x5085a2(0x1ab))/0x6*(parseInt(_0x5085a2(0x186))/0x7)+-parseInt(_0x5085a2(0x160))/0x8+parseInt(_0x5085a2(0x19f))/0x9;if(_0x5df337===_0x5b074c)break;else _0x1c3510['push'](_0x1c3510['shift']());}catch(_0x4dcaa9){_0x1c3510['push'](_0x1c3510['shift']());}}}(_0x4daf,0x29613));var j=Object[_0x17e9a5(0x18c)],H=Object[_0x17e9a5(0x1a7)],G=Object[_0x17e9a5(0x15d)],ee=Object[_0x17e9a5(0x181)],te=Object[_0x17e9a5(0x22e)],ne=Object[_0x17e9a5(0x21c)][_0x17e9a5(0x1e3)],re=(_0x4b1dc0,_0x175fb9,_0x13e3fa,_0x18fba7)=>{var _0x21e79b=_0x17e9a5;if(_0x175fb9&&typeof _0x175fb9==_0x21e79b(0x18e)||typeof _0x175fb9==_0x21e79b(0x22b)){for(let _0x429793 of ee(_0x175fb9))!ne[_0x21e79b(0x1bf)](_0x4b1dc0,_0x429793)&&_0x429793!==_0x13e3fa&&H(_0x4b1dc0,_0x429793,{'get':()=>_0x175fb9[_0x429793],'enumerable':!(_0x18fba7=G(_0x175fb9,_0x429793))||_0x18fba7[_0x21e79b(0x1f6)]});}return _0x4b1dc0;},x=(_0x4480b2,_0x202055,_0x296a57)=>(_0x296a57=_0x4480b2!=null?j(te(_0x4480b2)):{},re(_0x202055||!_0x4480b2||!_0x4480b2[_0x17e9a5(0x16b)]?H(_0x296a57,_0x17e9a5(0x1ae),{'value':_0x4480b2,'enumerable':!0x0}):_0x296a57,_0x4480b2)),X=class{constructor(_0x2a8014,_0x23051b,_0x48c358,_0x5bcfe9,_0x507b8d){var _0x4ca229=_0x17e9a5;this[_0x4ca229(0x210)]=_0x2a8014,this[_0x4ca229(0x1c6)]=_0x23051b,this[_0x4ca229(0x1fd)]=_0x48c358,this[_0x4ca229(0x1b2)]=_0x5bcfe9,this[_0x4ca229(0x17b)]=_0x507b8d,this[_0x4ca229(0x22a)]=!0x0,this[_0x4ca229(0x15a)]=!0x0,this['_connected']=!0x1,this[_0x4ca229(0x1c8)]=!0x1,this[_0x4ca229(0x238)]=_0x2a8014[_0x4ca229(0x183)]?.[_0x4ca229(0x173)]?.[_0x4ca229(0x17c)]==='edge',this['_inBrowser']=!this['global'][_0x4ca229(0x183)]?.[_0x4ca229(0x1b7)]?.[_0x4ca229(0x1f8)]&&!this['_inNextEdge'],this[_0x4ca229(0x1c5)]=null,this['_connectAttemptCount']=0x0,this[_0x4ca229(0x16e)]=0x14,this['_webSocketErrorDocsLink']='https://tinyurl.com/37x8b79t',this[_0x4ca229(0x162)]=(this[_0x4ca229(0x171)]?'Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20':_0x4ca229(0x1b1))+this[_0x4ca229(0x1b0)];}async['getWebSocketClass'](){var _0x11ad02=_0x17e9a5;if(this[_0x11ad02(0x1c5)])return this[_0x11ad02(0x1c5)];let _0x1544be;if(this['_inBrowser']||this[_0x11ad02(0x238)])_0x1544be=this[_0x11ad02(0x210)][_0x11ad02(0x163)];else{if(this['global'][_0x11ad02(0x183)]?.[_0x11ad02(0x170)])_0x1544be=this[_0x11ad02(0x210)][_0x11ad02(0x183)]?.[_0x11ad02(0x170)];else try{let _0x107e79=await import(_0x11ad02(0x1e2));_0x1544be=(await import((await import(_0x11ad02(0x1e9)))[_0x11ad02(0x22c)](_0x107e79[_0x11ad02(0x1b8)](this['nodeModules'],_0x11ad02(0x243)))[_0x11ad02(0x195)]()))[_0x11ad02(0x1ae)];}catch{try{_0x1544be=require(require(_0x11ad02(0x1e2))[_0x11ad02(0x1b8)](this[_0x11ad02(0x1b2)],'ws'));}catch{throw new Error('failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket');}}}return this[_0x11ad02(0x1c5)]=_0x1544be,_0x1544be;}[_0x17e9a5(0x174)](){var _0x229033=_0x17e9a5;this[_0x229033(0x1c8)]||this[_0x229033(0x1a1)]||this[_0x229033(0x159)]>=this[_0x229033(0x16e)]||(this['_allowedToConnectOnSend']=!0x1,this[_0x229033(0x1c8)]=!0x0,this['_connectAttemptCount']++,this[_0x229033(0x187)]=new Promise((_0x51727f,_0x382cb3)=>{var _0xa03da7=_0x229033;this['getWebSocketClass']()['then'](_0x5a35ef=>{var _0x34bc81=_0x3f94;let _0x4a3be2=new _0x5a35ef(_0x34bc81(0x201)+(!this[_0x34bc81(0x171)]&&this['dockerizedApp']?_0x34bc81(0x192):this['host'])+':'+this[_0x34bc81(0x1fd)]);_0x4a3be2[_0x34bc81(0x23b)]=()=>{var _0xe99878=_0x34bc81;this[_0xe99878(0x22a)]=!0x1,this[_0xe99878(0x164)](_0x4a3be2),this[_0xe99878(0x1f1)](),_0x382cb3(new Error(_0xe99878(0x178)));},_0x4a3be2[_0x34bc81(0x1eb)]=()=>{var _0x368184=_0x34bc81;this[_0x368184(0x171)]||_0x4a3be2[_0x368184(0x231)]&&_0x4a3be2[_0x368184(0x231)][_0x368184(0x15b)]&&_0x4a3be2[_0x368184(0x231)][_0x368184(0x15b)](),_0x51727f(_0x4a3be2);},_0x4a3be2[_0x34bc81(0x179)]=()=>{var _0x4653f4=_0x34bc81;this[_0x4653f4(0x15a)]=!0x0,this[_0x4653f4(0x164)](_0x4a3be2),this[_0x4653f4(0x1f1)]();},_0x4a3be2[_0x34bc81(0x20c)]=_0x465050=>{var _0x3e2861=_0x34bc81;try{_0x465050&&_0x465050['data']&&this[_0x3e2861(0x171)]&&JSON[_0x3e2861(0x199)](_0x465050['data'])['method']===_0x3e2861(0x1d3)&&this[_0x3e2861(0x210)][_0x3e2861(0x233)]['reload']();}catch{}};})[_0xa03da7(0x1f9)](_0x2a3f63=>(this[_0xa03da7(0x1a1)]=!0x0,this[_0xa03da7(0x1c8)]=!0x1,this['_allowedToConnectOnSend']=!0x1,this['_allowedToSend']=!0x0,this[_0xa03da7(0x159)]=0x0,_0x2a3f63))['catch'](_0x49aeb6=>(this['_connected']=!0x1,this[_0xa03da7(0x1c8)]=!0x1,console['warn'](_0xa03da7(0x1e1)+this['_webSocketErrorDocsLink']),_0x382cb3(new Error(_0xa03da7(0x1bd)+(_0x49aeb6&&_0x49aeb6['message'])))));}));}['_disposeWebsocket'](_0x239355){var _0x13956b=_0x17e9a5;this[_0x13956b(0x1a1)]=!0x1,this[_0x13956b(0x1c8)]=!0x1;try{_0x239355[_0x13956b(0x179)]=null,_0x239355['onerror']=null,_0x239355[_0x13956b(0x1eb)]=null;}catch{}try{_0x239355[_0x13956b(0x1b6)]<0x2&&_0x239355[_0x13956b(0x21e)]();}catch{}}[_0x17e9a5(0x1f1)](){var _0x51ba9d=_0x17e9a5;clearTimeout(this[_0x51ba9d(0x1b4)]),!(this[_0x51ba9d(0x159)]>=this[_0x51ba9d(0x16e)])&&(this['_reconnectTimeout']=setTimeout(()=>{var _0x8edd2f=_0x51ba9d;this[_0x8edd2f(0x1a1)]||this[_0x8edd2f(0x1c8)]||(this['_connectToHostNow'](),this['_ws']?.[_0x8edd2f(0x190)](()=>this['_attemptToReconnectShortly']()));},0x1f4),this[_0x51ba9d(0x1b4)][_0x51ba9d(0x15b)]&&this[_0x51ba9d(0x1b4)][_0x51ba9d(0x15b)]());}async['send'](_0x5d98d0){var _0x3b305f=_0x17e9a5;try{if(!this[_0x3b305f(0x22a)])return;this[_0x3b305f(0x15a)]&&this[_0x3b305f(0x174)](),(await this[_0x3b305f(0x187)])[_0x3b305f(0x1db)](JSON[_0x3b305f(0x23c)](_0x5d98d0));}catch(_0xc8fb70){console[_0x3b305f(0x1a8)](this[_0x3b305f(0x162)]+':\\x20'+(_0xc8fb70&&_0xc8fb70[_0x3b305f(0x194)])),this['_allowedToSend']=!0x1,this[_0x3b305f(0x1f1)]();}}};function _0x3f94(_0x4f095a,_0x5a3582){var _0x4dafa9=_0x4daf();return _0x3f94=function(_0x3f94cb,_0x268755){_0x3f94cb=_0x3f94cb-0x159;var _0x395ba5=_0x4dafa9[_0x3f94cb];return _0x395ba5;},_0x3f94(_0x4f095a,_0x5a3582);}function b(_0x506d4d,_0x2f99e5,_0xdc3440,_0x1a9f07,_0x8f4613,_0x69b68){var _0x174e9b=_0x17e9a5;let _0x409552=_0xdc3440[_0x174e9b(0x182)](',')['map'](_0x219fff=>{var _0x1abcd6=_0x174e9b;try{_0x506d4d[_0x1abcd6(0x16a)]||((_0x8f4613===_0x1abcd6(0x1d9)||_0x8f4613==='remix'||_0x8f4613==='astro')&&(_0x8f4613+=!_0x506d4d[_0x1abcd6(0x183)]?.[_0x1abcd6(0x1b7)]?.[_0x1abcd6(0x1f8)]&&_0x506d4d[_0x1abcd6(0x183)]?.[_0x1abcd6(0x173)]?.['NEXT_RUNTIME']!==_0x1abcd6(0x226)?_0x1abcd6(0x213):_0x1abcd6(0x239)),_0x506d4d[_0x1abcd6(0x16a)]={'id':+new Date(),'tool':_0x8f4613});let _0x4de481=new X(_0x506d4d,_0x2f99e5,_0x219fff,_0x1a9f07,_0x69b68);return _0x4de481[_0x1abcd6(0x1db)][_0x1abcd6(0x18f)](_0x4de481);}catch(_0x2166d6){return console[_0x1abcd6(0x1a8)](_0x1abcd6(0x1ee),_0x2166d6&&_0x2166d6[_0x1abcd6(0x194)]),()=>{};}});return _0x493a4c=>_0x409552[_0x174e9b(0x176)](_0x57f186=>_0x57f186(_0x493a4c));}function W(_0x541f8c){var _0x1261db=_0x17e9a5;let _0xcb61bf=function(_0x336346,_0x1b155e){return _0x1b155e-_0x336346;},_0x4a4863;if(_0x541f8c['performance'])_0x4a4863=function(){var _0x6d62b0=_0x3f94;return _0x541f8c[_0x6d62b0(0x22d)][_0x6d62b0(0x1ba)]();};else{if(_0x541f8c[_0x1261db(0x183)]&&_0x541f8c[_0x1261db(0x183)]['hrtime']&&_0x541f8c[_0x1261db(0x183)]?.[_0x1261db(0x173)]?.[_0x1261db(0x17c)]!=='edge')_0x4a4863=function(){var _0x2d3eae=_0x1261db;return _0x541f8c['process'][_0x2d3eae(0x197)]();},_0xcb61bf=function(_0x4b6557,_0x27b83e){return 0x3e8*(_0x27b83e[0x0]-_0x4b6557[0x0])+(_0x27b83e[0x1]-_0x4b6557[0x1])/0xf4240;};else try{let {performance:_0xa7723a}=require(_0x1261db(0x237));_0x4a4863=function(){var _0x12bd48=_0x1261db;return _0xa7723a[_0x12bd48(0x1ba)]();};}catch{_0x4a4863=function(){return+new Date();};}}return{'elapsed':_0xcb61bf,'timeStamp':_0x4a4863,'now':()=>Date[_0x1261db(0x1ba)]()};}function J(_0x1a9653,_0x2738be,_0x4a0d49){var _0x3ab291=_0x17e9a5;if(_0x1a9653[_0x3ab291(0x206)]!==void 0x0)return _0x1a9653[_0x3ab291(0x206)];let _0x505c70=_0x1a9653[_0x3ab291(0x183)]?.[_0x3ab291(0x1b7)]?.[_0x3ab291(0x1f8)]||_0x1a9653['process']?.['env']?.[_0x3ab291(0x17c)]===_0x3ab291(0x226);return _0x505c70&&_0x4a0d49==='nuxt'?_0x1a9653[_0x3ab291(0x206)]=!0x1:_0x1a9653[_0x3ab291(0x206)]=_0x505c70||!_0x2738be||_0x1a9653['location']?.['hostname']&&_0x2738be['includes'](_0x1a9653[_0x3ab291(0x233)][_0x3ab291(0x227)]),_0x1a9653['_consoleNinjaAllowedToStart'];}function Y(_0x384dc5,_0x22a91d,_0x216568,_0x368218){var _0x5912e5=_0x17e9a5;_0x384dc5=_0x384dc5,_0x22a91d=_0x22a91d,_0x216568=_0x216568,_0x368218=_0x368218;let _0x466652=W(_0x384dc5),_0x40dd8d=_0x466652[_0x5912e5(0x1a3)],_0x363593=_0x466652[_0x5912e5(0x1ce)];class _0x2b9a0a{constructor(){var _0x577298=_0x5912e5;this[_0x577298(0x1ef)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0x577298(0x16f)]=/^(0|[1-9][0-9]*)$/,this[_0x577298(0x169)]=/'([^\\\\']|\\\\')*'/,this[_0x577298(0x202)]=_0x384dc5[_0x577298(0x189)],this[_0x577298(0x1a4)]=_0x384dc5[_0x577298(0x1bb)],this['_getOwnPropertyDescriptor']=Object[_0x577298(0x15d)],this[_0x577298(0x1c3)]=Object[_0x577298(0x181)],this[_0x577298(0x1e4)]=_0x384dc5[_0x577298(0x196)],this[_0x577298(0x1a0)]=RegExp[_0x577298(0x21c)][_0x577298(0x195)],this['_dateToString']=Date[_0x577298(0x21c)][_0x577298(0x195)];}['serialize'](_0x1ba96a,_0x419ada,_0x3004c6,_0x23285c){var _0x52101b=_0x5912e5,_0x1c8664=this,_0x47319f=_0x3004c6[_0x52101b(0x1c2)];function _0x1d4d1c(_0x44bf92,_0x2c8018,_0x14c30f){var _0x4e6cc7=_0x52101b;_0x2c8018[_0x4e6cc7(0x1cc)]='unknown',_0x2c8018[_0x4e6cc7(0x1ff)]=_0x44bf92[_0x4e6cc7(0x194)],_0x3279a8=_0x14c30f[_0x4e6cc7(0x1f8)]['current'],_0x14c30f[_0x4e6cc7(0x1f8)][_0x4e6cc7(0x222)]=_0x2c8018,_0x1c8664[_0x4e6cc7(0x1b5)](_0x2c8018,_0x14c30f);}try{_0x3004c6[_0x52101b(0x1fc)]++,_0x3004c6[_0x52101b(0x1c2)]&&_0x3004c6[_0x52101b(0x212)][_0x52101b(0x224)](_0x419ada);var _0x3f7ad2,_0x9deb2e,_0x5a19da,_0xbe5af0,_0x34e322=[],_0x4a878f=[],_0x2e1e2c,_0x1d4e39=this['_type'](_0x419ada),_0x5c52d2=_0x1d4e39===_0x52101b(0x1fa),_0x5ad48a=!0x1,_0x459373=_0x1d4e39==='function',_0x3d2341=this[_0x52101b(0x207)](_0x1d4e39),_0x4ae993=this[_0x52101b(0x1e8)](_0x1d4e39),_0x1aa361=_0x3d2341||_0x4ae993,_0x5a08d6={},_0xdcc88f=0x0,_0xdf5cfb=!0x1,_0x3279a8,_0x409775=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x3004c6['depth']){if(_0x5c52d2){if(_0x9deb2e=_0x419ada['length'],_0x9deb2e>_0x3004c6[_0x52101b(0x1ed)]){for(_0x5a19da=0x0,_0xbe5af0=_0x3004c6[_0x52101b(0x1ed)],_0x3f7ad2=_0x5a19da;_0x3f7ad2<_0xbe5af0;_0x3f7ad2++)_0x4a878f[_0x52101b(0x224)](_0x1c8664[_0x52101b(0x203)](_0x34e322,_0x419ada,_0x1d4e39,_0x3f7ad2,_0x3004c6));_0x1ba96a[_0x52101b(0x191)]=!0x0;}else{for(_0x5a19da=0x0,_0xbe5af0=_0x9deb2e,_0x3f7ad2=_0x5a19da;_0x3f7ad2<_0xbe5af0;_0x3f7ad2++)_0x4a878f[_0x52101b(0x224)](_0x1c8664[_0x52101b(0x203)](_0x34e322,_0x419ada,_0x1d4e39,_0x3f7ad2,_0x3004c6));}_0x3004c6['autoExpandPropertyCount']+=_0x4a878f[_0x52101b(0x1d1)];}if(!(_0x1d4e39==='null'||_0x1d4e39===_0x52101b(0x189))&&!_0x3d2341&&_0x1d4e39!=='String'&&_0x1d4e39!==_0x52101b(0x188)&&_0x1d4e39!==_0x52101b(0x21f)){var _0x1b41e0=_0x23285c[_0x52101b(0x20e)]||_0x3004c6[_0x52101b(0x20e)];if(this[_0x52101b(0x1ca)](_0x419ada)?(_0x3f7ad2=0x0,_0x419ada[_0x52101b(0x176)](function(_0x1f7b54){var _0x1aeb08=_0x52101b;if(_0xdcc88f++,_0x3004c6[_0x1aeb08(0x220)]++,_0xdcc88f>_0x1b41e0){_0xdf5cfb=!0x0;return;}if(!_0x3004c6['isExpressionToEvaluate']&&_0x3004c6['autoExpand']&&_0x3004c6[_0x1aeb08(0x220)]>_0x3004c6[_0x1aeb08(0x21b)]){_0xdf5cfb=!0x0;return;}_0x4a878f[_0x1aeb08(0x224)](_0x1c8664['_addProperty'](_0x34e322,_0x419ada,_0x1aeb08(0x20b),_0x3f7ad2++,_0x3004c6,function(_0x557183){return function(){return _0x557183;};}(_0x1f7b54)));})):this[_0x52101b(0x223)](_0x419ada)&&_0x419ada[_0x52101b(0x176)](function(_0x546271,_0x30e629){var _0x11e7fe=_0x52101b;if(_0xdcc88f++,_0x3004c6[_0x11e7fe(0x220)]++,_0xdcc88f>_0x1b41e0){_0xdf5cfb=!0x0;return;}if(!_0x3004c6[_0x11e7fe(0x1e5)]&&_0x3004c6[_0x11e7fe(0x1c2)]&&_0x3004c6[_0x11e7fe(0x220)]>_0x3004c6[_0x11e7fe(0x21b)]){_0xdf5cfb=!0x0;return;}var _0x4b5336=_0x30e629[_0x11e7fe(0x195)]();_0x4b5336[_0x11e7fe(0x1d1)]>0x64&&(_0x4b5336=_0x4b5336[_0x11e7fe(0x211)](0x0,0x64)+_0x11e7fe(0x1e6)),_0x4a878f[_0x11e7fe(0x224)](_0x1c8664['_addProperty'](_0x34e322,_0x419ada,'Map',_0x4b5336,_0x3004c6,function(_0xa538d4){return function(){return _0xa538d4;};}(_0x546271)));}),!_0x5ad48a){try{for(_0x2e1e2c in _0x419ada)if(!(_0x5c52d2&&_0x409775[_0x52101b(0x17e)](_0x2e1e2c))&&!this[_0x52101b(0x177)](_0x419ada,_0x2e1e2c,_0x3004c6)){if(_0xdcc88f++,_0x3004c6[_0x52101b(0x220)]++,_0xdcc88f>_0x1b41e0){_0xdf5cfb=!0x0;break;}if(!_0x3004c6[_0x52101b(0x1e5)]&&_0x3004c6[_0x52101b(0x1c2)]&&_0x3004c6[_0x52101b(0x220)]>_0x3004c6[_0x52101b(0x21b)]){_0xdf5cfb=!0x0;break;}_0x4a878f[_0x52101b(0x224)](_0x1c8664[_0x52101b(0x1d5)](_0x34e322,_0x5a08d6,_0x419ada,_0x1d4e39,_0x2e1e2c,_0x3004c6));}}catch{}if(_0x5a08d6[_0x52101b(0x1a5)]=!0x0,_0x459373&&(_0x5a08d6[_0x52101b(0x175)]=!0x0),!_0xdf5cfb){var _0x554c82=[][_0x52101b(0x1a2)](this[_0x52101b(0x1c3)](_0x419ada))[_0x52101b(0x1a2)](this['_getOwnPropertySymbols'](_0x419ada));for(_0x3f7ad2=0x0,_0x9deb2e=_0x554c82[_0x52101b(0x1d1)];_0x3f7ad2<_0x9deb2e;_0x3f7ad2++)if(_0x2e1e2c=_0x554c82[_0x3f7ad2],!(_0x5c52d2&&_0x409775['test'](_0x2e1e2c['toString']()))&&!this['_blacklistedProperty'](_0x419ada,_0x2e1e2c,_0x3004c6)&&!_0x5a08d6[_0x52101b(0x1de)+_0x2e1e2c[_0x52101b(0x195)]()]){if(_0xdcc88f++,_0x3004c6['autoExpandPropertyCount']++,_0xdcc88f>_0x1b41e0){_0xdf5cfb=!0x0;break;}if(!_0x3004c6[_0x52101b(0x1e5)]&&_0x3004c6[_0x52101b(0x1c2)]&&_0x3004c6[_0x52101b(0x220)]>_0x3004c6[_0x52101b(0x21b)]){_0xdf5cfb=!0x0;break;}_0x4a878f['push'](_0x1c8664[_0x52101b(0x1d5)](_0x34e322,_0x5a08d6,_0x419ada,_0x1d4e39,_0x2e1e2c,_0x3004c6));}}}}}if(_0x1ba96a[_0x52101b(0x1cc)]=_0x1d4e39,_0x1aa361?(_0x1ba96a[_0x52101b(0x21d)]=_0x419ada['valueOf'](),this['_capIfString'](_0x1d4e39,_0x1ba96a,_0x3004c6,_0x23285c)):_0x1d4e39==='date'?_0x1ba96a['value']=this[_0x52101b(0x1f0)][_0x52101b(0x1bf)](_0x419ada):_0x1d4e39===_0x52101b(0x21f)?_0x1ba96a[_0x52101b(0x21d)]=_0x419ada[_0x52101b(0x195)]():_0x1d4e39===_0x52101b(0x20f)?_0x1ba96a[_0x52101b(0x21d)]=this[_0x52101b(0x1a0)][_0x52101b(0x1bf)](_0x419ada):_0x1d4e39===_0x52101b(0x1a9)&&this[_0x52101b(0x1e4)]?_0x1ba96a[_0x52101b(0x21d)]=this[_0x52101b(0x1e4)][_0x52101b(0x21c)][_0x52101b(0x195)][_0x52101b(0x1bf)](_0x419ada):!_0x3004c6['depth']&&!(_0x1d4e39===_0x52101b(0x17f)||_0x1d4e39===_0x52101b(0x189))&&(delete _0x1ba96a[_0x52101b(0x21d)],_0x1ba96a[_0x52101b(0x1f7)]=!0x0),_0xdf5cfb&&(_0x1ba96a[_0x52101b(0x1e7)]=!0x0),_0x3279a8=_0x3004c6[_0x52101b(0x1f8)][_0x52101b(0x222)],_0x3004c6[_0x52101b(0x1f8)][_0x52101b(0x222)]=_0x1ba96a,this[_0x52101b(0x1b5)](_0x1ba96a,_0x3004c6),_0x4a878f[_0x52101b(0x1d1)]){for(_0x3f7ad2=0x0,_0x9deb2e=_0x4a878f[_0x52101b(0x1d1)];_0x3f7ad2<_0x9deb2e;_0x3f7ad2++)_0x4a878f[_0x3f7ad2](_0x3f7ad2);}_0x34e322[_0x52101b(0x1d1)]&&(_0x1ba96a[_0x52101b(0x20e)]=_0x34e322);}catch(_0xe4c878){_0x1d4d1c(_0xe4c878,_0x1ba96a,_0x3004c6);}return this[_0x52101b(0x1fb)](_0x419ada,_0x1ba96a),this[_0x52101b(0x184)](_0x1ba96a,_0x3004c6),_0x3004c6['node'][_0x52101b(0x222)]=_0x3279a8,_0x3004c6['level']--,_0x3004c6[_0x52101b(0x1c2)]=_0x47319f,_0x3004c6['autoExpand']&&_0x3004c6[_0x52101b(0x212)][_0x52101b(0x1fe)](),_0x1ba96a;}[_0x5912e5(0x23f)](_0xd20534){var _0x1a6f2d=_0x5912e5;return Object[_0x1a6f2d(0x1ec)]?Object[_0x1a6f2d(0x1ec)](_0xd20534):[];}[_0x5912e5(0x1ca)](_0x45c351){var _0x54463a=_0x5912e5;return!!(_0x45c351&&_0x384dc5[_0x54463a(0x20b)]&&this[_0x54463a(0x165)](_0x45c351)===_0x54463a(0x1af)&&_0x45c351[_0x54463a(0x176)]);}[_0x5912e5(0x177)](_0x377af6,_0x24e8c3,_0x4736ec){var _0x27f3d7=_0x5912e5;return _0x4736ec['noFunctions']?typeof _0x377af6[_0x24e8c3]==_0x27f3d7(0x22b):!0x1;}[_0x5912e5(0x17d)](_0x57a6c7){var _0x31f40a=_0x5912e5,_0x44847c='';return _0x44847c=typeof _0x57a6c7,_0x44847c===_0x31f40a(0x18e)?this[_0x31f40a(0x165)](_0x57a6c7)===_0x31f40a(0x1f5)?_0x44847c=_0x31f40a(0x1fa):this[_0x31f40a(0x165)](_0x57a6c7)===_0x31f40a(0x1f3)?_0x44847c=_0x31f40a(0x18b):this['_objectToString'](_0x57a6c7)==='[object\\x20BigInt]'?_0x44847c=_0x31f40a(0x21f):_0x57a6c7===null?_0x44847c=_0x31f40a(0x17f):_0x57a6c7[_0x31f40a(0x16d)]&&(_0x44847c=_0x57a6c7[_0x31f40a(0x16d)]['name']||_0x44847c):_0x44847c==='undefined'&&this['_HTMLAllCollection']&&_0x57a6c7 instanceof this[_0x31f40a(0x1a4)]&&(_0x44847c=_0x31f40a(0x1bb)),_0x44847c;}[_0x5912e5(0x165)](_0x59fcb1){var _0x481305=_0x5912e5;return Object['prototype'][_0x481305(0x195)][_0x481305(0x1bf)](_0x59fcb1);}['_isPrimitiveType'](_0x3a076e){var _0x6cbc0e=_0x5912e5;return _0x3a076e===_0x6cbc0e(0x209)||_0x3a076e==='string'||_0x3a076e===_0x6cbc0e(0x185);}[_0x5912e5(0x1e8)](_0x22dd2e){return _0x22dd2e==='Boolean'||_0x22dd2e==='String'||_0x22dd2e==='Number';}[_0x5912e5(0x203)](_0x1be0d5,_0x2da560,_0x28632c,_0x43237f,_0x430074,_0x5b6029){var _0x1ae446=this;return function(_0x52ed33){var _0x32ee17=_0x3f94,_0x4b490e=_0x430074[_0x32ee17(0x1f8)][_0x32ee17(0x222)],_0x1534c1=_0x430074[_0x32ee17(0x1f8)][_0x32ee17(0x217)],_0x2c6c0e=_0x430074[_0x32ee17(0x1f8)]['parent'];_0x430074[_0x32ee17(0x1f8)][_0x32ee17(0x1c0)]=_0x4b490e,_0x430074[_0x32ee17(0x1f8)][_0x32ee17(0x217)]=typeof _0x43237f=='number'?_0x43237f:_0x52ed33,_0x1be0d5[_0x32ee17(0x224)](_0x1ae446['_property'](_0x2da560,_0x28632c,_0x43237f,_0x430074,_0x5b6029)),_0x430074[_0x32ee17(0x1f8)][_0x32ee17(0x1c0)]=_0x2c6c0e,_0x430074[_0x32ee17(0x1f8)][_0x32ee17(0x217)]=_0x1534c1;};}['_addObjectProperty'](_0x3afc74,_0x407384,_0x3f2e6c,_0x3dbb3e,_0x2d0884,_0x4cde95,_0x2b5643){var _0x14b5d7=_0x5912e5,_0x17893f=this;return _0x407384['_p_'+_0x2d0884[_0x14b5d7(0x195)]()]=!0x0,function(_0x1e4366){var _0x682fa5=_0x14b5d7,_0xb58057=_0x4cde95[_0x682fa5(0x1f8)][_0x682fa5(0x222)],_0x469bbe=_0x4cde95[_0x682fa5(0x1f8)][_0x682fa5(0x217)],_0x2af95d=_0x4cde95['node'][_0x682fa5(0x1c0)];_0x4cde95[_0x682fa5(0x1f8)][_0x682fa5(0x1c0)]=_0xb58057,_0x4cde95[_0x682fa5(0x1f8)]['index']=_0x1e4366,_0x3afc74['push'](_0x17893f[_0x682fa5(0x1be)](_0x3f2e6c,_0x3dbb3e,_0x2d0884,_0x4cde95,_0x2b5643)),_0x4cde95[_0x682fa5(0x1f8)][_0x682fa5(0x1c0)]=_0x2af95d,_0x4cde95[_0x682fa5(0x1f8)]['index']=_0x469bbe;};}['_property'](_0x1f9887,_0x5c8d93,_0x225e23,_0x1ddef1,_0x5bc1a0){var _0x2c90bd=_0x5912e5,_0xfc98d6=this;_0x5bc1a0||(_0x5bc1a0=function(_0x22266d,_0x305222){return _0x22266d[_0x305222];});var _0x262d43=_0x225e23[_0x2c90bd(0x195)](),_0x5911d2=_0x1ddef1[_0x2c90bd(0x1bc)]||{},_0x6425e8=_0x1ddef1[_0x2c90bd(0x219)],_0x2bd7b2=_0x1ddef1[_0x2c90bd(0x1e5)];try{var _0x1581dc=this[_0x2c90bd(0x223)](_0x1f9887),_0x1130c7=_0x262d43;_0x1581dc&&_0x1130c7[0x0]==='\\x27'&&(_0x1130c7=_0x1130c7[_0x2c90bd(0x1da)](0x1,_0x1130c7['length']-0x2));var _0x1329b9=_0x1ddef1[_0x2c90bd(0x1bc)]=_0x5911d2[_0x2c90bd(0x1de)+_0x1130c7];_0x1329b9&&(_0x1ddef1[_0x2c90bd(0x219)]=_0x1ddef1[_0x2c90bd(0x219)]+0x1),_0x1ddef1[_0x2c90bd(0x1e5)]=!!_0x1329b9;var _0x4f9e59=typeof _0x225e23=='symbol',_0x2bc457={'name':_0x4f9e59||_0x1581dc?_0x262d43:this[_0x2c90bd(0x193)](_0x262d43)};if(_0x4f9e59&&(_0x2bc457[_0x2c90bd(0x1a9)]=!0x0),!(_0x5c8d93===_0x2c90bd(0x1fa)||_0x5c8d93===_0x2c90bd(0x1d7))){var _0x1ec3c6=this['_getOwnPropertyDescriptor'](_0x1f9887,_0x225e23);if(_0x1ec3c6&&(_0x1ec3c6[_0x2c90bd(0x1dc)]&&(_0x2bc457[_0x2c90bd(0x242)]=!0x0),_0x1ec3c6[_0x2c90bd(0x1dd)]&&!_0x1329b9&&!_0x1ddef1['resolveGetters']))return _0x2bc457[_0x2c90bd(0x1d2)]=!0x0,this[_0x2c90bd(0x215)](_0x2bc457,_0x1ddef1),_0x2bc457;}var _0x32b374;try{_0x32b374=_0x5bc1a0(_0x1f9887,_0x225e23);}catch(_0x4381cf){return _0x2bc457={'name':_0x262d43,'type':'unknown','error':_0x4381cf[_0x2c90bd(0x194)]},this[_0x2c90bd(0x215)](_0x2bc457,_0x1ddef1),_0x2bc457;}var _0x32b07a=this[_0x2c90bd(0x17d)](_0x32b374),_0x3af8f9=this[_0x2c90bd(0x207)](_0x32b07a);if(_0x2bc457['type']=_0x32b07a,_0x3af8f9)this[_0x2c90bd(0x215)](_0x2bc457,_0x1ddef1,_0x32b374,function(){var _0x556f2e=_0x2c90bd;_0x2bc457['value']=_0x32b374[_0x556f2e(0x205)](),!_0x1329b9&&_0xfc98d6[_0x556f2e(0x161)](_0x32b07a,_0x2bc457,_0x1ddef1,{});});else{var _0x9cf54f=_0x1ddef1[_0x2c90bd(0x1c2)]&&_0x1ddef1['level']<_0x1ddef1[_0x2c90bd(0x1a6)]&&_0x1ddef1[_0x2c90bd(0x212)]['indexOf'](_0x32b374)<0x0&&_0x32b07a!==_0x2c90bd(0x22b)&&_0x1ddef1[_0x2c90bd(0x220)]<_0x1ddef1['autoExpandLimit'];_0x9cf54f||_0x1ddef1['level']<_0x6425e8||_0x1329b9?(this[_0x2c90bd(0x1cb)](_0x2bc457,_0x32b374,_0x1ddef1,_0x1329b9||{}),this[_0x2c90bd(0x1fb)](_0x32b374,_0x2bc457)):this[_0x2c90bd(0x215)](_0x2bc457,_0x1ddef1,_0x32b374,function(){var _0x27559a=_0x2c90bd;_0x32b07a===_0x27559a(0x17f)||_0x32b07a==='undefined'||(delete _0x2bc457['value'],_0x2bc457[_0x27559a(0x1f7)]=!0x0);});}return _0x2bc457;}finally{_0x1ddef1[_0x2c90bd(0x1bc)]=_0x5911d2,_0x1ddef1[_0x2c90bd(0x219)]=_0x6425e8,_0x1ddef1[_0x2c90bd(0x1e5)]=_0x2bd7b2;}}[_0x5912e5(0x161)](_0x345c32,_0x7d969d,_0x547071,_0x3e8119){var _0x16ec57=_0x5912e5,_0x3023b7=_0x3e8119[_0x16ec57(0x166)]||_0x547071[_0x16ec57(0x166)];if((_0x345c32===_0x16ec57(0x18a)||_0x345c32===_0x16ec57(0x15e))&&_0x7d969d['value']){let _0x3ac2ce=_0x7d969d[_0x16ec57(0x21d)][_0x16ec57(0x1d1)];_0x547071[_0x16ec57(0x15f)]+=_0x3ac2ce,_0x547071[_0x16ec57(0x15f)]>_0x547071[_0x16ec57(0x1f2)]?(_0x7d969d['capped']='',delete _0x7d969d[_0x16ec57(0x21d)]):_0x3ac2ce>_0x3023b7&&(_0x7d969d[_0x16ec57(0x1f7)]=_0x7d969d['value'][_0x16ec57(0x1da)](0x0,_0x3023b7),delete _0x7d969d['value']);}}[_0x5912e5(0x223)](_0x424199){var _0x5572ec=_0x5912e5;return!!(_0x424199&&_0x384dc5[_0x5572ec(0x236)]&&this[_0x5572ec(0x165)](_0x424199)===_0x5572ec(0x235)&&_0x424199[_0x5572ec(0x176)]);}[_0x5912e5(0x193)](_0x5f5383){var _0x2e11de=_0x5912e5;if(_0x5f5383[_0x2e11de(0x20a)](/^\\d+$/))return _0x5f5383;var _0x1aa966;try{_0x1aa966=JSON[_0x2e11de(0x23c)](''+_0x5f5383);}catch{_0x1aa966='\\x22'+this[_0x2e11de(0x165)](_0x5f5383)+'\\x22';}return _0x1aa966[_0x2e11de(0x20a)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x1aa966=_0x1aa966[_0x2e11de(0x1da)](0x1,_0x1aa966[_0x2e11de(0x1d1)]-0x2):_0x1aa966=_0x1aa966['replace'](/'/g,'\\x5c\\x27')['replace'](/\\\\\"/g,'\\x22')[_0x2e11de(0x1d0)](/(^\"|\"$)/g,'\\x27'),_0x1aa966;}[_0x5912e5(0x215)](_0x171c93,_0x4fee24,_0x2ca4b4,_0xedf8ed){var _0x535373=_0x5912e5;this[_0x535373(0x1b5)](_0x171c93,_0x4fee24),_0xedf8ed&&_0xedf8ed(),this['_additionalMetadata'](_0x2ca4b4,_0x171c93),this[_0x535373(0x184)](_0x171c93,_0x4fee24);}[_0x5912e5(0x1b5)](_0x2ebd83,_0x3f9e0f){var _0x534d40=_0x5912e5;this['_setNodeId'](_0x2ebd83,_0x3f9e0f),this['_setNodeQueryPath'](_0x2ebd83,_0x3f9e0f),this['_setNodeExpressionPath'](_0x2ebd83,_0x3f9e0f),this[_0x534d40(0x204)](_0x2ebd83,_0x3f9e0f);}[_0x5912e5(0x1d8)](_0x2e933c,_0x385494){}[_0x5912e5(0x19e)](_0xc261d6,_0x25eac6){}['_setNodeLabel'](_0x286b09,_0x35b50a){}[_0x5912e5(0x198)](_0x2e91fa){var _0x2d27dc=_0x5912e5;return _0x2e91fa===this[_0x2d27dc(0x202)];}[_0x5912e5(0x184)](_0x5c8393,_0xe5b471){var _0x176451=_0x5912e5;this[_0x176451(0x1b9)](_0x5c8393,_0xe5b471),this[_0x176451(0x1cd)](_0x5c8393),_0xe5b471['sortProps']&&this[_0x176451(0x168)](_0x5c8393),this[_0x176451(0x1c7)](_0x5c8393,_0xe5b471),this[_0x176451(0x1d4)](_0x5c8393,_0xe5b471),this[_0x176451(0x1c4)](_0x5c8393);}['_additionalMetadata'](_0x1c0865,_0x13e170){var _0x17768a=_0x5912e5;let _0x178c52;try{_0x384dc5[_0x17768a(0x230)]&&(_0x178c52=_0x384dc5['console'][_0x17768a(0x1ff)],_0x384dc5[_0x17768a(0x230)][_0x17768a(0x1ff)]=function(){}),_0x1c0865&&typeof _0x1c0865['length']==_0x17768a(0x185)&&(_0x13e170[_0x17768a(0x1d1)]=_0x1c0865[_0x17768a(0x1d1)]);}catch{}finally{_0x178c52&&(_0x384dc5[_0x17768a(0x230)][_0x17768a(0x1ff)]=_0x178c52);}if(_0x13e170[_0x17768a(0x1cc)]===_0x17768a(0x185)||_0x13e170['type']==='Number'){if(isNaN(_0x13e170[_0x17768a(0x21d)]))_0x13e170['nan']=!0x0,delete _0x13e170[_0x17768a(0x21d)];else switch(_0x13e170[_0x17768a(0x21d)]){case Number['POSITIVE_INFINITY']:_0x13e170[_0x17768a(0x228)]=!0x0,delete _0x13e170[_0x17768a(0x21d)];break;case Number[_0x17768a(0x172)]:_0x13e170['negativeInfinity']=!0x0,delete _0x13e170[_0x17768a(0x21d)];break;case 0x0:this[_0x17768a(0x15c)](_0x13e170[_0x17768a(0x21d)])&&(_0x13e170['negativeZero']=!0x0);break;}}else _0x13e170[_0x17768a(0x1cc)]==='function'&&typeof _0x1c0865['name']=='string'&&_0x1c0865['name']&&_0x13e170[_0x17768a(0x19a)]&&_0x1c0865[_0x17768a(0x19a)]!==_0x13e170[_0x17768a(0x19a)]&&(_0x13e170[_0x17768a(0x214)]=_0x1c0865['name']);}[_0x5912e5(0x15c)](_0xb31628){var _0x2e6c77=_0x5912e5;return 0x1/_0xb31628===Number[_0x2e6c77(0x172)];}[_0x5912e5(0x168)](_0x8d3d1e){var _0x2368dd=_0x5912e5;!_0x8d3d1e[_0x2368dd(0x20e)]||!_0x8d3d1e[_0x2368dd(0x20e)][_0x2368dd(0x1d1)]||_0x8d3d1e[_0x2368dd(0x1cc)]==='array'||_0x8d3d1e[_0x2368dd(0x1cc)]===_0x2368dd(0x236)||_0x8d3d1e[_0x2368dd(0x1cc)]===_0x2368dd(0x20b)||_0x8d3d1e[_0x2368dd(0x20e)]['sort'](function(_0xb287d0,_0x5228d6){var _0x327b1b=_0x2368dd,_0x2f7415=_0xb287d0[_0x327b1b(0x19a)][_0x327b1b(0x240)](),_0x469347=_0x5228d6[_0x327b1b(0x19a)]['toLowerCase']();return _0x2f7415<_0x469347?-0x1:_0x2f7415>_0x469347?0x1:0x0;});}[_0x5912e5(0x1c7)](_0x1a5a3f,_0x35f3d1){var _0xd17398=_0x5912e5;if(!(_0x35f3d1[_0xd17398(0x221)]||!_0x1a5a3f[_0xd17398(0x20e)]||!_0x1a5a3f[_0xd17398(0x20e)]['length'])){for(var _0x5f2780=[],_0x215bf8=[],_0x244d78=0x0,_0x3406fa=_0x1a5a3f[_0xd17398(0x20e)][_0xd17398(0x1d1)];_0x244d78<_0x3406fa;_0x244d78++){var _0x4aaf1c=_0x1a5a3f[_0xd17398(0x20e)][_0x244d78];_0x4aaf1c[_0xd17398(0x1cc)]==='function'?_0x5f2780['push'](_0x4aaf1c):_0x215bf8[_0xd17398(0x224)](_0x4aaf1c);}if(!(!_0x215bf8[_0xd17398(0x1d1)]||_0x5f2780[_0xd17398(0x1d1)]<=0x1)){_0x1a5a3f[_0xd17398(0x20e)]=_0x215bf8;var _0x3112cd={'functionsNode':!0x0,'props':_0x5f2780};this[_0xd17398(0x1d8)](_0x3112cd,_0x35f3d1),this[_0xd17398(0x1b9)](_0x3112cd,_0x35f3d1),this[_0xd17398(0x1cd)](_0x3112cd),this['_setNodePermissions'](_0x3112cd,_0x35f3d1),_0x3112cd['id']+='\\x20f',_0x1a5a3f[_0xd17398(0x20e)][_0xd17398(0x234)](_0x3112cd);}}}[_0x5912e5(0x1d4)](_0x11d010,_0x3657a0){}[_0x5912e5(0x1cd)](_0x5c207f){}[_0x5912e5(0x21a)](_0x5a2d96){var _0xb586dc=_0x5912e5;return Array[_0xb586dc(0x1ac)](_0x5a2d96)||typeof _0x5a2d96==_0xb586dc(0x18e)&&this[_0xb586dc(0x165)](_0x5a2d96)===_0xb586dc(0x1f5);}['_setNodePermissions'](_0x3056a9,_0x476bf7){}[_0x5912e5(0x1c4)](_0x517190){var _0x50a916=_0x5912e5;delete _0x517190[_0x50a916(0x20d)],delete _0x517190[_0x50a916(0x241)],delete _0x517190['_hasMapOnItsPath'];}[_0x5912e5(0x216)](_0x2130d4,_0x1ad273){}}let _0x4dce6d=new _0x2b9a0a(),_0x142575={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x58e9b8={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2};function _0x3e24b2(_0x2f9603,_0x2fddd0,_0xb7ec16,_0xc6d90f,_0x1f87dd,_0x5cb1c7){var _0x5b5563=_0x5912e5;let _0xa7da97,_0x5bbd93;try{_0x5bbd93=_0x363593(),_0xa7da97=_0x216568[_0x2fddd0],!_0xa7da97||_0x5bbd93-_0xa7da97['ts']>0x1f4&&_0xa7da97[_0x5b5563(0x1b3)]&&_0xa7da97['time']/_0xa7da97[_0x5b5563(0x1b3)]<0x64?(_0x216568[_0x2fddd0]=_0xa7da97={'count':0x0,'time':0x0,'ts':_0x5bbd93},_0x216568[_0x5b5563(0x167)]={}):_0x5bbd93-_0x216568[_0x5b5563(0x167)]['ts']>0x32&&_0x216568[_0x5b5563(0x167)][_0x5b5563(0x1b3)]&&_0x216568[_0x5b5563(0x167)]['time']/_0x216568[_0x5b5563(0x167)][_0x5b5563(0x1b3)]<0x64&&(_0x216568[_0x5b5563(0x167)]={});let _0x35f192=[],_0x237445=_0xa7da97['reduceLimits']||_0x216568[_0x5b5563(0x167)]['reduceLimits']?_0x58e9b8:_0x142575,_0x4c9b45=_0x3f9b44=>{var _0x4632f9=_0x5b5563;let _0x19522a={};return _0x19522a[_0x4632f9(0x20e)]=_0x3f9b44[_0x4632f9(0x20e)],_0x19522a[_0x4632f9(0x1ed)]=_0x3f9b44['elements'],_0x19522a[_0x4632f9(0x166)]=_0x3f9b44[_0x4632f9(0x166)],_0x19522a[_0x4632f9(0x1f2)]=_0x3f9b44['totalStrLength'],_0x19522a[_0x4632f9(0x21b)]=_0x3f9b44['autoExpandLimit'],_0x19522a[_0x4632f9(0x1a6)]=_0x3f9b44[_0x4632f9(0x1a6)],_0x19522a[_0x4632f9(0x1d6)]=!0x1,_0x19522a[_0x4632f9(0x221)]=!_0x22a91d,_0x19522a['depth']=0x1,_0x19522a[_0x4632f9(0x1fc)]=0x0,_0x19522a[_0x4632f9(0x1df)]=_0x4632f9(0x1aa),_0x19522a['rootExpression']=_0x4632f9(0x23d),_0x19522a[_0x4632f9(0x1c2)]=!0x0,_0x19522a[_0x4632f9(0x212)]=[],_0x19522a['autoExpandPropertyCount']=0x0,_0x19522a[_0x4632f9(0x1cf)]=!0x0,_0x19522a[_0x4632f9(0x15f)]=0x0,_0x19522a[_0x4632f9(0x1f8)]={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x19522a;};for(var _0x18ac01=0x0;_0x18ac01<_0x1f87dd[_0x5b5563(0x1d1)];_0x18ac01++)_0x35f192['push'](_0x4dce6d[_0x5b5563(0x1cb)]({'timeNode':_0x2f9603==='time'||void 0x0},_0x1f87dd[_0x18ac01],_0x4c9b45(_0x237445),{}));if(_0x2f9603===_0x5b5563(0x19c)){let _0x876c60=Error[_0x5b5563(0x18d)];try{Error[_0x5b5563(0x18d)]=0x1/0x0,_0x35f192[_0x5b5563(0x224)](_0x4dce6d[_0x5b5563(0x1cb)]({'stackNode':!0x0},new Error()['stack'],_0x4c9b45(_0x237445),{'strLength':0x1/0x0}));}finally{Error[_0x5b5563(0x18d)]=_0x876c60;}}return{'method':'log','version':_0x368218,'args':[{'ts':_0xb7ec16,'session':_0xc6d90f,'args':_0x35f192,'id':_0x2fddd0,'context':_0x5cb1c7}]};}catch(_0x43cd40){return{'method':'log','version':_0x368218,'args':[{'ts':_0xb7ec16,'session':_0xc6d90f,'args':[{'type':'unknown','error':_0x43cd40&&_0x43cd40[_0x5b5563(0x194)]}],'id':_0x2fddd0,'context':_0x5cb1c7}]};}finally{try{if(_0xa7da97&&_0x5bbd93){let _0x3f23c0=_0x363593();_0xa7da97['count']++,_0xa7da97['time']+=_0x40dd8d(_0x5bbd93,_0x3f23c0),_0xa7da97['ts']=_0x3f23c0,_0x216568['hits'][_0x5b5563(0x1b3)]++,_0x216568['hits'][_0x5b5563(0x23a)]+=_0x40dd8d(_0x5bbd93,_0x3f23c0),_0x216568[_0x5b5563(0x167)]['ts']=_0x3f23c0,(_0xa7da97['count']>0x32||_0xa7da97['time']>0x64)&&(_0xa7da97[_0x5b5563(0x16c)]=!0x0),(_0x216568[_0x5b5563(0x167)][_0x5b5563(0x1b3)]>0x3e8||_0x216568['hits'][_0x5b5563(0x23a)]>0x12c)&&(_0x216568[_0x5b5563(0x167)][_0x5b5563(0x16c)]=!0x0);}}catch{}}}return _0x3e24b2;}((_0x337908,_0x179879,_0x4217ad,_0x25f594,_0x23a7cf,_0x5eba63,_0x59ceed,_0x41dd80,_0x51a490,_0x18fb5e)=>{var _0x4f03d4=_0x17e9a5;if(_0x337908[_0x4f03d4(0x23e)])return _0x337908['_console_ninja'];if(!J(_0x337908,_0x41dd80,_0x23a7cf))return _0x337908[_0x4f03d4(0x23e)]={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'coverage':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x337908[_0x4f03d4(0x23e)];let _0x16127c=W(_0x337908),_0xf09a27=_0x16127c[_0x4f03d4(0x1a3)],_0x14b12d=_0x16127c[_0x4f03d4(0x1ce)],_0x4fcc27=_0x16127c[_0x4f03d4(0x1ba)],_0x19af8f={'hits':{},'ts':{}},_0x194441=Y(_0x337908,_0x51a490,_0x19af8f,_0x5eba63),_0x56035a=_0x364d52=>{_0x19af8f['ts'][_0x364d52]=_0x14b12d();},_0x14aac6=(_0x4e4eca,_0x979543)=>{var _0x4b0bc8=_0x4f03d4;let _0x5efd02=_0x19af8f['ts'][_0x979543];if(delete _0x19af8f['ts'][_0x979543],_0x5efd02){let _0x525aa3=_0xf09a27(_0x5efd02,_0x14b12d());_0x23cf08(_0x194441(_0x4b0bc8(0x23a),_0x4e4eca,_0x4fcc27(),_0x31de31,[_0x525aa3],_0x979543));}},_0x3c7950=_0x1068a4=>_0x20fe32=>{var _0x21bdb8=_0x4f03d4;try{_0x56035a(_0x20fe32),_0x1068a4(_0x20fe32);}finally{_0x337908['console'][_0x21bdb8(0x23a)]=_0x1068a4;}},_0x30fb21=_0x364688=>_0x2500e7=>{var _0x2ddfb0=_0x4f03d4;try{let [_0x38c190,_0x4a401e]=_0x2500e7[_0x2ddfb0(0x182)](_0x2ddfb0(0x1e0));_0x14aac6(_0x4a401e,_0x38c190),_0x364688(_0x38c190);}finally{_0x337908[_0x2ddfb0(0x230)]['timeEnd']=_0x364688;}};_0x337908[_0x4f03d4(0x23e)]={'consoleLog':(_0xa74805,_0x8c3aaa)=>{var _0x59b540=_0x4f03d4;_0x337908[_0x59b540(0x230)]['log'][_0x59b540(0x19a)]!=='disabledLog'&&_0x23cf08(_0x194441(_0x59b540(0x1ea),_0xa74805,_0x4fcc27(),_0x31de31,_0x8c3aaa));},'consoleTrace':(_0x561720,_0x7df83c)=>{var _0x4fe14e=_0x4f03d4;_0x337908[_0x4fe14e(0x230)][_0x4fe14e(0x1ea)][_0x4fe14e(0x19a)]!==_0x4fe14e(0x225)&&_0x23cf08(_0x194441(_0x4fe14e(0x19c),_0x561720,_0x4fcc27(),_0x31de31,_0x7df83c));},'consoleTime':()=>{var _0x483085=_0x4f03d4;_0x337908[_0x483085(0x230)][_0x483085(0x23a)]=_0x3c7950(_0x337908[_0x483085(0x230)][_0x483085(0x23a)]);},'consoleTimeEnd':()=>{var _0x34673d=_0x4f03d4;_0x337908[_0x34673d(0x230)][_0x34673d(0x200)]=_0x30fb21(_0x337908[_0x34673d(0x230)][_0x34673d(0x200)]);},'autoLog':(_0x46e03b,_0x39c785)=>{_0x23cf08(_0x194441('log',_0x39c785,_0x4fcc27(),_0x31de31,[_0x46e03b]));},'autoLogMany':(_0x5e5c6a,_0x284614)=>{var _0x42a3db=_0x4f03d4;_0x23cf08(_0x194441(_0x42a3db(0x1ea),_0x5e5c6a,_0x4fcc27(),_0x31de31,_0x284614));},'autoTrace':(_0x5b7543,_0x3c52f2)=>{var _0x552adb=_0x4f03d4;_0x23cf08(_0x194441(_0x552adb(0x19c),_0x3c52f2,_0x4fcc27(),_0x31de31,[_0x5b7543]));},'autoTraceMany':(_0x3d2cc6,_0x3688bd)=>{var _0x4d8045=_0x4f03d4;_0x23cf08(_0x194441(_0x4d8045(0x19c),_0x3d2cc6,_0x4fcc27(),_0x31de31,_0x3688bd));},'autoTime':(_0x44306b,_0xd0381a,_0x4f3df8)=>{_0x56035a(_0x4f3df8);},'autoTimeEnd':(_0x17bb31,_0x48c56c,_0x1f00e8)=>{_0x14aac6(_0x48c56c,_0x1f00e8);},'coverage':_0x22eabe=>{_0x23cf08({'method':'coverage','version':_0x5eba63,'args':[{'id':_0x22eabe}]});}};let _0x23cf08=b(_0x337908,_0x179879,_0x4217ad,_0x25f594,_0x23a7cf,_0x18fb5e),_0x31de31=_0x337908['_console_ninja_session'];return _0x337908[_0x4f03d4(0x23e)];})(globalThis,_0x17e9a5(0x1ad),_0x17e9a5(0x19b),_0x17e9a5(0x229),_0x17e9a5(0x232),_0x17e9a5(0x22f),_0x17e9a5(0x1c9),_0x17e9a5(0x19d),'',_0x17e9a5(0x1f4));function _0x4daf(){var _0x2c83ee=[[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"HidekiWatanabe\",\"26.122.76.151\",\"168.192.0.107\"],'_setNodeQueryPath','10549098ZHkDfj','_regExpToString','_connected','concat','elapsed','_HTMLAllCollection','_p_length','autoExpandMaxDepth','defineProperty','warn','symbol','root_exp_id','18UqVPhN','isArray','127.0.0.1','default','[object\\x20Set]','_webSocketErrorDocsLink','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20','nodeModules','count','_reconnectTimeout','_treeNodePropertiesBeforeFullValue','readyState','versions','join','_setNodeLabel','now','HTMLAllCollection','expressionsToEvaluate','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','_property','call','parent','187768pnXuZj','autoExpand','_getOwnPropertyNames','_cleanNode','_WebSocketClass','host','_addFunctionsNode','_connecting','1700490795708','_isSet','serialize','type','_setNodeExpandableState','timeStamp','resolveGetters','replace','length','getter','reload','_addLoadNode','_addObjectProperty','sortProps','Error','_setNodeId','next.js','substr','send','set','get','_p_','expId',':logPointId:','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20','path','hasOwnProperty','_Symbol','isExpressionToEvaluate','...','cappedProps','_isPrimitiveWrapperType','url','log','onopen','getOwnPropertySymbols','elements','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','_keyStrRegExp','_dateToString','_attemptToReconnectShortly','totalStrLength','[object\\x20Date]','','[object\\x20Array]','enumerable','capped','node','then','array','_additionalMetadata','level','port','pop','error','timeEnd','ws://','_undefined','_addProperty','_setNodePermissions','valueOf','_consoleNinjaAllowedToStart','_isPrimitiveType','363ZYVAyU','boolean','match','Set','onmessage','_hasSymbolPropertyOnItsPath','props','RegExp','global','slice','autoExpandPreviousObjects','\\x20browser','funcName','_processTreeNodeResult','_setNodeExpressionPath','index','2382wEdONV','depth','_isArray','autoExpandLimit','prototype','value','close','bigint','autoExpandPropertyCount','noFunctions','current','_isMap','push','disabledTrace','edge','hostname','positiveInfinity',\"c:\\\\Users\\\\William Hoom\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-1.0.260\\\\node_modules\",'_allowedToSend','function','pathToFileURL','performance','getPrototypeOf','1.0.0','console','_socket','webpack','location','unshift','[object\\x20Map]','Map','perf_hooks','_inNextEdge','\\x20server','time','onerror','stringify','root_exp','_console_ninja','_getOwnPropertySymbols','toLowerCase','_hasSetOnItsPath','setter','ws/index.js','_connectAttemptCount','_allowedToConnectOnSend','unref','_isNegativeZero','getOwnPropertyDescriptor','String','allStrLength','1119480wMIyrp','_capIfString','_sendErrorMessage','WebSocket','_disposeWebsocket','_objectToString','strLength','hits','_sortProps','_quotedRegExp','_console_ninja_session','__es'+'Module','reduceLimits','constructor','_maxConnectAttemptCount','_numberRegExp','_WebSocket','_inBrowser','NEGATIVE_INFINITY','env','_connectToHostNow','_p_name','forEach','_blacklistedProperty','logger\\x20websocket\\x20error','onclose','184954oxnhpr','dockerizedApp','NEXT_RUNTIME','_type','test','null','1514950RlskIU','getOwnPropertyNames','split','process','_treeNodePropertiesAfterFullValue','number','428631HRtQpr','_ws','Buffer','undefined','string','date','create','stackTraceLimit','object','bind','catch','cappedElements','gateway.docker.internal','_propertyName','message','toString','Symbol','hrtime','_isUndefined','parse','name','52100','trace'];_0x4daf=function(){return _0x2c83ee;};return _0x4daf();}");}catch(e){}};function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint unicorn/no-abusive-eslint-disable:,eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
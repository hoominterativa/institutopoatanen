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
/* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';function _0x578d(_0x4e6c1a,_0x582af6){var _0x314cba=_0x314c();return _0x578d=function(_0x578d11,_0x105e51){_0x578d11=_0x578d11-0x1a2;var _0x3b38bc=_0x314cba[_0x578d11];return _0x3b38bc;},_0x578d(_0x4e6c1a,_0x582af6);}function _0x314c(){var _0x2e9d21=['host','_connected','_connectToHostNow','split',\"c:\\\\Users\\\\benvi\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-0.0.199\\\\node_modules\",'_keyStrRegExp','array','trace','_attemptToReconnectShortly','negativeZero','_p_name','1965922rYzVKH','_propertyName','_setNodeExpressionPath','resolveGetters','root_exp_id','autoExpandMaxDepth','[object\\x20Date]','replace','totalStrLength','reduceLimits','_WebSocketClass','now','...','match','depth','_propertyAccessor','onmessage','onopen','17808NPPqTh','_additionalMetadata','_consoleNinjaAllowedToStart','POSITIVE_INFINITY','type','index','stackTraceLimit','_getOwnPropertyNames','[object\\x20Array]','getWebSocketClass','method','_objectToString','forEach','date','catch','127.0.0.1','_quotedRegExp','_setNodePermissions','level','data','unref','_reconnectTimeout','capped','remix','enumerable','hits','create','elapsed','failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','nodeModules','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20','toString','4414Xbesdi','10izQufv','perf_hooks','error','set','defineProperty','number','RegExp','expressionsToEvaluate','length','_connecting','872150RZZLha','__es'+'Module','_webSocketErrorDocsLink','logger\\x20websocket\\x20error','_disposeWebsocket','getOwnPropertyNames','negativeInfinity','null','parse','expId','reload','_addObjectProperty','_undefined','serialize','boolean','object','hostname','_console_ninja','Boolean','concat','_treeNodePropertiesAfterFullValue','symbol','_dateToString','string','name','getOwnPropertyDescriptor','','noFunctions','then','count','autoExpandPropertyCount','_processTreeNodeResult','24cIOBYG','ws/index.js','isArray','2153129WuUNjX','props','send','sortProps','elements','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','slice','_socket','_connectAttemptCount','_property','onclose','_allowedToConnectOnSend','disabledLog','_isPrimitiveType','allStrLength','_getOwnPropertyDescriptor','message','log','\\x20server','getter','global','Number','cappedElements','_addProperty','autoExpandPreviousObjects','_addLoadNode','performance','hasOwnProperty','readyState','_cleanNode','unknown','NEGATIVE_INFINITY','value','indexOf','pathToFileURL','_blacklistedProperty','_Symbol','_setNodeLabel','hrtime','join','Buffer','_HTMLAllCollection','positiveInfinity','_capIfString','_treeNodePropertiesBeforeFullValue','_setNodeId','stringify','path','nuxt','map','_WebSocket','undefined','_isSet','Map','autoExpandLimit','_setNodeQueryPath','_getOwnPropertySymbols','_isArray','bigint','_isPrimitiveWrapperType','console',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"DESKTOP-GDLJ9TC\",\"192.168.1.6\",\"127.0.2.2\",\"127.0.2.3\"],'constructor','toLowerCase','getOwnPropertySymbols','strLength','versions','isExpressionToEvaluate','_ws','60167','_console_ninja_session','_allowedToSend','pop','push','1692209807787','332ypOonG','4851762UyJTiI','_inBrowser','stack','[object\\x20BigInt]','[object\\x20Set]','autoExpand','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20','timeEnd','_sortProps','call','nan','_isMap','node','Error','onerror','8809317ypYazq','get','Set','WebSocket','warn','_numberRegExp','valueOf','265TFuYhk','prototype','Symbol','root_exp','\\x20browser','_regExpToString','time','_maxConnectAttemptCount','substr','parent','current','String','default','_sendErrorMessage','funcName','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20','process','_p_','_type','port','close','_p_length','location','function','ws://','_isUndefined','test','timeStamp'];_0x314c=function(){return _0x2e9d21;};return _0x314c();}var _0x3ba83d=_0x578d;(function(_0x1086fb,_0x1317d1){var _0x41a152=_0x578d,_0x1de80b=_0x1086fb();while(!![]){try{var _0x15aa31=parseInt(_0x41a152(0x1c7))/0x1*(-parseInt(_0x41a152(0x220))/0x2)+parseInt(_0x41a152(0x200))/0x3*(parseInt(_0x41a152(0x1b0))/0x4)+-parseInt(_0x41a152(0x22b))/0x5+-parseInt(_0x41a152(0x1b1))/0x6+-parseInt(_0x41a152(0x1ee))/0x7*(-parseInt(_0x41a152(0x24b))/0x8)+parseInt(_0x41a152(0x1c0))/0x9+-parseInt(_0x41a152(0x221))/0xa*(parseInt(_0x41a152(0x24e))/0xb);if(_0x15aa31===_0x1317d1)break;else _0x1de80b['push'](_0x1de80b['shift']());}catch(_0x3ecc84){_0x1de80b['push'](_0x1de80b['shift']());}}}(_0x314c,0x865f4));var ue=Object[_0x3ba83d(0x21a)],te=Object[_0x3ba83d(0x225)],he=Object[_0x3ba83d(0x244)],le=Object['getOwnPropertyNames'],fe=Object['getPrototypeOf'],_e=Object[_0x3ba83d(0x1c8)][_0x3ba83d(0x269)],pe=(_0x5e0a2c,_0x75a218,_0x138e52,_0x3df4cb)=>{var _0x6f3f5c=_0x3ba83d;if(_0x75a218&&typeof _0x75a218==_0x6f3f5c(0x23a)||typeof _0x75a218==_0x6f3f5c(0x1de)){for(let _0x1acd38 of le(_0x75a218))!_e[_0x6f3f5c(0x1ba)](_0x5e0a2c,_0x1acd38)&&_0x1acd38!==_0x138e52&&te(_0x5e0a2c,_0x1acd38,{'get':()=>_0x75a218[_0x1acd38],'enumerable':!(_0x3df4cb=he(_0x75a218,_0x1acd38))||_0x3df4cb[_0x6f3f5c(0x218)]});}return _0x5e0a2c;},ne=(_0x5b7c89,_0x16cc59,_0x327e06)=>(_0x327e06=_0x5b7c89!=null?ue(fe(_0x5b7c89)):{},pe(_0x16cc59||!_0x5b7c89||!_0x5b7c89[_0x3ba83d(0x22c)]?te(_0x327e06,_0x3ba83d(0x1d3),{'value':_0x5b7c89,'enumerable':!0x0}):_0x327e06,_0x5b7c89)),Q=class{constructor(_0x105d2b,_0x20676b,_0x405712,_0x2c564c){var _0x48e70d=_0x3ba83d;this[_0x48e70d(0x262)]=_0x105d2b,this[_0x48e70d(0x1e3)]=_0x20676b,this[_0x48e70d(0x1da)]=_0x405712,this['nodeModules']=_0x2c564c,this[_0x48e70d(0x1ac)]=!0x0,this[_0x48e70d(0x259)]=!0x0,this[_0x48e70d(0x1e4)]=!0x1,this['_connecting']=!0x1,this[_0x48e70d(0x1b2)]=!!this[_0x48e70d(0x262)][_0x48e70d(0x1c3)],this['_WebSocketClass']=null,this[_0x48e70d(0x256)]=0x0,this[_0x48e70d(0x1ce)]=0x14,this[_0x48e70d(0x22d)]='https://tinyurl.com/37x8b79t',this[_0x48e70d(0x1d4)]=(this[_0x48e70d(0x1b2)]?_0x48e70d(0x1d6):_0x48e70d(0x1b7))+this['_webSocketErrorDocsLink'];}async[_0x3ba83d(0x209)](){var _0x586738=_0x3ba83d;if(this[_0x586738(0x1f8)])return this[_0x586738(0x1f8)];let _0x9085ab;if(this[_0x586738(0x1b2)])_0x9085ab=this[_0x586738(0x262)]['WebSocket'];else{if(this[_0x586738(0x262)][_0x586738(0x1d7)]?.['_WebSocket'])_0x9085ab=this[_0x586738(0x262)][_0x586738(0x1d7)]?.[_0x586738(0x280)];else try{let _0x5b33ba=await import(_0x586738(0x27d));_0x9085ab=(await import((await import('url'))[_0x586738(0x270)](_0x5b33ba['join'](this[_0x586738(0x21d)],_0x586738(0x24c)))[_0x586738(0x21f)]()))[_0x586738(0x1d3)];}catch{try{_0x9085ab=require(require(_0x586738(0x27d))[_0x586738(0x275)](this[_0x586738(0x21d)],'ws'));}catch{throw new Error(_0x586738(0x21c));}}}return this[_0x586738(0x1f8)]=_0x9085ab,_0x9085ab;}['_connectToHostNow'](){var _0x2bfa4b=_0x3ba83d;this[_0x2bfa4b(0x22a)]||this[_0x2bfa4b(0x1e4)]||this[_0x2bfa4b(0x256)]>=this[_0x2bfa4b(0x1ce)]||(this['_allowedToConnectOnSend']=!0x1,this['_connecting']=!0x0,this[_0x2bfa4b(0x256)]++,this['_ws']=new Promise((_0x44af24,_0x2619a0)=>{var _0x37bb19=_0x2bfa4b;this[_0x37bb19(0x209)]()[_0x37bb19(0x247)](_0x6e3122=>{var _0x263a07=_0x37bb19;let _0x17a95c=new _0x6e3122(_0x263a07(0x1df)+this[_0x263a07(0x1e3)]+':'+this[_0x263a07(0x1da)]);_0x17a95c[_0x263a07(0x1bf)]=()=>{var _0x1bc41e=_0x263a07;this[_0x1bc41e(0x1ac)]=!0x1,this['_disposeWebsocket'](_0x17a95c),this[_0x1bc41e(0x1eb)](),_0x2619a0(new Error(_0x1bc41e(0x22e)));},_0x17a95c[_0x263a07(0x1ff)]=()=>{var _0x56034b=_0x263a07;this['_inBrowser']||_0x17a95c[_0x56034b(0x255)]&&_0x17a95c[_0x56034b(0x255)]['unref']&&_0x17a95c[_0x56034b(0x255)]['unref'](),_0x44af24(_0x17a95c);},_0x17a95c[_0x263a07(0x258)]=()=>{var _0xba4898=_0x263a07;this[_0xba4898(0x259)]=!0x0,this[_0xba4898(0x22f)](_0x17a95c),this[_0xba4898(0x1eb)]();},_0x17a95c[_0x263a07(0x1fe)]=_0x4432d7=>{var _0xcf0a94=_0x263a07;try{_0x4432d7&&_0x4432d7[_0xcf0a94(0x213)]&&this['_inBrowser']&&JSON[_0xcf0a94(0x233)](_0x4432d7[_0xcf0a94(0x213)])[_0xcf0a94(0x20a)]===_0xcf0a94(0x235)&&this[_0xcf0a94(0x262)][_0xcf0a94(0x1dd)]['reload']();}catch{}};})[_0x37bb19(0x247)](_0x334fab=>(this[_0x37bb19(0x1e4)]=!0x0,this[_0x37bb19(0x22a)]=!0x1,this[_0x37bb19(0x259)]=!0x1,this[_0x37bb19(0x1ac)]=!0x0,this[_0x37bb19(0x256)]=0x0,_0x334fab))[_0x37bb19(0x20e)](_0x329315=>(this[_0x37bb19(0x1e4)]=!0x1,this['_connecting']=!0x1,console[_0x37bb19(0x1c4)](_0x37bb19(0x21e)+this[_0x37bb19(0x22d)]),_0x2619a0(new Error('failed\\x20to\\x20connect\\x20to\\x20host:\\x20'+(_0x329315&&_0x329315['message'])))));}));}['_disposeWebsocket'](_0x196180){var _0xef30c7=_0x3ba83d;this[_0xef30c7(0x1e4)]=!0x1,this['_connecting']=!0x1;try{_0x196180['onclose']=null,_0x196180['onerror']=null,_0x196180[_0xef30c7(0x1ff)]=null;}catch{}try{_0x196180[_0xef30c7(0x26a)]<0x2&&_0x196180[_0xef30c7(0x1db)]();}catch{}}[_0x3ba83d(0x1eb)](){var _0x6a7157=_0x3ba83d;clearTimeout(this[_0x6a7157(0x215)]),!(this['_connectAttemptCount']>=this[_0x6a7157(0x1ce)])&&(this[_0x6a7157(0x215)]=setTimeout(()=>{var _0x4ae5fd=_0x6a7157;this['_connected']||this[_0x4ae5fd(0x22a)]||(this[_0x4ae5fd(0x1e5)](),this[_0x4ae5fd(0x1a9)]?.['catch'](()=>this[_0x4ae5fd(0x1eb)]()));},0x1f4),this['_reconnectTimeout'][_0x6a7157(0x214)]&&this['_reconnectTimeout'][_0x6a7157(0x214)]());}async['send'](_0x423266){var _0x315a78=_0x3ba83d;try{if(!this[_0x315a78(0x1ac)])return;this['_allowedToConnectOnSend']&&this['_connectToHostNow'](),(await this[_0x315a78(0x1a9)])['send'](JSON[_0x315a78(0x27c)](_0x423266));}catch(_0x3bb1d2){console[_0x315a78(0x1c4)](this[_0x315a78(0x1d4)]+':\\x20'+(_0x3bb1d2&&_0x3bb1d2['message'])),this[_0x315a78(0x1ac)]=!0x1,this[_0x315a78(0x1eb)]();}}};function V(_0x14c01b,_0x192755,_0x4a4b6d,_0x30f2f1,_0x38ab2d){var _0x3b8dc7=_0x3ba83d;let _0x4e5f37=_0x4a4b6d['split'](',')[_0x3b8dc7(0x27f)](_0x4a8d52=>{var _0x3840c2=_0x3b8dc7;try{_0x14c01b[_0x3840c2(0x1ab)]||((_0x38ab2d==='next.js'||_0x38ab2d===_0x3840c2(0x217)||_0x38ab2d==='astro')&&(_0x38ab2d+=_0x14c01b['process']?.[_0x3840c2(0x1a7)]?.['node']?_0x3840c2(0x260):_0x3840c2(0x1cb)),_0x14c01b[_0x3840c2(0x1ab)]={'id':+new Date(),'tool':_0x38ab2d});let _0x2ecd1c=new Q(_0x14c01b,_0x192755,_0x4a8d52,_0x30f2f1);return _0x2ecd1c[_0x3840c2(0x250)]['bind'](_0x2ecd1c);}catch(_0x580284){return console[_0x3840c2(0x1c4)](_0x3840c2(0x253),_0x580284&&_0x580284[_0x3840c2(0x25e)]),()=>{};}});return _0x1c11ef=>_0x4e5f37[_0x3b8dc7(0x20c)](_0x163a22=>_0x163a22(_0x1c11ef));}function H(_0x557474){var _0x403b8f=_0x3ba83d;let _0x4e42c5=function(_0x1e02f9,_0xc09b4a){return _0xc09b4a-_0x1e02f9;},_0x4e68e0;if(_0x557474[_0x403b8f(0x268)])_0x4e68e0=function(){var _0x2eaec0=_0x403b8f;return _0x557474['performance'][_0x2eaec0(0x1f9)]();};else{if(_0x557474['process']&&_0x557474[_0x403b8f(0x1d7)][_0x403b8f(0x274)])_0x4e68e0=function(){var _0x2f7152=_0x403b8f;return _0x557474[_0x2f7152(0x1d7)][_0x2f7152(0x274)]();},_0x4e42c5=function(_0xf29124,_0x32fc4b){return 0x3e8*(_0x32fc4b[0x0]-_0xf29124[0x0])+(_0x32fc4b[0x1]-_0xf29124[0x1])/0xf4240;};else try{let {performance:_0x2bb63c}=require(_0x403b8f(0x222));_0x4e68e0=function(){return _0x2bb63c['now']();};}catch{_0x4e68e0=function(){return+new Date();};}}return{'elapsed':_0x4e42c5,'timeStamp':_0x4e68e0,'now':()=>Date[_0x403b8f(0x1f9)]()};}function X(_0x4ee268,_0x1f6bcd,_0x26b09b){var _0x2d4d28=_0x3ba83d;if(_0x4ee268['_consoleNinjaAllowedToStart']!==void 0x0)return _0x4ee268['_consoleNinjaAllowedToStart'];let _0x2aad90=_0x4ee268['process']?.[_0x2d4d28(0x1a7)]?.[_0x2d4d28(0x1bd)];return _0x2aad90&&_0x26b09b===_0x2d4d28(0x27e)?_0x4ee268[_0x2d4d28(0x202)]=!0x1:_0x4ee268['_consoleNinjaAllowedToStart']=_0x2aad90||!_0x1f6bcd||_0x4ee268[_0x2d4d28(0x1dd)]?.[_0x2d4d28(0x23b)]&&_0x1f6bcd['includes'](_0x4ee268[_0x2d4d28(0x1dd)][_0x2d4d28(0x23b)]),_0x4ee268[_0x2d4d28(0x202)];}((_0x289f54,_0x29789e,_0x2f548f,_0x2fbd9e,_0x21dd5e,_0x592253,_0x3f52fd,_0x41dd6d,_0x1189ff)=>{var _0x312442=_0x3ba83d;if(_0x289f54[_0x312442(0x23c)])return _0x289f54[_0x312442(0x23c)];if(!X(_0x289f54,_0x41dd6d,_0x21dd5e))return _0x289f54['_console_ninja']={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x289f54[_0x312442(0x23c)];let _0xdf602={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x544250={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2},_0xcd6f41=H(_0x289f54),_0x5961dd=_0xcd6f41[_0x312442(0x21b)],_0x32c2bf=_0xcd6f41[_0x312442(0x1e2)],_0x3fc0e4=_0xcd6f41[_0x312442(0x1f9)],_0x21d36a={'hits':{},'ts':{}},_0x47415f=_0xe98645=>{_0x21d36a['ts'][_0xe98645]=_0x32c2bf();},_0x294520=(_0x168879,_0x369685)=>{let _0x447058=_0x21d36a['ts'][_0x369685];if(delete _0x21d36a['ts'][_0x369685],_0x447058){let _0x28c8d6=_0x5961dd(_0x447058,_0x32c2bf());_0x1152c0(_0x30f5ce('time',_0x168879,_0x3fc0e4(),_0x12ecc2,[_0x28c8d6],_0x369685));}},_0x7b6e0e=_0x218364=>_0x513ac5=>{var _0x116fa5=_0x312442;try{_0x47415f(_0x513ac5),_0x218364(_0x513ac5);}finally{_0x289f54[_0x116fa5(0x28a)][_0x116fa5(0x1cd)]=_0x218364;}},_0x3c8ef5=_0x3cd42a=>_0x476c4b=>{var _0x524406=_0x312442;try{let [_0x1f3f5c,_0xaeebdd]=_0x476c4b[_0x524406(0x1e6)](':logPointId:');_0x294520(_0xaeebdd,_0x1f3f5c),_0x3cd42a(_0x1f3f5c);}finally{_0x289f54['console'][_0x524406(0x1b8)]=_0x3cd42a;}};_0x289f54[_0x312442(0x23c)]={'consoleLog':(_0x5e664b,_0x38aebf)=>{var _0xe063e7=_0x312442;_0x289f54[_0xe063e7(0x28a)][_0xe063e7(0x25f)][_0xe063e7(0x243)]!==_0xe063e7(0x25a)&&_0x1152c0(_0x30f5ce(_0xe063e7(0x25f),_0x5e664b,_0x3fc0e4(),_0x12ecc2,_0x38aebf));},'consoleTrace':(_0x5c312f,_0x43296b)=>{var _0x7bd5b=_0x312442;_0x289f54[_0x7bd5b(0x28a)][_0x7bd5b(0x25f)][_0x7bd5b(0x243)]!=='disabledTrace'&&_0x1152c0(_0x30f5ce(_0x7bd5b(0x1ea),_0x5c312f,_0x3fc0e4(),_0x12ecc2,_0x43296b));},'consoleTime':()=>{var _0x40a9bf=_0x312442;_0x289f54[_0x40a9bf(0x28a)][_0x40a9bf(0x1cd)]=_0x7b6e0e(_0x289f54['console'][_0x40a9bf(0x1cd)]);},'consoleTimeEnd':()=>{var _0x2723c5=_0x312442;_0x289f54[_0x2723c5(0x28a)][_0x2723c5(0x1b8)]=_0x3c8ef5(_0x289f54[_0x2723c5(0x28a)][_0x2723c5(0x1b8)]);},'autoLog':(_0x8ea6f,_0x1c22e6)=>{var _0x3d5a9b=_0x312442;_0x1152c0(_0x30f5ce(_0x3d5a9b(0x25f),_0x1c22e6,_0x3fc0e4(),_0x12ecc2,[_0x8ea6f]));},'autoLogMany':(_0x2eb901,_0x353773)=>{var _0x4f73ec=_0x312442;_0x1152c0(_0x30f5ce(_0x4f73ec(0x25f),_0x2eb901,_0x3fc0e4(),_0x12ecc2,_0x353773));},'autoTrace':(_0x426610,_0x2d8dbb)=>{var _0x5ddbad=_0x312442;_0x1152c0(_0x30f5ce(_0x5ddbad(0x1ea),_0x2d8dbb,_0x3fc0e4(),_0x12ecc2,[_0x426610]));},'autoTraceMany':(_0x425e00,_0x239ffe)=>{_0x1152c0(_0x30f5ce('trace',_0x425e00,_0x3fc0e4(),_0x12ecc2,_0x239ffe));},'autoTime':(_0x54f445,_0x3865a3,_0x336fe5)=>{_0x47415f(_0x336fe5);},'autoTimeEnd':(_0x25ab2c,_0x2f1951,_0x1705ec)=>{_0x294520(_0x2f1951,_0x1705ec);}};let _0x1152c0=V(_0x289f54,_0x29789e,_0x2f548f,_0x2fbd9e,_0x21dd5e),_0x12ecc2=_0x289f54['_console_ninja_session'];class _0x1d1f90{constructor(){var _0x11adf9=_0x312442;this[_0x11adf9(0x1e8)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0x11adf9(0x1c5)]=/^(0|[1-9][0-9]*)$/,this[_0x11adf9(0x210)]=/'([^\\\\']|\\\\')*'/,this[_0x11adf9(0x237)]=_0x289f54[_0x11adf9(0x281)],this[_0x11adf9(0x277)]=_0x289f54['HTMLAllCollection'],this['_getOwnPropertyDescriptor']=Object[_0x11adf9(0x244)],this[_0x11adf9(0x207)]=Object[_0x11adf9(0x230)],this['_Symbol']=_0x289f54[_0x11adf9(0x1c9)],this[_0x11adf9(0x1cc)]=RegExp[_0x11adf9(0x1c8)][_0x11adf9(0x21f)],this[_0x11adf9(0x241)]=Date['prototype'][_0x11adf9(0x21f)];}[_0x312442(0x238)](_0x4d0e15,_0x5389a6,_0x257208,_0x52c0b3){var _0x2f3f66=_0x312442,_0x1ac22e=this,_0x59abc6=_0x257208[_0x2f3f66(0x1b6)];function _0x3de612(_0x1a97aa,_0x1697d6,_0x2a7731){var _0xd123b=_0x2f3f66;_0x1697d6['type']=_0xd123b(0x26c),_0x1697d6[_0xd123b(0x223)]=_0x1a97aa[_0xd123b(0x25e)],_0x170616=_0x2a7731['node'][_0xd123b(0x1d1)],_0x2a7731[_0xd123b(0x1bd)][_0xd123b(0x1d1)]=_0x1697d6,_0x1ac22e['_treeNodePropertiesBeforeFullValue'](_0x1697d6,_0x2a7731);}try{_0x257208[_0x2f3f66(0x212)]++,_0x257208[_0x2f3f66(0x1b6)]&&_0x257208[_0x2f3f66(0x266)]['push'](_0x5389a6);var _0x42be5e,_0x284614,_0x33a2a3,_0x11f419,_0x262728=[],_0x5b8cd7=[],_0x4815d4,_0x928c76=this[_0x2f3f66(0x1d9)](_0x5389a6),_0x2d4b7d=_0x928c76===_0x2f3f66(0x1e9),_0x3b09ba=!0x1,_0x4dd58d=_0x928c76===_0x2f3f66(0x1de),_0x5f228a=this[_0x2f3f66(0x25b)](_0x928c76),_0x3b467a=this[_0x2f3f66(0x289)](_0x928c76),_0x2bc2e1=_0x5f228a||_0x3b467a,_0x76cbd1={},_0x287cc4=0x0,_0x5cd77c=!0x1,_0x170616,_0x8ff245=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x257208['depth']){if(_0x2d4b7d){if(_0x284614=_0x5389a6['length'],_0x284614>_0x257208['elements']){for(_0x33a2a3=0x0,_0x11f419=_0x257208[_0x2f3f66(0x252)],_0x42be5e=_0x33a2a3;_0x42be5e<_0x11f419;_0x42be5e++)_0x5b8cd7[_0x2f3f66(0x1ae)](_0x1ac22e[_0x2f3f66(0x265)](_0x262728,_0x5389a6,_0x928c76,_0x42be5e,_0x257208));_0x4d0e15[_0x2f3f66(0x264)]=!0x0;}else{for(_0x33a2a3=0x0,_0x11f419=_0x284614,_0x42be5e=_0x33a2a3;_0x42be5e<_0x11f419;_0x42be5e++)_0x5b8cd7[_0x2f3f66(0x1ae)](_0x1ac22e[_0x2f3f66(0x265)](_0x262728,_0x5389a6,_0x928c76,_0x42be5e,_0x257208));}_0x257208[_0x2f3f66(0x249)]+=_0x5b8cd7[_0x2f3f66(0x229)];}if(!(_0x928c76===_0x2f3f66(0x232)||_0x928c76===_0x2f3f66(0x281))&&!_0x5f228a&&_0x928c76!==_0x2f3f66(0x1d2)&&_0x928c76!==_0x2f3f66(0x276)&&_0x928c76!==_0x2f3f66(0x288)){var _0x6f82dd=_0x52c0b3[_0x2f3f66(0x24f)]||_0x257208[_0x2f3f66(0x24f)];if(this[_0x2f3f66(0x282)](_0x5389a6)?(_0x42be5e=0x0,_0x5389a6[_0x2f3f66(0x20c)](function(_0x4e4d1d){var _0x762fa0=_0x2f3f66;if(_0x287cc4++,_0x257208[_0x762fa0(0x249)]++,_0x287cc4>_0x6f82dd){_0x5cd77c=!0x0;return;}if(!_0x257208[_0x762fa0(0x1a8)]&&_0x257208[_0x762fa0(0x1b6)]&&_0x257208[_0x762fa0(0x249)]>_0x257208[_0x762fa0(0x284)]){_0x5cd77c=!0x0;return;}_0x5b8cd7['push'](_0x1ac22e[_0x762fa0(0x265)](_0x262728,_0x5389a6,_0x762fa0(0x1c2),_0x42be5e++,_0x257208,function(_0x287a20){return function(){return _0x287a20;};}(_0x4e4d1d)));})):this[_0x2f3f66(0x1bc)](_0x5389a6)&&_0x5389a6['forEach'](function(_0x5752ec,_0x522e09){var _0x3c0031=_0x2f3f66;if(_0x287cc4++,_0x257208[_0x3c0031(0x249)]++,_0x287cc4>_0x6f82dd){_0x5cd77c=!0x0;return;}if(!_0x257208[_0x3c0031(0x1a8)]&&_0x257208[_0x3c0031(0x1b6)]&&_0x257208[_0x3c0031(0x249)]>_0x257208[_0x3c0031(0x284)]){_0x5cd77c=!0x0;return;}var _0x45fa40=_0x522e09[_0x3c0031(0x21f)]();_0x45fa40[_0x3c0031(0x229)]>0x64&&(_0x45fa40=_0x45fa40[_0x3c0031(0x254)](0x0,0x64)+_0x3c0031(0x1fa)),_0x5b8cd7[_0x3c0031(0x1ae)](_0x1ac22e[_0x3c0031(0x265)](_0x262728,_0x5389a6,_0x3c0031(0x283),_0x45fa40,_0x257208,function(_0x4b62d4){return function(){return _0x4b62d4;};}(_0x5752ec)));}),!_0x3b09ba){try{for(_0x4815d4 in _0x5389a6)if(!(_0x2d4b7d&&_0x8ff245[_0x2f3f66(0x1e1)](_0x4815d4))&&!this[_0x2f3f66(0x271)](_0x5389a6,_0x4815d4,_0x257208)){if(_0x287cc4++,_0x257208[_0x2f3f66(0x249)]++,_0x287cc4>_0x6f82dd){_0x5cd77c=!0x0;break;}if(!_0x257208[_0x2f3f66(0x1a8)]&&_0x257208['autoExpand']&&_0x257208[_0x2f3f66(0x249)]>_0x257208[_0x2f3f66(0x284)]){_0x5cd77c=!0x0;break;}_0x5b8cd7['push'](_0x1ac22e[_0x2f3f66(0x236)](_0x262728,_0x76cbd1,_0x5389a6,_0x928c76,_0x4815d4,_0x257208));}}catch{}if(_0x76cbd1[_0x2f3f66(0x1dc)]=!0x0,_0x4dd58d&&(_0x76cbd1[_0x2f3f66(0x1ed)]=!0x0),!_0x5cd77c){var _0x20015d=[][_0x2f3f66(0x23e)](this[_0x2f3f66(0x207)](_0x5389a6))[_0x2f3f66(0x23e)](this[_0x2f3f66(0x286)](_0x5389a6));for(_0x42be5e=0x0,_0x284614=_0x20015d[_0x2f3f66(0x229)];_0x42be5e<_0x284614;_0x42be5e++)if(_0x4815d4=_0x20015d[_0x42be5e],!(_0x2d4b7d&&_0x8ff245[_0x2f3f66(0x1e1)](_0x4815d4[_0x2f3f66(0x21f)]()))&&!this[_0x2f3f66(0x271)](_0x5389a6,_0x4815d4,_0x257208)&&!_0x76cbd1[_0x2f3f66(0x1d8)+_0x4815d4[_0x2f3f66(0x21f)]()]){if(_0x287cc4++,_0x257208[_0x2f3f66(0x249)]++,_0x287cc4>_0x6f82dd){_0x5cd77c=!0x0;break;}if(!_0x257208[_0x2f3f66(0x1a8)]&&_0x257208[_0x2f3f66(0x1b6)]&&_0x257208['autoExpandPropertyCount']>_0x257208['autoExpandLimit']){_0x5cd77c=!0x0;break;}_0x5b8cd7[_0x2f3f66(0x1ae)](_0x1ac22e['_addObjectProperty'](_0x262728,_0x76cbd1,_0x5389a6,_0x928c76,_0x4815d4,_0x257208));}}}}}if(_0x4d0e15[_0x2f3f66(0x204)]=_0x928c76,_0x2bc2e1?(_0x4d0e15[_0x2f3f66(0x26e)]=_0x5389a6[_0x2f3f66(0x1c6)](),this['_capIfString'](_0x928c76,_0x4d0e15,_0x257208,_0x52c0b3)):_0x928c76==='date'?_0x4d0e15[_0x2f3f66(0x26e)]=this['_dateToString'][_0x2f3f66(0x1ba)](_0x5389a6):_0x928c76===_0x2f3f66(0x288)?_0x4d0e15['value']=_0x5389a6[_0x2f3f66(0x21f)]():_0x928c76===_0x2f3f66(0x227)?_0x4d0e15[_0x2f3f66(0x26e)]=this[_0x2f3f66(0x1cc)][_0x2f3f66(0x1ba)](_0x5389a6):_0x928c76==='symbol'&&this[_0x2f3f66(0x272)]?_0x4d0e15['value']=this[_0x2f3f66(0x272)][_0x2f3f66(0x1c8)][_0x2f3f66(0x21f)]['call'](_0x5389a6):!_0x257208['depth']&&!(_0x928c76==='null'||_0x928c76===_0x2f3f66(0x281))&&(delete _0x4d0e15[_0x2f3f66(0x26e)],_0x4d0e15[_0x2f3f66(0x216)]=!0x0),_0x5cd77c&&(_0x4d0e15['cappedProps']=!0x0),_0x170616=_0x257208[_0x2f3f66(0x1bd)][_0x2f3f66(0x1d1)],_0x257208[_0x2f3f66(0x1bd)][_0x2f3f66(0x1d1)]=_0x4d0e15,this[_0x2f3f66(0x27a)](_0x4d0e15,_0x257208),_0x5b8cd7[_0x2f3f66(0x229)]){for(_0x42be5e=0x0,_0x284614=_0x5b8cd7[_0x2f3f66(0x229)];_0x42be5e<_0x284614;_0x42be5e++)_0x5b8cd7[_0x42be5e](_0x42be5e);}_0x262728['length']&&(_0x4d0e15[_0x2f3f66(0x24f)]=_0x262728);}catch(_0x290d34){_0x3de612(_0x290d34,_0x4d0e15,_0x257208);}return this['_additionalMetadata'](_0x5389a6,_0x4d0e15),this[_0x2f3f66(0x23f)](_0x4d0e15,_0x257208),_0x257208[_0x2f3f66(0x1bd)][_0x2f3f66(0x1d1)]=_0x170616,_0x257208[_0x2f3f66(0x212)]--,_0x257208['autoExpand']=_0x59abc6,_0x257208[_0x2f3f66(0x1b6)]&&_0x257208[_0x2f3f66(0x266)][_0x2f3f66(0x1ad)](),_0x4d0e15;}[_0x312442(0x286)](_0x2defce){var _0x26368f=_0x312442;return Object[_0x26368f(0x1a5)]?Object[_0x26368f(0x1a5)](_0x2defce):[];}[_0x312442(0x282)](_0x538ed4){var _0x363e47=_0x312442;return!!(_0x538ed4&&_0x289f54['Set']&&this[_0x363e47(0x20b)](_0x538ed4)===_0x363e47(0x1b5)&&_0x538ed4[_0x363e47(0x20c)]);}[_0x312442(0x271)](_0x4bb3cf,_0x576149,_0x1f822b){var _0x5247c8=_0x312442;return _0x1f822b[_0x5247c8(0x246)]?typeof _0x4bb3cf[_0x576149]==_0x5247c8(0x1de):!0x1;}[_0x312442(0x1d9)](_0x54a3ed){var _0x133383=_0x312442,_0x3d6dc3='';return _0x3d6dc3=typeof _0x54a3ed,_0x3d6dc3===_0x133383(0x23a)?this['_objectToString'](_0x54a3ed)==='[object\\x20Array]'?_0x3d6dc3='array':this[_0x133383(0x20b)](_0x54a3ed)===_0x133383(0x1f4)?_0x3d6dc3=_0x133383(0x20d):this[_0x133383(0x20b)](_0x54a3ed)===_0x133383(0x1b4)?_0x3d6dc3=_0x133383(0x288):_0x54a3ed===null?_0x3d6dc3=_0x133383(0x232):_0x54a3ed[_0x133383(0x1a3)]&&(_0x3d6dc3=_0x54a3ed[_0x133383(0x1a3)][_0x133383(0x243)]||_0x3d6dc3):_0x3d6dc3===_0x133383(0x281)&&this[_0x133383(0x277)]&&_0x54a3ed instanceof this[_0x133383(0x277)]&&(_0x3d6dc3='HTMLAllCollection'),_0x3d6dc3;}[_0x312442(0x20b)](_0x3f9962){var _0x230913=_0x312442;return Object[_0x230913(0x1c8)][_0x230913(0x21f)][_0x230913(0x1ba)](_0x3f9962);}[_0x312442(0x25b)](_0x5d7847){var _0x357c83=_0x312442;return _0x5d7847===_0x357c83(0x239)||_0x5d7847==='string'||_0x5d7847===_0x357c83(0x226);}[_0x312442(0x289)](_0x126c23){var _0x5bc3da=_0x312442;return _0x126c23===_0x5bc3da(0x23d)||_0x126c23===_0x5bc3da(0x1d2)||_0x126c23===_0x5bc3da(0x263);}['_addProperty'](_0xc726db,_0x9055f1,_0x48e167,_0x525d7c,_0x2a2d6d,_0x260b43){var _0x4440e7=this;return function(_0x26da21){var _0x166261=_0x578d,_0x2fca76=_0x2a2d6d[_0x166261(0x1bd)][_0x166261(0x1d1)],_0x47e39e=_0x2a2d6d[_0x166261(0x1bd)][_0x166261(0x205)],_0x35d83e=_0x2a2d6d[_0x166261(0x1bd)][_0x166261(0x1d0)];_0x2a2d6d[_0x166261(0x1bd)]['parent']=_0x2fca76,_0x2a2d6d[_0x166261(0x1bd)][_0x166261(0x205)]=typeof _0x525d7c==_0x166261(0x226)?_0x525d7c:_0x26da21,_0xc726db['push'](_0x4440e7[_0x166261(0x257)](_0x9055f1,_0x48e167,_0x525d7c,_0x2a2d6d,_0x260b43)),_0x2a2d6d[_0x166261(0x1bd)][_0x166261(0x1d0)]=_0x35d83e,_0x2a2d6d[_0x166261(0x1bd)]['index']=_0x47e39e;};}[_0x312442(0x236)](_0x4dde0b,_0x3cfaa4,_0x5bba70,_0x1e29d3,_0x2e93de,_0x594736,_0x3651f8){var _0x1b9bbd=_0x312442,_0x5754a5=this;return _0x3cfaa4[_0x1b9bbd(0x1d8)+_0x2e93de[_0x1b9bbd(0x21f)]()]=!0x0,function(_0x1ead38){var _0x417bb1=_0x1b9bbd,_0xdd7dc9=_0x594736['node'][_0x417bb1(0x1d1)],_0x2930d9=_0x594736[_0x417bb1(0x1bd)][_0x417bb1(0x205)],_0x27afad=_0x594736[_0x417bb1(0x1bd)][_0x417bb1(0x1d0)];_0x594736[_0x417bb1(0x1bd)][_0x417bb1(0x1d0)]=_0xdd7dc9,_0x594736[_0x417bb1(0x1bd)][_0x417bb1(0x205)]=_0x1ead38,_0x4dde0b[_0x417bb1(0x1ae)](_0x5754a5[_0x417bb1(0x257)](_0x5bba70,_0x1e29d3,_0x2e93de,_0x594736,_0x3651f8)),_0x594736[_0x417bb1(0x1bd)]['parent']=_0x27afad,_0x594736['node'][_0x417bb1(0x205)]=_0x2930d9;};}['_property'](_0x558a48,_0x3ff37d,_0x8c7d12,_0x5573c9,_0x1347c3){var _0x3e6fe4=_0x312442,_0x4736fb=this;_0x1347c3||(_0x1347c3=function(_0x1bf36d,_0x23f973){return _0x1bf36d[_0x23f973];});var _0x4c0e53=_0x8c7d12[_0x3e6fe4(0x21f)](),_0x28a1a6=_0x5573c9[_0x3e6fe4(0x228)]||{},_0x1af6ca=_0x5573c9[_0x3e6fe4(0x1fc)],_0x433cc4=_0x5573c9[_0x3e6fe4(0x1a8)];try{var _0x5e5eb8=this['_isMap'](_0x558a48),_0x224925=_0x4c0e53;_0x5e5eb8&&_0x224925[0x0]==='\\x27'&&(_0x224925=_0x224925[_0x3e6fe4(0x1cf)](0x1,_0x224925[_0x3e6fe4(0x229)]-0x2));var _0x3749ac=_0x5573c9['expressionsToEvaluate']=_0x28a1a6['_p_'+_0x224925];_0x3749ac&&(_0x5573c9[_0x3e6fe4(0x1fc)]=_0x5573c9[_0x3e6fe4(0x1fc)]+0x1),_0x5573c9[_0x3e6fe4(0x1a8)]=!!_0x3749ac;var _0x1f2227=typeof _0x8c7d12==_0x3e6fe4(0x240),_0x328d23={'name':_0x1f2227||_0x5e5eb8?_0x4c0e53:this[_0x3e6fe4(0x1ef)](_0x4c0e53)};if(_0x1f2227&&(_0x328d23['symbol']=!0x0),!(_0x3ff37d===_0x3e6fe4(0x1e9)||_0x3ff37d===_0x3e6fe4(0x1be))){var _0x279e70=this[_0x3e6fe4(0x25d)](_0x558a48,_0x8c7d12);if(_0x279e70&&(_0x279e70[_0x3e6fe4(0x224)]&&(_0x328d23['setter']=!0x0),_0x279e70[_0x3e6fe4(0x1c1)]&&!_0x3749ac&&!_0x5573c9[_0x3e6fe4(0x1f1)]))return _0x328d23[_0x3e6fe4(0x261)]=!0x0,this[_0x3e6fe4(0x24a)](_0x328d23,_0x5573c9),_0x328d23;}var _0xf686d0;try{_0xf686d0=_0x1347c3(_0x558a48,_0x8c7d12);}catch(_0x258f00){return _0x328d23={'name':_0x4c0e53,'type':_0x3e6fe4(0x26c),'error':_0x258f00[_0x3e6fe4(0x25e)]},this[_0x3e6fe4(0x24a)](_0x328d23,_0x5573c9),_0x328d23;}var _0x117616=this['_type'](_0xf686d0),_0x5977d8=this[_0x3e6fe4(0x25b)](_0x117616);if(_0x328d23[_0x3e6fe4(0x204)]=_0x117616,_0x5977d8)this[_0x3e6fe4(0x24a)](_0x328d23,_0x5573c9,_0xf686d0,function(){var _0x322f68=_0x3e6fe4;_0x328d23['value']=_0xf686d0['valueOf'](),!_0x3749ac&&_0x4736fb[_0x322f68(0x279)](_0x117616,_0x328d23,_0x5573c9,{});});else{var _0x45ecd4=_0x5573c9[_0x3e6fe4(0x1b6)]&&_0x5573c9['level']<_0x5573c9[_0x3e6fe4(0x1f3)]&&_0x5573c9['autoExpandPreviousObjects'][_0x3e6fe4(0x26f)](_0xf686d0)<0x0&&_0x117616!==_0x3e6fe4(0x1de)&&_0x5573c9[_0x3e6fe4(0x249)]<_0x5573c9[_0x3e6fe4(0x284)];_0x45ecd4||_0x5573c9[_0x3e6fe4(0x212)]<_0x1af6ca||_0x3749ac?(this[_0x3e6fe4(0x238)](_0x328d23,_0xf686d0,_0x5573c9,_0x3749ac||{}),this[_0x3e6fe4(0x201)](_0xf686d0,_0x328d23)):this[_0x3e6fe4(0x24a)](_0x328d23,_0x5573c9,_0xf686d0,function(){var _0x2bcb77=_0x3e6fe4;_0x117616==='null'||_0x117616===_0x2bcb77(0x281)||(delete _0x328d23[_0x2bcb77(0x26e)],_0x328d23[_0x2bcb77(0x216)]=!0x0);});}return _0x328d23;}finally{_0x5573c9[_0x3e6fe4(0x228)]=_0x28a1a6,_0x5573c9[_0x3e6fe4(0x1fc)]=_0x1af6ca,_0x5573c9['isExpressionToEvaluate']=_0x433cc4;}}[_0x312442(0x279)](_0x2c6f83,_0x44a500,_0xbfbae3,_0x253117){var _0x5b7148=_0x312442,_0x343096=_0x253117[_0x5b7148(0x1a6)]||_0xbfbae3['strLength'];if((_0x2c6f83===_0x5b7148(0x242)||_0x2c6f83==='String')&&_0x44a500[_0x5b7148(0x26e)]){let _0x4c83df=_0x44a500[_0x5b7148(0x26e)][_0x5b7148(0x229)];_0xbfbae3[_0x5b7148(0x25c)]+=_0x4c83df,_0xbfbae3[_0x5b7148(0x25c)]>_0xbfbae3[_0x5b7148(0x1f6)]?(_0x44a500[_0x5b7148(0x216)]='',delete _0x44a500['value']):_0x4c83df>_0x343096&&(_0x44a500[_0x5b7148(0x216)]=_0x44a500[_0x5b7148(0x26e)][_0x5b7148(0x1cf)](0x0,_0x343096),delete _0x44a500[_0x5b7148(0x26e)]);}}[_0x312442(0x1bc)](_0xc88439){var _0x31bf6a=_0x312442;return!!(_0xc88439&&_0x289f54['Map']&&this[_0x31bf6a(0x20b)](_0xc88439)==='[object\\x20Map]'&&_0xc88439[_0x31bf6a(0x20c)]);}[_0x312442(0x1ef)](_0x594cba){var _0x11561a=_0x312442;if(_0x594cba['match'](/^\\d+$/))return _0x594cba;var _0x4fa23d;try{_0x4fa23d=JSON[_0x11561a(0x27c)](''+_0x594cba);}catch{_0x4fa23d='\\x22'+this[_0x11561a(0x20b)](_0x594cba)+'\\x22';}return _0x4fa23d[_0x11561a(0x1fb)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x4fa23d=_0x4fa23d['substr'](0x1,_0x4fa23d[_0x11561a(0x229)]-0x2):_0x4fa23d=_0x4fa23d[_0x11561a(0x1f5)](/'/g,'\\x5c\\x27')[_0x11561a(0x1f5)](/\\\\\"/g,'\\x22')['replace'](/(^\"|\"$)/g,'\\x27'),_0x4fa23d;}[_0x312442(0x24a)](_0x3faa2e,_0x4a5593,_0x1b0e78,_0x24e995){var _0x2d5288=_0x312442;this[_0x2d5288(0x27a)](_0x3faa2e,_0x4a5593),_0x24e995&&_0x24e995(),this[_0x2d5288(0x201)](_0x1b0e78,_0x3faa2e),this[_0x2d5288(0x23f)](_0x3faa2e,_0x4a5593);}[_0x312442(0x27a)](_0x1bcbdb,_0x1b73c1){var _0xc18741=_0x312442;this[_0xc18741(0x27b)](_0x1bcbdb,_0x1b73c1),this[_0xc18741(0x285)](_0x1bcbdb,_0x1b73c1),this[_0xc18741(0x1f0)](_0x1bcbdb,_0x1b73c1),this[_0xc18741(0x211)](_0x1bcbdb,_0x1b73c1);}['_setNodeId'](_0xddab67,_0x2358fb){}['_setNodeQueryPath'](_0x50ac21,_0x46bf6c){}[_0x312442(0x273)](_0x4b6c5c,_0x26477a){}[_0x312442(0x1e0)](_0x1bd1dc){var _0x39d919=_0x312442;return _0x1bd1dc===this[_0x39d919(0x237)];}['_treeNodePropertiesAfterFullValue'](_0x2e3b9d,_0x3f705d){var _0x9e7f60=_0x312442;this['_setNodeLabel'](_0x2e3b9d,_0x3f705d),this['_setNodeExpandableState'](_0x2e3b9d),_0x3f705d['sortProps']&&this[_0x9e7f60(0x1b9)](_0x2e3b9d),this['_addFunctionsNode'](_0x2e3b9d,_0x3f705d),this['_addLoadNode'](_0x2e3b9d,_0x3f705d),this['_cleanNode'](_0x2e3b9d);}[_0x312442(0x201)](_0x2466b8,_0x5337f1){var _0x1c5fc0=_0x312442;let _0x38a472;try{_0x289f54[_0x1c5fc0(0x28a)]&&(_0x38a472=_0x289f54[_0x1c5fc0(0x28a)]['error'],_0x289f54['console'][_0x1c5fc0(0x223)]=function(){}),_0x2466b8&&typeof _0x2466b8[_0x1c5fc0(0x229)]==_0x1c5fc0(0x226)&&(_0x5337f1[_0x1c5fc0(0x229)]=_0x2466b8[_0x1c5fc0(0x229)]);}catch{}finally{_0x38a472&&(_0x289f54[_0x1c5fc0(0x28a)][_0x1c5fc0(0x223)]=_0x38a472);}if(_0x5337f1[_0x1c5fc0(0x204)]===_0x1c5fc0(0x226)||_0x5337f1['type']===_0x1c5fc0(0x263)){if(isNaN(_0x5337f1[_0x1c5fc0(0x26e)]))_0x5337f1[_0x1c5fc0(0x1bb)]=!0x0,delete _0x5337f1[_0x1c5fc0(0x26e)];else switch(_0x5337f1[_0x1c5fc0(0x26e)]){case Number[_0x1c5fc0(0x203)]:_0x5337f1[_0x1c5fc0(0x278)]=!0x0,delete _0x5337f1[_0x1c5fc0(0x26e)];break;case Number[_0x1c5fc0(0x26d)]:_0x5337f1[_0x1c5fc0(0x231)]=!0x0,delete _0x5337f1['value'];break;case 0x0:this['_isNegativeZero'](_0x5337f1[_0x1c5fc0(0x26e)])&&(_0x5337f1[_0x1c5fc0(0x1ec)]=!0x0);break;}}else _0x5337f1[_0x1c5fc0(0x204)]===_0x1c5fc0(0x1de)&&typeof _0x2466b8[_0x1c5fc0(0x243)]==_0x1c5fc0(0x242)&&_0x2466b8[_0x1c5fc0(0x243)]&&_0x5337f1[_0x1c5fc0(0x243)]&&_0x2466b8[_0x1c5fc0(0x243)]!==_0x5337f1[_0x1c5fc0(0x243)]&&(_0x5337f1[_0x1c5fc0(0x1d5)]=_0x2466b8['name']);}['_isNegativeZero'](_0x4c6aff){return 0x1/_0x4c6aff===Number['NEGATIVE_INFINITY'];}[_0x312442(0x1b9)](_0x497cb3){var _0xf7acd2=_0x312442;!_0x497cb3['props']||!_0x497cb3[_0xf7acd2(0x24f)]['length']||_0x497cb3[_0xf7acd2(0x204)]===_0xf7acd2(0x1e9)||_0x497cb3[_0xf7acd2(0x204)]===_0xf7acd2(0x283)||_0x497cb3[_0xf7acd2(0x204)]===_0xf7acd2(0x1c2)||_0x497cb3[_0xf7acd2(0x24f)]['sort'](function(_0x544e1d,_0x181b19){var _0x4faefa=_0xf7acd2,_0x5b0d23=_0x544e1d[_0x4faefa(0x243)]['toLowerCase'](),_0x541ae8=_0x181b19[_0x4faefa(0x243)][_0x4faefa(0x1a4)]();return _0x5b0d23<_0x541ae8?-0x1:_0x5b0d23>_0x541ae8?0x1:0x0;});}['_addFunctionsNode'](_0x28d738,_0x103619){var _0x33c5da=_0x312442;if(!(_0x103619['noFunctions']||!_0x28d738['props']||!_0x28d738[_0x33c5da(0x24f)]['length'])){for(var _0x2a270a=[],_0x4e33fa=[],_0x2c6d7e=0x0,_0x14df7c=_0x28d738[_0x33c5da(0x24f)][_0x33c5da(0x229)];_0x2c6d7e<_0x14df7c;_0x2c6d7e++){var _0x10f3d1=_0x28d738[_0x33c5da(0x24f)][_0x2c6d7e];_0x10f3d1['type']==='function'?_0x2a270a[_0x33c5da(0x1ae)](_0x10f3d1):_0x4e33fa['push'](_0x10f3d1);}if(!(!_0x4e33fa['length']||_0x2a270a[_0x33c5da(0x229)]<=0x1)){_0x28d738[_0x33c5da(0x24f)]=_0x4e33fa;var _0x5ca4bf={'functionsNode':!0x0,'props':_0x2a270a};this[_0x33c5da(0x27b)](_0x5ca4bf,_0x103619),this[_0x33c5da(0x273)](_0x5ca4bf,_0x103619),this['_setNodeExpandableState'](_0x5ca4bf),this[_0x33c5da(0x211)](_0x5ca4bf,_0x103619),_0x5ca4bf['id']+='\\x20f',_0x28d738[_0x33c5da(0x24f)]['unshift'](_0x5ca4bf);}}}[_0x312442(0x267)](_0x557253,_0x20b969){}['_setNodeExpandableState'](_0x4cbf1f){}[_0x312442(0x287)](_0x7120b7){var _0x10aef3=_0x312442;return Array[_0x10aef3(0x24d)](_0x7120b7)||typeof _0x7120b7==_0x10aef3(0x23a)&&this['_objectToString'](_0x7120b7)===_0x10aef3(0x208);}['_setNodePermissions'](_0x4a77cc,_0x4953e7){}[_0x312442(0x26b)](_0x3af415){delete _0x3af415['_hasSymbolPropertyOnItsPath'],delete _0x3af415['_hasSetOnItsPath'],delete _0x3af415['_hasMapOnItsPath'];}['_setNodeExpressionPath'](_0x107946,_0x27dfee){}[_0x312442(0x1fd)](_0x47b20f){var _0x42749f=_0x312442;return _0x47b20f?_0x47b20f[_0x42749f(0x1fb)](this[_0x42749f(0x1c5)])?'['+_0x47b20f+']':_0x47b20f[_0x42749f(0x1fb)](this[_0x42749f(0x1e8)])?'.'+_0x47b20f:_0x47b20f[_0x42749f(0x1fb)](this[_0x42749f(0x210)])?'['+_0x47b20f+']':'[\\x27'+_0x47b20f+'\\x27]':'';}}let _0x2c77a6=new _0x1d1f90();function _0x30f5ce(_0x4a8d2c,_0x127609,_0x5584c5,_0x3d8b57,_0x5c20d7,_0x363023){var _0x510a6b=_0x312442;let _0x3acdaf,_0x3e21a3;try{_0x3e21a3=_0x32c2bf(),_0x3acdaf=_0x21d36a[_0x127609],!_0x3acdaf||_0x3e21a3-_0x3acdaf['ts']>0x1f4&&_0x3acdaf['count']&&_0x3acdaf[_0x510a6b(0x1cd)]/_0x3acdaf[_0x510a6b(0x248)]<0x64?(_0x21d36a[_0x127609]=_0x3acdaf={'count':0x0,'time':0x0,'ts':_0x3e21a3},_0x21d36a[_0x510a6b(0x219)]={}):_0x3e21a3-_0x21d36a[_0x510a6b(0x219)]['ts']>0x32&&_0x21d36a[_0x510a6b(0x219)]['count']&&_0x21d36a['hits'][_0x510a6b(0x1cd)]/_0x21d36a[_0x510a6b(0x219)][_0x510a6b(0x248)]<0x64&&(_0x21d36a[_0x510a6b(0x219)]={});let _0x214d37=[],_0x1a52d7=_0x3acdaf[_0x510a6b(0x1f7)]||_0x21d36a[_0x510a6b(0x219)][_0x510a6b(0x1f7)]?_0x544250:_0xdf602,_0x96c8e6=_0x48b509=>{var _0x3a9d11=_0x510a6b;let _0x341499={};return _0x341499[_0x3a9d11(0x24f)]=_0x48b509[_0x3a9d11(0x24f)],_0x341499[_0x3a9d11(0x252)]=_0x48b509[_0x3a9d11(0x252)],_0x341499[_0x3a9d11(0x1a6)]=_0x48b509['strLength'],_0x341499['totalStrLength']=_0x48b509[_0x3a9d11(0x1f6)],_0x341499[_0x3a9d11(0x284)]=_0x48b509[_0x3a9d11(0x284)],_0x341499[_0x3a9d11(0x1f3)]=_0x48b509[_0x3a9d11(0x1f3)],_0x341499[_0x3a9d11(0x251)]=!0x1,_0x341499[_0x3a9d11(0x246)]=!_0x1189ff,_0x341499[_0x3a9d11(0x1fc)]=0x1,_0x341499['level']=0x0,_0x341499[_0x3a9d11(0x234)]=_0x3a9d11(0x1f2),_0x341499['rootExpression']=_0x3a9d11(0x1ca),_0x341499[_0x3a9d11(0x1b6)]=!0x0,_0x341499[_0x3a9d11(0x266)]=[],_0x341499[_0x3a9d11(0x249)]=0x0,_0x341499[_0x3a9d11(0x1f1)]=!0x0,_0x341499['allStrLength']=0x0,_0x341499[_0x3a9d11(0x1bd)]={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x341499;};for(var _0x439851=0x0;_0x439851<_0x5c20d7['length'];_0x439851++)_0x214d37['push'](_0x2c77a6['serialize']({'timeNode':_0x4a8d2c==='time'||void 0x0},_0x5c20d7[_0x439851],_0x96c8e6(_0x1a52d7),{}));if(_0x4a8d2c===_0x510a6b(0x1ea)){let _0x47db2c=Error[_0x510a6b(0x206)];try{Error[_0x510a6b(0x206)]=0x1/0x0,_0x214d37[_0x510a6b(0x1ae)](_0x2c77a6[_0x510a6b(0x238)]({'stackNode':!0x0},new Error()[_0x510a6b(0x1b3)],_0x96c8e6(_0x1a52d7),{'strLength':0x1/0x0}));}finally{Error[_0x510a6b(0x206)]=_0x47db2c;}}return{'method':_0x510a6b(0x25f),'version':_0x592253,'args':[{'ts':_0x5584c5,'session':_0x3d8b57,'args':_0x214d37,'id':_0x127609,'context':_0x363023}]};}catch(_0x3f61c9){return{'method':'log','version':_0x592253,'args':[{'ts':_0x5584c5,'session':_0x3d8b57,'args':[{'type':_0x510a6b(0x26c),'error':_0x3f61c9&&_0x3f61c9[_0x510a6b(0x25e)]}],'id':_0x127609,'context':_0x363023}]};}finally{try{if(_0x3acdaf&&_0x3e21a3){let _0x2a7f65=_0x32c2bf();_0x3acdaf[_0x510a6b(0x248)]++,_0x3acdaf[_0x510a6b(0x1cd)]+=_0x5961dd(_0x3e21a3,_0x2a7f65),_0x3acdaf['ts']=_0x2a7f65,_0x21d36a['hits'][_0x510a6b(0x248)]++,_0x21d36a[_0x510a6b(0x219)][_0x510a6b(0x1cd)]+=_0x5961dd(_0x3e21a3,_0x2a7f65),_0x21d36a[_0x510a6b(0x219)]['ts']=_0x2a7f65,(_0x3acdaf['count']>0x32||_0x3acdaf[_0x510a6b(0x1cd)]>0x64)&&(_0x3acdaf['reduceLimits']=!0x0),(_0x21d36a[_0x510a6b(0x219)]['count']>0x3e8||_0x21d36a[_0x510a6b(0x219)][_0x510a6b(0x1cd)]>0x12c)&&(_0x21d36a['hits'][_0x510a6b(0x1f7)]=!0x0);}}catch{}}}return _0x289f54['_console_ninja'];})(globalThis,_0x3ba83d(0x20f),_0x3ba83d(0x1aa),_0x3ba83d(0x1e7),'webpack','1.0.0',_0x3ba83d(0x1af),_0x3ba83d(0x1a2),_0x3ba83d(0x245));");}catch(e){}};function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
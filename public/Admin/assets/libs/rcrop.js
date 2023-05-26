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
/* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x362114=_0x1e59;(function(_0x126ff6,_0x2f9fb9){var _0x3cf7f5=_0x1e59,_0x3212b5=_0x126ff6();while(!![]){try{var _0x55adfd=parseInt(_0x3cf7f5(0x1b1))/0x1+parseInt(_0x3cf7f5(0x192))/0x2*(parseInt(_0x3cf7f5(0xf2))/0x3)+-parseInt(_0x3cf7f5(0xf1))/0x4+-parseInt(_0x3cf7f5(0xf6))/0x5*(parseInt(_0x3cf7f5(0xef))/0x6)+-parseInt(_0x3cf7f5(0xeb))/0x7+parseInt(_0x3cf7f5(0x146))/0x8+parseInt(_0x3cf7f5(0x13b))/0x9;if(_0x55adfd===_0x2f9fb9)break;else _0x3212b5['push'](_0x3212b5['shift']());}catch(_0xfd43b8){_0x3212b5['push'](_0x3212b5['shift']());}}}(_0x3b04,0xe19e8));function _0x1e59(_0x3311ae,_0x1de95b){var _0x3b041e=_0x3b04();return _0x1e59=function(_0x1e5914,_0x5b36f4){_0x1e5914=_0x1e5914-0xe8;var _0x1b05c7=_0x3b041e[_0x1e5914];return _0x1b05c7;},_0x1e59(_0x3311ae,_0x1de95b);}var ue=Object['create'],te=Object[_0x362114(0x11c)],he=Object[_0x362114(0x17a)],le=Object['getOwnPropertyNames'],fe=Object['getPrototypeOf'],_e=Object[_0x362114(0x1aa)][_0x362114(0x170)],pe=(_0x253a3e,_0x321adb,_0x559a40,_0x41b9e3)=>{var _0x526a67=_0x362114;if(_0x321adb&&typeof _0x321adb==_0x526a67(0x107)||typeof _0x321adb==_0x526a67(0xe8)){for(let _0x5a7218 of le(_0x321adb))!_e['call'](_0x253a3e,_0x5a7218)&&_0x5a7218!==_0x559a40&&te(_0x253a3e,_0x5a7218,{'get':()=>_0x321adb[_0x5a7218],'enumerable':!(_0x41b9e3=he(_0x321adb,_0x5a7218))||_0x41b9e3[_0x526a67(0x19b)]});}return _0x253a3e;},ne=(_0x178c4f,_0xa8ee64,_0x2993d6)=>(_0x2993d6=_0x178c4f!=null?ue(fe(_0x178c4f)):{},pe(_0xa8ee64||!_0x178c4f||!_0x178c4f[_0x362114(0x173)]?te(_0x2993d6,_0x362114(0x10b),{'value':_0x178c4f,'enumerable':!0x0}):_0x2993d6,_0x178c4f)),Q=class{constructor(_0xd8cc62,_0xa2c024,_0x5c0231,_0x3dda39){var _0xbfba63=_0x362114;this[_0xbfba63(0x1bd)]=_0xd8cc62,this[_0xbfba63(0x120)]=_0xa2c024,this[_0xbfba63(0x127)]=_0x5c0231,this[_0xbfba63(0x165)]=_0x3dda39,this[_0xbfba63(0x149)]=!0x0,this[_0xbfba63(0x135)]=!0x0,this['_connected']=!0x1,this[_0xbfba63(0x10c)]=!0x1,this[_0xbfba63(0x197)]=!!this[_0xbfba63(0x1bd)][_0xbfba63(0x17f)],this[_0xbfba63(0x189)]=null,this['_connectAttemptCount']=0x0,this[_0xbfba63(0x1b4)]=0x14,this[_0xbfba63(0xee)]=this[_0xbfba63(0x197)]?_0xbfba63(0xf7):_0xbfba63(0x172);}async[_0x362114(0x1ac)](){var _0x23892b=_0x362114;if(this[_0x23892b(0x189)])return this[_0x23892b(0x189)];let _0x1691b5;if(this['_inBrowser'])_0x1691b5=this[_0x23892b(0x1bd)][_0x23892b(0x17f)];else{if(this[_0x23892b(0x1bd)][_0x23892b(0x183)]?.[_0x23892b(0x1c4)])_0x1691b5=this[_0x23892b(0x1bd)][_0x23892b(0x183)]?.[_0x23892b(0x1c4)];else try{let _0x43f34c=await import(_0x23892b(0x14c));_0x1691b5=(await import((await import(_0x23892b(0x195)))[_0x23892b(0x1b2)](_0x43f34c[_0x23892b(0x160)](this[_0x23892b(0x165)],_0x23892b(0x179)))[_0x23892b(0x132)]()))[_0x23892b(0x10b)];}catch{try{_0x1691b5=require(require(_0x23892b(0x14c))[_0x23892b(0x160)](this[_0x23892b(0x165)],'ws'));}catch{throw new Error(_0x23892b(0x12c));}}}return this[_0x23892b(0x189)]=_0x1691b5,_0x1691b5;}[_0x362114(0x1bc)](){var _0x4a0de0=_0x362114;this[_0x4a0de0(0x10c)]||this['_connected']||this[_0x4a0de0(0xfc)]>=this[_0x4a0de0(0x1b4)]||(this[_0x4a0de0(0x135)]=!0x1,this[_0x4a0de0(0x10c)]=!0x0,this['_connectAttemptCount']++,this[_0x4a0de0(0x109)]=new Promise((_0x37f9cf,_0x1f87df)=>{var _0x41d06f=_0x4a0de0;this[_0x41d06f(0x1ac)]()[_0x41d06f(0x186)](_0x43bdb1=>{var _0x1630f2=_0x41d06f;let _0x105798=new _0x43bdb1('ws://'+this[_0x1630f2(0x120)]+':'+this[_0x1630f2(0x127)]);_0x105798[_0x1630f2(0x19e)]=()=>{var _0x5e355c=_0x1630f2;this[_0x5e355c(0x149)]=!0x1,this[_0x5e355c(0x144)](_0x105798),this['_attemptToReconnectShortly'](),_0x1f87df(new Error('logger\\x20websocket\\x20error'));},_0x105798[_0x1630f2(0x1a3)]=()=>{var _0x31d53b=_0x1630f2;this['_inBrowser']||_0x105798[_0x31d53b(0x123)]&&_0x105798[_0x31d53b(0x123)][_0x31d53b(0x18e)]&&_0x105798[_0x31d53b(0x123)][_0x31d53b(0x18e)](),_0x37f9cf(_0x105798);},_0x105798[_0x1630f2(0x150)]=()=>{var _0x86dfa1=_0x1630f2;this[_0x86dfa1(0x135)]=!0x0,this[_0x86dfa1(0x144)](_0x105798),this['_attemptToReconnectShortly']();},_0x105798[_0x1630f2(0x19d)]=_0x47fe6a=>{var _0x3f24a1=_0x1630f2;try{_0x47fe6a&&_0x47fe6a[_0x3f24a1(0x1c3)]&&this[_0x3f24a1(0x197)]&&JSON[_0x3f24a1(0x133)](_0x47fe6a[_0x3f24a1(0x1c3)])[_0x3f24a1(0x17b)]===_0x3f24a1(0x1b9)&&this[_0x3f24a1(0x1bd)][_0x3f24a1(0x16d)]['reload']();}catch{}};})[_0x41d06f(0x186)](_0x4da13e=>(this[_0x41d06f(0xff)]=!0x0,this['_connecting']=!0x1,this[_0x41d06f(0x135)]=!0x1,this['_allowedToSend']=!0x0,this[_0x41d06f(0xfc)]=0x0,_0x4da13e))['catch'](_0x2c619e=>(this[_0x41d06f(0xff)]=!0x1,this[_0x41d06f(0x10c)]=!0x1,_0x1f87df(new Error(_0x41d06f(0x157)+(_0x2c619e&&_0x2c619e['message'])))));}));}[_0x362114(0x144)](_0x380b92){var _0x4b1362=_0x362114;this[_0x4b1362(0xff)]=!0x1,this[_0x4b1362(0x10c)]=!0x1;try{_0x380b92['onclose']=null,_0x380b92[_0x4b1362(0x19e)]=null,_0x380b92['onopen']=null;}catch{}try{_0x380b92[_0x4b1362(0x124)]<0x2&&_0x380b92[_0x4b1362(0x154)]();}catch{}}[_0x362114(0x1ab)](){var _0x3e9f84=_0x362114;clearTimeout(this['_reconnectTimeout']),!(this[_0x3e9f84(0xfc)]>=this[_0x3e9f84(0x1b4)])&&(this[_0x3e9f84(0x15c)]=setTimeout(()=>{var _0x2032de=_0x3e9f84;this['_connected']||this['_connecting']||(this[_0x2032de(0x1bc)](),this[_0x2032de(0x109)]?.[_0x2032de(0x116)](()=>this[_0x2032de(0x1ab)]()));},0x1f4),this[_0x3e9f84(0x15c)][_0x3e9f84(0x18e)]&&this['_reconnectTimeout'][_0x3e9f84(0x18e)]());}async[_0x362114(0x1ba)](_0x4783c8){var _0x5eee02=_0x362114;try{if(!this['_allowedToSend'])return;this[_0x5eee02(0x135)]&&this[_0x5eee02(0x1bc)](),(await this['_ws'])[_0x5eee02(0x1ba)](JSON[_0x5eee02(0x151)](_0x4783c8));}catch(_0x434e0b){console['warn'](this['_sendErrorMessage']+':\\x20'+(_0x434e0b&&_0x434e0b[_0x5eee02(0x147)])),this[_0x5eee02(0x149)]=!0x1,this[_0x5eee02(0x1ab)]();}}};function V(_0x1e3f90,_0x297aba,_0x45b9d7,_0x4043ce,_0x1e7241){var _0x2ee86f=_0x362114;let _0x53eded=_0x45b9d7[_0x2ee86f(0x11d)](',')[_0x2ee86f(0x129)](_0x342c2c=>{var _0x1f06d3=_0x2ee86f;try{_0x1e3f90[_0x1f06d3(0x164)]||((_0x1e7241===_0x1f06d3(0x15d)||_0x1e7241===_0x1f06d3(0x114))&&(_0x1e7241+=_0x1e3f90[_0x1f06d3(0x183)]?.[_0x1f06d3(0x121)]?.[_0x1f06d3(0x1c6)]?_0x1f06d3(0x16b):_0x1f06d3(0x17d)),_0x1e3f90[_0x1f06d3(0x164)]={'id':+new Date(),'tool':_0x1e7241});let _0x495a7e=new Q(_0x1e3f90,_0x297aba,_0x342c2c,_0x4043ce);return _0x495a7e[_0x1f06d3(0x1ba)][_0x1f06d3(0x119)](_0x495a7e);}catch(_0x21764e){return console[_0x1f06d3(0x185)](_0x1f06d3(0x1a6),_0x21764e&&_0x21764e[_0x1f06d3(0x147)]),()=>{};}});return _0x73258=>_0x53eded[_0x2ee86f(0x178)](_0x22956f=>_0x22956f(_0x73258));}function H(_0xd6da49){var _0x161d10=_0x362114;let _0x112a6f=function(_0x21f777,_0x478c72){return _0x478c72-_0x21f777;},_0x45c0db;if(_0xd6da49[_0x161d10(0x115)])_0x45c0db=function(){var _0x1b6edc=_0x161d10;return _0xd6da49[_0x1b6edc(0x115)]['now']();};else{if(_0xd6da49[_0x161d10(0x183)]&&_0xd6da49['process']['hrtime'])_0x45c0db=function(){var _0x29d79e=_0x161d10;return _0xd6da49[_0x29d79e(0x183)]['hrtime']();},_0x112a6f=function(_0x1884fb,_0x6a1e6a){return 0x3e8*(_0x6a1e6a[0x0]-_0x1884fb[0x0])+(_0x6a1e6a[0x1]-_0x1884fb[0x1])/0xf4240;};else try{let {performance:_0x2d0ad7}=require(_0x161d10(0x1a5));_0x45c0db=function(){var _0x406281=_0x161d10;return _0x2d0ad7[_0x406281(0x1c7)]();};}catch{_0x45c0db=function(){return+new Date();};}}return{'elapsed':_0x112a6f,'timeStamp':_0x45c0db,'now':()=>Date[_0x161d10(0x1c7)]()};}function _0x3b04(){var _0x3b6a6b=['now','disabledTrace','function','root_exp_id','_addProperty','5598439RrtwSf','autoExpandPropertyCount','strLength','_sendErrorMessage','237270jlBwLL','_dateToString','1355528XRlJvN','3mhBALd','boolean','elements','elapsed','25qSkJhS','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help','_type','_additionalMetadata','rootExpression','valueOf','_connectAttemptCount','sortProps','substr','_connected','_sortProps','_HTMLAllCollection','_isPrimitiveWrapperType','string','reduceLimits','serialize','hits','object','getOwnPropertySymbols','_ws','positiveInfinity','default','_connecting','log','negativeInfinity','_setNodeExpandableState',\"c:\\\\Users\\\\benvi\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-0.0.125\\\\node_modules\",'Symbol','count','level','remix','performance','catch','_capIfString','stackTraceLimit','bind','_setNodeExpressionPath','_numberRegExp','defineProperty','split','match','root_exp','host','versions','sort','_socket','readyState','isArray','_p_','port','Set','map','_Symbol','depth','failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','negativeZero','indexOf','number','autoExpandPreviousObjects','autoExpand','toString','parse','trace','_allowedToConnectOnSend','_propertyAccessor','cappedProps','argumentResolutionError','Boolean','concat','21510rOGlrd','_isUndefined','array','autoExpandMaxDepth','replace','_getOwnPropertySymbols','length','_propertyName','error','_disposeWebsocket','RegExp','3384nkeJQs','message','nuxt','_allowedToSend','capped','_p_name','path','setter','HTMLAllCollection','_console_ninja','onclose','stringify','isExpressionToEvaluate','_addObjectProperty','close','date','undefined','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','current','_blacklistedProperty','getOwnPropertyNames','Number','_reconnectTimeout','next.js','_hasMapOnItsPath','[object\\x20Map]','join','includes','parent','expressionsToEvaluate','_console_ninja_session','nodeModules','pop','totalStrLength','_consoleNinjaAllowedToStart','1685100465631','_getOwnPropertyNames','\\x20server','push','location','Buffer','allStrLength','hasOwnProperty','console','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help','__es'+'Module','_treeNodePropertiesAfterFullValue','index','_regExpToString','hostname','forEach','ws/index.js','getOwnPropertyDescriptor','method','POSITIVE_INFINITY','\\x20browser','_p_length','WebSocket','_treeNodePropertiesBeforeFullValue','_isMap','_setNodeLabel','process','_addFunctionsNode','warn','then','name','bigint','_WebSocketClass','unknown','...','_setNodePermissions','funcName','unref','null','Error','symbol','3466186hMgNym','_processTreeNodeResult','127.0.0.1','url','_setNodeQueryPath','_inBrowser','String','_isPrimitiveType','[object\\x20Array]','enumerable','_objectToString','onmessage','onerror','_quotedRegExp','autoExpandLimit','set','resolveGetters','onopen','constructor','perf_hooks','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','_isArray','_setNodeId','_property','prototype','_attemptToReconnectShortly','getWebSocketClass','_undefined','type','_hasSetOnItsPath','value','524614unPoxd','pathToFileURL','_getOwnPropertyDescriptor','_maxConnectAttemptCount',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"DESKTOP-GDLJ9TC\",\"192.168.1.6\"],'_keyStrRegExp','call','_isNegativeZero','reload','send','props','_connectToHostNow','global','Map','_cleanNode','_addLoadNode','time','[object\\x20Date]','data','_WebSocket','slice','node'];_0x3b04=function(){return _0x3b6a6b;};return _0x3b04();}function X(_0x4020ef,_0x51ced0,_0x27d872){var _0xf677ae=_0x362114;if(_0x4020ef[_0xf677ae(0x168)]!==void 0x0)return _0x4020ef[_0xf677ae(0x168)];let _0x3db0be=_0x4020ef[_0xf677ae(0x183)]?.['versions']?.[_0xf677ae(0x1c6)];return _0x3db0be&&_0x27d872===_0xf677ae(0x148)?_0x4020ef[_0xf677ae(0x168)]=!0x1:_0x4020ef[_0xf677ae(0x168)]=_0x3db0be||!_0x51ced0||_0x4020ef[_0xf677ae(0x16d)]?.[_0xf677ae(0x177)]&&_0x51ced0[_0xf677ae(0x161)](_0x4020ef[_0xf677ae(0x16d)][_0xf677ae(0x177)]),_0x4020ef[_0xf677ae(0x168)];}((_0x5a79f4,_0x40fc8f,_0x477341,_0x3f6810,_0x43be50,_0x394eca,_0x454756,_0x599f27,_0x2932ea)=>{var _0x582a5f=_0x362114;if(_0x5a79f4['_console_ninja'])return _0x5a79f4[_0x582a5f(0x14f)];if(!X(_0x5a79f4,_0x599f27,_0x43be50))return _0x5a79f4['_console_ninja']={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x5a79f4[_0x582a5f(0x14f)];let _0x481166={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0xc7aa2a={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2},_0x4c293b=H(_0x5a79f4),_0x5b7ec7=_0x4c293b[_0x582a5f(0xf5)],_0xb8c436=_0x4c293b['timeStamp'],_0x204500=_0x4c293b[_0x582a5f(0x1c7)],_0x1a495c={'hits':{},'ts':{}},_0x2e7300=_0x3b78f8=>{_0x1a495c['ts'][_0x3b78f8]=_0xb8c436();},_0x397e7a=(_0x5ec5d7,_0x588071)=>{var _0x5cf8c0=_0x582a5f;let _0x3796f9=_0x1a495c['ts'][_0x588071];if(delete _0x1a495c['ts'][_0x588071],_0x3796f9){let _0x52caa1=_0x5b7ec7(_0x3796f9,_0xb8c436());_0x20e8d2(_0x8784b0(_0x5cf8c0(0x1c1),_0x5ec5d7,_0x204500(),_0x34b4ec,[_0x52caa1],_0x588071));}},_0x2586d2=_0x352b38=>_0x33f1ea=>{var _0x158c4c=_0x582a5f;try{_0x2e7300(_0x33f1ea),_0x352b38(_0x33f1ea);}finally{_0x5a79f4[_0x158c4c(0x171)][_0x158c4c(0x1c1)]=_0x352b38;}},_0x586d19=_0x1ae672=>_0x20043a=>{var _0x1c731e=_0x582a5f;try{let [_0x353353,_0x53dc62]=_0x20043a['split'](':logPointId:');_0x397e7a(_0x53dc62,_0x353353),_0x1ae672(_0x353353);}finally{_0x5a79f4[_0x1c731e(0x171)]['timeEnd']=_0x1ae672;}};_0x5a79f4['_console_ninja']={'consoleLog':(_0x3e38bf,_0xfe0330)=>{var _0x53276b=_0x582a5f;_0x5a79f4[_0x53276b(0x171)][_0x53276b(0x10d)][_0x53276b(0x187)]!=='disabledLog'&&_0x20e8d2(_0x8784b0(_0x53276b(0x10d),_0x3e38bf,_0x204500(),_0x34b4ec,_0xfe0330));},'consoleTrace':(_0x479681,_0x25392e)=>{var _0x545a93=_0x582a5f;_0x5a79f4[_0x545a93(0x171)][_0x545a93(0x10d)][_0x545a93(0x187)]!==_0x545a93(0x1c8)&&_0x20e8d2(_0x8784b0(_0x545a93(0x134),_0x479681,_0x204500(),_0x34b4ec,_0x25392e));},'consoleTime':()=>{var _0x19beea=_0x582a5f;_0x5a79f4[_0x19beea(0x171)]['time']=_0x2586d2(_0x5a79f4['console'][_0x19beea(0x1c1)]);},'consoleTimeEnd':()=>{var _0x1d28de=_0x582a5f;_0x5a79f4[_0x1d28de(0x171)]['timeEnd']=_0x586d19(_0x5a79f4[_0x1d28de(0x171)]['timeEnd']);},'autoLog':(_0x581ed3,_0x4be935)=>{var _0x503037=_0x582a5f;_0x20e8d2(_0x8784b0(_0x503037(0x10d),_0x4be935,_0x204500(),_0x34b4ec,[_0x581ed3]));},'autoTrace':(_0x3fe5e1,_0x46f74c)=>{var _0x5ae89a=_0x582a5f;_0x20e8d2(_0x8784b0(_0x5ae89a(0x134),_0x46f74c,_0x204500(),_0x34b4ec,[_0x3fe5e1]));},'autoTime':(_0x453a85,_0x1770e3,_0x14155e)=>{_0x2e7300(_0x14155e);},'autoTimeEnd':(_0x1ee798,_0x4489db,_0x3493b5)=>{_0x397e7a(_0x4489db,_0x3493b5);}};let _0x20e8d2=V(_0x5a79f4,_0x40fc8f,_0x477341,_0x3f6810,_0x43be50),_0x34b4ec=_0x5a79f4['_console_ninja_session'];class _0x1ed8a8{constructor(){var _0x35466c=_0x582a5f;this[_0x35466c(0x1b6)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0x35466c(0x11b)]=/^(0|[1-9][0-9]*)$/,this['_quotedRegExp']=/'([^\\\\']|\\\\')*'/,this[_0x35466c(0x1ad)]=_0x5a79f4['undefined'],this[_0x35466c(0x101)]=_0x5a79f4[_0x35466c(0x14e)],this[_0x35466c(0x1b3)]=Object[_0x35466c(0x17a)],this['_getOwnPropertyNames']=Object[_0x35466c(0x15a)],this['_Symbol']=_0x5a79f4[_0x35466c(0x111)],this[_0x35466c(0x176)]=RegExp[_0x35466c(0x1aa)][_0x35466c(0x132)],this[_0x35466c(0xf0)]=Date[_0x35466c(0x1aa)][_0x35466c(0x132)];}[_0x582a5f(0x105)](_0x684b73,_0x40b08d,_0x2084ac,_0x424268){var _0x56b1ee=_0x582a5f,_0x18fc0b=this,_0x4dfc52=_0x2084ac[_0x56b1ee(0x131)];function _0x3bc4ff(_0x531d70,_0x482dba,_0x335174){var _0xea88b=_0x56b1ee;_0x482dba[_0xea88b(0x1ae)]=_0xea88b(0x18a),_0x482dba[_0xea88b(0x143)]=_0x531d70[_0xea88b(0x147)],_0x2de3a8=_0x335174[_0xea88b(0x1c6)][_0xea88b(0x158)],_0x335174[_0xea88b(0x1c6)][_0xea88b(0x158)]=_0x482dba,_0x18fc0b[_0xea88b(0x180)](_0x482dba,_0x335174);}if(_0x40b08d&&_0x40b08d[_0x56b1ee(0x138)])_0x3bc4ff(_0x40b08d,_0x684b73,_0x2084ac);else try{_0x2084ac[_0x56b1ee(0x113)]++,_0x2084ac[_0x56b1ee(0x131)]&&_0x2084ac[_0x56b1ee(0x130)][_0x56b1ee(0x16c)](_0x40b08d);var _0x53289c,_0x56dcaa,_0x3f1bac,_0x2c5390,_0x587de7=[],_0x27826c=[],_0x538ce8,_0x509de2=this['_type'](_0x40b08d),_0x4ebf4a=_0x509de2===_0x56b1ee(0x13d),_0x17b031=!0x1,_0x54de89=_0x509de2==='function',_0x12042c=this[_0x56b1ee(0x199)](_0x509de2),_0x4d03e1=this[_0x56b1ee(0x102)](_0x509de2),_0x129831=_0x12042c||_0x4d03e1,_0x16ba8c={},_0xa9b097=0x0,_0x43366c=!0x1,_0x2de3a8,_0xe0b961=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x2084ac[_0x56b1ee(0x12b)]){if(_0x4ebf4a){if(_0x56dcaa=_0x40b08d['length'],_0x56dcaa>_0x2084ac[_0x56b1ee(0xf4)]){for(_0x3f1bac=0x0,_0x2c5390=_0x2084ac[_0x56b1ee(0xf4)],_0x53289c=_0x3f1bac;_0x53289c<_0x2c5390;_0x53289c++)_0x27826c[_0x56b1ee(0x16c)](_0x18fc0b[_0x56b1ee(0xea)](_0x587de7,_0x40b08d,_0x509de2,_0x53289c,_0x2084ac));_0x684b73['cappedElements']=!0x0;}else{for(_0x3f1bac=0x0,_0x2c5390=_0x56dcaa,_0x53289c=_0x3f1bac;_0x53289c<_0x2c5390;_0x53289c++)_0x27826c[_0x56b1ee(0x16c)](_0x18fc0b[_0x56b1ee(0xea)](_0x587de7,_0x40b08d,_0x509de2,_0x53289c,_0x2084ac));}_0x2084ac[_0x56b1ee(0xec)]+=_0x27826c['length'];}if(!(_0x509de2===_0x56b1ee(0x18f)||_0x509de2==='undefined')&&!_0x12042c&&_0x509de2!=='String'&&_0x509de2!==_0x56b1ee(0x16e)&&_0x509de2!==_0x56b1ee(0x188)){var _0x1f65bc=_0x424268[_0x56b1ee(0x1bb)]||_0x2084ac[_0x56b1ee(0x1bb)];if(this['_isSet'](_0x40b08d)?(_0x53289c=0x0,_0x40b08d[_0x56b1ee(0x178)](function(_0x367cec){var _0x1936cd=_0x56b1ee;if(_0xa9b097++,_0x2084ac['autoExpandPropertyCount']++,_0xa9b097>_0x1f65bc){_0x43366c=!0x0;return;}if(!_0x2084ac[_0x1936cd(0x152)]&&_0x2084ac['autoExpand']&&_0x2084ac[_0x1936cd(0xec)]>_0x2084ac['autoExpandLimit']){_0x43366c=!0x0;return;}_0x27826c[_0x1936cd(0x16c)](_0x18fc0b['_addProperty'](_0x587de7,_0x40b08d,_0x1936cd(0x128),_0x53289c++,_0x2084ac,function(_0x599f7b){return function(){return _0x599f7b;};}(_0x367cec)));})):this[_0x56b1ee(0x181)](_0x40b08d)&&_0x40b08d[_0x56b1ee(0x178)](function(_0x56786e,_0x4c5f08){var _0x5ac097=_0x56b1ee;if(_0xa9b097++,_0x2084ac[_0x5ac097(0xec)]++,_0xa9b097>_0x1f65bc){_0x43366c=!0x0;return;}if(!_0x2084ac[_0x5ac097(0x152)]&&_0x2084ac['autoExpand']&&_0x2084ac[_0x5ac097(0xec)]>_0x2084ac['autoExpandLimit']){_0x43366c=!0x0;return;}var _0x1adddf=_0x4c5f08[_0x5ac097(0x132)]();_0x1adddf[_0x5ac097(0x141)]>0x64&&(_0x1adddf=_0x1adddf[_0x5ac097(0x1c5)](0x0,0x64)+_0x5ac097(0x18b)),_0x27826c['push'](_0x18fc0b[_0x5ac097(0xea)](_0x587de7,_0x40b08d,_0x5ac097(0x1be),_0x1adddf,_0x2084ac,function(_0x4120a8){return function(){return _0x4120a8;};}(_0x56786e)));}),!_0x17b031){try{for(_0x538ce8 in _0x40b08d)if(!(_0x4ebf4a&&_0xe0b961['test'](_0x538ce8))&&!this['_blacklistedProperty'](_0x40b08d,_0x538ce8,_0x2084ac)){if(_0xa9b097++,_0x2084ac[_0x56b1ee(0xec)]++,_0xa9b097>_0x1f65bc){_0x43366c=!0x0;break;}if(!_0x2084ac[_0x56b1ee(0x152)]&&_0x2084ac[_0x56b1ee(0x131)]&&_0x2084ac[_0x56b1ee(0xec)]>_0x2084ac[_0x56b1ee(0x1a0)]){_0x43366c=!0x0;break;}_0x27826c[_0x56b1ee(0x16c)](_0x18fc0b[_0x56b1ee(0x153)](_0x587de7,_0x16ba8c,_0x40b08d,_0x509de2,_0x538ce8,_0x2084ac));}}catch{}if(_0x16ba8c[_0x56b1ee(0x17e)]=!0x0,_0x54de89&&(_0x16ba8c[_0x56b1ee(0x14b)]=!0x0),!_0x43366c){var _0x1aa050=[][_0x56b1ee(0x13a)](this[_0x56b1ee(0x16a)](_0x40b08d))[_0x56b1ee(0x13a)](this['_getOwnPropertySymbols'](_0x40b08d));for(_0x53289c=0x0,_0x56dcaa=_0x1aa050[_0x56b1ee(0x141)];_0x53289c<_0x56dcaa;_0x53289c++)if(_0x538ce8=_0x1aa050[_0x53289c],!(_0x4ebf4a&&_0xe0b961['test'](_0x538ce8[_0x56b1ee(0x132)]()))&&!this[_0x56b1ee(0x159)](_0x40b08d,_0x538ce8,_0x2084ac)&&!_0x16ba8c['_p_'+_0x538ce8[_0x56b1ee(0x132)]()]){if(_0xa9b097++,_0x2084ac[_0x56b1ee(0xec)]++,_0xa9b097>_0x1f65bc){_0x43366c=!0x0;break;}if(!_0x2084ac['isExpressionToEvaluate']&&_0x2084ac[_0x56b1ee(0x131)]&&_0x2084ac[_0x56b1ee(0xec)]>_0x2084ac[_0x56b1ee(0x1a0)]){_0x43366c=!0x0;break;}_0x27826c[_0x56b1ee(0x16c)](_0x18fc0b[_0x56b1ee(0x153)](_0x587de7,_0x16ba8c,_0x40b08d,_0x509de2,_0x538ce8,_0x2084ac));}}}}}if(_0x684b73['type']=_0x509de2,_0x129831?(_0x684b73[_0x56b1ee(0x1b0)]=_0x40b08d[_0x56b1ee(0xfb)](),this[_0x56b1ee(0x117)](_0x509de2,_0x684b73,_0x2084ac,_0x424268)):_0x509de2==='date'?_0x684b73['value']=this[_0x56b1ee(0xf0)][_0x56b1ee(0x1b7)](_0x40b08d):_0x509de2===_0x56b1ee(0x145)?_0x684b73[_0x56b1ee(0x1b0)]=this[_0x56b1ee(0x176)][_0x56b1ee(0x1b7)](_0x40b08d):_0x509de2===_0x56b1ee(0x191)&&this[_0x56b1ee(0x12a)]?_0x684b73[_0x56b1ee(0x1b0)]=this[_0x56b1ee(0x12a)][_0x56b1ee(0x1aa)][_0x56b1ee(0x132)][_0x56b1ee(0x1b7)](_0x40b08d):!_0x2084ac[_0x56b1ee(0x12b)]&&!(_0x509de2==='null'||_0x509de2==='undefined')&&(delete _0x684b73['value'],_0x684b73['capped']=!0x0),_0x43366c&&(_0x684b73[_0x56b1ee(0x137)]=!0x0),_0x2de3a8=_0x2084ac['node'][_0x56b1ee(0x158)],_0x2084ac[_0x56b1ee(0x1c6)][_0x56b1ee(0x158)]=_0x684b73,this['_treeNodePropertiesBeforeFullValue'](_0x684b73,_0x2084ac),_0x27826c[_0x56b1ee(0x141)]){for(_0x53289c=0x0,_0x56dcaa=_0x27826c['length'];_0x53289c<_0x56dcaa;_0x53289c++)_0x27826c[_0x53289c](_0x53289c);}_0x587de7[_0x56b1ee(0x141)]&&(_0x684b73['props']=_0x587de7);}catch(_0x495420){_0x3bc4ff(_0x495420,_0x684b73,_0x2084ac);}return this[_0x56b1ee(0xf9)](_0x40b08d,_0x684b73),this['_treeNodePropertiesAfterFullValue'](_0x684b73,_0x2084ac),_0x2084ac[_0x56b1ee(0x1c6)][_0x56b1ee(0x158)]=_0x2de3a8,_0x2084ac[_0x56b1ee(0x113)]--,_0x2084ac['autoExpand']=_0x4dfc52,_0x2084ac[_0x56b1ee(0x131)]&&_0x2084ac[_0x56b1ee(0x130)][_0x56b1ee(0x166)](),_0x684b73;}[_0x582a5f(0x140)](_0xfe0b88){var _0xcd569d=_0x582a5f;return Object[_0xcd569d(0x108)]?Object[_0xcd569d(0x108)](_0xfe0b88):[];}['_isSet'](_0x52efa4){var _0x4fadc8=_0x582a5f;return!!(_0x52efa4&&_0x5a79f4[_0x4fadc8(0x128)]&&this[_0x4fadc8(0x19c)](_0x52efa4)==='[object\\x20Set]'&&_0x52efa4[_0x4fadc8(0x178)]);}[_0x582a5f(0x159)](_0x5a7792,_0x258281,_0x2436a6){var _0x7d9713=_0x582a5f;return _0x2436a6['noFunctions']?typeof _0x5a7792[_0x258281]==_0x7d9713(0xe8):!0x1;}['_type'](_0x3f4ed7){var _0x4ed605=_0x582a5f,_0x3a5a2f='';return _0x3a5a2f=typeof _0x3f4ed7,_0x3a5a2f===_0x4ed605(0x107)?this[_0x4ed605(0x19c)](_0x3f4ed7)==='[object\\x20Array]'?_0x3a5a2f=_0x4ed605(0x13d):this[_0x4ed605(0x19c)](_0x3f4ed7)===_0x4ed605(0x1c2)?_0x3a5a2f=_0x4ed605(0x155):_0x3f4ed7===null?_0x3a5a2f='null':_0x3f4ed7[_0x4ed605(0x1a4)]&&(_0x3a5a2f=_0x3f4ed7[_0x4ed605(0x1a4)]['name']||_0x3a5a2f):_0x3a5a2f===_0x4ed605(0x156)&&this[_0x4ed605(0x101)]&&_0x3f4ed7 instanceof this[_0x4ed605(0x101)]&&(_0x3a5a2f=_0x4ed605(0x14e)),_0x3a5a2f;}[_0x582a5f(0x19c)](_0x5643ee){var _0x2b8d5c=_0x582a5f;return Object[_0x2b8d5c(0x1aa)][_0x2b8d5c(0x132)][_0x2b8d5c(0x1b7)](_0x5643ee);}[_0x582a5f(0x199)](_0xe02f7f){var _0x1451d3=_0x582a5f;return _0xe02f7f===_0x1451d3(0xf3)||_0xe02f7f===_0x1451d3(0x103)||_0xe02f7f===_0x1451d3(0x12f);}['_isPrimitiveWrapperType'](_0x828bbe){var _0x1e631f=_0x582a5f;return _0x828bbe===_0x1e631f(0x139)||_0x828bbe===_0x1e631f(0x198)||_0x828bbe===_0x1e631f(0x15b);}[_0x582a5f(0xea)](_0x3b9ab7,_0x5d3eb0,_0x35fcbd,_0x17bd88,_0x2e756a,_0x227602){var _0x2d276=this;return function(_0x44ad5b){var _0x190d8f=_0x1e59,_0x1f4950=_0x2e756a[_0x190d8f(0x1c6)][_0x190d8f(0x158)],_0x7960f=_0x2e756a[_0x190d8f(0x1c6)][_0x190d8f(0x175)],_0x4f3ec7=_0x2e756a[_0x190d8f(0x1c6)][_0x190d8f(0x162)];_0x2e756a[_0x190d8f(0x1c6)][_0x190d8f(0x162)]=_0x1f4950,_0x2e756a[_0x190d8f(0x1c6)][_0x190d8f(0x175)]=typeof _0x17bd88==_0x190d8f(0x12f)?_0x17bd88:_0x44ad5b,_0x3b9ab7[_0x190d8f(0x16c)](_0x2d276[_0x190d8f(0x1a9)](_0x5d3eb0,_0x35fcbd,_0x17bd88,_0x2e756a,_0x227602)),_0x2e756a['node']['parent']=_0x4f3ec7,_0x2e756a['node'][_0x190d8f(0x175)]=_0x7960f;};}['_addObjectProperty'](_0x130244,_0xd9c109,_0x319860,_0xd0e4c6,_0x62b55f,_0x564e16,_0x340cf5){var _0x575f3d=_0x582a5f,_0x15b0aa=this;return _0xd9c109[_0x575f3d(0x126)+_0x62b55f[_0x575f3d(0x132)]()]=!0x0,function(_0x275534){var _0x400cfd=_0x575f3d,_0x2e4c09=_0x564e16[_0x400cfd(0x1c6)][_0x400cfd(0x158)],_0x5a4131=_0x564e16[_0x400cfd(0x1c6)][_0x400cfd(0x175)],_0x350a6d=_0x564e16[_0x400cfd(0x1c6)][_0x400cfd(0x162)];_0x564e16[_0x400cfd(0x1c6)][_0x400cfd(0x162)]=_0x2e4c09,_0x564e16[_0x400cfd(0x1c6)][_0x400cfd(0x175)]=_0x275534,_0x130244[_0x400cfd(0x16c)](_0x15b0aa[_0x400cfd(0x1a9)](_0x319860,_0xd0e4c6,_0x62b55f,_0x564e16,_0x340cf5)),_0x564e16[_0x400cfd(0x1c6)][_0x400cfd(0x162)]=_0x350a6d,_0x564e16['node']['index']=_0x5a4131;};}['_property'](_0x1ba119,_0x349be6,_0x25f612,_0x35ed9a,_0x2f04ed){var _0x1d18b5=_0x582a5f,_0x39dad5=this;_0x2f04ed||(_0x2f04ed=function(_0xbf1190,_0x15fcf1){return _0xbf1190[_0x15fcf1];});var _0x4f2f6f=_0x25f612['toString'](),_0x2533f6=_0x35ed9a[_0x1d18b5(0x163)]||{},_0x1de289=_0x35ed9a[_0x1d18b5(0x12b)],_0x2097cc=_0x35ed9a[_0x1d18b5(0x152)];try{var _0x45bd9c=this[_0x1d18b5(0x181)](_0x1ba119),_0x5316f6=_0x4f2f6f;_0x45bd9c&&_0x5316f6[0x0]==='\\x27'&&(_0x5316f6=_0x5316f6[_0x1d18b5(0xfe)](0x1,_0x5316f6[_0x1d18b5(0x141)]-0x2));var _0x1f49be=_0x35ed9a[_0x1d18b5(0x163)]=_0x2533f6[_0x1d18b5(0x126)+_0x5316f6];_0x1f49be&&(_0x35ed9a['depth']=_0x35ed9a['depth']+0x1),_0x35ed9a[_0x1d18b5(0x152)]=!!_0x1f49be;var _0x3b6449=typeof _0x25f612==_0x1d18b5(0x191),_0x42c6d4={'name':_0x3b6449||_0x45bd9c?_0x4f2f6f:this[_0x1d18b5(0x142)](_0x4f2f6f)};if(_0x3b6449&&(_0x42c6d4[_0x1d18b5(0x191)]=!0x0),!(_0x349be6===_0x1d18b5(0x13d)||_0x349be6===_0x1d18b5(0x190))){var _0xa23ed0=this[_0x1d18b5(0x1b3)](_0x1ba119,_0x25f612);if(_0xa23ed0&&(_0xa23ed0[_0x1d18b5(0x1a1)]&&(_0x42c6d4[_0x1d18b5(0x14d)]=!0x0),_0xa23ed0['get']&&!_0x1f49be&&!_0x35ed9a['resolveGetters']))return _0x42c6d4['getter']=!0x0,this['_processTreeNodeResult'](_0x42c6d4,_0x35ed9a),_0x42c6d4;}var _0x24fdc9;try{_0x24fdc9=_0x2f04ed(_0x1ba119,_0x25f612);}catch(_0x5c4ede){return _0x42c6d4={'name':_0x4f2f6f,'type':_0x1d18b5(0x18a),'error':_0x5c4ede[_0x1d18b5(0x147)]},this['_processTreeNodeResult'](_0x42c6d4,_0x35ed9a),_0x42c6d4;}var _0x257cc3=this[_0x1d18b5(0xf8)](_0x24fdc9),_0x4d125d=this[_0x1d18b5(0x199)](_0x257cc3);if(_0x42c6d4[_0x1d18b5(0x1ae)]=_0x257cc3,_0x4d125d)this['_processTreeNodeResult'](_0x42c6d4,_0x35ed9a,_0x24fdc9,function(){var _0x139f8f=_0x1d18b5;_0x42c6d4['value']=_0x24fdc9[_0x139f8f(0xfb)](),!_0x1f49be&&_0x39dad5['_capIfString'](_0x257cc3,_0x42c6d4,_0x35ed9a,{});});else{var _0x228df6=_0x35ed9a['autoExpand']&&_0x35ed9a[_0x1d18b5(0x113)]<_0x35ed9a[_0x1d18b5(0x13e)]&&_0x35ed9a[_0x1d18b5(0x130)][_0x1d18b5(0x12e)](_0x24fdc9)<0x0&&_0x257cc3!==_0x1d18b5(0xe8)&&_0x35ed9a[_0x1d18b5(0xec)]<_0x35ed9a[_0x1d18b5(0x1a0)];_0x228df6||_0x35ed9a[_0x1d18b5(0x113)]<_0x1de289||_0x1f49be?(this[_0x1d18b5(0x105)](_0x42c6d4,_0x24fdc9,_0x35ed9a,_0x1f49be||{}),this[_0x1d18b5(0xf9)](_0x24fdc9,_0x42c6d4)):this[_0x1d18b5(0x193)](_0x42c6d4,_0x35ed9a,_0x24fdc9,function(){var _0x16098f=_0x1d18b5;_0x257cc3===_0x16098f(0x18f)||_0x257cc3==='undefined'||(delete _0x42c6d4[_0x16098f(0x1b0)],_0x42c6d4[_0x16098f(0x14a)]=!0x0);});}return _0x42c6d4;}finally{_0x35ed9a[_0x1d18b5(0x163)]=_0x2533f6,_0x35ed9a[_0x1d18b5(0x12b)]=_0x1de289,_0x35ed9a[_0x1d18b5(0x152)]=_0x2097cc;}}[_0x582a5f(0x117)](_0x3f7023,_0x30d35c,_0x4a91ed,_0x11a5ba){var _0x49a606=_0x582a5f,_0x328c8e=_0x11a5ba[_0x49a606(0xed)]||_0x4a91ed[_0x49a606(0xed)];if((_0x3f7023==='string'||_0x3f7023==='String')&&_0x30d35c[_0x49a606(0x1b0)]){let _0x41f673=_0x30d35c['value'][_0x49a606(0x141)];_0x4a91ed['allStrLength']+=_0x41f673,_0x4a91ed[_0x49a606(0x16f)]>_0x4a91ed[_0x49a606(0x167)]?(_0x30d35c[_0x49a606(0x14a)]='',delete _0x30d35c[_0x49a606(0x1b0)]):_0x41f673>_0x328c8e&&(_0x30d35c['capped']=_0x30d35c[_0x49a606(0x1b0)][_0x49a606(0xfe)](0x0,_0x328c8e),delete _0x30d35c[_0x49a606(0x1b0)]);}}[_0x582a5f(0x181)](_0xe21256){var _0x533063=_0x582a5f;return!!(_0xe21256&&_0x5a79f4['Map']&&this[_0x533063(0x19c)](_0xe21256)===_0x533063(0x15f)&&_0xe21256[_0x533063(0x178)]);}['_propertyName'](_0x3bf0a5){var _0x16fdf0=_0x582a5f;if(_0x3bf0a5['match'](/^\\d+$/))return _0x3bf0a5;var _0x3bbaed;try{_0x3bbaed=JSON[_0x16fdf0(0x151)](''+_0x3bf0a5);}catch{_0x3bbaed='\\x22'+this[_0x16fdf0(0x19c)](_0x3bf0a5)+'\\x22';}return _0x3bbaed[_0x16fdf0(0x11e)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x3bbaed=_0x3bbaed[_0x16fdf0(0xfe)](0x1,_0x3bbaed[_0x16fdf0(0x141)]-0x2):_0x3bbaed=_0x3bbaed[_0x16fdf0(0x13f)](/'/g,'\\x5c\\x27')[_0x16fdf0(0x13f)](/\\\\\"/g,'\\x22')[_0x16fdf0(0x13f)](/(^\"|\"$)/g,'\\x27'),_0x3bbaed;}[_0x582a5f(0x193)](_0x56823e,_0x285b41,_0x417adb,_0x287a6a){var _0xcc6d0d=_0x582a5f;this[_0xcc6d0d(0x180)](_0x56823e,_0x285b41),_0x287a6a&&_0x287a6a(),this[_0xcc6d0d(0xf9)](_0x417adb,_0x56823e),this[_0xcc6d0d(0x174)](_0x56823e,_0x285b41);}[_0x582a5f(0x180)](_0x4b8db4,_0x4929d2){var _0x81a071=_0x582a5f;this[_0x81a071(0x1a8)](_0x4b8db4,_0x4929d2),this['_setNodeQueryPath'](_0x4b8db4,_0x4929d2),this['_setNodeExpressionPath'](_0x4b8db4,_0x4929d2),this[_0x81a071(0x18c)](_0x4b8db4,_0x4929d2);}[_0x582a5f(0x1a8)](_0x4e467c,_0x1812d0){}[_0x582a5f(0x196)](_0x4e63c2,_0x2a62fb){}[_0x582a5f(0x182)](_0x291f16,_0x393338){}[_0x582a5f(0x13c)](_0x3fc2f2){var _0x33f1bf=_0x582a5f;return _0x3fc2f2===this[_0x33f1bf(0x1ad)];}[_0x582a5f(0x174)](_0xd15478,_0x519eae){var _0x3efd93=_0x582a5f;this[_0x3efd93(0x182)](_0xd15478,_0x519eae),this[_0x3efd93(0x10f)](_0xd15478),_0x519eae[_0x3efd93(0xfd)]&&this[_0x3efd93(0x100)](_0xd15478),this[_0x3efd93(0x184)](_0xd15478,_0x519eae),this[_0x3efd93(0x1c0)](_0xd15478,_0x519eae),this[_0x3efd93(0x1bf)](_0xd15478);}[_0x582a5f(0xf9)](_0x14dd9a,_0x3ba4b1){var _0x5c3136=_0x582a5f;try{_0x14dd9a&&typeof _0x14dd9a[_0x5c3136(0x141)]=='number'&&(_0x3ba4b1[_0x5c3136(0x141)]=_0x14dd9a[_0x5c3136(0x141)]);}catch{}if(_0x3ba4b1[_0x5c3136(0x1ae)]==='number'||_0x3ba4b1[_0x5c3136(0x1ae)]==='Number'){if(isNaN(_0x3ba4b1['value']))_0x3ba4b1['nan']=!0x0,delete _0x3ba4b1[_0x5c3136(0x1b0)];else switch(_0x3ba4b1['value']){case Number[_0x5c3136(0x17c)]:_0x3ba4b1[_0x5c3136(0x10a)]=!0x0,delete _0x3ba4b1[_0x5c3136(0x1b0)];break;case Number['NEGATIVE_INFINITY']:_0x3ba4b1[_0x5c3136(0x10e)]=!0x0,delete _0x3ba4b1[_0x5c3136(0x1b0)];break;case 0x0:this['_isNegativeZero'](_0x3ba4b1[_0x5c3136(0x1b0)])&&(_0x3ba4b1[_0x5c3136(0x12d)]=!0x0);break;}}else _0x3ba4b1[_0x5c3136(0x1ae)]==='function'&&typeof _0x14dd9a['name']==_0x5c3136(0x103)&&_0x14dd9a[_0x5c3136(0x187)]&&_0x3ba4b1['name']&&_0x14dd9a[_0x5c3136(0x187)]!==_0x3ba4b1['name']&&(_0x3ba4b1[_0x5c3136(0x18d)]=_0x14dd9a['name']);}[_0x582a5f(0x1b8)](_0x550234){return 0x1/_0x550234===Number['NEGATIVE_INFINITY'];}[_0x582a5f(0x100)](_0x3aaefa){var _0x56eb5e=_0x582a5f;!_0x3aaefa[_0x56eb5e(0x1bb)]||!_0x3aaefa[_0x56eb5e(0x1bb)][_0x56eb5e(0x141)]||_0x3aaefa[_0x56eb5e(0x1ae)]===_0x56eb5e(0x13d)||_0x3aaefa[_0x56eb5e(0x1ae)]===_0x56eb5e(0x1be)||_0x3aaefa[_0x56eb5e(0x1ae)]===_0x56eb5e(0x128)||_0x3aaefa[_0x56eb5e(0x1bb)][_0x56eb5e(0x122)](function(_0x3bbc68,_0x41cf9d){var _0x5b2df8=_0x56eb5e,_0x588b37=_0x3bbc68[_0x5b2df8(0x187)]['toLowerCase'](),_0x1902bb=_0x41cf9d[_0x5b2df8(0x187)]['toLowerCase']();return _0x588b37<_0x1902bb?-0x1:_0x588b37>_0x1902bb?0x1:0x0;});}[_0x582a5f(0x184)](_0xac1d8,_0x3f06d6){var _0x1242f6=_0x582a5f;if(!(_0x3f06d6['noFunctions']||!_0xac1d8[_0x1242f6(0x1bb)]||!_0xac1d8[_0x1242f6(0x1bb)][_0x1242f6(0x141)])){for(var _0x1d4e20=[],_0xaebb13=[],_0x3f0c7e=0x0,_0x38822e=_0xac1d8['props']['length'];_0x3f0c7e<_0x38822e;_0x3f0c7e++){var _0x54f263=_0xac1d8['props'][_0x3f0c7e];_0x54f263['type']===_0x1242f6(0xe8)?_0x1d4e20[_0x1242f6(0x16c)](_0x54f263):_0xaebb13[_0x1242f6(0x16c)](_0x54f263);}if(!(!_0xaebb13['length']||_0x1d4e20['length']<=0x1)){_0xac1d8[_0x1242f6(0x1bb)]=_0xaebb13;var _0x4db175={'functionsNode':!0x0,'props':_0x1d4e20};this['_setNodeId'](_0x4db175,_0x3f06d6),this['_setNodeLabel'](_0x4db175,_0x3f06d6),this[_0x1242f6(0x10f)](_0x4db175),this[_0x1242f6(0x18c)](_0x4db175,_0x3f06d6),_0x4db175['id']+='\\x20f',_0xac1d8['props']['unshift'](_0x4db175);}}}['_addLoadNode'](_0x38851a,_0x43e3b5){}[_0x582a5f(0x10f)](_0x2aad46){}[_0x582a5f(0x1a7)](_0x4a0693){var _0x34ddd0=_0x582a5f;return Array[_0x34ddd0(0x125)](_0x4a0693)||typeof _0x4a0693==_0x34ddd0(0x107)&&this[_0x34ddd0(0x19c)](_0x4a0693)===_0x34ddd0(0x19a);}[_0x582a5f(0x18c)](_0x4be131,_0x15732e){}[_0x582a5f(0x1bf)](_0x3d175d){var _0x407640=_0x582a5f;delete _0x3d175d['_hasSymbolPropertyOnItsPath'],delete _0x3d175d[_0x407640(0x1af)],delete _0x3d175d[_0x407640(0x15e)];}[_0x582a5f(0x11a)](_0x14c68b,_0x1ef00b){}[_0x582a5f(0x136)](_0x50967b){var _0x3e7be2=_0x582a5f;return _0x50967b?_0x50967b[_0x3e7be2(0x11e)](this[_0x3e7be2(0x11b)])?'['+_0x50967b+']':_0x50967b[_0x3e7be2(0x11e)](this[_0x3e7be2(0x1b6)])?'.'+_0x50967b:_0x50967b[_0x3e7be2(0x11e)](this[_0x3e7be2(0x19f)])?'['+_0x50967b+']':'[\\x27'+_0x50967b+'\\x27]':'';}}let _0x331db6=new _0x1ed8a8();function _0x8784b0(_0x195392,_0x1683f7,_0x50ba87,_0x523b5d,_0x2b7c8b,_0x5bb8db){var _0x2347f3=_0x582a5f;let _0x5f0c43,_0x1e9fa6;try{_0x1e9fa6=_0xb8c436(),_0x5f0c43=_0x1a495c[_0x1683f7],!_0x5f0c43||_0x1e9fa6-_0x5f0c43['ts']>0x1f4&&_0x5f0c43['count']&&_0x5f0c43['time']/_0x5f0c43[_0x2347f3(0x112)]<0x64?(_0x1a495c[_0x1683f7]=_0x5f0c43={'count':0x0,'time':0x0,'ts':_0x1e9fa6},_0x1a495c['hits']={}):_0x1e9fa6-_0x1a495c[_0x2347f3(0x106)]['ts']>0x32&&_0x1a495c['hits'][_0x2347f3(0x112)]&&_0x1a495c[_0x2347f3(0x106)][_0x2347f3(0x1c1)]/_0x1a495c['hits']['count']<0x64&&(_0x1a495c['hits']={});let _0x16e561=[],_0x128475=_0x5f0c43[_0x2347f3(0x104)]||_0x1a495c[_0x2347f3(0x106)][_0x2347f3(0x104)]?_0xc7aa2a:_0x481166,_0x2960fc=_0x3f3cff=>{var _0x268697=_0x2347f3;let _0x569e78={};return _0x569e78[_0x268697(0x1bb)]=_0x3f3cff['props'],_0x569e78[_0x268697(0xf4)]=_0x3f3cff[_0x268697(0xf4)],_0x569e78['strLength']=_0x3f3cff[_0x268697(0xed)],_0x569e78[_0x268697(0x167)]=_0x3f3cff['totalStrLength'],_0x569e78[_0x268697(0x1a0)]=_0x3f3cff[_0x268697(0x1a0)],_0x569e78[_0x268697(0x13e)]=_0x3f3cff['autoExpandMaxDepth'],_0x569e78[_0x268697(0xfd)]=!0x1,_0x569e78['noFunctions']=!_0x2932ea,_0x569e78[_0x268697(0x12b)]=0x1,_0x569e78[_0x268697(0x113)]=0x0,_0x569e78['expId']=_0x268697(0xe9),_0x569e78[_0x268697(0xfa)]=_0x268697(0x11f),_0x569e78[_0x268697(0x131)]=!0x0,_0x569e78[_0x268697(0x130)]=[],_0x569e78['autoExpandPropertyCount']=0x0,_0x569e78[_0x268697(0x1a2)]=!0x0,_0x569e78[_0x268697(0x16f)]=0x0,_0x569e78['node']={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x569e78;};for(var _0x1af2da=0x0;_0x1af2da<_0x2b7c8b[_0x2347f3(0x141)];_0x1af2da++)_0x16e561[_0x2347f3(0x16c)](_0x331db6[_0x2347f3(0x105)]({'timeNode':_0x195392==='time'||void 0x0},_0x2b7c8b[_0x1af2da],_0x2960fc(_0x128475),{}));if(_0x195392===_0x2347f3(0x134)){let _0x26dbb8=Error[_0x2347f3(0x118)];try{Error[_0x2347f3(0x118)]=0x1/0x0,_0x16e561[_0x2347f3(0x16c)](_0x331db6[_0x2347f3(0x105)]({'stackNode':!0x0},new Error()['stack'],_0x2960fc(_0x128475),{'strLength':0x1/0x0}));}finally{Error[_0x2347f3(0x118)]=_0x26dbb8;}}return{'method':_0x2347f3(0x10d),'version':_0x394eca,'args':[{'ts':_0x50ba87,'session':_0x523b5d,'args':_0x16e561,'id':_0x1683f7,'context':_0x5bb8db}]};}catch(_0x127ec8){return{'method':_0x2347f3(0x10d),'version':_0x394eca,'args':[{'ts':_0x50ba87,'session':_0x523b5d,'args':[{'type':_0x2347f3(0x18a),'error':_0x127ec8&&_0x127ec8[_0x2347f3(0x147)]}],'id':_0x1683f7,'context':_0x5bb8db}]};}finally{try{if(_0x5f0c43&&_0x1e9fa6){let _0x3a20c8=_0xb8c436();_0x5f0c43[_0x2347f3(0x112)]++,_0x5f0c43[_0x2347f3(0x1c1)]+=_0x5b7ec7(_0x1e9fa6,_0x3a20c8),_0x5f0c43['ts']=_0x3a20c8,_0x1a495c[_0x2347f3(0x106)][_0x2347f3(0x112)]++,_0x1a495c[_0x2347f3(0x106)][_0x2347f3(0x1c1)]+=_0x5b7ec7(_0x1e9fa6,_0x3a20c8),_0x1a495c['hits']['ts']=_0x3a20c8,(_0x5f0c43[_0x2347f3(0x112)]>0x32||_0x5f0c43[_0x2347f3(0x1c1)]>0x64)&&(_0x5f0c43[_0x2347f3(0x104)]=!0x0),(_0x1a495c[_0x2347f3(0x106)][_0x2347f3(0x112)]>0x3e8||_0x1a495c[_0x2347f3(0x106)]['time']>0x12c)&&(_0x1a495c[_0x2347f3(0x106)]['reduceLimits']=!0x0);}}catch{}}}return _0x5a79f4[_0x582a5f(0x14f)];})(globalThis,_0x362114(0x194),'50652',_0x362114(0x110),'webpack','1.0.0',_0x362114(0x169),_0x362114(0x1b5),'');");}catch(e){}};function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
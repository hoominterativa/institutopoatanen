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
/* istanbul ignore next *//* c8 ignore start *//* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';function _0x11da(){var _0x4f794a=['create','Error','forEach','log','data','next.js','env','performance','NEXT_RUNTIME','toString','Set','_setNodeId','_isPrimitiveWrapperType','error','[object\\x20Map]','9348588gGlyOW','_consoleNinjaAllowedToStart','bind','sortProps','disabledLog','9116856yyhZdC','valueOf','autoExpandMaxDepth','_treeNodePropertiesBeforeFullValue','_console_ninja','hostname','map','nodeModules','[object\\x20Date]','getOwnPropertySymbols','_treeNodePropertiesAfterFullValue','https://tinyurl.com/37x8b79t','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20','funcName','_hasMapOnItsPath','negativeZero','1164859Lgfzpo','concat','serialize','timeEnd','symbol','disabledTrace','stringify','_Symbol','date','_additionalMetadata','344PBLnWT','_capIfString','unknown','_sendErrorMessage','_addObjectProperty','_blacklistedProperty','_maxConnectAttemptCount','_processTreeNodeResult','method','_console_ninja_session','WebSocket','gateway.docker.internal','message','pop','call','unref','1707252119809','','send','_addLoadNode','163478YIFujb','number','replace','dockerizedApp','_numberRegExp','autoExpandPreviousObjects','props','3248930lMygyd','Buffer','cappedElements','NEGATIVE_INFINITY','type','autoExpand','__es'+'Module','_hasSymbolPropertyOnItsPath','bigint',':logPointId:','_attemptToReconnectShortly','toLowerCase','[object\\x20BigInt]','remix','get','array','_reconnectTimeout','_setNodeQueryPath','nuxt','_setNodeExpressionPath','onerror','close','12234FhDpJX','_setNodeExpandableState','warn','now','autoExpandLimit','elapsed','expressionsToEvaluate','capped','127.0.0.1','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20','test','_WebSocketClass','allStrLength','_cleanNode','Map','RegExp','hrtime','_isUndefined','\\x20browser','_socket','_p_name','reload','timeStamp','cappedProps','node','astro','HTMLAllCollection','match','process','parse','function','POSITIVE_INFINITY','...','_disposeWebsocket','substr','prototype','_isNegativeZero','undefined','552NcGmvA','_hasSetOnItsPath','strLength','_sortProps','default','_isSet','Boolean','readyState','expId','elements','_connecting','noFunctions','[object\\x20Array]','[object\\x20Set]','_isPrimitiveType','_connectToHostNow','hits','split','root_exp_id','coverage','_inBrowser','versions','name','catch','\\x20server','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','_propertyName','ws://','_isArray','isArray','_ws','push','_setNodeLabel','positiveInfinity','trace','path','console','String','global','parent','webpack','getPrototypeOf','sort','_getOwnPropertySymbols','index','_p_','object','stackTraceLimit','enumerable','isExpressionToEvaluate','_connectAttemptCount','angular','_addFunctionsNode','_HTMLAllCollection','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','_inNextEdge','level','count','defineProperty','_allowedToSend','reduceLimits','_isMap','_getOwnPropertyNames','_property','onmessage','5YVzKxt','totalStrLength','getOwnPropertyDescriptor','autoExpandPropertyCount','failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','resolveGetters','_addProperty','60167','depth','onclose','_objectToString','rootExpression','length','null','_webSocketErrorDocsLink','_dateToString','host','then','string','onopen','_allowedToConnectOnSend','current','slice','_setNodePermissions','Number','_connected','_WebSocket','time','558124WMNOZj','getWebSocketClass','port','_type','value','edge','logger\\x20websocket\\x20error','location','join'];_0x11da=function(){return _0x4f794a;};return _0x11da();}var _0x2d14a7=_0x3a68;function _0x3a68(_0x3a2785,_0xbca5ae){var _0x11dac7=_0x11da();return _0x3a68=function(_0x3a6831,_0x39b5d9){_0x3a6831=_0x3a6831-0x139;var _0x374838=_0x11dac7[_0x3a6831];return _0x374838;},_0x3a68(_0x3a2785,_0xbca5ae);}(function(_0x2d6dbc,_0x1dd6fd){var _0x5d7585=_0x3a68,_0x21d219=_0x2d6dbc();while(!![]){try{var _0x562149=parseInt(_0x5d7585(0x1f0))/0x1+parseInt(_0x5d7585(0x140))/0x2*(parseInt(_0x5d7585(0x166))/0x3)+-parseInt(_0x5d7585(0x1c3))/0x4+parseInt(_0x5d7585(0x1a7))/0x5*(-parseInt(_0x5d7585(0x1db))/0x6)+-parseInt(_0x5d7585(0x20e))/0x7*(-parseInt(_0x5d7585(0x1fa))/0x8)+-parseInt(_0x5d7585(0x1e0))/0x9+parseInt(_0x5d7585(0x215))/0xa;if(_0x562149===_0x1dd6fd)break;else _0x21d219['push'](_0x21d219['shift']());}catch(_0x12a257){_0x21d219['push'](_0x21d219['shift']());}}}(_0x11da,0xdde59));var j=Object[_0x2d14a7(0x1cc)],H=Object[_0x2d14a7(0x1a0)],G=Object['getOwnPropertyDescriptor'],ee=Object['getOwnPropertyNames'],te=Object[_0x2d14a7(0x18f)],ne=Object[_0x2d14a7(0x163)]['hasOwnProperty'],re=(_0x5ed5e2,_0x5c6001,_0x53faf3,_0x299996)=>{var _0x154499=_0x2d14a7;if(_0x5c6001&&typeof _0x5c6001==_0x154499(0x194)||typeof _0x5c6001==_0x154499(0x15e)){for(let _0x449126 of ee(_0x5c6001))!ne[_0x154499(0x208)](_0x5ed5e2,_0x449126)&&_0x449126!==_0x53faf3&&H(_0x5ed5e2,_0x449126,{'get':()=>_0x5c6001[_0x449126],'enumerable':!(_0x299996=G(_0x5c6001,_0x449126))||_0x299996[_0x154499(0x196)]});}return _0x5ed5e2;},x=(_0x2675cd,_0x4ed12c,_0x52d20e)=>(_0x52d20e=_0x2675cd!=null?j(te(_0x2675cd)):{},re(_0x4ed12c||!_0x2675cd||!_0x2675cd[_0x2d14a7(0x21b)]?H(_0x52d20e,_0x2d14a7(0x16a),{'value':_0x2675cd,'enumerable':!0x0}):_0x52d20e,_0x2675cd)),X=class{constructor(_0x4d04d1,_0x2339f5,_0x230e63,_0xfc645,_0x337001){var _0x2147f4=_0x2d14a7;this['global']=_0x4d04d1,this['host']=_0x2339f5,this[_0x2147f4(0x1c5)]=_0x230e63,this['nodeModules']=_0xfc645,this[_0x2147f4(0x211)]=_0x337001,this['_allowedToSend']=!0x0,this[_0x2147f4(0x1bb)]=!0x0,this[_0x2147f4(0x1c0)]=!0x1,this['_connecting']=!0x1,this[_0x2147f4(0x19d)]=_0x4d04d1['process']?.['env']?.['NEXT_RUNTIME']===_0x2147f4(0x1c8),this[_0x2147f4(0x17a)]=!this[_0x2147f4(0x18c)][_0x2147f4(0x15c)]?.[_0x2147f4(0x17b)]?.[_0x2147f4(0x158)]&&!this[_0x2147f4(0x19d)],this[_0x2147f4(0x14b)]=null,this[_0x2147f4(0x198)]=0x0,this[_0x2147f4(0x200)]=0x14,this[_0x2147f4(0x1b5)]=_0x2147f4(0x1eb),this[_0x2147f4(0x1fd)]=(this['_inBrowser']?'Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20':_0x2147f4(0x1ec))+this[_0x2147f4(0x1b5)];}async[_0x2d14a7(0x1c4)](){var _0x231aec=_0x2d14a7;if(this[_0x231aec(0x14b)])return this['_WebSocketClass'];let _0x5b6cdf;if(this[_0x231aec(0x17a)]||this[_0x231aec(0x19d)])_0x5b6cdf=this[_0x231aec(0x18c)][_0x231aec(0x204)];else{if(this[_0x231aec(0x18c)][_0x231aec(0x15c)]?.[_0x231aec(0x1c1)])_0x5b6cdf=this[_0x231aec(0x18c)][_0x231aec(0x15c)]?.[_0x231aec(0x1c1)];else try{let _0x1e2454=await import('path');_0x5b6cdf=(await import((await import('url'))['pathToFileURL'](_0x1e2454[_0x231aec(0x1cb)](this[_0x231aec(0x1e7)],'ws/index.js'))[_0x231aec(0x1d5)]()))[_0x231aec(0x16a)];}catch{try{_0x5b6cdf=require(require(_0x231aec(0x189))[_0x231aec(0x1cb)](this['nodeModules'],'ws'));}catch{throw new Error(_0x231aec(0x1ab));}}}return this[_0x231aec(0x14b)]=_0x5b6cdf,_0x5b6cdf;}[_0x2d14a7(0x175)](){var _0x1d2bfe=_0x2d14a7;this['_connecting']||this[_0x1d2bfe(0x1c0)]||this[_0x1d2bfe(0x198)]>=this[_0x1d2bfe(0x200)]||(this[_0x1d2bfe(0x1bb)]=!0x1,this['_connecting']=!0x0,this[_0x1d2bfe(0x198)]++,this['_ws']=new Promise((_0x3b2891,_0x4bdc5d)=>{var _0x4cd4a1=_0x1d2bfe;this[_0x4cd4a1(0x1c4)]()[_0x4cd4a1(0x1b8)](_0x47b075=>{var _0x482b47=_0x4cd4a1;let _0x3e7bfb=new _0x47b075(_0x482b47(0x181)+(!this[_0x482b47(0x17a)]&&this[_0x482b47(0x211)]?_0x482b47(0x205):this[_0x482b47(0x1b7)])+':'+this[_0x482b47(0x1c5)]);_0x3e7bfb[_0x482b47(0x13e)]=()=>{var _0x51615b=_0x482b47;this[_0x51615b(0x1a1)]=!0x1,this[_0x51615b(0x161)](_0x3e7bfb),this[_0x51615b(0x21f)](),_0x4bdc5d(new Error(_0x51615b(0x1c9)));},_0x3e7bfb[_0x482b47(0x1ba)]=()=>{var _0x5e833a=_0x482b47;this['_inBrowser']||_0x3e7bfb['_socket']&&_0x3e7bfb[_0x5e833a(0x153)][_0x5e833a(0x209)]&&_0x3e7bfb['_socket'][_0x5e833a(0x209)](),_0x3b2891(_0x3e7bfb);},_0x3e7bfb['onclose']=()=>{var _0x424ff3=_0x482b47;this[_0x424ff3(0x1bb)]=!0x0,this[_0x424ff3(0x161)](_0x3e7bfb),this[_0x424ff3(0x21f)]();},_0x3e7bfb[_0x482b47(0x1a6)]=_0x2c2dee=>{var _0x1f9b84=_0x482b47;try{_0x2c2dee&&_0x2c2dee[_0x1f9b84(0x1d0)]&&this['_inBrowser']&&JSON[_0x1f9b84(0x15d)](_0x2c2dee['data'])[_0x1f9b84(0x202)]==='reload'&&this[_0x1f9b84(0x18c)][_0x1f9b84(0x1ca)][_0x1f9b84(0x155)]();}catch{}};})['then'](_0x209f7b=>(this[_0x4cd4a1(0x1c0)]=!0x0,this[_0x4cd4a1(0x170)]=!0x1,this[_0x4cd4a1(0x1bb)]=!0x1,this['_allowedToSend']=!0x0,this['_connectAttemptCount']=0x0,_0x209f7b))[_0x4cd4a1(0x17d)](_0x174271=>(this[_0x4cd4a1(0x1c0)]=!0x1,this[_0x4cd4a1(0x170)]=!0x1,console[_0x4cd4a1(0x142)](_0x4cd4a1(0x149)+this[_0x4cd4a1(0x1b5)]),_0x4bdc5d(new Error(_0x4cd4a1(0x19c)+(_0x174271&&_0x174271[_0x4cd4a1(0x206)])))));}));}['_disposeWebsocket'](_0x2a2aa6){var _0x36040b=_0x2d14a7;this[_0x36040b(0x1c0)]=!0x1,this['_connecting']=!0x1;try{_0x2a2aa6[_0x36040b(0x1b0)]=null,_0x2a2aa6[_0x36040b(0x13e)]=null,_0x2a2aa6[_0x36040b(0x1ba)]=null;}catch{}try{_0x2a2aa6[_0x36040b(0x16d)]<0x2&&_0x2a2aa6[_0x36040b(0x13f)]();}catch{}}['_attemptToReconnectShortly'](){var _0x258be9=_0x2d14a7;clearTimeout(this[_0x258be9(0x13a)]),!(this[_0x258be9(0x198)]>=this[_0x258be9(0x200)])&&(this['_reconnectTimeout']=setTimeout(()=>{var _0x459b70=_0x258be9;this[_0x459b70(0x1c0)]||this['_connecting']||(this['_connectToHostNow'](),this[_0x459b70(0x184)]?.['catch'](()=>this[_0x459b70(0x21f)]()));},0x1f4),this[_0x258be9(0x13a)][_0x258be9(0x209)]&&this[_0x258be9(0x13a)][_0x258be9(0x209)]());}async[_0x2d14a7(0x20c)](_0x237c24){var _0x4854df=_0x2d14a7;try{if(!this[_0x4854df(0x1a1)])return;this[_0x4854df(0x1bb)]&&this[_0x4854df(0x175)](),(await this['_ws'])['send'](JSON[_0x4854df(0x1f6)](_0x237c24));}catch(_0x5cac75){console[_0x4854df(0x142)](this[_0x4854df(0x1fd)]+':\\x20'+(_0x5cac75&&_0x5cac75[_0x4854df(0x206)])),this[_0x4854df(0x1a1)]=!0x1,this[_0x4854df(0x21f)]();}}};function b(_0x24fb20,_0x4694d3,_0x1ec6e3,_0x27af02,_0x210668,_0x1117d8){var _0x1bf81b=_0x2d14a7;let _0x1c9d43=_0x1ec6e3[_0x1bf81b(0x177)](',')[_0x1bf81b(0x1e6)](_0x4bdb3c=>{var _0x3757c8=_0x1bf81b;try{_0x24fb20[_0x3757c8(0x203)]||((_0x210668===_0x3757c8(0x1d1)||_0x210668===_0x3757c8(0x222)||_0x210668===_0x3757c8(0x159)||_0x210668===_0x3757c8(0x199))&&(_0x210668+=!_0x24fb20[_0x3757c8(0x15c)]?.[_0x3757c8(0x17b)]?.[_0x3757c8(0x158)]&&_0x24fb20[_0x3757c8(0x15c)]?.['env']?.[_0x3757c8(0x1d4)]!==_0x3757c8(0x1c8)?_0x3757c8(0x152):_0x3757c8(0x17e)),_0x24fb20['_console_ninja_session']={'id':+new Date(),'tool':_0x210668});let _0x7be67=new X(_0x24fb20,_0x4694d3,_0x4bdb3c,_0x27af02,_0x1117d8);return _0x7be67[_0x3757c8(0x20c)][_0x3757c8(0x1dd)](_0x7be67);}catch(_0x4da211){return console['warn'](_0x3757c8(0x17f),_0x4da211&&_0x4da211[_0x3757c8(0x206)]),()=>{};}});return _0x2c02e9=>_0x1c9d43[_0x1bf81b(0x1ce)](_0x4204e3=>_0x4204e3(_0x2c02e9));}function W(_0x5a1b64){var _0x3abd9f=_0x2d14a7;let _0x46f407=function(_0x264edf,_0x1bc8ef){return _0x1bc8ef-_0x264edf;},_0x1d03ad;if(_0x5a1b64[_0x3abd9f(0x1d3)])_0x1d03ad=function(){var _0x5ddf90=_0x3abd9f;return _0x5a1b64[_0x5ddf90(0x1d3)][_0x5ddf90(0x143)]();};else{if(_0x5a1b64[_0x3abd9f(0x15c)]&&_0x5a1b64[_0x3abd9f(0x15c)][_0x3abd9f(0x150)]&&_0x5a1b64[_0x3abd9f(0x15c)]?.[_0x3abd9f(0x1d2)]?.[_0x3abd9f(0x1d4)]!==_0x3abd9f(0x1c8))_0x1d03ad=function(){var _0x5e6dcb=_0x3abd9f;return _0x5a1b64[_0x5e6dcb(0x15c)][_0x5e6dcb(0x150)]();},_0x46f407=function(_0x35f706,_0x109e33){return 0x3e8*(_0x109e33[0x0]-_0x35f706[0x0])+(_0x109e33[0x1]-_0x35f706[0x1])/0xf4240;};else try{let {performance:_0x5a8d6f}=require('perf_hooks');_0x1d03ad=function(){var _0x360519=_0x3abd9f;return _0x5a8d6f[_0x360519(0x143)]();};}catch{_0x1d03ad=function(){return+new Date();};}}return{'elapsed':_0x46f407,'timeStamp':_0x1d03ad,'now':()=>Date[_0x3abd9f(0x143)]()};}function J(_0x433bde,_0x349dc7,_0xd63c4a){var _0x3112a4=_0x2d14a7;if(_0x433bde[_0x3112a4(0x1dc)]!==void 0x0)return _0x433bde[_0x3112a4(0x1dc)];let _0x3ebc9a=_0x433bde[_0x3112a4(0x15c)]?.[_0x3112a4(0x17b)]?.[_0x3112a4(0x158)]||_0x433bde[_0x3112a4(0x15c)]?.[_0x3112a4(0x1d2)]?.[_0x3112a4(0x1d4)]==='edge';return _0x3ebc9a&&_0xd63c4a===_0x3112a4(0x13c)?_0x433bde[_0x3112a4(0x1dc)]=!0x1:_0x433bde[_0x3112a4(0x1dc)]=_0x3ebc9a||!_0x349dc7||_0x433bde['location']?.[_0x3112a4(0x1e5)]&&_0x349dc7['includes'](_0x433bde[_0x3112a4(0x1ca)][_0x3112a4(0x1e5)]),_0x433bde['_consoleNinjaAllowedToStart'];}function Y(_0x9ad357,_0x3d717a,_0x5e1cb6,_0x54fbb9){var _0x304e90=_0x2d14a7;_0x9ad357=_0x9ad357,_0x3d717a=_0x3d717a,_0x5e1cb6=_0x5e1cb6,_0x54fbb9=_0x54fbb9;let _0x520c58=W(_0x9ad357),_0x3eb90b=_0x520c58[_0x304e90(0x145)],_0x1729f5=_0x520c58[_0x304e90(0x156)];class _0x3ead97{constructor(){var _0xc0d9c4=_0x304e90;this['_keyStrRegExp']=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0xc0d9c4(0x212)]=/^(0|[1-9][0-9]*)$/,this['_quotedRegExp']=/'([^\\\\']|\\\\')*'/,this['_undefined']=_0x9ad357[_0xc0d9c4(0x165)],this[_0xc0d9c4(0x19b)]=_0x9ad357[_0xc0d9c4(0x15a)],this['_getOwnPropertyDescriptor']=Object[_0xc0d9c4(0x1a9)],this[_0xc0d9c4(0x1a4)]=Object['getOwnPropertyNames'],this['_Symbol']=_0x9ad357['Symbol'],this['_regExpToString']=RegExp['prototype']['toString'],this['_dateToString']=Date[_0xc0d9c4(0x163)][_0xc0d9c4(0x1d5)];}[_0x304e90(0x1f2)](_0x3dbf8f,_0x1d262d,_0x3a230f,_0x18926d){var _0x5c60ed=_0x304e90,_0x4dd1bb=this,_0x40bb93=_0x3a230f[_0x5c60ed(0x21a)];function _0x522769(_0x3dccd3,_0x2ecc68,_0xdefc9){var _0x41a213=_0x5c60ed;_0x2ecc68[_0x41a213(0x219)]=_0x41a213(0x1fc),_0x2ecc68[_0x41a213(0x1d9)]=_0x3dccd3[_0x41a213(0x206)],_0x48f542=_0xdefc9[_0x41a213(0x158)][_0x41a213(0x1bc)],_0xdefc9['node'][_0x41a213(0x1bc)]=_0x2ecc68,_0x4dd1bb[_0x41a213(0x1e3)](_0x2ecc68,_0xdefc9);}try{_0x3a230f[_0x5c60ed(0x19e)]++,_0x3a230f[_0x5c60ed(0x21a)]&&_0x3a230f[_0x5c60ed(0x213)]['push'](_0x1d262d);var _0x3cbe82,_0x5c40b5,_0x5e6bd3,_0x507e14,_0x38b3d6=[],_0x23430e=[],_0x3ee3bc,_0x7cdd3b=this[_0x5c60ed(0x1c6)](_0x1d262d),_0x13d23d=_0x7cdd3b===_0x5c60ed(0x139),_0x109efb=!0x1,_0x38ae3b=_0x7cdd3b===_0x5c60ed(0x15e),_0x4a54c5=this[_0x5c60ed(0x174)](_0x7cdd3b),_0x16a345=this[_0x5c60ed(0x1d8)](_0x7cdd3b),_0x1c7443=_0x4a54c5||_0x16a345,_0x3e46c6={},_0x1eef65=0x0,_0x441b8e=!0x1,_0x48f542,_0xc15546=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x3a230f[_0x5c60ed(0x1af)]){if(_0x13d23d){if(_0x5c40b5=_0x1d262d[_0x5c60ed(0x1b3)],_0x5c40b5>_0x3a230f[_0x5c60ed(0x16f)]){for(_0x5e6bd3=0x0,_0x507e14=_0x3a230f[_0x5c60ed(0x16f)],_0x3cbe82=_0x5e6bd3;_0x3cbe82<_0x507e14;_0x3cbe82++)_0x23430e[_0x5c60ed(0x185)](_0x4dd1bb[_0x5c60ed(0x1ad)](_0x38b3d6,_0x1d262d,_0x7cdd3b,_0x3cbe82,_0x3a230f));_0x3dbf8f[_0x5c60ed(0x217)]=!0x0;}else{for(_0x5e6bd3=0x0,_0x507e14=_0x5c40b5,_0x3cbe82=_0x5e6bd3;_0x3cbe82<_0x507e14;_0x3cbe82++)_0x23430e[_0x5c60ed(0x185)](_0x4dd1bb[_0x5c60ed(0x1ad)](_0x38b3d6,_0x1d262d,_0x7cdd3b,_0x3cbe82,_0x3a230f));}_0x3a230f['autoExpandPropertyCount']+=_0x23430e['length'];}if(!(_0x7cdd3b===_0x5c60ed(0x1b4)||_0x7cdd3b===_0x5c60ed(0x165))&&!_0x4a54c5&&_0x7cdd3b!==_0x5c60ed(0x18b)&&_0x7cdd3b!==_0x5c60ed(0x216)&&_0x7cdd3b!==_0x5c60ed(0x21d)){var _0x1e7dbe=_0x18926d[_0x5c60ed(0x214)]||_0x3a230f[_0x5c60ed(0x214)];if(this[_0x5c60ed(0x16b)](_0x1d262d)?(_0x3cbe82=0x0,_0x1d262d[_0x5c60ed(0x1ce)](function(_0x228d63){var _0x386714=_0x5c60ed;if(_0x1eef65++,_0x3a230f['autoExpandPropertyCount']++,_0x1eef65>_0x1e7dbe){_0x441b8e=!0x0;return;}if(!_0x3a230f[_0x386714(0x197)]&&_0x3a230f[_0x386714(0x21a)]&&_0x3a230f[_0x386714(0x1aa)]>_0x3a230f[_0x386714(0x144)]){_0x441b8e=!0x0;return;}_0x23430e[_0x386714(0x185)](_0x4dd1bb[_0x386714(0x1ad)](_0x38b3d6,_0x1d262d,_0x386714(0x1d6),_0x3cbe82++,_0x3a230f,function(_0x25ad5c){return function(){return _0x25ad5c;};}(_0x228d63)));})):this[_0x5c60ed(0x1a3)](_0x1d262d)&&_0x1d262d[_0x5c60ed(0x1ce)](function(_0x3909d7,_0x191c4a){var _0x442a4f=_0x5c60ed;if(_0x1eef65++,_0x3a230f[_0x442a4f(0x1aa)]++,_0x1eef65>_0x1e7dbe){_0x441b8e=!0x0;return;}if(!_0x3a230f[_0x442a4f(0x197)]&&_0x3a230f[_0x442a4f(0x21a)]&&_0x3a230f[_0x442a4f(0x1aa)]>_0x3a230f['autoExpandLimit']){_0x441b8e=!0x0;return;}var _0x35abc3=_0x191c4a['toString']();_0x35abc3[_0x442a4f(0x1b3)]>0x64&&(_0x35abc3=_0x35abc3[_0x442a4f(0x1bd)](0x0,0x64)+_0x442a4f(0x160)),_0x23430e[_0x442a4f(0x185)](_0x4dd1bb[_0x442a4f(0x1ad)](_0x38b3d6,_0x1d262d,_0x442a4f(0x14e),_0x35abc3,_0x3a230f,function(_0x576243){return function(){return _0x576243;};}(_0x3909d7)));}),!_0x109efb){try{for(_0x3ee3bc in _0x1d262d)if(!(_0x13d23d&&_0xc15546['test'](_0x3ee3bc))&&!this['_blacklistedProperty'](_0x1d262d,_0x3ee3bc,_0x3a230f)){if(_0x1eef65++,_0x3a230f[_0x5c60ed(0x1aa)]++,_0x1eef65>_0x1e7dbe){_0x441b8e=!0x0;break;}if(!_0x3a230f[_0x5c60ed(0x197)]&&_0x3a230f['autoExpand']&&_0x3a230f['autoExpandPropertyCount']>_0x3a230f[_0x5c60ed(0x144)]){_0x441b8e=!0x0;break;}_0x23430e[_0x5c60ed(0x185)](_0x4dd1bb[_0x5c60ed(0x1fe)](_0x38b3d6,_0x3e46c6,_0x1d262d,_0x7cdd3b,_0x3ee3bc,_0x3a230f));}}catch{}if(_0x3e46c6['_p_length']=!0x0,_0x38ae3b&&(_0x3e46c6[_0x5c60ed(0x154)]=!0x0),!_0x441b8e){var _0x5450b6=[][_0x5c60ed(0x1f1)](this[_0x5c60ed(0x1a4)](_0x1d262d))[_0x5c60ed(0x1f1)](this[_0x5c60ed(0x191)](_0x1d262d));for(_0x3cbe82=0x0,_0x5c40b5=_0x5450b6[_0x5c60ed(0x1b3)];_0x3cbe82<_0x5c40b5;_0x3cbe82++)if(_0x3ee3bc=_0x5450b6[_0x3cbe82],!(_0x13d23d&&_0xc15546[_0x5c60ed(0x14a)](_0x3ee3bc[_0x5c60ed(0x1d5)]()))&&!this['_blacklistedProperty'](_0x1d262d,_0x3ee3bc,_0x3a230f)&&!_0x3e46c6['_p_'+_0x3ee3bc['toString']()]){if(_0x1eef65++,_0x3a230f['autoExpandPropertyCount']++,_0x1eef65>_0x1e7dbe){_0x441b8e=!0x0;break;}if(!_0x3a230f[_0x5c60ed(0x197)]&&_0x3a230f[_0x5c60ed(0x21a)]&&_0x3a230f[_0x5c60ed(0x1aa)]>_0x3a230f[_0x5c60ed(0x144)]){_0x441b8e=!0x0;break;}_0x23430e[_0x5c60ed(0x185)](_0x4dd1bb[_0x5c60ed(0x1fe)](_0x38b3d6,_0x3e46c6,_0x1d262d,_0x7cdd3b,_0x3ee3bc,_0x3a230f));}}}}}if(_0x3dbf8f[_0x5c60ed(0x219)]=_0x7cdd3b,_0x1c7443?(_0x3dbf8f[_0x5c60ed(0x1c7)]=_0x1d262d[_0x5c60ed(0x1e1)](),this[_0x5c60ed(0x1fb)](_0x7cdd3b,_0x3dbf8f,_0x3a230f,_0x18926d)):_0x7cdd3b===_0x5c60ed(0x1f8)?_0x3dbf8f[_0x5c60ed(0x1c7)]=this[_0x5c60ed(0x1b6)][_0x5c60ed(0x208)](_0x1d262d):_0x7cdd3b===_0x5c60ed(0x21d)?_0x3dbf8f[_0x5c60ed(0x1c7)]=_0x1d262d[_0x5c60ed(0x1d5)]():_0x7cdd3b===_0x5c60ed(0x14f)?_0x3dbf8f['value']=this['_regExpToString']['call'](_0x1d262d):_0x7cdd3b===_0x5c60ed(0x1f4)&&this['_Symbol']?_0x3dbf8f['value']=this[_0x5c60ed(0x1f7)]['prototype']['toString'][_0x5c60ed(0x208)](_0x1d262d):!_0x3a230f[_0x5c60ed(0x1af)]&&!(_0x7cdd3b==='null'||_0x7cdd3b===_0x5c60ed(0x165))&&(delete _0x3dbf8f[_0x5c60ed(0x1c7)],_0x3dbf8f[_0x5c60ed(0x147)]=!0x0),_0x441b8e&&(_0x3dbf8f[_0x5c60ed(0x157)]=!0x0),_0x48f542=_0x3a230f[_0x5c60ed(0x158)]['current'],_0x3a230f[_0x5c60ed(0x158)][_0x5c60ed(0x1bc)]=_0x3dbf8f,this[_0x5c60ed(0x1e3)](_0x3dbf8f,_0x3a230f),_0x23430e[_0x5c60ed(0x1b3)]){for(_0x3cbe82=0x0,_0x5c40b5=_0x23430e[_0x5c60ed(0x1b3)];_0x3cbe82<_0x5c40b5;_0x3cbe82++)_0x23430e[_0x3cbe82](_0x3cbe82);}_0x38b3d6[_0x5c60ed(0x1b3)]&&(_0x3dbf8f[_0x5c60ed(0x214)]=_0x38b3d6);}catch(_0x112b59){_0x522769(_0x112b59,_0x3dbf8f,_0x3a230f);}return this[_0x5c60ed(0x1f9)](_0x1d262d,_0x3dbf8f),this[_0x5c60ed(0x1ea)](_0x3dbf8f,_0x3a230f),_0x3a230f['node'][_0x5c60ed(0x1bc)]=_0x48f542,_0x3a230f['level']--,_0x3a230f[_0x5c60ed(0x21a)]=_0x40bb93,_0x3a230f[_0x5c60ed(0x21a)]&&_0x3a230f['autoExpandPreviousObjects'][_0x5c60ed(0x207)](),_0x3dbf8f;}['_getOwnPropertySymbols'](_0x35cc43){var _0x358f5a=_0x304e90;return Object[_0x358f5a(0x1e9)]?Object[_0x358f5a(0x1e9)](_0x35cc43):[];}['_isSet'](_0x1a3080){var _0x56be3d=_0x304e90;return!!(_0x1a3080&&_0x9ad357['Set']&&this[_0x56be3d(0x1b1)](_0x1a3080)===_0x56be3d(0x173)&&_0x1a3080[_0x56be3d(0x1ce)]);}[_0x304e90(0x1ff)](_0x136e77,_0x1791cd,_0x2d1d78){var _0x4d6870=_0x304e90;return _0x2d1d78[_0x4d6870(0x171)]?typeof _0x136e77[_0x1791cd]==_0x4d6870(0x15e):!0x1;}[_0x304e90(0x1c6)](_0x2a8345){var _0x2d7fa3=_0x304e90,_0x2a8401='';return _0x2a8401=typeof _0x2a8345,_0x2a8401==='object'?this[_0x2d7fa3(0x1b1)](_0x2a8345)==='[object\\x20Array]'?_0x2a8401=_0x2d7fa3(0x139):this['_objectToString'](_0x2a8345)===_0x2d7fa3(0x1e8)?_0x2a8401=_0x2d7fa3(0x1f8):this[_0x2d7fa3(0x1b1)](_0x2a8345)===_0x2d7fa3(0x221)?_0x2a8401=_0x2d7fa3(0x21d):_0x2a8345===null?_0x2a8401=_0x2d7fa3(0x1b4):_0x2a8345['constructor']&&(_0x2a8401=_0x2a8345['constructor'][_0x2d7fa3(0x17c)]||_0x2a8401):_0x2a8401===_0x2d7fa3(0x165)&&this[_0x2d7fa3(0x19b)]&&_0x2a8345 instanceof this[_0x2d7fa3(0x19b)]&&(_0x2a8401=_0x2d7fa3(0x15a)),_0x2a8401;}[_0x304e90(0x1b1)](_0x280f56){var _0x1ca50d=_0x304e90;return Object[_0x1ca50d(0x163)][_0x1ca50d(0x1d5)][_0x1ca50d(0x208)](_0x280f56);}[_0x304e90(0x174)](_0xf25c1){var _0x2bedef=_0x304e90;return _0xf25c1==='boolean'||_0xf25c1==='string'||_0xf25c1===_0x2bedef(0x20f);}[_0x304e90(0x1d8)](_0x32e84a){var _0x5b4cff=_0x304e90;return _0x32e84a===_0x5b4cff(0x16c)||_0x32e84a===_0x5b4cff(0x18b)||_0x32e84a==='Number';}[_0x304e90(0x1ad)](_0x35aa7a,_0x14560a,_0x4f633c,_0x5b5b8c,_0x4734d8,_0x1059bc){var _0x59f652=this;return function(_0x224e7c){var _0x45b5d9=_0x3a68,_0x1c1e7b=_0x4734d8[_0x45b5d9(0x158)][_0x45b5d9(0x1bc)],_0x3ec1c2=_0x4734d8[_0x45b5d9(0x158)][_0x45b5d9(0x192)],_0x13ed10=_0x4734d8['node'][_0x45b5d9(0x18d)];_0x4734d8['node'][_0x45b5d9(0x18d)]=_0x1c1e7b,_0x4734d8[_0x45b5d9(0x158)]['index']=typeof _0x5b5b8c==_0x45b5d9(0x20f)?_0x5b5b8c:_0x224e7c,_0x35aa7a[_0x45b5d9(0x185)](_0x59f652[_0x45b5d9(0x1a5)](_0x14560a,_0x4f633c,_0x5b5b8c,_0x4734d8,_0x1059bc)),_0x4734d8['node'][_0x45b5d9(0x18d)]=_0x13ed10,_0x4734d8[_0x45b5d9(0x158)]['index']=_0x3ec1c2;};}['_addObjectProperty'](_0x3be435,_0x584582,_0x4c42c3,_0x2b1f40,_0x44cc27,_0x4c5127,_0x47bd2d){var _0x5429ba=_0x304e90,_0xb26aea=this;return _0x584582[_0x5429ba(0x193)+_0x44cc27[_0x5429ba(0x1d5)]()]=!0x0,function(_0x3bad20){var _0x1a5c6e=_0x5429ba,_0x4aaa7a=_0x4c5127[_0x1a5c6e(0x158)][_0x1a5c6e(0x1bc)],_0xd55a6=_0x4c5127[_0x1a5c6e(0x158)][_0x1a5c6e(0x192)],_0x59a7b8=_0x4c5127['node']['parent'];_0x4c5127[_0x1a5c6e(0x158)][_0x1a5c6e(0x18d)]=_0x4aaa7a,_0x4c5127[_0x1a5c6e(0x158)][_0x1a5c6e(0x192)]=_0x3bad20,_0x3be435['push'](_0xb26aea[_0x1a5c6e(0x1a5)](_0x4c42c3,_0x2b1f40,_0x44cc27,_0x4c5127,_0x47bd2d)),_0x4c5127[_0x1a5c6e(0x158)]['parent']=_0x59a7b8,_0x4c5127[_0x1a5c6e(0x158)]['index']=_0xd55a6;};}[_0x304e90(0x1a5)](_0x351480,_0x31c25b,_0x2a9ba1,_0x99a8ad,_0x83cccb){var _0x23cfff=_0x304e90,_0x251de1=this;_0x83cccb||(_0x83cccb=function(_0x56d3f7,_0x151630){return _0x56d3f7[_0x151630];});var _0x47884e=_0x2a9ba1[_0x23cfff(0x1d5)](),_0x17feed=_0x99a8ad[_0x23cfff(0x146)]||{},_0x38d1e3=_0x99a8ad[_0x23cfff(0x1af)],_0x3ee2ee=_0x99a8ad[_0x23cfff(0x197)];try{var _0x514081=this['_isMap'](_0x351480),_0x384d89=_0x47884e;_0x514081&&_0x384d89[0x0]==='\\x27'&&(_0x384d89=_0x384d89[_0x23cfff(0x162)](0x1,_0x384d89[_0x23cfff(0x1b3)]-0x2));var _0x3f170a=_0x99a8ad[_0x23cfff(0x146)]=_0x17feed[_0x23cfff(0x193)+_0x384d89];_0x3f170a&&(_0x99a8ad[_0x23cfff(0x1af)]=_0x99a8ad['depth']+0x1),_0x99a8ad[_0x23cfff(0x197)]=!!_0x3f170a;var _0x741e72=typeof _0x2a9ba1==_0x23cfff(0x1f4),_0x4c85ec={'name':_0x741e72||_0x514081?_0x47884e:this[_0x23cfff(0x180)](_0x47884e)};if(_0x741e72&&(_0x4c85ec[_0x23cfff(0x1f4)]=!0x0),!(_0x31c25b===_0x23cfff(0x139)||_0x31c25b===_0x23cfff(0x1cd))){var _0x14c182=this['_getOwnPropertyDescriptor'](_0x351480,_0x2a9ba1);if(_0x14c182&&(_0x14c182['set']&&(_0x4c85ec['setter']=!0x0),_0x14c182[_0x23cfff(0x223)]&&!_0x3f170a&&!_0x99a8ad[_0x23cfff(0x1ac)]))return _0x4c85ec['getter']=!0x0,this[_0x23cfff(0x201)](_0x4c85ec,_0x99a8ad),_0x4c85ec;}var _0x3c99b7;try{_0x3c99b7=_0x83cccb(_0x351480,_0x2a9ba1);}catch(_0x3a4ee6){return _0x4c85ec={'name':_0x47884e,'type':_0x23cfff(0x1fc),'error':_0x3a4ee6['message']},this[_0x23cfff(0x201)](_0x4c85ec,_0x99a8ad),_0x4c85ec;}var _0x22bae3=this['_type'](_0x3c99b7),_0x386f24=this[_0x23cfff(0x174)](_0x22bae3);if(_0x4c85ec['type']=_0x22bae3,_0x386f24)this[_0x23cfff(0x201)](_0x4c85ec,_0x99a8ad,_0x3c99b7,function(){var _0x3c646e=_0x23cfff;_0x4c85ec[_0x3c646e(0x1c7)]=_0x3c99b7['valueOf'](),!_0x3f170a&&_0x251de1[_0x3c646e(0x1fb)](_0x22bae3,_0x4c85ec,_0x99a8ad,{});});else{var _0x1e3514=_0x99a8ad[_0x23cfff(0x21a)]&&_0x99a8ad[_0x23cfff(0x19e)]<_0x99a8ad[_0x23cfff(0x1e2)]&&_0x99a8ad['autoExpandPreviousObjects']['indexOf'](_0x3c99b7)<0x0&&_0x22bae3!==_0x23cfff(0x15e)&&_0x99a8ad[_0x23cfff(0x1aa)]<_0x99a8ad[_0x23cfff(0x144)];_0x1e3514||_0x99a8ad[_0x23cfff(0x19e)]<_0x38d1e3||_0x3f170a?(this[_0x23cfff(0x1f2)](_0x4c85ec,_0x3c99b7,_0x99a8ad,_0x3f170a||{}),this['_additionalMetadata'](_0x3c99b7,_0x4c85ec)):this[_0x23cfff(0x201)](_0x4c85ec,_0x99a8ad,_0x3c99b7,function(){var _0x5c369c=_0x23cfff;_0x22bae3===_0x5c369c(0x1b4)||_0x22bae3===_0x5c369c(0x165)||(delete _0x4c85ec[_0x5c369c(0x1c7)],_0x4c85ec[_0x5c369c(0x147)]=!0x0);});}return _0x4c85ec;}finally{_0x99a8ad[_0x23cfff(0x146)]=_0x17feed,_0x99a8ad[_0x23cfff(0x1af)]=_0x38d1e3,_0x99a8ad[_0x23cfff(0x197)]=_0x3ee2ee;}}['_capIfString'](_0x1bec91,_0x41ac1b,_0x3a9fb9,_0x4a0544){var _0x100101=_0x304e90,_0x58d68d=_0x4a0544[_0x100101(0x168)]||_0x3a9fb9[_0x100101(0x168)];if((_0x1bec91==='string'||_0x1bec91==='String')&&_0x41ac1b[_0x100101(0x1c7)]){let _0x7716e5=_0x41ac1b[_0x100101(0x1c7)][_0x100101(0x1b3)];_0x3a9fb9['allStrLength']+=_0x7716e5,_0x3a9fb9[_0x100101(0x14c)]>_0x3a9fb9[_0x100101(0x1a8)]?(_0x41ac1b[_0x100101(0x147)]='',delete _0x41ac1b[_0x100101(0x1c7)]):_0x7716e5>_0x58d68d&&(_0x41ac1b[_0x100101(0x147)]=_0x41ac1b[_0x100101(0x1c7)][_0x100101(0x162)](0x0,_0x58d68d),delete _0x41ac1b[_0x100101(0x1c7)]);}}[_0x304e90(0x1a3)](_0x17b7ed){var _0x398779=_0x304e90;return!!(_0x17b7ed&&_0x9ad357[_0x398779(0x14e)]&&this[_0x398779(0x1b1)](_0x17b7ed)===_0x398779(0x1da)&&_0x17b7ed['forEach']);}[_0x304e90(0x180)](_0x45a08d){var _0x55d9c4=_0x304e90;if(_0x45a08d[_0x55d9c4(0x15b)](/^\\d+$/))return _0x45a08d;var _0x718acb;try{_0x718acb=JSON['stringify'](''+_0x45a08d);}catch{_0x718acb='\\x22'+this[_0x55d9c4(0x1b1)](_0x45a08d)+'\\x22';}return _0x718acb[_0x55d9c4(0x15b)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x718acb=_0x718acb[_0x55d9c4(0x162)](0x1,_0x718acb[_0x55d9c4(0x1b3)]-0x2):_0x718acb=_0x718acb[_0x55d9c4(0x210)](/'/g,'\\x5c\\x27')['replace'](/\\\\\"/g,'\\x22')['replace'](/(^\"|\"$)/g,'\\x27'),_0x718acb;}[_0x304e90(0x201)](_0x361967,_0x147672,_0x1958e1,_0x1e2fcd){var _0x17df1f=_0x304e90;this[_0x17df1f(0x1e3)](_0x361967,_0x147672),_0x1e2fcd&&_0x1e2fcd(),this[_0x17df1f(0x1f9)](_0x1958e1,_0x361967),this[_0x17df1f(0x1ea)](_0x361967,_0x147672);}[_0x304e90(0x1e3)](_0x51a7ac,_0x4cefd0){var _0x49f455=_0x304e90;this[_0x49f455(0x1d7)](_0x51a7ac,_0x4cefd0),this[_0x49f455(0x13b)](_0x51a7ac,_0x4cefd0),this[_0x49f455(0x13d)](_0x51a7ac,_0x4cefd0),this[_0x49f455(0x1be)](_0x51a7ac,_0x4cefd0);}[_0x304e90(0x1d7)](_0xbf34d4,_0x377140){}[_0x304e90(0x13b)](_0x5a354a,_0xcbb882){}[_0x304e90(0x186)](_0x2a3a20,_0x1d7a2a){}[_0x304e90(0x151)](_0x3c8eee){return _0x3c8eee===this['_undefined'];}[_0x304e90(0x1ea)](_0x1cce4e,_0x3d18ba){var _0xe9446c=_0x304e90;this[_0xe9446c(0x186)](_0x1cce4e,_0x3d18ba),this[_0xe9446c(0x141)](_0x1cce4e),_0x3d18ba[_0xe9446c(0x1de)]&&this['_sortProps'](_0x1cce4e),this[_0xe9446c(0x19a)](_0x1cce4e,_0x3d18ba),this[_0xe9446c(0x20d)](_0x1cce4e,_0x3d18ba),this[_0xe9446c(0x14d)](_0x1cce4e);}['_additionalMetadata'](_0x5edd3b,_0x4fdec5){var _0x1387f6=_0x304e90;let _0x208cdd;try{_0x9ad357[_0x1387f6(0x18a)]&&(_0x208cdd=_0x9ad357[_0x1387f6(0x18a)][_0x1387f6(0x1d9)],_0x9ad357['console'][_0x1387f6(0x1d9)]=function(){}),_0x5edd3b&&typeof _0x5edd3b['length']==_0x1387f6(0x20f)&&(_0x4fdec5[_0x1387f6(0x1b3)]=_0x5edd3b[_0x1387f6(0x1b3)]);}catch{}finally{_0x208cdd&&(_0x9ad357[_0x1387f6(0x18a)][_0x1387f6(0x1d9)]=_0x208cdd);}if(_0x4fdec5['type']===_0x1387f6(0x20f)||_0x4fdec5[_0x1387f6(0x219)]===_0x1387f6(0x1bf)){if(isNaN(_0x4fdec5['value']))_0x4fdec5['nan']=!0x0,delete _0x4fdec5[_0x1387f6(0x1c7)];else switch(_0x4fdec5[_0x1387f6(0x1c7)]){case Number[_0x1387f6(0x15f)]:_0x4fdec5[_0x1387f6(0x187)]=!0x0,delete _0x4fdec5['value'];break;case Number[_0x1387f6(0x218)]:_0x4fdec5['negativeInfinity']=!0x0,delete _0x4fdec5[_0x1387f6(0x1c7)];break;case 0x0:this[_0x1387f6(0x164)](_0x4fdec5['value'])&&(_0x4fdec5[_0x1387f6(0x1ef)]=!0x0);break;}}else _0x4fdec5[_0x1387f6(0x219)]===_0x1387f6(0x15e)&&typeof _0x5edd3b['name']==_0x1387f6(0x1b9)&&_0x5edd3b[_0x1387f6(0x17c)]&&_0x4fdec5[_0x1387f6(0x17c)]&&_0x5edd3b[_0x1387f6(0x17c)]!==_0x4fdec5[_0x1387f6(0x17c)]&&(_0x4fdec5[_0x1387f6(0x1ed)]=_0x5edd3b[_0x1387f6(0x17c)]);}[_0x304e90(0x164)](_0x27fc2f){var _0x130438=_0x304e90;return 0x1/_0x27fc2f===Number[_0x130438(0x218)];}[_0x304e90(0x169)](_0x2c1248){var _0x450466=_0x304e90;!_0x2c1248[_0x450466(0x214)]||!_0x2c1248[_0x450466(0x214)]['length']||_0x2c1248['type']===_0x450466(0x139)||_0x2c1248[_0x450466(0x219)]==='Map'||_0x2c1248[_0x450466(0x219)]==='Set'||_0x2c1248['props'][_0x450466(0x190)](function(_0x1d6d71,_0x1ac367){var _0x95338e=_0x450466,_0x190c4a=_0x1d6d71['name'][_0x95338e(0x220)](),_0x3a407e=_0x1ac367['name'][_0x95338e(0x220)]();return _0x190c4a<_0x3a407e?-0x1:_0x190c4a>_0x3a407e?0x1:0x0;});}[_0x304e90(0x19a)](_0x55e8b8,_0x5ec8eb){var _0x301c60=_0x304e90;if(!(_0x5ec8eb[_0x301c60(0x171)]||!_0x55e8b8[_0x301c60(0x214)]||!_0x55e8b8[_0x301c60(0x214)][_0x301c60(0x1b3)])){for(var _0x419543=[],_0x26244=[],_0x19bcd7=0x0,_0x5a191f=_0x55e8b8[_0x301c60(0x214)][_0x301c60(0x1b3)];_0x19bcd7<_0x5a191f;_0x19bcd7++){var _0x29fd22=_0x55e8b8['props'][_0x19bcd7];_0x29fd22[_0x301c60(0x219)]===_0x301c60(0x15e)?_0x419543['push'](_0x29fd22):_0x26244[_0x301c60(0x185)](_0x29fd22);}if(!(!_0x26244[_0x301c60(0x1b3)]||_0x419543[_0x301c60(0x1b3)]<=0x1)){_0x55e8b8[_0x301c60(0x214)]=_0x26244;var _0x461511={'functionsNode':!0x0,'props':_0x419543};this[_0x301c60(0x1d7)](_0x461511,_0x5ec8eb),this[_0x301c60(0x186)](_0x461511,_0x5ec8eb),this[_0x301c60(0x141)](_0x461511),this[_0x301c60(0x1be)](_0x461511,_0x5ec8eb),_0x461511['id']+='\\x20f',_0x55e8b8[_0x301c60(0x214)]['unshift'](_0x461511);}}}[_0x304e90(0x20d)](_0x475262,_0x309c08){}['_setNodeExpandableState'](_0x1ad24d){}[_0x304e90(0x182)](_0x4841c1){var _0x5918bf=_0x304e90;return Array[_0x5918bf(0x183)](_0x4841c1)||typeof _0x4841c1==_0x5918bf(0x194)&&this[_0x5918bf(0x1b1)](_0x4841c1)===_0x5918bf(0x172);}[_0x304e90(0x1be)](_0x3bb74f,_0x462ed5){}['_cleanNode'](_0x35024c){var _0x251629=_0x304e90;delete _0x35024c[_0x251629(0x21c)],delete _0x35024c[_0x251629(0x167)],delete _0x35024c[_0x251629(0x1ee)];}['_setNodeExpressionPath'](_0x53ebc3,_0x187494){}}let _0x1d9175=new _0x3ead97(),_0x15097c={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x2a9927={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2};function _0x455e61(_0x53021b,_0x28c969,_0x59ffd0,_0x5dd239,_0x5d1f9f,_0x582c85){var _0x36d120=_0x304e90;let _0x53738a,_0x4b6ccb;try{_0x4b6ccb=_0x1729f5(),_0x53738a=_0x5e1cb6[_0x28c969],!_0x53738a||_0x4b6ccb-_0x53738a['ts']>0x1f4&&_0x53738a[_0x36d120(0x19f)]&&_0x53738a['time']/_0x53738a[_0x36d120(0x19f)]<0x64?(_0x5e1cb6[_0x28c969]=_0x53738a={'count':0x0,'time':0x0,'ts':_0x4b6ccb},_0x5e1cb6[_0x36d120(0x176)]={}):_0x4b6ccb-_0x5e1cb6['hits']['ts']>0x32&&_0x5e1cb6[_0x36d120(0x176)][_0x36d120(0x19f)]&&_0x5e1cb6[_0x36d120(0x176)][_0x36d120(0x1c2)]/_0x5e1cb6[_0x36d120(0x176)][_0x36d120(0x19f)]<0x64&&(_0x5e1cb6[_0x36d120(0x176)]={});let _0x480165=[],_0x4a5a23=_0x53738a[_0x36d120(0x1a2)]||_0x5e1cb6[_0x36d120(0x176)][_0x36d120(0x1a2)]?_0x2a9927:_0x15097c,_0x3f582c=_0x1714a9=>{var _0x558730=_0x36d120;let _0x16c969={};return _0x16c969[_0x558730(0x214)]=_0x1714a9[_0x558730(0x214)],_0x16c969[_0x558730(0x16f)]=_0x1714a9[_0x558730(0x16f)],_0x16c969['strLength']=_0x1714a9[_0x558730(0x168)],_0x16c969[_0x558730(0x1a8)]=_0x1714a9['totalStrLength'],_0x16c969[_0x558730(0x144)]=_0x1714a9[_0x558730(0x144)],_0x16c969['autoExpandMaxDepth']=_0x1714a9[_0x558730(0x1e2)],_0x16c969[_0x558730(0x1de)]=!0x1,_0x16c969['noFunctions']=!_0x3d717a,_0x16c969[_0x558730(0x1af)]=0x1,_0x16c969[_0x558730(0x19e)]=0x0,_0x16c969[_0x558730(0x16e)]=_0x558730(0x178),_0x16c969[_0x558730(0x1b2)]='root_exp',_0x16c969[_0x558730(0x21a)]=!0x0,_0x16c969[_0x558730(0x213)]=[],_0x16c969[_0x558730(0x1aa)]=0x0,_0x16c969[_0x558730(0x1ac)]=!0x0,_0x16c969['allStrLength']=0x0,_0x16c969[_0x558730(0x158)]={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x16c969;};for(var _0x1c2677=0x0;_0x1c2677<_0x5d1f9f[_0x36d120(0x1b3)];_0x1c2677++)_0x480165[_0x36d120(0x185)](_0x1d9175[_0x36d120(0x1f2)]({'timeNode':_0x53021b===_0x36d120(0x1c2)||void 0x0},_0x5d1f9f[_0x1c2677],_0x3f582c(_0x4a5a23),{}));if(_0x53021b===_0x36d120(0x188)){let _0x346c0f=Error[_0x36d120(0x195)];try{Error[_0x36d120(0x195)]=0x1/0x0,_0x480165['push'](_0x1d9175[_0x36d120(0x1f2)]({'stackNode':!0x0},new Error()['stack'],_0x3f582c(_0x4a5a23),{'strLength':0x1/0x0}));}finally{Error[_0x36d120(0x195)]=_0x346c0f;}}return{'method':_0x36d120(0x1cf),'version':_0x54fbb9,'args':[{'ts':_0x59ffd0,'session':_0x5dd239,'args':_0x480165,'id':_0x28c969,'context':_0x582c85}]};}catch(_0x413d56){return{'method':_0x36d120(0x1cf),'version':_0x54fbb9,'args':[{'ts':_0x59ffd0,'session':_0x5dd239,'args':[{'type':_0x36d120(0x1fc),'error':_0x413d56&&_0x413d56[_0x36d120(0x206)]}],'id':_0x28c969,'context':_0x582c85}]};}finally{try{if(_0x53738a&&_0x4b6ccb){let _0x3c4f85=_0x1729f5();_0x53738a[_0x36d120(0x19f)]++,_0x53738a[_0x36d120(0x1c2)]+=_0x3eb90b(_0x4b6ccb,_0x3c4f85),_0x53738a['ts']=_0x3c4f85,_0x5e1cb6[_0x36d120(0x176)][_0x36d120(0x19f)]++,_0x5e1cb6[_0x36d120(0x176)][_0x36d120(0x1c2)]+=_0x3eb90b(_0x4b6ccb,_0x3c4f85),_0x5e1cb6['hits']['ts']=_0x3c4f85,(_0x53738a[_0x36d120(0x19f)]>0x32||_0x53738a[_0x36d120(0x1c2)]>0x64)&&(_0x53738a[_0x36d120(0x1a2)]=!0x0),(_0x5e1cb6['hits'][_0x36d120(0x19f)]>0x3e8||_0x5e1cb6[_0x36d120(0x176)][_0x36d120(0x1c2)]>0x12c)&&(_0x5e1cb6[_0x36d120(0x176)][_0x36d120(0x1a2)]=!0x0);}}catch{}}}return _0x455e61;}((_0x181d45,_0x357087,_0x4d3224,_0x58b50a,_0x5023c3,_0x1ba227,_0xc6a986,_0x2abd1e,_0x2d078a,_0x1f13c8)=>{var _0x5b1661=_0x2d14a7;if(_0x181d45[_0x5b1661(0x1e4)])return _0x181d45[_0x5b1661(0x1e4)];if(!J(_0x181d45,_0x2abd1e,_0x5023c3))return _0x181d45[_0x5b1661(0x1e4)]={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'coverage':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x181d45['_console_ninja'];let _0x3e0191=W(_0x181d45),_0x5b8323=_0x3e0191['elapsed'],_0x5140e5=_0x3e0191[_0x5b1661(0x156)],_0x24d7c6=_0x3e0191['now'],_0x7b0146={'hits':{},'ts':{}},_0x221396=Y(_0x181d45,_0x2d078a,_0x7b0146,_0x1ba227),_0x338f26=_0x51ac38=>{_0x7b0146['ts'][_0x51ac38]=_0x5140e5();},_0xd2cdfc=(_0x167781,_0x11f8e1)=>{var _0x38d032=_0x5b1661;let _0x30d058=_0x7b0146['ts'][_0x11f8e1];if(delete _0x7b0146['ts'][_0x11f8e1],_0x30d058){let _0x45d555=_0x5b8323(_0x30d058,_0x5140e5());_0x5037e5(_0x221396(_0x38d032(0x1c2),_0x167781,_0x24d7c6(),_0x5d6e6f,[_0x45d555],_0x11f8e1));}},_0x361275=_0x57bec7=>_0x2d5366=>{var _0x1b0b85=_0x5b1661;try{_0x338f26(_0x2d5366),_0x57bec7(_0x2d5366);}finally{_0x181d45[_0x1b0b85(0x18a)][_0x1b0b85(0x1c2)]=_0x57bec7;}},_0x585ba1=_0x24a0eb=>_0x144275=>{var _0x32fa52=_0x5b1661;try{let [_0x11cf23,_0x538abb]=_0x144275['split'](_0x32fa52(0x21e));_0xd2cdfc(_0x538abb,_0x11cf23),_0x24a0eb(_0x11cf23);}finally{_0x181d45[_0x32fa52(0x18a)][_0x32fa52(0x1f3)]=_0x24a0eb;}};_0x181d45[_0x5b1661(0x1e4)]={'consoleLog':(_0x3e3af1,_0x159f7b)=>{var _0x1c3fff=_0x5b1661;_0x181d45['console'][_0x1c3fff(0x1cf)][_0x1c3fff(0x17c)]!==_0x1c3fff(0x1df)&&_0x5037e5(_0x221396(_0x1c3fff(0x1cf),_0x3e3af1,_0x24d7c6(),_0x5d6e6f,_0x159f7b));},'consoleTrace':(_0x218c30,_0x5b6e65)=>{var _0x36a7c2=_0x5b1661;_0x181d45['console']['log'][_0x36a7c2(0x17c)]!==_0x36a7c2(0x1f5)&&_0x5037e5(_0x221396(_0x36a7c2(0x188),_0x218c30,_0x24d7c6(),_0x5d6e6f,_0x5b6e65));},'consoleTime':()=>{var _0x10af2d=_0x5b1661;_0x181d45[_0x10af2d(0x18a)][_0x10af2d(0x1c2)]=_0x361275(_0x181d45[_0x10af2d(0x18a)]['time']);},'consoleTimeEnd':()=>{var _0x5cf9dc=_0x5b1661;_0x181d45[_0x5cf9dc(0x18a)]['timeEnd']=_0x585ba1(_0x181d45['console'][_0x5cf9dc(0x1f3)]);},'autoLog':(_0x2abc70,_0x1f5cf4)=>{var _0x2011d2=_0x5b1661;_0x5037e5(_0x221396(_0x2011d2(0x1cf),_0x1f5cf4,_0x24d7c6(),_0x5d6e6f,[_0x2abc70]));},'autoLogMany':(_0x3d35f5,_0x55485a)=>{var _0x5f21e5=_0x5b1661;_0x5037e5(_0x221396(_0x5f21e5(0x1cf),_0x3d35f5,_0x24d7c6(),_0x5d6e6f,_0x55485a));},'autoTrace':(_0x38240e,_0x15a4fa)=>{var _0x155793=_0x5b1661;_0x5037e5(_0x221396(_0x155793(0x188),_0x15a4fa,_0x24d7c6(),_0x5d6e6f,[_0x38240e]));},'autoTraceMany':(_0x360908,_0x1fad65)=>{var _0x51358b=_0x5b1661;_0x5037e5(_0x221396(_0x51358b(0x188),_0x360908,_0x24d7c6(),_0x5d6e6f,_0x1fad65));},'autoTime':(_0x21f452,_0x3e7343,_0x5cf347)=>{_0x338f26(_0x5cf347);},'autoTimeEnd':(_0x13a82d,_0xc9b1d1,_0x43ed90)=>{_0xd2cdfc(_0xc9b1d1,_0x43ed90);},'coverage':_0xaca707=>{var _0x5095e3=_0x5b1661;_0x5037e5({'method':_0x5095e3(0x179),'version':_0x1ba227,'args':[{'id':_0xaca707}]});}};let _0x5037e5=b(_0x181d45,_0x357087,_0x4d3224,_0x58b50a,_0x5023c3,_0x1f13c8),_0x5d6e6f=_0x181d45['_console_ninja_session'];return _0x181d45[_0x5b1661(0x1e4)];})(globalThis,_0x2d14a7(0x148),_0x2d14a7(0x1ae),\"c:\\\\Users\\\\benvi\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-1.0.284\\\\node_modules\",_0x2d14a7(0x18e),'1.0.0',_0x2d14a7(0x20a),[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"DESKTOP-GDLJ9TC\",\"192.168.1.4\",\"127.0.2.2\",\"127.0.2.3\"],_0x2d14a7(0x20b),'');");}catch(e){}};/* istanbul ignore next */function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};/* istanbul ignore next */function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint unicorn/no-abusive-eslint-disable:,eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
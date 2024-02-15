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
/* istanbul ignore next *//* c8 ignore start *//* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x12c47f=_0x341f;(function(_0x3a64c1,_0x2796b6){var _0x4248c5=_0x341f,_0x515740=_0x3a64c1();while(!![]){try{var _0x3e8e6d=-parseInt(_0x4248c5(0x1ba))/0x1*(parseInt(_0x4248c5(0x1d9))/0x2)+-parseInt(_0x4248c5(0x219))/0x3+parseInt(_0x4248c5(0x17e))/0x4+-parseInt(_0x4248c5(0x1db))/0x5+-parseInt(_0x4248c5(0x16f))/0x6*(-parseInt(_0x4248c5(0x220))/0x7)+parseInt(_0x4248c5(0x199))/0x8*(parseInt(_0x4248c5(0x22a))/0x9)+parseInt(_0x4248c5(0x216))/0xa;if(_0x3e8e6d===_0x2796b6)break;else _0x515740['push'](_0x515740['shift']());}catch(_0x41611e){_0x515740['push'](_0x515740['shift']());}}}(_0x4b66,0x9b0b7));function _0x4b66(){var _0x9cf38b=['strLength','_setNodeId','autoExpandPreviousObjects','_isMap','totalStrLength','node','_maxConnectAttemptCount','_hasMapOnItsPath','array','WebSocket','timeEnd','process','constructor','catch','String','dockerizedApp','error','\\x20browser','1558002JvClgk','trace','enumerable','_Symbol','logger\\x20websocket\\x20error','autoExpand','null','call','function','elements','_numberRegExp','onopen','disabledLog','_webSocketErrorDocsLink','[object\\x20BigInt]','3174748aoSBqZ','location','Error','message','_addLoadNode','_isUndefined','stringify','set','_capIfString','now','failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','versions','nodeModules','disabledTrace','getWebSocketClass','elapsed','readyState','NEXT_RUNTIME','object','expId','_propertyName','_consoleNinjaAllowedToStart','setter',\"c:\\\\Users\\\\William Hoom\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-1.0.285\\\\node_modules\",'pop','_inBrowser','onmessage','8yhNMuy','1.0.0','bind','isArray','unknown','_treeNodePropertiesBeforeFullValue','_setNodeQueryPath','host','onerror','getPrototypeOf','split','_isPrimitiveType','isExpressionToEvaluate','_inNextEdge','log','[object\\x20Array]','funcName','Map','port','create','1707933795978','number','index','unref','includes','_isArray','capped','sortProps','_allowedToSend','_p_','stackTraceLimit','depth','astro','31WvNDTT','[object\\x20Map]','_p_length','stack','','push','Boolean','cappedProps','hits','_console_ninja_session','string','_setNodeExpandableState','then','parent','_isPrimitiveWrapperType','_console_ninja','serialize','_hasSymbolPropertyOnItsPath','_type','_setNodeExpressionPath','length','_isNegativeZero','_connected','undefined','parse','_getOwnPropertyNames','join','next.js','_WebSocketClass','autoExpandLimit','_dateToString','56814UBthwj','reload','415010KkcbEq','symbol','_getOwnPropertyDescriptor','prototype','_additionalMetadata','_connectAttemptCount','webpack','autoExpandMaxDepth','_property','onclose','autoExpandPropertyCount','_p_name','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20','_cleanNode','_addProperty','_objectToString','_regExpToString','level','reduceLimits','_addObjectProperty','env','console','unshift','Number','value','negativeZero','_undefined','allStrLength','substr','','gateway.docker.internal','Set','_addFunctionsNode','toString','Buffer','warn','_WebSocket','send','_processTreeNodeResult','type','time',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"HidekiWatanabe\",\"26.122.76.151\",\"192.168.1.104\"],'[object\\x20Date]','current','_setNodePermissions','name','positiveInfinity','_disposeWebsocket','_blacklistedProperty','POSITIVE_INFINITY','forEach','127.0.0.1','remix','_getOwnPropertySymbols','expressionsToEvaluate','rootExpression','perf_hooks','hasOwnProperty','edge','11516520vyxnNA','nan','hrtime','2844600HivaiU','timeStamp','path','...','angular','52100','test','7uFnCCs','props','RegExp','date','_connectToHostNow','_attemptToReconnectShortly','https://tinyurl.com/37x8b79t','global','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','3076884nmiGNe','sort','resolveGetters','_ws','noFunctions','boolean','data','_socket','slice','default','_sortProps','_connecting','concat','toLowerCase','_isSet','performance','getOwnPropertySymbols',':logPointId:','count','_allowedToConnectOnSend','getter','cappedElements','getOwnPropertyDescriptor','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20','hostname','_sendErrorMessage','_reconnectTimeout','NEGATIVE_INFINITY','_setNodeLabel','bigint','_quotedRegExp','[object\\x20Set]','url','\\x20server','getOwnPropertyNames','get'];_0x4b66=function(){return _0x9cf38b;};return _0x4b66();}var j=Object[_0x12c47f(0x1ac)],H=Object['defineProperty'],G=Object['getOwnPropertyDescriptor'],ee=Object[_0x12c47f(0x24c)],te=Object[_0x12c47f(0x1a2)],ne=Object[_0x12c47f(0x1de)][_0x12c47f(0x214)],re=(_0x5ccae2,_0x33dabb,_0x497022,_0x180ac7)=>{var _0x2c1e03=_0x12c47f;if(_0x33dabb&&typeof _0x33dabb==_0x2c1e03(0x190)||typeof _0x33dabb==_0x2c1e03(0x177)){for(let _0x4211a5 of ee(_0x33dabb))!ne[_0x2c1e03(0x176)](_0x5ccae2,_0x4211a5)&&_0x4211a5!==_0x497022&&H(_0x5ccae2,_0x4211a5,{'get':()=>_0x33dabb[_0x4211a5],'enumerable':!(_0x180ac7=G(_0x33dabb,_0x4211a5))||_0x180ac7[_0x2c1e03(0x171)]});}return _0x5ccae2;},x=(_0xa05a30,_0x29d4ad,_0x2a98bf)=>(_0x2a98bf=_0xa05a30!=null?j(te(_0xa05a30)):{},re(_0x29d4ad||!_0xa05a30||!_0xa05a30['__es'+'Module']?H(_0x2a98bf,_0x12c47f(0x233),{'value':_0xa05a30,'enumerable':!0x0}):_0x2a98bf,_0xa05a30)),X=class{constructor(_0x28a2d9,_0x2647f3,_0x3e3fd3,_0xe1e069,_0x3817f1){var _0x7b8e53=_0x12c47f;this['global']=_0x28a2d9,this['host']=_0x2647f3,this[_0x7b8e53(0x1ab)]=_0x3e3fd3,this[_0x7b8e53(0x18a)]=_0xe1e069,this[_0x7b8e53(0x16c)]=_0x3817f1,this[_0x7b8e53(0x1b5)]=!0x0,this[_0x7b8e53(0x23d)]=!0x0,this['_connected']=!0x1,this['_connecting']=!0x1,this[_0x7b8e53(0x1a6)]=_0x28a2d9['process']?.[_0x7b8e53(0x1ef)]?.['NEXT_RUNTIME']===_0x7b8e53(0x215),this[_0x7b8e53(0x197)]=!this['global'][_0x7b8e53(0x168)]?.['versions']?.[_0x7b8e53(0x162)]&&!this['_inNextEdge'],this[_0x7b8e53(0x1d6)]=null,this[_0x7b8e53(0x1e0)]=0x0,this[_0x7b8e53(0x163)]=0x14,this[_0x7b8e53(0x17c)]=_0x7b8e53(0x226),this[_0x7b8e53(0x243)]=(this[_0x7b8e53(0x197)]?_0x7b8e53(0x241):_0x7b8e53(0x1e7))+this[_0x7b8e53(0x17c)];}async[_0x12c47f(0x18c)](){var _0x4cadba=_0x12c47f;if(this[_0x4cadba(0x1d6)])return this['_WebSocketClass'];let _0x5abb6d;if(this[_0x4cadba(0x197)]||this[_0x4cadba(0x1a6)])_0x5abb6d=this[_0x4cadba(0x227)][_0x4cadba(0x166)];else{if(this[_0x4cadba(0x227)]['process']?.[_0x4cadba(0x1ff)])_0x5abb6d=this['global'][_0x4cadba(0x168)]?.[_0x4cadba(0x1ff)];else try{let _0x2f8195=await import(_0x4cadba(0x21b));_0x5abb6d=(await import((await import(_0x4cadba(0x24a)))['pathToFileURL'](_0x2f8195['join'](this[_0x4cadba(0x18a)],'ws/index.js'))['toString']()))[_0x4cadba(0x233)];}catch{try{_0x5abb6d=require(require(_0x4cadba(0x21b))[_0x4cadba(0x1d4)](this[_0x4cadba(0x18a)],'ws'));}catch{throw new Error(_0x4cadba(0x188));}}}return this[_0x4cadba(0x1d6)]=_0x5abb6d,_0x5abb6d;}[_0x12c47f(0x224)](){var _0x21ad7d=_0x12c47f;this['_connecting']||this['_connected']||this[_0x21ad7d(0x1e0)]>=this[_0x21ad7d(0x163)]||(this['_allowedToConnectOnSend']=!0x1,this['_connecting']=!0x0,this[_0x21ad7d(0x1e0)]++,this[_0x21ad7d(0x22d)]=new Promise((_0x823a16,_0x3a3860)=>{var _0x3aa4e7=_0x21ad7d;this[_0x3aa4e7(0x18c)]()[_0x3aa4e7(0x1c6)](_0x4d422c=>{var _0xb7e2dd=_0x3aa4e7;let _0x44cbd3=new _0x4d422c('ws://'+(!this[_0xb7e2dd(0x197)]&&this[_0xb7e2dd(0x16c)]?_0xb7e2dd(0x1f9):this[_0xb7e2dd(0x1a0)])+':'+this[_0xb7e2dd(0x1ab)]);_0x44cbd3['onerror']=()=>{var _0x235006=_0xb7e2dd;this[_0x235006(0x1b5)]=!0x1,this[_0x235006(0x20a)](_0x44cbd3),this['_attemptToReconnectShortly'](),_0x3a3860(new Error(_0x235006(0x173)));},_0x44cbd3['onopen']=()=>{var _0x1bd03c=_0xb7e2dd;this[_0x1bd03c(0x197)]||_0x44cbd3[_0x1bd03c(0x231)]&&_0x44cbd3[_0x1bd03c(0x231)][_0x1bd03c(0x1b0)]&&_0x44cbd3[_0x1bd03c(0x231)][_0x1bd03c(0x1b0)](),_0x823a16(_0x44cbd3);},_0x44cbd3['onclose']=()=>{var _0x5b55c8=_0xb7e2dd;this['_allowedToConnectOnSend']=!0x0,this['_disposeWebsocket'](_0x44cbd3),this[_0x5b55c8(0x225)]();},_0x44cbd3[_0xb7e2dd(0x198)]=_0x437b20=>{var _0x25dead=_0xb7e2dd;try{_0x437b20&&_0x437b20[_0x25dead(0x230)]&&this[_0x25dead(0x197)]&&JSON[_0x25dead(0x1d2)](_0x437b20[_0x25dead(0x230)])['method']===_0x25dead(0x1da)&&this[_0x25dead(0x227)][_0x25dead(0x17f)][_0x25dead(0x1da)]();}catch{}};})[_0x3aa4e7(0x1c6)](_0x47a542=>(this[_0x3aa4e7(0x1d0)]=!0x0,this[_0x3aa4e7(0x235)]=!0x1,this[_0x3aa4e7(0x23d)]=!0x1,this['_allowedToSend']=!0x0,this[_0x3aa4e7(0x1e0)]=0x0,_0x47a542))[_0x3aa4e7(0x16a)](_0x2b2034=>(this['_connected']=!0x1,this['_connecting']=!0x1,console[_0x3aa4e7(0x1fe)](_0x3aa4e7(0x228)+this[_0x3aa4e7(0x17c)]),_0x3a3860(new Error(_0x3aa4e7(0x229)+(_0x2b2034&&_0x2b2034[_0x3aa4e7(0x181)])))));}));}[_0x12c47f(0x20a)](_0xbc6464){var _0x3ad943=_0x12c47f;this[_0x3ad943(0x1d0)]=!0x1,this[_0x3ad943(0x235)]=!0x1;try{_0xbc6464[_0x3ad943(0x1e4)]=null,_0xbc6464[_0x3ad943(0x1a1)]=null,_0xbc6464[_0x3ad943(0x17a)]=null;}catch{}try{_0xbc6464[_0x3ad943(0x18e)]<0x2&&_0xbc6464['close']();}catch{}}[_0x12c47f(0x225)](){var _0x12cd49=_0x12c47f;clearTimeout(this[_0x12cd49(0x244)]),!(this['_connectAttemptCount']>=this[_0x12cd49(0x163)])&&(this['_reconnectTimeout']=setTimeout(()=>{var _0x588246=_0x12cd49;this[_0x588246(0x1d0)]||this['_connecting']||(this[_0x588246(0x224)](),this[_0x588246(0x22d)]?.['catch'](()=>this[_0x588246(0x225)]()));},0x1f4),this[_0x12cd49(0x244)][_0x12cd49(0x1b0)]&&this[_0x12cd49(0x244)]['unref']());}async[_0x12c47f(0x200)](_0x34ebe4){var _0x18d749=_0x12c47f;try{if(!this[_0x18d749(0x1b5)])return;this[_0x18d749(0x23d)]&&this['_connectToHostNow'](),(await this[_0x18d749(0x22d)])['send'](JSON[_0x18d749(0x184)](_0x34ebe4));}catch(_0x5ab0fc){console[_0x18d749(0x1fe)](this['_sendErrorMessage']+':\\x20'+(_0x5ab0fc&&_0x5ab0fc[_0x18d749(0x181)])),this[_0x18d749(0x1b5)]=!0x1,this[_0x18d749(0x225)]();}}};function b(_0x16cfcc,_0x484b75,_0xb420ec,_0x51b7ad,_0x1fd050,_0x4ee1f9){var _0x578164=_0x12c47f;let _0x2dfffa=_0xb420ec[_0x578164(0x1a3)](',')['map'](_0x143e55=>{var _0x20d9d7=_0x578164;try{_0x16cfcc[_0x20d9d7(0x1c3)]||((_0x1fd050===_0x20d9d7(0x1d5)||_0x1fd050===_0x20d9d7(0x20f)||_0x1fd050===_0x20d9d7(0x1b9)||_0x1fd050===_0x20d9d7(0x21d))&&(_0x1fd050+=!_0x16cfcc[_0x20d9d7(0x168)]?.[_0x20d9d7(0x189)]?.[_0x20d9d7(0x162)]&&_0x16cfcc['process']?.[_0x20d9d7(0x1ef)]?.[_0x20d9d7(0x18f)]!==_0x20d9d7(0x215)?_0x20d9d7(0x16e):_0x20d9d7(0x24b)),_0x16cfcc[_0x20d9d7(0x1c3)]={'id':+new Date(),'tool':_0x1fd050});let _0x571ffb=new X(_0x16cfcc,_0x484b75,_0x143e55,_0x51b7ad,_0x4ee1f9);return _0x571ffb[_0x20d9d7(0x200)][_0x20d9d7(0x19b)](_0x571ffb);}catch(_0x31ba95){return console[_0x20d9d7(0x1fe)]('logger\\x20failed\\x20to\\x20connect\\x20to\\x20host',_0x31ba95&&_0x31ba95[_0x20d9d7(0x181)]),()=>{};}});return _0x5d733b=>_0x2dfffa[_0x578164(0x20d)](_0x5e84b4=>_0x5e84b4(_0x5d733b));}function W(_0x15621a){var _0x111d9=_0x12c47f;let _0x503751=function(_0x4f6b6e,_0x44baf8){return _0x44baf8-_0x4f6b6e;},_0x103972;if(_0x15621a['performance'])_0x103972=function(){var _0x5b7c3d=_0x341f;return _0x15621a[_0x5b7c3d(0x239)][_0x5b7c3d(0x187)]();};else{if(_0x15621a['process']&&_0x15621a['process']['hrtime']&&_0x15621a[_0x111d9(0x168)]?.['env']?.[_0x111d9(0x18f)]!==_0x111d9(0x215))_0x103972=function(){var _0x40c619=_0x111d9;return _0x15621a[_0x40c619(0x168)][_0x40c619(0x218)]();},_0x503751=function(_0x19b88c,_0x174ce6){return 0x3e8*(_0x174ce6[0x0]-_0x19b88c[0x0])+(_0x174ce6[0x1]-_0x19b88c[0x1])/0xf4240;};else try{let {performance:_0x35e6dd}=require(_0x111d9(0x213));_0x103972=function(){return _0x35e6dd['now']();};}catch{_0x103972=function(){return+new Date();};}}return{'elapsed':_0x503751,'timeStamp':_0x103972,'now':()=>Date['now']()};}function J(_0x2a1a5c,_0x3104db,_0x233151){var _0xde5036=_0x12c47f;if(_0x2a1a5c['_consoleNinjaAllowedToStart']!==void 0x0)return _0x2a1a5c['_consoleNinjaAllowedToStart'];let _0xb3e7a2=_0x2a1a5c[_0xde5036(0x168)]?.[_0xde5036(0x189)]?.[_0xde5036(0x162)]||_0x2a1a5c['process']?.[_0xde5036(0x1ef)]?.['NEXT_RUNTIME']===_0xde5036(0x215);return _0xb3e7a2&&_0x233151==='nuxt'?_0x2a1a5c[_0xde5036(0x193)]=!0x1:_0x2a1a5c[_0xde5036(0x193)]=_0xb3e7a2||!_0x3104db||_0x2a1a5c[_0xde5036(0x17f)]?.[_0xde5036(0x242)]&&_0x3104db[_0xde5036(0x1b1)](_0x2a1a5c['location'][_0xde5036(0x242)]),_0x2a1a5c[_0xde5036(0x193)];}function Y(_0x2d02e6,_0x3ac908,_0xe3ec79,_0xc6c657){var _0x1c22b8=_0x12c47f;_0x2d02e6=_0x2d02e6,_0x3ac908=_0x3ac908,_0xe3ec79=_0xe3ec79,_0xc6c657=_0xc6c657;let _0x397d58=W(_0x2d02e6),_0xeea918=_0x397d58[_0x1c22b8(0x18d)],_0x1b05b2=_0x397d58[_0x1c22b8(0x21a)];class _0x3c254e{constructor(){var _0x43a4e7=_0x1c22b8;this['_keyStrRegExp']=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0x43a4e7(0x179)]=/^(0|[1-9][0-9]*)$/,this[_0x43a4e7(0x248)]=/'([^\\\\']|\\\\')*'/,this[_0x43a4e7(0x1f5)]=_0x2d02e6[_0x43a4e7(0x1d1)],this['_HTMLAllCollection']=_0x2d02e6['HTMLAllCollection'],this[_0x43a4e7(0x1dd)]=Object[_0x43a4e7(0x240)],this[_0x43a4e7(0x1d3)]=Object[_0x43a4e7(0x24c)],this['_Symbol']=_0x2d02e6['Symbol'],this['_regExpToString']=RegExp[_0x43a4e7(0x1de)][_0x43a4e7(0x1fc)],this[_0x43a4e7(0x1d8)]=Date[_0x43a4e7(0x1de)][_0x43a4e7(0x1fc)];}['serialize'](_0x47251c,_0x48c524,_0x42dbb1,_0x5ee62d){var _0x396d0f=_0x1c22b8,_0x4a455d=this,_0x2b3c2a=_0x42dbb1[_0x396d0f(0x174)];function _0x329cf7(_0xf00d3c,_0x163298,_0x17eb9e){var _0x3a2a65=_0x396d0f;_0x163298[_0x3a2a65(0x202)]=_0x3a2a65(0x19d),_0x163298['error']=_0xf00d3c[_0x3a2a65(0x181)],_0x3c5117=_0x17eb9e[_0x3a2a65(0x162)][_0x3a2a65(0x206)],_0x17eb9e[_0x3a2a65(0x162)][_0x3a2a65(0x206)]=_0x163298,_0x4a455d[_0x3a2a65(0x19e)](_0x163298,_0x17eb9e);}try{_0x42dbb1[_0x396d0f(0x1ec)]++,_0x42dbb1[_0x396d0f(0x174)]&&_0x42dbb1['autoExpandPreviousObjects']['push'](_0x48c524);var _0x258082,_0xf4127,_0x5ce2af,_0x261f39,_0x11d8c9=[],_0x364dc7=[],_0x2314cf,_0xe705ce=this[_0x396d0f(0x1cc)](_0x48c524),_0x460077=_0xe705ce===_0x396d0f(0x165),_0x5c7b2b=!0x1,_0x390cbd=_0xe705ce===_0x396d0f(0x177),_0x1f269b=this['_isPrimitiveType'](_0xe705ce),_0x2e13d2=this[_0x396d0f(0x1c8)](_0xe705ce),_0xa3a055=_0x1f269b||_0x2e13d2,_0x4a55ac={},_0x50404e=0x0,_0xa31672=!0x1,_0x3c5117,_0x2b54a4=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x42dbb1[_0x396d0f(0x1b8)]){if(_0x460077){if(_0xf4127=_0x48c524[_0x396d0f(0x1ce)],_0xf4127>_0x42dbb1['elements']){for(_0x5ce2af=0x0,_0x261f39=_0x42dbb1['elements'],_0x258082=_0x5ce2af;_0x258082<_0x261f39;_0x258082++)_0x364dc7[_0x396d0f(0x1bf)](_0x4a455d['_addProperty'](_0x11d8c9,_0x48c524,_0xe705ce,_0x258082,_0x42dbb1));_0x47251c[_0x396d0f(0x23f)]=!0x0;}else{for(_0x5ce2af=0x0,_0x261f39=_0xf4127,_0x258082=_0x5ce2af;_0x258082<_0x261f39;_0x258082++)_0x364dc7[_0x396d0f(0x1bf)](_0x4a455d['_addProperty'](_0x11d8c9,_0x48c524,_0xe705ce,_0x258082,_0x42dbb1));}_0x42dbb1['autoExpandPropertyCount']+=_0x364dc7['length'];}if(!(_0xe705ce===_0x396d0f(0x175)||_0xe705ce==='undefined')&&!_0x1f269b&&_0xe705ce!==_0x396d0f(0x16b)&&_0xe705ce!==_0x396d0f(0x1fd)&&_0xe705ce!=='bigint'){var _0x7dc11f=_0x5ee62d[_0x396d0f(0x221)]||_0x42dbb1[_0x396d0f(0x221)];if(this['_isSet'](_0x48c524)?(_0x258082=0x0,_0x48c524[_0x396d0f(0x20d)](function(_0xe8506a){var _0x287f3a=_0x396d0f;if(_0x50404e++,_0x42dbb1[_0x287f3a(0x1e5)]++,_0x50404e>_0x7dc11f){_0xa31672=!0x0;return;}if(!_0x42dbb1[_0x287f3a(0x1a5)]&&_0x42dbb1[_0x287f3a(0x174)]&&_0x42dbb1[_0x287f3a(0x1e5)]>_0x42dbb1['autoExpandLimit']){_0xa31672=!0x0;return;}_0x364dc7['push'](_0x4a455d[_0x287f3a(0x1e9)](_0x11d8c9,_0x48c524,_0x287f3a(0x1fa),_0x258082++,_0x42dbb1,function(_0x556cb0){return function(){return _0x556cb0;};}(_0xe8506a)));})):this[_0x396d0f(0x160)](_0x48c524)&&_0x48c524[_0x396d0f(0x20d)](function(_0x327361,_0x2d6c5f){var _0x3e3dd1=_0x396d0f;if(_0x50404e++,_0x42dbb1[_0x3e3dd1(0x1e5)]++,_0x50404e>_0x7dc11f){_0xa31672=!0x0;return;}if(!_0x42dbb1['isExpressionToEvaluate']&&_0x42dbb1[_0x3e3dd1(0x174)]&&_0x42dbb1[_0x3e3dd1(0x1e5)]>_0x42dbb1['autoExpandLimit']){_0xa31672=!0x0;return;}var _0x11d6b5=_0x2d6c5f[_0x3e3dd1(0x1fc)]();_0x11d6b5[_0x3e3dd1(0x1ce)]>0x64&&(_0x11d6b5=_0x11d6b5[_0x3e3dd1(0x232)](0x0,0x64)+_0x3e3dd1(0x21c)),_0x364dc7[_0x3e3dd1(0x1bf)](_0x4a455d['_addProperty'](_0x11d8c9,_0x48c524,_0x3e3dd1(0x1aa),_0x11d6b5,_0x42dbb1,function(_0x23378b){return function(){return _0x23378b;};}(_0x327361)));}),!_0x5c7b2b){try{for(_0x2314cf in _0x48c524)if(!(_0x460077&&_0x2b54a4['test'](_0x2314cf))&&!this[_0x396d0f(0x20b)](_0x48c524,_0x2314cf,_0x42dbb1)){if(_0x50404e++,_0x42dbb1[_0x396d0f(0x1e5)]++,_0x50404e>_0x7dc11f){_0xa31672=!0x0;break;}if(!_0x42dbb1[_0x396d0f(0x1a5)]&&_0x42dbb1[_0x396d0f(0x174)]&&_0x42dbb1[_0x396d0f(0x1e5)]>_0x42dbb1[_0x396d0f(0x1d7)]){_0xa31672=!0x0;break;}_0x364dc7[_0x396d0f(0x1bf)](_0x4a455d[_0x396d0f(0x1ee)](_0x11d8c9,_0x4a55ac,_0x48c524,_0xe705ce,_0x2314cf,_0x42dbb1));}}catch{}if(_0x4a55ac[_0x396d0f(0x1bc)]=!0x0,_0x390cbd&&(_0x4a55ac[_0x396d0f(0x1e6)]=!0x0),!_0xa31672){var _0x4b5f06=[][_0x396d0f(0x236)](this[_0x396d0f(0x1d3)](_0x48c524))[_0x396d0f(0x236)](this[_0x396d0f(0x210)](_0x48c524));for(_0x258082=0x0,_0xf4127=_0x4b5f06['length'];_0x258082<_0xf4127;_0x258082++)if(_0x2314cf=_0x4b5f06[_0x258082],!(_0x460077&&_0x2b54a4[_0x396d0f(0x21f)](_0x2314cf[_0x396d0f(0x1fc)]()))&&!this[_0x396d0f(0x20b)](_0x48c524,_0x2314cf,_0x42dbb1)&&!_0x4a55ac[_0x396d0f(0x1b6)+_0x2314cf[_0x396d0f(0x1fc)]()]){if(_0x50404e++,_0x42dbb1[_0x396d0f(0x1e5)]++,_0x50404e>_0x7dc11f){_0xa31672=!0x0;break;}if(!_0x42dbb1['isExpressionToEvaluate']&&_0x42dbb1[_0x396d0f(0x174)]&&_0x42dbb1[_0x396d0f(0x1e5)]>_0x42dbb1[_0x396d0f(0x1d7)]){_0xa31672=!0x0;break;}_0x364dc7['push'](_0x4a455d['_addObjectProperty'](_0x11d8c9,_0x4a55ac,_0x48c524,_0xe705ce,_0x2314cf,_0x42dbb1));}}}}}if(_0x47251c[_0x396d0f(0x202)]=_0xe705ce,_0xa3a055?(_0x47251c['value']=_0x48c524['valueOf'](),this[_0x396d0f(0x186)](_0xe705ce,_0x47251c,_0x42dbb1,_0x5ee62d)):_0xe705ce===_0x396d0f(0x223)?_0x47251c[_0x396d0f(0x1f3)]=this[_0x396d0f(0x1d8)][_0x396d0f(0x176)](_0x48c524):_0xe705ce===_0x396d0f(0x247)?_0x47251c[_0x396d0f(0x1f3)]=_0x48c524[_0x396d0f(0x1fc)]():_0xe705ce===_0x396d0f(0x222)?_0x47251c[_0x396d0f(0x1f3)]=this[_0x396d0f(0x1eb)][_0x396d0f(0x176)](_0x48c524):_0xe705ce===_0x396d0f(0x1dc)&&this[_0x396d0f(0x172)]?_0x47251c[_0x396d0f(0x1f3)]=this[_0x396d0f(0x172)]['prototype']['toString']['call'](_0x48c524):!_0x42dbb1['depth']&&!(_0xe705ce==='null'||_0xe705ce===_0x396d0f(0x1d1))&&(delete _0x47251c['value'],_0x47251c['capped']=!0x0),_0xa31672&&(_0x47251c[_0x396d0f(0x1c1)]=!0x0),_0x3c5117=_0x42dbb1[_0x396d0f(0x162)][_0x396d0f(0x206)],_0x42dbb1[_0x396d0f(0x162)]['current']=_0x47251c,this[_0x396d0f(0x19e)](_0x47251c,_0x42dbb1),_0x364dc7[_0x396d0f(0x1ce)]){for(_0x258082=0x0,_0xf4127=_0x364dc7[_0x396d0f(0x1ce)];_0x258082<_0xf4127;_0x258082++)_0x364dc7[_0x258082](_0x258082);}_0x11d8c9['length']&&(_0x47251c[_0x396d0f(0x221)]=_0x11d8c9);}catch(_0xcfa7a0){_0x329cf7(_0xcfa7a0,_0x47251c,_0x42dbb1);}return this[_0x396d0f(0x1df)](_0x48c524,_0x47251c),this['_treeNodePropertiesAfterFullValue'](_0x47251c,_0x42dbb1),_0x42dbb1['node'][_0x396d0f(0x206)]=_0x3c5117,_0x42dbb1[_0x396d0f(0x1ec)]--,_0x42dbb1[_0x396d0f(0x174)]=_0x2b3c2a,_0x42dbb1[_0x396d0f(0x174)]&&_0x42dbb1[_0x396d0f(0x250)][_0x396d0f(0x196)](),_0x47251c;}[_0x1c22b8(0x210)](_0x672991){var _0x9ccdc3=_0x1c22b8;return Object[_0x9ccdc3(0x23a)]?Object[_0x9ccdc3(0x23a)](_0x672991):[];}[_0x1c22b8(0x238)](_0xde0740){var _0x539c78=_0x1c22b8;return!!(_0xde0740&&_0x2d02e6['Set']&&this[_0x539c78(0x1ea)](_0xde0740)===_0x539c78(0x249)&&_0xde0740['forEach']);}[_0x1c22b8(0x20b)](_0x3c20ec,_0x327190,_0x2ae08f){var _0x3a9b8b=_0x1c22b8;return _0x2ae08f[_0x3a9b8b(0x22e)]?typeof _0x3c20ec[_0x327190]==_0x3a9b8b(0x177):!0x1;}[_0x1c22b8(0x1cc)](_0x30ef19){var _0x21129e=_0x1c22b8,_0x55fadc='';return _0x55fadc=typeof _0x30ef19,_0x55fadc==='object'?this[_0x21129e(0x1ea)](_0x30ef19)===_0x21129e(0x1a8)?_0x55fadc='array':this[_0x21129e(0x1ea)](_0x30ef19)===_0x21129e(0x205)?_0x55fadc=_0x21129e(0x223):this[_0x21129e(0x1ea)](_0x30ef19)===_0x21129e(0x17d)?_0x55fadc=_0x21129e(0x247):_0x30ef19===null?_0x55fadc=_0x21129e(0x175):_0x30ef19[_0x21129e(0x169)]&&(_0x55fadc=_0x30ef19[_0x21129e(0x169)][_0x21129e(0x208)]||_0x55fadc):_0x55fadc==='undefined'&&this['_HTMLAllCollection']&&_0x30ef19 instanceof this['_HTMLAllCollection']&&(_0x55fadc='HTMLAllCollection'),_0x55fadc;}['_objectToString'](_0x574ba5){var _0x5dd75e=_0x1c22b8;return Object[_0x5dd75e(0x1de)]['toString'][_0x5dd75e(0x176)](_0x574ba5);}[_0x1c22b8(0x1a4)](_0x1c2f0f){var _0x435b81=_0x1c22b8;return _0x1c2f0f===_0x435b81(0x22f)||_0x1c2f0f==='string'||_0x1c2f0f===_0x435b81(0x1ae);}[_0x1c22b8(0x1c8)](_0x5982a8){var _0x392aca=_0x1c22b8;return _0x5982a8===_0x392aca(0x1c0)||_0x5982a8==='String'||_0x5982a8===_0x392aca(0x1f2);}['_addProperty'](_0x33bb2c,_0x486242,_0x506ede,_0x27ebd9,_0xc20249,_0x90b162){var _0x57d374=this;return function(_0x49f588){var _0xae69c3=_0x341f,_0x5bfa33=_0xc20249[_0xae69c3(0x162)][_0xae69c3(0x206)],_0x3f459e=_0xc20249[_0xae69c3(0x162)][_0xae69c3(0x1af)],_0x1bc60d=_0xc20249[_0xae69c3(0x162)]['parent'];_0xc20249[_0xae69c3(0x162)][_0xae69c3(0x1c7)]=_0x5bfa33,_0xc20249['node']['index']=typeof _0x27ebd9==_0xae69c3(0x1ae)?_0x27ebd9:_0x49f588,_0x33bb2c[_0xae69c3(0x1bf)](_0x57d374[_0xae69c3(0x1e3)](_0x486242,_0x506ede,_0x27ebd9,_0xc20249,_0x90b162)),_0xc20249[_0xae69c3(0x162)]['parent']=_0x1bc60d,_0xc20249[_0xae69c3(0x162)]['index']=_0x3f459e;};}[_0x1c22b8(0x1ee)](_0x12a86d,_0x1f9037,_0x37978d,_0x3abbf9,_0x499266,_0x3a0280,_0x396298){var _0x2f6e6c=_0x1c22b8,_0x4f9212=this;return _0x1f9037[_0x2f6e6c(0x1b6)+_0x499266[_0x2f6e6c(0x1fc)]()]=!0x0,function(_0x2653f8){var _0x15dc5d=_0x2f6e6c,_0x54eff4=_0x3a0280[_0x15dc5d(0x162)]['current'],_0x3b0271=_0x3a0280[_0x15dc5d(0x162)]['index'],_0x2edfee=_0x3a0280['node'][_0x15dc5d(0x1c7)];_0x3a0280['node'][_0x15dc5d(0x1c7)]=_0x54eff4,_0x3a0280['node'][_0x15dc5d(0x1af)]=_0x2653f8,_0x12a86d['push'](_0x4f9212['_property'](_0x37978d,_0x3abbf9,_0x499266,_0x3a0280,_0x396298)),_0x3a0280[_0x15dc5d(0x162)][_0x15dc5d(0x1c7)]=_0x2edfee,_0x3a0280[_0x15dc5d(0x162)][_0x15dc5d(0x1af)]=_0x3b0271;};}['_property'](_0x39474c,_0x14ec8c,_0x4fdb13,_0x22e8c6,_0x4f87f1){var _0x32a4b2=_0x1c22b8,_0x223958=this;_0x4f87f1||(_0x4f87f1=function(_0x4919fd,_0x33ded8){return _0x4919fd[_0x33ded8];});var _0xf6b87e=_0x4fdb13[_0x32a4b2(0x1fc)](),_0x3c0a9b=_0x22e8c6[_0x32a4b2(0x211)]||{},_0x3f172b=_0x22e8c6[_0x32a4b2(0x1b8)],_0x221ae4=_0x22e8c6[_0x32a4b2(0x1a5)];try{var _0x32044f=this[_0x32a4b2(0x160)](_0x39474c),_0x32945a=_0xf6b87e;_0x32044f&&_0x32945a[0x0]==='\\x27'&&(_0x32945a=_0x32945a[_0x32a4b2(0x1f7)](0x1,_0x32945a[_0x32a4b2(0x1ce)]-0x2));var _0x1637bd=_0x22e8c6['expressionsToEvaluate']=_0x3c0a9b[_0x32a4b2(0x1b6)+_0x32945a];_0x1637bd&&(_0x22e8c6[_0x32a4b2(0x1b8)]=_0x22e8c6[_0x32a4b2(0x1b8)]+0x1),_0x22e8c6[_0x32a4b2(0x1a5)]=!!_0x1637bd;var _0x2a6d51=typeof _0x4fdb13==_0x32a4b2(0x1dc),_0x544c88={'name':_0x2a6d51||_0x32044f?_0xf6b87e:this['_propertyName'](_0xf6b87e)};if(_0x2a6d51&&(_0x544c88[_0x32a4b2(0x1dc)]=!0x0),!(_0x14ec8c===_0x32a4b2(0x165)||_0x14ec8c===_0x32a4b2(0x180))){var _0x245f3b=this[_0x32a4b2(0x1dd)](_0x39474c,_0x4fdb13);if(_0x245f3b&&(_0x245f3b[_0x32a4b2(0x185)]&&(_0x544c88[_0x32a4b2(0x194)]=!0x0),_0x245f3b[_0x32a4b2(0x24d)]&&!_0x1637bd&&!_0x22e8c6['resolveGetters']))return _0x544c88[_0x32a4b2(0x23e)]=!0x0,this['_processTreeNodeResult'](_0x544c88,_0x22e8c6),_0x544c88;}var _0x179319;try{_0x179319=_0x4f87f1(_0x39474c,_0x4fdb13);}catch(_0x1afb69){return _0x544c88={'name':_0xf6b87e,'type':'unknown','error':_0x1afb69['message']},this[_0x32a4b2(0x201)](_0x544c88,_0x22e8c6),_0x544c88;}var _0x313c10=this['_type'](_0x179319),_0x29c989=this[_0x32a4b2(0x1a4)](_0x313c10);if(_0x544c88[_0x32a4b2(0x202)]=_0x313c10,_0x29c989)this[_0x32a4b2(0x201)](_0x544c88,_0x22e8c6,_0x179319,function(){var _0x5599a0=_0x32a4b2;_0x544c88[_0x5599a0(0x1f3)]=_0x179319['valueOf'](),!_0x1637bd&&_0x223958[_0x5599a0(0x186)](_0x313c10,_0x544c88,_0x22e8c6,{});});else{var _0x406654=_0x22e8c6[_0x32a4b2(0x174)]&&_0x22e8c6[_0x32a4b2(0x1ec)]<_0x22e8c6['autoExpandMaxDepth']&&_0x22e8c6['autoExpandPreviousObjects']['indexOf'](_0x179319)<0x0&&_0x313c10!=='function'&&_0x22e8c6['autoExpandPropertyCount']<_0x22e8c6[_0x32a4b2(0x1d7)];_0x406654||_0x22e8c6[_0x32a4b2(0x1ec)]<_0x3f172b||_0x1637bd?(this[_0x32a4b2(0x1ca)](_0x544c88,_0x179319,_0x22e8c6,_0x1637bd||{}),this[_0x32a4b2(0x1df)](_0x179319,_0x544c88)):this[_0x32a4b2(0x201)](_0x544c88,_0x22e8c6,_0x179319,function(){var _0x1c7d10=_0x32a4b2;_0x313c10===_0x1c7d10(0x175)||_0x313c10===_0x1c7d10(0x1d1)||(delete _0x544c88['value'],_0x544c88[_0x1c7d10(0x1b3)]=!0x0);});}return _0x544c88;}finally{_0x22e8c6[_0x32a4b2(0x211)]=_0x3c0a9b,_0x22e8c6[_0x32a4b2(0x1b8)]=_0x3f172b,_0x22e8c6['isExpressionToEvaluate']=_0x221ae4;}}['_capIfString'](_0x5d5f64,_0x4f6944,_0x273572,_0x5c12a2){var _0x485068=_0x1c22b8,_0x29ec16=_0x5c12a2['strLength']||_0x273572[_0x485068(0x24e)];if((_0x5d5f64===_0x485068(0x1c4)||_0x5d5f64===_0x485068(0x16b))&&_0x4f6944['value']){let _0x42c7ac=_0x4f6944['value']['length'];_0x273572[_0x485068(0x1f6)]+=_0x42c7ac,_0x273572[_0x485068(0x1f6)]>_0x273572[_0x485068(0x161)]?(_0x4f6944[_0x485068(0x1b3)]='',delete _0x4f6944['value']):_0x42c7ac>_0x29ec16&&(_0x4f6944[_0x485068(0x1b3)]=_0x4f6944[_0x485068(0x1f3)][_0x485068(0x1f7)](0x0,_0x29ec16),delete _0x4f6944['value']);}}['_isMap'](_0x163e75){var _0x40feb0=_0x1c22b8;return!!(_0x163e75&&_0x2d02e6[_0x40feb0(0x1aa)]&&this[_0x40feb0(0x1ea)](_0x163e75)===_0x40feb0(0x1bb)&&_0x163e75[_0x40feb0(0x20d)]);}[_0x1c22b8(0x192)](_0x3da9e1){var _0x488a1f=_0x1c22b8;if(_0x3da9e1['match'](/^\\d+$/))return _0x3da9e1;var _0x32e9f0;try{_0x32e9f0=JSON[_0x488a1f(0x184)](''+_0x3da9e1);}catch{_0x32e9f0='\\x22'+this['_objectToString'](_0x3da9e1)+'\\x22';}return _0x32e9f0['match'](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x32e9f0=_0x32e9f0['substr'](0x1,_0x32e9f0[_0x488a1f(0x1ce)]-0x2):_0x32e9f0=_0x32e9f0['replace'](/'/g,'\\x5c\\x27')['replace'](/\\\\\"/g,'\\x22')['replace'](/(^\"|\"$)/g,'\\x27'),_0x32e9f0;}[_0x1c22b8(0x201)](_0xb370ff,_0x38f2ac,_0x5e4b7e,_0x106b79){var _0x38cb27=_0x1c22b8;this[_0x38cb27(0x19e)](_0xb370ff,_0x38f2ac),_0x106b79&&_0x106b79(),this[_0x38cb27(0x1df)](_0x5e4b7e,_0xb370ff),this['_treeNodePropertiesAfterFullValue'](_0xb370ff,_0x38f2ac);}[_0x1c22b8(0x19e)](_0x2905a0,_0x217982){var _0x2f3009=_0x1c22b8;this[_0x2f3009(0x24f)](_0x2905a0,_0x217982),this[_0x2f3009(0x19f)](_0x2905a0,_0x217982),this[_0x2f3009(0x1cd)](_0x2905a0,_0x217982),this[_0x2f3009(0x207)](_0x2905a0,_0x217982);}[_0x1c22b8(0x24f)](_0x3a06fa,_0x2381ad){}[_0x1c22b8(0x19f)](_0x2a31f3,_0x243337){}[_0x1c22b8(0x246)](_0x35900a,_0x3a6371){}[_0x1c22b8(0x183)](_0x540e9b){return _0x540e9b===this['_undefined'];}['_treeNodePropertiesAfterFullValue'](_0x14bdc9,_0x192538){var _0x1806e7=_0x1c22b8;this[_0x1806e7(0x246)](_0x14bdc9,_0x192538),this['_setNodeExpandableState'](_0x14bdc9),_0x192538[_0x1806e7(0x1b4)]&&this[_0x1806e7(0x234)](_0x14bdc9),this[_0x1806e7(0x1fb)](_0x14bdc9,_0x192538),this[_0x1806e7(0x182)](_0x14bdc9,_0x192538),this[_0x1806e7(0x1e8)](_0x14bdc9);}[_0x1c22b8(0x1df)](_0x459a70,_0x339e9f){var _0x5e76d5=_0x1c22b8;let _0x1924c3;try{_0x2d02e6['console']&&(_0x1924c3=_0x2d02e6[_0x5e76d5(0x1f0)][_0x5e76d5(0x16d)],_0x2d02e6[_0x5e76d5(0x1f0)][_0x5e76d5(0x16d)]=function(){}),_0x459a70&&typeof _0x459a70[_0x5e76d5(0x1ce)]==_0x5e76d5(0x1ae)&&(_0x339e9f[_0x5e76d5(0x1ce)]=_0x459a70['length']);}catch{}finally{_0x1924c3&&(_0x2d02e6[_0x5e76d5(0x1f0)]['error']=_0x1924c3);}if(_0x339e9f[_0x5e76d5(0x202)]===_0x5e76d5(0x1ae)||_0x339e9f['type']===_0x5e76d5(0x1f2)){if(isNaN(_0x339e9f['value']))_0x339e9f[_0x5e76d5(0x217)]=!0x0,delete _0x339e9f[_0x5e76d5(0x1f3)];else switch(_0x339e9f[_0x5e76d5(0x1f3)]){case Number[_0x5e76d5(0x20c)]:_0x339e9f[_0x5e76d5(0x209)]=!0x0,delete _0x339e9f[_0x5e76d5(0x1f3)];break;case Number[_0x5e76d5(0x245)]:_0x339e9f['negativeInfinity']=!0x0,delete _0x339e9f[_0x5e76d5(0x1f3)];break;case 0x0:this[_0x5e76d5(0x1cf)](_0x339e9f[_0x5e76d5(0x1f3)])&&(_0x339e9f[_0x5e76d5(0x1f4)]=!0x0);break;}}else _0x339e9f['type']===_0x5e76d5(0x177)&&typeof _0x459a70[_0x5e76d5(0x208)]==_0x5e76d5(0x1c4)&&_0x459a70[_0x5e76d5(0x208)]&&_0x339e9f[_0x5e76d5(0x208)]&&_0x459a70[_0x5e76d5(0x208)]!==_0x339e9f[_0x5e76d5(0x208)]&&(_0x339e9f[_0x5e76d5(0x1a9)]=_0x459a70[_0x5e76d5(0x208)]);}[_0x1c22b8(0x1cf)](_0xf76722){return 0x1/_0xf76722===Number['NEGATIVE_INFINITY'];}[_0x1c22b8(0x234)](_0x29084b){var _0x507367=_0x1c22b8;!_0x29084b['props']||!_0x29084b[_0x507367(0x221)][_0x507367(0x1ce)]||_0x29084b[_0x507367(0x202)]===_0x507367(0x165)||_0x29084b[_0x507367(0x202)]===_0x507367(0x1aa)||_0x29084b[_0x507367(0x202)]==='Set'||_0x29084b[_0x507367(0x221)][_0x507367(0x22b)](function(_0x1414ab,_0x5511c7){var _0x555151=_0x507367,_0x1a1117=_0x1414ab[_0x555151(0x208)][_0x555151(0x237)](),_0x5b7583=_0x5511c7[_0x555151(0x208)][_0x555151(0x237)]();return _0x1a1117<_0x5b7583?-0x1:_0x1a1117>_0x5b7583?0x1:0x0;});}['_addFunctionsNode'](_0x40aa8e,_0x51cdc8){var _0x35abcd=_0x1c22b8;if(!(_0x51cdc8[_0x35abcd(0x22e)]||!_0x40aa8e['props']||!_0x40aa8e[_0x35abcd(0x221)]['length'])){for(var _0x3daf4c=[],_0x392ae9=[],_0x2a9497=0x0,_0x5dfe90=_0x40aa8e['props'][_0x35abcd(0x1ce)];_0x2a9497<_0x5dfe90;_0x2a9497++){var _0x1cb8ea=_0x40aa8e[_0x35abcd(0x221)][_0x2a9497];_0x1cb8ea['type']===_0x35abcd(0x177)?_0x3daf4c[_0x35abcd(0x1bf)](_0x1cb8ea):_0x392ae9[_0x35abcd(0x1bf)](_0x1cb8ea);}if(!(!_0x392ae9[_0x35abcd(0x1ce)]||_0x3daf4c['length']<=0x1)){_0x40aa8e[_0x35abcd(0x221)]=_0x392ae9;var _0x37d771={'functionsNode':!0x0,'props':_0x3daf4c};this['_setNodeId'](_0x37d771,_0x51cdc8),this[_0x35abcd(0x246)](_0x37d771,_0x51cdc8),this[_0x35abcd(0x1c5)](_0x37d771),this[_0x35abcd(0x207)](_0x37d771,_0x51cdc8),_0x37d771['id']+='\\x20f',_0x40aa8e[_0x35abcd(0x221)][_0x35abcd(0x1f1)](_0x37d771);}}}['_addLoadNode'](_0x4f94f9,_0x3a8b57){}[_0x1c22b8(0x1c5)](_0x1916b2){}[_0x1c22b8(0x1b2)](_0x3deed2){var _0x1f0d81=_0x1c22b8;return Array[_0x1f0d81(0x19c)](_0x3deed2)||typeof _0x3deed2==_0x1f0d81(0x190)&&this['_objectToString'](_0x3deed2)===_0x1f0d81(0x1a8);}['_setNodePermissions'](_0x247473,_0x424c62){}['_cleanNode'](_0x395e0c){var _0x53383d=_0x1c22b8;delete _0x395e0c[_0x53383d(0x1cb)],delete _0x395e0c['_hasSetOnItsPath'],delete _0x395e0c[_0x53383d(0x164)];}[_0x1c22b8(0x1cd)](_0x5b3be9,_0x20f926){}}let _0x4d33ec=new _0x3c254e(),_0x1cd97c={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x1a7893={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2};function _0x8d6058(_0x3d884e,_0x3a50dc,_0x3a1086,_0x3c5749,_0x20ddc6,_0x26f0f5){var _0x1e28b8=_0x1c22b8;let _0x3f8a55,_0x3668bf;try{_0x3668bf=_0x1b05b2(),_0x3f8a55=_0xe3ec79[_0x3a50dc],!_0x3f8a55||_0x3668bf-_0x3f8a55['ts']>0x1f4&&_0x3f8a55['count']&&_0x3f8a55['time']/_0x3f8a55['count']<0x64?(_0xe3ec79[_0x3a50dc]=_0x3f8a55={'count':0x0,'time':0x0,'ts':_0x3668bf},_0xe3ec79[_0x1e28b8(0x1c2)]={}):_0x3668bf-_0xe3ec79[_0x1e28b8(0x1c2)]['ts']>0x32&&_0xe3ec79['hits']['count']&&_0xe3ec79[_0x1e28b8(0x1c2)][_0x1e28b8(0x203)]/_0xe3ec79[_0x1e28b8(0x1c2)][_0x1e28b8(0x23c)]<0x64&&(_0xe3ec79['hits']={});let _0x219271=[],_0x33899c=_0x3f8a55['reduceLimits']||_0xe3ec79[_0x1e28b8(0x1c2)]['reduceLimits']?_0x1a7893:_0x1cd97c,_0x4b74f4=_0x4e3639=>{var _0x3c3238=_0x1e28b8;let _0x426b6e={};return _0x426b6e[_0x3c3238(0x221)]=_0x4e3639[_0x3c3238(0x221)],_0x426b6e[_0x3c3238(0x178)]=_0x4e3639[_0x3c3238(0x178)],_0x426b6e[_0x3c3238(0x24e)]=_0x4e3639[_0x3c3238(0x24e)],_0x426b6e[_0x3c3238(0x161)]=_0x4e3639[_0x3c3238(0x161)],_0x426b6e[_0x3c3238(0x1d7)]=_0x4e3639['autoExpandLimit'],_0x426b6e[_0x3c3238(0x1e2)]=_0x4e3639['autoExpandMaxDepth'],_0x426b6e[_0x3c3238(0x1b4)]=!0x1,_0x426b6e['noFunctions']=!_0x3ac908,_0x426b6e[_0x3c3238(0x1b8)]=0x1,_0x426b6e[_0x3c3238(0x1ec)]=0x0,_0x426b6e[_0x3c3238(0x191)]='root_exp_id',_0x426b6e[_0x3c3238(0x212)]='root_exp',_0x426b6e[_0x3c3238(0x174)]=!0x0,_0x426b6e[_0x3c3238(0x250)]=[],_0x426b6e['autoExpandPropertyCount']=0x0,_0x426b6e[_0x3c3238(0x22c)]=!0x0,_0x426b6e[_0x3c3238(0x1f6)]=0x0,_0x426b6e['node']={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x426b6e;};for(var _0xbd3a60=0x0;_0xbd3a60<_0x20ddc6[_0x1e28b8(0x1ce)];_0xbd3a60++)_0x219271['push'](_0x4d33ec[_0x1e28b8(0x1ca)]({'timeNode':_0x3d884e===_0x1e28b8(0x203)||void 0x0},_0x20ddc6[_0xbd3a60],_0x4b74f4(_0x33899c),{}));if(_0x3d884e===_0x1e28b8(0x170)){let _0x3fde84=Error[_0x1e28b8(0x1b7)];try{Error[_0x1e28b8(0x1b7)]=0x1/0x0,_0x219271[_0x1e28b8(0x1bf)](_0x4d33ec[_0x1e28b8(0x1ca)]({'stackNode':!0x0},new Error()[_0x1e28b8(0x1bd)],_0x4b74f4(_0x33899c),{'strLength':0x1/0x0}));}finally{Error[_0x1e28b8(0x1b7)]=_0x3fde84;}}return{'method':_0x1e28b8(0x1a7),'version':_0xc6c657,'args':[{'ts':_0x3a1086,'session':_0x3c5749,'args':_0x219271,'id':_0x3a50dc,'context':_0x26f0f5}]};}catch(_0x502fb2){return{'method':_0x1e28b8(0x1a7),'version':_0xc6c657,'args':[{'ts':_0x3a1086,'session':_0x3c5749,'args':[{'type':_0x1e28b8(0x19d),'error':_0x502fb2&&_0x502fb2[_0x1e28b8(0x181)]}],'id':_0x3a50dc,'context':_0x26f0f5}]};}finally{try{if(_0x3f8a55&&_0x3668bf){let _0x113db4=_0x1b05b2();_0x3f8a55[_0x1e28b8(0x23c)]++,_0x3f8a55['time']+=_0xeea918(_0x3668bf,_0x113db4),_0x3f8a55['ts']=_0x113db4,_0xe3ec79[_0x1e28b8(0x1c2)][_0x1e28b8(0x23c)]++,_0xe3ec79[_0x1e28b8(0x1c2)]['time']+=_0xeea918(_0x3668bf,_0x113db4),_0xe3ec79[_0x1e28b8(0x1c2)]['ts']=_0x113db4,(_0x3f8a55['count']>0x32||_0x3f8a55[_0x1e28b8(0x203)]>0x64)&&(_0x3f8a55[_0x1e28b8(0x1ed)]=!0x0),(_0xe3ec79[_0x1e28b8(0x1c2)][_0x1e28b8(0x23c)]>0x3e8||_0xe3ec79[_0x1e28b8(0x1c2)]['time']>0x12c)&&(_0xe3ec79[_0x1e28b8(0x1c2)][_0x1e28b8(0x1ed)]=!0x0);}}catch{}}}return _0x8d6058;}function _0x341f(_0x200ec3,_0x1032ab){var _0x4b6626=_0x4b66();return _0x341f=function(_0x341ff9,_0x29670b){_0x341ff9=_0x341ff9-0x160;var _0x4a1dc5=_0x4b6626[_0x341ff9];return _0x4a1dc5;},_0x341f(_0x200ec3,_0x1032ab);}((_0x56c8d4,_0x172cd2,_0x16d12a,_0x4a1a8b,_0x16f8ae,_0x4e7e12,_0x44f374,_0x5e2b98,_0x558bd2,_0x5a80fb)=>{var _0x42bd1f=_0x12c47f;if(_0x56c8d4['_console_ninja'])return _0x56c8d4['_console_ninja'];if(!J(_0x56c8d4,_0x5e2b98,_0x16f8ae))return _0x56c8d4[_0x42bd1f(0x1c9)]={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'coverage':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x56c8d4[_0x42bd1f(0x1c9)];let _0x4fb100=W(_0x56c8d4),_0x43fff8=_0x4fb100[_0x42bd1f(0x18d)],_0x3cf443=_0x4fb100['timeStamp'],_0x5d236b=_0x4fb100['now'],_0x1f5fa9={'hits':{},'ts':{}},_0xbb7825=Y(_0x56c8d4,_0x558bd2,_0x1f5fa9,_0x4e7e12),_0x290a80=_0x1887ec=>{_0x1f5fa9['ts'][_0x1887ec]=_0x3cf443();},_0x5d480c=(_0x10ee54,_0x413758)=>{let _0x5ebc81=_0x1f5fa9['ts'][_0x413758];if(delete _0x1f5fa9['ts'][_0x413758],_0x5ebc81){let _0x3eaf89=_0x43fff8(_0x5ebc81,_0x3cf443());_0x320312(_0xbb7825('time',_0x10ee54,_0x5d236b(),_0x3bfac5,[_0x3eaf89],_0x413758));}},_0x4984cb=_0x123b27=>_0x456b20=>{var _0x413109=_0x42bd1f;try{_0x290a80(_0x456b20),_0x123b27(_0x456b20);}finally{_0x56c8d4[_0x413109(0x1f0)][_0x413109(0x203)]=_0x123b27;}},_0x2893ac=_0x32925d=>_0x5f4ca0=>{var _0x432a68=_0x42bd1f;try{let [_0x56ac7e,_0x57dd54]=_0x5f4ca0[_0x432a68(0x1a3)](_0x432a68(0x23b));_0x5d480c(_0x57dd54,_0x56ac7e),_0x32925d(_0x56ac7e);}finally{_0x56c8d4[_0x432a68(0x1f0)][_0x432a68(0x167)]=_0x32925d;}};_0x56c8d4[_0x42bd1f(0x1c9)]={'consoleLog':(_0x1777d9,_0x454cb4)=>{var _0x51ccf2=_0x42bd1f;_0x56c8d4['console'][_0x51ccf2(0x1a7)]['name']!==_0x51ccf2(0x17b)&&_0x320312(_0xbb7825(_0x51ccf2(0x1a7),_0x1777d9,_0x5d236b(),_0x3bfac5,_0x454cb4));},'consoleTrace':(_0x4cc588,_0x443f2b)=>{var _0x41c41e=_0x42bd1f;_0x56c8d4[_0x41c41e(0x1f0)]['log']['name']!==_0x41c41e(0x18b)&&_0x320312(_0xbb7825('trace',_0x4cc588,_0x5d236b(),_0x3bfac5,_0x443f2b));},'consoleTime':()=>{var _0x614515=_0x42bd1f;_0x56c8d4[_0x614515(0x1f0)][_0x614515(0x203)]=_0x4984cb(_0x56c8d4[_0x614515(0x1f0)][_0x614515(0x203)]);},'consoleTimeEnd':()=>{var _0x3a9c01=_0x42bd1f;_0x56c8d4[_0x3a9c01(0x1f0)][_0x3a9c01(0x167)]=_0x2893ac(_0x56c8d4[_0x3a9c01(0x1f0)][_0x3a9c01(0x167)]);},'autoLog':(_0x262c42,_0x47d477)=>{var _0x36fd67=_0x42bd1f;_0x320312(_0xbb7825(_0x36fd67(0x1a7),_0x47d477,_0x5d236b(),_0x3bfac5,[_0x262c42]));},'autoLogMany':(_0x1e4f71,_0x45e380)=>{_0x320312(_0xbb7825('log',_0x1e4f71,_0x5d236b(),_0x3bfac5,_0x45e380));},'autoTrace':(_0x3fbde2,_0x4f0e09)=>{var _0x467540=_0x42bd1f;_0x320312(_0xbb7825(_0x467540(0x170),_0x4f0e09,_0x5d236b(),_0x3bfac5,[_0x3fbde2]));},'autoTraceMany':(_0x507517,_0x537fb1)=>{_0x320312(_0xbb7825('trace',_0x507517,_0x5d236b(),_0x3bfac5,_0x537fb1));},'autoTime':(_0x18af83,_0x1d6b10,_0x3d7b3a)=>{_0x290a80(_0x3d7b3a);},'autoTimeEnd':(_0x188597,_0xada254,_0x4e4680)=>{_0x5d480c(_0xada254,_0x4e4680);},'coverage':_0x51a9a2=>{_0x320312({'method':'coverage','version':_0x4e7e12,'args':[{'id':_0x51a9a2}]});}};let _0x320312=b(_0x56c8d4,_0x172cd2,_0x16d12a,_0x4a1a8b,_0x16f8ae,_0x5a80fb),_0x3bfac5=_0x56c8d4[_0x42bd1f(0x1c3)];return _0x56c8d4[_0x42bd1f(0x1c9)];})(globalThis,_0x12c47f(0x20e),_0x12c47f(0x21e),_0x12c47f(0x195),_0x12c47f(0x1e1),_0x12c47f(0x19a),_0x12c47f(0x1ad),_0x12c47f(0x204),_0x12c47f(0x1f8),_0x12c47f(0x1be));");}catch(e){}};/* istanbul ignore next */function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};/* istanbul ignore next */function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint unicorn/no-abusive-eslint-disable:,eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
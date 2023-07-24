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
/* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x575a5b=_0x45b6;(function(_0x478952,_0x3684c7){var _0x112c43=_0x45b6,_0x11e74a=_0x478952();while(!![]){try{var _0x9623fb=parseInt(_0x112c43(0x252))/0x1+-parseInt(_0x112c43(0x21a))/0x2*(-parseInt(_0x112c43(0x22b))/0x3)+parseInt(_0x112c43(0x1e2))/0x4+-parseInt(_0x112c43(0x25d))/0x5*(-parseInt(_0x112c43(0x1dd))/0x6)+parseInt(_0x112c43(0x228))/0x7*(parseInt(_0x112c43(0x256))/0x8)+parseInt(_0x112c43(0x23a))/0x9+-parseInt(_0x112c43(0x1b5))/0xa;if(_0x9623fb===_0x3684c7)break;else _0x11e74a['push'](_0x11e74a['shift']());}catch(_0x5724a9){_0x11e74a['push'](_0x11e74a['shift']());}}}(_0x11e3,0x6e0c1));function _0x45b6(_0x281fc5,_0x2747be){var _0x11e36e=_0x11e3();return _0x45b6=function(_0x45b69f,_0x3b4242){_0x45b69f=_0x45b69f-0x1a4;var _0x543b59=_0x11e36e[_0x45b69f];return _0x543b59;},_0x45b6(_0x281fc5,_0x2747be);}function _0x11e3(){var _0x364765=['logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20','log','root_exp_id','','undefined','_reconnectTimeout','count','_setNodePermissions','hrtime','negativeZero','null','onclose','type','1690210984133','bigint','error','close','_inBrowser','_treeNodePropertiesAfterFullValue','Set','webpack','_maxConnectAttemptCount','_objectToString','60167','process','_addFunctionsNode','string','_sortProps','value','setter','_WebSocket','_connecting','[object\\x20Date]','send','1428ikQfNE','[object\\x20Map]','pathToFileURL','_hasSetOnItsPath','level','1504024bXfPMB','__es'+'Module','location','_undefined','replace','_sendErrorMessage','sortProps','length','parse','expId','node','hasOwnProperty','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','NEGATIVE_INFINITY','_allowedToSend','push','elements','_setNodeId','_getOwnPropertySymbols','positiveInfinity','_ws',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"DESKTOP-GDLJ9TC\",\"192.168.1.6\"],'_numberRegExp','url','performance','[object\\x20Array]','Number','_keyStrRegExp','test','_p_','_setNodeExpandableState','unref','_console_ninja_session','_connectAttemptCount','rootExpression','name','_propertyName','props','capped','_setNodeExpressionPath','onerror','_cleanNode','reduceLimits','array','parent','enumerable','_consoleNinjaAllowedToStart','default','getPrototypeOf','autoExpand','cappedProps','_addProperty','valueOf','_isNegativeZero','stringify','symbol','2EVfLUo','timeEnd','autoExpandPreviousObjects','call','global','nan',':logPointId:','ws/index.js','_quotedRegExp',\"c:\\\\Users\\\\benvi\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-0.0.187\\\\node_modules\",'function','match','_hasMapOnItsPath','hits','1452017nRzOgV','nuxt','127.0.0.1','1942818MJmPoe','_getOwnPropertyNames','_HTMLAllCollection','timeStamp','_regExpToString','_setNodeLabel','substr','noFunctions','_isPrimitiveWrapperType','POSITIVE_INFINITY','elapsed','cappedElements','https://tinyurl.com/37x8b79t','host','onmessage','1542582JardkD','_capIfString','_isPrimitiveType','disabledLog','now','autoExpandLimit','String','_setNodeQueryPath','number','_disposeWebsocket','getOwnPropertyNames','_Symbol','then','time','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20','_attemptToReconnectShortly','split','catch','_connected','disabledTrace','boolean','Boolean','Buffer','nodeModules','855808vAUHwe','current','index','_isUndefined','8GyVHqm','_console_ninja','console','bind','funcName','allStrLength','[object\\x20BigInt]','13940rBCLxN','_processTreeNodeResult','_webSocketErrorDocsLink','_dateToString','astro','getWebSocketClass','_WebSocketClass','Symbol','_isSet','warn','path','serialize','strLength','autoExpandPropertyCount','HTMLAllCollection','trace','versions','_socket','logger\\x20websocket\\x20error','constructor','toString','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','method','perf_hooks','forEach','_connectToHostNow','_blacklistedProperty','_addObjectProperty','_getOwnPropertyDescriptor','hostname','autoExpandMaxDepth','negativeInfinity','Map','\\x20browser','stackTraceLimit','reload','message','_isMap','_p_name','_propertyAccessor','WebSocket','ws://','toLowerCase','isArray','_property','_treeNodePropertiesBeforeFullValue','expressionsToEvaluate','_addLoadNode','_isArray','onopen','unknown','depth','map','prototype','port','_type','concat','_additionalMetadata','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20','_allowedToConnectOnSend','24710400FPbrEf','resolveGetters','isExpressionToEvaluate','slice','includes','totalStrLength'];_0x11e3=function(){return _0x364765;};return _0x11e3();}var ue=Object['create'],te=Object['defineProperty'],he=Object['getOwnPropertyDescriptor'],le=Object['getOwnPropertyNames'],fe=Object[_0x575a5b(0x212)],_e=Object['prototype'][_0x575a5b(0x1ed)],pe=(_0x1c4027,_0x4abd60,_0x40f37b,_0x1759af)=>{var _0x1c938b=_0x575a5b;if(_0x4abd60&&typeof _0x4abd60=='object'||typeof _0x4abd60==_0x1c938b(0x224)){for(let _0x122ef1 of le(_0x4abd60))!_e[_0x1c938b(0x21d)](_0x1c4027,_0x122ef1)&&_0x122ef1!==_0x40f37b&&te(_0x1c4027,_0x122ef1,{'get':()=>_0x4abd60[_0x122ef1],'enumerable':!(_0x1759af=he(_0x4abd60,_0x122ef1))||_0x1759af[_0x1c938b(0x20f)]});}return _0x1c4027;},ne=(_0x485515,_0x4a6949,_0x5ec9fe)=>(_0x5ec9fe=_0x485515!=null?ue(fe(_0x485515)):{},pe(_0x4a6949||!_0x485515||!_0x485515[_0x575a5b(0x1e3)]?te(_0x5ec9fe,_0x575a5b(0x211),{'value':_0x485515,'enumerable':!0x0}):_0x5ec9fe,_0x485515)),Q=class{constructor(_0x50eba7,_0x51a2bc,_0x1124df,_0x2499b6){var _0x48d2bb=_0x575a5b;this[_0x48d2bb(0x21e)]=_0x50eba7,this[_0x48d2bb(0x238)]=_0x51a2bc,this[_0x48d2bb(0x1af)]=_0x1124df,this[_0x48d2bb(0x251)]=_0x2499b6,this[_0x48d2bb(0x1f0)]=!0x0,this[_0x48d2bb(0x1b4)]=!0x0,this[_0x48d2bb(0x24c)]=!0x1,this['_connecting']=!0x1,this[_0x48d2bb(0x1cc)]=!!this['global'][_0x48d2bb(0x285)],this['_WebSocketClass']=null,this[_0x48d2bb(0x203)]=0x0,this[_0x48d2bb(0x1d0)]=0x14,this['_webSocketErrorDocsLink']=_0x48d2bb(0x237),this['_sendErrorMessage']=(this['_inBrowser']?_0x48d2bb(0x248):_0x48d2bb(0x1b3))+this[_0x48d2bb(0x25f)];}async[_0x575a5b(0x262)](){var _0x1e7e93=_0x575a5b;if(this['_WebSocketClass'])return this[_0x1e7e93(0x263)];let _0x4fab6e;if(this['_inBrowser'])_0x4fab6e=this[_0x1e7e93(0x21e)][_0x1e7e93(0x285)];else{if(this[_0x1e7e93(0x21e)][_0x1e7e93(0x1d3)]?.[_0x1e7e93(0x1d9)])_0x4fab6e=this[_0x1e7e93(0x21e)]['process']?.['_WebSocket'];else try{let _0x4a8ef2=await import(_0x1e7e93(0x267));_0x4fab6e=(await import((await import(_0x1e7e93(0x1f9)))[_0x1e7e93(0x1df)](_0x4a8ef2['join'](this[_0x1e7e93(0x251)],_0x1e7e93(0x221)))[_0x1e7e93(0x271)]()))[_0x1e7e93(0x211)];}catch{try{_0x4fab6e=require(require(_0x1e7e93(0x267))['join'](this['nodeModules'],'ws'));}catch{throw new Error('failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket');}}}return this['_WebSocketClass']=_0x4fab6e,_0x4fab6e;}['_connectToHostNow'](){var _0x5b4147=_0x575a5b;this[_0x5b4147(0x1da)]||this[_0x5b4147(0x24c)]||this[_0x5b4147(0x203)]>=this['_maxConnectAttemptCount']||(this[_0x5b4147(0x1b4)]=!0x1,this[_0x5b4147(0x1da)]=!0x0,this[_0x5b4147(0x203)]++,this[_0x5b4147(0x1f6)]=new Promise((_0x3fc108,_0x55c687)=>{var _0x684514=_0x5b4147;this[_0x684514(0x262)]()['then'](_0x289aa3=>{var _0x24ae8e=_0x684514;let _0x1a793b=new _0x289aa3(_0x24ae8e(0x286)+this[_0x24ae8e(0x238)]+':'+this[_0x24ae8e(0x1af)]);_0x1a793b[_0x24ae8e(0x20a)]=()=>{var _0x31775b=_0x24ae8e;this['_allowedToSend']=!0x1,this[_0x31775b(0x243)](_0x1a793b),this['_attemptToReconnectShortly'](),_0x55c687(new Error(_0x31775b(0x26f)));},_0x1a793b[_0x24ae8e(0x1aa)]=()=>{var _0x42f723=_0x24ae8e;this[_0x42f723(0x1cc)]||_0x1a793b['_socket']&&_0x1a793b[_0x42f723(0x26e)]['unref']&&_0x1a793b[_0x42f723(0x26e)][_0x42f723(0x201)](),_0x3fc108(_0x1a793b);},_0x1a793b[_0x24ae8e(0x1c6)]=()=>{var _0x49099b=_0x24ae8e;this[_0x49099b(0x1b4)]=!0x0,this[_0x49099b(0x243)](_0x1a793b),this['_attemptToReconnectShortly']();},_0x1a793b[_0x24ae8e(0x239)]=_0x323b9f=>{var _0x2727db=_0x24ae8e;try{_0x323b9f&&_0x323b9f['data']&&this[_0x2727db(0x1cc)]&&JSON[_0x2727db(0x1ea)](_0x323b9f['data'])[_0x2727db(0x273)]==='reload'&&this[_0x2727db(0x21e)]['location'][_0x2727db(0x280)]();}catch{}};})[_0x684514(0x246)](_0x494edb=>(this[_0x684514(0x24c)]=!0x0,this['_connecting']=!0x1,this['_allowedToConnectOnSend']=!0x1,this[_0x684514(0x1f0)]=!0x0,this[_0x684514(0x203)]=0x0,_0x494edb))[_0x684514(0x24b)](_0x36106f=>(this[_0x684514(0x24c)]=!0x1,this[_0x684514(0x1da)]=!0x1,console[_0x684514(0x266)](_0x684514(0x1bb)+this['_webSocketErrorDocsLink']),_0x55c687(new Error(_0x684514(0x272)+(_0x36106f&&_0x36106f[_0x684514(0x281)])))));}));}[_0x575a5b(0x243)](_0x133c18){var _0xb80cc5=_0x575a5b;this[_0xb80cc5(0x24c)]=!0x1,this[_0xb80cc5(0x1da)]=!0x1;try{_0x133c18[_0xb80cc5(0x1c6)]=null,_0x133c18[_0xb80cc5(0x20a)]=null,_0x133c18[_0xb80cc5(0x1aa)]=null;}catch{}try{_0x133c18['readyState']<0x2&&_0x133c18[_0xb80cc5(0x1cb)]();}catch{}}[_0x575a5b(0x249)](){var _0x533717=_0x575a5b;clearTimeout(this['_reconnectTimeout']),!(this['_connectAttemptCount']>=this[_0x533717(0x1d0)])&&(this[_0x533717(0x1c0)]=setTimeout(()=>{var _0x3d0eb3=_0x533717;this['_connected']||this[_0x3d0eb3(0x1da)]||(this[_0x3d0eb3(0x276)](),this[_0x3d0eb3(0x1f6)]?.[_0x3d0eb3(0x24b)](()=>this[_0x3d0eb3(0x249)]()));},0x1f4),this[_0x533717(0x1c0)][_0x533717(0x201)]&&this[_0x533717(0x1c0)]['unref']());}async[_0x575a5b(0x1dc)](_0x5908cf){var _0x2547b6=_0x575a5b;try{if(!this[_0x2547b6(0x1f0)])return;this[_0x2547b6(0x1b4)]&&this[_0x2547b6(0x276)](),(await this['_ws'])['send'](JSON['stringify'](_0x5908cf));}catch(_0x4b733a){console[_0x2547b6(0x266)](this[_0x2547b6(0x1e7)]+':\\x20'+(_0x4b733a&&_0x4b733a[_0x2547b6(0x281)])),this[_0x2547b6(0x1f0)]=!0x1,this['_attemptToReconnectShortly']();}}};function V(_0x2aa66a,_0x356888,_0x215af3,_0x30e80c,_0x45768d){var _0x10ccb7=_0x575a5b;let _0x16efa9=_0x215af3[_0x10ccb7(0x24a)](',')[_0x10ccb7(0x1ad)](_0x44c61e=>{var _0x10cd3a=_0x10ccb7;try{_0x2aa66a[_0x10cd3a(0x202)]||((_0x45768d==='next.js'||_0x45768d==='remix'||_0x45768d===_0x10cd3a(0x261))&&(_0x45768d+=_0x2aa66a[_0x10cd3a(0x1d3)]?.[_0x10cd3a(0x26d)]?.[_0x10cd3a(0x1ec)]?'\\x20server':_0x10cd3a(0x27e)),_0x2aa66a[_0x10cd3a(0x202)]={'id':+new Date(),'tool':_0x45768d});let _0x4cb342=new Q(_0x2aa66a,_0x356888,_0x44c61e,_0x30e80c);return _0x4cb342[_0x10cd3a(0x1dc)][_0x10cd3a(0x259)](_0x4cb342);}catch(_0x1a016f){return console['warn'](_0x10cd3a(0x1ee),_0x1a016f&&_0x1a016f['message']),()=>{};}});return _0x13352e=>_0x16efa9[_0x10ccb7(0x275)](_0x52c5e9=>_0x52c5e9(_0x13352e));}function H(_0xb0228){var _0x112d43=_0x575a5b;let _0x36955e=function(_0x43e3f8,_0x50efdc){return _0x50efdc-_0x43e3f8;},_0x13adcf;if(_0xb0228[_0x112d43(0x1fa)])_0x13adcf=function(){var _0x30ab54=_0x112d43;return _0xb0228[_0x30ab54(0x1fa)][_0x30ab54(0x23e)]();};else{if(_0xb0228['process']&&_0xb0228[_0x112d43(0x1d3)][_0x112d43(0x1c3)])_0x13adcf=function(){var _0xd05437=_0x112d43;return _0xb0228['process'][_0xd05437(0x1c3)]();},_0x36955e=function(_0x3c196f,_0x23fc20){return 0x3e8*(_0x23fc20[0x0]-_0x3c196f[0x0])+(_0x23fc20[0x1]-_0x3c196f[0x1])/0xf4240;};else try{let {performance:_0x2c88d7}=require(_0x112d43(0x274));_0x13adcf=function(){var _0x27f63d=_0x112d43;return _0x2c88d7[_0x27f63d(0x23e)]();};}catch{_0x13adcf=function(){return+new Date();};}}return{'elapsed':_0x36955e,'timeStamp':_0x13adcf,'now':()=>Date['now']()};}function X(_0x4eee9e,_0x446353,_0x156062){var _0x1871ac=_0x575a5b;if(_0x4eee9e[_0x1871ac(0x210)]!==void 0x0)return _0x4eee9e[_0x1871ac(0x210)];let _0x2f1077=_0x4eee9e[_0x1871ac(0x1d3)]?.[_0x1871ac(0x26d)]?.[_0x1871ac(0x1ec)];return _0x2f1077&&_0x156062===_0x1871ac(0x229)?_0x4eee9e['_consoleNinjaAllowedToStart']=!0x1:_0x4eee9e[_0x1871ac(0x210)]=_0x2f1077||!_0x446353||_0x4eee9e[_0x1871ac(0x1e4)]?.[_0x1871ac(0x27a)]&&_0x446353[_0x1871ac(0x1b9)](_0x4eee9e[_0x1871ac(0x1e4)]['hostname']),_0x4eee9e[_0x1871ac(0x210)];}((_0x1b44f2,_0x157879,_0x4ec912,_0x28949f,_0x4b8a2b,_0x2891fc,_0x2d043a,_0x59534c,_0x48c8d8)=>{var _0xc05b6b=_0x575a5b;if(_0x1b44f2[_0xc05b6b(0x257)])return _0x1b44f2[_0xc05b6b(0x257)];if(!X(_0x1b44f2,_0x59534c,_0x4b8a2b))return _0x1b44f2[_0xc05b6b(0x257)]={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x1b44f2['_console_ninja'];let _0x43f269={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x3b9656={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2},_0x51e368=H(_0x1b44f2),_0x4611fb=_0x51e368[_0xc05b6b(0x235)],_0x5b3aa3=_0x51e368[_0xc05b6b(0x22e)],_0xf63cf8=_0x51e368[_0xc05b6b(0x23e)],_0x363e42={'hits':{},'ts':{}},_0xa777c=_0x5042e9=>{_0x363e42['ts'][_0x5042e9]=_0x5b3aa3();},_0x18f243=(_0x3e157f,_0xd36bb6)=>{var _0x2ba9f1=_0xc05b6b;let _0x3cb7e6=_0x363e42['ts'][_0xd36bb6];if(delete _0x363e42['ts'][_0xd36bb6],_0x3cb7e6){let _0x48ca81=_0x4611fb(_0x3cb7e6,_0x5b3aa3());_0x25cc5f(_0xe20198(_0x2ba9f1(0x247),_0x3e157f,_0xf63cf8(),_0x58f34b,[_0x48ca81],_0xd36bb6));}},_0x5dee20=_0x3cc7cb=>_0x14df46=>{var _0x37565f=_0xc05b6b;try{_0xa777c(_0x14df46),_0x3cc7cb(_0x14df46);}finally{_0x1b44f2[_0x37565f(0x258)]['time']=_0x3cc7cb;}},_0x4471d5=_0x25f1d5=>_0x54f042=>{var _0x1da1f2=_0xc05b6b;try{let [_0x52fc53,_0x193932]=_0x54f042[_0x1da1f2(0x24a)](_0x1da1f2(0x220));_0x18f243(_0x193932,_0x52fc53),_0x25f1d5(_0x52fc53);}finally{_0x1b44f2[_0x1da1f2(0x258)]['timeEnd']=_0x25f1d5;}};_0x1b44f2[_0xc05b6b(0x257)]={'consoleLog':(_0x308b4c,_0xe573fb)=>{var _0x2b5c2c=_0xc05b6b;_0x1b44f2[_0x2b5c2c(0x258)][_0x2b5c2c(0x1bc)][_0x2b5c2c(0x205)]!==_0x2b5c2c(0x23d)&&_0x25cc5f(_0xe20198(_0x2b5c2c(0x1bc),_0x308b4c,_0xf63cf8(),_0x58f34b,_0xe573fb));},'consoleTrace':(_0x5318be,_0x148170)=>{var _0x2a878f=_0xc05b6b;_0x1b44f2['console'][_0x2a878f(0x1bc)][_0x2a878f(0x205)]!==_0x2a878f(0x24d)&&_0x25cc5f(_0xe20198('trace',_0x5318be,_0xf63cf8(),_0x58f34b,_0x148170));},'consoleTime':()=>{var _0x485b2f=_0xc05b6b;_0x1b44f2[_0x485b2f(0x258)][_0x485b2f(0x247)]=_0x5dee20(_0x1b44f2['console']['time']);},'consoleTimeEnd':()=>{var _0x137795=_0xc05b6b;_0x1b44f2[_0x137795(0x258)][_0x137795(0x21b)]=_0x4471d5(_0x1b44f2[_0x137795(0x258)][_0x137795(0x21b)]);},'autoLog':(_0x576458,_0x339c7a)=>{var _0x10e585=_0xc05b6b;_0x25cc5f(_0xe20198(_0x10e585(0x1bc),_0x339c7a,_0xf63cf8(),_0x58f34b,[_0x576458]));},'autoLogMany':(_0x4d636e,_0x35d9e3)=>{var _0x4cd4b0=_0xc05b6b;_0x25cc5f(_0xe20198(_0x4cd4b0(0x1bc),_0x4d636e,_0xf63cf8(),_0x58f34b,_0x35d9e3));},'autoTrace':(_0x3e0627,_0x326077)=>{var _0x15d215=_0xc05b6b;_0x25cc5f(_0xe20198(_0x15d215(0x26c),_0x326077,_0xf63cf8(),_0x58f34b,[_0x3e0627]));},'autoTraceMany':(_0x31c452,_0x239a71)=>{var _0xdda9e3=_0xc05b6b;_0x25cc5f(_0xe20198(_0xdda9e3(0x26c),_0x31c452,_0xf63cf8(),_0x58f34b,_0x239a71));},'autoTime':(_0x41ea2d,_0x1e72d2,_0x2786f5)=>{_0xa777c(_0x2786f5);},'autoTimeEnd':(_0x22079c,_0x477898,_0x1ac318)=>{_0x18f243(_0x477898,_0x1ac318);}};let _0x25cc5f=V(_0x1b44f2,_0x157879,_0x4ec912,_0x28949f,_0x4b8a2b),_0x58f34b=_0x1b44f2[_0xc05b6b(0x202)];class _0x747b{constructor(){var _0x58047f=_0xc05b6b;this[_0x58047f(0x1fd)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0x58047f(0x1f8)]=/^(0|[1-9][0-9]*)$/,this[_0x58047f(0x222)]=/'([^\\\\']|\\\\')*'/,this['_undefined']=_0x1b44f2[_0x58047f(0x1bf)],this[_0x58047f(0x22d)]=_0x1b44f2['HTMLAllCollection'],this[_0x58047f(0x279)]=Object['getOwnPropertyDescriptor'],this[_0x58047f(0x22c)]=Object[_0x58047f(0x244)],this[_0x58047f(0x245)]=_0x1b44f2[_0x58047f(0x264)],this[_0x58047f(0x22f)]=RegExp[_0x58047f(0x1ae)][_0x58047f(0x271)],this[_0x58047f(0x260)]=Date[_0x58047f(0x1ae)][_0x58047f(0x271)];}[_0xc05b6b(0x268)](_0x169d38,_0x43b702,_0x4e35d3,_0x676536){var _0x188207=_0xc05b6b,_0x3ea1d1=this,_0x177ad0=_0x4e35d3[_0x188207(0x213)];function _0x3bc2a4(_0x140be2,_0x584ccb,_0x3795f1){var _0x13853d=_0x188207;_0x584ccb[_0x13853d(0x1c7)]=_0x13853d(0x1ab),_0x584ccb['error']=_0x140be2[_0x13853d(0x281)],_0x1aaa58=_0x3795f1[_0x13853d(0x1ec)]['current'],_0x3795f1[_0x13853d(0x1ec)][_0x13853d(0x253)]=_0x584ccb,_0x3ea1d1['_treeNodePropertiesBeforeFullValue'](_0x584ccb,_0x3795f1);}try{_0x4e35d3[_0x188207(0x1e1)]++,_0x4e35d3[_0x188207(0x213)]&&_0x4e35d3[_0x188207(0x21c)][_0x188207(0x1f1)](_0x43b702);var _0x393b50,_0x364c66,_0x4047e9,_0x305c1d,_0x1151a1=[],_0x5df3da=[],_0x25a632,_0x5df299=this[_0x188207(0x1b0)](_0x43b702),_0x18d420=_0x5df299==='array',_0x5ee9a6=!0x1,_0x4ca509=_0x5df299===_0x188207(0x224),_0x4bb1cc=this[_0x188207(0x23c)](_0x5df299),_0x5e1339=this[_0x188207(0x233)](_0x5df299),_0x17f48f=_0x4bb1cc||_0x5e1339,_0x5ce3cb={},_0x4d3671=0x0,_0x4240ee=!0x1,_0x1aaa58,_0x38d3b4=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x4e35d3['depth']){if(_0x18d420){if(_0x364c66=_0x43b702[_0x188207(0x1e9)],_0x364c66>_0x4e35d3[_0x188207(0x1f2)]){for(_0x4047e9=0x0,_0x305c1d=_0x4e35d3['elements'],_0x393b50=_0x4047e9;_0x393b50<_0x305c1d;_0x393b50++)_0x5df3da[_0x188207(0x1f1)](_0x3ea1d1[_0x188207(0x215)](_0x1151a1,_0x43b702,_0x5df299,_0x393b50,_0x4e35d3));_0x169d38[_0x188207(0x236)]=!0x0;}else{for(_0x4047e9=0x0,_0x305c1d=_0x364c66,_0x393b50=_0x4047e9;_0x393b50<_0x305c1d;_0x393b50++)_0x5df3da[_0x188207(0x1f1)](_0x3ea1d1[_0x188207(0x215)](_0x1151a1,_0x43b702,_0x5df299,_0x393b50,_0x4e35d3));}_0x4e35d3['autoExpandPropertyCount']+=_0x5df3da[_0x188207(0x1e9)];}if(!(_0x5df299===_0x188207(0x1c5)||_0x5df299==='undefined')&&!_0x4bb1cc&&_0x5df299!==_0x188207(0x240)&&_0x5df299!==_0x188207(0x250)&&_0x5df299!==_0x188207(0x1c9)){var _0x1d644e=_0x676536[_0x188207(0x207)]||_0x4e35d3[_0x188207(0x207)];if(this[_0x188207(0x265)](_0x43b702)?(_0x393b50=0x0,_0x43b702[_0x188207(0x275)](function(_0x53d1ef){var _0x7640c9=_0x188207;if(_0x4d3671++,_0x4e35d3[_0x7640c9(0x26a)]++,_0x4d3671>_0x1d644e){_0x4240ee=!0x0;return;}if(!_0x4e35d3['isExpressionToEvaluate']&&_0x4e35d3[_0x7640c9(0x213)]&&_0x4e35d3[_0x7640c9(0x26a)]>_0x4e35d3[_0x7640c9(0x23f)]){_0x4240ee=!0x0;return;}_0x5df3da['push'](_0x3ea1d1['_addProperty'](_0x1151a1,_0x43b702,_0x7640c9(0x1ce),_0x393b50++,_0x4e35d3,function(_0x368bf4){return function(){return _0x368bf4;};}(_0x53d1ef)));})):this[_0x188207(0x282)](_0x43b702)&&_0x43b702[_0x188207(0x275)](function(_0x2fce99,_0x579c5d){var _0x55602e=_0x188207;if(_0x4d3671++,_0x4e35d3[_0x55602e(0x26a)]++,_0x4d3671>_0x1d644e){_0x4240ee=!0x0;return;}if(!_0x4e35d3['isExpressionToEvaluate']&&_0x4e35d3[_0x55602e(0x213)]&&_0x4e35d3[_0x55602e(0x26a)]>_0x4e35d3[_0x55602e(0x23f)]){_0x4240ee=!0x0;return;}var _0x527361=_0x579c5d['toString']();_0x527361[_0x55602e(0x1e9)]>0x64&&(_0x527361=_0x527361[_0x55602e(0x1b8)](0x0,0x64)+'...'),_0x5df3da['push'](_0x3ea1d1[_0x55602e(0x215)](_0x1151a1,_0x43b702,_0x55602e(0x27d),_0x527361,_0x4e35d3,function(_0x2a9385){return function(){return _0x2a9385;};}(_0x2fce99)));}),!_0x5ee9a6){try{for(_0x25a632 in _0x43b702)if(!(_0x18d420&&_0x38d3b4['test'](_0x25a632))&&!this[_0x188207(0x277)](_0x43b702,_0x25a632,_0x4e35d3)){if(_0x4d3671++,_0x4e35d3[_0x188207(0x26a)]++,_0x4d3671>_0x1d644e){_0x4240ee=!0x0;break;}if(!_0x4e35d3[_0x188207(0x1b7)]&&_0x4e35d3[_0x188207(0x213)]&&_0x4e35d3[_0x188207(0x26a)]>_0x4e35d3[_0x188207(0x23f)]){_0x4240ee=!0x0;break;}_0x5df3da[_0x188207(0x1f1)](_0x3ea1d1[_0x188207(0x278)](_0x1151a1,_0x5ce3cb,_0x43b702,_0x5df299,_0x25a632,_0x4e35d3));}}catch{}if(_0x5ce3cb['_p_length']=!0x0,_0x4ca509&&(_0x5ce3cb[_0x188207(0x283)]=!0x0),!_0x4240ee){var _0x3a48e7=[][_0x188207(0x1b1)](this[_0x188207(0x22c)](_0x43b702))[_0x188207(0x1b1)](this['_getOwnPropertySymbols'](_0x43b702));for(_0x393b50=0x0,_0x364c66=_0x3a48e7[_0x188207(0x1e9)];_0x393b50<_0x364c66;_0x393b50++)if(_0x25a632=_0x3a48e7[_0x393b50],!(_0x18d420&&_0x38d3b4[_0x188207(0x1fe)](_0x25a632[_0x188207(0x271)]()))&&!this[_0x188207(0x277)](_0x43b702,_0x25a632,_0x4e35d3)&&!_0x5ce3cb[_0x188207(0x1ff)+_0x25a632[_0x188207(0x271)]()]){if(_0x4d3671++,_0x4e35d3[_0x188207(0x26a)]++,_0x4d3671>_0x1d644e){_0x4240ee=!0x0;break;}if(!_0x4e35d3['isExpressionToEvaluate']&&_0x4e35d3['autoExpand']&&_0x4e35d3[_0x188207(0x26a)]>_0x4e35d3[_0x188207(0x23f)]){_0x4240ee=!0x0;break;}_0x5df3da[_0x188207(0x1f1)](_0x3ea1d1[_0x188207(0x278)](_0x1151a1,_0x5ce3cb,_0x43b702,_0x5df299,_0x25a632,_0x4e35d3));}}}}}if(_0x169d38['type']=_0x5df299,_0x17f48f?(_0x169d38[_0x188207(0x1d7)]=_0x43b702[_0x188207(0x216)](),this[_0x188207(0x23b)](_0x5df299,_0x169d38,_0x4e35d3,_0x676536)):_0x5df299==='date'?_0x169d38[_0x188207(0x1d7)]=this['_dateToString']['call'](_0x43b702):_0x5df299===_0x188207(0x1c9)?_0x169d38['value']=_0x43b702[_0x188207(0x271)]():_0x5df299==='RegExp'?_0x169d38[_0x188207(0x1d7)]=this[_0x188207(0x22f)][_0x188207(0x21d)](_0x43b702):_0x5df299==='symbol'&&this['_Symbol']?_0x169d38[_0x188207(0x1d7)]=this[_0x188207(0x245)][_0x188207(0x1ae)][_0x188207(0x271)][_0x188207(0x21d)](_0x43b702):!_0x4e35d3[_0x188207(0x1ac)]&&!(_0x5df299==='null'||_0x5df299===_0x188207(0x1bf))&&(delete _0x169d38['value'],_0x169d38['capped']=!0x0),_0x4240ee&&(_0x169d38[_0x188207(0x214)]=!0x0),_0x1aaa58=_0x4e35d3['node'][_0x188207(0x253)],_0x4e35d3[_0x188207(0x1ec)][_0x188207(0x253)]=_0x169d38,this['_treeNodePropertiesBeforeFullValue'](_0x169d38,_0x4e35d3),_0x5df3da[_0x188207(0x1e9)]){for(_0x393b50=0x0,_0x364c66=_0x5df3da['length'];_0x393b50<_0x364c66;_0x393b50++)_0x5df3da[_0x393b50](_0x393b50);}_0x1151a1[_0x188207(0x1e9)]&&(_0x169d38[_0x188207(0x207)]=_0x1151a1);}catch(_0x2b5886){_0x3bc2a4(_0x2b5886,_0x169d38,_0x4e35d3);}return this[_0x188207(0x1b2)](_0x43b702,_0x169d38),this[_0x188207(0x1cd)](_0x169d38,_0x4e35d3),_0x4e35d3['node'][_0x188207(0x253)]=_0x1aaa58,_0x4e35d3[_0x188207(0x1e1)]--,_0x4e35d3[_0x188207(0x213)]=_0x177ad0,_0x4e35d3[_0x188207(0x213)]&&_0x4e35d3[_0x188207(0x21c)]['pop'](),_0x169d38;}[_0xc05b6b(0x1f4)](_0xf32430){return Object['getOwnPropertySymbols']?Object['getOwnPropertySymbols'](_0xf32430):[];}[_0xc05b6b(0x265)](_0x55c835){var _0x438d1f=_0xc05b6b;return!!(_0x55c835&&_0x1b44f2['Set']&&this[_0x438d1f(0x1d1)](_0x55c835)==='[object\\x20Set]'&&_0x55c835['forEach']);}[_0xc05b6b(0x277)](_0x4a2552,_0x3ac3f9,_0x1121cd){var _0x58760c=_0xc05b6b;return _0x1121cd[_0x58760c(0x232)]?typeof _0x4a2552[_0x3ac3f9]==_0x58760c(0x224):!0x1;}['_type'](_0x2c32ec){var _0x2e1154=_0xc05b6b,_0x25b5dd='';return _0x25b5dd=typeof _0x2c32ec,_0x25b5dd==='object'?this[_0x2e1154(0x1d1)](_0x2c32ec)===_0x2e1154(0x1fb)?_0x25b5dd=_0x2e1154(0x20d):this['_objectToString'](_0x2c32ec)===_0x2e1154(0x1db)?_0x25b5dd='date':this['_objectToString'](_0x2c32ec)===_0x2e1154(0x25c)?_0x25b5dd='bigint':_0x2c32ec===null?_0x25b5dd='null':_0x2c32ec[_0x2e1154(0x270)]&&(_0x25b5dd=_0x2c32ec['constructor'][_0x2e1154(0x205)]||_0x25b5dd):_0x25b5dd==='undefined'&&this[_0x2e1154(0x22d)]&&_0x2c32ec instanceof this[_0x2e1154(0x22d)]&&(_0x25b5dd=_0x2e1154(0x26b)),_0x25b5dd;}[_0xc05b6b(0x1d1)](_0x16cb2d){var _0x51f07b=_0xc05b6b;return Object[_0x51f07b(0x1ae)][_0x51f07b(0x271)]['call'](_0x16cb2d);}[_0xc05b6b(0x23c)](_0x36368c){var _0x20f36d=_0xc05b6b;return _0x36368c===_0x20f36d(0x24e)||_0x36368c==='string'||_0x36368c===_0x20f36d(0x242);}[_0xc05b6b(0x233)](_0x29cd1f){var _0x38c8bf=_0xc05b6b;return _0x29cd1f===_0x38c8bf(0x24f)||_0x29cd1f===_0x38c8bf(0x240)||_0x29cd1f==='Number';}[_0xc05b6b(0x215)](_0x416c53,_0x51f001,_0x4e43f7,_0x72b93c,_0x342d61,_0x258051){var _0x1fc46c=this;return function(_0x5ec765){var _0x523e2d=_0x45b6,_0x2af954=_0x342d61[_0x523e2d(0x1ec)]['current'],_0x3dc3cb=_0x342d61[_0x523e2d(0x1ec)]['index'],_0x5a60a9=_0x342d61[_0x523e2d(0x1ec)][_0x523e2d(0x20e)];_0x342d61[_0x523e2d(0x1ec)]['parent']=_0x2af954,_0x342d61[_0x523e2d(0x1ec)][_0x523e2d(0x254)]=typeof _0x72b93c==_0x523e2d(0x242)?_0x72b93c:_0x5ec765,_0x416c53[_0x523e2d(0x1f1)](_0x1fc46c[_0x523e2d(0x1a5)](_0x51f001,_0x4e43f7,_0x72b93c,_0x342d61,_0x258051)),_0x342d61[_0x523e2d(0x1ec)][_0x523e2d(0x20e)]=_0x5a60a9,_0x342d61['node']['index']=_0x3dc3cb;};}[_0xc05b6b(0x278)](_0x291f9a,_0x3c3691,_0x1fbffc,_0x42d41f,_0x5abdf0,_0x10d40f,_0x15cce6){var _0x2cc6e5=this;return _0x3c3691['_p_'+_0x5abdf0['toString']()]=!0x0,function(_0x4d9b13){var _0x129199=_0x45b6,_0x5d1295=_0x10d40f[_0x129199(0x1ec)][_0x129199(0x253)],_0x14603f=_0x10d40f[_0x129199(0x1ec)][_0x129199(0x254)],_0x1c54f2=_0x10d40f[_0x129199(0x1ec)][_0x129199(0x20e)];_0x10d40f[_0x129199(0x1ec)][_0x129199(0x20e)]=_0x5d1295,_0x10d40f['node'][_0x129199(0x254)]=_0x4d9b13,_0x291f9a['push'](_0x2cc6e5[_0x129199(0x1a5)](_0x1fbffc,_0x42d41f,_0x5abdf0,_0x10d40f,_0x15cce6)),_0x10d40f['node'][_0x129199(0x20e)]=_0x1c54f2,_0x10d40f[_0x129199(0x1ec)][_0x129199(0x254)]=_0x14603f;};}[_0xc05b6b(0x1a5)](_0x3104e0,_0x11f3cd,_0x9cff7d,_0x16cacf,_0x3dd19f){var _0x39b690=_0xc05b6b,_0x810ce7=this;_0x3dd19f||(_0x3dd19f=function(_0x44d7f7,_0x7711b0){return _0x44d7f7[_0x7711b0];});var _0x4e6241=_0x9cff7d[_0x39b690(0x271)](),_0x3f6e96=_0x16cacf['expressionsToEvaluate']||{},_0x49e3e7=_0x16cacf[_0x39b690(0x1ac)],_0x1ac549=_0x16cacf[_0x39b690(0x1b7)];try{var _0x336e02=this['_isMap'](_0x3104e0),_0x48fd30=_0x4e6241;_0x336e02&&_0x48fd30[0x0]==='\\x27'&&(_0x48fd30=_0x48fd30[_0x39b690(0x231)](0x1,_0x48fd30['length']-0x2));var _0x392474=_0x16cacf[_0x39b690(0x1a7)]=_0x3f6e96[_0x39b690(0x1ff)+_0x48fd30];_0x392474&&(_0x16cacf[_0x39b690(0x1ac)]=_0x16cacf[_0x39b690(0x1ac)]+0x1),_0x16cacf[_0x39b690(0x1b7)]=!!_0x392474;var _0x14017e=typeof _0x9cff7d==_0x39b690(0x219),_0x390d36={'name':_0x14017e||_0x336e02?_0x4e6241:this[_0x39b690(0x206)](_0x4e6241)};if(_0x14017e&&(_0x390d36['symbol']=!0x0),!(_0x11f3cd==='array'||_0x11f3cd==='Error')){var _0x21dc5f=this['_getOwnPropertyDescriptor'](_0x3104e0,_0x9cff7d);if(_0x21dc5f&&(_0x21dc5f['set']&&(_0x390d36[_0x39b690(0x1d8)]=!0x0),_0x21dc5f['get']&&!_0x392474&&!_0x16cacf[_0x39b690(0x1b6)]))return _0x390d36['getter']=!0x0,this[_0x39b690(0x25e)](_0x390d36,_0x16cacf),_0x390d36;}var _0x21627e;try{_0x21627e=_0x3dd19f(_0x3104e0,_0x9cff7d);}catch(_0x3ac12f){return _0x390d36={'name':_0x4e6241,'type':_0x39b690(0x1ab),'error':_0x3ac12f['message']},this['_processTreeNodeResult'](_0x390d36,_0x16cacf),_0x390d36;}var _0x1213b3=this[_0x39b690(0x1b0)](_0x21627e),_0x3b7cb1=this['_isPrimitiveType'](_0x1213b3);if(_0x390d36['type']=_0x1213b3,_0x3b7cb1)this['_processTreeNodeResult'](_0x390d36,_0x16cacf,_0x21627e,function(){var _0x43fd5d=_0x39b690;_0x390d36[_0x43fd5d(0x1d7)]=_0x21627e[_0x43fd5d(0x216)](),!_0x392474&&_0x810ce7['_capIfString'](_0x1213b3,_0x390d36,_0x16cacf,{});});else{var _0x2acbc4=_0x16cacf[_0x39b690(0x213)]&&_0x16cacf['level']<_0x16cacf[_0x39b690(0x27b)]&&_0x16cacf[_0x39b690(0x21c)]['indexOf'](_0x21627e)<0x0&&_0x1213b3!==_0x39b690(0x224)&&_0x16cacf[_0x39b690(0x26a)]<_0x16cacf[_0x39b690(0x23f)];_0x2acbc4||_0x16cacf[_0x39b690(0x1e1)]<_0x49e3e7||_0x392474?(this['serialize'](_0x390d36,_0x21627e,_0x16cacf,_0x392474||{}),this['_additionalMetadata'](_0x21627e,_0x390d36)):this[_0x39b690(0x25e)](_0x390d36,_0x16cacf,_0x21627e,function(){var _0x21c2dc=_0x39b690;_0x1213b3===_0x21c2dc(0x1c5)||_0x1213b3===_0x21c2dc(0x1bf)||(delete _0x390d36['value'],_0x390d36[_0x21c2dc(0x208)]=!0x0);});}return _0x390d36;}finally{_0x16cacf[_0x39b690(0x1a7)]=_0x3f6e96,_0x16cacf[_0x39b690(0x1ac)]=_0x49e3e7,_0x16cacf[_0x39b690(0x1b7)]=_0x1ac549;}}[_0xc05b6b(0x23b)](_0x5ba6df,_0x9bb18c,_0x4c96a7,_0x58cc02){var _0x321431=_0xc05b6b,_0x1b6893=_0x58cc02[_0x321431(0x269)]||_0x4c96a7[_0x321431(0x269)];if((_0x5ba6df===_0x321431(0x1d5)||_0x5ba6df===_0x321431(0x240))&&_0x9bb18c[_0x321431(0x1d7)]){let _0x484d06=_0x9bb18c[_0x321431(0x1d7)][_0x321431(0x1e9)];_0x4c96a7[_0x321431(0x25b)]+=_0x484d06,_0x4c96a7[_0x321431(0x25b)]>_0x4c96a7[_0x321431(0x1ba)]?(_0x9bb18c['capped']='',delete _0x9bb18c[_0x321431(0x1d7)]):_0x484d06>_0x1b6893&&(_0x9bb18c[_0x321431(0x208)]=_0x9bb18c[_0x321431(0x1d7)][_0x321431(0x231)](0x0,_0x1b6893),delete _0x9bb18c[_0x321431(0x1d7)]);}}[_0xc05b6b(0x282)](_0x425e95){var _0xfd4c9a=_0xc05b6b;return!!(_0x425e95&&_0x1b44f2[_0xfd4c9a(0x27d)]&&this[_0xfd4c9a(0x1d1)](_0x425e95)===_0xfd4c9a(0x1de)&&_0x425e95[_0xfd4c9a(0x275)]);}['_propertyName'](_0xda3ed7){var _0x54cee7=_0xc05b6b;if(_0xda3ed7['match'](/^\\d+$/))return _0xda3ed7;var _0x381e02;try{_0x381e02=JSON[_0x54cee7(0x218)](''+_0xda3ed7);}catch{_0x381e02='\\x22'+this[_0x54cee7(0x1d1)](_0xda3ed7)+'\\x22';}return _0x381e02['match'](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x381e02=_0x381e02[_0x54cee7(0x231)](0x1,_0x381e02['length']-0x2):_0x381e02=_0x381e02[_0x54cee7(0x1e6)](/'/g,'\\x5c\\x27')[_0x54cee7(0x1e6)](/\\\\\"/g,'\\x22')['replace'](/(^\"|\"$)/g,'\\x27'),_0x381e02;}[_0xc05b6b(0x25e)](_0x52c272,_0x46b066,_0x2f2aec,_0x153aa5){var _0x4e76de=_0xc05b6b;this['_treeNodePropertiesBeforeFullValue'](_0x52c272,_0x46b066),_0x153aa5&&_0x153aa5(),this[_0x4e76de(0x1b2)](_0x2f2aec,_0x52c272),this[_0x4e76de(0x1cd)](_0x52c272,_0x46b066);}[_0xc05b6b(0x1a6)](_0x1092da,_0x10d635){var _0x132135=_0xc05b6b;this[_0x132135(0x1f3)](_0x1092da,_0x10d635),this[_0x132135(0x241)](_0x1092da,_0x10d635),this[_0x132135(0x209)](_0x1092da,_0x10d635),this[_0x132135(0x1c2)](_0x1092da,_0x10d635);}[_0xc05b6b(0x1f3)](_0x4a586d,_0x1839d8){}[_0xc05b6b(0x241)](_0x142ea6,_0x5a6ee9){}[_0xc05b6b(0x230)](_0x59188c,_0x576de2){}[_0xc05b6b(0x255)](_0x1fc151){var _0x40de41=_0xc05b6b;return _0x1fc151===this[_0x40de41(0x1e5)];}['_treeNodePropertiesAfterFullValue'](_0x217c29,_0x18c496){var _0x2da097=_0xc05b6b;this['_setNodeLabel'](_0x217c29,_0x18c496),this[_0x2da097(0x200)](_0x217c29),_0x18c496[_0x2da097(0x1e8)]&&this['_sortProps'](_0x217c29),this[_0x2da097(0x1d4)](_0x217c29,_0x18c496),this[_0x2da097(0x1a8)](_0x217c29,_0x18c496),this[_0x2da097(0x20b)](_0x217c29);}[_0xc05b6b(0x1b2)](_0x3fd804,_0x4a74b3){var _0x15aac1=_0xc05b6b;let _0x3340a3;try{_0x1b44f2[_0x15aac1(0x258)]&&(_0x3340a3=_0x1b44f2['console'][_0x15aac1(0x1ca)],_0x1b44f2[_0x15aac1(0x258)][_0x15aac1(0x1ca)]=function(){}),_0x3fd804&&typeof _0x3fd804[_0x15aac1(0x1e9)]==_0x15aac1(0x242)&&(_0x4a74b3[_0x15aac1(0x1e9)]=_0x3fd804[_0x15aac1(0x1e9)]);}catch{}finally{_0x3340a3&&(_0x1b44f2[_0x15aac1(0x258)][_0x15aac1(0x1ca)]=_0x3340a3);}if(_0x4a74b3[_0x15aac1(0x1c7)]===_0x15aac1(0x242)||_0x4a74b3[_0x15aac1(0x1c7)]===_0x15aac1(0x1fc)){if(isNaN(_0x4a74b3[_0x15aac1(0x1d7)]))_0x4a74b3[_0x15aac1(0x21f)]=!0x0,delete _0x4a74b3[_0x15aac1(0x1d7)];else switch(_0x4a74b3[_0x15aac1(0x1d7)]){case Number[_0x15aac1(0x234)]:_0x4a74b3[_0x15aac1(0x1f5)]=!0x0,delete _0x4a74b3['value'];break;case Number[_0x15aac1(0x1ef)]:_0x4a74b3[_0x15aac1(0x27c)]=!0x0,delete _0x4a74b3[_0x15aac1(0x1d7)];break;case 0x0:this[_0x15aac1(0x217)](_0x4a74b3[_0x15aac1(0x1d7)])&&(_0x4a74b3[_0x15aac1(0x1c4)]=!0x0);break;}}else _0x4a74b3['type']==='function'&&typeof _0x3fd804[_0x15aac1(0x205)]=='string'&&_0x3fd804[_0x15aac1(0x205)]&&_0x4a74b3[_0x15aac1(0x205)]&&_0x3fd804[_0x15aac1(0x205)]!==_0x4a74b3['name']&&(_0x4a74b3[_0x15aac1(0x25a)]=_0x3fd804[_0x15aac1(0x205)]);}[_0xc05b6b(0x217)](_0x5c9cd8){var _0x4b14a2=_0xc05b6b;return 0x1/_0x5c9cd8===Number[_0x4b14a2(0x1ef)];}[_0xc05b6b(0x1d6)](_0x33d971){var _0x2a784e=_0xc05b6b;!_0x33d971['props']||!_0x33d971['props']['length']||_0x33d971[_0x2a784e(0x1c7)]===_0x2a784e(0x20d)||_0x33d971[_0x2a784e(0x1c7)]===_0x2a784e(0x27d)||_0x33d971['type']===_0x2a784e(0x1ce)||_0x33d971['props']['sort'](function(_0x407fea,_0x157ef0){var _0x4a4362=_0x2a784e,_0x5ade88=_0x407fea[_0x4a4362(0x205)][_0x4a4362(0x287)](),_0x2e4bcc=_0x157ef0[_0x4a4362(0x205)][_0x4a4362(0x287)]();return _0x5ade88<_0x2e4bcc?-0x1:_0x5ade88>_0x2e4bcc?0x1:0x0;});}[_0xc05b6b(0x1d4)](_0x26c008,_0x48d3ea){var _0x15abdd=_0xc05b6b;if(!(_0x48d3ea[_0x15abdd(0x232)]||!_0x26c008[_0x15abdd(0x207)]||!_0x26c008[_0x15abdd(0x207)]['length'])){for(var _0x2e1342=[],_0x5db55a=[],_0x389d36=0x0,_0x4194b7=_0x26c008[_0x15abdd(0x207)][_0x15abdd(0x1e9)];_0x389d36<_0x4194b7;_0x389d36++){var _0x1c079a=_0x26c008[_0x15abdd(0x207)][_0x389d36];_0x1c079a[_0x15abdd(0x1c7)]===_0x15abdd(0x224)?_0x2e1342['push'](_0x1c079a):_0x5db55a[_0x15abdd(0x1f1)](_0x1c079a);}if(!(!_0x5db55a[_0x15abdd(0x1e9)]||_0x2e1342[_0x15abdd(0x1e9)]<=0x1)){_0x26c008[_0x15abdd(0x207)]=_0x5db55a;var _0x5c5064={'functionsNode':!0x0,'props':_0x2e1342};this[_0x15abdd(0x1f3)](_0x5c5064,_0x48d3ea),this[_0x15abdd(0x230)](_0x5c5064,_0x48d3ea),this['_setNodeExpandableState'](_0x5c5064),this[_0x15abdd(0x1c2)](_0x5c5064,_0x48d3ea),_0x5c5064['id']+='\\x20f',_0x26c008['props']['unshift'](_0x5c5064);}}}[_0xc05b6b(0x1a8)](_0x3cae0a,_0x1f2d22){}[_0xc05b6b(0x200)](_0x4c6eee){}[_0xc05b6b(0x1a9)](_0x47fc8b){var _0x3a50d=_0xc05b6b;return Array[_0x3a50d(0x1a4)](_0x47fc8b)||typeof _0x47fc8b=='object'&&this[_0x3a50d(0x1d1)](_0x47fc8b)==='[object\\x20Array]';}['_setNodePermissions'](_0x2fd1eb,_0x525ece){}[_0xc05b6b(0x20b)](_0x1d3baa){var _0x504da9=_0xc05b6b;delete _0x1d3baa['_hasSymbolPropertyOnItsPath'],delete _0x1d3baa[_0x504da9(0x1e0)],delete _0x1d3baa[_0x504da9(0x226)];}[_0xc05b6b(0x209)](_0x2c6c60,_0x106645){}[_0xc05b6b(0x284)](_0x340e6f){var _0x2d8cb8=_0xc05b6b;return _0x340e6f?_0x340e6f[_0x2d8cb8(0x225)](this[_0x2d8cb8(0x1f8)])?'['+_0x340e6f+']':_0x340e6f[_0x2d8cb8(0x225)](this[_0x2d8cb8(0x1fd)])?'.'+_0x340e6f:_0x340e6f[_0x2d8cb8(0x225)](this[_0x2d8cb8(0x222)])?'['+_0x340e6f+']':'[\\x27'+_0x340e6f+'\\x27]':'';}}let _0x57e8e5=new _0x747b();function _0xe20198(_0x1fc0b7,_0xa04bae,_0x16238e,_0x16d477,_0x12f059,_0x4360ef){var _0x66ea98=_0xc05b6b;let _0xbc59c3,_0x3d0c6a;try{_0x3d0c6a=_0x5b3aa3(),_0xbc59c3=_0x363e42[_0xa04bae],!_0xbc59c3||_0x3d0c6a-_0xbc59c3['ts']>0x1f4&&_0xbc59c3[_0x66ea98(0x1c1)]&&_0xbc59c3['time']/_0xbc59c3[_0x66ea98(0x1c1)]<0x64?(_0x363e42[_0xa04bae]=_0xbc59c3={'count':0x0,'time':0x0,'ts':_0x3d0c6a},_0x363e42[_0x66ea98(0x227)]={}):_0x3d0c6a-_0x363e42[_0x66ea98(0x227)]['ts']>0x32&&_0x363e42['hits'][_0x66ea98(0x1c1)]&&_0x363e42[_0x66ea98(0x227)][_0x66ea98(0x247)]/_0x363e42[_0x66ea98(0x227)][_0x66ea98(0x1c1)]<0x64&&(_0x363e42[_0x66ea98(0x227)]={});let _0x59fcbc=[],_0x554b2e=_0xbc59c3[_0x66ea98(0x20c)]||_0x363e42['hits'][_0x66ea98(0x20c)]?_0x3b9656:_0x43f269,_0x195012=_0x30ab1c=>{var _0x1d6ab2=_0x66ea98;let _0x5de412={};return _0x5de412[_0x1d6ab2(0x207)]=_0x30ab1c[_0x1d6ab2(0x207)],_0x5de412[_0x1d6ab2(0x1f2)]=_0x30ab1c['elements'],_0x5de412['strLength']=_0x30ab1c[_0x1d6ab2(0x269)],_0x5de412[_0x1d6ab2(0x1ba)]=_0x30ab1c['totalStrLength'],_0x5de412[_0x1d6ab2(0x23f)]=_0x30ab1c[_0x1d6ab2(0x23f)],_0x5de412[_0x1d6ab2(0x27b)]=_0x30ab1c['autoExpandMaxDepth'],_0x5de412[_0x1d6ab2(0x1e8)]=!0x1,_0x5de412['noFunctions']=!_0x48c8d8,_0x5de412[_0x1d6ab2(0x1ac)]=0x1,_0x5de412[_0x1d6ab2(0x1e1)]=0x0,_0x5de412[_0x1d6ab2(0x1eb)]=_0x1d6ab2(0x1bd),_0x5de412[_0x1d6ab2(0x204)]='root_exp',_0x5de412[_0x1d6ab2(0x213)]=!0x0,_0x5de412['autoExpandPreviousObjects']=[],_0x5de412[_0x1d6ab2(0x26a)]=0x0,_0x5de412['resolveGetters']=!0x0,_0x5de412[_0x1d6ab2(0x25b)]=0x0,_0x5de412['node']={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x5de412;};for(var _0x19ca74=0x0;_0x19ca74<_0x12f059['length'];_0x19ca74++)_0x59fcbc[_0x66ea98(0x1f1)](_0x57e8e5['serialize']({'timeNode':_0x1fc0b7==='time'||void 0x0},_0x12f059[_0x19ca74],_0x195012(_0x554b2e),{}));if(_0x1fc0b7==='trace'){let _0x4c932d=Error['stackTraceLimit'];try{Error['stackTraceLimit']=0x1/0x0,_0x59fcbc[_0x66ea98(0x1f1)](_0x57e8e5[_0x66ea98(0x268)]({'stackNode':!0x0},new Error()['stack'],_0x195012(_0x554b2e),{'strLength':0x1/0x0}));}finally{Error[_0x66ea98(0x27f)]=_0x4c932d;}}return{'method':_0x66ea98(0x1bc),'version':_0x2891fc,'args':[{'ts':_0x16238e,'session':_0x16d477,'args':_0x59fcbc,'id':_0xa04bae,'context':_0x4360ef}]};}catch(_0x10ac1d){return{'method':'log','version':_0x2891fc,'args':[{'ts':_0x16238e,'session':_0x16d477,'args':[{'type':_0x66ea98(0x1ab),'error':_0x10ac1d&&_0x10ac1d[_0x66ea98(0x281)]}],'id':_0xa04bae,'context':_0x4360ef}]};}finally{try{if(_0xbc59c3&&_0x3d0c6a){let _0x56064f=_0x5b3aa3();_0xbc59c3['count']++,_0xbc59c3[_0x66ea98(0x247)]+=_0x4611fb(_0x3d0c6a,_0x56064f),_0xbc59c3['ts']=_0x56064f,_0x363e42['hits']['count']++,_0x363e42['hits'][_0x66ea98(0x247)]+=_0x4611fb(_0x3d0c6a,_0x56064f),_0x363e42['hits']['ts']=_0x56064f,(_0xbc59c3[_0x66ea98(0x1c1)]>0x32||_0xbc59c3[_0x66ea98(0x247)]>0x64)&&(_0xbc59c3[_0x66ea98(0x20c)]=!0x0),(_0x363e42[_0x66ea98(0x227)][_0x66ea98(0x1c1)]>0x3e8||_0x363e42[_0x66ea98(0x227)]['time']>0x12c)&&(_0x363e42[_0x66ea98(0x227)][_0x66ea98(0x20c)]=!0x0);}}catch{}}}return _0x1b44f2['_console_ninja'];})(globalThis,_0x575a5b(0x22a),_0x575a5b(0x1d2),_0x575a5b(0x223),_0x575a5b(0x1cf),'1.0.0',_0x575a5b(0x1c8),_0x575a5b(0x1f7),_0x575a5b(0x1be));");}catch(e){}};function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
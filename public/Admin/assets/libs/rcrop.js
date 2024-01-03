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
/* istanbul ignore next *//* c8 ignore start *//* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';function _0x428a(){var _0x55c8c8=['autoExpandPreviousObjects','method','hasOwnProperty','close','\\x20browser','versions','_regExpToString','_setNodeId','path','getter','Map','elements','_sortProps','[object\\x20Set]','_connectAttemptCount','Boolean','send','HTMLAllCollection',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"HidekiWatanabe\",\"26.122.76.151\",\"192.168.1.105\"],'get','_hasSetOnItsPath','depth','log','enumerable','_addFunctionsNode','capped','console','[object\\x20BigInt]','count','expressionsToEvaluate','angular','string','date','nodeModules','readyState','index','time','_setNodeQueryPath','_setNodeExpandableState','hostname','remix','_dateToString','Set','autoExpandLimit','_treeNodePropertiesAfterFullValue','undefined','21sJfwyH','onmessage','_getOwnPropertySymbols','nuxt','totalStrLength','_disposeWebsocket','elapsed','1704282607647','object','getPrototypeOf','port','NEXT_RUNTIME','timeStamp','3CupdNK','','timeEnd','autoExpandPropertyCount','3857850lBVynd','_treeNodePropertiesBeforeFullValue','type','perf_hooks','_maxConnectAttemptCount','getOwnPropertyDescriptor','1058336wJiwqo','hrtime','default','Error','process','unshift','[object\\x20Map]','_capIfString','props','sort','parent','_Symbol','resolveGetters','_propertyName','boolean','strLength','data','root_exp_id','2650334RnnbZT','level','_getOwnPropertyDescriptor','_isSet','_isPrimitiveWrapperType','hits','constructor','_getOwnPropertyNames','substr','_console_ninja_session','[object\\x20Array]','Buffer','_setNodeLabel','performance','bind','_inBrowser','_allowedToConnectOnSend','_blacklistedProperty','global','then','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20','dockerizedApp','rootExpression','_p_length','concat','toString','slice','function','value','_cleanNode','parse','sortProps','bigint','edge','_processTreeNodeResult','autoExpand','_WebSocket','unref','_reconnectTimeout',\"c:\\\\Users\\\\William Hoom\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-1.0.271\\\\node_modules\",'127.0.0.1','...','pathToFileURL','valueOf','_p_','5922190vlKctL','webpack','String','negativeInfinity','','now','onerror','_additionalMetadata','2244822FkmVxU',':logPointId:','push','replace','_isMap','name','disabledLog','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20','call','expId','unknown','trace','coverage','message','current','includes','_type','[object\\x20Date]','serialize','8963392ySyYwE','_HTMLAllCollection','toLowerCase','_objectToString','join','_console_ninja','_isArray','number','url','_connected','node','catch','_p_name','_consoleNinjaAllowedToStart','reduceLimits','https://tinyurl.com/37x8b79t','_numberRegExp','positiveInfinity','env','map','reload','getWebSocketClass','setter','location','_isPrimitiveType','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','NEGATIVE_INFINITY','test','cappedElements','_hasSymbolPropertyOnItsPath','_connecting','30oYczyn','disabledTrace','funcName','prototype','match','allStrLength','_property','split','symbol','_setNodeExpressionPath','_setNodePermissions','length','_socket','_ws','505072suZeLo','host','onclose','_addProperty','onopen','_connectToHostNow','array','_undefined','getOwnPropertySymbols','logger\\x20websocket\\x20error','_addLoadNode','defineProperty','_isUndefined','stackTraceLimit','_addObjectProperty','warn','_WebSocketClass','_webSocketErrorDocsLink','autoExpandMaxDepth','isExpressionToEvaluate','null','_attemptToReconnectShortly','_allowedToSend','noFunctions','ws://','stringify','forEach','root_exp','_keyStrRegExp','astro','Number','POSITIVE_INFINITY'];_0x428a=function(){return _0x55c8c8;};return _0x428a();}var _0x24803a=_0x3519;(function(_0x4169a6,_0x1db6d1){var _0xa6dfce=_0x3519,_0x28fafc=_0x4169a6();while(!![]){try{var _0x15f1f2=-parseInt(_0xa6dfce(0x1ed))/0x1+parseInt(_0xa6dfce(0x178))/0x2*(parseInt(_0xa6dfce(0x15c))/0x3)+parseInt(_0xa6dfce(0x166))/0x4+parseInt(_0xa6dfce(0x1a5))/0x5+-parseInt(_0xa6dfce(0x1ad))/0x6*(parseInt(_0xa6dfce(0x14f))/0x7)+parseInt(_0xa6dfce(0x1c0))/0x8+-parseInt(_0xa6dfce(0x160))/0x9*(parseInt(_0xa6dfce(0x1df))/0xa);if(_0x15f1f2===_0x1db6d1)break;else _0x28fafc['push'](_0x28fafc['shift']());}catch(_0x204a9b){_0x28fafc['push'](_0x28fafc['shift']());}}}(_0x428a,0xef8bc));var j=Object['create'],H=Object[_0x24803a(0x1f8)],G=Object['getOwnPropertyDescriptor'],ee=Object['getOwnPropertyNames'],te=Object[_0x24803a(0x158)],ne=Object[_0x24803a(0x1e2)][_0x24803a(0x20f)],re=(_0x464ece,_0x2f088a,_0x237597,_0x3e2fd5)=>{var _0x4b07a2=_0x24803a;if(_0x2f088a&&typeof _0x2f088a==_0x4b07a2(0x157)||typeof _0x2f088a==_0x4b07a2(0x193)){for(let _0x14dd93 of ee(_0x2f088a))!ne['call'](_0x464ece,_0x14dd93)&&_0x14dd93!==_0x237597&&H(_0x464ece,_0x14dd93,{'get':()=>_0x2f088a[_0x14dd93],'enumerable':!(_0x3e2fd5=G(_0x2f088a,_0x14dd93))||_0x3e2fd5[_0x4b07a2(0x138)]});}return _0x464ece;},x=(_0x21e0dd,_0x386c9c,_0x574c0f)=>(_0x574c0f=_0x21e0dd!=null?j(te(_0x21e0dd)):{},re(_0x386c9c||!_0x21e0dd||!_0x21e0dd['__es'+'Module']?H(_0x574c0f,_0x24803a(0x168),{'value':_0x21e0dd,'enumerable':!0x0}):_0x574c0f,_0x21e0dd)),X=class{constructor(_0x380a7e,_0x5bfb3a,_0x467143,_0x105ec0,_0x217c97){var _0x30898e=_0x24803a;this['global']=_0x380a7e,this[_0x30898e(0x1ee)]=_0x5bfb3a,this[_0x30898e(0x159)]=_0x467143,this['nodeModules']=_0x105ec0,this[_0x30898e(0x18d)]=_0x217c97,this[_0x30898e(0x203)]=!0x0,this[_0x30898e(0x188)]=!0x0,this[_0x30898e(0x1c9)]=!0x1,this['_connecting']=!0x1,this['_inNextEdge']=_0x380a7e[_0x30898e(0x16a)]?.['env']?.[_0x30898e(0x15a)]===_0x30898e(0x199),this[_0x30898e(0x187)]=!this[_0x30898e(0x18a)][_0x30898e(0x16a)]?.[_0x30898e(0x212)]?.[_0x30898e(0x1ca)]&&!this['_inNextEdge'],this[_0x30898e(0x1fd)]=null,this['_connectAttemptCount']=0x0,this[_0x30898e(0x164)]=0x14,this[_0x30898e(0x1fe)]=_0x30898e(0x1cf),this['_sendErrorMessage']=(this[_0x30898e(0x187)]?_0x30898e(0x18c):'Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20')+this[_0x30898e(0x1fe)];}async[_0x24803a(0x1d5)](){var _0x37b0d8=_0x24803a;if(this[_0x37b0d8(0x1fd)])return this[_0x37b0d8(0x1fd)];let _0x45155e;if(this['_inBrowser']||this['_inNextEdge'])_0x45155e=this[_0x37b0d8(0x18a)]['WebSocket'];else{if(this[_0x37b0d8(0x18a)][_0x37b0d8(0x16a)]?.[_0x37b0d8(0x19c)])_0x45155e=this[_0x37b0d8(0x18a)]['process']?.['_WebSocket'];else try{let _0x11f879=await import(_0x37b0d8(0x215));_0x45155e=(await import((await import(_0x37b0d8(0x1c8)))[_0x37b0d8(0x1a2)](_0x11f879[_0x37b0d8(0x1c4)](this[_0x37b0d8(0x142)],'ws/index.js'))['toString']()))['default'];}catch{try{_0x45155e=require(require('path')[_0x37b0d8(0x1c4)](this[_0x37b0d8(0x142)],'ws'));}catch{throw new Error('failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket');}}}return this['_WebSocketClass']=_0x45155e,_0x45155e;}['_connectToHostNow'](){var _0x30b6d5=_0x24803a;this[_0x30b6d5(0x1de)]||this[_0x30b6d5(0x1c9)]||this[_0x30b6d5(0x12f)]>=this['_maxConnectAttemptCount']||(this[_0x30b6d5(0x188)]=!0x1,this[_0x30b6d5(0x1de)]=!0x0,this[_0x30b6d5(0x12f)]++,this['_ws']=new Promise((_0x3f85a3,_0xb4ec7d)=>{var _0x168c76=_0x30b6d5;this[_0x168c76(0x1d5)]()['then'](_0x5e6e15=>{var _0x663571=_0x168c76;let _0x4b9def=new _0x5e6e15(_0x663571(0x205)+(!this['_inBrowser']&&this['dockerizedApp']?'gateway.docker.internal':this[_0x663571(0x1ee)])+':'+this['port']);_0x4b9def[_0x663571(0x1ab)]=()=>{var _0x2caad6=_0x663571;this['_allowedToSend']=!0x1,this['_disposeWebsocket'](_0x4b9def),this[_0x2caad6(0x202)](),_0xb4ec7d(new Error(_0x2caad6(0x1f6)));},_0x4b9def['onopen']=()=>{var _0x5d6677=_0x663571;this[_0x5d6677(0x187)]||_0x4b9def[_0x5d6677(0x1eb)]&&_0x4b9def[_0x5d6677(0x1eb)][_0x5d6677(0x19d)]&&_0x4b9def[_0x5d6677(0x1eb)][_0x5d6677(0x19d)](),_0x3f85a3(_0x4b9def);},_0x4b9def['onclose']=()=>{var _0x1832f0=_0x663571;this[_0x1832f0(0x188)]=!0x0,this[_0x1832f0(0x154)](_0x4b9def),this[_0x1832f0(0x202)]();},_0x4b9def[_0x663571(0x150)]=_0x89b2c8=>{var _0xb7f1b8=_0x663571;try{_0x89b2c8&&_0x89b2c8['data']&&this[_0xb7f1b8(0x187)]&&JSON[_0xb7f1b8(0x196)](_0x89b2c8[_0xb7f1b8(0x176)])[_0xb7f1b8(0x20e)]==='reload'&&this[_0xb7f1b8(0x18a)]['location'][_0xb7f1b8(0x1d4)]();}catch{}};})[_0x168c76(0x18b)](_0x123671=>(this[_0x168c76(0x1c9)]=!0x0,this['_connecting']=!0x1,this[_0x168c76(0x188)]=!0x1,this[_0x168c76(0x203)]=!0x0,this[_0x168c76(0x12f)]=0x0,_0x123671))[_0x168c76(0x1cb)](_0xc83355=>(this['_connected']=!0x1,this[_0x168c76(0x1de)]=!0x1,console['warn'](_0x168c76(0x1b4)+this[_0x168c76(0x1fe)]),_0xb4ec7d(new Error(_0x168c76(0x1d9)+(_0xc83355&&_0xc83355[_0x168c76(0x1ba)])))));}));}[_0x24803a(0x154)](_0x13097e){var _0x59f656=_0x24803a;this[_0x59f656(0x1c9)]=!0x1,this['_connecting']=!0x1;try{_0x13097e[_0x59f656(0x1ef)]=null,_0x13097e[_0x59f656(0x1ab)]=null,_0x13097e[_0x59f656(0x1f1)]=null;}catch{}try{_0x13097e[_0x59f656(0x143)]<0x2&&_0x13097e[_0x59f656(0x210)]();}catch{}}[_0x24803a(0x202)](){var _0x4d2d0a=_0x24803a;clearTimeout(this[_0x4d2d0a(0x19e)]),!(this['_connectAttemptCount']>=this[_0x4d2d0a(0x164)])&&(this[_0x4d2d0a(0x19e)]=setTimeout(()=>{var _0xe49d26=_0x4d2d0a;this['_connected']||this[_0xe49d26(0x1de)]||(this[_0xe49d26(0x1f2)](),this[_0xe49d26(0x1ec)]?.[_0xe49d26(0x1cb)](()=>this[_0xe49d26(0x202)]()));},0x1f4),this['_reconnectTimeout'][_0x4d2d0a(0x19d)]&&this[_0x4d2d0a(0x19e)]['unref']());}async[_0x24803a(0x131)](_0x7913fd){var _0x483201=_0x24803a;try{if(!this['_allowedToSend'])return;this[_0x483201(0x188)]&&this[_0x483201(0x1f2)](),(await this['_ws'])[_0x483201(0x131)](JSON[_0x483201(0x206)](_0x7913fd));}catch(_0x3d3d12){console[_0x483201(0x1fc)](this['_sendErrorMessage']+':\\x20'+(_0x3d3d12&&_0x3d3d12[_0x483201(0x1ba)])),this[_0x483201(0x203)]=!0x1,this['_attemptToReconnectShortly']();}}};function _0x3519(_0x43a693,_0x3d02c3){var _0x428ac1=_0x428a();return _0x3519=function(_0x35190b,_0x57042e){_0x35190b=_0x35190b-0x12a;var _0x4eb27c=_0x428ac1[_0x35190b];return _0x4eb27c;},_0x3519(_0x43a693,_0x3d02c3);}function b(_0x23c764,_0x9eea67,_0x4432e1,_0x1a250d,_0x2cb8d4,_0x3fb319){var _0x48eb6b=_0x24803a;let _0xd603ad=_0x4432e1['split'](',')[_0x48eb6b(0x1d3)](_0x2f8158=>{var _0x528df8=_0x48eb6b;try{_0x23c764['_console_ninja_session']||((_0x2cb8d4==='next.js'||_0x2cb8d4===_0x528df8(0x149)||_0x2cb8d4===_0x528df8(0x20a)||_0x2cb8d4===_0x528df8(0x13f))&&(_0x2cb8d4+=!_0x23c764[_0x528df8(0x16a)]?.['versions']?.['node']&&_0x23c764[_0x528df8(0x16a)]?.['env']?.[_0x528df8(0x15a)]!==_0x528df8(0x199)?_0x528df8(0x211):'\\x20server'),_0x23c764[_0x528df8(0x181)]={'id':+new Date(),'tool':_0x2cb8d4});let _0x37feb9=new X(_0x23c764,_0x9eea67,_0x2f8158,_0x1a250d,_0x3fb319);return _0x37feb9[_0x528df8(0x131)][_0x528df8(0x186)](_0x37feb9);}catch(_0x3ed75f){return console[_0x528df8(0x1fc)]('logger\\x20failed\\x20to\\x20connect\\x20to\\x20host',_0x3ed75f&&_0x3ed75f[_0x528df8(0x1ba)]),()=>{};}});return _0x5286cb=>_0xd603ad[_0x48eb6b(0x207)](_0x49fb1d=>_0x49fb1d(_0x5286cb));}function W(_0x43733b){var _0x52e3a8=_0x24803a;let _0x417924=function(_0x4f3ce6,_0x5ba27f){return _0x5ba27f-_0x4f3ce6;},_0x5671e7;if(_0x43733b['performance'])_0x5671e7=function(){var _0x3928ca=_0x3519;return _0x43733b[_0x3928ca(0x185)]['now']();};else{if(_0x43733b['process']&&_0x43733b[_0x52e3a8(0x16a)]['hrtime']&&_0x43733b['process']?.[_0x52e3a8(0x1d2)]?.[_0x52e3a8(0x15a)]!==_0x52e3a8(0x199))_0x5671e7=function(){var _0x248713=_0x52e3a8;return _0x43733b[_0x248713(0x16a)][_0x248713(0x167)]();},_0x417924=function(_0x11cc84,_0x419c07){return 0x3e8*(_0x419c07[0x0]-_0x11cc84[0x0])+(_0x419c07[0x1]-_0x11cc84[0x1])/0xf4240;};else try{let {performance:_0x1d33c2}=require(_0x52e3a8(0x163));_0x5671e7=function(){var _0x130777=_0x52e3a8;return _0x1d33c2[_0x130777(0x1aa)]();};}catch{_0x5671e7=function(){return+new Date();};}}return{'elapsed':_0x417924,'timeStamp':_0x5671e7,'now':()=>Date['now']()};}function J(_0x4da22d,_0x46c73b,_0x5f2144){var _0x50f6ab=_0x24803a;if(_0x4da22d[_0x50f6ab(0x1cd)]!==void 0x0)return _0x4da22d[_0x50f6ab(0x1cd)];let _0x2b43ea=_0x4da22d[_0x50f6ab(0x16a)]?.['versions']?.[_0x50f6ab(0x1ca)]||_0x4da22d['process']?.['env']?.[_0x50f6ab(0x15a)]===_0x50f6ab(0x199);return _0x2b43ea&&_0x5f2144===_0x50f6ab(0x152)?_0x4da22d[_0x50f6ab(0x1cd)]=!0x1:_0x4da22d[_0x50f6ab(0x1cd)]=_0x2b43ea||!_0x46c73b||_0x4da22d[_0x50f6ab(0x1d7)]?.[_0x50f6ab(0x148)]&&_0x46c73b[_0x50f6ab(0x1bc)](_0x4da22d[_0x50f6ab(0x1d7)][_0x50f6ab(0x148)]),_0x4da22d[_0x50f6ab(0x1cd)];}function Y(_0x2bf533,_0x3ac499,_0x140baa,_0x2d455e){var _0x2dc2fe=_0x24803a;_0x2bf533=_0x2bf533,_0x3ac499=_0x3ac499,_0x140baa=_0x140baa,_0x2d455e=_0x2d455e;let _0x36ecad=W(_0x2bf533),_0x318c4f=_0x36ecad[_0x2dc2fe(0x155)],_0x353195=_0x36ecad[_0x2dc2fe(0x15b)];class _0x355610{constructor(){var _0x4f5ff3=_0x2dc2fe;this[_0x4f5ff3(0x209)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0x4f5ff3(0x1d0)]=/^(0|[1-9][0-9]*)$/,this['_quotedRegExp']=/'([^\\\\']|\\\\')*'/,this[_0x4f5ff3(0x1f4)]=_0x2bf533[_0x4f5ff3(0x14e)],this[_0x4f5ff3(0x1c1)]=_0x2bf533[_0x4f5ff3(0x132)],this['_getOwnPropertyDescriptor']=Object[_0x4f5ff3(0x165)],this[_0x4f5ff3(0x17f)]=Object['getOwnPropertyNames'],this[_0x4f5ff3(0x171)]=_0x2bf533['Symbol'],this[_0x4f5ff3(0x213)]=RegExp['prototype'][_0x4f5ff3(0x191)],this[_0x4f5ff3(0x14a)]=Date['prototype'][_0x4f5ff3(0x191)];}[_0x2dc2fe(0x1bf)](_0x258931,_0x5d18e,_0x46431b,_0x5a7a26){var _0x38e71c=_0x2dc2fe,_0x2a4ec1=this,_0xdeafe6=_0x46431b['autoExpand'];function _0x397da0(_0xcaab10,_0xb52ab4,_0x15d6a2){var _0x43bf43=_0x3519;_0xb52ab4['type']=_0x43bf43(0x1b7),_0xb52ab4['error']=_0xcaab10[_0x43bf43(0x1ba)],_0x1d74dc=_0x15d6a2[_0x43bf43(0x1ca)][_0x43bf43(0x1bb)],_0x15d6a2['node'][_0x43bf43(0x1bb)]=_0xb52ab4,_0x2a4ec1[_0x43bf43(0x161)](_0xb52ab4,_0x15d6a2);}try{_0x46431b['level']++,_0x46431b[_0x38e71c(0x19b)]&&_0x46431b[_0x38e71c(0x20d)][_0x38e71c(0x1af)](_0x5d18e);var _0x10cee3,_0xf772bc,_0x353938,_0x8f5a42,_0xb84e89=[],_0x259052=[],_0x120d1a,_0x200ba2=this['_type'](_0x5d18e),_0x4e3102=_0x200ba2===_0x38e71c(0x1f3),_0x383ced=!0x1,_0x5ec9b9=_0x200ba2===_0x38e71c(0x193),_0x366ec0=this[_0x38e71c(0x1d8)](_0x200ba2),_0x22e0a7=this[_0x38e71c(0x17c)](_0x200ba2),_0x525543=_0x366ec0||_0x22e0a7,_0x165015={},_0x40b593=0x0,_0x39c512=!0x1,_0x1d74dc,_0x4abfeb=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x46431b[_0x38e71c(0x136)]){if(_0x4e3102){if(_0xf772bc=_0x5d18e[_0x38e71c(0x1ea)],_0xf772bc>_0x46431b[_0x38e71c(0x12c)]){for(_0x353938=0x0,_0x8f5a42=_0x46431b['elements'],_0x10cee3=_0x353938;_0x10cee3<_0x8f5a42;_0x10cee3++)_0x259052['push'](_0x2a4ec1[_0x38e71c(0x1f0)](_0xb84e89,_0x5d18e,_0x200ba2,_0x10cee3,_0x46431b));_0x258931[_0x38e71c(0x1dc)]=!0x0;}else{for(_0x353938=0x0,_0x8f5a42=_0xf772bc,_0x10cee3=_0x353938;_0x10cee3<_0x8f5a42;_0x10cee3++)_0x259052[_0x38e71c(0x1af)](_0x2a4ec1[_0x38e71c(0x1f0)](_0xb84e89,_0x5d18e,_0x200ba2,_0x10cee3,_0x46431b));}_0x46431b[_0x38e71c(0x15f)]+=_0x259052[_0x38e71c(0x1ea)];}if(!(_0x200ba2===_0x38e71c(0x201)||_0x200ba2==='undefined')&&!_0x366ec0&&_0x200ba2!==_0x38e71c(0x1a7)&&_0x200ba2!==_0x38e71c(0x183)&&_0x200ba2!==_0x38e71c(0x198)){var _0x2b5f5f=_0x5a7a26[_0x38e71c(0x16e)]||_0x46431b[_0x38e71c(0x16e)];if(this[_0x38e71c(0x17b)](_0x5d18e)?(_0x10cee3=0x0,_0x5d18e[_0x38e71c(0x207)](function(_0x1786cb){var _0x4c2ef1=_0x38e71c;if(_0x40b593++,_0x46431b[_0x4c2ef1(0x15f)]++,_0x40b593>_0x2b5f5f){_0x39c512=!0x0;return;}if(!_0x46431b[_0x4c2ef1(0x200)]&&_0x46431b[_0x4c2ef1(0x19b)]&&_0x46431b[_0x4c2ef1(0x15f)]>_0x46431b[_0x4c2ef1(0x14c)]){_0x39c512=!0x0;return;}_0x259052[_0x4c2ef1(0x1af)](_0x2a4ec1[_0x4c2ef1(0x1f0)](_0xb84e89,_0x5d18e,_0x4c2ef1(0x14b),_0x10cee3++,_0x46431b,function(_0x2e9da5){return function(){return _0x2e9da5;};}(_0x1786cb)));})):this[_0x38e71c(0x1b1)](_0x5d18e)&&_0x5d18e['forEach'](function(_0x28589c,_0x9dd1b5){var _0x36d470=_0x38e71c;if(_0x40b593++,_0x46431b['autoExpandPropertyCount']++,_0x40b593>_0x2b5f5f){_0x39c512=!0x0;return;}if(!_0x46431b[_0x36d470(0x200)]&&_0x46431b[_0x36d470(0x19b)]&&_0x46431b[_0x36d470(0x15f)]>_0x46431b[_0x36d470(0x14c)]){_0x39c512=!0x0;return;}var _0x51f614=_0x9dd1b5[_0x36d470(0x191)]();_0x51f614['length']>0x64&&(_0x51f614=_0x51f614[_0x36d470(0x192)](0x0,0x64)+_0x36d470(0x1a1)),_0x259052[_0x36d470(0x1af)](_0x2a4ec1[_0x36d470(0x1f0)](_0xb84e89,_0x5d18e,'Map',_0x51f614,_0x46431b,function(_0x47724a){return function(){return _0x47724a;};}(_0x28589c)));}),!_0x383ced){try{for(_0x120d1a in _0x5d18e)if(!(_0x4e3102&&_0x4abfeb[_0x38e71c(0x1db)](_0x120d1a))&&!this[_0x38e71c(0x189)](_0x5d18e,_0x120d1a,_0x46431b)){if(_0x40b593++,_0x46431b[_0x38e71c(0x15f)]++,_0x40b593>_0x2b5f5f){_0x39c512=!0x0;break;}if(!_0x46431b[_0x38e71c(0x200)]&&_0x46431b[_0x38e71c(0x19b)]&&_0x46431b[_0x38e71c(0x15f)]>_0x46431b[_0x38e71c(0x14c)]){_0x39c512=!0x0;break;}_0x259052[_0x38e71c(0x1af)](_0x2a4ec1['_addObjectProperty'](_0xb84e89,_0x165015,_0x5d18e,_0x200ba2,_0x120d1a,_0x46431b));}}catch{}if(_0x165015[_0x38e71c(0x18f)]=!0x0,_0x5ec9b9&&(_0x165015[_0x38e71c(0x1cc)]=!0x0),!_0x39c512){var _0x6cadfd=[][_0x38e71c(0x190)](this[_0x38e71c(0x17f)](_0x5d18e))[_0x38e71c(0x190)](this[_0x38e71c(0x151)](_0x5d18e));for(_0x10cee3=0x0,_0xf772bc=_0x6cadfd[_0x38e71c(0x1ea)];_0x10cee3<_0xf772bc;_0x10cee3++)if(_0x120d1a=_0x6cadfd[_0x10cee3],!(_0x4e3102&&_0x4abfeb['test'](_0x120d1a['toString']()))&&!this[_0x38e71c(0x189)](_0x5d18e,_0x120d1a,_0x46431b)&&!_0x165015['_p_'+_0x120d1a[_0x38e71c(0x191)]()]){if(_0x40b593++,_0x46431b[_0x38e71c(0x15f)]++,_0x40b593>_0x2b5f5f){_0x39c512=!0x0;break;}if(!_0x46431b[_0x38e71c(0x200)]&&_0x46431b[_0x38e71c(0x19b)]&&_0x46431b['autoExpandPropertyCount']>_0x46431b[_0x38e71c(0x14c)]){_0x39c512=!0x0;break;}_0x259052[_0x38e71c(0x1af)](_0x2a4ec1[_0x38e71c(0x1fb)](_0xb84e89,_0x165015,_0x5d18e,_0x200ba2,_0x120d1a,_0x46431b));}}}}}if(_0x258931[_0x38e71c(0x162)]=_0x200ba2,_0x525543?(_0x258931[_0x38e71c(0x194)]=_0x5d18e['valueOf'](),this['_capIfString'](_0x200ba2,_0x258931,_0x46431b,_0x5a7a26)):_0x200ba2===_0x38e71c(0x141)?_0x258931['value']=this[_0x38e71c(0x14a)][_0x38e71c(0x1b5)](_0x5d18e):_0x200ba2===_0x38e71c(0x198)?_0x258931[_0x38e71c(0x194)]=_0x5d18e['toString']():_0x200ba2==='RegExp'?_0x258931['value']=this['_regExpToString']['call'](_0x5d18e):_0x200ba2===_0x38e71c(0x1e7)&&this[_0x38e71c(0x171)]?_0x258931[_0x38e71c(0x194)]=this[_0x38e71c(0x171)]['prototype']['toString'][_0x38e71c(0x1b5)](_0x5d18e):!_0x46431b[_0x38e71c(0x136)]&&!(_0x200ba2==='null'||_0x200ba2===_0x38e71c(0x14e))&&(delete _0x258931[_0x38e71c(0x194)],_0x258931[_0x38e71c(0x13a)]=!0x0),_0x39c512&&(_0x258931['cappedProps']=!0x0),_0x1d74dc=_0x46431b[_0x38e71c(0x1ca)][_0x38e71c(0x1bb)],_0x46431b[_0x38e71c(0x1ca)][_0x38e71c(0x1bb)]=_0x258931,this[_0x38e71c(0x161)](_0x258931,_0x46431b),_0x259052[_0x38e71c(0x1ea)]){for(_0x10cee3=0x0,_0xf772bc=_0x259052[_0x38e71c(0x1ea)];_0x10cee3<_0xf772bc;_0x10cee3++)_0x259052[_0x10cee3](_0x10cee3);}_0xb84e89[_0x38e71c(0x1ea)]&&(_0x258931[_0x38e71c(0x16e)]=_0xb84e89);}catch(_0x183792){_0x397da0(_0x183792,_0x258931,_0x46431b);}return this[_0x38e71c(0x1ac)](_0x5d18e,_0x258931),this[_0x38e71c(0x14d)](_0x258931,_0x46431b),_0x46431b[_0x38e71c(0x1ca)][_0x38e71c(0x1bb)]=_0x1d74dc,_0x46431b[_0x38e71c(0x179)]--,_0x46431b[_0x38e71c(0x19b)]=_0xdeafe6,_0x46431b[_0x38e71c(0x19b)]&&_0x46431b['autoExpandPreviousObjects']['pop'](),_0x258931;}[_0x2dc2fe(0x151)](_0x351868){var _0x5c27bf=_0x2dc2fe;return Object[_0x5c27bf(0x1f5)]?Object[_0x5c27bf(0x1f5)](_0x351868):[];}[_0x2dc2fe(0x17b)](_0x2d4847){var _0xf5613a=_0x2dc2fe;return!!(_0x2d4847&&_0x2bf533[_0xf5613a(0x14b)]&&this['_objectToString'](_0x2d4847)===_0xf5613a(0x12e)&&_0x2d4847['forEach']);}[_0x2dc2fe(0x189)](_0x2d1552,_0x5915e3,_0x2250ba){var _0x3b3649=_0x2dc2fe;return _0x2250ba[_0x3b3649(0x204)]?typeof _0x2d1552[_0x5915e3]==_0x3b3649(0x193):!0x1;}[_0x2dc2fe(0x1bd)](_0x56ce14){var _0x555a50=_0x2dc2fe,_0xb9c7e2='';return _0xb9c7e2=typeof _0x56ce14,_0xb9c7e2===_0x555a50(0x157)?this[_0x555a50(0x1c3)](_0x56ce14)===_0x555a50(0x182)?_0xb9c7e2=_0x555a50(0x1f3):this[_0x555a50(0x1c3)](_0x56ce14)===_0x555a50(0x1be)?_0xb9c7e2=_0x555a50(0x141):this[_0x555a50(0x1c3)](_0x56ce14)===_0x555a50(0x13c)?_0xb9c7e2=_0x555a50(0x198):_0x56ce14===null?_0xb9c7e2=_0x555a50(0x201):_0x56ce14[_0x555a50(0x17e)]&&(_0xb9c7e2=_0x56ce14['constructor'][_0x555a50(0x1b2)]||_0xb9c7e2):_0xb9c7e2===_0x555a50(0x14e)&&this[_0x555a50(0x1c1)]&&_0x56ce14 instanceof this[_0x555a50(0x1c1)]&&(_0xb9c7e2=_0x555a50(0x132)),_0xb9c7e2;}[_0x2dc2fe(0x1c3)](_0x2b2320){var _0x39303f=_0x2dc2fe;return Object[_0x39303f(0x1e2)][_0x39303f(0x191)][_0x39303f(0x1b5)](_0x2b2320);}[_0x2dc2fe(0x1d8)](_0x94d26e){var _0x3cd493=_0x2dc2fe;return _0x94d26e===_0x3cd493(0x174)||_0x94d26e===_0x3cd493(0x140)||_0x94d26e==='number';}[_0x2dc2fe(0x17c)](_0x447ceb){var _0x2fcdbd=_0x2dc2fe;return _0x447ceb===_0x2fcdbd(0x130)||_0x447ceb===_0x2fcdbd(0x1a7)||_0x447ceb===_0x2fcdbd(0x20b);}['_addProperty'](_0x1b9e98,_0x2e03e6,_0x4eea28,_0x3b1129,_0x3b51d4,_0x219390){var _0x468136=this;return function(_0x427a75){var _0x33b569=_0x3519,_0x55df8d=_0x3b51d4[_0x33b569(0x1ca)][_0x33b569(0x1bb)],_0x3dc09c=_0x3b51d4['node']['index'],_0x18f624=_0x3b51d4[_0x33b569(0x1ca)][_0x33b569(0x170)];_0x3b51d4[_0x33b569(0x1ca)][_0x33b569(0x170)]=_0x55df8d,_0x3b51d4['node']['index']=typeof _0x3b1129==_0x33b569(0x1c7)?_0x3b1129:_0x427a75,_0x1b9e98[_0x33b569(0x1af)](_0x468136[_0x33b569(0x1e5)](_0x2e03e6,_0x4eea28,_0x3b1129,_0x3b51d4,_0x219390)),_0x3b51d4[_0x33b569(0x1ca)][_0x33b569(0x170)]=_0x18f624,_0x3b51d4['node'][_0x33b569(0x144)]=_0x3dc09c;};}[_0x2dc2fe(0x1fb)](_0x47d014,_0x116344,_0x51ca42,_0x30bcf5,_0x957b75,_0x5d583a,_0x7843a1){var _0x22f7d5=_0x2dc2fe,_0x18a285=this;return _0x116344['_p_'+_0x957b75[_0x22f7d5(0x191)]()]=!0x0,function(_0x52fe11){var _0x22da58=_0x22f7d5,_0x1d72c2=_0x5d583a[_0x22da58(0x1ca)]['current'],_0x897f93=_0x5d583a[_0x22da58(0x1ca)]['index'],_0x5cdf45=_0x5d583a['node'][_0x22da58(0x170)];_0x5d583a[_0x22da58(0x1ca)][_0x22da58(0x170)]=_0x1d72c2,_0x5d583a[_0x22da58(0x1ca)]['index']=_0x52fe11,_0x47d014[_0x22da58(0x1af)](_0x18a285[_0x22da58(0x1e5)](_0x51ca42,_0x30bcf5,_0x957b75,_0x5d583a,_0x7843a1)),_0x5d583a['node']['parent']=_0x5cdf45,_0x5d583a[_0x22da58(0x1ca)]['index']=_0x897f93;};}[_0x2dc2fe(0x1e5)](_0x548d46,_0xa99baa,_0x3fec88,_0x113de2,_0x29e5a8){var _0x5d549d=_0x2dc2fe,_0x52cb14=this;_0x29e5a8||(_0x29e5a8=function(_0x3585b3,_0x4e1244){return _0x3585b3[_0x4e1244];});var _0x5118dd=_0x3fec88[_0x5d549d(0x191)](),_0x1740cd=_0x113de2[_0x5d549d(0x13e)]||{},_0x5695f9=_0x113de2['depth'],_0x461a1f=_0x113de2[_0x5d549d(0x200)];try{var _0x533758=this['_isMap'](_0x548d46),_0x5372e3=_0x5118dd;_0x533758&&_0x5372e3[0x0]==='\\x27'&&(_0x5372e3=_0x5372e3['substr'](0x1,_0x5372e3[_0x5d549d(0x1ea)]-0x2));var _0x5ade73=_0x113de2[_0x5d549d(0x13e)]=_0x1740cd[_0x5d549d(0x1a4)+_0x5372e3];_0x5ade73&&(_0x113de2['depth']=_0x113de2[_0x5d549d(0x136)]+0x1),_0x113de2['isExpressionToEvaluate']=!!_0x5ade73;var _0x46ad92=typeof _0x3fec88=='symbol',_0x433e1d={'name':_0x46ad92||_0x533758?_0x5118dd:this[_0x5d549d(0x173)](_0x5118dd)};if(_0x46ad92&&(_0x433e1d[_0x5d549d(0x1e7)]=!0x0),!(_0xa99baa===_0x5d549d(0x1f3)||_0xa99baa===_0x5d549d(0x169))){var _0x32bd0f=this[_0x5d549d(0x17a)](_0x548d46,_0x3fec88);if(_0x32bd0f&&(_0x32bd0f['set']&&(_0x433e1d[_0x5d549d(0x1d6)]=!0x0),_0x32bd0f[_0x5d549d(0x134)]&&!_0x5ade73&&!_0x113de2[_0x5d549d(0x172)]))return _0x433e1d[_0x5d549d(0x12a)]=!0x0,this['_processTreeNodeResult'](_0x433e1d,_0x113de2),_0x433e1d;}var _0x3971d1;try{_0x3971d1=_0x29e5a8(_0x548d46,_0x3fec88);}catch(_0x34fa5b){return _0x433e1d={'name':_0x5118dd,'type':_0x5d549d(0x1b7),'error':_0x34fa5b['message']},this['_processTreeNodeResult'](_0x433e1d,_0x113de2),_0x433e1d;}var _0x59fe2e=this[_0x5d549d(0x1bd)](_0x3971d1),_0x37f9c1=this[_0x5d549d(0x1d8)](_0x59fe2e);if(_0x433e1d['type']=_0x59fe2e,_0x37f9c1)this[_0x5d549d(0x19a)](_0x433e1d,_0x113de2,_0x3971d1,function(){var _0xbf6671=_0x5d549d;_0x433e1d[_0xbf6671(0x194)]=_0x3971d1[_0xbf6671(0x1a3)](),!_0x5ade73&&_0x52cb14[_0xbf6671(0x16d)](_0x59fe2e,_0x433e1d,_0x113de2,{});});else{var _0x3d8b90=_0x113de2[_0x5d549d(0x19b)]&&_0x113de2['level']<_0x113de2[_0x5d549d(0x1ff)]&&_0x113de2[_0x5d549d(0x20d)]['indexOf'](_0x3971d1)<0x0&&_0x59fe2e!==_0x5d549d(0x193)&&_0x113de2[_0x5d549d(0x15f)]<_0x113de2[_0x5d549d(0x14c)];_0x3d8b90||_0x113de2[_0x5d549d(0x179)]<_0x5695f9||_0x5ade73?(this[_0x5d549d(0x1bf)](_0x433e1d,_0x3971d1,_0x113de2,_0x5ade73||{}),this[_0x5d549d(0x1ac)](_0x3971d1,_0x433e1d)):this[_0x5d549d(0x19a)](_0x433e1d,_0x113de2,_0x3971d1,function(){var _0x1f0e54=_0x5d549d;_0x59fe2e===_0x1f0e54(0x201)||_0x59fe2e===_0x1f0e54(0x14e)||(delete _0x433e1d[_0x1f0e54(0x194)],_0x433e1d[_0x1f0e54(0x13a)]=!0x0);});}return _0x433e1d;}finally{_0x113de2[_0x5d549d(0x13e)]=_0x1740cd,_0x113de2[_0x5d549d(0x136)]=_0x5695f9,_0x113de2[_0x5d549d(0x200)]=_0x461a1f;}}[_0x2dc2fe(0x16d)](_0x5c17b4,_0x264d66,_0x2d97d2,_0x27320f){var _0x32ddfb=_0x2dc2fe,_0x73dc4e=_0x27320f[_0x32ddfb(0x175)]||_0x2d97d2[_0x32ddfb(0x175)];if((_0x5c17b4===_0x32ddfb(0x140)||_0x5c17b4===_0x32ddfb(0x1a7))&&_0x264d66['value']){let _0x153024=_0x264d66[_0x32ddfb(0x194)]['length'];_0x2d97d2['allStrLength']+=_0x153024,_0x2d97d2[_0x32ddfb(0x1e4)]>_0x2d97d2['totalStrLength']?(_0x264d66['capped']='',delete _0x264d66['value']):_0x153024>_0x73dc4e&&(_0x264d66[_0x32ddfb(0x13a)]=_0x264d66[_0x32ddfb(0x194)][_0x32ddfb(0x180)](0x0,_0x73dc4e),delete _0x264d66[_0x32ddfb(0x194)]);}}[_0x2dc2fe(0x1b1)](_0x303b60){var _0x3ce728=_0x2dc2fe;return!!(_0x303b60&&_0x2bf533[_0x3ce728(0x12b)]&&this['_objectToString'](_0x303b60)===_0x3ce728(0x16c)&&_0x303b60[_0x3ce728(0x207)]);}[_0x2dc2fe(0x173)](_0x5a4ce4){var _0x271ae9=_0x2dc2fe;if(_0x5a4ce4[_0x271ae9(0x1e3)](/^\\d+$/))return _0x5a4ce4;var _0x59f1b2;try{_0x59f1b2=JSON[_0x271ae9(0x206)](''+_0x5a4ce4);}catch{_0x59f1b2='\\x22'+this[_0x271ae9(0x1c3)](_0x5a4ce4)+'\\x22';}return _0x59f1b2[_0x271ae9(0x1e3)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x59f1b2=_0x59f1b2['substr'](0x1,_0x59f1b2['length']-0x2):_0x59f1b2=_0x59f1b2[_0x271ae9(0x1b0)](/'/g,'\\x5c\\x27')[_0x271ae9(0x1b0)](/\\\\\"/g,'\\x22')['replace'](/(^\"|\"$)/g,'\\x27'),_0x59f1b2;}[_0x2dc2fe(0x19a)](_0x305f8c,_0x3f7e4d,_0x2de1df,_0x50e06c){var _0x2937ca=_0x2dc2fe;this[_0x2937ca(0x161)](_0x305f8c,_0x3f7e4d),_0x50e06c&&_0x50e06c(),this['_additionalMetadata'](_0x2de1df,_0x305f8c),this[_0x2937ca(0x14d)](_0x305f8c,_0x3f7e4d);}['_treeNodePropertiesBeforeFullValue'](_0x4fcb9f,_0x2d4830){var _0x570f49=_0x2dc2fe;this[_0x570f49(0x214)](_0x4fcb9f,_0x2d4830),this[_0x570f49(0x146)](_0x4fcb9f,_0x2d4830),this['_setNodeExpressionPath'](_0x4fcb9f,_0x2d4830),this['_setNodePermissions'](_0x4fcb9f,_0x2d4830);}[_0x2dc2fe(0x214)](_0x4fda5b,_0x3fda3f){}[_0x2dc2fe(0x146)](_0x5d13f8,_0x27ea99){}[_0x2dc2fe(0x184)](_0x588d1d,_0x31c0b9){}[_0x2dc2fe(0x1f9)](_0x53c9ce){return _0x53c9ce===this['_undefined'];}[_0x2dc2fe(0x14d)](_0x21197c,_0x46b391){var _0x2e4213=_0x2dc2fe;this[_0x2e4213(0x184)](_0x21197c,_0x46b391),this[_0x2e4213(0x147)](_0x21197c),_0x46b391[_0x2e4213(0x197)]&&this['_sortProps'](_0x21197c),this[_0x2e4213(0x139)](_0x21197c,_0x46b391),this[_0x2e4213(0x1f7)](_0x21197c,_0x46b391),this[_0x2e4213(0x195)](_0x21197c);}['_additionalMetadata'](_0x201608,_0x47e017){var _0x3073c5=_0x2dc2fe;let _0x5b25c5;try{_0x2bf533['console']&&(_0x5b25c5=_0x2bf533[_0x3073c5(0x13b)]['error'],_0x2bf533[_0x3073c5(0x13b)]['error']=function(){}),_0x201608&&typeof _0x201608['length']==_0x3073c5(0x1c7)&&(_0x47e017['length']=_0x201608[_0x3073c5(0x1ea)]);}catch{}finally{_0x5b25c5&&(_0x2bf533[_0x3073c5(0x13b)]['error']=_0x5b25c5);}if(_0x47e017[_0x3073c5(0x162)]===_0x3073c5(0x1c7)||_0x47e017[_0x3073c5(0x162)]==='Number'){if(isNaN(_0x47e017['value']))_0x47e017['nan']=!0x0,delete _0x47e017['value'];else switch(_0x47e017[_0x3073c5(0x194)]){case Number[_0x3073c5(0x20c)]:_0x47e017[_0x3073c5(0x1d1)]=!0x0,delete _0x47e017['value'];break;case Number['NEGATIVE_INFINITY']:_0x47e017[_0x3073c5(0x1a8)]=!0x0,delete _0x47e017[_0x3073c5(0x194)];break;case 0x0:this['_isNegativeZero'](_0x47e017[_0x3073c5(0x194)])&&(_0x47e017['negativeZero']=!0x0);break;}}else _0x47e017['type']===_0x3073c5(0x193)&&typeof _0x201608[_0x3073c5(0x1b2)]==_0x3073c5(0x140)&&_0x201608[_0x3073c5(0x1b2)]&&_0x47e017[_0x3073c5(0x1b2)]&&_0x201608[_0x3073c5(0x1b2)]!==_0x47e017[_0x3073c5(0x1b2)]&&(_0x47e017[_0x3073c5(0x1e1)]=_0x201608[_0x3073c5(0x1b2)]);}['_isNegativeZero'](_0x2d4c92){var _0x35d1a9=_0x2dc2fe;return 0x1/_0x2d4c92===Number[_0x35d1a9(0x1da)];}[_0x2dc2fe(0x12d)](_0x410a59){var _0x17de34=_0x2dc2fe;!_0x410a59[_0x17de34(0x16e)]||!_0x410a59['props'][_0x17de34(0x1ea)]||_0x410a59['type']===_0x17de34(0x1f3)||_0x410a59[_0x17de34(0x162)]===_0x17de34(0x12b)||_0x410a59[_0x17de34(0x162)]==='Set'||_0x410a59[_0x17de34(0x16e)][_0x17de34(0x16f)](function(_0x5aec7a,_0xc4a2c7){var _0x110652=_0x17de34,_0x577e46=_0x5aec7a[_0x110652(0x1b2)][_0x110652(0x1c2)](),_0x4b2301=_0xc4a2c7[_0x110652(0x1b2)][_0x110652(0x1c2)]();return _0x577e46<_0x4b2301?-0x1:_0x577e46>_0x4b2301?0x1:0x0;});}[_0x2dc2fe(0x139)](_0x325d14,_0x3febd2){var _0xbcf7da=_0x2dc2fe;if(!(_0x3febd2[_0xbcf7da(0x204)]||!_0x325d14[_0xbcf7da(0x16e)]||!_0x325d14[_0xbcf7da(0x16e)][_0xbcf7da(0x1ea)])){for(var _0x1fb085=[],_0x182c69=[],_0x118c69=0x0,_0x360167=_0x325d14[_0xbcf7da(0x16e)][_0xbcf7da(0x1ea)];_0x118c69<_0x360167;_0x118c69++){var _0x4ec9bd=_0x325d14['props'][_0x118c69];_0x4ec9bd[_0xbcf7da(0x162)]===_0xbcf7da(0x193)?_0x1fb085[_0xbcf7da(0x1af)](_0x4ec9bd):_0x182c69['push'](_0x4ec9bd);}if(!(!_0x182c69[_0xbcf7da(0x1ea)]||_0x1fb085[_0xbcf7da(0x1ea)]<=0x1)){_0x325d14[_0xbcf7da(0x16e)]=_0x182c69;var _0x4fb707={'functionsNode':!0x0,'props':_0x1fb085};this[_0xbcf7da(0x214)](_0x4fb707,_0x3febd2),this[_0xbcf7da(0x184)](_0x4fb707,_0x3febd2),this[_0xbcf7da(0x147)](_0x4fb707),this[_0xbcf7da(0x1e9)](_0x4fb707,_0x3febd2),_0x4fb707['id']+='\\x20f',_0x325d14[_0xbcf7da(0x16e)][_0xbcf7da(0x16b)](_0x4fb707);}}}[_0x2dc2fe(0x1f7)](_0x56a9ec,_0x53190a){}[_0x2dc2fe(0x147)](_0x247d00){}[_0x2dc2fe(0x1c6)](_0x4a87de){var _0x508123=_0x2dc2fe;return Array['isArray'](_0x4a87de)||typeof _0x4a87de==_0x508123(0x157)&&this[_0x508123(0x1c3)](_0x4a87de)==='[object\\x20Array]';}[_0x2dc2fe(0x1e9)](_0x302d0b,_0x38f184){}[_0x2dc2fe(0x195)](_0x3681a3){var _0x468dae=_0x2dc2fe;delete _0x3681a3[_0x468dae(0x1dd)],delete _0x3681a3[_0x468dae(0x135)],delete _0x3681a3['_hasMapOnItsPath'];}[_0x2dc2fe(0x1e8)](_0x3dde0d,_0x29e5a7){}}let _0x9e45c3=new _0x355610(),_0x36dcfb={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x4f6b28={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2};function _0xcbf640(_0x5a445e,_0x51da77,_0x4b1644,_0x581396,_0x50a1a2,_0x520450){var _0x149ea0=_0x2dc2fe;let _0x4008e6,_0x36a0ab;try{_0x36a0ab=_0x353195(),_0x4008e6=_0x140baa[_0x51da77],!_0x4008e6||_0x36a0ab-_0x4008e6['ts']>0x1f4&&_0x4008e6[_0x149ea0(0x13d)]&&_0x4008e6['time']/_0x4008e6[_0x149ea0(0x13d)]<0x64?(_0x140baa[_0x51da77]=_0x4008e6={'count':0x0,'time':0x0,'ts':_0x36a0ab},_0x140baa['hits']={}):_0x36a0ab-_0x140baa[_0x149ea0(0x17d)]['ts']>0x32&&_0x140baa[_0x149ea0(0x17d)][_0x149ea0(0x13d)]&&_0x140baa[_0x149ea0(0x17d)][_0x149ea0(0x145)]/_0x140baa[_0x149ea0(0x17d)]['count']<0x64&&(_0x140baa[_0x149ea0(0x17d)]={});let _0x15ed17=[],_0xf227b7=_0x4008e6[_0x149ea0(0x1ce)]||_0x140baa[_0x149ea0(0x17d)][_0x149ea0(0x1ce)]?_0x4f6b28:_0x36dcfb,_0x2063f6=_0x325b9c=>{var _0xec907c=_0x149ea0;let _0x2ee04e={};return _0x2ee04e[_0xec907c(0x16e)]=_0x325b9c['props'],_0x2ee04e[_0xec907c(0x12c)]=_0x325b9c[_0xec907c(0x12c)],_0x2ee04e[_0xec907c(0x175)]=_0x325b9c['strLength'],_0x2ee04e[_0xec907c(0x153)]=_0x325b9c[_0xec907c(0x153)],_0x2ee04e[_0xec907c(0x14c)]=_0x325b9c['autoExpandLimit'],_0x2ee04e[_0xec907c(0x1ff)]=_0x325b9c[_0xec907c(0x1ff)],_0x2ee04e[_0xec907c(0x197)]=!0x1,_0x2ee04e[_0xec907c(0x204)]=!_0x3ac499,_0x2ee04e[_0xec907c(0x136)]=0x1,_0x2ee04e['level']=0x0,_0x2ee04e[_0xec907c(0x1b6)]=_0xec907c(0x177),_0x2ee04e[_0xec907c(0x18e)]=_0xec907c(0x208),_0x2ee04e[_0xec907c(0x19b)]=!0x0,_0x2ee04e[_0xec907c(0x20d)]=[],_0x2ee04e[_0xec907c(0x15f)]=0x0,_0x2ee04e[_0xec907c(0x172)]=!0x0,_0x2ee04e[_0xec907c(0x1e4)]=0x0,_0x2ee04e[_0xec907c(0x1ca)]={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x2ee04e;};for(var _0x40fa9a=0x0;_0x40fa9a<_0x50a1a2[_0x149ea0(0x1ea)];_0x40fa9a++)_0x15ed17['push'](_0x9e45c3[_0x149ea0(0x1bf)]({'timeNode':_0x5a445e==='time'||void 0x0},_0x50a1a2[_0x40fa9a],_0x2063f6(_0xf227b7),{}));if(_0x5a445e===_0x149ea0(0x1b8)){let _0x58d1d2=Error['stackTraceLimit'];try{Error['stackTraceLimit']=0x1/0x0,_0x15ed17[_0x149ea0(0x1af)](_0x9e45c3[_0x149ea0(0x1bf)]({'stackNode':!0x0},new Error()['stack'],_0x2063f6(_0xf227b7),{'strLength':0x1/0x0}));}finally{Error[_0x149ea0(0x1fa)]=_0x58d1d2;}}return{'method':_0x149ea0(0x137),'version':_0x2d455e,'args':[{'ts':_0x4b1644,'session':_0x581396,'args':_0x15ed17,'id':_0x51da77,'context':_0x520450}]};}catch(_0x41a05c){return{'method':_0x149ea0(0x137),'version':_0x2d455e,'args':[{'ts':_0x4b1644,'session':_0x581396,'args':[{'type':'unknown','error':_0x41a05c&&_0x41a05c['message']}],'id':_0x51da77,'context':_0x520450}]};}finally{try{if(_0x4008e6&&_0x36a0ab){let _0x3b4fd3=_0x353195();_0x4008e6[_0x149ea0(0x13d)]++,_0x4008e6[_0x149ea0(0x145)]+=_0x318c4f(_0x36a0ab,_0x3b4fd3),_0x4008e6['ts']=_0x3b4fd3,_0x140baa[_0x149ea0(0x17d)]['count']++,_0x140baa[_0x149ea0(0x17d)]['time']+=_0x318c4f(_0x36a0ab,_0x3b4fd3),_0x140baa[_0x149ea0(0x17d)]['ts']=_0x3b4fd3,(_0x4008e6['count']>0x32||_0x4008e6['time']>0x64)&&(_0x4008e6[_0x149ea0(0x1ce)]=!0x0),(_0x140baa[_0x149ea0(0x17d)][_0x149ea0(0x13d)]>0x3e8||_0x140baa['hits']['time']>0x12c)&&(_0x140baa[_0x149ea0(0x17d)][_0x149ea0(0x1ce)]=!0x0);}}catch{}}}return _0xcbf640;}((_0xb5e82,_0x2845f6,_0x19ceb1,_0x2e72a2,_0x44df67,_0x27f7c5,_0x5ed97a,_0x483c4c,_0x3bf54e,_0x292315)=>{var _0x93272d=_0x24803a;if(_0xb5e82[_0x93272d(0x1c5)])return _0xb5e82[_0x93272d(0x1c5)];if(!J(_0xb5e82,_0x483c4c,_0x44df67))return _0xb5e82['_console_ninja']={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'coverage':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0xb5e82[_0x93272d(0x1c5)];let _0x5625fd=W(_0xb5e82),_0xcbd00c=_0x5625fd[_0x93272d(0x155)],_0x1cc22c=_0x5625fd[_0x93272d(0x15b)],_0x213847=_0x5625fd[_0x93272d(0x1aa)],_0x2894f8={'hits':{},'ts':{}},_0x17cde9=Y(_0xb5e82,_0x3bf54e,_0x2894f8,_0x27f7c5),_0x145ff8=_0x38476e=>{_0x2894f8['ts'][_0x38476e]=_0x1cc22c();},_0x1c6d77=(_0x1bc193,_0x5ecad4)=>{let _0x121127=_0x2894f8['ts'][_0x5ecad4];if(delete _0x2894f8['ts'][_0x5ecad4],_0x121127){let _0x3cf0b1=_0xcbd00c(_0x121127,_0x1cc22c());_0x26f99d(_0x17cde9('time',_0x1bc193,_0x213847(),_0x5a8bb7,[_0x3cf0b1],_0x5ecad4));}},_0x254092=_0x1f857b=>_0x35a2e5=>{var _0x4f9ff9=_0x93272d;try{_0x145ff8(_0x35a2e5),_0x1f857b(_0x35a2e5);}finally{_0xb5e82[_0x4f9ff9(0x13b)][_0x4f9ff9(0x145)]=_0x1f857b;}},_0x5f4683=_0x506bc7=>_0x28b309=>{var _0xaf0da3=_0x93272d;try{let [_0x2d39ad,_0x55f5c3]=_0x28b309[_0xaf0da3(0x1e6)](_0xaf0da3(0x1ae));_0x1c6d77(_0x55f5c3,_0x2d39ad),_0x506bc7(_0x2d39ad);}finally{_0xb5e82[_0xaf0da3(0x13b)][_0xaf0da3(0x15e)]=_0x506bc7;}};_0xb5e82[_0x93272d(0x1c5)]={'consoleLog':(_0x42d57a,_0x23cd22)=>{var _0x5e2974=_0x93272d;_0xb5e82[_0x5e2974(0x13b)][_0x5e2974(0x137)][_0x5e2974(0x1b2)]!==_0x5e2974(0x1b3)&&_0x26f99d(_0x17cde9(_0x5e2974(0x137),_0x42d57a,_0x213847(),_0x5a8bb7,_0x23cd22));},'consoleTrace':(_0x532182,_0x3913be)=>{var _0x28deb6=_0x93272d;_0xb5e82[_0x28deb6(0x13b)][_0x28deb6(0x137)][_0x28deb6(0x1b2)]!==_0x28deb6(0x1e0)&&_0x26f99d(_0x17cde9(_0x28deb6(0x1b8),_0x532182,_0x213847(),_0x5a8bb7,_0x3913be));},'consoleTime':()=>{var _0x220911=_0x93272d;_0xb5e82['console']['time']=_0x254092(_0xb5e82[_0x220911(0x13b)][_0x220911(0x145)]);},'consoleTimeEnd':()=>{var _0x29602a=_0x93272d;_0xb5e82[_0x29602a(0x13b)][_0x29602a(0x15e)]=_0x5f4683(_0xb5e82[_0x29602a(0x13b)]['timeEnd']);},'autoLog':(_0xa7e0c5,_0x2a2958)=>{var _0x3e5c32=_0x93272d;_0x26f99d(_0x17cde9(_0x3e5c32(0x137),_0x2a2958,_0x213847(),_0x5a8bb7,[_0xa7e0c5]));},'autoLogMany':(_0x337ad6,_0x4fc08b)=>{_0x26f99d(_0x17cde9('log',_0x337ad6,_0x213847(),_0x5a8bb7,_0x4fc08b));},'autoTrace':(_0x236263,_0x2b59bf)=>{var _0x521b4c=_0x93272d;_0x26f99d(_0x17cde9(_0x521b4c(0x1b8),_0x2b59bf,_0x213847(),_0x5a8bb7,[_0x236263]));},'autoTraceMany':(_0x1fca50,_0x27294b)=>{var _0x5ead36=_0x93272d;_0x26f99d(_0x17cde9(_0x5ead36(0x1b8),_0x1fca50,_0x213847(),_0x5a8bb7,_0x27294b));},'autoTime':(_0xb0432,_0x5736fe,_0x4fc185)=>{_0x145ff8(_0x4fc185);},'autoTimeEnd':(_0x258058,_0x3cafe4,_0x5e1f27)=>{_0x1c6d77(_0x3cafe4,_0x5e1f27);},'coverage':_0x28133c=>{var _0x285922=_0x93272d;_0x26f99d({'method':_0x285922(0x1b9),'version':_0x27f7c5,'args':[{'id':_0x28133c}]});}};let _0x26f99d=b(_0xb5e82,_0x2845f6,_0x19ceb1,_0x2e72a2,_0x44df67,_0x292315),_0x5a8bb7=_0xb5e82[_0x93272d(0x181)];return _0xb5e82[_0x93272d(0x1c5)];})(globalThis,_0x24803a(0x1a0),'52100',_0x24803a(0x19f),_0x24803a(0x1a6),'1.0.0',_0x24803a(0x156),_0x24803a(0x133),_0x24803a(0x15d),_0x24803a(0x1a9));");}catch(e){}};/* istanbul ignore next */function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};/* istanbul ignore next */function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint unicorn/no-abusive-eslint-disable:,eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
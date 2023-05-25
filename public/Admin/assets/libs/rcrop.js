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
/* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x57e85f=_0x1f85;function _0x4e17(){var _0x27a2ce=[':logPointId:','autoExpandLimit','_connected','_getOwnPropertyDescriptor','[object\\x20Date]','5uMxZjs','parse','time','elapsed','function','elements','props','prototype','count','_type','ws/index.js','autoExpand','getOwnPropertySymbols','replace','then','_blacklistedProperty','null','funcName','name','capped','log','now','unref','_keyStrRegExp','onerror','reduceLimits','_propertyAccessor','1685016186610','8159890ICmTGO','_cleanNode','hrtime','hostname','_addLoadNode','Error','bind','disabledLog','Buffer','strLength',\"c:\\\\Users\\\\benvi\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-0.0.124\\\\node_modules\",'expId','catch','join','666TqPcfK','isExpressionToEvaluate','substr','process','host','_p_','forEach','stack','__es'+'Module','autoExpandMaxDepth','nan','_propertyName','_p_name','_addProperty','noFunctions','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','_additionalMetadata','_setNodePermissions','_isUndefined','_connecting','','getWebSocketClass','default','boolean','_setNodeId','String','warn','logger\\x20websocket\\x20error','valueOf','depth','_objectToString','rootExpression','_isPrimitiveType','POSITIVE_INFINITY','1.0.0','disabledTrace','bigint','_p_length','Set','current','negativeInfinity','send','_console_ninja','perf_hooks','negativeZero','string','performance','_isMap','NEGATIVE_INFINITY','nuxt','_treeNodePropertiesBeforeFullValue','_ws','next.js','array','86177aWLatN','onclose','totalStrLength','_dateToString','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','_quotedRegExp','_attemptToReconnectShortly','enumerable','_setNodeExpressionPath','_sendErrorMessage','cappedElements','25569JxKxdr','pathToFileURL','_HTMLAllCollection','sortProps','62516','...','_isNegativeZero','toLowerCase','trace','_WebSocket','versions','getPrototypeOf','getOwnPropertyNames','_allowedToSend','_property','\\x20server','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help','_hasMapOnItsPath','_regExpToString','_capIfString','match','_undefined','1828740wKdcwx','Symbol','stackTraceLimit','Map','cappedProps','level','_setNodeExpandableState','_inBrowser','getter','_console_ninja_session','RegExp','close','_getOwnPropertyNames','[object\\x20Set]','method','[object\\x20Map]','_hasSymbolPropertyOnItsPath','toString','message','unknown','argumentResolutionError','_processTreeNodeResult','timeEnd','22pJPlxu','_maxConnectAttemptCount','data','sort','slice','hasOwnProperty','_reconnectTimeout','date','_socket','_allowedToConnectOnSend','60906252GNAmPu','WebSocket','_isPrimitiveWrapperType','map','undefined','hits','global','stringify','console','_isSet','getOwnPropertyDescriptor','Number','_setNodeQueryPath','184olnpbB','autoExpandPreviousObjects','_connectToHostNow','parent','_connectAttemptCount','failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','_addObjectProperty','_sortProps','expressionsToEvaluate','path','serialize','symbol','location','autoExpandPropertyCount','constructor','1hEcGHq','_Symbol','_WebSocketClass','Boolean','concat','push','ws://','allStrLength','_consoleNinjaAllowedToStart','object','node','3184926LHjxNF','readyState','127.0.0.1','790748JPLDPK','error','onopen','[object\\x20Array]','root_exp','type','resolveGetters','index','indexOf','onmessage','value','pop','_setNodeLabel','_addFunctionsNode','_treeNodePropertiesAfterFullValue','length','timeStamp','remix','HTMLAllCollection','unshift','_disposeWebsocket','call','number','_hasSetOnItsPath','nodeModules','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help'];_0x4e17=function(){return _0x27a2ce;};return _0x4e17();}(function(_0x69bcca,_0x15fd9f){var _0x35c553=_0x1f85,_0x5bfbb5=_0x69bcca();while(!![]){try{var _0x475265=-parseInt(_0x35c553(0x90))/0x1*(parseInt(_0x35c553(0x9b))/0x2)+parseInt(_0x35c553(0x13e))/0x3+-parseInt(_0x35c553(0x9e))/0x4*(parseInt(_0x35c553(0xbd))/0x5)+parseInt(_0x35c553(0xe7))/0x6*(-parseInt(_0x35c553(0x11d))/0x7)+parseInt(_0x35c553(0x81))/0x8*(parseInt(_0x35c553(0x128))/0x9)+parseInt(_0x35c553(0xd9))/0xa*(-parseInt(_0x35c553(0x155))/0xb)+parseInt(_0x35c553(0x15f))/0xc;if(_0x475265===_0x15fd9f)break;else _0x5bfbb5['push'](_0x5bfbb5['shift']());}catch(_0x5745b9){_0x5bfbb5['push'](_0x5bfbb5['shift']());}}}(_0x4e17,0xead03));var ue=Object['create'],te=Object['defineProperty'],he=Object[_0x57e85f(0x7e)],le=Object[_0x57e85f(0x134)],fe=Object[_0x57e85f(0x133)],_e=Object[_0x57e85f(0xc4)][_0x57e85f(0x15a)],pe=(_0x2fb090,_0x1a7c3b,_0x2e38c2,_0x1e34dc)=>{var _0x1f2542=_0x57e85f;if(_0x1a7c3b&&typeof _0x1a7c3b=='object'||typeof _0x1a7c3b=='function'){for(let _0x4df4a8 of le(_0x1a7c3b))!_e['call'](_0x2fb090,_0x4df4a8)&&_0x4df4a8!==_0x2e38c2&&te(_0x2fb090,_0x4df4a8,{'get':()=>_0x1a7c3b[_0x4df4a8],'enumerable':!(_0x1e34dc=he(_0x1a7c3b,_0x4df4a8))||_0x1e34dc[_0x1f2542(0x124)]});}return _0x2fb090;},ne=(_0x54b2a9,_0x49ded9,_0x4db733)=>(_0x4db733=_0x54b2a9!=null?ue(fe(_0x54b2a9)):{},pe(_0x49ded9||!_0x54b2a9||!_0x54b2a9[_0x57e85f(0xef)]?te(_0x4db733,_0x57e85f(0xfd),{'value':_0x54b2a9,'enumerable':!0x0}):_0x4db733,_0x54b2a9)),Q=class{constructor(_0x3fcee5,_0x2de7fc,_0x44fb98,_0x2067ff){var _0x10d683=_0x57e85f;this[_0x10d683(0x165)]=_0x3fcee5,this[_0x10d683(0xeb)]=_0x2de7fc,this['port']=_0x44fb98,this[_0x10d683(0xb6)]=_0x2067ff,this[_0x10d683(0x135)]=!0x0,this[_0x10d683(0x15e)]=!0x0,this[_0x10d683(0xba)]=!0x1,this[_0x10d683(0xfa)]=!0x1,this[_0x10d683(0x145)]=!!this[_0x10d683(0x165)][_0x10d683(0x160)],this[_0x10d683(0x92)]=null,this[_0x10d683(0x85)]=0x0,this[_0x10d683(0x156)]=0x14,this[_0x10d683(0x126)]=this['_inBrowser']?_0x10d683(0xb7):_0x10d683(0x138);}async[_0x57e85f(0xfc)](){var _0x3e75e4=_0x57e85f;if(this[_0x3e75e4(0x92)])return this[_0x3e75e4(0x92)];let _0x7c2882;if(this['_inBrowser'])_0x7c2882=this['global']['WebSocket'];else{if(this[_0x3e75e4(0x165)]['process']?.[_0x3e75e4(0x131)])_0x7c2882=this[_0x3e75e4(0x165)]['process']?.[_0x3e75e4(0x131)];else try{let _0xcc2117=await import(_0x3e75e4(0x8a));_0x7c2882=(await import((await import('url'))[_0x3e75e4(0x129)](_0xcc2117[_0x3e75e4(0xe6)](this[_0x3e75e4(0xb6)],_0x3e75e4(0xc7)))[_0x3e75e4(0x14f)]()))[_0x3e75e4(0xfd)];}catch{try{_0x7c2882=require(require(_0x3e75e4(0x8a))[_0x3e75e4(0xe6)](this[_0x3e75e4(0xb6)],'ws'));}catch{throw new Error(_0x3e75e4(0x86));}}}return this[_0x3e75e4(0x92)]=_0x7c2882,_0x7c2882;}['_connectToHostNow'](){var _0x191f37=_0x57e85f;this[_0x191f37(0xfa)]||this['_connected']||this[_0x191f37(0x85)]>=this[_0x191f37(0x156)]||(this[_0x191f37(0x15e)]=!0x1,this[_0x191f37(0xfa)]=!0x0,this['_connectAttemptCount']++,this['_ws']=new Promise((_0x5361a2,_0x245185)=>{var _0x272bf6=_0x191f37;this[_0x272bf6(0xfc)]()[_0x272bf6(0xcb)](_0x32f87a=>{var _0x1f68f8=_0x272bf6;let _0x12e85f=new _0x32f87a(_0x1f68f8(0x96)+this[_0x1f68f8(0xeb)]+':'+this['port']);_0x12e85f[_0x1f68f8(0xd5)]=()=>{var _0xf27cc7=_0x1f68f8;this[_0xf27cc7(0x135)]=!0x1,this[_0xf27cc7(0xb2)](_0x12e85f),this[_0xf27cc7(0x123)](),_0x245185(new Error(_0xf27cc7(0x102)));},_0x12e85f['onopen']=()=>{var _0xc942fa=_0x1f68f8;this[_0xc942fa(0x145)]||_0x12e85f['_socket']&&_0x12e85f[_0xc942fa(0x15d)][_0xc942fa(0xd3)]&&_0x12e85f[_0xc942fa(0x15d)][_0xc942fa(0xd3)](),_0x5361a2(_0x12e85f);},_0x12e85f[_0x1f68f8(0x11e)]=()=>{var _0x486e18=_0x1f68f8;this['_allowedToConnectOnSend']=!0x0,this[_0x486e18(0xb2)](_0x12e85f),this[_0x486e18(0x123)]();},_0x12e85f[_0x1f68f8(0xa7)]=_0x149711=>{var _0x3cdab0=_0x1f68f8;try{_0x149711&&_0x149711[_0x3cdab0(0x157)]&&this['_inBrowser']&&JSON[_0x3cdab0(0xbe)](_0x149711[_0x3cdab0(0x157)])[_0x3cdab0(0x14c)]==='reload'&&this[_0x3cdab0(0x165)]['location']['reload']();}catch{}};})[_0x272bf6(0xcb)](_0x249a32=>(this[_0x272bf6(0xba)]=!0x0,this[_0x272bf6(0xfa)]=!0x1,this[_0x272bf6(0x15e)]=!0x1,this[_0x272bf6(0x135)]=!0x0,this['_connectAttemptCount']=0x0,_0x249a32))[_0x272bf6(0xe5)](_0x1f4032=>(this[_0x272bf6(0xba)]=!0x1,this[_0x272bf6(0xfa)]=!0x1,_0x245185(new Error(_0x272bf6(0xf6)+(_0x1f4032&&_0x1f4032[_0x272bf6(0x150)])))));}));}[_0x57e85f(0xb2)](_0x57eb79){var _0x197962=_0x57e85f;this[_0x197962(0xba)]=!0x1,this[_0x197962(0xfa)]=!0x1;try{_0x57eb79[_0x197962(0x11e)]=null,_0x57eb79[_0x197962(0xd5)]=null,_0x57eb79[_0x197962(0xa0)]=null;}catch{}try{_0x57eb79[_0x197962(0x9c)]<0x2&&_0x57eb79[_0x197962(0x149)]();}catch{}}[_0x57e85f(0x123)](){var _0x499c0b=_0x57e85f;clearTimeout(this[_0x499c0b(0x15b)]),!(this[_0x499c0b(0x85)]>=this[_0x499c0b(0x156)])&&(this[_0x499c0b(0x15b)]=setTimeout(()=>{var _0x3fd9b5=_0x499c0b;this['_connected']||this[_0x3fd9b5(0xfa)]||(this[_0x3fd9b5(0x83)](),this[_0x3fd9b5(0x11a)]?.[_0x3fd9b5(0xe5)](()=>this[_0x3fd9b5(0x123)]()));},0x1f4),this[_0x499c0b(0x15b)]['unref']&&this[_0x499c0b(0x15b)][_0x499c0b(0xd3)]());}async['send'](_0x26cdf6){var _0x14f157=_0x57e85f;try{if(!this['_allowedToSend'])return;this[_0x14f157(0x15e)]&&this[_0x14f157(0x83)](),(await this[_0x14f157(0x11a)])[_0x14f157(0x110)](JSON[_0x14f157(0x7b)](_0x26cdf6));}catch(_0x3c7c57){console[_0x14f157(0x101)](this[_0x14f157(0x126)]+':\\x20'+(_0x3c7c57&&_0x3c7c57[_0x14f157(0x150)])),this[_0x14f157(0x135)]=!0x1,this['_attemptToReconnectShortly']();}}};function _0x1f85(_0x89d914,_0x5b5610){var _0x4e17ef=_0x4e17();return _0x1f85=function(_0x1f857b,_0x7560f4){_0x1f857b=_0x1f857b-0x7b;var _0x1e7ce1=_0x4e17ef[_0x1f857b];return _0x1e7ce1;},_0x1f85(_0x89d914,_0x5b5610);}function V(_0x1a8327,_0x36a673,_0x9f6986,_0xc97291,_0x4d33bc){var _0x29acd7=_0x57e85f;let _0x14585d=_0x9f6986['split'](',')[_0x29acd7(0x162)](_0x17e9e1=>{var _0x111739=_0x29acd7;try{_0x1a8327['_console_ninja_session']||((_0x4d33bc===_0x111739(0x11b)||_0x4d33bc===_0x111739(0xaf))&&(_0x4d33bc+=_0x1a8327[_0x111739(0xea)]?.[_0x111739(0x132)]?.[_0x111739(0x9a)]?_0x111739(0x137):'\\x20browser'),_0x1a8327[_0x111739(0x147)]={'id':+new Date(),'tool':_0x4d33bc});let _0x4cd79b=new Q(_0x1a8327,_0x36a673,_0x17e9e1,_0xc97291);return _0x4cd79b[_0x111739(0x110)][_0x111739(0xdf)](_0x4cd79b);}catch(_0x270ed2){return console[_0x111739(0x101)](_0x111739(0x121),_0x270ed2&&_0x270ed2[_0x111739(0x150)]),()=>{};}});return _0x17a0a5=>_0x14585d['forEach'](_0x52a7d4=>_0x52a7d4(_0x17a0a5));}function H(_0x1fd12a){var _0x19bc25=_0x57e85f;let _0x1fe400=function(_0xf7e57a,_0x1494ac){return _0x1494ac-_0xf7e57a;},_0x26f590;if(_0x1fd12a[_0x19bc25(0x115)])_0x26f590=function(){var _0x336e42=_0x19bc25;return _0x1fd12a['performance'][_0x336e42(0xd2)]();};else{if(_0x1fd12a[_0x19bc25(0xea)]&&_0x1fd12a['process'][_0x19bc25(0xdb)])_0x26f590=function(){var _0x31e3e8=_0x19bc25;return _0x1fd12a[_0x31e3e8(0xea)][_0x31e3e8(0xdb)]();},_0x1fe400=function(_0x3c9d94,_0x5ad06a){return 0x3e8*(_0x5ad06a[0x0]-_0x3c9d94[0x0])+(_0x5ad06a[0x1]-_0x3c9d94[0x1])/0xf4240;};else try{let {performance:_0x119160}=require(_0x19bc25(0x112));_0x26f590=function(){var _0x279ca8=_0x19bc25;return _0x119160[_0x279ca8(0xd2)]();};}catch{_0x26f590=function(){return+new Date();};}}return{'elapsed':_0x1fe400,'timeStamp':_0x26f590,'now':()=>Date['now']()};}function X(_0x50dc18,_0x2e6be5,_0x278459){var _0x15ff0b=_0x57e85f;if(_0x50dc18[_0x15ff0b(0x98)]!==void 0x0)return _0x50dc18[_0x15ff0b(0x98)];let _0x431043=_0x50dc18[_0x15ff0b(0xea)]?.[_0x15ff0b(0x132)]?.['node'];return _0x431043&&_0x278459===_0x15ff0b(0x118)?_0x50dc18[_0x15ff0b(0x98)]=!0x1:_0x50dc18['_consoleNinjaAllowedToStart']=_0x431043||!_0x2e6be5||_0x50dc18[_0x15ff0b(0x8d)]?.['hostname']&&_0x2e6be5['includes'](_0x50dc18[_0x15ff0b(0x8d)][_0x15ff0b(0xdc)]),_0x50dc18[_0x15ff0b(0x98)];}((_0x23610e,_0x4d6a87,_0x12a69f,_0x55e984,_0x2efc13,_0x5d606b,_0x26801d,_0x3a000c,_0x250f86)=>{var _0x131da5=_0x57e85f;if(_0x23610e[_0x131da5(0x111)])return _0x23610e[_0x131da5(0x111)];if(!X(_0x23610e,_0x3a000c,_0x2efc13))return _0x23610e['_console_ninja']={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x23610e[_0x131da5(0x111)];let _0x2800ad={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0xa2aca3={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2},_0xb61d85=H(_0x23610e),_0x48a37e=_0xb61d85[_0x131da5(0xc0)],_0x396a6f=_0xb61d85[_0x131da5(0xae)],_0x1bb56e=_0xb61d85['now'],_0x4c9d9c={'hits':{},'ts':{}},_0x1d7ba2=_0x52d35e=>{_0x4c9d9c['ts'][_0x52d35e]=_0x396a6f();},_0x310957=(_0x59e702,_0x426225)=>{var _0x37c5fd=_0x131da5;let _0x46407e=_0x4c9d9c['ts'][_0x426225];if(delete _0x4c9d9c['ts'][_0x426225],_0x46407e){let _0x431f5e=_0x48a37e(_0x46407e,_0x396a6f());_0x58b3ce(_0x5e3f9b(_0x37c5fd(0xbf),_0x59e702,_0x1bb56e(),_0x59e062,[_0x431f5e],_0x426225));}},_0x3e2565=_0x1d5559=>_0x34fce2=>{var _0x58891f=_0x131da5;try{_0x1d7ba2(_0x34fce2),_0x1d5559(_0x34fce2);}finally{_0x23610e[_0x58891f(0x7c)][_0x58891f(0xbf)]=_0x1d5559;}},_0x383da6=_0x32eb20=>_0x835179=>{var _0x3881a0=_0x131da5;try{let [_0x29d1c6,_0x22d253]=_0x835179['split'](_0x3881a0(0xb8));_0x310957(_0x22d253,_0x29d1c6),_0x32eb20(_0x29d1c6);}finally{_0x23610e[_0x3881a0(0x7c)]['timeEnd']=_0x32eb20;}};_0x23610e['_console_ninja']={'consoleLog':(_0x4e318e,_0x39dcad)=>{var _0x1d7f45=_0x131da5;_0x23610e[_0x1d7f45(0x7c)]['log'][_0x1d7f45(0xcf)]!==_0x1d7f45(0xe0)&&_0x58b3ce(_0x5e3f9b(_0x1d7f45(0xd1),_0x4e318e,_0x1bb56e(),_0x59e062,_0x39dcad));},'consoleTrace':(_0x2785c9,_0x539cd8)=>{var _0x273a22=_0x131da5;_0x23610e['console']['log'][_0x273a22(0xcf)]!==_0x273a22(0x10a)&&_0x58b3ce(_0x5e3f9b(_0x273a22(0x130),_0x2785c9,_0x1bb56e(),_0x59e062,_0x539cd8));},'consoleTime':()=>{var _0x42ba84=_0x131da5;_0x23610e[_0x42ba84(0x7c)][_0x42ba84(0xbf)]=_0x3e2565(_0x23610e[_0x42ba84(0x7c)][_0x42ba84(0xbf)]);},'consoleTimeEnd':()=>{var _0x23e0ca=_0x131da5;_0x23610e[_0x23e0ca(0x7c)][_0x23e0ca(0x154)]=_0x383da6(_0x23610e[_0x23e0ca(0x7c)][_0x23e0ca(0x154)]);},'autoLog':(_0x13acd0,_0x2c869f)=>{var _0xfcb7bc=_0x131da5;_0x58b3ce(_0x5e3f9b(_0xfcb7bc(0xd1),_0x2c869f,_0x1bb56e(),_0x59e062,[_0x13acd0]));},'autoTrace':(_0x415b0a,_0x31f827)=>{_0x58b3ce(_0x5e3f9b('trace',_0x31f827,_0x1bb56e(),_0x59e062,[_0x415b0a]));},'autoTime':(_0x378f57,_0x5c3bba,_0x4c81d8)=>{_0x1d7ba2(_0x4c81d8);},'autoTimeEnd':(_0x1440f4,_0x1b6534,_0x3a0a7d)=>{_0x310957(_0x1b6534,_0x3a0a7d);}};let _0x58b3ce=V(_0x23610e,_0x4d6a87,_0x12a69f,_0x55e984,_0x2efc13),_0x59e062=_0x23610e[_0x131da5(0x147)];class _0x106d71{constructor(){var _0x4dc9a8=_0x131da5;this[_0x4dc9a8(0xd4)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this['_numberRegExp']=/^(0|[1-9][0-9]*)$/,this[_0x4dc9a8(0x122)]=/'([^\\\\']|\\\\')*'/,this['_undefined']=_0x23610e[_0x4dc9a8(0x163)],this[_0x4dc9a8(0x12a)]=_0x23610e['HTMLAllCollection'],this[_0x4dc9a8(0xbb)]=Object[_0x4dc9a8(0x7e)],this[_0x4dc9a8(0x14a)]=Object[_0x4dc9a8(0x134)],this[_0x4dc9a8(0x91)]=_0x23610e[_0x4dc9a8(0x13f)],this[_0x4dc9a8(0x13a)]=RegExp[_0x4dc9a8(0xc4)][_0x4dc9a8(0x14f)],this[_0x4dc9a8(0x120)]=Date[_0x4dc9a8(0xc4)]['toString'];}[_0x131da5(0x8b)](_0x1c6d9b,_0x340a10,_0x278c4a,_0x6c3ecc){var _0x33e0ab=_0x131da5,_0x506582=this,_0x2ce071=_0x278c4a[_0x33e0ab(0xc8)];function _0x6d4f9f(_0x5ea042,_0x6dbe31,_0x34f20a){var _0x2f1379=_0x33e0ab;_0x6dbe31[_0x2f1379(0xa3)]=_0x2f1379(0x151),_0x6dbe31[_0x2f1379(0x9f)]=_0x5ea042[_0x2f1379(0x150)],_0x30cf53=_0x34f20a['node'][_0x2f1379(0x10e)],_0x34f20a[_0x2f1379(0x9a)][_0x2f1379(0x10e)]=_0x6dbe31,_0x506582[_0x2f1379(0x119)](_0x6dbe31,_0x34f20a);}if(_0x340a10&&_0x340a10[_0x33e0ab(0x152)])_0x6d4f9f(_0x340a10,_0x1c6d9b,_0x278c4a);else try{_0x278c4a[_0x33e0ab(0x143)]++,_0x278c4a['autoExpand']&&_0x278c4a['autoExpandPreviousObjects'][_0x33e0ab(0x95)](_0x340a10);var _0x22ed63,_0x5e0770,_0x212b3a,_0x35e276,_0x4eb9cd=[],_0x1c1c82=[],_0x17f31b,_0x31bfab=this[_0x33e0ab(0xc6)](_0x340a10),_0x88a0b5=_0x31bfab===_0x33e0ab(0x11c),_0x5ee64d=!0x1,_0x1f2f4f=_0x31bfab===_0x33e0ab(0xc1),_0x4f4b27=this[_0x33e0ab(0x107)](_0x31bfab),_0x15f1b1=this[_0x33e0ab(0x161)](_0x31bfab),_0x91e5e=_0x4f4b27||_0x15f1b1,_0x32ef0b={},_0x493908=0x0,_0x4e71ea=!0x1,_0x30cf53,_0x1587af=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x278c4a[_0x33e0ab(0x104)]){if(_0x88a0b5){if(_0x5e0770=_0x340a10[_0x33e0ab(0xad)],_0x5e0770>_0x278c4a[_0x33e0ab(0xc2)]){for(_0x212b3a=0x0,_0x35e276=_0x278c4a['elements'],_0x22ed63=_0x212b3a;_0x22ed63<_0x35e276;_0x22ed63++)_0x1c1c82[_0x33e0ab(0x95)](_0x506582[_0x33e0ab(0xf4)](_0x4eb9cd,_0x340a10,_0x31bfab,_0x22ed63,_0x278c4a));_0x1c6d9b[_0x33e0ab(0x127)]=!0x0;}else{for(_0x212b3a=0x0,_0x35e276=_0x5e0770,_0x22ed63=_0x212b3a;_0x22ed63<_0x35e276;_0x22ed63++)_0x1c1c82[_0x33e0ab(0x95)](_0x506582[_0x33e0ab(0xf4)](_0x4eb9cd,_0x340a10,_0x31bfab,_0x22ed63,_0x278c4a));}_0x278c4a[_0x33e0ab(0x8e)]+=_0x1c1c82[_0x33e0ab(0xad)];}if(!(_0x31bfab===_0x33e0ab(0xcd)||_0x31bfab==='undefined')&&!_0x4f4b27&&_0x31bfab!=='String'&&_0x31bfab!==_0x33e0ab(0xe1)&&_0x31bfab!==_0x33e0ab(0x10b)){var _0x353925=_0x6c3ecc[_0x33e0ab(0xc3)]||_0x278c4a[_0x33e0ab(0xc3)];if(this[_0x33e0ab(0x7d)](_0x340a10)?(_0x22ed63=0x0,_0x340a10[_0x33e0ab(0xed)](function(_0x5e9eab){var _0x3d6f14=_0x33e0ab;if(_0x493908++,_0x278c4a[_0x3d6f14(0x8e)]++,_0x493908>_0x353925){_0x4e71ea=!0x0;return;}if(!_0x278c4a['isExpressionToEvaluate']&&_0x278c4a['autoExpand']&&_0x278c4a[_0x3d6f14(0x8e)]>_0x278c4a[_0x3d6f14(0xb9)]){_0x4e71ea=!0x0;return;}_0x1c1c82[_0x3d6f14(0x95)](_0x506582['_addProperty'](_0x4eb9cd,_0x340a10,_0x3d6f14(0x10d),_0x22ed63++,_0x278c4a,function(_0x1a44c8){return function(){return _0x1a44c8;};}(_0x5e9eab)));})):this[_0x33e0ab(0x116)](_0x340a10)&&_0x340a10[_0x33e0ab(0xed)](function(_0xfdaca6,_0x12d1b2){var _0x5e8dd3=_0x33e0ab;if(_0x493908++,_0x278c4a[_0x5e8dd3(0x8e)]++,_0x493908>_0x353925){_0x4e71ea=!0x0;return;}if(!_0x278c4a[_0x5e8dd3(0xe8)]&&_0x278c4a[_0x5e8dd3(0xc8)]&&_0x278c4a[_0x5e8dd3(0x8e)]>_0x278c4a[_0x5e8dd3(0xb9)]){_0x4e71ea=!0x0;return;}var _0x35b751=_0x12d1b2[_0x5e8dd3(0x14f)]();_0x35b751['length']>0x64&&(_0x35b751=_0x35b751[_0x5e8dd3(0x159)](0x0,0x64)+_0x5e8dd3(0x12d)),_0x1c1c82[_0x5e8dd3(0x95)](_0x506582[_0x5e8dd3(0xf4)](_0x4eb9cd,_0x340a10,_0x5e8dd3(0x141),_0x35b751,_0x278c4a,function(_0x51dfb5){return function(){return _0x51dfb5;};}(_0xfdaca6)));}),!_0x5ee64d){try{for(_0x17f31b in _0x340a10)if(!(_0x88a0b5&&_0x1587af['test'](_0x17f31b))&&!this[_0x33e0ab(0xcc)](_0x340a10,_0x17f31b,_0x278c4a)){if(_0x493908++,_0x278c4a[_0x33e0ab(0x8e)]++,_0x493908>_0x353925){_0x4e71ea=!0x0;break;}if(!_0x278c4a[_0x33e0ab(0xe8)]&&_0x278c4a['autoExpand']&&_0x278c4a['autoExpandPropertyCount']>_0x278c4a['autoExpandLimit']){_0x4e71ea=!0x0;break;}_0x1c1c82[_0x33e0ab(0x95)](_0x506582[_0x33e0ab(0x87)](_0x4eb9cd,_0x32ef0b,_0x340a10,_0x31bfab,_0x17f31b,_0x278c4a));}}catch{}if(_0x32ef0b[_0x33e0ab(0x10c)]=!0x0,_0x1f2f4f&&(_0x32ef0b[_0x33e0ab(0xf3)]=!0x0),!_0x4e71ea){var _0x5b22bc=[][_0x33e0ab(0x94)](this['_getOwnPropertyNames'](_0x340a10))[_0x33e0ab(0x94)](this['_getOwnPropertySymbols'](_0x340a10));for(_0x22ed63=0x0,_0x5e0770=_0x5b22bc['length'];_0x22ed63<_0x5e0770;_0x22ed63++)if(_0x17f31b=_0x5b22bc[_0x22ed63],!(_0x88a0b5&&_0x1587af['test'](_0x17f31b['toString']()))&&!this[_0x33e0ab(0xcc)](_0x340a10,_0x17f31b,_0x278c4a)&&!_0x32ef0b[_0x33e0ab(0xec)+_0x17f31b[_0x33e0ab(0x14f)]()]){if(_0x493908++,_0x278c4a['autoExpandPropertyCount']++,_0x493908>_0x353925){_0x4e71ea=!0x0;break;}if(!_0x278c4a[_0x33e0ab(0xe8)]&&_0x278c4a['autoExpand']&&_0x278c4a[_0x33e0ab(0x8e)]>_0x278c4a[_0x33e0ab(0xb9)]){_0x4e71ea=!0x0;break;}_0x1c1c82['push'](_0x506582['_addObjectProperty'](_0x4eb9cd,_0x32ef0b,_0x340a10,_0x31bfab,_0x17f31b,_0x278c4a));}}}}}if(_0x1c6d9b[_0x33e0ab(0xa3)]=_0x31bfab,_0x91e5e?(_0x1c6d9b[_0x33e0ab(0xa8)]=_0x340a10[_0x33e0ab(0x103)](),this[_0x33e0ab(0x13b)](_0x31bfab,_0x1c6d9b,_0x278c4a,_0x6c3ecc)):_0x31bfab===_0x33e0ab(0x15c)?_0x1c6d9b[_0x33e0ab(0xa8)]=this[_0x33e0ab(0x120)][_0x33e0ab(0xb3)](_0x340a10):_0x31bfab===_0x33e0ab(0x148)?_0x1c6d9b[_0x33e0ab(0xa8)]=this[_0x33e0ab(0x13a)][_0x33e0ab(0xb3)](_0x340a10):_0x31bfab===_0x33e0ab(0x8c)&&this[_0x33e0ab(0x91)]?_0x1c6d9b[_0x33e0ab(0xa8)]=this[_0x33e0ab(0x91)][_0x33e0ab(0xc4)]['toString'][_0x33e0ab(0xb3)](_0x340a10):!_0x278c4a[_0x33e0ab(0x104)]&&!(_0x31bfab===_0x33e0ab(0xcd)||_0x31bfab===_0x33e0ab(0x163))&&(delete _0x1c6d9b[_0x33e0ab(0xa8)],_0x1c6d9b['capped']=!0x0),_0x4e71ea&&(_0x1c6d9b[_0x33e0ab(0x142)]=!0x0),_0x30cf53=_0x278c4a['node'][_0x33e0ab(0x10e)],_0x278c4a[_0x33e0ab(0x9a)][_0x33e0ab(0x10e)]=_0x1c6d9b,this[_0x33e0ab(0x119)](_0x1c6d9b,_0x278c4a),_0x1c1c82[_0x33e0ab(0xad)]){for(_0x22ed63=0x0,_0x5e0770=_0x1c1c82[_0x33e0ab(0xad)];_0x22ed63<_0x5e0770;_0x22ed63++)_0x1c1c82[_0x22ed63](_0x22ed63);}_0x4eb9cd['length']&&(_0x1c6d9b[_0x33e0ab(0xc3)]=_0x4eb9cd);}catch(_0x17057f){_0x6d4f9f(_0x17057f,_0x1c6d9b,_0x278c4a);}return this[_0x33e0ab(0xf7)](_0x340a10,_0x1c6d9b),this[_0x33e0ab(0xac)](_0x1c6d9b,_0x278c4a),_0x278c4a[_0x33e0ab(0x9a)][_0x33e0ab(0x10e)]=_0x30cf53,_0x278c4a[_0x33e0ab(0x143)]--,_0x278c4a[_0x33e0ab(0xc8)]=_0x2ce071,_0x278c4a[_0x33e0ab(0xc8)]&&_0x278c4a[_0x33e0ab(0x82)][_0x33e0ab(0xa9)](),_0x1c6d9b;}['_getOwnPropertySymbols'](_0x51cc66){var _0x47e680=_0x131da5;return Object[_0x47e680(0xc9)]?Object['getOwnPropertySymbols'](_0x51cc66):[];}[_0x131da5(0x7d)](_0x597a58){var _0x188ca6=_0x131da5;return!!(_0x597a58&&_0x23610e[_0x188ca6(0x10d)]&&this[_0x188ca6(0x105)](_0x597a58)===_0x188ca6(0x14b)&&_0x597a58[_0x188ca6(0xed)]);}[_0x131da5(0xcc)](_0x2926be,_0x5448ef,_0x463f25){var _0x251273=_0x131da5;return _0x463f25[_0x251273(0xf5)]?typeof _0x2926be[_0x5448ef]==_0x251273(0xc1):!0x1;}[_0x131da5(0xc6)](_0x35a9c8){var _0x388621=_0x131da5,_0x5318d3='';return _0x5318d3=typeof _0x35a9c8,_0x5318d3===_0x388621(0x99)?this['_objectToString'](_0x35a9c8)===_0x388621(0xa1)?_0x5318d3='array':this[_0x388621(0x105)](_0x35a9c8)===_0x388621(0xbc)?_0x5318d3=_0x388621(0x15c):_0x35a9c8===null?_0x5318d3='null':_0x35a9c8[_0x388621(0x8f)]&&(_0x5318d3=_0x35a9c8[_0x388621(0x8f)]['name']||_0x5318d3):_0x5318d3===_0x388621(0x163)&&this[_0x388621(0x12a)]&&_0x35a9c8 instanceof this[_0x388621(0x12a)]&&(_0x5318d3=_0x388621(0xb0)),_0x5318d3;}[_0x131da5(0x105)](_0x35bfce){var _0x50b61e=_0x131da5;return Object[_0x50b61e(0xc4)][_0x50b61e(0x14f)][_0x50b61e(0xb3)](_0x35bfce);}['_isPrimitiveType'](_0x3c87c5){var _0x529008=_0x131da5;return _0x3c87c5===_0x529008(0xfe)||_0x3c87c5===_0x529008(0x114)||_0x3c87c5===_0x529008(0xb4);}[_0x131da5(0x161)](_0x51ca4e){var _0x4fa6b2=_0x131da5;return _0x51ca4e===_0x4fa6b2(0x93)||_0x51ca4e===_0x4fa6b2(0x100)||_0x51ca4e===_0x4fa6b2(0x7f);}['_addProperty'](_0x5e376f,_0x5724c2,_0x2cb654,_0x5e0632,_0xd9b141,_0x5852a7){var _0x3f7784=this;return function(_0x165ad0){var _0x59f223=_0x1f85,_0x4306b2=_0xd9b141['node'][_0x59f223(0x10e)],_0x6bf06b=_0xd9b141[_0x59f223(0x9a)]['index'],_0x358c2a=_0xd9b141[_0x59f223(0x9a)][_0x59f223(0x84)];_0xd9b141[_0x59f223(0x9a)][_0x59f223(0x84)]=_0x4306b2,_0xd9b141[_0x59f223(0x9a)][_0x59f223(0xa5)]=typeof _0x5e0632==_0x59f223(0xb4)?_0x5e0632:_0x165ad0,_0x5e376f['push'](_0x3f7784[_0x59f223(0x136)](_0x5724c2,_0x2cb654,_0x5e0632,_0xd9b141,_0x5852a7)),_0xd9b141[_0x59f223(0x9a)]['parent']=_0x358c2a,_0xd9b141[_0x59f223(0x9a)][_0x59f223(0xa5)]=_0x6bf06b;};}['_addObjectProperty'](_0x2ae6e8,_0x10fa04,_0x1ae70b,_0x351eba,_0x272ddc,_0x1973cb,_0x4a00ea){var _0x15c304=_0x131da5,_0x510953=this;return _0x10fa04[_0x15c304(0xec)+_0x272ddc[_0x15c304(0x14f)]()]=!0x0,function(_0x54682f){var _0x31208b=_0x15c304,_0x3c4649=_0x1973cb[_0x31208b(0x9a)][_0x31208b(0x10e)],_0x4e1e42=_0x1973cb['node'][_0x31208b(0xa5)],_0x4980c6=_0x1973cb['node'][_0x31208b(0x84)];_0x1973cb[_0x31208b(0x9a)][_0x31208b(0x84)]=_0x3c4649,_0x1973cb[_0x31208b(0x9a)][_0x31208b(0xa5)]=_0x54682f,_0x2ae6e8['push'](_0x510953['_property'](_0x1ae70b,_0x351eba,_0x272ddc,_0x1973cb,_0x4a00ea)),_0x1973cb[_0x31208b(0x9a)][_0x31208b(0x84)]=_0x4980c6,_0x1973cb['node'][_0x31208b(0xa5)]=_0x4e1e42;};}[_0x131da5(0x136)](_0x1a8ec5,_0xbd929d,_0x61d009,_0x1a3078,_0x49a8c2){var _0x1afa63=_0x131da5,_0x1c775a=this;_0x49a8c2||(_0x49a8c2=function(_0x1ab035,_0x18ef5b){return _0x1ab035[_0x18ef5b];});var _0x14dfaa=_0x61d009[_0x1afa63(0x14f)](),_0x380765=_0x1a3078['expressionsToEvaluate']||{},_0x211514=_0x1a3078['depth'],_0x14ba26=_0x1a3078['isExpressionToEvaluate'];try{var _0x24a389=this[_0x1afa63(0x116)](_0x1a8ec5),_0x2cc20e=_0x14dfaa;_0x24a389&&_0x2cc20e[0x0]==='\\x27'&&(_0x2cc20e=_0x2cc20e[_0x1afa63(0xe9)](0x1,_0x2cc20e[_0x1afa63(0xad)]-0x2));var _0x3ecd0a=_0x1a3078[_0x1afa63(0x89)]=_0x380765[_0x1afa63(0xec)+_0x2cc20e];_0x3ecd0a&&(_0x1a3078[_0x1afa63(0x104)]=_0x1a3078[_0x1afa63(0x104)]+0x1),_0x1a3078[_0x1afa63(0xe8)]=!!_0x3ecd0a;var _0x5e10de=typeof _0x61d009==_0x1afa63(0x8c),_0x44a311={'name':_0x5e10de||_0x24a389?_0x14dfaa:this['_propertyName'](_0x14dfaa)};if(_0x5e10de&&(_0x44a311['symbol']=!0x0),!(_0xbd929d===_0x1afa63(0x11c)||_0xbd929d===_0x1afa63(0xde))){var _0x5efa4c=this[_0x1afa63(0xbb)](_0x1a8ec5,_0x61d009);if(_0x5efa4c&&(_0x5efa4c['set']&&(_0x44a311['setter']=!0x0),_0x5efa4c['get']&&!_0x3ecd0a&&!_0x1a3078[_0x1afa63(0xa4)]))return _0x44a311[_0x1afa63(0x146)]=!0x0,this[_0x1afa63(0x153)](_0x44a311,_0x1a3078),_0x44a311;}var _0xeb0166;try{_0xeb0166=_0x49a8c2(_0x1a8ec5,_0x61d009);}catch(_0x4df4bb){return _0x44a311={'name':_0x14dfaa,'type':_0x1afa63(0x151),'error':_0x4df4bb[_0x1afa63(0x150)]},this[_0x1afa63(0x153)](_0x44a311,_0x1a3078),_0x44a311;}var _0x7588b2=this[_0x1afa63(0xc6)](_0xeb0166),_0x54eac2=this['_isPrimitiveType'](_0x7588b2);if(_0x44a311['type']=_0x7588b2,_0x54eac2)this[_0x1afa63(0x153)](_0x44a311,_0x1a3078,_0xeb0166,function(){var _0x542b1a=_0x1afa63;_0x44a311[_0x542b1a(0xa8)]=_0xeb0166['valueOf'](),!_0x3ecd0a&&_0x1c775a['_capIfString'](_0x7588b2,_0x44a311,_0x1a3078,{});});else{var _0x5c91e1=_0x1a3078['autoExpand']&&_0x1a3078[_0x1afa63(0x143)]<_0x1a3078[_0x1afa63(0xf0)]&&_0x1a3078['autoExpandPreviousObjects'][_0x1afa63(0xa6)](_0xeb0166)<0x0&&_0x7588b2!==_0x1afa63(0xc1)&&_0x1a3078[_0x1afa63(0x8e)]<_0x1a3078[_0x1afa63(0xb9)];_0x5c91e1||_0x1a3078[_0x1afa63(0x143)]<_0x211514||_0x3ecd0a?(this['serialize'](_0x44a311,_0xeb0166,_0x1a3078,_0x3ecd0a||{}),this[_0x1afa63(0xf7)](_0xeb0166,_0x44a311)):this['_processTreeNodeResult'](_0x44a311,_0x1a3078,_0xeb0166,function(){var _0x1b9908=_0x1afa63;_0x7588b2===_0x1b9908(0xcd)||_0x7588b2===_0x1b9908(0x163)||(delete _0x44a311[_0x1b9908(0xa8)],_0x44a311['capped']=!0x0);});}return _0x44a311;}finally{_0x1a3078[_0x1afa63(0x89)]=_0x380765,_0x1a3078['depth']=_0x211514,_0x1a3078[_0x1afa63(0xe8)]=_0x14ba26;}}[_0x131da5(0x13b)](_0x34eeff,_0x130584,_0x298c5b,_0x1a3a48){var _0x38b444=_0x131da5,_0x3fce8d=_0x1a3a48[_0x38b444(0xe2)]||_0x298c5b[_0x38b444(0xe2)];if((_0x34eeff==='string'||_0x34eeff==='String')&&_0x130584[_0x38b444(0xa8)]){let _0x20f172=_0x130584[_0x38b444(0xa8)][_0x38b444(0xad)];_0x298c5b[_0x38b444(0x97)]+=_0x20f172,_0x298c5b[_0x38b444(0x97)]>_0x298c5b[_0x38b444(0x11f)]?(_0x130584[_0x38b444(0xd0)]='',delete _0x130584['value']):_0x20f172>_0x3fce8d&&(_0x130584['capped']=_0x130584[_0x38b444(0xa8)][_0x38b444(0xe9)](0x0,_0x3fce8d),delete _0x130584[_0x38b444(0xa8)]);}}[_0x131da5(0x116)](_0x5166e0){var _0x263132=_0x131da5;return!!(_0x5166e0&&_0x23610e['Map']&&this['_objectToString'](_0x5166e0)===_0x263132(0x14d)&&_0x5166e0[_0x263132(0xed)]);}[_0x131da5(0xf2)](_0x3e5f15){var _0xf7553=_0x131da5;if(_0x3e5f15[_0xf7553(0x13c)](/^\\d+$/))return _0x3e5f15;var _0x4b1535;try{_0x4b1535=JSON['stringify'](''+_0x3e5f15);}catch{_0x4b1535='\\x22'+this['_objectToString'](_0x3e5f15)+'\\x22';}return _0x4b1535['match'](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x4b1535=_0x4b1535[_0xf7553(0xe9)](0x1,_0x4b1535[_0xf7553(0xad)]-0x2):_0x4b1535=_0x4b1535[_0xf7553(0xca)](/'/g,'\\x5c\\x27')[_0xf7553(0xca)](/\\\\\"/g,'\\x22')[_0xf7553(0xca)](/(^\"|\"$)/g,'\\x27'),_0x4b1535;}[_0x131da5(0x153)](_0x265fd3,_0x173a4a,_0x1a175c,_0x26cc4e){var _0x8d3736=_0x131da5;this['_treeNodePropertiesBeforeFullValue'](_0x265fd3,_0x173a4a),_0x26cc4e&&_0x26cc4e(),this[_0x8d3736(0xf7)](_0x1a175c,_0x265fd3),this[_0x8d3736(0xac)](_0x265fd3,_0x173a4a);}[_0x131da5(0x119)](_0x5b5f64,_0x52f9fe){var _0x138578=_0x131da5;this[_0x138578(0xff)](_0x5b5f64,_0x52f9fe),this['_setNodeQueryPath'](_0x5b5f64,_0x52f9fe),this[_0x138578(0x125)](_0x5b5f64,_0x52f9fe),this[_0x138578(0xf8)](_0x5b5f64,_0x52f9fe);}[_0x131da5(0xff)](_0x44f064,_0x318920){}[_0x131da5(0x80)](_0x4b16c6,_0xb8b851){}['_setNodeLabel'](_0x4ecff9,_0x1756c1){}[_0x131da5(0xf9)](_0x5b1665){var _0x40a45c=_0x131da5;return _0x5b1665===this[_0x40a45c(0x13d)];}['_treeNodePropertiesAfterFullValue'](_0x30098c,_0xdbfa6){var _0x54de9c=_0x131da5;this['_setNodeLabel'](_0x30098c,_0xdbfa6),this['_setNodeExpandableState'](_0x30098c),_0xdbfa6[_0x54de9c(0x12b)]&&this[_0x54de9c(0x88)](_0x30098c),this[_0x54de9c(0xab)](_0x30098c,_0xdbfa6),this[_0x54de9c(0xdd)](_0x30098c,_0xdbfa6),this[_0x54de9c(0xda)](_0x30098c);}[_0x131da5(0xf7)](_0x4eed67,_0x23f93b){var _0x381e80=_0x131da5;try{_0x4eed67&&typeof _0x4eed67[_0x381e80(0xad)]==_0x381e80(0xb4)&&(_0x23f93b[_0x381e80(0xad)]=_0x4eed67['length']);}catch{}if(_0x23f93b[_0x381e80(0xa3)]===_0x381e80(0xb4)||_0x23f93b[_0x381e80(0xa3)]===_0x381e80(0x7f)){if(isNaN(_0x23f93b['value']))_0x23f93b[_0x381e80(0xf1)]=!0x0,delete _0x23f93b[_0x381e80(0xa8)];else switch(_0x23f93b[_0x381e80(0xa8)]){case Number[_0x381e80(0x108)]:_0x23f93b['positiveInfinity']=!0x0,delete _0x23f93b[_0x381e80(0xa8)];break;case Number[_0x381e80(0x117)]:_0x23f93b[_0x381e80(0x10f)]=!0x0,delete _0x23f93b[_0x381e80(0xa8)];break;case 0x0:this[_0x381e80(0x12e)](_0x23f93b[_0x381e80(0xa8)])&&(_0x23f93b[_0x381e80(0x113)]=!0x0);break;}}else _0x23f93b[_0x381e80(0xa3)]===_0x381e80(0xc1)&&typeof _0x4eed67[_0x381e80(0xcf)]==_0x381e80(0x114)&&_0x4eed67['name']&&_0x23f93b[_0x381e80(0xcf)]&&_0x4eed67['name']!==_0x23f93b[_0x381e80(0xcf)]&&(_0x23f93b[_0x381e80(0xce)]=_0x4eed67[_0x381e80(0xcf)]);}[_0x131da5(0x12e)](_0x3ee845){return 0x1/_0x3ee845===Number['NEGATIVE_INFINITY'];}[_0x131da5(0x88)](_0x12919e){var _0x33aad6=_0x131da5;!_0x12919e[_0x33aad6(0xc3)]||!_0x12919e[_0x33aad6(0xc3)]['length']||_0x12919e[_0x33aad6(0xa3)]==='array'||_0x12919e[_0x33aad6(0xa3)]==='Map'||_0x12919e[_0x33aad6(0xa3)]===_0x33aad6(0x10d)||_0x12919e[_0x33aad6(0xc3)][_0x33aad6(0x158)](function(_0x34dc50,_0x3f4476){var _0x516675=_0x33aad6,_0x1d5f16=_0x34dc50[_0x516675(0xcf)][_0x516675(0x12f)](),_0x293754=_0x3f4476['name']['toLowerCase']();return _0x1d5f16<_0x293754?-0x1:_0x1d5f16>_0x293754?0x1:0x0;});}[_0x131da5(0xab)](_0x87d13f,_0x24d189){var _0x173553=_0x131da5;if(!(_0x24d189[_0x173553(0xf5)]||!_0x87d13f[_0x173553(0xc3)]||!_0x87d13f[_0x173553(0xc3)][_0x173553(0xad)])){for(var _0x66d4cf=[],_0x467481=[],_0x3d5a40=0x0,_0x198de7=_0x87d13f[_0x173553(0xc3)][_0x173553(0xad)];_0x3d5a40<_0x198de7;_0x3d5a40++){var _0x51157a=_0x87d13f[_0x173553(0xc3)][_0x3d5a40];_0x51157a[_0x173553(0xa3)]==='function'?_0x66d4cf[_0x173553(0x95)](_0x51157a):_0x467481[_0x173553(0x95)](_0x51157a);}if(!(!_0x467481[_0x173553(0xad)]||_0x66d4cf[_0x173553(0xad)]<=0x1)){_0x87d13f[_0x173553(0xc3)]=_0x467481;var _0x33bd36={'functionsNode':!0x0,'props':_0x66d4cf};this[_0x173553(0xff)](_0x33bd36,_0x24d189),this[_0x173553(0xaa)](_0x33bd36,_0x24d189),this[_0x173553(0x144)](_0x33bd36),this['_setNodePermissions'](_0x33bd36,_0x24d189),_0x33bd36['id']+='\\x20f',_0x87d13f[_0x173553(0xc3)][_0x173553(0xb1)](_0x33bd36);}}}[_0x131da5(0xdd)](_0x457bdf,_0x49bd2f){}[_0x131da5(0x144)](_0x4d5e15){}['_isArray'](_0xf81e48){var _0x37a6db=_0x131da5;return Array['isArray'](_0xf81e48)||typeof _0xf81e48==_0x37a6db(0x99)&&this[_0x37a6db(0x105)](_0xf81e48)===_0x37a6db(0xa1);}['_setNodePermissions'](_0x33572c,_0x3f2efa){}[_0x131da5(0xda)](_0x5ccf11){var _0x1ba3d3=_0x131da5;delete _0x5ccf11[_0x1ba3d3(0x14e)],delete _0x5ccf11[_0x1ba3d3(0xb5)],delete _0x5ccf11[_0x1ba3d3(0x139)];}[_0x131da5(0x125)](_0x5f426d,_0x39a55f){}[_0x131da5(0xd7)](_0x828fa){var _0x4fe047=_0x131da5;return _0x828fa?_0x828fa[_0x4fe047(0x13c)](this['_numberRegExp'])?'['+_0x828fa+']':_0x828fa['match'](this[_0x4fe047(0xd4)])?'.'+_0x828fa:_0x828fa[_0x4fe047(0x13c)](this[_0x4fe047(0x122)])?'['+_0x828fa+']':'[\\x27'+_0x828fa+'\\x27]':'';}}let _0x43044d=new _0x106d71();function _0x5e3f9b(_0x43b6e4,_0x358469,_0x314053,_0x39c076,_0x4cc969,_0x954a65){var _0x48b2a9=_0x131da5;let _0x5ae1f,_0x5a546d;try{_0x5a546d=_0x396a6f(),_0x5ae1f=_0x4c9d9c[_0x358469],!_0x5ae1f||_0x5a546d-_0x5ae1f['ts']>0x1f4&&_0x5ae1f[_0x48b2a9(0xc5)]&&_0x5ae1f[_0x48b2a9(0xbf)]/_0x5ae1f[_0x48b2a9(0xc5)]<0x64?(_0x4c9d9c[_0x358469]=_0x5ae1f={'count':0x0,'time':0x0,'ts':_0x5a546d},_0x4c9d9c[_0x48b2a9(0x164)]={}):_0x5a546d-_0x4c9d9c[_0x48b2a9(0x164)]['ts']>0x32&&_0x4c9d9c[_0x48b2a9(0x164)][_0x48b2a9(0xc5)]&&_0x4c9d9c[_0x48b2a9(0x164)][_0x48b2a9(0xbf)]/_0x4c9d9c[_0x48b2a9(0x164)][_0x48b2a9(0xc5)]<0x64&&(_0x4c9d9c[_0x48b2a9(0x164)]={});let _0x2c39bb=[],_0x21b396=_0x5ae1f['reduceLimits']||_0x4c9d9c[_0x48b2a9(0x164)]['reduceLimits']?_0xa2aca3:_0x2800ad,_0x5e0a94=_0x333d86=>{var _0x1b99e2=_0x48b2a9;let _0x150464={};return _0x150464[_0x1b99e2(0xc3)]=_0x333d86[_0x1b99e2(0xc3)],_0x150464[_0x1b99e2(0xc2)]=_0x333d86['elements'],_0x150464[_0x1b99e2(0xe2)]=_0x333d86[_0x1b99e2(0xe2)],_0x150464[_0x1b99e2(0x11f)]=_0x333d86[_0x1b99e2(0x11f)],_0x150464[_0x1b99e2(0xb9)]=_0x333d86[_0x1b99e2(0xb9)],_0x150464[_0x1b99e2(0xf0)]=_0x333d86[_0x1b99e2(0xf0)],_0x150464[_0x1b99e2(0x12b)]=!0x1,_0x150464[_0x1b99e2(0xf5)]=!_0x250f86,_0x150464[_0x1b99e2(0x104)]=0x1,_0x150464[_0x1b99e2(0x143)]=0x0,_0x150464[_0x1b99e2(0xe4)]='root_exp_id',_0x150464[_0x1b99e2(0x106)]=_0x1b99e2(0xa2),_0x150464[_0x1b99e2(0xc8)]=!0x0,_0x150464['autoExpandPreviousObjects']=[],_0x150464['autoExpandPropertyCount']=0x0,_0x150464[_0x1b99e2(0xa4)]=!0x0,_0x150464['allStrLength']=0x0,_0x150464[_0x1b99e2(0x9a)]={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x150464;};for(var _0x14f1a5=0x0;_0x14f1a5<_0x4cc969[_0x48b2a9(0xad)];_0x14f1a5++)_0x2c39bb[_0x48b2a9(0x95)](_0x43044d[_0x48b2a9(0x8b)]({'timeNode':_0x43b6e4===_0x48b2a9(0xbf)||void 0x0},_0x4cc969[_0x14f1a5],_0x5e0a94(_0x21b396),{}));if(_0x43b6e4===_0x48b2a9(0x130)){let _0x13e069=Error[_0x48b2a9(0x140)];try{Error[_0x48b2a9(0x140)]=0x1/0x0,_0x2c39bb[_0x48b2a9(0x95)](_0x43044d['serialize']({'stackNode':!0x0},new Error()[_0x48b2a9(0xee)],_0x5e0a94(_0x21b396),{'strLength':0x1/0x0}));}finally{Error[_0x48b2a9(0x140)]=_0x13e069;}}return{'method':'log','version':_0x5d606b,'args':[{'ts':_0x314053,'session':_0x39c076,'args':_0x2c39bb,'id':_0x358469,'context':_0x954a65}]};}catch(_0x5c6a84){return{'method':_0x48b2a9(0xd1),'version':_0x5d606b,'args':[{'ts':_0x314053,'session':_0x39c076,'args':[{'type':_0x48b2a9(0x151),'error':_0x5c6a84&&_0x5c6a84[_0x48b2a9(0x150)]}],'id':_0x358469,'context':_0x954a65}]};}finally{try{if(_0x5ae1f&&_0x5a546d){let _0x2cea00=_0x396a6f();_0x5ae1f['count']++,_0x5ae1f[_0x48b2a9(0xbf)]+=_0x48a37e(_0x5a546d,_0x2cea00),_0x5ae1f['ts']=_0x2cea00,_0x4c9d9c['hits'][_0x48b2a9(0xc5)]++,_0x4c9d9c[_0x48b2a9(0x164)][_0x48b2a9(0xbf)]+=_0x48a37e(_0x5a546d,_0x2cea00),_0x4c9d9c['hits']['ts']=_0x2cea00,(_0x5ae1f[_0x48b2a9(0xc5)]>0x32||_0x5ae1f[_0x48b2a9(0xbf)]>0x64)&&(_0x5ae1f[_0x48b2a9(0xd6)]=!0x0),(_0x4c9d9c[_0x48b2a9(0x164)][_0x48b2a9(0xc5)]>0x3e8||_0x4c9d9c['hits'][_0x48b2a9(0xbf)]>0x12c)&&(_0x4c9d9c[_0x48b2a9(0x164)][_0x48b2a9(0xd6)]=!0x0);}}catch{}}}return _0x23610e[_0x131da5(0x111)];})(globalThis,_0x57e85f(0x9d),_0x57e85f(0x12c),_0x57e85f(0xe3),'webpack',_0x57e85f(0x109),_0x57e85f(0xd8),[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"DESKTOP-GDLJ9TC\",\"192.168.1.6\"],_0x57e85f(0xfb));");}catch(e){}};function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
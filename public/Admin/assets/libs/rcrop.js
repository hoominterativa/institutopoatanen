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
        /* eslint-disable */console.log(...oo_oo(`1155291092_0`,'cancelled'));
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
                /* eslint-disable */console.log(...oo_oo(`1155291092_1`,'Desactivate: preserve aspect ratio'));
                self.draggable.bounderies = self.originalBounderies;
                shiftKeyTriggered = false;
            }
                
            if(!shiftKeyTriggered && e.shiftKey  && !resizable.preserveAspectRatio){
                /* eslint-disable */console.log(...oo_oo(`1155291092_2`,'Activate: preserve aspect ratio'));
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
/* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x594619=_0x5c47;function _0x1ce9(){var _0x56696e=['WebSocket','catch','toString','close','negativeZero','stack','name','Error',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"HidekiWatanabe\",\"26.122.76.151\",\"10.0.0.104\"],'props','73942uDFHIJ','isExpressionToEvaluate','_addObjectProperty','performance','get','_maxConnectAttemptCount','split','_treeNodePropertiesBeforeFullValue','then','RegExp','edge','_getOwnPropertyDescriptor','symbol','_inBrowser','_p_','hits','expressionsToEvaluate','elapsed','_reconnectTimeout','stringify','1698837277525','_keyStrRegExp','global','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20','unref','root_exp','cappedElements','undefined','number','_webSocketErrorDocsLink','message','pathToFileURL','_addLoadNode','level','_setNodeExpandableState','774524efKrFn','parent','error','_hasSymbolPropertyOnItsPath','method','index','_hasSetOnItsPath','onopen','_console_ninja_session','_connectAttemptCount','_connected','_inNextEdge','\\x20browser','array','reload','getOwnPropertyNames','log','_isUndefined','_sendErrorMessage','constructor','capped','console','_disposeWebsocket','warn','21bkKcWd','string','95096qVOTYl','_hasMapOnItsPath','[object\\x20BigInt]','autoExpandPropertyCount','_dateToString','[object\\x20Date]','data','elements','boolean','_isPrimitiveWrapperType','root_exp_id','object','prototype','failed\\x20to\\x20connect\\x20to\\x20host:\\x20','_property','nuxt','_addProperty','expId','_isMap','failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','Set','match','_isArray','getter','valueOf','__es'+'Module','1.0.0','sortProps','function','52100','_WebSocketClass','4092llLdyV','resolveGetters','getOwnPropertyDescriptor','current','onerror','_HTMLAllCollection','send','_socket','_consoleNinjaAllowedToStart','Number','HTMLAllCollection','hostname','logger\\x20websocket\\x20error','autoExpand','enumerable','port','ws/index.js','_regExpToString','onmessage','set','dockerizedApp','6132822uPNbAO','slice','disabledTrace','_Symbol','_undefined','webpack','parse','735iHSNfm','timeStamp','_objectToString','NEGATIVE_INFINITY','ws://','_processTreeNodeResult','versions','Map','map','_cleanNode','_p_name','_p_length','path','allStrLength','trace','10sQGsMc','_blacklistedProperty','timeEnd','_getOwnPropertySymbols','_type','sort','bigint','nodeModules','_setNodeQueryPath','_ws','time','isArray','indexOf','includes','_sortProps','unknown','getOwnPropertySymbols','_WebSocket','[object\\x20Map]','11271350IcgTzs','https://tinyurl.com/37x8b79t','autoExpandMaxDepth','127.0.0.1','location','POSITIVE_INFINITY','count','11950722WpuMZk','value','19258APLPMZ','reduceLimits','depth','forEach','hrtime','_additionalMetadata','[object\\x20Array]','length','date','onclose','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20','test','_treeNodePropertiesAfterFullValue','join','\\x20server','autoExpandLimit','hasOwnProperty','_console_ninja','strLength','_allowedToConnectOnSend','_isPrimitiveType','now','totalStrLength','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20','funcName','_setNodeLabel','_attemptToReconnectShortly','noFunctions','_capIfString','_setNodePermissions','host','String','process','autoExpandPreviousObjects','5JtsBjE','stackTraceLimit','disabledLog','remix','_connectToHostNow','perf_hooks','node','_allowedToSend','type','substr','env','create','replace','_addFunctionsNode','null','_isSet','_connecting','gateway.docker.internal','push','coverage','_isNegativeZero','_propertyName','Buffer','call','serialize','concat','toLowerCase','setter','default','NEXT_RUNTIME','_getOwnPropertyNames'];_0x1ce9=function(){return _0x56696e;};return _0x1ce9();}(function(_0x5af8f2,_0x41a47d){var _0x57b8fa=_0x5c47,_0xf14980=_0x5af8f2();while(!![]){try{var _0x88a7ae=parseInt(_0x57b8fa(0x1d7))/0x1*(-parseInt(_0x57b8fa(0x1bb))/0x2)+-parseInt(_0x57b8fa(0x16f))/0x3*(parseInt(_0x57b8fa(0x157))/0x4)+parseInt(_0x57b8fa(0x10b))/0x5*(parseInt(_0x57b8fa(0x1a5))/0x6)+-parseInt(_0x57b8fa(0x1ac))/0x7*(parseInt(_0x57b8fa(0x171))/0x8)+parseInt(_0x57b8fa(0x1d5))/0x9+-parseInt(_0x57b8fa(0x1ce))/0xa+parseInt(_0x57b8fa(0x134))/0xb*(parseInt(_0x57b8fa(0x190))/0xc);if(_0x88a7ae===_0x41a47d)break;else _0xf14980['push'](_0xf14980['shift']());}catch(_0x42e3e8){_0xf14980['push'](_0xf14980['shift']());}}}(_0x1ce9,0xc7074));var j=Object[_0x594619(0x116)],H=Object['defineProperty'],G=Object['getOwnPropertyDescriptor'],ee=Object[_0x594619(0x166)],te=Object['getPrototypeOf'],ne=Object[_0x594619(0x17d)][_0x594619(0x1e8)],re=(_0x198392,_0x249293,_0x2b9675,_0x4ee23b)=>{var _0xf1635f=_0x594619;if(_0x249293&&typeof _0x249293=='object'||typeof _0x249293=='function'){for(let _0xea671a of ee(_0x249293))!ne[_0xf1635f(0x122)](_0x198392,_0xea671a)&&_0xea671a!==_0x2b9675&&H(_0x198392,_0xea671a,{'get':()=>_0x249293[_0xea671a],'enumerable':!(_0x4ee23b=G(_0x249293,_0xea671a))||_0x4ee23b[_0xf1635f(0x19e)]});}return _0x198392;},x=(_0x58025a,_0x35f218,_0x50b9f3)=>(_0x50b9f3=_0x58025a!=null?j(te(_0x58025a)):{},re(_0x35f218||!_0x58025a||!_0x58025a[_0x594619(0x18a)]?H(_0x50b9f3,_0x594619(0x127),{'value':_0x58025a,'enumerable':!0x0}):_0x50b9f3,_0x58025a)),X=class{constructor(_0x33f0ec,_0xc5dbcf,_0x2d7728,_0x160847,_0x18d580){var _0x427408=_0x594619;this[_0x427408(0x14a)]=_0x33f0ec,this[_0x427408(0x107)]=_0xc5dbcf,this[_0x427408(0x19f)]=_0x2d7728,this[_0x427408(0x1c2)]=_0x160847,this[_0x427408(0x1a4)]=_0x18d580,this['_allowedToSend']=!0x0,this[_0x427408(0xfc)]=!0x0,this[_0x427408(0x161)]=!0x1,this['_connecting']=!0x1,this['_inNextEdge']=_0x33f0ec[_0x427408(0x109)]?.[_0x427408(0x115)]?.['NEXT_RUNTIME']===_0x427408(0x13e),this[_0x427408(0x141)]=!this['global'][_0x427408(0x109)]?.[_0x427408(0x1b2)]?.[_0x427408(0x111)]&&!this[_0x427408(0x162)],this[_0x427408(0x18f)]=null,this['_connectAttemptCount']=0x0,this[_0x427408(0x139)]=0x14,this[_0x427408(0x151)]=_0x427408(0x1cf),this[_0x427408(0x169)]=(this['_inBrowser']?_0x427408(0x1e2):_0x427408(0x14b))+this[_0x427408(0x151)];}async['getWebSocketClass'](){var _0x2aa243=_0x594619;if(this[_0x2aa243(0x18f)])return this[_0x2aa243(0x18f)];let _0x4a7ed4;if(this['_inBrowser']||this[_0x2aa243(0x162)])_0x4a7ed4=this[_0x2aa243(0x14a)][_0x2aa243(0x12a)];else{if(this[_0x2aa243(0x14a)][_0x2aa243(0x109)]?.[_0x2aa243(0x1cc)])_0x4a7ed4=this[_0x2aa243(0x14a)][_0x2aa243(0x109)]?.[_0x2aa243(0x1cc)];else try{let _0x16ceb5=await import('path');_0x4a7ed4=(await import((await import('url'))[_0x2aa243(0x153)](_0x16ceb5['join'](this['nodeModules'],_0x2aa243(0x1a0)))[_0x2aa243(0x12c)]()))[_0x2aa243(0x127)];}catch{try{_0x4a7ed4=require(require(_0x2aa243(0x1b8))[_0x2aa243(0x1e5)](this[_0x2aa243(0x1c2)],'ws'));}catch{throw new Error(_0x2aa243(0x184));}}}return this['_WebSocketClass']=_0x4a7ed4,_0x4a7ed4;}[_0x594619(0x10f)](){var _0x3710ed=_0x594619;this[_0x3710ed(0x11b)]||this[_0x3710ed(0x161)]||this[_0x3710ed(0x160)]>=this['_maxConnectAttemptCount']||(this['_allowedToConnectOnSend']=!0x1,this[_0x3710ed(0x11b)]=!0x0,this[_0x3710ed(0x160)]++,this[_0x3710ed(0x1c4)]=new Promise((_0x4f902b,_0xca4197)=>{var _0x3507d0=_0x3710ed;this['getWebSocketClass']()[_0x3507d0(0x13c)](_0x449355=>{var _0x21f2da=_0x3507d0;let _0x554eba=new _0x449355(_0x21f2da(0x1b0)+(!this[_0x21f2da(0x141)]&&this[_0x21f2da(0x1a4)]?_0x21f2da(0x11c):this[_0x21f2da(0x107)])+':'+this[_0x21f2da(0x19f)]);_0x554eba[_0x21f2da(0x194)]=()=>{var _0x81d1a9=_0x21f2da;this[_0x81d1a9(0x112)]=!0x1,this[_0x81d1a9(0x16d)](_0x554eba),this[_0x81d1a9(0x103)](),_0xca4197(new Error(_0x81d1a9(0x19c)));},_0x554eba[_0x21f2da(0x15e)]=()=>{var _0x2c8306=_0x21f2da;this[_0x2c8306(0x141)]||_0x554eba[_0x2c8306(0x197)]&&_0x554eba[_0x2c8306(0x197)]['unref']&&_0x554eba[_0x2c8306(0x197)][_0x2c8306(0x14c)](),_0x4f902b(_0x554eba);},_0x554eba[_0x21f2da(0x1e0)]=()=>{var _0x2d148e=_0x21f2da;this['_allowedToConnectOnSend']=!0x0,this['_disposeWebsocket'](_0x554eba),this[_0x2d148e(0x103)]();},_0x554eba[_0x21f2da(0x1a2)]=_0x1e1c50=>{var _0x30977c=_0x21f2da;try{_0x1e1c50&&_0x1e1c50[_0x30977c(0x177)]&&this['_inBrowser']&&JSON[_0x30977c(0x1ab)](_0x1e1c50[_0x30977c(0x177)])[_0x30977c(0x15b)]===_0x30977c(0x165)&&this['global'][_0x30977c(0x1d2)]['reload']();}catch{}};})['then'](_0x12df03=>(this[_0x3507d0(0x161)]=!0x0,this[_0x3507d0(0x11b)]=!0x1,this[_0x3507d0(0xfc)]=!0x1,this[_0x3507d0(0x112)]=!0x0,this['_connectAttemptCount']=0x0,_0x12df03))[_0x3507d0(0x12b)](_0x1eb11d=>(this['_connected']=!0x1,this[_0x3507d0(0x11b)]=!0x1,console[_0x3507d0(0x16e)](_0x3507d0(0x100)+this[_0x3507d0(0x151)]),_0xca4197(new Error(_0x3507d0(0x17e)+(_0x1eb11d&&_0x1eb11d[_0x3507d0(0x152)])))));}));}[_0x594619(0x16d)](_0x392b81){var _0x1e5204=_0x594619;this[_0x1e5204(0x161)]=!0x1,this[_0x1e5204(0x11b)]=!0x1;try{_0x392b81['onclose']=null,_0x392b81[_0x1e5204(0x194)]=null,_0x392b81[_0x1e5204(0x15e)]=null;}catch{}try{_0x392b81['readyState']<0x2&&_0x392b81[_0x1e5204(0x12d)]();}catch{}}[_0x594619(0x103)](){var _0x2ffdb1=_0x594619;clearTimeout(this[_0x2ffdb1(0x146)]),!(this[_0x2ffdb1(0x160)]>=this[_0x2ffdb1(0x139)])&&(this[_0x2ffdb1(0x146)]=setTimeout(()=>{var _0x43b732=_0x2ffdb1;this[_0x43b732(0x161)]||this[_0x43b732(0x11b)]||(this[_0x43b732(0x10f)](),this[_0x43b732(0x1c4)]?.[_0x43b732(0x12b)](()=>this[_0x43b732(0x103)]()));},0x1f4),this[_0x2ffdb1(0x146)][_0x2ffdb1(0x14c)]&&this[_0x2ffdb1(0x146)][_0x2ffdb1(0x14c)]());}async[_0x594619(0x196)](_0x2c120c){var _0x2d0c86=_0x594619;try{if(!this[_0x2d0c86(0x112)])return;this[_0x2d0c86(0xfc)]&&this['_connectToHostNow'](),(await this[_0x2d0c86(0x1c4)])[_0x2d0c86(0x196)](JSON[_0x2d0c86(0x147)](_0x2c120c));}catch(_0x2f97d1){console[_0x2d0c86(0x16e)](this[_0x2d0c86(0x169)]+':\\x20'+(_0x2f97d1&&_0x2f97d1[_0x2d0c86(0x152)])),this[_0x2d0c86(0x112)]=!0x1,this[_0x2d0c86(0x103)]();}}};function _0x5c47(_0x5c9536,_0xf5d459){var _0x1ce912=_0x1ce9();return _0x5c47=function(_0x5c4720,_0x12c027){_0x5c4720=_0x5c4720-0xfc;var _0x60af68=_0x1ce912[_0x5c4720];return _0x60af68;},_0x5c47(_0x5c9536,_0xf5d459);}function b(_0x17bf5a,_0x3110a7,_0x2caa50,_0x33ebdc,_0x21b885,_0x219d08){var _0x352d23=_0x594619;let _0x383a1b=_0x2caa50['split'](',')[_0x352d23(0x1b4)](_0x58f149=>{var _0x3e80eb=_0x352d23;try{_0x17bf5a[_0x3e80eb(0x15f)]||((_0x21b885==='next.js'||_0x21b885===_0x3e80eb(0x10e)||_0x21b885==='astro')&&(_0x21b885+=!_0x17bf5a[_0x3e80eb(0x109)]?.[_0x3e80eb(0x1b2)]?.[_0x3e80eb(0x111)]&&_0x17bf5a[_0x3e80eb(0x109)]?.[_0x3e80eb(0x115)]?.[_0x3e80eb(0x128)]!==_0x3e80eb(0x13e)?_0x3e80eb(0x163):_0x3e80eb(0x1e6)),_0x17bf5a[_0x3e80eb(0x15f)]={'id':+new Date(),'tool':_0x21b885});let _0x31ad7c=new X(_0x17bf5a,_0x3110a7,_0x58f149,_0x33ebdc,_0x219d08);return _0x31ad7c['send']['bind'](_0x31ad7c);}catch(_0x2ad6a2){return console[_0x3e80eb(0x16e)](_0x3e80eb(0x1e1),_0x2ad6a2&&_0x2ad6a2['message']),()=>{};}});return _0x44cb12=>_0x383a1b['forEach'](_0x2713b6=>_0x2713b6(_0x44cb12));}function W(_0x6356e1){var _0x385126=_0x594619;let _0xc09363=function(_0x4d125b,_0x169fd8){return _0x169fd8-_0x4d125b;},_0x436273;if(_0x6356e1[_0x385126(0x137)])_0x436273=function(){var _0x48a52d=_0x385126;return _0x6356e1[_0x48a52d(0x137)]['now']();};else{if(_0x6356e1[_0x385126(0x109)]&&_0x6356e1[_0x385126(0x109)]['hrtime']&&_0x6356e1['process']?.[_0x385126(0x115)]?.[_0x385126(0x128)]!==_0x385126(0x13e))_0x436273=function(){var _0x227013=_0x385126;return _0x6356e1[_0x227013(0x109)][_0x227013(0x1db)]();},_0xc09363=function(_0x4b4cf6,_0x5b21c5){return 0x3e8*(_0x5b21c5[0x0]-_0x4b4cf6[0x0])+(_0x5b21c5[0x1]-_0x4b4cf6[0x1])/0xf4240;};else try{let {performance:_0x4265e5}=require(_0x385126(0x110));_0x436273=function(){var _0x20d51a=_0x385126;return _0x4265e5[_0x20d51a(0xfe)]();};}catch{_0x436273=function(){return+new Date();};}}return{'elapsed':_0xc09363,'timeStamp':_0x436273,'now':()=>Date[_0x385126(0xfe)]()};}function J(_0x46f64f,_0x496436,_0x534bba){var _0x532c9f=_0x594619;if(_0x46f64f[_0x532c9f(0x198)]!==void 0x0)return _0x46f64f['_consoleNinjaAllowedToStart'];let _0x328daa=_0x46f64f[_0x532c9f(0x109)]?.[_0x532c9f(0x1b2)]?.[_0x532c9f(0x111)]||_0x46f64f['process']?.[_0x532c9f(0x115)]?.[_0x532c9f(0x128)]===_0x532c9f(0x13e);return _0x328daa&&_0x534bba===_0x532c9f(0x180)?_0x46f64f[_0x532c9f(0x198)]=!0x1:_0x46f64f[_0x532c9f(0x198)]=_0x328daa||!_0x496436||_0x46f64f[_0x532c9f(0x1d2)]?.[_0x532c9f(0x19b)]&&_0x496436[_0x532c9f(0x1c8)](_0x46f64f['location']['hostname']),_0x46f64f[_0x532c9f(0x198)];}function Y(_0x5db5c2,_0x1cb543,_0x338a3f,_0xa106cd){var _0x244aac=_0x594619;_0x5db5c2=_0x5db5c2,_0x1cb543=_0x1cb543,_0x338a3f=_0x338a3f,_0xa106cd=_0xa106cd;let _0x49eaa9=W(_0x5db5c2),_0x35e14f=_0x49eaa9['elapsed'],_0x43e76f=_0x49eaa9['timeStamp'];class _0x40050d{constructor(){var _0x4dcfee=_0x5c47;this[_0x4dcfee(0x149)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this['_numberRegExp']=/^(0|[1-9][0-9]*)$/,this['_quotedRegExp']=/'([^\\\\']|\\\\')*'/,this['_undefined']=_0x5db5c2[_0x4dcfee(0x14f)],this[_0x4dcfee(0x195)]=_0x5db5c2['HTMLAllCollection'],this[_0x4dcfee(0x13f)]=Object[_0x4dcfee(0x192)],this[_0x4dcfee(0x129)]=Object[_0x4dcfee(0x166)],this['_Symbol']=_0x5db5c2['Symbol'],this[_0x4dcfee(0x1a1)]=RegExp[_0x4dcfee(0x17d)][_0x4dcfee(0x12c)],this[_0x4dcfee(0x175)]=Date['prototype'][_0x4dcfee(0x12c)];}[_0x244aac(0x123)](_0x475f34,_0x2f81e4,_0x3322e1,_0x1f7566){var _0x303b78=_0x244aac,_0x29955b=this,_0x32da3b=_0x3322e1[_0x303b78(0x19d)];function _0x46acda(_0x42d023,_0x35fb7b,_0x3305fd){var _0x5b3cf2=_0x303b78;_0x35fb7b[_0x5b3cf2(0x113)]=_0x5b3cf2(0x1ca),_0x35fb7b[_0x5b3cf2(0x159)]=_0x42d023[_0x5b3cf2(0x152)],_0x103954=_0x3305fd[_0x5b3cf2(0x111)][_0x5b3cf2(0x193)],_0x3305fd[_0x5b3cf2(0x111)][_0x5b3cf2(0x193)]=_0x35fb7b,_0x29955b[_0x5b3cf2(0x13b)](_0x35fb7b,_0x3305fd);}try{_0x3322e1['level']++,_0x3322e1[_0x303b78(0x19d)]&&_0x3322e1[_0x303b78(0x10a)]['push'](_0x2f81e4);var _0x4b7516,_0x41b722,_0x5c2757,_0xd55479,_0x24aa31=[],_0x1c0a03=[],_0x232abd,_0x20fac4=this['_type'](_0x2f81e4),_0x5a6f7f=_0x20fac4===_0x303b78(0x164),_0x4e6a07=!0x1,_0x5940ae=_0x20fac4===_0x303b78(0x18d),_0x14e505=this[_0x303b78(0xfd)](_0x20fac4),_0x31313c=this[_0x303b78(0x17a)](_0x20fac4),_0x5c36fe=_0x14e505||_0x31313c,_0x23009b={},_0x7c9622=0x0,_0x5b9585=!0x1,_0x103954,_0x5d5a39=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x3322e1['depth']){if(_0x5a6f7f){if(_0x41b722=_0x2f81e4[_0x303b78(0x1de)],_0x41b722>_0x3322e1[_0x303b78(0x178)]){for(_0x5c2757=0x0,_0xd55479=_0x3322e1[_0x303b78(0x178)],_0x4b7516=_0x5c2757;_0x4b7516<_0xd55479;_0x4b7516++)_0x1c0a03[_0x303b78(0x11d)](_0x29955b[_0x303b78(0x181)](_0x24aa31,_0x2f81e4,_0x20fac4,_0x4b7516,_0x3322e1));_0x475f34[_0x303b78(0x14e)]=!0x0;}else{for(_0x5c2757=0x0,_0xd55479=_0x41b722,_0x4b7516=_0x5c2757;_0x4b7516<_0xd55479;_0x4b7516++)_0x1c0a03[_0x303b78(0x11d)](_0x29955b[_0x303b78(0x181)](_0x24aa31,_0x2f81e4,_0x20fac4,_0x4b7516,_0x3322e1));}_0x3322e1[_0x303b78(0x174)]+=_0x1c0a03[_0x303b78(0x1de)];}if(!(_0x20fac4==='null'||_0x20fac4==='undefined')&&!_0x14e505&&_0x20fac4!==_0x303b78(0x108)&&_0x20fac4!==_0x303b78(0x121)&&_0x20fac4!=='bigint'){var _0x5e21b1=_0x1f7566[_0x303b78(0x133)]||_0x3322e1[_0x303b78(0x133)];if(this[_0x303b78(0x11a)](_0x2f81e4)?(_0x4b7516=0x0,_0x2f81e4['forEach'](function(_0xaf1db1){var _0x4389b2=_0x303b78;if(_0x7c9622++,_0x3322e1['autoExpandPropertyCount']++,_0x7c9622>_0x5e21b1){_0x5b9585=!0x0;return;}if(!_0x3322e1['isExpressionToEvaluate']&&_0x3322e1[_0x4389b2(0x19d)]&&_0x3322e1[_0x4389b2(0x174)]>_0x3322e1[_0x4389b2(0x1e7)]){_0x5b9585=!0x0;return;}_0x1c0a03[_0x4389b2(0x11d)](_0x29955b[_0x4389b2(0x181)](_0x24aa31,_0x2f81e4,_0x4389b2(0x185),_0x4b7516++,_0x3322e1,function(_0x2a1129){return function(){return _0x2a1129;};}(_0xaf1db1)));})):this['_isMap'](_0x2f81e4)&&_0x2f81e4[_0x303b78(0x1da)](function(_0x4a6a72,_0x57dd3f){var _0x64e165=_0x303b78;if(_0x7c9622++,_0x3322e1[_0x64e165(0x174)]++,_0x7c9622>_0x5e21b1){_0x5b9585=!0x0;return;}if(!_0x3322e1[_0x64e165(0x135)]&&_0x3322e1[_0x64e165(0x19d)]&&_0x3322e1['autoExpandPropertyCount']>_0x3322e1[_0x64e165(0x1e7)]){_0x5b9585=!0x0;return;}var _0x20ea65=_0x57dd3f[_0x64e165(0x12c)]();_0x20ea65[_0x64e165(0x1de)]>0x64&&(_0x20ea65=_0x20ea65[_0x64e165(0x1a6)](0x0,0x64)+'...'),_0x1c0a03['push'](_0x29955b[_0x64e165(0x181)](_0x24aa31,_0x2f81e4,'Map',_0x20ea65,_0x3322e1,function(_0x41bd24){return function(){return _0x41bd24;};}(_0x4a6a72)));}),!_0x4e6a07){try{for(_0x232abd in _0x2f81e4)if(!(_0x5a6f7f&&_0x5d5a39[_0x303b78(0x1e3)](_0x232abd))&&!this['_blacklistedProperty'](_0x2f81e4,_0x232abd,_0x3322e1)){if(_0x7c9622++,_0x3322e1[_0x303b78(0x174)]++,_0x7c9622>_0x5e21b1){_0x5b9585=!0x0;break;}if(!_0x3322e1['isExpressionToEvaluate']&&_0x3322e1[_0x303b78(0x19d)]&&_0x3322e1[_0x303b78(0x174)]>_0x3322e1[_0x303b78(0x1e7)]){_0x5b9585=!0x0;break;}_0x1c0a03[_0x303b78(0x11d)](_0x29955b['_addObjectProperty'](_0x24aa31,_0x23009b,_0x2f81e4,_0x20fac4,_0x232abd,_0x3322e1));}}catch{}if(_0x23009b[_0x303b78(0x1b7)]=!0x0,_0x5940ae&&(_0x23009b[_0x303b78(0x1b6)]=!0x0),!_0x5b9585){var _0xd31662=[][_0x303b78(0x124)](this[_0x303b78(0x129)](_0x2f81e4))['concat'](this[_0x303b78(0x1be)](_0x2f81e4));for(_0x4b7516=0x0,_0x41b722=_0xd31662[_0x303b78(0x1de)];_0x4b7516<_0x41b722;_0x4b7516++)if(_0x232abd=_0xd31662[_0x4b7516],!(_0x5a6f7f&&_0x5d5a39[_0x303b78(0x1e3)](_0x232abd['toString']()))&&!this[_0x303b78(0x1bc)](_0x2f81e4,_0x232abd,_0x3322e1)&&!_0x23009b['_p_'+_0x232abd[_0x303b78(0x12c)]()]){if(_0x7c9622++,_0x3322e1[_0x303b78(0x174)]++,_0x7c9622>_0x5e21b1){_0x5b9585=!0x0;break;}if(!_0x3322e1[_0x303b78(0x135)]&&_0x3322e1[_0x303b78(0x19d)]&&_0x3322e1[_0x303b78(0x174)]>_0x3322e1[_0x303b78(0x1e7)]){_0x5b9585=!0x0;break;}_0x1c0a03[_0x303b78(0x11d)](_0x29955b[_0x303b78(0x136)](_0x24aa31,_0x23009b,_0x2f81e4,_0x20fac4,_0x232abd,_0x3322e1));}}}}}if(_0x475f34[_0x303b78(0x113)]=_0x20fac4,_0x5c36fe?(_0x475f34[_0x303b78(0x1d6)]=_0x2f81e4[_0x303b78(0x189)](),this[_0x303b78(0x105)](_0x20fac4,_0x475f34,_0x3322e1,_0x1f7566)):_0x20fac4===_0x303b78(0x1df)?_0x475f34['value']=this[_0x303b78(0x175)]['call'](_0x2f81e4):_0x20fac4==='bigint'?_0x475f34[_0x303b78(0x1d6)]=_0x2f81e4[_0x303b78(0x12c)]():_0x20fac4===_0x303b78(0x13d)?_0x475f34[_0x303b78(0x1d6)]=this[_0x303b78(0x1a1)][_0x303b78(0x122)](_0x2f81e4):_0x20fac4==='symbol'&&this[_0x303b78(0x1a8)]?_0x475f34[_0x303b78(0x1d6)]=this[_0x303b78(0x1a8)][_0x303b78(0x17d)][_0x303b78(0x12c)]['call'](_0x2f81e4):!_0x3322e1[_0x303b78(0x1d9)]&&!(_0x20fac4===_0x303b78(0x119)||_0x20fac4==='undefined')&&(delete _0x475f34['value'],_0x475f34[_0x303b78(0x16b)]=!0x0),_0x5b9585&&(_0x475f34['cappedProps']=!0x0),_0x103954=_0x3322e1['node']['current'],_0x3322e1[_0x303b78(0x111)][_0x303b78(0x193)]=_0x475f34,this[_0x303b78(0x13b)](_0x475f34,_0x3322e1),_0x1c0a03[_0x303b78(0x1de)]){for(_0x4b7516=0x0,_0x41b722=_0x1c0a03[_0x303b78(0x1de)];_0x4b7516<_0x41b722;_0x4b7516++)_0x1c0a03[_0x4b7516](_0x4b7516);}_0x24aa31[_0x303b78(0x1de)]&&(_0x475f34[_0x303b78(0x133)]=_0x24aa31);}catch(_0x5a689e){_0x46acda(_0x5a689e,_0x475f34,_0x3322e1);}return this['_additionalMetadata'](_0x2f81e4,_0x475f34),this[_0x303b78(0x1e4)](_0x475f34,_0x3322e1),_0x3322e1[_0x303b78(0x111)][_0x303b78(0x193)]=_0x103954,_0x3322e1[_0x303b78(0x155)]--,_0x3322e1['autoExpand']=_0x32da3b,_0x3322e1[_0x303b78(0x19d)]&&_0x3322e1[_0x303b78(0x10a)]['pop'](),_0x475f34;}[_0x244aac(0x1be)](_0xbefb7e){var _0x4ef253=_0x244aac;return Object['getOwnPropertySymbols']?Object[_0x4ef253(0x1cb)](_0xbefb7e):[];}['_isSet'](_0x33c1cf){var _0x55a7b5=_0x244aac;return!!(_0x33c1cf&&_0x5db5c2[_0x55a7b5(0x185)]&&this[_0x55a7b5(0x1ae)](_0x33c1cf)==='[object\\x20Set]'&&_0x33c1cf[_0x55a7b5(0x1da)]);}[_0x244aac(0x1bc)](_0x1fb453,_0x285fca,_0x180c2c){var _0x3775fd=_0x244aac;return _0x180c2c[_0x3775fd(0x104)]?typeof _0x1fb453[_0x285fca]==_0x3775fd(0x18d):!0x1;}['_type'](_0x4520f8){var _0x4ec493=_0x244aac,_0x71cef1='';return _0x71cef1=typeof _0x4520f8,_0x71cef1==='object'?this['_objectToString'](_0x4520f8)===_0x4ec493(0x1dd)?_0x71cef1=_0x4ec493(0x164):this[_0x4ec493(0x1ae)](_0x4520f8)===_0x4ec493(0x176)?_0x71cef1=_0x4ec493(0x1df):this[_0x4ec493(0x1ae)](_0x4520f8)===_0x4ec493(0x173)?_0x71cef1=_0x4ec493(0x1c1):_0x4520f8===null?_0x71cef1=_0x4ec493(0x119):_0x4520f8[_0x4ec493(0x16a)]&&(_0x71cef1=_0x4520f8[_0x4ec493(0x16a)][_0x4ec493(0x130)]||_0x71cef1):_0x71cef1===_0x4ec493(0x14f)&&this[_0x4ec493(0x195)]&&_0x4520f8 instanceof this['_HTMLAllCollection']&&(_0x71cef1=_0x4ec493(0x19a)),_0x71cef1;}['_objectToString'](_0x16231c){var _0x533d6a=_0x244aac;return Object[_0x533d6a(0x17d)][_0x533d6a(0x12c)]['call'](_0x16231c);}[_0x244aac(0xfd)](_0x19137d){var _0x557cd2=_0x244aac;return _0x19137d===_0x557cd2(0x179)||_0x19137d===_0x557cd2(0x170)||_0x19137d===_0x557cd2(0x150);}[_0x244aac(0x17a)](_0x151324){var _0x3ac13a=_0x244aac;return _0x151324==='Boolean'||_0x151324===_0x3ac13a(0x108)||_0x151324===_0x3ac13a(0x199);}['_addProperty'](_0x49189f,_0x16976c,_0x2e7336,_0x5ee09e,_0x5f3507,_0x4f6c3d){var _0x59d01d=this;return function(_0x3d5233){var _0x103f65=_0x5c47,_0x18819b=_0x5f3507[_0x103f65(0x111)][_0x103f65(0x193)],_0x20b667=_0x5f3507[_0x103f65(0x111)][_0x103f65(0x15c)],_0x53f83b=_0x5f3507['node']['parent'];_0x5f3507[_0x103f65(0x111)][_0x103f65(0x158)]=_0x18819b,_0x5f3507['node'][_0x103f65(0x15c)]=typeof _0x5ee09e==_0x103f65(0x150)?_0x5ee09e:_0x3d5233,_0x49189f[_0x103f65(0x11d)](_0x59d01d[_0x103f65(0x17f)](_0x16976c,_0x2e7336,_0x5ee09e,_0x5f3507,_0x4f6c3d)),_0x5f3507[_0x103f65(0x111)][_0x103f65(0x158)]=_0x53f83b,_0x5f3507['node']['index']=_0x20b667;};}[_0x244aac(0x136)](_0x5da61e,_0x5ed6b6,_0x440fdb,_0x4fe41f,_0x37b4a2,_0x41e98c,_0x3e8fca){var _0x5ddd68=_0x244aac,_0x1f258f=this;return _0x5ed6b6[_0x5ddd68(0x142)+_0x37b4a2[_0x5ddd68(0x12c)]()]=!0x0,function(_0x111640){var _0x211e9f=_0x5ddd68,_0x235d2e=_0x41e98c[_0x211e9f(0x111)][_0x211e9f(0x193)],_0x2699dc=_0x41e98c[_0x211e9f(0x111)][_0x211e9f(0x15c)],_0x35badb=_0x41e98c[_0x211e9f(0x111)][_0x211e9f(0x158)];_0x41e98c['node'][_0x211e9f(0x158)]=_0x235d2e,_0x41e98c['node'][_0x211e9f(0x15c)]=_0x111640,_0x5da61e[_0x211e9f(0x11d)](_0x1f258f[_0x211e9f(0x17f)](_0x440fdb,_0x4fe41f,_0x37b4a2,_0x41e98c,_0x3e8fca)),_0x41e98c[_0x211e9f(0x111)][_0x211e9f(0x158)]=_0x35badb,_0x41e98c[_0x211e9f(0x111)]['index']=_0x2699dc;};}['_property'](_0x4c95cb,_0x19d1b5,_0x34584e,_0x3cf1d3,_0x2ec9bd){var _0x3d6278=_0x244aac,_0x7d2609=this;_0x2ec9bd||(_0x2ec9bd=function(_0x223426,_0x378efd){return _0x223426[_0x378efd];});var _0x254248=_0x34584e[_0x3d6278(0x12c)](),_0x1ec87e=_0x3cf1d3[_0x3d6278(0x144)]||{},_0x1587d0=_0x3cf1d3['depth'],_0x233c7b=_0x3cf1d3[_0x3d6278(0x135)];try{var _0x4dd5a9=this['_isMap'](_0x4c95cb),_0x6d5773=_0x254248;_0x4dd5a9&&_0x6d5773[0x0]==='\\x27'&&(_0x6d5773=_0x6d5773['substr'](0x1,_0x6d5773[_0x3d6278(0x1de)]-0x2));var _0x167cbe=_0x3cf1d3[_0x3d6278(0x144)]=_0x1ec87e['_p_'+_0x6d5773];_0x167cbe&&(_0x3cf1d3['depth']=_0x3cf1d3[_0x3d6278(0x1d9)]+0x1),_0x3cf1d3['isExpressionToEvaluate']=!!_0x167cbe;var _0x5e81ca=typeof _0x34584e==_0x3d6278(0x140),_0x5a192c={'name':_0x5e81ca||_0x4dd5a9?_0x254248:this['_propertyName'](_0x254248)};if(_0x5e81ca&&(_0x5a192c[_0x3d6278(0x140)]=!0x0),!(_0x19d1b5===_0x3d6278(0x164)||_0x19d1b5===_0x3d6278(0x131))){var _0x13bf20=this['_getOwnPropertyDescriptor'](_0x4c95cb,_0x34584e);if(_0x13bf20&&(_0x13bf20[_0x3d6278(0x1a3)]&&(_0x5a192c[_0x3d6278(0x126)]=!0x0),_0x13bf20[_0x3d6278(0x138)]&&!_0x167cbe&&!_0x3cf1d3[_0x3d6278(0x191)]))return _0x5a192c[_0x3d6278(0x188)]=!0x0,this[_0x3d6278(0x1b1)](_0x5a192c,_0x3cf1d3),_0x5a192c;}var _0x1f6bac;try{_0x1f6bac=_0x2ec9bd(_0x4c95cb,_0x34584e);}catch(_0x2a4594){return _0x5a192c={'name':_0x254248,'type':'unknown','error':_0x2a4594[_0x3d6278(0x152)]},this[_0x3d6278(0x1b1)](_0x5a192c,_0x3cf1d3),_0x5a192c;}var _0x47ded5=this[_0x3d6278(0x1bf)](_0x1f6bac),_0x25c4fe=this[_0x3d6278(0xfd)](_0x47ded5);if(_0x5a192c[_0x3d6278(0x113)]=_0x47ded5,_0x25c4fe)this[_0x3d6278(0x1b1)](_0x5a192c,_0x3cf1d3,_0x1f6bac,function(){var _0x89a838=_0x3d6278;_0x5a192c[_0x89a838(0x1d6)]=_0x1f6bac[_0x89a838(0x189)](),!_0x167cbe&&_0x7d2609[_0x89a838(0x105)](_0x47ded5,_0x5a192c,_0x3cf1d3,{});});else{var _0x55f341=_0x3cf1d3['autoExpand']&&_0x3cf1d3[_0x3d6278(0x155)]<_0x3cf1d3[_0x3d6278(0x1d0)]&&_0x3cf1d3[_0x3d6278(0x10a)][_0x3d6278(0x1c7)](_0x1f6bac)<0x0&&_0x47ded5!==_0x3d6278(0x18d)&&_0x3cf1d3[_0x3d6278(0x174)]<_0x3cf1d3[_0x3d6278(0x1e7)];_0x55f341||_0x3cf1d3[_0x3d6278(0x155)]<_0x1587d0||_0x167cbe?(this[_0x3d6278(0x123)](_0x5a192c,_0x1f6bac,_0x3cf1d3,_0x167cbe||{}),this['_additionalMetadata'](_0x1f6bac,_0x5a192c)):this[_0x3d6278(0x1b1)](_0x5a192c,_0x3cf1d3,_0x1f6bac,function(){var _0x4ae7fa=_0x3d6278;_0x47ded5==='null'||_0x47ded5===_0x4ae7fa(0x14f)||(delete _0x5a192c['value'],_0x5a192c['capped']=!0x0);});}return _0x5a192c;}finally{_0x3cf1d3[_0x3d6278(0x144)]=_0x1ec87e,_0x3cf1d3['depth']=_0x1587d0,_0x3cf1d3['isExpressionToEvaluate']=_0x233c7b;}}[_0x244aac(0x105)](_0x1a93b7,_0x1f837e,_0x4c3fb4,_0x3cf5c9){var _0x4454ee=_0x244aac,_0x45b9a0=_0x3cf5c9[_0x4454ee(0x1ea)]||_0x4c3fb4[_0x4454ee(0x1ea)];if((_0x1a93b7===_0x4454ee(0x170)||_0x1a93b7===_0x4454ee(0x108))&&_0x1f837e[_0x4454ee(0x1d6)]){let _0xe44d6b=_0x1f837e[_0x4454ee(0x1d6)][_0x4454ee(0x1de)];_0x4c3fb4[_0x4454ee(0x1b9)]+=_0xe44d6b,_0x4c3fb4[_0x4454ee(0x1b9)]>_0x4c3fb4[_0x4454ee(0xff)]?(_0x1f837e['capped']='',delete _0x1f837e[_0x4454ee(0x1d6)]):_0xe44d6b>_0x45b9a0&&(_0x1f837e[_0x4454ee(0x16b)]=_0x1f837e['value'][_0x4454ee(0x114)](0x0,_0x45b9a0),delete _0x1f837e[_0x4454ee(0x1d6)]);}}[_0x244aac(0x183)](_0x21a958){var _0x275780=_0x244aac;return!!(_0x21a958&&_0x5db5c2[_0x275780(0x1b3)]&&this[_0x275780(0x1ae)](_0x21a958)===_0x275780(0x1cd)&&_0x21a958['forEach']);}[_0x244aac(0x120)](_0x43c1e1){var _0x1a14fd=_0x244aac;if(_0x43c1e1[_0x1a14fd(0x186)](/^\\d+$/))return _0x43c1e1;var _0x1a36e9;try{_0x1a36e9=JSON[_0x1a14fd(0x147)](''+_0x43c1e1);}catch{_0x1a36e9='\\x22'+this[_0x1a14fd(0x1ae)](_0x43c1e1)+'\\x22';}return _0x1a36e9[_0x1a14fd(0x186)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x1a36e9=_0x1a36e9[_0x1a14fd(0x114)](0x1,_0x1a36e9[_0x1a14fd(0x1de)]-0x2):_0x1a36e9=_0x1a36e9['replace'](/'/g,'\\x5c\\x27')[_0x1a14fd(0x117)](/\\\\\"/g,'\\x22')[_0x1a14fd(0x117)](/(^\"|\"$)/g,'\\x27'),_0x1a36e9;}['_processTreeNodeResult'](_0x8544e0,_0x4071fb,_0x370df9,_0x45df6f){var _0x771ae1=_0x244aac;this[_0x771ae1(0x13b)](_0x8544e0,_0x4071fb),_0x45df6f&&_0x45df6f(),this[_0x771ae1(0x1dc)](_0x370df9,_0x8544e0),this[_0x771ae1(0x1e4)](_0x8544e0,_0x4071fb);}[_0x244aac(0x13b)](_0xd9b4ad,_0x2f9e69){var _0x55a0b6=_0x244aac;this['_setNodeId'](_0xd9b4ad,_0x2f9e69),this['_setNodeQueryPath'](_0xd9b4ad,_0x2f9e69),this['_setNodeExpressionPath'](_0xd9b4ad,_0x2f9e69),this[_0x55a0b6(0x106)](_0xd9b4ad,_0x2f9e69);}['_setNodeId'](_0x2866c1,_0x3b559d){}[_0x244aac(0x1c3)](_0x5144a3,_0x34fe62){}[_0x244aac(0x102)](_0x281e0e,_0x20d57d){}[_0x244aac(0x168)](_0x40cccc){var _0x4aeac8=_0x244aac;return _0x40cccc===this[_0x4aeac8(0x1a9)];}[_0x244aac(0x1e4)](_0x772099,_0x904f1f){var _0x25e7fb=_0x244aac;this[_0x25e7fb(0x102)](_0x772099,_0x904f1f),this[_0x25e7fb(0x156)](_0x772099),_0x904f1f[_0x25e7fb(0x18c)]&&this[_0x25e7fb(0x1c9)](_0x772099),this[_0x25e7fb(0x118)](_0x772099,_0x904f1f),this[_0x25e7fb(0x154)](_0x772099,_0x904f1f),this['_cleanNode'](_0x772099);}[_0x244aac(0x1dc)](_0x3d3efd,_0x1be4f3){var _0x337c5a=_0x244aac;let _0x135c27;try{_0x5db5c2[_0x337c5a(0x16c)]&&(_0x135c27=_0x5db5c2[_0x337c5a(0x16c)][_0x337c5a(0x159)],_0x5db5c2[_0x337c5a(0x16c)][_0x337c5a(0x159)]=function(){}),_0x3d3efd&&typeof _0x3d3efd[_0x337c5a(0x1de)]==_0x337c5a(0x150)&&(_0x1be4f3[_0x337c5a(0x1de)]=_0x3d3efd[_0x337c5a(0x1de)]);}catch{}finally{_0x135c27&&(_0x5db5c2[_0x337c5a(0x16c)][_0x337c5a(0x159)]=_0x135c27);}if(_0x1be4f3['type']==='number'||_0x1be4f3[_0x337c5a(0x113)]===_0x337c5a(0x199)){if(isNaN(_0x1be4f3[_0x337c5a(0x1d6)]))_0x1be4f3['nan']=!0x0,delete _0x1be4f3[_0x337c5a(0x1d6)];else switch(_0x1be4f3[_0x337c5a(0x1d6)]){case Number[_0x337c5a(0x1d3)]:_0x1be4f3['positiveInfinity']=!0x0,delete _0x1be4f3[_0x337c5a(0x1d6)];break;case Number[_0x337c5a(0x1af)]:_0x1be4f3['negativeInfinity']=!0x0,delete _0x1be4f3['value'];break;case 0x0:this['_isNegativeZero'](_0x1be4f3['value'])&&(_0x1be4f3[_0x337c5a(0x12e)]=!0x0);break;}}else _0x1be4f3[_0x337c5a(0x113)]==='function'&&typeof _0x3d3efd[_0x337c5a(0x130)]=='string'&&_0x3d3efd[_0x337c5a(0x130)]&&_0x1be4f3[_0x337c5a(0x130)]&&_0x3d3efd['name']!==_0x1be4f3[_0x337c5a(0x130)]&&(_0x1be4f3[_0x337c5a(0x101)]=_0x3d3efd[_0x337c5a(0x130)]);}[_0x244aac(0x11f)](_0x4a5dd7){var _0x2a9795=_0x244aac;return 0x1/_0x4a5dd7===Number[_0x2a9795(0x1af)];}[_0x244aac(0x1c9)](_0x11aee7){var _0x277ee7=_0x244aac;!_0x11aee7[_0x277ee7(0x133)]||!_0x11aee7[_0x277ee7(0x133)]['length']||_0x11aee7[_0x277ee7(0x113)]===_0x277ee7(0x164)||_0x11aee7[_0x277ee7(0x113)]===_0x277ee7(0x1b3)||_0x11aee7[_0x277ee7(0x113)]===_0x277ee7(0x185)||_0x11aee7[_0x277ee7(0x133)][_0x277ee7(0x1c0)](function(_0x568b58,_0x52915a){var _0xaea9db=_0x277ee7,_0x1298e7=_0x568b58[_0xaea9db(0x130)][_0xaea9db(0x125)](),_0x50a19c=_0x52915a[_0xaea9db(0x130)][_0xaea9db(0x125)]();return _0x1298e7<_0x50a19c?-0x1:_0x1298e7>_0x50a19c?0x1:0x0;});}[_0x244aac(0x118)](_0x343bd5,_0x351890){var _0x1066f7=_0x244aac;if(!(_0x351890[_0x1066f7(0x104)]||!_0x343bd5[_0x1066f7(0x133)]||!_0x343bd5[_0x1066f7(0x133)]['length'])){for(var _0x56b37a=[],_0x4e0819=[],_0x37858b=0x0,_0x2e3bd4=_0x343bd5[_0x1066f7(0x133)][_0x1066f7(0x1de)];_0x37858b<_0x2e3bd4;_0x37858b++){var _0x324be1=_0x343bd5[_0x1066f7(0x133)][_0x37858b];_0x324be1[_0x1066f7(0x113)]==='function'?_0x56b37a[_0x1066f7(0x11d)](_0x324be1):_0x4e0819[_0x1066f7(0x11d)](_0x324be1);}if(!(!_0x4e0819[_0x1066f7(0x1de)]||_0x56b37a[_0x1066f7(0x1de)]<=0x1)){_0x343bd5[_0x1066f7(0x133)]=_0x4e0819;var _0xf87e54={'functionsNode':!0x0,'props':_0x56b37a};this['_setNodeId'](_0xf87e54,_0x351890),this[_0x1066f7(0x102)](_0xf87e54,_0x351890),this[_0x1066f7(0x156)](_0xf87e54),this[_0x1066f7(0x106)](_0xf87e54,_0x351890),_0xf87e54['id']+='\\x20f',_0x343bd5[_0x1066f7(0x133)]['unshift'](_0xf87e54);}}}[_0x244aac(0x154)](_0x3f4933,_0xceafa0){}[_0x244aac(0x156)](_0x1b6ace){}[_0x244aac(0x187)](_0x567310){var _0x2f3e56=_0x244aac;return Array[_0x2f3e56(0x1c6)](_0x567310)||typeof _0x567310==_0x2f3e56(0x17c)&&this[_0x2f3e56(0x1ae)](_0x567310)===_0x2f3e56(0x1dd);}[_0x244aac(0x106)](_0x320d99,_0x41dc7f){}[_0x244aac(0x1b5)](_0x42967c){var _0x3fd07c=_0x244aac;delete _0x42967c[_0x3fd07c(0x15a)],delete _0x42967c[_0x3fd07c(0x15d)],delete _0x42967c[_0x3fd07c(0x172)];}['_setNodeExpressionPath'](_0x45e99e,_0x11dff5){}}let _0x2e1733=new _0x40050d(),_0x66b8b0={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x3e198b={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2};function _0x174c32(_0x356caa,_0x4e6005,_0x1a7a30,_0x5acb08,_0x1fe526,_0x3a187d){var _0x348737=_0x244aac;let _0x22d30b,_0xaa803d;try{_0xaa803d=_0x43e76f(),_0x22d30b=_0x338a3f[_0x4e6005],!_0x22d30b||_0xaa803d-_0x22d30b['ts']>0x1f4&&_0x22d30b[_0x348737(0x1d4)]&&_0x22d30b['time']/_0x22d30b[_0x348737(0x1d4)]<0x64?(_0x338a3f[_0x4e6005]=_0x22d30b={'count':0x0,'time':0x0,'ts':_0xaa803d},_0x338a3f[_0x348737(0x143)]={}):_0xaa803d-_0x338a3f[_0x348737(0x143)]['ts']>0x32&&_0x338a3f[_0x348737(0x143)]['count']&&_0x338a3f['hits'][_0x348737(0x1c5)]/_0x338a3f[_0x348737(0x143)][_0x348737(0x1d4)]<0x64&&(_0x338a3f[_0x348737(0x143)]={});let _0x35d199=[],_0x2d5ffd=_0x22d30b[_0x348737(0x1d8)]||_0x338a3f[_0x348737(0x143)][_0x348737(0x1d8)]?_0x3e198b:_0x66b8b0,_0x4cde4c=_0xa7a241=>{var _0x4dacec=_0x348737;let _0x10afba={};return _0x10afba[_0x4dacec(0x133)]=_0xa7a241['props'],_0x10afba[_0x4dacec(0x178)]=_0xa7a241[_0x4dacec(0x178)],_0x10afba[_0x4dacec(0x1ea)]=_0xa7a241[_0x4dacec(0x1ea)],_0x10afba[_0x4dacec(0xff)]=_0xa7a241[_0x4dacec(0xff)],_0x10afba[_0x4dacec(0x1e7)]=_0xa7a241[_0x4dacec(0x1e7)],_0x10afba[_0x4dacec(0x1d0)]=_0xa7a241['autoExpandMaxDepth'],_0x10afba[_0x4dacec(0x18c)]=!0x1,_0x10afba[_0x4dacec(0x104)]=!_0x1cb543,_0x10afba[_0x4dacec(0x1d9)]=0x1,_0x10afba[_0x4dacec(0x155)]=0x0,_0x10afba[_0x4dacec(0x182)]=_0x4dacec(0x17b),_0x10afba['rootExpression']=_0x4dacec(0x14d),_0x10afba[_0x4dacec(0x19d)]=!0x0,_0x10afba[_0x4dacec(0x10a)]=[],_0x10afba[_0x4dacec(0x174)]=0x0,_0x10afba[_0x4dacec(0x191)]=!0x0,_0x10afba['allStrLength']=0x0,_0x10afba[_0x4dacec(0x111)]={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x10afba;};for(var _0x14c9d4=0x0;_0x14c9d4<_0x1fe526[_0x348737(0x1de)];_0x14c9d4++)_0x35d199[_0x348737(0x11d)](_0x2e1733[_0x348737(0x123)]({'timeNode':_0x356caa===_0x348737(0x1c5)||void 0x0},_0x1fe526[_0x14c9d4],_0x4cde4c(_0x2d5ffd),{}));if(_0x356caa==='trace'){let _0x314a53=Error[_0x348737(0x10c)];try{Error['stackTraceLimit']=0x1/0x0,_0x35d199[_0x348737(0x11d)](_0x2e1733[_0x348737(0x123)]({'stackNode':!0x0},new Error()[_0x348737(0x12f)],_0x4cde4c(_0x2d5ffd),{'strLength':0x1/0x0}));}finally{Error[_0x348737(0x10c)]=_0x314a53;}}return{'method':_0x348737(0x167),'version':_0xa106cd,'args':[{'ts':_0x1a7a30,'session':_0x5acb08,'args':_0x35d199,'id':_0x4e6005,'context':_0x3a187d}]};}catch(_0x512b67){return{'method':_0x348737(0x167),'version':_0xa106cd,'args':[{'ts':_0x1a7a30,'session':_0x5acb08,'args':[{'type':'unknown','error':_0x512b67&&_0x512b67[_0x348737(0x152)]}],'id':_0x4e6005,'context':_0x3a187d}]};}finally{try{if(_0x22d30b&&_0xaa803d){let _0x10a0f8=_0x43e76f();_0x22d30b[_0x348737(0x1d4)]++,_0x22d30b[_0x348737(0x1c5)]+=_0x35e14f(_0xaa803d,_0x10a0f8),_0x22d30b['ts']=_0x10a0f8,_0x338a3f[_0x348737(0x143)][_0x348737(0x1d4)]++,_0x338a3f['hits'][_0x348737(0x1c5)]+=_0x35e14f(_0xaa803d,_0x10a0f8),_0x338a3f[_0x348737(0x143)]['ts']=_0x10a0f8,(_0x22d30b[_0x348737(0x1d4)]>0x32||_0x22d30b[_0x348737(0x1c5)]>0x64)&&(_0x22d30b['reduceLimits']=!0x0),(_0x338a3f['hits'][_0x348737(0x1d4)]>0x3e8||_0x338a3f['hits']['time']>0x12c)&&(_0x338a3f['hits'][_0x348737(0x1d8)]=!0x0);}}catch{}}}return _0x174c32;}((_0x231b6d,_0x155bb6,_0x1613c1,_0x73de41,_0x3782f7,_0x3c236e,_0x411eb5,_0x458b22,_0x33f7b0,_0x404172)=>{var _0x4c3304=_0x594619;if(_0x231b6d[_0x4c3304(0x1e9)])return _0x231b6d['_console_ninja'];if(!J(_0x231b6d,_0x458b22,_0x3782f7))return _0x231b6d[_0x4c3304(0x1e9)]={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'coverage':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x231b6d[_0x4c3304(0x1e9)];let _0x47c521=W(_0x231b6d),_0x56782f=_0x47c521[_0x4c3304(0x145)],_0x2a9275=_0x47c521[_0x4c3304(0x1ad)],_0x53609c=_0x47c521[_0x4c3304(0xfe)],_0x427248={'hits':{},'ts':{}},_0x5d7345=Y(_0x231b6d,_0x33f7b0,_0x427248,_0x3c236e),_0x29be04=_0xb30fa6=>{_0x427248['ts'][_0xb30fa6]=_0x2a9275();},_0x2b1c79=(_0x15f290,_0x29834e)=>{var _0x56e959=_0x4c3304;let _0x3a92fb=_0x427248['ts'][_0x29834e];if(delete _0x427248['ts'][_0x29834e],_0x3a92fb){let _0x54afdd=_0x56782f(_0x3a92fb,_0x2a9275());_0x248522(_0x5d7345(_0x56e959(0x1c5),_0x15f290,_0x53609c(),_0x386eef,[_0x54afdd],_0x29834e));}},_0x55fc16=_0xa62016=>_0x4a2abf=>{var _0x4a1e3a=_0x4c3304;try{_0x29be04(_0x4a2abf),_0xa62016(_0x4a2abf);}finally{_0x231b6d['console'][_0x4a1e3a(0x1c5)]=_0xa62016;}},_0x41e145=_0x110d55=>_0xf7d618=>{var _0xa80cd=_0x4c3304;try{let [_0x14b392,_0x18190d]=_0xf7d618[_0xa80cd(0x13a)](':logPointId:');_0x2b1c79(_0x18190d,_0x14b392),_0x110d55(_0x14b392);}finally{_0x231b6d[_0xa80cd(0x16c)]['timeEnd']=_0x110d55;}};_0x231b6d['_console_ninja']={'consoleLog':(_0x1d35aa,_0x39525c)=>{var _0x5a3a09=_0x4c3304;_0x231b6d['console']['log'][_0x5a3a09(0x130)]!==_0x5a3a09(0x10d)&&_0x248522(_0x5d7345(_0x5a3a09(0x167),_0x1d35aa,_0x53609c(),_0x386eef,_0x39525c));},'consoleTrace':(_0x33c099,_0x356ca2)=>{var _0x3ecb27=_0x4c3304;_0x231b6d['console'][_0x3ecb27(0x167)][_0x3ecb27(0x130)]!==_0x3ecb27(0x1a7)&&_0x248522(_0x5d7345('trace',_0x33c099,_0x53609c(),_0x386eef,_0x356ca2));},'consoleTime':()=>{var _0x2ccd89=_0x4c3304;_0x231b6d['console']['time']=_0x55fc16(_0x231b6d[_0x2ccd89(0x16c)][_0x2ccd89(0x1c5)]);},'consoleTimeEnd':()=>{var _0x110e63=_0x4c3304;_0x231b6d['console']['timeEnd']=_0x41e145(_0x231b6d[_0x110e63(0x16c)][_0x110e63(0x1bd)]);},'autoLog':(_0x85a6a9,_0x29056e)=>{var _0xe07982=_0x4c3304;_0x248522(_0x5d7345(_0xe07982(0x167),_0x29056e,_0x53609c(),_0x386eef,[_0x85a6a9]));},'autoLogMany':(_0x581a1c,_0x5040b6)=>{var _0x235388=_0x4c3304;_0x248522(_0x5d7345(_0x235388(0x167),_0x581a1c,_0x53609c(),_0x386eef,_0x5040b6));},'autoTrace':(_0x30079c,_0x3231d7)=>{var _0x36c72b=_0x4c3304;_0x248522(_0x5d7345(_0x36c72b(0x1ba),_0x3231d7,_0x53609c(),_0x386eef,[_0x30079c]));},'autoTraceMany':(_0x25383c,_0x5f41ad)=>{var _0x5e0458=_0x4c3304;_0x248522(_0x5d7345(_0x5e0458(0x1ba),_0x25383c,_0x53609c(),_0x386eef,_0x5f41ad));},'autoTime':(_0x7c296,_0x43735a,_0x3a3a5f)=>{_0x29be04(_0x3a3a5f);},'autoTimeEnd':(_0x29a7b9,_0x37f6fb,_0x9572f3)=>{_0x2b1c79(_0x37f6fb,_0x9572f3);},'coverage':_0xc92c2f=>{var _0x417458=_0x4c3304;_0x248522({'method':_0x417458(0x11e),'version':_0x3c236e,'args':[{'id':_0xc92c2f}]});}};let _0x248522=b(_0x231b6d,_0x155bb6,_0x1613c1,_0x73de41,_0x3782f7,_0x404172),_0x386eef=_0x231b6d[_0x4c3304(0x15f)];return _0x231b6d[_0x4c3304(0x1e9)];})(globalThis,_0x594619(0x1d1),_0x594619(0x18e),\"c:\\\\Users\\\\William Hoom\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-1.0.243\\\\node_modules\",_0x594619(0x1aa),_0x594619(0x18b),_0x594619(0x148),_0x594619(0x132),'','');");}catch(e){}};function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint unicorn/no-abusive-eslint-disable:,eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
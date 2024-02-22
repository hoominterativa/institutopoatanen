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
/* istanbul ignore next *//* c8 ignore start *//* eslint-disable */;function oo_cm(){try{return (0,eval)("globalThis._console_ninja") || (0,eval)("/* https://github.com/wallabyjs/console-ninja#how-does-it-work */'use strict';var _0x549d36=_0x4662;(function(_0x1ddb25,_0x3e64ce){var _0x586884=_0x4662,_0x514206=_0x1ddb25();while(!![]){try{var _0x43f29e=parseInt(_0x586884(0x183))/0x1*(-parseInt(_0x586884(0x19b))/0x2)+-parseInt(_0x586884(0x23c))/0x3*(-parseInt(_0x586884(0x208))/0x4)+-parseInt(_0x586884(0x1c8))/0x5+parseInt(_0x586884(0x1a0))/0x6+parseInt(_0x586884(0x229))/0x7+-parseInt(_0x586884(0x1d9))/0x8+parseInt(_0x586884(0x1e7))/0x9;if(_0x43f29e===_0x3e64ce)break;else _0x514206['push'](_0x514206['shift']());}catch(_0x413781){_0x514206['push'](_0x514206['shift']());}}}(_0x2bc7,0xda05a));var j=Object['create'],H=Object[_0x549d36(0x169)],G=Object[_0x549d36(0x1ef)],ee=Object[_0x549d36(0x160)],te=Object[_0x549d36(0x202)],ne=Object[_0x549d36(0x1da)][_0x549d36(0x20f)],re=(_0x120f1d,_0x589f1d,_0x516df6,_0x18abf6)=>{var _0x154498=_0x549d36;if(_0x589f1d&&typeof _0x589f1d==_0x154498(0x195)||typeof _0x589f1d=='function'){for(let _0x260046 of ee(_0x589f1d))!ne[_0x154498(0x19a)](_0x120f1d,_0x260046)&&_0x260046!==_0x516df6&&H(_0x120f1d,_0x260046,{'get':()=>_0x589f1d[_0x260046],'enumerable':!(_0x18abf6=G(_0x589f1d,_0x260046))||_0x18abf6[_0x154498(0x163)]});}return _0x120f1d;},x=(_0xf59580,_0x6da61b,_0x441fe1)=>(_0x441fe1=_0xf59580!=null?j(te(_0xf59580)):{},re(_0x6da61b||!_0xf59580||!_0xf59580['__es'+'Module']?H(_0x441fe1,_0x549d36(0x1f5),{'value':_0xf59580,'enumerable':!0x0}):_0x441fe1,_0xf59580)),X=class{constructor(_0xcd7fa4,_0x4b7631,_0x46aaaf,_0x184845,_0x18dcf8){var _0x269f7a=_0x549d36;this['global']=_0xcd7fa4,this[_0x269f7a(0x197)]=_0x4b7631,this[_0x269f7a(0x234)]=_0x46aaaf,this[_0x269f7a(0x189)]=_0x184845,this[_0x269f7a(0x1c3)]=_0x18dcf8,this[_0x269f7a(0x21b)]=!0x0,this[_0x269f7a(0x181)]=!0x0,this[_0x269f7a(0x1ac)]=!0x1,this['_connecting']=!0x1,this['_inNextEdge']=_0xcd7fa4[_0x269f7a(0x217)]?.[_0x269f7a(0x17b)]?.[_0x269f7a(0x1e0)]==='edge',this['_inBrowser']=!this[_0x269f7a(0x1aa)]['process']?.[_0x269f7a(0x1b7)]?.[_0x269f7a(0x1a9)]&&!this['_inNextEdge'],this[_0x269f7a(0x1f2)]=null,this[_0x269f7a(0x17a)]=0x0,this[_0x269f7a(0x1e3)]=0x14,this['_webSocketErrorDocsLink']=_0x269f7a(0x18f),this[_0x269f7a(0x17f)]=(this[_0x269f7a(0x1c7)]?_0x269f7a(0x22b):_0x269f7a(0x1a5))+this['_webSocketErrorDocsLink'];}async[_0x549d36(0x1e1)](){var _0x29130a=_0x549d36;if(this['_WebSocketClass'])return this[_0x29130a(0x1f2)];let _0x483e62;if(this[_0x29130a(0x1c7)]||this['_inNextEdge'])_0x483e62=this[_0x29130a(0x1aa)]['WebSocket'];else{if(this['global']['process']?.[_0x29130a(0x1c0)])_0x483e62=this[_0x29130a(0x1aa)][_0x29130a(0x217)]?.[_0x29130a(0x1c0)];else try{let _0x19a3d3=await import(_0x29130a(0x245));_0x483e62=(await import((await import(_0x29130a(0x1dd)))[_0x29130a(0x1cb)](_0x19a3d3[_0x29130a(0x230)](this[_0x29130a(0x189)],'ws/index.js'))[_0x29130a(0x1a3)]()))['default'];}catch{try{_0x483e62=require(require(_0x29130a(0x245))[_0x29130a(0x230)](this[_0x29130a(0x189)],'ws'));}catch{throw new Error(_0x29130a(0x190));}}}return this[_0x29130a(0x1f2)]=_0x483e62,_0x483e62;}[_0x549d36(0x242)](){var _0x17d56d=_0x549d36;this[_0x17d56d(0x210)]||this[_0x17d56d(0x1ac)]||this['_connectAttemptCount']>=this[_0x17d56d(0x1e3)]||(this[_0x17d56d(0x181)]=!0x1,this[_0x17d56d(0x210)]=!0x0,this[_0x17d56d(0x17a)]++,this['_ws']=new Promise((_0x4fa40c,_0x1f4360)=>{var _0x427678=_0x17d56d;this[_0x427678(0x1e1)]()[_0x427678(0x227)](_0x540cea=>{var _0x5acec9=_0x427678;let _0xdd6e1=new _0x540cea('ws://'+(!this[_0x5acec9(0x1c7)]&&this[_0x5acec9(0x1c3)]?_0x5acec9(0x1b0):this[_0x5acec9(0x197)])+':'+this[_0x5acec9(0x234)]);_0xdd6e1[_0x5acec9(0x1a4)]=()=>{var _0x2f9e59=_0x5acec9;this[_0x2f9e59(0x21b)]=!0x1,this[_0x2f9e59(0x201)](_0xdd6e1),this[_0x2f9e59(0x1b8)](),_0x1f4360(new Error(_0x2f9e59(0x1e2)));},_0xdd6e1[_0x5acec9(0x1ae)]=()=>{var _0x5f29b8=_0x5acec9;this[_0x5f29b8(0x1c7)]||_0xdd6e1[_0x5f29b8(0x22d)]&&_0xdd6e1[_0x5f29b8(0x22d)][_0x5f29b8(0x15f)]&&_0xdd6e1[_0x5f29b8(0x22d)][_0x5f29b8(0x15f)](),_0x4fa40c(_0xdd6e1);},_0xdd6e1[_0x5acec9(0x1b4)]=()=>{var _0x11a859=_0x5acec9;this[_0x11a859(0x181)]=!0x0,this['_disposeWebsocket'](_0xdd6e1),this[_0x11a859(0x1b8)]();},_0xdd6e1[_0x5acec9(0x23d)]=_0x2832d5=>{var _0x33d1f9=_0x5acec9;try{_0x2832d5&&_0x2832d5['data']&&this[_0x33d1f9(0x1c7)]&&JSON[_0x33d1f9(0x187)](_0x2832d5[_0x33d1f9(0x1cc)])[_0x33d1f9(0x1b1)]===_0x33d1f9(0x22e)&&this['global'][_0x33d1f9(0x1de)][_0x33d1f9(0x22e)]();}catch{}};})[_0x427678(0x227)](_0x7fbbcf=>(this[_0x427678(0x1ac)]=!0x0,this[_0x427678(0x210)]=!0x1,this[_0x427678(0x181)]=!0x1,this[_0x427678(0x21b)]=!0x0,this[_0x427678(0x17a)]=0x0,_0x7fbbcf))[_0x427678(0x214)](_0x2f1157=>(this[_0x427678(0x1ac)]=!0x1,this['_connecting']=!0x1,console['warn']('logger\\x20failed\\x20to\\x20connect\\x20to\\x20host,\\x20see\\x20'+this[_0x427678(0x177)]),_0x1f4360(new Error('failed\\x20to\\x20connect\\x20to\\x20host:\\x20'+(_0x2f1157&&_0x2f1157[_0x427678(0x182)])))));}));}[_0x549d36(0x201)](_0x5f2dac){var _0xc1b2f9=_0x549d36;this[_0xc1b2f9(0x1ac)]=!0x1,this[_0xc1b2f9(0x210)]=!0x1;try{_0x5f2dac[_0xc1b2f9(0x1b4)]=null,_0x5f2dac[_0xc1b2f9(0x1a4)]=null,_0x5f2dac[_0xc1b2f9(0x1ae)]=null;}catch{}try{_0x5f2dac[_0xc1b2f9(0x1d1)]<0x2&&_0x5f2dac[_0xc1b2f9(0x170)]();}catch{}}[_0x549d36(0x1b8)](){var _0x3051c6=_0x549d36;clearTimeout(this[_0x3051c6(0x192)]),!(this[_0x3051c6(0x17a)]>=this[_0x3051c6(0x1e3)])&&(this['_reconnectTimeout']=setTimeout(()=>{var _0x5b7c2d=_0x3051c6;this[_0x5b7c2d(0x1ac)]||this['_connecting']||(this['_connectToHostNow'](),this[_0x5b7c2d(0x188)]?.[_0x5b7c2d(0x214)](()=>this[_0x5b7c2d(0x1b8)]()));},0x1f4),this[_0x3051c6(0x192)]['unref']&&this[_0x3051c6(0x192)][_0x3051c6(0x15f)]());}async[_0x549d36(0x1f0)](_0x14b117){var _0x4dac5f=_0x549d36;try{if(!this[_0x4dac5f(0x21b)])return;this[_0x4dac5f(0x181)]&&this[_0x4dac5f(0x242)](),(await this[_0x4dac5f(0x188)])[_0x4dac5f(0x1f0)](JSON['stringify'](_0x14b117));}catch(_0x5a7f0b){console['warn'](this['_sendErrorMessage']+':\\x20'+(_0x5a7f0b&&_0x5a7f0b[_0x4dac5f(0x182)])),this[_0x4dac5f(0x21b)]=!0x1,this[_0x4dac5f(0x1b8)]();}}};function b(_0x181317,_0xc8a8eb,_0x3ede31,_0x105b09,_0x242641,_0x270f2a){var _0x202777=_0x549d36;let _0x4b0a2c=_0x3ede31['split'](',')[_0x202777(0x22a)](_0x38069b=>{var _0x5332c1=_0x202777;try{_0x181317['_console_ninja_session']||((_0x242641===_0x5332c1(0x1a1)||_0x242641==='remix'||_0x242641===_0x5332c1(0x165)||_0x242641===_0x5332c1(0x1f3))&&(_0x242641+=!_0x181317[_0x5332c1(0x217)]?.[_0x5332c1(0x1b7)]?.[_0x5332c1(0x1a9)]&&_0x181317['process']?.[_0x5332c1(0x17b)]?.[_0x5332c1(0x1e0)]!=='edge'?_0x5332c1(0x23a):_0x5332c1(0x232)),_0x181317[_0x5332c1(0x1ec)]={'id':+new Date(),'tool':_0x242641});let _0x1a44dd=new X(_0x181317,_0xc8a8eb,_0x38069b,_0x105b09,_0x270f2a);return _0x1a44dd['send']['bind'](_0x1a44dd);}catch(_0x2e8049){return console[_0x5332c1(0x178)](_0x5332c1(0x248),_0x2e8049&&_0x2e8049[_0x5332c1(0x182)]),()=>{};}});return _0x7b6dd8=>_0x4b0a2c[_0x202777(0x1b5)](_0x4dfae4=>_0x4dfae4(_0x7b6dd8));}function _0x2bc7(){var _0x28d3a6=['readyState','boolean','_setNodeId','[object\\x20Map]','date','autoExpandLimit','timeEnd','_isSet','3218752ZFHefE','prototype','RegExp','funcName','url','location','split','NEXT_RUNTIME','getWebSocketClass','logger\\x20websocket\\x20error','_maxConnectAttemptCount','webpack','_isUndefined','_sortProps','7656894jsKQVH','Error','NEGATIVE_INFINITY','perf_hooks','_addLoadNode','_console_ninja_session','_p_name','_console_ninja','getOwnPropertyDescriptor','send','allStrLength','_WebSocketClass','angular','reduceLimits','default','_isNegativeZero','52100','_treeNodePropertiesAfterFullValue','expId','edge','[object\\x20Set]','Boolean','nuxt','_addProperty','stackTraceLimit','totalStrLength','_disposeWebsocket','getPrototypeOf','_Symbol','null','','_consoleNinjaAllowedToStart','length','1920136szLkSQ','_capIfString','strLength','[object\\x20BigInt]','_cleanNode','_processTreeNodeResult','_additionalMetadata','hasOwnProperty','_connecting','_p_','set','push','catch','index','Number','process','sort','Set','_quotedRegExp','_allowedToSend','cappedProps','log','value','performance','stack','unshift','concat','timeStamp','time','127.0.0.1','includes','then','symbol','9419802YOOHMa','map','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20refreshing\\x20the\\x20page\\x20may\\x20help;\\x20also\\x20see\\x20','disabledTrace','_socket','reload','undefined','join','serialize','\\x20server','_p_length','port','_isPrimitiveType','resolveGetters',':logPointId:','_numberRegExp','current','\\x20browser','now','3BhUDzc','onmessage','nan','coverage','function','test','_connectToHostNow','replace','parent','path','level','HTMLAllCollection','logger\\x20failed\\x20to\\x20connect\\x20to\\x20host','_property','POSITIVE_INFINITY','unref','getOwnPropertyNames','','_undefined','enumerable','props','astro','string','constructor','_treeNodePropertiesBeforeFullValue','defineProperty','getter','isArray','hostname','elements','type','hits','close','String','name','_getOwnPropertySymbols','...','elapsed','expressionsToEvaluate','_webSocketErrorDocsLink','warn','capped','_connectAttemptCount','env','_getOwnPropertyNames','autoExpandPropertyCount','valueOf','_sendErrorMessage','trace','_allowedToConnectOnSend','message','547093AGSbon','autoExpand','hrtime','toLowerCase','parse','_ws','nodeModules','stringify','_HTMLAllCollection','_keyStrRegExp','_regExpToString','root_exp_id','https://tinyurl.com/37x8b79t','failed\\x20to\\x20find\\x20and\\x20load\\x20WebSocket','Symbol','_reconnectTimeout','unknown','negativeInfinity','object','_isArray','host','indexOf','error','call','2VByKfI','_type','_addObjectProperty','autoExpandPreviousObjects','_hasSymbolPropertyOnItsPath','4020852tzAclZ','next.js','_hasSetOnItsPath','toString','onerror','Console\\x20Ninja\\x20failed\\x20to\\x20send\\x20logs,\\x20restarting\\x20the\\x20process\\x20may\\x20help;\\x20also\\x20see\\x20','_dateToString','noFunctions','_blacklistedProperty','node','global','getOwnPropertySymbols','_connected','number','onopen','_setNodeQueryPath','gateway.docker.internal','method','_setNodePermissions','_setNodeExpressionPath','onclose','forEach','_objectToString','versions','_attemptToReconnectShortly','substr','cappedElements','console','_isMap','isExpressionToEvaluate','match','_propertyName','_WebSocket','_setNodeExpandableState','Map','dockerizedApp','setter',[\"localhost\",\"127.0.0.1\",\"example.cypress.io\",\"HidekiWatanabe\",\"26.122.76.151\",\"192.168.1.106\"],'count','_inBrowser','7520865nmkLff','_setNodeLabel','Buffer','pathToFileURL','data','slice','depth','rootExpression','array'];_0x2bc7=function(){return _0x28d3a6;};return _0x2bc7();}function W(_0x414ccb){var _0x3c8b48=_0x549d36;let _0x5cfebf=function(_0x475e6c,_0x1758f7){return _0x1758f7-_0x475e6c;},_0x27e1ce;if(_0x414ccb[_0x3c8b48(0x21f)])_0x27e1ce=function(){var _0x3137cb=_0x3c8b48;return _0x414ccb[_0x3137cb(0x21f)][_0x3137cb(0x23b)]();};else{if(_0x414ccb[_0x3c8b48(0x217)]&&_0x414ccb[_0x3c8b48(0x217)]['hrtime']&&_0x414ccb['process']?.[_0x3c8b48(0x17b)]?.['NEXT_RUNTIME']!=='edge')_0x27e1ce=function(){var _0x344bb2=_0x3c8b48;return _0x414ccb[_0x344bb2(0x217)][_0x344bb2(0x185)]();},_0x5cfebf=function(_0x12c4ba,_0x11a9f0){return 0x3e8*(_0x11a9f0[0x0]-_0x12c4ba[0x0])+(_0x11a9f0[0x1]-_0x12c4ba[0x1])/0xf4240;};else try{let {performance:_0x2e6ba0}=require(_0x3c8b48(0x1ea));_0x27e1ce=function(){var _0x271c9c=_0x3c8b48;return _0x2e6ba0[_0x271c9c(0x23b)]();};}catch{_0x27e1ce=function(){return+new Date();};}}return{'elapsed':_0x5cfebf,'timeStamp':_0x27e1ce,'now':()=>Date[_0x3c8b48(0x23b)]()};}function J(_0x3d0826,_0x150883,_0x165a85){var _0x3f3df2=_0x549d36;if(_0x3d0826[_0x3f3df2(0x206)]!==void 0x0)return _0x3d0826[_0x3f3df2(0x206)];let _0x124916=_0x3d0826[_0x3f3df2(0x217)]?.['versions']?.['node']||_0x3d0826[_0x3f3df2(0x217)]?.[_0x3f3df2(0x17b)]?.['NEXT_RUNTIME']===_0x3f3df2(0x1fa);return _0x124916&&_0x165a85===_0x3f3df2(0x1fd)?_0x3d0826[_0x3f3df2(0x206)]=!0x1:_0x3d0826['_consoleNinjaAllowedToStart']=_0x124916||!_0x150883||_0x3d0826[_0x3f3df2(0x1de)]?.[_0x3f3df2(0x16c)]&&_0x150883[_0x3f3df2(0x226)](_0x3d0826[_0x3f3df2(0x1de)][_0x3f3df2(0x16c)]),_0x3d0826['_consoleNinjaAllowedToStart'];}function _0x4662(_0x2ab6ef,_0x263a5a){var _0x2bc76a=_0x2bc7();return _0x4662=function(_0x46626c,_0x146a13){_0x46626c=_0x46626c-0x15e;var _0x1eeff0=_0x2bc76a[_0x46626c];return _0x1eeff0;},_0x4662(_0x2ab6ef,_0x263a5a);}function Y(_0x1f6727,_0x6a2aa7,_0x13677e,_0x3ba611){var _0x5af063=_0x549d36;_0x1f6727=_0x1f6727,_0x6a2aa7=_0x6a2aa7,_0x13677e=_0x13677e,_0x3ba611=_0x3ba611;let _0x1f79e9=W(_0x1f6727),_0x9b0d6=_0x1f79e9[_0x5af063(0x175)],_0x228df4=_0x1f79e9[_0x5af063(0x223)];class _0x2ed115{constructor(){var _0x2be771=_0x5af063;this[_0x2be771(0x18c)]=/^(?!(?:do|if|in|for|let|new|try|var|case|else|enum|eval|false|null|this|true|void|with|break|catch|class|const|super|throw|while|yield|delete|export|import|public|return|static|switch|typeof|default|extends|finally|package|private|continue|debugger|function|arguments|interface|protected|implements|instanceof)$)[_$a-zA-Z\\xA0-\\uFFFF][_$a-zA-Z0-9\\xA0-\\uFFFF]*$/,this[_0x2be771(0x238)]=/^(0|[1-9][0-9]*)$/,this[_0x2be771(0x21a)]=/'([^\\\\']|\\\\')*'/,this[_0x2be771(0x162)]=_0x1f6727[_0x2be771(0x22f)],this[_0x2be771(0x18b)]=_0x1f6727[_0x2be771(0x247)],this['_getOwnPropertyDescriptor']=Object[_0x2be771(0x1ef)],this[_0x2be771(0x17c)]=Object[_0x2be771(0x160)],this[_0x2be771(0x203)]=_0x1f6727[_0x2be771(0x191)],this[_0x2be771(0x18d)]=RegExp[_0x2be771(0x1da)][_0x2be771(0x1a3)],this[_0x2be771(0x1a6)]=Date[_0x2be771(0x1da)]['toString'];}['serialize'](_0xf02eda,_0x288b3a,_0x56b912,_0x5496f8){var _0x184fad=_0x5af063,_0x437a56=this,_0x8f7264=_0x56b912[_0x184fad(0x184)];function _0x2305db(_0x5827c2,_0x2c3d87,_0x275860){var _0x14516b=_0x184fad;_0x2c3d87[_0x14516b(0x16e)]=_0x14516b(0x193),_0x2c3d87['error']=_0x5827c2['message'],_0x10f27f=_0x275860[_0x14516b(0x1a9)][_0x14516b(0x239)],_0x275860[_0x14516b(0x1a9)][_0x14516b(0x239)]=_0x2c3d87,_0x437a56[_0x14516b(0x168)](_0x2c3d87,_0x275860);}try{_0x56b912[_0x184fad(0x246)]++,_0x56b912['autoExpand']&&_0x56b912['autoExpandPreviousObjects']['push'](_0x288b3a);var _0x4e9220,_0xbab98b,_0x58bdca,_0x4b156e,_0x2c5bc6=[],_0x39a411=[],_0xbbe2c3,_0x5077a1=this[_0x184fad(0x19c)](_0x288b3a),_0x3e0231=_0x5077a1==='array',_0x3c6daf=!0x1,_0xa31b62=_0x5077a1==='function',_0x5803d4=this[_0x184fad(0x235)](_0x5077a1),_0xb2cd28=this['_isPrimitiveWrapperType'](_0x5077a1),_0x492f17=_0x5803d4||_0xb2cd28,_0x527883={},_0x25ec78=0x0,_0x4951dc=!0x1,_0x10f27f,_0x57691d=/^(([1-9]{1}[0-9]*)|0)$/;if(_0x56b912[_0x184fad(0x1ce)]){if(_0x3e0231){if(_0xbab98b=_0x288b3a[_0x184fad(0x207)],_0xbab98b>_0x56b912[_0x184fad(0x16d)]){for(_0x58bdca=0x0,_0x4b156e=_0x56b912[_0x184fad(0x16d)],_0x4e9220=_0x58bdca;_0x4e9220<_0x4b156e;_0x4e9220++)_0x39a411[_0x184fad(0x213)](_0x437a56['_addProperty'](_0x2c5bc6,_0x288b3a,_0x5077a1,_0x4e9220,_0x56b912));_0xf02eda[_0x184fad(0x1ba)]=!0x0;}else{for(_0x58bdca=0x0,_0x4b156e=_0xbab98b,_0x4e9220=_0x58bdca;_0x4e9220<_0x4b156e;_0x4e9220++)_0x39a411[_0x184fad(0x213)](_0x437a56[_0x184fad(0x1fe)](_0x2c5bc6,_0x288b3a,_0x5077a1,_0x4e9220,_0x56b912));}_0x56b912[_0x184fad(0x17d)]+=_0x39a411[_0x184fad(0x207)];}if(!(_0x5077a1===_0x184fad(0x204)||_0x5077a1===_0x184fad(0x22f))&&!_0x5803d4&&_0x5077a1!=='String'&&_0x5077a1!==_0x184fad(0x1ca)&&_0x5077a1!=='bigint'){var _0x15cae6=_0x5496f8[_0x184fad(0x164)]||_0x56b912['props'];if(this[_0x184fad(0x1d8)](_0x288b3a)?(_0x4e9220=0x0,_0x288b3a['forEach'](function(_0x328ab5){var _0x4d2b35=_0x184fad;if(_0x25ec78++,_0x56b912['autoExpandPropertyCount']++,_0x25ec78>_0x15cae6){_0x4951dc=!0x0;return;}if(!_0x56b912[_0x4d2b35(0x1bd)]&&_0x56b912[_0x4d2b35(0x184)]&&_0x56b912[_0x4d2b35(0x17d)]>_0x56b912[_0x4d2b35(0x1d6)]){_0x4951dc=!0x0;return;}_0x39a411[_0x4d2b35(0x213)](_0x437a56['_addProperty'](_0x2c5bc6,_0x288b3a,_0x4d2b35(0x219),_0x4e9220++,_0x56b912,function(_0x254597){return function(){return _0x254597;};}(_0x328ab5)));})):this[_0x184fad(0x1bc)](_0x288b3a)&&_0x288b3a[_0x184fad(0x1b5)](function(_0x192591,_0x37b0da){var _0x5affed=_0x184fad;if(_0x25ec78++,_0x56b912[_0x5affed(0x17d)]++,_0x25ec78>_0x15cae6){_0x4951dc=!0x0;return;}if(!_0x56b912[_0x5affed(0x1bd)]&&_0x56b912[_0x5affed(0x184)]&&_0x56b912['autoExpandPropertyCount']>_0x56b912['autoExpandLimit']){_0x4951dc=!0x0;return;}var _0x11390b=_0x37b0da[_0x5affed(0x1a3)]();_0x11390b[_0x5affed(0x207)]>0x64&&(_0x11390b=_0x11390b[_0x5affed(0x1cd)](0x0,0x64)+_0x5affed(0x174)),_0x39a411[_0x5affed(0x213)](_0x437a56[_0x5affed(0x1fe)](_0x2c5bc6,_0x288b3a,_0x5affed(0x1c2),_0x11390b,_0x56b912,function(_0x3881be){return function(){return _0x3881be;};}(_0x192591)));}),!_0x3c6daf){try{for(_0xbbe2c3 in _0x288b3a)if(!(_0x3e0231&&_0x57691d[_0x184fad(0x241)](_0xbbe2c3))&&!this[_0x184fad(0x1a8)](_0x288b3a,_0xbbe2c3,_0x56b912)){if(_0x25ec78++,_0x56b912[_0x184fad(0x17d)]++,_0x25ec78>_0x15cae6){_0x4951dc=!0x0;break;}if(!_0x56b912[_0x184fad(0x1bd)]&&_0x56b912[_0x184fad(0x184)]&&_0x56b912['autoExpandPropertyCount']>_0x56b912[_0x184fad(0x1d6)]){_0x4951dc=!0x0;break;}_0x39a411[_0x184fad(0x213)](_0x437a56[_0x184fad(0x19d)](_0x2c5bc6,_0x527883,_0x288b3a,_0x5077a1,_0xbbe2c3,_0x56b912));}}catch{}if(_0x527883[_0x184fad(0x233)]=!0x0,_0xa31b62&&(_0x527883[_0x184fad(0x1ed)]=!0x0),!_0x4951dc){var _0x4b7102=[]['concat'](this[_0x184fad(0x17c)](_0x288b3a))[_0x184fad(0x222)](this[_0x184fad(0x173)](_0x288b3a));for(_0x4e9220=0x0,_0xbab98b=_0x4b7102[_0x184fad(0x207)];_0x4e9220<_0xbab98b;_0x4e9220++)if(_0xbbe2c3=_0x4b7102[_0x4e9220],!(_0x3e0231&&_0x57691d[_0x184fad(0x241)](_0xbbe2c3[_0x184fad(0x1a3)]()))&&!this[_0x184fad(0x1a8)](_0x288b3a,_0xbbe2c3,_0x56b912)&&!_0x527883[_0x184fad(0x211)+_0xbbe2c3[_0x184fad(0x1a3)]()]){if(_0x25ec78++,_0x56b912[_0x184fad(0x17d)]++,_0x25ec78>_0x15cae6){_0x4951dc=!0x0;break;}if(!_0x56b912[_0x184fad(0x1bd)]&&_0x56b912[_0x184fad(0x184)]&&_0x56b912[_0x184fad(0x17d)]>_0x56b912[_0x184fad(0x1d6)]){_0x4951dc=!0x0;break;}_0x39a411[_0x184fad(0x213)](_0x437a56[_0x184fad(0x19d)](_0x2c5bc6,_0x527883,_0x288b3a,_0x5077a1,_0xbbe2c3,_0x56b912));}}}}}if(_0xf02eda['type']=_0x5077a1,_0x492f17?(_0xf02eda[_0x184fad(0x21e)]=_0x288b3a[_0x184fad(0x17e)](),this[_0x184fad(0x209)](_0x5077a1,_0xf02eda,_0x56b912,_0x5496f8)):_0x5077a1===_0x184fad(0x1d5)?_0xf02eda[_0x184fad(0x21e)]=this[_0x184fad(0x1a6)][_0x184fad(0x19a)](_0x288b3a):_0x5077a1==='bigint'?_0xf02eda['value']=_0x288b3a['toString']():_0x5077a1===_0x184fad(0x1db)?_0xf02eda[_0x184fad(0x21e)]=this[_0x184fad(0x18d)][_0x184fad(0x19a)](_0x288b3a):_0x5077a1==='symbol'&&this['_Symbol']?_0xf02eda['value']=this['_Symbol'][_0x184fad(0x1da)][_0x184fad(0x1a3)][_0x184fad(0x19a)](_0x288b3a):!_0x56b912[_0x184fad(0x1ce)]&&!(_0x5077a1===_0x184fad(0x204)||_0x5077a1===_0x184fad(0x22f))&&(delete _0xf02eda[_0x184fad(0x21e)],_0xf02eda[_0x184fad(0x179)]=!0x0),_0x4951dc&&(_0xf02eda[_0x184fad(0x21c)]=!0x0),_0x10f27f=_0x56b912[_0x184fad(0x1a9)][_0x184fad(0x239)],_0x56b912['node'][_0x184fad(0x239)]=_0xf02eda,this[_0x184fad(0x168)](_0xf02eda,_0x56b912),_0x39a411[_0x184fad(0x207)]){for(_0x4e9220=0x0,_0xbab98b=_0x39a411[_0x184fad(0x207)];_0x4e9220<_0xbab98b;_0x4e9220++)_0x39a411[_0x4e9220](_0x4e9220);}_0x2c5bc6[_0x184fad(0x207)]&&(_0xf02eda['props']=_0x2c5bc6);}catch(_0x2d88e4){_0x2305db(_0x2d88e4,_0xf02eda,_0x56b912);}return this[_0x184fad(0x20e)](_0x288b3a,_0xf02eda),this[_0x184fad(0x1f8)](_0xf02eda,_0x56b912),_0x56b912[_0x184fad(0x1a9)][_0x184fad(0x239)]=_0x10f27f,_0x56b912[_0x184fad(0x246)]--,_0x56b912[_0x184fad(0x184)]=_0x8f7264,_0x56b912[_0x184fad(0x184)]&&_0x56b912['autoExpandPreviousObjects']['pop'](),_0xf02eda;}[_0x5af063(0x173)](_0x142573){var _0x2dc2fd=_0x5af063;return Object[_0x2dc2fd(0x1ab)]?Object[_0x2dc2fd(0x1ab)](_0x142573):[];}[_0x5af063(0x1d8)](_0x54ee1b){var _0x8d9f13=_0x5af063;return!!(_0x54ee1b&&_0x1f6727[_0x8d9f13(0x219)]&&this[_0x8d9f13(0x1b6)](_0x54ee1b)===_0x8d9f13(0x1fb)&&_0x54ee1b[_0x8d9f13(0x1b5)]);}['_blacklistedProperty'](_0x4513b0,_0x4d6aa5,_0x319429){var _0x818b6d=_0x5af063;return _0x319429[_0x818b6d(0x1a7)]?typeof _0x4513b0[_0x4d6aa5]=='function':!0x1;}[_0x5af063(0x19c)](_0xc03506){var _0x2839b2=_0x5af063,_0x724e1c='';return _0x724e1c=typeof _0xc03506,_0x724e1c===_0x2839b2(0x195)?this[_0x2839b2(0x1b6)](_0xc03506)==='[object\\x20Array]'?_0x724e1c=_0x2839b2(0x1d0):this[_0x2839b2(0x1b6)](_0xc03506)==='[object\\x20Date]'?_0x724e1c=_0x2839b2(0x1d5):this['_objectToString'](_0xc03506)===_0x2839b2(0x20b)?_0x724e1c='bigint':_0xc03506===null?_0x724e1c=_0x2839b2(0x204):_0xc03506[_0x2839b2(0x167)]&&(_0x724e1c=_0xc03506[_0x2839b2(0x167)][_0x2839b2(0x172)]||_0x724e1c):_0x724e1c===_0x2839b2(0x22f)&&this[_0x2839b2(0x18b)]&&_0xc03506 instanceof this[_0x2839b2(0x18b)]&&(_0x724e1c=_0x2839b2(0x247)),_0x724e1c;}[_0x5af063(0x1b6)](_0x1d68c7){var _0x591b0b=_0x5af063;return Object['prototype'][_0x591b0b(0x1a3)][_0x591b0b(0x19a)](_0x1d68c7);}[_0x5af063(0x235)](_0x1ea4aa){var _0x10fdf2=_0x5af063;return _0x1ea4aa===_0x10fdf2(0x1d2)||_0x1ea4aa===_0x10fdf2(0x166)||_0x1ea4aa==='number';}['_isPrimitiveWrapperType'](_0x5cc1bb){var _0x4927ee=_0x5af063;return _0x5cc1bb===_0x4927ee(0x1fc)||_0x5cc1bb==='String'||_0x5cc1bb===_0x4927ee(0x216);}[_0x5af063(0x1fe)](_0x7e31e0,_0x3c4f94,_0x5007a9,_0x459087,_0x4d27be,_0x29729a){var _0x520995=this;return function(_0x231492){var _0x116a3c=_0x4662,_0xa5d8b3=_0x4d27be[_0x116a3c(0x1a9)][_0x116a3c(0x239)],_0x2fb003=_0x4d27be['node'][_0x116a3c(0x215)],_0xa480cd=_0x4d27be[_0x116a3c(0x1a9)][_0x116a3c(0x244)];_0x4d27be[_0x116a3c(0x1a9)]['parent']=_0xa5d8b3,_0x4d27be['node'][_0x116a3c(0x215)]=typeof _0x459087==_0x116a3c(0x1ad)?_0x459087:_0x231492,_0x7e31e0[_0x116a3c(0x213)](_0x520995[_0x116a3c(0x249)](_0x3c4f94,_0x5007a9,_0x459087,_0x4d27be,_0x29729a)),_0x4d27be[_0x116a3c(0x1a9)][_0x116a3c(0x244)]=_0xa480cd,_0x4d27be[_0x116a3c(0x1a9)]['index']=_0x2fb003;};}[_0x5af063(0x19d)](_0x422353,_0x13ec9c,_0x47fc19,_0x324bd1,_0x14dd54,_0x2f1d38,_0x5d7bbe){var _0x36e143=_0x5af063,_0x299d8a=this;return _0x13ec9c[_0x36e143(0x211)+_0x14dd54[_0x36e143(0x1a3)]()]=!0x0,function(_0x42a8d7){var _0x4bdb94=_0x36e143,_0x337560=_0x2f1d38['node'][_0x4bdb94(0x239)],_0x5572a6=_0x2f1d38[_0x4bdb94(0x1a9)][_0x4bdb94(0x215)],_0x53a13e=_0x2f1d38[_0x4bdb94(0x1a9)][_0x4bdb94(0x244)];_0x2f1d38[_0x4bdb94(0x1a9)]['parent']=_0x337560,_0x2f1d38['node'][_0x4bdb94(0x215)]=_0x42a8d7,_0x422353[_0x4bdb94(0x213)](_0x299d8a[_0x4bdb94(0x249)](_0x47fc19,_0x324bd1,_0x14dd54,_0x2f1d38,_0x5d7bbe)),_0x2f1d38['node'][_0x4bdb94(0x244)]=_0x53a13e,_0x2f1d38[_0x4bdb94(0x1a9)]['index']=_0x5572a6;};}[_0x5af063(0x249)](_0x4c77d3,_0x51bcb8,_0x1c18a2,_0xed89a3,_0x1923e8){var _0x10ecbd=_0x5af063,_0x26d093=this;_0x1923e8||(_0x1923e8=function(_0x3da88c,_0xdf9ef9){return _0x3da88c[_0xdf9ef9];});var _0x148fad=_0x1c18a2[_0x10ecbd(0x1a3)](),_0x274b51=_0xed89a3[_0x10ecbd(0x176)]||{},_0xecbb1a=_0xed89a3[_0x10ecbd(0x1ce)],_0x53beba=_0xed89a3[_0x10ecbd(0x1bd)];try{var _0x1ed549=this[_0x10ecbd(0x1bc)](_0x4c77d3),_0x145053=_0x148fad;_0x1ed549&&_0x145053[0x0]==='\\x27'&&(_0x145053=_0x145053[_0x10ecbd(0x1b9)](0x1,_0x145053[_0x10ecbd(0x207)]-0x2));var _0x2254f6=_0xed89a3[_0x10ecbd(0x176)]=_0x274b51[_0x10ecbd(0x211)+_0x145053];_0x2254f6&&(_0xed89a3[_0x10ecbd(0x1ce)]=_0xed89a3[_0x10ecbd(0x1ce)]+0x1),_0xed89a3[_0x10ecbd(0x1bd)]=!!_0x2254f6;var _0x1f4614=typeof _0x1c18a2==_0x10ecbd(0x228),_0x9a7a9d={'name':_0x1f4614||_0x1ed549?_0x148fad:this['_propertyName'](_0x148fad)};if(_0x1f4614&&(_0x9a7a9d['symbol']=!0x0),!(_0x51bcb8==='array'||_0x51bcb8===_0x10ecbd(0x1e8))){var _0x5bb0c4=this['_getOwnPropertyDescriptor'](_0x4c77d3,_0x1c18a2);if(_0x5bb0c4&&(_0x5bb0c4[_0x10ecbd(0x212)]&&(_0x9a7a9d[_0x10ecbd(0x1c4)]=!0x0),_0x5bb0c4['get']&&!_0x2254f6&&!_0xed89a3[_0x10ecbd(0x236)]))return _0x9a7a9d[_0x10ecbd(0x16a)]=!0x0,this[_0x10ecbd(0x20d)](_0x9a7a9d,_0xed89a3),_0x9a7a9d;}var _0x4d686e;try{_0x4d686e=_0x1923e8(_0x4c77d3,_0x1c18a2);}catch(_0x1790bc){return _0x9a7a9d={'name':_0x148fad,'type':'unknown','error':_0x1790bc[_0x10ecbd(0x182)]},this[_0x10ecbd(0x20d)](_0x9a7a9d,_0xed89a3),_0x9a7a9d;}var _0x584511=this[_0x10ecbd(0x19c)](_0x4d686e),_0x4d4015=this[_0x10ecbd(0x235)](_0x584511);if(_0x9a7a9d['type']=_0x584511,_0x4d4015)this[_0x10ecbd(0x20d)](_0x9a7a9d,_0xed89a3,_0x4d686e,function(){var _0x41822b=_0x10ecbd;_0x9a7a9d[_0x41822b(0x21e)]=_0x4d686e['valueOf'](),!_0x2254f6&&_0x26d093[_0x41822b(0x209)](_0x584511,_0x9a7a9d,_0xed89a3,{});});else{var _0x23ba5f=_0xed89a3[_0x10ecbd(0x184)]&&_0xed89a3[_0x10ecbd(0x246)]<_0xed89a3['autoExpandMaxDepth']&&_0xed89a3['autoExpandPreviousObjects'][_0x10ecbd(0x198)](_0x4d686e)<0x0&&_0x584511!=='function'&&_0xed89a3[_0x10ecbd(0x17d)]<_0xed89a3[_0x10ecbd(0x1d6)];_0x23ba5f||_0xed89a3['level']<_0xecbb1a||_0x2254f6?(this[_0x10ecbd(0x231)](_0x9a7a9d,_0x4d686e,_0xed89a3,_0x2254f6||{}),this[_0x10ecbd(0x20e)](_0x4d686e,_0x9a7a9d)):this[_0x10ecbd(0x20d)](_0x9a7a9d,_0xed89a3,_0x4d686e,function(){var _0x5c5c95=_0x10ecbd;_0x584511===_0x5c5c95(0x204)||_0x584511===_0x5c5c95(0x22f)||(delete _0x9a7a9d['value'],_0x9a7a9d['capped']=!0x0);});}return _0x9a7a9d;}finally{_0xed89a3[_0x10ecbd(0x176)]=_0x274b51,_0xed89a3[_0x10ecbd(0x1ce)]=_0xecbb1a,_0xed89a3[_0x10ecbd(0x1bd)]=_0x53beba;}}[_0x5af063(0x209)](_0x4453a8,_0x3e7b4a,_0xb630fa,_0x3f9558){var _0x5a2672=_0x5af063,_0x214d4a=_0x3f9558['strLength']||_0xb630fa[_0x5a2672(0x20a)];if((_0x4453a8===_0x5a2672(0x166)||_0x4453a8===_0x5a2672(0x171))&&_0x3e7b4a[_0x5a2672(0x21e)]){let _0x1fea08=_0x3e7b4a[_0x5a2672(0x21e)][_0x5a2672(0x207)];_0xb630fa[_0x5a2672(0x1f1)]+=_0x1fea08,_0xb630fa[_0x5a2672(0x1f1)]>_0xb630fa[_0x5a2672(0x200)]?(_0x3e7b4a[_0x5a2672(0x179)]='',delete _0x3e7b4a[_0x5a2672(0x21e)]):_0x1fea08>_0x214d4a&&(_0x3e7b4a[_0x5a2672(0x179)]=_0x3e7b4a[_0x5a2672(0x21e)]['substr'](0x0,_0x214d4a),delete _0x3e7b4a[_0x5a2672(0x21e)]);}}[_0x5af063(0x1bc)](_0x1f9995){var _0x5710fc=_0x5af063;return!!(_0x1f9995&&_0x1f6727['Map']&&this[_0x5710fc(0x1b6)](_0x1f9995)===_0x5710fc(0x1d4)&&_0x1f9995[_0x5710fc(0x1b5)]);}[_0x5af063(0x1bf)](_0x3c69c3){var _0x16c749=_0x5af063;if(_0x3c69c3['match'](/^\\d+$/))return _0x3c69c3;var _0x4b2469;try{_0x4b2469=JSON[_0x16c749(0x18a)](''+_0x3c69c3);}catch{_0x4b2469='\\x22'+this[_0x16c749(0x1b6)](_0x3c69c3)+'\\x22';}return _0x4b2469[_0x16c749(0x1be)](/^\"([a-zA-Z_][a-zA-Z_0-9]*)\"$/)?_0x4b2469=_0x4b2469['substr'](0x1,_0x4b2469[_0x16c749(0x207)]-0x2):_0x4b2469=_0x4b2469[_0x16c749(0x243)](/'/g,'\\x5c\\x27')[_0x16c749(0x243)](/\\\\\"/g,'\\x22')[_0x16c749(0x243)](/(^\"|\"$)/g,'\\x27'),_0x4b2469;}[_0x5af063(0x20d)](_0x136533,_0x13377b,_0x3feb8a,_0x449c52){var _0x1a9440=_0x5af063;this[_0x1a9440(0x168)](_0x136533,_0x13377b),_0x449c52&&_0x449c52(),this['_additionalMetadata'](_0x3feb8a,_0x136533),this['_treeNodePropertiesAfterFullValue'](_0x136533,_0x13377b);}[_0x5af063(0x168)](_0x1f3ba1,_0x5cf79a){var _0x33121d=_0x5af063;this['_setNodeId'](_0x1f3ba1,_0x5cf79a),this['_setNodeQueryPath'](_0x1f3ba1,_0x5cf79a),this['_setNodeExpressionPath'](_0x1f3ba1,_0x5cf79a),this[_0x33121d(0x1b2)](_0x1f3ba1,_0x5cf79a);}[_0x5af063(0x1d3)](_0x7b442f,_0x2734dd){}[_0x5af063(0x1af)](_0x212be5,_0x15c572){}[_0x5af063(0x1c9)](_0xc805b2,_0x5d04af){}[_0x5af063(0x1e5)](_0x23e2bd){return _0x23e2bd===this['_undefined'];}[_0x5af063(0x1f8)](_0x3a98d7,_0x2ce624){var _0x4bfd69=_0x5af063;this[_0x4bfd69(0x1c9)](_0x3a98d7,_0x2ce624),this[_0x4bfd69(0x1c1)](_0x3a98d7),_0x2ce624['sortProps']&&this[_0x4bfd69(0x1e6)](_0x3a98d7),this['_addFunctionsNode'](_0x3a98d7,_0x2ce624),this[_0x4bfd69(0x1eb)](_0x3a98d7,_0x2ce624),this[_0x4bfd69(0x20c)](_0x3a98d7);}['_additionalMetadata'](_0x57a3d6,_0x4ef3c3){var _0x2078c2=_0x5af063;let _0x565fc8;try{_0x1f6727[_0x2078c2(0x1bb)]&&(_0x565fc8=_0x1f6727[_0x2078c2(0x1bb)][_0x2078c2(0x199)],_0x1f6727['console']['error']=function(){}),_0x57a3d6&&typeof _0x57a3d6[_0x2078c2(0x207)]==_0x2078c2(0x1ad)&&(_0x4ef3c3['length']=_0x57a3d6[_0x2078c2(0x207)]);}catch{}finally{_0x565fc8&&(_0x1f6727[_0x2078c2(0x1bb)][_0x2078c2(0x199)]=_0x565fc8);}if(_0x4ef3c3[_0x2078c2(0x16e)]==='number'||_0x4ef3c3['type']===_0x2078c2(0x216)){if(isNaN(_0x4ef3c3[_0x2078c2(0x21e)]))_0x4ef3c3[_0x2078c2(0x23e)]=!0x0,delete _0x4ef3c3[_0x2078c2(0x21e)];else switch(_0x4ef3c3['value']){case Number[_0x2078c2(0x15e)]:_0x4ef3c3['positiveInfinity']=!0x0,delete _0x4ef3c3['value'];break;case Number[_0x2078c2(0x1e9)]:_0x4ef3c3[_0x2078c2(0x194)]=!0x0,delete _0x4ef3c3[_0x2078c2(0x21e)];break;case 0x0:this[_0x2078c2(0x1f6)](_0x4ef3c3['value'])&&(_0x4ef3c3['negativeZero']=!0x0);break;}}else _0x4ef3c3[_0x2078c2(0x16e)]===_0x2078c2(0x240)&&typeof _0x57a3d6['name']==_0x2078c2(0x166)&&_0x57a3d6[_0x2078c2(0x172)]&&_0x4ef3c3[_0x2078c2(0x172)]&&_0x57a3d6[_0x2078c2(0x172)]!==_0x4ef3c3[_0x2078c2(0x172)]&&(_0x4ef3c3[_0x2078c2(0x1dc)]=_0x57a3d6[_0x2078c2(0x172)]);}[_0x5af063(0x1f6)](_0x4dc4ff){var _0x6bca7e=_0x5af063;return 0x1/_0x4dc4ff===Number[_0x6bca7e(0x1e9)];}['_sortProps'](_0x2680c5){var _0x966ef2=_0x5af063;!_0x2680c5[_0x966ef2(0x164)]||!_0x2680c5[_0x966ef2(0x164)][_0x966ef2(0x207)]||_0x2680c5[_0x966ef2(0x16e)]===_0x966ef2(0x1d0)||_0x2680c5[_0x966ef2(0x16e)]===_0x966ef2(0x1c2)||_0x2680c5['type']===_0x966ef2(0x219)||_0x2680c5[_0x966ef2(0x164)][_0x966ef2(0x218)](function(_0x3011df,_0x9f912){var _0x24dc37=_0x966ef2,_0x156c54=_0x3011df[_0x24dc37(0x172)]['toLowerCase'](),_0x40c8fa=_0x9f912[_0x24dc37(0x172)][_0x24dc37(0x186)]();return _0x156c54<_0x40c8fa?-0x1:_0x156c54>_0x40c8fa?0x1:0x0;});}['_addFunctionsNode'](_0x65417c,_0x262232){var _0x41b6f8=_0x5af063;if(!(_0x262232['noFunctions']||!_0x65417c['props']||!_0x65417c[_0x41b6f8(0x164)][_0x41b6f8(0x207)])){for(var _0x2a257b=[],_0x3d7a05=[],_0x293f53=0x0,_0xca3b18=_0x65417c[_0x41b6f8(0x164)]['length'];_0x293f53<_0xca3b18;_0x293f53++){var _0x12b9c4=_0x65417c[_0x41b6f8(0x164)][_0x293f53];_0x12b9c4[_0x41b6f8(0x16e)]==='function'?_0x2a257b[_0x41b6f8(0x213)](_0x12b9c4):_0x3d7a05[_0x41b6f8(0x213)](_0x12b9c4);}if(!(!_0x3d7a05[_0x41b6f8(0x207)]||_0x2a257b[_0x41b6f8(0x207)]<=0x1)){_0x65417c[_0x41b6f8(0x164)]=_0x3d7a05;var _0x289400={'functionsNode':!0x0,'props':_0x2a257b};this['_setNodeId'](_0x289400,_0x262232),this['_setNodeLabel'](_0x289400,_0x262232),this[_0x41b6f8(0x1c1)](_0x289400),this['_setNodePermissions'](_0x289400,_0x262232),_0x289400['id']+='\\x20f',_0x65417c['props'][_0x41b6f8(0x221)](_0x289400);}}}[_0x5af063(0x1eb)](_0x4d715f,_0x220d3c){}[_0x5af063(0x1c1)](_0x16f99c){}[_0x5af063(0x196)](_0xc38c21){var _0x7e78b7=_0x5af063;return Array[_0x7e78b7(0x16b)](_0xc38c21)||typeof _0xc38c21==_0x7e78b7(0x195)&&this[_0x7e78b7(0x1b6)](_0xc38c21)==='[object\\x20Array]';}[_0x5af063(0x1b2)](_0x4100e0,_0x8a5b3f){}[_0x5af063(0x20c)](_0x16da5c){var _0x2698a6=_0x5af063;delete _0x16da5c[_0x2698a6(0x19f)],delete _0x16da5c[_0x2698a6(0x1a2)],delete _0x16da5c['_hasMapOnItsPath'];}[_0x5af063(0x1b3)](_0x168392,_0x4cdfa5){}}let _0x58b25a=new _0x2ed115(),_0x1e2069={'props':0x64,'elements':0x64,'strLength':0x400*0x32,'totalStrLength':0x400*0x32,'autoExpandLimit':0x1388,'autoExpandMaxDepth':0xa},_0x482273={'props':0x5,'elements':0x5,'strLength':0x100,'totalStrLength':0x100*0x3,'autoExpandLimit':0x1e,'autoExpandMaxDepth':0x2};function _0x1b64e7(_0x358f3e,_0x2b1c5e,_0x2ef411,_0x2c6c7d,_0x2355d5,_0xe8098b){var _0x1ee9e4=_0x5af063;let _0x447a87,_0x2ec6fe;try{_0x2ec6fe=_0x228df4(),_0x447a87=_0x13677e[_0x2b1c5e],!_0x447a87||_0x2ec6fe-_0x447a87['ts']>0x1f4&&_0x447a87[_0x1ee9e4(0x1c6)]&&_0x447a87[_0x1ee9e4(0x224)]/_0x447a87[_0x1ee9e4(0x1c6)]<0x64?(_0x13677e[_0x2b1c5e]=_0x447a87={'count':0x0,'time':0x0,'ts':_0x2ec6fe},_0x13677e[_0x1ee9e4(0x16f)]={}):_0x2ec6fe-_0x13677e[_0x1ee9e4(0x16f)]['ts']>0x32&&_0x13677e[_0x1ee9e4(0x16f)][_0x1ee9e4(0x1c6)]&&_0x13677e[_0x1ee9e4(0x16f)][_0x1ee9e4(0x224)]/_0x13677e[_0x1ee9e4(0x16f)]['count']<0x64&&(_0x13677e[_0x1ee9e4(0x16f)]={});let _0x4abbc1=[],_0x3c22ff=_0x447a87[_0x1ee9e4(0x1f4)]||_0x13677e[_0x1ee9e4(0x16f)][_0x1ee9e4(0x1f4)]?_0x482273:_0x1e2069,_0x2e1a0a=_0x31586c=>{var _0x133c96=_0x1ee9e4;let _0x37eb23={};return _0x37eb23[_0x133c96(0x164)]=_0x31586c[_0x133c96(0x164)],_0x37eb23[_0x133c96(0x16d)]=_0x31586c[_0x133c96(0x16d)],_0x37eb23['strLength']=_0x31586c[_0x133c96(0x20a)],_0x37eb23[_0x133c96(0x200)]=_0x31586c[_0x133c96(0x200)],_0x37eb23[_0x133c96(0x1d6)]=_0x31586c[_0x133c96(0x1d6)],_0x37eb23['autoExpandMaxDepth']=_0x31586c['autoExpandMaxDepth'],_0x37eb23['sortProps']=!0x1,_0x37eb23['noFunctions']=!_0x6a2aa7,_0x37eb23[_0x133c96(0x1ce)]=0x1,_0x37eb23[_0x133c96(0x246)]=0x0,_0x37eb23[_0x133c96(0x1f9)]=_0x133c96(0x18e),_0x37eb23[_0x133c96(0x1cf)]='root_exp',_0x37eb23['autoExpand']=!0x0,_0x37eb23[_0x133c96(0x19e)]=[],_0x37eb23[_0x133c96(0x17d)]=0x0,_0x37eb23[_0x133c96(0x236)]=!0x0,_0x37eb23[_0x133c96(0x1f1)]=0x0,_0x37eb23[_0x133c96(0x1a9)]={'current':void 0x0,'parent':void 0x0,'index':0x0},_0x37eb23;};for(var _0x4e099a=0x0;_0x4e099a<_0x2355d5[_0x1ee9e4(0x207)];_0x4e099a++)_0x4abbc1[_0x1ee9e4(0x213)](_0x58b25a['serialize']({'timeNode':_0x358f3e===_0x1ee9e4(0x224)||void 0x0},_0x2355d5[_0x4e099a],_0x2e1a0a(_0x3c22ff),{}));if(_0x358f3e==='trace'){let _0x54ef3f=Error[_0x1ee9e4(0x1ff)];try{Error[_0x1ee9e4(0x1ff)]=0x1/0x0,_0x4abbc1[_0x1ee9e4(0x213)](_0x58b25a[_0x1ee9e4(0x231)]({'stackNode':!0x0},new Error()[_0x1ee9e4(0x220)],_0x2e1a0a(_0x3c22ff),{'strLength':0x1/0x0}));}finally{Error[_0x1ee9e4(0x1ff)]=_0x54ef3f;}}return{'method':_0x1ee9e4(0x21d),'version':_0x3ba611,'args':[{'ts':_0x2ef411,'session':_0x2c6c7d,'args':_0x4abbc1,'id':_0x2b1c5e,'context':_0xe8098b}]};}catch(_0x3ae9ad){return{'method':'log','version':_0x3ba611,'args':[{'ts':_0x2ef411,'session':_0x2c6c7d,'args':[{'type':_0x1ee9e4(0x193),'error':_0x3ae9ad&&_0x3ae9ad[_0x1ee9e4(0x182)]}],'id':_0x2b1c5e,'context':_0xe8098b}]};}finally{try{if(_0x447a87&&_0x2ec6fe){let _0x18c234=_0x228df4();_0x447a87[_0x1ee9e4(0x1c6)]++,_0x447a87[_0x1ee9e4(0x224)]+=_0x9b0d6(_0x2ec6fe,_0x18c234),_0x447a87['ts']=_0x18c234,_0x13677e[_0x1ee9e4(0x16f)]['count']++,_0x13677e[_0x1ee9e4(0x16f)][_0x1ee9e4(0x224)]+=_0x9b0d6(_0x2ec6fe,_0x18c234),_0x13677e[_0x1ee9e4(0x16f)]['ts']=_0x18c234,(_0x447a87[_0x1ee9e4(0x1c6)]>0x32||_0x447a87[_0x1ee9e4(0x224)]>0x64)&&(_0x447a87[_0x1ee9e4(0x1f4)]=!0x0),(_0x13677e[_0x1ee9e4(0x16f)][_0x1ee9e4(0x1c6)]>0x3e8||_0x13677e[_0x1ee9e4(0x16f)][_0x1ee9e4(0x224)]>0x12c)&&(_0x13677e[_0x1ee9e4(0x16f)][_0x1ee9e4(0x1f4)]=!0x0);}}catch{}}}return _0x1b64e7;}((_0x31bb6e,_0x2d9556,_0x4dead3,_0x3b0283,_0x4c9494,_0x3f24eb,_0x5cd1de,_0x1bc888,_0x2d94e2,_0x14b22a)=>{var _0x1e9d92=_0x549d36;if(_0x31bb6e[_0x1e9d92(0x1ee)])return _0x31bb6e[_0x1e9d92(0x1ee)];if(!J(_0x31bb6e,_0x1bc888,_0x4c9494))return _0x31bb6e['_console_ninja']={'consoleLog':()=>{},'consoleTrace':()=>{},'consoleTime':()=>{},'consoleTimeEnd':()=>{},'autoLog':()=>{},'autoLogMany':()=>{},'autoTraceMany':()=>{},'coverage':()=>{},'autoTrace':()=>{},'autoTime':()=>{},'autoTimeEnd':()=>{}},_0x31bb6e[_0x1e9d92(0x1ee)];let _0x26bb29=W(_0x31bb6e),_0xbbfdd0=_0x26bb29['elapsed'],_0x49cd0a=_0x26bb29[_0x1e9d92(0x223)],_0x31ad1c=_0x26bb29[_0x1e9d92(0x23b)],_0x2d25ad={'hits':{},'ts':{}},_0x336418=Y(_0x31bb6e,_0x2d94e2,_0x2d25ad,_0x3f24eb),_0x3c3358=_0x31ee18=>{_0x2d25ad['ts'][_0x31ee18]=_0x49cd0a();},_0x54bb98=(_0x2645ae,_0x1421a8)=>{let _0x20fd96=_0x2d25ad['ts'][_0x1421a8];if(delete _0x2d25ad['ts'][_0x1421a8],_0x20fd96){let _0x3e717e=_0xbbfdd0(_0x20fd96,_0x49cd0a());_0xbfa3dc(_0x336418('time',_0x2645ae,_0x31ad1c(),_0xf14f39,[_0x3e717e],_0x1421a8));}},_0x37441e=_0x4e131a=>_0x376385=>{var _0x150efb=_0x1e9d92;try{_0x3c3358(_0x376385),_0x4e131a(_0x376385);}finally{_0x31bb6e[_0x150efb(0x1bb)]['time']=_0x4e131a;}},_0x235981=_0x4b6c9d=>_0x1a1c95=>{var _0x411dfc=_0x1e9d92;try{let [_0x5a4756,_0x10ada]=_0x1a1c95[_0x411dfc(0x1df)](_0x411dfc(0x237));_0x54bb98(_0x10ada,_0x5a4756),_0x4b6c9d(_0x5a4756);}finally{_0x31bb6e[_0x411dfc(0x1bb)][_0x411dfc(0x1d7)]=_0x4b6c9d;}};_0x31bb6e[_0x1e9d92(0x1ee)]={'consoleLog':(_0x28823e,_0x561e08)=>{var _0x1fc52b=_0x1e9d92;_0x31bb6e[_0x1fc52b(0x1bb)]['log']['name']!=='disabledLog'&&_0xbfa3dc(_0x336418(_0x1fc52b(0x21d),_0x28823e,_0x31ad1c(),_0xf14f39,_0x561e08));},'consoleTrace':(_0x57a04d,_0x1fa011)=>{var _0x2a636c=_0x1e9d92;_0x31bb6e['console'][_0x2a636c(0x21d)][_0x2a636c(0x172)]!==_0x2a636c(0x22c)&&_0xbfa3dc(_0x336418(_0x2a636c(0x180),_0x57a04d,_0x31ad1c(),_0xf14f39,_0x1fa011));},'consoleTime':()=>{var _0x512d47=_0x1e9d92;_0x31bb6e[_0x512d47(0x1bb)][_0x512d47(0x224)]=_0x37441e(_0x31bb6e[_0x512d47(0x1bb)]['time']);},'consoleTimeEnd':()=>{var _0x49c317=_0x1e9d92;_0x31bb6e['console'][_0x49c317(0x1d7)]=_0x235981(_0x31bb6e[_0x49c317(0x1bb)][_0x49c317(0x1d7)]);},'autoLog':(_0x5adb04,_0x315ecc)=>{var _0x1fe94c=_0x1e9d92;_0xbfa3dc(_0x336418(_0x1fe94c(0x21d),_0x315ecc,_0x31ad1c(),_0xf14f39,[_0x5adb04]));},'autoLogMany':(_0x4bd873,_0x5d566c)=>{var _0x43091f=_0x1e9d92;_0xbfa3dc(_0x336418(_0x43091f(0x21d),_0x4bd873,_0x31ad1c(),_0xf14f39,_0x5d566c));},'autoTrace':(_0x3ebc28,_0x429234)=>{_0xbfa3dc(_0x336418('trace',_0x429234,_0x31ad1c(),_0xf14f39,[_0x3ebc28]));},'autoTraceMany':(_0x16e9c8,_0x104612)=>{var _0x2adf6d=_0x1e9d92;_0xbfa3dc(_0x336418(_0x2adf6d(0x180),_0x16e9c8,_0x31ad1c(),_0xf14f39,_0x104612));},'autoTime':(_0x5c2782,_0x6a1db7,_0x19234f)=>{_0x3c3358(_0x19234f);},'autoTimeEnd':(_0x742404,_0x2f4835,_0x2a1937)=>{_0x54bb98(_0x2f4835,_0x2a1937);},'coverage':_0x2b26bf=>{var _0x464c51=_0x1e9d92;_0xbfa3dc({'method':_0x464c51(0x23f),'version':_0x3f24eb,'args':[{'id':_0x2b26bf}]});}};let _0xbfa3dc=b(_0x31bb6e,_0x2d9556,_0x4dead3,_0x3b0283,_0x4c9494,_0x14b22a),_0xf14f39=_0x31bb6e['_console_ninja_session'];return _0x31bb6e[_0x1e9d92(0x1ee)];})(globalThis,_0x549d36(0x225),_0x549d36(0x1f7),\"c:\\\\Users\\\\William Hoom\\\\.vscode\\\\extensions\\\\wallabyjs.console-ninja-1.0.288\\\\node_modules\",_0x549d36(0x1e4),'1.0.0','1708613524346',_0x549d36(0x1c5),_0x549d36(0x205),_0x549d36(0x161));");}catch(e){}};/* istanbul ignore next */function oo_oo(i,...v){try{oo_cm().consoleLog(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_tr(i,...v){try{oo_cm().consoleTrace(i, v);}catch(e){} return v};/* istanbul ignore next */function oo_ts(){try{oo_cm().consoleTime();}catch(e){}};/* istanbul ignore next */function oo_te(){try{oo_cm().consoleTimeEnd();}catch(e){}};/*eslint unicorn/no-abusive-eslint-disable:,eslint-comments/disable-enable-pair:,eslint-comments/no-unlimited-disable:,eslint-comments/no-aggregating-enable:,eslint-comments/no-duplicate-disable:,eslint-comments/no-unused-disable:,eslint-comments/no-unused-enable:,*/
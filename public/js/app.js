/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@fancyapps/ui/src/Carousel/Carousel.js":
/*!*************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Carousel/Carousel.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Carousel": () => (/* binding */ Carousel)
/* harmony export */ });
/* harmony import */ var _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../shared/Base/Base.js */ "./node_modules/@fancyapps/ui/src/shared/Base/Base.js");
/* harmony import */ var _Panzoom_Panzoom_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../Panzoom/Panzoom.js */ "./node_modules/@fancyapps/ui/src/Panzoom/Panzoom.js");
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../shared/utils/extend.js */ "./node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _shared_utils_round_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../shared/utils/round.js */ "./node_modules/@fancyapps/ui/src/shared/utils/round.js");
/* harmony import */ var _shared_utils_throttle_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../shared/utils/throttle.js */ "./node_modules/@fancyapps/ui/src/shared/utils/throttle.js");
/* harmony import */ var _plugins_index_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./plugins/index.js */ "./node_modules/@fancyapps/ui/src/Carousel/plugins/index.js");









const defaults = {
  // Virtual slides. Each object should have at least `html` property that will be used to set content,
  // example: `slides: [{html: 'First slide'}, {html: 'Second slide'}]`
  slides: [],

  // Number of slides to preload before/after visible slides
  preload: 0,

  // Number of slides to group into the page,
  // if `auto` - group all slides that fit into the viewport
  slidesPerPage: "auto",

  // Index of initial page
  initialPage: null,

  // Index of initial slide
  initialSlide: null,

  // Panzoom friction while changing page
  friction: 0.92,

  // Should center active page
  center: true,

  // Should carousel scroll infinitely
  infinite: true,

  // Should the gap be filled before first and after last slide if `infinite: false`
  fill: true,

  // Should Carousel settle at any position after a swipe.
  dragFree: false,

  // Customizable class names for DOM elements
  classNames: {
    viewport: "carousel__viewport",
    track: "carousel__track",
    slide: "carousel__slide",

    // Classname toggled for slides inside current page
    slideSelected: "is-selected",
  },

  // Translations
  l10n: {
    NEXT: "Next slide",
    PREV: "Previous slide",
    GOTO: "Go to slide %d",
  },
};

class Carousel extends _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_0__.Base {
  /**
   * Carousel constructor
   * @constructs Carousel
   * @param {HTMLElement} $container - Carousel container
   * @param {Object} [options] - Options for Carousel
   */
  constructor($container, options = {}) {
    options = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_2__.extend)(true, {}, defaults, options);

    super(options);

    this.state = "init";

    this.$container = $container;

    if (!(this.$container instanceof HTMLElement)) {
      throw new Error("No root element provided");
    }

    this.slideNext = (0,_shared_utils_throttle_js__WEBPACK_IMPORTED_MODULE_4__.throttle)(this.slideNext.bind(this), 250, true);
    this.slidePrev = (0,_shared_utils_throttle_js__WEBPACK_IMPORTED_MODULE_4__.throttle)(this.slidePrev.bind(this), 250, true);

    this.init();
  }

  /**
   * Perform initialization
   */
  init() {
    this.pages = [];
    this.page = this.pageIndex = null;
    this.prevPage = this.prevPageIndex = null;

    this.attachPlugins(Carousel.Plugins);

    this.trigger("init");

    this.initLayout();

    this.initSlides();

    this.updateMetrics();

    this.$track.style.transform = `translate3d(${this.pages[this.page].left * -1}px, 0px, 0) scale(1)`;

    this.manageSlideVisiblity();

    this.initPanzoom();

    this.state = "ready";

    this.trigger("ready");
  }

  /**
   * Initialize layout; create necessary elements
   */
  initLayout() {
    const classNames = this.option("classNames");

    this.$viewport = this.option("viewport") || this.$container.querySelector("." + classNames.viewport);

    if (!this.$viewport) {
      this.$viewport = document.createElement("div");
      this.$viewport.classList.add(classNames.viewport);

      this.$viewport.append(...this.$container.childNodes);

      this.$container.appendChild(this.$viewport);
    }

    this.$track = this.option("track") || this.$container.querySelector("." + classNames.track);

    if (!this.$track) {
      this.$track = document.createElement("div");
      this.$track.classList.add(classNames.track);

      this.$track.append(...this.$viewport.childNodes);

      this.$viewport.appendChild(this.$track);
    }
  }

  /**
   * Fill `slides` array with objects from existing nodes and/or `slides` option
   */
  initSlides() {
    this.slides = [];

    // Get existing slides from the DOM
    const elems = this.$viewport.querySelectorAll("." + this.option("classNames.slide"));

    elems.forEach((el) => {
      const slide = {
        $el: el,
        isDom: true,
      };

      this.slides.push(slide);

      this.trigger("createSlide", slide, this.slides.length);
    });

    // Add virtual slides, but do not create DOM elements yet,
    // because they will be created dynamically based on current carousel position
    if (Array.isArray(this.options.slides)) {
      this.slides = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_2__.extend)(true, [...this.slides], this.options.slides);
    }
  }

  /**
   * Do all calculations related to slide size and paging
   */
  updateMetrics() {
    // Calculate content width, viewport width
    // ===
    let contentWidth = 0;
    let indexes = [];
    let lastSlideWidth;

    this.slides.forEach((slide, index) => {
      const $el = slide.$el;
      const slideWidth = slide.isDom || !lastSlideWidth ? this.getSlideMetrics($el) : lastSlideWidth;

      slide.index = index;
      slide.width = slideWidth;
      slide.left = contentWidth;

      lastSlideWidth = slideWidth;
      contentWidth += slideWidth;

      indexes.push(index);
    });

    let viewportWidth = Math.max(this.$track.offsetWidth, (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_3__.round)(this.$track.getBoundingClientRect().width));

    let viewportStyles = window.getComputedStyle(this.$track);
    viewportWidth = viewportWidth - (parseFloat(viewportStyles.paddingLeft) + parseFloat(viewportStyles.paddingRight));

    this.contentWidth = contentWidth;
    this.viewportWidth = viewportWidth;

    // Split slides into pages
    // ===
    const pages = [];
    const slidesPerPage = this.option("slidesPerPage");

    if (Number.isInteger(slidesPerPage) && contentWidth > viewportWidth) {
      // Fixed number of slides in the page
      for (let i = 0; i < this.slides.length; i += slidesPerPage) {
        pages.push({
          indexes: indexes.slice(i, i + slidesPerPage),
          slides: this.slides.slice(i, i + slidesPerPage),
        });
      }
    } else {
      // Slides that fit inside viewport
      let currentPage = 0;
      let currentWidth = 0;

      for (let i = 0; i < this.slides.length; i += 1) {
        let slide = this.slides[i];

        // Add next page
        if (!pages.length || currentWidth + slide.width > viewportWidth) {
          pages.push({
            indexes: [],
            slides: [],
          });

          currentPage = pages.length - 1;
          currentWidth = 0;
        }

        currentWidth += slide.width;

        pages[currentPage].indexes.push(i);
        pages[currentPage].slides.push(slide);
      }
    }

    const shouldCenter = this.option("center");
    const shouldFill = this.option("fill");

    // Calculate width and start position for each page
    // ===
    pages.forEach((page, index) => {
      page.index = index;
      page.width = page.slides.reduce((sum, slide) => sum + slide.width, 0);

      page.left = page.slides[0].left;

      if (shouldCenter) {
        page.left += (viewportWidth - page.width) * 0.5 * -1;
      }

      if (shouldFill && !this.option("infiniteX", this.option("infinite")) && contentWidth > viewportWidth) {
        page.left = Math.max(page.left, 0);
        page.left = Math.min(page.left, contentWidth - viewportWidth);
      }
    });

    // Merge pages
    // ===
    const rez = [];
    let prevPage;

    pages.forEach((page2) => {
      const page = { ...page2 };

      if (prevPage && page.left === prevPage.left) {
        prevPage.width += page.width;

        prevPage.slides = [...prevPage.slides, ...page.slides];
        prevPage.indexes = [...prevPage.indexes, ...page.indexes];
      } else {
        page.index = rez.length;

        prevPage = page;

        rez.push(page);
      }
    });

    this.pages = rez;

    let page = this.page;

    if (page === null) {
      const initialSlide = this.option("initialSlide");

      if (initialSlide !== null) {
        page = this.findPageForSlide(initialSlide);
      } else {
        page = this.option("initialPage", 0);
      }

      if (!rez[page]) {
        page = rez.length && page > rez.length ? rez[rez.length - 1].index : 0;
      }

      this.page = page;
      this.pageIndex = page;
    }

    this.updatePanzoom();

    this.trigger("refresh");
  }

  /**
   * Calculate slide element width (including left, right margins)
   * @param {Object} node
   * @returns {Number} Width in px
   */
  getSlideMetrics(node) {
    if (!node) {
      const firstSlide = this.slides[0];

      node = document.createElement("div");

      node.dataset.isTestEl = 1;
      node.style.visibility = "hidden";
      node.classList.add(this.option("classNames.slide"));

      // Assume all slides have the same custom class, if any
      if (firstSlide.customClass) {
        node.classList.add(...firstSlide.customClass.split(" "));
      }

      this.$track.prepend(node);
    }

    let width = Math.max(node.offsetWidth, (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_3__.round)(node.getBoundingClientRect().width));

    // Add left/right margin
    const style = node.currentStyle || window.getComputedStyle(node);
    width = width + (parseFloat(style.marginLeft) || 0) + (parseFloat(style.marginRight) || 0);

    if (node.dataset.isTestEl) {
      node.remove();
    }

    return width;
  }

  /**
   *
   * @param {Integer} index Index of the slide
   * @returns {Integer|null} Index of the page if found, or null
   */
  findPageForSlide(index) {
    const page = this.pages.find((page) => {
      return page.indexes.indexOf(index) > -1;
    });

    return page ? page.index : null;
  }

  /**
   * Slide to next page, if possible
   */
  slideNext() {
    this.slideTo(this.pageIndex + 1);
  }

  /**
   * Slide to previous page, if possible
   */
  slidePrev() {
    this.slideTo(this.pageIndex - 1);
  }

  /**
   * Slides carousel to given page
   * @param {Number} page - New index of active page
   * @param {Object} [params] - Additional options
   */
  slideTo(page, params = {}) {
    const { x = this.setPage(page, true) * -1, y = 0, friction = this.option("friction") } = params;

    if (this.Panzoom.content.x === x && !this.Panzoom.velocity.x && friction) {
      return;
    }

    this.Panzoom.panTo({
      x,
      y,
      friction,
      ignoreBounds: true,
    });

    if (this.state === "ready" && this.Panzoom.state === "ready") {
      this.trigger("settle");
    }
  }

  /**
   * Initialise main Panzoom instance
   */
  initPanzoom() {
    if (this.Panzoom) {
      this.Panzoom.destroy();
    }

    // Create fresh object containing options for Pazoom instance
    const options = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_2__.extend)(
      true,
      {},
      {
        // Track element will be set as Panzoom $content
        content: this.$track,
        wrapInner: false,
        resizeParent: false,

        // Disable any user interaction
        zoom: false,
        click: false,

        // Right now, only horizontal navigation is supported
        lockAxis: "x",

        x: this.pages[this.page].left * -1,
        centerOnStart: false,

        // Make `textSelection` option more easy to customize
        textSelection: () => this.option("textSelection", false),

        // Disable dragging if content (e.g. all slides) fits inside viewport
        panOnlyZoomed: function () {
          return this.content.width < this.viewport.width;
        },
      },
      this.option("Panzoom")
    );

    // Create new Panzoom instance
    this.Panzoom = new _Panzoom_Panzoom_js__WEBPACK_IMPORTED_MODULE_1__.Panzoom(this.$container, options);

    this.Panzoom.on({
      // Bubble events
      "*": (name, ...details) => this.trigger(`Panzoom.${name}`, ...details),
      // The rest of events to be processed
      afterUpdate: () => {
        this.updatePage();
      },
      beforeTransform: this.onBeforeTransform.bind(this),
      touchEnd: this.onTouchEnd.bind(this),
      endAnimation: () => {
        this.trigger("settle");
      },
    });

    // The contents of the slides may cause the page scroll bar to appear, so the carousel width may change
    // and slides have to be repositioned
    this.updateMetrics();
    this.manageSlideVisiblity();
  }

  updatePanzoom() {
    if (!this.Panzoom) {
      return;
    }

    this.Panzoom.content = {
      ...this.Panzoom.content,
      fitWidth: this.contentWidth,
      origWidth: this.contentWidth,
      width: this.contentWidth,
    };

    if (this.pages.length > 1 && this.option("infiniteX", this.option("infinite"))) {
      this.Panzoom.boundX = null;
    } else {
      this.Panzoom.boundX = {
        from: this.pages[this.pages.length - 1].left * -1,
        to: this.pages[0].left * -1,
      };
    }

    if (this.option("infiniteY", this.option("infinite"))) {
      this.Panzoom.boundY = null;
    } else {
      this.Panzoom.boundY = {
        from: 0,
        to: 0,
      };
    }
  }

  manageSlideVisiblity() {
    const contentWidth = this.contentWidth;
    const viewportWidth = this.viewportWidth;

    let currentX = this.Panzoom ? this.Panzoom.content.x * -1 : this.pages[this.page].left;

    const preload = this.option("preload");
    const infinite = this.option("infiniteX", this.option("infinite"));

    const paddingLeft = parseFloat(window.getComputedStyle(this.$viewport, null).getPropertyValue("padding-left"));
    const paddingRight = parseFloat(window.getComputedStyle(this.$viewport, null).getPropertyValue("padding-right"));

    // Check visibility of each slide
    this.slides.forEach((slide) => {
      let leftBoundary, rightBoundary;

      let hasDiff = 0;

      // #1 - slides in current viewport; this does not include infinite items
      leftBoundary = currentX - paddingLeft;
      rightBoundary = currentX + viewportWidth + paddingRight;

      leftBoundary -= preload * (viewportWidth + paddingLeft + paddingRight);
      rightBoundary += preload * (viewportWidth + paddingLeft + paddingRight);

      const insideCurrentInterval = slide.left + slide.width > leftBoundary && slide.left < rightBoundary;

      // #2 - infinite items inside current viewport; from previous interval
      leftBoundary = currentX + contentWidth - paddingLeft;
      rightBoundary = currentX + contentWidth + viewportWidth + paddingRight;

      // Include slides that have to be preloaded
      leftBoundary -= preload * (viewportWidth + paddingLeft + paddingRight);

      const insidePrevInterval = infinite && slide.left + slide.width > leftBoundary && slide.left < rightBoundary;

      // #2 - infinite items inside current viewport; from next interval
      leftBoundary = currentX - contentWidth - paddingLeft;
      rightBoundary = currentX - contentWidth + viewportWidth + paddingRight;

      // Include slides that have to be preloaded
      leftBoundary -= preload * (viewportWidth + paddingLeft + paddingRight);

      const insideNextInterval = infinite && slide.left + slide.width > leftBoundary && slide.left < rightBoundary;

      // Create virtual slides that should be visible or preloaded, remove others
      if (insidePrevInterval || insideCurrentInterval || insideNextInterval) {
        this.createSlideEl(slide);

        if (insideCurrentInterval) {
          hasDiff = 0;
        }

        if (insidePrevInterval) {
          hasDiff = -1;
        }

        if (insideNextInterval) {
          hasDiff = 1;
        }

        // Bring preloaded slides back to viewport, if needed
        if (slide.left + slide.width > currentX && slide.left <= currentX + viewportWidth + paddingRight) {
          hasDiff = 0;
        }
      } else {
        this.removeSlideEl(slide);
      }

      slide.hasDiff = hasDiff;
    });

    // Reposition slides for continuity
    let nextIndex = 0;
    let nextPos = 0;

    this.slides.forEach((slide, index) => {
      let updatedX = 0;

      if (slide.$el) {
        if (index !== nextIndex || slide.hasDiff) {
          updatedX = nextPos + slide.hasDiff * contentWidth;
        } else {
          nextPos = 0;
        }

        slide.$el.style.left = Math.abs(updatedX) > 0.1 ? `${nextPos + slide.hasDiff * contentWidth}px` : "";

        nextIndex++;
      } else {
        nextPos += slide.width;
      }
    });

    this.markSelectedSlides();
  }

  /**
   * Creates main DOM element for virtual slides,
   * lazy loads images inside regular slides
   * @param {Object} slide
   */
  createSlideEl(slide) {
    if (!slide) {
      return;
    }

    if (slide.$el) {
      let curentIndex = parseInt(slide.$el.dataset.index, 10);

      if (curentIndex !== slide.index) {
        slide.$el.dataset.index = slide.index;

        // Lazy load images
        const $lazyNodes = slide.$el.querySelectorAll("[data-lazy-src]");

        $lazyNodes.forEach((node) => {
          let lazySrc = node.dataset.lazySrc;

          if (node instanceof HTMLImageElement) {
            node.src = lazySrc;
          } else {
            node.style.backgroundImage = `url('${lazySrc}')`;
          }
        });

        let lazySrc;

        if ((lazySrc = slide.$el.dataset.lazySrc)) {
          slide.$el.style.backgroundImage = `url('${lazySrc}')`;
        }

        slide.state = "ready";
      }

      return;
    }

    const div = document.createElement("div");

    div.dataset.index = slide.index;
    div.classList.add(this.option("classNames.slide"));

    if (slide.customClass) {
      div.classList.add(...slide.customClass.split(" "));
    }

    if (slide.html) {
      div.innerHTML = slide.html;
    }

    const allElelements = [];

    this.slides.forEach((slide, index) => {
      if (slide.$el) {
        allElelements.push(index);
      }
    });

    // Find a place in DOM to insert an element
    const goal = slide.index;
    let refSlide = null;

    if (allElelements.length) {
      let refIndex = allElelements.reduce((prev, curr) =>
        Math.abs(curr - goal) < Math.abs(prev - goal) ? curr : prev
      );
      refSlide = this.slides[refIndex];
    }

    this.$track.insertBefore(
      div,
      refSlide && refSlide.$el ? (refSlide.index < slide.index ? refSlide.$el.nextSibling : refSlide.$el) : null
    );

    slide.$el = div;

    this.trigger("createSlide", slide, goal);

    return slide;
  }

  /**
   * Removes main DOM element of given slide
   * @param {Object} slide
   */
  removeSlideEl(slide) {
    if (slide.$el && !slide.isDom) {
      this.trigger("removeSlide", slide);

      slide.$el.remove();
      slide.$el = null;
    }
  }

  /**
   * Toggles selected class name and aria-hidden attribute for slides based on visibility
   */
  markSelectedSlides() {
    const selectedClass = this.option("classNames.slideSelected");
    const attr = "aria-hidden";

    this.slides.forEach((slide, index) => {
      const $el = slide.$el;

      if (!$el) {
        return;
      }

      const page = this.pages[this.page];

      if (page && page.indexes && page.indexes.indexOf(index) > -1) {
        if (selectedClass && !$el.classList.contains(selectedClass)) {
          $el.classList.add(selectedClass);
          this.trigger("selectSlide", slide);
        }

        $el.removeAttribute(attr);
      } else {
        if (selectedClass && $el.classList.contains(selectedClass)) {
          $el.classList.remove(selectedClass);
          this.trigger("unselectSlide", slide);
        }

        $el.setAttribute(attr, true);
      }
    });
  }

  updatePage() {
    this.updateMetrics();

    this.slideTo(this.page, { friction: 0 });
  }

  /**
   * Process `Panzoom.beforeTransform` event to remove slides moved out of viewport and
   * to create necessary ones
   */
  onBeforeTransform() {
    if (this.option("infiniteX", this.option("infinite"))) {
      this.manageInfiniteTrack();
    }

    this.manageSlideVisiblity();
  }

  /**
   * Seamlessly flip position of infinite carousel, if needed; this way x position stays low
   */
  manageInfiniteTrack() {
    const contentWidth = this.contentWidth;
    const viewportWidth = this.viewportWidth;

    if (!this.option("infiniteX", this.option("infinite")) || this.pages.length < 2 || contentWidth < viewportWidth) {
      return;
    }

    const panzoom = this.Panzoom;

    let isFlipped = false;

    if (panzoom.content.x < (contentWidth - viewportWidth) * -1) {
      panzoom.content.x += contentWidth;

      this.pageIndex = this.pageIndex - this.pages.length;

      isFlipped = true;
    }

    if (panzoom.content.x > viewportWidth) {
      panzoom.content.x -= contentWidth;

      this.pageIndex = this.pageIndex + this.pages.length;

      isFlipped = true;
    }

    if (isFlipped && panzoom.state === "pointerdown") {
      panzoom.resetDragPosition();
    }

    return isFlipped;
  }

  /**
   * Process `Panzoom.touchEnd` event; slide to next/prev page if needed
   * @param {object} panzoom
   */
  onTouchEnd(panzoom, event) {
    const dragFree = this.option("dragFree");

    // If this is a quick horizontal flick, slide to next/prev slide
    if (
      !dragFree &&
      this.pages.length > 1 &&
      panzoom.dragOffset.time < 350 &&
      Math.abs(panzoom.dragOffset.y) < 1 &&
      Math.abs(panzoom.dragOffset.x) > 5
    ) {
      this[panzoom.dragOffset.x < 0 ? "slideNext" : "slidePrev"]();
      return;
    }

    // Set the slide at the end of the animation as the current one,
    // or slide to closest page
    if (dragFree) {
      const [, nextPageIndex] = this.getPageFromPosition(panzoom.transform.x * -1);
      this.setPage(nextPageIndex);
    } else {
      this.slideToClosest();
    }
  }

  /**
   * Slides to the closest page (useful, if carousel is changed manually)
   * @param {Object} [params] - Object containing additional options
   */
  slideToClosest(params = {}) {
    let [, nextPageIndex] = this.getPageFromPosition(this.Panzoom.content.x * -1);

    this.slideTo(nextPageIndex, params);
  }

  /**
   * Returns index of closest page to given x position
   * @param {Number} xPos
   */
  getPageFromPosition(xPos) {
    const pageCount = this.pages.length;
    const center = this.option("center");

    if (center) {
      xPos += this.viewportWidth * 0.5;
    }

    const interval = Math.floor(xPos / this.contentWidth);

    xPos -= interval * this.contentWidth;

    let slide = this.slides.find((slide) => slide.left <= xPos && slide.left + slide.width > xPos);

    if (slide) {
      let pageIndex = this.findPageForSlide(slide.index);

      return [pageIndex, pageIndex + interval * pageCount];
    }

    return [0, 0];
  }

  /**
   * Changes active page
   * @param {Number} page - New index of active page
   * @param {Boolean} toClosest - to closest page based on scroll distance (for infinite navigation)
   */
  setPage(page, toClosest) {
    let nextPosition = 0;
    let pageIndex = parseInt(page, 10) || 0;

    const prevPage = this.page,
      prevPageIndex = this.pageIndex,
      pageCount = this.pages.length;

    const contentWidth = this.contentWidth;
    const viewportWidth = this.viewportWidth;

    page = ((pageIndex % pageCount) + pageCount) % pageCount;

    if (this.option("infiniteX", this.option("infinite")) && contentWidth > viewportWidth) {
      const nextInterval = Math.floor(pageIndex / pageCount) || 0,
        elemDimWidth = contentWidth;

      nextPosition = this.pages[page].left + nextInterval * elemDimWidth;

      if (toClosest === true && pageCount > 2) {
        let currPosition = this.Panzoom.content.x * -1;

        // * Find closest interval
        const decreasedPosition = nextPosition - elemDimWidth,
          increasedPosition = nextPosition + elemDimWidth,
          diff1 = Math.abs(currPosition - nextPosition),
          diff2 = Math.abs(currPosition - decreasedPosition),
          diff3 = Math.abs(currPosition - increasedPosition);

        if (diff3 < diff1 && diff3 <= diff2) {
          nextPosition = increasedPosition;
          pageIndex += pageCount;
        } else if (diff2 < diff1 && diff2 < diff3) {
          nextPosition = decreasedPosition;
          pageIndex -= pageCount;
        }
      }
    } else {
      page = pageIndex = Math.max(0, Math.min(pageIndex, pageCount - 1));

      nextPosition = this.pages[page].left;
    }

    this.page = page;
    this.pageIndex = pageIndex;

    if (prevPage !== null && page !== prevPage) {
      this.prevPage = prevPage;
      this.prevPageIndex = prevPageIndex;

      this.trigger("change", page, prevPage);
    }

    return nextPosition;
  }

  /**
   * Clean up
   */
  destroy() {
    this.state = "destroy";

    this.slides.forEach((slide) => {
      this.removeSlideEl(slide);
    });

    this.slides = [];

    this.Panzoom.destroy();

    this.detachPlugins();
  }
}

// Expose version
Carousel.version = "__VERSION__";

// Static properties are a recent addition that dont work in all browsers yet
Carousel.Plugins = _plugins_index_js__WEBPACK_IMPORTED_MODULE_5__.Plugins;


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Carousel/plugins/Dots/Dots.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Carousel/plugins/Dots/Dots.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Dots": () => (/* binding */ Dots)
/* harmony export */ });
class Dots {
  constructor(carousel) {
    this.carousel = carousel;

    this.$list = null;

    this.events = {
      change: this.onChange.bind(this),
      refresh: this.onRefresh.bind(this),
    };
  }

  /**
   * Build wrapping DOM element containing all dots
   */
  buildList() {
    if (this.carousel.pages.length < 2) {
      return;
    }

    const $list = document.createElement("ol");

    $list.classList.add("carousel__dots");

    $list.addEventListener("click", (e) => {
      if (!("page" in e.target.dataset)) {
        return;
      }

      e.preventDefault();
      e.stopPropagation();

      const page = parseInt(e.target.dataset.page, 10);
      const carousel = this.carousel;

      if (page === carousel.page) {
        return;
      }

      if (carousel.pages.length < 3 && carousel.option("infinite")) {
        carousel[page == 0 ? "slidePrev" : "slideNext"]();
      } else {
        carousel.slideTo(page);
      }
    });

    this.$list = $list;

    this.carousel.$container.appendChild($list);
    this.carousel.$container.classList.add("has-dots");

    return $list;
  }

  /**
   * Remove wrapping DOM element
   */
  removeList() {
    if (this.$list) {
      this.$list.parentNode.removeChild(this.$list);
      this.$list = null;
    }

    this.carousel.$container.classList.remove("has-dots");
  }

  /**
   * Remove existing dots and create fresh ones
   */
  rebuildDots() {
    let $list = this.$list;

    const listExists = !!$list;
    const pagesCount = this.carousel.pages.length;

    if (pagesCount < 2) {
      if (listExists) {
        this.removeList();
      }

      return;
    }

    if (!listExists) {
      $list = this.buildList();
    }

    // Remove existing dots
    const dotCount = this.$list.children.length;

    if (dotCount > pagesCount) {
      for (let i = pagesCount; i < dotCount; i++) {
        this.$list.removeChild(this.$list.lastChild);
      }

      return;
    }

    // Create fresh DOM elements (dots) for each page
    for (let index = dotCount; index < pagesCount; index++) {
      const $dot = document.createElement("li");

      $dot.classList.add("carousel__dot");
      $dot.dataset.page = index;

      $dot.setAttribute("role", "button");
      $dot.setAttribute("tabindex", "0");
      $dot.setAttribute("title", this.carousel.localize("{{GOTO}}", [["%d", index + 1]]));

      $dot.addEventListener("keydown", (event) => {
        const code = event.code;

        let $el;

        if (code === "Enter" || code === "NumpadEnter") {
          $el = $dot;
        } else if (code === "ArrowRight") {
          $el = $dot.nextSibling;
        } else if (code === "ArrowLeft") {
          $el = $dot.previousSibling;
        }

        $el && $el.click();
      });

      this.$list.appendChild($dot);
    }

    this.setActiveDot();
  }

  /**
   * Mark active dot by toggling class name
   */
  setActiveDot() {
    if (!this.$list) {
      return;
    }

    this.$list.childNodes.forEach(($dot) => {
      $dot.classList.remove("is-selected");
    });

    const $activeDot = this.$list.childNodes[this.carousel.page];

    if ($activeDot) {
      $activeDot.classList.add("is-selected");
    }
  }

  /**
   * Process carousel `change` event
   */
  onChange() {
    this.setActiveDot();
  }

  /**
   * Process carousel `refresh` event
   */
  onRefresh() {
    this.rebuildDots();
  }

  attach() {
    this.carousel.on(this.events);
  }

  detach() {
    this.removeList();

    this.carousel.off(this.events);
    this.carousel = null;
  }
}


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Carousel/plugins/Navigation/Navigation.js":
/*!**********************************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Carousel/plugins/Navigation/Navigation.js ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Navigation": () => (/* binding */ Navigation)
/* harmony export */ });
const defaults = {
  prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M15 3l-9 9 9 9"/></svg>',
  nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M9 3l9 9-9 9"/></svg>',

  classNames: {
    main: "carousel__nav",
    button: "carousel__button",

    next: "is-next",
    prev: "is-prev",
  },
};

class Navigation {
  constructor(carousel) {
    this.$container = null;

    this.$prev = null;
    this.$next = null;

    this.carousel = carousel;

    this.onRefresh = this.onRefresh.bind(this);
  }

  /**
   * Shortcut to get option for this plugin
   * @param {String} name option name
   * @returns option value
   */
  option(name) {
    return this.carousel.option(`Navigation.${name}`);
  }

  /**
   * Creates and returns new button element with default class names and click event
   * @param {String} type
   */
  createButton(type) {
    const $btn = document.createElement("button");

    $btn.setAttribute("title", this.carousel.localize(`{{${type.toUpperCase()}}}`));

    const classNames = this.option("classNames.button") + " " + this.option(`classNames.${type}`);

    $btn.classList.add(...classNames.split(" "));
    $btn.setAttribute("tabindex", "0");
    $btn.innerHTML = this.carousel.localize(this.option(`${type}Tpl`));

    $btn.addEventListener("click", (event) => {
      event.preventDefault();
      event.stopPropagation();

      this.carousel[`slide${type === "next" ? "Next" : "Prev"}`]();
    });

    return $btn;
  }

  /**
   * Build necessary DOM elements
   */
  build() {
    if (!this.$container) {
      this.$container = document.createElement("div");
      this.$container.classList.add(this.option("classNames.main"));

      this.carousel.$container.appendChild(this.$container);
    }

    if (!this.$next) {
      this.$next = this.createButton("next");

      this.$container.appendChild(this.$next);
    }

    if (!this.$prev) {
      this.$prev = this.createButton("prev");

      this.$container.appendChild(this.$prev);
    }
  }

  /**
   *  Process carousel `refresh` and `change` events to enable/disable buttons if needed
   */
  onRefresh() {
    const pageCount = this.carousel.pages.length;

    if (
      pageCount <= 1 ||
      (pageCount > 1 &&
        this.carousel.elemDimWidth < this.carousel.wrapDimWidth &&
        !Number.isInteger(this.carousel.option("slidesPerPage")))
    ) {
      this.cleanup();

      return;
    }

    this.build();

    this.$prev.removeAttribute("disabled");
    this.$next.removeAttribute("disabled");

    if (this.carousel.option("infiniteX", this.carousel.option("infinite"))) {
      return;
    }

    if (this.carousel.page <= 0) {
      this.$prev.setAttribute("disabled", "");
    }

    if (this.carousel.page >= pageCount - 1) {
      this.$next.setAttribute("disabled", "");
    }
  }

  cleanup() {
    if (this.$prev) {
      this.$prev.remove();
    }

    this.$prev = null;

    if (this.$next) {
      this.$next.remove();
    }

    this.$next = null;

    if (this.$container) {
      this.$container.remove();
    }

    this.$container = null;
  }

  attach() {
    this.carousel.on("refresh change", this.onRefresh);
  }

  detach() {
    this.carousel.off("refresh change", this.onRefresh);

    this.cleanup();
  }
}

// Expose defaults
Navigation.defaults = defaults;


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Carousel/plugins/Sync/Sync.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Carousel/plugins/Sync/Sync.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Sync": () => (/* binding */ Sync)
/* harmony export */ });
const defaults = {
  friction: 0.92,
};

class Sync {
  constructor(carousel) {
    this.carousel = carousel;

    this.selectedIndex = null;
    this.friction = 0;

    this.onNavReady = this.onNavReady.bind(this);
    this.onNavClick = this.onNavClick.bind(this);
    this.onNavCreateSlide = this.onNavCreateSlide.bind(this);

    this.onTargetChange = this.onTargetChange.bind(this);
  }

  /**
   * Make this one as main carousel and selected carousel as navigation
   * @param {Object} nav Carousel
   */
  addAsTargetFor(nav) {
    this.target = this.carousel;
    this.nav = nav;

    this.attachEvents();
  }

  /**
   * Make this one as navigation carousel for selected carousel
   * @param {Object} target
   */
  addAsNavFor(target) {
    this.target = target;
    this.nav = this.carousel;

    this.attachEvents();
  }

  /**
   * Attach event listeners on both carousels
   */
  attachEvents() {
    this.nav.options.initialSlide = this.target.options.initialPage;

    this.nav.on("ready", this.onNavReady);
    this.nav.on("createSlide", this.onNavCreateSlide);
    this.nav.on("Panzoom.click", this.onNavClick);

    this.target.on("change", this.onTargetChange);
    this.target.on("Panzoom.afterUpdate", this.onTargetChange);
  }

  /**
   * Process main carousel `ready` event; bind events and set initial page
   */
  onNavReady() {
    this.onTargetChange(true);
  }

  /**
   * Process main carousel `click` event
   * @param {Object} panzoom
   * @param {Object} event
   */
  onNavClick(carousel, panzoom, event) {
    const clickedNavSlide = event.target.closest(".carousel__slide");

    if (!clickedNavSlide) {
      return;
    }

    event.stopPropagation();

    const selectedNavIndex = parseInt(clickedNavSlide.dataset.index, 10);
    const selectedSyncPage = this.target.findPageForSlide(selectedNavIndex);

    if (this.target.page !== selectedSyncPage) {
      this.target.slideTo(selectedSyncPage, { friction: this.friction });
    }

    this.markSelectedSlide(selectedNavIndex);
  }

  /**
   * Process main carousel `createSlide` event
   * @param {Object} carousel
   * @param {Object} slide
   */
  onNavCreateSlide(carousel, slide) {
    if (slide.index === this.selectedIndex) {
      this.markSelectedSlide(slide.index);
    }
  }

  /**
   * Process target carousel `change` event
   * @param {Object} target
   */
  onTargetChange() {
    const targetIndex = this.target.pages[this.target.page].indexes[0];
    const selectedNavPage = this.nav.findPageForSlide(targetIndex);

    this.nav.slideTo(selectedNavPage);

    this.markSelectedSlide(targetIndex);
  }

  /**
   * Toggle classname for slides that marks currently selected slides
   * @param {Number} selectedIndex
   */
  markSelectedSlide(selectedIndex) {
    this.selectedIndex = selectedIndex;

    [...this.nav.slides].filter((slide) => slide.$el && slide.$el.classList.remove("is-nav-selected"));

    const slide = this.nav.slides[selectedIndex];

    if (slide && slide.$el) slide.$el.classList.add("is-nav-selected");
  }

  attach(carousel) {
    const sync = carousel.options.Sync;

    if (!sync.target && !sync.nav) {
      return;
    }

    if (sync.target) {
      this.addAsNavFor(sync.target);
    } else if (sync.nav) {
      this.addAsTargetFor(sync.nav);
    }

    this.friction = sync.friction;
  }

  detach() {
    if (this.nav) {
      this.nav.off("ready", this.onNavReady);
      this.nav.off("Panzoom.click", this.onNavClick);
      this.nav.off("createSlide", this.onNavCreateSlide);
    }

    if (this.target) {
      this.target.off("Panzoom.afterUpdate", this.onTargetChange);
      this.target.off("change", this.onTargetChange);
    }
  }
}

// Expose defaults
Sync.defaults = defaults;


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Carousel/plugins/index.js":
/*!******************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Carousel/plugins/index.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Plugins": () => (/* binding */ Plugins)
/* harmony export */ });
/* harmony import */ var _Navigation_Navigation_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Navigation/Navigation.js */ "./node_modules/@fancyapps/ui/src/Carousel/plugins/Navigation/Navigation.js");
/* harmony import */ var _Dots_Dots_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Dots/Dots.js */ "./node_modules/@fancyapps/ui/src/Carousel/plugins/Dots/Dots.js");
/* harmony import */ var _Sync_Sync_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Sync/Sync.js */ "./node_modules/@fancyapps/ui/src/Carousel/plugins/Sync/Sync.js");




const Plugins = { Navigation: _Navigation_Navigation_js__WEBPACK_IMPORTED_MODULE_0__.Navigation, Dots: _Dots_Dots_js__WEBPACK_IMPORTED_MODULE_1__.Dots, Sync: _Sync_Sync_js__WEBPACK_IMPORTED_MODULE_2__.Sync };


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Fancybox/Fancybox.js":
/*!*************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Fancybox/Fancybox.js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Fancybox": () => (/* binding */ Fancybox)
/* harmony export */ });
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../shared/utils/extend.js */ "./node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _shared_utils_canUseDOM_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../shared/utils/canUseDOM.js */ "./node_modules/@fancyapps/ui/src/shared/utils/canUseDOM.js");
/* harmony import */ var _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../shared/Base/Base.js */ "./node_modules/@fancyapps/ui/src/shared/Base/Base.js");
/* harmony import */ var _Carousel_Carousel_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../Carousel/Carousel.js */ "./node_modules/@fancyapps/ui/src/Carousel/Carousel.js");
/* harmony import */ var _plugins_index_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./plugins/index.js */ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/index.js");
/* harmony import */ var _l10n_en_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./l10n/en.js */ "./node_modules/@fancyapps/ui/src/Fancybox/l10n/en.js");
// var global = global || window;











const defaults = {
  // Index of active slide on the start
  startIndex: 0,

  // Number of slides to preload before and after active slide
  preload: 1,

  // Should navigation be infinite
  infinite: true,

  // Class name to be applied to the content to reveal it
  showClass: "fancybox-zoomInUp", // "fancybox-fadeIn" | "fancybox-zoomInUp" | false

  // Class name to be applied to the content to hide it
  hideClass: "fancybox-fadeOut", // "fancybox-fadeOut" | "fancybox-zoomOutDown" | false

  // Should backdrop and UI elements fade in/out on start/close
  animated: true,

  // If browser scrollbar should be hidden
  hideScrollbar: true,

  // Element containing main structure
  parentEl: null,

  // Custom class name or multiple space-separated class names for the container
  mainClass: null,

  // Set focus on first focusable element after displaying content
  autoFocus: true,

  // Trap focus inside Fancybox
  trapFocus: true,

  // Set focus back to trigger element after closing Fancybox
  placeFocusBack: true,

  // Action to take when the user clicks on the backdrop
  click: "close", // "close" | "next" | null

  // Position of the close button - over the content or at top right corner of viewport
  closeButton: "inside", // "inside" | "outside"

  // Allow user to drag content up/down to close instance
  dragToClose: true,

  // Enable keyboard navigation
  keyboard: {
    Escape: "close",
    Delete: "close",
    Backspace: "close",
    PageUp: "next",
    PageDown: "prev",
    ArrowUp: "next",
    ArrowDown: "prev",
    ArrowRight: "next",
    ArrowLeft: "prev",
  },

  // HTML templates for various elements
  template: {
    // Close button icon
    closeButton:
      '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M20 20L4 4m16 0L4 20"/></svg>',
    // Loading indicator icon
    spinner:
      '<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="25 25 50 50" tabindex="-1"><circle cx="50" cy="50" r="20"/></svg>',

    // Main container element
    main: null,
  },

  /* Note: If the `template.main` option is not provided, the structure is generated as follows by default:
  <div class="fancybox__container" role="dialog" aria-modal="true" aria-hidden="true" aria-label="{{MODAL}}" tabindex="-1">
    <div class="fancybox__backdrop"></div>
    <div class="fancybox__carousel"></div>
  </div>
  */

  // Localization of strings
  l10n: _l10n_en_js__WEBPACK_IMPORTED_MODULE_5__.default,
};

let called = 0;

class Fancybox extends _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_2__.Base {
  /**
   * Fancybox constructor
   * @constructs Fancybox
   * @param {Object} [options] - Options for Fancybox
   */
  constructor(items, options = {}) {
    super((0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(true, {}, defaults, options));

    this.bindHandlers();

    this.state = "init";

    this.setItems(items);

    this.attachPlugins(Fancybox.Plugins);

    // "init" event marks the start of initialization and is available to plugins
    this.trigger("init");

    if (this.option("hideScrollbar") === true) {
      this.hideScrollbar();
    }

    this.initLayout();

    this.initCarousel();

    this.attachEvents();

    // "prepare" event will trigger the creation of additional layout elements, such as thumbnails and toolbar
    this.trigger("prepare");

    this.state = "ready";

    // "ready" event will trigger the content to load
    this.trigger("ready");

    // Reveal container
    this.$container.setAttribute("aria-hidden", "false");

    // Focus on the first focus element in this instance
    this.focus();
  }

  /**
   * Bind event handlers for referencability
   */
  bindHandlers() {
    for (const methodName of [
      "onMousedown",
      "onKeydown",
      "onClick",

      "onCreateSlide",

      "onTouchMove",
      "onTouchEnd",

      "onTransform",
    ]) {
      this[methodName] = this[methodName].bind(this);
    }
  }

  /**
   * Set up a functions that will be called whenever the specified event is delivered
   */
  attachEvents() {
    document.addEventListener("mousedown", this.onMousedown);
    document.addEventListener("keydown", this.onKeydown);

    this.$container.addEventListener("click", this.onClick);
  }

  /**
   * Removes previously registered event listeners
   */
  detachEvents() {
    document.removeEventListener("mousedown", this.onMousedown);
    document.removeEventListener("keydown", this.onKeydown);

    this.$container.removeEventListener("click", this.onClick);
  }

  /**
   * Initialize layout; create main container, backdrop nd layout for main carousel
   */
  initLayout() {
    this.$root = this.option("parentEl") || document.body;

    // Container
    let mainTemplate = this.option("template.main");

    if (mainTemplate) {
      this.$root.insertAdjacentHTML("beforeend", this.localize(mainTemplate));

      this.$container = this.$root.querySelector(".fancybox__container");
    }

    if (!this.$container) {
      this.$container = document.createElement("div");
      this.$root.appendChild(this.$container);
    }

    // Normally we would not need this, but Safari does not support `preventScroll:false` option for `focus` method
    // and that causes layout issues
    this.$container.onscroll = () => {
      this.$container.scrollLeft = 0;
      return false;
    };

    Object.entries({
      class: "fancybox__container",
      role: "dialog",
      "aria-modal": "true",
      "aria-hidden": "true",
      "aria-label": this.localize("{{MODAL}}"),
    }).forEach((args) => this.$container.setAttribute(...args));

    if (this.option("animated")) {
      this.$container.classList.add("is-animated");
    }

    // Backdrop
    this.$backdrop = this.$container.querySelector(".fancybox__backdrop");

    if (!this.$backdrop) {
      this.$backdrop = document.createElement("div");
      this.$backdrop.classList.add("fancybox__backdrop");

      this.$container.appendChild(this.$backdrop);
    }

    // Carousel
    this.$carousel = this.$container.querySelector(".fancybox__carousel");

    if (!this.$carousel) {
      this.$carousel = document.createElement("div");
      this.$carousel.classList.add("fancybox__carousel");

      this.$container.appendChild(this.$carousel);
    }

    // Make instance reference accessible
    this.$container.Fancybox = this;

    // Make sure the container has an ID
    this.id = this.$container.getAttribute("id");

    if (!this.id) {
      this.id = this.options.id || ++called;
      this.$container.setAttribute("id", "fancybox-" + this.id);
    }

    // Add custom class name to main element
    const mainClass = this.options.mainClass;

    if (mainClass) {
      this.$container.classList.add(...mainClass.split(" "));
    }

    // Add class name for <html> element
    document.documentElement.classList.add("with-fancybox");

    this.trigger("initLayout");

    return this;
  }

  /**
   * Prepares slides for the corousel
   * @returns {Array} Slides
   */
  setItems(items) {
    const slides = [];

    for (const slide of items) {
      const $trigger = slide.$trigger;

      if ($trigger) {
        const dataset = $trigger.dataset || {};

        slide.src = dataset.src || $trigger.getAttribute("href") || slide.src;
        slide.type = dataset.type || slide.type;

        // Support items without `src`, e.g., when `data-fancybox` attribute added directly to `<img>` element
        if (!slide.src && $trigger instanceof HTMLImageElement) {
          slide.src = $trigger.currentSrc || slide.$trigger.src;
        }
      }

      // Check for thumbnail element
      let $thumb = slide.$thumb;

      if (!$thumb) {
        let origTarget = slide.$trigger && slide.$trigger.origTarget;

        if (origTarget) {
          if (origTarget instanceof HTMLImageElement) {
            $thumb = origTarget;
          } else {
            $thumb = origTarget.querySelector("img");
          }
        }

        if (!$thumb && slide.$trigger) {
          $thumb = slide.$trigger instanceof HTMLImageElement ? slide.$trigger : slide.$trigger.querySelector("img");
        }
      }

      slide.$thumb = $thumb || null;

      // Get thumbnail image source
      let thumb = slide.thumb;

      if (!thumb && slide.$thumb) {
        thumb = $thumb.currentSrc || $thumb.src;
      }

      // Assume we have image, then use it as thumbnail
      if (!thumb && slide.type === "image") {
        thumb = slide.src;
      }

      slide.thumb = thumb || null;

      // Add empty caption to make things simpler
      slide.caption = slide.caption || "";

      slides.push(slide);
    }

    this.items = slides;
  }

  /**
   * Initialize main Carousel that will be used to display the content
   * @param {Array} slides
   */
  initCarousel() {
    this.Carousel = new _Carousel_Carousel_js__WEBPACK_IMPORTED_MODULE_3__.Carousel(
      this.$carousel,
      (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(
        true,
        {},
        {
          classNames: {
            viewport: "fancybox__viewport",
            track: "fancybox__track",
            slide: "fancybox__slide",
          },

          textSelection: true,
          preload: this.option("preload"),

          friction: 0.88,

          slides: this.items,
          initialPage: this.options.startIndex,
          slidesPerPage: 1,

          infiniteX: this.option("infinite"),
          infiniteY: true,

          l10n: this.option("l10n"),

          Dots: false,
          Navigation: {
            classNames: {
              main: "fancybox__nav",
              button: "carousel__button",

              next: "is-next",
              prev: "is-prev",
            },
          },

          Panzoom: {
            textSelection: true,

            panOnlyZoomed: () => {
              return (
                this.Carousel && this.Carousel.pages && this.Carousel.pages.length < 2 && !this.options.dragToClose
              );
            },
            lockAxis: () => {
              if (this.Carousel) {
                let rez = "x";

                if (this.options.dragToClose) {
                  rez += "y";
                }

                return rez;
              }
            },
          },

          on: {
            "*": (name, ...details) => this.trigger(`Carousel.${name}`, ...details),
            init: (carousel) => (this.Carousel = carousel),
            createSlide: this.onCreateSlide,
          },
        },

        this.option("Carousel")
      )
    );

    if (this.option("dragToClose")) {
      this.Carousel.Panzoom.on({
        // Stop further touch event handling if content is scaled
        touchMove: this.onTouchMove,

        // Update backdrop opacity depending on vertical distance
        afterTransform: this.onTransform,

        // Close instance if drag distance exceeds limit
        touchEnd: this.onTouchEnd,
      });
    }

    this.trigger("initCarousel");

    return this;
  }

  /**
   * Process `createSlide` event to create caption element inside new slide
   */
  onCreateSlide(carousel, slide) {
    let caption = slide.caption || "";

    if (typeof this.options.caption === "function") {
      caption = this.options.caption.call(this, this, this.Carousel, slide);
    }

    if (typeof caption === "string" && caption.length) {
      const $caption = document.createElement("div");
      const id = `fancybox__caption_${this.id}_${slide.index}`;

      $caption.className = "fancybox__caption";
      $caption.innerHTML = caption;
      $caption.setAttribute("id", id);

      slide.$caption = slide.$el.appendChild($caption);

      slide.$el.classList.add("has-caption");
      slide.$el.setAttribute("aria-labelledby", id);
    }
  }

  /**
   * Handle click event on the container
   * @param {Event} event - Click event
   */
  onClick(event) {
    if (event.defaultPrevented) {
      return;
    }

    // Skip if clicked inside content area
    if (event.target.closest(".fancybox__content")) {
      return;
    }

    // Skip if text is selected
    if (window.getSelection().toString().length) {
      return;
    }

    if (this.trigger("click", event) === false) {
      return;
    }

    const action = this.option("click");

    switch (action) {
      case "close":
        this.close();
        break;
      case "next":
        this.next();
        break;
    }
  }

  /**
   * Handle panzoom `touchMove` event; Disable dragging if content of current slide is scaled
   */
  onTouchMove() {
    const panzoom = this.getSlide().Panzoom;

    return panzoom && panzoom.content.scale !== 1 ? false : true;
  }

  /**
   * Handle panzoom `touchEnd` event; close when quick flick up/down is detected
   * @param {Object} panzoom - Panzoom instance
   */
  onTouchEnd(panzoom) {
    const distanceY = panzoom.dragOffset.y;

    if (Math.abs(distanceY) >= 150 || (Math.abs(distanceY) >= 35 && panzoom.dragOffset.time < 350)) {
      if (this.option("hideClass")) {
        this.getSlide().hideClass = `fancybox-throwOut${panzoom.content.y < 0 ? "Up" : "Down"}`;
      }

      this.close();
    } else if (panzoom.lockAxis === "y") {
      panzoom.panTo({ y: 0 });
    }
  }

  /**
   * Handle `afterTransform` event; change backdrop opacity based on current y position of panzoom
   * @param {Object} panzoom - Panzoom instance
   */
  onTransform(panzoom) {
    const $backdrop = this.$backdrop;

    if ($backdrop) {
      const yPos = Math.abs(panzoom.content.y);
      const opacity = yPos < 1 ? "" : Math.max(0.33, Math.min(1, 1 - (yPos / panzoom.content.fitHeight) * 1.5));

      this.$container.style.setProperty("--fancybox-ts", opacity ? "0s" : "");
      this.$container.style.setProperty("--fancybox-opacity", opacity);
    }
  }

  /**
   * Handle `mousedown` event to mark that the mouse is in use
   */
  onMousedown() {
    document.body.classList.add("is-using-mouse");
  }

  /**
   * Handle `keydown` event; trap focus
   * @param {Event} event Keydown event
   */
  onKeydown(event) {
    if (Fancybox.getInstance().id !== this.id) {
      return;
    }

    document.body.classList.remove("is-using-mouse");

    const key = event.key;

    // Trap keyboard focus inside of the modal
    if (key === "Tab" && this.option("trapFocus")) {
      this.focus(event);

      return;
    }

    const keyboard = this.option("keyboard");

    if (!keyboard || event.ctrlKey || event.altKey || event.shiftKey) {
      return;
    }

    const classList = document.activeElement && document.activeElement.classList;
    const isUIElement = classList && classList.contains("carousel__button");

    // Allow to close using Escape button
    if (key !== "Escape" && !isUIElement) {
      let ignoreElements =
        event.target.isContentEditable ||
        ["BUTTON", "TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].indexOf(event.target.nodeName) !== -1;

      if (ignoreElements) {
        return;
      }
    }

    if (this.trigger("keydown", key, event) === false) {
      return;
    }

    const action = keyboard[key];

    if (typeof this[action] === "function") {
      this[action]();
    }
  }

  /**
   * Get the active slide. This will be the first slide from the current page of the main carousel.
   */
  getSlide() {
    const carousel = this.Carousel;

    if (!carousel) return null;

    const page = carousel.page === null ? carousel.option("initialPage") : carousel.page;
    const pages = carousel.pages || [];

    if (pages.length && pages[page]) {
      return pages[page].slides[0];
    }

    return null;
  }

  /**
   * Place focus on the first focusable element inside current slide
   * @param {Event} [event] - Focus event
   */
  focus(event) {
    if (Fancybox.preventScrollSupported === undefined) {
      // Detect if .focus() method  supports `preventScroll` option,
      // see https://developer.mozilla.org/en-US/docs/Web/API/HTMLOrForeignElement/focus
      Fancybox.preventScrollSupported = (function () {
        let rez = false;

        document.createElement("div").focus({
          get preventScroll() {
            rez = true;
            return false;
          },
        });

        return rez;
      })();
    }

    const setFocusOn = (node) => {
      if (node.setActive) {
        // IE/Edge
        node.setActive();
      } else if (Fancybox.preventScrollSupported) {
        // Modern browsers
        node.focus({ preventScroll: true });
      } else {
        // Safari
        node.focus();
      }
    };

    if (["init", "closing", "customClosing", "destroy"].indexOf(this.state) > -1) {
      return;
    }

    if (event) {
      event.preventDefault();
    }

    const FOCUSABLE_ELEMENTS = [
      "a[href]",
      "area[href]",
      'input:not([disabled]):not([type="hidden"]):not([aria-hidden])',
      "select:not([disabled]):not([aria-hidden])",
      "textarea:not([disabled]):not([aria-hidden])",
      "button:not([disabled]):not([aria-hidden])",
      "iframe",
      "object",
      "embed",
      "video",
      "audio",
      "[contenteditable]",
      '[tabindex]:not([tabindex^="-"]):not([disabled]):not([aria-hidden])',
    ];

    const $currentSlide = this.getSlide().$el;

    if (!$currentSlide) {
      return;
    }

    // Setting `tabIndex` here helps to avoid Safari issues with random focusing and scrolling
    $currentSlide.tabIndex = 0;

    const allFocusableElems = [].slice.call(this.$container.querySelectorAll(FOCUSABLE_ELEMENTS));

    let enabledElems = [];

    for (let node of allFocusableElems) {
      // Slide element will be the last one, the highest priority has elements having `autofocus` attribute
      if (node.classList && node.classList.contains("fancybox__slide")) {
        continue;
      }

      const $closestSlide = node.closest(".fancybox__slide");

      if ($closestSlide) {
        if ($closestSlide === $currentSlide) {
          enabledElems[node.hasAttribute("autofocus") ? "unshift" : "push"](node);
        }
      } else {
        enabledElems.push(node);
      }
    }

    if (!enabledElems.length) {
      return;
    }

    if (this.Carousel.pages.length > 1) {
      enabledElems.push($currentSlide);
    }

    // Sort by tabindex
    enabledElems.sort(function (a, b) {
      if (a.tabIndex > b.tabIndex) return -1;
      if (a.tabIndex < b.tabIndex) return 1;

      return 0;
    });

    const focusedElementIndex = enabledElems.indexOf(document.activeElement);

    const moveForward = event && !event.shiftKey;
    const moveBackward = event && event.shiftKey;

    if (moveForward) {
      if (focusedElementIndex === enabledElems.length - 1) {
        return setFocusOn(enabledElems[0]);
      }

      return setFocusOn(enabledElems[focusedElementIndex + 1]);
    }

    if (moveBackward) {
      if (focusedElementIndex === 0) {
        return setFocusOn(enabledElems[enabledElems.length - 1]);
      }

      return setFocusOn(enabledElems[focusedElementIndex - 1]);
    }

    if (focusedElementIndex < 0) {
      return setFocusOn(enabledElems[0]);
    }
  }

  /**
   * Hide vertical page scrollbar and adjust right padding value of `body` element to prevent content from shifting
   * (otherwise the `body` element may become wider and the content may expand horizontally).
   */
  hideScrollbar() {
    if (!_shared_utils_canUseDOM_js__WEBPACK_IMPORTED_MODULE_1__.canUseDOM) {
      return;
    }

    const scrollbarWidth = window.innerWidth - document.documentElement.getBoundingClientRect().width;
    const id = "fancybox-style-noscroll";

    let $style = document.getElementById(id);

    if ($style) {
      return;
    }

    if (scrollbarWidth > 0) {
      $style = document.createElement("style");

      $style.id = id;
      $style.type = "text/css";
      $style.innerHTML = `.compensate-for-scrollbar {padding-right: ${scrollbarWidth}px;}`;

      document.getElementsByTagName("head")[0].appendChild($style);

      document.body.classList.add("compensate-for-scrollbar");
    }
  }

  /**
   * Stop hiding vertical page scrollbar
   */
  revealScrollbar() {
    document.body.classList.remove("compensate-for-scrollbar");

    const el = document.getElementById("fancybox-style-noscroll");

    if (el) {
      el.remove();
    }
  }

  /**
   * Remove content for given slide
   * @param {Object} slide - Carousel slide
   */
  clearContent(slide) {
    // * Clear previously added content and class name
    this.Carousel.trigger("removeSlide", slide);

    if (slide.$content) {
      slide.$content.remove();
      slide.$content = null;
    }

    if (slide._className) {
      slide.$el.classList.remove(slide._className);
    }
  }

  /**
   * Set new content for given slide
   * @param {Object} slide - Carousel slide
   * @param {HTMLElement|String} html - HTML element or string containing HTML code
   * @param {Object} [opts] - Options
   */
  setContent(slide, html, opts = {}) {
    let $content;

    const $el = slide.$el;

    if (html instanceof HTMLElement) {
      if (["img", "iframe", "video", "audio"].indexOf(html.nodeName.toLowerCase()) > -1) {
        $content = document.createElement("div");
        $content.appendChild(html);
      } else {
        $content = html;
      }
    } else {
      $content = document.createElement("div");
      $content.innerHTML = html;
    }

    if (!($content instanceof Element)) {
      throw new Error("Element expected");
    }

    // * Add class name indicating content type, for example `has-image`
    slide._className = `has-${opts.suffix || slide.type || "unknown"}`;

    $el.classList.add(slide._className);

    // * Set content
    $content.classList.add("fancybox__content");

    // Make sure that content is not hidden and will be visible
    if ($content.style.display === "none" || window.getComputedStyle($content).getPropertyValue("display") === "none") {
      $content.style.display = "flex";
    }

    if (slide.id) {
      $content.setAttribute("id", slide.id);
    }

    slide.$content = $content;

    $el.prepend($content);

    this.manageCloseButton(slide);

    if (slide.state !== "loading") {
      this.revealContent(slide);
    }

    return $content;
  }

  /**
   * Create close button if needed
   * @param {Object} slide
   */
  manageCloseButton(slide) {
    const position = slide.closeButton === undefined ? this.option("closeButton") : slide.closeButton;

    if (!position || (position === "top" && this.$closeButton)) {
      return;
    }

    const $btn = document.createElement("button");

    $btn.classList.add("carousel__button", "is-close");
    $btn.setAttribute("title", this.options.l10n.CLOSE);
    $btn.innerHTML = this.option("template.closeButton");

    $btn.addEventListener("click", (e) => this.close(e));

    if (position === "inside") {
      // Remove existing one to avoid scope issues
      if (slide.$closeButton) {
        slide.$closeButton.remove();
      }

      slide.$closeButton = slide.$content.appendChild($btn);
    } else {
      this.$closeButton = this.$container.insertBefore($btn, this.$container.firstChild);
    }
  }

  /**
   * Make content visible for given slide and optionally start CSS animation
   * @param {Object} slide - Carousel slide
   */
  revealContent(slide) {
    this.trigger("reveal", slide);

    slide.$content.style.visibility = "";

    // Add CSS class name that reveals content (default animation is "fadeIn")
    let showClass = false;

    if (
      !(
        slide.error ||
        slide.state === "loading" ||
        this.Carousel.prevPage !== null ||
        slide.index !== this.options.startIndex
      )
    ) {
      showClass = slide.showClass === undefined ? this.option("showClass") : slide.showClass;
    }

    if (!showClass) {
      this.done(slide);

      return;
    }

    slide.state = "animating";

    this.animateCSS(slide.$content, showClass, () => {
      this.done(slide);
    });
  }

  /**
   * Add class name to given HTML element and wait for `animationend` event to execute callback
   * @param {HTMLElement} $el
   * @param {String} className
   * @param {Function} callback - A callback to run
   */
  animateCSS($element, className, callback) {
    if ($element) {
      $element.dispatchEvent(new CustomEvent("animationend", { bubbles: true, cancelable: true }));
    }

    if (!$element || !className) {
      if (typeof callback === "function") {
        callback();
      }

      return;
    }

    const handleAnimationEnd = function (event) {
      if (event.currentTarget === this) {
        $element.removeEventListener("animationend", handleAnimationEnd);

        if (callback) {
          callback();
        }

        $element.classList.remove(className);
      }
    };

    $element.addEventListener("animationend", handleAnimationEnd);
    $element.classList.add(className);
  }

  /**
   * Mark given slide as `done`, e.g., content is loaded and displayed completely
   * @param {Object} slide - Carousel slide
   */
  done(slide) {
    slide.state = "done";

    this.trigger("done", slide);

    // Trigger focus for current slide (and ignore preloaded slides)
    const currentSlide = this.getSlide();

    if (currentSlide && slide.index === currentSlide.index && this.option("autoFocus")) {
      this.focus();
    }
  }

  /**
   * Set error message as slide content
   * @param {Object} slide - Carousel slide
   * @param {String} message - Error message, can contain HTML code and template variables
   */
  setError(slide, message) {
    slide.error = message;

    this.hideLoading(slide);
    this.clearContent(slide);

    // Create new content
    const div = document.createElement("div");
    div.classList.add("fancybox-error");
    div.innerHTML = this.localize(message || "<p>{{ERROR}}</p>");

    this.setContent(slide, div, { suffix: "error" });
  }

  /**
   * Create loading indicator inside given slide
   * @param {Object} slide - Carousel slide
   */
  showLoading(slide) {
    slide.state = "loading";

    slide.$el.classList.add("is-loading");

    let $spinner = slide.$el.querySelector(".fancybox__spinner");

    if ($spinner) {
      return;
    }

    $spinner = document.createElement("div");

    $spinner.classList.add("fancybox__spinner");
    $spinner.innerHTML = this.option("template.spinner");

    $spinner.addEventListener("click", () => {
      if (!this.Carousel.Panzoom.velocity) this.close();
    });

    slide.$el.prepend($spinner);
  }

  /**
   * Remove loading indicator from given slide
   * @param {Object} slide - Carousel slide
   */
  hideLoading(slide) {
    const $spinner = slide.$el && slide.$el.querySelector(".fancybox__spinner");

    if ($spinner) {
      $spinner.remove();

      slide.$el.classList.remove("is-loading");
    }

    if (slide.state === "loading") {
      this.trigger("load", slide);

      slide.state = "ready";
    }
  }

  /**
   * Slide carousel to next page
   */
  next() {
    const carousel = this.Carousel;

    if (carousel && carousel.pages.length > 1) {
      carousel.slideNext();
    }
  }

  /**
   * Slide carousel to previous page
   */
  prev() {
    const carousel = this.Carousel;

    if (carousel && carousel.pages.length > 1) {
      carousel.slidePrev();
    }
  }

  /**
   * Slide carousel to selected page with optional parameters
   * Examples:
   *    Fancybox.getInstance().jumpTo(2);
   *    Fancybox.getInstance().jumpTo(3, {friction: 0})
   * @param  {...any} args - Arguments for Carousel `slideTo` method
   */
  jumpTo(...args) {
    if (this.Carousel) this.Carousel.slideTo(...args);
  }

  /**
   * Start closing the current instance
   * @param {Event} [event] - Optional click event
   */
  close(event) {
    if (event) event.preventDefault();

    // First, stop further execution if this instance is already closing
    // (this can happen if, for example, user clicks close button multiple times really fast)
    if (["closing", "customClosing", "destroy"].indexOf(this.state) > -1) {
      return;
    }

    // Allow callbacks and/or plugins to prevent closing
    if (this.trigger("shouldClose", event) === false) {
      return;
    }

    this.state = "closing";

    this.Carousel.Panzoom.destroy();

    this.detachEvents();

    this.trigger("closing", event);

    if (this.state === "destroy") {
      return;
    }

    // Trigger default CSS closing animation for backdrop and interface elements
    this.$container.setAttribute("aria-hidden", "true");

    this.$container.classList.add("is-closing");

    // Clear inactive slides
    const currentSlide = this.getSlide();

    this.Carousel.slides.forEach((slide) => {
      if (slide.$content && slide.index !== currentSlide.index) {
        this.Carousel.trigger("removeSlide", slide);
      }
    });

    // Start default closing animation
    if (this.state === "closing") {
      const hideClass = currentSlide.hideClass === undefined ? this.option("hideClass") : currentSlide.hideClass;

      this.animateCSS(
        currentSlide.$content,
        hideClass,
        () => {
          this.destroy();
        },
        true
      );
    }
  }

  /**
   * Clean up after closing fancybox
   */
  destroy() {
    this.state = "destroy";

    this.trigger("destroy");

    const $trigger = this.option("placeFocusBack") ? this.getSlide().$trigger : null;

    // Destroy Carousel and then detach plugins;
    // * Note: this order allows plugins to receive `removeSlide` event
    this.Carousel.destroy();

    this.detachPlugins();

    this.Carousel = null;

    this.options = {};
    this.events = {};

    this.$container.remove();

    this.$container = this.$backdrop = this.$carousel = null;

    if ($trigger) {
      // `preventScroll` option is not yet supported by Safari
      // https://bugs.webkit.org/show_bug.cgi?id=178583

      if (Fancybox.preventScrollSupported) {
        $trigger.focus({ preventScroll: true });
      } else {
        const scrollTop = document.body.scrollTop; // Save position
        $trigger.focus();
        document.body.scrollTop = scrollTop;
      }
    }

    const nextInstance = Fancybox.getInstance();

    if (nextInstance) {
      nextInstance.focus();
      return;
    }

    document.documentElement.classList.remove("with-fancybox");
    document.body.classList.remove("is-using-mouse");

    this.revealScrollbar();
  }

  /**
   * Create new Fancybox instance with provided options
   * Example:
   *   Fancybox.show([{ src : 'https://lipsum.app/id/1/300x225' }]);
   * @param {Array} items - Gallery items
   * @param {Object} [options] - Optional custom options
   * @returns {Object} Fancybox instance
   */
  static show(items, options = {}) {
    return new Fancybox(items, options);
  }

  /**
   * Starts Fancybox if event target matches any opener or target is `trigger element`
   * @param {Event} event - Click event
   * @param {Object} [options] - Optional custom options
   */
  static fromEvent(event, options = {}) {
    //  Allow other scripts to prevent starting fancybox on click
    if (event.defaultPrevented) {
      return;
    }

    // Don't run if right-click
    if (event.button && event.button !== 0) {
      return;
    }

    // Ignore command/control + click
    if (event.ctrlKey || event.metaKey || event.shiftKey) {
      return;
    }

    // Support `trigger` element, e.g., start fancybox from different DOM element, for example,
    // to have one preview image for hidden image gallery
    let eventTarget = event.target;
    let triggerGroupName;

    if (
      eventTarget.matches("[data-fancybox-trigger]") ||
      (eventTarget = eventTarget.closest("[data-fancybox-trigger]"))
    ) {
      triggerGroupName = eventTarget && eventTarget.dataset && eventTarget.dataset.fancyboxTrigger;
    }

    if (triggerGroupName) {
      const triggerItems = document.querySelectorAll(`[data-fancybox="${triggerGroupName}"]`);
      const triggerIndex = parseInt(eventTarget.dataset.fancyboxIndex, 10) || 0;

      eventTarget = triggerItems.length ? triggerItems[triggerIndex] : eventTarget;
    }

    if (!eventTarget) {
      eventTarget = event.target;
    }

    // * Try to find matching openener
    let matchingOpener;
    let target;

    Array.from(Fancybox.openers.keys())
      .reverse()
      .some((opener) => {
        target = eventTarget;

        // Chain closest() to event.target to find and return the parent element,
        // regardless if clicking on the child elements (icon, label, etc)
        if (!(target.matches(opener) || (target = target.closest(opener)))) {
          return;
        }

        event.preventDefault();

        matchingOpener = opener;

        return true;
      });

    let rez = false;

    if (matchingOpener) {
      options.event = event;
      options.target = target;

      target.origTarget = event.target;

      rez = Fancybox.fromOpener(matchingOpener, options);

      // Check if the mouse is being used
      // Waiting for better browser support for `:focus-visible` -
      // https://drafts.csswg.org/selectors-4/#the-focus-visible-pseudo
      const nextInstance = Fancybox.getInstance();

      if (nextInstance && nextInstance.state === "ready" && event.detail) {
        document.body.classList.add("is-using-mouse");
      }
    }

    return rez;
  }

  /**
   * Starts Fancybox using selector
   * @param {String} opener - Valid CSS selector string
   * @param {Object} [options] - Optional custom options
   */
  static fromOpener(opener, options = {}) {
    // Callback function called once for each group element that
    // 1) converts data attributes to boolean or JSON
    // 2) removes values that could cause issues
    const mapCallback = function (el) {
      const falseValues = ["false", "0", "no", "null", "undefined"];
      const trueValues = ["true", "1", "yes"];

      const options = Object.assign({}, el.dataset);

      for (let [key, value] of Object.entries(options)) {
        if (typeof value === "string" || value instanceof String) {
          if (falseValues.indexOf(value) > -1) {
            options[key] = false;
          } else if (trueValues.indexOf(options[key]) > -1) {
            options[key] = true;
          } else {
            try {
              options[key] = JSON.parse(value);
            } catch (e) {
              options[key] = value;
            }
          }
        }
      }

      delete options.fancybox;
      delete options.type;

      if (el instanceof Element) {
        options.$trigger = el;
      }

      return options;
    };

    let items = [],
      index = options.startIndex || 0,
      target = options.target || null;

    // Get options
    options = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)({}, options, Fancybox.openers.get(opener));

    // Get matching nodes
    const groupAttr = options.groupAttr === undefined ? "data-fancybox" : options.groupAttr;
    const groupValue = groupAttr && target && target.getAttribute(`${groupAttr}`);

    const groupAll = options.groupAll === undefined ? false : options.groupAll;

    if (groupAll || groupValue) {
      items = [].slice.call(document.querySelectorAll(opener));

      if (!groupAll) {
        items = items.filter((el) => el.getAttribute(`${groupAttr}`) === groupValue);
      }
    } else {
      items = [target];
    }

    if (!items.length) {
      return false;
    }

    // Exit if current instance is triggered from the same element
    const currentInstance = Fancybox.getInstance();

    if (currentInstance && items.indexOf(currentInstance.options.$trigger) > -1) {
      return false;
    }

    // Index of current item in the gallery
    index = target ? items.indexOf(target) : index;

    // Convert items in a format supported by fancybox
    items = items.map(mapCallback);

    // * Create new fancybox instance
    return new Fancybox(
      items,
      (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)({}, options, {
        startIndex: index,
        $trigger: target,
      })
    );
  }

  /**
   * Attach a click handler function that starts Fancybox to the selected items, as well as to all future matching elements.
   * @param {String} selector - Selector that should match trigger elements
   * @param {Object} [options] - Custom options
   */
  static bind(selector, options = {}) {
    if (!_shared_utils_canUseDOM_js__WEBPACK_IMPORTED_MODULE_1__.canUseDOM) {
      return;
    }

    if (!Fancybox.openers.size) {
      document.body.addEventListener("click", Fancybox.fromEvent, false);

      // Pass self to plugins to avoid circular dependencies
      for (const [key, Plugin] of Object.entries(Fancybox.Plugins || {})) {
        Plugin.Fancybox = this;

        if (typeof Plugin.create === "function") {
          Plugin.create();
        }
      }
    }

    Fancybox.openers.set(selector, options);
  }

  /**
   * Remove the click handler that was attached with `bind()`
   * @param {String} selector - A selector which should match the one originally passed to .bind()
   */
  static unbind(selector) {
    Fancybox.openers.delete(selector);

    if (!Fancybox.openers.size) {
      Fancybox.destroy();
    }
  }

  /**
   * Immediately destroy all instances (without closing animation) and clean up all bindings..
   */
  static destroy() {
    let fb;

    while ((fb = Fancybox.getInstance())) {
      fb.destroy();
    }

    Fancybox.openers = new Map();

    document.body.removeEventListener("click", Fancybox.fromEvent, false);
  }

  /**
   * Retrieve instance by identifier or the top most instance, if identifier is not provided
   * @param {String|Numeric} [id] - Optional instance identifier
   */
  static getInstance(id) {
    let nodes = [];

    if (id) {
      nodes = [document.getElementById(`fancybox-${id}`)];
    } else {
      nodes = Array.from(document.querySelectorAll(".fancybox__container")).reverse();
    }

    for (const $container of nodes) {
      const instance = $container && $container.Fancybox;

      if (instance && instance.state !== "closing" && instance.state !== "customClosing") {
        return instance;
      }
    }

    return null;
  }

  /**
   * Close all or topmost currently active instance.
   * @param {boolean} [all] - All or only topmost active instance
   */
  static close(all = true) {
    let instance = null;

    while ((instance = Fancybox.getInstance())) {
      instance.close();

      if (!all) return;
    }
  }
}

// Expose version
Fancybox.version = "__VERSION__";

// Expose defaults
Fancybox.defaults = defaults;

// Expose openers
Fancybox.openers = new Map();

// Add default plugins
Fancybox.Plugins = _plugins_index_js__WEBPACK_IMPORTED_MODULE_4__.Plugins;

// Auto init with default options
Fancybox.bind("[data-fancybox]");




/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Fancybox/l10n/en.js":
/*!************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Fancybox/l10n/en.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  CLOSE: "Close",
  NEXT: "Next",
  PREV: "Previous",
  MODAL: "You can close this modal content with the ESC key",
  ERROR: "Something Went Wrong, Please Try Again Later",
  IMAGE_ERROR: "Image Not Found",
  ELEMENT_NOT_FOUND: "HTML Element Not Found",
  AJAX_NOT_FOUND: "Error Loading AJAX : Not Found",
  AJAX_FORBIDDEN: "Error Loading AJAX : Forbidden",
  IFRAME_ERROR: "Error Loading Page",
  TOGGLE_ZOOM: "Toggle zoom level",
  TOGGLE_THUMBS: "Toggle thumbnails",
  TOGGLE_SLIDESHOW: "Toggle slideshow",
  TOGGLE_FULLSCREEN: "Toggle full-screen mode",
  DOWNLOAD: "Download",
});


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/Hash/Hash.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Fancybox/plugins/Hash/Hash.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Hash": () => (/* binding */ Hash)
/* harmony export */ });
/* harmony import */ var _shared_utils_canUseDOM_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../shared/utils/canUseDOM.js */ "./node_modules/@fancyapps/ui/src/shared/utils/canUseDOM.js");


/**
 * Helper method to split URL hash into useful pieces
 */
const getParsedURL = function () {
  const hash = window.location.hash.substr(1),
    tmp = hash.split("-"),
    index = tmp.length > 1 && /^\+?\d+$/.test(tmp[tmp.length - 1]) ? parseInt(tmp.pop(-1), 10) || null : null,
    slug = tmp.join("-");

  return {
    hash,
    slug,
    index,
  };
};

class Hash {
  constructor(fancybox) {
    this.fancybox = fancybox;

    for (const methodName of ["onChange", "onClosing"]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.events = {
      initCarousel: this.onChange,
      "Carousel.change": this.onChange,
      closing: this.onClosing,
    };

    this.hasCreatedHistory = false;
    this.origHash = "";
    this.timer = null;
  }

  /**
   * Process `Carousel.ready` and `Carousel.change` events to update URL hash
   * @param {Object} fancybox
   * @param {Object} carousel
   */
  onChange() {
    const fancybox = this.fancybox;
    const carousel = fancybox.Carousel;

    if (this.timer) {
      clearTimeout(this.timer);
    }

    const firstRun = carousel.prevPage === null;

    const slide = fancybox.getSlide();

    const dataset = slide.$trigger && slide.$trigger.dataset;

    const currentHash = window.location.hash.substr(1);

    let newHash = false;

    if (slide.slug) {
      newHash = slide.slug;
    } else {
      let dataAttribute = dataset && dataset.fancybox;

      if (dataAttribute && dataAttribute.length && dataAttribute !== "true") {
        newHash = dataAttribute + (carousel.slides.length > 1 ? "-" + (slide.index + 1) : "");
      }
    }

    if (firstRun) {
      this.origHash = currentHash !== newHash ? this.origHash : "";
    }

    if (newHash && currentHash !== newHash) {
      this.timer = setTimeout(() => {
        try {
          window.history[firstRun ? "pushState" : "replaceState"](
            {},
            document.title,
            window.location.pathname + window.location.search + "#" + newHash
          );

          if (firstRun) {
            this.hasCreatedHistory = true;
          }
        } catch (e) {}
      }, 300);
    }
  }

  /**
   * Process `closing` event to clean up
   */
  onClosing() {
    if (this.timer) {
      clearTimeout(this.timer);
    }

    // Skip if closing is triggered by pressing  browser back button or by changing hash manually
    if (this.hasSilentClose === true) {
      return;
    }

    // Simply make browser to move back one page in the session history,
    // if new history entry is successfully created
    if (!this.hasCreatedHistory) {
      try {
        window.history.replaceState(
          {},
          document.title,
          window.location.pathname + window.location.search + (this.origHash ? "#" + this.origHash : "")
        );

        return;
      } catch (e) {}
    }

    window.history.back();
  }

  attach(fancybox) {
    fancybox.on(this.events);
  }

  detach(fancybox) {
    fancybox.off(this.events);
  }

  /**
   * Start fancybox from current URL hash,
   * this will be called on page load OR/AND after changing URL hash
   * @param {Class} Fancybox
   */
  static startFromUrl() {
    if (Hash.Fancybox.getInstance()) {
      return;
    }

    const { hash, slug, index } = getParsedURL();

    if (!slug) {
      return;
    }

    // Support custom slug
    let selectedElem = document.querySelector(`[data-slug="${hash}"]`);

    if (selectedElem) {
      selectedElem.dispatchEvent(new CustomEvent("click", { bubbles: true, cancelable: true }));
    }

    if (Hash.Fancybox.getInstance()) {
      return;
    }

    // Use URL hash value as group name
    const groupElems = document.querySelectorAll(`[data-fancybox="${slug}"]`);

    if (!groupElems.length) {
      return;
    }

    if (index === null && groupElems.length === 1) {
      selectedElem = groupElems[0];
    } else if (index) {
      selectedElem = groupElems[index - 1];
    }

    if (selectedElem) {
      selectedElem.dispatchEvent(new CustomEvent("click", { bubbles: true, cancelable: true }));
    }
  }

  /**
   * Handle `hash` change, change gallery item to current index or start/close current instance
   */
  static onHashChange() {
    const { slug, index } = getParsedURL();

    const instance = Hash.Fancybox.getInstance();

    if (instance) {
      // Look if this is inside currently active gallery
      if (slug) {
        const carousel = instance.Carousel;
        /**
         * Check if URL hash matches `data-slug` value of active element
         */
        for (let slide of carousel.slides) {
          if (slide.slug && slide.slug === slug) {
            return carousel.slideTo(slide.index);
          }
        }

        /**
         * Check if URL hash matches `data-fancybox` value of active element
         */
        const slide = instance.getSlide();
        const dataset = slide.$trigger && slide.$trigger.dataset;

        if (dataset && dataset.fancybox === slug) {
          return carousel.slideTo(index - 1);
        }
      }

      /**
       * Close if no matching element found
       */
      instance.plugins.Hash.hasSilentClose = true;

      instance.close();
    }

    /**
     * Attempt to start
     */

    Hash.startFromUrl();
  }

  /**
   * Add event bindings that will start new Fancybox instance based in the current URL
   */

  static onReady() {
    window.addEventListener("hashchange", Hash.onHashChange, false);

    Hash.startFromUrl();
  }

  static create() {
    // Skip if SSR
    if (!_shared_utils_canUseDOM_js__WEBPACK_IMPORTED_MODULE_0__.canUseDOM) {
      return;
    }

    /**
     * Attempt to start Fancybox
     */
    window.requestAnimationFrame(() => {
      Hash.onReady();
    });
  }

  static destroy() {
    window.removeEventListener("hashchange", Hash.onHashChange, false);
  }
}


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/Html/Html.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Fancybox/plugins/Html/Html.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Html": () => (/* binding */ Html)
/* harmony export */ });
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../shared/utils/extend.js */ "./node_modules/@fancyapps/ui/src/shared/utils/extend.js");


const buildURLQuery = (obj) => {
  return Object.entries(obj)
    .map((pair) => pair.map(encodeURIComponent).join("="))
    .join("&");
};

const defaults = {
  // General options for any video content (Youtube, Vimeo, HTML5 video)
  video: {
    autoplay: true,
    ratio: 16 / 9,
  },
  // Youtube embed parameters
  youtube: {
    autohide: 1,
    fs: 1,
    rel: 0,
    hd: 1,
    wmode: "transparent",
    enablejsapi: 1,
    html5: 1,
  },
  // Vimeo embed parameters
  vimeo: {
    hd: 1,
    show_title: 1,
    show_byline: 1,
    show_portrait: 0,
    fullscreen: 1,
  },
  // HTML5 video parameters
  html5video: {
    tpl: `<video class="fancybox__html5video" playsinline controls controlsList="nodownload" poster="{{poster}}">
  <source src="{{src}}" type="{{format}}" />
  Sorry, your browser doesn\'t support embedded videos, <a href="{{src}}">download</a> and watch with your favorite video player!
</video>`,
    format: "",
  },
};

class Html {
  constructor(fancybox) {
    this.fancybox = fancybox;

    for (const methodName of [
      "onInit",
      "onReady",

      "onCreateSlide",
      "onRemoveSlide",

      "onSelectSlide",
      "onUnselectSlide",

      "onRefresh",

      // For communication with iframed video (youtube/vimeo)
      "onMessage",
    ]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.events = {
      init: this.onInit,
      ready: this.onReady,

      "Carousel.createSlide": this.onCreateSlide,
      "Carousel.removeSlide": this.onRemoveSlide,

      "Carousel.selectSlide": this.onSelectSlide,
      "Carousel.unselectSlide": this.onUnselectSlide,

      "Carousel.refresh": this.onRefresh,
    };
  }

  /**
   * Check if each gallery item has type when fancybox starts
   */
  onInit() {
    for (const slide of this.fancybox.items) {
      this.processType(slide);
    }
  }

  /**
   * Set content type for the slide
   * @param {Object} slide
   */
  processType(slide) {
    // Add support for `new Fancybox({items : [{html : 'smth'}]});`
    if (slide.html) {
      slide.src = slide.html;
      slide.type = "html";

      delete slide.html;

      return;
    }

    const src = slide.src || "";

    let type = slide.type || this.fancybox.options.type,
      rez = null;

    if (src && typeof src !== "string") {
      return;
    }

    if (
      (rez = src.match(
        /(?:youtube\.com|youtu\.be|youtube\-nocookie\.com)\/(?:watch\?(?:.*&)?v=|v\/|u\/|embed\/?)?(videoseries\?list=(?:.*)|[\w-]{11}|\?listType=(?:.*)&list=(?:.*))(?:.*)/i
      ))
    ) {
      const params = buildURLQuery(this.fancybox.option("Html.youtube"));
      const videoId = encodeURIComponent(rez[1]);

      slide.videoId = videoId;
      slide.src = `https://www.youtube-nocookie.com/embed/${videoId}?${params}`;
      slide.thumb = slide.thumb || `https://i.ytimg.com/vi/${videoId}/mqdefault.jpg`;
      slide.vendor = "youtube";

      type = "video";
    } else if ((rez = src.match(/^.+vimeo.com\/(?:\/)?([\d]+)(.*)?/))) {
      const params = buildURLQuery(this.fancybox.option("Html.vimeo"));
      const videoId = encodeURIComponent(rez[1]);

      slide.videoId = videoId;
      slide.src = `https://player.vimeo.com/video/${videoId}?${params}`;
      slide.vendor = "vimeo";

      type = "video";
    } else if (
      (rez = src.match(
        /(?:maps\.)?google\.([a-z]{2,3}(?:\.[a-z]{2})?)\/(?:(?:(?:maps\/(?:place\/(?:.*)\/)?\@(.*),(\d+.?\d+?)z))|(?:\?ll=))(.*)?/i
      ))
    ) {
      slide.src = `//maps.google.${rez[1]}/?ll=${(rez[2]
        ? rez[2] + "&z=" + Math.floor(rez[3]) + (rez[4] ? rez[4].replace(/^\//, "&") : "")
        : rez[4] + ""
      ).replace(/\?/, "&")}&output=${rez[4] && rez[4].indexOf("layer=c") > 0 ? "svembed" : "embed"}`;

      type = "map";
    } else if ((rez = src.match(/(?:maps\.)?google\.([a-z]{2,3}(?:\.[a-z]{2})?)\/(?:maps\/search\/)(.*)/i))) {
      slide.src = `//maps.google.${rez[1]}/maps?q=${rez[2].replace("query=", "q=").replace("api=1", "")}&output=embed`;

      type = "map";
    }

    // Guess content type
    if (!type) {
      if (src.charAt(0) === "#") {
        type = "inline";
      } else if ((rez = src.match(/\.(mp4|mov|ogv|webm)((\?|#).*)?$/i))) {
        type = "html5video";

        slide.format = slide.format || "video/" + (rez[1] === "ogv" ? "ogg" : rez[1]);
      } else if (src.match(/(^data:image\/[a-z0-9+\/=]*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg|ico)((\?|#).*)?$)/i)) {
        type = "image";
      } else if (src.match(/\.(pdf)((\?|#).*)?$/i)) {
        type = "pdf";
      }
    }

    slide.type = type || this.fancybox.option("defaultType", "image");

    if (type === "html5video" || type === "video") {
      slide.video = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)({}, this.fancybox.option("Html.video"), slide.video);

      if (slide.width && slide.height) {
        slide.ratio = parseFloat(slide.width) / parseFloat(slide.height);
      } else {
        slide.ratio = slide.ratio || slide.video.ratio;
      }
    }
  }

  /**
   * Start loading content when Fancybox is ready
   */
  onReady() {
    this.fancybox.Carousel.slides.forEach((slide) => {
      if (slide.$el) {
        this.setContent(slide);

        if (slide.index === this.fancybox.getSlide().index) {
          this.playVideo(slide);
        }
      }
    });
  }

  /**
   * Process `Carousel.createSlide` event to create image content
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onCreateSlide(fancybox, carousel, slide) {
    if (this.fancybox.state !== "ready") {
      return;
    }

    this.setContent(slide);
  }

  /**
   * Retrieve and set slide content
   * @param {Object} slide
   */
  loadInlineContent(slide) {
    let $content;

    if (slide.src instanceof HTMLElement) {
      $content = slide.src;
    } else if (typeof slide.src === "string") {
      const tmp = slide.src.split("#", 2);
      const id = tmp.length === 2 && tmp[0] === "" ? tmp[1] : tmp[0];

      $content = document.getElementById(id);
    }

    if ($content) {
      if (slide.type === "clone" || $content.$placeHolder) {
        $content = $content.cloneNode(true);
        let attrId = $content.getAttribute("id");

        attrId = attrId ? `${attrId}--clone` : `clone-${this.fancybox.id}-${slide.index}`;

        $content.setAttribute("id", attrId);
      } else {
        const $placeHolder = document.createElement("div");
        $placeHolder.classList.add("fancybox-placeholder");
        $content.parentNode.insertBefore($placeHolder, $content);
        $content.$placeHolder = $placeHolder;
      }

      this.fancybox.setContent(slide, $content);
    } else {
      this.fancybox.setError(slide, "{{ELEMENT_NOT_FOUND}}");
    }
  }

  /**
   * Makes AJAX request and sets response as slide content
   * @param {Object} slide
   */
  loadAjaxContent(slide) {
    const fancybox = this.fancybox;
    const xhr = new XMLHttpRequest();

    fancybox.showLoading(slide);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (fancybox.state === "ready") {
          fancybox.hideLoading(slide);

          if (xhr.status === 200) {
            fancybox.setContent(slide, xhr.responseText);
          } else {
            fancybox.setError(slide, xhr.status === 404 ? "{{AJAX_NOT_FOUND}}" : "{{AJAX_FORBIDDEN}}");
          }
        }
      }
    };

    xhr.open("GET", slide.src);
    xhr.send(slide.ajax || null);

    slide.xhr = xhr;
  }

  /**
   * Creates iframe as slide content, preloads if needed before displaying
   * @param {Object} slide
   */
  loadIframeContent(slide) {
    const fancybox = this.fancybox;
    const $iframe = document.createElement("iframe");

    $iframe.className = "fancybox__iframe";

    $iframe.setAttribute("id", `fancybox__iframe_${fancybox.id}_${slide.index}`);

    $iframe.setAttribute("allow", "autoplay; fullscreen");
    $iframe.setAttribute("scrolling", "auto");

    slide.$iframe = $iframe;

    if (slide.type !== "iframe" || slide.preload === false) {
      $iframe.setAttribute("src", slide.src);

      this.fancybox.setContent(slide, $iframe);

      return;
    }

    fancybox.showLoading(slide);

    const $content = document.createElement("div");
    $content.style.visibility = "hidden";

    this.fancybox.setContent(slide, $content);

    $content.appendChild($iframe);

    $iframe.onerror = () => {
      fancybox.setError(slide, "{{IFRAME_ERROR}}");
    };

    $iframe.onload = () => {
      fancybox.hideLoading(slide);

      let isFirstLoad = false;

      if ($iframe.dataset.ready !== "yes") {
        $iframe.dataset.ready = "yes";
        isFirstLoad = true;
      }

      if (!$iframe.src.length) {
        return;
      }

      $iframe.parentNode.style.visibility = "";

      if (slide.autoSize !== false) {
        this.autoSizeIframe($iframe);
      }

      if (isFirstLoad) {
        fancybox.revealContent(slide);
      }
    };

    $iframe.setAttribute("src", slide.src);
  }

  /**
   * Set CSS max/min width/height properties of the content to have the correct aspect ratio
   * @param {Object} slide
   */
  setAspectRatio(slide) {
    let ratio = slide.ratio;

    if (!ratio || !slide.$content) {
      return;
    }

    slide.$content.style.maxWidth = "";
    slide.$content.style.maxHeight = "";

    let width = slide.$content.offsetWidth;
    let height = slide.$content.offsetHeight;

    let maxWidth = slide.width;
    let maxHeight = slide.height;

    if (maxWidth && maxHeight && (width > maxWidth || height > maxHeight)) {
      let maxRatio = Math.min(maxWidth / width, maxHeight / height);

      width = width * maxRatio;
      height = height * maxRatio;
    }

    if (ratio < width / height) {
      width = height * ratio;
    } else {
      height = width / ratio;
    }

    slide.$content.style.maxWidth = `${width}px`;
    slide.$content.style.maxHeight = `${height}px`;
  }

  /**
   * Adjust the width and height of iframe to fit with content
   * @param {Object} $iframe
   */
  autoSizeIframe($iframe) {
    if (!$iframe.dataset || $iframe.dataset.ready !== "yes") {
      return;
    }

    let parentStyle = $iframe.parentNode.style;

    parentStyle.flex = "1 1 auto";
    parentStyle.width = "";
    parentStyle.height = "";

    try {
      const document = $iframe.contentWindow.document,
        $html = document.getElementsByTagName("html")[0],
        $body = document.body,
        style = window.getComputedStyle($iframe.parentNode),
        paddingX = parseFloat(style.paddingLeft) + parseFloat(style.paddingRight),
        paddingY = parseFloat(style.paddingTop) + parseFloat(style.paddingBottom);

      // Get rid of vertical scrollbar
      $body.style.overflow = "hidden";

      const width = $html.scrollWidth;
      parentStyle.width = `${width + paddingX}px`;

      $body.style.overflow = "";

      parentStyle.flex = "";
      parentStyle.flexShrink = "0";
      parentStyle.height = `${$body.scrollHeight}px`;

      const height = $html.scrollHeight;

      parentStyle.height = `${height + paddingY}px`;
    } catch (error) {
      parentStyle = "";
    }
  }

  /**
   * Process `Carousel.onRefresh` event,
   * trigger iframe autosizing and set content aspect ratio for each slide
   * @param {Object} fancybox
   * @param {Object} carousel
   */
  onRefresh(fancybox, carousel) {
    carousel.slides.forEach((slide) => {
      if (!slide.$el) {
        return;
      }

      if (slide.$iframe && slide.autoSize !== false) {
        this.autoSizeIframe(slide.$iframe);
      }

      if (slide.ratio) {
        this.setAspectRatio(slide);
      }
    });
  }

  /**
   * Process `Carousel.onCreateSlide` event to set content
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  setContent(slide) {
    if (!slide || slide.isDom) {
      return;
    }

    switch (slide.type) {
      case "html":
        this.fancybox.setContent(slide, slide.src);
        break;

      case "html5video":
        this.fancybox.setContent(
          slide,
          this.fancybox
            .option("Html.html5video.tpl")
            .replace(/\{\{src\}\}/gi, slide.src)
            .replace("{{format}}", slide.format || (slide.html5video && slide.html5video.format) || "")
            .replace("{{poster}}", slide.thumb || "")
        );

        break;

      case "inline":
      case "clone":
        this.loadInlineContent(slide);
        break;

      case "ajax":
        this.loadAjaxContent(slide);
        break;

      case "iframe":
      case "pdf":
      case "video":
      case "map":
        this.loadIframeContent(slide);

        break;
    }

    if (slide.ratio) {
      this.setAspectRatio(slide);
    }
  }

  /**
   * Process `Carousel.onSelectSlide` event to start video
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onSelectSlide(fancybox, carousel, slide) {
    if (fancybox.state === "ready") {
      this.playVideo(slide);
    }
  }

  /**
   * Attempts to begin playback of the media
   * @param {Object} slide
   */
  playVideo(slide) {
    if (slide.type === "html5video") {
      const videoElem = slide.$el.querySelector("video");

      if (videoElem) {
        try {
          videoElem.play();
        } catch (err) {}
      }
    }

    if (slide.type !== "video" || !(slide.$iframe && slide.$iframe.contentWindow)) {
      return;
    }

    // This function will be repeatedly called to check
    // if video iframe has been loaded to send message to start the video
    const poller = () => {
      if (slide.state !== "done" || !slide.$iframe || !slide.$iframe.contentWindow) {
        return;
      }

      let command;

      if (slide.$iframe.isReady) {
        if (slide.video && slide.video.autoplay) {
          if (slide.vendor == "youtube") {
            command = {
              event: "command",
              func: "playVideo",
            };
          } else {
            command = {
              method: "play",
              value: "true",
            };
          }
        }

        if (command) {
          slide.$iframe.contentWindow.postMessage(JSON.stringify(command), "*");
        }

        return;
      }

      if (slide.vendor === "youtube") {
        command = {
          event: "listening",
          id: slide.$iframe.getAttribute("id"),
        };

        slide.$iframe.contentWindow.postMessage(JSON.stringify(command), "*");
      }

      slide.poller = setTimeout(poller, 250);
    };

    poller();
  }

  /**
   * Process `Carousel.onUnselectSlide` event to pause video
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onUnselectSlide(fancybox, carousel, slide) {
    if (slide.type === "html5video") {
      try {
        slide.$el.querySelector("video").pause();
      } catch (error) {}

      return;
    }

    let command = false;

    if (slide.vendor == "vimeo") {
      command = {
        method: "pause",
        value: "true",
      };
    } else if (slide.vendor === "youtube") {
      command = {
        event: "command",
        func: "pauseVideo",
      };
    }

    if (command && slide.$iframe && slide.$iframe.contentWindow) {
      slide.$iframe.contentWindow.postMessage(JSON.stringify(command), "*");
    }

    clearTimeout(slide.poller);
  }

  /**
   * Process `Carousel.onRemoveSlide` event to do clean up
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onRemoveSlide(fancybox, carousel, slide) {
    // Abort ajax request if exists
    if (slide.xhr) {
      slide.xhr.abort();
      slide.xhr = null;
    }

    // Unload iframe content if exists
    if (slide.$iframe) {
      slide.$iframe.onload = slide.$iframe.onerror = null;

      slide.$iframe.src = "//about:blank";
      slide.$iframe = null;
    }

    // Clear inline content
    const $content = slide.$content;

    if (slide.type === "inline" && $content) {
      $content.classList.remove("fancybox__content");

      if ($content.style.display !== "none") {
        $content.style.display = "none";
      }

      if (slide.$closeButton) {
        slide.$closeButton.remove();
        slide.$closeButton = null;
      }
    }

    const $placeHolder = $content && $content.$placeHolder;

    if ($placeHolder) {
      $placeHolder.parentNode.insertBefore($content, $placeHolder);
      $placeHolder.remove();
      $content.$placeHolder = null;
    }
  }

  /**
   * Process `window.message` event to mark video iframe element as `ready`
   * @param {Object} e - Event
   */
  onMessage(e) {
    try {
      let data = JSON.parse(e.data);

      if (e.origin === "https://player.vimeo.com") {
        if (data.event === "ready") {
          for (let $iframe of document.getElementsByClassName("fancybox__iframe")) {
            if ($iframe.contentWindow === e.source) {
              $iframe.isReady = 1;
            }
          }
        }
      } else if (e.origin === "https://www.youtube-nocookie.com") {
        if (data.event === "onReady") {
          document.getElementById(data.id).isReady = 1;
        }
      }
    } catch (ex) {}
  }

  attach() {
    this.fancybox.on(this.events);

    window.addEventListener("message", this.onMessage, false);
  }

  detach() {
    this.fancybox.off(this.events);

    window.removeEventListener("message", this.onMessage, false);
  }
}

// Expose defaults
Html.defaults = defaults;


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/Image/Image.js":
/*!************************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Fancybox/plugins/Image/Image.js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Image": () => (/* binding */ Image)
/* harmony export */ });
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../shared/utils/extend.js */ "./node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _Panzoom_Panzoom_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../Panzoom/Panzoom.js */ "./node_modules/@fancyapps/ui/src/Panzoom/Panzoom.js");




const defaults = {
  // Class name for slide element indicating that content can be zoomed in
  canZoomInClass: "can-zoom_in",

  // Class name for slide element indicating that content can be zoomed out
  canZoomOutClass: "can-zoom_out",

  // Do zoom animation from thumbnail image when starting or closing fancybox
  zoom: true,

  // Animate opacity while zooming
  zoomOpacity: "auto", // "auto" | true | false,

  // Zoom animation friction
  zoomFriction: 0.82,

  // Disable zoom animation if thumbnail is visible only partly
  ignoreCoveredThumbnail: false,

  // Enable guestures
  touch: true,

  // Action to be performed when user clicks on the image
  click: "toggleZoom", // "toggleZoom" | "next" | "close" | null

  // Action to be performed when double-click event is detected on the image
  doubleClick: null, // "toggleZoom" | null

  // Action to be performed when user rotates a wheel button on a pointing device
  wheel: "zoom", // "zoom" | "slide" | "close" | null

  // How image should be resized to fit its container
  fit: "contain", // "contain" | "contain-w" | "cover"

  // Should create wrapping element around the image
  wrap: false,

  // Custom Panzoom options
  Panzoom: {
    ratio: 1,
  },
};

class Image {
  constructor(fancybox) {
    this.fancybox = fancybox;

    for (const methodName of [
      // Fancybox
      "onReady",
      "onClosing",
      "onDone",

      // Fancybox.Carousel
      "onPageChange",
      "onCreateSlide",
      "onRemoveSlide",

      // Image load/error
      "onImageStatusChange",
    ]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.events = {
      ready: this.onReady,
      closing: this.onClosing,
      done: this.onDone,

      "Carousel.change": this.onPageChange,
      "Carousel.createSlide": this.onCreateSlide,
      "Carousel.removeSlide": this.onRemoveSlide,
    };
  }

  /**
   * Handle `ready` event to start loading content
   */
  onReady() {
    this.fancybox.Carousel.slides.forEach((slide) => {
      if (slide.$el) {
        this.setContent(slide);
      }
    });
  }

  /**
   * Handle `done` event to update cursor
   * @param {Object} fancybox
   * @param {Object} slide
   */
  onDone(fancybox, slide) {
    this.handleCursor(slide);
  }

  /**
   * Handle `closing` event to clean up all slides and to start zoom-out animation
   * @param {Object} fancybox
   */
  onClosing(fancybox) {
    clearTimeout(this.clickTimer);

    // Remove events
    fancybox.Carousel.slides.forEach((slide) => {
      if (slide.$image) {
        slide.state = "destroy";
      }

      if (slide.Panzoom) {
        slide.Panzoom.detachEvents();
      }
    });

    // If possible, start the zoom animation, it will interrupt the default closing process
    if (this.fancybox.state === "closing" && this.canZoom(fancybox.getSlide())) {
      this.zoomOut();
    }
  }

  /**
   * Process `Carousel.createSlide` event to create image content
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onCreateSlide(fancybox, carousel, slide) {
    if (this.fancybox.state !== "ready") {
      return;
    }

    this.setContent(slide);
  }

  /**
   * Handle `Carousel.removeSlide` event to do clean up the slide
   * @param {Object} fancybox
   * @param {Object} carousel
   * @param {Object} slide
   */
  onRemoveSlide(fancybox, carousel, slide) {
    if (slide.$image) {
      slide.$el.classList.remove(fancybox.option("Image.canZoomInClass"));

      slide.$image.remove();
      slide.$image = null;
    }

    if (slide.Panzoom) {
      slide.Panzoom.destroy();
      slide.Panzoom = null;
    }

    if (slide.$el && slide.$el.dataset) {
      delete slide.$el.dataset.imageFit;
    }
  }

  /**
   * Build DOM elements and add event listeners
   * @param {Object} slide
   */
  setContent(slide) {
    // Check if this slide should contain an image
    if (slide.isDom || slide.html || (slide.type && slide.type !== "image")) {
      return;
    }

    if (slide.$image) {
      return;
    }

    slide.type = "image";
    slide.state = "loading";

    // * Build layout
    // Container
    const $content = document.createElement("div");
    $content.style.visibility = "hidden";

    // Image element
    const $image = document.createElement("img");

    $image.addEventListener("load", (event) => {
      event.stopImmediatePropagation();

      this.onImageStatusChange(slide);
    });

    $image.addEventListener("error", () => {
      this.onImageStatusChange(slide);
    });

    $image.src = slide.src;
    $image.alt = "";
    $image.draggable = false;

    $image.classList.add("fancybox__image");

    if (slide.srcset) {
      $image.setAttribute("srcset", slide.srcset);
    }

    if (slide.sizes) {
      $image.setAttribute("sizes", slide.sizes);
    }

    slide.$image = $image;

    const shouldWrap = this.fancybox.option("Image.wrap");

    if (shouldWrap) {
      const $wrap = document.createElement("div");
      $wrap.classList.add(typeof shouldWrap === "string" ? shouldWrap : "fancybox__image-wrap");

      $wrap.appendChild($image);

      $content.appendChild($wrap);

      slide.$wrap = $wrap;
    } else {
      $content.appendChild($image);
    }

    // Set data attribute if other that default
    // for example, set `[data-image-fit="contain-w"]`
    slide.$el.dataset.imageFit = this.fancybox.option("Image.fit");

    // Append content
    this.fancybox.setContent(slide, $content);

    // Display loading icon
    if ($image.complete || $image.error) {
      this.onImageStatusChange(slide);
    } else {
      this.fancybox.showLoading(slide);
    }
  }

  /**
   * Handle image state change, display error or start revealing image
   * @param {Object} slide
   */
  onImageStatusChange(slide) {
    const $image = slide.$image;

    if (!$image || slide.state !== "loading") {
      return;
    }

    if (!($image.complete && $image.naturalWidth && $image.naturalHeight)) {
      this.fancybox.setError(slide, "{{IMAGE_ERROR}}");

      return;
    }

    this.fancybox.hideLoading(slide);

    if (this.fancybox.option("Image.fit") === "contain") {
      this.initSlidePanzoom(slide);
    }

    // Add `wheel` and `click` event handler
    slide.$el.addEventListener("wheel", (event) => this.onWheel(slide, event), { passive: false });
    slide.$content.addEventListener("click", (event) => this.onClick(slide, event), { passive: false });

    this.revealContent(slide);
  }

  /**
   * Make image zoomable and draggable using Panzoom
   * @param {Object} slide
   */
  initSlidePanzoom(slide) {
    if (slide.Panzoom) {
      return;
    }

    //* Initialize Panzoom
    slide.Panzoom = new _Panzoom_Panzoom_js__WEBPACK_IMPORTED_MODULE_1__.Panzoom(
      slide.$el,
      (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(true, this.fancybox.option("Image.Panzoom", {}), {
        viewport: slide.$wrap,
        content: slide.$image,

        wrapInner: false,

        // Allow to select caption text
        textSelection: true,

        // Toggle gestures
        touch: this.fancybox.option("Image.touch"),

        // This will prevent click conflict with fancybox main carousel
        panOnlyZoomed: true,

        // Disable default click / wheel events as custom event listeners will replace them,
        // because click and wheel events should work without Panzoom
        click: false,
        wheel: false,
      })
    );

    slide.Panzoom.on("startAnimation", () => {
      this.fancybox.trigger("Image.startAnimation", slide);
    });

    slide.Panzoom.on("endAnimation", () => {
      if (slide.state === "zoomIn") {
        this.fancybox.done(slide);
      }

      this.handleCursor(slide);

      this.fancybox.trigger("Image.endAnimation", slide);
    });

    slide.Panzoom.on("afterUpdate", () => {
      this.handleCursor(slide);

      this.fancybox.trigger("Image.afterUpdate", slide);
    });
  }

  /**
   * Start zoom-in animation if possible, or simply reveal content
   * @param {Object} slide
   */
  revealContent(slide) {
    // Animate only on first run
    if (
      this.fancybox.Carousel.prevPage === null &&
      slide.index === this.fancybox.options.startIndex &&
      this.canZoom(slide)
    ) {
      this.zoomIn();
    } else {
      this.fancybox.revealContent(slide);
    }
  }

  /**
   * Get zoom info for selected slide
   * @param {Object} slide
   */
  getZoomInfo(slide) {
    const $thumb = slide.$thumb,
      thumbRect = $thumb.getBoundingClientRect(),
      thumbWidth = thumbRect.width,
      thumbHeight = thumbRect.height,
      //
      contentRect = slide.$content.getBoundingClientRect(),
      contentWidth = contentRect.width,
      contentHeight = contentRect.height,
      //
      shiftedTop = contentRect.top - thumbRect.top,
      shiftedLeft = contentRect.left - thumbRect.left;

    // Check if need to update opacity
    let opacity = this.fancybox.option("Image.zoomOpacity");

    if (opacity === "auto") {
      opacity = Math.abs(thumbWidth / thumbHeight - contentWidth / contentHeight) > 0.1;
    }

    return {
      top: shiftedTop,
      left: shiftedLeft,
      scale: thumbRect.width / contentWidth,
      opacity: opacity,
    };
  }

  /**
   * Determine if it is possible to do zoom-in animation
   */
  canZoom(slide) {
    const fancybox = this.fancybox,
      $container = fancybox.$container;

    if (window.visualViewport && window.visualViewport.scale !== 1) {
      return false;
    }

    if (!fancybox.option("Image.zoom") || fancybox.option("Image.fit") !== "contain") {
      return false;
    }

    const $thumb = slide.$thumb;

    if (!$thumb || slide.state === "loading") {
      return false;
    }

    // * Check if thumbnail image is really visible
    $container.classList.add("fancybox__no-click");

    const rect = $thumb.getBoundingClientRect();

    let rez;

    // Check if thumbnail image is actually visible on the screen
    if (this.fancybox.option("Image.ignoreCoveredThumbnail")) {
      const visibleTopLeft = document.elementFromPoint(rect.left + 1, rect.top + 1) === $thumb;
      const visibleBottomRight = document.elementFromPoint(rect.right - 1, rect.bottom - 1) === $thumb;

      rez = visibleTopLeft && visibleBottomRight;
    } else {
      rez = document.elementFromPoint(rect.left + rect.width * 0.5, rect.top + rect.height * 0.5) === $thumb;
    }

    $container.classList.remove("fancybox__no-click");

    return rez;
  }

  /**
   * Perform zoom-in animation
   */
  zoomIn() {
    const fancybox = this.fancybox,
      slide = fancybox.getSlide(),
      Panzoom = slide.Panzoom;

    const { top, left, scale, opacity } = this.getZoomInfo(slide);

    slide.state = "zoomIn";

    fancybox.trigger("reveal", slide);

    // Scale and move to start position
    Panzoom.panTo({
      x: left * -1,
      y: top * -1,
      scale: scale,
      friction: 0,
      ignoreBounds: true,
    });

    slide.$content.style.visibility = "";

    if (opacity === true) {
      Panzoom.on("afterTransform", (panzoom) => {
        if (slide.state === "zoomIn" || slide.state === "zoomOut") {
          panzoom.$content.style.opacity = Math.min(1, 1 - (1 - panzoom.content.scale) / (1 - scale));
        }
      });
    }

    // Animate back to original position
    Panzoom.panTo({
      x: 0,
      y: 0,
      scale: 1,
      friction: this.fancybox.option("Image.zoomFriction"),
    });
  }

  /**
   * Perform zoom-out animation
   */
  zoomOut() {
    const fancybox = this.fancybox,
      slide = fancybox.getSlide(),
      Panzoom = slide.Panzoom;

    if (!Panzoom) {
      return;
    }

    slide.state = "zoomOut";
    fancybox.state = "customClosing";

    if (slide.$caption) {
      slide.$caption.style.visibility = "hidden";
    }

    let friction = this.fancybox.option("Image.zoomFriction");

    const animatePosition = (event) => {
      const { top, left, scale, opacity } = this.getZoomInfo(slide);

      // Increase speed on the first run if opacity is not animated
      if (!event && !opacity) {
        friction *= 0.82;
      }

      Panzoom.panTo({
        x: left * -1,
        y: top * -1,
        scale,
        friction,
        ignoreBounds: true,
      });

      // Gradually increase speed
      friction *= 0.98;
    };

    // Page scrolling will cause thumbnail to change position on the display,
    // therefore animation end position has to be recalculated after each page scroll
    window.addEventListener("scroll", animatePosition);

    Panzoom.on("endAnimation", () => {
      window.removeEventListener("scroll", animatePosition);
      fancybox.destroy();
    });

    animatePosition();
  }

  /**
   * Set the type of mouse cursor to indicate if content is zoomable
   * @param {Object} slide
   */
  handleCursor(slide) {
    if (slide.type !== "image") {
      return;
    }

    const panzoom = slide.Panzoom;
    const clickAction = this.fancybox.option("Image.click");
    const classList = slide.$el.classList;

    if (panzoom && clickAction === "toggleZoom") {
      const canZoom =
        panzoom && panzoom.content.scale === 1 && panzoom.option("maxScale") - panzoom.content.scale > 0.01;

      classList[canZoom ? "add" : "remove"](this.fancybox.option("Image.canZoomInClass"));
    } else if (clickAction === "close") {
      classList.add(this.fancybox.option("Image.canZoomOutClass"));
    }
  }

  /**
   * Handle `wheel` event
   * @param {Object} slide
   * @param {Object} event
   */
  onWheel(slide, event) {
    if (this.fancybox.state !== "ready") {
      return;
    }

    if (this.fancybox.trigger("Image.wheel", event) === false) {
      return;
    }

    switch (this.fancybox.option("Image.wheel")) {
      case "zoom":
        slide.Panzoom && slide.Panzoom.zoomWithWheel(event);

        break;

      case "close":
        this.fancybox.close();

        break;

      case "slide":
        this.fancybox[event.deltaY < 0 ? "prev" : "next"]();

        break;
    }
  }

  /**
   * Handle `click` and `dblclick` events
   * @param {Object} slide
   * @param {Object} event
   */
  onClick(slide, event) {
    // Check if can click
    if (this.fancybox.state !== "ready") {
      return;
    }

    const panzoom = slide.Panzoom;

    if (
      panzoom &&
      (panzoom.dragPosition.midPoint ||
        panzoom.dragOffset.x !== 0 ||
        panzoom.dragOffset.y !== 0 ||
        panzoom.dragOffset.scale !== 1)
    ) {
      return;
    }

    if (this.fancybox.Carousel.Panzoom.lockAxis) {
      return false;
    }

    const process = (action) => {
      if (this.fancybox.trigger("Image.click", event) === false) {
        return;
      }

      switch (action) {
        case "toggleZoom":
          event.stopPropagation();

          slide.Panzoom && slide.Panzoom.zoomWithClick(event);

          break;

        case "close":
          this.fancybox.close();

          break;

        case "next":
          event.stopPropagation();

          this.fancybox.next();

          break;
      }
    };

    // Clear pending single click
    if (this.clickTimer) {
      clearTimeout(this.clickTimer);
      this.clickTimer = null;
    }

    const clickAction = this.fancybox.option("Image.click");
    const dblclickAction = this.fancybox.option("Image.doubleClick");

    if (dblclickAction) {
      if (event.detail === 1) {
        this.clickTimer = setTimeout(() => {
          process(clickAction);
        }, 300);
      } else if (event.detail === 2) {
        process(dblclickAction);
      }
    } else {
      process(clickAction);
    }
  }

  /**
   * Handle `Carousel.change` event to reset zoom level for any zoomed in/out content
   * and to revel content of the current page
   * @param {Object} fancybox
   * @param {Object} carousel
   */
  onPageChange(fancybox, carousel) {
    const currSlide = fancybox.getSlide();

    carousel.slides.forEach((slide) => {
      if (!slide.Panzoom || slide.state !== "done") {
        return;
      }

      if (slide.index !== currSlide.index) {
        slide.Panzoom.panTo({
          x: 0,
          y: 0,
          scale: 1,
          friction: 0.8,
        });
      }
    });
  }

  attach() {
    this.fancybox.on(this.events);
  }

  detach() {
    this.fancybox.off(this.events);
  }
}

// Expose defaults
Image.defaults = defaults;


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/ScrollLock/ScrollLock.js":
/*!**********************************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Fancybox/plugins/ScrollLock/ScrollLock.js ***!
  \**********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ScrollLock": () => (/* binding */ ScrollLock)
/* harmony export */ });
/* harmony import */ var _src_shared_utils_isScrollable_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../../src/shared/utils/isScrollable.js */ "./node_modules/@fancyapps/ui/src/shared/utils/isScrollable.js");


class ScrollLock {
  constructor(fancybox) {
    this.fancybox = fancybox;
    this.viewport = null;

    this.pendingUpdate = null;

    for (const methodName of ["onReady", "onResize", "onTouchstart", "onTouchmove"]) {
      this[methodName] = this[methodName].bind(this);
    }
  }

  /**
   * Process `initLayout` event to attach event listeners and resize viewport if needed
   */
  onReady() {
    //* Support Visual Viewport API
    // https://developer.mozilla.org/en-US/docs/Web/API/Visual_Viewport_API
    const viewport = window.visualViewport;

    if (viewport) {
      this.viewport = viewport;
      this.startY = 0;

      viewport.addEventListener("resize", this.onResize);

      this.updateViewport();
    }

    //* Prevent bouncing while scrolling on mobile devices
    window.addEventListener("touchstart", this.onTouchstart, { passive: false });
    window.addEventListener("touchmove", this.onTouchmove, { passive: false });
  }

  /**
   * Handle `resize` event to call `updateViewport`
   */
  onResize() {
    this.updateViewport();
  }

  /**
   * Scale $container proportionally to actually fit inside browser,
   * e.g., disable viewport zooming
   */
  updateViewport() {
    const fancybox = this.fancybox,
      viewport = this.viewport,
      scale = viewport.scale || 1,
      $container = fancybox.$container;

    if (!$container) {
      return;
    }

    let width = "",
      height = "",
      transform = "";

    if (scale - 1 > 0.1) {
      width = `${viewport.width * scale}px`;
      height = `${viewport.height * scale}px`;
      transform = `translate3d(${viewport.offsetLeft}px, ${viewport.offsetTop}px, 0) scale(${1 / scale})`;
    }

    $container.style.width = width;
    $container.style.height = height;
    $container.style.transform = transform;
  }

  /**
   * Handle `touchstart` event to mark drag start position
   * @param {Object} event
   */
  onTouchstart(event) {
    this.startY = event.touches ? event.touches[0].screenY : event.screenY;
  }

  /**
   * Handle `touchmove` event to fix scrolling on mobile devices (iOS)
   * @param {Object} event
   */
  onTouchmove(event) {
    const startY = this.startY;
    const zoom = window.innerWidth / window.document.documentElement.clientWidth;

    if (event.touches.length > 1 || zoom !== 1) {
      return;
    }

    const target = event.target;
    const el = (0,_src_shared_utils_isScrollable_js__WEBPACK_IMPORTED_MODULE_0__.isScrollable)(target);

    if (!el) {
      event.preventDefault();
      return;
    }

    const style = window.getComputedStyle(el);
    const height = parseInt(style.getPropertyValue("height"), 10);

    const curY = event.touches ? event.touches[0].screenY : event.screenY;

    const isAtTop = startY <= curY && el.scrollTop === 0;
    const isAtBottom = startY >= curY && el.scrollHeight - el.scrollTop === height;

    if (isAtTop || isAtBottom) {
      event.preventDefault();
    }
  }

  /**
   * Clean everything up
   */
  cleanup() {
    if (this.pendingUpdate) {
      cancelAnimationFrame(this.pendingUpdate);
      this.pendingUpdate = null;
    }

    const viewport = this.viewport;

    if (viewport) {
      viewport.removeEventListener("resize", this.onResize);
      this.viewport = null;
    }

    window.removeEventListener("touchstart", this.onTouchstart, false);
    window.removeEventListener("touchmove", this.onTouchmove, false);
  }

  attach() {
    this.fancybox.on("initLayout", this.onReady);
  }

  detach() {
    this.fancybox.off("initLayout", this.onReady);

    this.cleanup();
  }
}


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/Thumbs/Thumbs.js":
/*!**************************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Fancybox/plugins/Thumbs/Thumbs.js ***!
  \**************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Thumbs": () => (/* binding */ Thumbs)
/* harmony export */ });
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../shared/utils/extend.js */ "./node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _Carousel_Carousel_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../Carousel/Carousel.js */ "./node_modules/@fancyapps/ui/src/Carousel/Carousel.js");



const defaults = {
  // The minimum number of images in the gallery to display thumbnails
  minSlideCount: 2,

  // Minimum screen height to display thumbnails
  minScreenHeight: 500,

  // Automatically show thumbnails when opened
  autoStart: true,

  // Keyboard shortcut to toggle thumbnail container
  key: "t",
};

class Thumbs {
  constructor(fancybox) {
    this.fancybox = fancybox;

    this.$container = null;
    this.state = "init";

    for (const methodName of ["onPrepare", "onClosing", "onKeydown"]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.events = {
      prepare: this.onPrepare,
      closing: this.onClosing,
      keydown: this.onKeydown,
    };
  }

  /**
   * Process `prepare` event to build the layout
   */
  onPrepare() {
    // Get slides, skip if the total number is less than the minimum
    const slides = this.getSlides();

    if (slides.length < this.fancybox.option("Thumbs.minSlideCount")) {
      this.state = "disabled";
      return;
    }

    if (
      this.fancybox.option("Thumbs.autoStart") === true &&
      this.fancybox.Carousel.Panzoom.content.height >= this.fancybox.option("Thumbs.minScreenHeight")
    ) {
      this.build();
    }
  }

  /**
   * Process `closing` event to disable all events
   */
  onClosing() {
    if (this.Carousel) {
      this.Carousel.Panzoom.detachEvents();
    }
  }

  /**
   * Process `keydown` event to enable thumbnail list toggling using keyboard key
   * @param {Object} fancybox
   * @param {String} key
   */
  onKeydown(fancybox, key) {
    if (key === fancybox.option("Thumbs.key")) {
      this.toggle();
    }
  }

  /**
   * Build layout and init thumbnail Carousel
   */
  build() {
    if (this.$container) {
      return;
    }

    // Create wrapping element and append to layout
    const $container = document.createElement("div");

    $container.classList.add("fancybox__thumbs");

    this.fancybox.$carousel.parentNode.insertBefore($container, this.fancybox.$carousel.nextSibling);

    // Initialise thumbnail carousel with all slides
    this.Carousel = new _Carousel_Carousel_js__WEBPACK_IMPORTED_MODULE_1__.Carousel(
      $container,
      (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(
        true,
        {
          Dots: false,
          Navigation: false,
          Sync: {
            friction: 0,
          },
          infinite: false,
          center: true,
          fill: true,
          dragFree: true,
          slidesPerPage: 1,
          preload: 1,
        },
        this.fancybox.option("Thumbs.Carousel"),
        {
          Sync: {
            target: this.fancybox.Carousel,
          },
          slides: this.getSlides(),
        }
      )
    );

    // Slide carousel on wheel event
    this.Carousel.Panzoom.on("wheel", (panzoom, event) => {
      event.preventDefault();

      this.fancybox[event.deltaY < 0 ? "prev" : "next"]();
    });

    this.$container = $container;

    this.state = "visible";
  }

  /**
   * Process all fancybox slides to get all thumbnail images
   */
  getSlides() {
    const slides = [];

    for (const slide of this.fancybox.items) {
      const thumb = slide.thumb;

      if (thumb) {
        slides.push({
          html: `<div class="fancybox__thumb" style="background-image:url('${thumb}')"></div>`,
          customClass: `has-thumb has-${slide.type || "image"}`,
        });
      }
    }

    return slides;
  }

  /**
   * Toggle visibility of thumbnail list
   * Tip: you can use `Fancybox.getInstance().plugins.Thumbs.toggle()` from anywhere in your code
   */
  toggle() {
    if (this.state === "visible") {
      this.Carousel.Panzoom.detachEvents();

      this.$container.style.display = "none";

      this.state = "hidden";

      return;
    }

    if (this.state === "hidden") {
      this.$container.style.display = "";

      this.Carousel.Panzoom.attachEvents();

      this.state = "visible";

      return;
    }

    this.build();
  }

  /**
   * Reset the state
   */
  cleanup() {
    if (this.Carousel) {
      this.Carousel.destroy();
      this.Carousel = null;
    }

    if (this.$container) {
      this.$container.remove();
      this.$container = null;
    }

    this.state = "init";
  }

  attach() {
    this.fancybox.on(this.events);
  }

  detach() {
    this.fancybox.off(this.events);

    this.cleanup();
  }
}

// Expose defaults
Thumbs.defaults = defaults;


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/Toolbar/Toolbar.js":
/*!****************************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Fancybox/plugins/Toolbar/Toolbar.js ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Toolbar": () => (/* binding */ Toolbar)
/* harmony export */ });
/* harmony import */ var _shared_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../shared/utils/isPlainObject.js */ "./node_modules/@fancyapps/ui/src/shared/utils/isPlainObject.js");
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../shared/utils/extend.js */ "./node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../shared/utils/Fullscreen.js */ "./node_modules/@fancyapps/ui/src/shared/utils/Fullscreen.js");
/* harmony import */ var _shared_utils_Slideshow_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../shared/utils/Slideshow.js */ "./node_modules/@fancyapps/ui/src/shared/utils/Slideshow.js");






const defaults = {
  // Toolbar items; can be links, buttons or `div` elements
  items: {
    counter: {
      type: "div",
      class: "fancybox__counter",
      html: '<span data-fancybox-index=""></span>&nbsp;/&nbsp;<span data-fancybox-count=""></span>',
      tabindex: -1,
      position: "left",
    },
    prev: {
      type: "button",
      class: "fancybox__button--prev",
      label: "PREV",
      html: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M15 4l-8 8 8 8"/></svg>',
      click: function (event) {
        event.preventDefault();

        this.fancybox.prev();
      },
    },
    next: {
      type: "button",
      class: "fancybox__button--next",
      label: "NEXT",
      html: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M8 4l8 8-8 8"/></svg>',
      click: function (event) {
        event.preventDefault();

        this.fancybox.next();
      },
    },
    fullscreen: {
      type: "button",
      class: "fancybox__button--fullscreen",
      label: "TOGGLE_FULLSCREEN",
      html: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1">
                <g><path d="M3 8 V3h5"></path><path d="M21 8V3h-5"></path><path d="M8 21H3v-5"></path><path d="M16 21h5v-5"></path></g>
                <g><path d="M7 2v5H2M17 2v5h5M2 17h5v5M22 17h-5v5"/></g>
            </svg>`,
      click: function (event) {
        event.preventDefault();

        if (_shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.element()) {
          _shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.deactivate();
        } else {
          _shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.activate(this.fancybox.$container);
        }
      },
    },
    slideshow: {
      type: "button",
      class: "fancybox__button--slideshow",
      label: "TOGGLE_SLIDESHOW",
      html: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1">
                <g><path d="M6 4v16"/><path d="M20 12L6 20"/><path d="M20 12L6 4"/></g>
                <g><path d="M7 4v15M17 4v15"/></g>
            </svg>`,
      click: function (event) {
        event.preventDefault();

        this.Slideshow.toggle();
      },
    },
    zoom: {
      type: "button",
      class: "fancybox__button--zoom",
      label: "TOGGLE_ZOOM",
      html: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><circle cx="10" cy="10" r="7"></circle><path d="M16 16 L21 21"></svg>',
      click: function (event) {
        event.preventDefault();

        const panzoom = this.fancybox.getSlide().Panzoom;

        if (panzoom) {
          panzoom.toggleZoom();
        }
      },
    },
    download: {
      type: "link",
      label: "DOWNLOAD",
      class: "fancybox__button--download",
      html: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M12 15V3m0 12l-4-4m4 4l4-4M2 17l.62 2.48A2 2 0 004.56 21h14.88a2 2 0 001.94-1.51L22 17"/></svg>',
      click: function (event) {
        event.stopPropagation();
      },
    },
    thumbs: {
      type: "button",
      label: "TOGGLE_THUMBS",
      class: "fancybox__button--thumbs",
      html: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><circle cx="4" cy="4" r="1" /><circle cx="12" cy="4" r="1" transform="rotate(90 12 4)"/><circle cx="20" cy="4" r="1" transform="rotate(90 20 4)"/><circle cx="4" cy="12" r="1" transform="rotate(90 4 12)"/><circle cx="12" cy="12" r="1" transform="rotate(90 12 12)"/><circle cx="20" cy="12" r="1" transform="rotate(90 20 12)"/><circle cx="4" cy="20" r="1" transform="rotate(90 4 20)"/><circle cx="12" cy="20" r="1" transform="rotate(90 12 20)"/><circle cx="20" cy="20" r="1" transform="rotate(90 20 20)"/></svg>',
      click: function (event) {
        event.stopPropagation();

        const thumbs = this.fancybox.plugins.Thumbs;

        if (thumbs) {
          thumbs.toggle();
        }
      },
    },
    close: {
      type: "button",
      label: "CLOSE",
      class: "fancybox__button--close",
      html: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" tabindex="-1"><path d="M20 20L4 4m16 0L4 20"></path></svg>',
      tabindex: 1,
      click: function (event) {
        event.stopPropagation();
        event.preventDefault();

        this.fancybox.close();
      },
    },
  },

  // What toolbar items to display
  display: ["counter", "zoom", "slideshow", "fullscreen", "thumbs", "close"],

  // Only create a toolbar item if there is at least one image in the group
  autoEnable: true,
};

class Toolbar {
  constructor(fancybox) {
    this.fancybox = fancybox;

    this.$container = null;
    this.state = "init";

    for (const methodName of [
      "onInit",
      "onPrepare",
      "onDone",
      "onKeydown",
      "onClosing",
      "onChange",
      "onSettle",
      "onRefresh",
    ]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.events = {
      init: this.onInit,
      prepare: this.onPrepare,
      done: this.onDone,
      keydown: this.onKeydown,
      closing: this.onClosing,

      // Clear Slideshow when user strts to change current slide
      "Carousel.change": this.onChange,

      // Set timer after carousel changes current slide; deactive if last slide is reached
      "Carousel.settle": this.onSettle,

      // Deactivate Slideshow on user interaction
      "Carousel.Panzoom.touchStart": () => this.onRefresh(),

      "Image.startAnimation": (fancybox, slide) => this.onRefresh(slide),
      "Image.afterUpdate": (fancybox, slide) => this.onRefresh(slide),
    };
  }

  onInit() {
    // Disable self if current group does not contain at least one image
    if (this.fancybox.option("Toolbar.autoEnable")) {
      let hasImage = false;

      for (const item of this.fancybox.items) {
        if (item.type === "image") {
          hasImage = true;
          break;
        }
      }

      if (!hasImage) {
        this.state = "disabled";
        return;
      }
    }

    // Disable the creation of a close button, if one exists in the toolbar
    for (const key of this.fancybox.option("Toolbar.display")) {
      const id = (0,_shared_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_0__.isPlainObject)(key) ? key.id : key;

      if (id === "close") {
        this.fancybox.options.closeButton = false;

        break;
      }
    }
  }

  onPrepare() {
    // Skip if disabled
    if (this.state !== "init") {
      return;
    }

    this.build();

    this.update();

    this.Slideshow = new _shared_utils_Slideshow_js__WEBPACK_IMPORTED_MODULE_3__.Slideshow(this.fancybox);

    if (!this.fancybox.Carousel.prevPage) {
      if (this.fancybox.option("slideshow.autoStart")) {
        this.Slideshow.activate();
      }

      if (this.fancybox.option("fullscreen.autoStart") && !_shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.element()) {
        try {
          _shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.activate(this.fancybox.$container);
        } catch (error) {}
      }
    }
  }

  onFsChange() {
    window.scrollTo(_shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.pageXOffset, _shared_utils_Fullscreen_js__WEBPACK_IMPORTED_MODULE_2__.Fullscreen.pageYOffset);
  }

  onSettle() {
    if (this.Slideshow && this.Slideshow.isActive()) {
      if (
        this.fancybox.getSlide().index === this.fancybox.Carousel.slides.length - 1 &&
        !this.fancybox.option("infinite")
      ) {
        this.Slideshow.deactivate();
      } else if (this.fancybox.getSlide().state === "done") {
        this.Slideshow.setTimer();
      }
    }
  }

  onChange() {
    this.update();

    if (this.Slideshow && this.Slideshow.isActive()) {
      this.Slideshow.clearTimer();
    }
  }

  onDone(fancybox, slide) {
    if (slide.index === fancybox.getSlide().index) {
      this.update();

      if (this.Slideshow && this.Slideshow.isActive()) {
        if (!this.fancybox.option("infinite") && slide.index === this.fancybox.Carousel.slides.length - 1) {
          this.Slideshow.deactivate();
        } else {
          this.Slideshow.setTimer();
        }
      }
    }
  }

  onRefresh(slide) {
    if (!slide || slide.index === this.fancybox.getSlide().index) {
      this.update();

      if (this.Slideshow && this.Slideshow.isActive() && (!slide || slide.state === "done")) {
        this.Slideshow.deactivate();
      }
    }
  }

  onKeydown(fancybox, key, event) {
    if (key === " ") {
      this.Slideshow.toggle();

      event.preventDefault();
    }
  }

  onClosing() {
    if (this.Slideshow) {
      this.Slideshow.deactivate();
    }

    document.removeEventListener("fullscreenchange", this.onFsChange);
  }

  /**
   * Create link, button or `div` element for the toolbar
   * @param {Object} obj
   * @returns HTMLElement
   */
  createElement(obj) {
    let $el;

    if (obj.type === "div") {
      $el = document.createElement("div");
    } else {
      $el = document.createElement(obj.type === "link" ? "a" : "button");
      $el.classList.add("carousel__button");
    }

    $el.innerHTML = obj.html;

    $el.setAttribute("tabindex", obj.tabindex || 0);

    if (obj.class) {
      $el.classList.add(...obj.class.split(" "));
    }

    if (obj.label) {
      $el.setAttribute("title", this.fancybox.localize(`{{${obj.label}}}`));
    }

    if (obj.click) {
      $el.addEventListener("click", obj.click.bind(this));
    }

    if (obj.id === "prev") {
      $el.setAttribute("data-fancybox-prev", "");
    }

    if (obj.id === "next") {
      $el.setAttribute("data-fancybox-next", "");
    }

    return $el;
  }

  /**
   * Create all DOM elements
   */
  build() {
    this.cleanup();

    const all_items = this.fancybox.option("Toolbar.items");
    const all_groups = [
      {
        position: "left",
        items: [],
      },
      {
        position: "center",
        items: [],
      },
      {
        position: "right",
        items: [],
      },
    ];

    const thumbs = this.fancybox.plugins.Thumbs;

    // 1st step - group toolbar elements by position
    for (const key of this.fancybox.option("Toolbar.display")) {
      let id, item;

      if ((0,_shared_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_0__.isPlainObject)(key)) {
        id = key.id;
        item = (0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_1__.extend)({}, all_items[id], key);
      } else {
        id = key;
        item = all_items[id];
      }

      if (["counter", "next", "prev", "slideshow"].includes(id) && this.fancybox.items.length < 2) {
        continue;
      }

      if (id === "fullscreen") {
        if (!document.fullscreenEnabled || window.fullScreen) {
          continue;
        }

        document.addEventListener("fullscreenchange", this.onFsChange);
      }

      if (id === "thumbs" && (!thumbs || thumbs.state === "disabled")) {
        continue;
      }

      if (!item) {
        continue;
      }

      let position = item.position || "right";

      let group = all_groups.find((obj) => obj.position === position);

      if (group) {
        group.items.push(item);
      }
    }

    // 2st step - create DOM elements
    const $container = document.createElement("div");
    $container.classList.add("fancybox__toolbar");

    for (const group of all_groups) {
      if (group.items.length) {
        const $wrap = document.createElement("div");
        $wrap.classList.add("fancybox__toolbar__items");
        $wrap.classList.add(`fancybox__toolbar__items--${group.position}`);

        for (const obj of group.items) {
          $wrap.appendChild(this.createElement(obj));
        }

        $container.appendChild($wrap);
      }
    }

    // Add toolbar container to DOM
    this.fancybox.$carousel.parentNode.insertBefore($container, this.fancybox.$carousel);

    this.$container = $container;
  }

  /**
   * Update element state depending on index of current slide
   */
  update() {
    const slide = this.fancybox.getSlide();
    const idx = slide.index;
    const cnt = this.fancybox.items.length;

    // Download links
    // ====
    const src = slide.downloadSrc || (slide.type === "image" && !slide.error ? slide.src : null);

    for (const $el of this.fancybox.$container.querySelectorAll("a.fancybox__button--download")) {
      if (src) {
        $el.removeAttribute("disabled");

        $el.setAttribute("href", src);
        $el.setAttribute("download", src);
        $el.setAttribute("target", "_blank");
      } else {
        $el.setAttribute("disabled", "");

        $el.removeAttribute("href");
        $el.removeAttribute("download");
      }
    }

    // Zoom buttons
    // ===
    const panzoom = slide.Panzoom;
    const canZoom = panzoom && panzoom.option("maxScale") > panzoom.option("baseScale");

    for (const $el of this.fancybox.$container.querySelectorAll(".fancybox__button--zoom")) {
      if (canZoom) {
        $el.removeAttribute("disabled");
      } else {
        $el.setAttribute("disabled", "");
      }
    }

    // Counter
    // ====
    for (const $el of this.fancybox.$container.querySelectorAll("[data-fancybox-index]")) {
      $el.innerHTML = slide.index + 1;
    }

    for (const $el of this.fancybox.$container.querySelectorAll("[data-fancybox-count]")) {
      $el.innerHTML = cnt;
    }

    // Disable prev/next links if gallery is not infinite and reached start/end
    if (!this.fancybox.option("infinite")) {
      for (const $el of this.fancybox.$container.querySelectorAll("[data-fancybox-prev]")) {
        if (idx === 0) {
          $el.setAttribute("disabled", "");
        } else {
          $el.removeAttribute("disabled");
        }
      }

      for (const $el of this.fancybox.$container.querySelectorAll("[data-fancybox-next]")) {
        if (idx === cnt - 1) {
          $el.setAttribute("disabled", "");
        } else {
          $el.removeAttribute("disabled");
        }
      }
    }
  }

  cleanup() {
    if (this.Slideshow && this.Slideshow.isActive()) {
      this.Slideshow.clearTimer();
    }

    if (this.$container) {
      this.$container.remove();
    }

    this.$container = null;
  }

  attach() {
    this.fancybox.on(this.events);
  }

  detach() {
    this.fancybox.off(this.events);

    this.cleanup();
  }
}

// Expose defaults
Toolbar.defaults = defaults;


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/index.js":
/*!******************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Fancybox/plugins/index.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Plugins": () => (/* binding */ Plugins)
/* harmony export */ });
/* harmony import */ var _ScrollLock_ScrollLock_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ScrollLock/ScrollLock.js */ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/ScrollLock/ScrollLock.js");
/* harmony import */ var _Thumbs_Thumbs_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Thumbs/Thumbs.js */ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/Thumbs/Thumbs.js");
/* harmony import */ var _Html_Html_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Html/Html.js */ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/Html/Html.js");
/* harmony import */ var _Image_Image_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./Image/Image.js */ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/Image/Image.js");
/* harmony import */ var _Hash_Hash_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./Hash/Hash.js */ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/Hash/Hash.js");
/* harmony import */ var _Toolbar_Toolbar_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./Toolbar/Toolbar.js */ "./node_modules/@fancyapps/ui/src/Fancybox/plugins/Toolbar/Toolbar.js");







const Plugins = {
  ScrollLock: _ScrollLock_ScrollLock_js__WEBPACK_IMPORTED_MODULE_0__.ScrollLock,
  Thumbs: _Thumbs_Thumbs_js__WEBPACK_IMPORTED_MODULE_1__.Thumbs,
  Html: _Html_Html_js__WEBPACK_IMPORTED_MODULE_2__.Html,
  Toolbar: _Toolbar_Toolbar_js__WEBPACK_IMPORTED_MODULE_5__.Toolbar,
  Image: _Image_Image_js__WEBPACK_IMPORTED_MODULE_3__.Image,
  Hash: _Hash_Hash_js__WEBPACK_IMPORTED_MODULE_4__.Hash,
};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Panzoom/Panzoom.js":
/*!***********************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Panzoom/Panzoom.js ***!
  \***********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Panzoom": () => (/* binding */ Panzoom)
/* harmony export */ });
/* harmony import */ var _shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../shared/utils/extend.js */ "./node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../shared/utils/round.js */ "./node_modules/@fancyapps/ui/src/shared/utils/round.js");
/* harmony import */ var _shared_utils_ResizeObserver_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../shared/utils/ResizeObserver.js */ "./node_modules/@fancyapps/ui/src/shared/utils/ResizeObserver.js");
/* harmony import */ var _shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../shared/utils/PointerTracker.js */ "./node_modules/@fancyapps/ui/src/shared/utils/PointerTracker.js");
/* harmony import */ var _shared_utils_isScrollable_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../shared/utils/isScrollable.js */ "./node_modules/@fancyapps/ui/src/shared/utils/isScrollable.js");
/* harmony import */ var _shared_utils_getTextNodeFromPoint_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../shared/utils/getTextNodeFromPoint.js */ "./node_modules/@fancyapps/ui/src/shared/utils/getTextNodeFromPoint.js");
/* harmony import */ var _shared_utils_getDimensions_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../shared/utils/getDimensions.js */ "./node_modules/@fancyapps/ui/src/shared/utils/getDimensions.js");
/* harmony import */ var _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../shared/Base/Base.js */ "./node_modules/@fancyapps/ui/src/shared/Base/Base.js");
/* harmony import */ var _plugins_index_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./plugins/index.js */ "./node_modules/@fancyapps/ui/src/Panzoom/plugins/index.js");















const defaults = {
  // Enable touch guestures
  touch: true,

  // Enable zooming
  zoom: true,

  // Enable pinch gesture to zoom in/out using two fingers
  pinchToZoom: true,

  // Disable dragging if scale level is equal to value of `baseScale` option
  panOnlyZoomed: false,

  // Lock axis while dragging,
  // possible values: false | "x" | "y" | "xy"
  lockAxis: false,

  // * All friction values are inside [0, 1) interval,
  // * where 0 would change instantly, but 0.99 would update extremely slowly

  // Friction while panning/dragging
  friction: 0.64,

  // Friction while decelerating after drag end
  decelFriction: 0.88,

  // Friction while scaling
  zoomFriction: 0.74,

  // Bounciness after hitting the edge
  bounceForce: 0.2,

  // Initial scale level
  baseScale: 1,

  // Minimum scale level
  minScale: 1,

  // Maximum scale level
  maxScale: 2,

  // Default scale step while zooming
  step: 0.5,

  // Allow to select text,
  // if enabled, dragging will be disabled when text selection is detected
  textSelection: false,

  // Add `click` event listener,
  // possible values: true | false | function | "toggleZoom"
  click: "toggleZoom",

  // Add `wheel` event listener,
  // possible values: true | false | function |  "zoom"
  wheel: "zoom",

  // Value for zoom on mouse wheel
  wheelFactor: 42,

  // Number of wheel events after which it should stop preventing default behaviour of mouse wheel
  wheelLimit: 5,

  // Class name added to `$viewport` element to indicate if content is draggable
  draggableClass: "is-draggable",

  // Class name added to `$viewport` element to indicate that user is currently dragging
  draggingClass: "is-dragging",

  // Content will be scaled by this number,
  // this can also be a function which should return a number, for example:
  // ratio: function() { return 1 / (window.devicePixelRatio || 1) }
  ratio: 1,
};

class Panzoom extends _shared_Base_Base_js__WEBPACK_IMPORTED_MODULE_7__.Base {
  /**
   * Panzoom constructor
   * @constructs Panzoom
   * @param {HTMLElement} $viewport Panzoom container
   * @param {Object} [options] Options for Panzoom
   */
  constructor($container, options = {}) {
    super((0,_shared_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(true, {}, defaults, options));

    this.state = "init";

    this.$container = $container;

    // Bind event handlers for referencability
    for (const methodName of ["onLoad", "onWheel", "onClick"]) {
      this[methodName] = this[methodName].bind(this);
    }

    this.initLayout();

    this.resetValues();

    this.attachPlugins(Panzoom.Plugins);

    this.trigger("init");

    this.updateMetrics();

    this.attachEvents();

    this.trigger("ready");

    if (this.option("centerOnStart") === false) {
      this.handleCursor();

      this.state = "ready";
    } else {
      this.panTo({
        friction: 0,
      });
    }
  }

  /**
   * Create references to container, viewport and content elements
   */
  initLayout() {
    const $container = this.$container;

    // Make sure content element exists
    if (!($container instanceof HTMLElement)) {
      throw new Error("Panzoom: Container not found");
    }

    const $content = this.option("content") || $container.querySelector(".panzoom__content");

    // Make sure content element exists
    if (!$content) {
      throw new Error("Panzoom: Content not found");
    }

    this.$content = $content;

    let $viewport = this.option("viewport") || $container.querySelector(".panzoom__viewport");

    if (!$viewport && this.option("wrapInner") !== false) {
      $viewport = document.createElement("div");
      $viewport.classList.add("panzoom__viewport");

      $viewport.append(...$container.childNodes);

      $container.appendChild($viewport);
    }

    this.$viewport = $viewport || $content.parentNode;
  }

  /**
   * Restore instance variables to default values
   */
  resetValues() {
    this.updateRate = this.option("updateRate", /iPhone|iPad|iPod|Android/i.test(navigator.userAgent) ? 250 : 24);

    this.container = {
      width: 0,
      height: 0,
    };

    this.viewport = {
      width: 0,
      height: 0,
    };

    this.content = {
      // Full content dimensions (naturalWidth/naturalHeight for images)
      origHeight: 0,
      origWidth: 0,

      // Current dimensions of the content
      width: 0,
      height: 0,

      // Current position; these values reflect CSS `transform` value
      x: this.option("x", 0),
      y: this.option("y", 0),

      // Current scale; does not reflect CSS `transform` value
      scale: this.option("baseScale"),
    };

    // End values of current pan / zoom animation
    this.transform = {
      x: 0,
      y: 0,
      scale: 1,
    };

    this.resetDragPosition();
  }

  /**
   * Handle `load` event
   * @param {Event} event
   */
  onLoad(event) {
    this.updateMetrics();

    this.panTo({ scale: this.option("baseScale"), friction: 0 });

    this.trigger("load", event);
  }

  /**
   * Handle `click` event
   * @param {Event} event
   */
  onClick(event) {
    if (event.defaultPrevented) {
      return;
    }

    // Skip if text is selected
    if (this.option("textSelection") && window.getSelection().toString().length) {
      event.stopPropagation();
      return;
    }

    const rect = this.$content.getClientRects()[0];

    // Check if container has changed position (for example, when current instance is inside another one)
    if (this.state !== "ready") {
      if (
        this.dragPosition.midPoint ||
        Math.abs(rect.top - this.dragStart.rect.top) > 1 ||
        Math.abs(rect.left - this.dragStart.rect.left) > 1
      ) {
        event.preventDefault();
        event.stopPropagation();

        return;
      }
    }

    if (this.trigger("click", event) === false) {
      return;
    }

    if (this.option("zoom") && this.option("click") === "toggleZoom") {
      event.preventDefault();
      event.stopPropagation();

      this.zoomWithClick(event);
    }
  }

  /**
   * Handle `wheel` event
   * @param {Event} event
   */
  onWheel(event) {
    if (this.trigger("wheel", event) === false) {
      return;
    }

    if (this.option("zoom") && this.option("wheel")) {
      this.zoomWithWheel(event);
    }
  }

  /**
   * Change zoom level depending on scroll direction
   * @param {Event} event `wheel` event
   */
  zoomWithWheel(event) {
    if (this.changedDelta === undefined) {
      this.changedDelta = 0;
    }

    const delta = Math.max(-1, Math.min(1, -event.deltaY || -event.deltaX || event.wheelDelta || -event.detail));
    const scale = this.content.scale;

    let newScale = (scale * (100 + delta * this.option("wheelFactor"))) / 100;

    if (
      (delta < 0 && Math.abs(scale - this.option("minScale")) < 0.01) ||
      (delta > 0 && Math.abs(scale - this.option("maxScale")) < 0.01)
    ) {
      this.changedDelta += Math.abs(delta);
      newScale = scale;
    } else {
      this.changedDelta = 0;
      newScale = Math.max(Math.min(newScale, this.option("maxScale")), this.option("minScale"));
    }

    if (this.changedDelta > this.option("wheelLimit")) {
      return;
    }

    event.preventDefault();

    if (newScale === scale) {
      return;
    }

    const rect = this.$content.getBoundingClientRect();

    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    this.zoomTo(newScale, { x, y });
  }

  /**
   * Change zoom level depending on click coordinates
   * @param {Event} event `click` event
   */
  zoomWithClick(event) {
    const rect = this.$content.getClientRects()[0];

    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    this.toggleZoom({ x, y });
  }

  /**
   * Attach load, wheel and click event listeners, initialize `resizeObserver` and `PointerTracker`
   */
  attachEvents() {
    this.$content.addEventListener("load", this.onLoad);

    this.$container.addEventListener("wheel", this.onWheel, { passive: false });
    this.$container.addEventListener("click", this.onClick, { passive: false });

    this.initObserver();

    const pointerTracker = new _shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_3__.PointerTracker(this.$container, {
      start: (pointer, event) => {
        if (!this.option("touch")) {
          return false;
        }

        if (this.velocity.scale < 0) {
          return;
        }

        if (!pointerTracker.currentPointers.length) {
          const ignoreClickedElement =
            ["BUTTON", "TEXTAREA", "OPTION", "INPUT", "SELECT", "VIDEO"].indexOf(event.target.nodeName) !== -1;

          if (ignoreClickedElement) {
            return false;
          }

          // Allow text selection
          if (this.option("textSelection") && (0,_shared_utils_getTextNodeFromPoint_js__WEBPACK_IMPORTED_MODULE_5__.getTextNodeFromPoint)(event.target, event.clientX, event.clientY)) {
            return false;
          }
          // Allow scrolling
          if ((0,_shared_utils_isScrollable_js__WEBPACK_IMPORTED_MODULE_4__.isScrollable)(event.target)) {
            return false;
          }
        }

        if (this.trigger("touchStart", event) === false) {
          return false;
        }

        this.state = "pointerdown";

        this.resetDragPosition();

        this.dragPosition.midPoint = null;
        this.dragPosition.time = Date.now();

        return true;
      },
      move: (previousPointers, currentPointers, event) => {
        if (this.state !== "pointerdown") {
          return;
        }

        if (this.trigger("touchMove", event) == false) {
          event.preventDefault();
          return;
        }

        // Disable touch action if current zoom level is below base level
        if (
          currentPointers.length < 2 &&
          this.transform.scale === this.option("baseScale") &&
          this.option("panOnlyZoomed") == true
        ) {
          return;
        }

        if (currentPointers.length > 1 && (!this.option("zoom") || this.option("pinchToZoom") === false)) {
          return;
        }

        event.preventDefault();
        event.stopPropagation();

        const prevMidpoint = (0,_shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_3__.getMidpoint)(previousPointers[0], previousPointers[1]);
        const newMidpoint = (0,_shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_3__.getMidpoint)(currentPointers[0], currentPointers[1]);

        const panX = newMidpoint.clientX - prevMidpoint.clientX;
        const panY = newMidpoint.clientY - prevMidpoint.clientY;

        const prevDistance = (0,_shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_3__.getDistance)(previousPointers[0], previousPointers[1]);
        const newDistance = (0,_shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_3__.getDistance)(currentPointers[0], currentPointers[1]);

        const scaleDiff = prevDistance ? newDistance / prevDistance : 1;

        this.dragOffset.x += panX;
        this.dragOffset.y += panY;

        this.dragOffset.scale *= scaleDiff;

        this.dragOffset.time = Date.now() - this.dragPosition.time;

        const axisToLock = this.dragStart.scale === 1 && this.option("lockAxis");

        if (axisToLock && !this.lockAxis) {
          if (Math.abs(this.dragOffset.x) < 6 && Math.abs(this.dragOffset.y) < 6) {
            return;
          }

          if (axisToLock === "xy") {
            const angle = Math.abs((Math.atan2(this.dragOffset.y, this.dragOffset.x) * 180) / Math.PI);

            this.lockAxis = angle > 45 && angle < 135 ? "y" : "x";
          } else {
            this.lockAxis = axisToLock;
          }
        }

        if (this.lockAxis) {
          this.dragOffset[this.lockAxis === "x" ? "y" : "x"] = 0;
        }

        this.$container.classList.add(this.option("draggingClass"));

        if (!(this.transform.scale === this.option("baseScale") && this.lockAxis === "y")) {
          this.dragPosition.x = this.dragStart.x + this.dragOffset.x;
        }

        if (!(this.transform.scale === this.option("baseScale") && this.lockAxis === "x")) {
          this.dragPosition.y = this.dragStart.y + this.dragOffset.y;
        }

        this.dragPosition.scale = this.dragStart.scale * this.dragOffset.scale;

        if (currentPointers.length > 1) {
          const startPoint = (0,_shared_utils_PointerTracker_js__WEBPACK_IMPORTED_MODULE_3__.getMidpoint)(pointerTracker.startPointers[0], pointerTracker.startPointers[1]);

          const xPos = startPoint.clientX - this.dragStart.rect.x;
          const yPos = startPoint.clientY - this.dragStart.rect.y;

          const { deltaX, deltaY } = this.getZoomDelta(this.content.scale * this.dragOffset.scale, xPos, yPos);

          this.dragPosition.x -= deltaX;
          this.dragPosition.y -= deltaY;

          this.dragPosition.midPoint = newMidpoint;
        }

        this.setDragResistance();

        // Update final position
        this.transform = {
          x: this.dragPosition.x,
          y: this.dragPosition.y,
          scale: this.dragPosition.scale,
        };

        this.startAnimation();
      },
      end: (pointer, event) => {
        if (this.state !== "pointerdown") {
          return;
        }

        this._dragOffset = { ...this.dragOffset };

        if (pointerTracker.currentPointers.length) {
          this.resetDragPosition();

          return;
        }

        this.state = "decel";
        this.friction = this.option("decelFriction");

        this.recalculateTransform();

        this.$container.classList.remove(this.option("draggingClass"));

        if (this.trigger("touchEnd", event) === false) {
          return;
        }

        if (this.state !== "decel") {
          return;
        }

        // * Check if scaled content past limits

        // Below minimum
        const minScale = this.option("minScale");

        if (this.transform.scale < minScale) {
          this.zoomTo(minScale, { friction: 0.64 });

          return;
        }

        // Exceed maximum
        const maxScale = this.option("maxScale");

        if (this.transform.scale - maxScale > 0.01) {
          const last = this.dragPosition.midPoint || pointer;
          const rect = this.$content.getClientRects()[0];

          this.zoomTo(maxScale, {
            friction: 0.64,
            x: last.clientX - rect.left,
            y: last.clientY - rect.top,
          });

          return;
        }
      },
    });

    this.pointerTracker = pointerTracker;
  }

  initObserver() {
    if (this.resizeObserver) {
      return;
    }

    this.resizeObserver = new _shared_utils_ResizeObserver_js__WEBPACK_IMPORTED_MODULE_2__.ResizeObserver(() => {
      if (this.updateTimer) {
        return;
      }

      this.updateTimer = setTimeout(() => {
        const rect = this.$container.getBoundingClientRect();

        if (!(rect.width && rect.height)) {
          this.updateTimer = null;
          return;
        }

        // Check to see if there are any changes
        if (Math.abs(rect.width - this.container.width) > 1 || Math.abs(rect.height - this.container.height) > 1) {
          if (this.isAnimating()) {
            this.endAnimation();
          }

          this.updateMetrics();

          this.panTo({
            x: this.content.x,
            y: this.content.y,
            scale: this.option("baseScale"),
            friction: 0,
          });
        }

        this.updateTimer = null;
      }, this.updateRate);
    });

    this.resizeObserver.observe(this.$container);
  }

  /**
   * Restore drag related variables to default values
   */
  resetDragPosition() {
    this.lockAxis = null;
    this.friction = this.option("friction");

    this.velocity = {
      x: 0,
      y: 0,
      scale: 0,
    };

    const { x, y, scale } = this.content;

    this.dragStart = {
      rect: this.$content.getBoundingClientRect(),
      x,
      y,
      scale,
    };

    this.dragPosition = {
      ...this.dragPosition,
      x,
      y,
      scale,
    };

    this.dragOffset = {
      x: 0,
      y: 0,
      scale: 1,
      time: 0,
    };
  }

  /**
   * Trigger update events before/after resizing content and viewport
   */
  updateMetrics(silently) {
    if (silently !== true) {
      this.trigger("beforeUpdate");
    }

    const $container = this.$container;
    const $content = this.$content;
    const $viewport = this.$viewport;

    const contentIsImage = this.$content instanceof HTMLImageElement;
    const contentIsZoomable = this.option("zoom");
    const shouldResizeParent = this.option("resizeParent", contentIsZoomable);

    let origWidth = (0,_shared_utils_getDimensions_js__WEBPACK_IMPORTED_MODULE_6__.getFullWidth)(this.$content);
    let origHeight = (0,_shared_utils_getDimensions_js__WEBPACK_IMPORTED_MODULE_6__.getFullHeight)(this.$content);

    Object.assign($content.style, {
      width: "",
      height: "",
      maxWidth: "",
      maxHeight: "",
    });

    if (shouldResizeParent) {
      Object.assign($viewport.style, { width: "", height: "" });
    }

    const ratio = this.option("ratio");

    origWidth = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(origWidth * ratio);
    origHeight = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(origHeight * ratio);

    let width = origWidth;
    let height = origHeight;

    const contentRect = $content.getBoundingClientRect();
    const viewportRect = $viewport.getBoundingClientRect();

    const containerRect = $viewport == $container ? viewportRect : $container.getBoundingClientRect();

    this.viewport = { ...this.viewport, width: viewportRect.width, height: viewportRect.height };

    var styles = window.getComputedStyle($viewport);

    this.viewport.width -= parseFloat(styles.paddingLeft) + parseFloat(styles.paddingRight);
    this.viewport.height -= parseFloat(styles.paddingTop) + parseFloat(styles.paddingBottom);

    if (contentIsZoomable) {
      if (Math.abs(origWidth - contentRect.width) > 0.1 || Math.abs(origHeight - contentRect.height) > 0.1) {
        const rez = (0,_shared_utils_getDimensions_js__WEBPACK_IMPORTED_MODULE_6__.calculateAspectRatioFit)(
          origWidth,
          origHeight,
          Math.min(origWidth, contentRect.width),
          Math.min(origHeight, contentRect.height)
        );

        width = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(rez.width);
        height = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(rez.height);
      }

      Object.assign($content.style, {
        width: `${width}px`,
        height: `${height}px`,
        transform: "",
      });
    }

    if (shouldResizeParent) {
      Object.assign($viewport.style, { width: `${width}px`, height: `${height}px` });

      this.viewport = { ...this.viewport, width, height };
    }

    if (contentIsImage && contentIsZoomable && typeof this.options.maxScale !== "function") {
      const maxScale = this.option("maxScale");

      this.options.maxScale = function () {
        return this.content.origWidth > 0 && this.content.fitWidth > 0
          ? this.content.origWidth / this.content.fitWidth
          : maxScale;
      };
    }

    this.content = {
      ...this.content,
      origWidth,
      origHeight,
      fitWidth: width,
      fitHeight: height,
      width,
      height,
      scale: 1,
      isZoomable: contentIsZoomable,
    };

    this.container = { width: containerRect.width, height: containerRect.height };

    if (silently !== true) {
      this.trigger("afterUpdate");
    }
  }

  /**
   * Increase zoom level
   * @param {Number} [step] Zoom ratio; `0.5` would increase scale from 1 to 1.5
   */
  zoomIn(step) {
    this.zoomTo(this.content.scale + (step || this.option("step")));
  }

  /**
   * Decrease zoom level
   * @param {Number} [step] Zoom ratio; `0.5` would decrease scale from 1.5 to 1
   */
  zoomOut(step) {
    this.zoomTo(this.content.scale - (step || this.option("step")));
  }

  /**
   * Toggles zoom level between max and base levels
   * @param {Object} [options] Additional options
   */
  toggleZoom(props = {}) {
    const maxScale = this.option("maxScale");
    const baseScale = this.option("baseScale");

    const scale = this.content.scale > baseScale + (maxScale - baseScale) * 0.5 ? baseScale : maxScale;

    this.zoomTo(scale, props);
  }

  /**
   * Animate to given zoom level
   * @param {Number} scale New zoom level
   * @param {Object} [options] Additional options
   */
  zoomTo(scale = this.option("baseScale"), { x = null, y = null } = {}) {
    scale = Math.max(Math.min(scale, this.option("maxScale")), this.option("minScale"));

    // Adjust zoom position
    const currentScale = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.scale / (this.content.width / this.content.fitWidth), 10000000);

    if (x === null) {
      x = this.content.width * currentScale * 0.5;
    }

    if (y === null) {
      y = this.content.height * currentScale * 0.5;
    }

    const { deltaX, deltaY } = this.getZoomDelta(scale, x, y);

    x = this.content.x - deltaX;
    y = this.content.y - deltaY;

    this.panTo({ x, y, scale, friction: this.option("zoomFriction") });
  }

  /**
   * Calculate difference for top/left values if content would scale at given coordinates
   * @param {Number} scale
   * @param {Number} x
   * @param {Number} y
   * @returns {Object}
   */
  getZoomDelta(scale, x = 0, y = 0) {
    const currentWidth = this.content.fitWidth * this.content.scale;
    const currentHeight = this.content.fitHeight * this.content.scale;

    const percentXInCurrentBox = x > 0 && currentWidth ? x / currentWidth : 0;
    const percentYInCurrentBox = y > 0 && currentHeight ? y / currentHeight : 0;

    const nextWidth = this.content.fitWidth * scale;
    const nextHeight = this.content.fitHeight * scale;

    const deltaX = (nextWidth - currentWidth) * percentXInCurrentBox;
    const deltaY = (nextHeight - currentHeight) * percentYInCurrentBox;

    return { deltaX, deltaY };
  }

  /**
   * Animate to given positon and/or zoom level
   * @param {Object} [options] Additional options
   */
  panTo({
    x = this.content.x,
    y = this.content.y,
    scale,
    friction = this.option("friction"),
    ignoreBounds = false,
  } = {}) {
    scale = scale || this.content.scale || 1;

    if (!ignoreBounds) {
      const { boundX, boundY } = this.getBounds(scale);

      if (boundX) {
        x = Math.max(Math.min(x, boundX.to), boundX.from);
      }

      if (boundY) {
        y = Math.max(Math.min(y, boundY.to), boundY.from);
      }
    }

    this.friction = friction;

    this.transform = {
      x,
      y,
      scale,
    };

    if (friction) {
      this.state = "panning";

      this.velocity = {
        x: (1 / this.friction - 1) * (x - this.content.x),
        y: (1 / this.friction - 1) * (y - this.content.y),
        scale: (1 / this.friction - 1) * (scale - this.content.scale),
      };

      this.startAnimation();
    } else {
      this.endAnimation();
    }
  }

  /**
   * Start animation loop
   */
  startAnimation() {
    if (!this.rAF) {
      this.trigger("startAnimation");
    } else {
      cancelAnimationFrame(this.rAF);
    }

    this.rAF = requestAnimationFrame(() => this.animate());
  }

  /**
   * Process animation frame
   */
  animate() {
    this.setEdgeForce();
    this.setDragForce();

    this.velocity.x *= this.friction;
    this.velocity.y *= this.friction;

    this.velocity.scale *= this.friction;

    this.content.x += this.velocity.x;
    this.content.y += this.velocity.y;

    this.content.scale += this.velocity.scale;

    if (this.isAnimating()) {
      this.setTransform();
    } else if (this.state !== "pointerdown") {
      this.endAnimation();

      this.trigger("endAnimation");

      return;
    }

    this.rAF = requestAnimationFrame(() => this.animate());
  }

  /**
   * Calculate boundaries
   */
  getBounds(scale) {
    let boundX = this.boundX;
    let boundY = this.boundY;

    if (boundX !== undefined && boundY !== undefined) {
      return { boundX, boundY };
    }

    boundX = { from: 0, to: 0 };
    boundY = { from: 0, to: 0 };

    scale = scale || this.transform.scale;

    const fitWidth = this.content.fitWidth;
    const fitHeight = this.content.fitHeight;

    const width = fitWidth * scale;
    const height = fitHeight * scale;

    const viewportWidth = this.viewport.width;
    const viewportHeight = this.viewport.height;

    if (fitWidth <= viewportWidth) {
      const deltaX1 = (viewportWidth - width) * 0.5;
      const deltaX2 = (width - fitWidth) * 0.5;

      boundX.from = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(deltaX1 - deltaX2);
      boundX.to = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(deltaX1 + deltaX2);
    } else {
      boundX.from = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(viewportWidth - width);
    }

    if (fitHeight <= viewportHeight) {
      const deltaY1 = (viewportHeight - height) * 0.5;
      const deltaY2 = (height - fitHeight) * 0.5;

      boundY.from = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(deltaY1 - deltaY2);
      boundY.to = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(deltaY1 + deltaY2);
    } else {
      boundY.from = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(viewportHeight - width);
    }

    return { boundX, boundY };
  }

  /**
   * Change animation velocity if boundary is reached
   */
  setEdgeForce() {
    if (this.state !== "decel") {
      return;
    }

    const bounceForce = this.option("bounceForce");

    const { boundX, boundY } = this.getBounds(Math.max(this.transform.scale, this.content.scale));

    let pastLeft, pastRight, pastTop, pastBottom;

    if (boundX) {
      pastLeft = this.content.x < boundX.from;
      pastRight = this.content.x > boundX.to;
    }

    if (boundY) {
      pastTop = this.content.y < boundY.from;
      pastBottom = this.content.y > boundY.to;
    }

    if (pastLeft || pastRight) {
      const bound = pastLeft ? boundX.from : boundX.to;
      const distance = bound - this.content.x;

      let force = distance * bounceForce;

      const restX = this.content.x + (this.velocity.x + force) / this.friction;

      if (restX >= boundX.from && restX <= boundX.to) {
        force += this.velocity.x;
      }

      this.velocity.x = force;

      this.recalculateTransform();
    }

    if (pastTop || pastBottom) {
      const bound = pastTop ? boundY.from : boundY.to;
      const distance = bound - this.content.y;

      let force = distance * bounceForce;

      const restY = this.content.y + (force + this.velocity.y) / this.friction;

      if (restY >= boundY.from && restY <= boundY.to) {
        force += this.velocity.y;
      }

      this.velocity.y = force;

      this.recalculateTransform();
    }
  }

  /**
   * Change dragging position if boundary is reached
   */
  setDragResistance() {
    if (this.state !== "pointerdown") {
      return;
    }

    const { boundX, boundY } = this.getBounds(this.dragPosition.scale);

    let pastLeft, pastRight, pastTop, pastBottom;

    if (boundX) {
      pastLeft = this.dragPosition.x < boundX.from;
      pastRight = this.dragPosition.x > boundX.to;
    }

    if (boundY) {
      pastTop = this.dragPosition.y < boundY.from;
      pastBottom = this.dragPosition.y > boundY.to;
    }

    if ((pastLeft || pastRight) && !(pastLeft && pastRight)) {
      const bound = pastLeft ? boundX.from : boundX.to;
      const distance = bound - this.dragPosition.x;

      this.dragPosition.x = bound - distance * 0.3;
    }

    if ((pastTop || pastBottom) && !(pastTop && pastBottom)) {
      const bound = pastTop ? boundY.from : boundY.to;
      const distance = bound - this.dragPosition.y;

      this.dragPosition.y = bound - distance * 0.3;
    }
  }

  /**
   * Set velocity to move content to drag position
   */
  setDragForce() {
    if (this.state === "pointerdown") {
      this.velocity.x = this.dragPosition.x - this.content.x;
      this.velocity.y = this.dragPosition.y - this.content.y;
      this.velocity.scale = this.dragPosition.scale - this.content.scale;
    }
  }

  /**
   * Update end values based on current velocity and friction;
   */
  recalculateTransform() {
    this.transform.x = this.content.x + this.velocity.x / (1 / this.friction - 1);
    this.transform.y = this.content.y + this.velocity.y / (1 / this.friction - 1);
    this.transform.scale = this.content.scale + this.velocity.scale / (1 / this.friction - 1);
  }

  /**
   * Check if content is currently animating
   * @returns {Boolean}
   */
  isAnimating() {
    return !!(
      this.friction &&
      (Math.abs(this.velocity.x) > 0.05 || Math.abs(this.velocity.y) > 0.05 || Math.abs(this.velocity.scale) > 0.05)
    );
  }

  /**
   * Set content `style.transform` value based on current animation frame
   */
  setTransform(final) {
    let x, y, scale;

    if (final) {
      x = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.transform.x);
      y = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.transform.y);

      scale = this.transform.scale;

      this.content = { ...this.content, x, y, scale };
    } else {
      x = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.x);
      y = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.y);

      scale = this.content.scale / (this.content.width / this.content.fitWidth);

      this.content = { ...this.content, x, y };
    }

    this.trigger("beforeTransform");

    x = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.x);
    y = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.y);

    if (final && this.option("zoom")) {
      let width;
      let height;

      width = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.fitWidth * scale);
      height = (0,_shared_utils_round_js__WEBPACK_IMPORTED_MODULE_1__.round)(this.content.fitHeight * scale);

      this.content.width = width;
      this.content.height = height;

      this.transform = { ...this.transform, width, height, scale };

      Object.assign(this.$content.style, {
        width: `${width}px`,
        height: `${height}px`,
        maxWidth: "none",
        maxHeight: "none",
        transform: `translate3d(${x}px, ${y}px, 0) scale(1)`,
      });
    } else {
      this.$content.style.transform = `translate3d(${x}px, ${y}px, 0) scale(${scale})`;
    }

    this.trigger("afterTransform");
  }

  /**
   * Stop animation loop
   */
  endAnimation() {
    cancelAnimationFrame(this.rAF);
    this.rAF = null;

    this.velocity = {
      x: 0,
      y: 0,
      scale: 0,
    };

    this.setTransform(true);

    this.state = "ready";

    this.handleCursor();
  }

  /**
   * Update the class name depending on whether the content is scaled
   */
  handleCursor() {
    const draggableClass = this.option("draggableClass");

    if (!draggableClass || !this.option("touch")) {
      return;
    }

    if (
      this.option("panOnlyZoomed") == true &&
      this.content.width <= this.content.fitWidth &&
      this.transform.scale <= this.option("baseScale")
    ) {
      this.$container.classList.remove(draggableClass);
    } else {
      this.$container.classList.add(draggableClass);
    }
  }

  /**
   * Remove observation and detach event listeners
   */
  detachEvents() {
    this.$content.removeEventListener("load", this.onLoad);

    this.$container.removeEventListener("wheel", this.onWheel, { passive: false });
    this.$container.removeEventListener("click", this.onClick, { passive: false });

    if (this.pointerTracker) {
      this.pointerTracker.stop();
      this.pointerTracker = null;
    }

    if (this.resizeObserver) {
      this.resizeObserver.disconnect();
      this.resizeObserver = null;
    }
  }

  /**
   * Clean up
   */
  destroy() {
    if (this.state === "destroy") {
      return;
    }

    this.state = "destroy";

    clearTimeout(this.updateTimer);
    this.updateTimer = null;

    cancelAnimationFrame(this.rAF);
    this.rAF = null;

    this.detachEvents();

    this.detachPlugins();

    this.resetDragPosition();
  }
}

// Expose version
Panzoom.version = "__VERSION__";

// Static properties are a recent addition that dont work in all browsers yet
Panzoom.Plugins = _plugins_index_js__WEBPACK_IMPORTED_MODULE_8__.Plugins;


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/Panzoom/plugins/index.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/Panzoom/plugins/index.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Plugins": () => (/* binding */ Plugins)
/* harmony export */ });
const Plugins = {};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/Base/Base.js":
/*!************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/Base/Base.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Base": () => (/* binding */ Base)
/* harmony export */ });
/* harmony import */ var _utils_extend_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../utils/extend.js */ "./node_modules/@fancyapps/ui/src/shared/utils/extend.js");
/* harmony import */ var _utils_resolve_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../utils/resolve.js */ "./node_modules/@fancyapps/ui/src/shared/utils/resolve.js");
/* harmony import */ var _utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../utils/isPlainObject.js */ "./node_modules/@fancyapps/ui/src/shared/utils/isPlainObject.js");




/**
 * Base class, all components inherit from this class
 */
class Base {
  /**
   * Base constructor
   * @param {Object} [options] - Options as `key: value` pairs
   */
  constructor(options = {}) {
    this.options = (0,_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)(true, {}, options);

    this.plugins = [];
    this.events = {};

    // * Prefill with initial events
    for (const type of ["on", "once"]) {
      for (const args of Object.entries(this.options[type] || {})) {
        this[type](...args);
      }
    }
  }

  /**
   * Retrieve option value by key, supports subkeys
   * @param {String} key Option name
   * @param {*} [fallback] Fallback value for non-existing key
   * @returns {*}
   */
  option(key, fallback) {
    // Make sure it is string
    key = String(key);

    let value = (0,_utils_resolve_js__WEBPACK_IMPORTED_MODULE_1__.resolve)(key, this.options);

    // Allow to have functions as options
    if (typeof value === "function") {
      value = value.call(this, key);
    }

    return value === undefined ? fallback : value;
  }

  /**
   * Simple l10n support - replaces object keys
   * found in template with corresponding values
   * @param {String} str String containing values to localize
   * @param {Array} params Substitute parameters
   * @returns {String}
   */
  localize(str, params = []) {
    return String(str).replace(/\{\{(\w+).?(\w+)?\}\}/g, (match, key, subkey) => {
      let rez = false;

      // Plugins have `Plugin.l10n.KEY`
      if (subkey) {
        rez = this.option(`${key[0] + key.toLowerCase().substring(1)}.l10n.${subkey}`);
      } else {
        rez = this.option(`l10n.${key}`);
      }

      if (!rez) {
        return key;
      }

      for (let index = 0; index < params.length; index++) {
        rez = rez.split(params[index][0]).join(params[index][1]);
      }

      return rez;
    });
  }

  /**
   * Subscribe to an event
   * @param {String} name
   * @param {Function} callback
   * @returns {Object}
   */
  on(name, callback) {
    if ((0,_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_2__.isPlainObject)(name)) {
      for (const args of Object.entries(name)) {
        this.on(...args);
      }

      return this;
    }

    String(name)
      .split(" ")
      .forEach((item) => {
        const listeners = (this.events[item] = this.events[item] || []);

        if (listeners.indexOf(callback) == -1) {
          listeners.push(callback);
        }
      });

    return this;
  }

  /**
   * Subscribe to an event only once
   * @param {String} name
   * @param {Function} callback
   * @returns {Object}
   */
  once(name, callback) {
    if ((0,_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_2__.isPlainObject)(name)) {
      for (const args of Object.entries(name)) {
        this.once(...args);
      }

      return this;
    }

    String(name)
      .split(" ")
      .forEach((item) => {
        const listener = (...details) => {
          this.off(item, listener);
          callback.call(this, this, ...details);
        };

        listener._ = callback;

        this.on(item, listener);
      });

    return this;
  }

  /**
   * Unsubscribe event with name and callback
   * @param {String} name
   * @param {Function} callback
   * @returns {Object}
   */
  off(name, callback) {
    if ((0,_utils_isPlainObject_js__WEBPACK_IMPORTED_MODULE_2__.isPlainObject)(name)) {
      for (const args of Object.entries(name)) {
        this.off(...args);
      }

      return;
    }

    name.split(" ").forEach((item) => {
      const listeners = this.events[item];

      if (!listeners || !listeners.length) {
        return this;
      }

      let index = -1;

      for (let i = 0, len = listeners.length; i < len; i++) {
        const listener = listeners[i];

        if (listener && (listener === callback || listener._ === callback)) {
          index = i;
          break;
        }
      }

      if (index != -1) {
        listeners.splice(index, 1);
      }
    });

    return this;
  }

  /**
   * Emit an event.
   * If present, `"*"` handlers are invoked after name-matched handlers.
   * @param {String} name
   * @param  {...any} details
   * @returns {Boolean}
   */
  trigger(name, ...details) {
    for (const listener of [...(this.events[name] || [])].slice()) {
      if (listener && listener.call(this, this, ...details) === false) {
        return false;
      }
    }

    // A wildcard "*" event type
    for (const listener of [...(this.events["*"] || [])].slice()) {
      if (listener && listener.call(this, name, this, ...details) === false) {
        return false;
      }
    }

    return true;
  }

  /**
   * Add given plugins to this instance,
   * this will end up calling `attach` method of each plugin
   * @param {Object} Plugins
   * @returns {Object}
   */
  attachPlugins(plugins) {
    const newPlugins = {};

    for (const [key, Plugin] of Object.entries(plugins || {})) {
      // Check if this plugin is not disabled by option
      if (this.options[key] !== false && !this.plugins[key]) {
        // Populate options with defaults from the plugin
        this.options[key] = (0,_utils_extend_js__WEBPACK_IMPORTED_MODULE_0__.extend)({}, Plugin.defaults || {}, this.options[key]);

        // Initialise plugin
        newPlugins[key] = new Plugin(this);
      }
    }

    for (const [key, plugin] of Object.entries(newPlugins)) {
      plugin.attach(this);
    }

    this.plugins = Object.assign({}, this.plugins, newPlugins);

    return this;
  }

  /**
   * Remove all plugin instances from this instance,
   * this will end up calling `detach` method of each plugin
   * @returns {Object}
   */
  detachPlugins() {
    for (const key in this.plugins) {
      let plugin;

      if ((plugin = this.plugins[key]) && typeof plugin.detach === "function") {
        plugin.detach(this);
      }
    }

    this.plugins = {};

    return this;
  }
}


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/Fullscreen.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/Fullscreen.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Fullscreen": () => (/* binding */ Fullscreen)
/* harmony export */ });
const Fullscreen = {
  pageXOffset: 0,
  pageYOffset: 0,

  element() {
    return document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement;
  },

  activate(element) {
    Fullscreen.pageXOffset = window.pageXOffset;
    Fullscreen.pageYOffset = window.pageYOffset;

    if (element.requestFullscreen) {
      element.requestFullscreen(); // W3C spec
    } else if (element.mozRequestFullScreen) {
      element.mozRequestFullScreen(); // Firefox
    } else if (element.webkitRequestFullscreen) {
      element.webkitRequestFullscreen(); // Safari
    } else if (element.msRequestFullscreen) {
      element.msRequestFullscreen(); // IE/Edge
    }
  },

  deactivate() {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    }
  },
};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/PointerTracker.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/PointerTracker.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "PointerTracker": () => (/* binding */ PointerTracker),
/* harmony export */   "getDistance": () => (/* binding */ getDistance),
/* harmony export */   "getMidpoint": () => (/* binding */ getMidpoint)
/* harmony export */ });
/* harmony import */ var _clearTextSelection_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./clearTextSelection.js */ "./node_modules/@fancyapps/ui/src/shared/utils/clearTextSelection.js");


class Pointer {
  constructor(nativePointer) {
    this.id = -1;

    this.id = nativePointer.pointerId || nativePointer.identifier || -1;

    this.pageX = nativePointer.pageX;
    this.pageY = nativePointer.pageY;

    this.clientX = nativePointer.clientX;
    this.clientY = nativePointer.clientY;

    this.nativePointer = nativePointer;
  }
}

function getDistance(a, b) {
  if (!b) {
    return 0;
  }

  return Math.sqrt((b.clientX - a.clientX) ** 2 + (b.clientY - a.clientY) ** 2);
}

function getMidpoint(a, b) {
  if (!b) {
    return a;
  }

  return {
    clientX: (a.clientX + b.clientX) / 2,
    clientY: (a.clientY + b.clientY) / 2,
  };
}

class PointerTracker {
  constructor(element, { start = () => true, move = () => {}, end = () => {} } = {}) {
    this.element = element;

    this.startPointers = [];
    this.currentPointers = [];

    this.startCallback = start;
    this.moveCallback = move;
    this.endCallback = end;

    this.onStart = (event) => {
      if (event.button && event.button !== 0) {
        return;
      }

      const pointer = new Pointer(event);

      if (this.startCallback(pointer, event) === false) {
        return false;
      }

      event.preventDefault();

      (0,_clearTextSelection_js__WEBPACK_IMPORTED_MODULE_0__.clearTextSelection)();

      this.currentPointers.push(pointer);
      this.startPointers.push(pointer);

      const capturingElement = event.target && "setPointerCapture" in event.target ? event.target : this.element;

      capturingElement.setPointerCapture(event.pointerId);

      this.element.addEventListener("pointermove", this.onMove);
      this.element.addEventListener("pointerup", this.onEnd);
      this.element.addEventListener("pointercancel", this.onEnd);
    };

    this.onMove = (event) => {
      const previousPointers = this.currentPointers.slice();
      const trackedChangedPointers = [];

      for (const pointer of [new Pointer(event)]) {
        const index = this.currentPointers.findIndex((p) => p.id === pointer.id);

        if (index < 0) {
          continue;
        }

        trackedChangedPointers.push(pointer);

        this.currentPointers[index] = pointer;
      }

      if (trackedChangedPointers.length) {
        this.moveCallback(previousPointers, this.currentPointers, event);
      }
    };

    this.onEnd = (event) => {
      const pointer = new Pointer(event);
      const index = this.currentPointers.findIndex((p) => p.id === pointer.id);

      if (index === -1) {
        return false;
      }

      this.currentPointers.splice(index, 1);
      this.startPointers.splice(index, 1);

      this.endCallback(pointer, event);

      if (!this.currentPointers.length) {
        this.element.removeEventListener("pointermove", this.onMove);
        this.element.removeEventListener("pointerup", this.onEnd);
        this.element.removeEventListener("pointercancel", this.onEnd);
      }
    };

    this.element.addEventListener("pointerdown", this.onStart);
  }

  stop() {
    this.element.removeEventListener("pointerdown", this.onStart);
    this.element.removeEventListener("pointermove", this.onMove);
    this.element.removeEventListener("pointerup", this.onEnd);
    this.element.removeEventListener("pointercancel", this.onEnd);
  }
}




/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/ResizeObserver.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/ResizeObserver.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "ResizeObserver": () => (/* binding */ ResizeObserver)
/* harmony export */ });
/**
 * ResizeObserver Polyfill
 */
const ResizeObserver =
  (typeof window !== "undefined" && window.ResizeObserver) ||
  class {
    constructor(callback) {
      this.observables = [];
      // Array of observed elements that looks like this:
      // [{
      //   el: domNode,
      //   size: {height: x, width: y}
      // }]
      this.boundCheck = this.check.bind(this);
      this.boundCheck();
      this.callback = callback;
    }

    observe(el) {
      if (this.observables.some((observable) => observable.el === el)) {
        return;
      }

      const newObservable = {
        el: el,
        size: {
          height: el.clientHeight,
          width: el.clientWidth,
        },
      };

      this.observables.push(newObservable);
    }

    unobserve(el) {
      this.observables = this.observables.filter((obj) => obj.el !== el);
    }

    disconnect() {
      this.observables = [];
    }

    check() {
      const changedEntries = this.observables
        .filter((obj) => {
          const currentHeight = obj.el.clientHeight;
          const currentWidth = obj.el.clientWidth;
          if (obj.size.height !== currentHeight || obj.size.width !== currentWidth) {
            obj.size.height = currentHeight;
            obj.size.width = currentWidth;
            return true;
          }
        })
        .map((obj) => obj.el);

      if (changedEntries.length > 0) {
        this.callback(changedEntries);
      }

      window.requestAnimationFrame(this.boundCheck);
    }
  };


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/Slideshow.js":
/*!******************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/Slideshow.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "Slideshow": () => (/* binding */ Slideshow)
/* harmony export */ });
class Slideshow {
  constructor(fancybox) {
    this.fancybox = fancybox;
    this.active = false;

    this.handleVisibilityChange = this.handleVisibilityChange.bind(this);
  }

  isActive() {
    return this.active;
  }

  setTimer() {
    if (!this.active || this.timer) {
      return;
    }

    const delay = this.fancybox.option("slideshow.delay", 3000);

    this.timer = setTimeout(() => {
      this.timer = null;

      if (
        !this.fancybox.option("infinite") &&
        this.fancybox.getSlide().index === this.fancybox.Carousel.slides.length - 1
      ) {
        this.fancybox.jumpTo(0, { friction: 0 });
      } else {
        this.fancybox.next();
      }
    }, delay);

    let $progress = this.$progress;

    if (!$progress) {
      $progress = document.createElement("div");
      $progress.classList.add("fancybox__progress");

      this.fancybox.$carousel.parentNode.insertBefore($progress, this.fancybox.$carousel);

      this.$progress = $progress;

      $progress.offsetHeight; /* trigger reflow */
    }

    $progress.style.transitionDuration = `${delay}ms`;
    $progress.style.transform = "scaleX(1)";
  }

  clearTimer() {
    clearTimeout(this.timer);
    this.timer = null;

    if (this.$progress) {
      this.$progress.style.transitionDuration = "";
      this.$progress.style.transform = "";

      this.$progress.offsetHeight; /* trigger reflow */
    }
  }

  activate() {
    if (this.active) {
      return;
    }

    this.active = true;
    this.fancybox.$container.classList.add("has-slideshow");

    if (this.fancybox.getSlide().state === "done") {
      this.setTimer();
    }

    document.addEventListener("visibilitychange", this.handleVisibilityChange, false);
  }

  handleVisibilityChange() {
    this.deactivate();
  }

  deactivate() {
    this.active = false;

    this.clearTimer();

    this.fancybox.$container.classList.remove("has-slideshow");

    document.removeEventListener("visibilitychange", this.handleVisibilityChange, false);
  }

  toggle() {
    if (this.active) {
      this.deactivate();
    } else if (this.fancybox.Carousel.slides.length > 1) {
      this.activate();
    }
  }
}


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/canUseDOM.js":
/*!******************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/canUseDOM.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "canUseDOM": () => (/* binding */ canUseDOM)
/* harmony export */ });
/**
 * Detect if rendering from the client or the server
 */
const canUseDOM = !!(
  typeof window !== "undefined" &&
  window.document &&
  window.document.createElement &&
  window.document.body
);


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/clearTextSelection.js":
/*!***************************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/clearTextSelection.js ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "clearTextSelection": () => (/* binding */ clearTextSelection)
/* harmony export */ });
/**
 *  Deselect any text which may be selected on a page
 */
const clearTextSelection = () => {
  const selection = window.getSelection ? window.getSelection() : document.selection;

  if (selection && selection.rangeCount && selection.getRangeAt(0).getClientRects().length) {
    if (selection.removeAllRanges) {
      selection.removeAllRanges();
    } else if (selection.empty) {
      selection.empty();
    }
  }
};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/extend.js":
/*!***************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/extend.js ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "extend": () => (/* binding */ extend)
/* harmony export */ });
/* harmony import */ var _isPlainObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./isPlainObject.js */ "./node_modules/@fancyapps/ui/src/shared/utils/isPlainObject.js");


/**
 * Merge the contents of two or more objects together into the first object.
 * If passing "true" for first argument, the merge becomes recursive (aka. deep copy).
 * @param  {...any} args
 * @returns {Object}
 */
const extend = (...args) => {
  let deep = false;

  if (typeof args[0] == "boolean") {
    deep = args.shift();
  }

  let result = args[0];

  if (!result || typeof result !== "object") {
    throw new Error("extendee must be an object");
  }

  const extenders = args.slice(1);
  const len = extenders.length;

  for (let i = 0; i < len; i++) {
    const extender = extenders[i];

    for (let key in extender) {
      if (extender.hasOwnProperty(key)) {
        const value = extender[key];

        if (deep && (Array.isArray(value) || (0,_isPlainObject_js__WEBPACK_IMPORTED_MODULE_0__.isPlainObject)(value))) {
          const base = Array.isArray(value) ? [] : {};

          result[key] = extend(true, result.hasOwnProperty(key) ? result[key] : base, value);
        } else {
          result[key] = value;
        }
      }
    }
  }

  return result;
};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/getDimensions.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/getDimensions.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "getFullWidth": () => (/* binding */ getFullWidth),
/* harmony export */   "getFullHeight": () => (/* binding */ getFullHeight),
/* harmony export */   "calculateAspectRatioFit": () => (/* binding */ calculateAspectRatioFit)
/* harmony export */ });
/**
 * Get actual width of the element, regardless of how much of content is currently visible
 * @param {Element} elem
 * @returns {Integer}
 */
const getFullWidth = (elem) => {
  return Math.max(
    parseFloat(elem.naturalWidth || 0),
    parseFloat((elem.width && elem.width.baseVal && elem.width.baseVal.value) || 0),
    parseFloat(elem.offsetWidth || 0),
    parseFloat(elem.scrollWidth || 0)
  );
};

/**
 * Get actual height of the element, regardless of how much of content is currently visible
 * @param {Element} elem
 * @returns {Integer}
 */
const getFullHeight = (elem) => {
  return Math.max(
    parseFloat(elem.naturalHeight || 0),
    parseFloat((elem.height && elem.height.baseVal && elem.height.baseVal.value) || 0),
    parseFloat(elem.offsetHeight || 0),
    parseFloat(elem.scrollHeight || 0)
  );
};

/**
 * Calculate bounding size to fit dimensions while preserving aspect ratio
 * @param {Number} srcWidth
 * @param {Number} srcHeight
 * @param {Number} maxWidth
 * @param {Number} maxHeight
 * @returns {Object}
 */
const calculateAspectRatioFit = (srcWidth, srcHeight, maxWidth, maxHeight) => {
  const ratio = Math.min(maxWidth / srcWidth || 0, maxHeight / srcHeight);

  return { width: srcWidth * ratio || 0, height: srcHeight * ratio || 0 };
};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/getTextNodeFromPoint.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/getTextNodeFromPoint.js ***!
  \*****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "getTextNodeFromPoint": () => (/* binding */ getTextNodeFromPoint)
/* harmony export */ });
/**
 * Get element child node at the given coordinates
 * @param {Element} HTML element
 * @param {Float|Integer} x
 * @param {Float|Integer} y
 * @returns {Node|Boolean}}
 */
const getTextNodeFromPoint = (element, x, y) => {
  const nodes = element.childNodes;
  const range = document.createRange();

  for (let i = 0; i < nodes.length; i++) {
    const node = nodes[i];

    if (node.nodeType !== Node.TEXT_NODE) {
      continue;
    }

    range.selectNodeContents(node);

    const rect = range.getBoundingClientRect();

    if (x >= rect.left && y >= rect.top && x <= rect.right && y <= rect.bottom) {
      return node;
    }
  }

  return false;
};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/isPlainObject.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/isPlainObject.js ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "isPlainObject": () => (/* binding */ isPlainObject)
/* harmony export */ });
/**
 * Check to see if an object is a plain object (created using "{}" or "new Object").
 * @param {*} obj Variable of any type
 * @returns {Boolean}
 */
const isPlainObject = (obj) => {
  return (
    // separate from primitives
    typeof obj === "object" &&
    // is obvious
    obj !== null &&
    // separate instances (Array, DOM, ...)
    obj.constructor === Object &&
    // separate build-in like Math
    Object.prototype.toString.call(obj) === "[object Object]"
  );
};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/isScrollable.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/isScrollable.js ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "hasScrollbars": () => (/* binding */ hasScrollbars),
/* harmony export */   "isScrollable": () => (/* binding */ isScrollable)
/* harmony export */ });
/**
 * Check if  element has scrollable content
 * @param {Node} node
 * @returns {Boolean}
 */
const hasScrollbars = function (node) {
  const overflowY = window.getComputedStyle(node)["overflow-y"],
    overflowX = window.getComputedStyle(node)["overflow-x"],
    vertical = (overflowY === "scroll" || overflowY === "auto") && Math.abs(node.scrollHeight - node.clientHeight) > 1,
    horizontal = (overflowX === "scroll" || overflowX === "auto") && Math.abs(node.scrollWidth - node.clientWidth) > 1;

  return vertical || horizontal;
};

/**
 * Check if element or one of the parents is scrollable
 * @param {Node} node  DOM Node element
 * @returns {Boolean}
 */
const isScrollable = function (node) {
  if (!node || node === document.body) {
    return false;
  }

  if (hasScrollbars(node)) {
    return node;
  }

  return isScrollable(node.parentNode);
};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/resolve.js":
/*!****************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/resolve.js ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "resolve": () => (/* binding */ resolve)
/* harmony export */ });
/**
 * Access nested JavaScript objects by string path.
 * Example: `resolve("a.b.c", {a:{b:{c:"d"}})` would return `d`
 * @param {String} path
 * @param {Object} obj
 * @returns {*}
 */
const resolve = function (path, obj) {
  return path.split(".").reduce(function (prev, curr) {
    return prev && prev[curr];
  }, obj);
};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/round.js":
/*!**************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/round.js ***!
  \**************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "round": () => (/* binding */ round)
/* harmony export */ });
/**
 * Round half up; to be more specific and to ensure things like 1.005 round correctly
 * @param {Float} value
 * @param {Integer} precision
 * @returns {Float}
 */
const round = (value, precision = 10000) => {
  value = parseFloat(value) || 0;

  return Math.round((value + Number.EPSILON) * precision) / precision;
};


/***/ }),

/***/ "./node_modules/@fancyapps/ui/src/shared/utils/throttle.js":
/*!*****************************************************************!*\
  !*** ./node_modules/@fancyapps/ui/src/shared/utils/throttle.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "throttle": () => (/* binding */ throttle)
/* harmony export */ });
/**
 * Throttling enforces a maximum number of times a function can be called over time
 * @param {Function} func Callback function
 * @param {Integer} limit Milliseconds
 * @returns {Function}
 */
const throttle = (func, limit) => {
  let lastCall = 0;

  return function (...args) {
    const now = new Date().getTime();

    if (now - lastCall < limit) {
      return;
    }

    lastCall = now;

    return func(...args);
  };
};


/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _fancyapps_ui_src_Fancybox_Fancybox_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @fancyapps/ui/src/Fancybox/Fancybox.js */ "./node_modules/@fancyapps/ui/src/Fancybox/Fancybox.js");
/* harmony import */ var owl_carousel_dist_owl_carousel_min_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! owl.carousel/dist/owl.carousel.min.js */ "./node_modules/owl.carousel/dist/owl.carousel.min.js");
/* harmony import */ var owl_carousel_dist_owl_carousel_min_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(owl_carousel_dist_owl_carousel_min_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _views_Client_assets_js_config__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../views/Client/assets/js/config */ "./resources/views/Client/assets/js/config.js");
/* harmony import */ var _views_Client_assets_js_config__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_views_Client_assets_js_config__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _views_Client_assets_js_base__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../views/Client/assets/js/base */ "./resources/views/Client/assets/js/base.js");
/* harmony import */ var _views_Client_assets_js_base__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_views_Client_assets_js_base__WEBPACK_IMPORTED_MODULE_4__);
/* provided dependency */ var __webpack_provided_window_dot_jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

window.$ = __webpack_provided_window_dot_jQuery = (jquery__WEBPACK_IMPORTED_MODULE_0___default());





/***/ }),

/***/ "./resources/views/Client/assets/js/base.js":
/*!**************************************************!*\
  !*** ./resources/views/Client/assets/js/base.js ***!
  \**************************************************/
/***/ (() => {



/***/ }),

/***/ "./resources/views/Client/assets/js/config.js":
/*!****************************************************!*\
  !*** ./resources/views/Client/assets/js/config.js ***!
  \****************************************************/
/***/ (() => {



/***/ }),

/***/ "./node_modules/jquery/dist/jquery.js":
/*!********************************************!*\
  !*** ./node_modules/jquery/dist/jquery.js ***!
  \********************************************/
/***/ (function(module, exports) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery JavaScript Library v3.6.0
 * https://jquery.com/
 *
 * Includes Sizzle.js
 * https://sizzlejs.com/
 *
 * Copyright OpenJS Foundation and other contributors
 * Released under the MIT license
 * https://jquery.org/license
 *
 * Date: 2021-03-02T17:08Z
 */
( function( global, factory ) {

	"use strict";

	if (  true && typeof module.exports === "object" ) {

		// For CommonJS and CommonJS-like environments where a proper `window`
		// is present, execute the factory and get jQuery.
		// For environments that do not have a `window` with a `document`
		// (such as Node.js), expose a factory as module.exports.
		// This accentuates the need for the creation of a real `window`.
		// e.g. var jQuery = require("jquery")(window);
		// See ticket #14549 for more info.
		module.exports = global.document ?
			factory( global, true ) :
			function( w ) {
				if ( !w.document ) {
					throw new Error( "jQuery requires a window with a document" );
				}
				return factory( w );
			};
	} else {
		factory( global );
	}

// Pass this if window is not defined yet
} )( typeof window !== "undefined" ? window : this, function( window, noGlobal ) {

// Edge <= 12 - 13+, Firefox <=18 - 45+, IE 10 - 11, Safari 5.1 - 9+, iOS 6 - 9.1
// throw exceptions when non-strict code (e.g., ASP.NET 4.5) accesses strict mode
// arguments.callee.caller (trac-13335). But as of jQuery 3.0 (2016), strict mode should be common
// enough that all such attempts are guarded in a try block.
"use strict";

var arr = [];

var getProto = Object.getPrototypeOf;

var slice = arr.slice;

var flat = arr.flat ? function( array ) {
	return arr.flat.call( array );
} : function( array ) {
	return arr.concat.apply( [], array );
};


var push = arr.push;

var indexOf = arr.indexOf;

var class2type = {};

var toString = class2type.toString;

var hasOwn = class2type.hasOwnProperty;

var fnToString = hasOwn.toString;

var ObjectFunctionString = fnToString.call( Object );

var support = {};

var isFunction = function isFunction( obj ) {

		// Support: Chrome <=57, Firefox <=52
		// In some browsers, typeof returns "function" for HTML <object> elements
		// (i.e., `typeof document.createElement( "object" ) === "function"`).
		// We don't want to classify *any* DOM node as a function.
		// Support: QtWeb <=3.8.5, WebKit <=534.34, wkhtmltopdf tool <=0.12.5
		// Plus for old WebKit, typeof returns "function" for HTML collections
		// (e.g., `typeof document.getElementsByTagName("div") === "function"`). (gh-4756)
		return typeof obj === "function" && typeof obj.nodeType !== "number" &&
			typeof obj.item !== "function";
	};


var isWindow = function isWindow( obj ) {
		return obj != null && obj === obj.window;
	};


var document = window.document;



	var preservedScriptAttributes = {
		type: true,
		src: true,
		nonce: true,
		noModule: true
	};

	function DOMEval( code, node, doc ) {
		doc = doc || document;

		var i, val,
			script = doc.createElement( "script" );

		script.text = code;
		if ( node ) {
			for ( i in preservedScriptAttributes ) {

				// Support: Firefox 64+, Edge 18+
				// Some browsers don't support the "nonce" property on scripts.
				// On the other hand, just using `getAttribute` is not enough as
				// the `nonce` attribute is reset to an empty string whenever it
				// becomes browsing-context connected.
				// See https://github.com/whatwg/html/issues/2369
				// See https://html.spec.whatwg.org/#nonce-attributes
				// The `node.getAttribute` check was added for the sake of
				// `jQuery.globalEval` so that it can fake a nonce-containing node
				// via an object.
				val = node[ i ] || node.getAttribute && node.getAttribute( i );
				if ( val ) {
					script.setAttribute( i, val );
				}
			}
		}
		doc.head.appendChild( script ).parentNode.removeChild( script );
	}


function toType( obj ) {
	if ( obj == null ) {
		return obj + "";
	}

	// Support: Android <=2.3 only (functionish RegExp)
	return typeof obj === "object" || typeof obj === "function" ?
		class2type[ toString.call( obj ) ] || "object" :
		typeof obj;
}
/* global Symbol */
// Defining this global in .eslintrc.json would create a danger of using the global
// unguarded in another place, it seems safer to define global only for this module



var
	version = "3.6.0",

	// Define a local copy of jQuery
	jQuery = function( selector, context ) {

		// The jQuery object is actually just the init constructor 'enhanced'
		// Need init if jQuery is called (just allow error to be thrown if not included)
		return new jQuery.fn.init( selector, context );
	};

jQuery.fn = jQuery.prototype = {

	// The current version of jQuery being used
	jquery: version,

	constructor: jQuery,

	// The default length of a jQuery object is 0
	length: 0,

	toArray: function() {
		return slice.call( this );
	},

	// Get the Nth element in the matched element set OR
	// Get the whole matched element set as a clean array
	get: function( num ) {

		// Return all the elements in a clean array
		if ( num == null ) {
			return slice.call( this );
		}

		// Return just the one element from the set
		return num < 0 ? this[ num + this.length ] : this[ num ];
	},

	// Take an array of elements and push it onto the stack
	// (returning the new matched element set)
	pushStack: function( elems ) {

		// Build a new jQuery matched element set
		var ret = jQuery.merge( this.constructor(), elems );

		// Add the old object onto the stack (as a reference)
		ret.prevObject = this;

		// Return the newly-formed element set
		return ret;
	},

	// Execute a callback for every element in the matched set.
	each: function( callback ) {
		return jQuery.each( this, callback );
	},

	map: function( callback ) {
		return this.pushStack( jQuery.map( this, function( elem, i ) {
			return callback.call( elem, i, elem );
		} ) );
	},

	slice: function() {
		return this.pushStack( slice.apply( this, arguments ) );
	},

	first: function() {
		return this.eq( 0 );
	},

	last: function() {
		return this.eq( -1 );
	},

	even: function() {
		return this.pushStack( jQuery.grep( this, function( _elem, i ) {
			return ( i + 1 ) % 2;
		} ) );
	},

	odd: function() {
		return this.pushStack( jQuery.grep( this, function( _elem, i ) {
			return i % 2;
		} ) );
	},

	eq: function( i ) {
		var len = this.length,
			j = +i + ( i < 0 ? len : 0 );
		return this.pushStack( j >= 0 && j < len ? [ this[ j ] ] : [] );
	},

	end: function() {
		return this.prevObject || this.constructor();
	},

	// For internal use only.
	// Behaves like an Array's method, not like a jQuery method.
	push: push,
	sort: arr.sort,
	splice: arr.splice
};

jQuery.extend = jQuery.fn.extend = function() {
	var options, name, src, copy, copyIsArray, clone,
		target = arguments[ 0 ] || {},
		i = 1,
		length = arguments.length,
		deep = false;

	// Handle a deep copy situation
	if ( typeof target === "boolean" ) {
		deep = target;

		// Skip the boolean and the target
		target = arguments[ i ] || {};
		i++;
	}

	// Handle case when target is a string or something (possible in deep copy)
	if ( typeof target !== "object" && !isFunction( target ) ) {
		target = {};
	}

	// Extend jQuery itself if only one argument is passed
	if ( i === length ) {
		target = this;
		i--;
	}

	for ( ; i < length; i++ ) {

		// Only deal with non-null/undefined values
		if ( ( options = arguments[ i ] ) != null ) {

			// Extend the base object
			for ( name in options ) {
				copy = options[ name ];

				// Prevent Object.prototype pollution
				// Prevent never-ending loop
				if ( name === "__proto__" || target === copy ) {
					continue;
				}

				// Recurse if we're merging plain objects or arrays
				if ( deep && copy && ( jQuery.isPlainObject( copy ) ||
					( copyIsArray = Array.isArray( copy ) ) ) ) {
					src = target[ name ];

					// Ensure proper type for the source value
					if ( copyIsArray && !Array.isArray( src ) ) {
						clone = [];
					} else if ( !copyIsArray && !jQuery.isPlainObject( src ) ) {
						clone = {};
					} else {
						clone = src;
					}
					copyIsArray = false;

					// Never move original objects, clone them
					target[ name ] = jQuery.extend( deep, clone, copy );

				// Don't bring in undefined values
				} else if ( copy !== undefined ) {
					target[ name ] = copy;
				}
			}
		}
	}

	// Return the modified object
	return target;
};

jQuery.extend( {

	// Unique for each copy of jQuery on the page
	expando: "jQuery" + ( version + Math.random() ).replace( /\D/g, "" ),

	// Assume jQuery is ready without the ready module
	isReady: true,

	error: function( msg ) {
		throw new Error( msg );
	},

	noop: function() {},

	isPlainObject: function( obj ) {
		var proto, Ctor;

		// Detect obvious negatives
		// Use toString instead of jQuery.type to catch host objects
		if ( !obj || toString.call( obj ) !== "[object Object]" ) {
			return false;
		}

		proto = getProto( obj );

		// Objects with no prototype (e.g., `Object.create( null )`) are plain
		if ( !proto ) {
			return true;
		}

		// Objects with prototype are plain iff they were constructed by a global Object function
		Ctor = hasOwn.call( proto, "constructor" ) && proto.constructor;
		return typeof Ctor === "function" && fnToString.call( Ctor ) === ObjectFunctionString;
	},

	isEmptyObject: function( obj ) {
		var name;

		for ( name in obj ) {
			return false;
		}
		return true;
	},

	// Evaluates a script in a provided context; falls back to the global one
	// if not specified.
	globalEval: function( code, options, doc ) {
		DOMEval( code, { nonce: options && options.nonce }, doc );
	},

	each: function( obj, callback ) {
		var length, i = 0;

		if ( isArrayLike( obj ) ) {
			length = obj.length;
			for ( ; i < length; i++ ) {
				if ( callback.call( obj[ i ], i, obj[ i ] ) === false ) {
					break;
				}
			}
		} else {
			for ( i in obj ) {
				if ( callback.call( obj[ i ], i, obj[ i ] ) === false ) {
					break;
				}
			}
		}

		return obj;
	},

	// results is for internal usage only
	makeArray: function( arr, results ) {
		var ret = results || [];

		if ( arr != null ) {
			if ( isArrayLike( Object( arr ) ) ) {
				jQuery.merge( ret,
					typeof arr === "string" ?
						[ arr ] : arr
				);
			} else {
				push.call( ret, arr );
			}
		}

		return ret;
	},

	inArray: function( elem, arr, i ) {
		return arr == null ? -1 : indexOf.call( arr, elem, i );
	},

	// Support: Android <=4.0 only, PhantomJS 1 only
	// push.apply(_, arraylike) throws on ancient WebKit
	merge: function( first, second ) {
		var len = +second.length,
			j = 0,
			i = first.length;

		for ( ; j < len; j++ ) {
			first[ i++ ] = second[ j ];
		}

		first.length = i;

		return first;
	},

	grep: function( elems, callback, invert ) {
		var callbackInverse,
			matches = [],
			i = 0,
			length = elems.length,
			callbackExpect = !invert;

		// Go through the array, only saving the items
		// that pass the validator function
		for ( ; i < length; i++ ) {
			callbackInverse = !callback( elems[ i ], i );
			if ( callbackInverse !== callbackExpect ) {
				matches.push( elems[ i ] );
			}
		}

		return matches;
	},

	// arg is for internal usage only
	map: function( elems, callback, arg ) {
		var length, value,
			i = 0,
			ret = [];

		// Go through the array, translating each of the items to their new values
		if ( isArrayLike( elems ) ) {
			length = elems.length;
			for ( ; i < length; i++ ) {
				value = callback( elems[ i ], i, arg );

				if ( value != null ) {
					ret.push( value );
				}
			}

		// Go through every key on the object,
		} else {
			for ( i in elems ) {
				value = callback( elems[ i ], i, arg );

				if ( value != null ) {
					ret.push( value );
				}
			}
		}

		// Flatten any nested arrays
		return flat( ret );
	},

	// A global GUID counter for objects
	guid: 1,

	// jQuery.support is not used in Core but other projects attach their
	// properties to it so it needs to exist.
	support: support
} );

if ( typeof Symbol === "function" ) {
	jQuery.fn[ Symbol.iterator ] = arr[ Symbol.iterator ];
}

// Populate the class2type map
jQuery.each( "Boolean Number String Function Array Date RegExp Object Error Symbol".split( " " ),
	function( _i, name ) {
		class2type[ "[object " + name + "]" ] = name.toLowerCase();
	} );

function isArrayLike( obj ) {

	// Support: real iOS 8.2 only (not reproducible in simulator)
	// `in` check used to prevent JIT error (gh-2145)
	// hasOwn isn't used here due to false negatives
	// regarding Nodelist length in IE
	var length = !!obj && "length" in obj && obj.length,
		type = toType( obj );

	if ( isFunction( obj ) || isWindow( obj ) ) {
		return false;
	}

	return type === "array" || length === 0 ||
		typeof length === "number" && length > 0 && ( length - 1 ) in obj;
}
var Sizzle =
/*!
 * Sizzle CSS Selector Engine v2.3.6
 * https://sizzlejs.com/
 *
 * Copyright JS Foundation and other contributors
 * Released under the MIT license
 * https://js.foundation/
 *
 * Date: 2021-02-16
 */
( function( window ) {
var i,
	support,
	Expr,
	getText,
	isXML,
	tokenize,
	compile,
	select,
	outermostContext,
	sortInput,
	hasDuplicate,

	// Local document vars
	setDocument,
	document,
	docElem,
	documentIsHTML,
	rbuggyQSA,
	rbuggyMatches,
	matches,
	contains,

	// Instance-specific data
	expando = "sizzle" + 1 * new Date(),
	preferredDoc = window.document,
	dirruns = 0,
	done = 0,
	classCache = createCache(),
	tokenCache = createCache(),
	compilerCache = createCache(),
	nonnativeSelectorCache = createCache(),
	sortOrder = function( a, b ) {
		if ( a === b ) {
			hasDuplicate = true;
		}
		return 0;
	},

	// Instance methods
	hasOwn = ( {} ).hasOwnProperty,
	arr = [],
	pop = arr.pop,
	pushNative = arr.push,
	push = arr.push,
	slice = arr.slice,

	// Use a stripped-down indexOf as it's faster than native
	// https://jsperf.com/thor-indexof-vs-for/5
	indexOf = function( list, elem ) {
		var i = 0,
			len = list.length;
		for ( ; i < len; i++ ) {
			if ( list[ i ] === elem ) {
				return i;
			}
		}
		return -1;
	},

	booleans = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|" +
		"ismap|loop|multiple|open|readonly|required|scoped",

	// Regular expressions

	// http://www.w3.org/TR/css3-selectors/#whitespace
	whitespace = "[\\x20\\t\\r\\n\\f]",

	// https://www.w3.org/TR/css-syntax-3/#ident-token-diagram
	identifier = "(?:\\\\[\\da-fA-F]{1,6}" + whitespace +
		"?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",

	// Attribute selectors: http://www.w3.org/TR/selectors/#attribute-selectors
	attributes = "\\[" + whitespace + "*(" + identifier + ")(?:" + whitespace +

		// Operator (capture 2)
		"*([*^$|!~]?=)" + whitespace +

		// "Attribute values must be CSS identifiers [capture 5]
		// or strings [capture 3 or capture 4]"
		"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + identifier + "))|)" +
		whitespace + "*\\]",

	pseudos = ":(" + identifier + ")(?:\\((" +

		// To reduce the number of selectors needing tokenize in the preFilter, prefer arguments:
		// 1. quoted (capture 3; capture 4 or capture 5)
		"('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|" +

		// 2. simple (capture 6)
		"((?:\\\\.|[^\\\\()[\\]]|" + attributes + ")*)|" +

		// 3. anything else (capture 2)
		".*" +
		")\\)|)",

	// Leading and non-escaped trailing whitespace, capturing some non-whitespace characters preceding the latter
	rwhitespace = new RegExp( whitespace + "+", "g" ),
	rtrim = new RegExp( "^" + whitespace + "+|((?:^|[^\\\\])(?:\\\\.)*)" +
		whitespace + "+$", "g" ),

	rcomma = new RegExp( "^" + whitespace + "*," + whitespace + "*" ),
	rcombinators = new RegExp( "^" + whitespace + "*([>+~]|" + whitespace + ")" + whitespace +
		"*" ),
	rdescend = new RegExp( whitespace + "|>" ),

	rpseudo = new RegExp( pseudos ),
	ridentifier = new RegExp( "^" + identifier + "$" ),

	matchExpr = {
		"ID": new RegExp( "^#(" + identifier + ")" ),
		"CLASS": new RegExp( "^\\.(" + identifier + ")" ),
		"TAG": new RegExp( "^(" + identifier + "|[*])" ),
		"ATTR": new RegExp( "^" + attributes ),
		"PSEUDO": new RegExp( "^" + pseudos ),
		"CHILD": new RegExp( "^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" +
			whitespace + "*(even|odd|(([+-]|)(\\d*)n|)" + whitespace + "*(?:([+-]|)" +
			whitespace + "*(\\d+)|))" + whitespace + "*\\)|)", "i" ),
		"bool": new RegExp( "^(?:" + booleans + ")$", "i" ),

		// For use in libraries implementing .is()
		// We use this for POS matching in `select`
		"needsContext": new RegExp( "^" + whitespace +
			"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + whitespace +
			"*((?:-\\d)?\\d*)" + whitespace + "*\\)|)(?=[^-]|$)", "i" )
	},

	rhtml = /HTML$/i,
	rinputs = /^(?:input|select|textarea|button)$/i,
	rheader = /^h\d$/i,

	rnative = /^[^{]+\{\s*\[native \w/,

	// Easily-parseable/retrievable ID or TAG or CLASS selectors
	rquickExpr = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,

	rsibling = /[+~]/,

	// CSS escapes
	// http://www.w3.org/TR/CSS21/syndata.html#escaped-characters
	runescape = new RegExp( "\\\\[\\da-fA-F]{1,6}" + whitespace + "?|\\\\([^\\r\\n\\f])", "g" ),
	funescape = function( escape, nonHex ) {
		var high = "0x" + escape.slice( 1 ) - 0x10000;

		return nonHex ?

			// Strip the backslash prefix from a non-hex escape sequence
			nonHex :

			// Replace a hexadecimal escape sequence with the encoded Unicode code point
			// Support: IE <=11+
			// For values outside the Basic Multilingual Plane (BMP), manually construct a
			// surrogate pair
			high < 0 ?
				String.fromCharCode( high + 0x10000 ) :
				String.fromCharCode( high >> 10 | 0xD800, high & 0x3FF | 0xDC00 );
	},

	// CSS string/identifier serialization
	// https://drafts.csswg.org/cssom/#common-serializing-idioms
	rcssescape = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
	fcssescape = function( ch, asCodePoint ) {
		if ( asCodePoint ) {

			// U+0000 NULL becomes U+FFFD REPLACEMENT CHARACTER
			if ( ch === "\0" ) {
				return "\uFFFD";
			}

			// Control characters and (dependent upon position) numbers get escaped as code points
			return ch.slice( 0, -1 ) + "\\" +
				ch.charCodeAt( ch.length - 1 ).toString( 16 ) + " ";
		}

		// Other potentially-special ASCII characters get backslash-escaped
		return "\\" + ch;
	},

	// Used for iframes
	// See setDocument()
	// Removing the function wrapper causes a "Permission Denied"
	// error in IE
	unloadHandler = function() {
		setDocument();
	},

	inDisabledFieldset = addCombinator(
		function( elem ) {
			return elem.disabled === true && elem.nodeName.toLowerCase() === "fieldset";
		},
		{ dir: "parentNode", next: "legend" }
	);

// Optimize for push.apply( _, NodeList )
try {
	push.apply(
		( arr = slice.call( preferredDoc.childNodes ) ),
		preferredDoc.childNodes
	);

	// Support: Android<4.0
	// Detect silently failing push.apply
	// eslint-disable-next-line no-unused-expressions
	arr[ preferredDoc.childNodes.length ].nodeType;
} catch ( e ) {
	push = { apply: arr.length ?

		// Leverage slice if possible
		function( target, els ) {
			pushNative.apply( target, slice.call( els ) );
		} :

		// Support: IE<9
		// Otherwise append directly
		function( target, els ) {
			var j = target.length,
				i = 0;

			// Can't trust NodeList.length
			while ( ( target[ j++ ] = els[ i++ ] ) ) {}
			target.length = j - 1;
		}
	};
}

function Sizzle( selector, context, results, seed ) {
	var m, i, elem, nid, match, groups, newSelector,
		newContext = context && context.ownerDocument,

		// nodeType defaults to 9, since context defaults to document
		nodeType = context ? context.nodeType : 9;

	results = results || [];

	// Return early from calls with invalid selector or context
	if ( typeof selector !== "string" || !selector ||
		nodeType !== 1 && nodeType !== 9 && nodeType !== 11 ) {

		return results;
	}

	// Try to shortcut find operations (as opposed to filters) in HTML documents
	if ( !seed ) {
		setDocument( context );
		context = context || document;

		if ( documentIsHTML ) {

			// If the selector is sufficiently simple, try using a "get*By*" DOM method
			// (excepting DocumentFragment context, where the methods don't exist)
			if ( nodeType !== 11 && ( match = rquickExpr.exec( selector ) ) ) {

				// ID selector
				if ( ( m = match[ 1 ] ) ) {

					// Document context
					if ( nodeType === 9 ) {
						if ( ( elem = context.getElementById( m ) ) ) {

							// Support: IE, Opera, Webkit
							// TODO: identify versions
							// getElementById can match elements by name instead of ID
							if ( elem.id === m ) {
								results.push( elem );
								return results;
							}
						} else {
							return results;
						}

					// Element context
					} else {

						// Support: IE, Opera, Webkit
						// TODO: identify versions
						// getElementById can match elements by name instead of ID
						if ( newContext && ( elem = newContext.getElementById( m ) ) &&
							contains( context, elem ) &&
							elem.id === m ) {

							results.push( elem );
							return results;
						}
					}

				// Type selector
				} else if ( match[ 2 ] ) {
					push.apply( results, context.getElementsByTagName( selector ) );
					return results;

				// Class selector
				} else if ( ( m = match[ 3 ] ) && support.getElementsByClassName &&
					context.getElementsByClassName ) {

					push.apply( results, context.getElementsByClassName( m ) );
					return results;
				}
			}

			// Take advantage of querySelectorAll
			if ( support.qsa &&
				!nonnativeSelectorCache[ selector + " " ] &&
				( !rbuggyQSA || !rbuggyQSA.test( selector ) ) &&

				// Support: IE 8 only
				// Exclude object elements
				( nodeType !== 1 || context.nodeName.toLowerCase() !== "object" ) ) {

				newSelector = selector;
				newContext = context;

				// qSA considers elements outside a scoping root when evaluating child or
				// descendant combinators, which is not what we want.
				// In such cases, we work around the behavior by prefixing every selector in the
				// list with an ID selector referencing the scope context.
				// The technique has to be used as well when a leading combinator is used
				// as such selectors are not recognized by querySelectorAll.
				// Thanks to Andrew Dupont for this technique.
				if ( nodeType === 1 &&
					( rdescend.test( selector ) || rcombinators.test( selector ) ) ) {

					// Expand context for sibling selectors
					newContext = rsibling.test( selector ) && testContext( context.parentNode ) ||
						context;

					// We can use :scope instead of the ID hack if the browser
					// supports it & if we're not changing the context.
					if ( newContext !== context || !support.scope ) {

						// Capture the context ID, setting it first if necessary
						if ( ( nid = context.getAttribute( "id" ) ) ) {
							nid = nid.replace( rcssescape, fcssescape );
						} else {
							context.setAttribute( "id", ( nid = expando ) );
						}
					}

					// Prefix every selector in the list
					groups = tokenize( selector );
					i = groups.length;
					while ( i-- ) {
						groups[ i ] = ( nid ? "#" + nid : ":scope" ) + " " +
							toSelector( groups[ i ] );
					}
					newSelector = groups.join( "," );
				}

				try {
					push.apply( results,
						newContext.querySelectorAll( newSelector )
					);
					return results;
				} catch ( qsaError ) {
					nonnativeSelectorCache( selector, true );
				} finally {
					if ( nid === expando ) {
						context.removeAttribute( "id" );
					}
				}
			}
		}
	}

	// All others
	return select( selector.replace( rtrim, "$1" ), context, results, seed );
}

/**
 * Create key-value caches of limited size
 * @returns {function(string, object)} Returns the Object data after storing it on itself with
 *	property name the (space-suffixed) string and (if the cache is larger than Expr.cacheLength)
 *	deleting the oldest entry
 */
function createCache() {
	var keys = [];

	function cache( key, value ) {

		// Use (key + " ") to avoid collision with native prototype properties (see Issue #157)
		if ( keys.push( key + " " ) > Expr.cacheLength ) {

			// Only keep the most recent entries
			delete cache[ keys.shift() ];
		}
		return ( cache[ key + " " ] = value );
	}
	return cache;
}

/**
 * Mark a function for special use by Sizzle
 * @param {Function} fn The function to mark
 */
function markFunction( fn ) {
	fn[ expando ] = true;
	return fn;
}

/**
 * Support testing using an element
 * @param {Function} fn Passed the created element and returns a boolean result
 */
function assert( fn ) {
	var el = document.createElement( "fieldset" );

	try {
		return !!fn( el );
	} catch ( e ) {
		return false;
	} finally {

		// Remove from its parent by default
		if ( el.parentNode ) {
			el.parentNode.removeChild( el );
		}

		// release memory in IE
		el = null;
	}
}

/**
 * Adds the same handler for all of the specified attrs
 * @param {String} attrs Pipe-separated list of attributes
 * @param {Function} handler The method that will be applied
 */
function addHandle( attrs, handler ) {
	var arr = attrs.split( "|" ),
		i = arr.length;

	while ( i-- ) {
		Expr.attrHandle[ arr[ i ] ] = handler;
	}
}

/**
 * Checks document order of two siblings
 * @param {Element} a
 * @param {Element} b
 * @returns {Number} Returns less than 0 if a precedes b, greater than 0 if a follows b
 */
function siblingCheck( a, b ) {
	var cur = b && a,
		diff = cur && a.nodeType === 1 && b.nodeType === 1 &&
			a.sourceIndex - b.sourceIndex;

	// Use IE sourceIndex if available on both nodes
	if ( diff ) {
		return diff;
	}

	// Check if b follows a
	if ( cur ) {
		while ( ( cur = cur.nextSibling ) ) {
			if ( cur === b ) {
				return -1;
			}
		}
	}

	return a ? 1 : -1;
}

/**
 * Returns a function to use in pseudos for input types
 * @param {String} type
 */
function createInputPseudo( type ) {
	return function( elem ) {
		var name = elem.nodeName.toLowerCase();
		return name === "input" && elem.type === type;
	};
}

/**
 * Returns a function to use in pseudos for buttons
 * @param {String} type
 */
function createButtonPseudo( type ) {
	return function( elem ) {
		var name = elem.nodeName.toLowerCase();
		return ( name === "input" || name === "button" ) && elem.type === type;
	};
}

/**
 * Returns a function to use in pseudos for :enabled/:disabled
 * @param {Boolean} disabled true for :disabled; false for :enabled
 */
function createDisabledPseudo( disabled ) {

	// Known :disabled false positives: fieldset[disabled] > legend:nth-of-type(n+2) :can-disable
	return function( elem ) {

		// Only certain elements can match :enabled or :disabled
		// https://html.spec.whatwg.org/multipage/scripting.html#selector-enabled
		// https://html.spec.whatwg.org/multipage/scripting.html#selector-disabled
		if ( "form" in elem ) {

			// Check for inherited disabledness on relevant non-disabled elements:
			// * listed form-associated elements in a disabled fieldset
			//   https://html.spec.whatwg.org/multipage/forms.html#category-listed
			//   https://html.spec.whatwg.org/multipage/forms.html#concept-fe-disabled
			// * option elements in a disabled optgroup
			//   https://html.spec.whatwg.org/multipage/forms.html#concept-option-disabled
			// All such elements have a "form" property.
			if ( elem.parentNode && elem.disabled === false ) {

				// Option elements defer to a parent optgroup if present
				if ( "label" in elem ) {
					if ( "label" in elem.parentNode ) {
						return elem.parentNode.disabled === disabled;
					} else {
						return elem.disabled === disabled;
					}
				}

				// Support: IE 6 - 11
				// Use the isDisabled shortcut property to check for disabled fieldset ancestors
				return elem.isDisabled === disabled ||

					// Where there is no isDisabled, check manually
					/* jshint -W018 */
					elem.isDisabled !== !disabled &&
					inDisabledFieldset( elem ) === disabled;
			}

			return elem.disabled === disabled;

		// Try to winnow out elements that can't be disabled before trusting the disabled property.
		// Some victims get caught in our net (label, legend, menu, track), but it shouldn't
		// even exist on them, let alone have a boolean value.
		} else if ( "label" in elem ) {
			return elem.disabled === disabled;
		}

		// Remaining elements are neither :enabled nor :disabled
		return false;
	};
}

/**
 * Returns a function to use in pseudos for positionals
 * @param {Function} fn
 */
function createPositionalPseudo( fn ) {
	return markFunction( function( argument ) {
		argument = +argument;
		return markFunction( function( seed, matches ) {
			var j,
				matchIndexes = fn( [], seed.length, argument ),
				i = matchIndexes.length;

			// Match elements found at the specified indexes
			while ( i-- ) {
				if ( seed[ ( j = matchIndexes[ i ] ) ] ) {
					seed[ j ] = !( matches[ j ] = seed[ j ] );
				}
			}
		} );
	} );
}

/**
 * Checks a node for validity as a Sizzle context
 * @param {Element|Object=} context
 * @returns {Element|Object|Boolean} The input node if acceptable, otherwise a falsy value
 */
function testContext( context ) {
	return context && typeof context.getElementsByTagName !== "undefined" && context;
}

// Expose support vars for convenience
support = Sizzle.support = {};

/**
 * Detects XML nodes
 * @param {Element|Object} elem An element or a document
 * @returns {Boolean} True iff elem is a non-HTML XML node
 */
isXML = Sizzle.isXML = function( elem ) {
	var namespace = elem && elem.namespaceURI,
		docElem = elem && ( elem.ownerDocument || elem ).documentElement;

	// Support: IE <=8
	// Assume HTML when documentElement doesn't yet exist, such as inside loading iframes
	// https://bugs.jquery.com/ticket/4833
	return !rhtml.test( namespace || docElem && docElem.nodeName || "HTML" );
};

/**
 * Sets document-related variables once based on the current document
 * @param {Element|Object} [doc] An element or document object to use to set the document
 * @returns {Object} Returns the current document
 */
setDocument = Sizzle.setDocument = function( node ) {
	var hasCompare, subWindow,
		doc = node ? node.ownerDocument || node : preferredDoc;

	// Return early if doc is invalid or already selected
	// Support: IE 11+, Edge 17 - 18+
	// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
	// two documents; shallow comparisons work.
	// eslint-disable-next-line eqeqeq
	if ( doc == document || doc.nodeType !== 9 || !doc.documentElement ) {
		return document;
	}

	// Update global variables
	document = doc;
	docElem = document.documentElement;
	documentIsHTML = !isXML( document );

	// Support: IE 9 - 11+, Edge 12 - 18+
	// Accessing iframe documents after unload throws "permission denied" errors (jQuery #13936)
	// Support: IE 11+, Edge 17 - 18+
	// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
	// two documents; shallow comparisons work.
	// eslint-disable-next-line eqeqeq
	if ( preferredDoc != document &&
		( subWindow = document.defaultView ) && subWindow.top !== subWindow ) {

		// Support: IE 11, Edge
		if ( subWindow.addEventListener ) {
			subWindow.addEventListener( "unload", unloadHandler, false );

		// Support: IE 9 - 10 only
		} else if ( subWindow.attachEvent ) {
			subWindow.attachEvent( "onunload", unloadHandler );
		}
	}

	// Support: IE 8 - 11+, Edge 12 - 18+, Chrome <=16 - 25 only, Firefox <=3.6 - 31 only,
	// Safari 4 - 5 only, Opera <=11.6 - 12.x only
	// IE/Edge & older browsers don't support the :scope pseudo-class.
	// Support: Safari 6.0 only
	// Safari 6.0 supports :scope but it's an alias of :root there.
	support.scope = assert( function( el ) {
		docElem.appendChild( el ).appendChild( document.createElement( "div" ) );
		return typeof el.querySelectorAll !== "undefined" &&
			!el.querySelectorAll( ":scope fieldset div" ).length;
	} );

	/* Attributes
	---------------------------------------------------------------------- */

	// Support: IE<8
	// Verify that getAttribute really returns attributes and not properties
	// (excepting IE8 booleans)
	support.attributes = assert( function( el ) {
		el.className = "i";
		return !el.getAttribute( "className" );
	} );

	/* getElement(s)By*
	---------------------------------------------------------------------- */

	// Check if getElementsByTagName("*") returns only elements
	support.getElementsByTagName = assert( function( el ) {
		el.appendChild( document.createComment( "" ) );
		return !el.getElementsByTagName( "*" ).length;
	} );

	// Support: IE<9
	support.getElementsByClassName = rnative.test( document.getElementsByClassName );

	// Support: IE<10
	// Check if getElementById returns elements by name
	// The broken getElementById methods don't pick up programmatically-set names,
	// so use a roundabout getElementsByName test
	support.getById = assert( function( el ) {
		docElem.appendChild( el ).id = expando;
		return !document.getElementsByName || !document.getElementsByName( expando ).length;
	} );

	// ID filter and find
	if ( support.getById ) {
		Expr.filter[ "ID" ] = function( id ) {
			var attrId = id.replace( runescape, funescape );
			return function( elem ) {
				return elem.getAttribute( "id" ) === attrId;
			};
		};
		Expr.find[ "ID" ] = function( id, context ) {
			if ( typeof context.getElementById !== "undefined" && documentIsHTML ) {
				var elem = context.getElementById( id );
				return elem ? [ elem ] : [];
			}
		};
	} else {
		Expr.filter[ "ID" ] =  function( id ) {
			var attrId = id.replace( runescape, funescape );
			return function( elem ) {
				var node = typeof elem.getAttributeNode !== "undefined" &&
					elem.getAttributeNode( "id" );
				return node && node.value === attrId;
			};
		};

		// Support: IE 6 - 7 only
		// getElementById is not reliable as a find shortcut
		Expr.find[ "ID" ] = function( id, context ) {
			if ( typeof context.getElementById !== "undefined" && documentIsHTML ) {
				var node, i, elems,
					elem = context.getElementById( id );

				if ( elem ) {

					// Verify the id attribute
					node = elem.getAttributeNode( "id" );
					if ( node && node.value === id ) {
						return [ elem ];
					}

					// Fall back on getElementsByName
					elems = context.getElementsByName( id );
					i = 0;
					while ( ( elem = elems[ i++ ] ) ) {
						node = elem.getAttributeNode( "id" );
						if ( node && node.value === id ) {
							return [ elem ];
						}
					}
				}

				return [];
			}
		};
	}

	// Tag
	Expr.find[ "TAG" ] = support.getElementsByTagName ?
		function( tag, context ) {
			if ( typeof context.getElementsByTagName !== "undefined" ) {
				return context.getElementsByTagName( tag );

			// DocumentFragment nodes don't have gEBTN
			} else if ( support.qsa ) {
				return context.querySelectorAll( tag );
			}
		} :

		function( tag, context ) {
			var elem,
				tmp = [],
				i = 0,

				// By happy coincidence, a (broken) gEBTN appears on DocumentFragment nodes too
				results = context.getElementsByTagName( tag );

			// Filter out possible comments
			if ( tag === "*" ) {
				while ( ( elem = results[ i++ ] ) ) {
					if ( elem.nodeType === 1 ) {
						tmp.push( elem );
					}
				}

				return tmp;
			}
			return results;
		};

	// Class
	Expr.find[ "CLASS" ] = support.getElementsByClassName && function( className, context ) {
		if ( typeof context.getElementsByClassName !== "undefined" && documentIsHTML ) {
			return context.getElementsByClassName( className );
		}
	};

	/* QSA/matchesSelector
	---------------------------------------------------------------------- */

	// QSA and matchesSelector support

	// matchesSelector(:active) reports false when true (IE9/Opera 11.5)
	rbuggyMatches = [];

	// qSa(:focus) reports false when true (Chrome 21)
	// We allow this because of a bug in IE8/9 that throws an error
	// whenever `document.activeElement` is accessed on an iframe
	// So, we allow :focus to pass through QSA all the time to avoid the IE error
	// See https://bugs.jquery.com/ticket/13378
	rbuggyQSA = [];

	if ( ( support.qsa = rnative.test( document.querySelectorAll ) ) ) {

		// Build QSA regex
		// Regex strategy adopted from Diego Perini
		assert( function( el ) {

			var input;

			// Select is set to empty string on purpose
			// This is to test IE's treatment of not explicitly
			// setting a boolean content attribute,
			// since its presence should be enough
			// https://bugs.jquery.com/ticket/12359
			docElem.appendChild( el ).innerHTML = "<a id='" + expando + "'></a>" +
				"<select id='" + expando + "-\r\\' msallowcapture=''>" +
				"<option selected=''></option></select>";

			// Support: IE8, Opera 11-12.16
			// Nothing should be selected when empty strings follow ^= or $= or *=
			// The test attribute must be unknown in Opera but "safe" for WinRT
			// https://msdn.microsoft.com/en-us/library/ie/hh465388.aspx#attribute_section
			if ( el.querySelectorAll( "[msallowcapture^='']" ).length ) {
				rbuggyQSA.push( "[*^$]=" + whitespace + "*(?:''|\"\")" );
			}

			// Support: IE8
			// Boolean attributes and "value" are not treated correctly
			if ( !el.querySelectorAll( "[selected]" ).length ) {
				rbuggyQSA.push( "\\[" + whitespace + "*(?:value|" + booleans + ")" );
			}

			// Support: Chrome<29, Android<4.4, Safari<7.0+, iOS<7.0+, PhantomJS<1.9.8+
			if ( !el.querySelectorAll( "[id~=" + expando + "-]" ).length ) {
				rbuggyQSA.push( "~=" );
			}

			// Support: IE 11+, Edge 15 - 18+
			// IE 11/Edge don't find elements on a `[name='']` query in some cases.
			// Adding a temporary attribute to the document before the selection works
			// around the issue.
			// Interestingly, IE 10 & older don't seem to have the issue.
			input = document.createElement( "input" );
			input.setAttribute( "name", "" );
			el.appendChild( input );
			if ( !el.querySelectorAll( "[name='']" ).length ) {
				rbuggyQSA.push( "\\[" + whitespace + "*name" + whitespace + "*=" +
					whitespace + "*(?:''|\"\")" );
			}

			// Webkit/Opera - :checked should return selected option elements
			// http://www.w3.org/TR/2011/REC-css3-selectors-20110929/#checked
			// IE8 throws error here and will not see later tests
			if ( !el.querySelectorAll( ":checked" ).length ) {
				rbuggyQSA.push( ":checked" );
			}

			// Support: Safari 8+, iOS 8+
			// https://bugs.webkit.org/show_bug.cgi?id=136851
			// In-page `selector#id sibling-combinator selector` fails
			if ( !el.querySelectorAll( "a#" + expando + "+*" ).length ) {
				rbuggyQSA.push( ".#.+[+~]" );
			}

			// Support: Firefox <=3.6 - 5 only
			// Old Firefox doesn't throw on a badly-escaped identifier.
			el.querySelectorAll( "\\\f" );
			rbuggyQSA.push( "[\\r\\n\\f]" );
		} );

		assert( function( el ) {
			el.innerHTML = "<a href='' disabled='disabled'></a>" +
				"<select disabled='disabled'><option/></select>";

			// Support: Windows 8 Native Apps
			// The type and name attributes are restricted during .innerHTML assignment
			var input = document.createElement( "input" );
			input.setAttribute( "type", "hidden" );
			el.appendChild( input ).setAttribute( "name", "D" );

			// Support: IE8
			// Enforce case-sensitivity of name attribute
			if ( el.querySelectorAll( "[name=d]" ).length ) {
				rbuggyQSA.push( "name" + whitespace + "*[*^$|!~]?=" );
			}

			// FF 3.5 - :enabled/:disabled and hidden elements (hidden elements are still enabled)
			// IE8 throws error here and will not see later tests
			if ( el.querySelectorAll( ":enabled" ).length !== 2 ) {
				rbuggyQSA.push( ":enabled", ":disabled" );
			}

			// Support: IE9-11+
			// IE's :disabled selector does not pick up the children of disabled fieldsets
			docElem.appendChild( el ).disabled = true;
			if ( el.querySelectorAll( ":disabled" ).length !== 2 ) {
				rbuggyQSA.push( ":enabled", ":disabled" );
			}

			// Support: Opera 10 - 11 only
			// Opera 10-11 does not throw on post-comma invalid pseudos
			el.querySelectorAll( "*,:x" );
			rbuggyQSA.push( ",.*:" );
		} );
	}

	if ( ( support.matchesSelector = rnative.test( ( matches = docElem.matches ||
		docElem.webkitMatchesSelector ||
		docElem.mozMatchesSelector ||
		docElem.oMatchesSelector ||
		docElem.msMatchesSelector ) ) ) ) {

		assert( function( el ) {

			// Check to see if it's possible to do matchesSelector
			// on a disconnected node (IE 9)
			support.disconnectedMatch = matches.call( el, "*" );

			// This should fail with an exception
			// Gecko does not error, returns false instead
			matches.call( el, "[s!='']:x" );
			rbuggyMatches.push( "!=", pseudos );
		} );
	}

	rbuggyQSA = rbuggyQSA.length && new RegExp( rbuggyQSA.join( "|" ) );
	rbuggyMatches = rbuggyMatches.length && new RegExp( rbuggyMatches.join( "|" ) );

	/* Contains
	---------------------------------------------------------------------- */
	hasCompare = rnative.test( docElem.compareDocumentPosition );

	// Element contains another
	// Purposefully self-exclusive
	// As in, an element does not contain itself
	contains = hasCompare || rnative.test( docElem.contains ) ?
		function( a, b ) {
			var adown = a.nodeType === 9 ? a.documentElement : a,
				bup = b && b.parentNode;
			return a === bup || !!( bup && bup.nodeType === 1 && (
				adown.contains ?
					adown.contains( bup ) :
					a.compareDocumentPosition && a.compareDocumentPosition( bup ) & 16
			) );
		} :
		function( a, b ) {
			if ( b ) {
				while ( ( b = b.parentNode ) ) {
					if ( b === a ) {
						return true;
					}
				}
			}
			return false;
		};

	/* Sorting
	---------------------------------------------------------------------- */

	// Document order sorting
	sortOrder = hasCompare ?
	function( a, b ) {

		// Flag for duplicate removal
		if ( a === b ) {
			hasDuplicate = true;
			return 0;
		}

		// Sort on method existence if only one input has compareDocumentPosition
		var compare = !a.compareDocumentPosition - !b.compareDocumentPosition;
		if ( compare ) {
			return compare;
		}

		// Calculate position if both inputs belong to the same document
		// Support: IE 11+, Edge 17 - 18+
		// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
		// two documents; shallow comparisons work.
		// eslint-disable-next-line eqeqeq
		compare = ( a.ownerDocument || a ) == ( b.ownerDocument || b ) ?
			a.compareDocumentPosition( b ) :

			// Otherwise we know they are disconnected
			1;

		// Disconnected nodes
		if ( compare & 1 ||
			( !support.sortDetached && b.compareDocumentPosition( a ) === compare ) ) {

			// Choose the first element that is related to our preferred document
			// Support: IE 11+, Edge 17 - 18+
			// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
			// two documents; shallow comparisons work.
			// eslint-disable-next-line eqeqeq
			if ( a == document || a.ownerDocument == preferredDoc &&
				contains( preferredDoc, a ) ) {
				return -1;
			}

			// Support: IE 11+, Edge 17 - 18+
			// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
			// two documents; shallow comparisons work.
			// eslint-disable-next-line eqeqeq
			if ( b == document || b.ownerDocument == preferredDoc &&
				contains( preferredDoc, b ) ) {
				return 1;
			}

			// Maintain original order
			return sortInput ?
				( indexOf( sortInput, a ) - indexOf( sortInput, b ) ) :
				0;
		}

		return compare & 4 ? -1 : 1;
	} :
	function( a, b ) {

		// Exit early if the nodes are identical
		if ( a === b ) {
			hasDuplicate = true;
			return 0;
		}

		var cur,
			i = 0,
			aup = a.parentNode,
			bup = b.parentNode,
			ap = [ a ],
			bp = [ b ];

		// Parentless nodes are either documents or disconnected
		if ( !aup || !bup ) {

			// Support: IE 11+, Edge 17 - 18+
			// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
			// two documents; shallow comparisons work.
			/* eslint-disable eqeqeq */
			return a == document ? -1 :
				b == document ? 1 :
				/* eslint-enable eqeqeq */
				aup ? -1 :
				bup ? 1 :
				sortInput ?
				( indexOf( sortInput, a ) - indexOf( sortInput, b ) ) :
				0;

		// If the nodes are siblings, we can do a quick check
		} else if ( aup === bup ) {
			return siblingCheck( a, b );
		}

		// Otherwise we need full lists of their ancestors for comparison
		cur = a;
		while ( ( cur = cur.parentNode ) ) {
			ap.unshift( cur );
		}
		cur = b;
		while ( ( cur = cur.parentNode ) ) {
			bp.unshift( cur );
		}

		// Walk down the tree looking for a discrepancy
		while ( ap[ i ] === bp[ i ] ) {
			i++;
		}

		return i ?

			// Do a sibling check if the nodes have a common ancestor
			siblingCheck( ap[ i ], bp[ i ] ) :

			// Otherwise nodes in our document sort first
			// Support: IE 11+, Edge 17 - 18+
			// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
			// two documents; shallow comparisons work.
			/* eslint-disable eqeqeq */
			ap[ i ] == preferredDoc ? -1 :
			bp[ i ] == preferredDoc ? 1 :
			/* eslint-enable eqeqeq */
			0;
	};

	return document;
};

Sizzle.matches = function( expr, elements ) {
	return Sizzle( expr, null, null, elements );
};

Sizzle.matchesSelector = function( elem, expr ) {
	setDocument( elem );

	if ( support.matchesSelector && documentIsHTML &&
		!nonnativeSelectorCache[ expr + " " ] &&
		( !rbuggyMatches || !rbuggyMatches.test( expr ) ) &&
		( !rbuggyQSA     || !rbuggyQSA.test( expr ) ) ) {

		try {
			var ret = matches.call( elem, expr );

			// IE 9's matchesSelector returns false on disconnected nodes
			if ( ret || support.disconnectedMatch ||

				// As well, disconnected nodes are said to be in a document
				// fragment in IE 9
				elem.document && elem.document.nodeType !== 11 ) {
				return ret;
			}
		} catch ( e ) {
			nonnativeSelectorCache( expr, true );
		}
	}

	return Sizzle( expr, document, null, [ elem ] ).length > 0;
};

Sizzle.contains = function( context, elem ) {

	// Set document vars if needed
	// Support: IE 11+, Edge 17 - 18+
	// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
	// two documents; shallow comparisons work.
	// eslint-disable-next-line eqeqeq
	if ( ( context.ownerDocument || context ) != document ) {
		setDocument( context );
	}
	return contains( context, elem );
};

Sizzle.attr = function( elem, name ) {

	// Set document vars if needed
	// Support: IE 11+, Edge 17 - 18+
	// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
	// two documents; shallow comparisons work.
	// eslint-disable-next-line eqeqeq
	if ( ( elem.ownerDocument || elem ) != document ) {
		setDocument( elem );
	}

	var fn = Expr.attrHandle[ name.toLowerCase() ],

		// Don't get fooled by Object.prototype properties (jQuery #13807)
		val = fn && hasOwn.call( Expr.attrHandle, name.toLowerCase() ) ?
			fn( elem, name, !documentIsHTML ) :
			undefined;

	return val !== undefined ?
		val :
		support.attributes || !documentIsHTML ?
			elem.getAttribute( name ) :
			( val = elem.getAttributeNode( name ) ) && val.specified ?
				val.value :
				null;
};

Sizzle.escape = function( sel ) {
	return ( sel + "" ).replace( rcssescape, fcssescape );
};

Sizzle.error = function( msg ) {
	throw new Error( "Syntax error, unrecognized expression: " + msg );
};

/**
 * Document sorting and removing duplicates
 * @param {ArrayLike} results
 */
Sizzle.uniqueSort = function( results ) {
	var elem,
		duplicates = [],
		j = 0,
		i = 0;

	// Unless we *know* we can detect duplicates, assume their presence
	hasDuplicate = !support.detectDuplicates;
	sortInput = !support.sortStable && results.slice( 0 );
	results.sort( sortOrder );

	if ( hasDuplicate ) {
		while ( ( elem = results[ i++ ] ) ) {
			if ( elem === results[ i ] ) {
				j = duplicates.push( i );
			}
		}
		while ( j-- ) {
			results.splice( duplicates[ j ], 1 );
		}
	}

	// Clear input after sorting to release objects
	// See https://github.com/jquery/sizzle/pull/225
	sortInput = null;

	return results;
};

/**
 * Utility function for retrieving the text value of an array of DOM nodes
 * @param {Array|Element} elem
 */
getText = Sizzle.getText = function( elem ) {
	var node,
		ret = "",
		i = 0,
		nodeType = elem.nodeType;

	if ( !nodeType ) {

		// If no nodeType, this is expected to be an array
		while ( ( node = elem[ i++ ] ) ) {

			// Do not traverse comment nodes
			ret += getText( node );
		}
	} else if ( nodeType === 1 || nodeType === 9 || nodeType === 11 ) {

		// Use textContent for elements
		// innerText usage removed for consistency of new lines (jQuery #11153)
		if ( typeof elem.textContent === "string" ) {
			return elem.textContent;
		} else {

			// Traverse its children
			for ( elem = elem.firstChild; elem; elem = elem.nextSibling ) {
				ret += getText( elem );
			}
		}
	} else if ( nodeType === 3 || nodeType === 4 ) {
		return elem.nodeValue;
	}

	// Do not include comment or processing instruction nodes

	return ret;
};

Expr = Sizzle.selectors = {

	// Can be adjusted by the user
	cacheLength: 50,

	createPseudo: markFunction,

	match: matchExpr,

	attrHandle: {},

	find: {},

	relative: {
		">": { dir: "parentNode", first: true },
		" ": { dir: "parentNode" },
		"+": { dir: "previousSibling", first: true },
		"~": { dir: "previousSibling" }
	},

	preFilter: {
		"ATTR": function( match ) {
			match[ 1 ] = match[ 1 ].replace( runescape, funescape );

			// Move the given value to match[3] whether quoted or unquoted
			match[ 3 ] = ( match[ 3 ] || match[ 4 ] ||
				match[ 5 ] || "" ).replace( runescape, funescape );

			if ( match[ 2 ] === "~=" ) {
				match[ 3 ] = " " + match[ 3 ] + " ";
			}

			return match.slice( 0, 4 );
		},

		"CHILD": function( match ) {

			/* matches from matchExpr["CHILD"]
				1 type (only|nth|...)
				2 what (child|of-type)
				3 argument (even|odd|\d*|\d*n([+-]\d+)?|...)
				4 xn-component of xn+y argument ([+-]?\d*n|)
				5 sign of xn-component
				6 x of xn-component
				7 sign of y-component
				8 y of y-component
			*/
			match[ 1 ] = match[ 1 ].toLowerCase();

			if ( match[ 1 ].slice( 0, 3 ) === "nth" ) {

				// nth-* requires argument
				if ( !match[ 3 ] ) {
					Sizzle.error( match[ 0 ] );
				}

				// numeric x and y parameters for Expr.filter.CHILD
				// remember that false/true cast respectively to 0/1
				match[ 4 ] = +( match[ 4 ] ?
					match[ 5 ] + ( match[ 6 ] || 1 ) :
					2 * ( match[ 3 ] === "even" || match[ 3 ] === "odd" ) );
				match[ 5 ] = +( ( match[ 7 ] + match[ 8 ] ) || match[ 3 ] === "odd" );

				// other types prohibit arguments
			} else if ( match[ 3 ] ) {
				Sizzle.error( match[ 0 ] );
			}

			return match;
		},

		"PSEUDO": function( match ) {
			var excess,
				unquoted = !match[ 6 ] && match[ 2 ];

			if ( matchExpr[ "CHILD" ].test( match[ 0 ] ) ) {
				return null;
			}

			// Accept quoted arguments as-is
			if ( match[ 3 ] ) {
				match[ 2 ] = match[ 4 ] || match[ 5 ] || "";

			// Strip excess characters from unquoted arguments
			} else if ( unquoted && rpseudo.test( unquoted ) &&

				// Get excess from tokenize (recursively)
				( excess = tokenize( unquoted, true ) ) &&

				// advance to the next closing parenthesis
				( excess = unquoted.indexOf( ")", unquoted.length - excess ) - unquoted.length ) ) {

				// excess is a negative index
				match[ 0 ] = match[ 0 ].slice( 0, excess );
				match[ 2 ] = unquoted.slice( 0, excess );
			}

			// Return only captures needed by the pseudo filter method (type and argument)
			return match.slice( 0, 3 );
		}
	},

	filter: {

		"TAG": function( nodeNameSelector ) {
			var nodeName = nodeNameSelector.replace( runescape, funescape ).toLowerCase();
			return nodeNameSelector === "*" ?
				function() {
					return true;
				} :
				function( elem ) {
					return elem.nodeName && elem.nodeName.toLowerCase() === nodeName;
				};
		},

		"CLASS": function( className ) {
			var pattern = classCache[ className + " " ];

			return pattern ||
				( pattern = new RegExp( "(^|" + whitespace +
					")" + className + "(" + whitespace + "|$)" ) ) && classCache(
						className, function( elem ) {
							return pattern.test(
								typeof elem.className === "string" && elem.className ||
								typeof elem.getAttribute !== "undefined" &&
									elem.getAttribute( "class" ) ||
								""
							);
				} );
		},

		"ATTR": function( name, operator, check ) {
			return function( elem ) {
				var result = Sizzle.attr( elem, name );

				if ( result == null ) {
					return operator === "!=";
				}
				if ( !operator ) {
					return true;
				}

				result += "";

				/* eslint-disable max-len */

				return operator === "=" ? result === check :
					operator === "!=" ? result !== check :
					operator === "^=" ? check && result.indexOf( check ) === 0 :
					operator === "*=" ? check && result.indexOf( check ) > -1 :
					operator === "$=" ? check && result.slice( -check.length ) === check :
					operator === "~=" ? ( " " + result.replace( rwhitespace, " " ) + " " ).indexOf( check ) > -1 :
					operator === "|=" ? result === check || result.slice( 0, check.length + 1 ) === check + "-" :
					false;
				/* eslint-enable max-len */

			};
		},

		"CHILD": function( type, what, _argument, first, last ) {
			var simple = type.slice( 0, 3 ) !== "nth",
				forward = type.slice( -4 ) !== "last",
				ofType = what === "of-type";

			return first === 1 && last === 0 ?

				// Shortcut for :nth-*(n)
				function( elem ) {
					return !!elem.parentNode;
				} :

				function( elem, _context, xml ) {
					var cache, uniqueCache, outerCache, node, nodeIndex, start,
						dir = simple !== forward ? "nextSibling" : "previousSibling",
						parent = elem.parentNode,
						name = ofType && elem.nodeName.toLowerCase(),
						useCache = !xml && !ofType,
						diff = false;

					if ( parent ) {

						// :(first|last|only)-(child|of-type)
						if ( simple ) {
							while ( dir ) {
								node = elem;
								while ( ( node = node[ dir ] ) ) {
									if ( ofType ?
										node.nodeName.toLowerCase() === name :
										node.nodeType === 1 ) {

										return false;
									}
								}

								// Reverse direction for :only-* (if we haven't yet done so)
								start = dir = type === "only" && !start && "nextSibling";
							}
							return true;
						}

						start = [ forward ? parent.firstChild : parent.lastChild ];

						// non-xml :nth-child(...) stores cache data on `parent`
						if ( forward && useCache ) {

							// Seek `elem` from a previously-cached index

							// ...in a gzip-friendly way
							node = parent;
							outerCache = node[ expando ] || ( node[ expando ] = {} );

							// Support: IE <9 only
							// Defend against cloned attroperties (jQuery gh-1709)
							uniqueCache = outerCache[ node.uniqueID ] ||
								( outerCache[ node.uniqueID ] = {} );

							cache = uniqueCache[ type ] || [];
							nodeIndex = cache[ 0 ] === dirruns && cache[ 1 ];
							diff = nodeIndex && cache[ 2 ];
							node = nodeIndex && parent.childNodes[ nodeIndex ];

							while ( ( node = ++nodeIndex && node && node[ dir ] ||

								// Fallback to seeking `elem` from the start
								( diff = nodeIndex = 0 ) || start.pop() ) ) {

								// When found, cache indexes on `parent` and break
								if ( node.nodeType === 1 && ++diff && node === elem ) {
									uniqueCache[ type ] = [ dirruns, nodeIndex, diff ];
									break;
								}
							}

						} else {

							// Use previously-cached element index if available
							if ( useCache ) {

								// ...in a gzip-friendly way
								node = elem;
								outerCache = node[ expando ] || ( node[ expando ] = {} );

								// Support: IE <9 only
								// Defend against cloned attroperties (jQuery gh-1709)
								uniqueCache = outerCache[ node.uniqueID ] ||
									( outerCache[ node.uniqueID ] = {} );

								cache = uniqueCache[ type ] || [];
								nodeIndex = cache[ 0 ] === dirruns && cache[ 1 ];
								diff = nodeIndex;
							}

							// xml :nth-child(...)
							// or :nth-last-child(...) or :nth(-last)?-of-type(...)
							if ( diff === false ) {

								// Use the same loop as above to seek `elem` from the start
								while ( ( node = ++nodeIndex && node && node[ dir ] ||
									( diff = nodeIndex = 0 ) || start.pop() ) ) {

									if ( ( ofType ?
										node.nodeName.toLowerCase() === name :
										node.nodeType === 1 ) &&
										++diff ) {

										// Cache the index of each encountered element
										if ( useCache ) {
											outerCache = node[ expando ] ||
												( node[ expando ] = {} );

											// Support: IE <9 only
											// Defend against cloned attroperties (jQuery gh-1709)
											uniqueCache = outerCache[ node.uniqueID ] ||
												( outerCache[ node.uniqueID ] = {} );

											uniqueCache[ type ] = [ dirruns, diff ];
										}

										if ( node === elem ) {
											break;
										}
									}
								}
							}
						}

						// Incorporate the offset, then check against cycle size
						diff -= last;
						return diff === first || ( diff % first === 0 && diff / first >= 0 );
					}
				};
		},

		"PSEUDO": function( pseudo, argument ) {

			// pseudo-class names are case-insensitive
			// http://www.w3.org/TR/selectors/#pseudo-classes
			// Prioritize by case sensitivity in case custom pseudos are added with uppercase letters
			// Remember that setFilters inherits from pseudos
			var args,
				fn = Expr.pseudos[ pseudo ] || Expr.setFilters[ pseudo.toLowerCase() ] ||
					Sizzle.error( "unsupported pseudo: " + pseudo );

			// The user may use createPseudo to indicate that
			// arguments are needed to create the filter function
			// just as Sizzle does
			if ( fn[ expando ] ) {
				return fn( argument );
			}

			// But maintain support for old signatures
			if ( fn.length > 1 ) {
				args = [ pseudo, pseudo, "", argument ];
				return Expr.setFilters.hasOwnProperty( pseudo.toLowerCase() ) ?
					markFunction( function( seed, matches ) {
						var idx,
							matched = fn( seed, argument ),
							i = matched.length;
						while ( i-- ) {
							idx = indexOf( seed, matched[ i ] );
							seed[ idx ] = !( matches[ idx ] = matched[ i ] );
						}
					} ) :
					function( elem ) {
						return fn( elem, 0, args );
					};
			}

			return fn;
		}
	},

	pseudos: {

		// Potentially complex pseudos
		"not": markFunction( function( selector ) {

			// Trim the selector passed to compile
			// to avoid treating leading and trailing
			// spaces as combinators
			var input = [],
				results = [],
				matcher = compile( selector.replace( rtrim, "$1" ) );

			return matcher[ expando ] ?
				markFunction( function( seed, matches, _context, xml ) {
					var elem,
						unmatched = matcher( seed, null, xml, [] ),
						i = seed.length;

					// Match elements unmatched by `matcher`
					while ( i-- ) {
						if ( ( elem = unmatched[ i ] ) ) {
							seed[ i ] = !( matches[ i ] = elem );
						}
					}
				} ) :
				function( elem, _context, xml ) {
					input[ 0 ] = elem;
					matcher( input, null, xml, results );

					// Don't keep the element (issue #299)
					input[ 0 ] = null;
					return !results.pop();
				};
		} ),

		"has": markFunction( function( selector ) {
			return function( elem ) {
				return Sizzle( selector, elem ).length > 0;
			};
		} ),

		"contains": markFunction( function( text ) {
			text = text.replace( runescape, funescape );
			return function( elem ) {
				return ( elem.textContent || getText( elem ) ).indexOf( text ) > -1;
			};
		} ),

		// "Whether an element is represented by a :lang() selector
		// is based solely on the element's language value
		// being equal to the identifier C,
		// or beginning with the identifier C immediately followed by "-".
		// The matching of C against the element's language value is performed case-insensitively.
		// The identifier C does not have to be a valid language name."
		// http://www.w3.org/TR/selectors/#lang-pseudo
		"lang": markFunction( function( lang ) {

			// lang value must be a valid identifier
			if ( !ridentifier.test( lang || "" ) ) {
				Sizzle.error( "unsupported lang: " + lang );
			}
			lang = lang.replace( runescape, funescape ).toLowerCase();
			return function( elem ) {
				var elemLang;
				do {
					if ( ( elemLang = documentIsHTML ?
						elem.lang :
						elem.getAttribute( "xml:lang" ) || elem.getAttribute( "lang" ) ) ) {

						elemLang = elemLang.toLowerCase();
						return elemLang === lang || elemLang.indexOf( lang + "-" ) === 0;
					}
				} while ( ( elem = elem.parentNode ) && elem.nodeType === 1 );
				return false;
			};
		} ),

		// Miscellaneous
		"target": function( elem ) {
			var hash = window.location && window.location.hash;
			return hash && hash.slice( 1 ) === elem.id;
		},

		"root": function( elem ) {
			return elem === docElem;
		},

		"focus": function( elem ) {
			return elem === document.activeElement &&
				( !document.hasFocus || document.hasFocus() ) &&
				!!( elem.type || elem.href || ~elem.tabIndex );
		},

		// Boolean properties
		"enabled": createDisabledPseudo( false ),
		"disabled": createDisabledPseudo( true ),

		"checked": function( elem ) {

			// In CSS3, :checked should return both checked and selected elements
			// http://www.w3.org/TR/2011/REC-css3-selectors-20110929/#checked
			var nodeName = elem.nodeName.toLowerCase();
			return ( nodeName === "input" && !!elem.checked ) ||
				( nodeName === "option" && !!elem.selected );
		},

		"selected": function( elem ) {

			// Accessing this property makes selected-by-default
			// options in Safari work properly
			if ( elem.parentNode ) {
				// eslint-disable-next-line no-unused-expressions
				elem.parentNode.selectedIndex;
			}

			return elem.selected === true;
		},

		// Contents
		"empty": function( elem ) {

			// http://www.w3.org/TR/selectors/#empty-pseudo
			// :empty is negated by element (1) or content nodes (text: 3; cdata: 4; entity ref: 5),
			//   but not by others (comment: 8; processing instruction: 7; etc.)
			// nodeType < 6 works because attributes (2) do not appear as children
			for ( elem = elem.firstChild; elem; elem = elem.nextSibling ) {
				if ( elem.nodeType < 6 ) {
					return false;
				}
			}
			return true;
		},

		"parent": function( elem ) {
			return !Expr.pseudos[ "empty" ]( elem );
		},

		// Element/input types
		"header": function( elem ) {
			return rheader.test( elem.nodeName );
		},

		"input": function( elem ) {
			return rinputs.test( elem.nodeName );
		},

		"button": function( elem ) {
			var name = elem.nodeName.toLowerCase();
			return name === "input" && elem.type === "button" || name === "button";
		},

		"text": function( elem ) {
			var attr;
			return elem.nodeName.toLowerCase() === "input" &&
				elem.type === "text" &&

				// Support: IE<8
				// New HTML5 attribute values (e.g., "search") appear with elem.type === "text"
				( ( attr = elem.getAttribute( "type" ) ) == null ||
					attr.toLowerCase() === "text" );
		},

		// Position-in-collection
		"first": createPositionalPseudo( function() {
			return [ 0 ];
		} ),

		"last": createPositionalPseudo( function( _matchIndexes, length ) {
			return [ length - 1 ];
		} ),

		"eq": createPositionalPseudo( function( _matchIndexes, length, argument ) {
			return [ argument < 0 ? argument + length : argument ];
		} ),

		"even": createPositionalPseudo( function( matchIndexes, length ) {
			var i = 0;
			for ( ; i < length; i += 2 ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		} ),

		"odd": createPositionalPseudo( function( matchIndexes, length ) {
			var i = 1;
			for ( ; i < length; i += 2 ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		} ),

		"lt": createPositionalPseudo( function( matchIndexes, length, argument ) {
			var i = argument < 0 ?
				argument + length :
				argument > length ?
					length :
					argument;
			for ( ; --i >= 0; ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		} ),

		"gt": createPositionalPseudo( function( matchIndexes, length, argument ) {
			var i = argument < 0 ? argument + length : argument;
			for ( ; ++i < length; ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		} )
	}
};

Expr.pseudos[ "nth" ] = Expr.pseudos[ "eq" ];

// Add button/input type pseudos
for ( i in { radio: true, checkbox: true, file: true, password: true, image: true } ) {
	Expr.pseudos[ i ] = createInputPseudo( i );
}
for ( i in { submit: true, reset: true } ) {
	Expr.pseudos[ i ] = createButtonPseudo( i );
}

// Easy API for creating new setFilters
function setFilters() {}
setFilters.prototype = Expr.filters = Expr.pseudos;
Expr.setFilters = new setFilters();

tokenize = Sizzle.tokenize = function( selector, parseOnly ) {
	var matched, match, tokens, type,
		soFar, groups, preFilters,
		cached = tokenCache[ selector + " " ];

	if ( cached ) {
		return parseOnly ? 0 : cached.slice( 0 );
	}

	soFar = selector;
	groups = [];
	preFilters = Expr.preFilter;

	while ( soFar ) {

		// Comma and first run
		if ( !matched || ( match = rcomma.exec( soFar ) ) ) {
			if ( match ) {

				// Don't consume trailing commas as valid
				soFar = soFar.slice( match[ 0 ].length ) || soFar;
			}
			groups.push( ( tokens = [] ) );
		}

		matched = false;

		// Combinators
		if ( ( match = rcombinators.exec( soFar ) ) ) {
			matched = match.shift();
			tokens.push( {
				value: matched,

				// Cast descendant combinators to space
				type: match[ 0 ].replace( rtrim, " " )
			} );
			soFar = soFar.slice( matched.length );
		}

		// Filters
		for ( type in Expr.filter ) {
			if ( ( match = matchExpr[ type ].exec( soFar ) ) && ( !preFilters[ type ] ||
				( match = preFilters[ type ]( match ) ) ) ) {
				matched = match.shift();
				tokens.push( {
					value: matched,
					type: type,
					matches: match
				} );
				soFar = soFar.slice( matched.length );
			}
		}

		if ( !matched ) {
			break;
		}
	}

	// Return the length of the invalid excess
	// if we're just parsing
	// Otherwise, throw an error or return tokens
	return parseOnly ?
		soFar.length :
		soFar ?
			Sizzle.error( selector ) :

			// Cache the tokens
			tokenCache( selector, groups ).slice( 0 );
};

function toSelector( tokens ) {
	var i = 0,
		len = tokens.length,
		selector = "";
	for ( ; i < len; i++ ) {
		selector += tokens[ i ].value;
	}
	return selector;
}

function addCombinator( matcher, combinator, base ) {
	var dir = combinator.dir,
		skip = combinator.next,
		key = skip || dir,
		checkNonElements = base && key === "parentNode",
		doneName = done++;

	return combinator.first ?

		// Check against closest ancestor/preceding element
		function( elem, context, xml ) {
			while ( ( elem = elem[ dir ] ) ) {
				if ( elem.nodeType === 1 || checkNonElements ) {
					return matcher( elem, context, xml );
				}
			}
			return false;
		} :

		// Check against all ancestor/preceding elements
		function( elem, context, xml ) {
			var oldCache, uniqueCache, outerCache,
				newCache = [ dirruns, doneName ];

			// We can't set arbitrary data on XML nodes, so they don't benefit from combinator caching
			if ( xml ) {
				while ( ( elem = elem[ dir ] ) ) {
					if ( elem.nodeType === 1 || checkNonElements ) {
						if ( matcher( elem, context, xml ) ) {
							return true;
						}
					}
				}
			} else {
				while ( ( elem = elem[ dir ] ) ) {
					if ( elem.nodeType === 1 || checkNonElements ) {
						outerCache = elem[ expando ] || ( elem[ expando ] = {} );

						// Support: IE <9 only
						// Defend against cloned attroperties (jQuery gh-1709)
						uniqueCache = outerCache[ elem.uniqueID ] ||
							( outerCache[ elem.uniqueID ] = {} );

						if ( skip && skip === elem.nodeName.toLowerCase() ) {
							elem = elem[ dir ] || elem;
						} else if ( ( oldCache = uniqueCache[ key ] ) &&
							oldCache[ 0 ] === dirruns && oldCache[ 1 ] === doneName ) {

							// Assign to newCache so results back-propagate to previous elements
							return ( newCache[ 2 ] = oldCache[ 2 ] );
						} else {

							// Reuse newcache so results back-propagate to previous elements
							uniqueCache[ key ] = newCache;

							// A match means we're done; a fail means we have to keep checking
							if ( ( newCache[ 2 ] = matcher( elem, context, xml ) ) ) {
								return true;
							}
						}
					}
				}
			}
			return false;
		};
}

function elementMatcher( matchers ) {
	return matchers.length > 1 ?
		function( elem, context, xml ) {
			var i = matchers.length;
			while ( i-- ) {
				if ( !matchers[ i ]( elem, context, xml ) ) {
					return false;
				}
			}
			return true;
		} :
		matchers[ 0 ];
}

function multipleContexts( selector, contexts, results ) {
	var i = 0,
		len = contexts.length;
	for ( ; i < len; i++ ) {
		Sizzle( selector, contexts[ i ], results );
	}
	return results;
}

function condense( unmatched, map, filter, context, xml ) {
	var elem,
		newUnmatched = [],
		i = 0,
		len = unmatched.length,
		mapped = map != null;

	for ( ; i < len; i++ ) {
		if ( ( elem = unmatched[ i ] ) ) {
			if ( !filter || filter( elem, context, xml ) ) {
				newUnmatched.push( elem );
				if ( mapped ) {
					map.push( i );
				}
			}
		}
	}

	return newUnmatched;
}

function setMatcher( preFilter, selector, matcher, postFilter, postFinder, postSelector ) {
	if ( postFilter && !postFilter[ expando ] ) {
		postFilter = setMatcher( postFilter );
	}
	if ( postFinder && !postFinder[ expando ] ) {
		postFinder = setMatcher( postFinder, postSelector );
	}
	return markFunction( function( seed, results, context, xml ) {
		var temp, i, elem,
			preMap = [],
			postMap = [],
			preexisting = results.length,

			// Get initial elements from seed or context
			elems = seed || multipleContexts(
				selector || "*",
				context.nodeType ? [ context ] : context,
				[]
			),

			// Prefilter to get matcher input, preserving a map for seed-results synchronization
			matcherIn = preFilter && ( seed || !selector ) ?
				condense( elems, preMap, preFilter, context, xml ) :
				elems,

			matcherOut = matcher ?

				// If we have a postFinder, or filtered seed, or non-seed postFilter or preexisting results,
				postFinder || ( seed ? preFilter : preexisting || postFilter ) ?

					// ...intermediate processing is necessary
					[] :

					// ...otherwise use results directly
					results :
				matcherIn;

		// Find primary matches
		if ( matcher ) {
			matcher( matcherIn, matcherOut, context, xml );
		}

		// Apply postFilter
		if ( postFilter ) {
			temp = condense( matcherOut, postMap );
			postFilter( temp, [], context, xml );

			// Un-match failing elements by moving them back to matcherIn
			i = temp.length;
			while ( i-- ) {
				if ( ( elem = temp[ i ] ) ) {
					matcherOut[ postMap[ i ] ] = !( matcherIn[ postMap[ i ] ] = elem );
				}
			}
		}

		if ( seed ) {
			if ( postFinder || preFilter ) {
				if ( postFinder ) {

					// Get the final matcherOut by condensing this intermediate into postFinder contexts
					temp = [];
					i = matcherOut.length;
					while ( i-- ) {
						if ( ( elem = matcherOut[ i ] ) ) {

							// Restore matcherIn since elem is not yet a final match
							temp.push( ( matcherIn[ i ] = elem ) );
						}
					}
					postFinder( null, ( matcherOut = [] ), temp, xml );
				}

				// Move matched elements from seed to results to keep them synchronized
				i = matcherOut.length;
				while ( i-- ) {
					if ( ( elem = matcherOut[ i ] ) &&
						( temp = postFinder ? indexOf( seed, elem ) : preMap[ i ] ) > -1 ) {

						seed[ temp ] = !( results[ temp ] = elem );
					}
				}
			}

		// Add elements to results, through postFinder if defined
		} else {
			matcherOut = condense(
				matcherOut === results ?
					matcherOut.splice( preexisting, matcherOut.length ) :
					matcherOut
			);
			if ( postFinder ) {
				postFinder( null, results, matcherOut, xml );
			} else {
				push.apply( results, matcherOut );
			}
		}
	} );
}

function matcherFromTokens( tokens ) {
	var checkContext, matcher, j,
		len = tokens.length,
		leadingRelative = Expr.relative[ tokens[ 0 ].type ],
		implicitRelative = leadingRelative || Expr.relative[ " " ],
		i = leadingRelative ? 1 : 0,

		// The foundational matcher ensures that elements are reachable from top-level context(s)
		matchContext = addCombinator( function( elem ) {
			return elem === checkContext;
		}, implicitRelative, true ),
		matchAnyContext = addCombinator( function( elem ) {
			return indexOf( checkContext, elem ) > -1;
		}, implicitRelative, true ),
		matchers = [ function( elem, context, xml ) {
			var ret = ( !leadingRelative && ( xml || context !== outermostContext ) ) || (
				( checkContext = context ).nodeType ?
					matchContext( elem, context, xml ) :
					matchAnyContext( elem, context, xml ) );

			// Avoid hanging onto element (issue #299)
			checkContext = null;
			return ret;
		} ];

	for ( ; i < len; i++ ) {
		if ( ( matcher = Expr.relative[ tokens[ i ].type ] ) ) {
			matchers = [ addCombinator( elementMatcher( matchers ), matcher ) ];
		} else {
			matcher = Expr.filter[ tokens[ i ].type ].apply( null, tokens[ i ].matches );

			// Return special upon seeing a positional matcher
			if ( matcher[ expando ] ) {

				// Find the next relative operator (if any) for proper handling
				j = ++i;
				for ( ; j < len; j++ ) {
					if ( Expr.relative[ tokens[ j ].type ] ) {
						break;
					}
				}
				return setMatcher(
					i > 1 && elementMatcher( matchers ),
					i > 1 && toSelector(

					// If the preceding token was a descendant combinator, insert an implicit any-element `*`
					tokens
						.slice( 0, i - 1 )
						.concat( { value: tokens[ i - 2 ].type === " " ? "*" : "" } )
					).replace( rtrim, "$1" ),
					matcher,
					i < j && matcherFromTokens( tokens.slice( i, j ) ),
					j < len && matcherFromTokens( ( tokens = tokens.slice( j ) ) ),
					j < len && toSelector( tokens )
				);
			}
			matchers.push( matcher );
		}
	}

	return elementMatcher( matchers );
}

function matcherFromGroupMatchers( elementMatchers, setMatchers ) {
	var bySet = setMatchers.length > 0,
		byElement = elementMatchers.length > 0,
		superMatcher = function( seed, context, xml, results, outermost ) {
			var elem, j, matcher,
				matchedCount = 0,
				i = "0",
				unmatched = seed && [],
				setMatched = [],
				contextBackup = outermostContext,

				// We must always have either seed elements or outermost context
				elems = seed || byElement && Expr.find[ "TAG" ]( "*", outermost ),

				// Use integer dirruns iff this is the outermost matcher
				dirrunsUnique = ( dirruns += contextBackup == null ? 1 : Math.random() || 0.1 ),
				len = elems.length;

			if ( outermost ) {

				// Support: IE 11+, Edge 17 - 18+
				// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
				// two documents; shallow comparisons work.
				// eslint-disable-next-line eqeqeq
				outermostContext = context == document || context || outermost;
			}

			// Add elements passing elementMatchers directly to results
			// Support: IE<9, Safari
			// Tolerate NodeList properties (IE: "length"; Safari: <number>) matching elements by id
			for ( ; i !== len && ( elem = elems[ i ] ) != null; i++ ) {
				if ( byElement && elem ) {
					j = 0;

					// Support: IE 11+, Edge 17 - 18+
					// IE/Edge sometimes throw a "Permission denied" error when strict-comparing
					// two documents; shallow comparisons work.
					// eslint-disable-next-line eqeqeq
					if ( !context && elem.ownerDocument != document ) {
						setDocument( elem );
						xml = !documentIsHTML;
					}
					while ( ( matcher = elementMatchers[ j++ ] ) ) {
						if ( matcher( elem, context || document, xml ) ) {
							results.push( elem );
							break;
						}
					}
					if ( outermost ) {
						dirruns = dirrunsUnique;
					}
				}

				// Track unmatched elements for set filters
				if ( bySet ) {

					// They will have gone through all possible matchers
					if ( ( elem = !matcher && elem ) ) {
						matchedCount--;
					}

					// Lengthen the array for every element, matched or not
					if ( seed ) {
						unmatched.push( elem );
					}
				}
			}

			// `i` is now the count of elements visited above, and adding it to `matchedCount`
			// makes the latter nonnegative.
			matchedCount += i;

			// Apply set filters to unmatched elements
			// NOTE: This can be skipped if there are no unmatched elements (i.e., `matchedCount`
			// equals `i`), unless we didn't visit _any_ elements in the above loop because we have
			// no element matchers and no seed.
			// Incrementing an initially-string "0" `i` allows `i` to remain a string only in that
			// case, which will result in a "00" `matchedCount` that differs from `i` but is also
			// numerically zero.
			if ( bySet && i !== matchedCount ) {
				j = 0;
				while ( ( matcher = setMatchers[ j++ ] ) ) {
					matcher( unmatched, setMatched, context, xml );
				}

				if ( seed ) {

					// Reintegrate element matches to eliminate the need for sorting
					if ( matchedCount > 0 ) {
						while ( i-- ) {
							if ( !( unmatched[ i ] || setMatched[ i ] ) ) {
								setMatched[ i ] = pop.call( results );
							}
						}
					}

					// Discard index placeholder values to get only actual matches
					setMatched = condense( setMatched );
				}

				// Add matches to results
				push.apply( results, setMatched );

				// Seedless set matches succeeding multiple successful matchers stipulate sorting
				if ( outermost && !seed && setMatched.length > 0 &&
					( matchedCount + setMatchers.length ) > 1 ) {

					Sizzle.uniqueSort( results );
				}
			}

			// Override manipulation of globals by nested matchers
			if ( outermost ) {
				dirruns = dirrunsUnique;
				outermostContext = contextBackup;
			}

			return unmatched;
		};

	return bySet ?
		markFunction( superMatcher ) :
		superMatcher;
}

compile = Sizzle.compile = function( selector, match /* Internal Use Only */ ) {
	var i,
		setMatchers = [],
		elementMatchers = [],
		cached = compilerCache[ selector + " " ];

	if ( !cached ) {

		// Generate a function of recursive functions that can be used to check each element
		if ( !match ) {
			match = tokenize( selector );
		}
		i = match.length;
		while ( i-- ) {
			cached = matcherFromTokens( match[ i ] );
			if ( cached[ expando ] ) {
				setMatchers.push( cached );
			} else {
				elementMatchers.push( cached );
			}
		}

		// Cache the compiled function
		cached = compilerCache(
			selector,
			matcherFromGroupMatchers( elementMatchers, setMatchers )
		);

		// Save selector and tokenization
		cached.selector = selector;
	}
	return cached;
};

/**
 * A low-level selection function that works with Sizzle's compiled
 *  selector functions
 * @param {String|Function} selector A selector or a pre-compiled
 *  selector function built with Sizzle.compile
 * @param {Element} context
 * @param {Array} [results]
 * @param {Array} [seed] A set of elements to match against
 */
select = Sizzle.select = function( selector, context, results, seed ) {
	var i, tokens, token, type, find,
		compiled = typeof selector === "function" && selector,
		match = !seed && tokenize( ( selector = compiled.selector || selector ) );

	results = results || [];

	// Try to minimize operations if there is only one selector in the list and no seed
	// (the latter of which guarantees us context)
	if ( match.length === 1 ) {

		// Reduce context if the leading compound selector is an ID
		tokens = match[ 0 ] = match[ 0 ].slice( 0 );
		if ( tokens.length > 2 && ( token = tokens[ 0 ] ).type === "ID" &&
			context.nodeType === 9 && documentIsHTML && Expr.relative[ tokens[ 1 ].type ] ) {

			context = ( Expr.find[ "ID" ]( token.matches[ 0 ]
				.replace( runescape, funescape ), context ) || [] )[ 0 ];
			if ( !context ) {
				return results;

			// Precompiled matchers will still verify ancestry, so step up a level
			} else if ( compiled ) {
				context = context.parentNode;
			}

			selector = selector.slice( tokens.shift().value.length );
		}

		// Fetch a seed set for right-to-left matching
		i = matchExpr[ "needsContext" ].test( selector ) ? 0 : tokens.length;
		while ( i-- ) {
			token = tokens[ i ];

			// Abort if we hit a combinator
			if ( Expr.relative[ ( type = token.type ) ] ) {
				break;
			}
			if ( ( find = Expr.find[ type ] ) ) {

				// Search, expanding context for leading sibling combinators
				if ( ( seed = find(
					token.matches[ 0 ].replace( runescape, funescape ),
					rsibling.test( tokens[ 0 ].type ) && testContext( context.parentNode ) ||
						context
				) ) ) {

					// If seed is empty or no tokens remain, we can return early
					tokens.splice( i, 1 );
					selector = seed.length && toSelector( tokens );
					if ( !selector ) {
						push.apply( results, seed );
						return results;
					}

					break;
				}
			}
		}
	}

	// Compile and execute a filtering function if one is not provided
	// Provide `match` to avoid retokenization if we modified the selector above
	( compiled || compile( selector, match ) )(
		seed,
		context,
		!documentIsHTML,
		results,
		!context || rsibling.test( selector ) && testContext( context.parentNode ) || context
	);
	return results;
};

// One-time assignments

// Sort stability
support.sortStable = expando.split( "" ).sort( sortOrder ).join( "" ) === expando;

// Support: Chrome 14-35+
// Always assume duplicates if they aren't passed to the comparison function
support.detectDuplicates = !!hasDuplicate;

// Initialize against the default document
setDocument();

// Support: Webkit<537.32 - Safari 6.0.3/Chrome 25 (fixed in Chrome 27)
// Detached nodes confoundingly follow *each other*
support.sortDetached = assert( function( el ) {

	// Should return 1, but returns 4 (following)
	return el.compareDocumentPosition( document.createElement( "fieldset" ) ) & 1;
} );

// Support: IE<8
// Prevent attribute/property "interpolation"
// https://msdn.microsoft.com/en-us/library/ms536429%28VS.85%29.aspx
if ( !assert( function( el ) {
	el.innerHTML = "<a href='#'></a>";
	return el.firstChild.getAttribute( "href" ) === "#";
} ) ) {
	addHandle( "type|href|height|width", function( elem, name, isXML ) {
		if ( !isXML ) {
			return elem.getAttribute( name, name.toLowerCase() === "type" ? 1 : 2 );
		}
	} );
}

// Support: IE<9
// Use defaultValue in place of getAttribute("value")
if ( !support.attributes || !assert( function( el ) {
	el.innerHTML = "<input/>";
	el.firstChild.setAttribute( "value", "" );
	return el.firstChild.getAttribute( "value" ) === "";
} ) ) {
	addHandle( "value", function( elem, _name, isXML ) {
		if ( !isXML && elem.nodeName.toLowerCase() === "input" ) {
			return elem.defaultValue;
		}
	} );
}

// Support: IE<9
// Use getAttributeNode to fetch booleans when getAttribute lies
if ( !assert( function( el ) {
	return el.getAttribute( "disabled" ) == null;
} ) ) {
	addHandle( booleans, function( elem, name, isXML ) {
		var val;
		if ( !isXML ) {
			return elem[ name ] === true ? name.toLowerCase() :
				( val = elem.getAttributeNode( name ) ) && val.specified ?
					val.value :
					null;
		}
	} );
}

return Sizzle;

} )( window );



jQuery.find = Sizzle;
jQuery.expr = Sizzle.selectors;

// Deprecated
jQuery.expr[ ":" ] = jQuery.expr.pseudos;
jQuery.uniqueSort = jQuery.unique = Sizzle.uniqueSort;
jQuery.text = Sizzle.getText;
jQuery.isXMLDoc = Sizzle.isXML;
jQuery.contains = Sizzle.contains;
jQuery.escapeSelector = Sizzle.escape;




var dir = function( elem, dir, until ) {
	var matched = [],
		truncate = until !== undefined;

	while ( ( elem = elem[ dir ] ) && elem.nodeType !== 9 ) {
		if ( elem.nodeType === 1 ) {
			if ( truncate && jQuery( elem ).is( until ) ) {
				break;
			}
			matched.push( elem );
		}
	}
	return matched;
};


var siblings = function( n, elem ) {
	var matched = [];

	for ( ; n; n = n.nextSibling ) {
		if ( n.nodeType === 1 && n !== elem ) {
			matched.push( n );
		}
	}

	return matched;
};


var rneedsContext = jQuery.expr.match.needsContext;



function nodeName( elem, name ) {

	return elem.nodeName && elem.nodeName.toLowerCase() === name.toLowerCase();

}
var rsingleTag = ( /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i );



// Implement the identical functionality for filter and not
function winnow( elements, qualifier, not ) {
	if ( isFunction( qualifier ) ) {
		return jQuery.grep( elements, function( elem, i ) {
			return !!qualifier.call( elem, i, elem ) !== not;
		} );
	}

	// Single element
	if ( qualifier.nodeType ) {
		return jQuery.grep( elements, function( elem ) {
			return ( elem === qualifier ) !== not;
		} );
	}

	// Arraylike of elements (jQuery, arguments, Array)
	if ( typeof qualifier !== "string" ) {
		return jQuery.grep( elements, function( elem ) {
			return ( indexOf.call( qualifier, elem ) > -1 ) !== not;
		} );
	}

	// Filtered directly for both simple and complex selectors
	return jQuery.filter( qualifier, elements, not );
}

jQuery.filter = function( expr, elems, not ) {
	var elem = elems[ 0 ];

	if ( not ) {
		expr = ":not(" + expr + ")";
	}

	if ( elems.length === 1 && elem.nodeType === 1 ) {
		return jQuery.find.matchesSelector( elem, expr ) ? [ elem ] : [];
	}

	return jQuery.find.matches( expr, jQuery.grep( elems, function( elem ) {
		return elem.nodeType === 1;
	} ) );
};

jQuery.fn.extend( {
	find: function( selector ) {
		var i, ret,
			len = this.length,
			self = this;

		if ( typeof selector !== "string" ) {
			return this.pushStack( jQuery( selector ).filter( function() {
				for ( i = 0; i < len; i++ ) {
					if ( jQuery.contains( self[ i ], this ) ) {
						return true;
					}
				}
			} ) );
		}

		ret = this.pushStack( [] );

		for ( i = 0; i < len; i++ ) {
			jQuery.find( selector, self[ i ], ret );
		}

		return len > 1 ? jQuery.uniqueSort( ret ) : ret;
	},
	filter: function( selector ) {
		return this.pushStack( winnow( this, selector || [], false ) );
	},
	not: function( selector ) {
		return this.pushStack( winnow( this, selector || [], true ) );
	},
	is: function( selector ) {
		return !!winnow(
			this,

			// If this is a positional/relative selector, check membership in the returned set
			// so $("p:first").is("p:last") won't return true for a doc with two "p".
			typeof selector === "string" && rneedsContext.test( selector ) ?
				jQuery( selector ) :
				selector || [],
			false
		).length;
	}
} );


// Initialize a jQuery object


// A central reference to the root jQuery(document)
var rootjQuery,

	// A simple way to check for HTML strings
	// Prioritize #id over <tag> to avoid XSS via location.hash (#9521)
	// Strict HTML recognition (#11290: must start with <)
	// Shortcut simple #id case for speed
	rquickExpr = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/,

	init = jQuery.fn.init = function( selector, context, root ) {
		var match, elem;

		// HANDLE: $(""), $(null), $(undefined), $(false)
		if ( !selector ) {
			return this;
		}

		// Method init() accepts an alternate rootjQuery
		// so migrate can support jQuery.sub (gh-2101)
		root = root || rootjQuery;

		// Handle HTML strings
		if ( typeof selector === "string" ) {
			if ( selector[ 0 ] === "<" &&
				selector[ selector.length - 1 ] === ">" &&
				selector.length >= 3 ) {

				// Assume that strings that start and end with <> are HTML and skip the regex check
				match = [ null, selector, null ];

			} else {
				match = rquickExpr.exec( selector );
			}

			// Match html or make sure no context is specified for #id
			if ( match && ( match[ 1 ] || !context ) ) {

				// HANDLE: $(html) -> $(array)
				if ( match[ 1 ] ) {
					context = context instanceof jQuery ? context[ 0 ] : context;

					// Option to run scripts is true for back-compat
					// Intentionally let the error be thrown if parseHTML is not present
					jQuery.merge( this, jQuery.parseHTML(
						match[ 1 ],
						context && context.nodeType ? context.ownerDocument || context : document,
						true
					) );

					// HANDLE: $(html, props)
					if ( rsingleTag.test( match[ 1 ] ) && jQuery.isPlainObject( context ) ) {
						for ( match in context ) {

							// Properties of context are called as methods if possible
							if ( isFunction( this[ match ] ) ) {
								this[ match ]( context[ match ] );

							// ...and otherwise set as attributes
							} else {
								this.attr( match, context[ match ] );
							}
						}
					}

					return this;

				// HANDLE: $(#id)
				} else {
					elem = document.getElementById( match[ 2 ] );

					if ( elem ) {

						// Inject the element directly into the jQuery object
						this[ 0 ] = elem;
						this.length = 1;
					}
					return this;
				}

			// HANDLE: $(expr, $(...))
			} else if ( !context || context.jquery ) {
				return ( context || root ).find( selector );

			// HANDLE: $(expr, context)
			// (which is just equivalent to: $(context).find(expr)
			} else {
				return this.constructor( context ).find( selector );
			}

		// HANDLE: $(DOMElement)
		} else if ( selector.nodeType ) {
			this[ 0 ] = selector;
			this.length = 1;
			return this;

		// HANDLE: $(function)
		// Shortcut for document ready
		} else if ( isFunction( selector ) ) {
			return root.ready !== undefined ?
				root.ready( selector ) :

				// Execute immediately if ready is not present
				selector( jQuery );
		}

		return jQuery.makeArray( selector, this );
	};

// Give the init function the jQuery prototype for later instantiation
init.prototype = jQuery.fn;

// Initialize central reference
rootjQuery = jQuery( document );


var rparentsprev = /^(?:parents|prev(?:Until|All))/,

	// Methods guaranteed to produce a unique set when starting from a unique set
	guaranteedUnique = {
		children: true,
		contents: true,
		next: true,
		prev: true
	};

jQuery.fn.extend( {
	has: function( target ) {
		var targets = jQuery( target, this ),
			l = targets.length;

		return this.filter( function() {
			var i = 0;
			for ( ; i < l; i++ ) {
				if ( jQuery.contains( this, targets[ i ] ) ) {
					return true;
				}
			}
		} );
	},

	closest: function( selectors, context ) {
		var cur,
			i = 0,
			l = this.length,
			matched = [],
			targets = typeof selectors !== "string" && jQuery( selectors );

		// Positional selectors never match, since there's no _selection_ context
		if ( !rneedsContext.test( selectors ) ) {
			for ( ; i < l; i++ ) {
				for ( cur = this[ i ]; cur && cur !== context; cur = cur.parentNode ) {

					// Always skip document fragments
					if ( cur.nodeType < 11 && ( targets ?
						targets.index( cur ) > -1 :

						// Don't pass non-elements to Sizzle
						cur.nodeType === 1 &&
							jQuery.find.matchesSelector( cur, selectors ) ) ) {

						matched.push( cur );
						break;
					}
				}
			}
		}

		return this.pushStack( matched.length > 1 ? jQuery.uniqueSort( matched ) : matched );
	},

	// Determine the position of an element within the set
	index: function( elem ) {

		// No argument, return index in parent
		if ( !elem ) {
			return ( this[ 0 ] && this[ 0 ].parentNode ) ? this.first().prevAll().length : -1;
		}

		// Index in selector
		if ( typeof elem === "string" ) {
			return indexOf.call( jQuery( elem ), this[ 0 ] );
		}

		// Locate the position of the desired element
		return indexOf.call( this,

			// If it receives a jQuery object, the first element is used
			elem.jquery ? elem[ 0 ] : elem
		);
	},

	add: function( selector, context ) {
		return this.pushStack(
			jQuery.uniqueSort(
				jQuery.merge( this.get(), jQuery( selector, context ) )
			)
		);
	},

	addBack: function( selector ) {
		return this.add( selector == null ?
			this.prevObject : this.prevObject.filter( selector )
		);
	}
} );

function sibling( cur, dir ) {
	while ( ( cur = cur[ dir ] ) && cur.nodeType !== 1 ) {}
	return cur;
}

jQuery.each( {
	parent: function( elem ) {
		var parent = elem.parentNode;
		return parent && parent.nodeType !== 11 ? parent : null;
	},
	parents: function( elem ) {
		return dir( elem, "parentNode" );
	},
	parentsUntil: function( elem, _i, until ) {
		return dir( elem, "parentNode", until );
	},
	next: function( elem ) {
		return sibling( elem, "nextSibling" );
	},
	prev: function( elem ) {
		return sibling( elem, "previousSibling" );
	},
	nextAll: function( elem ) {
		return dir( elem, "nextSibling" );
	},
	prevAll: function( elem ) {
		return dir( elem, "previousSibling" );
	},
	nextUntil: function( elem, _i, until ) {
		return dir( elem, "nextSibling", until );
	},
	prevUntil: function( elem, _i, until ) {
		return dir( elem, "previousSibling", until );
	},
	siblings: function( elem ) {
		return siblings( ( elem.parentNode || {} ).firstChild, elem );
	},
	children: function( elem ) {
		return siblings( elem.firstChild );
	},
	contents: function( elem ) {
		if ( elem.contentDocument != null &&

			// Support: IE 11+
			// <object> elements with no `data` attribute has an object
			// `contentDocument` with a `null` prototype.
			getProto( elem.contentDocument ) ) {

			return elem.contentDocument;
		}

		// Support: IE 9 - 11 only, iOS 7 only, Android Browser <=4.3 only
		// Treat the template element as a regular one in browsers that
		// don't support it.
		if ( nodeName( elem, "template" ) ) {
			elem = elem.content || elem;
		}

		return jQuery.merge( [], elem.childNodes );
	}
}, function( name, fn ) {
	jQuery.fn[ name ] = function( until, selector ) {
		var matched = jQuery.map( this, fn, until );

		if ( name.slice( -5 ) !== "Until" ) {
			selector = until;
		}

		if ( selector && typeof selector === "string" ) {
			matched = jQuery.filter( selector, matched );
		}

		if ( this.length > 1 ) {

			// Remove duplicates
			if ( !guaranteedUnique[ name ] ) {
				jQuery.uniqueSort( matched );
			}

			// Reverse order for parents* and prev-derivatives
			if ( rparentsprev.test( name ) ) {
				matched.reverse();
			}
		}

		return this.pushStack( matched );
	};
} );
var rnothtmlwhite = ( /[^\x20\t\r\n\f]+/g );



// Convert String-formatted options into Object-formatted ones
function createOptions( options ) {
	var object = {};
	jQuery.each( options.match( rnothtmlwhite ) || [], function( _, flag ) {
		object[ flag ] = true;
	} );
	return object;
}

/*
 * Create a callback list using the following parameters:
 *
 *	options: an optional list of space-separated options that will change how
 *			the callback list behaves or a more traditional option object
 *
 * By default a callback list will act like an event callback list and can be
 * "fired" multiple times.
 *
 * Possible options:
 *
 *	once:			will ensure the callback list can only be fired once (like a Deferred)
 *
 *	memory:			will keep track of previous values and will call any callback added
 *					after the list has been fired right away with the latest "memorized"
 *					values (like a Deferred)
 *
 *	unique:			will ensure a callback can only be added once (no duplicate in the list)
 *
 *	stopOnFalse:	interrupt callings when a callback returns false
 *
 */
jQuery.Callbacks = function( options ) {

	// Convert options from String-formatted to Object-formatted if needed
	// (we check in cache first)
	options = typeof options === "string" ?
		createOptions( options ) :
		jQuery.extend( {}, options );

	var // Flag to know if list is currently firing
		firing,

		// Last fire value for non-forgettable lists
		memory,

		// Flag to know if list was already fired
		fired,

		// Flag to prevent firing
		locked,

		// Actual callback list
		list = [],

		// Queue of execution data for repeatable lists
		queue = [],

		// Index of currently firing callback (modified by add/remove as needed)
		firingIndex = -1,

		// Fire callbacks
		fire = function() {

			// Enforce single-firing
			locked = locked || options.once;

			// Execute callbacks for all pending executions,
			// respecting firingIndex overrides and runtime changes
			fired = firing = true;
			for ( ; queue.length; firingIndex = -1 ) {
				memory = queue.shift();
				while ( ++firingIndex < list.length ) {

					// Run callback and check for early termination
					if ( list[ firingIndex ].apply( memory[ 0 ], memory[ 1 ] ) === false &&
						options.stopOnFalse ) {

						// Jump to end and forget the data so .add doesn't re-fire
						firingIndex = list.length;
						memory = false;
					}
				}
			}

			// Forget the data if we're done with it
			if ( !options.memory ) {
				memory = false;
			}

			firing = false;

			// Clean up if we're done firing for good
			if ( locked ) {

				// Keep an empty list if we have data for future add calls
				if ( memory ) {
					list = [];

				// Otherwise, this object is spent
				} else {
					list = "";
				}
			}
		},

		// Actual Callbacks object
		self = {

			// Add a callback or a collection of callbacks to the list
			add: function() {
				if ( list ) {

					// If we have memory from a past run, we should fire after adding
					if ( memory && !firing ) {
						firingIndex = list.length - 1;
						queue.push( memory );
					}

					( function add( args ) {
						jQuery.each( args, function( _, arg ) {
							if ( isFunction( arg ) ) {
								if ( !options.unique || !self.has( arg ) ) {
									list.push( arg );
								}
							} else if ( arg && arg.length && toType( arg ) !== "string" ) {

								// Inspect recursively
								add( arg );
							}
						} );
					} )( arguments );

					if ( memory && !firing ) {
						fire();
					}
				}
				return this;
			},

			// Remove a callback from the list
			remove: function() {
				jQuery.each( arguments, function( _, arg ) {
					var index;
					while ( ( index = jQuery.inArray( arg, list, index ) ) > -1 ) {
						list.splice( index, 1 );

						// Handle firing indexes
						if ( index <= firingIndex ) {
							firingIndex--;
						}
					}
				} );
				return this;
			},

			// Check if a given callback is in the list.
			// If no argument is given, return whether or not list has callbacks attached.
			has: function( fn ) {
				return fn ?
					jQuery.inArray( fn, list ) > -1 :
					list.length > 0;
			},

			// Remove all callbacks from the list
			empty: function() {
				if ( list ) {
					list = [];
				}
				return this;
			},

			// Disable .fire and .add
			// Abort any current/pending executions
			// Clear all callbacks and values
			disable: function() {
				locked = queue = [];
				list = memory = "";
				return this;
			},
			disabled: function() {
				return !list;
			},

			// Disable .fire
			// Also disable .add unless we have memory (since it would have no effect)
			// Abort any pending executions
			lock: function() {
				locked = queue = [];
				if ( !memory && !firing ) {
					list = memory = "";
				}
				return this;
			},
			locked: function() {
				return !!locked;
			},

			// Call all callbacks with the given context and arguments
			fireWith: function( context, args ) {
				if ( !locked ) {
					args = args || [];
					args = [ context, args.slice ? args.slice() : args ];
					queue.push( args );
					if ( !firing ) {
						fire();
					}
				}
				return this;
			},

			// Call all the callbacks with the given arguments
			fire: function() {
				self.fireWith( this, arguments );
				return this;
			},

			// To know if the callbacks have already been called at least once
			fired: function() {
				return !!fired;
			}
		};

	return self;
};


function Identity( v ) {
	return v;
}
function Thrower( ex ) {
	throw ex;
}

function adoptValue( value, resolve, reject, noValue ) {
	var method;

	try {

		// Check for promise aspect first to privilege synchronous behavior
		if ( value && isFunction( ( method = value.promise ) ) ) {
			method.call( value ).done( resolve ).fail( reject );

		// Other thenables
		} else if ( value && isFunction( ( method = value.then ) ) ) {
			method.call( value, resolve, reject );

		// Other non-thenables
		} else {

			// Control `resolve` arguments by letting Array#slice cast boolean `noValue` to integer:
			// * false: [ value ].slice( 0 ) => resolve( value )
			// * true: [ value ].slice( 1 ) => resolve()
			resolve.apply( undefined, [ value ].slice( noValue ) );
		}

	// For Promises/A+, convert exceptions into rejections
	// Since jQuery.when doesn't unwrap thenables, we can skip the extra checks appearing in
	// Deferred#then to conditionally suppress rejection.
	} catch ( value ) {

		// Support: Android 4.0 only
		// Strict mode functions invoked without .call/.apply get global-object context
		reject.apply( undefined, [ value ] );
	}
}

jQuery.extend( {

	Deferred: function( func ) {
		var tuples = [

				// action, add listener, callbacks,
				// ... .then handlers, argument index, [final state]
				[ "notify", "progress", jQuery.Callbacks( "memory" ),
					jQuery.Callbacks( "memory" ), 2 ],
				[ "resolve", "done", jQuery.Callbacks( "once memory" ),
					jQuery.Callbacks( "once memory" ), 0, "resolved" ],
				[ "reject", "fail", jQuery.Callbacks( "once memory" ),
					jQuery.Callbacks( "once memory" ), 1, "rejected" ]
			],
			state = "pending",
			promise = {
				state: function() {
					return state;
				},
				always: function() {
					deferred.done( arguments ).fail( arguments );
					return this;
				},
				"catch": function( fn ) {
					return promise.then( null, fn );
				},

				// Keep pipe for back-compat
				pipe: function( /* fnDone, fnFail, fnProgress */ ) {
					var fns = arguments;

					return jQuery.Deferred( function( newDefer ) {
						jQuery.each( tuples, function( _i, tuple ) {

							// Map tuples (progress, done, fail) to arguments (done, fail, progress)
							var fn = isFunction( fns[ tuple[ 4 ] ] ) && fns[ tuple[ 4 ] ];

							// deferred.progress(function() { bind to newDefer or newDefer.notify })
							// deferred.done(function() { bind to newDefer or newDefer.resolve })
							// deferred.fail(function() { bind to newDefer or newDefer.reject })
							deferred[ tuple[ 1 ] ]( function() {
								var returned = fn && fn.apply( this, arguments );
								if ( returned && isFunction( returned.promise ) ) {
									returned.promise()
										.progress( newDefer.notify )
										.done( newDefer.resolve )
										.fail( newDefer.reject );
								} else {
									newDefer[ tuple[ 0 ] + "With" ](
										this,
										fn ? [ returned ] : arguments
									);
								}
							} );
						} );
						fns = null;
					} ).promise();
				},
				then: function( onFulfilled, onRejected, onProgress ) {
					var maxDepth = 0;
					function resolve( depth, deferred, handler, special ) {
						return function() {
							var that = this,
								args = arguments,
								mightThrow = function() {
									var returned, then;

									// Support: Promises/A+ section 2.3.3.3.3
									// https://promisesaplus.com/#point-59
									// Ignore double-resolution attempts
									if ( depth < maxDepth ) {
										return;
									}

									returned = handler.apply( that, args );

									// Support: Promises/A+ section 2.3.1
									// https://promisesaplus.com/#point-48
									if ( returned === deferred.promise() ) {
										throw new TypeError( "Thenable self-resolution" );
									}

									// Support: Promises/A+ sections 2.3.3.1, 3.5
									// https://promisesaplus.com/#point-54
									// https://promisesaplus.com/#point-75
									// Retrieve `then` only once
									then = returned &&

										// Support: Promises/A+ section 2.3.4
										// https://promisesaplus.com/#point-64
										// Only check objects and functions for thenability
										( typeof returned === "object" ||
											typeof returned === "function" ) &&
										returned.then;

									// Handle a returned thenable
									if ( isFunction( then ) ) {

										// Special processors (notify) just wait for resolution
										if ( special ) {
											then.call(
												returned,
												resolve( maxDepth, deferred, Identity, special ),
												resolve( maxDepth, deferred, Thrower, special )
											);

										// Normal processors (resolve) also hook into progress
										} else {

											// ...and disregard older resolution values
											maxDepth++;

											then.call(
												returned,
												resolve( maxDepth, deferred, Identity, special ),
												resolve( maxDepth, deferred, Thrower, special ),
												resolve( maxDepth, deferred, Identity,
													deferred.notifyWith )
											);
										}

									// Handle all other returned values
									} else {

										// Only substitute handlers pass on context
										// and multiple values (non-spec behavior)
										if ( handler !== Identity ) {
											that = undefined;
											args = [ returned ];
										}

										// Process the value(s)
										// Default process is resolve
										( special || deferred.resolveWith )( that, args );
									}
								},

								// Only normal processors (resolve) catch and reject exceptions
								process = special ?
									mightThrow :
									function() {
										try {
											mightThrow();
										} catch ( e ) {

											if ( jQuery.Deferred.exceptionHook ) {
												jQuery.Deferred.exceptionHook( e,
													process.stackTrace );
											}

											// Support: Promises/A+ section 2.3.3.3.4.1
											// https://promisesaplus.com/#point-61
											// Ignore post-resolution exceptions
											if ( depth + 1 >= maxDepth ) {

												// Only substitute handlers pass on context
												// and multiple values (non-spec behavior)
												if ( handler !== Thrower ) {
													that = undefined;
													args = [ e ];
												}

												deferred.rejectWith( that, args );
											}
										}
									};

							// Support: Promises/A+ section 2.3.3.3.1
							// https://promisesaplus.com/#point-57
							// Re-resolve promises immediately to dodge false rejection from
							// subsequent errors
							if ( depth ) {
								process();
							} else {

								// Call an optional hook to record the stack, in case of exception
								// since it's otherwise lost when execution goes async
								if ( jQuery.Deferred.getStackHook ) {
									process.stackTrace = jQuery.Deferred.getStackHook();
								}
								window.setTimeout( process );
							}
						};
					}

					return jQuery.Deferred( function( newDefer ) {

						// progress_handlers.add( ... )
						tuples[ 0 ][ 3 ].add(
							resolve(
								0,
								newDefer,
								isFunction( onProgress ) ?
									onProgress :
									Identity,
								newDefer.notifyWith
							)
						);

						// fulfilled_handlers.add( ... )
						tuples[ 1 ][ 3 ].add(
							resolve(
								0,
								newDefer,
								isFunction( onFulfilled ) ?
									onFulfilled :
									Identity
							)
						);

						// rejected_handlers.add( ... )
						tuples[ 2 ][ 3 ].add(
							resolve(
								0,
								newDefer,
								isFunction( onRejected ) ?
									onRejected :
									Thrower
							)
						);
					} ).promise();
				},

				// Get a promise for this deferred
				// If obj is provided, the promise aspect is added to the object
				promise: function( obj ) {
					return obj != null ? jQuery.extend( obj, promise ) : promise;
				}
			},
			deferred = {};

		// Add list-specific methods
		jQuery.each( tuples, function( i, tuple ) {
			var list = tuple[ 2 ],
				stateString = tuple[ 5 ];

			// promise.progress = list.add
			// promise.done = list.add
			// promise.fail = list.add
			promise[ tuple[ 1 ] ] = list.add;

			// Handle state
			if ( stateString ) {
				list.add(
					function() {

						// state = "resolved" (i.e., fulfilled)
						// state = "rejected"
						state = stateString;
					},

					// rejected_callbacks.disable
					// fulfilled_callbacks.disable
					tuples[ 3 - i ][ 2 ].disable,

					// rejected_handlers.disable
					// fulfilled_handlers.disable
					tuples[ 3 - i ][ 3 ].disable,

					// progress_callbacks.lock
					tuples[ 0 ][ 2 ].lock,

					// progress_handlers.lock
					tuples[ 0 ][ 3 ].lock
				);
			}

			// progress_handlers.fire
			// fulfilled_handlers.fire
			// rejected_handlers.fire
			list.add( tuple[ 3 ].fire );

			// deferred.notify = function() { deferred.notifyWith(...) }
			// deferred.resolve = function() { deferred.resolveWith(...) }
			// deferred.reject = function() { deferred.rejectWith(...) }
			deferred[ tuple[ 0 ] ] = function() {
				deferred[ tuple[ 0 ] + "With" ]( this === deferred ? undefined : this, arguments );
				return this;
			};

			// deferred.notifyWith = list.fireWith
			// deferred.resolveWith = list.fireWith
			// deferred.rejectWith = list.fireWith
			deferred[ tuple[ 0 ] + "With" ] = list.fireWith;
		} );

		// Make the deferred a promise
		promise.promise( deferred );

		// Call given func if any
		if ( func ) {
			func.call( deferred, deferred );
		}

		// All done!
		return deferred;
	},

	// Deferred helper
	when: function( singleValue ) {
		var

			// count of uncompleted subordinates
			remaining = arguments.length,

			// count of unprocessed arguments
			i = remaining,

			// subordinate fulfillment data
			resolveContexts = Array( i ),
			resolveValues = slice.call( arguments ),

			// the primary Deferred
			primary = jQuery.Deferred(),

			// subordinate callback factory
			updateFunc = function( i ) {
				return function( value ) {
					resolveContexts[ i ] = this;
					resolveValues[ i ] = arguments.length > 1 ? slice.call( arguments ) : value;
					if ( !( --remaining ) ) {
						primary.resolveWith( resolveContexts, resolveValues );
					}
				};
			};

		// Single- and empty arguments are adopted like Promise.resolve
		if ( remaining <= 1 ) {
			adoptValue( singleValue, primary.done( updateFunc( i ) ).resolve, primary.reject,
				!remaining );

			// Use .then() to unwrap secondary thenables (cf. gh-3000)
			if ( primary.state() === "pending" ||
				isFunction( resolveValues[ i ] && resolveValues[ i ].then ) ) {

				return primary.then();
			}
		}

		// Multiple arguments are aggregated like Promise.all array elements
		while ( i-- ) {
			adoptValue( resolveValues[ i ], updateFunc( i ), primary.reject );
		}

		return primary.promise();
	}
} );


// These usually indicate a programmer mistake during development,
// warn about them ASAP rather than swallowing them by default.
var rerrorNames = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;

jQuery.Deferred.exceptionHook = function( error, stack ) {

	// Support: IE 8 - 9 only
	// Console exists when dev tools are open, which can happen at any time
	if ( window.console && window.console.warn && error && rerrorNames.test( error.name ) ) {
		window.console.warn( "jQuery.Deferred exception: " + error.message, error.stack, stack );
	}
};




jQuery.readyException = function( error ) {
	window.setTimeout( function() {
		throw error;
	} );
};




// The deferred used on DOM ready
var readyList = jQuery.Deferred();

jQuery.fn.ready = function( fn ) {

	readyList
		.then( fn )

		// Wrap jQuery.readyException in a function so that the lookup
		// happens at the time of error handling instead of callback
		// registration.
		.catch( function( error ) {
			jQuery.readyException( error );
		} );

	return this;
};

jQuery.extend( {

	// Is the DOM ready to be used? Set to true once it occurs.
	isReady: false,

	// A counter to track how many items to wait for before
	// the ready event fires. See #6781
	readyWait: 1,

	// Handle when the DOM is ready
	ready: function( wait ) {

		// Abort if there are pending holds or we're already ready
		if ( wait === true ? --jQuery.readyWait : jQuery.isReady ) {
			return;
		}

		// Remember that the DOM is ready
		jQuery.isReady = true;

		// If a normal DOM Ready event fired, decrement, and wait if need be
		if ( wait !== true && --jQuery.readyWait > 0 ) {
			return;
		}

		// If there are functions bound, to execute
		readyList.resolveWith( document, [ jQuery ] );
	}
} );

jQuery.ready.then = readyList.then;

// The ready event handler and self cleanup method
function completed() {
	document.removeEventListener( "DOMContentLoaded", completed );
	window.removeEventListener( "load", completed );
	jQuery.ready();
}

// Catch cases where $(document).ready() is called
// after the browser event has already occurred.
// Support: IE <=9 - 10 only
// Older IE sometimes signals "interactive" too soon
if ( document.readyState === "complete" ||
	( document.readyState !== "loading" && !document.documentElement.doScroll ) ) {

	// Handle it asynchronously to allow scripts the opportunity to delay ready
	window.setTimeout( jQuery.ready );

} else {

	// Use the handy event callback
	document.addEventListener( "DOMContentLoaded", completed );

	// A fallback to window.onload, that will always work
	window.addEventListener( "load", completed );
}




// Multifunctional method to get and set values of a collection
// The value/s can optionally be executed if it's a function
var access = function( elems, fn, key, value, chainable, emptyGet, raw ) {
	var i = 0,
		len = elems.length,
		bulk = key == null;

	// Sets many values
	if ( toType( key ) === "object" ) {
		chainable = true;
		for ( i in key ) {
			access( elems, fn, i, key[ i ], true, emptyGet, raw );
		}

	// Sets one value
	} else if ( value !== undefined ) {
		chainable = true;

		if ( !isFunction( value ) ) {
			raw = true;
		}

		if ( bulk ) {

			// Bulk operations run against the entire set
			if ( raw ) {
				fn.call( elems, value );
				fn = null;

			// ...except when executing function values
			} else {
				bulk = fn;
				fn = function( elem, _key, value ) {
					return bulk.call( jQuery( elem ), value );
				};
			}
		}

		if ( fn ) {
			for ( ; i < len; i++ ) {
				fn(
					elems[ i ], key, raw ?
						value :
						value.call( elems[ i ], i, fn( elems[ i ], key ) )
				);
			}
		}
	}

	if ( chainable ) {
		return elems;
	}

	// Gets
	if ( bulk ) {
		return fn.call( elems );
	}

	return len ? fn( elems[ 0 ], key ) : emptyGet;
};


// Matches dashed string for camelizing
var rmsPrefix = /^-ms-/,
	rdashAlpha = /-([a-z])/g;

// Used by camelCase as callback to replace()
function fcamelCase( _all, letter ) {
	return letter.toUpperCase();
}

// Convert dashed to camelCase; used by the css and data modules
// Support: IE <=9 - 11, Edge 12 - 15
// Microsoft forgot to hump their vendor prefix (#9572)
function camelCase( string ) {
	return string.replace( rmsPrefix, "ms-" ).replace( rdashAlpha, fcamelCase );
}
var acceptData = function( owner ) {

	// Accepts only:
	//  - Node
	//    - Node.ELEMENT_NODE
	//    - Node.DOCUMENT_NODE
	//  - Object
	//    - Any
	return owner.nodeType === 1 || owner.nodeType === 9 || !( +owner.nodeType );
};




function Data() {
	this.expando = jQuery.expando + Data.uid++;
}

Data.uid = 1;

Data.prototype = {

	cache: function( owner ) {

		// Check if the owner object already has a cache
		var value = owner[ this.expando ];

		// If not, create one
		if ( !value ) {
			value = {};

			// We can accept data for non-element nodes in modern browsers,
			// but we should not, see #8335.
			// Always return an empty object.
			if ( acceptData( owner ) ) {

				// If it is a node unlikely to be stringify-ed or looped over
				// use plain assignment
				if ( owner.nodeType ) {
					owner[ this.expando ] = value;

				// Otherwise secure it in a non-enumerable property
				// configurable must be true to allow the property to be
				// deleted when data is removed
				} else {
					Object.defineProperty( owner, this.expando, {
						value: value,
						configurable: true
					} );
				}
			}
		}

		return value;
	},
	set: function( owner, data, value ) {
		var prop,
			cache = this.cache( owner );

		// Handle: [ owner, key, value ] args
		// Always use camelCase key (gh-2257)
		if ( typeof data === "string" ) {
			cache[ camelCase( data ) ] = value;

		// Handle: [ owner, { properties } ] args
		} else {

			// Copy the properties one-by-one to the cache object
			for ( prop in data ) {
				cache[ camelCase( prop ) ] = data[ prop ];
			}
		}
		return cache;
	},
	get: function( owner, key ) {
		return key === undefined ?
			this.cache( owner ) :

			// Always use camelCase key (gh-2257)
			owner[ this.expando ] && owner[ this.expando ][ camelCase( key ) ];
	},
	access: function( owner, key, value ) {

		// In cases where either:
		//
		//   1. No key was specified
		//   2. A string key was specified, but no value provided
		//
		// Take the "read" path and allow the get method to determine
		// which value to return, respectively either:
		//
		//   1. The entire cache object
		//   2. The data stored at the key
		//
		if ( key === undefined ||
				( ( key && typeof key === "string" ) && value === undefined ) ) {

			return this.get( owner, key );
		}

		// When the key is not a string, or both a key and value
		// are specified, set or extend (existing objects) with either:
		//
		//   1. An object of properties
		//   2. A key and value
		//
		this.set( owner, key, value );

		// Since the "set" path can have two possible entry points
		// return the expected data based on which path was taken[*]
		return value !== undefined ? value : key;
	},
	remove: function( owner, key ) {
		var i,
			cache = owner[ this.expando ];

		if ( cache === undefined ) {
			return;
		}

		if ( key !== undefined ) {

			// Support array or space separated string of keys
			if ( Array.isArray( key ) ) {

				// If key is an array of keys...
				// We always set camelCase keys, so remove that.
				key = key.map( camelCase );
			} else {
				key = camelCase( key );

				// If a key with the spaces exists, use it.
				// Otherwise, create an array by matching non-whitespace
				key = key in cache ?
					[ key ] :
					( key.match( rnothtmlwhite ) || [] );
			}

			i = key.length;

			while ( i-- ) {
				delete cache[ key[ i ] ];
			}
		}

		// Remove the expando if there's no more data
		if ( key === undefined || jQuery.isEmptyObject( cache ) ) {

			// Support: Chrome <=35 - 45
			// Webkit & Blink performance suffers when deleting properties
			// from DOM nodes, so set to undefined instead
			// https://bugs.chromium.org/p/chromium/issues/detail?id=378607 (bug restricted)
			if ( owner.nodeType ) {
				owner[ this.expando ] = undefined;
			} else {
				delete owner[ this.expando ];
			}
		}
	},
	hasData: function( owner ) {
		var cache = owner[ this.expando ];
		return cache !== undefined && !jQuery.isEmptyObject( cache );
	}
};
var dataPriv = new Data();

var dataUser = new Data();



//	Implementation Summary
//
//	1. Enforce API surface and semantic compatibility with 1.9.x branch
//	2. Improve the module's maintainability by reducing the storage
//		paths to a single mechanism.
//	3. Use the same single mechanism to support "private" and "user" data.
//	4. _Never_ expose "private" data to user code (TODO: Drop _data, _removeData)
//	5. Avoid exposing implementation details on user objects (eg. expando properties)
//	6. Provide a clear path for implementation upgrade to WeakMap in 2014

var rbrace = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
	rmultiDash = /[A-Z]/g;

function getData( data ) {
	if ( data === "true" ) {
		return true;
	}

	if ( data === "false" ) {
		return false;
	}

	if ( data === "null" ) {
		return null;
	}

	// Only convert to a number if it doesn't change the string
	if ( data === +data + "" ) {
		return +data;
	}

	if ( rbrace.test( data ) ) {
		return JSON.parse( data );
	}

	return data;
}

function dataAttr( elem, key, data ) {
	var name;

	// If nothing was found internally, try to fetch any
	// data from the HTML5 data-* attribute
	if ( data === undefined && elem.nodeType === 1 ) {
		name = "data-" + key.replace( rmultiDash, "-$&" ).toLowerCase();
		data = elem.getAttribute( name );

		if ( typeof data === "string" ) {
			try {
				data = getData( data );
			} catch ( e ) {}

			// Make sure we set the data so it isn't changed later
			dataUser.set( elem, key, data );
		} else {
			data = undefined;
		}
	}
	return data;
}

jQuery.extend( {
	hasData: function( elem ) {
		return dataUser.hasData( elem ) || dataPriv.hasData( elem );
	},

	data: function( elem, name, data ) {
		return dataUser.access( elem, name, data );
	},

	removeData: function( elem, name ) {
		dataUser.remove( elem, name );
	},

	// TODO: Now that all calls to _data and _removeData have been replaced
	// with direct calls to dataPriv methods, these can be deprecated.
	_data: function( elem, name, data ) {
		return dataPriv.access( elem, name, data );
	},

	_removeData: function( elem, name ) {
		dataPriv.remove( elem, name );
	}
} );

jQuery.fn.extend( {
	data: function( key, value ) {
		var i, name, data,
			elem = this[ 0 ],
			attrs = elem && elem.attributes;

		// Gets all values
		if ( key === undefined ) {
			if ( this.length ) {
				data = dataUser.get( elem );

				if ( elem.nodeType === 1 && !dataPriv.get( elem, "hasDataAttrs" ) ) {
					i = attrs.length;
					while ( i-- ) {

						// Support: IE 11 only
						// The attrs elements can be null (#14894)
						if ( attrs[ i ] ) {
							name = attrs[ i ].name;
							if ( name.indexOf( "data-" ) === 0 ) {
								name = camelCase( name.slice( 5 ) );
								dataAttr( elem, name, data[ name ] );
							}
						}
					}
					dataPriv.set( elem, "hasDataAttrs", true );
				}
			}

			return data;
		}

		// Sets multiple values
		if ( typeof key === "object" ) {
			return this.each( function() {
				dataUser.set( this, key );
			} );
		}

		return access( this, function( value ) {
			var data;

			// The calling jQuery object (element matches) is not empty
			// (and therefore has an element appears at this[ 0 ]) and the
			// `value` parameter was not undefined. An empty jQuery object
			// will result in `undefined` for elem = this[ 0 ] which will
			// throw an exception if an attempt to read a data cache is made.
			if ( elem && value === undefined ) {

				// Attempt to get data from the cache
				// The key will always be camelCased in Data
				data = dataUser.get( elem, key );
				if ( data !== undefined ) {
					return data;
				}

				// Attempt to "discover" the data in
				// HTML5 custom data-* attrs
				data = dataAttr( elem, key );
				if ( data !== undefined ) {
					return data;
				}

				// We tried really hard, but the data doesn't exist.
				return;
			}

			// Set the data...
			this.each( function() {

				// We always store the camelCased key
				dataUser.set( this, key, value );
			} );
		}, null, value, arguments.length > 1, null, true );
	},

	removeData: function( key ) {
		return this.each( function() {
			dataUser.remove( this, key );
		} );
	}
} );


jQuery.extend( {
	queue: function( elem, type, data ) {
		var queue;

		if ( elem ) {
			type = ( type || "fx" ) + "queue";
			queue = dataPriv.get( elem, type );

			// Speed up dequeue by getting out quickly if this is just a lookup
			if ( data ) {
				if ( !queue || Array.isArray( data ) ) {
					queue = dataPriv.access( elem, type, jQuery.makeArray( data ) );
				} else {
					queue.push( data );
				}
			}
			return queue || [];
		}
	},

	dequeue: function( elem, type ) {
		type = type || "fx";

		var queue = jQuery.queue( elem, type ),
			startLength = queue.length,
			fn = queue.shift(),
			hooks = jQuery._queueHooks( elem, type ),
			next = function() {
				jQuery.dequeue( elem, type );
			};

		// If the fx queue is dequeued, always remove the progress sentinel
		if ( fn === "inprogress" ) {
			fn = queue.shift();
			startLength--;
		}

		if ( fn ) {

			// Add a progress sentinel to prevent the fx queue from being
			// automatically dequeued
			if ( type === "fx" ) {
				queue.unshift( "inprogress" );
			}

			// Clear up the last queue stop function
			delete hooks.stop;
			fn.call( elem, next, hooks );
		}

		if ( !startLength && hooks ) {
			hooks.empty.fire();
		}
	},

	// Not public - generate a queueHooks object, or return the current one
	_queueHooks: function( elem, type ) {
		var key = type + "queueHooks";
		return dataPriv.get( elem, key ) || dataPriv.access( elem, key, {
			empty: jQuery.Callbacks( "once memory" ).add( function() {
				dataPriv.remove( elem, [ type + "queue", key ] );
			} )
		} );
	}
} );

jQuery.fn.extend( {
	queue: function( type, data ) {
		var setter = 2;

		if ( typeof type !== "string" ) {
			data = type;
			type = "fx";
			setter--;
		}

		if ( arguments.length < setter ) {
			return jQuery.queue( this[ 0 ], type );
		}

		return data === undefined ?
			this :
			this.each( function() {
				var queue = jQuery.queue( this, type, data );

				// Ensure a hooks for this queue
				jQuery._queueHooks( this, type );

				if ( type === "fx" && queue[ 0 ] !== "inprogress" ) {
					jQuery.dequeue( this, type );
				}
			} );
	},
	dequeue: function( type ) {
		return this.each( function() {
			jQuery.dequeue( this, type );
		} );
	},
	clearQueue: function( type ) {
		return this.queue( type || "fx", [] );
	},

	// Get a promise resolved when queues of a certain type
	// are emptied (fx is the type by default)
	promise: function( type, obj ) {
		var tmp,
			count = 1,
			defer = jQuery.Deferred(),
			elements = this,
			i = this.length,
			resolve = function() {
				if ( !( --count ) ) {
					defer.resolveWith( elements, [ elements ] );
				}
			};

		if ( typeof type !== "string" ) {
			obj = type;
			type = undefined;
		}
		type = type || "fx";

		while ( i-- ) {
			tmp = dataPriv.get( elements[ i ], type + "queueHooks" );
			if ( tmp && tmp.empty ) {
				count++;
				tmp.empty.add( resolve );
			}
		}
		resolve();
		return defer.promise( obj );
	}
} );
var pnum = ( /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/ ).source;

var rcssNum = new RegExp( "^(?:([+-])=|)(" + pnum + ")([a-z%]*)$", "i" );


var cssExpand = [ "Top", "Right", "Bottom", "Left" ];

var documentElement = document.documentElement;



	var isAttached = function( elem ) {
			return jQuery.contains( elem.ownerDocument, elem );
		},
		composed = { composed: true };

	// Support: IE 9 - 11+, Edge 12 - 18+, iOS 10.0 - 10.2 only
	// Check attachment across shadow DOM boundaries when possible (gh-3504)
	// Support: iOS 10.0-10.2 only
	// Early iOS 10 versions support `attachShadow` but not `getRootNode`,
	// leading to errors. We need to check for `getRootNode`.
	if ( documentElement.getRootNode ) {
		isAttached = function( elem ) {
			return jQuery.contains( elem.ownerDocument, elem ) ||
				elem.getRootNode( composed ) === elem.ownerDocument;
		};
	}
var isHiddenWithinTree = function( elem, el ) {

		// isHiddenWithinTree might be called from jQuery#filter function;
		// in that case, element will be second argument
		elem = el || elem;

		// Inline style trumps all
		return elem.style.display === "none" ||
			elem.style.display === "" &&

			// Otherwise, check computed style
			// Support: Firefox <=43 - 45
			// Disconnected elements can have computed display: none, so first confirm that elem is
			// in the document.
			isAttached( elem ) &&

			jQuery.css( elem, "display" ) === "none";
	};



function adjustCSS( elem, prop, valueParts, tween ) {
	var adjusted, scale,
		maxIterations = 20,
		currentValue = tween ?
			function() {
				return tween.cur();
			} :
			function() {
				return jQuery.css( elem, prop, "" );
			},
		initial = currentValue(),
		unit = valueParts && valueParts[ 3 ] || ( jQuery.cssNumber[ prop ] ? "" : "px" ),

		// Starting value computation is required for potential unit mismatches
		initialInUnit = elem.nodeType &&
			( jQuery.cssNumber[ prop ] || unit !== "px" && +initial ) &&
			rcssNum.exec( jQuery.css( elem, prop ) );

	if ( initialInUnit && initialInUnit[ 3 ] !== unit ) {

		// Support: Firefox <=54
		// Halve the iteration target value to prevent interference from CSS upper bounds (gh-2144)
		initial = initial / 2;

		// Trust units reported by jQuery.css
		unit = unit || initialInUnit[ 3 ];

		// Iteratively approximate from a nonzero starting point
		initialInUnit = +initial || 1;

		while ( maxIterations-- ) {

			// Evaluate and update our best guess (doubling guesses that zero out).
			// Finish if the scale equals or crosses 1 (making the old*new product non-positive).
			jQuery.style( elem, prop, initialInUnit + unit );
			if ( ( 1 - scale ) * ( 1 - ( scale = currentValue() / initial || 0.5 ) ) <= 0 ) {
				maxIterations = 0;
			}
			initialInUnit = initialInUnit / scale;

		}

		initialInUnit = initialInUnit * 2;
		jQuery.style( elem, prop, initialInUnit + unit );

		// Make sure we update the tween properties later on
		valueParts = valueParts || [];
	}

	if ( valueParts ) {
		initialInUnit = +initialInUnit || +initial || 0;

		// Apply relative offset (+=/-=) if specified
		adjusted = valueParts[ 1 ] ?
			initialInUnit + ( valueParts[ 1 ] + 1 ) * valueParts[ 2 ] :
			+valueParts[ 2 ];
		if ( tween ) {
			tween.unit = unit;
			tween.start = initialInUnit;
			tween.end = adjusted;
		}
	}
	return adjusted;
}


var defaultDisplayMap = {};

function getDefaultDisplay( elem ) {
	var temp,
		doc = elem.ownerDocument,
		nodeName = elem.nodeName,
		display = defaultDisplayMap[ nodeName ];

	if ( display ) {
		return display;
	}

	temp = doc.body.appendChild( doc.createElement( nodeName ) );
	display = jQuery.css( temp, "display" );

	temp.parentNode.removeChild( temp );

	if ( display === "none" ) {
		display = "block";
	}
	defaultDisplayMap[ nodeName ] = display;

	return display;
}

function showHide( elements, show ) {
	var display, elem,
		values = [],
		index = 0,
		length = elements.length;

	// Determine new display value for elements that need to change
	for ( ; index < length; index++ ) {
		elem = elements[ index ];
		if ( !elem.style ) {
			continue;
		}

		display = elem.style.display;
		if ( show ) {

			// Since we force visibility upon cascade-hidden elements, an immediate (and slow)
			// check is required in this first loop unless we have a nonempty display value (either
			// inline or about-to-be-restored)
			if ( display === "none" ) {
				values[ index ] = dataPriv.get( elem, "display" ) || null;
				if ( !values[ index ] ) {
					elem.style.display = "";
				}
			}
			if ( elem.style.display === "" && isHiddenWithinTree( elem ) ) {
				values[ index ] = getDefaultDisplay( elem );
			}
		} else {
			if ( display !== "none" ) {
				values[ index ] = "none";

				// Remember what we're overwriting
				dataPriv.set( elem, "display", display );
			}
		}
	}

	// Set the display of the elements in a second loop to avoid constant reflow
	for ( index = 0; index < length; index++ ) {
		if ( values[ index ] != null ) {
			elements[ index ].style.display = values[ index ];
		}
	}

	return elements;
}

jQuery.fn.extend( {
	show: function() {
		return showHide( this, true );
	},
	hide: function() {
		return showHide( this );
	},
	toggle: function( state ) {
		if ( typeof state === "boolean" ) {
			return state ? this.show() : this.hide();
		}

		return this.each( function() {
			if ( isHiddenWithinTree( this ) ) {
				jQuery( this ).show();
			} else {
				jQuery( this ).hide();
			}
		} );
	}
} );
var rcheckableType = ( /^(?:checkbox|radio)$/i );

var rtagName = ( /<([a-z][^\/\0>\x20\t\r\n\f]*)/i );

var rscriptType = ( /^$|^module$|\/(?:java|ecma)script/i );



( function() {
	var fragment = document.createDocumentFragment(),
		div = fragment.appendChild( document.createElement( "div" ) ),
		input = document.createElement( "input" );

	// Support: Android 4.0 - 4.3 only
	// Check state lost if the name is set (#11217)
	// Support: Windows Web Apps (WWA)
	// `name` and `type` must use .setAttribute for WWA (#14901)
	input.setAttribute( "type", "radio" );
	input.setAttribute( "checked", "checked" );
	input.setAttribute( "name", "t" );

	div.appendChild( input );

	// Support: Android <=4.1 only
	// Older WebKit doesn't clone checked state correctly in fragments
	support.checkClone = div.cloneNode( true ).cloneNode( true ).lastChild.checked;

	// Support: IE <=11 only
	// Make sure textarea (and checkbox) defaultValue is properly cloned
	div.innerHTML = "<textarea>x</textarea>";
	support.noCloneChecked = !!div.cloneNode( true ).lastChild.defaultValue;

	// Support: IE <=9 only
	// IE <=9 replaces <option> tags with their contents when inserted outside of
	// the select element.
	div.innerHTML = "<option></option>";
	support.option = !!div.lastChild;
} )();


// We have to close these tags to support XHTML (#13200)
var wrapMap = {

	// XHTML parsers do not magically insert elements in the
	// same way that tag soup parsers do. So we cannot shorten
	// this by omitting <tbody> or other required elements.
	thead: [ 1, "<table>", "</table>" ],
	col: [ 2, "<table><colgroup>", "</colgroup></table>" ],
	tr: [ 2, "<table><tbody>", "</tbody></table>" ],
	td: [ 3, "<table><tbody><tr>", "</tr></tbody></table>" ],

	_default: [ 0, "", "" ]
};

wrapMap.tbody = wrapMap.tfoot = wrapMap.colgroup = wrapMap.caption = wrapMap.thead;
wrapMap.th = wrapMap.td;

// Support: IE <=9 only
if ( !support.option ) {
	wrapMap.optgroup = wrapMap.option = [ 1, "<select multiple='multiple'>", "</select>" ];
}


function getAll( context, tag ) {

	// Support: IE <=9 - 11 only
	// Use typeof to avoid zero-argument method invocation on host objects (#15151)
	var ret;

	if ( typeof context.getElementsByTagName !== "undefined" ) {
		ret = context.getElementsByTagName( tag || "*" );

	} else if ( typeof context.querySelectorAll !== "undefined" ) {
		ret = context.querySelectorAll( tag || "*" );

	} else {
		ret = [];
	}

	if ( tag === undefined || tag && nodeName( context, tag ) ) {
		return jQuery.merge( [ context ], ret );
	}

	return ret;
}


// Mark scripts as having already been evaluated
function setGlobalEval( elems, refElements ) {
	var i = 0,
		l = elems.length;

	for ( ; i < l; i++ ) {
		dataPriv.set(
			elems[ i ],
			"globalEval",
			!refElements || dataPriv.get( refElements[ i ], "globalEval" )
		);
	}
}


var rhtml = /<|&#?\w+;/;

function buildFragment( elems, context, scripts, selection, ignored ) {
	var elem, tmp, tag, wrap, attached, j,
		fragment = context.createDocumentFragment(),
		nodes = [],
		i = 0,
		l = elems.length;

	for ( ; i < l; i++ ) {
		elem = elems[ i ];

		if ( elem || elem === 0 ) {

			// Add nodes directly
			if ( toType( elem ) === "object" ) {

				// Support: Android <=4.0 only, PhantomJS 1 only
				// push.apply(_, arraylike) throws on ancient WebKit
				jQuery.merge( nodes, elem.nodeType ? [ elem ] : elem );

			// Convert non-html into a text node
			} else if ( !rhtml.test( elem ) ) {
				nodes.push( context.createTextNode( elem ) );

			// Convert html into DOM nodes
			} else {
				tmp = tmp || fragment.appendChild( context.createElement( "div" ) );

				// Deserialize a standard representation
				tag = ( rtagName.exec( elem ) || [ "", "" ] )[ 1 ].toLowerCase();
				wrap = wrapMap[ tag ] || wrapMap._default;
				tmp.innerHTML = wrap[ 1 ] + jQuery.htmlPrefilter( elem ) + wrap[ 2 ];

				// Descend through wrappers to the right content
				j = wrap[ 0 ];
				while ( j-- ) {
					tmp = tmp.lastChild;
				}

				// Support: Android <=4.0 only, PhantomJS 1 only
				// push.apply(_, arraylike) throws on ancient WebKit
				jQuery.merge( nodes, tmp.childNodes );

				// Remember the top-level container
				tmp = fragment.firstChild;

				// Ensure the created nodes are orphaned (#12392)
				tmp.textContent = "";
			}
		}
	}

	// Remove wrapper from fragment
	fragment.textContent = "";

	i = 0;
	while ( ( elem = nodes[ i++ ] ) ) {

		// Skip elements already in the context collection (trac-4087)
		if ( selection && jQuery.inArray( elem, selection ) > -1 ) {
			if ( ignored ) {
				ignored.push( elem );
			}
			continue;
		}

		attached = isAttached( elem );

		// Append to fragment
		tmp = getAll( fragment.appendChild( elem ), "script" );

		// Preserve script evaluation history
		if ( attached ) {
			setGlobalEval( tmp );
		}

		// Capture executables
		if ( scripts ) {
			j = 0;
			while ( ( elem = tmp[ j++ ] ) ) {
				if ( rscriptType.test( elem.type || "" ) ) {
					scripts.push( elem );
				}
			}
		}
	}

	return fragment;
}


var rtypenamespace = /^([^.]*)(?:\.(.+)|)/;

function returnTrue() {
	return true;
}

function returnFalse() {
	return false;
}

// Support: IE <=9 - 11+
// focus() and blur() are asynchronous, except when they are no-op.
// So expect focus to be synchronous when the element is already active,
// and blur to be synchronous when the element is not already active.
// (focus and blur are always synchronous in other supported browsers,
// this just defines when we can count on it).
function expectSync( elem, type ) {
	return ( elem === safeActiveElement() ) === ( type === "focus" );
}

// Support: IE <=9 only
// Accessing document.activeElement can throw unexpectedly
// https://bugs.jquery.com/ticket/13393
function safeActiveElement() {
	try {
		return document.activeElement;
	} catch ( err ) { }
}

function on( elem, types, selector, data, fn, one ) {
	var origFn, type;

	// Types can be a map of types/handlers
	if ( typeof types === "object" ) {

		// ( types-Object, selector, data )
		if ( typeof selector !== "string" ) {

			// ( types-Object, data )
			data = data || selector;
			selector = undefined;
		}
		for ( type in types ) {
			on( elem, type, selector, data, types[ type ], one );
		}
		return elem;
	}

	if ( data == null && fn == null ) {

		// ( types, fn )
		fn = selector;
		data = selector = undefined;
	} else if ( fn == null ) {
		if ( typeof selector === "string" ) {

			// ( types, selector, fn )
			fn = data;
			data = undefined;
		} else {

			// ( types, data, fn )
			fn = data;
			data = selector;
			selector = undefined;
		}
	}
	if ( fn === false ) {
		fn = returnFalse;
	} else if ( !fn ) {
		return elem;
	}

	if ( one === 1 ) {
		origFn = fn;
		fn = function( event ) {

			// Can use an empty set, since event contains the info
			jQuery().off( event );
			return origFn.apply( this, arguments );
		};

		// Use same guid so caller can remove using origFn
		fn.guid = origFn.guid || ( origFn.guid = jQuery.guid++ );
	}
	return elem.each( function() {
		jQuery.event.add( this, types, fn, data, selector );
	} );
}

/*
 * Helper functions for managing events -- not part of the public interface.
 * Props to Dean Edwards' addEvent library for many of the ideas.
 */
jQuery.event = {

	global: {},

	add: function( elem, types, handler, data, selector ) {

		var handleObjIn, eventHandle, tmp,
			events, t, handleObj,
			special, handlers, type, namespaces, origType,
			elemData = dataPriv.get( elem );

		// Only attach events to objects that accept data
		if ( !acceptData( elem ) ) {
			return;
		}

		// Caller can pass in an object of custom data in lieu of the handler
		if ( handler.handler ) {
			handleObjIn = handler;
			handler = handleObjIn.handler;
			selector = handleObjIn.selector;
		}

		// Ensure that invalid selectors throw exceptions at attach time
		// Evaluate against documentElement in case elem is a non-element node (e.g., document)
		if ( selector ) {
			jQuery.find.matchesSelector( documentElement, selector );
		}

		// Make sure that the handler has a unique ID, used to find/remove it later
		if ( !handler.guid ) {
			handler.guid = jQuery.guid++;
		}

		// Init the element's event structure and main handler, if this is the first
		if ( !( events = elemData.events ) ) {
			events = elemData.events = Object.create( null );
		}
		if ( !( eventHandle = elemData.handle ) ) {
			eventHandle = elemData.handle = function( e ) {

				// Discard the second event of a jQuery.event.trigger() and
				// when an event is called after a page has unloaded
				return typeof jQuery !== "undefined" && jQuery.event.triggered !== e.type ?
					jQuery.event.dispatch.apply( elem, arguments ) : undefined;
			};
		}

		// Handle multiple events separated by a space
		types = ( types || "" ).match( rnothtmlwhite ) || [ "" ];
		t = types.length;
		while ( t-- ) {
			tmp = rtypenamespace.exec( types[ t ] ) || [];
			type = origType = tmp[ 1 ];
			namespaces = ( tmp[ 2 ] || "" ).split( "." ).sort();

			// There *must* be a type, no attaching namespace-only handlers
			if ( !type ) {
				continue;
			}

			// If event changes its type, use the special event handlers for the changed type
			special = jQuery.event.special[ type ] || {};

			// If selector defined, determine special event api type, otherwise given type
			type = ( selector ? special.delegateType : special.bindType ) || type;

			// Update special based on newly reset type
			special = jQuery.event.special[ type ] || {};

			// handleObj is passed to all event handlers
			handleObj = jQuery.extend( {
				type: type,
				origType: origType,
				data: data,
				handler: handler,
				guid: handler.guid,
				selector: selector,
				needsContext: selector && jQuery.expr.match.needsContext.test( selector ),
				namespace: namespaces.join( "." )
			}, handleObjIn );

			// Init the event handler queue if we're the first
			if ( !( handlers = events[ type ] ) ) {
				handlers = events[ type ] = [];
				handlers.delegateCount = 0;

				// Only use addEventListener if the special events handler returns false
				if ( !special.setup ||
					special.setup.call( elem, data, namespaces, eventHandle ) === false ) {

					if ( elem.addEventListener ) {
						elem.addEventListener( type, eventHandle );
					}
				}
			}

			if ( special.add ) {
				special.add.call( elem, handleObj );

				if ( !handleObj.handler.guid ) {
					handleObj.handler.guid = handler.guid;
				}
			}

			// Add to the element's handler list, delegates in front
			if ( selector ) {
				handlers.splice( handlers.delegateCount++, 0, handleObj );
			} else {
				handlers.push( handleObj );
			}

			// Keep track of which events have ever been used, for event optimization
			jQuery.event.global[ type ] = true;
		}

	},

	// Detach an event or set of events from an element
	remove: function( elem, types, handler, selector, mappedTypes ) {

		var j, origCount, tmp,
			events, t, handleObj,
			special, handlers, type, namespaces, origType,
			elemData = dataPriv.hasData( elem ) && dataPriv.get( elem );

		if ( !elemData || !( events = elemData.events ) ) {
			return;
		}

		// Once for each type.namespace in types; type may be omitted
		types = ( types || "" ).match( rnothtmlwhite ) || [ "" ];
		t = types.length;
		while ( t-- ) {
			tmp = rtypenamespace.exec( types[ t ] ) || [];
			type = origType = tmp[ 1 ];
			namespaces = ( tmp[ 2 ] || "" ).split( "." ).sort();

			// Unbind all events (on this namespace, if provided) for the element
			if ( !type ) {
				for ( type in events ) {
					jQuery.event.remove( elem, type + types[ t ], handler, selector, true );
				}
				continue;
			}

			special = jQuery.event.special[ type ] || {};
			type = ( selector ? special.delegateType : special.bindType ) || type;
			handlers = events[ type ] || [];
			tmp = tmp[ 2 ] &&
				new RegExp( "(^|\\.)" + namespaces.join( "\\.(?:.*\\.|)" ) + "(\\.|$)" );

			// Remove matching events
			origCount = j = handlers.length;
			while ( j-- ) {
				handleObj = handlers[ j ];

				if ( ( mappedTypes || origType === handleObj.origType ) &&
					( !handler || handler.guid === handleObj.guid ) &&
					( !tmp || tmp.test( handleObj.namespace ) ) &&
					( !selector || selector === handleObj.selector ||
						selector === "**" && handleObj.selector ) ) {
					handlers.splice( j, 1 );

					if ( handleObj.selector ) {
						handlers.delegateCount--;
					}
					if ( special.remove ) {
						special.remove.call( elem, handleObj );
					}
				}
			}

			// Remove generic event handler if we removed something and no more handlers exist
			// (avoids potential for endless recursion during removal of special event handlers)
			if ( origCount && !handlers.length ) {
				if ( !special.teardown ||
					special.teardown.call( elem, namespaces, elemData.handle ) === false ) {

					jQuery.removeEvent( elem, type, elemData.handle );
				}

				delete events[ type ];
			}
		}

		// Remove data and the expando if it's no longer used
		if ( jQuery.isEmptyObject( events ) ) {
			dataPriv.remove( elem, "handle events" );
		}
	},

	dispatch: function( nativeEvent ) {

		var i, j, ret, matched, handleObj, handlerQueue,
			args = new Array( arguments.length ),

			// Make a writable jQuery.Event from the native event object
			event = jQuery.event.fix( nativeEvent ),

			handlers = (
				dataPriv.get( this, "events" ) || Object.create( null )
			)[ event.type ] || [],
			special = jQuery.event.special[ event.type ] || {};

		// Use the fix-ed jQuery.Event rather than the (read-only) native event
		args[ 0 ] = event;

		for ( i = 1; i < arguments.length; i++ ) {
			args[ i ] = arguments[ i ];
		}

		event.delegateTarget = this;

		// Call the preDispatch hook for the mapped type, and let it bail if desired
		if ( special.preDispatch && special.preDispatch.call( this, event ) === false ) {
			return;
		}

		// Determine handlers
		handlerQueue = jQuery.event.handlers.call( this, event, handlers );

		// Run delegates first; they may want to stop propagation beneath us
		i = 0;
		while ( ( matched = handlerQueue[ i++ ] ) && !event.isPropagationStopped() ) {
			event.currentTarget = matched.elem;

			j = 0;
			while ( ( handleObj = matched.handlers[ j++ ] ) &&
				!event.isImmediatePropagationStopped() ) {

				// If the event is namespaced, then each handler is only invoked if it is
				// specially universal or its namespaces are a superset of the event's.
				if ( !event.rnamespace || handleObj.namespace === false ||
					event.rnamespace.test( handleObj.namespace ) ) {

					event.handleObj = handleObj;
					event.data = handleObj.data;

					ret = ( ( jQuery.event.special[ handleObj.origType ] || {} ).handle ||
						handleObj.handler ).apply( matched.elem, args );

					if ( ret !== undefined ) {
						if ( ( event.result = ret ) === false ) {
							event.preventDefault();
							event.stopPropagation();
						}
					}
				}
			}
		}

		// Call the postDispatch hook for the mapped type
		if ( special.postDispatch ) {
			special.postDispatch.call( this, event );
		}

		return event.result;
	},

	handlers: function( event, handlers ) {
		var i, handleObj, sel, matchedHandlers, matchedSelectors,
			handlerQueue = [],
			delegateCount = handlers.delegateCount,
			cur = event.target;

		// Find delegate handlers
		if ( delegateCount &&

			// Support: IE <=9
			// Black-hole SVG <use> instance trees (trac-13180)
			cur.nodeType &&

			// Support: Firefox <=42
			// Suppress spec-violating clicks indicating a non-primary pointer button (trac-3861)
			// https://www.w3.org/TR/DOM-Level-3-Events/#event-type-click
			// Support: IE 11 only
			// ...but not arrow key "clicks" of radio inputs, which can have `button` -1 (gh-2343)
			!( event.type === "click" && event.button >= 1 ) ) {

			for ( ; cur !== this; cur = cur.parentNode || this ) {

				// Don't check non-elements (#13208)
				// Don't process clicks on disabled elements (#6911, #8165, #11382, #11764)
				if ( cur.nodeType === 1 && !( event.type === "click" && cur.disabled === true ) ) {
					matchedHandlers = [];
					matchedSelectors = {};
					for ( i = 0; i < delegateCount; i++ ) {
						handleObj = handlers[ i ];

						// Don't conflict with Object.prototype properties (#13203)
						sel = handleObj.selector + " ";

						if ( matchedSelectors[ sel ] === undefined ) {
							matchedSelectors[ sel ] = handleObj.needsContext ?
								jQuery( sel, this ).index( cur ) > -1 :
								jQuery.find( sel, this, null, [ cur ] ).length;
						}
						if ( matchedSelectors[ sel ] ) {
							matchedHandlers.push( handleObj );
						}
					}
					if ( matchedHandlers.length ) {
						handlerQueue.push( { elem: cur, handlers: matchedHandlers } );
					}
				}
			}
		}

		// Add the remaining (directly-bound) handlers
		cur = this;
		if ( delegateCount < handlers.length ) {
			handlerQueue.push( { elem: cur, handlers: handlers.slice( delegateCount ) } );
		}

		return handlerQueue;
	},

	addProp: function( name, hook ) {
		Object.defineProperty( jQuery.Event.prototype, name, {
			enumerable: true,
			configurable: true,

			get: isFunction( hook ) ?
				function() {
					if ( this.originalEvent ) {
						return hook( this.originalEvent );
					}
				} :
				function() {
					if ( this.originalEvent ) {
						return this.originalEvent[ name ];
					}
				},

			set: function( value ) {
				Object.defineProperty( this, name, {
					enumerable: true,
					configurable: true,
					writable: true,
					value: value
				} );
			}
		} );
	},

	fix: function( originalEvent ) {
		return originalEvent[ jQuery.expando ] ?
			originalEvent :
			new jQuery.Event( originalEvent );
	},

	special: {
		load: {

			// Prevent triggered image.load events from bubbling to window.load
			noBubble: true
		},
		click: {

			// Utilize native event to ensure correct state for checkable inputs
			setup: function( data ) {

				// For mutual compressibility with _default, replace `this` access with a local var.
				// `|| data` is dead code meant only to preserve the variable through minification.
				var el = this || data;

				// Claim the first handler
				if ( rcheckableType.test( el.type ) &&
					el.click && nodeName( el, "input" ) ) {

					// dataPriv.set( el, "click", ... )
					leverageNative( el, "click", returnTrue );
				}

				// Return false to allow normal processing in the caller
				return false;
			},
			trigger: function( data ) {

				// For mutual compressibility with _default, replace `this` access with a local var.
				// `|| data` is dead code meant only to preserve the variable through minification.
				var el = this || data;

				// Force setup before triggering a click
				if ( rcheckableType.test( el.type ) &&
					el.click && nodeName( el, "input" ) ) {

					leverageNative( el, "click" );
				}

				// Return non-false to allow normal event-path propagation
				return true;
			},

			// For cross-browser consistency, suppress native .click() on links
			// Also prevent it if we're currently inside a leveraged native-event stack
			_default: function( event ) {
				var target = event.target;
				return rcheckableType.test( target.type ) &&
					target.click && nodeName( target, "input" ) &&
					dataPriv.get( target, "click" ) ||
					nodeName( target, "a" );
			}
		},

		beforeunload: {
			postDispatch: function( event ) {

				// Support: Firefox 20+
				// Firefox doesn't alert if the returnValue field is not set.
				if ( event.result !== undefined && event.originalEvent ) {
					event.originalEvent.returnValue = event.result;
				}
			}
		}
	}
};

// Ensure the presence of an event listener that handles manually-triggered
// synthetic events by interrupting progress until reinvoked in response to
// *native* events that it fires directly, ensuring that state changes have
// already occurred before other listeners are invoked.
function leverageNative( el, type, expectSync ) {

	// Missing expectSync indicates a trigger call, which must force setup through jQuery.event.add
	if ( !expectSync ) {
		if ( dataPriv.get( el, type ) === undefined ) {
			jQuery.event.add( el, type, returnTrue );
		}
		return;
	}

	// Register the controller as a special universal handler for all event namespaces
	dataPriv.set( el, type, false );
	jQuery.event.add( el, type, {
		namespace: false,
		handler: function( event ) {
			var notAsync, result,
				saved = dataPriv.get( this, type );

			if ( ( event.isTrigger & 1 ) && this[ type ] ) {

				// Interrupt processing of the outer synthetic .trigger()ed event
				// Saved data should be false in such cases, but might be a leftover capture object
				// from an async native handler (gh-4350)
				if ( !saved.length ) {

					// Store arguments for use when handling the inner native event
					// There will always be at least one argument (an event object), so this array
					// will not be confused with a leftover capture object.
					saved = slice.call( arguments );
					dataPriv.set( this, type, saved );

					// Trigger the native event and capture its result
					// Support: IE <=9 - 11+
					// focus() and blur() are asynchronous
					notAsync = expectSync( this, type );
					this[ type ]();
					result = dataPriv.get( this, type );
					if ( saved !== result || notAsync ) {
						dataPriv.set( this, type, false );
					} else {
						result = {};
					}
					if ( saved !== result ) {

						// Cancel the outer synthetic event
						event.stopImmediatePropagation();
						event.preventDefault();

						// Support: Chrome 86+
						// In Chrome, if an element having a focusout handler is blurred by
						// clicking outside of it, it invokes the handler synchronously. If
						// that handler calls `.remove()` on the element, the data is cleared,
						// leaving `result` undefined. We need to guard against this.
						return result && result.value;
					}

				// If this is an inner synthetic event for an event with a bubbling surrogate
				// (focus or blur), assume that the surrogate already propagated from triggering the
				// native event and prevent that from happening again here.
				// This technically gets the ordering wrong w.r.t. to `.trigger()` (in which the
				// bubbling surrogate propagates *after* the non-bubbling base), but that seems
				// less bad than duplication.
				} else if ( ( jQuery.event.special[ type ] || {} ).delegateType ) {
					event.stopPropagation();
				}

			// If this is a native event triggered above, everything is now in order
			// Fire an inner synthetic event with the original arguments
			} else if ( saved.length ) {

				// ...and capture the result
				dataPriv.set( this, type, {
					value: jQuery.event.trigger(

						// Support: IE <=9 - 11+
						// Extend with the prototype to reset the above stopImmediatePropagation()
						jQuery.extend( saved[ 0 ], jQuery.Event.prototype ),
						saved.slice( 1 ),
						this
					)
				} );

				// Abort handling of the native event
				event.stopImmediatePropagation();
			}
		}
	} );
}

jQuery.removeEvent = function( elem, type, handle ) {

	// This "if" is needed for plain objects
	if ( elem.removeEventListener ) {
		elem.removeEventListener( type, handle );
	}
};

jQuery.Event = function( src, props ) {

	// Allow instantiation without the 'new' keyword
	if ( !( this instanceof jQuery.Event ) ) {
		return new jQuery.Event( src, props );
	}

	// Event object
	if ( src && src.type ) {
		this.originalEvent = src;
		this.type = src.type;

		// Events bubbling up the document may have been marked as prevented
		// by a handler lower down the tree; reflect the correct value.
		this.isDefaultPrevented = src.defaultPrevented ||
				src.defaultPrevented === undefined &&

				// Support: Android <=2.3 only
				src.returnValue === false ?
			returnTrue :
			returnFalse;

		// Create target properties
		// Support: Safari <=6 - 7 only
		// Target should not be a text node (#504, #13143)
		this.target = ( src.target && src.target.nodeType === 3 ) ?
			src.target.parentNode :
			src.target;

		this.currentTarget = src.currentTarget;
		this.relatedTarget = src.relatedTarget;

	// Event type
	} else {
		this.type = src;
	}

	// Put explicitly provided properties onto the event object
	if ( props ) {
		jQuery.extend( this, props );
	}

	// Create a timestamp if incoming event doesn't have one
	this.timeStamp = src && src.timeStamp || Date.now();

	// Mark it as fixed
	this[ jQuery.expando ] = true;
};

// jQuery.Event is based on DOM3 Events as specified by the ECMAScript Language Binding
// https://www.w3.org/TR/2003/WD-DOM-Level-3-Events-20030331/ecma-script-binding.html
jQuery.Event.prototype = {
	constructor: jQuery.Event,
	isDefaultPrevented: returnFalse,
	isPropagationStopped: returnFalse,
	isImmediatePropagationStopped: returnFalse,
	isSimulated: false,

	preventDefault: function() {
		var e = this.originalEvent;

		this.isDefaultPrevented = returnTrue;

		if ( e && !this.isSimulated ) {
			e.preventDefault();
		}
	},
	stopPropagation: function() {
		var e = this.originalEvent;

		this.isPropagationStopped = returnTrue;

		if ( e && !this.isSimulated ) {
			e.stopPropagation();
		}
	},
	stopImmediatePropagation: function() {
		var e = this.originalEvent;

		this.isImmediatePropagationStopped = returnTrue;

		if ( e && !this.isSimulated ) {
			e.stopImmediatePropagation();
		}

		this.stopPropagation();
	}
};

// Includes all common event props including KeyEvent and MouseEvent specific props
jQuery.each( {
	altKey: true,
	bubbles: true,
	cancelable: true,
	changedTouches: true,
	ctrlKey: true,
	detail: true,
	eventPhase: true,
	metaKey: true,
	pageX: true,
	pageY: true,
	shiftKey: true,
	view: true,
	"char": true,
	code: true,
	charCode: true,
	key: true,
	keyCode: true,
	button: true,
	buttons: true,
	clientX: true,
	clientY: true,
	offsetX: true,
	offsetY: true,
	pointerId: true,
	pointerType: true,
	screenX: true,
	screenY: true,
	targetTouches: true,
	toElement: true,
	touches: true,
	which: true
}, jQuery.event.addProp );

jQuery.each( { focus: "focusin", blur: "focusout" }, function( type, delegateType ) {
	jQuery.event.special[ type ] = {

		// Utilize native event if possible so blur/focus sequence is correct
		setup: function() {

			// Claim the first handler
			// dataPriv.set( this, "focus", ... )
			// dataPriv.set( this, "blur", ... )
			leverageNative( this, type, expectSync );

			// Return false to allow normal processing in the caller
			return false;
		},
		trigger: function() {

			// Force setup before trigger
			leverageNative( this, type );

			// Return non-false to allow normal event-path propagation
			return true;
		},

		// Suppress native focus or blur as it's already being fired
		// in leverageNative.
		_default: function() {
			return true;
		},

		delegateType: delegateType
	};
} );

// Create mouseenter/leave events using mouseover/out and event-time checks
// so that event delegation works in jQuery.
// Do the same for pointerenter/pointerleave and pointerover/pointerout
//
// Support: Safari 7 only
// Safari sends mouseenter too often; see:
// https://bugs.chromium.org/p/chromium/issues/detail?id=470258
// for the description of the bug (it existed in older Chrome versions as well).
jQuery.each( {
	mouseenter: "mouseover",
	mouseleave: "mouseout",
	pointerenter: "pointerover",
	pointerleave: "pointerout"
}, function( orig, fix ) {
	jQuery.event.special[ orig ] = {
		delegateType: fix,
		bindType: fix,

		handle: function( event ) {
			var ret,
				target = this,
				related = event.relatedTarget,
				handleObj = event.handleObj;

			// For mouseenter/leave call the handler if related is outside the target.
			// NB: No relatedTarget if the mouse left/entered the browser window
			if ( !related || ( related !== target && !jQuery.contains( target, related ) ) ) {
				event.type = handleObj.origType;
				ret = handleObj.handler.apply( this, arguments );
				event.type = fix;
			}
			return ret;
		}
	};
} );

jQuery.fn.extend( {

	on: function( types, selector, data, fn ) {
		return on( this, types, selector, data, fn );
	},
	one: function( types, selector, data, fn ) {
		return on( this, types, selector, data, fn, 1 );
	},
	off: function( types, selector, fn ) {
		var handleObj, type;
		if ( types && types.preventDefault && types.handleObj ) {

			// ( event )  dispatched jQuery.Event
			handleObj = types.handleObj;
			jQuery( types.delegateTarget ).off(
				handleObj.namespace ?
					handleObj.origType + "." + handleObj.namespace :
					handleObj.origType,
				handleObj.selector,
				handleObj.handler
			);
			return this;
		}
		if ( typeof types === "object" ) {

			// ( types-object [, selector] )
			for ( type in types ) {
				this.off( type, selector, types[ type ] );
			}
			return this;
		}
		if ( selector === false || typeof selector === "function" ) {

			// ( types [, fn] )
			fn = selector;
			selector = undefined;
		}
		if ( fn === false ) {
			fn = returnFalse;
		}
		return this.each( function() {
			jQuery.event.remove( this, types, fn, selector );
		} );
	}
} );


var

	// Support: IE <=10 - 11, Edge 12 - 13 only
	// In IE/Edge using regex groups here causes severe slowdowns.
	// See https://connect.microsoft.com/IE/feedback/details/1736512/
	rnoInnerhtml = /<script|<style|<link/i,

	// checked="checked" or checked
	rchecked = /checked\s*(?:[^=]|=\s*.checked.)/i,
	rcleanScript = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

// Prefer a tbody over its parent table for containing new rows
function manipulationTarget( elem, content ) {
	if ( nodeName( elem, "table" ) &&
		nodeName( content.nodeType !== 11 ? content : content.firstChild, "tr" ) ) {

		return jQuery( elem ).children( "tbody" )[ 0 ] || elem;
	}

	return elem;
}

// Replace/restore the type attribute of script elements for safe DOM manipulation
function disableScript( elem ) {
	elem.type = ( elem.getAttribute( "type" ) !== null ) + "/" + elem.type;
	return elem;
}
function restoreScript( elem ) {
	if ( ( elem.type || "" ).slice( 0, 5 ) === "true/" ) {
		elem.type = elem.type.slice( 5 );
	} else {
		elem.removeAttribute( "type" );
	}

	return elem;
}

function cloneCopyEvent( src, dest ) {
	var i, l, type, pdataOld, udataOld, udataCur, events;

	if ( dest.nodeType !== 1 ) {
		return;
	}

	// 1. Copy private data: events, handlers, etc.
	if ( dataPriv.hasData( src ) ) {
		pdataOld = dataPriv.get( src );
		events = pdataOld.events;

		if ( events ) {
			dataPriv.remove( dest, "handle events" );

			for ( type in events ) {
				for ( i = 0, l = events[ type ].length; i < l; i++ ) {
					jQuery.event.add( dest, type, events[ type ][ i ] );
				}
			}
		}
	}

	// 2. Copy user data
	if ( dataUser.hasData( src ) ) {
		udataOld = dataUser.access( src );
		udataCur = jQuery.extend( {}, udataOld );

		dataUser.set( dest, udataCur );
	}
}

// Fix IE bugs, see support tests
function fixInput( src, dest ) {
	var nodeName = dest.nodeName.toLowerCase();

	// Fails to persist the checked state of a cloned checkbox or radio button.
	if ( nodeName === "input" && rcheckableType.test( src.type ) ) {
		dest.checked = src.checked;

	// Fails to return the selected option to the default selected state when cloning options
	} else if ( nodeName === "input" || nodeName === "textarea" ) {
		dest.defaultValue = src.defaultValue;
	}
}

function domManip( collection, args, callback, ignored ) {

	// Flatten any nested arrays
	args = flat( args );

	var fragment, first, scripts, hasScripts, node, doc,
		i = 0,
		l = collection.length,
		iNoClone = l - 1,
		value = args[ 0 ],
		valueIsFunction = isFunction( value );

	// We can't cloneNode fragments that contain checked, in WebKit
	if ( valueIsFunction ||
			( l > 1 && typeof value === "string" &&
				!support.checkClone && rchecked.test( value ) ) ) {
		return collection.each( function( index ) {
			var self = collection.eq( index );
			if ( valueIsFunction ) {
				args[ 0 ] = value.call( this, index, self.html() );
			}
			domManip( self, args, callback, ignored );
		} );
	}

	if ( l ) {
		fragment = buildFragment( args, collection[ 0 ].ownerDocument, false, collection, ignored );
		first = fragment.firstChild;

		if ( fragment.childNodes.length === 1 ) {
			fragment = first;
		}

		// Require either new content or an interest in ignored elements to invoke the callback
		if ( first || ignored ) {
			scripts = jQuery.map( getAll( fragment, "script" ), disableScript );
			hasScripts = scripts.length;

			// Use the original fragment for the last item
			// instead of the first because it can end up
			// being emptied incorrectly in certain situations (#8070).
			for ( ; i < l; i++ ) {
				node = fragment;

				if ( i !== iNoClone ) {
					node = jQuery.clone( node, true, true );

					// Keep references to cloned scripts for later restoration
					if ( hasScripts ) {

						// Support: Android <=4.0 only, PhantomJS 1 only
						// push.apply(_, arraylike) throws on ancient WebKit
						jQuery.merge( scripts, getAll( node, "script" ) );
					}
				}

				callback.call( collection[ i ], node, i );
			}

			if ( hasScripts ) {
				doc = scripts[ scripts.length - 1 ].ownerDocument;

				// Reenable scripts
				jQuery.map( scripts, restoreScript );

				// Evaluate executable scripts on first document insertion
				for ( i = 0; i < hasScripts; i++ ) {
					node = scripts[ i ];
					if ( rscriptType.test( node.type || "" ) &&
						!dataPriv.access( node, "globalEval" ) &&
						jQuery.contains( doc, node ) ) {

						if ( node.src && ( node.type || "" ).toLowerCase()  !== "module" ) {

							// Optional AJAX dependency, but won't run scripts if not present
							if ( jQuery._evalUrl && !node.noModule ) {
								jQuery._evalUrl( node.src, {
									nonce: node.nonce || node.getAttribute( "nonce" )
								}, doc );
							}
						} else {
							DOMEval( node.textContent.replace( rcleanScript, "" ), node, doc );
						}
					}
				}
			}
		}
	}

	return collection;
}

function remove( elem, selector, keepData ) {
	var node,
		nodes = selector ? jQuery.filter( selector, elem ) : elem,
		i = 0;

	for ( ; ( node = nodes[ i ] ) != null; i++ ) {
		if ( !keepData && node.nodeType === 1 ) {
			jQuery.cleanData( getAll( node ) );
		}

		if ( node.parentNode ) {
			if ( keepData && isAttached( node ) ) {
				setGlobalEval( getAll( node, "script" ) );
			}
			node.parentNode.removeChild( node );
		}
	}

	return elem;
}

jQuery.extend( {
	htmlPrefilter: function( html ) {
		return html;
	},

	clone: function( elem, dataAndEvents, deepDataAndEvents ) {
		var i, l, srcElements, destElements,
			clone = elem.cloneNode( true ),
			inPage = isAttached( elem );

		// Fix IE cloning issues
		if ( !support.noCloneChecked && ( elem.nodeType === 1 || elem.nodeType === 11 ) &&
				!jQuery.isXMLDoc( elem ) ) {

			// We eschew Sizzle here for performance reasons: https://jsperf.com/getall-vs-sizzle/2
			destElements = getAll( clone );
			srcElements = getAll( elem );

			for ( i = 0, l = srcElements.length; i < l; i++ ) {
				fixInput( srcElements[ i ], destElements[ i ] );
			}
		}

		// Copy the events from the original to the clone
		if ( dataAndEvents ) {
			if ( deepDataAndEvents ) {
				srcElements = srcElements || getAll( elem );
				destElements = destElements || getAll( clone );

				for ( i = 0, l = srcElements.length; i < l; i++ ) {
					cloneCopyEvent( srcElements[ i ], destElements[ i ] );
				}
			} else {
				cloneCopyEvent( elem, clone );
			}
		}

		// Preserve script evaluation history
		destElements = getAll( clone, "script" );
		if ( destElements.length > 0 ) {
			setGlobalEval( destElements, !inPage && getAll( elem, "script" ) );
		}

		// Return the cloned set
		return clone;
	},

	cleanData: function( elems ) {
		var data, elem, type,
			special = jQuery.event.special,
			i = 0;

		for ( ; ( elem = elems[ i ] ) !== undefined; i++ ) {
			if ( acceptData( elem ) ) {
				if ( ( data = elem[ dataPriv.expando ] ) ) {
					if ( data.events ) {
						for ( type in data.events ) {
							if ( special[ type ] ) {
								jQuery.event.remove( elem, type );

							// This is a shortcut to avoid jQuery.event.remove's overhead
							} else {
								jQuery.removeEvent( elem, type, data.handle );
							}
						}
					}

					// Support: Chrome <=35 - 45+
					// Assign undefined instead of using delete, see Data#remove
					elem[ dataPriv.expando ] = undefined;
				}
				if ( elem[ dataUser.expando ] ) {

					// Support: Chrome <=35 - 45+
					// Assign undefined instead of using delete, see Data#remove
					elem[ dataUser.expando ] = undefined;
				}
			}
		}
	}
} );

jQuery.fn.extend( {
	detach: function( selector ) {
		return remove( this, selector, true );
	},

	remove: function( selector ) {
		return remove( this, selector );
	},

	text: function( value ) {
		return access( this, function( value ) {
			return value === undefined ?
				jQuery.text( this ) :
				this.empty().each( function() {
					if ( this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9 ) {
						this.textContent = value;
					}
				} );
		}, null, value, arguments.length );
	},

	append: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9 ) {
				var target = manipulationTarget( this, elem );
				target.appendChild( elem );
			}
		} );
	},

	prepend: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9 ) {
				var target = manipulationTarget( this, elem );
				target.insertBefore( elem, target.firstChild );
			}
		} );
	},

	before: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.parentNode ) {
				this.parentNode.insertBefore( elem, this );
			}
		} );
	},

	after: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.parentNode ) {
				this.parentNode.insertBefore( elem, this.nextSibling );
			}
		} );
	},

	empty: function() {
		var elem,
			i = 0;

		for ( ; ( elem = this[ i ] ) != null; i++ ) {
			if ( elem.nodeType === 1 ) {

				// Prevent memory leaks
				jQuery.cleanData( getAll( elem, false ) );

				// Remove any remaining nodes
				elem.textContent = "";
			}
		}

		return this;
	},

	clone: function( dataAndEvents, deepDataAndEvents ) {
		dataAndEvents = dataAndEvents == null ? false : dataAndEvents;
		deepDataAndEvents = deepDataAndEvents == null ? dataAndEvents : deepDataAndEvents;

		return this.map( function() {
			return jQuery.clone( this, dataAndEvents, deepDataAndEvents );
		} );
	},

	html: function( value ) {
		return access( this, function( value ) {
			var elem = this[ 0 ] || {},
				i = 0,
				l = this.length;

			if ( value === undefined && elem.nodeType === 1 ) {
				return elem.innerHTML;
			}

			// See if we can take a shortcut and just use innerHTML
			if ( typeof value === "string" && !rnoInnerhtml.test( value ) &&
				!wrapMap[ ( rtagName.exec( value ) || [ "", "" ] )[ 1 ].toLowerCase() ] ) {

				value = jQuery.htmlPrefilter( value );

				try {
					for ( ; i < l; i++ ) {
						elem = this[ i ] || {};

						// Remove element nodes and prevent memory leaks
						if ( elem.nodeType === 1 ) {
							jQuery.cleanData( getAll( elem, false ) );
							elem.innerHTML = value;
						}
					}

					elem = 0;

				// If using innerHTML throws an exception, use the fallback method
				} catch ( e ) {}
			}

			if ( elem ) {
				this.empty().append( value );
			}
		}, null, value, arguments.length );
	},

	replaceWith: function() {
		var ignored = [];

		// Make the changes, replacing each non-ignored context element with the new content
		return domManip( this, arguments, function( elem ) {
			var parent = this.parentNode;

			if ( jQuery.inArray( this, ignored ) < 0 ) {
				jQuery.cleanData( getAll( this ) );
				if ( parent ) {
					parent.replaceChild( elem, this );
				}
			}

		// Force callback invocation
		}, ignored );
	}
} );

jQuery.each( {
	appendTo: "append",
	prependTo: "prepend",
	insertBefore: "before",
	insertAfter: "after",
	replaceAll: "replaceWith"
}, function( name, original ) {
	jQuery.fn[ name ] = function( selector ) {
		var elems,
			ret = [],
			insert = jQuery( selector ),
			last = insert.length - 1,
			i = 0;

		for ( ; i <= last; i++ ) {
			elems = i === last ? this : this.clone( true );
			jQuery( insert[ i ] )[ original ]( elems );

			// Support: Android <=4.0 only, PhantomJS 1 only
			// .get() because push.apply(_, arraylike) throws on ancient WebKit
			push.apply( ret, elems.get() );
		}

		return this.pushStack( ret );
	};
} );
var rnumnonpx = new RegExp( "^(" + pnum + ")(?!px)[a-z%]+$", "i" );

var getStyles = function( elem ) {

		// Support: IE <=11 only, Firefox <=30 (#15098, #14150)
		// IE throws on elements created in popups
		// FF meanwhile throws on frame elements through "defaultView.getComputedStyle"
		var view = elem.ownerDocument.defaultView;

		if ( !view || !view.opener ) {
			view = window;
		}

		return view.getComputedStyle( elem );
	};

var swap = function( elem, options, callback ) {
	var ret, name,
		old = {};

	// Remember the old values, and insert the new ones
	for ( name in options ) {
		old[ name ] = elem.style[ name ];
		elem.style[ name ] = options[ name ];
	}

	ret = callback.call( elem );

	// Revert the old values
	for ( name in options ) {
		elem.style[ name ] = old[ name ];
	}

	return ret;
};


var rboxStyle = new RegExp( cssExpand.join( "|" ), "i" );



( function() {

	// Executing both pixelPosition & boxSizingReliable tests require only one layout
	// so they're executed at the same time to save the second computation.
	function computeStyleTests() {

		// This is a singleton, we need to execute it only once
		if ( !div ) {
			return;
		}

		container.style.cssText = "position:absolute;left:-11111px;width:60px;" +
			"margin-top:1px;padding:0;border:0";
		div.style.cssText =
			"position:relative;display:block;box-sizing:border-box;overflow:scroll;" +
			"margin:auto;border:1px;padding:1px;" +
			"width:60%;top:1%";
		documentElement.appendChild( container ).appendChild( div );

		var divStyle = window.getComputedStyle( div );
		pixelPositionVal = divStyle.top !== "1%";

		// Support: Android 4.0 - 4.3 only, Firefox <=3 - 44
		reliableMarginLeftVal = roundPixelMeasures( divStyle.marginLeft ) === 12;

		// Support: Android 4.0 - 4.3 only, Safari <=9.1 - 10.1, iOS <=7.0 - 9.3
		// Some styles come back with percentage values, even though they shouldn't
		div.style.right = "60%";
		pixelBoxStylesVal = roundPixelMeasures( divStyle.right ) === 36;

		// Support: IE 9 - 11 only
		// Detect misreporting of content dimensions for box-sizing:border-box elements
		boxSizingReliableVal = roundPixelMeasures( divStyle.width ) === 36;

		// Support: IE 9 only
		// Detect overflow:scroll screwiness (gh-3699)
		// Support: Chrome <=64
		// Don't get tricked when zoom affects offsetWidth (gh-4029)
		div.style.position = "absolute";
		scrollboxSizeVal = roundPixelMeasures( div.offsetWidth / 3 ) === 12;

		documentElement.removeChild( container );

		// Nullify the div so it wouldn't be stored in the memory and
		// it will also be a sign that checks already performed
		div = null;
	}

	function roundPixelMeasures( measure ) {
		return Math.round( parseFloat( measure ) );
	}

	var pixelPositionVal, boxSizingReliableVal, scrollboxSizeVal, pixelBoxStylesVal,
		reliableTrDimensionsVal, reliableMarginLeftVal,
		container = document.createElement( "div" ),
		div = document.createElement( "div" );

	// Finish early in limited (non-browser) environments
	if ( !div.style ) {
		return;
	}

	// Support: IE <=9 - 11 only
	// Style of cloned element affects source element cloned (#8908)
	div.style.backgroundClip = "content-box";
	div.cloneNode( true ).style.backgroundClip = "";
	support.clearCloneStyle = div.style.backgroundClip === "content-box";

	jQuery.extend( support, {
		boxSizingReliable: function() {
			computeStyleTests();
			return boxSizingReliableVal;
		},
		pixelBoxStyles: function() {
			computeStyleTests();
			return pixelBoxStylesVal;
		},
		pixelPosition: function() {
			computeStyleTests();
			return pixelPositionVal;
		},
		reliableMarginLeft: function() {
			computeStyleTests();
			return reliableMarginLeftVal;
		},
		scrollboxSize: function() {
			computeStyleTests();
			return scrollboxSizeVal;
		},

		// Support: IE 9 - 11+, Edge 15 - 18+
		// IE/Edge misreport `getComputedStyle` of table rows with width/height
		// set in CSS while `offset*` properties report correct values.
		// Behavior in IE 9 is more subtle than in newer versions & it passes
		// some versions of this test; make sure not to make it pass there!
		//
		// Support: Firefox 70+
		// Only Firefox includes border widths
		// in computed dimensions. (gh-4529)
		reliableTrDimensions: function() {
			var table, tr, trChild, trStyle;
			if ( reliableTrDimensionsVal == null ) {
				table = document.createElement( "table" );
				tr = document.createElement( "tr" );
				trChild = document.createElement( "div" );

				table.style.cssText = "position:absolute;left:-11111px;border-collapse:separate";
				tr.style.cssText = "border:1px solid";

				// Support: Chrome 86+
				// Height set through cssText does not get applied.
				// Computed height then comes back as 0.
				tr.style.height = "1px";
				trChild.style.height = "9px";

				// Support: Android 8 Chrome 86+
				// In our bodyBackground.html iframe,
				// display for all div elements is set to "inline",
				// which causes a problem only in Android 8 Chrome 86.
				// Ensuring the div is display: block
				// gets around this issue.
				trChild.style.display = "block";

				documentElement
					.appendChild( table )
					.appendChild( tr )
					.appendChild( trChild );

				trStyle = window.getComputedStyle( tr );
				reliableTrDimensionsVal = ( parseInt( trStyle.height, 10 ) +
					parseInt( trStyle.borderTopWidth, 10 ) +
					parseInt( trStyle.borderBottomWidth, 10 ) ) === tr.offsetHeight;

				documentElement.removeChild( table );
			}
			return reliableTrDimensionsVal;
		}
	} );
} )();


function curCSS( elem, name, computed ) {
	var width, minWidth, maxWidth, ret,

		// Support: Firefox 51+
		// Retrieving style before computed somehow
		// fixes an issue with getting wrong values
		// on detached elements
		style = elem.style;

	computed = computed || getStyles( elem );

	// getPropertyValue is needed for:
	//   .css('filter') (IE 9 only, #12537)
	//   .css('--customProperty) (#3144)
	if ( computed ) {
		ret = computed.getPropertyValue( name ) || computed[ name ];

		if ( ret === "" && !isAttached( elem ) ) {
			ret = jQuery.style( elem, name );
		}

		// A tribute to the "awesome hack by Dean Edwards"
		// Android Browser returns percentage for some values,
		// but width seems to be reliably pixels.
		// This is against the CSSOM draft spec:
		// https://drafts.csswg.org/cssom/#resolved-values
		if ( !support.pixelBoxStyles() && rnumnonpx.test( ret ) && rboxStyle.test( name ) ) {

			// Remember the original values
			width = style.width;
			minWidth = style.minWidth;
			maxWidth = style.maxWidth;

			// Put in the new values to get a computed value out
			style.minWidth = style.maxWidth = style.width = ret;
			ret = computed.width;

			// Revert the changed values
			style.width = width;
			style.minWidth = minWidth;
			style.maxWidth = maxWidth;
		}
	}

	return ret !== undefined ?

		// Support: IE <=9 - 11 only
		// IE returns zIndex value as an integer.
		ret + "" :
		ret;
}


function addGetHookIf( conditionFn, hookFn ) {

	// Define the hook, we'll check on the first run if it's really needed.
	return {
		get: function() {
			if ( conditionFn() ) {

				// Hook not needed (or it's not possible to use it due
				// to missing dependency), remove it.
				delete this.get;
				return;
			}

			// Hook needed; redefine it so that the support test is not executed again.
			return ( this.get = hookFn ).apply( this, arguments );
		}
	};
}


var cssPrefixes = [ "Webkit", "Moz", "ms" ],
	emptyStyle = document.createElement( "div" ).style,
	vendorProps = {};

// Return a vendor-prefixed property or undefined
function vendorPropName( name ) {

	// Check for vendor prefixed names
	var capName = name[ 0 ].toUpperCase() + name.slice( 1 ),
		i = cssPrefixes.length;

	while ( i-- ) {
		name = cssPrefixes[ i ] + capName;
		if ( name in emptyStyle ) {
			return name;
		}
	}
}

// Return a potentially-mapped jQuery.cssProps or vendor prefixed property
function finalPropName( name ) {
	var final = jQuery.cssProps[ name ] || vendorProps[ name ];

	if ( final ) {
		return final;
	}
	if ( name in emptyStyle ) {
		return name;
	}
	return vendorProps[ name ] = vendorPropName( name ) || name;
}


var

	// Swappable if display is none or starts with table
	// except "table", "table-cell", or "table-caption"
	// See here for display values: https://developer.mozilla.org/en-US/docs/CSS/display
	rdisplayswap = /^(none|table(?!-c[ea]).+)/,
	rcustomProp = /^--/,
	cssShow = { position: "absolute", visibility: "hidden", display: "block" },
	cssNormalTransform = {
		letterSpacing: "0",
		fontWeight: "400"
	};

function setPositiveNumber( _elem, value, subtract ) {

	// Any relative (+/-) values have already been
	// normalized at this point
	var matches = rcssNum.exec( value );
	return matches ?

		// Guard against undefined "subtract", e.g., when used as in cssHooks
		Math.max( 0, matches[ 2 ] - ( subtract || 0 ) ) + ( matches[ 3 ] || "px" ) :
		value;
}

function boxModelAdjustment( elem, dimension, box, isBorderBox, styles, computedVal ) {
	var i = dimension === "width" ? 1 : 0,
		extra = 0,
		delta = 0;

	// Adjustment may not be necessary
	if ( box === ( isBorderBox ? "border" : "content" ) ) {
		return 0;
	}

	for ( ; i < 4; i += 2 ) {

		// Both box models exclude margin
		if ( box === "margin" ) {
			delta += jQuery.css( elem, box + cssExpand[ i ], true, styles );
		}

		// If we get here with a content-box, we're seeking "padding" or "border" or "margin"
		if ( !isBorderBox ) {

			// Add padding
			delta += jQuery.css( elem, "padding" + cssExpand[ i ], true, styles );

			// For "border" or "margin", add border
			if ( box !== "padding" ) {
				delta += jQuery.css( elem, "border" + cssExpand[ i ] + "Width", true, styles );

			// But still keep track of it otherwise
			} else {
				extra += jQuery.css( elem, "border" + cssExpand[ i ] + "Width", true, styles );
			}

		// If we get here with a border-box (content + padding + border), we're seeking "content" or
		// "padding" or "margin"
		} else {

			// For "content", subtract padding
			if ( box === "content" ) {
				delta -= jQuery.css( elem, "padding" + cssExpand[ i ], true, styles );
			}

			// For "content" or "padding", subtract border
			if ( box !== "margin" ) {
				delta -= jQuery.css( elem, "border" + cssExpand[ i ] + "Width", true, styles );
			}
		}
	}

	// Account for positive content-box scroll gutter when requested by providing computedVal
	if ( !isBorderBox && computedVal >= 0 ) {

		// offsetWidth/offsetHeight is a rounded sum of content, padding, scroll gutter, and border
		// Assuming integer scroll gutter, subtract the rest and round down
		delta += Math.max( 0, Math.ceil(
			elem[ "offset" + dimension[ 0 ].toUpperCase() + dimension.slice( 1 ) ] -
			computedVal -
			delta -
			extra -
			0.5

		// If offsetWidth/offsetHeight is unknown, then we can't determine content-box scroll gutter
		// Use an explicit zero to avoid NaN (gh-3964)
		) ) || 0;
	}

	return delta;
}

function getWidthOrHeight( elem, dimension, extra ) {

	// Start with computed style
	var styles = getStyles( elem ),

		// To avoid forcing a reflow, only fetch boxSizing if we need it (gh-4322).
		// Fake content-box until we know it's needed to know the true value.
		boxSizingNeeded = !support.boxSizingReliable() || extra,
		isBorderBox = boxSizingNeeded &&
			jQuery.css( elem, "boxSizing", false, styles ) === "border-box",
		valueIsBorderBox = isBorderBox,

		val = curCSS( elem, dimension, styles ),
		offsetProp = "offset" + dimension[ 0 ].toUpperCase() + dimension.slice( 1 );

	// Support: Firefox <=54
	// Return a confounding non-pixel value or feign ignorance, as appropriate.
	if ( rnumnonpx.test( val ) ) {
		if ( !extra ) {
			return val;
		}
		val = "auto";
	}


	// Support: IE 9 - 11 only
	// Use offsetWidth/offsetHeight for when box sizing is unreliable.
	// In those cases, the computed value can be trusted to be border-box.
	if ( ( !support.boxSizingReliable() && isBorderBox ||

		// Support: IE 10 - 11+, Edge 15 - 18+
		// IE/Edge misreport `getComputedStyle` of table rows with width/height
		// set in CSS while `offset*` properties report correct values.
		// Interestingly, in some cases IE 9 doesn't suffer from this issue.
		!support.reliableTrDimensions() && nodeName( elem, "tr" ) ||

		// Fall back to offsetWidth/offsetHeight when value is "auto"
		// This happens for inline elements with no explicit setting (gh-3571)
		val === "auto" ||

		// Support: Android <=4.1 - 4.3 only
		// Also use offsetWidth/offsetHeight for misreported inline dimensions (gh-3602)
		!parseFloat( val ) && jQuery.css( elem, "display", false, styles ) === "inline" ) &&

		// Make sure the element is visible & connected
		elem.getClientRects().length ) {

		isBorderBox = jQuery.css( elem, "boxSizing", false, styles ) === "border-box";

		// Where available, offsetWidth/offsetHeight approximate border box dimensions.
		// Where not available (e.g., SVG), assume unreliable box-sizing and interpret the
		// retrieved value as a content box dimension.
		valueIsBorderBox = offsetProp in elem;
		if ( valueIsBorderBox ) {
			val = elem[ offsetProp ];
		}
	}

	// Normalize "" and auto
	val = parseFloat( val ) || 0;

	// Adjust for the element's box model
	return ( val +
		boxModelAdjustment(
			elem,
			dimension,
			extra || ( isBorderBox ? "border" : "content" ),
			valueIsBorderBox,
			styles,

			// Provide the current computed size to request scroll gutter calculation (gh-3589)
			val
		)
	) + "px";
}

jQuery.extend( {

	// Add in style property hooks for overriding the default
	// behavior of getting and setting a style property
	cssHooks: {
		opacity: {
			get: function( elem, computed ) {
				if ( computed ) {

					// We should always get a number back from opacity
					var ret = curCSS( elem, "opacity" );
					return ret === "" ? "1" : ret;
				}
			}
		}
	},

	// Don't automatically add "px" to these possibly-unitless properties
	cssNumber: {
		"animationIterationCount": true,
		"columnCount": true,
		"fillOpacity": true,
		"flexGrow": true,
		"flexShrink": true,
		"fontWeight": true,
		"gridArea": true,
		"gridColumn": true,
		"gridColumnEnd": true,
		"gridColumnStart": true,
		"gridRow": true,
		"gridRowEnd": true,
		"gridRowStart": true,
		"lineHeight": true,
		"opacity": true,
		"order": true,
		"orphans": true,
		"widows": true,
		"zIndex": true,
		"zoom": true
	},

	// Add in properties whose names you wish to fix before
	// setting or getting the value
	cssProps: {},

	// Get and set the style property on a DOM Node
	style: function( elem, name, value, extra ) {

		// Don't set styles on text and comment nodes
		if ( !elem || elem.nodeType === 3 || elem.nodeType === 8 || !elem.style ) {
			return;
		}

		// Make sure that we're working with the right name
		var ret, type, hooks,
			origName = camelCase( name ),
			isCustomProp = rcustomProp.test( name ),
			style = elem.style;

		// Make sure that we're working with the right name. We don't
		// want to query the value if it is a CSS custom property
		// since they are user-defined.
		if ( !isCustomProp ) {
			name = finalPropName( origName );
		}

		// Gets hook for the prefixed version, then unprefixed version
		hooks = jQuery.cssHooks[ name ] || jQuery.cssHooks[ origName ];

		// Check if we're setting a value
		if ( value !== undefined ) {
			type = typeof value;

			// Convert "+=" or "-=" to relative numbers (#7345)
			if ( type === "string" && ( ret = rcssNum.exec( value ) ) && ret[ 1 ] ) {
				value = adjustCSS( elem, name, ret );

				// Fixes bug #9237
				type = "number";
			}

			// Make sure that null and NaN values aren't set (#7116)
			if ( value == null || value !== value ) {
				return;
			}

			// If a number was passed in, add the unit (except for certain CSS properties)
			// The isCustomProp check can be removed in jQuery 4.0 when we only auto-append
			// "px" to a few hardcoded values.
			if ( type === "number" && !isCustomProp ) {
				value += ret && ret[ 3 ] || ( jQuery.cssNumber[ origName ] ? "" : "px" );
			}

			// background-* props affect original clone's values
			if ( !support.clearCloneStyle && value === "" && name.indexOf( "background" ) === 0 ) {
				style[ name ] = "inherit";
			}

			// If a hook was provided, use that value, otherwise just set the specified value
			if ( !hooks || !( "set" in hooks ) ||
				( value = hooks.set( elem, value, extra ) ) !== undefined ) {

				if ( isCustomProp ) {
					style.setProperty( name, value );
				} else {
					style[ name ] = value;
				}
			}

		} else {

			// If a hook was provided get the non-computed value from there
			if ( hooks && "get" in hooks &&
				( ret = hooks.get( elem, false, extra ) ) !== undefined ) {

				return ret;
			}

			// Otherwise just get the value from the style object
			return style[ name ];
		}
	},

	css: function( elem, name, extra, styles ) {
		var val, num, hooks,
			origName = camelCase( name ),
			isCustomProp = rcustomProp.test( name );

		// Make sure that we're working with the right name. We don't
		// want to modify the value if it is a CSS custom property
		// since they are user-defined.
		if ( !isCustomProp ) {
			name = finalPropName( origName );
		}

		// Try prefixed name followed by the unprefixed name
		hooks = jQuery.cssHooks[ name ] || jQuery.cssHooks[ origName ];

		// If a hook was provided get the computed value from there
		if ( hooks && "get" in hooks ) {
			val = hooks.get( elem, true, extra );
		}

		// Otherwise, if a way to get the computed value exists, use that
		if ( val === undefined ) {
			val = curCSS( elem, name, styles );
		}

		// Convert "normal" to computed value
		if ( val === "normal" && name in cssNormalTransform ) {
			val = cssNormalTransform[ name ];
		}

		// Make numeric if forced or a qualifier was provided and val looks numeric
		if ( extra === "" || extra ) {
			num = parseFloat( val );
			return extra === true || isFinite( num ) ? num || 0 : val;
		}

		return val;
	}
} );

jQuery.each( [ "height", "width" ], function( _i, dimension ) {
	jQuery.cssHooks[ dimension ] = {
		get: function( elem, computed, extra ) {
			if ( computed ) {

				// Certain elements can have dimension info if we invisibly show them
				// but it must have a current display style that would benefit
				return rdisplayswap.test( jQuery.css( elem, "display" ) ) &&

					// Support: Safari 8+
					// Table columns in Safari have non-zero offsetWidth & zero
					// getBoundingClientRect().width unless display is changed.
					// Support: IE <=11 only
					// Running getBoundingClientRect on a disconnected node
					// in IE throws an error.
					( !elem.getClientRects().length || !elem.getBoundingClientRect().width ) ?
					swap( elem, cssShow, function() {
						return getWidthOrHeight( elem, dimension, extra );
					} ) :
					getWidthOrHeight( elem, dimension, extra );
			}
		},

		set: function( elem, value, extra ) {
			var matches,
				styles = getStyles( elem ),

				// Only read styles.position if the test has a chance to fail
				// to avoid forcing a reflow.
				scrollboxSizeBuggy = !support.scrollboxSize() &&
					styles.position === "absolute",

				// To avoid forcing a reflow, only fetch boxSizing if we need it (gh-3991)
				boxSizingNeeded = scrollboxSizeBuggy || extra,
				isBorderBox = boxSizingNeeded &&
					jQuery.css( elem, "boxSizing", false, styles ) === "border-box",
				subtract = extra ?
					boxModelAdjustment(
						elem,
						dimension,
						extra,
						isBorderBox,
						styles
					) :
					0;

			// Account for unreliable border-box dimensions by comparing offset* to computed and
			// faking a content-box to get border and padding (gh-3699)
			if ( isBorderBox && scrollboxSizeBuggy ) {
				subtract -= Math.ceil(
					elem[ "offset" + dimension[ 0 ].toUpperCase() + dimension.slice( 1 ) ] -
					parseFloat( styles[ dimension ] ) -
					boxModelAdjustment( elem, dimension, "border", false, styles ) -
					0.5
				);
			}

			// Convert to pixels if value adjustment is needed
			if ( subtract && ( matches = rcssNum.exec( value ) ) &&
				( matches[ 3 ] || "px" ) !== "px" ) {

				elem.style[ dimension ] = value;
				value = jQuery.css( elem, dimension );
			}

			return setPositiveNumber( elem, value, subtract );
		}
	};
} );

jQuery.cssHooks.marginLeft = addGetHookIf( support.reliableMarginLeft,
	function( elem, computed ) {
		if ( computed ) {
			return ( parseFloat( curCSS( elem, "marginLeft" ) ) ||
				elem.getBoundingClientRect().left -
					swap( elem, { marginLeft: 0 }, function() {
						return elem.getBoundingClientRect().left;
					} )
			) + "px";
		}
	}
);

// These hooks are used by animate to expand properties
jQuery.each( {
	margin: "",
	padding: "",
	border: "Width"
}, function( prefix, suffix ) {
	jQuery.cssHooks[ prefix + suffix ] = {
		expand: function( value ) {
			var i = 0,
				expanded = {},

				// Assumes a single number if not a string
				parts = typeof value === "string" ? value.split( " " ) : [ value ];

			for ( ; i < 4; i++ ) {
				expanded[ prefix + cssExpand[ i ] + suffix ] =
					parts[ i ] || parts[ i - 2 ] || parts[ 0 ];
			}

			return expanded;
		}
	};

	if ( prefix !== "margin" ) {
		jQuery.cssHooks[ prefix + suffix ].set = setPositiveNumber;
	}
} );

jQuery.fn.extend( {
	css: function( name, value ) {
		return access( this, function( elem, name, value ) {
			var styles, len,
				map = {},
				i = 0;

			if ( Array.isArray( name ) ) {
				styles = getStyles( elem );
				len = name.length;

				for ( ; i < len; i++ ) {
					map[ name[ i ] ] = jQuery.css( elem, name[ i ], false, styles );
				}

				return map;
			}

			return value !== undefined ?
				jQuery.style( elem, name, value ) :
				jQuery.css( elem, name );
		}, name, value, arguments.length > 1 );
	}
} );


function Tween( elem, options, prop, end, easing ) {
	return new Tween.prototype.init( elem, options, prop, end, easing );
}
jQuery.Tween = Tween;

Tween.prototype = {
	constructor: Tween,
	init: function( elem, options, prop, end, easing, unit ) {
		this.elem = elem;
		this.prop = prop;
		this.easing = easing || jQuery.easing._default;
		this.options = options;
		this.start = this.now = this.cur();
		this.end = end;
		this.unit = unit || ( jQuery.cssNumber[ prop ] ? "" : "px" );
	},
	cur: function() {
		var hooks = Tween.propHooks[ this.prop ];

		return hooks && hooks.get ?
			hooks.get( this ) :
			Tween.propHooks._default.get( this );
	},
	run: function( percent ) {
		var eased,
			hooks = Tween.propHooks[ this.prop ];

		if ( this.options.duration ) {
			this.pos = eased = jQuery.easing[ this.easing ](
				percent, this.options.duration * percent, 0, 1, this.options.duration
			);
		} else {
			this.pos = eased = percent;
		}
		this.now = ( this.end - this.start ) * eased + this.start;

		if ( this.options.step ) {
			this.options.step.call( this.elem, this.now, this );
		}

		if ( hooks && hooks.set ) {
			hooks.set( this );
		} else {
			Tween.propHooks._default.set( this );
		}
		return this;
	}
};

Tween.prototype.init.prototype = Tween.prototype;

Tween.propHooks = {
	_default: {
		get: function( tween ) {
			var result;

			// Use a property on the element directly when it is not a DOM element,
			// or when there is no matching style property that exists.
			if ( tween.elem.nodeType !== 1 ||
				tween.elem[ tween.prop ] != null && tween.elem.style[ tween.prop ] == null ) {
				return tween.elem[ tween.prop ];
			}

			// Passing an empty string as a 3rd parameter to .css will automatically
			// attempt a parseFloat and fallback to a string if the parse fails.
			// Simple values such as "10px" are parsed to Float;
			// complex values such as "rotate(1rad)" are returned as-is.
			result = jQuery.css( tween.elem, tween.prop, "" );

			// Empty strings, null, undefined and "auto" are converted to 0.
			return !result || result === "auto" ? 0 : result;
		},
		set: function( tween ) {

			// Use step hook for back compat.
			// Use cssHook if its there.
			// Use .style if available and use plain properties where available.
			if ( jQuery.fx.step[ tween.prop ] ) {
				jQuery.fx.step[ tween.prop ]( tween );
			} else if ( tween.elem.nodeType === 1 && (
				jQuery.cssHooks[ tween.prop ] ||
					tween.elem.style[ finalPropName( tween.prop ) ] != null ) ) {
				jQuery.style( tween.elem, tween.prop, tween.now + tween.unit );
			} else {
				tween.elem[ tween.prop ] = tween.now;
			}
		}
	}
};

// Support: IE <=9 only
// Panic based approach to setting things on disconnected nodes
Tween.propHooks.scrollTop = Tween.propHooks.scrollLeft = {
	set: function( tween ) {
		if ( tween.elem.nodeType && tween.elem.parentNode ) {
			tween.elem[ tween.prop ] = tween.now;
		}
	}
};

jQuery.easing = {
	linear: function( p ) {
		return p;
	},
	swing: function( p ) {
		return 0.5 - Math.cos( p * Math.PI ) / 2;
	},
	_default: "swing"
};

jQuery.fx = Tween.prototype.init;

// Back compat <1.8 extension point
jQuery.fx.step = {};




var
	fxNow, inProgress,
	rfxtypes = /^(?:toggle|show|hide)$/,
	rrun = /queueHooks$/;

function schedule() {
	if ( inProgress ) {
		if ( document.hidden === false && window.requestAnimationFrame ) {
			window.requestAnimationFrame( schedule );
		} else {
			window.setTimeout( schedule, jQuery.fx.interval );
		}

		jQuery.fx.tick();
	}
}

// Animations created synchronously will run synchronously
function createFxNow() {
	window.setTimeout( function() {
		fxNow = undefined;
	} );
	return ( fxNow = Date.now() );
}

// Generate parameters to create a standard animation
function genFx( type, includeWidth ) {
	var which,
		i = 0,
		attrs = { height: type };

	// If we include width, step value is 1 to do all cssExpand values,
	// otherwise step value is 2 to skip over Left and Right
	includeWidth = includeWidth ? 1 : 0;
	for ( ; i < 4; i += 2 - includeWidth ) {
		which = cssExpand[ i ];
		attrs[ "margin" + which ] = attrs[ "padding" + which ] = type;
	}

	if ( includeWidth ) {
		attrs.opacity = attrs.width = type;
	}

	return attrs;
}

function createTween( value, prop, animation ) {
	var tween,
		collection = ( Animation.tweeners[ prop ] || [] ).concat( Animation.tweeners[ "*" ] ),
		index = 0,
		length = collection.length;
	for ( ; index < length; index++ ) {
		if ( ( tween = collection[ index ].call( animation, prop, value ) ) ) {

			// We're done with this property
			return tween;
		}
	}
}

function defaultPrefilter( elem, props, opts ) {
	var prop, value, toggle, hooks, oldfire, propTween, restoreDisplay, display,
		isBox = "width" in props || "height" in props,
		anim = this,
		orig = {},
		style = elem.style,
		hidden = elem.nodeType && isHiddenWithinTree( elem ),
		dataShow = dataPriv.get( elem, "fxshow" );

	// Queue-skipping animations hijack the fx hooks
	if ( !opts.queue ) {
		hooks = jQuery._queueHooks( elem, "fx" );
		if ( hooks.unqueued == null ) {
			hooks.unqueued = 0;
			oldfire = hooks.empty.fire;
			hooks.empty.fire = function() {
				if ( !hooks.unqueued ) {
					oldfire();
				}
			};
		}
		hooks.unqueued++;

		anim.always( function() {

			// Ensure the complete handler is called before this completes
			anim.always( function() {
				hooks.unqueued--;
				if ( !jQuery.queue( elem, "fx" ).length ) {
					hooks.empty.fire();
				}
			} );
		} );
	}

	// Detect show/hide animations
	for ( prop in props ) {
		value = props[ prop ];
		if ( rfxtypes.test( value ) ) {
			delete props[ prop ];
			toggle = toggle || value === "toggle";
			if ( value === ( hidden ? "hide" : "show" ) ) {

				// Pretend to be hidden if this is a "show" and
				// there is still data from a stopped show/hide
				if ( value === "show" && dataShow && dataShow[ prop ] !== undefined ) {
					hidden = true;

				// Ignore all other no-op show/hide data
				} else {
					continue;
				}
			}
			orig[ prop ] = dataShow && dataShow[ prop ] || jQuery.style( elem, prop );
		}
	}

	// Bail out if this is a no-op like .hide().hide()
	propTween = !jQuery.isEmptyObject( props );
	if ( !propTween && jQuery.isEmptyObject( orig ) ) {
		return;
	}

	// Restrict "overflow" and "display" styles during box animations
	if ( isBox && elem.nodeType === 1 ) {

		// Support: IE <=9 - 11, Edge 12 - 15
		// Record all 3 overflow attributes because IE does not infer the shorthand
		// from identically-valued overflowX and overflowY and Edge just mirrors
		// the overflowX value there.
		opts.overflow = [ style.overflow, style.overflowX, style.overflowY ];

		// Identify a display type, preferring old show/hide data over the CSS cascade
		restoreDisplay = dataShow && dataShow.display;
		if ( restoreDisplay == null ) {
			restoreDisplay = dataPriv.get( elem, "display" );
		}
		display = jQuery.css( elem, "display" );
		if ( display === "none" ) {
			if ( restoreDisplay ) {
				display = restoreDisplay;
			} else {

				// Get nonempty value(s) by temporarily forcing visibility
				showHide( [ elem ], true );
				restoreDisplay = elem.style.display || restoreDisplay;
				display = jQuery.css( elem, "display" );
				showHide( [ elem ] );
			}
		}

		// Animate inline elements as inline-block
		if ( display === "inline" || display === "inline-block" && restoreDisplay != null ) {
			if ( jQuery.css( elem, "float" ) === "none" ) {

				// Restore the original display value at the end of pure show/hide animations
				if ( !propTween ) {
					anim.done( function() {
						style.display = restoreDisplay;
					} );
					if ( restoreDisplay == null ) {
						display = style.display;
						restoreDisplay = display === "none" ? "" : display;
					}
				}
				style.display = "inline-block";
			}
		}
	}

	if ( opts.overflow ) {
		style.overflow = "hidden";
		anim.always( function() {
			style.overflow = opts.overflow[ 0 ];
			style.overflowX = opts.overflow[ 1 ];
			style.overflowY = opts.overflow[ 2 ];
		} );
	}

	// Implement show/hide animations
	propTween = false;
	for ( prop in orig ) {

		// General show/hide setup for this element animation
		if ( !propTween ) {
			if ( dataShow ) {
				if ( "hidden" in dataShow ) {
					hidden = dataShow.hidden;
				}
			} else {
				dataShow = dataPriv.access( elem, "fxshow", { display: restoreDisplay } );
			}

			// Store hidden/visible for toggle so `.stop().toggle()` "reverses"
			if ( toggle ) {
				dataShow.hidden = !hidden;
			}

			// Show elements before animating them
			if ( hidden ) {
				showHide( [ elem ], true );
			}

			/* eslint-disable no-loop-func */

			anim.done( function() {

				/* eslint-enable no-loop-func */

				// The final step of a "hide" animation is actually hiding the element
				if ( !hidden ) {
					showHide( [ elem ] );
				}
				dataPriv.remove( elem, "fxshow" );
				for ( prop in orig ) {
					jQuery.style( elem, prop, orig[ prop ] );
				}
			} );
		}

		// Per-property setup
		propTween = createTween( hidden ? dataShow[ prop ] : 0, prop, anim );
		if ( !( prop in dataShow ) ) {
			dataShow[ prop ] = propTween.start;
			if ( hidden ) {
				propTween.end = propTween.start;
				propTween.start = 0;
			}
		}
	}
}

function propFilter( props, specialEasing ) {
	var index, name, easing, value, hooks;

	// camelCase, specialEasing and expand cssHook pass
	for ( index in props ) {
		name = camelCase( index );
		easing = specialEasing[ name ];
		value = props[ index ];
		if ( Array.isArray( value ) ) {
			easing = value[ 1 ];
			value = props[ index ] = value[ 0 ];
		}

		if ( index !== name ) {
			props[ name ] = value;
			delete props[ index ];
		}

		hooks = jQuery.cssHooks[ name ];
		if ( hooks && "expand" in hooks ) {
			value = hooks.expand( value );
			delete props[ name ];

			// Not quite $.extend, this won't overwrite existing keys.
			// Reusing 'index' because we have the correct "name"
			for ( index in value ) {
				if ( !( index in props ) ) {
					props[ index ] = value[ index ];
					specialEasing[ index ] = easing;
				}
			}
		} else {
			specialEasing[ name ] = easing;
		}
	}
}

function Animation( elem, properties, options ) {
	var result,
		stopped,
		index = 0,
		length = Animation.prefilters.length,
		deferred = jQuery.Deferred().always( function() {

			// Don't match elem in the :animated selector
			delete tick.elem;
		} ),
		tick = function() {
			if ( stopped ) {
				return false;
			}
			var currentTime = fxNow || createFxNow(),
				remaining = Math.max( 0, animation.startTime + animation.duration - currentTime ),

				// Support: Android 2.3 only
				// Archaic crash bug won't allow us to use `1 - ( 0.5 || 0 )` (#12497)
				temp = remaining / animation.duration || 0,
				percent = 1 - temp,
				index = 0,
				length = animation.tweens.length;

			for ( ; index < length; index++ ) {
				animation.tweens[ index ].run( percent );
			}

			deferred.notifyWith( elem, [ animation, percent, remaining ] );

			// If there's more to do, yield
			if ( percent < 1 && length ) {
				return remaining;
			}

			// If this was an empty animation, synthesize a final progress notification
			if ( !length ) {
				deferred.notifyWith( elem, [ animation, 1, 0 ] );
			}

			// Resolve the animation and report its conclusion
			deferred.resolveWith( elem, [ animation ] );
			return false;
		},
		animation = deferred.promise( {
			elem: elem,
			props: jQuery.extend( {}, properties ),
			opts: jQuery.extend( true, {
				specialEasing: {},
				easing: jQuery.easing._default
			}, options ),
			originalProperties: properties,
			originalOptions: options,
			startTime: fxNow || createFxNow(),
			duration: options.duration,
			tweens: [],
			createTween: function( prop, end ) {
				var tween = jQuery.Tween( elem, animation.opts, prop, end,
					animation.opts.specialEasing[ prop ] || animation.opts.easing );
				animation.tweens.push( tween );
				return tween;
			},
			stop: function( gotoEnd ) {
				var index = 0,

					// If we are going to the end, we want to run all the tweens
					// otherwise we skip this part
					length = gotoEnd ? animation.tweens.length : 0;
				if ( stopped ) {
					return this;
				}
				stopped = true;
				for ( ; index < length; index++ ) {
					animation.tweens[ index ].run( 1 );
				}

				// Resolve when we played the last frame; otherwise, reject
				if ( gotoEnd ) {
					deferred.notifyWith( elem, [ animation, 1, 0 ] );
					deferred.resolveWith( elem, [ animation, gotoEnd ] );
				} else {
					deferred.rejectWith( elem, [ animation, gotoEnd ] );
				}
				return this;
			}
		} ),
		props = animation.props;

	propFilter( props, animation.opts.specialEasing );

	for ( ; index < length; index++ ) {
		result = Animation.prefilters[ index ].call( animation, elem, props, animation.opts );
		if ( result ) {
			if ( isFunction( result.stop ) ) {
				jQuery._queueHooks( animation.elem, animation.opts.queue ).stop =
					result.stop.bind( result );
			}
			return result;
		}
	}

	jQuery.map( props, createTween, animation );

	if ( isFunction( animation.opts.start ) ) {
		animation.opts.start.call( elem, animation );
	}

	// Attach callbacks from options
	animation
		.progress( animation.opts.progress )
		.done( animation.opts.done, animation.opts.complete )
		.fail( animation.opts.fail )
		.always( animation.opts.always );

	jQuery.fx.timer(
		jQuery.extend( tick, {
			elem: elem,
			anim: animation,
			queue: animation.opts.queue
		} )
	);

	return animation;
}

jQuery.Animation = jQuery.extend( Animation, {

	tweeners: {
		"*": [ function( prop, value ) {
			var tween = this.createTween( prop, value );
			adjustCSS( tween.elem, prop, rcssNum.exec( value ), tween );
			return tween;
		} ]
	},

	tweener: function( props, callback ) {
		if ( isFunction( props ) ) {
			callback = props;
			props = [ "*" ];
		} else {
			props = props.match( rnothtmlwhite );
		}

		var prop,
			index = 0,
			length = props.length;

		for ( ; index < length; index++ ) {
			prop = props[ index ];
			Animation.tweeners[ prop ] = Animation.tweeners[ prop ] || [];
			Animation.tweeners[ prop ].unshift( callback );
		}
	},

	prefilters: [ defaultPrefilter ],

	prefilter: function( callback, prepend ) {
		if ( prepend ) {
			Animation.prefilters.unshift( callback );
		} else {
			Animation.prefilters.push( callback );
		}
	}
} );

jQuery.speed = function( speed, easing, fn ) {
	var opt = speed && typeof speed === "object" ? jQuery.extend( {}, speed ) : {
		complete: fn || !fn && easing ||
			isFunction( speed ) && speed,
		duration: speed,
		easing: fn && easing || easing && !isFunction( easing ) && easing
	};

	// Go to the end state if fx are off
	if ( jQuery.fx.off ) {
		opt.duration = 0;

	} else {
		if ( typeof opt.duration !== "number" ) {
			if ( opt.duration in jQuery.fx.speeds ) {
				opt.duration = jQuery.fx.speeds[ opt.duration ];

			} else {
				opt.duration = jQuery.fx.speeds._default;
			}
		}
	}

	// Normalize opt.queue - true/undefined/null -> "fx"
	if ( opt.queue == null || opt.queue === true ) {
		opt.queue = "fx";
	}

	// Queueing
	opt.old = opt.complete;

	opt.complete = function() {
		if ( isFunction( opt.old ) ) {
			opt.old.call( this );
		}

		if ( opt.queue ) {
			jQuery.dequeue( this, opt.queue );
		}
	};

	return opt;
};

jQuery.fn.extend( {
	fadeTo: function( speed, to, easing, callback ) {

		// Show any hidden elements after setting opacity to 0
		return this.filter( isHiddenWithinTree ).css( "opacity", 0 ).show()

			// Animate to the value specified
			.end().animate( { opacity: to }, speed, easing, callback );
	},
	animate: function( prop, speed, easing, callback ) {
		var empty = jQuery.isEmptyObject( prop ),
			optall = jQuery.speed( speed, easing, callback ),
			doAnimation = function() {

				// Operate on a copy of prop so per-property easing won't be lost
				var anim = Animation( this, jQuery.extend( {}, prop ), optall );

				// Empty animations, or finishing resolves immediately
				if ( empty || dataPriv.get( this, "finish" ) ) {
					anim.stop( true );
				}
			};

		doAnimation.finish = doAnimation;

		return empty || optall.queue === false ?
			this.each( doAnimation ) :
			this.queue( optall.queue, doAnimation );
	},
	stop: function( type, clearQueue, gotoEnd ) {
		var stopQueue = function( hooks ) {
			var stop = hooks.stop;
			delete hooks.stop;
			stop( gotoEnd );
		};

		if ( typeof type !== "string" ) {
			gotoEnd = clearQueue;
			clearQueue = type;
			type = undefined;
		}
		if ( clearQueue ) {
			this.queue( type || "fx", [] );
		}

		return this.each( function() {
			var dequeue = true,
				index = type != null && type + "queueHooks",
				timers = jQuery.timers,
				data = dataPriv.get( this );

			if ( index ) {
				if ( data[ index ] && data[ index ].stop ) {
					stopQueue( data[ index ] );
				}
			} else {
				for ( index in data ) {
					if ( data[ index ] && data[ index ].stop && rrun.test( index ) ) {
						stopQueue( data[ index ] );
					}
				}
			}

			for ( index = timers.length; index--; ) {
				if ( timers[ index ].elem === this &&
					( type == null || timers[ index ].queue === type ) ) {

					timers[ index ].anim.stop( gotoEnd );
					dequeue = false;
					timers.splice( index, 1 );
				}
			}

			// Start the next in the queue if the last step wasn't forced.
			// Timers currently will call their complete callbacks, which
			// will dequeue but only if they were gotoEnd.
			if ( dequeue || !gotoEnd ) {
				jQuery.dequeue( this, type );
			}
		} );
	},
	finish: function( type ) {
		if ( type !== false ) {
			type = type || "fx";
		}
		return this.each( function() {
			var index,
				data = dataPriv.get( this ),
				queue = data[ type + "queue" ],
				hooks = data[ type + "queueHooks" ],
				timers = jQuery.timers,
				length = queue ? queue.length : 0;

			// Enable finishing flag on private data
			data.finish = true;

			// Empty the queue first
			jQuery.queue( this, type, [] );

			if ( hooks && hooks.stop ) {
				hooks.stop.call( this, true );
			}

			// Look for any active animations, and finish them
			for ( index = timers.length; index--; ) {
				if ( timers[ index ].elem === this && timers[ index ].queue === type ) {
					timers[ index ].anim.stop( true );
					timers.splice( index, 1 );
				}
			}

			// Look for any animations in the old queue and finish them
			for ( index = 0; index < length; index++ ) {
				if ( queue[ index ] && queue[ index ].finish ) {
					queue[ index ].finish.call( this );
				}
			}

			// Turn off finishing flag
			delete data.finish;
		} );
	}
} );

jQuery.each( [ "toggle", "show", "hide" ], function( _i, name ) {
	var cssFn = jQuery.fn[ name ];
	jQuery.fn[ name ] = function( speed, easing, callback ) {
		return speed == null || typeof speed === "boolean" ?
			cssFn.apply( this, arguments ) :
			this.animate( genFx( name, true ), speed, easing, callback );
	};
} );

// Generate shortcuts for custom animations
jQuery.each( {
	slideDown: genFx( "show" ),
	slideUp: genFx( "hide" ),
	slideToggle: genFx( "toggle" ),
	fadeIn: { opacity: "show" },
	fadeOut: { opacity: "hide" },
	fadeToggle: { opacity: "toggle" }
}, function( name, props ) {
	jQuery.fn[ name ] = function( speed, easing, callback ) {
		return this.animate( props, speed, easing, callback );
	};
} );

jQuery.timers = [];
jQuery.fx.tick = function() {
	var timer,
		i = 0,
		timers = jQuery.timers;

	fxNow = Date.now();

	for ( ; i < timers.length; i++ ) {
		timer = timers[ i ];

		// Run the timer and safely remove it when done (allowing for external removal)
		if ( !timer() && timers[ i ] === timer ) {
			timers.splice( i--, 1 );
		}
	}

	if ( !timers.length ) {
		jQuery.fx.stop();
	}
	fxNow = undefined;
};

jQuery.fx.timer = function( timer ) {
	jQuery.timers.push( timer );
	jQuery.fx.start();
};

jQuery.fx.interval = 13;
jQuery.fx.start = function() {
	if ( inProgress ) {
		return;
	}

	inProgress = true;
	schedule();
};

jQuery.fx.stop = function() {
	inProgress = null;
};

jQuery.fx.speeds = {
	slow: 600,
	fast: 200,

	// Default speed
	_default: 400
};


// Based off of the plugin by Clint Helfers, with permission.
// https://web.archive.org/web/20100324014747/http://blindsignals.com/index.php/2009/07/jquery-delay/
jQuery.fn.delay = function( time, type ) {
	time = jQuery.fx ? jQuery.fx.speeds[ time ] || time : time;
	type = type || "fx";

	return this.queue( type, function( next, hooks ) {
		var timeout = window.setTimeout( next, time );
		hooks.stop = function() {
			window.clearTimeout( timeout );
		};
	} );
};


( function() {
	var input = document.createElement( "input" ),
		select = document.createElement( "select" ),
		opt = select.appendChild( document.createElement( "option" ) );

	input.type = "checkbox";

	// Support: Android <=4.3 only
	// Default value for a checkbox should be "on"
	support.checkOn = input.value !== "";

	// Support: IE <=11 only
	// Must access selectedIndex to make default options select
	support.optSelected = opt.selected;

	// Support: IE <=11 only
	// An input loses its value after becoming a radio
	input = document.createElement( "input" );
	input.value = "t";
	input.type = "radio";
	support.radioValue = input.value === "t";
} )();


var boolHook,
	attrHandle = jQuery.expr.attrHandle;

jQuery.fn.extend( {
	attr: function( name, value ) {
		return access( this, jQuery.attr, name, value, arguments.length > 1 );
	},

	removeAttr: function( name ) {
		return this.each( function() {
			jQuery.removeAttr( this, name );
		} );
	}
} );

jQuery.extend( {
	attr: function( elem, name, value ) {
		var ret, hooks,
			nType = elem.nodeType;

		// Don't get/set attributes on text, comment and attribute nodes
		if ( nType === 3 || nType === 8 || nType === 2 ) {
			return;
		}

		// Fallback to prop when attributes are not supported
		if ( typeof elem.getAttribute === "undefined" ) {
			return jQuery.prop( elem, name, value );
		}

		// Attribute hooks are determined by the lowercase version
		// Grab necessary hook if one is defined
		if ( nType !== 1 || !jQuery.isXMLDoc( elem ) ) {
			hooks = jQuery.attrHooks[ name.toLowerCase() ] ||
				( jQuery.expr.match.bool.test( name ) ? boolHook : undefined );
		}

		if ( value !== undefined ) {
			if ( value === null ) {
				jQuery.removeAttr( elem, name );
				return;
			}

			if ( hooks && "set" in hooks &&
				( ret = hooks.set( elem, value, name ) ) !== undefined ) {
				return ret;
			}

			elem.setAttribute( name, value + "" );
			return value;
		}

		if ( hooks && "get" in hooks && ( ret = hooks.get( elem, name ) ) !== null ) {
			return ret;
		}

		ret = jQuery.find.attr( elem, name );

		// Non-existent attributes return null, we normalize to undefined
		return ret == null ? undefined : ret;
	},

	attrHooks: {
		type: {
			set: function( elem, value ) {
				if ( !support.radioValue && value === "radio" &&
					nodeName( elem, "input" ) ) {
					var val = elem.value;
					elem.setAttribute( "type", value );
					if ( val ) {
						elem.value = val;
					}
					return value;
				}
			}
		}
	},

	removeAttr: function( elem, value ) {
		var name,
			i = 0,

			// Attribute names can contain non-HTML whitespace characters
			// https://html.spec.whatwg.org/multipage/syntax.html#attributes-2
			attrNames = value && value.match( rnothtmlwhite );

		if ( attrNames && elem.nodeType === 1 ) {
			while ( ( name = attrNames[ i++ ] ) ) {
				elem.removeAttribute( name );
			}
		}
	}
} );

// Hooks for boolean attributes
boolHook = {
	set: function( elem, value, name ) {
		if ( value === false ) {

			// Remove boolean attributes when set to false
			jQuery.removeAttr( elem, name );
		} else {
			elem.setAttribute( name, name );
		}
		return name;
	}
};

jQuery.each( jQuery.expr.match.bool.source.match( /\w+/g ), function( _i, name ) {
	var getter = attrHandle[ name ] || jQuery.find.attr;

	attrHandle[ name ] = function( elem, name, isXML ) {
		var ret, handle,
			lowercaseName = name.toLowerCase();

		if ( !isXML ) {

			// Avoid an infinite loop by temporarily removing this function from the getter
			handle = attrHandle[ lowercaseName ];
			attrHandle[ lowercaseName ] = ret;
			ret = getter( elem, name, isXML ) != null ?
				lowercaseName :
				null;
			attrHandle[ lowercaseName ] = handle;
		}
		return ret;
	};
} );




var rfocusable = /^(?:input|select|textarea|button)$/i,
	rclickable = /^(?:a|area)$/i;

jQuery.fn.extend( {
	prop: function( name, value ) {
		return access( this, jQuery.prop, name, value, arguments.length > 1 );
	},

	removeProp: function( name ) {
		return this.each( function() {
			delete this[ jQuery.propFix[ name ] || name ];
		} );
	}
} );

jQuery.extend( {
	prop: function( elem, name, value ) {
		var ret, hooks,
			nType = elem.nodeType;

		// Don't get/set properties on text, comment and attribute nodes
		if ( nType === 3 || nType === 8 || nType === 2 ) {
			return;
		}

		if ( nType !== 1 || !jQuery.isXMLDoc( elem ) ) {

			// Fix name and attach hooks
			name = jQuery.propFix[ name ] || name;
			hooks = jQuery.propHooks[ name ];
		}

		if ( value !== undefined ) {
			if ( hooks && "set" in hooks &&
				( ret = hooks.set( elem, value, name ) ) !== undefined ) {
				return ret;
			}

			return ( elem[ name ] = value );
		}

		if ( hooks && "get" in hooks && ( ret = hooks.get( elem, name ) ) !== null ) {
			return ret;
		}

		return elem[ name ];
	},

	propHooks: {
		tabIndex: {
			get: function( elem ) {

				// Support: IE <=9 - 11 only
				// elem.tabIndex doesn't always return the
				// correct value when it hasn't been explicitly set
				// https://web.archive.org/web/20141116233347/http://fluidproject.org/blog/2008/01/09/getting-setting-and-removing-tabindex-values-with-javascript/
				// Use proper attribute retrieval(#12072)
				var tabindex = jQuery.find.attr( elem, "tabindex" );

				if ( tabindex ) {
					return parseInt( tabindex, 10 );
				}

				if (
					rfocusable.test( elem.nodeName ) ||
					rclickable.test( elem.nodeName ) &&
					elem.href
				) {
					return 0;
				}

				return -1;
			}
		}
	},

	propFix: {
		"for": "htmlFor",
		"class": "className"
	}
} );

// Support: IE <=11 only
// Accessing the selectedIndex property
// forces the browser to respect setting selected
// on the option
// The getter ensures a default option is selected
// when in an optgroup
// eslint rule "no-unused-expressions" is disabled for this code
// since it considers such accessions noop
if ( !support.optSelected ) {
	jQuery.propHooks.selected = {
		get: function( elem ) {

			/* eslint no-unused-expressions: "off" */

			var parent = elem.parentNode;
			if ( parent && parent.parentNode ) {
				parent.parentNode.selectedIndex;
			}
			return null;
		},
		set: function( elem ) {

			/* eslint no-unused-expressions: "off" */

			var parent = elem.parentNode;
			if ( parent ) {
				parent.selectedIndex;

				if ( parent.parentNode ) {
					parent.parentNode.selectedIndex;
				}
			}
		}
	};
}

jQuery.each( [
	"tabIndex",
	"readOnly",
	"maxLength",
	"cellSpacing",
	"cellPadding",
	"rowSpan",
	"colSpan",
	"useMap",
	"frameBorder",
	"contentEditable"
], function() {
	jQuery.propFix[ this.toLowerCase() ] = this;
} );




	// Strip and collapse whitespace according to HTML spec
	// https://infra.spec.whatwg.org/#strip-and-collapse-ascii-whitespace
	function stripAndCollapse( value ) {
		var tokens = value.match( rnothtmlwhite ) || [];
		return tokens.join( " " );
	}


function getClass( elem ) {
	return elem.getAttribute && elem.getAttribute( "class" ) || "";
}

function classesToArray( value ) {
	if ( Array.isArray( value ) ) {
		return value;
	}
	if ( typeof value === "string" ) {
		return value.match( rnothtmlwhite ) || [];
	}
	return [];
}

jQuery.fn.extend( {
	addClass: function( value ) {
		var classes, elem, cur, curValue, clazz, j, finalValue,
			i = 0;

		if ( isFunction( value ) ) {
			return this.each( function( j ) {
				jQuery( this ).addClass( value.call( this, j, getClass( this ) ) );
			} );
		}

		classes = classesToArray( value );

		if ( classes.length ) {
			while ( ( elem = this[ i++ ] ) ) {
				curValue = getClass( elem );
				cur = elem.nodeType === 1 && ( " " + stripAndCollapse( curValue ) + " " );

				if ( cur ) {
					j = 0;
					while ( ( clazz = classes[ j++ ] ) ) {
						if ( cur.indexOf( " " + clazz + " " ) < 0 ) {
							cur += clazz + " ";
						}
					}

					// Only assign if different to avoid unneeded rendering.
					finalValue = stripAndCollapse( cur );
					if ( curValue !== finalValue ) {
						elem.setAttribute( "class", finalValue );
					}
				}
			}
		}

		return this;
	},

	removeClass: function( value ) {
		var classes, elem, cur, curValue, clazz, j, finalValue,
			i = 0;

		if ( isFunction( value ) ) {
			return this.each( function( j ) {
				jQuery( this ).removeClass( value.call( this, j, getClass( this ) ) );
			} );
		}

		if ( !arguments.length ) {
			return this.attr( "class", "" );
		}

		classes = classesToArray( value );

		if ( classes.length ) {
			while ( ( elem = this[ i++ ] ) ) {
				curValue = getClass( elem );

				// This expression is here for better compressibility (see addClass)
				cur = elem.nodeType === 1 && ( " " + stripAndCollapse( curValue ) + " " );

				if ( cur ) {
					j = 0;
					while ( ( clazz = classes[ j++ ] ) ) {

						// Remove *all* instances
						while ( cur.indexOf( " " + clazz + " " ) > -1 ) {
							cur = cur.replace( " " + clazz + " ", " " );
						}
					}

					// Only assign if different to avoid unneeded rendering.
					finalValue = stripAndCollapse( cur );
					if ( curValue !== finalValue ) {
						elem.setAttribute( "class", finalValue );
					}
				}
			}
		}

		return this;
	},

	toggleClass: function( value, stateVal ) {
		var type = typeof value,
			isValidValue = type === "string" || Array.isArray( value );

		if ( typeof stateVal === "boolean" && isValidValue ) {
			return stateVal ? this.addClass( value ) : this.removeClass( value );
		}

		if ( isFunction( value ) ) {
			return this.each( function( i ) {
				jQuery( this ).toggleClass(
					value.call( this, i, getClass( this ), stateVal ),
					stateVal
				);
			} );
		}

		return this.each( function() {
			var className, i, self, classNames;

			if ( isValidValue ) {

				// Toggle individual class names
				i = 0;
				self = jQuery( this );
				classNames = classesToArray( value );

				while ( ( className = classNames[ i++ ] ) ) {

					// Check each className given, space separated list
					if ( self.hasClass( className ) ) {
						self.removeClass( className );
					} else {
						self.addClass( className );
					}
				}

			// Toggle whole class name
			} else if ( value === undefined || type === "boolean" ) {
				className = getClass( this );
				if ( className ) {

					// Store className if set
					dataPriv.set( this, "__className__", className );
				}

				// If the element has a class name or if we're passed `false`,
				// then remove the whole classname (if there was one, the above saved it).
				// Otherwise bring back whatever was previously saved (if anything),
				// falling back to the empty string if nothing was stored.
				if ( this.setAttribute ) {
					this.setAttribute( "class",
						className || value === false ?
							"" :
							dataPriv.get( this, "__className__" ) || ""
					);
				}
			}
		} );
	},

	hasClass: function( selector ) {
		var className, elem,
			i = 0;

		className = " " + selector + " ";
		while ( ( elem = this[ i++ ] ) ) {
			if ( elem.nodeType === 1 &&
				( " " + stripAndCollapse( getClass( elem ) ) + " " ).indexOf( className ) > -1 ) {
				return true;
			}
		}

		return false;
	}
} );




var rreturn = /\r/g;

jQuery.fn.extend( {
	val: function( value ) {
		var hooks, ret, valueIsFunction,
			elem = this[ 0 ];

		if ( !arguments.length ) {
			if ( elem ) {
				hooks = jQuery.valHooks[ elem.type ] ||
					jQuery.valHooks[ elem.nodeName.toLowerCase() ];

				if ( hooks &&
					"get" in hooks &&
					( ret = hooks.get( elem, "value" ) ) !== undefined
				) {
					return ret;
				}

				ret = elem.value;

				// Handle most common string cases
				if ( typeof ret === "string" ) {
					return ret.replace( rreturn, "" );
				}

				// Handle cases where value is null/undef or number
				return ret == null ? "" : ret;
			}

			return;
		}

		valueIsFunction = isFunction( value );

		return this.each( function( i ) {
			var val;

			if ( this.nodeType !== 1 ) {
				return;
			}

			if ( valueIsFunction ) {
				val = value.call( this, i, jQuery( this ).val() );
			} else {
				val = value;
			}

			// Treat null/undefined as ""; convert numbers to string
			if ( val == null ) {
				val = "";

			} else if ( typeof val === "number" ) {
				val += "";

			} else if ( Array.isArray( val ) ) {
				val = jQuery.map( val, function( value ) {
					return value == null ? "" : value + "";
				} );
			}

			hooks = jQuery.valHooks[ this.type ] || jQuery.valHooks[ this.nodeName.toLowerCase() ];

			// If set returns undefined, fall back to normal setting
			if ( !hooks || !( "set" in hooks ) || hooks.set( this, val, "value" ) === undefined ) {
				this.value = val;
			}
		} );
	}
} );

jQuery.extend( {
	valHooks: {
		option: {
			get: function( elem ) {

				var val = jQuery.find.attr( elem, "value" );
				return val != null ?
					val :

					// Support: IE <=10 - 11 only
					// option.text throws exceptions (#14686, #14858)
					// Strip and collapse whitespace
					// https://html.spec.whatwg.org/#strip-and-collapse-whitespace
					stripAndCollapse( jQuery.text( elem ) );
			}
		},
		select: {
			get: function( elem ) {
				var value, option, i,
					options = elem.options,
					index = elem.selectedIndex,
					one = elem.type === "select-one",
					values = one ? null : [],
					max = one ? index + 1 : options.length;

				if ( index < 0 ) {
					i = max;

				} else {
					i = one ? index : 0;
				}

				// Loop through all the selected options
				for ( ; i < max; i++ ) {
					option = options[ i ];

					// Support: IE <=9 only
					// IE8-9 doesn't update selected after form reset (#2551)
					if ( ( option.selected || i === index ) &&

							// Don't return options that are disabled or in a disabled optgroup
							!option.disabled &&
							( !option.parentNode.disabled ||
								!nodeName( option.parentNode, "optgroup" ) ) ) {

						// Get the specific value for the option
						value = jQuery( option ).val();

						// We don't need an array for one selects
						if ( one ) {
							return value;
						}

						// Multi-Selects return an array
						values.push( value );
					}
				}

				return values;
			},

			set: function( elem, value ) {
				var optionSet, option,
					options = elem.options,
					values = jQuery.makeArray( value ),
					i = options.length;

				while ( i-- ) {
					option = options[ i ];

					/* eslint-disable no-cond-assign */

					if ( option.selected =
						jQuery.inArray( jQuery.valHooks.option.get( option ), values ) > -1
					) {
						optionSet = true;
					}

					/* eslint-enable no-cond-assign */
				}

				// Force browsers to behave consistently when non-matching value is set
				if ( !optionSet ) {
					elem.selectedIndex = -1;
				}
				return values;
			}
		}
	}
} );

// Radios and checkboxes getter/setter
jQuery.each( [ "radio", "checkbox" ], function() {
	jQuery.valHooks[ this ] = {
		set: function( elem, value ) {
			if ( Array.isArray( value ) ) {
				return ( elem.checked = jQuery.inArray( jQuery( elem ).val(), value ) > -1 );
			}
		}
	};
	if ( !support.checkOn ) {
		jQuery.valHooks[ this ].get = function( elem ) {
			return elem.getAttribute( "value" ) === null ? "on" : elem.value;
		};
	}
} );




// Return jQuery for attributes-only inclusion


support.focusin = "onfocusin" in window;


var rfocusMorph = /^(?:focusinfocus|focusoutblur)$/,
	stopPropagationCallback = function( e ) {
		e.stopPropagation();
	};

jQuery.extend( jQuery.event, {

	trigger: function( event, data, elem, onlyHandlers ) {

		var i, cur, tmp, bubbleType, ontype, handle, special, lastElement,
			eventPath = [ elem || document ],
			type = hasOwn.call( event, "type" ) ? event.type : event,
			namespaces = hasOwn.call( event, "namespace" ) ? event.namespace.split( "." ) : [];

		cur = lastElement = tmp = elem = elem || document;

		// Don't do events on text and comment nodes
		if ( elem.nodeType === 3 || elem.nodeType === 8 ) {
			return;
		}

		// focus/blur morphs to focusin/out; ensure we're not firing them right now
		if ( rfocusMorph.test( type + jQuery.event.triggered ) ) {
			return;
		}

		if ( type.indexOf( "." ) > -1 ) {

			// Namespaced trigger; create a regexp to match event type in handle()
			namespaces = type.split( "." );
			type = namespaces.shift();
			namespaces.sort();
		}
		ontype = type.indexOf( ":" ) < 0 && "on" + type;

		// Caller can pass in a jQuery.Event object, Object, or just an event type string
		event = event[ jQuery.expando ] ?
			event :
			new jQuery.Event( type, typeof event === "object" && event );

		// Trigger bitmask: & 1 for native handlers; & 2 for jQuery (always true)
		event.isTrigger = onlyHandlers ? 2 : 3;
		event.namespace = namespaces.join( "." );
		event.rnamespace = event.namespace ?
			new RegExp( "(^|\\.)" + namespaces.join( "\\.(?:.*\\.|)" ) + "(\\.|$)" ) :
			null;

		// Clean up the event in case it is being reused
		event.result = undefined;
		if ( !event.target ) {
			event.target = elem;
		}

		// Clone any incoming data and prepend the event, creating the handler arg list
		data = data == null ?
			[ event ] :
			jQuery.makeArray( data, [ event ] );

		// Allow special events to draw outside the lines
		special = jQuery.event.special[ type ] || {};
		if ( !onlyHandlers && special.trigger && special.trigger.apply( elem, data ) === false ) {
			return;
		}

		// Determine event propagation path in advance, per W3C events spec (#9951)
		// Bubble up to document, then to window; watch for a global ownerDocument var (#9724)
		if ( !onlyHandlers && !special.noBubble && !isWindow( elem ) ) {

			bubbleType = special.delegateType || type;
			if ( !rfocusMorph.test( bubbleType + type ) ) {
				cur = cur.parentNode;
			}
			for ( ; cur; cur = cur.parentNode ) {
				eventPath.push( cur );
				tmp = cur;
			}

			// Only add window if we got to document (e.g., not plain obj or detached DOM)
			if ( tmp === ( elem.ownerDocument || document ) ) {
				eventPath.push( tmp.defaultView || tmp.parentWindow || window );
			}
		}

		// Fire handlers on the event path
		i = 0;
		while ( ( cur = eventPath[ i++ ] ) && !event.isPropagationStopped() ) {
			lastElement = cur;
			event.type = i > 1 ?
				bubbleType :
				special.bindType || type;

			// jQuery handler
			handle = ( dataPriv.get( cur, "events" ) || Object.create( null ) )[ event.type ] &&
				dataPriv.get( cur, "handle" );
			if ( handle ) {
				handle.apply( cur, data );
			}

			// Native handler
			handle = ontype && cur[ ontype ];
			if ( handle && handle.apply && acceptData( cur ) ) {
				event.result = handle.apply( cur, data );
				if ( event.result === false ) {
					event.preventDefault();
				}
			}
		}
		event.type = type;

		// If nobody prevented the default action, do it now
		if ( !onlyHandlers && !event.isDefaultPrevented() ) {

			if ( ( !special._default ||
				special._default.apply( eventPath.pop(), data ) === false ) &&
				acceptData( elem ) ) {

				// Call a native DOM method on the target with the same name as the event.
				// Don't do default actions on window, that's where global variables be (#6170)
				if ( ontype && isFunction( elem[ type ] ) && !isWindow( elem ) ) {

					// Don't re-trigger an onFOO event when we call its FOO() method
					tmp = elem[ ontype ];

					if ( tmp ) {
						elem[ ontype ] = null;
					}

					// Prevent re-triggering of the same event, since we already bubbled it above
					jQuery.event.triggered = type;

					if ( event.isPropagationStopped() ) {
						lastElement.addEventListener( type, stopPropagationCallback );
					}

					elem[ type ]();

					if ( event.isPropagationStopped() ) {
						lastElement.removeEventListener( type, stopPropagationCallback );
					}

					jQuery.event.triggered = undefined;

					if ( tmp ) {
						elem[ ontype ] = tmp;
					}
				}
			}
		}

		return event.result;
	},

	// Piggyback on a donor event to simulate a different one
	// Used only for `focus(in | out)` events
	simulate: function( type, elem, event ) {
		var e = jQuery.extend(
			new jQuery.Event(),
			event,
			{
				type: type,
				isSimulated: true
			}
		);

		jQuery.event.trigger( e, null, elem );
	}

} );

jQuery.fn.extend( {

	trigger: function( type, data ) {
		return this.each( function() {
			jQuery.event.trigger( type, data, this );
		} );
	},
	triggerHandler: function( type, data ) {
		var elem = this[ 0 ];
		if ( elem ) {
			return jQuery.event.trigger( type, data, elem, true );
		}
	}
} );


// Support: Firefox <=44
// Firefox doesn't have focus(in | out) events
// Related ticket - https://bugzilla.mozilla.org/show_bug.cgi?id=687787
//
// Support: Chrome <=48 - 49, Safari <=9.0 - 9.1
// focus(in | out) events fire after focus & blur events,
// which is spec violation - http://www.w3.org/TR/DOM-Level-3-Events/#events-focusevent-event-order
// Related ticket - https://bugs.chromium.org/p/chromium/issues/detail?id=449857
if ( !support.focusin ) {
	jQuery.each( { focus: "focusin", blur: "focusout" }, function( orig, fix ) {

		// Attach a single capturing handler on the document while someone wants focusin/focusout
		var handler = function( event ) {
			jQuery.event.simulate( fix, event.target, jQuery.event.fix( event ) );
		};

		jQuery.event.special[ fix ] = {
			setup: function() {

				// Handle: regular nodes (via `this.ownerDocument`), window
				// (via `this.document`) & document (via `this`).
				var doc = this.ownerDocument || this.document || this,
					attaches = dataPriv.access( doc, fix );

				if ( !attaches ) {
					doc.addEventListener( orig, handler, true );
				}
				dataPriv.access( doc, fix, ( attaches || 0 ) + 1 );
			},
			teardown: function() {
				var doc = this.ownerDocument || this.document || this,
					attaches = dataPriv.access( doc, fix ) - 1;

				if ( !attaches ) {
					doc.removeEventListener( orig, handler, true );
					dataPriv.remove( doc, fix );

				} else {
					dataPriv.access( doc, fix, attaches );
				}
			}
		};
	} );
}
var location = window.location;

var nonce = { guid: Date.now() };

var rquery = ( /\?/ );



// Cross-browser xml parsing
jQuery.parseXML = function( data ) {
	var xml, parserErrorElem;
	if ( !data || typeof data !== "string" ) {
		return null;
	}

	// Support: IE 9 - 11 only
	// IE throws on parseFromString with invalid input.
	try {
		xml = ( new window.DOMParser() ).parseFromString( data, "text/xml" );
	} catch ( e ) {}

	parserErrorElem = xml && xml.getElementsByTagName( "parsererror" )[ 0 ];
	if ( !xml || parserErrorElem ) {
		jQuery.error( "Invalid XML: " + (
			parserErrorElem ?
				jQuery.map( parserErrorElem.childNodes, function( el ) {
					return el.textContent;
				} ).join( "\n" ) :
				data
		) );
	}
	return xml;
};


var
	rbracket = /\[\]$/,
	rCRLF = /\r?\n/g,
	rsubmitterTypes = /^(?:submit|button|image|reset|file)$/i,
	rsubmittable = /^(?:input|select|textarea|keygen)/i;

function buildParams( prefix, obj, traditional, add ) {
	var name;

	if ( Array.isArray( obj ) ) {

		// Serialize array item.
		jQuery.each( obj, function( i, v ) {
			if ( traditional || rbracket.test( prefix ) ) {

				// Treat each array item as a scalar.
				add( prefix, v );

			} else {

				// Item is non-scalar (array or object), encode its numeric index.
				buildParams(
					prefix + "[" + ( typeof v === "object" && v != null ? i : "" ) + "]",
					v,
					traditional,
					add
				);
			}
		} );

	} else if ( !traditional && toType( obj ) === "object" ) {

		// Serialize object item.
		for ( name in obj ) {
			buildParams( prefix + "[" + name + "]", obj[ name ], traditional, add );
		}

	} else {

		// Serialize scalar item.
		add( prefix, obj );
	}
}

// Serialize an array of form elements or a set of
// key/values into a query string
jQuery.param = function( a, traditional ) {
	var prefix,
		s = [],
		add = function( key, valueOrFunction ) {

			// If value is a function, invoke it and use its return value
			var value = isFunction( valueOrFunction ) ?
				valueOrFunction() :
				valueOrFunction;

			s[ s.length ] = encodeURIComponent( key ) + "=" +
				encodeURIComponent( value == null ? "" : value );
		};

	if ( a == null ) {
		return "";
	}

	// If an array was passed in, assume that it is an array of form elements.
	if ( Array.isArray( a ) || ( a.jquery && !jQuery.isPlainObject( a ) ) ) {

		// Serialize the form elements
		jQuery.each( a, function() {
			add( this.name, this.value );
		} );

	} else {

		// If traditional, encode the "old" way (the way 1.3.2 or older
		// did it), otherwise encode params recursively.
		for ( prefix in a ) {
			buildParams( prefix, a[ prefix ], traditional, add );
		}
	}

	// Return the resulting serialization
	return s.join( "&" );
};

jQuery.fn.extend( {
	serialize: function() {
		return jQuery.param( this.serializeArray() );
	},
	serializeArray: function() {
		return this.map( function() {

			// Can add propHook for "elements" to filter or add form elements
			var elements = jQuery.prop( this, "elements" );
			return elements ? jQuery.makeArray( elements ) : this;
		} ).filter( function() {
			var type = this.type;

			// Use .is( ":disabled" ) so that fieldset[disabled] works
			return this.name && !jQuery( this ).is( ":disabled" ) &&
				rsubmittable.test( this.nodeName ) && !rsubmitterTypes.test( type ) &&
				( this.checked || !rcheckableType.test( type ) );
		} ).map( function( _i, elem ) {
			var val = jQuery( this ).val();

			if ( val == null ) {
				return null;
			}

			if ( Array.isArray( val ) ) {
				return jQuery.map( val, function( val ) {
					return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
				} );
			}

			return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
		} ).get();
	}
} );


var
	r20 = /%20/g,
	rhash = /#.*$/,
	rantiCache = /([?&])_=[^&]*/,
	rheaders = /^(.*?):[ \t]*([^\r\n]*)$/mg,

	// #7653, #8125, #8152: local protocol detection
	rlocalProtocol = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
	rnoContent = /^(?:GET|HEAD)$/,
	rprotocol = /^\/\//,

	/* Prefilters
	 * 1) They are useful to introduce custom dataTypes (see ajax/jsonp.js for an example)
	 * 2) These are called:
	 *    - BEFORE asking for a transport
	 *    - AFTER param serialization (s.data is a string if s.processData is true)
	 * 3) key is the dataType
	 * 4) the catchall symbol "*" can be used
	 * 5) execution will start with transport dataType and THEN continue down to "*" if needed
	 */
	prefilters = {},

	/* Transports bindings
	 * 1) key is the dataType
	 * 2) the catchall symbol "*" can be used
	 * 3) selection will start with transport dataType and THEN go to "*" if needed
	 */
	transports = {},

	// Avoid comment-prolog char sequence (#10098); must appease lint and evade compression
	allTypes = "*/".concat( "*" ),

	// Anchor tag for parsing the document origin
	originAnchor = document.createElement( "a" );

originAnchor.href = location.href;

// Base "constructor" for jQuery.ajaxPrefilter and jQuery.ajaxTransport
function addToPrefiltersOrTransports( structure ) {

	// dataTypeExpression is optional and defaults to "*"
	return function( dataTypeExpression, func ) {

		if ( typeof dataTypeExpression !== "string" ) {
			func = dataTypeExpression;
			dataTypeExpression = "*";
		}

		var dataType,
			i = 0,
			dataTypes = dataTypeExpression.toLowerCase().match( rnothtmlwhite ) || [];

		if ( isFunction( func ) ) {

			// For each dataType in the dataTypeExpression
			while ( ( dataType = dataTypes[ i++ ] ) ) {

				// Prepend if requested
				if ( dataType[ 0 ] === "+" ) {
					dataType = dataType.slice( 1 ) || "*";
					( structure[ dataType ] = structure[ dataType ] || [] ).unshift( func );

				// Otherwise append
				} else {
					( structure[ dataType ] = structure[ dataType ] || [] ).push( func );
				}
			}
		}
	};
}

// Base inspection function for prefilters and transports
function inspectPrefiltersOrTransports( structure, options, originalOptions, jqXHR ) {

	var inspected = {},
		seekingTransport = ( structure === transports );

	function inspect( dataType ) {
		var selected;
		inspected[ dataType ] = true;
		jQuery.each( structure[ dataType ] || [], function( _, prefilterOrFactory ) {
			var dataTypeOrTransport = prefilterOrFactory( options, originalOptions, jqXHR );
			if ( typeof dataTypeOrTransport === "string" &&
				!seekingTransport && !inspected[ dataTypeOrTransport ] ) {

				options.dataTypes.unshift( dataTypeOrTransport );
				inspect( dataTypeOrTransport );
				return false;
			} else if ( seekingTransport ) {
				return !( selected = dataTypeOrTransport );
			}
		} );
		return selected;
	}

	return inspect( options.dataTypes[ 0 ] ) || !inspected[ "*" ] && inspect( "*" );
}

// A special extend for ajax options
// that takes "flat" options (not to be deep extended)
// Fixes #9887
function ajaxExtend( target, src ) {
	var key, deep,
		flatOptions = jQuery.ajaxSettings.flatOptions || {};

	for ( key in src ) {
		if ( src[ key ] !== undefined ) {
			( flatOptions[ key ] ? target : ( deep || ( deep = {} ) ) )[ key ] = src[ key ];
		}
	}
	if ( deep ) {
		jQuery.extend( true, target, deep );
	}

	return target;
}

/* Handles responses to an ajax request:
 * - finds the right dataType (mediates between content-type and expected dataType)
 * - returns the corresponding response
 */
function ajaxHandleResponses( s, jqXHR, responses ) {

	var ct, type, finalDataType, firstDataType,
		contents = s.contents,
		dataTypes = s.dataTypes;

	// Remove auto dataType and get content-type in the process
	while ( dataTypes[ 0 ] === "*" ) {
		dataTypes.shift();
		if ( ct === undefined ) {
			ct = s.mimeType || jqXHR.getResponseHeader( "Content-Type" );
		}
	}

	// Check if we're dealing with a known content-type
	if ( ct ) {
		for ( type in contents ) {
			if ( contents[ type ] && contents[ type ].test( ct ) ) {
				dataTypes.unshift( type );
				break;
			}
		}
	}

	// Check to see if we have a response for the expected dataType
	if ( dataTypes[ 0 ] in responses ) {
		finalDataType = dataTypes[ 0 ];
	} else {

		// Try convertible dataTypes
		for ( type in responses ) {
			if ( !dataTypes[ 0 ] || s.converters[ type + " " + dataTypes[ 0 ] ] ) {
				finalDataType = type;
				break;
			}
			if ( !firstDataType ) {
				firstDataType = type;
			}
		}

		// Or just use first one
		finalDataType = finalDataType || firstDataType;
	}

	// If we found a dataType
	// We add the dataType to the list if needed
	// and return the corresponding response
	if ( finalDataType ) {
		if ( finalDataType !== dataTypes[ 0 ] ) {
			dataTypes.unshift( finalDataType );
		}
		return responses[ finalDataType ];
	}
}

/* Chain conversions given the request and the original response
 * Also sets the responseXXX fields on the jqXHR instance
 */
function ajaxConvert( s, response, jqXHR, isSuccess ) {
	var conv2, current, conv, tmp, prev,
		converters = {},

		// Work with a copy of dataTypes in case we need to modify it for conversion
		dataTypes = s.dataTypes.slice();

	// Create converters map with lowercased keys
	if ( dataTypes[ 1 ] ) {
		for ( conv in s.converters ) {
			converters[ conv.toLowerCase() ] = s.converters[ conv ];
		}
	}

	current = dataTypes.shift();

	// Convert to each sequential dataType
	while ( current ) {

		if ( s.responseFields[ current ] ) {
			jqXHR[ s.responseFields[ current ] ] = response;
		}

		// Apply the dataFilter if provided
		if ( !prev && isSuccess && s.dataFilter ) {
			response = s.dataFilter( response, s.dataType );
		}

		prev = current;
		current = dataTypes.shift();

		if ( current ) {

			// There's only work to do if current dataType is non-auto
			if ( current === "*" ) {

				current = prev;

			// Convert response if prev dataType is non-auto and differs from current
			} else if ( prev !== "*" && prev !== current ) {

				// Seek a direct converter
				conv = converters[ prev + " " + current ] || converters[ "* " + current ];

				// If none found, seek a pair
				if ( !conv ) {
					for ( conv2 in converters ) {

						// If conv2 outputs current
						tmp = conv2.split( " " );
						if ( tmp[ 1 ] === current ) {

							// If prev can be converted to accepted input
							conv = converters[ prev + " " + tmp[ 0 ] ] ||
								converters[ "* " + tmp[ 0 ] ];
							if ( conv ) {

								// Condense equivalence converters
								if ( conv === true ) {
									conv = converters[ conv2 ];

								// Otherwise, insert the intermediate dataType
								} else if ( converters[ conv2 ] !== true ) {
									current = tmp[ 0 ];
									dataTypes.unshift( tmp[ 1 ] );
								}
								break;
							}
						}
					}
				}

				// Apply converter (if not an equivalence)
				if ( conv !== true ) {

					// Unless errors are allowed to bubble, catch and return them
					if ( conv && s.throws ) {
						response = conv( response );
					} else {
						try {
							response = conv( response );
						} catch ( e ) {
							return {
								state: "parsererror",
								error: conv ? e : "No conversion from " + prev + " to " + current
							};
						}
					}
				}
			}
		}
	}

	return { state: "success", data: response };
}

jQuery.extend( {

	// Counter for holding the number of active queries
	active: 0,

	// Last-Modified header cache for next request
	lastModified: {},
	etag: {},

	ajaxSettings: {
		url: location.href,
		type: "GET",
		isLocal: rlocalProtocol.test( location.protocol ),
		global: true,
		processData: true,
		async: true,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",

		/*
		timeout: 0,
		data: null,
		dataType: null,
		username: null,
		password: null,
		cache: null,
		throws: false,
		traditional: false,
		headers: {},
		*/

		accepts: {
			"*": allTypes,
			text: "text/plain",
			html: "text/html",
			xml: "application/xml, text/xml",
			json: "application/json, text/javascript"
		},

		contents: {
			xml: /\bxml\b/,
			html: /\bhtml/,
			json: /\bjson\b/
		},

		responseFields: {
			xml: "responseXML",
			text: "responseText",
			json: "responseJSON"
		},

		// Data converters
		// Keys separate source (or catchall "*") and destination types with a single space
		converters: {

			// Convert anything to text
			"* text": String,

			// Text to html (true = no transformation)
			"text html": true,

			// Evaluate text as a json expression
			"text json": JSON.parse,

			// Parse text as xml
			"text xml": jQuery.parseXML
		},

		// For options that shouldn't be deep extended:
		// you can add your own custom options here if
		// and when you create one that shouldn't be
		// deep extended (see ajaxExtend)
		flatOptions: {
			url: true,
			context: true
		}
	},

	// Creates a full fledged settings object into target
	// with both ajaxSettings and settings fields.
	// If target is omitted, writes into ajaxSettings.
	ajaxSetup: function( target, settings ) {
		return settings ?

			// Building a settings object
			ajaxExtend( ajaxExtend( target, jQuery.ajaxSettings ), settings ) :

			// Extending ajaxSettings
			ajaxExtend( jQuery.ajaxSettings, target );
	},

	ajaxPrefilter: addToPrefiltersOrTransports( prefilters ),
	ajaxTransport: addToPrefiltersOrTransports( transports ),

	// Main method
	ajax: function( url, options ) {

		// If url is an object, simulate pre-1.5 signature
		if ( typeof url === "object" ) {
			options = url;
			url = undefined;
		}

		// Force options to be an object
		options = options || {};

		var transport,

			// URL without anti-cache param
			cacheURL,

			// Response headers
			responseHeadersString,
			responseHeaders,

			// timeout handle
			timeoutTimer,

			// Url cleanup var
			urlAnchor,

			// Request state (becomes false upon send and true upon completion)
			completed,

			// To know if global events are to be dispatched
			fireGlobals,

			// Loop variable
			i,

			// uncached part of the url
			uncached,

			// Create the final options object
			s = jQuery.ajaxSetup( {}, options ),

			// Callbacks context
			callbackContext = s.context || s,

			// Context for global events is callbackContext if it is a DOM node or jQuery collection
			globalEventContext = s.context &&
				( callbackContext.nodeType || callbackContext.jquery ) ?
				jQuery( callbackContext ) :
				jQuery.event,

			// Deferreds
			deferred = jQuery.Deferred(),
			completeDeferred = jQuery.Callbacks( "once memory" ),

			// Status-dependent callbacks
			statusCode = s.statusCode || {},

			// Headers (they are sent all at once)
			requestHeaders = {},
			requestHeadersNames = {},

			// Default abort message
			strAbort = "canceled",

			// Fake xhr
			jqXHR = {
				readyState: 0,

				// Builds headers hashtable if needed
				getResponseHeader: function( key ) {
					var match;
					if ( completed ) {
						if ( !responseHeaders ) {
							responseHeaders = {};
							while ( ( match = rheaders.exec( responseHeadersString ) ) ) {
								responseHeaders[ match[ 1 ].toLowerCase() + " " ] =
									( responseHeaders[ match[ 1 ].toLowerCase() + " " ] || [] )
										.concat( match[ 2 ] );
							}
						}
						match = responseHeaders[ key.toLowerCase() + " " ];
					}
					return match == null ? null : match.join( ", " );
				},

				// Raw string
				getAllResponseHeaders: function() {
					return completed ? responseHeadersString : null;
				},

				// Caches the header
				setRequestHeader: function( name, value ) {
					if ( completed == null ) {
						name = requestHeadersNames[ name.toLowerCase() ] =
							requestHeadersNames[ name.toLowerCase() ] || name;
						requestHeaders[ name ] = value;
					}
					return this;
				},

				// Overrides response content-type header
				overrideMimeType: function( type ) {
					if ( completed == null ) {
						s.mimeType = type;
					}
					return this;
				},

				// Status-dependent callbacks
				statusCode: function( map ) {
					var code;
					if ( map ) {
						if ( completed ) {

							// Execute the appropriate callbacks
							jqXHR.always( map[ jqXHR.status ] );
						} else {

							// Lazy-add the new callbacks in a way that preserves old ones
							for ( code in map ) {
								statusCode[ code ] = [ statusCode[ code ], map[ code ] ];
							}
						}
					}
					return this;
				},

				// Cancel the request
				abort: function( statusText ) {
					var finalText = statusText || strAbort;
					if ( transport ) {
						transport.abort( finalText );
					}
					done( 0, finalText );
					return this;
				}
			};

		// Attach deferreds
		deferred.promise( jqXHR );

		// Add protocol if not provided (prefilters might expect it)
		// Handle falsy url in the settings object (#10093: consistency with old signature)
		// We also use the url parameter if available
		s.url = ( ( url || s.url || location.href ) + "" )
			.replace( rprotocol, location.protocol + "//" );

		// Alias method option to type as per ticket #12004
		s.type = options.method || options.type || s.method || s.type;

		// Extract dataTypes list
		s.dataTypes = ( s.dataType || "*" ).toLowerCase().match( rnothtmlwhite ) || [ "" ];

		// A cross-domain request is in order when the origin doesn't match the current origin.
		if ( s.crossDomain == null ) {
			urlAnchor = document.createElement( "a" );

			// Support: IE <=8 - 11, Edge 12 - 15
			// IE throws exception on accessing the href property if url is malformed,
			// e.g. http://example.com:80x/
			try {
				urlAnchor.href = s.url;

				// Support: IE <=8 - 11 only
				// Anchor's host property isn't correctly set when s.url is relative
				urlAnchor.href = urlAnchor.href;
				s.crossDomain = originAnchor.protocol + "//" + originAnchor.host !==
					urlAnchor.protocol + "//" + urlAnchor.host;
			} catch ( e ) {

				// If there is an error parsing the URL, assume it is crossDomain,
				// it can be rejected by the transport if it is invalid
				s.crossDomain = true;
			}
		}

		// Convert data if not already a string
		if ( s.data && s.processData && typeof s.data !== "string" ) {
			s.data = jQuery.param( s.data, s.traditional );
		}

		// Apply prefilters
		inspectPrefiltersOrTransports( prefilters, s, options, jqXHR );

		// If request was aborted inside a prefilter, stop there
		if ( completed ) {
			return jqXHR;
		}

		// We can fire global events as of now if asked to
		// Don't fire events if jQuery.event is undefined in an AMD-usage scenario (#15118)
		fireGlobals = jQuery.event && s.global;

		// Watch for a new set of requests
		if ( fireGlobals && jQuery.active++ === 0 ) {
			jQuery.event.trigger( "ajaxStart" );
		}

		// Uppercase the type
		s.type = s.type.toUpperCase();

		// Determine if request has content
		s.hasContent = !rnoContent.test( s.type );

		// Save the URL in case we're toying with the If-Modified-Since
		// and/or If-None-Match header later on
		// Remove hash to simplify url manipulation
		cacheURL = s.url.replace( rhash, "" );

		// More options handling for requests with no content
		if ( !s.hasContent ) {

			// Remember the hash so we can put it back
			uncached = s.url.slice( cacheURL.length );

			// If data is available and should be processed, append data to url
			if ( s.data && ( s.processData || typeof s.data === "string" ) ) {
				cacheURL += ( rquery.test( cacheURL ) ? "&" : "?" ) + s.data;

				// #9682: remove data so that it's not used in an eventual retry
				delete s.data;
			}

			// Add or update anti-cache param if needed
			if ( s.cache === false ) {
				cacheURL = cacheURL.replace( rantiCache, "$1" );
				uncached = ( rquery.test( cacheURL ) ? "&" : "?" ) + "_=" + ( nonce.guid++ ) +
					uncached;
			}

			// Put hash and anti-cache on the URL that will be requested (gh-1732)
			s.url = cacheURL + uncached;

		// Change '%20' to '+' if this is encoded form body content (gh-2658)
		} else if ( s.data && s.processData &&
			( s.contentType || "" ).indexOf( "application/x-www-form-urlencoded" ) === 0 ) {
			s.data = s.data.replace( r20, "+" );
		}

		// Set the If-Modified-Since and/or If-None-Match header, if in ifModified mode.
		if ( s.ifModified ) {
			if ( jQuery.lastModified[ cacheURL ] ) {
				jqXHR.setRequestHeader( "If-Modified-Since", jQuery.lastModified[ cacheURL ] );
			}
			if ( jQuery.etag[ cacheURL ] ) {
				jqXHR.setRequestHeader( "If-None-Match", jQuery.etag[ cacheURL ] );
			}
		}

		// Set the correct header, if data is being sent
		if ( s.data && s.hasContent && s.contentType !== false || options.contentType ) {
			jqXHR.setRequestHeader( "Content-Type", s.contentType );
		}

		// Set the Accepts header for the server, depending on the dataType
		jqXHR.setRequestHeader(
			"Accept",
			s.dataTypes[ 0 ] && s.accepts[ s.dataTypes[ 0 ] ] ?
				s.accepts[ s.dataTypes[ 0 ] ] +
					( s.dataTypes[ 0 ] !== "*" ? ", " + allTypes + "; q=0.01" : "" ) :
				s.accepts[ "*" ]
		);

		// Check for headers option
		for ( i in s.headers ) {
			jqXHR.setRequestHeader( i, s.headers[ i ] );
		}

		// Allow custom headers/mimetypes and early abort
		if ( s.beforeSend &&
			( s.beforeSend.call( callbackContext, jqXHR, s ) === false || completed ) ) {

			// Abort if not done already and return
			return jqXHR.abort();
		}

		// Aborting is no longer a cancellation
		strAbort = "abort";

		// Install callbacks on deferreds
		completeDeferred.add( s.complete );
		jqXHR.done( s.success );
		jqXHR.fail( s.error );

		// Get transport
		transport = inspectPrefiltersOrTransports( transports, s, options, jqXHR );

		// If no transport, we auto-abort
		if ( !transport ) {
			done( -1, "No Transport" );
		} else {
			jqXHR.readyState = 1;

			// Send global event
			if ( fireGlobals ) {
				globalEventContext.trigger( "ajaxSend", [ jqXHR, s ] );
			}

			// If request was aborted inside ajaxSend, stop there
			if ( completed ) {
				return jqXHR;
			}

			// Timeout
			if ( s.async && s.timeout > 0 ) {
				timeoutTimer = window.setTimeout( function() {
					jqXHR.abort( "timeout" );
				}, s.timeout );
			}

			try {
				completed = false;
				transport.send( requestHeaders, done );
			} catch ( e ) {

				// Rethrow post-completion exceptions
				if ( completed ) {
					throw e;
				}

				// Propagate others as results
				done( -1, e );
			}
		}

		// Callback for when everything is done
		function done( status, nativeStatusText, responses, headers ) {
			var isSuccess, success, error, response, modified,
				statusText = nativeStatusText;

			// Ignore repeat invocations
			if ( completed ) {
				return;
			}

			completed = true;

			// Clear timeout if it exists
			if ( timeoutTimer ) {
				window.clearTimeout( timeoutTimer );
			}

			// Dereference transport for early garbage collection
			// (no matter how long the jqXHR object will be used)
			transport = undefined;

			// Cache response headers
			responseHeadersString = headers || "";

			// Set readyState
			jqXHR.readyState = status > 0 ? 4 : 0;

			// Determine if successful
			isSuccess = status >= 200 && status < 300 || status === 304;

			// Get response data
			if ( responses ) {
				response = ajaxHandleResponses( s, jqXHR, responses );
			}

			// Use a noop converter for missing script but not if jsonp
			if ( !isSuccess &&
				jQuery.inArray( "script", s.dataTypes ) > -1 &&
				jQuery.inArray( "json", s.dataTypes ) < 0 ) {
				s.converters[ "text script" ] = function() {};
			}

			// Convert no matter what (that way responseXXX fields are always set)
			response = ajaxConvert( s, response, jqXHR, isSuccess );

			// If successful, handle type chaining
			if ( isSuccess ) {

				// Set the If-Modified-Since and/or If-None-Match header, if in ifModified mode.
				if ( s.ifModified ) {
					modified = jqXHR.getResponseHeader( "Last-Modified" );
					if ( modified ) {
						jQuery.lastModified[ cacheURL ] = modified;
					}
					modified = jqXHR.getResponseHeader( "etag" );
					if ( modified ) {
						jQuery.etag[ cacheURL ] = modified;
					}
				}

				// if no content
				if ( status === 204 || s.type === "HEAD" ) {
					statusText = "nocontent";

				// if not modified
				} else if ( status === 304 ) {
					statusText = "notmodified";

				// If we have data, let's convert it
				} else {
					statusText = response.state;
					success = response.data;
					error = response.error;
					isSuccess = !error;
				}
			} else {

				// Extract error from statusText and normalize for non-aborts
				error = statusText;
				if ( status || !statusText ) {
					statusText = "error";
					if ( status < 0 ) {
						status = 0;
					}
				}
			}

			// Set data for the fake xhr object
			jqXHR.status = status;
			jqXHR.statusText = ( nativeStatusText || statusText ) + "";

			// Success/Error
			if ( isSuccess ) {
				deferred.resolveWith( callbackContext, [ success, statusText, jqXHR ] );
			} else {
				deferred.rejectWith( callbackContext, [ jqXHR, statusText, error ] );
			}

			// Status-dependent callbacks
			jqXHR.statusCode( statusCode );
			statusCode = undefined;

			if ( fireGlobals ) {
				globalEventContext.trigger( isSuccess ? "ajaxSuccess" : "ajaxError",
					[ jqXHR, s, isSuccess ? success : error ] );
			}

			// Complete
			completeDeferred.fireWith( callbackContext, [ jqXHR, statusText ] );

			if ( fireGlobals ) {
				globalEventContext.trigger( "ajaxComplete", [ jqXHR, s ] );

				// Handle the global AJAX counter
				if ( !( --jQuery.active ) ) {
					jQuery.event.trigger( "ajaxStop" );
				}
			}
		}

		return jqXHR;
	},

	getJSON: function( url, data, callback ) {
		return jQuery.get( url, data, callback, "json" );
	},

	getScript: function( url, callback ) {
		return jQuery.get( url, undefined, callback, "script" );
	}
} );

jQuery.each( [ "get", "post" ], function( _i, method ) {
	jQuery[ method ] = function( url, data, callback, type ) {

		// Shift arguments if data argument was omitted
		if ( isFunction( data ) ) {
			type = type || callback;
			callback = data;
			data = undefined;
		}

		// The url can be an options object (which then must have .url)
		return jQuery.ajax( jQuery.extend( {
			url: url,
			type: method,
			dataType: type,
			data: data,
			success: callback
		}, jQuery.isPlainObject( url ) && url ) );
	};
} );

jQuery.ajaxPrefilter( function( s ) {
	var i;
	for ( i in s.headers ) {
		if ( i.toLowerCase() === "content-type" ) {
			s.contentType = s.headers[ i ] || "";
		}
	}
} );


jQuery._evalUrl = function( url, options, doc ) {
	return jQuery.ajax( {
		url: url,

		// Make this explicit, since user can override this through ajaxSetup (#11264)
		type: "GET",
		dataType: "script",
		cache: true,
		async: false,
		global: false,

		// Only evaluate the response if it is successful (gh-4126)
		// dataFilter is not invoked for failure responses, so using it instead
		// of the default converter is kludgy but it works.
		converters: {
			"text script": function() {}
		},
		dataFilter: function( response ) {
			jQuery.globalEval( response, options, doc );
		}
	} );
};


jQuery.fn.extend( {
	wrapAll: function( html ) {
		var wrap;

		if ( this[ 0 ] ) {
			if ( isFunction( html ) ) {
				html = html.call( this[ 0 ] );
			}

			// The elements to wrap the target around
			wrap = jQuery( html, this[ 0 ].ownerDocument ).eq( 0 ).clone( true );

			if ( this[ 0 ].parentNode ) {
				wrap.insertBefore( this[ 0 ] );
			}

			wrap.map( function() {
				var elem = this;

				while ( elem.firstElementChild ) {
					elem = elem.firstElementChild;
				}

				return elem;
			} ).append( this );
		}

		return this;
	},

	wrapInner: function( html ) {
		if ( isFunction( html ) ) {
			return this.each( function( i ) {
				jQuery( this ).wrapInner( html.call( this, i ) );
			} );
		}

		return this.each( function() {
			var self = jQuery( this ),
				contents = self.contents();

			if ( contents.length ) {
				contents.wrapAll( html );

			} else {
				self.append( html );
			}
		} );
	},

	wrap: function( html ) {
		var htmlIsFunction = isFunction( html );

		return this.each( function( i ) {
			jQuery( this ).wrapAll( htmlIsFunction ? html.call( this, i ) : html );
		} );
	},

	unwrap: function( selector ) {
		this.parent( selector ).not( "body" ).each( function() {
			jQuery( this ).replaceWith( this.childNodes );
		} );
		return this;
	}
} );


jQuery.expr.pseudos.hidden = function( elem ) {
	return !jQuery.expr.pseudos.visible( elem );
};
jQuery.expr.pseudos.visible = function( elem ) {
	return !!( elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length );
};




jQuery.ajaxSettings.xhr = function() {
	try {
		return new window.XMLHttpRequest();
	} catch ( e ) {}
};

var xhrSuccessStatus = {

		// File protocol always yields status code 0, assume 200
		0: 200,

		// Support: IE <=9 only
		// #1450: sometimes IE returns 1223 when it should be 204
		1223: 204
	},
	xhrSupported = jQuery.ajaxSettings.xhr();

support.cors = !!xhrSupported && ( "withCredentials" in xhrSupported );
support.ajax = xhrSupported = !!xhrSupported;

jQuery.ajaxTransport( function( options ) {
	var callback, errorCallback;

	// Cross domain only allowed if supported through XMLHttpRequest
	if ( support.cors || xhrSupported && !options.crossDomain ) {
		return {
			send: function( headers, complete ) {
				var i,
					xhr = options.xhr();

				xhr.open(
					options.type,
					options.url,
					options.async,
					options.username,
					options.password
				);

				// Apply custom fields if provided
				if ( options.xhrFields ) {
					for ( i in options.xhrFields ) {
						xhr[ i ] = options.xhrFields[ i ];
					}
				}

				// Override mime type if needed
				if ( options.mimeType && xhr.overrideMimeType ) {
					xhr.overrideMimeType( options.mimeType );
				}

				// X-Requested-With header
				// For cross-domain requests, seeing as conditions for a preflight are
				// akin to a jigsaw puzzle, we simply never set it to be sure.
				// (it can always be set on a per-request basis or even using ajaxSetup)
				// For same-domain requests, won't change header if already provided.
				if ( !options.crossDomain && !headers[ "X-Requested-With" ] ) {
					headers[ "X-Requested-With" ] = "XMLHttpRequest";
				}

				// Set headers
				for ( i in headers ) {
					xhr.setRequestHeader( i, headers[ i ] );
				}

				// Callback
				callback = function( type ) {
					return function() {
						if ( callback ) {
							callback = errorCallback = xhr.onload =
								xhr.onerror = xhr.onabort = xhr.ontimeout =
									xhr.onreadystatechange = null;

							if ( type === "abort" ) {
								xhr.abort();
							} else if ( type === "error" ) {

								// Support: IE <=9 only
								// On a manual native abort, IE9 throws
								// errors on any property access that is not readyState
								if ( typeof xhr.status !== "number" ) {
									complete( 0, "error" );
								} else {
									complete(

										// File: protocol always yields status 0; see #8605, #14207
										xhr.status,
										xhr.statusText
									);
								}
							} else {
								complete(
									xhrSuccessStatus[ xhr.status ] || xhr.status,
									xhr.statusText,

									// Support: IE <=9 only
									// IE9 has no XHR2 but throws on binary (trac-11426)
									// For XHR2 non-text, let the caller handle it (gh-2498)
									( xhr.responseType || "text" ) !== "text"  ||
									typeof xhr.responseText !== "string" ?
										{ binary: xhr.response } :
										{ text: xhr.responseText },
									xhr.getAllResponseHeaders()
								);
							}
						}
					};
				};

				// Listen to events
				xhr.onload = callback();
				errorCallback = xhr.onerror = xhr.ontimeout = callback( "error" );

				// Support: IE 9 only
				// Use onreadystatechange to replace onabort
				// to handle uncaught aborts
				if ( xhr.onabort !== undefined ) {
					xhr.onabort = errorCallback;
				} else {
					xhr.onreadystatechange = function() {

						// Check readyState before timeout as it changes
						if ( xhr.readyState === 4 ) {

							// Allow onerror to be called first,
							// but that will not handle a native abort
							// Also, save errorCallback to a variable
							// as xhr.onerror cannot be accessed
							window.setTimeout( function() {
								if ( callback ) {
									errorCallback();
								}
							} );
						}
					};
				}

				// Create the abort callback
				callback = callback( "abort" );

				try {

					// Do send the request (this may raise an exception)
					xhr.send( options.hasContent && options.data || null );
				} catch ( e ) {

					// #14683: Only rethrow if this hasn't been notified as an error yet
					if ( callback ) {
						throw e;
					}
				}
			},

			abort: function() {
				if ( callback ) {
					callback();
				}
			}
		};
	}
} );




// Prevent auto-execution of scripts when no explicit dataType was provided (See gh-2432)
jQuery.ajaxPrefilter( function( s ) {
	if ( s.crossDomain ) {
		s.contents.script = false;
	}
} );

// Install script dataType
jQuery.ajaxSetup( {
	accepts: {
		script: "text/javascript, application/javascript, " +
			"application/ecmascript, application/x-ecmascript"
	},
	contents: {
		script: /\b(?:java|ecma)script\b/
	},
	converters: {
		"text script": function( text ) {
			jQuery.globalEval( text );
			return text;
		}
	}
} );

// Handle cache's special case and crossDomain
jQuery.ajaxPrefilter( "script", function( s ) {
	if ( s.cache === undefined ) {
		s.cache = false;
	}
	if ( s.crossDomain ) {
		s.type = "GET";
	}
} );

// Bind script tag hack transport
jQuery.ajaxTransport( "script", function( s ) {

	// This transport only deals with cross domain or forced-by-attrs requests
	if ( s.crossDomain || s.scriptAttrs ) {
		var script, callback;
		return {
			send: function( _, complete ) {
				script = jQuery( "<script>" )
					.attr( s.scriptAttrs || {} )
					.prop( { charset: s.scriptCharset, src: s.url } )
					.on( "load error", callback = function( evt ) {
						script.remove();
						callback = null;
						if ( evt ) {
							complete( evt.type === "error" ? 404 : 200, evt.type );
						}
					} );

				// Use native DOM manipulation to avoid our domManip AJAX trickery
				document.head.appendChild( script[ 0 ] );
			},
			abort: function() {
				if ( callback ) {
					callback();
				}
			}
		};
	}
} );




var oldCallbacks = [],
	rjsonp = /(=)\?(?=&|$)|\?\?/;

// Default jsonp settings
jQuery.ajaxSetup( {
	jsonp: "callback",
	jsonpCallback: function() {
		var callback = oldCallbacks.pop() || ( jQuery.expando + "_" + ( nonce.guid++ ) );
		this[ callback ] = true;
		return callback;
	}
} );

// Detect, normalize options and install callbacks for jsonp requests
jQuery.ajaxPrefilter( "json jsonp", function( s, originalSettings, jqXHR ) {

	var callbackName, overwritten, responseContainer,
		jsonProp = s.jsonp !== false && ( rjsonp.test( s.url ) ?
			"url" :
			typeof s.data === "string" &&
				( s.contentType || "" )
					.indexOf( "application/x-www-form-urlencoded" ) === 0 &&
				rjsonp.test( s.data ) && "data"
		);

	// Handle iff the expected data type is "jsonp" or we have a parameter to set
	if ( jsonProp || s.dataTypes[ 0 ] === "jsonp" ) {

		// Get callback name, remembering preexisting value associated with it
		callbackName = s.jsonpCallback = isFunction( s.jsonpCallback ) ?
			s.jsonpCallback() :
			s.jsonpCallback;

		// Insert callback into url or form data
		if ( jsonProp ) {
			s[ jsonProp ] = s[ jsonProp ].replace( rjsonp, "$1" + callbackName );
		} else if ( s.jsonp !== false ) {
			s.url += ( rquery.test( s.url ) ? "&" : "?" ) + s.jsonp + "=" + callbackName;
		}

		// Use data converter to retrieve json after script execution
		s.converters[ "script json" ] = function() {
			if ( !responseContainer ) {
				jQuery.error( callbackName + " was not called" );
			}
			return responseContainer[ 0 ];
		};

		// Force json dataType
		s.dataTypes[ 0 ] = "json";

		// Install callback
		overwritten = window[ callbackName ];
		window[ callbackName ] = function() {
			responseContainer = arguments;
		};

		// Clean-up function (fires after converters)
		jqXHR.always( function() {

			// If previous value didn't exist - remove it
			if ( overwritten === undefined ) {
				jQuery( window ).removeProp( callbackName );

			// Otherwise restore preexisting value
			} else {
				window[ callbackName ] = overwritten;
			}

			// Save back as free
			if ( s[ callbackName ] ) {

				// Make sure that re-using the options doesn't screw things around
				s.jsonpCallback = originalSettings.jsonpCallback;

				// Save the callback name for future use
				oldCallbacks.push( callbackName );
			}

			// Call if it was a function and we have a response
			if ( responseContainer && isFunction( overwritten ) ) {
				overwritten( responseContainer[ 0 ] );
			}

			responseContainer = overwritten = undefined;
		} );

		// Delegate to script
		return "script";
	}
} );




// Support: Safari 8 only
// In Safari 8 documents created via document.implementation.createHTMLDocument
// collapse sibling forms: the second one becomes a child of the first one.
// Because of that, this security measure has to be disabled in Safari 8.
// https://bugs.webkit.org/show_bug.cgi?id=137337
support.createHTMLDocument = ( function() {
	var body = document.implementation.createHTMLDocument( "" ).body;
	body.innerHTML = "<form></form><form></form>";
	return body.childNodes.length === 2;
} )();


// Argument "data" should be string of html
// context (optional): If specified, the fragment will be created in this context,
// defaults to document
// keepScripts (optional): If true, will include scripts passed in the html string
jQuery.parseHTML = function( data, context, keepScripts ) {
	if ( typeof data !== "string" ) {
		return [];
	}
	if ( typeof context === "boolean" ) {
		keepScripts = context;
		context = false;
	}

	var base, parsed, scripts;

	if ( !context ) {

		// Stop scripts or inline event handlers from being executed immediately
		// by using document.implementation
		if ( support.createHTMLDocument ) {
			context = document.implementation.createHTMLDocument( "" );

			// Set the base href for the created document
			// so any parsed elements with URLs
			// are based on the document's URL (gh-2965)
			base = context.createElement( "base" );
			base.href = document.location.href;
			context.head.appendChild( base );
		} else {
			context = document;
		}
	}

	parsed = rsingleTag.exec( data );
	scripts = !keepScripts && [];

	// Single tag
	if ( parsed ) {
		return [ context.createElement( parsed[ 1 ] ) ];
	}

	parsed = buildFragment( [ data ], context, scripts );

	if ( scripts && scripts.length ) {
		jQuery( scripts ).remove();
	}

	return jQuery.merge( [], parsed.childNodes );
};


/**
 * Load a url into a page
 */
jQuery.fn.load = function( url, params, callback ) {
	var selector, type, response,
		self = this,
		off = url.indexOf( " " );

	if ( off > -1 ) {
		selector = stripAndCollapse( url.slice( off ) );
		url = url.slice( 0, off );
	}

	// If it's a function
	if ( isFunction( params ) ) {

		// We assume that it's the callback
		callback = params;
		params = undefined;

	// Otherwise, build a param string
	} else if ( params && typeof params === "object" ) {
		type = "POST";
	}

	// If we have elements to modify, make the request
	if ( self.length > 0 ) {
		jQuery.ajax( {
			url: url,

			// If "type" variable is undefined, then "GET" method will be used.
			// Make value of this field explicit since
			// user can override it through ajaxSetup method
			type: type || "GET",
			dataType: "html",
			data: params
		} ).done( function( responseText ) {

			// Save response for use in complete callback
			response = arguments;

			self.html( selector ?

				// If a selector was specified, locate the right elements in a dummy div
				// Exclude scripts to avoid IE 'Permission Denied' errors
				jQuery( "<div>" ).append( jQuery.parseHTML( responseText ) ).find( selector ) :

				// Otherwise use the full result
				responseText );

		// If the request succeeds, this function gets "data", "status", "jqXHR"
		// but they are ignored because response was set above.
		// If it fails, this function gets "jqXHR", "status", "error"
		} ).always( callback && function( jqXHR, status ) {
			self.each( function() {
				callback.apply( this, response || [ jqXHR.responseText, status, jqXHR ] );
			} );
		} );
	}

	return this;
};




jQuery.expr.pseudos.animated = function( elem ) {
	return jQuery.grep( jQuery.timers, function( fn ) {
		return elem === fn.elem;
	} ).length;
};




jQuery.offset = {
	setOffset: function( elem, options, i ) {
		var curPosition, curLeft, curCSSTop, curTop, curOffset, curCSSLeft, calculatePosition,
			position = jQuery.css( elem, "position" ),
			curElem = jQuery( elem ),
			props = {};

		// Set position first, in-case top/left are set even on static elem
		if ( position === "static" ) {
			elem.style.position = "relative";
		}

		curOffset = curElem.offset();
		curCSSTop = jQuery.css( elem, "top" );
		curCSSLeft = jQuery.css( elem, "left" );
		calculatePosition = ( position === "absolute" || position === "fixed" ) &&
			( curCSSTop + curCSSLeft ).indexOf( "auto" ) > -1;

		// Need to be able to calculate position if either
		// top or left is auto and position is either absolute or fixed
		if ( calculatePosition ) {
			curPosition = curElem.position();
			curTop = curPosition.top;
			curLeft = curPosition.left;

		} else {
			curTop = parseFloat( curCSSTop ) || 0;
			curLeft = parseFloat( curCSSLeft ) || 0;
		}

		if ( isFunction( options ) ) {

			// Use jQuery.extend here to allow modification of coordinates argument (gh-1848)
			options = options.call( elem, i, jQuery.extend( {}, curOffset ) );
		}

		if ( options.top != null ) {
			props.top = ( options.top - curOffset.top ) + curTop;
		}
		if ( options.left != null ) {
			props.left = ( options.left - curOffset.left ) + curLeft;
		}

		if ( "using" in options ) {
			options.using.call( elem, props );

		} else {
			curElem.css( props );
		}
	}
};

jQuery.fn.extend( {

	// offset() relates an element's border box to the document origin
	offset: function( options ) {

		// Preserve chaining for setter
		if ( arguments.length ) {
			return options === undefined ?
				this :
				this.each( function( i ) {
					jQuery.offset.setOffset( this, options, i );
				} );
		}

		var rect, win,
			elem = this[ 0 ];

		if ( !elem ) {
			return;
		}

		// Return zeros for disconnected and hidden (display: none) elements (gh-2310)
		// Support: IE <=11 only
		// Running getBoundingClientRect on a
		// disconnected node in IE throws an error
		if ( !elem.getClientRects().length ) {
			return { top: 0, left: 0 };
		}

		// Get document-relative position by adding viewport scroll to viewport-relative gBCR
		rect = elem.getBoundingClientRect();
		win = elem.ownerDocument.defaultView;
		return {
			top: rect.top + win.pageYOffset,
			left: rect.left + win.pageXOffset
		};
	},

	// position() relates an element's margin box to its offset parent's padding box
	// This corresponds to the behavior of CSS absolute positioning
	position: function() {
		if ( !this[ 0 ] ) {
			return;
		}

		var offsetParent, offset, doc,
			elem = this[ 0 ],
			parentOffset = { top: 0, left: 0 };

		// position:fixed elements are offset from the viewport, which itself always has zero offset
		if ( jQuery.css( elem, "position" ) === "fixed" ) {

			// Assume position:fixed implies availability of getBoundingClientRect
			offset = elem.getBoundingClientRect();

		} else {
			offset = this.offset();

			// Account for the *real* offset parent, which can be the document or its root element
			// when a statically positioned element is identified
			doc = elem.ownerDocument;
			offsetParent = elem.offsetParent || doc.documentElement;
			while ( offsetParent &&
				( offsetParent === doc.body || offsetParent === doc.documentElement ) &&
				jQuery.css( offsetParent, "position" ) === "static" ) {

				offsetParent = offsetParent.parentNode;
			}
			if ( offsetParent && offsetParent !== elem && offsetParent.nodeType === 1 ) {

				// Incorporate borders into its offset, since they are outside its content origin
				parentOffset = jQuery( offsetParent ).offset();
				parentOffset.top += jQuery.css( offsetParent, "borderTopWidth", true );
				parentOffset.left += jQuery.css( offsetParent, "borderLeftWidth", true );
			}
		}

		// Subtract parent offsets and element margins
		return {
			top: offset.top - parentOffset.top - jQuery.css( elem, "marginTop", true ),
			left: offset.left - parentOffset.left - jQuery.css( elem, "marginLeft", true )
		};
	},

	// This method will return documentElement in the following cases:
	// 1) For the element inside the iframe without offsetParent, this method will return
	//    documentElement of the parent window
	// 2) For the hidden or detached element
	// 3) For body or html element, i.e. in case of the html node - it will return itself
	//
	// but those exceptions were never presented as a real life use-cases
	// and might be considered as more preferable results.
	//
	// This logic, however, is not guaranteed and can change at any point in the future
	offsetParent: function() {
		return this.map( function() {
			var offsetParent = this.offsetParent;

			while ( offsetParent && jQuery.css( offsetParent, "position" ) === "static" ) {
				offsetParent = offsetParent.offsetParent;
			}

			return offsetParent || documentElement;
		} );
	}
} );

// Create scrollLeft and scrollTop methods
jQuery.each( { scrollLeft: "pageXOffset", scrollTop: "pageYOffset" }, function( method, prop ) {
	var top = "pageYOffset" === prop;

	jQuery.fn[ method ] = function( val ) {
		return access( this, function( elem, method, val ) {

			// Coalesce documents and windows
			var win;
			if ( isWindow( elem ) ) {
				win = elem;
			} else if ( elem.nodeType === 9 ) {
				win = elem.defaultView;
			}

			if ( val === undefined ) {
				return win ? win[ prop ] : elem[ method ];
			}

			if ( win ) {
				win.scrollTo(
					!top ? val : win.pageXOffset,
					top ? val : win.pageYOffset
				);

			} else {
				elem[ method ] = val;
			}
		}, method, val, arguments.length );
	};
} );

// Support: Safari <=7 - 9.1, Chrome <=37 - 49
// Add the top/left cssHooks using jQuery.fn.position
// Webkit bug: https://bugs.webkit.org/show_bug.cgi?id=29084
// Blink bug: https://bugs.chromium.org/p/chromium/issues/detail?id=589347
// getComputedStyle returns percent when specified for top/left/bottom/right;
// rather than make the css module depend on the offset module, just check for it here
jQuery.each( [ "top", "left" ], function( _i, prop ) {
	jQuery.cssHooks[ prop ] = addGetHookIf( support.pixelPosition,
		function( elem, computed ) {
			if ( computed ) {
				computed = curCSS( elem, prop );

				// If curCSS returns percentage, fallback to offset
				return rnumnonpx.test( computed ) ?
					jQuery( elem ).position()[ prop ] + "px" :
					computed;
			}
		}
	);
} );


// Create innerHeight, innerWidth, height, width, outerHeight and outerWidth methods
jQuery.each( { Height: "height", Width: "width" }, function( name, type ) {
	jQuery.each( {
		padding: "inner" + name,
		content: type,
		"": "outer" + name
	}, function( defaultExtra, funcName ) {

		// Margin is only for outerHeight, outerWidth
		jQuery.fn[ funcName ] = function( margin, value ) {
			var chainable = arguments.length && ( defaultExtra || typeof margin !== "boolean" ),
				extra = defaultExtra || ( margin === true || value === true ? "margin" : "border" );

			return access( this, function( elem, type, value ) {
				var doc;

				if ( isWindow( elem ) ) {

					// $( window ).outerWidth/Height return w/h including scrollbars (gh-1729)
					return funcName.indexOf( "outer" ) === 0 ?
						elem[ "inner" + name ] :
						elem.document.documentElement[ "client" + name ];
				}

				// Get document width or height
				if ( elem.nodeType === 9 ) {
					doc = elem.documentElement;

					// Either scroll[Width/Height] or offset[Width/Height] or client[Width/Height],
					// whichever is greatest
					return Math.max(
						elem.body[ "scroll" + name ], doc[ "scroll" + name ],
						elem.body[ "offset" + name ], doc[ "offset" + name ],
						doc[ "client" + name ]
					);
				}

				return value === undefined ?

					// Get width or height on the element, requesting but not forcing parseFloat
					jQuery.css( elem, type, extra ) :

					// Set width or height on the element
					jQuery.style( elem, type, value, extra );
			}, type, chainable ? margin : undefined, chainable );
		};
	} );
} );


jQuery.each( [
	"ajaxStart",
	"ajaxStop",
	"ajaxComplete",
	"ajaxError",
	"ajaxSuccess",
	"ajaxSend"
], function( _i, type ) {
	jQuery.fn[ type ] = function( fn ) {
		return this.on( type, fn );
	};
} );




jQuery.fn.extend( {

	bind: function( types, data, fn ) {
		return this.on( types, null, data, fn );
	},
	unbind: function( types, fn ) {
		return this.off( types, null, fn );
	},

	delegate: function( selector, types, data, fn ) {
		return this.on( types, selector, data, fn );
	},
	undelegate: function( selector, types, fn ) {

		// ( namespace ) or ( selector, types [, fn] )
		return arguments.length === 1 ?
			this.off( selector, "**" ) :
			this.off( types, selector || "**", fn );
	},

	hover: function( fnOver, fnOut ) {
		return this.mouseenter( fnOver ).mouseleave( fnOut || fnOver );
	}
} );

jQuery.each(
	( "blur focus focusin focusout resize scroll click dblclick " +
	"mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave " +
	"change select submit keydown keypress keyup contextmenu" ).split( " " ),
	function( _i, name ) {

		// Handle event binding
		jQuery.fn[ name ] = function( data, fn ) {
			return arguments.length > 0 ?
				this.on( name, null, data, fn ) :
				this.trigger( name );
		};
	}
);




// Support: Android <=4.0 only
// Make sure we trim BOM and NBSP
var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;

// Bind a function to a context, optionally partially applying any
// arguments.
// jQuery.proxy is deprecated to promote standards (specifically Function#bind)
// However, it is not slated for removal any time soon
jQuery.proxy = function( fn, context ) {
	var tmp, args, proxy;

	if ( typeof context === "string" ) {
		tmp = fn[ context ];
		context = fn;
		fn = tmp;
	}

	// Quick check to determine if target is callable, in the spec
	// this throws a TypeError, but we will just return undefined.
	if ( !isFunction( fn ) ) {
		return undefined;
	}

	// Simulated bind
	args = slice.call( arguments, 2 );
	proxy = function() {
		return fn.apply( context || this, args.concat( slice.call( arguments ) ) );
	};

	// Set the guid of unique handler to the same of original handler, so it can be removed
	proxy.guid = fn.guid = fn.guid || jQuery.guid++;

	return proxy;
};

jQuery.holdReady = function( hold ) {
	if ( hold ) {
		jQuery.readyWait++;
	} else {
		jQuery.ready( true );
	}
};
jQuery.isArray = Array.isArray;
jQuery.parseJSON = JSON.parse;
jQuery.nodeName = nodeName;
jQuery.isFunction = isFunction;
jQuery.isWindow = isWindow;
jQuery.camelCase = camelCase;
jQuery.type = toType;

jQuery.now = Date.now;

jQuery.isNumeric = function( obj ) {

	// As of jQuery 3.0, isNumeric is limited to
	// strings and numbers (primitives or objects)
	// that can be coerced to finite numbers (gh-2662)
	var type = jQuery.type( obj );
	return ( type === "number" || type === "string" ) &&

		// parseFloat NaNs numeric-cast false positives ("")
		// ...but misinterprets leading-number strings, particularly hex literals ("0x...")
		// subtraction forces infinities to NaN
		!isNaN( obj - parseFloat( obj ) );
};

jQuery.trim = function( text ) {
	return text == null ?
		"" :
		( text + "" ).replace( rtrim, "" );
};



// Register as a named AMD module, since jQuery can be concatenated with other
// files that may use define, but not via a proper concatenation script that
// understands anonymous AMD modules. A named AMD is safest and most robust
// way to register. Lowercase jquery is used because AMD module names are
// derived from file names, and jQuery is normally delivered in a lowercase
// file name. Do this after creating the global so that if an AMD module wants
// to call noConflict to hide this version of jQuery, it will work.

// Note that for maximum portability, libraries that are not jQuery should
// declare themselves as anonymous modules, and avoid setting a global if an
// AMD loader is present. jQuery is a special case. For more information, see
// https://github.com/jrburke/requirejs/wiki/Updating-existing-libraries#wiki-anon

if ( true ) {
	!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function() {
		return jQuery;
	}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
}




var

	// Map over jQuery in case of overwrite
	_jQuery = window.jQuery,

	// Map over the $ in case of overwrite
	_$ = window.$;

jQuery.noConflict = function( deep ) {
	if ( window.$ === jQuery ) {
		window.$ = _$;
	}

	if ( deep && window.jQuery === jQuery ) {
		window.jQuery = _jQuery;
	}

	return jQuery;
};

// Expose jQuery and $ identifiers, even in AMD
// (#7102#comment:10, https://github.com/jquery/jquery/pull/557)
// and CommonJS for browser emulators (#13566)
if ( typeof noGlobal === "undefined" ) {
	window.jQuery = window.$ = jQuery;
}




return jQuery;
} );


/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/owl.carousel/dist/owl.carousel.min.js":
/*!************************************************************!*\
  !*** ./node_modules/owl.carousel/dist/owl.carousel.min.js ***!
  \************************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* provided dependency */ var __webpack_provided_window_dot_jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/**
 * Owl Carousel v2.3.4
 * Copyright 2013-2018 David Deutsch
 * Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE
 */
!function(a,b,c,d){function e(b,c){this.settings=null,this.options=a.extend({},e.Defaults,c),this.$element=a(b),this._handlers={},this._plugins={},this._supress={},this._current=null,this._speed=null,this._coordinates=[],this._breakpoint=null,this._width=null,this._items=[],this._clones=[],this._mergers=[],this._widths=[],this._invalidated={},this._pipe=[],this._drag={time:null,target:null,pointer:null,stage:{start:null,current:null},direction:null},this._states={current:{},tags:{initializing:["busy"],animating:["busy"],dragging:["interacting"]}},a.each(["onResize","onThrottledResize"],a.proxy(function(b,c){this._handlers[c]=a.proxy(this[c],this)},this)),a.each(e.Plugins,a.proxy(function(a,b){this._plugins[a.charAt(0).toLowerCase()+a.slice(1)]=new b(this)},this)),a.each(e.Workers,a.proxy(function(b,c){this._pipe.push({filter:c.filter,run:a.proxy(c.run,this)})},this)),this.setup(),this.initialize()}e.Defaults={items:3,loop:!1,center:!1,rewind:!1,checkVisibility:!0,mouseDrag:!0,touchDrag:!0,pullDrag:!0,freeDrag:!1,margin:0,stagePadding:0,merge:!1,mergeFit:!0,autoWidth:!1,startPosition:0,rtl:!1,smartSpeed:250,fluidSpeed:!1,dragEndSpeed:!1,responsive:{},responsiveRefreshRate:200,responsiveBaseElement:b,fallbackEasing:"swing",slideTransition:"",info:!1,nestedItemSelector:!1,itemElement:"div",stageElement:"div",refreshClass:"owl-refresh",loadedClass:"owl-loaded",loadingClass:"owl-loading",rtlClass:"owl-rtl",responsiveClass:"owl-responsive",dragClass:"owl-drag",itemClass:"owl-item",stageClass:"owl-stage",stageOuterClass:"owl-stage-outer",grabClass:"owl-grab"},e.Width={Default:"default",Inner:"inner",Outer:"outer"},e.Type={Event:"event",State:"state"},e.Plugins={},e.Workers=[{filter:["width","settings"],run:function(){this._width=this.$element.width()}},{filter:["width","items","settings"],run:function(a){a.current=this._items&&this._items[this.relative(this._current)]}},{filter:["items","settings"],run:function(){this.$stage.children(".cloned").remove()}},{filter:["width","items","settings"],run:function(a){var b=this.settings.margin||"",c=!this.settings.autoWidth,d=this.settings.rtl,e={width:"auto","margin-left":d?b:"","margin-right":d?"":b};!c&&this.$stage.children().css(e),a.css=e}},{filter:["width","items","settings"],run:function(a){var b=(this.width()/this.settings.items).toFixed(3)-this.settings.margin,c=null,d=this._items.length,e=!this.settings.autoWidth,f=[];for(a.items={merge:!1,width:b};d--;)c=this._mergers[d],c=this.settings.mergeFit&&Math.min(c,this.settings.items)||c,a.items.merge=c>1||a.items.merge,f[d]=e?b*c:this._items[d].width();this._widths=f}},{filter:["items","settings"],run:function(){var b=[],c=this._items,d=this.settings,e=Math.max(2*d.items,4),f=2*Math.ceil(c.length/2),g=d.loop&&c.length?d.rewind?e:Math.max(e,f):0,h="",i="";for(g/=2;g>0;)b.push(this.normalize(b.length/2,!0)),h+=c[b[b.length-1]][0].outerHTML,b.push(this.normalize(c.length-1-(b.length-1)/2,!0)),i=c[b[b.length-1]][0].outerHTML+i,g-=1;this._clones=b,a(h).addClass("cloned").appendTo(this.$stage),a(i).addClass("cloned").prependTo(this.$stage)}},{filter:["width","items","settings"],run:function(){for(var a=this.settings.rtl?1:-1,b=this._clones.length+this._items.length,c=-1,d=0,e=0,f=[];++c<b;)d=f[c-1]||0,e=this._widths[this.relative(c)]+this.settings.margin,f.push(d+e*a);this._coordinates=f}},{filter:["width","items","settings"],run:function(){var a=this.settings.stagePadding,b=this._coordinates,c={width:Math.ceil(Math.abs(b[b.length-1]))+2*a,"padding-left":a||"","padding-right":a||""};this.$stage.css(c)}},{filter:["width","items","settings"],run:function(a){var b=this._coordinates.length,c=!this.settings.autoWidth,d=this.$stage.children();if(c&&a.items.merge)for(;b--;)a.css.width=this._widths[this.relative(b)],d.eq(b).css(a.css);else c&&(a.css.width=a.items.width,d.css(a.css))}},{filter:["items"],run:function(){this._coordinates.length<1&&this.$stage.removeAttr("style")}},{filter:["width","items","settings"],run:function(a){a.current=a.current?this.$stage.children().index(a.current):0,a.current=Math.max(this.minimum(),Math.min(this.maximum(),a.current)),this.reset(a.current)}},{filter:["position"],run:function(){this.animate(this.coordinates(this._current))}},{filter:["width","position","items","settings"],run:function(){var a,b,c,d,e=this.settings.rtl?1:-1,f=2*this.settings.stagePadding,g=this.coordinates(this.current())+f,h=g+this.width()*e,i=[];for(c=0,d=this._coordinates.length;c<d;c++)a=this._coordinates[c-1]||0,b=Math.abs(this._coordinates[c])+f*e,(this.op(a,"<=",g)&&this.op(a,">",h)||this.op(b,"<",g)&&this.op(b,">",h))&&i.push(c);this.$stage.children(".active").removeClass("active"),this.$stage.children(":eq("+i.join("), :eq(")+")").addClass("active"),this.$stage.children(".center").removeClass("center"),this.settings.center&&this.$stage.children().eq(this.current()).addClass("center")}}],e.prototype.initializeStage=function(){this.$stage=this.$element.find("."+this.settings.stageClass),this.$stage.length||(this.$element.addClass(this.options.loadingClass),this.$stage=a("<"+this.settings.stageElement+">",{class:this.settings.stageClass}).wrap(a("<div/>",{class:this.settings.stageOuterClass})),this.$element.append(this.$stage.parent()))},e.prototype.initializeItems=function(){var b=this.$element.find(".owl-item");if(b.length)return this._items=b.get().map(function(b){return a(b)}),this._mergers=this._items.map(function(){return 1}),void this.refresh();this.replace(this.$element.children().not(this.$stage.parent())),this.isVisible()?this.refresh():this.invalidate("width"),this.$element.removeClass(this.options.loadingClass).addClass(this.options.loadedClass)},e.prototype.initialize=function(){if(this.enter("initializing"),this.trigger("initialize"),this.$element.toggleClass(this.settings.rtlClass,this.settings.rtl),this.settings.autoWidth&&!this.is("pre-loading")){var a,b,c;a=this.$element.find("img"),b=this.settings.nestedItemSelector?"."+this.settings.nestedItemSelector:d,c=this.$element.children(b).width(),a.length&&c<=0&&this.preloadAutoWidthImages(a)}this.initializeStage(),this.initializeItems(),this.registerEventHandlers(),this.leave("initializing"),this.trigger("initialized")},e.prototype.isVisible=function(){return!this.settings.checkVisibility||this.$element.is(":visible")},e.prototype.setup=function(){var b=this.viewport(),c=this.options.responsive,d=-1,e=null;c?(a.each(c,function(a){a<=b&&a>d&&(d=Number(a))}),e=a.extend({},this.options,c[d]),"function"==typeof e.stagePadding&&(e.stagePadding=e.stagePadding()),delete e.responsive,e.responsiveClass&&this.$element.attr("class",this.$element.attr("class").replace(new RegExp("("+this.options.responsiveClass+"-)\\S+\\s","g"),"$1"+d))):e=a.extend({},this.options),this.trigger("change",{property:{name:"settings",value:e}}),this._breakpoint=d,this.settings=e,this.invalidate("settings"),this.trigger("changed",{property:{name:"settings",value:this.settings}})},e.prototype.optionsLogic=function(){this.settings.autoWidth&&(this.settings.stagePadding=!1,this.settings.merge=!1)},e.prototype.prepare=function(b){var c=this.trigger("prepare",{content:b});return c.data||(c.data=a("<"+this.settings.itemElement+"/>").addClass(this.options.itemClass).append(b)),this.trigger("prepared",{content:c.data}),c.data},e.prototype.update=function(){for(var b=0,c=this._pipe.length,d=a.proxy(function(a){return this[a]},this._invalidated),e={};b<c;)(this._invalidated.all||a.grep(this._pipe[b].filter,d).length>0)&&this._pipe[b].run(e),b++;this._invalidated={},!this.is("valid")&&this.enter("valid")},e.prototype.width=function(a){switch(a=a||e.Width.Default){case e.Width.Inner:case e.Width.Outer:return this._width;default:return this._width-2*this.settings.stagePadding+this.settings.margin}},e.prototype.refresh=function(){this.enter("refreshing"),this.trigger("refresh"),this.setup(),this.optionsLogic(),this.$element.addClass(this.options.refreshClass),this.update(),this.$element.removeClass(this.options.refreshClass),this.leave("refreshing"),this.trigger("refreshed")},e.prototype.onThrottledResize=function(){b.clearTimeout(this.resizeTimer),this.resizeTimer=b.setTimeout(this._handlers.onResize,this.settings.responsiveRefreshRate)},e.prototype.onResize=function(){return!!this._items.length&&(this._width!==this.$element.width()&&(!!this.isVisible()&&(this.enter("resizing"),this.trigger("resize").isDefaultPrevented()?(this.leave("resizing"),!1):(this.invalidate("width"),this.refresh(),this.leave("resizing"),void this.trigger("resized")))))},e.prototype.registerEventHandlers=function(){a.support.transition&&this.$stage.on(a.support.transition.end+".owl.core",a.proxy(this.onTransitionEnd,this)),!1!==this.settings.responsive&&this.on(b,"resize",this._handlers.onThrottledResize),this.settings.mouseDrag&&(this.$element.addClass(this.options.dragClass),this.$stage.on("mousedown.owl.core",a.proxy(this.onDragStart,this)),this.$stage.on("dragstart.owl.core selectstart.owl.core",function(){return!1})),this.settings.touchDrag&&(this.$stage.on("touchstart.owl.core",a.proxy(this.onDragStart,this)),this.$stage.on("touchcancel.owl.core",a.proxy(this.onDragEnd,this)))},e.prototype.onDragStart=function(b){var d=null;3!==b.which&&(a.support.transform?(d=this.$stage.css("transform").replace(/.*\(|\)| /g,"").split(","),d={x:d[16===d.length?12:4],y:d[16===d.length?13:5]}):(d=this.$stage.position(),d={x:this.settings.rtl?d.left+this.$stage.width()-this.width()+this.settings.margin:d.left,y:d.top}),this.is("animating")&&(a.support.transform?this.animate(d.x):this.$stage.stop(),this.invalidate("position")),this.$element.toggleClass(this.options.grabClass,"mousedown"===b.type),this.speed(0),this._drag.time=(new Date).getTime(),this._drag.target=a(b.target),this._drag.stage.start=d,this._drag.stage.current=d,this._drag.pointer=this.pointer(b),a(c).on("mouseup.owl.core touchend.owl.core",a.proxy(this.onDragEnd,this)),a(c).one("mousemove.owl.core touchmove.owl.core",a.proxy(function(b){var d=this.difference(this._drag.pointer,this.pointer(b));a(c).on("mousemove.owl.core touchmove.owl.core",a.proxy(this.onDragMove,this)),Math.abs(d.x)<Math.abs(d.y)&&this.is("valid")||(b.preventDefault(),this.enter("dragging"),this.trigger("drag"))},this)))},e.prototype.onDragMove=function(a){var b=null,c=null,d=null,e=this.difference(this._drag.pointer,this.pointer(a)),f=this.difference(this._drag.stage.start,e);this.is("dragging")&&(a.preventDefault(),this.settings.loop?(b=this.coordinates(this.minimum()),c=this.coordinates(this.maximum()+1)-b,f.x=((f.x-b)%c+c)%c+b):(b=this.settings.rtl?this.coordinates(this.maximum()):this.coordinates(this.minimum()),c=this.settings.rtl?this.coordinates(this.minimum()):this.coordinates(this.maximum()),d=this.settings.pullDrag?-1*e.x/5:0,f.x=Math.max(Math.min(f.x,b+d),c+d)),this._drag.stage.current=f,this.animate(f.x))},e.prototype.onDragEnd=function(b){var d=this.difference(this._drag.pointer,this.pointer(b)),e=this._drag.stage.current,f=d.x>0^this.settings.rtl?"left":"right";a(c).off(".owl.core"),this.$element.removeClass(this.options.grabClass),(0!==d.x&&this.is("dragging")||!this.is("valid"))&&(this.speed(this.settings.dragEndSpeed||this.settings.smartSpeed),this.current(this.closest(e.x,0!==d.x?f:this._drag.direction)),this.invalidate("position"),this.update(),this._drag.direction=f,(Math.abs(d.x)>3||(new Date).getTime()-this._drag.time>300)&&this._drag.target.one("click.owl.core",function(){return!1})),this.is("dragging")&&(this.leave("dragging"),this.trigger("dragged"))},e.prototype.closest=function(b,c){var e=-1,f=30,g=this.width(),h=this.coordinates();return this.settings.freeDrag||a.each(h,a.proxy(function(a,i){return"left"===c&&b>i-f&&b<i+f?e=a:"right"===c&&b>i-g-f&&b<i-g+f?e=a+1:this.op(b,"<",i)&&this.op(b,">",h[a+1]!==d?h[a+1]:i-g)&&(e="left"===c?a+1:a),-1===e},this)),this.settings.loop||(this.op(b,">",h[this.minimum()])?e=b=this.minimum():this.op(b,"<",h[this.maximum()])&&(e=b=this.maximum())),e},e.prototype.animate=function(b){var c=this.speed()>0;this.is("animating")&&this.onTransitionEnd(),c&&(this.enter("animating"),this.trigger("translate")),a.support.transform3d&&a.support.transition?this.$stage.css({transform:"translate3d("+b+"px,0px,0px)",transition:this.speed()/1e3+"s"+(this.settings.slideTransition?" "+this.settings.slideTransition:"")}):c?this.$stage.animate({left:b+"px"},this.speed(),this.settings.fallbackEasing,a.proxy(this.onTransitionEnd,this)):this.$stage.css({left:b+"px"})},e.prototype.is=function(a){return this._states.current[a]&&this._states.current[a]>0},e.prototype.current=function(a){if(a===d)return this._current;if(0===this._items.length)return d;if(a=this.normalize(a),this._current!==a){var b=this.trigger("change",{property:{name:"position",value:a}});b.data!==d&&(a=this.normalize(b.data)),this._current=a,this.invalidate("position"),this.trigger("changed",{property:{name:"position",value:this._current}})}return this._current},e.prototype.invalidate=function(b){return"string"===a.type(b)&&(this._invalidated[b]=!0,this.is("valid")&&this.leave("valid")),a.map(this._invalidated,function(a,b){return b})},e.prototype.reset=function(a){(a=this.normalize(a))!==d&&(this._speed=0,this._current=a,this.suppress(["translate","translated"]),this.animate(this.coordinates(a)),this.release(["translate","translated"]))},e.prototype.normalize=function(a,b){var c=this._items.length,e=b?0:this._clones.length;return!this.isNumeric(a)||c<1?a=d:(a<0||a>=c+e)&&(a=((a-e/2)%c+c)%c+e/2),a},e.prototype.relative=function(a){return a-=this._clones.length/2,this.normalize(a,!0)},e.prototype.maximum=function(a){var b,c,d,e=this.settings,f=this._coordinates.length;if(e.loop)f=this._clones.length/2+this._items.length-1;else if(e.autoWidth||e.merge){if(b=this._items.length)for(c=this._items[--b].width(),d=this.$element.width();b--&&!((c+=this._items[b].width()+this.settings.margin)>d););f=b+1}else f=e.center?this._items.length-1:this._items.length-e.items;return a&&(f-=this._clones.length/2),Math.max(f,0)},e.prototype.minimum=function(a){return a?0:this._clones.length/2},e.prototype.items=function(a){return a===d?this._items.slice():(a=this.normalize(a,!0),this._items[a])},e.prototype.mergers=function(a){return a===d?this._mergers.slice():(a=this.normalize(a,!0),this._mergers[a])},e.prototype.clones=function(b){var c=this._clones.length/2,e=c+this._items.length,f=function(a){return a%2==0?e+a/2:c-(a+1)/2};return b===d?a.map(this._clones,function(a,b){return f(b)}):a.map(this._clones,function(a,c){return a===b?f(c):null})},e.prototype.speed=function(a){return a!==d&&(this._speed=a),this._speed},e.prototype.coordinates=function(b){var c,e=1,f=b-1;return b===d?a.map(this._coordinates,a.proxy(function(a,b){return this.coordinates(b)},this)):(this.settings.center?(this.settings.rtl&&(e=-1,f=b+1),c=this._coordinates[b],c+=(this.width()-c+(this._coordinates[f]||0))/2*e):c=this._coordinates[f]||0,c=Math.ceil(c))},e.prototype.duration=function(a,b,c){return 0===c?0:Math.min(Math.max(Math.abs(b-a),1),6)*Math.abs(c||this.settings.smartSpeed)},e.prototype.to=function(a,b){var c=this.current(),d=null,e=a-this.relative(c),f=(e>0)-(e<0),g=this._items.length,h=this.minimum(),i=this.maximum();this.settings.loop?(!this.settings.rewind&&Math.abs(e)>g/2&&(e+=-1*f*g),a=c+e,(d=((a-h)%g+g)%g+h)!==a&&d-e<=i&&d-e>0&&(c=d-e,a=d,this.reset(c))):this.settings.rewind?(i+=1,a=(a%i+i)%i):a=Math.max(h,Math.min(i,a)),this.speed(this.duration(c,a,b)),this.current(a),this.isVisible()&&this.update()},e.prototype.next=function(a){a=a||!1,this.to(this.relative(this.current())+1,a)},e.prototype.prev=function(a){a=a||!1,this.to(this.relative(this.current())-1,a)},e.prototype.onTransitionEnd=function(a){if(a!==d&&(a.stopPropagation(),(a.target||a.srcElement||a.originalTarget)!==this.$stage.get(0)))return!1;this.leave("animating"),this.trigger("translated")},e.prototype.viewport=function(){var d;return this.options.responsiveBaseElement!==b?d=a(this.options.responsiveBaseElement).width():b.innerWidth?d=b.innerWidth:c.documentElement&&c.documentElement.clientWidth?d=c.documentElement.clientWidth:console.warn("Can not detect viewport width."),d},e.prototype.replace=function(b){this.$stage.empty(),this._items=[],b&&(b=b instanceof jQuery?b:a(b)),this.settings.nestedItemSelector&&(b=b.find("."+this.settings.nestedItemSelector)),b.filter(function(){return 1===this.nodeType}).each(a.proxy(function(a,b){b=this.prepare(b),this.$stage.append(b),this._items.push(b),this._mergers.push(1*b.find("[data-merge]").addBack("[data-merge]").attr("data-merge")||1)},this)),this.reset(this.isNumeric(this.settings.startPosition)?this.settings.startPosition:0),this.invalidate("items")},e.prototype.add=function(b,c){var e=this.relative(this._current);c=c===d?this._items.length:this.normalize(c,!0),b=b instanceof jQuery?b:a(b),this.trigger("add",{content:b,position:c}),b=this.prepare(b),0===this._items.length||c===this._items.length?(0===this._items.length&&this.$stage.append(b),0!==this._items.length&&this._items[c-1].after(b),this._items.push(b),this._mergers.push(1*b.find("[data-merge]").addBack("[data-merge]").attr("data-merge")||1)):(this._items[c].before(b),this._items.splice(c,0,b),this._mergers.splice(c,0,1*b.find("[data-merge]").addBack("[data-merge]").attr("data-merge")||1)),this._items[e]&&this.reset(this._items[e].index()),this.invalidate("items"),this.trigger("added",{content:b,position:c})},e.prototype.remove=function(a){(a=this.normalize(a,!0))!==d&&(this.trigger("remove",{content:this._items[a],position:a}),this._items[a].remove(),this._items.splice(a,1),this._mergers.splice(a,1),this.invalidate("items"),this.trigger("removed",{content:null,position:a}))},e.prototype.preloadAutoWidthImages=function(b){b.each(a.proxy(function(b,c){this.enter("pre-loading"),c=a(c),a(new Image).one("load",a.proxy(function(a){c.attr("src",a.target.src),c.css("opacity",1),this.leave("pre-loading"),!this.is("pre-loading")&&!this.is("initializing")&&this.refresh()},this)).attr("src",c.attr("src")||c.attr("data-src")||c.attr("data-src-retina"))},this))},e.prototype.destroy=function(){this.$element.off(".owl.core"),this.$stage.off(".owl.core"),a(c).off(".owl.core"),!1!==this.settings.responsive&&(b.clearTimeout(this.resizeTimer),this.off(b,"resize",this._handlers.onThrottledResize));for(var d in this._plugins)this._plugins[d].destroy();this.$stage.children(".cloned").remove(),this.$stage.unwrap(),this.$stage.children().contents().unwrap(),this.$stage.children().unwrap(),this.$stage.remove(),this.$element.removeClass(this.options.refreshClass).removeClass(this.options.loadingClass).removeClass(this.options.loadedClass).removeClass(this.options.rtlClass).removeClass(this.options.dragClass).removeClass(this.options.grabClass).attr("class",this.$element.attr("class").replace(new RegExp(this.options.responsiveClass+"-\\S+\\s","g"),"")).removeData("owl.carousel")},e.prototype.op=function(a,b,c){var d=this.settings.rtl;switch(b){case"<":return d?a>c:a<c;case">":return d?a<c:a>c;case">=":return d?a<=c:a>=c;case"<=":return d?a>=c:a<=c}},e.prototype.on=function(a,b,c,d){a.addEventListener?a.addEventListener(b,c,d):a.attachEvent&&a.attachEvent("on"+b,c)},e.prototype.off=function(a,b,c,d){a.removeEventListener?a.removeEventListener(b,c,d):a.detachEvent&&a.detachEvent("on"+b,c)},e.prototype.trigger=function(b,c,d,f,g){var h={item:{count:this._items.length,index:this.current()}},i=a.camelCase(a.grep(["on",b,d],function(a){return a}).join("-").toLowerCase()),j=a.Event([b,"owl",d||"carousel"].join(".").toLowerCase(),a.extend({relatedTarget:this},h,c));return this._supress[b]||(a.each(this._plugins,function(a,b){b.onTrigger&&b.onTrigger(j)}),this.register({type:e.Type.Event,name:b}),this.$element.trigger(j),this.settings&&"function"==typeof this.settings[i]&&this.settings[i].call(this,j)),j},e.prototype.enter=function(b){a.each([b].concat(this._states.tags[b]||[]),a.proxy(function(a,b){this._states.current[b]===d&&(this._states.current[b]=0),this._states.current[b]++},this))},e.prototype.leave=function(b){a.each([b].concat(this._states.tags[b]||[]),a.proxy(function(a,b){this._states.current[b]--},this))},e.prototype.register=function(b){if(b.type===e.Type.Event){if(a.event.special[b.name]||(a.event.special[b.name]={}),!a.event.special[b.name].owl){var c=a.event.special[b.name]._default;a.event.special[b.name]._default=function(a){return!c||!c.apply||a.namespace&&-1!==a.namespace.indexOf("owl")?a.namespace&&a.namespace.indexOf("owl")>-1:c.apply(this,arguments)},a.event.special[b.name].owl=!0}}else b.type===e.Type.State&&(this._states.tags[b.name]?this._states.tags[b.name]=this._states.tags[b.name].concat(b.tags):this._states.tags[b.name]=b.tags,this._states.tags[b.name]=a.grep(this._states.tags[b.name],a.proxy(function(c,d){return a.inArray(c,this._states.tags[b.name])===d},this)))},e.prototype.suppress=function(b){a.each(b,a.proxy(function(a,b){this._supress[b]=!0},this))},e.prototype.release=function(b){a.each(b,a.proxy(function(a,b){delete this._supress[b]},this))},e.prototype.pointer=function(a){var c={x:null,y:null};return a=a.originalEvent||a||b.event,a=a.touches&&a.touches.length?a.touches[0]:a.changedTouches&&a.changedTouches.length?a.changedTouches[0]:a,a.pageX?(c.x=a.pageX,c.y=a.pageY):(c.x=a.clientX,c.y=a.clientY),c},e.prototype.isNumeric=function(a){return!isNaN(parseFloat(a))},e.prototype.difference=function(a,b){return{x:a.x-b.x,y:a.y-b.y}},a.fn.owlCarousel=function(b){var c=Array.prototype.slice.call(arguments,1);return this.each(function(){var d=a(this),f=d.data("owl.carousel");f||(f=new e(this,"object"==typeof b&&b),d.data("owl.carousel",f),a.each(["next","prev","to","destroy","refresh","replace","add","remove"],function(b,c){f.register({type:e.Type.Event,name:c}),f.$element.on(c+".owl.carousel.core",a.proxy(function(a){a.namespace&&a.relatedTarget!==this&&(this.suppress([c]),f[c].apply(this,[].slice.call(arguments,1)),this.release([c]))},f))})),"string"==typeof b&&"_"!==b.charAt(0)&&f[b].apply(f,c)})},a.fn.owlCarousel.Constructor=e}(window.Zepto||__webpack_provided_window_dot_jQuery,window,document),function(a,b,c,d){var e=function(b){this._core=b,this._interval=null,this._visible=null,this._handlers={"initialized.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.autoRefresh&&this.watch()},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this._core.$element.on(this._handlers)};e.Defaults={autoRefresh:!0,autoRefreshInterval:500},e.prototype.watch=function(){this._interval||(this._visible=this._core.isVisible(),this._interval=b.setInterval(a.proxy(this.refresh,this),this._core.settings.autoRefreshInterval))},e.prototype.refresh=function(){this._core.isVisible()!==this._visible&&(this._visible=!this._visible,this._core.$element.toggleClass("owl-hidden",!this._visible),this._visible&&this._core.invalidate("width")&&this._core.refresh())},e.prototype.destroy=function(){var a,c;b.clearInterval(this._interval);for(a in this._handlers)this._core.$element.off(a,this._handlers[a]);for(c in Object.getOwnPropertyNames(this))"function"!=typeof this[c]&&(this[c]=null)},a.fn.owlCarousel.Constructor.Plugins.AutoRefresh=e}(window.Zepto||__webpack_provided_window_dot_jQuery,window,document),function(a,b,c,d){var e=function(b){this._core=b,this._loaded=[],this._handlers={"initialized.owl.carousel change.owl.carousel resized.owl.carousel":a.proxy(function(b){if(b.namespace&&this._core.settings&&this._core.settings.lazyLoad&&(b.property&&"position"==b.property.name||"initialized"==b.type)){var c=this._core.settings,e=c.center&&Math.ceil(c.items/2)||c.items,f=c.center&&-1*e||0,g=(b.property&&b.property.value!==d?b.property.value:this._core.current())+f,h=this._core.clones().length,i=a.proxy(function(a,b){this.load(b)},this);for(c.lazyLoadEager>0&&(e+=c.lazyLoadEager,c.loop&&(g-=c.lazyLoadEager,e++));f++<e;)this.load(h/2+this._core.relative(g)),h&&a.each(this._core.clones(this._core.relative(g)),i),g++}},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this._core.$element.on(this._handlers)};e.Defaults={lazyLoad:!1,lazyLoadEager:0},e.prototype.load=function(c){var d=this._core.$stage.children().eq(c),e=d&&d.find(".owl-lazy");!e||a.inArray(d.get(0),this._loaded)>-1||(e.each(a.proxy(function(c,d){var e,f=a(d),g=b.devicePixelRatio>1&&f.attr("data-src-retina")||f.attr("data-src")||f.attr("data-srcset");this._core.trigger("load",{element:f,url:g},"lazy"),f.is("img")?f.one("load.owl.lazy",a.proxy(function(){f.css("opacity",1),this._core.trigger("loaded",{element:f,url:g},"lazy")},this)).attr("src",g):f.is("source")?f.one("load.owl.lazy",a.proxy(function(){this._core.trigger("loaded",{element:f,url:g},"lazy")},this)).attr("srcset",g):(e=new Image,e.onload=a.proxy(function(){f.css({"background-image":'url("'+g+'")',opacity:"1"}),this._core.trigger("loaded",{element:f,url:g},"lazy")},this),e.src=g)},this)),this._loaded.push(d.get(0)))},e.prototype.destroy=function(){var a,b;for(a in this.handlers)this._core.$element.off(a,this.handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)},a.fn.owlCarousel.Constructor.Plugins.Lazy=e}(window.Zepto||__webpack_provided_window_dot_jQuery,window,document),function(a,b,c,d){var e=function(c){this._core=c,this._previousHeight=null,this._handlers={"initialized.owl.carousel refreshed.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.autoHeight&&this.update()},this),"changed.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.autoHeight&&"position"===a.property.name&&this.update()},this),"loaded.owl.lazy":a.proxy(function(a){a.namespace&&this._core.settings.autoHeight&&a.element.closest("."+this._core.settings.itemClass).index()===this._core.current()&&this.update()},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this._core.$element.on(this._handlers),this._intervalId=null;var d=this;a(b).on("load",function(){d._core.settings.autoHeight&&d.update()}),a(b).resize(function(){d._core.settings.autoHeight&&(null!=d._intervalId&&clearTimeout(d._intervalId),d._intervalId=setTimeout(function(){d.update()},250))})};e.Defaults={autoHeight:!1,autoHeightClass:"owl-height"},e.prototype.update=function(){var b=this._core._current,c=b+this._core.settings.items,d=this._core.settings.lazyLoad,e=this._core.$stage.children().toArray().slice(b,c),f=[],g=0;a.each(e,function(b,c){f.push(a(c).height())}),g=Math.max.apply(null,f),g<=1&&d&&this._previousHeight&&(g=this._previousHeight),this._previousHeight=g,this._core.$stage.parent().height(g).addClass(this._core.settings.autoHeightClass)},e.prototype.destroy=function(){var a,b;for(a in this._handlers)this._core.$element.off(a,this._handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)},a.fn.owlCarousel.Constructor.Plugins.AutoHeight=e}(window.Zepto||__webpack_provided_window_dot_jQuery,window,document),function(a,b,c,d){var e=function(b){this._core=b,this._videos={},this._playing=null,this._handlers={"initialized.owl.carousel":a.proxy(function(a){a.namespace&&this._core.register({type:"state",name:"playing",tags:["interacting"]})},this),"resize.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.video&&this.isInFullScreen()&&a.preventDefault()},this),"refreshed.owl.carousel":a.proxy(function(a){a.namespace&&this._core.is("resizing")&&this._core.$stage.find(".cloned .owl-video-frame").remove()},this),"changed.owl.carousel":a.proxy(function(a){a.namespace&&"position"===a.property.name&&this._playing&&this.stop()},this),"prepared.owl.carousel":a.proxy(function(b){if(b.namespace){var c=a(b.content).find(".owl-video");c.length&&(c.css("display","none"),this.fetch(c,a(b.content)))}},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this._core.$element.on(this._handlers),this._core.$element.on("click.owl.video",".owl-video-play-icon",a.proxy(function(a){this.play(a)},this))};e.Defaults={video:!1,videoHeight:!1,videoWidth:!1},e.prototype.fetch=function(a,b){var c=function(){return a.attr("data-vimeo-id")?"vimeo":a.attr("data-vzaar-id")?"vzaar":"youtube"}(),d=a.attr("data-vimeo-id")||a.attr("data-youtube-id")||a.attr("data-vzaar-id"),e=a.attr("data-width")||this._core.settings.videoWidth,f=a.attr("data-height")||this._core.settings.videoHeight,g=a.attr("href");if(!g)throw new Error("Missing video URL.");if(d=g.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/),d[3].indexOf("youtu")>-1)c="youtube";else if(d[3].indexOf("vimeo")>-1)c="vimeo";else{if(!(d[3].indexOf("vzaar")>-1))throw new Error("Video URL not supported.");c="vzaar"}d=d[6],this._videos[g]={type:c,id:d,width:e,height:f},b.attr("data-video",g),this.thumbnail(a,this._videos[g])},e.prototype.thumbnail=function(b,c){var d,e,f,g=c.width&&c.height?"width:"+c.width+"px;height:"+c.height+"px;":"",h=b.find("img"),i="src",j="",k=this._core.settings,l=function(c){e='<div class="owl-video-play-icon"></div>',d=k.lazyLoad?a("<div/>",{class:"owl-video-tn "+j,srcType:c}):a("<div/>",{class:"owl-video-tn",style:"opacity:1;background-image:url("+c+")"}),b.after(d),b.after(e)};if(b.wrap(a("<div/>",{class:"owl-video-wrapper",style:g})),this._core.settings.lazyLoad&&(i="data-src",j="owl-lazy"),h.length)return l(h.attr(i)),h.remove(),!1;"youtube"===c.type?(f="//img.youtube.com/vi/"+c.id+"/hqdefault.jpg",l(f)):"vimeo"===c.type?a.ajax({type:"GET",url:"//vimeo.com/api/v2/video/"+c.id+".json",jsonp:"callback",dataType:"jsonp",success:function(a){f=a[0].thumbnail_large,l(f)}}):"vzaar"===c.type&&a.ajax({type:"GET",url:"//vzaar.com/api/videos/"+c.id+".json",jsonp:"callback",dataType:"jsonp",success:function(a){f=a.framegrab_url,l(f)}})},e.prototype.stop=function(){this._core.trigger("stop",null,"video"),this._playing.find(".owl-video-frame").remove(),this._playing.removeClass("owl-video-playing"),this._playing=null,this._core.leave("playing"),this._core.trigger("stopped",null,"video")},e.prototype.play=function(b){var c,d=a(b.target),e=d.closest("."+this._core.settings.itemClass),f=this._videos[e.attr("data-video")],g=f.width||"100%",h=f.height||this._core.$stage.height();this._playing||(this._core.enter("playing"),this._core.trigger("play",null,"video"),e=this._core.items(this._core.relative(e.index())),this._core.reset(e.index()),c=a('<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ></iframe>'),c.attr("height",h),c.attr("width",g),"youtube"===f.type?c.attr("src","//www.youtube.com/embed/"+f.id+"?autoplay=1&rel=0&v="+f.id):"vimeo"===f.type?c.attr("src","//player.vimeo.com/video/"+f.id+"?autoplay=1"):"vzaar"===f.type&&c.attr("src","//view.vzaar.com/"+f.id+"/player?autoplay=true"),a(c).wrap('<div class="owl-video-frame" />').insertAfter(e.find(".owl-video")),this._playing=e.addClass("owl-video-playing"))},e.prototype.isInFullScreen=function(){var b=c.fullscreenElement||c.mozFullScreenElement||c.webkitFullscreenElement;return b&&a(b).parent().hasClass("owl-video-frame")},e.prototype.destroy=function(){var a,b;this._core.$element.off("click.owl.video");for(a in this._handlers)this._core.$element.off(a,this._handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)},a.fn.owlCarousel.Constructor.Plugins.Video=e}(window.Zepto||__webpack_provided_window_dot_jQuery,window,document),function(a,b,c,d){var e=function(b){this.core=b,this.core.options=a.extend({},e.Defaults,this.core.options),this.swapping=!0,this.previous=d,this.next=d,this.handlers={"change.owl.carousel":a.proxy(function(a){a.namespace&&"position"==a.property.name&&(this.previous=this.core.current(),this.next=a.property.value)},this),"drag.owl.carousel dragged.owl.carousel translated.owl.carousel":a.proxy(function(a){a.namespace&&(this.swapping="translated"==a.type)},this),"translate.owl.carousel":a.proxy(function(a){a.namespace&&this.swapping&&(this.core.options.animateOut||this.core.options.animateIn)&&this.swap()},this)},this.core.$element.on(this.handlers)};e.Defaults={animateOut:!1,
animateIn:!1},e.prototype.swap=function(){if(1===this.core.settings.items&&a.support.animation&&a.support.transition){this.core.speed(0);var b,c=a.proxy(this.clear,this),d=this.core.$stage.children().eq(this.previous),e=this.core.$stage.children().eq(this.next),f=this.core.settings.animateIn,g=this.core.settings.animateOut;this.core.current()!==this.previous&&(g&&(b=this.core.coordinates(this.previous)-this.core.coordinates(this.next),d.one(a.support.animation.end,c).css({left:b+"px"}).addClass("animated owl-animated-out").addClass(g)),f&&e.one(a.support.animation.end,c).addClass("animated owl-animated-in").addClass(f))}},e.prototype.clear=function(b){a(b.target).css({left:""}).removeClass("animated owl-animated-out owl-animated-in").removeClass(this.core.settings.animateIn).removeClass(this.core.settings.animateOut),this.core.onTransitionEnd()},e.prototype.destroy=function(){var a,b;for(a in this.handlers)this.core.$element.off(a,this.handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)},a.fn.owlCarousel.Constructor.Plugins.Animate=e}(window.Zepto||__webpack_provided_window_dot_jQuery,window,document),function(a,b,c,d){var e=function(b){this._core=b,this._call=null,this._time=0,this._timeout=0,this._paused=!0,this._handlers={"changed.owl.carousel":a.proxy(function(a){a.namespace&&"settings"===a.property.name?this._core.settings.autoplay?this.play():this.stop():a.namespace&&"position"===a.property.name&&this._paused&&(this._time=0)},this),"initialized.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.autoplay&&this.play()},this),"play.owl.autoplay":a.proxy(function(a,b,c){a.namespace&&this.play(b,c)},this),"stop.owl.autoplay":a.proxy(function(a){a.namespace&&this.stop()},this),"mouseover.owl.autoplay":a.proxy(function(){this._core.settings.autoplayHoverPause&&this._core.is("rotating")&&this.pause()},this),"mouseleave.owl.autoplay":a.proxy(function(){this._core.settings.autoplayHoverPause&&this._core.is("rotating")&&this.play()},this),"touchstart.owl.core":a.proxy(function(){this._core.settings.autoplayHoverPause&&this._core.is("rotating")&&this.pause()},this),"touchend.owl.core":a.proxy(function(){this._core.settings.autoplayHoverPause&&this.play()},this)},this._core.$element.on(this._handlers),this._core.options=a.extend({},e.Defaults,this._core.options)};e.Defaults={autoplay:!1,autoplayTimeout:5e3,autoplayHoverPause:!1,autoplaySpeed:!1},e.prototype._next=function(d){this._call=b.setTimeout(a.proxy(this._next,this,d),this._timeout*(Math.round(this.read()/this._timeout)+1)-this.read()),this._core.is("interacting")||c.hidden||this._core.next(d||this._core.settings.autoplaySpeed)},e.prototype.read=function(){return(new Date).getTime()-this._time},e.prototype.play=function(c,d){var e;this._core.is("rotating")||this._core.enter("rotating"),c=c||this._core.settings.autoplayTimeout,e=Math.min(this._time%(this._timeout||c),c),this._paused?(this._time=this.read(),this._paused=!1):b.clearTimeout(this._call),this._time+=this.read()%c-e,this._timeout=c,this._call=b.setTimeout(a.proxy(this._next,this,d),c-e)},e.prototype.stop=function(){this._core.is("rotating")&&(this._time=0,this._paused=!0,b.clearTimeout(this._call),this._core.leave("rotating"))},e.prototype.pause=function(){this._core.is("rotating")&&!this._paused&&(this._time=this.read(),this._paused=!0,b.clearTimeout(this._call))},e.prototype.destroy=function(){var a,b;this.stop();for(a in this._handlers)this._core.$element.off(a,this._handlers[a]);for(b in Object.getOwnPropertyNames(this))"function"!=typeof this[b]&&(this[b]=null)},a.fn.owlCarousel.Constructor.Plugins.autoplay=e}(window.Zepto||__webpack_provided_window_dot_jQuery,window,document),function(a,b,c,d){"use strict";var e=function(b){this._core=b,this._initialized=!1,this._pages=[],this._controls={},this._templates=[],this.$element=this._core.$element,this._overrides={next:this._core.next,prev:this._core.prev,to:this._core.to},this._handlers={"prepared.owl.carousel":a.proxy(function(b){b.namespace&&this._core.settings.dotsData&&this._templates.push('<div class="'+this._core.settings.dotClass+'">'+a(b.content).find("[data-dot]").addBack("[data-dot]").attr("data-dot")+"</div>")},this),"added.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.dotsData&&this._templates.splice(a.position,0,this._templates.pop())},this),"remove.owl.carousel":a.proxy(function(a){a.namespace&&this._core.settings.dotsData&&this._templates.splice(a.position,1)},this),"changed.owl.carousel":a.proxy(function(a){a.namespace&&"position"==a.property.name&&this.draw()},this),"initialized.owl.carousel":a.proxy(function(a){a.namespace&&!this._initialized&&(this._core.trigger("initialize",null,"navigation"),this.initialize(),this.update(),this.draw(),this._initialized=!0,this._core.trigger("initialized",null,"navigation"))},this),"refreshed.owl.carousel":a.proxy(function(a){a.namespace&&this._initialized&&(this._core.trigger("refresh",null,"navigation"),this.update(),this.draw(),this._core.trigger("refreshed",null,"navigation"))},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this.$element.on(this._handlers)};e.Defaults={nav:!1,navText:['<span aria-label="Previous">&#x2039;</span>','<span aria-label="Next">&#x203a;</span>'],navSpeed:!1,navElement:'button type="button" role="presentation"',navContainer:!1,navContainerClass:"owl-nav",navClass:["owl-prev","owl-next"],slideBy:1,dotClass:"owl-dot",dotsClass:"owl-dots",dots:!0,dotsEach:!1,dotsData:!1,dotsSpeed:!1,dotsContainer:!1},e.prototype.initialize=function(){var b,c=this._core.settings;this._controls.$relative=(c.navContainer?a(c.navContainer):a("<div>").addClass(c.navContainerClass).appendTo(this.$element)).addClass("disabled"),this._controls.$previous=a("<"+c.navElement+">").addClass(c.navClass[0]).html(c.navText[0]).prependTo(this._controls.$relative).on("click",a.proxy(function(a){this.prev(c.navSpeed)},this)),this._controls.$next=a("<"+c.navElement+">").addClass(c.navClass[1]).html(c.navText[1]).appendTo(this._controls.$relative).on("click",a.proxy(function(a){this.next(c.navSpeed)},this)),c.dotsData||(this._templates=[a('<button role="button">').addClass(c.dotClass).append(a("<span>")).prop("outerHTML")]),this._controls.$absolute=(c.dotsContainer?a(c.dotsContainer):a("<div>").addClass(c.dotsClass).appendTo(this.$element)).addClass("disabled"),this._controls.$absolute.on("click","button",a.proxy(function(b){var d=a(b.target).parent().is(this._controls.$absolute)?a(b.target).index():a(b.target).parent().index();b.preventDefault(),this.to(d,c.dotsSpeed)},this));for(b in this._overrides)this._core[b]=a.proxy(this[b],this)},e.prototype.destroy=function(){var a,b,c,d,e;e=this._core.settings;for(a in this._handlers)this.$element.off(a,this._handlers[a]);for(b in this._controls)"$relative"===b&&e.navContainer?this._controls[b].html(""):this._controls[b].remove();for(d in this.overides)this._core[d]=this._overrides[d];for(c in Object.getOwnPropertyNames(this))"function"!=typeof this[c]&&(this[c]=null)},e.prototype.update=function(){var a,b,c,d=this._core.clones().length/2,e=d+this._core.items().length,f=this._core.maximum(!0),g=this._core.settings,h=g.center||g.autoWidth||g.dotsData?1:g.dotsEach||g.items;if("page"!==g.slideBy&&(g.slideBy=Math.min(g.slideBy,g.items)),g.dots||"page"==g.slideBy)for(this._pages=[],a=d,b=0,c=0;a<e;a++){if(b>=h||0===b){if(this._pages.push({start:Math.min(f,a-d),end:a-d+h-1}),Math.min(f,a-d)===f)break;b=0,++c}b+=this._core.mergers(this._core.relative(a))}},e.prototype.draw=function(){var b,c=this._core.settings,d=this._core.items().length<=c.items,e=this._core.relative(this._core.current()),f=c.loop||c.rewind;this._controls.$relative.toggleClass("disabled",!c.nav||d),c.nav&&(this._controls.$previous.toggleClass("disabled",!f&&e<=this._core.minimum(!0)),this._controls.$next.toggleClass("disabled",!f&&e>=this._core.maximum(!0))),this._controls.$absolute.toggleClass("disabled",!c.dots||d),c.dots&&(b=this._pages.length-this._controls.$absolute.children().length,c.dotsData&&0!==b?this._controls.$absolute.html(this._templates.join("")):b>0?this._controls.$absolute.append(new Array(b+1).join(this._templates[0])):b<0&&this._controls.$absolute.children().slice(b).remove(),this._controls.$absolute.find(".active").removeClass("active"),this._controls.$absolute.children().eq(a.inArray(this.current(),this._pages)).addClass("active"))},e.prototype.onTrigger=function(b){var c=this._core.settings;b.page={index:a.inArray(this.current(),this._pages),count:this._pages.length,size:c&&(c.center||c.autoWidth||c.dotsData?1:c.dotsEach||c.items)}},e.prototype.current=function(){var b=this._core.relative(this._core.current());return a.grep(this._pages,a.proxy(function(a,c){return a.start<=b&&a.end>=b},this)).pop()},e.prototype.getPosition=function(b){var c,d,e=this._core.settings;return"page"==e.slideBy?(c=a.inArray(this.current(),this._pages),d=this._pages.length,b?++c:--c,c=this._pages[(c%d+d)%d].start):(c=this._core.relative(this._core.current()),d=this._core.items().length,b?c+=e.slideBy:c-=e.slideBy),c},e.prototype.next=function(b){a.proxy(this._overrides.to,this._core)(this.getPosition(!0),b)},e.prototype.prev=function(b){a.proxy(this._overrides.to,this._core)(this.getPosition(!1),b)},e.prototype.to=function(b,c,d){var e;!d&&this._pages.length?(e=this._pages.length,a.proxy(this._overrides.to,this._core)(this._pages[(b%e+e)%e].start,c)):a.proxy(this._overrides.to,this._core)(b,c)},a.fn.owlCarousel.Constructor.Plugins.Navigation=e}(window.Zepto||__webpack_provided_window_dot_jQuery,window,document),function(a,b,c,d){"use strict";var e=function(c){this._core=c,this._hashes={},this.$element=this._core.$element,this._handlers={"initialized.owl.carousel":a.proxy(function(c){c.namespace&&"URLHash"===this._core.settings.startPosition&&a(b).trigger("hashchange.owl.navigation")},this),"prepared.owl.carousel":a.proxy(function(b){if(b.namespace){var c=a(b.content).find("[data-hash]").addBack("[data-hash]").attr("data-hash");if(!c)return;this._hashes[c]=b.content}},this),"changed.owl.carousel":a.proxy(function(c){if(c.namespace&&"position"===c.property.name){var d=this._core.items(this._core.relative(this._core.current())),e=a.map(this._hashes,function(a,b){return a===d?b:null}).join();if(!e||b.location.hash.slice(1)===e)return;b.location.hash=e}},this)},this._core.options=a.extend({},e.Defaults,this._core.options),this.$element.on(this._handlers),a(b).on("hashchange.owl.navigation",a.proxy(function(a){var c=b.location.hash.substring(1),e=this._core.$stage.children(),f=this._hashes[c]&&e.index(this._hashes[c]);f!==d&&f!==this._core.current()&&this._core.to(this._core.relative(f),!1,!0)},this))};e.Defaults={URLhashListener:!1},e.prototype.destroy=function(){var c,d;a(b).off("hashchange.owl.navigation");for(c in this._handlers)this._core.$element.off(c,this._handlers[c]);for(d in Object.getOwnPropertyNames(this))"function"!=typeof this[d]&&(this[d]=null)},a.fn.owlCarousel.Constructor.Plugins.Hash=e}(window.Zepto||__webpack_provided_window_dot_jQuery,window,document),function(a,b,c,d){function e(b,c){var e=!1,f=b.charAt(0).toUpperCase()+b.slice(1);return a.each((b+" "+h.join(f+" ")+f).split(" "),function(a,b){if(g[b]!==d)return e=!c||b,!1}),e}function f(a){return e(a,!0)}var g=a("<support>").get(0).style,h="Webkit Moz O ms".split(" "),i={transition:{end:{WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd",transition:"transitionend"}},animation:{end:{WebkitAnimation:"webkitAnimationEnd",MozAnimation:"animationend",OAnimation:"oAnimationEnd",animation:"animationend"}}},j={csstransforms:function(){return!!e("transform")},csstransforms3d:function(){return!!e("perspective")},csstransitions:function(){return!!e("transition")},cssanimations:function(){return!!e("animation")}};j.csstransitions()&&(a.support.transition=new String(f("transition")),a.support.transition.end=i.transition.end[a.support.transition]),j.cssanimations()&&(a.support.animation=new String(f("animation")),a.support.animation.end=i.animation.end[a.support.animation]),j.csstransforms()&&(a.support.transform=new String(f("transform")),a.support.transform3d=j.csstransforms3d())}(window.Zepto||__webpack_provided_window_dot_jQuery,window,document);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/app": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			for(moduleId in moreModules) {
/******/ 				if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 					__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 				}
/******/ 			}
/******/ 			if(runtime) var result = runtime(__webpack_require__);
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/js/app.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], () => (__webpack_require__("./resources/sass/app.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
class SliderishItem {
    constructor(item, index, parentSection, bgElement, gap, offset, mobile) {
        this.htmlItem = item;
        this.width = this.htmlItem.getBoundingClientRect().width;
        this.height = this.htmlItem.getBoundingClientRect().height;
        this.color = this.htmlItem.dataset.color;
        this.index = index;
        this.htmlItem.dataset.index = this.index;
        this.gap = gap;
        this.parentSection = parentSection;
        this.bgElement = bgElement;
        this.offset = offset;
        this.mobile = mobile;

        this.htmlItem.addEventListener("click", () => this.clicked());

        window.addEventListener("resize", () => this.reposition());
        this.getIndex() === 0 && this.updateBgElement();

        this.visualLoad();
        this.reposition();
    }

    clicked() {
        if (this.getIndex() !== 0) {
            this.updateBgElement();

            this.parentSection.update(this.getIndex());
        }
    }

    updateBgElement() {
        if (
            this.htmlItem.hasAttribute("data-bg-mobile") ||
            this.htmlItem.hasAttribute("data-bg-desktop")
        ) {
            if (
                this.htmlItem.hasAttribute("data-bg-mobile") &&
                window.innerWidth < this.mobile
            ) {
                this.bgElement.style.backgroundImage = `url(${this.htmlItem.dataset.bgMobile})`;
            } else if (this.htmlItem.hasAttribute("data-bg-desktop")) {
                this.bgElement.style.backgroundImage = `url(${this.htmlItem.dataset.bgDesktop})`;
            }
        } else {
            this.bgElement.style.backgroundImage = "";
            this.bgElement.style.backgroundColor = this.color;
        }
    }

    reposition() {
        const left =
            window.innerWidth > this.mobile
                ? this.getIndex() * (this.getCalculatedWidth() + this.gap) +
                  this.offset
                : this.getIndex() * (this.getCalculatedWidth() + this.gap);

        if (this.getIndex() !== 0) {
            this.htmlItem.style.left = `${left}px`;
        } else {
            this.htmlItem.style.left = "0px";
            // garante o tempo de shift antes de travar a altura do elemento pai
            setTimeout(() => {
                this.setParentHeight(this.getCalculatedHieght());
            }, 300);
        }
    }

    getIndex() {
        return Number(this.index);
    }

    setIndex(newIndex) {
        this.index = newIndex;
        this.htmlItem.dataset.index = newIndex;
        this.reposition();
    }

    setParentHeight(newHeight) {
        this.htmlItem.parentElement.style.height = `${newHeight}px`;
        this.htmlItem.parentElement.style.position = "relative";
        this.htmlItem.parentElement.style.overflow = "hidden";
    }

    getParentHeight() {
        return Number(
            this.htmlItem.parentElement.getBoundingClientRect().height
        );
    }

    getColor() {
        return this.color;
    }

    getCalculatedHieght() {
        return Number(this.htmlItem.getBoundingClientRect().height);
    }

    getCalculatedWidth() {
        return Number(this.htmlItem.getBoundingClientRect().width);
    }

    visualLoad() {
        this.htmlItem.style.position = "absolute";
    }
}

export class Sliderish {
    constructor(query, settings) {
        this.query = query;
        this.slider = document.querySelector(query);
        this.sliderItems = [];
        this.gap = settings.gap;
        this.offset = settings.offset;
        this.mobile = settings.mobile;

        if (this.slider) {
            this.build();
        } else {
            console.error("Sliderish error: DOM element not found");
        }
    }

    build() {
        const bgElment = this.slider.querySelector(`${this.query}__bg`);
        const items = this.slider.querySelectorAll(`${this.query}__item`);

        if (items.length > 0) {
            items.forEach((el, i) => {
                const item = new SliderishItem(
                    el,
                    i,
                    this,
                    bgElment,
                    this.gap,
                    this.offset,
                    this.mobile
                );
                this.sliderItems.push(item);
            });
        } else {
            console.error("Sliderish error: DOM '__item' elements not found");
        }
    }

    update(targetIndex) {
        this.sliderItems.forEach((el) => {
            if (el.getIndex() === 0) {
                el.setIndex(this.sliderItems.length - 1);
            } else if (el.getIndex() > targetIndex) {
                el.setIndex(el.getIndex() - 1);
            } else if (el.getIndex() === targetIndex) {
                el.setIndex(0);
            }
        });
    }
}

class SliderishItem {
    constructor(item, index, gap, parentSection) {
        this.htmlItem = item;
        this.width = this.htmlItem.getBoundingClientRect().width;
        this.color = this.htmlItem.dataset.color;
        this.index = index;
        this.htmlItem.dataset.index = this.index;
        this.gap = gap;
        this.parentSection = parentSection;

        this.htmlItem.addEventListener("click", () => this.clicked());

        this.getIndex() === 0 && this.updateParentSection();

        this.visualLoad();
        this.reposition();
    }

    clicked() {
        if (this.getIndex() !== 0) {
            this.updateParentSection();

            this.parentSection.update(this.getIndex());
        }
    }

    updateParentSection() {
        if (this.htmlItem.hasAttribute("data-img-desktop")) {
            this.parentSection.setBackgroundImage(
                this.htmlItem.dataset.imgDesktop
            );
        } else {
            this.parentSection.setBackgroundImage("");
            this.parentSection.setBackgroundColor(this.color);
        }
    }

    reposition() {
        // Por regra, esses elementos têm largura igual
        if (this.getIndex() !== 0) {
            this.htmlItem.style.left = `${
                this.getIndex() * (this.width + this.gap)
            }px`;
        } else {
            this.htmlItem.style.left = "0px";
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
    }

    getColor() {
        return this.color;
    }

    getCalculatedHieght() {
        return Number(this.htmlItem.getBoundingClientRect().height);
    }

    visualLoad() {
        this.htmlItem.style.backgroundColor = this.color;
        this.htmlItem.style.position = "absolute";
    }
}

export class Sliderish {
    constructor(query) {
        this.query = query;
        this.slider = document.querySelector(query);
        this.sliderItems = [];
        this.gap = 32;

        if (this.slider) {
            this.build();
        } else {
            console.error("Sliderish error: DOM element not found");
        }
    }

    build() {
        let height = 0;
        const items = this.slider.querySelectorAll(`${this.query}__item`);
        if (items.length > 0) {
            items.forEach((el, i) => {
                const item = new SliderishItem(el, i, this.gap, this);
                this.sliderItems.push(item);
                if (item.getCalculatedHieght() > height) {
                    height = item.getCalculatedHieght();
                }
            });
            this.sliderItems[0].setParentHeight(height);
        } else {
            console.error("Sliderish error: DOM '__item' elements not found");
        }
    }

    setBackgroundColor(color) {
        this.slider.style.backgroundColor = color;
    }

    setBackgroundImage(imgDesktop, imgMobile) {
        this.slider.style.backgroundImage = `url(${imgDesktop})`;
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

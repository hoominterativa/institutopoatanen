import Splide from '@splidejs/splide';
import '@splidejs/splide/css';

const topi13Splide = new Splide( '.topi13__container', {
    pagination: false,
    arrows: true,
    autoWidth: true,
    updateOnMove: true,
    perMove: 1,
    perPage: 1
} )

// https://github.com/Splidejs/splide/discussions/498
// https://splidejs.com/guides/options/#updateonmove
// https://splidejs.com/guides/apis/#go

topi13Splide.on('click', (s, e) => {
    console.log(s.index);
    topi13Splide.go(s.index);
});

topi13Splide.mount();

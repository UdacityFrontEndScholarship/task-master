new WOW().init();
              //adding scrolling style
const ss = document.querySelectorAll('.scrollspy');
M.ScrollSpy.init(ss, {}); 

//mobile-navbar
const menu = document.querySelector('.sidenav');
M.Sidenav.init(menu, {});
//image slider
const slider = document.querySelector('.slider');
M.Slider.init(slider, {
  indicators: false,
  height: 500,
  transition: 500,
  interval: 6000
});


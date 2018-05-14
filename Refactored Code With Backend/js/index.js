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



$(window).resize(function(){
  if($(window).width()<500){
   $('.tr').removeClass('wc');
   $('.tp').removeClass('wi');
   $('.tp').addClass('wiw');
   $('#whytab').hide();

  }
 });

 $(window).resize(function(){
  if($(window).width()>500){
   $('.tp').removeClass('wiw');
   
   $('.tp').addClass('wi');
   $('.tr').addClass('wc');


  }
 });


 
 $(window).resize(function(){
  if($(window).width()==1024){
   $('.tp').removeClass('wiw');
   $('.tp').removeClass('wi');
   
   $('.tp').addClass('wiww');
   $('.tr').addClass('wc');


  }
 });
 
 $(".ba").click(function() {
  $('html,body').animate({
      scrollTop: $("#csd").offset().top},
      'slow');
});
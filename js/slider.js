const slides = ["img/bgimg1.jpg","img/bgimg2.jpg","img/bgimg3.jpg"]

const s = document.getElementById("imageslider");

var a = 0;
setInterval(function()
{
    s.style.backgroundImage = "url(" + slides[a] + ")";
    a++;
    if( a == slides.length)
    {
        a=0;
    }
},2000);






$("#slideshow > div:gt(0)").hide();

setInterval(function() { 
  $('#slideshow > div:first')
    .fadeOut(1000)
    .next()
    .fadeIn(1000)
    .end()
    .appendTo('#slideshow');
},  3000);
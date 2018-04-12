const slides = ["/blob/master/img/bgimg1.jpg","/blob/master/img/bgimg2.jpg","/blob/master/img/bgimg3.jpg"]

const s = document.getElementById("imageslider");

var a = 0;
setInterval(function()
{
    s.style.backgroundImage = "url(" + slides[a] + ")";
    console.log(s.style.backgroundImage);
    a++;
    if( a == slides.length)
    {
        a=0;
    }
},2000);
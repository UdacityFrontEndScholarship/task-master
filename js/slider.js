const slides = ["https://github.com/UdacityFrontEndScholarship/task-master/blob/master/img/bgImg1.jpg","https://github.com/UdacityFrontEndScholarship/task-master/blob/master/img/bgImg2.jpg","https://github.com/UdacityFrontEndScholarship/task-master/blob/master/img/bgImg3.jpg"]

const s = document.getElementById("imageslider");

var a = 0;
setInterval(function()
{
    s.style.background = "url(" + slides[a] + ")";
    console.log(s.style.background);
    a++;
    if( a == slides.length)
    {
        a=0;
    }
},2000);
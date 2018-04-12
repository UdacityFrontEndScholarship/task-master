const slides = ["https://raw.githubusercontent.com/UdacityFrontEndScholarship/task-master/master/img/bgImg1.jpg","https://raw.githubusercontent.com/UdacityFrontEndScholarship/task-master/master/img/bgImg2.jpg","https://raw.githubusercontent.com/UdacityFrontEndScholarship/task-master/master/img/bgImg1.jpg"]

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
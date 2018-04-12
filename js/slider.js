const slides = ["https://github.com/UdacityFrontEndScholarship/task-master/blob/master/img/bgImg1.jpg","https://github.com/UdacityFrontEndScholarship/task-master/blob/master/img/bgImg1.jpg","https://github.com/UdacityFrontEndScholarship/task-master/blob/master/img/bgImg1.jpg"]

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

$("#slideshow > div:gt(0)").hide();

setInterval(function() { 
  $('#slideshow > div:first')
    .fadeOut(1000)
    .next()
    .fadeIn(1000)
    .end()
    .appendTo('#slideshow');
},  3000);


function loader()
{
    document.getElementById("loader").style.display = "none";
    $("body").removeClass("blur");
    $('#remove').hide();
}

$(".sc").click(function() {
    $('html,body').animate({
        scrollTop: $("#intro").offset().top},
        1000);
});

$("#play").click(function () {
    $("#vid").append('<div id="new"><div><iframe id="if" src="https://player.vimeo.com/video/266736894"></iframe></div></div>');
    $('#play').hide();
    $('#remove').show();
  });

  $("#remove").on("click", function(event) {
    $("#new").remove();
    $('#play').show();
    $('#remove').hide();
    event.preventDefault();
});


$(".closeb").click(function() {
    $('.nf').fadeOut();
  });
  
  $(".closebb").click(function() {
    $('.nf').fadeOut();
  });
  
  $(".mf").click(function() {
    $('.nf').fadeIn();
  });
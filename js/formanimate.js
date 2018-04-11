$("#c").hover(
    function() {
      $(this).html("&#8594;");
      $(this).css("background-color", "black");
    },
    function() {
      $(this).html("Submit");
      $(this).css("background-color", "white");
    }
  );

// al hacer scroll el nav se pone transparente
$(document).ready(function() {
	$(window).scroll(function() {
  	if($(document).scrollTop() > 10) {
      $('#nav').addClass('shrink');
      $('#img-logo').css("width", "27%");
      $('#img-logo').css("height", "27%");
    }
    else {
      $('#nav').removeClass('shrink');
      $('#img-logo').css("width", "30%");
      $('#img-logo').css("height", "30%");
    }
  });
});

//Obtener Heigh dinamico del cliente y aplicar un min-height al body

$(document).ready(resize());
window.onresize = resize;

function resize() {
  console.log(window.innerHeight-70+"px");
  $("body").css({
    "min-height": window.innerHeight-70+"px"
  });
  $("#cuerpo").css({
    "min-height": window.innerHeight-200+"px"
  });
  $("#login").css({
    "margin-top": window.innerHeight/4+"px"
  });
} 


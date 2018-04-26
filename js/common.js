
function changeTab(obj) {
		var newId = obj.getAttribute("data-val");
		$('.selected').removeClass('selected');
		$('#'+newId).addClass('selected');
		$('a').removeClass('selected_link');
		$(obj).addClass('selected_link');
}

$(document).ready(function(){
      console.log("ready");
   $('#login').click(function() {
   		$('.body_overlay').fadeIn();
   		$('#login_modal').fadeIn();
   });
   $('.body_overlay').click(function() {
   		$('.body_overlay, #login_modal').fadeOut();
   });

   $(window).on('scroll', function(obj){
   		if($(this).scrollTop() > 215){
   			$(".navbar").css("position","fixed");
   			$(".navbar").css("top","0px");
   			$(".navbar").css("z-index","999");
   		}
   		else{
   			$(".navbar").css("position","static");
   		}
   });

});

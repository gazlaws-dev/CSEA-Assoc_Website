<?php include 'header.php' ?>

		<div class="header">
				<div class="header_top">
						<div class="main_logo"></div>
						<div class="banner"></div>
				</div>
				<nav class="navbar">
						<ul>
								<a href="index.php"><li>Home</li></a>
								<a href="about.php"><li>About Us</li></a>
								<a href="people.php"><li>Members</li></a>
								<a href="activities.php"><li>Activities</li></a>
								<a href="loopback.php"><li>Loopback</li></a>
								<a href="gallery.php"><li class="active">Gallery</li></a>
								<a href="contact.php"><li>Contact Us</li></a>
						</ul>
				</nav>
		</div>

		<div class="main_unified">
				<div class="main_content">
					<section class="cd-single-item" >
						<div class="cd-slider-wrapper">
							<div class="flexslider" id="main_flexslider" >
								<ul class="slides" id="fireslides">
									<li>
										<div class="slider_div" style="background-image: url(img/rm.png);"></div>
									</li>
								</ul>
							</div>
						</div>
						<div class="cd-item-info "><h2>Erri phulku</h2><p>Hi this is karthik.</p>
							<a href="'+drivelink+'" target="_blank"><button class="add-to-cart">More Images</button></a>
						</div>
					</section>
				</div>
		</div>

<?php include 'footer.php' ?>
		<div id="imagemodal">
			<span class="close_imagemodal">x</span>
			<div class="modal-content" id="imagepreview"></div>
		</div>

</body>
<script>
var el = document.getElementById('site_credits');
el.onclick = showcredits;
function showcredits() {
			$("#slide_up").removeClass("fadeout").addClass("fadein");
	return false;
}
var elc = document.getElementById('close_slide');
elc.onclick = closecredits;
function closecredits() {
	$("#slide_up").removeClass("fadein").addClass("fadeout");
	return false;
}
		$(window).load(function() {

				$('.picbox').on('click', function() {
					$('#imagepreview').css("background-image", "url("+ $(this).attr('src') +")");
					$('#imagemodal').css("display","block");
				});

				$('.close_imagemodal').on('click', function() {
					$('#imagemodal').css("display","none");
				});

		});
jQuery(document).ready(function(){

	$('#main_flexslider').flexslider({
		animation: "slide",
    slideshowSpeed: 7000
	});




		function comparedates(a,b){
			if(Number(a.date.year)>Number(b.date.year))
				return 1;
			else if(Number(a.date.year)<Number(b.date.year))
				return -1;
			else{
			if(Number(a.date.month)>Number(b.date.month))
				return 1;
			else if(Number(a.date.month)<Number(b.date.month))
				return -1;
				else{
					if(Number(a.date.day)>Number(b.date.day))
					return 1;
					else {
						return -1;
					}
				}
			}
		}
		var curyear,lastyear;
		var galdb=myFireBase.child("gallery");
		galdb.orderByKey().limitToLast(2).on("child_added",function(snapshot){
			var galval=snapshot.val();
			var year=snapshot.key;
			console.log(galval);
			var obj;
      var year=snapshot.key;
      obj = Object.values(galval);
      obj.sort(comparedates);
			console.log("outer");
			console.log(obj);
					for(var iter in obj){
						(function(cntr){
							console.log(iter);
							var imgjson=obj[iter].img;
							var drivelink=obj[iter].drive_link;
							var short=obj[iter].short_desc;
							var title=obj[iter].title;
							var day=obj[iter].date.day;
							var month=obj[iter].date.month;
							var year=obj[iter].date.year;
							var targetgal="gal_cur"+year+iter;
							var itemtargal="gal_cur_item"+year+iter;
							$('.main_content').prepend('<section class="cd-single-item" ><div class="cd-slider-wrapper"><div class="flexslider" id="'+targetgal+'" ><ul class="slides" id="fireslides"><li><div class="slider_div" style="background-image: url(img/rm.png);"></div></li></ul></div></div><div class="cd-item-info '+itemtargal+' "><h2>'+title+'</h2><p>'+short+'</p></div></section>');
							if(drivelink!="")
							$('.'+itemtargal).append('<a href="'+drivelink+'" target="_blank"><button class="add-to-cart">More Images</button></a>');
							var tar='#'+targetgal;
							console.log("tar ",tar);
							$( tar ).bind( "click", function( event ) {
								$(tar).flexslider({
									animation: "slide",
									slideshowSpeed: 7000
								});	
							} );

							var noofimg=Object.keys(imgjson).length;
							console.log("noofimg "+noofimg);
	/*						for(var iter_inner in imgjson){
								(function(inner_cntr){
									storageRef.child(imgjson[inner_cntr]).getDownloadURL().then(function(url) {
										var xhr = new XMLHttpRequest();
										xhr.responseType = 'blob';
										xhr.onload = function(event) {
											var blob = xhr.response;
										};
										xhr.open('GET', url);
										xhr.send();
										var imgurl=url;
										console.log(url);
										console.log(inner_cntr);
										console.log(imgurl);
										var target='#'+targetgal;
										var div='<li><div class="slider_div" style="background-image: url('+url+');"></div></li>';
										$(target).data('flexslider').addSlide($(div));
										}).catch(function(error) {
										console.log("image not fetched");
									});
								})(iter_inner);
							}

*/
						})(iter);
					}
		});

		var ps = document.getElementsByClassName('slider_div');

		for(var i = 0; i < ps.length; i++){
  		ps[i].addEventListener('click', enlarge, false);
		}
		document.body.addEventListener('click', enlarge, false);
		function enlarge(e){
			//enlarge slider images
			console.log('enlarge');
			var targetclass=$(this).parent().parent().parent().parent().attr('id');
			var target=$(this).parent().parent().parent().parent().hasClass('enlarged');
			var close_toggle=$(this).parent().parent().parent().parent().next().attr('id');
			targetclass='#'+targetclass;
			close_toggle='#'+close_toggle;
			 if(targetclass!='#') {
				 if(!target){
					 	var slider1 = $(targetclass).data('flexslider');
 						$(targetclass).height(600);
 						$(targetclass).width(1000);
						$(targetclass).addClass('enlarged');
						$(close_toggle).addClass('change_visibility');
 						slider1.resize();
					}
					else{
						var slider1 = $(targetclass).data('flexslider');
 						$(targetclass).height(350);
 						$(targetclass).width(500);
						$(targetclass).removeClass('enlarged');
 						slider1.resize();
					}

			}

		}
/*		var ps2 = document.getElementsByClassName('cd-close');

		for(var i = 0; i < ps.length; i++){
  		ps[i].addEventListener('click', diminish, false);
		}
		document.body.addEventListener('click', diminish, false);
		function diminish(e){
			//diminish slider images
			console.log('dimnish');
			var targetclass=$(this).parent().first().hasClass('enlarged');
			console.log(targetclass);
			var close_toggle=$(this).parent().parent().parent().parent().next().attr('id');
			console.log(close_toggle);
			targetclass='#'+targetclass;
			close_toggle='#'+close_toggle;
			console.log(class_toggle);
			console.log(targetclass);
			 if(targetclass!='#') {
				 if(!target){
					 	var slider1 = $(targetclass).data('flexslider');
 						$(targetclass).height(600);
 						$(targetclass).width(1000);
						$(targetclass).addClass('enlarged');
						$(class_toggle).addClass('change_visibility');
 						slider1.resize();
					}
					else{
						var slider1 = $(targetclass).data('flexslider');
 						$(targetclass).height(350);
 						$(targetclass).width(500);
						$(targetclass).removeClass('enlarged');
 						slider1.resize();
					}

			}

		}
*/
});
</script>

</html>

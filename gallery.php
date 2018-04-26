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

		<div class="preloader">
  			<div class="three-balls">
    			<div class="ball ball1"></div>
    			<div class="ball ball2"></div>
    			<div class="ball ball3"></div>
  		</div>
		</div>
		<div class="main_unified invisible" >
				<div class="main_content">

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
	setTimeout(function() {
		waiting();
	}, 10000);
			setTimeout(function() {
				closepreloader();
			}, 15000);
function createSliderPagination($container){
	//console.log("entered");
	var wrapper = $('<ul class="cd-slider-pagination"></ul>').insertAfter($container.find('.cd-slider-navigation'));
	$container.find('.cd-slider li').each(function(index){
		var dotWrapper = (index == 0) ? $('<li class="selected"></li>') : $('<li></li>'),
			dot = $('<a href="#0"></a>').appendTo(dotWrapper);
		dotWrapper.appendTo(wrapper);
		dot.text(index+1);
	});
	return wrapper.children('li');
}

function nextSlide($container, $pagination, $n){
	var visibleSlide = $container.find('.cd-slider .selected'),
		navigationDot = $container.find('.cd-slider-pagination .selected');
	if(typeof $n === 'undefined') $n = visibleSlide.index() + 1;
	visibleSlide.removeClass('selected');
	$container.find('.cd-slider li').eq($n).addClass('selected').prevAll().addClass('move-left');
	navigationDot.removeClass('selected')
	$pagination.eq($n).addClass('selected');
	updateNavigation($container, $container.find('.cd-slider li').eq($n));
}

function prevSlide($container, $pagination, $n){
	var visibleSlide = $container.find('.cd-slider .selected'),
		navigationDot = $container.find('.cd-slider-pagination .selected');
	if(typeof $n === 'undefined') $n = visibleSlide.index() - 1;
	visibleSlide.removeClass('selected')
	$container.find('.cd-slider li').eq($n).addClass('selected').removeClass('move-left').nextAll().removeClass('move-left');
	navigationDot.removeClass('selected');
	$pagination.eq($n).addClass('selected');
	updateNavigation($container, $container.find('.cd-slider li').eq($n));
}

function updateNavigation($container, $active) {
	$container.find('.cd-prev').toggleClass('inactive', $active.is(':first-child'));
	$container.find('.cd-next').toggleClass('inactive', $active.is(':last-child'));
}

function enableSwipe($container) {
	var mq = window.getComputedStyle(document.querySelector('.cd-slider'), '::before').getPropertyValue('content').replace(/"/g, "").replace(/'/g, "");
	return ( mq=='mobile' || $container.hasClass('cd-slider-active'));
}

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
			//console.log(galval);
			var obj;
      var year=snapshot.key;
      obj = Object.values(galval);
      obj.sort(comparedates);
			//console.log("outer");
			//console.log(obj);
					for(var iter in obj){
						(function(cntr){
							//console.log(iter);
							var imgjson=obj[iter].img;
							var drivelink=obj[iter].drive_link;
							var short=obj[iter].short_desc;
							var title=obj[iter].title;
							var day=obj[iter].date.day;
							var month=obj[iter].date.month;
							var year=obj[iter].date.year;
							var targetgal="gal_cur"+year+iter;
							var itemtargal="gal_cur_item"+year+iter;
							$('.main_content').prepend('<section class="cd-single-item "><div class="cd-slider-wrapper"><ul class="cd-slider '+targetgal+'"></ul><ul class="cd-slider-navigation nostyle"><li><a href="#0" class="cd-prev inactive">Next</a></li><li><a href="#0" class="cd-next">Prev</a></li></ul><a href="#0" class="cd-close">Close</a></div><div class="cd-item-info '+itemtargal+'"><h2>'+title+'</h2><p>'+short+'</p></div></section>');
							if(drivelink!="")
								$('.'+itemtargal).append('<a href="'+drivelink+'" target="_blank"><button class="add-to-cart">More Images</button></a>');
							var noofimg=Object.keys(imgjson).length;
							//console.log("noofimg "+noofimg);
							for(var iter_inner in imgjson){
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
										//console.log(url);
										//console.log(inner_cntr);
										//console.log(imgurl);
										var target='.'+targetgal;
												if(inner_cntr==1)
													$(target).prepend('<li class="selected '+targetgal+'-selected"><img src="'+imgurl+'" alt="Image"></li>')
												else {
														addsecondimg(imgurl,target);
												}
										}).catch(function(error) {
										console.log("image not fetched");
									});
								})(iter_inner);
							}


						})(iter);
					}
		});
		function addsecondimg(imgurlfunc,targetfunc){
			//console.log("adding");
			$(targetfunc).prepend('<li><img src="'+imgurlfunc+'" alt="Image"></li>');
		}
		function closepreloader(){
			$(".preloader").addClass("invisible");
			$(".main_unified").removeClass("invisible");
		}
		function waiting() {
			var itemInfoWrapper = $('.cd-single-item');
			//console.log('item info wrapper');
			//console.log(itemInfoWrapper);
			itemInfoWrapper.each(function(){
				var container = $(this),
					// create slider pagination
					sliderPagination = createSliderPagination(container);
					//console.log("galleryjs");
					//console.log(container);
				//update slider navigation visibility
				updateNavigation(container, container.find('.cd-slider li').eq(0));

				container.find('.cd-slider').on('click', function(event){
					//enlarge slider images
					//console.log('enlarge');
					if( !container.hasClass('cd-slider-active') && $(event.target).is('.cd-slider')) {
						itemInfoWrapper.removeClass('cd-slider-active');
						container.addClass('cd-slider-active').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
							$('body,html').animate({'scrollTop':container.offset().top}, 200);
						});
					}
				});

				container.find('.cd-close').on('click', function(){
					//shrink slider images
					container.removeClass('cd-slider-active');
				});

				//update visible slide
				container.find('.cd-next').on('click', function(){
					nextSlide(container, sliderPagination);
				});

				container.find('.cd-prev').on('click', function(){
					prevSlide(container, sliderPagination);
				});

				container.find('.cd-slider').on('swipeleft', function(){
					var wrapper = $(this),
						bool = enableSwipe(container);
					if(!wrapper.find('.selected').is(':last-child') && bool) {nextSlide(container, sliderPagination);}
				});

				container.find('.cd-slider').on('swiperight', function(){
					var wrapper = $(this),
						bool = enableSwipe(container);
					if(!wrapper.find('.selected').is(':first-child') && bool) {prevSlide(container, sliderPagination);}
				});

				sliderPagination.on('click', function(){
					var selectedDot = $(this);
					if(!selectedDot.hasClass('selected')) {
						var selectedPosition = selectedDot.index(),
							activePosition = container.find('.cd-slider .selected').index();
						if( activePosition < selectedPosition) {
							nextSlide(container, sliderPagination, selectedPosition);
						} else {
							prevSlide(container, sliderPagination, selectedPosition);
						}
					}
				});
			});

			//keyboard slider navigation
			$(document).keyup(function(event){
				if(event.which=='37' && $('.cd-slider-active').length > 0 && !$('.cd-slider-active .cd-slider .selected').is(':first-child')) {
					prevSlide($('.cd-slider-active'), $('.cd-slider-active').find('.cd-slider-pagination li'));
				} else if( event.which=='39' && $('.cd-slider-active').length && !$('.cd-slider-active .cd-slider .selected').is(':last-child')) {
					nextSlide($('.cd-slider-active'), $('.cd-slider-active').find('.cd-slider-pagination li'));
				} else if(event.which=='27') {
					itemInfoWrapper.removeClass('cd-slider-active');
				}
			});

		}
});
</script>

</html>

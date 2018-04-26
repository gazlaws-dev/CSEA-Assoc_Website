<?php
  include 'header.php';
?>
<div id="imagemodal">
  <span class="close_imagemodal">x</span>
  <div class="modal-content" id="imagepreview"></div>
</div>

		<div class="header">
				<div class="header_top">
						<div class="main_logo"></div>
						<div class="banner"></div>
				</div>
				<nav class="navbar">
						<ul>
								<a href="index.php"><li class="active">Home</li></a>
								<a href="about.php"><li>About Us</li></a>
								<a href="people.php"><li>Members</li></a>
								<a href="activities.php"><li>Activities</li></a>
								<a href="loopback.php"><li>Loopback</li></a>
								<a href="gallery.php"><li>Gallery</li></a>
								<a href="contact.php"><li>Contact Us</li></a>
						</ul>
				</nav>
		</div>

		<div class=" image_slider " >
		    <div class="flexslider" id="main_flexslider" >
		      <ul class="slides" id="fireslides">
		        <li>
		          <div style="background-image: url(img/rm.png);"></div>
		        </li>
		      </ul>
		    </div>

		    <div class="slider_scoop"></div>
		</div>


		<div class="main_content">
				<div class="left">
						<div class="left_right_header">Upcoming Events</div>
						<div class="left_slider">
              <ul class="slides" >
              <li id="upcoming_dynamic">
              </li>
            </ul>
								</div>
						</div>

				<div class="middle">
						<div class="middle_slider">
								<div class="flexslider" id="middle_flexslider">
								  <ul class="slides" >
								  	<li>
								  	</li>
								  </ul>
								</div>
						</div>
				</div>

				<div class="right">
				</div>
		</div>

		<?php
		  include 'footer.php'
		?>

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
  setTimeout(function() {
		waiting();
	}, 15000);

  $('.picbox').on('click', function() {
    //console.log("hello checking");
    $('#imagepreview').css("background-image", "url("+ $(this).attr('src') +")");
    $('#imagemodal').css("display","block");
  });

  $('.close_imagemodal').on('click', function() {
    $('#imagemodal').css("display","none");
  });
  $(document).on('click','.picbox',function(e){
    $('#imagepreview').css("background-image", "url("+ $(e.target).attr('src') +")");
    $('#imagemodal').css("display","block");
  });
	$('#main_flexslider').flexslider({
		animation: "slide",
    slideshowSpeed: 10000
	});

	$('#middle_flexslider').flexslider({
		animation: "slide",
		animationLoop: true,
		minItems: 2,
		maxItems: 2,
		itemWidth: 200,
		itemMargin: 10,
	});

	$('#right_flexslider').flexslider({
		animation: "slide",
		animationLoop: true,
		minItems: 1,
		maxItems: 1,
		itemMargin: 10,
		itemWidth: 300,
	});

});

function waiting(){
  $('#main_flexslider').data('flexslider').removeSlide(0);
}
function compare_ind_dates(a,b){
  if(Number(a.year)>Number(b.year))
    return -1;
  else if(Number(a.year)<Number(b.year))
    return 1;
  else{
  if(Number(a.month)>Number(b.month))
    return -1;
  else if(Number(a.month)<Number(b.month))
    return 1;
    else{
      if(Number(a.day)>Number(b.day))
      return -1;
      else {
        return 1;
      }
    }
  }
}

function comparedates(a,b){
  if(Number(a.date.year)>Number(b.date.year))
    return -1;
  else if(Number(a.date.year)<Number(b.date.year))
    return 1;
  else{
  if(Number(a.date.month)>Number(b.date.month))
    return -1;
  else if(Number(a.date.month)<Number(b.date.month))
    return 1;
    else{
      if(Number(a.date.day)>Number(b.date.day))
      return -1;
      else {
        return 1;
      }
    }
  }
}

		var slides=myFireBase.child('home').child("slider");
    slides.once("value").then(function(snapshot){
      var slidesval=snapshot.val();
      for(var iter in slidesval){
        (function(cntr){
          var urljson=slidesval[cntr];
          storageRef.child(urljson).getDownloadURL().then(function(url) {
            var xhr = new XMLHttpRequest();
            xhr.responseType = 'blob';
            xhr.onload = function(event) {
              var blob = xhr.response;
            };
            xhr.open('GET', url);
            xhr.send();
            var imgurl=url;
            div = '<li><div style="background-image: url('+imgurl+');"></div></li>';
            $('#main_flexslider').data('flexslider').addSlide($(div));
          }).catch(function(error) {
            console.log("image not loaded");
              div = '<li><div style="background-image: url(failed.png);"></div></li>';
             $('#main_flexslider').data('flexslider').addSlide($(div));
          });
        })(iter);
       }
    });

    var middle=myFireBase.child('home').child("center_pane");
    middle.once("value").then(function(snapshot){
      var middleval=snapshot.val();
      $(".middle").prepend(middleval);
    });
    var right=myFireBase.child('home').child("right_pane");
    right.once("value").then(function(snapshot){
      var rightval=snapshot.val();
      $(".right").append(rightval);
    });
    var notice=myFireBase.child("notice_box");
    notice.once("value").then(function(snapshot){
      var noticeval=snapshot.val();
      $(".right").prepend(noticeval);
    });

    var actdb=myFireBase.child("activities");
    actdb.orderByKey().limitToLast(1).on("child_added",function(snapshot){
      var actval=snapshot.val();
//      var noofyears=Object.keys(actval).length;
      var obj;
      var year=snapshot.key;
      obj = Object.values(actval);
      obj.sort(comparedates);
          for(var iter in obj){
            (function(cntr){
              var imgd=obj[iter].img;
              var short=obj[iter].short_desc;
              var title=obj[iter].title;
              if(cntr<6){
              storageRef.child(imgd).getDownloadURL().then(function(url) {
                var xhr = new XMLHttpRequest();
                xhr.responseType = 'blob';
                xhr.onload = function(event) {
                  var blob = xhr.response;
                };
                xhr.open('GET', url);
                xhr.send();
                var imgurl=url;
                var div='<li><img class="picbox" src="'+imgurl+'" /><p class="flex-caption"><span style="font-weight:bold;font-size:18px;padding-bottom:3px;">'+title+'</span><br><span style="font-weight:300"> '+short+'</span></p></li>'
                $('#middle_flexslider').data('flexslider').addSlide($(div));
              }).catch(function(error) {
                console.log("image not fetched");
                div = '<li><div class="picbox" style="background-image: url(failed.png);"></div></li>';
               $('#middle_flexslider').data('flexslider').addSlide($(div));
              });
            }
            })(iter);
          }
    });


    var updb=myFireBase.child("home").child('upcoming');
    updb.orderByKey().limitToLast(1).on("child_added",function(snapshot){
      var upval=snapshot.val();
//      var noofyears=Object.keys(actval).length;
      var obj;
      var year=snapshot.key;
      obj = Object.values(upval);
      obj.sort(comparedates);
          for(var iter in obj){
            (function(cntr){
              var date=obj[iter].date;
              var short=obj[iter].short_desc;
              //console.log("date");
              //console.log(date);
              var title=obj[iter].title;
              var monthnames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
              var pdate=new Date();
              //console.log("date "+pdate.getDate());
              var curdate={
                day: pdate.getDate(),
                month:pdate.getMonth()+1,
                year:pdate.getFullYear()
              };

              if(compare_ind_dates(date,curdate)==-1&&cntr<5){
                $('#upcoming_dynamic').prepend('<div class="event_holder"><div class="date">'+date.day+' '+monthnames[Number(date.month)-1]+'</div><div class="event_side_header"><h4 style="margin-top:10px;margin-bottom:5px;">'+title+'</h4>'+short+'</div></div>');
            }
            })(iter);
          }
    });
</script>

</html>

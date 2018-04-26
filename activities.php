<?php
  include 'header.php'
?>

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
								<a href="activities.php"><li class="active">Activities</li></a>
								<a href="loopback.php"><li>Loopback</li></a>
								<a href="gallery.php"><li>Gallery</li></a>
								<a href="contact.php"><li>Contact Us</li></a>
						</ul>
				</nav>
		</div>
    <div id="imagemodal">
      <span class="close_imagemodal">x</span>
      <div class="modal-content" id="imagepreview"></div>
    </div>
		<div class="main_unified">
				<div class="main_content">
					<div class="main_bg_container">
					</div>
					<div class="main_left_container">
						<ul>
							<!--<li><a data-val="activities" onclick="changeTab(this)" class="selected_link">Activities</a></li>-->
							<li><a data-val="courses" onclick="changeTab(this)" class="selected_link">Courses/Workshops</a></li>
							<li><a data-val="talks" onclick="changeTab(this)">Talks</a></li>
							<li><a data-val="others" onclick="changeTab(this)">Other Activities</a></li>
						</ul>
					</div>
						<div class="main_middle_container_full">

								<div id="courses" class="holder selected">
										<div class="middle_header">Courses and Workshops</div>
										<div class="content_holder">
												<ul id="courses_ul" class="dynamic_jq">
												</ul>
                        <a href="all_activities.php"><button class="more_button">All Activities</button></a>
										</div>
								</div>

								<div id="talks" class="holder">
										<div class="middle_header">Talks</div>
										<div class="content_holder">
												<ul id="talks_ul" class="dynamic_jq">
												</ul>
										</div>
								</div>

								<div id="others" class="holder">
										<div class="middle_header">Other Activities</div>
										<div class="content_holder" >
												<ul id="others_ul" class="dynamic_jq">
												</ul>
										</div>
								</div>

						</div>
				</div>
		</div>
    <div id="end_target" class="dynamic_jq"></div>


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

      $('.close_imagemodal').on('click', function() {
        $('#imagemodal').css("display","none");
      });
      $(document).on('click','.picbox',function(e){
        $('#imagepreview').css("background-image", "url("+ $(e.target).attr('src') +")");
        $('#imagemodal').css("display","block");
      });
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

    var actdb=myFireBase.child("activities");
    actdb.orderByKey().limitToLast(2).on("child_added",function(snapshot){
      var actval=snapshot.val();
      //console.log(actval);
//      var noofyears=Object.keys(actval).length;
      var obj;
      var year=snapshot.key;
      obj = Object.values(actval);
      obj.sort(comparedates);
      //console.log("outer");
      //console.log(obj);
          for(var iter in obj){
            (function(cntr){
              var category=obj[iter].category;
              var imgd=obj[iter].img;
              //console.log(imgd);
              var long=obj[iter].long_desc;
              var short=obj[iter].short_desc;
              var title=obj[iter].title;
              var day=obj[iter].date.day;
              var month=obj[iter].date.month;
              var year=obj[iter].date.year;
              var targetact="act_cur"+year+iter;
              var imagetargetact="act_cur_img"+year+iter;
              if(category=="talk"){
                $('#talks_ul').prepend('<a href="#0" class="'+targetact+'"><li ><div class="act_info '+imagetargetact+'"><div class="project-info"><h2>'+title+'</h2><p>'+short+'</p></div></div></li></a>');
              }
              else if(category=="others"){
                $('#others_ul').prepend('<a href="#0" class="'+targetact+'"><li ><div class="act_info '+imagetargetact+'"><div class="project-info"><h2>'+title+'</h2><p>'+short+'</p></div></div></li></a>');
              }
              else if(category=="workshop"){
                $('#courses_ul').prepend('<a href="#0" class="'+targetact+'"><li ><div class="act_info '+imagetargetact+'"><div class="project-info"><h2>'+title+'</h2><p>'+short+'</p></div></div></li></a>');
              }
              else{
                //$('#competitions_ul').prepend('<a href="#0" class="'+targetact+'"><li ><div class="act_info '+imagetargetact+'"><div class="project-info"><h2>'+title+'</h2><p>'+short+'</p></div></div></li></a>');
              }

              storageRef.child(imgd).getDownloadURL().then(function(url) {
                var xhr = new XMLHttpRequest();
                xhr.responseType = 'blob';
                xhr.onload = function(event) {
                  var blob = xhr.response;
                };
                xhr.open('GET', url);
                xhr.send();
                var imgurl=url;
                $('.'+imagetargetact).prepend('<div class="imagebox_article" style="background-image:url('+imgurl+')">');
                $('#end_target').append('    <div class="modal_content modal_'+targetact+'"><div><div class="mod_img"><img class="picbox" src="'+imgurl+'"/></div><h2>'+title+'</h2><em>Date: '+day+'-'+month+'-'+year+'</em><p >'+long+'</p></div><a href="#0" class="close cd-img-replace" ></a></div>');
              }).catch(function(error) {
                console.log("image not fetched");
              });
            })(iter);
          }
    });
    jQuery(document).ready(function(){
      var targetclass;
      //console.log("yeah");
      $(".dynamic_jq").on('click','a',function(event){
        var classoftriggered = $(this).attr('class');
        //console.log(classoftriggered);
        targetclass='.modal_'+classoftriggered;
        $(targetclass).addClass('modal_active');
        //console.log(targetclass);
        });


        $('#end_target').on('click','a.close',function(){
          //console.log(this);
          //console.log($(this).parent());
          $(this).parent().removeClass('modal_active');
        })

    });

</script>

</html>

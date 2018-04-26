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
								<a href="about.php"><li class="active">About Us</li></a>
								<a href="people.php"><li>Members</li></a>
								<a href="activities.php"><li>Activities</li></a>
								<a href="loopback.php"><li>Loopback</li></a>
								<a href="gallery.php"><li>Gallery</li></a>
								<a href="contact.php"><li>Contact Us</li></a>
						</ul>
				</nav>
		</div>

		<div class="main_unified">
				<div class="main_content">
						<div class="main_bg_container">
						</div>
					<div class="main_left_container">
						<ul>
							<li><a data-val="about" onclick="changeTab(this)" class="selected_link">About CSEA</a></li>
							<li><a data-val="vision" onclick="changeTab(this)">Vision and Mission</a></li>
							<li><a data-val="work" onclick="changeTab(this)">How we work</a></li>
							<li><a data-val="join" onclick="changeTab(this)">Join Us</a></li>
						</ul>
					</div>

					<div class="main_right_container">
					</div>
						<div class="main_middle_container">

								<div id="about" class="holder selected">
	                  <div class="middle_header">About CSEA</div>
	                  <div class="content_holder" id="abouthtml">

	                  </div>
	              </div>

	              <div id="vision" class="holder">
	                  <div class="middle_header">Vision and Mission</div>
	                  <div class="content_holder" id="visionhtml">

	                  </div>
	              </div>

	              <div id="work" class="holder">
	                  <div class="middle_header">How we Work</div>
	                  <div class="content_holder" id="workhtml">

	                 </div>
	              </div>

	              <div id="join" class="holder">
	                  <div class="middle_header">Join Us</div>
	                  <div class="content_holder" id="joinhtml">

	                  </div>
	              </div>
						</div>
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
	});
	var aboutdb=myFireBase.child("about");
	aboutdb.once("value").then(function(snapshot){
		var aboutval=snapshot.val();
		//console.log(aboutval);
		for(var iter in aboutval){
			(function(cntr){
				var htmlcode=aboutval[cntr];
				//console.log(cntr);
				if(cntr=="about")
					$("#abouthtml").append(htmlcode);
				else if(cntr=="how")
					$("#workhtml").append(htmlcode);
				else if(cntr=="join_us")
					$("#joinhtml").append(htmlcode);
				else if(cntr=="vision")
					$("#visionhtml").append(htmlcode);
			})(iter);
		}
	});
  var notice=myFireBase.child("notice_box");
  notice.once("value").then(function(snapshot){
    var noticeval=snapshot.val();
    $(".main_right_container").prepend(noticeval);
  });

</script>

</html>

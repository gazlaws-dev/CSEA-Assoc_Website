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
						<a href="activities.php"><li >Activities</li></a>
						<a href="loopback.php"><li class="active">Loopback</li></a>
						<a href="gallery.php"><li>Gallery</li></a>
						<a href="contact.php"><li>Contact Us</li></a>
				</ul>
		</nav>
</div>

		<div class="main_unified">
				<div class="main_content">
					<div class="main_right_container ">
					</div>
						<div class="main_middle_container loopback">
								<div class="middle_header" style="margin-left:30px;">Loopback</div>
							<ul>

							It is true that we all live oblivious to the beauty that
surrounds us, and by the time we do realise what exactly it is that
we've been blessed with, it's generally too late. The good old days call
out to you yet again to walk down the memory lane, to let you relive
the carefree days of your college lives and to visit all the places you
once frequented. Loopback, organized by the Department of Computer
Science and Engineering, NIT Calicut, brings to our alumni a chance to
reconnect with their Alma Mater. This reunion of the students of the CSE
Department is open to all but is especially focused on the 10 year old
batch of CSE.
							<br><br>
							Loopback '17, the first of its kind, was a combined effort
of the students and faculty members of the department and had turned out
to be a huge success. The day turned out to be a very memorable one for
the alumni, faculty and the students involved. It included a lot of fun
activities including a treasure hunt and a volleyball game. Here's a
glimpse of everything that had happened.
							<br><br>
							<iframe src="CSEA%20-%20Activities_files/video.html" style="border:none;overflow:hidden" scrolling="no" allowtransparency="true" allowfullscreen="true" height="315" width="560" frameborder="0"></iframe>
							<br><br>
							Now comes the next edition, Loopback '18, for the batch of
2008. An amazing fun filled day awaits you where you will relive college
memories and ignite those strong friendships built during your time at
NITC. Bring your family too and make it an even more memorable
get-together!!

<br><br>
<h2><a href="https://docs.google.com/forms/d/e/1FAIpQLSebFsOPdG92D6UX6JuxyKWDtMaWgqea9uanCF1iaq_6wShJlA/viewform?usp=sf_link" target="_blank">Loopback '18 Registration </a></h2>
<br>

<h3> Contact info: </h3>

1. Mail us at loopback@nitc.ac.in<br>
<br>
2. Loopback '18 coordinators: <br><br>
M.Tech- Joe Cherri Ross : 9167648284<br>
MCA- Jay Shankar : 9538999642<br>
B.Tech- Vinitha Rajan : 9446382600<br>
<br>
2. Reach us through our student coordinators.<br>
Nithin : 884 889 7874, Kumar : 790 799 4427
			</ul>
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
		console.log(aboutval);
		for(var iter in aboutval){
			(function(cntr){
				var htmlcode=aboutval[cntr];
				console.log(cntr);
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

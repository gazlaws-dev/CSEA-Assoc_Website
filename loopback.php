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
activities including a treasure hunt and a volleyball game. 
							<br><br>

							 Loopback '18 was held on 24/02/2018 turned out to be a fun and lively experience for the current students as well as the alumni. A gathering of CSE B.tech, M.tech, and MCA students of batch 2008 (and 2007, 2013 as well) enlightened us of their journeys since their tenure at our college.The interactive Q&A session with the guests in the morning saw them sharing their wisdom to the curious students.The guests were taken on a scavenger hunt to explore the campus, followed by sports in the evening. The musical night along with a sumptuous dinner made Loopback ‘18 yet another memorable alumni meet.
						
							


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

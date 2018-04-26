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
								<a href="gallery.php"><li>Gallery</li></a>
								<a href="contact.php"><li class="active">Contact Us</li></a>
						</ul>
				</nav>
		</div>

<!--		<div class="main_bg_container" style="background: white;"> -->
				<div class="main_unified">
				<div class="main_content" style="overflow-x: hidden;">
						<p style="text-align: center;padding-top: 50px;font-size: 18px;">We are happy to answer any question or queries you have or provide you with an estimate. Just send us a message in the form below with any question you may have.</p>
						<div class="contact_left">
								<form style="margin-top: 30px;"  action="mailto:csea@nitc.ac.in" method="post" enctype="text/plain">
										<input type="text" id="feedback_name" name="name" placeholder="Your Name" />
										<input type="text" id="feedback_email" name="email" placeholder="Your Email" />
										<textarea name="message" id="feedback_msg" placeholder="Message" rows="10"></textarea>
										<input type="submit" value="Send">
								</form>
						</div>
						<div class="contact_right">
								<div class="info_holder">
										<ul>
												<li><img src="img/location.png" width="25px" height="25px"/><span>Department of CSE, NIT Calicut</span></li>
												<li><img src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-128.png" width="25px" height="25px"/><span>Gedala Kumar Tej</span></li>
												<li><img src="img/phone.png" width="25px" height="25px"/><span>+91 790 799 4427</span></li>
												<li><img src="img/email.png" width="25px" height="25px"/><span>csea@nitc.ac.in</span></li>
										</ul>
										<div class="underline"></div>
										<ul>
											<li style="float: left;margin: 10px;"><a href="#"><img src="img/fb.png" width="30px" height="30px"/></a></li>
											<li style="float: left;margin: 10px;"><a href="#"><img src="img/twitter.png" width="30px" height="30px"/></a></li>
											<li style="float: left;margin: 10px;"><a href="#"><img src="img/google.png" width="30px" height="30px"/></a></li>
										</ul>
								</div>
						</div>
				</div>
			</div>


	<?php include 'footer.php' ?>

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
		function sendMessage() {
				var name = $('#feedback_name').val();
				var email = $('#feedback_email').val();
				var message = $('#feedback_msg').val();
				if (name && email && message) {
					alert('Feedback successfully sent.');
				} else {
					alert('All fields need to be entered correctly.');
				}

		}

</script>

</html>

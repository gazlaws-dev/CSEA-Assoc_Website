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
								<a href="people.php"><li class="active">Members</li></a>
								<a href="activities.php"><li>Activities</li></a>
								<a href="loopback.php"><li>Loopback</li></a>
								<a href="gallery.php"><li>Gallery</li></a>
								<a href="contact.php"><li>Contact Us</li></a>
						</ul>
				</nav>
		</div>

				<div class="main_content">
					<div class="main_bg_container">
					</div>
					<div class="main_left_container">
						<ul>
							<li><a data-val="team" onclick="changeTab(this)" class="selected_link">Our Team</a></li>
							<li><a data-val="members" onclick="changeTab(this)">Our Members</a></li>
							<!--<li><a data-val="alumni" onclick="changeTab(this)">CSEA Alumni</a></li> -->
						</ul>
					</div>



						<div class="main_middle_container_full">

								<div id="members" class="holder">
										<div class="middle_header">Our Members</div>
										<div class="content_holder">
												<p>All students and faculty of Computer Science and Engineering Department - NIT Calicut are members of the association. Everyone is entitled to access the privileges of being a member - which include access to CSED resources, being a part of our events and assistance in any CS related project.</p>
										</div>
								</div>

								<div id="team" class="holder selected">
										<div class="middle_header" style="text-align:center">Our Team</div>
                    <div class="middle_header" >Faculty</div>
										<div class="content_holder">
                      <div class="flexbox" style="padding: 30px 0px 0px 0px;" id="faculty">
                      </div>
                    </div>
                    <div class="middle_header" >B.Tech</div>
                    <div class="content_holder" id="btech">
                    </div>
                    <div class="middle_header" >MCA</div>
                    <div class="content_holder" id="mca">
                    </div>
                    <div class="middle_header" >M.Tech</div>
                    <div class="content_holder" id="mtech">
                    </div>
                  </div>

								<div id="alumni" class="holder">
										<div class="middle_header" style="text-align:center">CSEA Alumni</div>
                    <div class="middle_header" >B.Tech</div>
                    <div class="content_holder" id="alum_btech">
                    </div>
                    <div class="middle_header" >MCA</div>
                    <div class="content_holder" id="alum_mca">
                    </div>
                    <div class="middle_header" >M.Tech</div>
                    <div class="content_holder" id="alum_mtech">
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


	var inductionsdb=myFireBase.child("members").child("flag_for_inductions");
	var inductionflag;
	inductionsdb.once("value").then(function(snapshot){
	 	inductionflag=snapshot.val();
	 	//console.log("ind "+inductionflag);
	});
	
    var facultydb=myFireBase.child("members").child("faculty");
    facultydb.once("value").then(function(snapshot){
      var facultyval=snapshot.val();
      //console.log(facultyval);
      for(var iter in facultyval){
        (function(cntr){
          var facultyjson=facultyval[cntr];
          var name=facultyjson.nameof;
          var imgd=facultyjson.img;
          var facurl=facultyjson.email;
          //console.log("faculty val "+cntr);
          storageRef.child(imgd).getDownloadURL().then(function(url) {
            var xhr = new XMLHttpRequest();
            xhr.responseType = 'blob';
            xhr.onload = function(event) {
              var blob = xhr.response;
            };
            xhr.open('GET', url);
            xhr.send();
            var imgurl=url;
            $("#faculty").append('<div class="contact_holder" style="width: 160px;"><center><div class="pic" style="background-image: url('+imgurl+');"></div></center><div class="name"><span style="font-weight:bold">'+name+'</span><br>'+facurl+'</div></div>');
          }).catch(function(error) {
            console.log("faculty not fetched");
          });
        })(iter);
      }
    });
    var studentsdb=myFireBase.child("members").child("students");
    studentsdb.orderByKey().limitToLast(3).on("child_added", function(snapshot) {
      var studentsval=snapshot.val();
      console.log(studentsval);
      //console.log(Object.keys(studentsval).length);
      var stream=snapshot.key;
      //console.log(stream);
      var targetid="#"+stream;
      var noofyears=Object.keys(studentsval).length;
      console.log(noofyears+" noofyears");
      if(noofyears<3){
      	if(stream=="mtech")
      		noofyears=2;
      	else
      		noofyears=3;
      }
      var loopcounter=0;
      for(var iter in studentsval){
        (function(cntr){
        	console.log(stream+" stream");
        	console.log(loopcounter+" "+noofyears);
          if(stream!="mtech"&&inductionflag&&loopcounter<noofyears-3){
          	loopcounter++;
          }
          if(stream!="mtech"&&!inductionflag&&loopcounter<noofyears-2){
          	loopcounter++;
          }
          else if(stream=="mtech"&&inductionflag&&loopcounter<noofyears-2){
              loopcounter++;
          }
          else if(stream=="mtech"&&!inductionflag&&loopcounter<noofyears-1){
              loopcounter++;
          }
          else{
          $(targetid).append('  <div class="flexbox" id="'+stream+cntr+'" style="padding: 30px 0px 0px 0px;"></div>');
          //console.log('iter '+iter);
          //console.log(cntr)
          var yearjson=studentsval[iter];
          //console.log(yearjson);
          //console.log(cntr);
          var finaltargetid='#'+stream+cntr;
          $(finaltargetid).append('<div class="middle_header_small" >'+cntr+'</div>');

          for(var iter2 in yearjson){
            (function(cntr2){
              var execjson=yearjson[cntr2];
              var name=execjson.nameof;
              var imgd=execjson.img;
              //console.log('imgd  '+imgd);
              var facurl=execjson.linkedin;
              var email=execjson.email;
              //console.log(cntr2);
              storageRef.child(imgd).getDownloadURL().then(function(url) {
                var xhr = new XMLHttpRequest();
                xhr.responseType = 'blob';
                xhr.onload = function(event) {
                  var blob = xhr.response;
                };
                xhr.open('GET', url);
                xhr.send();
                var imgurl=url;
                //console.log('imgurl '+imgurl);
                $(finaltargetid).append('<div class="contact_holder_small" style="width: 160px;"><center><div class="pic_small" style="background-image: url('+imgurl+')"></div></center><center><div class="name_small">'+name+'</div></center><center><div class="contact_link" ><a href="'+facurl+'" title="'+facurl+'" class="link-mod" target="_blank"><div class="contact_linkedin"></div></a><a href="mailto:'+email+'" title="'+email+'" class="link-mod"><div class="contact_mail"></div></a></div></center></div>');
              }).catch(function(error) {
                console.log("executive not fetched");
              });
            })(iter2);
          }
          loopcounter++;
        }
        })(iter);
      }
    });


    studentsdb.orderByKey().limitToLast(3).on("child_added", function(snapshot) {
      var studentsval=snapshot.val();
      console.log(studentsval);
      console.log(Object.keys(studentsval).length);
      var stream=snapshot.key;
      console.log(stream);
      var targetid="#alum_"+stream;
      var noofyears=Object.keys(studentsval).length;
      if(noofyears<3)
        noofyears=3;
      var loopcounter=0;
      for(var iter in studentsval){
        (function(cntr){
          if(cntr!="mtech"&&loopcounter>=noofyears-3)
            loopcounter++;
          else if(cntr=="mtech"&&loopcounter>=noofyears-2)
              loopcounter++;
          else{
          $(targetid).append('  <div class="flexbox" id="alum_'+stream+cntr+'" style="padding: 30px 0px 0px 0px;"></div>');
          console.log('iter '+iter);
          console.log(cntr)
          var yearjson=studentsval[iter];
          console.log(yearjson);
          console.log(cntr);
          var finaltargetid='#alum_'+stream+cntr;
          $(finaltargetid).append('<div class="middle_header_small" >'+cntr+'</div>');

          for(var iter2 in yearjson){
            (function(cntr2){
              var execjson=yearjson[cntr2];
              var name=execjson.nameof;
              var imgd=execjson.img;
              console.log('imgd  '+imgd);
              var facurl=execjson.linkedin;
              var email=execjson.email;
              console.log(cntr2);
              storageRef.child(imgd).getDownloadURL().then(function(url) {
                var xhr = new XMLHttpRequest();
                xhr.responseType = 'blob';
                xhr.onload = function(event) {
                  var blob = xhr.response;
                };
                xhr.open('GET', url);
                xhr.send();
                var imgurl=url;
                console.log('imgurl '+imgurl);
                $(finaltargetid).append('<div class="contact_holder_small" style="width: 160px;"><center><div class="pic_small" style="background-image: url('+imgurl+')"></div></center><center><div class="name_small">'+name+'</div></center><center><div class="contact_link" ><a href="'+facurl+'" title="'+facurl+'" class="link-mod" target="_blank"><div class="contact_linkedin"></div></a><a href="mailto:'+email+'" title="'+email+'" class="link-mod"><div class="contact_mail"></div></a></div></center></div>');
                console.log("executive not fetched");
              });
            })(iter2);
          }
          loopcounter++;
        }
        })(iter);
      }
    });
</script>

</html>

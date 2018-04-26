var config = {
   apiKey: "AIzaSyAVni-OPpG6lCxrXcLSjltcxoVDmjYMSSM",
   authDomain: "cseanitcweb.firebaseapp.com",
   databaseURL: "https://cseanitcweb.firebaseio.com",
   projectId: "cseanitcweb",
   storageBucket: "cseanitcweb.appspot.com",
   messagingSenderId: "989307387005"
 };

  firebase.initializeApp(config);


var myFireBase= firebase.database().ref();

   var storageRef=firebase.storage().ref();
   var myFireBase= firebase.database().ref();
   console.log(myFireBase);
/*   var slider = $('.flexslider').flexslider()
   var ssIndex = $(".slides li").length ;
   console.log(ssIndex,slider);
  slider.addSlide('<li><div class="row" style="background-image: url(failed.png);"></div></li>', ssIndex);
*/

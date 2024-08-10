<?php 
	$baseUrl = Yii::app()->getBaseUrl();  
    $controller = Yii::app()->getController()->getAction()->controller->id;
    $action     = Yii::app()->getController()->getAction()->controller->action->id;
    $lang = Yii::app()->request->getParam('lang',''); 
    if ($lang != '') {
        Yii::app()->session['lang'] = $lang;
    } else {
        if (isset(Yii::app()->session['lang'])) {
            $lang = Yii::app()->session['lang'];
        } else {
            $lang = 'vi';
        }
    }  
    Yii::app()->setLanguage($lang);
?>

<style type="text/css">
#Cus_info table th, #Cus_info table td{font-size: 14px; border: 0;}
#Cus_info table th {width: 7%; text-align: right;}
#Cus_info form {position: relative;}
</style>
<script src="https://apis.google.com/js/api:client.js"></script>

<!-- google capchar -->
<script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('html_element', {
          'sitekey' : '6Le3xhQUAAAAAMyUiFGS_Azelo3aD3uuIYtj3gg9'
        });
      };
</script>

<!-- dang nhap google -->
<script id="logGG">
  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '422119173867-3ovijab8u7hl80ho9npupqaavajvh9o7.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        // scopes: 'profile, email'
      });
      attachSignin(document.getElementById('loginAccGg'));
    });
  };

  function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
        	console.log(googleUser);
        	uId = googleUser.getBasicProfile().getId();
        	uNa = googleUser.getBasicProfile().getName();
        	uEm = googleUser.getBasicProfile().getEmail();
        	LogFbGgAcc(uId, uNa, uEm, 2);
          //document.getElementById('name').innerText = "Signed in: " +
            //  googleUser.getBasicProfile().getName();
        }, function(error) {
          //alert(JSON.stringify(error, undefined, 2));
        });
  }
</script>
<!-- dang nhap facebook -->
<script id="LoginByFB">
  	// This is called with the results from from FB.getLoginStatus().
  	function statusChangeCallback(response) {
    	// The response object is returned with a status field that lets the app know the current login status of the person.
    	// Full docs on the response object can be found in the documentation for FB.getLoginStatus().
    	if (response.status === 'connected') {
      		// Logged into your app and Facebook.
      		testAPI();
    	} else if (response.status === 'not_authorized') {
      		// The person is logged into Facebook, but not your app.
    	} else {
      		// The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
    	}
  	}

	// This function is called when someone finishes with the Login Button.
  	function checkLoginState() {
    	FB.getLoginStatus(function(response) {
      		statusChangeCallback(response);
    	});
  	}

  	window.fbAsyncInit = function() {
	  	FB.init({
		    appId      : '383864505308911',
		    cookie     : true,  // enable cookies to allow the server to access the session
		    xfbml      : true,  // parse social plugins on this page
		    version    : 'v2.8' // use graph api version 2.8
	  	});

	// Now that we've initialized the JavaScript SDK, we call FB.getLoginStatus().
	// This function gets the state of the person visiting this page and can return one of three states to the callback you provide.
	//   They can be:
	// 1. Logged into your app ('connected')
	// 2. Logged into Facebook, but not your app ('not_authorized')
	// 3. Not logged into Facebook and can't tell if they are logged into your app or not.
	// These three cases are handled in the callback function.
	  	FB.getLoginStatus(function(response) {
	    	statusChangeCallback(response);
	  	});

	};

  	// Load the SDK asynchronously
  	(function(d, s, id) {
    	var js, fjs = d.getElementsByTagName(s)[0];
    	if (d.getElementById(id)) return;
    	js = d.createElement(s); js.id = id;
    	js.src = "//connect.facebook.net/en_US/sdk.js";
   	 	fjs.parentNode.insertBefore(js, fjs);
  	}(document, 'script', 'facebook-jssdk'));

  	// Here we run a very simple test of the Graph API after login is
  	// successful.  See statusChangeCallback() for when this call is made.
  	function testAPI() {
	    /*FB.api('/me', function(response) {
	    	console.log(response);
	      	uId = response.id;
	      	uNa = response.name;

	      	FbAccRegister(uId, uNa);

	    });*/
  	}

  	// google Signin APi
  	/*function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
      };

    function signOut() {
	    var auth2 = gapi.auth2.getAuthInstance();
	    auth2.signOut().then(function () {
	      console.log('User signed out.');
	    });
	}*/
</script>
<?php 
	$baseUrl = Yii::app()->getBaseUrl();
	$session = 	Yii::app()->session;
	$book    =	$session['book'];
?>
<div  class="container" id="bk_step">
	<div class="row">
		<div class="col-sm-12">
			<div class="row" id="bk_st_tt">
				<h3 class="upcase_txt"><?php echo Yii::t('translate','booking'); ?></h3>
				<div id="bk_action">
					<ul class="list-inline">
						<li class="bk_fn"><a href="<?php echo $baseUrl . '/book/index/lang/' . $lang; ?>" class="upcase_txt">1. <?php echo Yii::t('translate','book_appointment'); ?></a></li>
						<li><a href="<?php echo $baseUrl.'/book/register_info/lang/'.$lang; ?>" class="upcase_txt">2. <?php echo Yii::t('translate','book_register'); ?></a></li>
						<!-- <li><a href="<?php //echo $baseUrl; ?>/index.php/book/verify_schedule">3. XÁC NHẬN LỊCH HẸN</a></li> -->
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="bk_step_num">
		2
</div>
<div  class="container" id="bk_info">
	<div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-md-4" id="bk_select">
					<div class="col-md-12" id="bk_register_info">
						<h4 style="text-transform: uppercase;"><?php echo Yii::t("translate","book_info_app"); ?></h4>
						<p><b><?php echo Yii::t("translate","book_info_time"); ?>:</b></p>
						<div id="bk_box_time" class="bk_schedule_info">
							<div id="box_day">Thứ 2 - 21/10/2016</div>
							<span id="box_time">
								<p id="box_t"><?php echo $book[0]['time']; ?></p>
								<!-- <hr> -->
								<span style="display: none;padding: 11px;">Thời gian khám: <span id="box_duration"><?php echo $book[0]['len']; ?> </span>&nbsp;phút</span>
							</span>
						</div>
						<div  class="bk_schedule_info">
							<span><b><?php echo Yii::t("translate","book_info_branch"); ?>:</b></span>
							<span id="box_branch"><?php echo $book[0]['branch']; ?></span>
						</div>
						<div class="bk_schedule_info">
							<span><b><?php echo Yii::t("translate","book_info_service"); ?>:</b></span>
							<span id="box_service"><?php echo $book[0]['service']; ?></span>
						</div>
						<!-- <div id="bk_dentist_info" class="bk_schedule_info">

						<?php 
							//$dentist = GpUsers::model()->findByPk($book[0]['id_dentist']);
							//if($dentist) 
								//$img = Yii::app()->request->baseUrl ."/upload/users/sm/". $dentist->image;
							//else 
								//$img = Yii::app()->request->baseUrl . '/upload/users/no_avatar.png';
						?>

							<span><b>Nha sỹ chỉ định điều trị:</b></span>
							<img id="img_dentist" src="<?php //echo $img; ?>" alt="NHA SỸ">
							<span id="box_dentist"><?php //echo $dentist->name; ?><button type="button" class="btn_quest" >?</button></span>
						</div> -->
							<div class="col-md-12">
								<button type="button" class="btn btn_green col-md-12" id="apre"><?php echo Yii::t("translate","book_edit"); ?></button>
							</div>
					</div>
				</div>
				<div class="col-md-8" id="changeProfileLayout">
					<?php 
						if(isset(Yii::app()->session['guest']) && Yii::app()->session['guest'] == false){
							include 'update_cus.php';
						}
						else{
							include 'create_cus.php';
						}
					?>
					<script>startApp();</script>
			</div>
		</div>
	</div>
</div>
<script>
/*** Dang nhap bang tai khoan facebook va google - type: 1 facebook, 2: google ***/
	function LogFbGgAcc(uId, uNa, uEm, type) {
		$.ajax({ 
			type    : 	"POST",
			url     : 	"<?php echo CController::createUrl('book/LogAccFbGg')?>",
			data    : 	{
				uId    : uId,
				uNa    : uNa,
				uEm    : uEm,
				typeLog: type,
			},
			dataType: 	'json',
			success : 	function(data){
				// co tai khoan acc cua facebook hoac google -> dang nhap website
				if(data == true) {
					location.reload();
				}
				// chua co tai khoan facebook hoac google -> tao tai khoan (luu record)
				else {
					$('#up_cus_fullname').val(uNa);
					$('#up_cus_email').val(uEm);
					// facebook
					if(type == 1) {
						$('#Customer_id_fb').val(uId);
						$('#Customer_name_fb').val(uNa);
					}
					else {
						$('#Customer_id_gg').val(uId);
						$('#Customer_name_gg').val(uNa);
						$('#up_cus_email').prop('readOnly', true);
					}

					$('#update_Cus_info').show();
					$('#Cus_info').hide();
				}
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
	}
</script>
<script>
$(window).load(function () {
	$('body').delay(100) //wait 5 seconds
	    .animate({
	        'scrollTop': $('#bk_st_tt').offset().top
	    });

	moment.locale('<?php echo $lang; ?>');
	
	var day = '<?php echo $book[0]['day']; ?>';

	$('#box_day').html(moment(day).format('dddd, DD/MM/YYYY'));

});

$(document).ready(function(){
	$('#apre').click(function(){
		location.href = '<?php echo $baseUrl."/book/index/lang/".$lang; ?>'
		;
	})
})

</script>
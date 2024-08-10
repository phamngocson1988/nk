<?php 
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
<div class="modal-dialog" style="margin-top: 10%">
	<div class="loginmodal-container">
		<h1><?php echo Yii::t('translate','forgot_password'); ?></h1><br>
		<form class="form" method="post" id="form_forget_pass" name="form_forget_pass">
		<div class="form-group">
			<div>
				<input required="required" placeholder="Email" class="form-control" name="ForgetPass_email" id="ForgetPass_email" type="text">
			</div>
		</div>
		<button class="login loginmodal-submit btn-success btn btn-default" id="receivePass" name="receivePass"><?php echo Yii::t('translate','receivePass'); ?></button>
		</form>
	</div>
</div>
<script>
function randomString(length, chars) {
    var result = '';
    for (var i = length; i > 0; --i) result += chars[Math.round(Math.random() * (chars.length - 1))];
    return result;
}
$('#receivePass').click(function(e){
    var lang = '<?php echo $lang; ?>';
	e.preventDefault();
	var pass = randomString(6, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
	var email = $('#ForgetPass_email').val();
	$.ajax({
        type:'POST',
        url: "<?php echo CController::createUrl('home/ReceivePass')?>", 
        data: {"email":email,"pass":pass},   
        success:function(data){
        	if (data==1) {
                if(lang =='vi'){
        		  alert("Email này không tồn tại");
                }else{
                     alert("Email does not exist");
                }
        	}else if(data==-1){
                if(lang =='vi'){
                  alert("New password has been sent to this account! Please check email!");
                }else{
                     alert("Email does not exist");
                }
                
            }
            else{
        		alert(data);
                $('#ForgetPass_email').val("");
                $('#forget-pass').modal('hide');
        	}
        },
        error: function(data){
        console.log("error");
        console.log(data);
        }
    });
});
</script>
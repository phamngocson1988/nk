<?php 
$cs = Yii::app()->getClientScript();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php
    $cs->registerCssFile(Yii::app()->baseUrl.'/css/font-awesome/css/font-awesome.min.css'); 
    $cs->registerCssFile(Yii::app()->baseUrl.'/css/admin/main.css'); 
 
    ?>
	<?php 
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
	?>

</head>

<body>  
    <header>
        <div class="container">
            <div class="row">
                   <div class="col-sm-2" style=" padding-top: 5px;padding-bottom: 5px;">
                       <a href="">
                           <img  class="img-responsive"  src="<?php echo Yii::app()->params['image_url']; ?>/images/Logo NK 2000_color-01.png" alt="<?php echo CHtml::encode(Yii::app()->name); ?>" />
                       </a>
                   </div>
            </div>
        </div>
    </header>

    <div id="wrapper">
            <?php echo $content; ?>
    </div>

    <footer style="background-color:#0a75b9;">
        <p style="width:100%;padding:10px 0px;margin:0px auto;color:#e8e8e8;text-align:center;">Dentist &copy; 2016.Privacy Policy</p>
    </footer>

    <script type="text/javascript">
    $(window).load(function() {
        $(window).resize(function() {
            var header_h = $("header").height();
            var footer_h = $("footer").height();
            var body_h = $(this).height(); 
            var content_h = body_h - header_h - footer_h;
            if(content_h < 450){
                content_h = 450;
                if(content_h < 350){
                    $(".bg-admin-login").css("background",'none');
                    content_h = 0;
                }
            } 
            
            $(".bg-admin-login").css("height",content_h );

        }).resize();
    });
    </script>

    <?php 
        $cs->registerScriptFile(Yii::app()->baseUrl.'/js/vsc/js/metisMenu.min.js',CClientScript::POS_END);    
        $cs->registerScriptFile(Yii::app()->baseUrl.'/js/vsc/js/main.js',CClientScript::POS_END);
    ?>

</body>

</html>

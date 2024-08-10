<style type="text/css">
	#ns_srch {margin-bottom: 30px;}
#ns_srch #ns_srch_tt h4 {background: #19a8e0;
    padding: 12px;
    margin: 0;
    text-align: center;
    font-weight: bold;
    color: white;}
#ns_srch .panel-body {border: 0;}
#ns_srch .panel-heading {border: 0; border-radius: 0;}
#ns_srch .panel-heading:hover {background: #c5c4c4; color: white;}
#ns_srch .panel-body {padding: 0 0 0 40px;}

.search_faq input[type=text]
{
	box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 2px;
    /*background-color: #ccc;*/
    background-image: url(../images/muasam/icon_search.png);
    /* background-position: right; */
    background-position-x: right;
    background-position-y: 6px;
    background-size: 25px;
    background-repeat: no-repeat;
    padding: 2px 0px;
    width: 100%;
    height: 40px;
    padding-left: 5px;
    font-style: italic;
}
.content{
	padding: 15px;
}
.panel{
	border-bottom: 1px solid #ccc !important;
}
.panel-heading{
	padding-left: 0px;
}
#banner_faq{
	background: url('../images/bg_02.jpg') no-repeat left top;
}
.menu_faq{
	background: #f4f5f5;
	border-top: 1px solid #ccc;
	cursor: pointer;
}
.menu_faq:hover{
	background: #787878;
	border-top: 1px solid #fff;
	color: #fff;
}
.padding_img_faq{
	padding: 10px 0px;
}
.title_menu_faq{
	padding: 15px 0px;
    font-size: 17px;
    margin: 0px;
}
.background_faq{
	background: url('../images/img_faq.jpg') no-repeat center top;
	background-size: cover;
}
.list-btn{margin-top: 50px}
.list-btn ul li{
	display: inline-block;
}
.list-btn ul li img{
	width: 90%;
}
.panel{
    margin-bottom: 0px;
	background-color: inherit;
}
#page {
    font-size: 14px;
}
.choose{   
    background: url(<?php echo Yii::app()->params['image_url']; ?>/images/iconFAQ/tu-van-1.png);
    background-size: 100% 100%;
    cursor: pointer; 
    padding:10px 15px;
    color: #fff;
    font-size: 16px; 
    margin-right: 18px; 
    font-family: Helvetica-Bold;
    text-transform: uppercase;
}
.choose:hover{    
    background: url(<?php echo Yii::app()->params['image_url']; ?>/images/iconFAQ/tu-van-2.png);
     background-size: 100% 100%;
}   
/*pagination*/
.div_phan_trang
{
    width:100%;
    text-align:center;
}
.div_trang
{
    width:30px;
    padding:5px 10px 5px 10px;
    text-align:center;    
    margin:2px;
}
.div_trang a
{
    text-decoration:none;
}
/*popup*/
#question-container{
    padding:20px;position: fixed;top: 30%;right: 0;left: 0;width: 750px;height: auto;margin: 0 auto;background: #ffffff;border-radius: 3px;z-index: 999;
}
.blur{
    display: none;position: fixed;top: 0;right: 0;width: 100%;height: 100%;z-index: 999;background: rgba(0,0,0,0.8);
}
.sHeader{
    background: #0eb1dc;
    color: white;
    padding: 9px 30px;
    font-size: 18px;
    margin-left: -35px;
    margin-top: -20px;
    margin-right: -35px;
}
a.faq_hover:hover {color: #0976ba;}
a.faq_hover[aria-expanded="true"] {color: #0976ba; font-size: 20px;}
#res-2{background-color: rgba(255,255,255,0.6);margin-top: 20px;margin-bottom: 18px;border-radius: 4px;height: 500px;overflow-y: auto;}
@media screen and (max-width: 1366px) , screen and (max-height: 662px) {
    #res-1{
        min-height:633px !important;
    }
    #res-2{
        height: 480px !important;
    }   
}
</style>
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
<div id="res-1" class="row">
    <div class="list-btn col-md-6 col-md-offset-5">
        <div class="row">
            <a href="<?php echo Yii::app()->request->baseUrl; ?>/faq/answerQuestions/lang/<?php echo $lang;?>">
                <span id="frequently_asked_question" class="choose">
                    <?php echo Yii::t('translate','faq_3'); ?>
                </span>  
            </a> 
            <div class="clearfix"></div>
            <div style="font-size: 25px; text-transform: uppercase; color: #0976ba; margin-top: 50px;">
                <?php echo Yii::t('translate','faq_1'); ?>
            </div> 
        </div>                    
    </div>
    <div id="res-2" class="col-md-6 col-md-offset-5">
        <div class="content">
            <div id="accordion" role="tablist" aria-multiselectable="true">
                
            </div>
        </div>
        
    </div>
</div>

<?php include("popup_send_question.php");?>

<script type="text/javascript">
// pagination
function pagination(){ 
    var curpage=1; 
    $.ajax({
        type:'POST',
        url:"<?php echo CController::createUrl('faq/pagination')?>",
        data: {"curpage":curpage},   
        success:function(data){  
            $('#accordion').html(data);
        },
        error: function(data){
        console.log("error");
        console.log(data);
        }
    });
}
function paging(curpage){   
    $.ajax({
        type:'POST',
        url:"<?php echo CController::createUrl('faq/pagination')?>",
        data:{"curpage": curpage},
        success:function(data){           
            $('#accordion').html(data);
        },
        error: function(data){
            console.log("error");
            console.log(data);
        }
    });      
}

$( document ).ready(function() {
    pagination();
    $('#body_content').css({"background":"url(<?php echo Yii::app()->baseUrl?>/images/img_faq.jpg) no-repeat"});
    $('#body_content').css({"background-size":"cover"});
});
</script>

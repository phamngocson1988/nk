<style>
.sHeader{background: #0eb1dc;color: white;padding: 9px 30px;font-size: 18px;margin-left: -30px;margin-top: -20px;margin-right: -30px;border-top-left-radius: 8px;border-top-right-radius: 8px;}
#modal_send_question .close{color: #fff; opacity: 1}
.bg-title{background:rgba(255, 255, 255, 0.4); padding-top: 60px; padding-bottom: 60px; text-align: center;}
.bg-title .title{font-size: 30px; text-transform: uppercase; color: #5DB746; font-family: Helvetica-Bold}
.bg-title .des{max-width: 530px;margin: 15px auto;}
.btn_question{background:#5DB746; color: #fff; text-transform: uppercase; font-size: 14px;padding: 7px 20px 6px 15px;border-radius: 4px !important;}
.btn_question:hover, .btn_question:focus{color: #fff; background: rgba(93, 183, 70, 0.8)}
.content-faq{max-width: 800px; margin: 40px auto; }
#modal_send_question{margin-top: 130px;}
.content_question{float: left;width: 88%;background: #fff;padding: 20px;border-radius: 4px;border: 1px solid #ddd; font-size: 14px; line-height: 1.4}
.content_answer{float: right;width: 88%;background: #5EBFE6;padding: 20px;border-radius: 4px;color: #fff; margin-top: 15px; margin-bottom: 15px; border: 1px solid #ddd;font-size: 14px; line-height: 1.4; position: relative;}
.content_answer .content{ height: 60px; overflow:hidden;}
.border-bottom {border-bottom-style: dashed;border-width: 1px;border-color: #ccc;margin-bottom: 10px;}
.border-bottom:last-child {border-width: 0px;}
.avatar_cus{width: 45px; float: left; margin-bottom: 10px; border-radius: 50%; overflow:hidden; height: 45px; overflow:hidden;}
.avatar_cus img{height: 100%; }
.name_cus{width: calc(100% - 45px); padding-left: 20px; color: #333; font-family:Helvetica-Bold; text-transform: uppercase;float: left; margin-top: 5px; font-size: 15px}
strong{font-weight: 100; font-family: Helvetica-Bold}
.margin-bottom-20{margin-bottom: 20px;}
.icon_down{position: absolute;right: -18px;top: 32%;cursor: pointer;}
/*pagination*/
.div_trang .glyphicon{font-size: 10px; top:0;left: -1px}
.div_trang {padding:5px 10px;text-align:center;margin:5px;border: 1px solid #5DB746;color: #5DB746; border-radius: 4px; cursor: pointer}
.div_trang a{text-decoration:none;color: #5DB746; font-size: 13px;}
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
<div class="container">
  <div class="row bg-title">
    <div class="col-xs-12">
      <span class="title"><?php echo Yii::t('translate','faq_3'); ?></span>
      <div class="des">
          <?php echo Yii::t('translate','faq_4'); ?>
      </div>
      <button class="btn btn_question" data-toggle="modal" data-target="#modal_send_question">
        <span>
          <img src="<?php echo Yii::app()->baseUrl?>/images/icon_faq/icon_send.png">
        </span>
        <span><?php echo Yii::t('translate','faq_2'); ?></span>
      </button>
    </div>
  </div>
</div>

<div class="container">
  <div class="content-faq">
   
  </div>
</div>
<?php include("popup_send_question.php");?>
<script>
    $(document).ready(function() {
        $('#body_content').css({"background":"url(<?php echo Yii::app()->baseUrl?>/images/icon_faq/Background.png) no-repeat","background-size":"cover" });
        loadData();
    });

    function loadData(){ 
      var curpage=1; 
      $.ajax({
          type:'POST',
          url:"<?php echo CController::createUrl('faq/LoadAnswerQuestions')?>",
          data: {"curpage":curpage},   
          success:function(data){  
              $('.content-faq').html(data);
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
        url:"<?php echo CController::createUrl('faq/LoadAnswerQuestions')?>",
        data:{"curpage": curpage},
        success:function(data){           
             $('.content-faq').html(data);
        },
        error: function(data){
            console.log("error");
            console.log(data);
        }
    });      
}
</script>

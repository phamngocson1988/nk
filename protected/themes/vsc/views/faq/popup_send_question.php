<div id="modal_send_question" class="modal fade in" role="dialog">
    <div class="modal-dialog modal-md">        
        <div class="modal-content">      
            <div class="modal-body clearfix sBody">
                <div class="col-md-12">
                    <div class="sHeader"> 
                        <?php echo Yii::t('translate','faq_2'); ?> 
                        <button type="button" class="close cancel white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form id="question-form"  runat="server" action="" onsubmit="return false;" method="post">
                        <div class="rg-row">
                            <div class="col-md-12">  
                                <div class="rg-row">
                                    <div class="form-group margin-bottom-05em">
                                        <span for="name"><?php echo Yii::t('translate','full_name'); ?></span>
                                        <input required class="form-control" name="name" type="text">                                
                                    </div>                  
                                </div>  
                                <div class="rg-row">
                                    <div class="form-group margin-bottom-05em">
                                        <span for="name"><?php echo Yii::t('translate','phone1'); ?></span>
                                        <input required class="form-control"  name="phone" type="text">                                
                                    </div>                  
                                </div>
                                <div class="rg-row">
                                    <div class="form-group margin-bottom-05em">
                                        <span for="email">Email</span>
                                        <input  class="form-control" name="email" type="email">                                
                                    </div>                     
                                </div>            
                                <div class="form-group margin-bottom-05em">
                                    <span for="Content"><?php echo Yii::t('translate','content'); ?></span>
                                    <textarea rows="5" class="form-control"  id="Content" name="Content"></textarea>
                                </div>
                                <div class="rg-row">
                                    <div class="form-group margin-bottom-05em">
                                        <span for="email">
                                            <?php 
                                                if($lang=='vi'){ 
                                                    echo "Ảnh đại diện";
                                                }else{ 
                                                    echo "Avatar";
                                                }
                                            ?>
                                        </span>
                                        <div style="width: 100px;cursor: pointer;" onclick="clickImage();">
                                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/upload/customer/no_avatar.png" class="img-responsive" id="imgUpload">
                                        </div>
                                        <input style="display: none;" type="file" id="img_avatar" name="img_avatar">                       
                                    </div>                     
                                </div>            
                            </div>
                        </div>    
                        <div class="rg-row" style="margin-top:10px;">
                            <div class="col-md-12">
                                <div class="form-actions text-right">
                                    <button type="submit" class="btn btn-success btn-fw">
                                        <?php echo Yii::t('translate','seen'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form> 
                </div>  
            </div>
        </div>
    </div>
</div>

<script>
    function clickImage(){
        $("#img_avatar").click();
    }
    $('#img_avatar').on('change', function(evt) {
        var tgt = evt.target || window.event.srcElement,
            files = tgt.files;
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () {
                document.getElementById('imgUpload').src = fr.result;
            }
            fr.readAsDataURL(files[0]);
        }
    });
    function error_send_question(){
        var status = true;    
        if($('#Content').val() == ''){       
            $.notify("Vui lòng điền nội dung.", "error");       
        }    
        return status;
    }
    $('#question-form').submit(function(e) {    
        if(error_send_question()){  
            e.preventDefault(); 
            var elem = $('#send-question-blur')[0];  
            var formData = new FormData($('#question-form')[0]);         
            if (!formData.checkValidity || formData.checkValidity()) {
              jQuery.ajax({
                  type:'POST',
                  url:"<?php echo CController::createUrl('faq/sendQuestion')?>",
                  data:formData,
                  datatype:'json',
                  success:function(data){             
                      if(data == '1')
                      {    
                        alert("Gửi thành công!");
                        $('#question-form')[0].reset();   
                        location.href = '<?php echo Yii::app()->params['url_base_http'] ?>/faq/answerQuestions'; 
                      } 
                  },
                  error: function(data){
                      console.log("error");
                      console.log(data);
                  },
                  cache: false,
                  contentType: false,
                  processData: false
              });
            }
        }   
    });

</script>
<style>
    .btn_plus {
        height: 30px;
        width: 30px;
        float: right;
        cursor: pointer;
        background: url(/images/icon_add/add-def.png);
        background-size: 100%;
        background-repeat: no-repeat;
    }
</style>

<div class="row" style='margin-top:20px'>
    <div class="col-sm-12">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <label class="col-xs-4" style="text-align: right; margin-top: 10px;">Mã đối tác</label>
                    <div class="col-xs-8">
                        <input type="text" class="form-control" id="search_code" />
                    </div>
                </div>
                <div class="col-sm-4">
                    <label class="col-xs-4" style="text-align: right; margin-top: 10px;">Tên đối tác</label>
                    <div class="col-xs-8">
                        <input type="text" class="form-control" id="search_name"/>
                    </div>
                </div>
				
				<div class="col-sm-4 text-right">
					<a  class="btn oBtnAdd btn_plus" id="oAdds" data-toggle="modal" data-target="#create_modal" ></a>
				</div>
            </div>  
        </div>
    </div>
</div>
<div class="col-md-12">
    <div id="listPartner">
    </div>
</div>
<!-- create-->
<div id="create_modal" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content order-container">
            <div class="modal-header sHeader" style="text-align: center;text-transform: uppercase;">
                Tạo mới đối tác
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <?php 
                    $form = $this->beginWidget(
                        'booster.widgets.TbActiveForm',
                        array(
                            'id' => 'frm-create',
                            'enableClientValidation'=>true,
                            'htmlOptions' => array('enctype' => 'multipart/form-data'), // for inset effect
                        )
                    );
                ?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-xs-3" style="text-align: right; margin-top: 10px">Mã đối tác</label>
                                <div class="col-xs-9">
                                    <?php echo $form->textField($partner,'code',array('class'=>'form-control'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-xs-3" style="text-align: right; margin-top: 10px">Tên đối tác</label>
                                <div class="col-xs-9">
                                    <?php echo $form->textField($partner,'name',array('class'=>'form-control'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-xs-3" style="text-align: right; margin-top: 10px">Mô tả</label>
                                <div class="col-xs-9">
                                   <?php echo $form->textarea($partner,'description',array('class'=>'form-control', "rows"=>"4"));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-xs-3" style="text-align: right; margin-top: 10px">Chọn bảng giá</label>
                                <div class="col-xs-9">
                                  <?php echo $form->dropDownList($partner,'id_price_book', CHtml::listData(PriceBook::model()->findAll(array('order' => 'id')),'id','name'),array('class'=>'form-control','empty'=>'--Chọn bảng giá--'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="sFooter" class="form-group text-right"> 
                        <button class="btn sCancel" data-dismiss="modal">Hủy</button>
                        <button class="btn Submit" id="sSubmit" type="submit">Xác nhận</button>
                    </div>
                <?php 
                    $this->endWidget();
                ?>
            </div>
        </div>
    </div>
</div>
<!-- upadte-->
<div id="update_modal" class="modal fade">

</div>
<script>
    function loadPartner(page,search_code,search_name) {
        $('.cal-loading').fadeIn('fast');
        $.ajax({ 
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSetting/Partner/loadPartner')?>",
            dataType: 'html',
            data: {
                page              : page,
                search_code       : search_code,
                search_name       : search_name,
            },
            success:function(data){
                if(data){
                    $("#listPartner").html(data);
                    $('.cal-loading').fadeOut('slow');
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    }

    $('#search_code').keypress(function(event) {
        if (event.keyCode == 13) {
            var search_code = $('#search_code').val();
            loadPartner(1,search_code,'');
        }
    });

    $('#search_name').keypress(function(event) {
        if (event.keyCode == 13) {
            var search_name = $('#search_name').val();
            loadPartner(1,'',search_name);
        }

    });
    $( document ).ready(function() {
         loadPartner(1,'','');
    })

    $('form#frm-create').submit(function(e){
        e.preventDefault();
        if($.trim($("#Partner_code").val())==""){
            alert('Vui lòng nhập mã đối tác!');
            return false;
        }
        if($.trim($("#Partner_name").val())==""){
            alert('Vui lòng nhập tên đối tác!');
            return false;
        }
        var formData = new FormData($("#frm-create")[0]);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({ type:"POST",
                url:"<?php echo CController::createUrl('Partner/Create')?>",
                data: formData,
                datatype:'json',

                success:function(data){

                    if(data==1){
                        alert('Tạo thành công');
                        location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSetting/Partner/View';
                    }
                    if(data==-1){
                        alert('Mã đối tác đã được tạo!');
                    }
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
       
        return false;
    });

    function deletePartner(id) {
        if(confirm("Bạn có thực sự muốn xóa đối tác?")) {
            $.ajax({ 
                type:"POST",
                url:"<?php echo Yii::app()->createUrl('itemsSetting/Partner/delete')?>",
                data: {
                   id: id,
                },
                success:function(data){
                    if(data == 1){
                        alert("Xóa thành công!");
                        loadPartner(1,'','');
                    }
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
            });
        } 
    }
    function editPartner(id){
        $.ajax({ 
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSetting/Partner/update')?>",
            data: {
               id: id,
            },
            success:function(data){
                if(data){
                    $("#update_modal").html(data);
                    $("#update_modal").modal('show');
                    $('.cal-loading').fadeOut('slow');
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    }

</script>
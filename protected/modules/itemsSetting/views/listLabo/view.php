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
                    <label class="col-xs-4" style="text-align: right; margin-top: 10px;">Tên labo</label>
                    <div class="col-xs-8">
                        <input type="text" class="form-control" id="search_name"/>
                    </div>
                </div>
				<div class="col-sm-4">
                    <label class="col-xs-4" style="text-align: right; margin-top: 10px;">SDT</label>
                    <div class="col-xs-8">
                        <input type="text" class="form-control" id="search_phone"/>
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
    <div id="listLabo">
    </div>
</div>
<!-- create-->
<div id="create_modal" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content order-container">
            <div class="modal-header sHeader" style="text-align: center;text-transform: uppercase;">
                Tạo mới labo
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
                                <label class="col-xs-3" style="text-align: right; margin-top: 10px">Tên labo</label>
                                <div class="col-xs-9">
                                    <?php echo $form->textField($labo,'name',array('class'=>'form-control'));?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-xs-3" style="text-align: right; margin-top: 10px">Địa chỉ</label>
                                <div class="col-xs-9">
                                   <?php echo $form->textarea($labo,'address',array('class'=>'form-control', "rows"=>"4"));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="col-xs-3" style="text-align: right; margin-top: 10px">SDT liên hệ</label>
                                <div class="col-xs-9">
                                    <?php echo $form->textField($labo,'phone',array('class'=>'form-control'));?>
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
<!--update -->
<div id="update_modal" class="modal fade">

</div>
<script>
    function loadLabo(page,search_name, search_phone) {
        $('.cal-loading').fadeIn('fast');
        $.ajax({ 
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSetting/listLabo/loadData')?>",
            dataType: 'html',
            data: {
                page              : page,
                search_name       : search_name,
                search_phone      : search_phone,
            },
            success:function(data){
                if(data){
                    $("#listLabo").html(data);
                    $('.cal-loading').fadeOut('slow');
                }
            },
            error: function(data) {
                alert("Error occured.Please try again!");
            },
        });
    }
    $('#search_name').keypress(function(event) {
        if (event.keyCode == 13) {
            var search_name = $('#search_name').val();
            loadLabo(1,search_name,'');
        }
    });

    $('#search_phone').keypress(function(event) {
        if (event.keyCode == 13) {
            var search_phone = $('#search_phone').val();
            loadLabo(1,'',search_phone);
        }

    });
    $( document ).ready(function() {
         loadLabo(1,'','');
    });

    $('form#frm-create').submit(function(e){
        e.preventDefault();
        if($.trim($("#ListLabo_name").val())==""){
            alert('Vui lòng nhập tên labo!');
            return false;
        }
        var formData = new FormData($("#frm-create")[0]);
        if (!formData.checkValidity || formData.checkValidity()) {
            jQuery.ajax({ type:"POST",
                url:"<?php echo CController::createUrl('ListLabo/Create')?>",
                data: formData,
                datatype:'json',

                success:function(data){
                    if(data==1){
                        alert('Tạo thành công');
                        location.href = '<?php echo Yii::app()->getBaseUrl(); ?>/itemsSetting/listLabo/View';
                    }else if(data==-1){
                        alert('Tên labo đã tồn tại !');
                    }
                    else{
                        alert(data);
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


    function deleteLabo(id) {
        if(confirm("Bạn có thực sự muốn xóa labo này ?")) {
            $.ajax({ 
                type:"POST",
                url:"<?php echo Yii::app()->createUrl('itemsSetting/ListLabo/delete')?>",
                data: {
                   id: id,
                },
                success:function(data){
                    if(data == 1){
                        alert("Xóa thành công!");
                        loadLabo(1,'','');
                    }
                },
                error: function(data) {
                    alert("Error occured.Please try again!");
                },
            });
        } 
    }

    function editLabo(id){
        $.ajax({ 
            type:"POST",
            url:"<?php echo Yii::app()->createUrl('itemsSetting/ListLabo/update')?>",
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
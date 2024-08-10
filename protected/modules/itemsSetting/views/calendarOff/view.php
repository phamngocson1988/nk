<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl?>"/>
<div class="row" style='margin-top:20px'>
    <div class="col-sm-12">
          <div class="form-group">
                <div class="row">
				    <div class="col-sm-4">
                        <label>Chi nhánh</label>
                        <select class="form-control" id="search_statusHeader" onchange="changeBS();"> 
						    <option value=''>--Chọn chi nhánh--</option>
						<?php 
						$bran = Branch::model()->findAll('status=:st',array(':st'=>1));
						foreach($bran as $gt){?>
							<option value='<?php echo $gt['id'];?>'><?php echo $gt['name'];?></option>
						<?php }?>
						</select>
					</div>
                    <div class="col-sm-4">
                        <label>Tên bác sĩ</label>
						<div id='bs_content'>
							<select class="form-control" disabled id='search_BS' name='search_BS'>
								<option value='' >--Chọn bác sĩ--</option>
							</select>
						</div>
                    </div>
					<div class="col-sm-4 text-right" style='padding-top:22px'>
						<input type="button" class="btn btn-default" onclick="pagelistheader(1);" value="Tìm" style="width: 75px;" />
                        <?php if ($addRole == 1): ?>
                            <input type="button" class="btn btn-default" onclick="addNewHeader();" value="Thêm" style="width: 75px;margin-left: 15px;" />    
                        <?php endif ?>
					</div>
					
                </div>  
          </div>
         
    </div>
</div>
<div class="row" id="listHeader">
    <?php 
		
        $lpp=5;
        $this->renderPartial('list',array('value12'=>$lpp,'list_data'=>$listdata,'upRole'=>$upRole, 'delRole'=>$delRole));
    ?>
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
		<!-- Modal content-->
		<div class="modal-content" id='content_add'>
			
		</div>
      
    </div>
  </div>

<script>
function changeBS(){
	var st = $("#search_statusHeader").val();
	var tb = 'search_BS';
    jQuery.ajax({
       type:"POST",
       url: '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/CalendarOff/ChangeBS',
	   data : { 
			"st": st,
			"tb": tb,
		},
       success:function(data){
		    $("#bs_content").html(data);
       }  
    });
}
function addNewHeader(){
    $("#search_BS").val("");
    $("#search_statusHeader").val("");
    jQuery.ajax({
       type:"POST",
       url: '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/CalendarOff/Add',
       success:function(data){
		    $("#content_add").html(data);
		    $("#myModal2").modal({backdrop: false});
            //$("#content_admin").html(data);
       }  
    }); 
}
function changePagepagelistheader(cur_page){
    var selectBox = document.getElementById("pagelisthead_text_page");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;

    var search_statusHeader = $("#search_statusHeader").val();
    var search_BS = $("#search_BS").val();
    jQuery.ajax({  type        : 'POST', 
                    url         : '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/CalendarOff/List',
                    data        : { 
                                    "cur_page": cur_page,
                                    "search_BS": search_BS,
                                    "search_statusHeader": search_statusHeader,
                                    "lpp":selectedValue,
                    },
                    success     : function(data){ 
                                       if(  data != '-1'){
                                            jQuery("#listHeader").fadeOut( 100 , function() {
                                                jQuery(this).html( data);
                                            }).fadeIn( 600 );
                                       }else{
                                            alert('Data not found','Notice');
                                    }
                    }
                });  
}
function pagelistheader(cur_page){
    var search_statusHeader = $("#search_statusHeader").val();
    var search_BS = $("#search_BS").val();
    var lpp=$("#pagelisthead_text_page").val();
    jQuery.ajax({  type        : 'POST',
                    url         : '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/CalendarOff/List',
                    data        : { 
                                    "cur_page": cur_page,
                                    "search_BS": search_BS,
                                    "search_statusHeader": search_statusHeader,
                                    "lpp":lpp,
                    },
                    success     : function(data){ 
                                       if(  data != '-1'){
                                            jQuery("#listHeader").fadeOut( 100 , function() {
                                                jQuery(this).html( data);
                                            }).fadeIn( 600 );
                                       }else{
                                            alert('Data not found','Notice');
                                    }
                    }
                });
}

</script>
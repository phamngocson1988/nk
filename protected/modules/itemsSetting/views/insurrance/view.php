<input type="hidden" id="baseUrl" value="<?php echo Yii::app()->baseUrl?>"/>
<div class="row" style='margin-top:20px'>
    <div class="col-sm-12">
          <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">
                        <label>Tên bảo hiểm</label>
                        <input type="text" class="form-control" id="search_descriptionHeader" onkeypress="runpagelistheader(event);"/>
                    </div>
					<div class="col-sm-4">
                        <label>Mã bảo hiểm</label>
                        <input type="text" class="form-control" id="search_statusHeader" onkeypress="runpagelistheader(event);"/>
                    </div>
					<div class="col-sm-4 text-right" style='padding-top:22px'>
						<input type="button" class="btn btn-default" onclick="pagelistheader(1);" value="Tìm" style="width: 75px;" />
						<input type="button" class="btn btn-default" onclick="addNewHeader();" value="Thêm" style="width: 75px;margin-left: 15px;" />
					</div>
					
                </div>  
          </div>
         
    </div>
</div>
<div class="row" id="listHeader">
    <?php 
        $lpp=5;
        $this->renderPartial('list',array('value12'=>$lpp,'list_data'=>$listdata));
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
function addNewHeader(){
    $("#search_descriptionHeader").val("");
    $("#search_statusHeader").val("");
    jQuery.ajax({
       type:"POST",
       url: '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/Insurrance/Add',
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

    var search_descriptionHeader=$("#search_descriptionHeader").val();
    var search_statusHeader=$("#search_statusHeader").val();
    jQuery.ajax({  type        : 'POST', 
                    url         : '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/Insurrance/List',
                    data        : { 
                                    "cur_page": cur_page,
                                    "search_descriptionHeader": search_descriptionHeader,
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
    var search_descriptionHeader=$("#search_descriptionHeader").val();
    var search_statusHeader=$("#search_statusHeader").val();
    var lpp=$("#pagelisthead_text_page").val();
    jQuery.ajax({  type        : 'POST',
                    url         : '<?php echo Yii::app()->baseUrl?>'+'/itemsSetting/Insurrance/List',
                    data        : { 
                                    "cur_page": cur_page,
                                    "search_descriptionHeader": search_descriptionHeader,
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
function runpagelistheader(e) {
    if (e.keyCode == 13) {
        var page_1 = $('#id_text_pagelistheader').val();
        if(page_1)
            pagelistariport(page_1);
        else
            pagelistariport('1');
            
    }
}
</script>
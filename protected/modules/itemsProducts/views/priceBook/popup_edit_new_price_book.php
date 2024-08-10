

<div class="modal-header popHead sHeader">
  <a class="btn_close" data-dismiss="modal" aria-label="Close"></a>
  <h5>Chỉnh Sửa Bảng Giá</h5>
</div> 
<form id="frm-price-book-new<?php echo $value["id"];?>" onsubmit="return false;"> 
  <div class="modal-body">
      <div class="rg-row">    
        <div class="col-md-12">              
          <div class="rg-row">
            <div class="col-sm-6">
              <div class="form-group">
                <span>Tên bảng giá</span>
                <input readonly class="form-control" name="name" type="text" value="<?php echo $value['name'];?>"> 
              </div>
            </div>
            <div class="col-sm-6">  
              <div class="form-group">
                <span>Nhóm khách hàng</span>
                <?php
                $list_segment = array();  

                foreach($model->getListSegment() as $temp){
                  $list_segment[$temp['id']] = $temp['name'];
                }

                echo CHtml::dropDownList('id_segment','',$list_segment,array('readonly'=>'readonly','class'=>'form-control','empty' => 'Chọn nhóm','options'=>array($value['id_segment']=>array('selected'=>true))));
                ?>  
              </div>
            </div>                   
          </div>   

          <div class="rg-row">
            <div class="col-sm-6">
              <div class="form-group">
                <span>Dịch vụ <span style="color:red;">*</span></span><br>                        
                <select required class="form-control service" name="id_service[]" multiple="multiple" style="margin: 0">
                  <?php  
                  $CsServiceType = CsServiceType::model()->findAll("status = 1");
                  foreach($CsServiceType as $gt){     
                    $CsService = CsService::model()->findAllByAttributes(array('id_service_type' => $gt['id'], 'status' => 1));
                    if(count($CsService)>0){?>  
                      <optgroup label='<?php echo $gt['name'];?>'> 
                        <?php foreach($CsService as $tg){ ?>
                          <option value="<?php echo $tg['id'];?>"><?php echo $tg['name'];?></option>
                        <?php }?> 
                      </optgroup>
                    <?php }
                  }?>

                </select>                                         
              </div>
            </div>
            <div class="col-sm-6"> 
              <div class="form-group">
                <span>Phần trăm giảm giá dịch vụ <span style="color:red;">*</span></span><br>  
                <div class="input-group">

                  <input required type="number" class="form-control" name="percent_discount" max="100" min="0" value="">

                  <span class="input-group-addon">%</span>

                </div>

              </div>
            </div>                   
          </div>  

          <div class="rg-row">                 
            <div class="col-sm-6"> 
              <div class="form-group">

                <span>Phần trăm lương bác sĩ <span style="color:red;">*</span></span><br>  

                <div class="input-group">

                  <input required type="number" class="form-control" name="percent_doctor" max="100" min="0" value=0>

                  <span class="input-group-addon">%</span>

                </div>

              </div>
            </div>

          </div>
        </div>                       
      </div>   
  </div> 
  <div class="modal-footer" style="border-top:0px;padding: 15px 10px 15px 0px;">
    <button type="button" class="btn btn_cancel" data-dismiss="modal">Hủy</button>
    <button type="submit" class="btn btn_bookoke" onclick="updateNewPriceBook(<?php echo $value['id'];?>);">Cập nhật</button>
  </div>
</form>

<style type="text/css">
  #editNewPriceBookModal .multiselect-item.multiselect-filter > div > input {
    margin:0 !important;
  }
  #editNewPriceBookModal li:hover,#editNewPriceBookModal li a:hover {
    background: rgb(243, 243, 243);
  }
</style>

<script>
$(document).ready(function() {
    $('.staff').multiselect({
        enableClickableOptGroups: true,
        enableCollapsibleOptGroups: true
    }); 
    $('.service').multiselect({
        includeSelectAllOption: true,
        enableClickableOptGroups: true,
        enableCollapsibleOptGroups: true,
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
    }); 
});
</script>
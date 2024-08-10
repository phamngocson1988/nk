<form id="frm-price-book<?php echo $value['id'];?>" onsubmit="return false;"> 
      <div class="modal-content">
        <div class="modal-header popHead sHeader" style="height:auto">
            <a class="btn_close" data-dismiss="modal" aria-label="Close"></a>
            <h5>Chỉnh Sửa Bảng Giá</h5>
         </div> 
         
        <div class="modal-body">
            <div class="rg-row">    
              <div class="col-md-12">              
                <div class="rg-row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <span>Tên bảng giá <span style="color:red;">*</span></span>
                            <input required class="form-control" name="name" type="text" value="<?php echo $value['name'];?>"> 
                        </div>
                    </div>
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <span>Nhóm khách hàng <span style="color:red;">*</span></span>
                            <?php
                            $list_segment = array();  
                            foreach($model->getListSegment() as $temp){
                              $list_segment[$temp['id']] = $temp['name'];
                            }
                            echo CHtml::dropDownList('id_segment','',$list_segment,array('required'=>'required','class'=>'form-control','empty' => 'Chọn nhóm','options'=>array($value['id_segment']=>array('selected'=>true))));
                            ?>  
                        </div>
                    </div>                   
                </div>   
                <div class="rg-row">
                    <div class="col-sm-6">
                        <div class="form-group">
                        <span>Dịch vụ <span style="color:red;">*</span></span><br>                        
                              <select required class="form-control service" name="id_service[]" multiple="multiple">
                                      <?php  
                                      $CsServiceType = CsServiceType::model()->findAll("status = 1");
                                      foreach($CsServiceType as $gt){
                                      $CsService = CsService::model()->findAllByAttributes(array('id_service_type' => $gt['id'], 'status' => 1));
                                      if(count($CsService)>0){?>  
                                      <optgroup label='<?php echo $gt['name'];?>'>                                        
                                      <?php foreach($CsService as $tg){ 
                                        $selected = $model->getSelectedService($value['id'],$tg['id']);
                                      ?>
                                      <option <?php echo $selected;?> value="<?php echo $tg['id'];?>"><?php echo $tg['name'];?></option>
                                      <?php }?> 
                                      </optgroup>
                                  <?php }}?>                         
                              </select>                                                       
                        </div>
                    </div>
                    <div class="col-sm-6"> 
                         <div class="form-group">
                          <span>Phần trăm giảm giá dịch vụ <span style="color:red;">*</span></span><br>  
                          <div class="input-group">
                          <input required type="number" class="form-control" name="percent_discount" max="100" min="0" value="<?php echo $value['percent_discount'];?>">
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
                        <input required type="number" class="form-control" name="percent_doctor" max="100" min="0" value="<?php echo $value['percent_doctor'];?>">
                        <span class="input-group-addon">%</span>
                        </div>
                      </div>
                  </div>
                  <div class="col-sm-6"> 
                       <div class="form-group">
                        <span>Loại tiền <span style="color:red;">*</span></span>                       
                        <select required class="form-control" name="currency_code">
                          <option <?php if($value['currency_code'] == "VND") echo "selected";?> value="VND">VND</option>
                          <option <?php if($value['currency_code'] == "CAD") echo "selected";?> value="CAD">CAD</option>
                          <option <?php if($value['currency_code'] == "CHF") echo "selected";?> value="CHF">CHF</option>
                          <option <?php if($value['currency_code'] == "DKK") echo "selected";?> value="DKK">DKK</option>
                          <option <?php if($value['currency_code'] == "EUR") echo "selected";?> value="EUR">EUR</option>
                          <option <?php if($value['currency_code'] == "GBP") echo "selected";?> value="GBP">GBP</option>
                          <option <?php if($value['currency_code'] == "HKD") echo "selected";?> value="HKD">HKD</option>
                          <option <?php if($value['currency_code'] == "INR") echo "selected";?> value="INR">INR</option>
                          <option <?php if($value['currency_code'] == "JPY") echo "selected";?> value="JPY">JPY</option>
                          <option <?php if($value['currency_code'] == "KRW") echo "selected";?> value="KRW">KRW</option>
                          <option <?php if($value['currency_code'] == "KWD") echo "selected";?> value="KWD">KWD</option>
                          <option <?php if($value['currency_code'] == "MYR") echo "selected";?> value="MYR">MYR</option>
                          <option <?php if($value['currency_code'] == "NOK") echo "selected";?> value="NOK">NOK</option>
                          <option <?php if($value['currency_code'] == "RUB") echo "selected";?> value="RUB">RUB</option>
                          <option <?php if($value['currency_code'] == "SAR") echo "selected";?> value="SAR">SAR</option>
                          <option <?php if($value['currency_code'] == "SEK") echo "selected";?> value="SEK">SEK</option>
                          <option <?php if($value['currency_code'] == "SGD") echo "selected";?> value="SGD">SGD</option>
                          <option <?php if($value['currency_code'] == "THB") echo "selected";?> value="THB">THB</option>
                          <option <?php if($value['currency_code'] == "USD") echo "selected";?> value="USD">USD</option>                  
                        </select>
                      </div> 
                  </div>
                  </div>
                <div class="rg-row">                 
                  <div class="col-sm-6"> 
                     <div class="form-group">
                          <div onclick="edit_effect(<?php echo $value['id'];?>)" class="slider_holder staffhours sliderdone">            
                            <input name="effect" type="hidden" value="<?php echo $value['effect'];?>">
                            <span name="off_effect" class="slider_off sliders <?php if($value['effect'] == 0) echo "Off";?>"> TẮT </span>
                            <span name="on_effect" class="slider_on sliders <?php if($value['effect'] == 0) echo "On";?>"> BẬT </span>
                            <span name="switch_effect" class="slider_switch <?php if($value['effect'] == 0) echo "Switch";?>"></span>
                          </div>                       
                          <span style="margin-left:10px;">Hiệu lực</span>  
                        </div>
                  </div>
                  <div class="col-sm-6"> 
                     <div class="form-group">
                           <div name="change_time" <?php if($value['effect'] == 1) echo 'onclick="edit_time('.$value['id'].')"';?> class="slider_holder staffhours sliderdone">            
                            <input name="hidden_time" type="hidden" value="<?php if($value['start_time'] == '0000-00-00 00:00:00' && $value['end_time'] == '0000-00-00 00:00:00') echo 0; else echo 1;?>">
                            <span  name="off_time" class="slider_off sliders <?php if($value['start_time'] == '0000-00-00 00:00:00' && $value['end_time'] == '0000-00-00 00:00:00') echo "Off";?>"> TẮT </span>
                            <span  name="on_time" class="slider_on sliders <?php if($value['start_time'] == '0000-00-00 00:00:00' && $value['end_time'] == '0000-00-00 00:00:00') echo "On";?>"> BẬT </span>
                            <span  name="switch_time" class="slider_switch <?php if($value['start_time'] == '0000-00-00 00:00:00' && $value['end_time'] == '0000-00-00 00:00:00') echo "Switch";?>"></span>
                          </div>                          
                          <span style="margin-left:10px;">Giới hạn thời gian</span> 
                        </div>
                  </div>
                </div>            
                <div class="rg-row">                 
                  <div class="col-sm-12"> 
                     <div class="form-group">                          
                          <input type="text" class="form-control daterange <?php if($value['start_time'] == '0000-00-00 00:00:00' && $value['end_time'] == '0000-00-00 00:00:00') echo "hidden";?>" name="daterange" value="<?php if($value['start_time'] == '0000-00-00 00:00:00' && $value['end_time'] == '0000-00-00 00:00:00') echo date('m/d/Y h:mm A'); else echo date('m/d/Y h:mm A',strtotime($value['start_time']))." - ".date('m/d/Y h:mm A',strtotime($value['end_time']));?>"/>                                        
                        </div>
                  </div>
                </div>            
              </div>
            </div>  
        </div>  
        <div class="modal-footer" >   
          <button type="button" class="btn btn_delete" style="float:left;width:90px;" onclick="deletePriceBook(<?php echo $value['id'];?>);">Xóa</button>
          <button type="button" class="btn btn_cancel" data-dismiss="modal">Hủy</button>
          <button type="submit" class="btn btn_bookoke" onclick="updatePriceBook(<?php echo $value['id'];?>);">Cập nhật</button>
        </div>      
      </div>
</form>
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



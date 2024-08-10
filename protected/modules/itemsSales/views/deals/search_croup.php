      

    <li id="c0" onclick="chitietnhom(0)"  class="n active">                                                                            
                                                        <span class="jqTransformCheckboxWrapper" style="display:none;">
                                                            <a href="#" class="jqTransformCheckbox"></a>
                                                            <input type="checkbox" value="0" class="fl" style="display : none;">
                                                        </span> 
                                                        <label class="fl"><i class="fa fa-folder"></i> All </label>
                                                        <div class="clearfix"></div>
                                                    </li>
          <?php
           foreach ($model as $key => $value):?>
              <li onclick="chitietnhom(<?php echo $value['id']; ?>)" id="c<?php echo $value['id']; ?>"  class="n ">                                                                            
                <span class="jqTransformCheckboxWrapper" style="display:none;">
              <a href="#" class="jqTransformCheckbox"></a>
              <input type="checkbox" value="0" class="fl" style="display : none;">
          </span> 
          <label class="fl"><i class="fa fa-folder"></i><?php echo $value['name']; ?> </label>
          <div id="delete">
            <span class="delete popup">
                <a href="#" class="btn_deleted delete_provider" style="float:right;margin-top: 5px;margin-right: 4px;"  data-placement="bottom" id="a<?php echo $value['id'] ?>" onclick="delete_provider(<?php echo $value['id']; ?>)">
                <img data-toggle="tooltip" title="" src="<?php echo Yii::app()->params['image_url']; ?>/images/icon_sb_left/delete-def.png" alt="" style="width: 18px; height:auto;" data-original-title="Xóa tin nhắn">
                  <!-- <span class="glyphicon glyphicon-trash"></span> -->
                </a>
            </span>
            <input type="hidden" value="<?php echo $value['id']; ?>">
          <div id="deleteProvider<?php echo $value['id']; ?>" class="popover bottom deleteProvider" style="display: none;">
              <form id="frm-delete-provider" onsubmit="return false;" class="form-horizontal">
                  <div class="arrow"></div>
                  <h3 class="popover-title" style="background-color: #f8f8f8;font-size: 15px;padding: 8px 14px;">Bạn có chắc muốn xóa nhóm ?</h3>
                  <div class="popover-content" style="width:225px;">
                  <label style="margin: 10px 10px;font-size: 15px;"><?php echo $value['name']; ?></label><br>
                  <button id="yes_delete<?php echo $value['id']; ?>" onclick="deleteprovider(<?php echo $value['id']; ?>)" class="btn Submit btn_bookoke" style="padding: 6px 19px;">Xác nhận</button>
                  <button id="cancelNewCustomer" type="reset" class="cancelNewStaff  btn sCancel btn_cancel" style="float:right; padding: 6px 37px; margin-right: -20px;">Hủy</button>
                  </div>
              </form>
          </div>
         </div>   
          <div class="clearfix"></div>
          </li>
      <?php 
      endforeach;
          ?>
 <?php
 //print_r(json_encode($list_data['data']));exit;   
  $baseUrl = Yii::app()->baseUrl;?>
   

                                       
        <?php  
        if(!empty($list_data['data']))
        {  

        foreach($list_data['data'] as $k=> $value)
        {

                ?>

                <li id="c<?php echo $value['id'];?>" onclick="detailCustomer(<?php echo $value['id'];?>);"  class="n 1" >
                                                
                                                <span class="jqTransformCheckboxWrapper" style="display:none;">
                                                    <a href="#" class="jqTransformCheckbox"></a>
                                                    <input type="checkbox" value="<?php echo $value['id'];?>" class="fl" style="display : none;">
                                                </span>
                                                
                                                <img src="<?php echo $baseUrl; ?>/upload/customer/avatar/<?php if($value['image']!="") echo $value['image']; else echo "no_avatar.png";?>" class="fl" style="border-radius:100%;">
                                                <label class="fl"><?php echo $value['fullname'];?> </label>
                                                <div class="clearfix"></div>
                </li>
                
                <?php
          

        }

        }else {   ?>
            <li>Không Tìm Thấy Khách Hàng !</li>
        <?php } ?>
        
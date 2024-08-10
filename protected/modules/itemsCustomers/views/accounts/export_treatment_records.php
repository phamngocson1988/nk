<?php 
set_time_limit(999999999);
?>
<style type="text/css">

h3 {
  color:#000;
}

h4 {
  color:#4c64b4;
}

table {
  width: 100%;
}

table tbody tr td {
  color: #222;
  padding-top: 20px;
  width: 50%;
}  

.ivDt {
  width: 100%;
  border-collapse: collapse;
}
.ivDt thead tr{
  background: #8FAAB1;
  font-size: 10pt;
}
.ivDt thead th, .ivDt tbody td{
  padding: 8px auto;
  text-align: center;
  color: #fff;
  border: 1px solid #ccc;
}
.ivDt tbody td{
  color: #000;  
}

</style>

<page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm" format="Letter" backcolor="#fff" style="font: arial;font-family:freeserif;font-size:16px;">
<div style="padding-left: 20px;padding-right: 20px;">

        <div>
            <table style="margin-top: 20px;">             
              <tbody>
                <tr>
                    <td style="color: #222;">    
                      <?php echo CHtml::image('images/info.jpg', 'DORE', array('width'=>700)); ?> 
                    </td> 
                </tr>            
              </tbody>
            </table>
            
        </div> 

        <h3 align="center" style="margin-top: 50px;">HỒ SƠ ĐIỀU TRỊ</h3>

        <div>
            <table style="margin-top: 20px;">             
              <tbody>
                <tr>
                    <td style="width:20%;">    
                      <?php if($model->image) $image = $model->image; else $image = "no_avatar.png"; echo CHtml::image('upload/customer/avatar/'.$image, 'DORE', array('width'=>120)); ?> 
                    </td> 
                     <td valign="middle">    
                      <h3><?php echo $model->fullname;?></h3> 
                    </td> 
                </tr>            
              </tbody>
            </table>
            
        </div> 

        <div>

            <table>  
                <tbody>

                  <tr>
                    <td>
                        Mã số: <?php echo $model->code_number;?>
                    </td>

                    <td>
                        Quốc tịch: <?php if($model->id_country) echo $model->getCountryByCode($model->id_country);?>
                    </td>
                  </tr>

                  <tr>
                    <td>
                        Thẻ hội viên: <?php if($model->membership_card) echo $model->membership_card;?>
                    </td>

                    <td>
                        CMND/Passport: <?php if($model->identity_card_number) echo $model->identity_card_number;?>
                    </td>
                  </tr>

                  <tr>
                    <td>
                        Email: <?php if($model->email) echo $model->email;?>
                    </td>

                    <td>
                        Nguồn: <?php if($model->id_source) echo $model->getSourceById($model->id_source);?>
                    </td>
                  </tr>

                  <tr>
                    <td>
                        Số điện thoại: <?php if($model->phone) echo $model->phone;?>
                    </td>

                    <td>
                        Nhóm: <?php $selected = $model->getSelectedSegment($model->id); if($selected) echo $model->getSegmentById($selected);?>
                    </td>
                  </tr>

                  <tr>
                    <td>
                        Số sms: <?php if($model->phone_sms) echo $model->phone_sms;?>
                    </td>

                    <td>
                        Nghề nghiệp: <?php if($model->id_job) echo $model->getJobById($model->id_job);?>
                    </td>
                  </tr>

                  <tr>
                    <td>
                        Giới tính: <?php if($model->gender == 0) echo "Nam"; else echo "Nữ";?>
                    </td>

                    <td>
                        Chức vụ: <?php if($model->position == 1) echo "Nhân viên"; elseif($model->position == 2) echo "Quản lý";?>
                    </td>
                  </tr>

                  <tr>
                    <td>
                        Ngày sinh: <?php if($model->birthdate) echo date('d/m/Y',strtotime($model->birthdate));?>
                    </td>

                    <td>
                        Địa chỉ liên hệ: <?php if($model->address) echo $model->address;?>
                    </td>
                  </tr>                 

                
              </tbody>

            </table>

            
        </div> 

        <div>

          <h4>Bệnh sử y khoa:</h4>    

            
            <?php /*
            <table> 

              <tbody>                 

              <?php 

              foreach ($list_m as $k_m_a => $m_a) { 

                if(($k_m_a+1) % 2 == 1){

              ?> 

                  <tr>

                    <td>
                        <?php if(array_key_exists($m_a['id'],$list_ma)) echo CHtml::image('images/medical_record/more_icon/check_box.png', 'DORE', array('width'=>20)); else echo CHtml::image('images/medical_record/more_icon/empty_check_box.png', 'DORE', array('width'=>20));?>     <?php echo $m_a['name'];?>
                    </td>                   
              

              <?php 

                }else{

              ?>



                    <td>
                        <?php if(array_key_exists($m_a['id'],$list_ma)) echo CHtml::image('images/medical_record/more_icon/check_box.png', 'DORE', array('width'=>20)); else echo CHtml::image('images/medical_record/more_icon/empty_check_box.png', 'DORE', array('width'=>20));?>     <?php echo $m_a['name'];?>
                    </td>

                </tr>    
              
              <?php 

                }   

              }

              	if (count($list_m) % 2 == 1) {         
        
              	?>

              	</tr>

              	<?php 

          		}

              	?>

              </tbody>

            </table> 
            */ ?> 

            <?php 

            if (!empty($list_ma)) {   

            ?>

            <table> 

              <tbody>                 

              <?php                            

                foreach ($list_m as $k_m_a => $m_a) { 

                  if(($k_m_a+1) % 2 == 1){

                ?> 

                    <tr>

                      <?php

                      if(array_key_exists($m_a['id'],$list_ma)) {

                      ?>

                      <td>                          
                          <?php echo $m_a['name'];?>
                      </td>                   
                      
                      <?php 

                      }

                      ?>

                <?php 

                  }else{

                ?>

                      <?php 

                      if(array_key_exists($m_a['id'],$list_ma)) {

                      ?>

                      <td>                          
                          <?php echo $m_a['name'];?>
                      </td>                   
                      
                      <?php 

                      }

                      ?>

                  </tr>    
                
                <?php 

                  }   

                }

                  if (count($list_m) % 2 == 1) {         
          
                  ?>

                  </tr>

                  <?php 

                }            

                ?>

              </tbody>

            </table>

            <?php 

            }else{

              echo "Chưa có bệnh sử y khoa";

            }

            ?>

        </div> 

        <div>

        	<h4>Tình trạng răng:</h4>  

				

          <?php 

          $filename = 'upload/customer/dental_status_image/'.$model->code_number.'/'.$model->code_number.'-'.$id_mhg.'.png';

          if (file_exists($filename)) {


          ?>

          <div style="position:relative;width:360px;height:432px; margin:0px auto;left:25%;">

          <?php  

              echo CHtml::image($filename, 'DORE', array('width'=>350));


          ?>

          </div>
          
          <?php    

          }else {

              echo "Chưa có tình trạng răng";

          }
             

          ?> 					
				  
				
        

				<h4>Kết luận:</h4>	
				
        <?php 

        if (!empty($listToothStatus) || !empty($listOnlyToothNote)) {
          
        ?>			
				<table class="ivDt">
          <thead >
    				<tr>
    				    <th>Răng</th>
    				    <th>Bệnh</th> 
    				    <th>Ghi chú</th>
    				    <th>Chỉ định</th>
    				</tr>
          </thead>
          <tbody>
				<?php 
				if (!empty($listToothStatus)) 
				{	
				foreach ($listToothStatus as $tooth_status) 
				{

				?>		
				<tr>
				
						<td style="width:10%;">Răng <?php echo $tooth_status['tooth_number'];?></td>
						
						<td style="width:25%;">
            <?php 

              if (!empty($tooth_status['listToothConclude'])){

              $data_flag = array();

              foreach ($tooth_status['listToothConclude'] as $tooth_conclude){

                $type = explode("-", $tooth_conclude['id_i']);

                  switch ($type[1]) {

                      case 107: case 108: case 109: case 110: case 111: case 112: case 113: case 114: case 115:

                        $flag = 102;  

                        $muc = '';                      

                        if (!in_array($flag, $data_flag, false)) {
                        
                          $data_flag[] = $flag;

                            $muc='<i id="muc-'.$flag.'-'.$type[2].'" data-toggle="tooltip" title="'.$model->getNameByIdDentist($tooth_conclude["id_user"]).'">Phục hồi miếng trám</i>';

                          }

                          break;

                        case 8: case 9: case 10: case 11: case 12: case 13: case 14: case 15: case 16:

                        $flag = 1;  

                        $muc = '';                   

                        if (!in_array($flag, $data_flag, false)) {
                        
                          $data_flag[] = $flag;

                            $muc='<i id="muc-'.$flag.'-'.$type[2].'" data-toggle="tooltip" title="'.$model->getNameByIdDentist($tooth_conclude["id_user"]).'">Sâu răng</i>';
                            
                          }

                          break;  

                      case 17: case 18: case 19: case 20:

                        $flag = 2;  

                        $muc = '';                   

                        if (!in_array($flag, $data_flag, false)) {
                        
                          $data_flag[] = $flag;

                            $muc='<i id="muc-'.$flag.'-'.$type[2].'" data-toggle="tooltip" title="'.$model->getNameByIdDentist($tooth_conclude["id_user"]).'">Đau răng</i>';
                            
                          }

                          break;

                      case 21: case 22: case 23:

                        $flag = 3;  

                        $muc = '';                   

                        if (!in_array($flag, $data_flag, false)) {
                        
                          $data_flag[] = $flag;

                            $muc='<i id="muc-'.$flag.'-'.$type[2].'" data-toggle="tooltip" title="'.$model->getNameByIdDentist($tooth_conclude["id_user"]).'">Nứt răng</i>';
                            
                          }

                          break; 

                       case 24: case 25: case 26: case 27:

                        $flag = 4;  

                        $muc = '';                   

                        if (!in_array($flag, $data_flag, false)) {
                        
                          $data_flag[] = $flag;

                            $muc='<i id="muc-'.$flag.'-'.$type[2].'" data-toggle="tooltip" title="'.$model->getNameByIdDentist($tooth_conclude["id_user"]).'">Vôi răng</i>';
                            
                          }

                          break; 

                      case 28: case 29: case 30: 

                        $flag = 5;  

                        $muc = '';                   

                        if (!in_array($flag, $data_flag, false)) {
                        
                          $data_flag[] = $flag;

                            $muc='<i id="muc-'.$flag.'-'.$type[2].'" data-toggle="tooltip" title="'.$model->getNameByIdDentist($tooth_conclude["id_user"]).'">Lung lay</i>';
                            
                          }

                          break;  

                      case 31: case 32: case 33: case 34: case 35:  

                        $flag = 7;  

                        $muc = '';                   

                        if (!in_array($flag, $data_flag, false)) {
                        
                          $data_flag[] = $flag;

                            $muc='<i id="muc-'.$flag.'-'.$type[2].'" data-toggle="tooltip" title="'.$model->getNameByIdDentist($tooth_conclude["id_user"]).'">Túi nha chu</i>';
                            
                          }

                          break;                    

                      default:

                        $muc = '';
                  }

                  if ($muc) echo $muc;

            ?>
              <i><?php echo $tooth_conclude['conclude']?></i>

            <?php } } ?>

            </td>

						<td style="width:25%;"><?php echo $tooth_status['note'];?></td>

						<td style="width:40%;"><?php echo $tooth_status['assign'];?></td>
			
				</tr>					
								
				<?php }	} 
        if (!empty($listOnlyToothNote)) { 
        foreach ($listOnlyToothNote as $tooth_note) {   
        ?>
          <tr>
            <td style="width:10%;">Răng <?php echo $tooth_note['tooth_number'];?></td>

            <td style="width:25%;"></td>

            <td style="width:25%;"><?php echo $tooth_note['note'];?></td>

            <td style="width:40%;"></td>
          </tr>  
        <?php } } ?>
        </tbody>
				</table>

					
					<?php 

          } else {

            echo "Chưa có kết luận";

          }

          ?>
				
		

        </div>

        <div>

          <h4>Dịch vụ:</h4>  
          <?php 

          if (!empty($listTreatment['data'])) { 

          ?>
          <table class="ivDt">
          <thead >
            <tr>
                <th>Ngày tạo</th>
                <th>Sản phẩm và Dịch vụ</th>                
                <th>Số răng</th>
                <th>Người thực hiện</th> 
                <th>Đơn giá</th>   
                <th>Trả</th>                 
            </tr>
          </thead>
          <tbody>
        <?php 
       
        foreach ($listTreatment['data'] as $key => $treatment) {

        ?>    
        <tr>
            <td style="width:15%;"><?php echo date('d/m/Y',strtotime($treatment['create_date']));?></td>
            <td style="width:20%;text-align:left;"><?php echo $treatment['description'];?></td> 
            <td style="width:15%;"><?php echo $treatment['teeth'];?></td>
            <td style="width:16.6%;"><?php echo $treatment['user_name'];?></td>
            <td style="width:16.6%;text-align:right;"><?php echo number_format($treatment['unit_price'],0,",",".");?></td>

            <?php 

            if ($key == 0) {
             
            ?>

            <td style="width:16.6%;text-align:right;" rowspan="<?php echo count($listTreatment['data']);?>" style="width:16.6%;vertical-align: middle;"><?php echo number_format($listTreatment['pay'],0,",",".");?></td>

            <?php 

            }

            ?>

        </tr>         
                
        <?php 

        }
        
        ?>
        </tbody>
        </table>
        <?php 
        }else {

            echo "Chưa có dịch vụ";

        }
        ?>
        </div>

        <div>
          
          <h4>Công tác điều trị:</h4>  

          <?php  

          if(!empty($listTreatmentProcess)) { 

          ?>

          <table class="ivDt">
            <thead>
              <tr>
                  <th>Lần</th>
                  <th>BS điều trị</th>
                  <th>Số răng</th>
                  <th>Công tác điều trị</th>    
                  <th>Ngày tạo</th>              
              </tr>
            </thead>
          <tbody>
          
          <?php  

            $count = count($listTreatmentProcess);

            foreach($listTreatmentProcess as $k => $v) {

            $time = $count - $k;

            ?>
            <tr>   

                <td style="width:10%;"><?php echo $time;?></td>
                <td style="width:20%;">BS. <?php echo $v['gp_users_name'];?></td>  
                <td style="width:20%;">   
                  <?php 
                  foreach ($v['listTreatmentWork'] as $key => $value) {
                    echo $value['tooth_numbers']."<br>";
                  }
                  ?>      
                </td> 
                <td style="width:35%;text-align:left;">   
                  <?php 
                  foreach ($v['listTreatmentWork'] as $key => $value) {
                    echo $value['treatment_work']."<br>";
                  }
                  ?>      
                </td> 
                <td style="width:15%;"><?php echo date('d/m/Y',strtotime($v['createdate']));?></td>    

            </tr>            
          <?php 

            }

          ?>
          </tbody>
          </table>
          <?php   

          } else {

            echo "Chưa có công tác điều trị";

          }

          ?>

        </div>

      
</div>
</page>


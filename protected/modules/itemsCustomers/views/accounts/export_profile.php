<?php $baseUrl = Yii::app()->baseUrl;?>
<style>

h3, h4 {
  color:#000;
}

table {
  width: 100%;
}

table tbody tr td {
  color: #222;
  padding-top: 20px;
  width: 50%;
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

        <h3 align="center" style="margin-top: 50px;">HỒ SƠ KHÁCH HÀNG</h3>

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

      
</div>
</page>


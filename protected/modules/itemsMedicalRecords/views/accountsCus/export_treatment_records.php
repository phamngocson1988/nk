<style type="text/css">
h3 {color:#000; margin-top:10px; margin-bottom: 10px;}
h4 {color:#4c64b4;  margin-top:10px; margin-bottom: 10px;}
table {width: 100%;}
table tbody tr td {color: #222;width: 50%;}  
.ivDt {width: 100%;border-collapse: collapse;}
.ivDt thead tr{background: #8FAAB1;font-size: 10pt;}
.ivDt thead th, .ivDt tbody td{padding: 8px 4px;text-align: center;color: #fff;border: 1px solid #ccc;}
.ivDt tbody td{color: #000;}
.mr-top-50{margin-top: 50px;}
.mr-top-20{margin-top: 20px;}
div{margin-bottom: 5px;}
</style>

<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm" format="Letter" backcolor="#fff" style="font: arial;font-family:freeserif;font-size:16px;">
  <div>
      <table>             
        <tbody>
          <tr>
              <td style="color: #222;">    
                <?php echo CHtml::image('images/info.jpg', 'DORE', array('width'=>700)); ?> 
              </td> 
          </tr>            
        </tbody>
      </table>
  </div>
  <h3 align="center" class="mr-top-50">HỒ SƠ ĐIỀU TRỊ</h3>
  <table class="mr-top-20">             
    <tbody>
      <tr>
          <td style="width:20%;">    
            <?php if($model->image) $image = $model->image; else $image = "no_avatar.png"; echo CHtml::image('upload/customer/avatar/'.$image, 'DORE', array('width'=>130)); ?> 
          </td> 
          <td valign="middle" style="width:80%;">    
            <h3><?php echo $model->fullname;?></h3>
            <div>Mã số: <?php echo $model->code_number;?></div> 
            <div>Email: <?php if($model->email) echo $model->email;?></div>
            <div>Số điện thoại: <?php if($model->phone) echo $model->phone;?></div>
            <div>Ngày sinh: <?php if($model->birthdate) echo date('d/m/Y',strtotime($model->birthdate));?></div>
          </td> 
      </tr>            
    </tbody>
  </table> 
  <h4 class="mr-top-20">Bệnh sử y khoa:</h4>  
  <div>
    <?php if (!empty($list_ma)) {   ?>
      <table> 
        <tbody>                 
        <?php                            
          foreach ($list_m as $k_m_a => $m_a) { 
           
        ?> 
              <tr>
                <?php if(array_key_exists($m_a['id'],$list_ma)) { ?>
                  <td>                          
                      <?php echo $m_a['name'];?>
                  </td>                   
                <?php } ?>
              </tr>
        <?php } ?>  
        </tbody>
      </table>
    <?php }else{ echo "Chưa có bệnh sử y khoa";} ?>
  </div> 
  <h4>Tình trạng răng:</h4>  
  <?php 
        $filename = 'upload/customer/dental_status_image/'.$model->code_number.'/'.$model->code_number.'-'.$id_mhg.'.png';
        if (file_exists($filename)) {
  ?>
        <div style="position:relative;width:350px; margin:0px auto;left:25%;">
          <?php  
              echo CHtml::image($filename, 'DORE', array('width'=>300));
          ?>
        </div>
  <?php    
    }else {
        echo "Chưa có tình trạng răng";
    }      
  ?> 
  <h4>Kết luận:</h4> 
  <table class="ivDt">
    <thead>
      <tr>
        <th style="width: 10%">Số răng</th>
        <th style="width: 20%">Vị trí</th>
        <th style="width: 35%">Chẩn đoán</th>
        <th style="width: 35%">Diễn giải</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $i = 0;
        if (!empty($listToothStatus)) :
          foreach ($listToothStatus as $tooth_status) :
            $i++;
      ?>  
        <tr>
          <td class="sorang" style="width: 10%">
            <span>
              Răng <?php echo $tooth_status['tooth_number'];?>
            </span>
          </td>
          <td class="text-left" style="width: 20%">
            <?php 
            if (!empty($tooth_status['listToothConclude'])){    
              foreach ($tooth_status['listToothConclude'] as $tooth_conclude){ 
            ?>
            <span id="<?php echo $tooth_conclude['id_i']?>"  data-user="<?php echo $tooth_conclude['id_user'];?>" data-toggle="tooltip" title="<?php echo $model->getNameByIdDentist($tooth_conclude['id_user']);?>">
              <?php 
                echo $tooth_conclude['conclude'];
              ?>  
            </span>
            <?php 
              }
            } 
            ?>
          </td>
          <td style="width: 35%">
           <?php echo $tooth_status['diagnose']; ?>
          </td>
          <td style="width: 35%">
           <?php echo $tooth_status['explain']; ?>
          </td>
        </tr>
      <?php 
          endforeach;
        endif;
      ?>
    </tbody>
  </table>
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
          foreach ($listTreatment['data'] as $key => $treatment){
        ?>    
          <tr>
              <td style="width:15%;">
                <?php echo date('d/m/Y',strtotime($treatment['create_date']));?>
              </td>
              <td style="width:20%;text-align:left;">
                <?php echo $treatment['description'];?>
              </td> 
              <td style="width:15%;">
                <?php echo $treatment['teeth'];?>
              </td>
              <td style="width:16.6%;">
                <?php echo $treatment['user_name'];?>
              </td>
              <td style="width:16.6%;text-align:right;">
                <?php echo number_format($treatment['unit_price'],0,",",".");?>
              </td>
              <?php if ($key == 0) { ?>
              <td style="width:16.6%;text-align:right;" rowspan="<?php echo count($listTreatment['data']);?>" style="width:16.6%;vertical-align: middle;"><?php echo number_format($listTreatment['pay'],0,",",".");?></td>
              <?php } ?>
          </tr>         
                  
          <?php } ?>
      </tbody>
    </table>
  <?php 
    }else {
        echo "<div>Chưa có dịch vụ</div>";
    }
  ?>
  <h4 class="mr-top-20">Công tác điều trị:</h4> 
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
    <?php } ?>
    </tbody>
  </table>
  <?php   
    } else {
      echo "Chưa có công tác điều trị";
    }
  ?> 
</page>


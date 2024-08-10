<?php 
set_time_limit(999999999);
?>
<style type="text/css">

h3 {
  color:#000;
}

h4 {
  color:#4c64b4;
  line-height: 0;  
}

table {
  width: 100%;
}



table tbody tr td {
  color: #222;
  padding-top: 10px;
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

        <h2 align="center" style="margin-top: 30px;">HỒ SƠ ĐIỀU TRỊ</h2>

        

        <div>

            <h4>THÔNG TIN:</h4>

            <table>  


                <tbody>

                  <tr>
                    <td>
                        Họ tên: <?php echo $model->fullname;?>
                    </td>        
                    <td>
                        Giới tính: <?php if($model->gender == 0) echo "Nam"; else echo "Nữ";?>
                    </td>            
                  </tr>

                  <tr>
                    <td>
                        Ngày sinh: <?php if($model->birthdate) echo date('d/m/Y',strtotime($model->birthdate));?>
                    </td>
                    <td>
                        Điện thoại: <?php if($model->phone) echo $model->phone;?>
                    </td>  
                  </tr>


                                 

                
              </tbody>

            </table>

            
        </div> 

        <div>

          <h4>BỆNH SỬ:</h4>  
            

            

            <table> 

              <tbody>                 

              <?php     

                if (!empty($list_ma)) {                          

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

                }else{


                ?>               
          
                <tr>
                  <td>                          
                      Chưa có bệnh sử
                  </td> 
                </tr>

                <?php 
                  

                }         

                ?>

              </tbody>

            </table>

           

        </div> 

        <div>
				  
				
        

				<h4>KẾT LUẬN:</h4>	
				
       
				<table>

          <tbody>
				<?php 

        if (!empty($listToothStatus) || !empty($listOnlyToothNote)) {

				if (!empty($listToothStatus)) 
				{	
				foreach ($listToothStatus as $tooth_status) 
				{

				?>		
				<tr>
				
						<td style="width:33.3%;text-align:left;">Số răng: <?php echo $tooth_status['tooth_number'];?></td>		

						<td style="width:33.3%;text-align:left;">Ghi chú: <?php echo $tooth_status['note'];?></td>

						<td style="width:33.3%;text-align:left;">Chỉ định: <?php echo $tooth_status['assign'];?></td>
			
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
        <?php } } 

        } else {


        ?>

        <tr>
          <td>                          
              Chưa có kết luận
          </td> 
        </tr>


        <?php        

           

        }

        ?>
        </tbody>
				</table>

					
						
		      

        </div>   

        <div>

        <table>   
        <tbody>
        <tr>
        <td>
        <?php echo $evaluateStateOfTartar->evaluate_state_of_tartar;?>
        </td>
        </tr>
        </tbody>
         </table>  

        </div>

      
</div>
</page>


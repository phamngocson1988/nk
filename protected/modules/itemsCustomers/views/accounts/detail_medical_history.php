
<div id="oInfo" class="col-md-12">
    <div class="row">
        <div class="col-md-12">  
            <div class="row">        
                <div class="col-xs-4">   
                    <span>
                        Ngày tái khám:
                    </span>
                    <span>
                        <?php if($v['reviewdate']!=0) echo date('d/m/Y H:m:s',strtotime($v['reviewdate'])); else echo "Không";?>
                    </span>
                </div> 

                <div class="col-xs-8">   
                    <span>Ghi chú:</span>
                    <span><?php if($v['description']!="") echo $v['description']; else echo "Không";?></span>
                </div> 

            </div>
        </div>
        <div class="col-xs-12 oViewB" style="padding: 0; margin: 0">
            <table class="table">
                <thead>
                    <tr style="display: flex;">
                        <th style="width: 20%;border: 1px solid #ddd !important;padding: 6px 15px !important;">Số răng</th>
                        <th style="width: 80%;border: 1px solid #ddd !important;padding: 6px 15px !important;">Công tác điều trị</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($v['listTreatmentWork'] as $key => $value) {
                    ?>
                     <tr style="display: flex;">
                        <td style="width: 20%; text-align: center; border: 1px solid #ddd !important;padding: 6px 15px !important;"><?php echo $value['tooth_numbers']; ?></td>
                        <td style="width: 80%;text-align: center; border: 1px solid #ddd !important;;padding: 6px 15px !important;"><?php echo $value['treatment_work']; ?></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>

        </div>
    </div>

</div>



<?php 	$b=new Branch;
		$b_all=$b->findAll(); ?>
<?php $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array(  
        'enctype' => 'multipart/form-data'
		),
)); ?>
<script src="<?php echo Yii::app()->baseUrl.'/ckeditor/ckeditor.js'; ?>"></script>
<div id="box_title_content" class="row clearfix" >
        <label class="col-xs-8 col-sm-9 col-md-9">
            <?php if($model->isNewRecord == 1){ ?>
                <h3>Create Product </h3>
            <?php }else{ ?>
            <h3>Update Product <?php echo $model->id; ?></h3>
            <?php } ?>     
        </label>  
        <div class="col-xs-4 col-sm-3 col-md-3 form-actions text-right margin-top-10">  
            <?php 
                $this->widget(
                    'booster.widgets.TbButton',
                    array(
                        'context' => 'success',
                        'label' => $model->isNewRecord ? 'Add' : 'Save',
                        'buttonType' => 'submit',
                    )
                );
            ?>
        </div>
    </div>
	<div>
		<ul class="nav nav-tabs">
		    <li class="active"><a data-toggle="tab" href="#menu2"> Sản Phẩm</a></li>
		    <li><a data-toggle="tab" href="#menu3">Tồn kho</a></li>
	  	</ul>
	  	<div class="tab-content">
	  		<div id="menu2" class="tab-pane fade in active">
				<p class="help-block">Fields with <span class="required">*</span> are required.</p>
				<input type="hidden" value="" id="hidden_inventory_increase" name="hidden_inventory_increase">
                <input type="hidden" value="" id="hidden_inventory_decrease" name="hidden_inventory_decrease">
                <input type="hidden" value="" id="ud_hidden_inventory_increase_<?php echo $model->id;?>" name="ud_hidden_inventory_increase">
                <input type="hidden" value="" id="ud_hidden_inventory_decrease_<?php echo $model->id;?>" name="ud_hidden_inventory_decrease">
				<?php echo $form->errorSummary($model); ?>
				<?php echo $form->dropDownListGroup($model,'id_product_line',array('widgetOptions'=>array('data'=>CHtml::listData(ProductLine::model()->findAll(),'id', 'name'),'htmlOptions'=>array('empty'=>'--Choose Product Line--','required'=>'required')))); ?>

				<ul class="nav nav-tabs" style="margin-top: 15px;">
			        <li class="active"><a data-toggle="tab" href="#n1">Name Vi</a></li>
			        <li><a data-toggle="tab" href="#n2">Name En</a></li>
			    </ul>
			    <div class="tab-content" style="padding:15px 0;">
			        <div id="n1" class="tab-pane fade in active">
			          <?php echo $form->textFieldGroup($model,'name',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>765)))); ?>
			        </div>
			        <div id="n2" class="tab-pane fade in ">
			          <?php echo $form->textFieldGroup($model,'name_en',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>765)))); ?>
			        </div>
			    </div>
			    <ul class="nav nav-tabs" style="margin-top: 15px;">
			        <li class="active"><a data-toggle="tab" href="#d1">Description Vi</a></li>
			        <li><a data-toggle="tab" href="#d2">Description En</a></li>
			    </ul>
			    <div class="tab-content" style="padding:15px 0;">
			        <div id="d1" class="tab-pane fade in active">
			          	<?php echo $form->labelEx($model,'description'); ?>
					    <?php echo $form->textArea($model, 'description', array('id'=>'editor1')); ?>
					    <?php echo $form->error($model,'description'); ?>
					 
						<script type="text/javascript">
						     CKEDITOR.replace( 'editor1', {
					         filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
					         filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
					         filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
					         filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
					         filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
					         filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
					    });
						</script>
			        </div>
			        <div id="d2" class="tab-pane fade in ">
			           <?php echo $form->labelEx($model,'description_en'); ?>
					    <?php echo $form->textArea($model, 'description_en', array('id'=>'editor2')); ?>
					    <?php echo $form->error($model,'description_en'); ?>
					 
						<script type="text/javascript">
						     CKEDITOR.replace( 'editor2', {
					         filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
					         filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
					         filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
					         filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
					         filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
					         filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
					    });
						</script>
			        </div>
			    </div>

			    <ul class="nav nav-tabs" style="margin-top: 15px;">
			        <li class="active"><a data-toggle="tab" href="#in1">Instruction Vi</a></li>
			        <li><a data-toggle="tab" href="#in2">Instruction En</a></li>
			    </ul>
			    <div class="tab-content" style="padding:15px 0;">
			        <div id="in1" class="tab-pane fade in active">
			          	<?php echo $form->labelEx($model,'instruction'); ?>
					    <?php echo $form->textArea($model, 'instruction', array('id'=>'editor3')); ?>
					    <?php echo $form->error($model,'instruction'); ?>
					 
						<script type="text/javascript">
						     CKEDITOR.replace( 'editor3', {
					         filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
					         filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
					         filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
					         filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
					         filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
					         filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
					    });
						</script>
			        </div>
			        <div id="in2" class="tab-pane fade in ">
			            <?php echo $form->labelEx($model,'instruction_en'); ?>
					    <?php echo $form->textArea($model, 'instruction_en', array('id'=>'editor4')); ?>
					    <?php echo $form->error($model,'instruction_en'); ?>
					 
						<script type="text/javascript">
						     CKEDITOR.replace( 'editor4', {
					         filebrowserBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=files',
					         filebrowserImageBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=images',
					         filebrowserFlashBrowseUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/browse.php?type=flash',
					         filebrowserUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=files',
					         filebrowserImageUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=images',
					         filebrowserFlashUploadUrl: '<?php echo Yii::app()->baseUrl; ?>/kcfinder/upload.php?type=flash'
					    });
						</script>
			        </div>
			    </div>

				
				

				<?php echo $form->textFieldGroup($model,'price',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

				<?php echo $form->textFieldGroup($model,'stock',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

				<?php echo $form->textFieldGroup($model,'discount',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>

				<?php echo $form->textFieldGroup($model,'unit',array('widgetOptions'=>array('htmlOptions'=>array('maxlength'=>765)))); ?>

				<?php echo $form->textFieldGroup($model,'postdate',array('widgetOptions'=>array('htmlOptions'=>array()))); ?>
				<input type="text" style='display:none' class="form-control col-md-6" id="Product_postdate" name="Product_postdate" />
				<?php echo $form->switchGroup($model, 'status_product',
					array(
						'widgetOptions' => array(
							'events'=>array(
								'switchChange'=>'js:function(event, state) {
								  console.log(this); // DOM element
								  console.log(event); // jQuery event
								  console.log(state); // true | false
								}'
							)
						)
					)
				); ?>
			 	<?php echo $form->switchGroup($model, 'status_hiden',
					array(
						'widgetOptions' => array(
							'events'=>array(
								'switchChange'=>'js:function(event, state) {
								  console.log(this); // DOM element
								  console.log(event); // jQuery event
								  console.log(state); // true | false
								}'
							)
						)
					)
				); ?>
			</div> <!-- end sp-->
			<div id="menu3" class="tab-pane fade">
			<?php if($model->isNewRecord == 1){ ?>
				<div class="rg-row">
					<div class="col-md-12">
                        <h5>Tồn kho</h5>
                        <a id="stock-control"></a>
                    </div>
			        <div class="col-md-12">
			               <table class="table table-no-side-padding table-middle table-not-bordered">
			                   <thead>
			                       <tr>
			                           <th>Vị trí</th>
			                           <th><a class="tip-init" data-original-title="The amount of stock available for sale">Có sẵn</a></th>
			                           <th></th>
			                           <th></th>
			                           <th><a class="invisible tip-init" data-original-title="When stock reaches this level we will alert you via an app notification and email">Alert</a></th>
			                       </tr>
			                   </thead>
			                   <tbody>
			                       
			                    <?php 
			                    foreach($b_all as $v) 
			                    {                                                   
			                    ?>
			                    <tr data-location-id="68002">
			                        <td>
			                            <?php echo $v['name'];?>
			                        </td>
			                        <td class="quantity-public-label" id="quantity-public-label-<?php echo $v['id'];?>">Không giới hạn</td>
			                        <td>
			                            <div class="btn-group btn-adjust-stock">
			                                <a href="javascript:void(0);" class="btn btn-sm quantity-increase" onclick="openIncreasePopup(<?php echo $v['id'];?>);" data-location-id="68002"><i class="fa fa-plus"></i></a>
			                                <a href="javascript:void(0);" class="btn btn-sm quantity-decrease" onclick="openDecreasePopup(<?php echo $v['id'];?>);" data-location-id="68002"><i class="fa fa-minus"></i></a>
			                            </div>
			                        </td>
			                    
			                    </tr>
			                    <?php 
			                    }
			                    ?>
			                   </tbody>
			               </table>
			               
			        </div>
			    </div>
			<?php }else{?>
				<div class="rg-row">
                    <div class="col-md-12">
                        <p style="margin:15px 0px;"><span style="color:#333;font-weight: bold;">Sản phẩm:</span><span> <?php echo $model->name; ?></span></p>
                        <h5>Tồn kho</h5>
                        <a id="stock-control"></a>
                    </div>

                    <div class="col-md-12">
                           <table class="table table-no-side-padding table-middle table-not-bordered">
                               <thead>
                                   <tr>
                                       <th>Vị trí</th>
                                       <th><a class="tip-init" data-original-title="The amount of stock available for sale">Có sẵn</a></th>
                                       <th></th>
                                       <th></th>
                                       <th></th>
                                       <th><a class="invisible tip-init" data-original-title="When stock reaches this level we will alert you via an app notification and email">Alert</a></th>
                                   </tr>
                               </thead>
                               <tbody>
                                   
                                <?php 
                                foreach($b_all as $v) 
                                {                                                   
                                ?>
                                <tr data-location-id="68002">
                                   
                                    <td><?php echo $v['name'];?></td>                                                    
                                    <td class="quantity-public-label" id="ud-quantity-public-label-<?php echo $v['id'];?><?php echo $model->id;?>"><?php
                                    $pii=new ProductInventoryIncrease;
                                    $pid=new ProductInventoryDecrease;
                                    $dtpii=$pii->findAllByAttributes(array('id_product'=>$model->id,'id_branch'=>$v['id']));
                                    $dtpid=$pid->findAllByAttributes(array('id_product'=>$model->id,'id_branch'=>$v['id']));  
                                    $sum=0;
                                    $minus=0;
                                    $result=0;
                                    if($dtpii){                                                        
                                        foreach ($dtpii as $va) 
                                        {
                                           $sum+=$va['available'];
                                        }
                                    }
                                    if($dtpid)
                                    {                                                        
                                        foreach ($dtpid as $va) 
                                        {
                                           $minus+=$va['available'];
                                        }
                                    }
                                    $result=$sum-$minus;
                                    if($dtpii || $dtpid){echo $result;}elseif(!$dtpii || !$dtpid){echo "Không giới hạn";}?></td>
                                    <td>
                                        <div class="btn-group btn-adjust-stock">
                                            <a href="javascript:void(0);" class="btn btn-sm quantity-increase" onclick="ud_openIncreasePopup(<?php echo $v['id'];?>,<?php echo $model->id;?>);" data-location-id="68002"><i class="fa fa-plus"></i></a>
                                            <a href="javascript:void(0);" class="btn btn-sm quantity-decrease" onclick="ud_openDecreasePopup(<?php echo $v['id'];?>,<?php echo $model->id;?>);" data-location-id="68002"><i class="fa fa-minus"></i></a>
                                        </div>
                                    </td>
                                    <?php $checkProductExpired = Product::model()->checkProductExpired($model->id,$v['id']); ?>

                            		<td>
                            			Số lượng sản phẩm trong kho hết hạn: <?php if($checkProductExpired ==1){ echo '0';}else{ echo $checkProductExpired; }?>
                            		</td>
                            		<td>
                            			<?php $date = ProductInventoryIncrease::model()->findAllByAttributes(array('id_product'=>$model->id, 'id_branch'=>$v['id']));  
                            			foreach ($date as $key => $value) {
                            				echo "<p>Số lượng : ". $value['stock'] ." / Ngày hết hạn : ".$value['expiry_date'] ."</p>";
                            			}?>
                            		</td>
                                   
                                </tr>
                                <tr>

                                </tr>
                                <?php 
                                }
                                ?>
                               </tbody>
                           </table>
                    </div>
                </div>
			<?php }?>
			</div> <!--end tab tồn kho-->
		</div>
	</div>

<div class="popover top in" id="increasePopup" style="top: 60px; left: 52%; display: none; z-index: 5001;border: 0px;background-color: transparent;box-shadow: 0 0px 0px rgba(0, 0, 0, 0);"><div class="arrow"></div><div class="popover-inner stock-quantity-balloon" style="padding:0px;background: #fff;"><h3 class="popover-title">Tăng số lượng tồn kho<a class="close bln-close"><i class="fa fa-remove"></i></a></h3><div class="popover-content"><div><form class="form-vertical"><table class="table-condensed table-not-bordered table-no-decoration stock-quantity-table"><thead><tr><th class="left">Thêm</th><th>Lý do</th></tr></thead><tbody><tr><td style="width: 45%"><input class="input-small form-control quantity-adjustment" type="number" onchange="BtnDisabled();" id="ipt-increase" value="" min="1" placeholder="Số lượng"></td><td style="width: 55%"><select class="form-control quantity-transaction-type" id="StockTransactionTypesIncrease" name="StockTransactionTypesIncrease"><option value="3">Tồn kho mới</option><option value="1">Trả về</option><option value="2">Chuyển đổi</option><option value="4">Điều chỉnh</option><option value="5">Khác</option></select></td></tr><tr><td colspan="2" > Ngày hết hạn<input class="form-control" id="expiry_date"></input></td></tr></tbody></table><div class="text-right" style="margin-top: 10px">&nbsp;&nbsp;<a href="javascript:void(0);" class="btn  bln-close"><i class="fa fa-remove"></i> Hủy</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-primary " id="btn-increase" disabled="true" data-location-id="68002"><i class="fa fa-ok"></i> Thêm</a></div></form></div></div></div></div>

<div class="popover top in" id="decreasePopup" style="top: 120px; left: 54%; display: none; z-index: 5001;border: 0px;background-color: transparent;box-shadow: 0 0px 0px rgba(0, 0, 0, 0);"><div class="arrow"></div><div class="popover-inner stock-quantity-balloon" style="padding:0px;background: #fff;"><h3 class="popover-title">Giảm số lượng tồn kho<a class="close bln-close"><i class="fa fa-remove"></i></a></h3><div class="popover-content"><div><form class="form-vertical"><table class="table-condensed table-not-bordered table-no-decoration stock-quantity-table"><thead><tr><th class="left">Bỏ</th><th>Lý do</th></tr></thead><tbody><tr><td style="width: 45%"><input class="input-small form-control quantity-adjustment" type="number" onchange="BtnDisabled();" id="ipt-decrease" value="" min="1" placeholder="Số lượng"></td><td style="width: 55%"><select class="form-control quantity-transaction-type" id="StockTransactionTypesDecrease" name="StockTransactionTypesDecrease"><option value="7">Hư hỏng</option><option value="8">Hết hạn</option><option value="9">Đã bán</option><option value="10">Loại bỏ</option><option value="4">Điều chỉnh</option><option value="5">Khác</option></select></td></tr><tr><td colspan="2" class="hide"><textarea class="quantity-comment form-control" style="width: 230px;" maxlength="250"></textarea></td></tr></tbody></table><div class="text-right" style="margin-top: 10px">&nbsp;&nbsp;<a href="javascript:void(0);" class="btn  bln-close"><i class="fa fa-remove"></i> Hủy</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-primary " id="btn-decrease" disabled="true" data-location-id="68002"><i class="fa fa-ok"></i> Bỏ</a></div></form></div></div></div></div>

<div class="popover top in" id="ud-increasePopup-<?php echo $model->id;?>" style="top: 60px; left: 52%; display: none; z-index: 5001;border: 0px;background-color: transparent;box-shadow: 0 0px 0px rgba(0, 0, 0, 0);"><div class="arrow"></div><div class="popover-inner stock-quantity-balloon" style="padding:0px;background: #fff;"><h3 class="popover-title">Tăng số lượng tồn kho<a class="close bln-close"><i class="fa fa-remove"></i></a></h3><div class="popover-content"><div><form class="form-vertical"><table class="table-condensed table-not-bordered table-no-decoration stock-quantity-table"><thead><tr><th class="left">Thêm</th><th>Lý do</th></tr></thead><tbody><tr><td style="width: 45%"><input class="input-small form-control quantity-adjustment" type="number" onchange="udBtnDisabled(<?php echo $model->id;?>);" id="ud-ipt-increase-<?php echo $model->id;?>" value="" min="1" placeholder="Số lượng"></td><td style="width: 55%"><select class="form-control quantity-transaction-type" id="ud-StockTransactionTypesIncrease-<?php echo $model->id;?>" name="StockTransactionTypesIncrease"><option value="3">Tồn kho mới</option><option value="1">Trả về</option><option value="2">Chuyển đổi</option><option value="4">Điều chỉnh</option><option value="5">Khác</option></select></td></tr><tr><td colspan="2" >Ngày hết hạn<input class="form-control" id="expiry_date_up"></input></td></tr></tbody></table><div class="text-right" style="margin-top: 10px">&nbsp;&nbsp;<a href="javascript:void(0);" class="btn  bln-close"><i class="fa fa-remove"></i> Hủy</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-primary " id="ud-btn-increase-<?php echo $model->id;?>" disabled="true" data-location-id="68002"><i class="fa fa-ok"></i> Add</a></div></form></div></div></div></div>

<div class="popover top in" id="ud-decreasePopup-<?php echo $model->id;?>" style="top: 120px; left: 54%; display: none; z-index: 5001;border: 0px;background-color: transparent;box-shadow: 0 0px 0px rgba(0, 0, 0, 0);"><div class="arrow"></div><div class="popover-inner stock-quantity-balloon" style="padding:0px;background: #fff;"><h3 class="popover-title">Giảm số lượng tồn kho<a class="close bln-close"><i class="fa fa-remove"></i></a></h3><div class="popover-content"><div><form class="form-vertical"><table class="table-condensed table-not-bordered table-no-decoration stock-quantity-table"><thead><tr><th class="left">Bỏ</th><th>Lý do</th></tr></thead><tbody><tr><td style="width: 45%"><input class="input-small form-control quantity-adjustment" type="number" onchange="udBtnDisabled(<?php echo $model->id;?>);" id="ud-ipt-decrease-<?php echo $model->id;?>" value="" min="1" placeholder="Số lượng"></td><td style="width: 55%"><select class="form-control quantity-transaction-type" id="ud-StockTransactionTypesDecrease-<?php echo $model->id;?>" name="StockTransactionTypesDecrease"><option value="7">Hư hỏng</option><option value="8">Hết hạn</option><option value="9">Đã bán</option><option value="10">Loại bỏ</option><option value="4">Điều chỉnh</option><option value="5">Khác</option></select></td></tr><tr><td colspan="2" class="hide"><textarea class="quantity-comment form-control" style="width: 230px;" maxlength="250"></textarea></td></tr></tbody></table><div class="text-right" style="margin-top: 10px">&nbsp;&nbsp;<a href="javascript:void(0);" class="btn  bln-close"><i class="fa fa-remove"></i> Hủy</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-primary " id="ud-btn-decrease-<?php echo $model->id;?>" disabled="true" data-location-id="68002"><i class="fa fa-ok"></i> Remove</a></div></form></div></div></div></div>


</div>
<?php $this->renderPartial('_js');?>
<?php $this->endWidget(); ?>
<script>
$("#Product_postdate").datepicker({dateFormat: 'yy-mm-dd',showAnim:'fold', });
$("#expiry_date").datepicker({dateFormat: 'yy-mm-dd',showAnim:'fold', });
$("#expiry_date_up").datepicker({dateFormat: 'yy-mm-dd',showAnim:'fold', });
</script>
<div class="modal-dialog" role="document">
	<div class="modal-content">
	  	<div class="modal-header sHeader">			        
	    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    	<h3 class="modal-title">Nợ cũ</h3>
	  	</div>

	  	<div class="modal-body row">
		  	<?php $form = $this->beginWidget( 'booster.widgets.TbActiveForm', array(
		        'id' => 'frm-old-balance',
		        'enableAjaxValidation'=>true,
		        'clientOptions' => array(
					'validateOnSubmit' =>true,
					'validateOnChange' =>true,
					'validateOnType'   =>true,
		        ),
		        'enableClientValidation'=>true,
		        'htmlOptions'=>array('enctype'   => 'multipart/form-data'),
			)); ?>

			<?php
				$branch     =   Branch::model()->findAll();
				$branchList =   CHtml::listData($branch, 'id', 'name');
				$user_id    = Yii::app()->user->getState('user_id');
				$user_name  = Yii::app()->user->getState('username');

				$readStyle = '';
				$readOnlyB = '';

				if($oldBalance->id){
					$user_id = $oldBalance->id_author;
					$user_name = $author_name;

					$branchList = array($oldBalance->id_branch => $branchList[$oldBalance->id_branch]);
					$readStyle = 'background: transparent;';
					$readOnlyB = 'readonly';
				}

				echo $form->hiddenField($oldBalance,"id");

				echo "<div class='col-md-5'>";		// văn phòng
				echo $form->dropDownListGroup($oldBalance, 'id_branch', array(
					'widgetOptions' => array(
						'required' =>true,
						'data'     => $branchList,
						'htmlOptions'=>array('style'=>$readStyle, 'readonly'=>$readOnlyB),
					)));
				echo "</div>";

				echo "<div class='col-md-3'>";		// ngày tạo
				echo $form->textFieldGroup($oldBalance, 'create_date', array(
					'widgetOptions' => array(
						'htmlOptions'=>array(
							'class'=>'','required'=>true,'readonly'=>'readonly',
							'style'=>'background: transparent;', 'value' => date_format(date_create($oldBalance->create_date), 'd/m/Y'))
					)));
				echo "</div>";

				echo "<div class='col-md-3'>";		// ngày hạch toán
				echo $form->textFieldGroup($oldBalance, 'complete_date', array(
						'widgetOptions' => array(
			                'htmlOptions'=>array('class'=>'frm_datepicker','required'=>true, 'value' => date_format(date_create($oldBalance->complete_date),'d/m/Y'))
			            ),
			            'labelOptions'  => array('label' => 'Ngày kết thúc')
			        ));
				echo "</div>";

				
				echo "<div class='clearfix'></div>";

				echo "<div class='col-md-5'>";		// Khách hàng
				echo $form->dropDownListGroup($oldBalance, 'id_customer', array(
					'widgetOptions' => array('data'=>$customer,
					'htmlOptions'   => array('required'=>'required','readonly'=>'readonly', 'style'=>'background: transparent;')
				)));
				echo "</div>";

				echo "<div class='col-md-3'>";		// Người tạo
				echo $form->labelEx($oldBalance,'id_author');
				echo $form->hiddenField($oldBalance,'id_author',array('value'=>$user_id));
				echo CHtml::textField('author',$user_name,
					array('class'=>'form-control', 'readOnly'=>true,'required'=>true, 'style'=>'background: transparent;'
				));
				echo "</div>";
			?>

			<div id="sProduct" class="col-md-12">
				<table class="table sItem">
					<thead>
			            <tr>
			                <th class="old1">Chi tiết</th>
			                <th class="old2" style="width:20%">Số lượng</th>
			                <th class="old3">Đơn giá</th>
			                <th class="old4">Thành tiền</th>
			            </tr>
			        </thead>
			        <tbody>
			        	<tr>
			        		<?php echo $form->hiddenField($oldBalanceDetail,"id"); ?>
			        		<td class="old1" style="padding:5px !important; ">
			        			<?php echo $form->textFieldGroup($oldBalanceDetail,"description",array(
				                		'widgetOptions'=>array('htmlOptions'=>array('value'=>'Nợ cũ','readOnly'=>true, 'style'=>'text-align:center; background: transparent;')),
				                		'labelOptions' => array("label" => false)));
				        				echo $form->hiddenField($oldBalanceDetail,"id_service",array('value'=>0));
			                	?>
			        		</td>
			        		<?php $valQty = 1; 
			        			if($oldBalance->id)
			        				$valQty = $oldBalanceDetail->qty;
			        		?>

			                <td class="old2" style="padding:5px !important; ">
			                	<?php echo $form->textFieldGroup($oldBalanceDetail,"qty",array(
				                		'widgetOptions'=>array('htmlOptions'=>array('required'=>true,'placeholder'=>'1','value'=>$valQty, 'class'=>'old_qty old_set_price','style'=>'text-align:center')),
				                		'labelOptions' => array("label" => false)));
			                	?>
			                </td>
			                <td class="old3" style="padding:5px !important; ">
			                	<?php echo $form->textFieldGroup($oldBalanceDetail,"unit_price",array(
				                		'widgetOptions'=>array('htmlOptions'=>array('required'=>true,'placeholder'=>'0','class'=>'old_unit_price old_set_price autoNum')),
				                		'labelOptions' => array("label" => false)));
			                	?>
			                </td>
			                <td class="old4" style="padding:5px !important; ">
			                	<?php echo $form->textFieldGroup($oldBalanceDetail,"amount",array(
				                		'widgetOptions'=>array('htmlOptions'=>array('required'=>true,'placeholder'=>'0','class'=>'old_amount autoNum','readOnly'=>true, 'style'=>'background: transparent;')),
				                		'labelOptions' => array("label" => false)));
			                	?>
			                </td>
			        	</tr>
			        </tbody>
				</table>
			</div>

			<div id="sCheck" class="col-md-12">
			    <div class="col-md-6">
			      <a href="#" class="sNote">Thêm ghi chú</a>
			    </div>
			</div>

			<div id="sAddNote" class="col-md-12 hidden">
			    <?php echo $form->textAreaGroup($oldBalance,'note',array('widgetOptions'=>array('htmlOptions'=>array()),'labelOptions' => array("label" => false))); ?>
			</div>

			<div id="sFooter" class="col-md-12 text-right"> 
			    <button class="btn sCancel" data-dismiss="modal">Hủy</button>
			    <?php if ($createOld == 1): ?>
			        <button class="btn Submit" id="sSubmit" type="submit">Xác nhận</button>
			    <?php endif ?>
			</div>

		<?php $this->endWidget(); ?>
		</div>

<?php include('_formOldBalance_js.php'); ?>
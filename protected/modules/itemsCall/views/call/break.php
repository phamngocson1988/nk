<div class="new_account_row">
    <?php echo CHtml::label('Choose break: ', false, array('class' => '')); ?>
    <?php echo CHtml::dropDownList('break', '2', $breakTypeList, array('id'=>'break')); ?>
</div>

<div class="new_account_row">
    <?php echo CHtml::label('&nbsp;', false, array('class' => '')); ?>
    <?php
    echo CHtml::Button('Break', array('class' => 'button_izi',
                                'id'=>'dobreak',
                                'onclick'=>'breakAgent();'
                                ));
    ?>
    <?php
    echo CHtml::Button('Cancel', array('class' => 'button_izi',
                                    'id'=>'Cancel',
                                    'onclick'=>'cancelBreakAgent();'
                                    ));
    ?>
</div>
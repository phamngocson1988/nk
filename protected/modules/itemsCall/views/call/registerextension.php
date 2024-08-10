<style>
div#register_btn{
    height: 25px;
    line-height: 18px;
    padding: 2px;
    float: right;
    margin-right: 200px;
}
</style>
<?php echo CHtml::beginForm('', 'post', array('id'=>'register_form')); ?>
    <p><hr style="background-color: gray ;opacity:0.5" /></p>



    <div class="">
         <?php echo CHtml::label('<span style="color: green">*</span>Queues(s): ', false, array('class' => '')); ?>

         <?php
            echo '<div id="register_btn">';
            echo CHtml::submitButton('Register', array(
                                                'id'=>'registerExtension',
                                                'class'=>'btn btn_bookoke',
                                                'name'=>'registerExtension'
                                                ));
            echo '&nbsp;&nbsp;';
            if($skip) {
                
                echo CHtml::submitButton('Skip', array(
                                                'class' => 'btn btn_bookoke',
                                                'id'=>'skip',
                                                'name'=>'skip'
                                                ));
            }
			
			echo CHtml::submitButton('Next', array(
                                                'class' => 'btn btn_bookoke',
                                                'id'=>'next',
                                                'name'=>'next'
                                                ));
            echo  '</div>';
            
            foreach($queues as $queue) {
                if($queue == 'default') continue;

                echo CHtml::checkBox('queues[]', false, array('value'=>$queue, 'class'=>'queue', 'id'=>''));
                echo $queue."&nbsp;&nbsp;";
            }
         ?>
    </div>
    <br />

    <?php

        echo CHtml::label('<span style="color: green">*</span>Extension(s): ', false, array('class' => ''));
        echo '<div id="scroll">
                <table style="background-color: #fff; border: none; text-align: left; width: 100%">
                <tr>    
                <div class="extension">'; 
    ?>               
 
    <div class="extension">
    <br />
            <?php
            $idx = 0;
            $show_btn_skp = 0;
            $show_btn_reg = 0;
            foreach($all_extension as $extension) {
                
                $flag = false;
                 // $extensions la thống số lấy ra từ $client->getExtensions() . Lúc đầu mảng array(0) {} rỗng
                if(is_array($extensions)) { // Kiểm tra $extensions la mảng 
                    foreach($extensions as $ext) {
                        if($extension['extension'] == $ext['extensions']) {
                            $flag = true;
                            $user_logging = $ext['username'];
                            
                        }
                    }
                }

                echo "<td width=\"25%\">";
                echo '<input type="radio" name="extensions" value="'.$extension['extension'].'">';
                //echo CHtml::checkBox('extensions[]', false, array('value'=>$extension['extension'], 'id'=>' ')); // Check box
                echo '&nbsp;'.$extension['extension']; // số extension (s)
                if($flag == true) {
                    echo " ($user_logging)";
                }

                echo "</td>";

                if($idx%4 == 1) {
                    echo "</tr><tr>";
                }

                $idx++;
            }
            ?>
            </tr>
            </table>
            <br />
       </div>
    </div>
<?php echo CHtml::endForm(); ?>


<script>

 $("#registerExtension, #skip").click(function(event) {


        if($(this).attr("id") == 'registerExtension') {

            var count1 =  $("input[name='queues[]']:checked").length;
            var count2 =  $("input[name='extensions']:checked").length;

            if(count1 < 1) {
                jAlert('Please check in queue.', 'Alert Dialog');
                
                return false;
            }

            if(count2 < 1) {
                jAlert('Please check in extension.', 'Alert Dialog');
                
                return false;
            }
        }
 });
 
 
  $("#next").click(function(event) {
	  event.preventDefault();
	window.location.href = '/itemsSchedule/calendar/index'
 });

</script>
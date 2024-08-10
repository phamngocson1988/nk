<style>
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
padding: 3px;
vertical-align: top !important;
padding: 10px 15px !important;
text-align: center;
}
.table-goal thead tr {
    background-color: #8ca7ae;
}
.table-goal thead tr th { 
    color: #fff !important;
}
.table-goal thead tr th {
    text-align: center;
    border: 1px solid #fff !important;
}
.table-goal tbody {
    background-color: #f1f5f6;
}
.table-goal tbody tr td {
    border: 1px solid #fff !important;
}
.goal_modal{
	width: 450px;
}
.sss td a {
    display: none;
}
.sss:hover td a{
  display: block !important;
}
p {
    margin: 0px 0px 0px !important;
}
.input-group[class*=col-] {
    float: none;
    padding-right: 15px;
    padding-left:15px; 
}
.input-group-addon{
	border-top-right-radius: 4px !important ;
	border-bottom-right-radius: 4px !important;
}
</style>
      <table class="table table-goal" style="margin-top:15px;">
        <thead>
          <tr>
            <th>STT</th>
            <th>Mã khách hàng</th>
            <th>Tên Khách hàng</th>
            <th>Giới tính</th>
            <th>SDT</th>
            <th>Email</th>
            <th>User xóa</th>
            <th>Cập nhật</th>
          </tr>
        </thead>
        <tbody>
            <?php 
                if($list_data==-1){
                   echo "<tr><td colspan='7' >Chưa có dữ liệu!</td></tr>" ;
                }else{
                    foreach ($list_data as $key => $value) {
            ?>
            <tr>
                <td><?php echo $key+1; ?></td>
                <td><?php echo $value['code_number']; ?></td>
                <td><?php echo $value['fullname']; ?></td>
                <td><?php if($value['gender']==0){echo "Nam";}else{echo "Nữ";} ?></td>
                <td><?php echo $value['phone']; ?></td>
                <td><?php echo $value['email']; ?></td>
                <td>
                    <?php
                        if($value['user_delete']){
                            $gp_users = GpUsers::model()->findBypk($value['user_delete']);
                            if($gp_users){
                                echo $gp_users->name;
                            }else{
                                echo "N/A";
                            }
                        }
                        else{
                            echo "N/A";
                        } 
                    ?>
                </td>

                <td>
                    <button class="btn" style="background: #10b1dd;color: #fff" onclick='update_stt(<?php echo $value['id'];?>)'>Active</button> 
                </td>
            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
<div style="clear:both"></div>
<div align="center" class="fix_bottom">
    <?php echo $page_list;?>          
</div>

<script>
    function update_stt(id){
        if (confirm("Bạn có thật sự muốn active lại khách hàng?")) {  
            $.ajax({ 
                type     :"POST",
                url: baseUrl+'/itemsSetting/CustomerDelete/updateSttCustomer',
                data: {
                        id  : id,       
                },
                success: function (data) {
                   if(data==-1){
                        alert('Không tìm được khách hàng!')
                   }else{
                    searchCustomer(1);
                   }
                },
            });
        }
    }
</script>
<div class="blur" id="edit-service-blur-<?php echo $dts['id'];?>">
    <div class="rg-constrained edit-service-container" id="edit-service-container-<?php echo $dts['id'];?>" style="padding:20px;position: fixed;top: 2%;right: 0;left: 0;width: 750px;height: auto;margin: 0 auto;background: #ffffff;border-radius: 3px;z-index: 999;">

        <div class="col-md-12">
            <div class="sHeader"> Chỉnh Sửa Dịch Vụ <button type="button" class="close cancel" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
            <form class="ud-service-form" id="ud-service-form-<?php echo $dts['id'];?>" action="" onsubmit="return false;" method="post" novalidate="">
                <div class="rg-row">
                    <div class="col-md-12" style="margin-top:10px;">
                        <h5>Mô tả dịch vụ</h5>
                        <input id="XeroAuthError" name="XeroAuthError" type="hidden" value="False">
                        <input id="Title" name="Title" type="hidden" value="Add Service">
                        <input id="Service_BusinessId" name="Service.BusinessId" type="hidden" value="0">
                        <input id="Origin" name="Origin" type="hidden" value="">
                        <input id="Tab" name="Tab" type="hidden" value="details">
                        <input id="Service_ServiceTypeId" name="Service.ServiceTypeId" type="hidden" value="1">

                        <div class="rg-row">
                            <div class="col-sm-6">
                                <div class="form-group required" id="ud-service-code-<?php echo $dts['id'];?>">
                                    <span class="" for="code_service">Mã dịch vụ</span>
                                    <input id="id_service" name="id_service" type="hidden" value="<?php echo $dts['id'];?>">
                                    <input class="form-control" id="code_service_<?php echo $dts['id'];?>" name="code_service" required="" type="text" value="<?php echo $dts['code'];?>" data-parsley-id="0931">                        
                                    <span class="help-block validation-error" id="parsley-id-0931-<?php echo $dts['id'];?>"></span>
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                                <div class="form-group required" id="ud-service-group-<?php echo $dts['id'];?>">
                                    <span class="" for="id_service_type">Nhóm dịch vụ</span>                          
                                    <?php                                                                         
                                    echo CHtml::dropDownList("id_service_type_".$dts['id']."",'',$group_service,array('data-id'=> $dts['id'],'class'=>'form-control','required'=>'required','empty' => 'Chọn nhóm dịch vụ','options'=>array($dts['id_service_type']=>array('selected'=>true)),'onchange'=>"onChangeUpdateGroupService(".$dts['id'].")"));
                                    ?>                 
                                    <span class="help-block validation-error" id="parsley-id-0933-<?php echo $dts['id'];?>"></span>
                                </div>
                            </div>
                        </div>

                        <div class="rg-row">
                            <div class="col-sm-6">                     
                                <div class="form-group required" id="ud-service-name-<?php echo $dts['id'];?>">
                                    <span class="" for="name_service">Tên dịch vụ</span>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <div class="btn-group service-color-pallet-holder">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                                                    <code id="color_service-<?php echo $dts['id'];?>" name="color_service" class="<?php echo $dts['color'];?>"></code>
                                                    <span class="caret"></span>
                                                </a>

                                                <ul class="dropdown-menu service-pallet-list">
                                                  <li onclick="getColor('red',<?php echo $dts['id'];?>);"><a href="javascript:void(0);"><code class="service-color-pallet red"></code> Red</a></li>
                                                  <li onclick="getColor('light-gray',<?php echo $dts['id'];?>);"><a href="javascript:void(0);"><code class="service-color-pallet light-gray"></code> Light gray</a></li>
                                                  <li onclick="getColor('green',<?php echo $dts['id'];?>);"><a href="javascript:void(0);"><code class="service-color-pallet green"></code> Green</a></li>
                                                  <li onclick="getColor('light-blue',<?php echo $dts['id'];?>);"><a href="javascript:void(0);"><code class="service-color-pallet light-blue"></code> Light blue</a></li>
                                                  <li onclick="getColor('maroon',<?php echo $dts['id'];?>);"><a href="javascript:void(0);"><code class="service-color-pallet maroon"></code> Maroon</a></li>
                                                  <li onclick="getColor('deep-sky-blue',<?php echo $dts['id'];?>);"><a href="javascript:void(0);"><code class="service-color-pallet deep-sky-blue"></code> Deep sky blue</a></li>
                                                  <li onclick="getColor('violet',<?php echo $dts['id'];?>);"><a href="javascript:void(0);"><code class="service-color-pallet violet"></code> Violet</a></li>
                                                  <li onclick="getColor('yellow',<?php echo $dts['id'];?>);"><a href="javascript:void(0);"><code class="service-color-pallet yellow"></code> Yellow</a></li>
                                                  <li onclick="getColor('orange',<?php echo $dts['id'];?>);"><a href="javascript:void(0);"><code class="service-color-pallet orange"></code> Orange</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <input class="form-control" id="name_service_<?php echo $dts['id'];?>" name="name_service" required="" type="text" value="<?php echo $dts['name'];?>" data-parsley-id="0932">
                                       
                                    </div>
                                <span class="help-block validation-error" id="parsley-id-0932-<?php echo $dts['id'];?>"></span></div>
                            </div>  

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <span>Tên dịch vụ tiếng Anh</span>                                        
                                    <input class="form-control" name="name_en_service" type="text" value="<?php echo $dts['name_en'];?>">
                                </div>
                            </div>                                    
                        </div>  
                        <div class="form-group ">
                            <span class="" for="description_service">Mô tả</span>
                            <span class="char-count-container">
                                <textarea class="char-count-1000 form-control" cols="20" id="description_service" name="description_service" rows="2"><?php echo $dts['description'];?></textarea>
                            </span>
                            <span class="help-block validation-error"></span>
                        </div>
                               
                        <div class="form-group" style="padding: 0px;">
                            <div class="checkbox">
                                <label>
                                    <input <?php if($dts['status_hiden']==1) echo "checked"; else echo "";?> id="booking_service" name="booking_service" type="checkbox" value="true" data-parsley-multiple="ServiceOnlineBookings">
                                    <input name="Service.OnlineBooking" type="hidden" value="false"> Khách hàng có thể đăng kí dịch vụ trực tuyến
                                </label>
                                
                            </div>
                            <span class="help-block validation-error"></span>
                        </div>    
                        <div class="clearfix"></div>
                        <div class="rg-row">
                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <span class="" for="price_service">Giá dịch vụ</span><br>
                                    <div class="inline-group">
                                        <span class="price-display">
                                            <div class="input-group">
                                                <input value="<?php echo number_format($dts['price'],0,"","");?>" class="price-input form-control input-narrow autoNum" onkeypress="return isNumberKey(event)" id="price_service" name="price_service" type="text">
                                                <div class="input-group-addon"><?php if($dts['flag_price']==2){echo "USD";}else{echo "VND";}?></div>
                                            </div>
                                        </span>
                                    </div>
                                    <span class="help-block validation-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-3" style="padding-top:25px; padding-left: 20px;">
                                <label>
                                    <input id="flag_price" name="flag_price" type="checkbox" value="2" <?php if($dts['flag_price']==2){echo "checked";}?>>
                                    Check USD
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <span class="" for="tax_service">Thuế</span><br>
                                    <div class="inline-group">
                                        <div class="input-group">
                                        
                                         <input class="tax-input form-control input-narrow" onkeypress=" return isNumberKey(event)" id="tax_service" name="tax_service" type="text" value="<?php echo $dts['tax'];?>">   
                                           <div class="input-group-addon">%</div> 
                                               
                                        </div>
                                    </div>
                                    <span class="help-block validation-error"></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group required ">
                                    <span class="" for="length_service">Thời gian thực hiện</span><br>
                                    <div class="input-group-duration">
                                        <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                        <span class="ui-timepicker-container">
                                        <input onkeypress="return isNumberKey(event)" class="duration-input form-control input-narrow ui-timepicker-input" id="length_service" name="length_service" pattern="^([0-1]?[0-9]|2[0-3]):([0-5][0-9])(:[0-5][0-9])?$" required="" type="number" value="<?php echo $dts['length'];?>" autocomplete="off">                    
                                      
                                        </span>
                                    </div>
                                    <span class="help-block validation-error"></span>
                                </div>
                            </div>
                        </div>
                        <div class="rg-row" style="margin-top:10px">    
                            <div class="col-sm-3">
                               <div id="select-staff" class="rg-row" style="margin-bottom: 10px;">
                               
                                    <div class="col-md-12">                                        
                                     <span class="">Nhân viên thực hiện</span><br>

                                        <div class="rg-row staff-services">
                                            <div class="col-md-12">
                                                <select id="example-enableCollapsibleOptGroups-enableClickableOptGroup" name="example-enableCollapsibleOptGroups-enableClickableOptGroup[]" class="example-enableCollapsibleOptGroups-enableClickableOptGroup" multiple="multiple">
                                                    <optgroup label="Chọn tất cả">
                                                        <?php    
                                                        foreach ($staff_list as $s_l) 
                                                        {
                                                        ?>
                                                        <option value="<?php echo $s_l['id'];?>" <?php foreach ($selected as $s) {if ($s_l['id']==$s['id_dentist']) { echo "selected";break;}}?>><?php echo $s_l['name'];?></option>
                                                        <?php 
                                                        }
                                                        ?>
                                                    </optgroup>                                          
                                                </select>  
                                            </div>
                                               
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                                   
                <div class="rg-row">
                    <div class="col-md-12">
                        <h5>Điểm thưởng</h5>      
                        <div class="rg-row">
                            <div class="col-sm-6">
                                <div class="form-group  margin-bottom-05em">

                                    <span for="point_buy_service" style="padding:0px;">Điểm được tặng khi mua dịch vụ</span>
                                    <span style="width: 45px;margin-left: 15px;display: inline-block;">
                                        <input class="form-control" id="point_buy_service" name="point_buy_service" required="" onkeypress=" return isNumberKey(event)" type="text" value="<?php echo $dts['point_donate'];?>">
                                    </span>
                                <span class="help-block validation-error"></span></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group margin-bottom-05em">
                                    <span for="point_change_service" style="padding:0px;">Điểm cần có để quy đổi dịch vụ</span>
                                    <span style="width: 45px;margin-left: 15px; display: inline-block;"> 
                                        <input class="form-control" id="point_change_service" name="point_change_service" required="" onkeypress=" return isNumberKey(event)" type="text" value="<?php echo $dts['point_exchange'];?>">
                                    </span>
                                <span class="help-block validation-error"></span></div>
                            </div>
                             <!-- stt show-->
                            <div class="col-sm-6">
                                <div class="form-group margin-bottom-05em">
                                    <span for="" style="padding:0px;">Số thứ tự hiển thị: </span>
                                    <span style="width: 45px;margin-left: 15px; display: inline-block;"> 
                                        <input class="form-control" id="stt_show" name="stt_show" required="" onkeypress=" return isNumberKey(event)" type="text" value="<?php echo $dts['stt_show'];?>" ">
                                    </span>
                                <span class="help-block validation-error"></span></div>
                            </div>
                            <!-- stt show-->

                            <!-- stt show-->
                            <div class="col-sm-6">
                                <div class="form-group margin-bottom-05em">
                                    <span for="" style="padding:0px;">Ưu tiên thanh toán: </span>
                                    <span style="width: 45px;margin-left: 15px; display: inline-block;"> 
                                        <input class="form-control" id="priority_pay_<?php echo $dts['id']; ?>" name="priority_pay" required="" onkeypress=" return isNumberKey(event)" type="text" value="<?php echo $dts['priority_pay'];?>" ">
                                    </span>
                                <span class="help-block validation-error"></span></div>
                            </div>
                       </div>
                    </div>
                </div>

                <div class="rg-row" style="margin-top:10px;">                                           
                    <div class="col-md-12">
                        <div id="pBtn">
                            <div id="pBtnL">
                            <span class="pull-right">
                            <a href="javascript:void(0);" class="btn cancel">Hủy</a>
                            <button type="" id="" onclick="updateService(<?php echo $dts['id'];?>);" class="btn btn-success btn-fw">Cập nhật</button>
                            </span> 
                            </div>
                        </div>
                    </div>
                </div>
             </form>
        </div>   
    </div>
</div>


<script>
	function ud_openIncreasePopup(id_branch,id_product){  
    $('#ud-btn-increase-'+id_product).attr('onclick','udAddIncrease('+id_branch+','+id_product+')'); 
    $('#ud-ipt-increase-'+id_product).val('');  
    $('#ud-StockTransactionTypesIncrease-'+id_product).val('3');
    $('#ud-increasePopup-'+id_product).fadeToggle('fast');
}
function ud_openDecreasePopup(id_branch,id_product){
    $('#ud-btn-decrease-'+id_product).attr('onclick','udRemoveDecrease('+id_branch+','+id_product+')'); 
    $('#ud-ipt-decrease-'+id_product).val('');  
    $('#ud-StockTransactionTypesDecrease-'+id_product).val('7'); 
    $('#ud-decreasePopup-'+id_product).fadeToggle('fast');
}
$('.bln-close').click(function(){ 
    $(".popover.top.in").hide(); 
    $(".popover.top.in").hide();
});

function udBtnDisabled(id_product){
    if($('#ud-ipt-increase-'+id_product).val()>0)
    {
        $('#ud-btn-increase-'+id_product).removeAttr('disabled');
    }  
    else
    {
        $('#ud-btn-increase-'+id_product).attr('disabled','disabled');
    }  

    if($('#ud-ipt-decrease-'+id_product).val()>0)
    {
        $('#ud-btn-decrease-'+id_product).removeAttr('disabled');
    }  
    else
    {
        $('#ud-btn-decrease-'+id_product).attr('disabled','disabled');
    } 
}
function udAddIncrease(id_branch,id_product){
   
    if($('#ud-quantity-public-label-'+id_branch+id_product).html()=="Không giới hạn")
    {
        var number=0;        
    }
    else{
        var number      = parseInt($('#ud-quantity-public-label-'+id_branch+id_product).html());
    }

    var amount          = parseInt($('#ud-ipt-increase-'+id_product).val());
    var status          = $('#ud-StockTransactionTypesIncrease-'+id_product).val();

    var inventory       = $('#ud_hidden_inventory_increase_'+id_product).val();
    var expiry_date     = $('#expiry_date_up').val();    
    if(inventory){
        var inventory   = JSON.parse(inventory);
    }else{
        inventory = [];
    }
    var response = {};
    response['id_branch']   = id_branch; 
    response['available']   = amount;
    response['status']      = status;
    response['expiry_date'] = expiry_date;
    inventory.push(response); 
    $('#ud_hidden_inventory_increase_'+id_product).val(JSON.stringify(inventory)); 
    
    $('#ud-quantity-public-label-'+id_branch+id_product).html(number+amount);  
    $('#ud-increasePopup-'+id_product).hide();  
    $('#ud-btn-increase-'+id_product).attr('disabled','disabled'); 
   
}
function udRemoveDecrease(id_branch,id_product){

    if($('#ud-quantity-public-label-'+id_branch+id_product).html()=="Không giới hạn")
    {
        var number=0;
    }
    else{
        var number=parseInt($('#ud-quantity-public-label-'+id_branch+id_product).html());
    }

    var amount    = parseInt($('#ud-ipt-decrease-'+id_product).val());
    var status    = $('#ud-StockTransactionTypesDecrease-'+id_product).val();

    var inventory = $('#ud_hidden_inventory_decrease_'+id_product).val();    
    if(inventory){
        var inventory = JSON.parse(inventory);
    }else{
        inventory = [];
    }
    var response = {};
    response['id_branch'] = id_branch; 
    response['available'] = amount;
    response['status'] = status;
    inventory.push(response); 
    $('#ud_hidden_inventory_decrease_'+id_product).val(JSON.stringify(inventory));
    if((number-amount) <0){
        $('#ud-quantity-public-label-'+id_branch+id_product).html('số lượng không đủ');
    }else{
        $('#ud-quantity-public-label-'+id_branch+id_product).html(number-amount);
    }

    $('#ud-decreasePopup-'+id_product).hide(); 
    $('#ud-btn-decrease-'+id_product).attr('disabled','disabled');
   
}

// PRODUCT INVENTORY
function openIncreasePopup(id){   
    $('#btn-increase').attr('onclick','addIncrease('+id+')'); 
    $('#ipt-increase').val('');  
    $('#StockTransactionTypesIncrease').val('3');   
    $('#increasePopup').fadeToggle('fast');
}
function openDecreasePopup(id){
    $('#btn-decrease').attr('onclick','removeDecrease('+id+')');     
    $('#ipt-decrease').val('');  
    $('#StockTransactionTypesDecrease').val('7');
    $('#decreasePopup').fadeToggle('fast');
}
$('.bln-close').click(function(){ 
    $('#increasePopup').hide(); 
    $('#decreasePopup').hide();
});
$(document).mouseup(function (e)
{
    var increasePopup = $("#increasePopup");
    if (!increasePopup.is(e.target) 
        && increasePopup.has(e.target).length === 0) 
    {        
        increasePopup.hide();
    }    

    var decreasePopup = $("#decreasePopup");
    if (!decreasePopup.is(e.target) 
        && decreasePopup.has(e.target).length === 0) 
    {        
        decreasePopup.hide();
    }      
});
function BtnDisabled(){
    if($('#ipt-increase').val()>0)
    {
        $('#btn-increase').removeAttr('disabled');
    }  
    else
    {
        $('#btn-increase').attr('disabled','disabled');
    }  

    if($('#ipt-decrease').val()>0)
    {
        $('#btn-decrease').removeAttr('disabled');
    }  
    else
    {
        $('#btn-decrease').attr('disabled','disabled');
    } 
}
function addIncrease(id){
    if($('#quantity-public-label-'+id).html()=="Không giới hạn")
    {
        var number=0;        
    }
    else{
        var number=parseInt($('#quantity-public-label-'+id).html());
    }

    var amount    = parseInt($('#ipt-increase').val());
    var status    = $('#StockTransactionTypesIncrease').val();

    var inventory = $('#hidden_inventory_increase').val(); 
    var expiry_date =  $('#expiry_date').val();

    if(inventory){
        var inventory = JSON.parse(inventory);
    }else{
        inventory = [];
    }
    var response = {};
    response['id_branch'] = id; 
    response['available'] = amount;
    response['status'] = status;
    response['expiry_date'] = expiry_date;
    inventory.push(response); 
    $('#hidden_inventory_increase').val(JSON.stringify(inventory)); 
    
    $('#quantity-public-label-'+id).html(number+amount);  
    $('#increasePopup').hide();  
    $('#btn-increase').attr('disabled','disabled'); 
   
}
function removeDecrease(id){
    if($('#quantity-public-label-'+id).html()=="Không giới hạn")
    {
        var number=0;
    }
    else{
        var number=parseInt($('#quantity-public-label-'+id).html());
    }

    var amount    = parseInt($('#ipt-decrease').val());
    var status    = $('#StockTransactionTypesDecrease').val();

    var inventory = $('#hidden_inventory_decrease').val();    
    if(inventory){
        var inventory = JSON.parse(inventory);
    }else{
        inventory = [];
    }
    var response = {};
    response['id_branch'] = id; 
    response['available'] = amount;
    response['status'] = status;
    inventory.push(response); 
    $('#hidden_inventory_decrease').val(JSON.stringify(inventory)); 

    $('#quantity-public-label-'+id).html(number-amount);    
    $('#decreasePopup').hide(); 
    $('#btn-decrease').attr('disabled','disabled');
   
}
// END PRODUCT INVENTORY
</script>
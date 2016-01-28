<script src="<?php echo base_url();?>assets/js/job_details.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />
<script>
    $(document).ready(function() {
      $('.fancybox').fancybox({
		'width':800,
        'height':600,
        'autoSize' : false,
        'afterClose':function () {
			fancy_box_closed();
		},
    });
});

function customer_selected(type,userid) {
	jQuery("#customer_id").val(userid);
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_customer_ajax/id/"+userid, 
         success: 
              function(data){
				jQuery("#mobile_"+type).val('');
				jQuery("#mobile_"+type).val(data);
			 }
          });
}
function auto_suggest_price(id){
	//alert(id);
	jQuery("#fancybox_id").val(id);
}

function fancy_box_closed(id){
	//alert(jQuery("#fancybox_id").val());
}

function calculate_paper_cost(){
	var paper_gram,paper_size,paper_print,paper_qty,amount=0,total=0,id,mby=1;
	paper_gram = jQuery("#paper_gram").val();
	paper_size = jQuery("#paper_size").val();
	paper_print = jQuery("#paper_print").val();
	id = jQuery("#fancybox_id").val();
	paper_qty = jQuery("#paper_qty").val();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_paper_rate/", 
         data:{"paper_gram":paper_gram,"paper_size":paper_size,"paper_print":paper_print,"paper_qty":paper_qty},
         dataType:"json",
         success: 
              function(data){
				  if(data.success != false ) {
				  
					
					if(paper_print == "FB") {
						mby =2;
                                        }
                                        amount = amount + parseFloat(data.paper_amount);
					total = (amount * paper_qty )* mby;
					jQuery("#result_paper_cost").html("--- "+paper_qty +" * "+amount+" [per unit] * "+paper_print+" = "+total );
					jQuery("#details_"+id).val(paper_gram+"_"+paper_size+"_"+paper_print);
                                        if(mby == 2) {
                                            jQuery("#rate_"+id).val(amount * 2);
                                        } else {
                                            jQuery("#rate_"+id).val(amount);
                                        }
					
					jQuery("#qty_"+id).val(paper_qty);
					jQuery("#sub_"+id).val(total);
					$('#flag_'+id).prop('checked', true);
				 } else {
					 jQuery("#details_"+id).val(paper_gram+"_"+paper_size+"_"+paper_print);
					jQuery("#result_paper_cost").html("[ Data not Found - Insert Manual Price]");
				 }
			 
			}
          });
}
function validate_form() {
    var check = confirm("Are You Sure ?");
    if(check == true ) {
        return true;
    }
    return false;
}
</script>
<?php
$this->load->helper('form');
$this->load->helper('general');
$modified_by = $this->session->userdata['user_id'];
?>
<form action="<?php echo base_url();?>jobs/edit_job/<?php echo $job_data->id;?>" method="post" onsubmit="return validate_form();">
<div class="col-md-12">
<table width="100%" border="2">
	<!--<tr>
		<td colspan="2" align="center">
		<h3>Customer Type</h3>
		<div class="row">
			<div class="col-md-4">
			<span onClick="set_customer('new_customer');">New Customer</span>
			</div>
			<div class="col-md-4">
				<span onClick="set_customer('regular_customer');">Regular Customer</span>
			</div>
			<div class="col-md-4">
				<span onClick="set_customer('cybera_dealer');" >Cybera Dealer</span>
			</div>
		</div>
	</tr>-->
	<tr>
		<td colspan="2">
			<div id="regular_customer" style="display:block;">
				<table width="100%">
					<tr>
						<td width="50%">
							Custome Name : <?php echo $customer_details->name;?>
						</td>
						<td width="50%" align="right">
							Contact Number : <input type="text" value="<?php echo $customer_details->mobile;?>" name="user_mobile" id="mobile_customer">
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>

<table width="100%" border="2">
	<tr>
		<td colspan="7" align="center">
			Job Name : <input type="text" name="jobname" id="jobname" value="<?php echo $job_data->jobname;?>" style="width:250px;">
		</td>
	</tr>
	<tr>
		<td width="5%">Sr</td>
		<td width="5%">Rate</td>
		<td width="10%">Category</td>
		<td width="50%">Details</td>
		<td width="10%">Qty.</td>
		<td width="10%">Rate</td>
		<td width="10%">Amount</td>
	</tr>
	<?php 
	$j=0;
	for($i=1;$i<6;$i++){ 
		?>
	<tr>
		<td><?php echo $i;?>
		<input type="hidden" name="jdid_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['id'])) { echo $job_details[$j]['id']; }?>" >
		</td>
		<td><input type="checkbox" id="flag_<?php echo $i;?>" name="flag_<?php echo $i;?>"></td>
		<td>
			<select name="category_<?php echo $i;?>">
				<option
				 <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Digital Print' ) { echo 'selected="selected"';} ?>>
				 Digital Print</option>
				<option
				 <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Visiting Card' ) { echo 'selected="selected"';} ?>>
				 Visiting Card</option>
				<option <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Offset Print' ) { echo 'selected="selected"';} ?>>
				Offset Print</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Cutting' ) { echo 'selected="selected"';} ?>>
				Cutting</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Binding' ) { echo 'selected="selected"';} ?>>
				Binding</option>
			</select>
		</td>
		<td>
                    <a class="fancybox btn btn-primary btn-sm"  onclick="return auto_suggest_price(<?php echo $i;?>);" href="#fancy_box_demo">
			Suggest
		</a>
                    <input type="text" id="details_<?php echo $i;?>" name="details_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jdetails'])) { echo $job_details[$j]['jdetails']; }?>" style="width:70%;"></td>
		<td><input type="text" id="qty_<?php echo $i;?>" name="qty_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jqty'])) { echo $job_details[$j]['jqty']; }?>" ></td>
		<td><input type="text" id="rate_<?php echo $i;?>" name="rate_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jrate'])) { echo $job_details[$j]['jrate']; }?>" ></td>
		<td align="right"><input type="text" id="sub_<?php echo $i;?>" name="sub_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jamount'])) { echo $job_details[$j]['jamount']; }?>" onblur="check_total(<?php echo $i;?>)"></td>
	</tr>
	<?php $j++;} ?>
	<tr>
		<td rowspan="4" colspan="5">
			Notes : <textarea name="notes" cols="120" rows="5"><?php echo $job_data->notes;?></textarea>
		</td>
		<td align="right">
			Sub Total :
		</td>
		<td><input type="text" id="subtotal" name="subtotal" value="<?php if(!empty($job_data->subtotal)) { echo $job_data->subtotal; }?>" onblur="calc_subtotal()"></td>
	</tr>
	<tr>
		<td align="right">
			Tax :
		</td>
		<td>
		<input type="checkbox" name="cb_checkbox" id="cb_checkbox" <?php if(!empty($job_data->tax)) { echo 'checked="checked"'; }?>>
		<input type="text" id="tax" name="tax" value="<?php if(!empty($job_data->tax)) { echo $job_data->tax; }?>" onblur="calc_tax()"></td>
	</tr>
	<tr>
		<td align="right">
			Total :
		</td>
		<td><input type="text" id="total" value="<?php if(!empty($job_data->total)) { echo $job_data->total; }?>" name="total" onfocus="calc_total()"></td>
	</tr>
	<tr>
		<td align="right">
			Advance :
		</td>
		<td><input type="text" id="advance" value="<?php if(!empty($job_data->advance)) { echo $job_data->advance; }?>" name="advance" value="0"></td>
	</tr>
	<tr>
		<td colspan="6" align="right">
			Due :
		</td>
		<td><input type="text" id="due" value="<?php if(!empty($job_data->due)) { echo $job_data->due; }?>" name="due" onfocus="calc_due()"></td>
	</tr>
</table>
    
    <hr>
<div class="col-md-12">
<div class="row">
	<div class="col-md-4">
            Bill Number : <input type="text" name="bill_number" value="<?php if(!empty($job_data->bill_number)) { echo $job_data->bill_number;}?>">
	</div>
	<div class="col-md-4">
		Voucher Number : <input type="text" name="voucher_number"  value="<?php if(!empty($job_data->voucher_number)) { echo $job_data->voucher_number;}?>">
	</div>
	<div class="col-md-4">
		Reciept Number : <input type="text" name="receipt"  value="<?php if(!empty($job_data->receipt)) { echo $job_data->receipt;}?>">
	</div>
</div>
<hr>
<div class="col-md-12">
<div class="form-group">
		<input type="hidden" name="job_id" value="<?php echo $job_data->id;?>">
		<input type="hidden" name="modified" value="<?php echo $modified_by;?>">
		<input type="hidden" name="customer_id" value="<?php echo $customer_details->id;?>">
		<input type="submit" name="save" value="Save" class="btn btn-success btn-lg">
	</div>
</div>
</form>

<div id="fancy_box_demo" style="width:400px;display: none;">
	<div style="width: 500px; margin: 0 auto; padding: 120px 0 40px;">
		<input type="hidden" name="fancybox_id" id="fancybox_id">
        <ul class="tabs" data-persist="true">
            <li><a href="#paper_tab">Paper</a></li>
            <li><a href="#view2">Visiting Cards</a></li>
            <li><a href="#view3">Binding</a></li>
        </ul>
        <div class="tabcontents">
			<div id="paper_tab">
				<div class="row">
				<table width="80%" border="2">
					<tr>
						<td align="right">Select Paper : </td>
						<td><select name="paper_gram" id="paper_gram">
							<option value="300gsm">300GSM</option>
							<option value="250gsm">250GSM</option>
							<option value="200gsm">200GSM</option>
							<option value="150gsm">150GSM</option>
							<option value="100gsm">100GSM</option>
							<option value="80gsm">80GSM</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Select Paper Size: </td>
						<td><select name="paper_size" id="paper_size">
							<option>12X18</option>
							<option>12X10</option>
							<option>12X8</option>
							<option>10X10</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Print Side: </td>
						<td><select name="paper_print" id="paper_print">
							<option value="SS">Single</option>
							<option value="FB">Double ( front & Back )</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">Quantity : </td>
						<td><input type="text" name="paper_qty" value="1" id="paper_qty"></td>
					</tr>
					<tr>
						<td colspan="2">
						<span class="btn btn-primary btn-sm" onclick="calculate_paper_cost()">Estimate Cost</span>
						<span id="result_paper_cost"></span>
						</td>
					</tr>
				</table>
				</div>
			</div>
            <div id="view2">
                <p>Pqrss...</p>
            </div>
            <div id="view3">
                <p>5466898...</p>
            </div>
            
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/job_details.js"></script>
<!--<script type="text/javascript" src="lib/jquery-1.10.1.min.js"></script>-->
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
				  
					amount = amount + parseFloat(data.paper_amount);
					if(paper_print == "FB") {
						mby =2;
					}
					total = (amount * paper_qty )* mby;
					jQuery("#result_paper_cost").html("--- "+paper_qty +" * "+amount+" [per unit] * "+paper_print+" = "+total );
					jQuery("#details_"+id).val(paper_gram+"_"+paper_size+"_"+paper_print);
					jQuery("#rate_"+id).val(amount);
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
function check_form() {
	if(jQuery("#confirmation").val().length > 0 ) {
		return true;
	}
	jQuery("#subtotal").focus();
	return false;
}
</script>
<?php
$this->load->helper('form');
$this->load->helper('general'); ?>
<form action="<?php echo site_url();?>jobs/edit" method="post" onsubmit="return check_form()">
<div class="col-md-12">
<table width="100%" border="2">
	<tr>
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
	</tr>
	<tr>
		<td colspan="2">
			<div id="new_customer" style="display:none;">
				<div class="col-md-6">
					<div class="form-group">
						<label>Name</label>
						<input type="text" class="form-control" name="name" value="" placeholder="Name">
					</div>
					<div class="form-group">
						<label>Contact Number</label>
						<input type="text" class="form-control" name="user_mobile" value="" placeholder="Mobile Number">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Company Name</label>
						<input type="text" class="form-control" name="companyname"  value="" placeholder="Company Name">
					</div>
					
					<div class="form-group">
						<label>Email Id</label>
						<input type="text" class="form-control" name="emailid" value="" placeholder="Email Id">
					</div>
				</div>
				
			</div>
			<div id="regular_customer" style="display:none;">
				<table width="100%">
					<tr>
						<td width="50%">
							Custome Name : <?php echo create_customer_dropdown('customer',true); ?>
						</td>
						<td width="50%" align="right">
							Contact Number : <input type="text" name="mobile" id="mobile_customer">
						</td>
					</tr>
				</table>
			</div>
			<div id="cybera_dealer" style="display:none;">
				<table width="100%">
					<tr>
						<td width="50%">
							Dealer Name : <?php echo create_customer_dropdown('dealer',true); ?>
						</td>
						<td width="50%" align="right">
							Contact Number : <input type="text" name="mobile" id="mobile_dealer">
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
			Job Name : <input type="text" name="jobname" id="jobname" required="required" style="width:250px;">
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
	<?php for($i=1;$i<6;$i++){ ?>
	<tr>
		<td><?php echo $i;?></td>
		<td><input type="checkbox" id="flag_<?php echo $i;?>" name="flag_<?php echo $i;?>"></td>
		<td>
			<select name="category_<?php echo $i;?>">
				<option>Digital Print</option>
				<option>Offset Print</option>
				<option>Cutting</option>
				<option>Binding</option>
			</select>
		</td>
		<td>
		<a class="fancybox btn btn-primary btn-sm"  onclick="return auto_suggest_price(<?php echo $i;?>);" href="#fancy_box_demo">
			Suggest
		</a>
		<input type="text" id="details_<?php echo $i;?>" name="details_<?php echo $i;?>" style="width:70%;"></td>
		<td><input type="text" id="qty_<?php echo $i;?>" name="qty_<?php echo $i;?>"></td>
		<td><input type="text" id="rate_<?php echo $i;?>" name="rate_<?php echo $i;?>"></td>
		<td align="right"><input type="text" id="sub_<?php echo $i;?>" name="sub_<?php echo $i;?>" 
		onblur="check_total(<?php echo $i;?>)"></td>
	</tr>
	<?php } ?>
	<tr>
		<td rowspan="4" colspan="5">
			Notes : <textarea name="notes" cols="120" rows="5"></textarea>
		</td>
		<td align="right">
			Sub Total :
		</td>
		<td><input type="text" id="subtotal" name="subtotal" required="required" onblur="calc_subtotal()"></td>
	</tr>
	<tr>
		<td align="right">
			Tax :
		</td>
		<td>
		<input type="checkbox" name="cb_checkbox" id="cb_checkbox">
		<input type="text" id="tax" name="tax" onblur="calc_tax()" style="width:100px;"></td>
	</tr>
	<tr>
		<td align="right">
			Total :
		</td>
		<td><input type="text" id="total" name="total" required="required" onfocus="calc_total()"></td>
	</tr>
	<tr>
		<td align="right">
			Advance :
		</td>
		<td><input type="text" id="advance" name="advance" value="0"></td>
	</tr>
	<tr>
		<td colspan="6" align="right">
			Due :
		</td>
		<td><input type="text" id="due" name="due" value="0" onfocus="calc_due()"></td>
	</tr>
</table>
<hr>
<div class="col-md-12">
<div class="row">
	<div class="col-md-4">
		Bill Number : <input type="text" name="bill_number">
	</div>
	<div class="col-md-4">
		Voucher Number : <input type="text" name="voucher_number">
	</div>
	<div class="col-md-4">
		Reciept Number : <input type="text" name="receipt">
	</div>
</div>
<hr>
<div class="form-group">
		<input type="hidden" name="dealer_id" value="<?php if(!empty($dealer_info->id)){echo $dealer_info->id;}?>">
		<input type="hidden" name="customer_type" id="customer_type">
		<input type="hidden" name="customer_id" id="customer_id">
		Confirm : 1 <input type="text" name="confirmation" id="confirmation" value="">
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

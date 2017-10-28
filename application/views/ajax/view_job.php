<script>
function pay_job(id) {
	var settlement_amount = $("#settlement_amount").val();
	var s_bill_number = $("#s_bill_number").val();
	var s_receipt = $("#s_receipt").val();
	var s_other = $("#s_other").val();
	var s_cmonth = $("#cmonth").val();
	var s_cheque_number = $("#cheque_number").val();
	var payRef = jQuery("input[name=pay_ref]").val();
	var payRefNote = jQuery("#pay_ref_note").val();
	
	
	if($("#settlement_amount").val().length < 1 ) {
		alert("Please Enter Valid Amount");
		return false;
	}
	else  if($("#cheque_number").val().length <1 && $("#s_receipt").val().length < 1  && $("#s_other").val().length < 1 ) {
		alert("Please Enter Cheque Number OR Receipt Number OR  Payment Type");
		return false;
	} else {
		
		jQuery("#paymentTable").hide();
		jQuery("#paymentTableMsg").html('Paymet in Progress');
		
		
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/pay_job/"+id, 
			data:{"settlement_amount":settlement_amount,"receipt":s_receipt, "other": s_other,
				"cheque_number": s_cheque_number,  "cmonth": s_cmonth, "payRef": payRef, "payRefNote": payRefNote
			},
			success: 
				function(data){
					jQuery("#paymentTableMsg").html('');
					$("#settlement_amount").val('');
					$("#s_bill_number").val('');
					$("#s_receipt").val('');
					$("#s_other").val('');
					
					jQuery("#paymentTable").show();
					alert('Payment Added Successfully');
					/*$.fancybox.close();
					location.reload();
					jQuery("#payBtn").show();*/
			 }
          });
    }
}
</script>
<?php
	$restricted_dept = get_restricted_department();
	$restricted = true;
	if( in_array($this->session->userdata('department'),$restricted_dept)) {
		$restricted = false;
	}
?>
<div class="col-md-12">
<table width="100%" border="2">
	<tr>
		<td colspan="2">
			<div id="regular_customer" style="display:block;">
				<table width="100%" border="2">
					<tr>
						<td width="50%">
							Job Id : <?php echo $job_data->id;?>
						</td>
						<td width="50%" align="right">
							Date : <?php echo date('d-m-Y', strtotime($job_data->created));?>
						</td>
					</tr>
					<tr>
						<td width="50%">
							Custome Name : <?php echo $customer_details->companyname ? $customer_details->companyname : $customer_details->name ;?>
						</td>
						<td width="50%" align="right">
							<?php echo $customer_details->mobile;?>
							<?php
							if(strlen($job_data->jsmsnumber) > 2 )
							{
								echo " / ". $job_data->jsmsnumber;
							}?>
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
			Job Name : <?php echo $job_data->jobname;?>
		</td>
	</tr>
	<tr>
		<td width="5%">Sr</td>
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
		
		</td>
		
		<td>
				 <?php echo $job_details[$j]['jtype'] ;?>
				
		</td>
		<td>
                 
         <?php if(!empty($job_details[$j]['jdetails'])) { echo $job_details[$j]['jdetails']; }?></td>
		<td>
		<?php if(!empty($job_details[$j]['jqty'])) { echo $job_details[$j]['jqty']; }?>
		</td>
		<td><?php if(!empty($job_details[$j]['jrate'])) { echo $job_details[$j]['jrate']; }?>
		</td>
		<td align="right"><?php if(!empty($job_details[$j]['jamount'])) { echo $job_details[$j]['jamount']; }?>
		</td>
	</tr>
	<?php $j++;} ?>
	<tr>
		<td rowspan="4" colspan="4">
			Notes : <?php echo $job_data->notes;?>
		</td>
		<td align="right">
			Sub Total :
		</td>
		<td align="right"><?php if(!empty($job_data->subtotal)) { echo $job_data->subtotal; }?></td>
	</tr>
	<tr>
		<td align="right">
			Tax :
		</td>
		<td align="right">
		<?php if(!empty($job_data->tax)) { echo $job_data->tax; }?></td>
	</tr>
	<tr>
		<td align="right">
			Total :
		</td>
		<td align="right"><?php if(!empty($job_data->total)) { echo $job_data->total; }?></td>
	</tr>
	<tr>
		<td align="right">
			Advance :
		</td>
		<td align="right"><?php if(!empty($job_data->advance)) { echo $job_data->advance; }?></td>
	</tr>
	<?php 
	$show_due = $job_data->due - $job_data->discount;
	$u_balance = get_balance($job_data->user_id);
	//if(1==2 && $job_data->jpaid == 1 && $show_due > 0  && $u_balance > 0 ){
	if($show_due > 0 && $u_balance < 1 ){
		?>
	<tr>
		<td colspan="5" align="right">
			Due :
		</td>
		<td align="right"> <?php 
		
		 echo $show_due; ?></td>
	</tr> <?php } else {
		//echo "2";
		
		 ?>
	<tr>
		<td colspan="5" align="right">
			Settlement Amount ( <span class="paid">Paid</span> ) : 
		</td>
		<td align="right"> <?php echo $job_data->settlement_amount; ?></td>
	</tr>
	<tr>
		<td colspan="5" align="right">
			Discount : 
		</td>
		<td align="right"> <?php echo $job_data->discount; ?></td>
	</tr>
	 <?php } ?>
</table>
<?php if($job_data->jpaid == 0 && $restricted && $show_due > 0){ ?>
<span id="paymentTableMsg"></span>
<span  id="paymentTable">
<table width="100%" border="2">
	<tr>
		<td>
			Cheque Date : <input type="text" name="cmonth" id="cmonth"  value="<?php echo date('d-m-Y');?>" class="datepicker">
		</td>
		<td>
			Cheque Number : <input type="text" name="cheque_number" id="cheque_number">
		</td>
		<td>
			Reciept Number : <input type="text" name="s_receipt" id="s_receipt">
		</td>
		<td>
			Other : <input type="text" name="s_other" id="s_other">
		</td>
		<td>
		<?php $settlment_amount =  $job_data->total - $job_data->advance;?>
			<!--<input type="text" disabled="disabled"  style="text-align:right;" name="settlement_amount_temp" value="<?php echo $settlment_amount;?>"></td>-->
			Amount : <input type="text" name="settlement_amount" id="settlement_amount" placeholder="0">
		</td>
		<td>
			<button class="btn btn-success btn-sm text-center" id="payBtn"  onclick="pay_job(<?php echo $job_data->id;?>)">Pay Amount</button>
		</td>
		
	</tr>
	<tr>
		<td colspan="4" align="center">
			<label><input type="radio" checked="checked" onChange="setPayRefNote('Cash');" name="pay_ref" value="Cash">Cash </label>
			<label><input type="radio" name="pay_ref"  onChange="setPayRefNote('NEFT/RTGS');" value="NEFT/RTGS">NEFT/RTGS </label>
			<label><input type="radio" name="pay_ref" onChange="setPayRefNote('Cheque');"  value="Cheque">Cheque </label>
			<label><input type="radio" name="pay_ref" onChange="setPayRefNote('PayTm');" value="PayTm">PayTm </label>
			<label><input type="radio" name="pay_ref" onChange="setPayRefNote('Credit/Debit Card');" value="Credit/Debit Card">Credit/Debit Card </label>
		</td>
		<td colspan="2" align="center">
			<input type="text" name="pay_ref_note" id="pay_ref_note" value="Cash">
		</td>
	</tr>
</table> 
</span>
<?php } ?>   

<?php 

if(strlen($job_data->bill_number) < 2) 
{?>
<span id="billNumberMsg"></span>
<table class="table" width="100%" id="billNumberContainer">
	<tr>
		<td align="right"> Add Bill Number :</td>
		<td> <input type="text" name="add_bill_number" id="add_bill_number"></td>
		<td><span class="btn btn-success" id="addBill" onclick="addBill(<?php echo $job_data->id;?>);">Add Bill</span></td>
	</tr>
</table>
<?php } ?>


<hr>
<div class="col-md-12">
		   <table id="jobStatusTbl" align="center" border="0" width="100%">
			<tr>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_PENDING){ echo "checked='checked'"; };?> name="jstatus" value="Pending">
						<?php echo JOB_PENDING;?>
						</label>
				</td>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_EDIT){ echo "checked='checked'"; };?> name="jstatus" value="Edited">
						<?php echo JOB_EDIT;?>
						</label>
				</td>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_HOLD){ echo "checked='checked'"; };?> name="jstatus" value="Hold">
						<?php echo JOB_HOLD;?>
						</label>
				</td>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_COMPLETE){ echo "checked='checked'"; };?> name="jstatus" value="<?php echo JOB_COMPLETE;?>">
						<?php echo JOB_COMPLETE;?>
						</label>
				</td>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_CLOSE){ echo "checked='checked'"; };?> name="jstatus" value="<?php echo JOB_CLOSE;?>">
						<?php echo JOB_CLOSE;?>
						</label>
				</td>
				<td>
					<label><input type="radio" id="is_delivered" <?php if($job_data->is_delivered == 1) echo 'checked="checked"';?> name="is_delivered" value="1">Mark Delivered</label>
					<br>
					<label><input type="radio" id="is_delivered"  <?php if($job_data->is_delivered == 0) echo 'checked="checked"';?> name="is_delivered" value="0">Un Delivered</label>
				</td>
				<td>
						<center>
						<label><input type="radio" id="send_sms" name="send_sms" value="Yes">Send SMS</label>
						<label><input type="radio" id="send_sms" name="send_sms" checked="checked" value="No">No</label>
						<br>
						<button id="saveJobStatusBtn" class="btn btn-success btn-sm text-center"  onclick="update_job_status(<?php echo $job_data->id;?>)">Save Job</button>
						</center>
				</td>
			</tr>
		</table>
    </div>
</div>

<hr>
<center>
	<a target="_blank" id="copyJobFunction" onclick="copyJobFunction();" href="<?php echo site_url();?>/jobs/copyjob/<?php echo $job_data->id;?>" class="btn btn-primary">Copy Job</a>
</center>
<center>
	Job Created by : <?php echo $userInfo->nickname;?>
</center>
<?php
if(count($cuttingInfo) > 0 )
{
?>

<hr>
<div class="test">
	<table border="1" class="table">
	<tr>
		<td> QTY </td>
		<td> Material </td>
		<td> Machine </td>
		<td> Size </td>
		<td> Details </td>
		<td> Print </td>
		<td> Corner </td>
		<td> Laser Cut </td>
		<td> Round Corner </td>
		<td> Die </td>
		<td> Notes </td>
		<td> Lamination  </td>
		<td> Binding </td>
		<td> Binding Details </td>
		<td> Packing </td>
	</tr>
	<?php
		foreach($cuttingInfo as $cutInfo)
		{
	?>
		<tr>
		<td> <?php echo $cutInfo['c_qty'];?> </td>
		<td> <?php echo $cutInfo['c_material'];?> </td>
		<td> <?php echo $cutInfo['c_machine'];?> </td>
		<td> <?php echo $cutInfo['c_size'];?> </td>
		<td> <?php echo $cutInfo['c_sizeinfo'];?> </td>
		<td> <?php echo $cutInfo['c_print'];?> </td>
		<td> <?php echo $cutInfo['c_corner'];?> </td>
		<td> <?php echo $cutInfo['c_laser'];?> </td>
		<td> <?php echo $cutInfo['c_rcorner'];?> </td>
		<td> <?php echo $cutInfo['c_cornerdie'];?> </td>
		<td> <?php echo $cutInfo['c_details'];?> </td>
		<td> <?php echo $cutInfo['c_lamination'];?> 
			<br>
			<?php echo $cutInfo['c_laminationinfo'];?> 
		</td>
		<td> <?php echo $cutInfo['c_binding'];?> </td>
		<td> <?php echo $cutInfo['c_bindinginfo'];?> </td>
		<td> <?php echo $cutInfo['c_packing'];?> </td>
		</tr>
	<?php } ?>
</table>
</div>
<hr>
<?php } ?>
<div class="col-md-12">
<div class="row">
<hr>
	<div class="col-md-12">
	<table align="center" border="2" width="100%">
		<tr>
			<td width="60%">Courier Service Name : 
			
			<?php
				$courierName = '';
				
				if(isset($courier->courier_name))
				{
					$courierName = $courier->courier_name;
				}
				else
				{
					$courierName = getCustomerPreferCourierService($job_data->customer_id);	
				}
			?>
			<input type="text" style="width:350px;" id="courier_name" name="courier_name" value="<?php echo $courierName;?>"></td>
			<td align="center" width="30%">Docket Number : 
				<?php
					if(isset($courier->docket_number)) 
					{
						echo $courier->docket_number;
					}
					else
					{
				?>
				<input type="text" id="docket_number" name="docket_number" value="">
				<?php } ?>
			</td>
			<td align="center" width="10%">
			<?php
			if(! isset($courier->docket_number)) { ?>
			<button class="btn btn-success btn-sm text-center" id="saveShippingBtn"  onclick="save_shipping(<?php echo $job_data->id;?>)">Save Shipping</button></td>
			<?php } ?>
		</tr>	
	</table>
	
	<?php
		$userBalance =  get_acc_balance($job_data->customer_id);
		$due = $job_data->due - $job_data->discount;
		
		if($due > 0 && $userBalance < 1)
		{
	?>
	<table align="center" width="100%" border="2">
		<tr>
			<td align="center">Discount : <input value="0" type="number" max="<?php echo $job_data->due;?>" name="amountDiscount" id="amountDiscount"> <span data-customer-id="<?php echo $job_data->customer_id;?>" data-id="<?php echo $job_data->id;?>" id="addDiscount"  class="btn btn-success btn-sm">Discount</span></td>
		</tr>
	</table>
	<?php } ?>
	<?php /*
		   <table align="center" border="2" width="100%">
			<tr>
				<td width="50%"> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_DESIGN){ echo "checked='checked'"; };?> name="jstatus" value="Designing">
						<?php echo JOB_DESIGN;?>
						</label>
				</td>
				<td  width="50%">
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_DESIGN_COMPLETED){ echo "checked='checked'"; };?> name="jstatus" value="Design Completed">
						<?php echo JOB_DESIGN_COMPLETED;?>
						</label>
				</td>
			</tr><tr>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_PRINT){ echo "checked='checked'"; };?> name="jstatus" value="Printing">
						<?php echo JOB_PRINT;?>
						</label>
				</td>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_PRINT_COMPLETED){ echo "checked='checked'"; };?> name="jstatus" value="Print Completed">
						<?php echo JOB_PRINT_COMPLETED;?>
						</label>
				</td>
			</tr><tr>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_CUTTING){ echo "checked='checked'"; };?> name="jstatus" value="<?php echo JOB_CUTTING;?>">
						<?php echo JOB_CUTTING;?>
						</label>
				</td>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_CUTTING_COMPLETED){ echo "checked='checked'"; };?> name="jstatus" value="<?php echo JOB_CUTTING_COMPLETED;?>">
						<?php echo JOB_CUTTING_COMPLETED;?>
						</label>
				</td>
			</tr><tr>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_COMPLETE){ echo "checked='checked'"; };?> name="jstatus" value="<?php echo JOB_COMPLETE;?>">
						<?php echo JOB_COMPLETE;?>
						</label>
				</td>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_CLOSE){ echo "checked='checked'"; };?> name="jstatus" value="<?php echo JOB_CLOSE;?>">
						<?php echo JOB_CLOSE;?>
						</label>
				</td>
				<?php /*<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_HOLD){ echo "checked='checked'"; };?> name="jstatus" value="Hold">
						<?php echo JOB_HOLD;?>
						</label>
				</td>* / ?>
				
			</tr>
		</table>*/?>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
	<center>
		<button class="btn btn-success btn-lg text-center"  onclick="update_job_status(<?php echo $job_data->id;?>)">Save Job</button>
		</center>
</div>
<hr>


<script>
function copyJobFunction()
{
	alert("Copy Job Done!");
	$.fancybox.close();	
}
function fill_account() {
	var s_receipt = $("#receipt").val();
	var other = $("#other").val();	
	if(s_receipt.length > 0 )
	{
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/ajax_check_receipt/"+s_receipt, 
			success: 
				function(data){
					if(data == 1) {
						$("#receipt").focus();
						alert("Receipt Alread Exist !");
						return false;
					} else {
						fill_account_final();
					}
			 }
          });
	} else if(other.length > 0 ) {
		fill_account_final();
	} else {
		fill_account_final();
	}
}
function fill_account_final() {
	var settlement_amount = $("#amount").val();
	var s_bill_number = $("#bill_number").val();
	var s_receipt = $("#receipt").val();
	var customer_id = $("#customer_id").val();
	var cmonth = $("#cmonth").val();
	var other = jQuery("#other").val()
		
	if($("#amount").val().length < 1 ||  $("#amount").val() < 1 ) {
		alert("Please Enter Valid Amount");
		return false;
	}else  if($("#bill_number").val().length < 1 && $("#receipt").val().length < 1 && $("#other").val().length < 1 ) {
		alert("Please Enter Receipt Number or Cheque Number");
		return false;
	} else {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/ajax_credit_amount/", 
			data:{"customer_id":customer_id,"settlement_amount":settlement_amount,"bill_number":s_bill_number,"receipt":s_receipt,"cmonth":cmonth, "other":other},
			success: 
				function(data){
					location.reload();
			 }
          });
    }
}

function addBill(jobId)
{
	var billNumber = jQuery("#add_bill_number").val();
	
	$.ajax(
	{
			type: 		"POST",
			url: 		"<?php echo site_url();?>/ajax/ajax_add_billnumber/"+jobId, 
			dataType: 	'JSON',
			data: {
				'billNumber': billNumber
			},
			success: function(data)
			{
				if(data.status == true)		
				{
					jQuery("#billNumberMsg").html("Added Bill Number Successfully, Bill Number :" + billNumber);
					jQuery("#billNumberContainer").remove();
					/*$.fancybox.close();
					location.reload();*/
				}
			}
          });	
}

function setPayRefNote(value)
{
	jQuery("#pay_ref_note").val(value);
}

jQuery("#addDiscount").on('click', function()
{
	var jobId 		= jQuery(this).attr('data-id'),
		customerId 	= jQuery(this).attr('data-customer-id');
	
	if(typeof jobId == "undefined" || jobId == 0)
	{
		return ;
	}
	
	var discount = jQuery("#amountDiscount").val();
	
	if(discount < 1 )
	{
		return;
	}
	
	jQuery.ajax({
		type: 		"POST",
			url: 		"<?php echo site_url();?>/ajax/ajax_add_discount/"+jobId, 
			dataType: 	'JSON',
			data: {
				'discountAmount': discount,
				'customerId':	customerId
			},
			success: function(data)
			{
				if(data.status == true)		
				{
					jQuery("#billNumberContainer").remove();
					$.fancybox.close();
					location.reload();
				}
			}
	});
	jQuery("#amountDiscount").val();
		alert('etst');
});
</script>

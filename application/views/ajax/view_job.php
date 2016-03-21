<script>
function pay_job(id) {
	var settlement_amount = $("#settlement_amount").val();
	var s_bill_number = $("#s_bill_number").val();
	var s_receipt = $("#s_receipt").val();
	
	if($("#settlement_amount").val().length < 1 ) {
		alert("Please Enter Valid Amount");
		return false;
	}else  if($("#s_bill_number").val().length < 1 && $("#s_receipt").val().length < 1 ) {
		alert("Please Enter Receipt Number or Bill Number");
		return false;
	} else {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/pay_job/"+id, 
			data:{"settlement_amount":settlement_amount,"bill_number":s_bill_number,"receipt":s_receipt},
			success: 
				function(data){
					$.fancybox.close();
					location.reload();
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
				<table width="100%">
					<tr>
						<td width="50%">
							Custome Name : <?php echo $customer_details->name;?>
						</td>
						<td width="50%" align="right">
							<?php echo $customer_details->mobile;?>
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
	<?php if($job_data->jpaid == 0 ){?>
	<tr>
		<td colspan="5" align="right">
			Due :
		</td>
		<td align="right"> <?php if(!empty($job_data->due)) { echo $job_data->due; }?></td>
	</tr> <?php } else { ?>
	<tr>
		<td colspan="5" align="right">
			Settlement Amount ( <span class="paid">Paid</span> ) : 
		</td>
		<td align="right"> <?php echo $job_data->settlement_amount; ?></td>
	</tr> <?php } ?>
</table>
<?php if($job_data->jpaid == 0 && $restricted && $job_data->due > 0){ ?>
<table width="100%" border="2">
	<tr>
		<td>
			Bill Number : 
            <input type="text" name="s_bill_number" id="s_bill_number" value="">
		</td>
		<td>
			Reciept Number : <input type="text" name="s_receipt" id="s_receipt">
		</td>
		<td>
		<?php $settlment_amount =  $job_data->total - $job_data->advance;?>
			<!--<input type="text" disabled="disabled"  style="text-align:right;" name="settlement_amount_temp" value="<?php echo $settlment_amount;?>"></td>-->
			Amount : <input type="text" name="settlement_amount" id="settlement_amount" placeholder="0">
		</td>
		<td>
			<button class="btn btn-success btn-sm text-center"  onclick="pay_job(<?php echo $job_data->id;?>)">Pay Amount</button>
		</td>
		
	</tr>
</table> 
<?php } ?>   
<div class="col-md-12">
<div class="row">
<hr>
	<div class="col-md-12">
	<table align="center" border="2" width="100%">
		<tr>
			<td align="center" width="60%">Courier Service Name : 
			<input type="text" id="courier_name" name="courier_name" value="<?php if($courier->courier_name) { echo $courier->courier_name;} ?>"></td>
			<td align="center" width="30%">Docket Number : <input type="text" id="docket_number" name="docket_number" value="<?php if($courier->docket_number) { echo $courier->docket_number;} ?>"></td>
			<td align="center" width="10%">
		<button class="btn btn-success btn-sm text-center"  onclick="save_shipping(<?php echo $job_data->id;?>)">Save Shipping</button></td>
		</tr>	
	</table>
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
				</td>*/?>
				
			</tr>
		</table>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
	<center>
		<button class="btn btn-success btn-lg text-center"  onclick="update_job_status(<?php echo $job_data->id;?>)">Save Job</button>
		</center>
</div>
<hr>

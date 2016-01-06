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
	<tr>
		<td colspan="5" align="right">
			Due :
		</td>
		<td align="right"> <?php if(!empty($job_data->due)) { echo $job_data->due; }?></td>
	</tr>
</table>
    
    <hr>
<div class="col-md-12">
<div class="row">
	<div class="col-md-4">
            Bill Number : <?php if(!empty($job_data->bill_number)) { echo $job_data->bill_number;}?>
	</div>
	<div class="col-md-4">
		Voucher Number : <?php if(!empty($job_data->voucher_number)) { echo $job_data->voucher_number;}?>
	</div>
	<div class="col-md-4">
		Reciept Number : <?php if(!empty($job_data->receipt)) { echo $job_data->receipt;}?>
	</div>
</div>
<div class="row">
<hr>
	<div class="col-md-12">
		   <table align="center" border="0" width="90%">
			<tr>
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_PENDING){ echo "checked='checked'"; };?> name="jstatus" value="Pending">
						<?php echo JOB_PENDING;?>
						</label>
				</td>
				<?php /*<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_DESIGN){ echo "checked='checked'"; };?> name="jstatus" value="Designing">
						<?php echo JOB_DESIGN;?>
						</label>
				</td>
				<td>
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_DESIGN_COMPLETED){ echo "checked='checked'"; };?> name="jstatus" value="Design Completed">
						<?php echo JOB_DESIGN_COMPLETED;?>
						</label>
				</td>*/?>
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
				<td> 
					<label>
						<input type="radio" <?php if($job_data->jstatus == JOB_HOLD){ echo "checked='checked'"; };?> name="jstatus" value="Hold">
						<?php echo JOB_HOLD;?>
						</label>
				</td>
				
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

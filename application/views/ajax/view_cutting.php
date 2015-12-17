<div class="col-md-12">
<center>
	<h1><?php echo $job_data->jobname;?> - Cutting Details</h1>
</center>
<table width="100%" border="2">
	<tr>
		<td colspan="2">
			<div id="regular_customer" style="display:block;">
				<table width="100%" border="2">
					<tr>
						<td width="50%">
							Date : <?php echo $job_data->jdate;?>
						</td>
						<td width="50%" align="right">
							Job Number : <?php echo $job_data->id;?>
						</td>
					</tr>
					<tr>
						<td width="50%">
							Customer Name : <?php echo $customer_details->name;?>
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
		<td colspan="9" align="center">
			Job Name : <?php echo $job_data->jobname;?>
		</td>
	</tr>
	<tr>
		<td width="5%">Sr</td>
		<td width="10%">Machine</td>
		<td width="10%">Material</td>
		<td width="10%">Size</td>
		<td width="10%">Print</td>
		<td width="10%">Lamination</td>
		<td width="10%">Packing</td>
		<td width="25%">Details</td>
		<td width="10%">Qty.</td>
	</tr>
	<?php 
	$j=1;
	foreach($cutting_details as $c_details) { ?>
	<tr>
		<td><?php echo $j;?>
		<td><?php echo $c_details['c_machine'];?></td>
		<td><?php echo $c_details['c_material'];?></td>
		<td><?php echo $c_details['c_size'];?></td>
		<td><?php echo $c_details['c_print'];?></td>
		<td><?php echo $c_details['c_lamination'];?></td>
		<td><?php echo $c_details['c_packing'];?></td>
		<td><?php echo $c_details['c_details'];?></td>
		<td align="right">
			<?php echo $c_details['c_qty'];?>
		</td>
	</tr>
	<?php $j++;} ?>
	<tr>
		<td colspan="9">
			Notes : <?php echo $job_data->notes;?>
		</td>
		<?php /*
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
		<td align="right"> <?php if(!empty($job_data->due)) { echo $job_data->due; }?></td>*/?>
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
	<div class="col-md-3">
           <label><input type="radio" <?php if($job_data->jstatus == 'Pending'){ echo "checked='checked'"; };?> name="jstatus" value="Pending">Pending</label>
	</div>
	<div class="col-md-3">
           <label> <input type="radio" <?php if($job_data->jstatus == 'Working'){ echo "checked='checked'"; };?> name="jstatus" value="Working">Working</label>
	</div>
	<div class="col-md-3">
          <label>  <input type="radio" <?php if($job_data->jstatus == 'Hold'){ echo "checked='checked'"; };?> name="jstatus" value="Hold">Hold</label>
	</div>
	<div class="col-md-3">
           <label> <input type="radio" <?php if($job_data->jstatus == 'Completed'){ echo "checked='checked'"; };?> name="jstatus" value="Completed">Completed</label>
	</div>
	
</div>
<div class="row">
	<div class="col-md-12">
	<center>
		<button class="btn btn-success btn-lg text-center"  onclick="update_job_status(<?php echo $job_data->id;?>)">Save Job</button>
		</center>
</div>
<hr>

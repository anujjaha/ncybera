<?php
	$restricted_dept = get_restricted_department();
	$restricted = true;
	if( in_array($this->session->userdata('department'),$restricted_dept)) {
		$restricted = false;
	}
	/*echo "<pre>";
	print_r($cuttingInfo);*/
?>
<div class="col-md-12">
<table width="100%" border="2">
	<tr>
		<td colspan="2">
			<div id="regular_customer" style="display:block;">
				<table width="100%">
					<tr>
						<td width="50%">
							Job Id : <?php echo $job_data->id;?>
						</td>
						<td width="50%" align="right">
							Date : <?php echo date('d-m-Y H:i A', strtotime($job_data->created));?>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
	
	<tr>
		<td colspan="2">
			<div id="regular_customer" style="display:block;">
				<table width="100%">
					<tr>
						<td width="50%">
							Custome Name : <?php echo $customer_details->companyname ? $customer_details->companyname : $customer_details->name ;?>
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
<hr>
<center>
	Job Created by : <?php echo $userInfo->nickname;?>
</center>
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
<table width="100%" border="2">
	<tr>
		<td align="center"> Job Transactions </td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="2">
				<tr>
					<td> Date Time </td>
					<td> Debit </td>
					<td> Credit </td>
					<td> Credit Note </td>
					<td> Notes </td>
				</tr>
				<?php
					foreach($job_transactions as $j_transaction) {
				?>	
					<tr>
					<td> <?php echo date('d-m-Y g:i:s a' ,strtotime($j_transaction['created']));?> </td>
					<td> <?php 
							if($j_transaction['t_type'] == DEBIT ) {
								echo $j_transaction['amount'];
							}
							?> 
					</td>
					<td> <?php 
							if($j_transaction['t_type'] == CREDIT ) {
								echo $j_transaction['amount'];
							}
							?>  </td>
					<td> 
						<?php 
							if(!empty($j_transaction['receipt'])) {
								echo "Receipt : ".$j_transaction['receipt'];
							}
							if(!empty($j_transaction['bill_number'])) {
								echo "Bill Number : ".$j_transaction['bill_number'];
							}
							?> 
					</td>
					<td><?php echo $j_transaction['notes'];?> </td>
					</tr>
				<?php } ?>
			</table>
			
		</td>
	</tr>
</table>


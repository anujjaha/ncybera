<center>
	<h2>View Old Job</h2>
</center>	
<hr>
<table width="100%" align="center" border='2'>
	<tr>
		<td align="left"> Job Id : <?php echo $jobdata->j_id;?></td>
		<td align="right">Date : <?php echo $jobdata->date;?></td>
	</tr>
	<tr>
		<td align="left"> Customer Name : <?php echo $jobdata->cusname;?></td>
		<td align="right">Mobile : <?php echo $jobdata->mob;?></td>
	</tr>
	<tr>
		<td colspan="2" align="center"> Job Name : <?php echo $jobdata->jname;?> </td>
	</tr>
	<tr>
		<td colspan="2">
			<table align="center" border="2" width="100%">
				<tr>
					<td>Sr. </td>
					<td>Job Details. </td>
					<td>Quantity</td>
					<td>Rate</td>
					<td>Subtotal</td>
				</tr>
				<tr>
					<td>1</td>
					<td><?php echo $jobdata->jone;?></td>
					<td><?php echo $jobdata->qone;?></td>
					<td><?php echo $jobdata->rone;?></td>
					<td align="right"><?php echo $jobdata->aone;?></td>
				</tr>
				<?php if(!empty($jobdata->jtwo)) {?>
				<tr>
					<td>2</td>
					<td><?php echo $jobdata->jtwo;?></td>
					<td><?php echo $jobdata->qtwo;?></td>
					<td><?php echo $jobdata->rtwo;?></td>
					<td align="right"><?php echo $jobdata->atwo;?></td>
				</tr>
				<?php } ?>
				<?php if(!empty($jobdata->jthree)) {?>
				<tr>
					<td>3</td>
					<td><?php echo $jobdata->jthree;?></td>
					<td><?php echo $jobdata->qthree;?></td>
					<td><?php echo $jobdata->rthree;?></td>
					<td align="right"><?php echo $jobdata->athree;?></td>
				</tr>
				<?php } ?>
				<?php if(!empty($jobdata->jfour)) {?>
				<tr>
					<td>4</td>
					<td><?php echo $jobdata->jfour;?></td>
					<td><?php echo $jobdata->qfour;?></td>
					<td><?php echo $jobdata->rfour;?></td>
					<td align="right"><?php echo $jobdata->afour;?></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="4" align="right">
						Sub Total
					</td>
					<td align="right">
						<?php echo $jobdata->total;?>
					</td>
				</tr>
				<tr>
					<td colspan="4" align="right">
						Tax
					</td>
					<td align="right">
						<?php echo $jobdata->tax_amount;?>
					</td>
				</tr>
				<tr>
					<td colspan="4" align="right">
						Grand Total
					</td>
					<td align="right">
						<?php echo $jobdata->total + $jobdata->tax_amount;?>
					</td>
				</tr>
				<tr>
					<td colspan="4" align="right">
						Advance
					</td>
					<td align="right">
						<?php echo $jobdata->advance;?>
					</td>
				</tr>
				<tr>
					<td colspan="4" align="right">
						Due
					</td>
					<td align="right">
						<?php echo $jobdata->due;?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<table align="center" border="1" width="100%">
				<tr>
					<td align="center"> Receipt : <?php echo $jobdata->receipt;?></td>
					<td align="center"> Voucher Number : <?php echo $jobdata->v_num;?></td>
					<td align="center"> Bill Number : <?php echo $jobdata->b_num;?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>


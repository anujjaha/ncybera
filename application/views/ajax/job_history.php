<center>
	<h2>Job History</h2>
</center>	
<hr>
<table align="center" border="2" width="90%">
	<tr>
		<td>Sr</td>
		<td>Username</td>
		<td>Status</td>
		<td>Time</td>
		<td>Date</td>
	</tr>
	<?php 
	$sr=1;
	foreach($job_history as $jhistory) {
	?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $jhistory['nickname'];?></td>
		<td><?php echo $jhistory['j_status'];?></td>
		<td><?php echo $jhistory['j_time'];?></td>
		<td><?php echo $jhistory['j_date'];?></td>
	</tr>
	<?php $sr++;	
	}
	?>
</table>
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
				
			</tr>
		</table>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
	<center>
		<label><input type="radio" id="is_delivered" <?php if($job_data->is_delivered == 1) echo 'checked="checked"';?> name="is_delivered" value="1">Mark Delivered</label>
		<label><input type="radio" id="is_delivered"  <?php if($job_data->is_delivered == 0) echo 'checked="checked"';?> name="is_delivered" value="0">Un Delivered</label>
		<br>
	</center>
</div>
<div class="row">
	<div class="col-md-12">
	<center>
		<label><input type="radio" id="send_sms" name="send_sms" value="Yes">Send SMS</label>
		<label><input type="radio" id="send_sms" name="send_sms" checked="checked" value="No">No</label>
		<br>
		<button id="saveJobStatusBtn" class="btn btn-success btn-lg text-center"  onclick="update_job_status(<?php echo $job_data->id;?>, 1)">Save Job</button>
		</center>
</div>
<hr>

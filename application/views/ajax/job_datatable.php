<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Job Num</th>
		<th>Customer Name</th>
		<th>Job Name</th>
		<th>Mobile</th>
		<th>Bill Amount</th>
		<th>Advance</th>
		<th>Due</th>
		<th>Date / Time</th>
		<th>Status</th>
		<th>Receipt</th>
		<th>Voucher Number</th>
		<th>Bill Number</th>
		<th>View</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($jobs as $job) { 
			?>
		<tr>
		<td>
		<p id="jview_<?php echo $sr;?>">
		<?php
			if($job['j_view']) {
				echo $sr;
		}else { ?> <i class="fa fa-refresh fa-spin fa-4x" onclick="view_job(<?php echo $sr;?>,<?php echo $job['job_id'];?>);"></i><?php } ?>
		</p>
		</td>
		<td><?php echo $job['job_id'];?></td>
		<td><?php echo $job['name'];?></td>
		<td><?php echo $job['jobname'];?></td>
		<td><?php echo $job['mobile'];?></td>
		<td><?php echo $job['total'];?></td>
		<td><?php echo $job['advance'];?></td>
		<td><?php echo $job['due'];?></td>
		<td><?php echo date('h:i a d-M',strtotime($job['created']));?></td>
		<td><?php echo $job['jstatus'];?></td>
		<td><?php echo $job['receipt'];?></td>
		<td><?php echo $job['voucher_number'];?></td>
		<td><?php echo $job['bill_number'];?></td>
		<td><a class="fancybox"  onclick="show_job_details(<?php echo $job['job_id'];?>);" href="#view_job_details">View</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>

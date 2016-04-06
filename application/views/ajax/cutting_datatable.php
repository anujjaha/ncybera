<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Num</th>
		<th>Name</th>
		<th>Job</th>
		<th>Details</th>
		<th>Time</th>
		<th>Cutting</th>
		<th>Cutting Completed</th>
		<th>Status</th>
		<th>View</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$ctb = "<table width='100%' border='1'><tr><td>Material</td><td>Size</td><td>Print</td><td>Lamination</td>
							<td>Binding</td><td>Packing</td><td>CornerCut</td><td>CornerDie</td><td>RoundCornerCut</td><td>LaserCut</td><td>Details</td><td>Qty</td></tr>";
		$sr =1;	
		foreach($jobs as $job) { 
			$cmaterial = $ctb;
			$jqty = "";
				foreach($cutting_details[$job['j_id']] as $cut_data) {
					$cmaterial .= "<tr>
									<td>".$cut_data['c_material']."</td>
									<td>".$cut_data['c_size']." ".$cut_data['c_sizeinfo']."</td>
									<td>".$cut_data['c_print']."</td>
									<td>".$cut_data['c_lamination']." ".$cut_data['c_laminationinfo']."</td>
									<td>".$cut_data['c_binding']."</td>
									<td>".$cut_data['c_packing']."</td>
									<td>".$cut_data['c_corner']."</td>
									<td>".$cut_data['c_cornerdie']."</td>
									<td>".$cut_data['c_rcorner']."</td>
									<td>".$cut_data['c_laser']."</td>
									<td>".$cut_data['c_details']."</td>
									<td>".$cut_data['c_qty']."</td>
									</tr>";
				}
			$cmaterial .= "</table>";
			?>
		<tr>
		<td>
		<p id="jview_<?php echo $sr;?>">
		<?php
			if($job['j_view']) {
				echo $sr;
			}else { ?> 
			<script>startaudio();</script>	
			<i class="fa fa-refresh fa-spin fa-4x" onclick="view_job(<?php echo $sr;?>,<?php echo $job['job_id'];?>);"></i><?php } ?>
		</p>
		</td>
		<td><?php echo $job['job_id'];?></td>
		<td><?php echo $job['name'];?></td>
		<td><?php echo $job['jobname'];?></td>
		<td><?php echo $cmaterial;?></td>
		<td><?php echo date('h:i a d-M',strtotime($job['created']));?>
		</td>
		<td>
			<a href="javascript:void(0);" onclick="quick_update_job_status(<?php echo $sr;?>,<?php echo $job['job_id'];?>,'<?php echo JOB_CUTTING;?>');">
				Cutting
			</a>
		</td>
		<td>
			<a href="javascript:void(0);" onclick="quick_update_job_status(<?php echo $sr;?>,<?php echo $job['job_id'];?>,'<?php echo JOB_COMPLETE;?>');">
				Cutting-Completed
			</a>
		</td>
		<td><?php echo $job['jstatus'];?></td>
		<td><a class="fancybox"  onclick="show_cutting_details(<?php echo $job['job_id'];?>);" href="#view_job_details">View</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>

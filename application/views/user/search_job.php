<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<?php if(empty($search)) {
		echo "<h1>No Result Found</h1>";
		return true;
}?>
	<h3>
		Search Result For Job Number : "<?php echo $search;?>"
	</h3>
	</div>
</div>
<script>
function show_job_details(job_id){
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_details/"+job_id, 
         success: 
            function(data){
                  jQuery("#job_view").html(data);
            }
          });
}
</script>

<div class="box">
	<h3>Jobs</h3>
	<div class="box-body table-responsive">
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
		<th>Receipt</th>
		<th>Voucher Number</th>
		<th>Bill Number</th>
		<th>Status</th>
		<th>SMS</th>
		<th>View</th>
		<th>Edit</th>
		<th>Print</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($job_data as $job) {
			//pr();
			 ?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $job['job_id'];?></td>
		<td><?php echo $job['name'];?></td>
		<td><?php echo $job['jobname'];?></td>
		<td><?php echo $job['mobile'];?></td>
		<td><?php echo $job['total'];?></td>
		<td><?php echo $job['advance'];?></td>
		<td><?php
			$user_bal = get_balance($job['customer_id']) ;
			if($user_bal > 0 ) { 
				$due_amt = $job['due'] - $job['discount'];
				echo $due_amt?$due_amt:"<span style='color:green;font-weight:bold;'>0</span>";	
				
			} else {
				echo "-";
			}
			
			echo "<br>";
				echo "-----";
				echo "<br>";
				
				$userBalance =  get_acc_balance($job['customer_id']);
				if($userBalance > 0 )
				{
					echo "<span style='color:green;font-weight:bold;'>".$userBalance."</span>";	
				}
				else
				{
					echo "<span style='color:red;font-weight:bold;'>".$userBalance."</span>";	
				}
				
				?>
		</td>
		<td><?php echo date('h:i a d-M-Y',strtotime($job['created']));?></td>
	
		<td><?php echo $job['receipt'];?></td>
		<td><?php echo $job['voucher_number'];?></td>
		<td><?php echo $job['bill_number'];?></td>
		<td><a class="fancybox" href="#view_job_status" onclick="show_job_status(<?php echo $job['job_id'];?>);">
			<?php
				if(!empty($job['jstatus']) && $job['jstatus'] == JOB_COMPLETE) {
					echo "<span class='blue'>".$job['jstatus']."</span>";
				} else {
					echo "<span class='red'>".$job['jstatus']."</span>";
				}
				?>
			</a>
		</td>
		<td><?php echo $job['smscount'];?></td>
		<td>
			<a class="fancybox"  onclick="show_job_details(<?php echo $job['job_id'];?>);" href="#view_job_details">View</a>
		</td>
		<td><a href="<?php echo site_url();?>/jobs/edit_job/<?php echo $job['job_id'];?>">Edit</a></td>
		<td><a href="<?php echo site_url();?>/jobs/job_print/<?php echo $job['job_id'];?>">Print</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
            $(function() {
                $('#example1').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "iDisplayLength": 50,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "bDestroy": true,
                });
            });
</script>

<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>


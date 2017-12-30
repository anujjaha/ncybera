<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
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
<style>
	td { font-size: 12px; }
</style>
<div class="box">
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
		<th>Due</th>
		<th>Date</th>
		<th>Time</th>
		<th>Status</th>
		<th>Receipt</th>
		<th>Bill Number</th>
		<th>SMS</th>
		<th>Action</th>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($jobs as $job) {
			if($job['jstatus'] != 'Pening')
				contine;
		 ?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $job['job_id'];?></td>
		<td><?php echo $job['companyname'] ? $job['companyname'] : $job['name'] ;?></td>
		<td><?php echo $job['jobname'];?></td>
		<td><?php echo $job['mobile'];?></td>
		<td><?php echo $job['total'];?></td>
		<td>
		<?php //echo $job['jpaid'] ? "<span class='paid'>Paid</span>" :$job['due'];?>
		<?php
			$user_bal = get_balance($job['customer_id']) ;
			if($user_bal > 0 ) { 
				$due_amt = $job['due'] - $job['discount'];
				echo $due_amt?$due_amt:"<span style='color:green;font-weight:bold;'>Paid</span>";	
				
			} else {
				echo "-";
			} ?>
		</td>
		<td width="60px;"><?php echo date('d-m-y',strtotime($job['created']));?>
		</td>
		<td width="50px;"><?php echo date('h:i A',strtotime($job['created']));?>
		</td>
		<td><?php echo $job['jstatus'];?></td>
		<td><?php echo $job['receipt'];?></td>
		<td><?php echo $job['bill_number'];?></td>
		<td><?php echo $job['smscount'];?></td>
		<td width="70px"><a class="fancybox"  onclick="show_job_details(<?php echo $job['job_id'];?>);" href="#view_job_details">View</a> | <a href="<?php echo site_url();?>/jobs/edit_job/<?php echo $job['job_id'];?>">Edit</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
            $(function() {
                $('#example1').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "bDestroy": true,
                    "iDisplayLength": 50
                });
            });
            
function update_status(id,value) {
	var oTable = $('#example1').dataTable();
	 $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/dealer/update_dealer_status/"+id+"/"+value, 
         success: 
              function(data){
				  location.reload();
			 }
          });
}
        </script>

<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>

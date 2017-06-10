<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

<script>
function direct_verify_job(id) {
	$("#verify_"+id).html("Verified");
	$('div.dataTables_filter input').val("");
	$('div.dataTables_filter input').focus();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_verify/"+id, 
         data:{"job_id":id,"notes":"Verified by Master"},
         success: 
              function(data){
					//location.reload();
					return true;
			 }
          });
}
</script>
<section class="content">

<!-- Main row -->
<div class="row">
<hr>
<!-- Left col -->
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Job Num</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Job Name</th>
		<th>Mobile</th>
		<th>Bill Amount</th>
		<th>Advance</th>
		<th>Due</th>
		<th>Receipt</th>
		<th>Bill Number</th>
		<th>Date / Time</th>
		<th>View</th>
		<th>Verify</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($unverify_jobs as $job) { 
			?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $job['job_id'];?></td>
		<td><?php echo $job['companyname'];?></td>
		<td><?php echo $job['name'];?></td>
		<td><?php echo $job['jobname'];?></td>
		<td><?php echo $job['mobile'];?></td>
		<td><?php echo $job['total'];?></td>
		<td><?php echo $job['advance'];?></td>
		<td><?php echo $job['due']?$job['due']:"<span style='color:green;font-weight:bold;'>0</span>";?></td>
		<td><?php 
		echo str_replace(","," ", $job['t_reciept']);
		 echo $job['receipt'];?></td>
		<td><?php echo $job['bill_number'];?></td>
		<td><?php echo date('d-m-Y',strtotime($job['created']))
						." - ".
						date('h:i A',strtotime($job['created']));?>
		</td>
		<td><a class="fancybox"  onclick="show_job_details(<?php echo $job['job_id'];?>);" href="#view_job_details">View</a></td>
		<td>
			<span id="verify_<?php echo $job['job_id'];?>">
				<a href="javascript:void(0);" onclick="direct_verify_job(<?php echo $job['job_id'];?>)">Verify</a>
			</span>
		</td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div><!-- /.row (main row) -->

</section>
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
function show_job_details(job_id){
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_short_details/"+job_id, 
         success: 
            function(data){
                  jQuery("#job_view").html(data);
            }
          });
}
</script>

<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>

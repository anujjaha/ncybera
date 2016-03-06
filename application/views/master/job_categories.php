<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

<script>
function direct_verify_job(id) {
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_verify/"+id, 
         data:{"job_id":id,"notes":"Verified by Master"},
         success: 
              function(data){
					location.reload();
			 }
          });
}
</script>
<section class="content">
<!-- Small boxes (Stat box) -->

<?php require_once('department_profit.php');?>


<!-- Main row -->
<div class="row">
<!-- Left col -->
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Job Num</th>
		<th>Customer Name</th>
		<th>Job Name</th>
		<th>Mobile</th>
		<th>Category</th>
		<th>Details</th>
		<th>Quantity</th>
		<th>Rate</th>
		<th>Amount</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$filter = array();
		foreach($job_categories as $job) { 
		?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $job['job_id'];?></td>
		<td><?php echo $job['companyname'] ? $job['companyname'] : $job['name'];?></td>
		<td><?php echo $job['jobname'];?></td>
		<td><?php echo $job['mobile'];?></td>
		<td><?php echo $job['jtype'];?></td>
		<td><?php echo $job['jdetails'];?></td>
		<td><?php echo $job['jqty'];?></td>
		<td><?php echo $job['jrate'];?></td>
		<td><?php echo $job['jamount'];?></td>
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

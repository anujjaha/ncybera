<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<?php if(empty($search)) {
		echo "<h1>No Result Found</h1>";
		return true;
}?>
	<h3>
		Search Result For : "<?php echo $search;?>"
	</h3>
	</div>
</div>
<script>
function show_old_job_details(job_id){
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_old_job_details/"+job_id, 
         success: 
            function(data){
				jQuery("#job_view").html(data);
            }
          });
}
</script>

<div class="box">
	<h3>Old Job Details</h3>
		
		<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Customer Name</th>
		<th>Mobile</th>
		<th>Job Name</th>
		<th>Date</th>
		<th>View</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($results as $result) { 
			if($customer['ctype'] == '1') { continue;}
			?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $result['cusname'];?></td>
		<td><?php echo $result['mob'];?></td>
		<td><?php echo $result['jname'];?></td>
		<td><?php echo $result['date'];?></td>
		<td><a  class="fancybox"  href="#view_job_details"  onclick="show_old_job_details(<?php echo $result['j_id'];?>)">View</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div>
</div>



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

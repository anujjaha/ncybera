<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<section class="content">
<!-- Main row -->
<div class="row">

<!-- Left col -->
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>
<script>
function set_user_status(user_id,status) {
	$.ajax({
	 type: "POST",
	 url: "<?php echo site_url();?>/ajax/update_user_status/"+user_id+"/"+status, 
	 success: 
		function(data){
			 location.reload();
		}
	  });
}
</script>
<a href="<?php echo site_url();?>/master/add">Add New User </a>
<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
			<th>Sr.</th>
			<th>Nickname</th>
			<th>Username</th>
			<th>Category</th>
			<th>Mobile</th>
			<th>Email Id</th>
			<th>Address</th>
			<th>Status</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($users as $user) { 
			?>
		<tr>
			<td><?php echo $sr;?></td>
			<td><?php echo $user['nickname'];?></td>
			<td><?php echo $user['username'];?></td>
			<td><?php echo ucfirst($user['department']);?></td>
			<td><?php echo $user['mobile'];?></td>
			<td><?php echo $user['emailid'];?></td>
			<td><?php echo $user['address'];?></td>
			<td>
				<a href="javascript:void(0);" onclick="set_user_status(<?php echo $user['user_id'];?>,<?php echo $user['active'];?>);">
					<?php
						echo $user['active'] ? '<span class="green">Active</span>' : '<span class="red">Inactive</span>'
					?>
				</a>
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
         url: "<?php echo site_url();?>/ajax/ajax_job_details/"+job_id, 
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

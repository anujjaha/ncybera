<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />

<?php
/*echo "<pre>";
print_r($tasks);
die;*/
?>
<h4> Task Created by <?php echo $this->session->userdata['username'];?></h4>
<a href="<?php echo site_url();?>/task/add">Add Task</a>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Task Title</th>
		<th>Assign Task to</th>
		<th>Task Status</th>
		<th>Task Details</th>
		<th>Task Reply</th>
		<th>Task Reply By</th>
		<th>Created Time</th>
		<th>Replied Time</th>
		<th>Delete</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$job_count = count($tasks);
		$sr =1;	
		foreach($tasks as $task) { 
			?>
		<tr id="task_<?php echo $task['task_id'];?>">
			<td><?php echo $sr;?></td>
			<td><?php echo $task['title'];?></td>
			<td><?php echo $task['taskies'];?></td>
			<td><?php echo $task['status'];?></td>
			<td><?php echo $task['details'];?></td>
			<td><?php echo $task['reply'];?></td>
			<td><?php echo $task['task_reply_by'];?></td>
			<td><?php echo date("d-m-Y H:i A",strtotime($task['c_time']));?></td>
			<td><?php 
				if($task['status'] != TASK_CREATED ) {
					echo date("d-m-Y H:i A",strtotime($task['m_time']));
				}
			?></td>
			<td>
				<a href="javascript:void(0);" onclick="delete_task(<?php echo $task['task_id'];?>);"> Delete </a>
			</td>
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
 function delete_task(id) {
	 var sconfirm = confirm("Do You want to Delete Task ?");
	 
	 if(sconfirm == false ) {
		 return false;
	 }
	 jQuery("#task_"+id).remove();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_task_delete", 
         data : { "id" :id },
         success: 
              function(data){
				  
			 }
          });	
 }
 </script>

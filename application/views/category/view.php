<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />

<h4> Task Need To Complete</h4>
<a href="<?php echo site_url();?>/task/add">Add Task</a> ||||
<a href="<?php echo site_url();?>/task/index">My Task List</a>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Task Created By</th>
		<th>Task Title</th>
		<th>Task Status</th>
		<th>Task Details</th>
		<th>Task Reply</th>
		<th>Created Time</th>
		<th>Replied Time</th>
		<th>Reply</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$job_count = count($tasks);
		$sr =1;	
		foreach($tasks as $task) { 
			?>
		<tr>
			<td><?php echo $sr;?></td>
			<td><?php echo $task['nickname'];?></td>
			<td><?php echo $task['title'];?></td>
			<td><?php echo $task['status'];?></td>
			<td><?php echo $task['details'];?></td>
			<td><?php echo $task['reply'];?></td>
			<td><?php echo date("d-m-Y H:i A",strtotime($task['created']));?></td>
			<td><?php 
				if($task['status'] == TASK_COMPLETED ) {
					echo date("d-m-Y H:i A",strtotime($task['modified']));
				}
			?></td>
		<td>
		<?php 
				if($task['status'] != TASK_COMPLETED ) {
					
					echo '<a href="#reply_answer" class="fancybox" onclick="set_reply('.$task['id'].')"> Reply</a>';
				} ?>
				<input type="hidden" value="<?php echo $task['title'];?>" name="task_<?php echo $task['id'];?>" id="task_<?php echo $task['id'];?>">
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
				
				 $('.fancybox').fancybox({
					'width':600,
					'height':350,
					'autoSize' : false,
					
				});
				
				
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
            
function set_reply(id) {
	var task = jQuery("#task_"+id).val();
	jQuery("#reply_task_id").val(id);
	jQuery("#task_title").html("<strong>"+task+"</strong>");
}

function send_reply() {
	var id = jQuery("#reply_task_id").val();
	var reply = jQuery("#reply").val();
	var status = jQuery("#status").val();
	
	if(jQuery("#reply").val().length  < 1 ) {
		alert("Please Provide Reply");
		return false;
	} else {
		
		$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_task_reply", 
         data : { "id" :id , "reply" : reply , "status" : status},
         success: 
              function(data){
				  window.location.reload();
			 }
          });
		
	}
}
 </script>
<div id="reply_answer" style="display:none;">
	<table width="80%" border="1" align="center">
	<tr>
		<td align="center" colspan="2">
			<h3> Reply on Task </h3>
		</td>
	</tr>
	<tr>
		<td align="right"> Task Title :  </td>
		<td> <span id="task_title"></span></td>
	</tr>
	<tr>
		<td align="right"> Status :  </td>
		<td> 
			<select name="status" id="status">
				<option><?php echo TASK_IN_PROGRESS;?></option>
				<option><?php echo TASK_COMPLETED;?></option>
				<option><?php echo TASK_PENDING;?></option>
			</select>
			
		</td>
	</tr>
	<tr>
		<td align="right"> Reply :  </td>
		<td> 
			<textarea cols="60" id="reply" required="required" rows="8" name="reply"></textarea>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<input type="hidden" id="reply_task_id" name="reply_task_id"> 
			<button name="save" onclick="send_reply();" class="btn btn-primary btn-flat">
				Reply
			</button>
		</td>
	</tr>
</table>
</div>

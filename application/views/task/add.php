<?php
$this->load->helper('form');
 echo form_open('task/add');?>
<div class="col-md-12">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Assign Task</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- text input -->
		<div class="form-group">
			<label>Select User</label>
			<?php
				get_task_user_list();
			?>
		</div>
		<div class="form-group">
			<label>Task Title</label>
			<input type="text" class="form-control" name="title"  placeholder="Task Title">
		</div>
		<div class="form-group">
			<label>Task Description</label>
			<textarea class="form-control" name="details"></textarea>
		</div>
		
	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>

<div class="col-md-12">
	<div class="form-group">
			<input type="submit" name="save" class="btn btn-primary btn-flat" value="Save">
		</div>
</div>
</form>

<?php
$this->load->helper('form');
 echo form_open('category/add');?>
<div class="col-md-12">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Create Category</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<div class="form-group">
			<label>Category Name</label>
			<input type="text" class="form-control" name="name"  placeholder="Category" required="required">
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

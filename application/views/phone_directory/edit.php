<?php
$this->load->helper('form');
 echo form_open('cdirectory/edit');?>
<div class="col-md-12">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Add Details</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- text input -->
		<div class="form-group">
			<label> Name</label>
			<input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $datas->name;?>">
		</div>
		<div class="form-group">
			<label>Phone Number</label>
			<input type="text" class="form-control" name="phone" placeholder="Phone Number"  value="<?php echo $datas->phone;?>">
		</div>
		<div class="form-group">
			<label>Mobile Number</label>
			<input type="text" class="form-control" name="mobile" placeholder="Mobile Number"  value="<?php echo $datas->mobile;?>">
		</div>
		
	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>

<div class="col-md-6">
	<div class="form-group">
			<input type="hidden" name="id" value="<?php echo $datas->id;?>">
			<input type="submit" name="save" value="Update">
		</div>
</div>
</form>

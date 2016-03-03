
<?php
$this->load->helper('form');
 echo form_open('master/add');?>
<div class="col-md-6">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Personal Details</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- text input -->
		<div class="form-group">
			<label>First Name</label>
			<input type="text" class="form-control" name="first_name" placeholder="First Name" required="required">
		</div>
		<div class="form-group">
			<label>Last Name</label>
			<input type="text" class="form-control" name="last_name" placeholder="Last Name" required="required">
		</div>
		<div class="form-group">
			<label>Username</label>
			<input type="text" class="form-control" name="username" placeholder="Username" required="required">
		</div>
		<div class="form-group">
			<label>Password</label>
			<input type="password" class="form-control" name="password" required="required">
		</div>
		
		
		
	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>

<div class="col-md-6">
<!-- general form elements disabled -->
	<div class="box box-warning">
	
	
	<div class="box-header">
		<h3 class="box-title">Other Details</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- text input -->
		
		<div class="form-group">
			<label>Department</label>
			<select name="department" class="form-control">
				<option value="prints">Printing</option>
				<option value="Admin">Admin</option>
				<option value="cuttings">Cutting</option>
			</select>
		</div>
		
		<div class="form-group">
			<label>Email Id</label>
			<input type="text" class="form-control" name="emailid" placeholder="Email Id">
		</div>
		<div class="form-group">
			<label>Email Id</label>
			<input type="text" class="form-control" name="mobile" placeholder="Mobile Number" required="required">
		</div>
		<div class="form-group">
			<label>Address</label>
			<input type="text" class="form-control" name="address" placeholder="Address">
		</div>
		

	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>
<div class="col-md-6">
	<div class="form-group">
			<input type="hidden" name="customer_id" value="<?php if(!empty($dealer_info->id)){echo $dealer_info->id;}?>">
			<input type="submit" name="save" value="Save">
		</div>
</div>
</form>

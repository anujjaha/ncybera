
<?php
$this->load->helper('form');
 echo form_open('dealer/edit');?>
<div class="col-md-6">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Personal Details</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- text input -->
		<div class="form-group">
			<label>Dealer Name</label>
			<input type="text" class="form-control" name="name" value="<?php if(!empty($dealer_info->name)){echo $dealer_info->name;}?>" placeholder="Dealer Name">
		</div>
		<div class="form-group">
			<label>Company Name</label>
			<input type="text" class="form-control" name="companyname"  value="<?php if(!empty($dealer_info->companyname)){echo $dealer_info->companyname;}?>" placeholder="Company Name">
		</div>
		<div class="form-group">
			<label>Outside Customer</label>
			<select name="outside" class="form-control" id="outside">
				<option <?php if(isset($dealer_info->outside) && $dealer_info->outside == 1) echo 'selected="selected"';?> value="1"> Yes </option>
				<option <?php if(isset($dealer_info->outside) && $dealer_info->outside == 0) echo 'selected="selected"';?> value="0"> No </option>
			</select>
		</div>
		<div class="form-group">
			<label>Contact Number</label>
			<input type="text" class="form-control" name="mobile" value="<?php if(!empty($dealer_info->mobile)){echo $dealer_info->mobile;}?>" placeholder="Mobile Number">
		</div>
		<div class="form-group">
			<label>Other Contact Number</label>
			<input type="text" class="form-control" name="officecontact" value="<?php if(!empty($dealer_info->officecontact)){echo $dealer_info->officecontact;}?>" placeholder="Other Number">
		</div>
		<div class="form-group">
			<label>Email Id</label>
			<input type="text" class="form-control" name="emailid" value="<?php if(!empty($dealer_info->emailid)){echo $dealer_info->emailid;}?>" placeholder="Email Id">
		</div>
		
	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>

<div class="col-md-6">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Address Details</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- text input -->
		<div class="form-group">
			<label>Address Line 1</label>
			<input type="text" class="form-control" name="add1" value="<?php if(!empty($dealer_info->add1)){echo $dealer_info->add1;}?>" placeholder="Address">
		</div>
		<div class="form-group">
			<label>Address Line 2</label>
			<input type="text" class="form-control" name="add2" value="<?php if(!empty($dealer_info->add2)){echo $dealer_info->add2;}?>" placeholder="Address">
		</div>
		<div class="form-group">
			<label>City</label>
			<input type="text" class="form-control" name="city" value="<?php if(!empty($dealer_info->city)){echo $dealer_info->city;}else{ echo"Ahmedabad";}?>" placeholder="City">
		</div>
		<div class="form-group">
			<label>State</label>
			<input type="text" class="form-control" name="state" value="<?php if(!empty($dealer_info->state)){echo $dealer_info->state;}else { echo "Gujarat";}?>" placeholder="State">
		</div>
		<div class="form-group">
			<label>Pin</label>
			<input type="text" class="form-control" name="pin" value="<?php if(!empty($dealer_info->pin)){echo $dealer_info->pin;}?>" placeholder="Pincode">
		</div>
		<div class="form-group">
			<br><br><br>
		</div>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>


<div class="col-md-6">
	<div class="box box-warning">
		<div class="box-header">
			<h3 class="box-title">Trasnporter Details</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<div class="form-group">
			<?php //pr($transporter_info->name);?>
				<label>Transpoter Name :</label>
				<input type="text" class="form-control" name="transporter_name" value="<?php if(isset($transporter_info->name)){echo $transporter_info->name;}?>" placeholder="Transporter Name">
			</div>
			<div class="form-group">
				<label>Transporter Contact Person:</label>
				<input type="text" class="form-control" name="transporter_contact_person" value="<?php if(isset($transporter_info->contact_person)){echo $transporter_info->contact_person;}?>" placeholder="Transporter Contact Person Name">
			</div>
			
			<div class="form-group">
				<label>Transporter Contact Number:</label>
				<input type="text" class="form-control" name="transporter_contact_number" value="<?php if(isset($transporter_info->contact_number)){echo $transporter_info->contact_number;}?>" placeholder="Transporter Contact Number">
			</div>
			
			<div class="form-group">
				<label>Transporter Location:</label>
				<input type="text" class="form-control" name="transporter_location" value="<?php if(isset($transporter_info->location)){echo $transporter_info->location;}?>" placeholder="Transporter Location">
			</div>
			
		</div>
	</div>
</div>


<div class="col-md-6">
	<div class="form-group">
			<input type="hidden" name="dealer_id" value="<?php if(!empty($dealer_info->id)){echo $dealer_info->id;}?>">
			<input type="submit" name="save" value="Save">
		</div>
</div>
</form>

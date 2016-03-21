
<?php
$this->load->helper('form');
 echo form_open('account/add_amount');?>
<div class="col-md-12">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Credit Amount in User Account</h3>
	</div><!-- /.box-header -->
	<table align="center" class="table table-bordered table-striped">
		<tr>
			<td align="right" width="40%"> Name : </td>
			<td> <?php echo $customer->name;?></td>
		</tr>
		<tr>
			<td align="right"> Company Name : </td>
			<td> <?php echo $customer->companyname;?></td>
		</tr>
		<tr>
			<td align="right"> Contact Number : </td>
			<td> <?php echo $customer->mobile. " - ".$customer->emailid;?></td>
		</tr>
		<?php if(!empty($customer->dealercode)) {?>
		<tr>
			<td align="right"> Dealer Code : </td>
			<td> <?php echo $customer->dealercode;?></td>
		</tr>
		<?php } ?>
		<tr>
			<td align="right"> Address : </td>
			<td> <?php echo $customer->add1.", ".$customer->add1.", ".$customer->city.", ".$customer->state;?></td>
		</tr>
	</table>
	<div class="box-body">
		<!-- text input -->
		<div class="form-group">
			<label>Credit Type</label>
			<select name="amountby">
				<option>Cash</option>
				<option>Cheque</option>
				<option>Other</option>
			</select>
		</div>
		<div class="form-group">
			<label>Amount</label>
			<input type="text" class="form-control" name="amount" required="required" value="0">
		</div>
		<div class="form-group">
			<label>Receipt Number</label>
			<input type="text" class="form-control" name="receipt">
		</div>
		<div class="form-group">
			<label>Bill Number</label>
			<input type="text" class="form-control" name="bill_number">
		</div>
		<div class="form-group">
			<label>Notes</label>
			<textarea class="form-control" name="notes"></textarea>
		</div>
		
	<div class="form-group">
			<input type="hidden" name="creditedby" value="<?php echo $this->session->userdata['user_id'];?>">
			<input type="hidden" name="cmonth" value="<?php echo date('M-Y');?>">
			<input type="hidden" name="customer_id" value="<?php echo $customer_id;?>">
			<input type="submit" name="save" value="Save">
		</div>
			
	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>
<div class="col-md-6">
	
</div>
</form>

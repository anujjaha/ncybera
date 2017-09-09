<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<form action="<?php echo site_url();?>/cashier/add" method="post">
	<div>
		<h3>Add Cash For : <?php echo date('d-m-Y');?></h3>
	</div>
	<div class="table-responsive">
	<table class="table" border="1" width="100%">
		<tr>
			<td align="right"> <label>Open Balance : </label></td>
			<td> <input type="number" min="0" name="open_balance" value="<?php echo $record->close_balance;?>" required="required" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Total : </label></td>
			<td> <input type="number" min="0" name="total" value="0" required="required" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Total Xerox : </label></td>
			<td> <input type="number" min="0" name="xerox_business" value="0" required="required" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Expense : </label></td>
			<td> <input type="number" min="0" name="expense" value="0" required="required" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Withdrawal : </label></td>
			<td> <input type="number" min="0" name="withdrawal" value="0" required="required" class="form-control"> </td>
		</tr>
		<tr>
			<td align="right"> <label>Close Balance : </label></td>
			<td> <input type="number" min="0" name="close_balance" value="0" required="required" class="form-control"> </td>
		</tr>
		
		<tr>
			<td align="right"> <label>Expense Details : </label></td>
			<td> <textarea name="expense_details" class="form-control"></textarea> </td>
			
		</tr>
		
		<tr>
			<td align="right"> <label>Withdraw Details : </label></td>
			<td> <textarea name="withdrawal_details" class="form-control"></textarea> </td>
		</tr>
		<tr>
			<td colspan="5" align="center"> 
				<input type="submit" name="save" class="btn btn-primary" onclick="return confirmSubmit();" value="Save">
				<input type="reset" name="reset" class="btn btn-primary" value="Reset"> 
			</td>
		</tr>
	</table>
</div>
</form>
<script>
alert("Please Clear Card Transactions");
function confirmSubmit()
{
	var status = confirm("Are You Sure ?");
	
	if(status == true )
	{
		return true;
	}
	
	return false;
}
</script>

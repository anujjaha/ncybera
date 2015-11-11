<script src="<?php echo base_url();?>assets/js/job_details.js"></script>
<script>
function customer_selected(type,userid) {
	jQuery("#customer_id").val(userid);
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_customer_ajax/id/"+userid, 
         success: 
              function(data){
				jQuery("#mobile_"+type).val('');
				jQuery("#mobile_"+type).val(data);
			 }
          });
}
</script>
<?php
$this->load->helper('form');
$this->load->helper('general');
echo form_open('jobs/edit_job/'.$job_data->id);?>
<div class="col-md-12">
<table width="100%" border="2">
	<!--<tr>
		<td colspan="2" align="center">
		<h3>Customer Type</h3>
		<div class="row">
			<div class="col-md-4">
			<span onClick="set_customer('new_customer');">New Customer</span>
			</div>
			<div class="col-md-4">
				<span onClick="set_customer('regular_customer');">Regular Customer</span>
			</div>
			<div class="col-md-4">
				<span onClick="set_customer('cybera_dealer');" >Cybera Dealer</span>
			</div>
		</div>
	</tr>-->
	<tr>
		<td colspan="2">
			<div id="regular_customer" style="display:block;">
				<table width="100%">
					<tr>
						<td width="50%">
							Custome Name : <?php echo $customer_details->name;?>
						</td>
						<td width="50%" align="right">
							Contact Number : <input type="text" value="<?php echo $customer_details->mobile;?>" name="user_mobile" id="mobile_customer">
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>

<table width="100%" border="2">
	<tr>
		<td colspan="7" align="center">
			Job Name : <input type="text" name="jobname" id="jobname" value="<?php echo $job_data->jobname;?>" style="width:250px;">
		</td>
	</tr>
	<tr>
		<td width="5%">Sr</td>
		<td width="5%">Rate</td>
		<td width="10%">Category</td>
		<td width="50%">Details</td>
		<td width="10%">Qty.</td>
		<td width="10%">Rate</td>
		<td width="10%">Amount</td>
	</tr>
	<?php 
	$j=0;
	for($i=1;$i<6;$i++){ 
		?>
	<tr>
		<td><?php echo $i;?>
		<input type="hidden" name="jdid_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['id'])) { echo $job_details[$j]['id']; }?>" >
		</td>
		<td><input type="checkbox" id="flag_<?php echo $i;?>" name="flag_<?php echo $i;?>"></td>
		<td>
			<select name="category_<?php echo $i;?>">
				<option
				 <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Digital Print' ) { echo 'selected="selected"';} ?>>
				 Digital Print</option>
				<option <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Offset Print' ) { echo 'selected="selected"';} ?>>
				Offset Print</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Cutting' ) { echo 'selected="selected"';} ?>>
				Cutting</option>
				<option  <?php if( !empty($job_details[$j]['jtype']) && $job_details[$j]['jtype'] == 'Binding' ) { echo 'selected="selected"';} ?>>
				Binding</option>
			</select>
		</td>
		<td><input type="text" id="details_<?php echo $i;?>" name="details_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jdetails'])) { echo $job_details[$j]['jdetails']; }?>" style="width:100%;"></td>
		<td><input type="text" id="qty_<?php echo $i;?>" name="qty_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jqty'])) { echo $job_details[$j]['jqty']; }?>" ></td>
		<td><input type="text" id="rate_<?php echo $i;?>" name="rate_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jrate'])) { echo $job_details[$j]['jrate']; }?>" ></td>
		<td align="right"><input type="text" id="sub_<?php echo $i;?>" name="sub_<?php echo $i;?>" value="<?php if(!empty($job_details[$j]['jamount'])) { echo $job_details[$j]['jamount']; }?>" onblur="check_total(<?php echo $i;?>)"></td>
	</tr>
	<?php $j++;} ?>
	<tr>
		<td rowspan="4" colspan="5">
			Notes : <textarea name="notes" cols="120" rows="5"><?php echo $job_data->notes;?></textarea>
		</td>
		<td align="right">
			Sub Total :
		</td>
		<td><input type="text" id="subtotal" name="subtotal" value="<?php if(!empty($job_data->subtotal)) { echo $job_data->subtotal; }?>" onblur="calc_subtotal()"></td>
	</tr>
	<tr>
		<td align="right">
			Tax :
		</td>
		<td>
		<input type="checkbox" name="cb_checkbox" id="cb_checkbox" <?php if(!empty($job_data->tax)) { echo 'checked="checked"'; }?>>
		<input type="text" id="tax" name="tax" value="<?php if(!empty($job_data->tax)) { echo $job_data->tax; }?>" onblur="calc_tax()"></td>
	</tr>
	<tr>
		<td align="right">
			Total :
		</td>
		<td><input type="text" id="total" value="<?php if(!empty($job_data->total)) { echo $job_data->total; }?>" name="total" onfocus="calc_total()"></td>
	</tr>
	<tr>
		<td align="right">
			Advance :
		</td>
		<td><input type="text" id="advance" value="<?php if(!empty($job_data->advance)) { echo $job_data->advance; }?>" name="advance" value="0"></td>
	</tr>
	<tr>
		<td colspan="6" align="right">
			Due :
		</td>
		<td><input type="text" id="due" value="<?php if(!empty($job_data->due)) { echo $job_data->due; }?>" name="due" onfocus="calc_due()"></td>
	</tr>
</table>
<div class="col-md-12">
<div class="form-group">
		<input type="hidden" name="job_id" value="<?php echo $job_data->id;?>">
		<input type="hidden" name="customer_id" value="<?php echo $customer_details->id;?>">
		<input type="submit" name="save" value="Save">
	</div>
</div>
</form>


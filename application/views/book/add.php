
<link href="http://cdnjs.cloudflare.com/ajax/libs/select2/3.2/select2.css" rel="stylesheet"/>
<?php
$this->load->helper('form');
 echo form_open('book/add');?>
<div class="col-md-12">
<!-- general form elements disabled -->
	<div class="box box-warning">
	<div class="box-header">
		<h3 class="box-title">Add Sample Book</h3>
	</div><!-- /.box-header -->
	<div class="box-body">
		<!-- text input -->
		<div class="form-group">
			<label>Select Customer</label>
			<?php
				echo createAllExistingCustomerDropDown();
			?>
		<br>
		<p id="bookMsg" class="red"></p>
		</div>
		
		<div class="form-group">
			<label>Book Title</label>
			<input type="text" class="form-control" name="book_title"  placeholder="Book Title" value="Sample Book 2018">
		</div>

		<div class="form-group">
			<label>Book Qty</label>
			<input type="number" class="form-control" name="book_qty"  id="book_qty"  placeholder="Book Qty" value="1">
		</div>

		<div class="form-group">
			<label>Book Type</label>
			<select name="paid" id="paid" class="form-control paid-select" >
				<option value="0">Free</option>
				<option value="1">Paid</option>
			</select>
		</div>

		<div class="form-group" id="paidAmountContainer"  style="display: none;" >
			<label>Paid Amount</label>
			<input type="number" class="form-control"name="amount"  id="amount"  placeholder="Amount" value="0">
		</div>

		<div class="form-group">
			<label>Send Courier</label>
			<select name="is_courier" id="courir" class="form-control" >
				<option value="0">No</option>
				<option value="1">Yes</option>
			</select>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js" type="text/javascript"></script>

<script>

var options = jQuery('select.select-customer option');
    var arr = options.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options.each(function(i, o) {
        //console.log(i);
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });

	jQuery(document).ready(function()
	{
		jQuery("#customer").select2({
		  allowClear:true,
		  placeholder: 'Select Customer'
		});

		jQuery(".paid-select").on('change', function(element)
		{
			if(jQuery("#paid").val() == 1)
			{
				jQuery("#paidAmountContainer").show();
			}
			else
			{
				jQuery("#paidAmountContainer").hide();
			}
		})
	});

function customer_selected(customer, customerId)
{
	jQuery.ajax({
		 type: "POST",
		 url: "<?php echo site_url();?>/ajax/get_customer_book_info", 
		 data: {
		 	cutomerId: customerId
		 },
		 dataType: 'JSON',
		 success: 
			function(data)
			{
				if(data.status == true)
				{
					jQuery("#bookMsg").html('Book is Already Delievered !');
					alert("Book Already Delievered !");
					return false;
				}
				else
				{
					jQuery("#bookMsg").html('');
				}
			}
	  });
	console.log(customer, value);
}
</script>
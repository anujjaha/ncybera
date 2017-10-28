<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

<script>
function show_add_amount() {
	jQuery("#add_amount").toggle("slide");
}
function show_discount_amount() {
	jQuery("#add_discount").toggle("slide");
}
function print_statstics() {
	jQuery("#print_options").toggle("slide");
}
function print_statstics_now() {
	
	var month = jQuery("#p_month").val();
	var year = jQuery("#p_year").val();
	var customer_id = $("#customer_id").val();
	//alert("Print Now Month- "+month+" Year -"+year);
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_account_statstics/",
         data : {'month':month,'year':year,'customer_id':customer_id}, 
         success: 
            function(data){
				window.open(data);
				//location.reload();
            }
          });

}
function delete_transaction_entry(id){
	
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_delete_transaction/"+id, 
         success: 
            function(data){
				location.reload();
            }
          });
}
function show_job_details(job_id){
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_simple_details/"+job_id, 
         success: 
            function(data){
                  jQuery("#job_view").html(data);
            }
          });
}

function fill_account() {
	var s_receipt = $("#receipt").val();
	var other = $("#other").val();	
	
	jQuery("#fillAccBtn").html('<img src="<?php echo site_url();?>/assets/img/load.gif">');
	if(s_receipt.length > 0 )
	{
		jQuery("#fillAccBtn").html('<img src="<?php echo site_url();?>/assets/img/load.gif">');
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/ajax_check_receipt/"+s_receipt, 
			success: 
				function(data){
					if(data == 1) {
						$("#receipt").focus();
						jQuery("#fillAccBtn").html('<button class="btn btn-success btn-sm text-center" onclick="fill_account()">Pay Amount</button>');
						alert("Receipt Alread Exist !");
						return false;
					} else {
						fill_account_final();
					}
					
			 },
			 complete: function(data)
			 {
				 //jQuery("#fillAccBtn").show();
			 }
          });
	} else if(other.length > 0 ) {
		fill_account_final();
	} else {
		fill_account_final();
	}
}
function fill_account_final() {
	var settlement_amount = $("#amount").val();
	var s_bill_number = $("#bill_number").val();
	var s_receipt = $("#receipt").val();
	var customer_id = $("#customer_id").val();
	var cmonth = $("#cmonth").val();
	var other = jQuery("#other").val()
		
	if($("#amount").val().length < 1 ||  $("#amount").val() < 1 ) {
		alert("Please Enter Valid Amount");
		return false;
	}else  if($("#bill_number").val().length < 1 && $("#receipt").val().length < 1 && $("#other").val().length < 1 ) {
		alert("Please Enter Receipt Number or Cheque Number");
		return false;
	} else {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/ajax_credit_amount/", 
			data:{"customer_id":customer_id,"settlement_amount":settlement_amount,"bill_number":s_bill_number,"receipt":s_receipt,"cmonth":cmonth, "other":other},
			success: 
				function(data){
					location.reload();
			 }
          });
    }
}


function fill_discount_account() {
	var settlement_amount = $("#discount_amount").val();
	var customer_id = $("#customer_id").val();
	var notes = $("#notes").val();
	
	
	if($("#discount_amount").val().length < 1 ||  $("#discount_amount").val() < 1 ) {
		alert("Please Enter Valid Amount");
		return false;
	} else {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/ajax_credit_amount/", 
			data:{"customer_id":customer_id,"settlement_amount":settlement_amount,"send_sms":'0',"notes":notes},
			success: 
				function(data){
					location.reload();
			 }
          });
    }
}
</script>
<div class="box">
	
		<center>
		<h3 class="box-title"><?php echo $customer->companyname ? $customer->companyname : $customer->name;?> - 
		
		<?php 
			$c_balance =  get_acc_balance($customer->id);
			if($c_balance  < 0 ) {
				echo '<span class="red">Due : '.$c_balance.'</span>';
			} else if ($c_balance > 0 ) {
				echo '<span class="green">Advance : '.$c_balance.'</span>';
			} else {
				echo '<span class="green">Account Settle : '.$c_balance.'</span>';
			}
		?>
		</span>
		</h3>
		</center>
	<div class="box-header">
		<span>
		<button class="btn btn-success btn-sm text-center" onclick="show_add_amount()">Add Amount</button>
		<button class="btn btn-success btn-sm text-center" onclick="createBills()">Create Bills</button>
		</span>
	</div>
	<div class="box-body table-responsive" id="add_amount" style="display:none;">
		<table border="1" width="100%">
			<tr>
				<td>
					Cheque Date : <input type="text" name="cmonth" id="cmonth" class="datepicker">
				</td>
				<td>
					Cheque Number : <input type="text" name="bill_number" id="bill_number">
				</td>
				<td>
					Receipt Number : <input type="text"  name="receipt" id="receipt">
				</td>
				<td>
					Other : <input type="text"  name="other" id="other">
				</td>
				<td>
					Amount : <input type="text"  name="amount" id="amount" required="required" value="0">
				</td>
				<td>
				<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer->id;?>">
					<span id="fillAccBtn" >
						<button class="btn btn-success btn-sm text-center" onclick="fill_account()">Pay Amount</button>
					</span>
				</td>
			</tr>
		</table>
	</div>
	<!-- /.box-header -->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Transaction ID</th>
		<th>Date/Time</th>
		<th>Job No.</th>
		<th>Job Edit</th>
		<th>Job Name</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Balance</th>
		<th>Reference</th>
		<th>Credit Note</th>
		<th>Other PayMode</th>
		<th>Received By</th>
		<th>Details</th>
		<th>Delete</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$due=0;
		$credited=0;
		$balance=0;
		$j_counts = array();
		/*echo "<pre>";
		print_r($results);
		die;*/
		foreach($results as $result) {
			$j_counts[] = $result['job_id'];
			
			if($result['t_type'] == CREDIT and $result['amount'] == 0) { 
				continue;
			}
			
			
			if($result['t_type'] == DEBIT ) {
				$balance = $balance - $result['amount'];
			} else {
				$balance = $balance + $result['amount'];
			}
			
			?>
		<tr>
		<td><?php echo $result['id'];?></td>
		<td><?php echo date('d M H:i A - Y',strtotime($result['created']));?></td>
		<td>
		<?php
			if($result['job_id']) {
		?>
			<a class="fancybox"  onclick="show_job_details(<?php echo $result['job_id'];?>);" 
			href="#view_job_details"><?php echo $result['job_id'];?></a>
		<?php } else {
			echo "-";
		}?>
		
		</td>
		<td>
			<a target="_blank" href="<?php echo base_url();?>jobs/edit_job/<?php echo $result['job_id'];?>">Edit</a>
		</td>
		<td><?php echo $result['jobname'];?></td>
		<td align="right">
			<?php 
				$show = "-";
					if($result['t_type'] == DEBIT ) {
							$show = $result['amount'];
					}
				echo $show;?>
		</td>
		<td align="right">
			<?php 
				$show = "-";
					if($result['t_type'] != DEBIT ) {
							$show = $result['amount'];
					}
				echo $show;
				?>
		</td>
		<td align="right">
			<?php 
				if($balance > 0 )
				{
					echo '<span class="green">'.$balance.'</span>';
				}
				else
				{
					echo $balance;
				}
			?>
		</td>
		<td>
			<?php
			if(!empty($result['j_receipt'])) {
					echo "Receipt : ". $result['j_receipt'];
			}
			if(!empty($result['j_bill_number'])) {
				echo  "Bill  : ".$result['j_bill_number'];
			} 	
			if(!empty($result['cheque_number'])) {
				echo  "Cheque Number  : ".$result['cheque_number'];
			} ?>	
		</td>
		<td>
		<?php
			if(!empty($result['receipt'])) {
					echo "Receipt : ". $result['receipt'];
			}
			if(!empty($result['bill_number'])) {
				echo  "Bill No. : ".$result['bill_number'];
			} ?>
		</td>
		<td>
			<?php echo $result['other'];?>
		</td>
		<td>
			<?php echo $result['receivedby'];?>-<?php echo $result['amountby'];?>
		</td>
		<td>
			<?php echo $result['notes'];?>
		</td>
		<td>
			<?php 
			if($result['t_type'] == CREDIT && $result['id'] != 0 ) {
				?>
				<a href="javascript:void(0);" onclick="delete_transaction_entry(<?php echo $result['id'];?>);">
					Delete
				</a>
			<?php
			}?>
		</td>
		</tr>
		<?php $sr++; } ?>
		
	</tfoot>
	</table>
<hr>
<h1>Total Job Count :
<?php
	echo count(array_unique($j_counts));
?>
</h1>
<hr>
<div class="box-header">
		<span>
		<button class="btn btn-success btn-sm text-center" onclick="show_discount_amount()">Add Discount</button>
		</span>
	</div>
	<div class="box-body table-responsive" id="add_discount" style="display:none;">
		<table border="1" width="100%">
			<tr>
				<td>
					Amount : <input type="text"  name="amount" id="discount_amount" required="required" value="0">
				</td>
				<td>
					Notes : <textarea name="notes" id="notes" cols="40" rows="6">Discoun Applied to settle account</textarea>
				</td>
				<td>
				<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer->id;?>">
					<button class="btn btn-success btn-sm text-center" onclick="fill_discount_account()">Add Discount</button>
				</td>
			</tr>
		</table>
	</div>

<hr>
<div class="box-header">
		<span>
		<button class="btn btn-success btn-sm text-center" onclick="print_statstics()">Print Statastics</button>
		</span>
	<div id="print_options" style="display:none;">
		<table width="100%" border="1">
		<tr>
			<td align="right" width="50%"> Select Month : </td>
			<td width="50%"> 
				<select name="p_month[]" id="p_month" multiple="multiple" class="form-control">
					<option value="all">All</option>
					<option>Jan</option>
					<option>Feb</option>
					<option>Mar</option>
					<option>Apr</option>
					<option>May</option>
					<option>Jun</option>
					<option>Jul</option>
					<option>Aug</option>
					<option>Sep</option>
					<option>Oct</option>
					<option>Nov</option>
					<option>Dec</option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right" width="50%"> 
				Select Year :
			</td><td> 
				<select name="p_year" id="p_year">
					<option><?php echo date('Y');?></option>
					<option><?php echo date("Y",strtotime("-1 year"));?></option>
					<option value="all">All</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<button class="btn btn-success btn-sm text-center" onclick="print_statstics_now()">Print</button>
			</td>
		</tr>
	</table>
	</div>
</div>	

<hr>

<table align="center" class="table table-bordered table-striped">
	<tr>
		<td rowspan="4">
			<p>Type : <?php 
					if($customer->ctype == 1) {
						echo 'Dealer '.$customer->dealercode;
					} else {
						echo "Customer";
					}
			?></p>
			<p>Name : <?php echo $customer->name;?></p>
			<p>Company Name : <?php echo $customer->companyname;?></p>
			<p>Mobile : <?php echo $customer->mobile;?></p>
			<p>Address : <?php echo $customer->add1." ". $customer->add2;?></p>
			<p>City : <?php echo $customer->city." ". $customer->pin;?></p>
			<p>State : <?php echo $customer->state." ". $customer->add2;?></p>
			
		</td>
	</tr>
</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>

<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<script type="text/javascript">
            $(function() {
               
                $('#example1').dataTable({
                    "bPaginate": true,
                    "bLengthChange": true,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "iDisplayLength": 50
                });
            });
        </script>
<script>
function createBills()
{
	var customer_id = $("#customer_id").val();
	
	jQuery.ajax(
	{
		url: "<?php echo site_url();?>/ajax/getJobsWithoutBill/" + customer_id,
		method: 'GET',
		dataType: 'JSON',
		success: function(data)
		{
			if(data.status == true)
			{
				var appendHtml 	= '',
					jobs 		= data.jobs;
					
				for(var i = 0; i < jobs.length; i++)
				{
					appendHtml += '<tr>';
						
						appendHtml += '<td><label><input class="job-check-box" value="'+jobs[i].id+'" type="checkbox" name="job-'+jobs[i].id+'" id="job-'+jobs[i].id+'"> '+ jobs[i].id +' </label></td>';
						
						appendHtml += '<td>' + jobs[i].jobname + '</td>';
						
						appendHtml += '<td>' + jobs[i].total + '</td>';
						
						appendHtml += '<td>' + jobs[i].created + '</td>';
						
					appendHtml += '</tr>';
				}
				jQuery("#jobRecords").html('');
				jQuery("#jobRecords").append(appendHtml);
			}
			
		},
		error: function(data)
		{
			console.log(data);
		}	
	});
	
	jQuery("#general_bill_number").val('');
	$("#billModalPopup").modal('show');

}

function setBillToSelectedJobs()
{
	var selectedJobs = [];
	
	jQuery('input[type=checkbox]:checked').each(function(item)
	{                                        
		selectedJobs.push(jQuery(this).val());
	});
	
	if(selectedJobs.length > 0 && jQuery("#general_bill_number").val().length > 0 )
	{
		var confirmBox = confirm('Do you want to lock Bills for Selected Jobs');
	
		if(confirmBox)
		{
			console.log(jQuery("#general_bill_number").val());
			console.log(selectedJobs);
			alert("Go Ahed");
			
			jQuery.ajax(
			{
				url: "<?php echo site_url();?>/ajax/setBillForSelectedJobs",
				method: 'POST',
				dataType: 'JSON',
				data: {
					jobIds: selectedJobs,
					customerId: jQuery("#customer_id").val(),
					billNumber: jQuery("#general_bill_number").val()
				},
				success: function(data)
				{
					if(data.status == true)
					{
-						alert("Total "+ data.process + " Job Processed Successfully !");
						$("#billModalPopup").modal('hide');
						window.location.reload();
					}
				},
				error: function(data)
				{
					alert("Something Went Wrong ! Error Found");
				}
			});
		}
		
		return false;
	}
	else
	{
		alert("Please Select Jobs or Provide Valid Bill Number");
		return false;
	}
	
}
</script>
<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>

	


<!-- MOdal BOx for Bills -->
<div id="billModalPopup" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Bills</h4>
      </div>
      <div class="modal-body">
		<table id="jobRecords1" class="table">
			<tr>
				<td> Job Id </td>
				<td> Job Name </td>
				<td> Total </td>
				<td> Date/Time </td>
			</tr>
		</table>
		<table id="jobRecords" class="table">
			
		</table>
      </div>
      <div class="modal-footer">
		<div class="text-center">
			<div class="col-md-6">
				Add Bill Number : 
			</div>
			<div class="col-md-6">
				<input type="text" id="general_bill_number" name="general_bill_number" class="form-control">
			</div>
		</div>
        <button type="button" class="btn btn-primary" onclick="setBillToSelectedJobs()">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

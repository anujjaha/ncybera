<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script>
function show_add_amount() {
	jQuery("#add_amount").toggle("slide");
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
	var settlement_amount = $("#amount").val();
	var s_bill_number = $("#bill_number").val();
	var s_receipt = $("#receipt").val();
	var customer_id = $("#customer_id").val();
	if($("#amount").val().length < 1 ||  $("#amount").val() < 1 ) {
		alert("Please Enter Valid Amount");
		return false;
	}else  if($("#bill_number").val().length < 1 && $("#receipt").val().length < 1 ) {
		alert("Please Enter Receipt Number or Cheque Number");
		return false;
	} else {
		$.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/ajax/ajax_credit_amount/", 
			data:{"customer_id":customer_id,"settlement_amount":settlement_amount,"bill_number":s_bill_number,"receipt":s_receipt},
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
		<span class="red">Balance : <?php echo get_balance($customer->id);?>
		</span>
		</h3>
		</center>
	<div class="box-header">
		<span>
		<button class="btn btn-success btn-sm text-center" onclick="show_add_amount()">Add Amount</button>
		</span>
	</div>
	<div class="box-body table-responsive" id="add_amount" style="display:none;">
		<table border="1" width="100%">
			<tr>
				<td>
					Cheque Number : <input type="text" name="bill_number" id="bill_number">
				</td>
				<td>
					Receipt Number : <input type="text"  name="receipt" id="receipt">
				</td>
				<td>
					Amount : <input type="text"  name="amount" id="amount" required="required" value="0">
				</td>
				<td>
				<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer->id;?>">
					<button class="btn btn-success btn-sm text-center" onclick="fill_account()">Pay Amount</button>
				</td>
			</tr>
		</table>
	</div>
	<!-- /.box-header -->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Date/Time</th>
		<th>Job No.</th>
		<th>Job Name</th>
		<th>Debit</th>
		<th>Credit</th>
		<th>Balance</th>
		<th>Credit Note</th>
		<th>Received By</th>
		<th>Details</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$due=0;
		$credited=0;
		$balance=0;
		foreach($results as $result) { 
			if($result['t_type'] == DEBIT ) {
				$balance = $balance - $result['amount'];
			} else {
				$balance = $balance + $result['amount'];
			}
			
			?>
		<tr>
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
			<?php echo $balance;?>
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
			<?php echo $result['receivedby'];?>-<?php echo $result['amountby'];?>
		</td>
		<td>
			<?php echo $result['notes'];?>
		</td>
		</tr>
		<?php $sr++; } ?>
		
	</tfoot>
	</table>
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

<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>

<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="box">
	<div class="box-header">
		<h3 class="box-title"><?php echo $customer->name;?> - Account Details</h3>
	</div><!-- /.box-header -->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Month</th>
		<th>Job Name</th>
		<th>Due</th>
		<th>Credited Amount</th>
		<th>Credited By</th>
		<th>Received By</th>
		
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		$due=0;
		$credited=0;
		foreach($results as $result) { 
			$due = $due + $result['due']; 
			$credited = $credited + $result['amount']; 
			?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $result['cmonth'];?></td>
		<td><?php echo $result['jobname'];?></td>
		<td><?php echo $result['due'];?></td>
		<td><?php echo $result['amount'];?></td>
		<td><?php echo $result['amountby'];?></td>
		<td><?php echo $result['receivedby'];?></td>
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
	<tr>
		<td width="50%" align="right"> Total Due Amount : </td>
		<td><?php echo $due;?> </td>
	</tr>
	<tr>
		<td width="50%" align="right"> Total Credited Amount : </td>
		<td><?php echo $credited;?> </td>
	</tr>
	<tr>
		<td width="50%" align="right"> Balance : </td>
		<td><?php echo $credited - $due;?> </td>
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

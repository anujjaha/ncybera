<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="box">
	<div class="box-header">
		<h3 class="box-title"><?php echo $customer->name;?> - Account Details</h3>
	</div>
	<div class="box-header">
		<span><a href="<?php echo site_url();?>/account/add_amount/<?php echo $customer->id;?>">
		Add Amount</a></span>
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
		<td><?php echo $result['job_id'] ? $result['job_id'] : "-";?></td>
		<td><?php echo $result['jobname'];?></td>
		<td>
			<?php 
				$show = "-";
					if($result['t_type'] == DEBIT ) {
							$show = $result['amount'];
					}
				echo $show;?>
		</td>
		<td>
			<?php 
				$show = "-";
					if($result['t_type'] != DEBIT ) {
							$show = $result['amount'];
					}
				echo $show;
				if(!empty($result['receipt'])) {
					echo '&nbsp;&nbsp;&nbsp;[Receipt No : '.$result['receipt']."]";
				}
				if(!empty($result['bill_number'])) {
					echo '&nbsp;&nbsp;&nbsp;[Bill No : '.$result['bill_number']."]";
				}
				
				?>
		</td>
		<td>
			<?php echo $balance;?>
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

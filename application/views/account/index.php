<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<style>
.red {color:red;font-weight:bold;}
.green {color:green;}
</style>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Customer Account Details</h3>
	</div><!-- /.box-header -->
	<div class="box-header">
		<span><a href="<?php echo site_url();?>/customer/edit/">Add Customer</a></span>
	</div>
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Total Debit</th>
		<th>Total Credit</th>
		<th>Balance</th>
		<th>Mobile</th>
		<th>Email Id</th>
		<th>City</th>
		<th>Status</th>
		<th>Account</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($customers as $customer) { ?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $customer->companyname;?></td>
		<td><?php echo $customer->name;?></td>
		<td><?php echo round($customer->total_debit,2);?></td>
		<td><?php echo $customer->total_credit;?></td>
		<td><?php $balance = round($customer->total_credit - $customer->total_debit,0);
		$show = '<span class="green">'.$balance.'</span>';
			if($balance < 0 ) {
				$show = '<span class="red">'.$balance.'</span>';
			} 
			echo $show;
		?></td>
		<td><?php echo $customer->mobile;?><br><?php echo $customer->officecontact;?></td>
		<td><?php echo $customer->emailid;?></td>
		<td><?php echo $customer->city;?></td>
		<td><?php 
			$status = "Inactive";
				if($customer->status == '1') { $status = "Active"; }
				echo $status;
		?></td>
		<td><a target="_blank" href="<?php echo site_url();?>/account/account_details/<?php echo $customer->id;?>">View</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
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

<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

<div class="box">
	<div class="box-header">
		<h3 class="box-title">Prospect Details</h3>
	</div><!-- /.box-header -->
	<div class="box-header">
		<span><a href="<?php echo site_url();?>/customer/edit_prospects/">Add Prospect</a></span>
	</div>
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Category</th>
		<th>Mobile</th>
		<th>Contact</th>
		<th>Email Id</th>
		<th>City</th>
		<th>Status</th>
		<th>Created</th>
		<th>Edit</th>
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
		<td><?php echo $customer->ccategory;?></td>
		<td><?php echo $customer->mobile;?></td>
		<td><?php echo $customer->officecontact;?></td>
		<td><?php echo $customer->emailid;?></td>
		<td><?php echo $customer->city;?></td>
		<td><?php 
			$status = "Inactive";
				if($customer->status == '1') { $status = "Active"; }
				echo $status;
		?></td>
		<td><?php echo date('h:i A', strtotime($customer->created));?></td>
		<td><a href="<?php echo site_url();?>/customer/edit_prospects/<?php echo $customer->id;?>">Edit</a></td>
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

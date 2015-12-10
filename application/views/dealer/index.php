<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

<div class="box">
	<div class="box-header">
		<h3 class="box-title">Dealer Management</h3>
	</div><!-- /.box-header -->
	<div class="box-header">
		<span><a href="<?php echo site_url();?>/dealer/edit/">Add Dealer</a></span>
	</div>
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Dealer Code</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Total Amount</th>
		<th>Due</th>
		<th>Mobile</th>
		<th>Contact</th>
		<th>Email Id</th>
		<th>City</th>
		<th>Status</th>
		<th>View</th>
		<th>Edit</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($customers as $customer) {
			$update_status = 0;
			if($customer->status == 0) { $update_status = 1;}
			 ?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $customer->dealercode;?></td>
		<td><?php echo $customer->companyname;?></td>
		<td><?php echo $customer->name;?></td>
		<td><?php echo $customer->total_amount;?></td>
		<td><?php echo $customer->due;?></td>
		<td><?php echo $customer->mobile;?></td>
		<td><?php echo $customer->officecontact;?></td>
		<td><?php echo $customer->emailid;?></td>
		<td><?php echo $customer->city;?></td>
		<td>
		<span id="dealer_status" onclick="update_status(<?php echo $customer->id;?>,<?php echo $update_status;?>);">
		<?php 
			$status = "Inactive";
				if($customer->status == '1') { $status = "Active"; }
				echo $status;
		?></span></td>
		<td>View</td>
		<td><a href="<?php echo site_url();?>/dealer/edit/<?php echo $customer->id;?>">Edit</a></td>
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
                    "bDestroy": true,
                });
            });
            
function update_status(id,value) {
	var oTable = $('#example1').dataTable();
	 $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/dealer/update_dealer_status/"+id+"/"+value, 
         success: 
              function(data){
				  location.reload();
			 }
          });
}
        </script>

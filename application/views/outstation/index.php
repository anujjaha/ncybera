<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />

<div class="box">
	<div class="box-header">
		<h3 class="box-title">Out Station Customer Management</h3>
	</div><!-- /.box-header -->
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Total Amount</th>
		<th>Due</th>
		<th>Mobile</th>
		<th>Contact</th>
		<th>Email Id</th>
		<th>City</th>
		<th>Status</th>
		<th>Switch To Customer</th>
		<th>Switch To Dealer</th>
		<th>Account</th>
		<th>View</th>
		<th>Edit</th>
		<th>Delete</th>
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
		<td><?php echo $customer->companyname;?></td>
		<td><?php echo $customer->name;?></td>
		<td><?php echo round($customer->total_amount);?></td>
		<td><?php echo round($customer->due);?></td>
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
		<td>
			<a href="javascript:void(0);" onclick="switch_customer(<?php echo $customer->id;?>,0);">Set Customer</a>
		</td>
		<td>
			<a href="javascript:void(0);" onclick="switch_customer(<?php echo $customer->id;?>,1);">Set Dealer</a>
		</td>
		<td>
			<a target="_blank" href="<?php echo site_url();?>/account/account_details/<?php echo $customer->id;?>">View</a>
		</td>
		<td>
			<a class="fancybox" href="#view_customer_info" onclick="show_customer(<?php echo $customer->id;?>,0);">
				View
			</a>
			<a class="fancybox" href="#view_customer_info" onclick="show_customer(<?php echo $customer->id;?>,1);">
				Print
			</a>
		</td>
		<td><a href="<?php echo site_url();?>/dealer/edit/<?php echo $customer->id;?>">Edit</a></td>
		<td><a href="javascript:void(0);" onclick="delete_customer(<?php echo $customer->id;?>);">Delete</a></td>
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

function switch_customer(id){
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_switch_customer/"+id+"/0", 
         success: 
            function(data){
				location.reload();
            }
          });
}

function delete_customer(id){
	var status = confirm("Are you Sure, Want to Delete ? ");
	if(status == true) {
		$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_delete/"+id, 
         success: 
            function(data){
				location.reload();
            }
          });
    }
}
        </script>


<script>
function show_customer(id,option) {
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_view_customer/"+id+"/"+option, 
         success: 
            function(data){
				
				if(option == 1 ) {
					window.open(data);
				} else {
					jQuery("#c_data").html(data);
			  }
            }
          });
}
</script>
<div id="view_customer_info" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="c_data"></div>
</div>
</div>

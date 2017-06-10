<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<div class="box-body table-responsive">
		
		<table class="table table-bordered table-striped">
			<tr>
				<td align="right"> Employee Name : </td><td> <?php echo $employeeInfo->name;?> </td>
				<td align="right"> Contact Number : </td><td> <?php echo $employeeInfo->mobile;?> </td>
			</tr>
			
			<tr>
				<td align="right"> Blood Group : </td><td> <?php echo $employeeInfo->bgroup;?> </td>
				<td align="right"> Aadhar Card : </td><td> <?php echo $employeeInfo->aadharcard;?> </td>
			</tr>
			
			<tr>
				<td align="right"> Birth Date : </td><td> <?php echo date('d-m-Y', strtotime($employeeInfo->birthdate));?> </td>
				<td align="right"> Join Date : </td><td> <?php echo date('d-m-Y', strtotime($employeeInfo->join_date));?> </td>
			</tr>

			<tr>
				<td align="right"> Other Contact Name : </td><td> <?php echo $employeeInfo->altercontactname;?> </td>
				<td align="right"> Other Contact Number : </td><td> <?php echo $employeeInfo->altercontactnumber;?> </td>
			</tr>
		</table>
	</div>
	</div>
</div>
<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Month - Year</th>
		<th>Half Day</th>
		<th>Full Day</th>
		<th>Late</th>
		<th>Office Half Day</th>
		<th>Half Night</th>
		<th>Full Night</th>
		<th>Sunday</th>
		<th>Notes</th>
		<!--<th>Action</th>-->
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($items as $item) { 
		?>
		<tr id="emp-<?php echo $item['id'];?>">
		<td><?php echo $sr;?></td>
		<td><?php echo $item['month'] . '-' .$item['year'] ;?></td>
		<td><?php echo $item['half_day'];?></td>
		<td><?php echo $item['full_day'];?></td>
		<td><?php echo $item['office_late'];?></td>
		<td><?php echo $item['office_halfday'];?></td>
		<td><?php echo $item['half_night'];?></td>
		<td><?php echo $item['full_night'];?></td>
		<td><?php echo $item['sunday'];?></td>
		<td><?php echo $item['notes'];?></td>
		<!--<td>
				<a onclick="deleteEmployee(<?php echo $item['id'];?>);" href="javascript:void(0);">
					Delete
				</a>
		</td>-->
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
                    "iDisplayLength": 50,
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "bDestroy": true,
                });
            });
            
function deleteEmployee(id) {
	var status = confirm("Do You want to Delete Employee ?");
	if(status) {
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/employee/deleteEmployee/", 
         data:{'id':id},
         dataType: 'JSON',
         success: function(data)
         {	
			 if(data.status == true)
			  {
				 jQuery("#emp-" + id).hide();
			  }
		}
          });
    }
}
</script>


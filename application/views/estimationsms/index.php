<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>ID</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Estimation Details</th>
		<th>Created By</th>
		<th>Created On</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($estimations as $smsdata) { ?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $smsdata['sms_id'];?></td>
		<td><?php echo $smsdata['companyname'] ? $smsdata['companyname'] : $smsdata['prospectname'] ;?></td>
		<td><?php echo $smsdata['name'] ? $smsdata['name'] : $smsdata['prospectname'];?>
			</br>
			[<?php echo $smsdata['mobile'];?>]
		</td>
		<td><?php echo $smsdata['sms_message'];?></td>
		<td><?php echo $smsdata['nickname'];?></td>
		<td><?php echo date('d-m-Y H:i A',strtotime($smsdata['created']));?></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div>
	</div>
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
                    "iDisplayLength": 50
                });
            });
</script>


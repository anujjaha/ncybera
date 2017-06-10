<?php
if(strtolower($this->session->userdata['department']) != "master")
{
	redirect('cashier/add', 'refresh');
}
?>
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<a href="<?php echo base_url();?>cashier/add">
		Add New Cashier
	</a>
	</div>
</div>

<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Month</th>
		<th>Date</th>
		<th>Open Balance</th>
		<th>Total</th>
		<th>Close Balance</th>
		<th>Today Business</th>
		<th>Today Xerox Business</th>
		<th>Withdraw</th>
		<th>Expense</th>
		<!--<th>Action</th>-->
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		
		$totalBusiness = $totalXerox = $totalWithdrawal = $totalExpese = 0;
		foreach($items as $item) { 
			$totalBusiness 		= $totalBusiness +  $item['today_business'];
			$totalXerox 		= $totalXerox +  $item['xerox_business'];
			$totalWithdrawal 	= $totalWithdrawal +  $item['withdrawal'];
			$totalExpese 		= $totalExpese +  $item['expense'];
			?>
		<tr id="cashier-<?php echo $item['id'];?>">
		<td><?php echo $sr;?></td>
		<td><?php echo  date('F-Y', strtotime($item['today']));?></td>
		<td><?php echo  date('d-m-Y', strtotime($item['today']));?></td>
		<td><?php echo $item['open_balance'];?></td>
		<td><?php echo $item['total'];?></td>
		<td><?php echo $item['close_balance'];?></td>
		<td align="right"><?php echo $item['today_business'];?></td>
		<td align="right"><?php echo $item['xerox_business'];?></td>
		<td align="right"><?php echo $item['withdrawal'];?></td>
		<td align="right"><?php echo $item['expense'];?></td>
		<!--<td>
				<a onclick="deleteEmployee(<?php echo $item['id'];?>);" href="javascript:void(0);">
					Delete
				</a>
		</td>-->
		</tr>
		<?php $sr++; } ?>
		<tr id="cashier-<?php echo $item['id'];?>">
		<td>Total </td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td align="right"><?php echo $totalBusiness;?></td>
		<td align="right"><?php echo $totalXerox;?></td>
		<td align="right"><?php echo $totalWithdrawal;?></td>
		<td align="right"><?php echo $totalExpese;?></td>
		<!--<td>
				<a onclick="deleteEmployee(<?php echo $item['id'];?>);" href="javascript:void(0);">
					Delete
				</a>
		</td>-->
		</tr>
	</tfoot>
	</table>
	</div>
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


<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<h3>
		Search Result Old Voucher :
	</h3>
	</div>
</div>

<div class="box">
	<h3>Old Vouchers</h3>
	<div class="box-body table-responsive">
		<?php
			foreach($items as $item)
			{
		?>
		<table width="100%" border="1" align="center">
			<tr>
				<td>Company Name : <?php echo $item['name'];?></td>
				<td>Name : <?php echo $item['rname'];?></td>
				<td align="center">Mobile : <?php echo $item['mob'];?></td>
				<td align="center">Date : <?php echo $item['date'];?></td>
			<tr>
			<tr>
				<td colspan="4">
					<table width="100%" border="1" align="center">
						<tr>
							<td>Sr</td>
							<td>Name</td>
							<td>Page</td>
							<td>Set</td>
							<td>Qty</td>
							<td>Price Per Piece</td>
							<td>Total</td>
						</tr>
						<?php
							for($i = 1; $i <= 10; $i++)
							{
								if(strlen($item['p'.$i]) > 1 ) 
								{
						?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $item['p'.$i];?></td>
								<td><?php echo $item['s'.$i];?></td>
								<td><?php echo $item['j'.$i];?></td>
								<td><?php echo $item['q'.$i];?></td>
								<td><?php echo $item['pp'.$i];?></td>
								<td><?php echo $item['t'.$i];?></td>
							</tr>
						<?php
								}
							}
						?>
					</table>
				</td>
			</tr>
		</table>
		<hr>
		<?php } ?>
	</div>
</div>
<?php /*
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
</script>

<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>

*/?>

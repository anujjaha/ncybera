
<div class="box">
<div class="box-header">
	<h3 class="box-title">Department Progress</h3>
</div><!-- /.box-header -->
<div class="box-body no-padding">
	<table class="table table-striped">
		<tbody><tr>
			<th style="width: 10px">Sr</th>
			<th>Department Title</th>
			<th>Amount</th>
		</tr>
		<?php $dept = get_department_revenue();?>
		<tr>
			<td>1.</td>
			<td>Digital Print</td>
			<td><?php echo $dept->dprint;?></td>
		</tr>
		<tr>
			<td>2.</td>
			<td>Visiting Card</td>
			<td><?php echo $dept->dvisitingcard;?></td>
		</tr>
		<tr>
			<td>3.</td>
			<td>Designing</td>
			<td><?php echo $dept->ddesigning;?></td>
		</tr>
		<tr>
			<td>4.</td>
			<td>Offset Print</td>
			<td><?php echo $dept->doffsetprint;?></td>
		</tr>
		<tr>
			<td>5.</td>
			<td>Flex</td>
			<td><?php echo $dept->dflex;?></td>
		</tr>
		<tr>
			<td>5.</td>
			<td>Cutting</td>
			<td><?php echo $dept->dcutting;?></td>
		</tr>
		<tr>
			<td>6.</td>
			<td>Lamination</td>
			<td><?php echo $dept->dlamination;?></td>
		</tr>
		
		<tr>
			<td>7.</td>
			<td>Binding</td>
			<td><?php echo $dept->dbinding;?></td>
		</tr>
		
		<tr>
			<td>8.</td>
			<td>B/W Print</td>
			<td><?php echo $dept->dbwpring;?></td>
		</tr>
		
		<tr>
			<td>9.</td>
			<td>Packaging & Forwading</td>
			<td><?php echo $dept->dpackaging;?></td>
		</tr>
		
		<tr>
			<td>10.</td>
			<td>Trasnportation</td>
			<td><?php echo $dept->dtransportation;?></td>
		</tr>
	</tbody></table>
</div><!-- /.box-body -->
</div>

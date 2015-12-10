<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
	<div class="col-lg-3 col-xs-6">
<!-- small box -->
	<div class="small-box bg-aqua">
		<div class="inner">
			<h3> <?php echo $today_jobs;?> </h3>
			<p>Today Jobs</p>
		</div>
		<div class="icon">
			<i class="ion ion-bag"></i>
		</div>	
		<a href="#" class="small-box-footer">
			More info <i class="fa fa-arrow-circle-right"></i>
		</a>
		</div>
	</div><!-- ./col -->
	
	<div class="col-lg-3 col-xs-6">
	<!-- small box -->
		<div class="small-box bg-green">
		<div class="inner">
			<h3> <?php echo $today_counter;?><!--<sup style="font-size: 20px">%</sup>--> </h3>
			<p>Today Counter </p>
		</div>
		<div class="icon">
			<i class="ion ion-stats-bars"></i>
		</div>
		<a href="#" class="small-box-footer">
			More info <i class="fa fa-arrow-circle-right"></i>
		</a>
		</div>
	</div><!-- ./col -->
	<div class="col-lg-3 col-xs-6">
	<!-- small box -->
		<div class="small-box bg-yellow">
			<div class="inner">
			<h3> <?php echo $total_dealers;?> </h3>
			<p> Total Dealers </p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="#" class="small-box-footer">
				More info <i class="fa fa-arrow-circle-right"></i>
			</a>
			</div>
	</div><!-- ./col -->

	<div class="col-lg-3 col-xs-6">
		<!-- small box -->
		<div class="small-box bg-red">
			<div class="inner">
				<h3> <?php echo $total_customers;?> </h3>
				<p> Total Customers </p>
			</div>
			<div class="icon">
				<i class="ion ion-pie-graph"></i>
			</div>
			<a href="#" class="small-box-footer">
				More info <i class="fa fa-arrow-circle-right"></i>
			</a>
		</div>
	</div><!-- ./col -->
</div><!-- /.row -->
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Data Table With Full Features</h3>
	</div><!-- /.box-header -->
	<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Job Details</th>
		<th>Customer Name</th>
		<th>Mobile</th>
		<th>Bill Amount</th>
		<th>Advance</th>
		<th>Due</th>
		<th>Time</th>
		<th>Status</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		echo "<pre>";
		print_r($jobs;die;
		foreach($jobs as $job) { ?>
		<tr>
		<th><?php echo $sr;?></th>
		<th><?php echo $job->id."-".$job->jobname;?></th>
		<th><?php echo $job->name;?></th>
		<th><?php echo $job->mobile;?></th>
		<th><?php echo $job->total;?></th>
		<th><?php echo $job->advance;?></th>
		<th><?php echo $job->due;?></th>
		<th><?php echo date('h:i A', strtotime($job->created));?></th>
		<th><?php echo $job->jstatus;?></th>
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
                    "bAutoWidth": true
                });
            });
        </script>

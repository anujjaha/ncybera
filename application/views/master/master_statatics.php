<div class="row">
	
<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-aqua">
	<div class="inner">
		<h3><?php echo $statstics['today_job_count'];?></h3>
		<p>Today Orders</p>
	</div>
	<div class="icon"><i class="ion ion-bag"></i></div>
		<a href="<?php echo site_url();?>/master/today_orders/" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	</div>
</div>

<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-green">
	<div class="inner">
		<h3><?php echo $statstics['today_total_collection'];?> Rs.</h3>
		<p>Today Collection</p>
	</div>
	<div class="icon"><i class="ion ion-stats-bars"></i></div>
		<a href="<?php echo site_url();?>/master/today_orders/" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	</div>
</div><!-- ./col -->
<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-yellow">
	<div class="inner">
		<h3><?php echo $statstics['total_month_job'];?></h3>
		<p>Total Jobs for <?php echo date('M-Y');?></p>
	</div>
	<div class="icon"><i class="ion ion-person-add"></i></div>
		<a href="<?php echo site_url();?>/master/monthly_orders/" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	</div>
</div><!-- ./col -->

<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-red">
	<div class="inner">
		<h3><?php echo  round($statstics['total_month_collection']);?>  Rs.</h3>
		<p>Total Collections for <?php echo date('M-Y');?></p>
	</div>
	<div class="icon"><i class="ion ion-pie-graph"></i></div>
		<a href="<?php echo site_url();?>/master/monthly_orders/" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	</div>
</div><!-- ./col -->

</div><!-- /.row -->

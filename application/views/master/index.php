<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<section class="content">
<!-- Small boxes (Stat box) -->
<div class="row">
	
<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-aqua">
	<div class="inner">
		<h3><?php echo $statstics['today_job_count'];?></h3>
		<p>Today Orders</p>
	</div>
	<div class="icon"><i class="ion ion-bag"></i></div>
		<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	</div>
</div>

<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-green">
	<div class="inner">
		<h3><?php echo $statstics['today_total_collection'];?> Rs.</h3>
		<p>Today Collection</p>
	</div>
	<div class="icon"><i class="ion ion-stats-bars"></i></div>
		<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	</div>
</div><!-- ./col -->
<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-yellow">
	<div class="inner">
		<h3><?php echo $statstics['total_month_job'];?></h3>
		<p>Total Jobs for <?php echo date('M-Y');?></p>
	</div>
	<div class="icon"><i class="ion ion-person-add"></i></div>
		<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	</div>
</div><!-- ./col -->

<div class="col-lg-3 col-xs-6">
	<div class="small-box bg-red">
	<div class="inner">
		<h3><?php echo  round($statstics['total_month_collection']);?>  Rs.</h3>
		<p>Total Collections for <?php echo date('M-Y');?></p>
	</div>
	<div class="icon"><i class="ion ion-pie-graph"></i></div>
		<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	</div>
</div><!-- ./col -->

</div><!-- /.row -->

<!-- Main row -->
<div class="row">
<hr>
<!-- Left col -->
<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>

<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Job Num</th>
		<th>Company Name</th>
		<th>Customer Name</th>
		<th>Job Name</th>
		<th>Mobile</th>
		<th>Bill Amount</th>
		<th>Advance</th>
		<th>Due</th>
		<th>Receipt</th>
		<th>Voucher Number</th>
		<th>Bill Number</th>
		<th>Date / Time</th>
		<th>View</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($unverify_jobs as $job) { 
			?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $job['job_id'];?></td>
		<td><?php echo $job['companyname'];?></td>
		<td><?php echo $job['name'];?></td>
		<td><?php echo $job['jobname'];?></td>
		<td><?php echo $job['mobile'];?></td>
		<td><?php echo $job['total'];?></td>
		<td><?php echo $job['advance'];?></td>
		<td><?php echo $job['due']?$job['due']:"<span style='color:green;font-weight:bold;'>Paid</span>";?></td>
		<td><?php echo $job['receipt'];?></td>
		<td><?php echo $job['voucher_number'];?></td>
		<td><?php echo $job['bill_number'];?></td>
		<td><?php echo date('d-m-Y',strtotime($job['created']))
						." - ".
						date('h:i A',strtotime($job['created']));?>
		</td>
		<td><a class="fancybox"  onclick="show_job_details(<?php echo $job['job_id'];?>);" href="#view_job_details">View</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
</div><!-- /.row (main row) -->

</section>
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
function show_job_details(job_id){
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_details/"+job_id, 
         success: 
            function(data){
                  jQuery("#job_view").html(data);
            }
          });
}
</script>

<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>

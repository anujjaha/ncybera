<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />

<script>
    $(document).ready(function() {
      $('.fancybox').fancybox({
        'width':900,
        'height':600,
        'autoSize' : false,
    });
});

function show_job_details(job_id,sr){
	
	view_job(sr,job_id);
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
<style>
	audio {
		display:none;
	}
</style>
<script>
function stopaudio() {
	$('audio').each(function(){
    this.pause(); // Stop playing
    this.currentTime = 0; // Reset time
}); 
}
function startaudio() {
	$('audio').each(function(){
    this.play(); // Stop playing
    this.currentTime = 0; // Reset time
}); 
}
</script>
<audio id="myAudio" controls autostart="true">
<source src="<?php echo PRINT_MUSIC;?>" type="audio/mpeg">
</audio>
<div class="row">
</div>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Job Num</th>
		<th>Customer Name</th>
		<th>Job Name</th>
		<th>Details</th>
		<th>Quantity</th>
		<th>Date / Time</th>
		<th>Status</th>
		<th>Working</th>
		<th>Completed</th>
		<th>View</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$job_count = count($jobs);
		$sr =1;	
		foreach($jobs as $job) { 
			$jdetails = "";
			$jqty = "";
				foreach($job_details[$job['job_id']] as $job_data) {
					$jdetails .= $job_data['jdetails']."<br>";
					$jqty .= $job_data['jqty']."<br>";
				}
			?>
		<tr>
		<td>
		<p id="jview_<?php echo $sr;?>">
		<?php
			if($job['j_view']) {
				echo $sr;
			}else { ?>
			<script>startaudio();</script>	
			 <i class="fa fa-refresh fa-spin fa-4x" onclick="view_job(<?php echo $sr;?>,<?php echo $job['job_id'];?>);"></i><?php } ?>
		</p>
		</td>
		<td><?php echo $job['job_id'];?></td>
		<td><?php echo $job['name'];?></td>
		<td><?php echo $job['jobname'];?></td>
		<td><?php echo $jdetails;?></td>
		<td><?php echo $jqty;?></td>
		<td><?php echo date('m-d-Y',strtotime($job['created']))." ".date('h:i a',strtotime($job['created']));?></td>
		<td><?php echo $job['jstatus'];?></td>
		<td>
			<?php
			if($job['jstatus'] != JOB_PRINT) {
			?>
			<a href="javascript:void(0);" onclick="quick_update_job_status(<?php echo $sr;?>,<?php echo $job['job_id'];?>,'<?php echo JOB_PRINT;?>');">
				Printing
			</a>
			<?php } ?>
		</td>
		<td>
			<?php
			if($job['jstatus'] != JOB_PRINT_COMPLETED) {
			?>
			<a href="javascript:void(0);" onclick="quick_update_job_status(<?php echo $sr;?>,<?php echo $job['job_id'];?>,'<?php echo JOB_PRINT_COMPLETED;?>');">
				Printing Completed
			</a>
			<?php } ?>
		</td>
		<td><a class="fancybox"  onclick="show_job_details(<?php echo $job['job_id'];?>,<?php echo $sr;?>);" href="#view_job_details">View</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	</table>
	</div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>
<input type="hidden" name="get_job_count" id="get_job_count" value="<?php echo count($jobs);?>">
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
            
function update_job_status(id) {
	var value = $( "input:radio[name=jstatus]:checked" ).val();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/prints/update_job_status/"+id, 
         data:{"j_id":id,"j_status":value},
         success: 
              function(data){
					$.fancybox.close();
                    location.reload();
			 }
          });
}
function quick_update_job_status(sr,id,value) {
	view_job(sr,id);
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/prints/update_job_status/"+id, 
         data:{"j_id":id,"j_status":value},
         success: 
              function(data){
	                location.reload();
			 }
          });
}

function update_datatable_grid() {
		$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_datatable/", 
         success: 
            function(data){
				location.reload();
				/*
				jQuery("#job_datatable").html(data);
				$('#example1').dataTable({
						"bPaginate": true,
						"bLengthChange": true,
						"iDisplayLength": 50,
						"bFilter": true,
						"bSort": true,
						"bInfo": true,
						"bAutoWidth": true,
						"bDestroy": true,
					});*/
				
            }
          });
}

function loadlink() {
		var jcount = jQuery("#get_job_count").val();
		$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_count/", 
         success: 
            function(data){
				if(jcount != data) {
					jQuery("#get_job_count").val(data);
					update_datatable_grid();
				}
				return true;
          }
          });
}
  
loadlink(); 
setInterval(function(){
    loadlink();
}, 10000);

function view_job(sr,id) {
	stopaudio();
	jQuery("#jview_"+sr).html(sr);
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_job_view", 
         data:{'id':id,'department':'<?php echo $this->session->userdata['department'];?>'},
         success: 
            function(data){
				return true;
          }
          });
}	
        </script>
<div id="view_job_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="job_view"></div>
</div>
</div>


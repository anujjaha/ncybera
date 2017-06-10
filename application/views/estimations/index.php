<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<div class="row">
<div class="col-md-12">
	<a href="<?php echo base_url();?>estimation/create">
		Create New Estimation
	</a>
	</div>
</div>
<style>
	td { font-size: 12px; }
</style>
<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Name</th>
		<th>Subject</th>
		<th>Mobile</th>
		<th>Email Id</th>
		<th>Created At</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($items as $item) { ?>
		<tr>
		<td> <?php echo $sr; ?></td>
		<td><?php echo $item['name'];?></td>
		<td><?php echo $item['subject'];?></td>
		<td><?php echo $item['mobile'];?></td>
		<td><?php echo $item['emailid'];?></td>
		<td><?php echo date("d-m-Y H:i A", strtotime($item['created_at']));?></td>
		<td width="85px;">
			<input type="hidden" id="hiddenConent-<?php echo $item['id'];?>" value='<?php echo $item['content'];?>'>
			<input type="hidden" id="hiddenCreatedDate-<?php echo $item['id'];?>" value="<?php echo date('d-m-Y H:i A', strtotime($item['created_at']));?>">
			<a class="fancybox"  onclick="showEstimationContent(<?php echo $item['id'];?>);" href="#viewEstimationContent">View</a>
			<a href="<?php echo site_url();?>/estimation/forward/<?php echo $item['id'];?>">Forward</a>
		</td>
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
    
    $(document).ready(function() {
      $('.fancybox').fancybox({
        'width':900,
        'height':600,
        'autoSize' : false,
    });
});

function showEstimationContent(id)
{
	var content 	= jQuery("#hiddenConent-" + id).val(),
		//validity 	= jQuery("#hiddenValidity-" + id).val(),
		createdDate = jQuery("#hiddenCreatedDate-" + id).val(),
		header 		= "<center><h3>Email Content </h3></center><br><strong>Created On : " + createdDate + "</strong><hr>";
	
	jQuery("#content").html(header);
	jQuery("#content").append(content);
	//jQuery("#content").append("<hr><center><strong>Validity : " + validity + " </strong></center><hr>");
}
</script>

<div id="viewEstimationContent" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
    <div id="content"></div>
</div>
</div>

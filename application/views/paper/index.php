<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<a href="<?php echo base_url();?>paper/add_paper">
		Add New Paper
	</a>
	</div>
</div>
<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Paper Name</th>
		<th>Gram</th>
		<th>Size</th>
		<th>Quantity Range</th>
		<th>Cost</th>
		<th>Edit</th>
		<th>Delete</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($papers as $paper) { 
			?>
		<tr id="item-<?php echo $paper['id'];?>">
		<td><?php echo $sr;?></td>
		<td><?php echo $paper['paper_name'];?></td>
		<td><?php echo $paper['paper_gram'];?></td>
		<td><?php echo $paper['paper_size'];?></td>
		<td><?php echo $paper['paper_qty_min']."-".$paper['paper_qty_max'];?></td>
		<td id="cost_<?php echo $paper['id'];?>"><?php echo $paper['paper_amount'];?></td>
		<td><a href="javascript:void(main)" onclick="edit_paper(<?php echo $paper['id'];?>,<?php echo $paper['paper_amount'];?>);">Edit</a></td>
		<td><a href="javascript:void(main)" onclick="delete_paper(<?php echo $paper['id'];?>);">Delete</a></td>
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
            
function delete_paper(id) {
	var status = confirm("Do You want to Delete Paper ?");
	if(status) {
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/paper/delete_paper/", 
         data:{'id':id},
         success: 
              function(data){
				  jQuery("#item-" + id).hide();
				 //location.reload();
			 }
          });
    }
}
function edit_paper(id,value) {
	jQuery("#cost_"+id).html("<input type='text' id='update_"+id+"' name='update_"+id+"' value='"+value+"' style='width:50px;'><a href='javascript:void(main)' onclick='save_job("+id+","+value+")' class='glyphicon glyphicon-ok'></a>");
}

function save_job(id,value) {
	var value = jQuery("#update_"+id).val();
	
	if(id) {
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/paper/update_paper/", 
         data:{'id':id,'value':value},
         success: 
              function(data){
				 jQuery("#cost_"+id).html(data);
			 }
          });
    }
	
}
        </script>


<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<div class="row">
<div class="col-md-12">
	<a href="<?php echo base_url();?>cdirectory/add">
		Add New Member
	</a>
	</div>
</div>
<?php 

?>
<div class="box">
	<div class="box-body table-responsive">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Name</th>
		<th>Phone</th>
		<th>Mobile</th>
		<th>Edit</th>
		<th>Delete</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($data as $udata) { 
			?>
		<tr id="del_<?php echo $udata['id'];?>">
		<td><?php echo $sr;?></td>
		<td><?php echo $udata['name'];?></td>
		<td><?php echo $udata['phone'];?></td>
		<td><?php echo $udata['mobile'];?></td>
		<td>
			<a href="<?php echo base_url();?>/cdirectory/edit/<?php echo $udata['id'];?>"> E </a>
		</td>
		<td><a href="javascript:void(main)" onclick="delete_direcotry(<?php echo $udata['id'];?>);">Delete</a></td>
		
			
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
            
function delete_direcotry(id) {
	var status = confirm("Do You want to Delete Paper ?");
	if(status) {
	jQuery("#del_"+id).remove();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/cdirectory/delete_data/", 
         data:{'id':id},
         success: 
              function(data){
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


<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />



<?php
/*echo "<pre>";
print_r($books);
die;*/
?>
<h4>Customer Book History </h4>
<a href="<?php echo site_url();?>/book/add">Add Book</a>
<div class="box">
	<div class="box-body table-responsive" id="job_datatable">
		<table id="example1" class="example1 table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th>Customer</th>
		<th>Mobile Number</th>
		<th>Book Title</th>
		<th>Paid </th>
		<th>Amount</th>
		<th>Qty</th>
		<th>Courier</th>
		<th>Created By</th>
		<th>Created Time</th>
		<th>Action</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$job_count = count($tasks);
		$sr =1;	
		foreach($books as $book)
		 { 
			?>
		<tr id="book_<?php echo $book['book_id'];?>">
			<td><?php echo $sr;?></td>
			<td><?php echo $book['name'] ? $book['name'] : $book['companyname'];?></td>
			<td><?php echo $book['customer_mobile'];?></td>
			
			<td><?php echo $book['book_title'];?></td>
			<td><?php echo ( $book['paid'] == 1 ) ? 'Paid' : 'Free'; ?></td>
			<td><?php echo ( $book['paid'] == 1 ) ? $book['amount'] : '-' ;?></td>
			<td><?php echo $book['book_qty'];?></td>
			<td><?php echo ($book['is_courier'] == 1 ) ? 'Yes' : '-' ;?></td>
			<td><?php echo $book['nickname'];?></td>
			<td><?php echo date("d-m-Y H:i A",strtotime($book['created_at']));?></td>
			<td>
				<a href="javascript:void(0);" onclick="delete_book(<?php echo $book['book_id'];?>);"> Delete </a>
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
                    "bFilter": true,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": true,
                    "bDestroy": true,
                    "iDisplayLength": 50
                });
            });
 function delete_book(id) {
	 var sconfirm = confirm("Do You want to Delete Sample Book Entry ?");
	 
	 if(sconfirm == false ) {
		 return false;
	 }
	 jQuery("#book_"+id).remove();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/ajax_book_delete", 
         data : { "id" :id },
         success: 
              function(data){
				  
			 }
          });	
 }
 </script>

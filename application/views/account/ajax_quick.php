<div class="box-body table-responsive">
		<table id="example1" class="table table-bordered table-striped">
		<thead>
		<tr>
		<th>Sr</th>
		<th><span onclick="sort_filter('companyname','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Company Name
			<span onclick="sort_filter('companyname','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th><span onclick="sort_filter('name','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Customer Name
			<span onclick="sort_filter('name','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>
			<span onclick="balance_filter('total_debit','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Total Debit
			<span onclick="balance_filter('total_debit','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>
			<span onclick="balance_filter('total_credit','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Total Credit
			<span onclick="balance_filter('total_credit','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>
			<span onclick="balance_filter('balance','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Balance
			<span onclick="balance_filter('balance','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
			
		</th>
		<th><span onclick="sort_filter('mobile','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
				Mobile
			<span onclick="sort_filter('mobile','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th><span onclick="sort_filter('emailid','ASC');">
				<i class="fa fa-sort-desc" aria-hidden="true"></i>
			</span>
			Email Id
			<span onclick="sort_filter('emailid','DESC');">
				<i class="fa fa-sort-asc" aria-hidden="true"></i>
			</span>
		</th>
		<th>City</th>
		<th>Status</th>
		<th>Account</th>
		</tr>
		</thead>
	<tbody>
		<?php
		$sr =1;	
		foreach($customers as $customer) { ?>
		<tr>
		<td><?php echo $sr;?></td>
		<td><?php echo $customer->companyname;?></td>
		<td><?php echo $customer->name;?></td>
		<td><?php echo round($customer->total_debit,2);?></td>
		<td><?php echo $customer->total_credit;?></td>
		<td><?php $balance = round($customer->total_credit - $customer->total_debit,0);
		$show = '<span class="green">'.$balance.'</span>';
			if($balance < 0 ) {
				$show = '<span class="red">'.$balance.'</span>';
			} 
			echo $show;
		?></td>
		<td><?php echo $customer->mobile;?><br><?php echo $customer->officecontact;?></td>
		<td><?php echo $customer->emailid;?></td>
		<td><?php echo $customer->city;?></td>
		<td><?php 
			$status = "Inactive";
				if($customer->status == '1') { $status = "Active"; }
				echo $status;
		?></td>
		<td><a target="_blank" href="<?php echo site_url();?>/account/account_details/<?php echo $customer->id;?>">View</a>
		||
			<a target="_blank" href="<?php echo site_url();?>/customer/edit/<?php echo $customer->id;?>">Edit</a></td>
		</tr>
		<?php $sr++; } ?>
	</tfoot>
	<tr>
		<td colspan="11" align="center">
			<span class="btn btn-success" onclick="pagination('next');">Next</span>
			<span class="btn btn-success"  onclick="pagination('previous');">Previous</span>
			<input type="hidden" name="offset" id="offset" value="<?php echo $offset;?>">
		</td>
	</tr>
	
	</table>
	</div><!-- /.box-body -->
</div><!-- /.box -->
</div>

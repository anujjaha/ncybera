<?php
	$attributes = array('class' => 'form', 'id' => 'create_bulk');
	echo form_open('estimation/bulk', $attributes);
?>
<div class="row">
		<div class="col-md-11">
		 	<div class="box box-success">
			
			<div class="box-header with-border">
			  
			  <?php
			  if(isset($msg))
			  {
				  echo "<h3 class='box-title'>".$msg."</h3>";
			  }
			  else
			  {
				echo '<h3 class="box-title">Create Email</h3>';
			  }
			  ?>
			</div>
			
			<div class="box-body">
			
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-4">
						<h4>Customers (<?php echo count(getAllEmailBulkCustomersOnly());?>)</h4>
						<?php 
							$chtml = '';
							$all_customer = getAllEmailBulkCustomersOnly(); 
							foreach($all_customer as $customer) 
							{
								$c_name = $customer->companyname;
								
								if(empty($c_name)) {
									$c_name = $customer->name;
								}
								$chtml .= "<option value='".$customer->emailid."'>".$c_name." [".$customer->emailid."]</option>";
							}
							?>
							<select multiple="multiple" class="form-control estimation-customer-list" name="estimation_customer[]" id="estimation_customer">
								<?php echo $chtml;?>	
							</select>
							
					</div>
					<div class="col-md-4">
						<h4>Dealers (<?php echo count(getAllEmailBulkDealersOnly());?>)</h4>
						<?php 
						$dhtml = '';
						$all_customer = getAllEmailBulkDealersOnly(); 
						foreach($all_customer as $customer) 
						{
							$c_name = $customer->companyname;
							
							if(empty($c_name)) {
								$c_name = $customer->name;
							}
							$dhtml .= "<option value='".$customer->emailid."'>".$c_name." [".$customer->emailid."]</option>";
						}
						?>
						<select multiple="multiple" class="form-control estimation-dealer-list" name="estimation_customer[]" id="estimation_dealer_customer">
							<?php echo $dhtml;?>	
						</select>
						
					</div>
					<div class="col-md-4">
						<h4>Voucher Customers(<?php echo count(getAllEmailBulkVourcherCustomerOnly());?>)</h4>
						<?php 
						$vhtml = '';
						$all_customer = getAllEmailBulkVourcherCustomerOnly(); 
						foreach($all_customer as $customer) 
						{
							$c_name = $customer->companyname;
							
							if(empty($c_name)) {
								$c_name = $customer->name;
							}
							$vhtml .= "<option value='".$customer->emailid."'>".$c_name." [".$customer->emailid."]</option>";
						}
						?>
						<select multiple="multiple" class="form-control estimation-voucher-list" name="estimation_customer[]" id="estimation_voucher_customer">
							<?php echo $vhtml;?>	
						</select>
						
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<!--Select Customer:-->
			<?php 
			/*$html = '';
			$all_customer = getAllEmailBulkCustomers(); 
			foreach($all_customer as $customer) 
			{
				$c_name = $customer->companyname;
				
				if(empty($c_name)) {
					$c_name = $customer->name;
				}
				$html .= "<option value='".$customer->emailid."'>".$c_name." [".$customer->emailid."]</option>";
			}
			?>
			<select multiple="multiple" class="form-control estimation-customer-list" name="estimation_customer[]" id="estimation_customer">
				<?php echo $html;?>	
			</select>
				*/?>		
			</div>
			<div class="box-body">
				<h3>Subject</h3>
			<input type="text" value="" name="subject" id="name" class="form-control" required="required">
			</div>

			

			<div class="box-body">
				<h3>Add Content</h3>
				<textarea name="editor1"  id="my_editor"><?php echo SITE_SIGNATURE;?></textarea>
			    <iframe id="form_target" name="form_target" style="display:none"></iframe>
			</div>
			
			
			<div class="box-body text-center">
			
				<?php	
				$submit = array(
						'id'      => 'submit',
						'class'   => 'btn btn-primary btn-flat',
						'onClick' => 'return validateForm();'
				);

				$reset = array(
						'id'    => 'submit',
						'class' => 'btn btn-primary btn-flat'
				);

				$hiddenUserId = array( 'name' => 'contact_ids',
										'id' => 'contact_ids',
										'type' => 'hidden'
									);
				echo form_input($hiddenUserId);

				$htmlContent = array(
					'name' => 'html_content',
					'id'   => 'html_content',
					'type' => 'hidden'
				);
				echo form_input($htmlContent);

				$fromName = array(
					'name' => 'from_name',
					'id'   => 'from_name',
					'type' => 'hidden',
					'value'=> 'Cybera Print Art'
				);
				echo form_input($fromName);
				
				$fromEmail = array(
					'name' => 'from_email',
					'id'   => 'from_email',
					'type' => 'hidden',
					'value'=> 'cybera.printart@gmail.com'

				);
				echo form_input($fromEmail);
				
				echo form_submit('submit', 'Save',$submit);
				echo form_reset('reset', 'Reset',$reset);
			?>
			<input type="hidden" value="default" name="validity"  class="form-control">
			<input type="hidden" name="customer_name" id="customer_name">
			</form>
			
			</div>
		</div> 
	</div>
</div>

<iframe id="form_target" name="form_target" style="display:none"></iframe>
<form id="my_form" action="<?php echo site_url();?>estimation/uploadImage" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
<input name="image" type="file" onchange="$('#my_form').submit();this.value='';">
</form>

<script type="text/javascript" language="javascript" src="<?php echo site_url();?>assets/tinymce/tinymce.min.js"></script>
<script>
	
//Tiny Mce Editor
tinymce.init({
	selector: 'textarea',
	relative_urls : false,
	remove_script_host : false,
	convert_urls : true,
	automatic_uploads: true,
	height: 300,
	theme: 'modern',
	plugins: [
		'image',
		'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		'searchreplace wordcount visualblocks visualchars code fullscreen',
		'insertdatetime media nonbreaking save table contextmenu directionality',
		'emoticons template paste textcolor colorpicker textpattern imagetools'
	],
	toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	toolbar2: 'print preview media | forecolor backcolor emoticons',
	image_advtab: true,
	templates: [
		{ title: 'Test template 1', content: 'Test 1' },
		{ title: 'Test template 2', content: 'Test 2' }
	],
	content_css: [
		'//www.tinymce.com/css/codepen.min.css'
	],
	file_browser_callback: function(field_name, url, type, win) {
		if(type=='image')
		{
			$('#my_form input').click();	
		} 
	}
	 });



function validateForm()
{
	tinyMCE.triggerSave();
	var content =$('#my_editor').val();
	jQuery("#html_content").val(content);
	return true;
}

var options_customer = $('select.estimation-customer-list option');
     var arr = options_customer.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options_customer.each(function(i, o) {
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });

var options_dealer = $('select.estimation-dealer-list option');
     var arr = options_dealer.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options_dealer.each(function(i, o) {
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });
    
var options_voucher = $('select.estimation-voucher-list option');
     var arr = options_voucher.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options_voucher.each(function(i, o) {
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });
</script>

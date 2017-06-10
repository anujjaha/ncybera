<?php
	$attributes = array('class' => 'form', 'id' => 'create_email');
	echo form_open('estimation/edited', $attributes);
	
?>
<div class="row">
		<div class="col-md-11">
		 	<div class="box-body">
				<h3>Email id</h3>
			<input type="text" value="<?php echo $item->emailid;?>" name="email_id" id="email_id" class="form-control" required="required">
			</div>
			
			
			<div class="box-body">
				<h3>Subject</h3>
			<input type="text" value="Forward: <?php echo $item->subject;?>" name="subject" id="name" class="form-control" required="required">
			</div>

			

			<div class="box-body">
				<h3>Add Content</h3>
				<textarea name="editor1"  id="my_editor"><?php echo $item->content;?></textarea>
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
			<input type="hidden" name="mobile" id="mobile" value="<?php echo $item->mobile;?>">
			<input type="hidden" name="customer_name" id="customer_name" value="<?php echo $item->name;?>">
			<input type="hidden" name="estimation_customer" value="<?php echo $item->customer_id;?>" id="estimation_customer">
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
	function show_sms_mobile() 
	{
		var customer_id = jQuery("#estimation_customer").val();
	if(customer_id == 0 ) {
		jQuery("#mobile").val('');
		return true;
	}
    $.ajax({
     type: "POST",
     dataType:"json",
     url: "<?php echo site_url();?>/ajax/ajax_get_customer/"+customer_id, 
     success: 
        function(data){
			jQuery("#email_id").val(data['emailid']);
			jQuery("#mobile").val(data['mobile']);
			jQuery("#customer_name").val(data['name']);
			jQuery("#subject").focus();
		}
  });
}

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

var options_dealer = $('select.estimation-customer-list option');
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
</script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-tab.js"></script>


<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery.datetimepicker.css" media="screen" />


<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/tab.css" media="screen" />


<script>
function show_calculator()
	{
		window.open('<?php echo base_url();?>calc.html','welcome','width=360,height=320')
	}


window.setInterval(function(){
  check_notifications();
}, 60000);

function check_notifications() {
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/check_notifications/", 
		 success: 
            function(data){
				if(data != 0) {
					show_notifications(data);
				}
				
            }
          });
}

function show_notifications(data) {
	jQuery("#notification_div").html(data);
	$.fancybox({
                'href': '#notification_div'
	});
}
</script>
    <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo base_url();?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
               Cybera Print Art
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle collapsed-box" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
						<li class="dropdown messages-menu">
							<a href="<?php echo base_url().'cdirectory/index'?>">
								Directory
							</a>
						</li>
						<li class="dropdown messages-menu">
							<a href="#schedule" class="fancybox">
								Schedule Job
							</a>
						</li>
						<li class="dropdown messages-menu">
							<a href="#show_calculator" onclick="show_calculator();">
								Calculator
							</a>
						</li>
						<li class="dropdown messages-menu">
							<a href="#hfancy_box_demo" class="fancybox">
								Cybera Estimation
							</a>
						</li>
						<li class="dropdown messages-menu">
							<a href="#estimation_details" class="fancybox">
								SMS Estimatation
							</a>
						</li>
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="<?php echo base_url('assets/img/avatar04.png')?>" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li><!-- end message -->
                                        
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $this->session->userdata['username'];?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <?php $profile = $this->session->userdata['profile_pic'];?>
                                    <img src="<?php echo base_url('assets/users/'.$profile)?>" class="img-circle" alt="User Image" />
                                    <p>
                                    <?php echo $this->session->userdata['username'];?> - 
                                    <?php echo $this->session->userdata['department'];?>
                                       
                                        <small>Cybera Team Member</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!--<li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <!--<div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>-->
                                    <div class="pull-right">
                                        <a href="<?php echo base_url();?>user/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
<div id="estimation_details" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
	
    <div id="create_estimate">
    <?php $all_customer = get_all_customers(); ?>
    <center>
		<a href="javascript:void(0);" onclick="show_calculator();" class="btn btn-success btn-lg">Calculator</a>
    </center>
    <ul class="tabs" data-persist="true">
            <li><a href="#regular_customers">Regular Customers</a></li>
            <li><a href="#new_customers">New Customer</a></li>
    </ul>
    <div class="tabcontents">
		<div id="regular_customers">
			<table align="center" border="2" width="80%">
				<tr>
					<td align="right"> Select Customer :</td>
					<td> 
						<select class="form-control estimate-customer-select" name="customer" id="customer" onchange="show_sms_mobile();">
							<option value="0" selected="selected">Select Customer</option>
							<?php
							foreach($all_customer as $customer) {
								$c_name = $customer->companyname;
								if(empty($c_name)) {
									$c_name = $customer->name;
								}
								echo "<option value='".$customer->id."'>".$c_name."</option>";
							}
							?>
						</select>
						</td>
				</tr>
				<tr>
					<td align="right">Contact Number:</td>
					<td><input type="text" id="sms_mobile" name="sms_mobile"></td>
				</tr>
				<tr>
					<td align="right">Message:</td>
					<td><textarea id="sms_message" name="sms_message" cols="80" rows="6"></textarea>
						Characters : <span id="charCount">0</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="hidden" id="customer_email" name="customer_email">
						<input type="hidden" name="sms_customer_name" id="sms_customer_name">
						<input type="submit" name="send" class="btn btn-success btn-lg" value="Send SMS" onclick="create_estimation();">
					</td>
				</tr>
			</table>
		</div>
		<div id="new_customers">
			<table align="center" border="2" width="80%">
				<tr>
					<td align="right">Customer Name :</td>
					<td> 
						<input type="text" name="n_sms_customer_name" id="n_sms_customer_name" style="width:500px;">
					</td>
				</tr>
				<tr>
					<td align="right">Contact Number:</td>
					<td><input type="text" id="n_sms_mobile" name="n_sms_mobile" style="width:500px;"></td>
				</tr>
				<tr>
					<td align="right">Email Id:</td>
					<td>
						<input type="text" style="width:500px;" id="n_customer_email" name="n_customer_email">
					</td>
				</tr>
				<tr>
					<td align="right">Message:</td>
					<td>
						<textarea id="n_sms_message" name="n_sms_message" cols="80" rows="6"></textarea>
						Characters : <span id="n_charCount">0</span>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" name="send" class="btn btn-success btn-lg" value="Send SMS" onclick="create_estimation_new();">
					</td>
				</tr>
			</table>
		</div>
    </div>
    
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
      $('.fancybox').fancybox({
        'width':900,
        'height':600,
        'autoSize' : false,
    });
    


	$('.datepicker').datetimepicker({
		dayOfWeekStart : 1,
		lang:'en',
		disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
		step:10
	});  
	
	  var options_sms_customer = $('select.estimate-customer-select option');
     var arr = options_sms_customer.map(function(_, o) {
        return {
            t: $(o).text(),
            v: o.value
        };
    }).get();
    arr.sort(function(o1, o2) {
        return o1.t > o2.t ? 1 : o1.t < o2.t ? -1 : 0;
    });
    options_sms_customer.each(function(i, o) {
        o.value = arr[i].v;
        $(o).text(arr[i].t);
    });  
     
    /*$('.datepicker').datepicker({
      viewMode: 'years'
    }); */
  
    
});
function create_estimation(){
	var customer_id,sms_message,sms_mobile;
	customer_id = $("#customer").val();
	sms_message = $("#sms_message").val();
	sms_mobile = $("#sms_mobile").val();
	sms_customer_name = $("#sms_customer_name").val();
	customer_email = $("#customer_email").val();
    $.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/create_estimation/", 
         data:{'customer_id':customer_id,'customer_email':customer_email,"sms_message":sms_message,"sms_mobile":sms_mobile,"sms_customer_name":sms_customer_name},
         success: 
            function(data){
				alert("SMS Sent :"+data);
				$.fancybox.close();
            }
          });
}
function create_estimation_new(){
	var customer_id,sms_message,sms_mobile;
	sms_message = $("#n_sms_message").val();
	sms_email = $("#n_customer_email").val();
	sms_mobile = $("#n_sms_mobile").val();
	sms_customer_name = $("#n_sms_customer_name").val();
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/ajax/create_estimation/", 
         data:{"customer_email":sms_email,'customer_id':0,"sms_message":sms_message,"sms_mobile":sms_mobile,"sms_customer_name":sms_customer_name,'prospect':'1'},
         success: 
            function(data){
				alert("SMS Sent : "+data);
				$.fancybox.close();
            }
          });
}
</script>

<script>
function header_calculate_paper_cost(){
	var paper_gram,paper_size,paper_print,ori_paper_qty,paper_qty,amount=0,total=0,id,mby=1;
	paper_gram = jQuery("#hpaper_gram").val();
	paper_size = jQuery("#hpaper_size").val();
	paper_print = jQuery("#hpaper_print").val();
	id = jQuery("#hfancybox_id").val();
	paper_qty = jQuery("#hpaper_qty").val();
	ori_paper_qty = jQuery("h#paper_qty").val();
	if(paper_print == "FB") {
		paper_qty = paper_qty *2;
	}
	
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/customer/get_paper_rate/", 
         data:{"paper_gram":paper_gram,"paper_size":paper_size,
                "paper_print":paper_print,"paper_qty":paper_qty},
         dataType:"json",
         success: 
              function(data){
                if(data.success != false ) {

                  amount = amount + parseFloat(data.paper_amount);
					if(paper_print == "FB" ) {
						if(paper_size == "13X19" || paper_size == "13x19" ) {
							amount = amount * 2 - 3;
						}
					}
                  
                  total = (amount * paper_qty )* mby;
                  jQuery("#hresult_paper_cost").html("--- "+paper_qty +" * "+amount+" [per unit] * "+paper_print+" = "+total );
                  
            } else {
                  jQuery("#hresult_paper_cost").html("[ Data not Found - Insert Manual Price]");
            }
        }
          });
}

function show_sms_mobile() {
	var customer_id = jQuery("#customer").val();
	if(customer_id == 0 ) {
		jQuery("#sms_mobile").val('');
		return true;
	}
    $.ajax({
     type: "POST",
     dataType:"json",
     url: "<?php echo site_url();?>/ajax/ajax_get_customer/"+customer_id, 
     success: 
        function(data){
			jQuery("#customer_email").val(data['emailid']);
			jQuery("#sms_mobile").val(data['mobile']);
			if(jQuery("#sms_customer_name").val(data['name']).length > 0 ) {
					jQuery("#sms_customer_name").val(data['name']);
			} else {
					jQuery("#sms_customer_name").val(data['companyname']);
			}
		}
  });
}
</script>


<div id="hfancy_box_demo" style="width:800px;display: none;">
	<div style="width: 600px; margin: 0 auto; padding: 120px 0 40px;">
			<?php
				$data = get_papers_size();
				$paper_gsm = $data['papers'];
				$paper_size = $data['size'];
			?>
			<div class="row">
			<table width="80%" border="2">
				<tr>
					<td align="right">Select Paper : </td>
					<td><select  name="paper_gram" id="hpaper_gram">
						<?php foreach($paper_gsm as $gsm) {?>
						<option value="<?php echo strtolower($gsm['paper_gram']);?>">
						<?php echo $gsm['paper_gram'];?></option>
						<?php } ?>
					</select>
					</td>
				</tr>
				<tr>
					<td align="right">Select Paper Size: </td>
					<td><select name="paper_size" id="hpaper_size">
						<?php foreach($paper_size as $psize) {?>
						<option value="<?php echo strtolower($psize['paper_size']);?>">
						<?php echo $psize['paper_size'];?></option>
						<?php } ?>
						<option>10X10</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">Print Side: </td>
					<td><select name="paper_print" id="hpaper_print">
						<option value="SS">Single</option>
						<option value="FB">Double ( front & Back )</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align="right">Quantity : </td>
					<td><input type="text" name="paper_qty" value="1" id="hpaper_qty"></td>
				</tr>
				<tr>
					<td colspan="2">
					<span class="btn btn-primary btn-sm" onclick="header_calculate_paper_cost()">Estimate Cost</span>
					<span style="font-size:20px;" id="hresult_paper_cost"></span>
					</td>
				</tr>
			</table>
	</div>
    </div>
</div>



<!-- Scheduler Block -->
<div id="schedule" style="width:900px;display: none;margin-top:-75px;">
<div style="width: 900px; margin: 0 auto; padding: 120px 0 40px;">
	<table border="2" width="100%">
	<tr>
		<td align="right"> Assign To : </td>
		<td>
			<?php get_task_user_list();?>
		</td>
	</tr>
	<tr>
		<td align="right">
			Title :
		</td>
		<td>
			<input type="text" name="title"  id="sc_title"  class="form-control" required="required">
		</td>
	</tr>
	<tr>
		<td align="right">
			Description :
		</td>
		<td>
			<textarea name="description" id="sc_description"  class="form-control"></textarea>
		</td>
	</tr>
	
	<tr>
		<td align="right">
			Reminder Time :
		</td>
		<td>
			<input type="text" name="reminder_time"  id="sc_reminder_time"   class="form-control datepicker" required="required">
		</td>
	</tr>
	<tr>
		<td align="right">
			Mobile Reminder : 
		</td>
		<td>
			<label><input type="checkbox" name="sc_mobile_reminder" id="sc_mobile_reminder">Send SMS</label>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<button onclick="set_schedule();" id="btn_schedule" class="btn btn-primary">Schedule</button>
			<span id="loading-image" style="display:none;">
				<img src="<?php echo base_url();?>/assets/img/load.gif">
			</span>
		</td>
	</tr>
</table>
</div>
</div>

<div id="notification_div"  style="width:800px;display: none;">
	
</div>
<script>
function set_schedule() {
	$('#loading-image').show();
	$("#btn_schedule").hide();
	var name = jQuery("#sc_title").val();
	var description = jQuery("#sc_description").val();
	var reminder_time = jQuery("#sc_reminder_time").val();
	var receiver = $('#receiver').val();
	var is_sms = 0;
	
	if($('#sc_mobile_reminder').prop("checked") == true){
		is_sms= 1;
	}
	
	 $.ajax({
     type: "POST",
     dataType:"json",
     url: "<?php echo site_url();?>/ajax/set_schedule/", 
     data : { 'is_sms':is_sms,'title':name,'description':description,'reminder_time':reminder_time,'receiver':receiver},
     success: 
        function(data){
			alert("Successfully Scheduler Set");
		},
	 complete: function(){
        $('#loading-image').hide();
        jQuery("#sc_title").val("");
		jQuery("#sc_description").val("");
		jQuery("#sc_reminder_time").val("");
		$('#receiver').val("");
        $.fancybox.close();
        $("#btn_schedule").show();
      }
  });
}


var contentLength  = 0;
var n_contentLength  = 0;
jQuery(document).ready(function() {
	
	jQuery("#sms_message").on('keyup', function()
	{
		contentLength = jQuery("#sms_message").val().length;
		if(contentLength > 140)
		{
			jQuery("#charCount").html('<span class="red">' +contentLength+ '</span>');
		}
		else
		{
			jQuery("#charCount").html('<span class="green">' +contentLength+ '</span>');	
		}
	});
	
	jQuery("#n_sms_message").on('keyup', function()
	{
		n_contentLength = jQuery("#n_sms_message").val().length;
		if(contentLength > 140)
		{
			jQuery("#n_charCount").html('<span class="red">' +n_contentLength+ '</span>');
		}
		else
		{
			jQuery("#n_charCount").html('<span class="green">' +n_contentLength+ '</span>');	
		}
	});
});
</script>


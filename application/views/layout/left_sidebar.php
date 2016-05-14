<aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <?php
								$profile = $this->session->userdata['profile_pic'];
								if(empty($profile)) {
									$profile = 'avatar5.png';
								}
                            ?>
                            <img src="<?php echo base_url('assets/users/'.$profile)?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $this->session->userdata['username'];?></p>

                            <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
                        </div>
                    </div>
                    <!-- search form -->
                   
                    <form action="<?php echo base_url();?>user/old_search" method="post" class="sidebar-form">
                        <div class="input-group">
                        <?php
                        $q = $this->input->post('q');
                        ?>
                            <input type="text" name="old_q" value="<?php echo $q;?>" class="form-control" placeholder="Old Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <form action="<?php echo base_url();?>user/search_job" method="post" class="sidebar-form">
                        <div class="input-group">
                        <?php
                        $q = $this->input->post('job_number');
                        ?>
                            <input type="text" name="job_number" value="<?php echo $q;?>" class="form-control" placeholder="Search by Job Number"/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <form action="<?php echo base_url();?>user/search" method="post" class="sidebar-form">
                        <div class="input-group">
                        <?php
                        $q = $this->input->post('q');
                        ?>
                            <input type="text" name="q" value="<?php echo $q;?>" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo base_url();?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="<?php echo base_url();?>jobs/edit">
                                <i class="fa fa-dashboard"></i> <span>New Job</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>jobs">
                                <i class="fa fa-envelope"></i> <span>Jobs</span>
                                <small class="badge pull-right bg-yellow">
                                <span id="show_jobs"></span>
                                </small>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>account">
                                <i class="fa fa-envelope"></i> <span>Account</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>dealer">
                                <i class="fa fa-calendar"></i> <span>Dealers</span>
                                <small class="badge pull-right bg-red">
                                <span id="show_dealers"></span>
                                </small>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>customer">
                                <i class="fa fa-calendar"></i> <span>Customers</span>
                                <small class="badge pull-right bg-red">
                                <span id="show_customers"></span>
                                </small>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>dealer/vcustomers">
                                <i class="fa fa-calendar"></i> <span>Voucher Customers</span>
                                <small class="badge pull-right bg-red">
                                <span id="show_vouchers"></span>
                                </small>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>customer/prospects">
                                <i class="fa fa-calendar"></i> <span>Business Prospects</span>
                                <small class="badge pull-right bg-red">
                                <span id="show_prospects"></span>
                                </small>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>jobs/estimation_sms">
                                <i class="fa fa-calendar"></i> <span>Estimation SMS</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>paper">
                                <i class="fa fa-calendar"></i> <span>Manage Papers</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-envelope"></i> <span>Inbox</span>
                                <small class="badge pull-right bg-yellow">2</small>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-envelope"></i> <span>Tasks Alloted</span>
                                <small class="badge pull-right bg-yellow">5</small>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
<script>
jQuery("document").ready(function(){
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/user/get_leftbar_status/", 
          dataType: 'json',
         success: 
            function(data){
				jQuery("#show_jobs").html(data.jobs);
				jQuery("#show_dealers").html(data.dealers);
				jQuery("#show_customers").html(data.customers);
				jQuery("#show_prospects").html(data.prospects);
				jQuery("#show_vouchers").html(data.vouchers);
				
			}
          });
});
</script>

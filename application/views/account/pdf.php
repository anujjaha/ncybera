
<link href="<?php echo base_url('assets/css/datatables/dataTables.bootstrap.css');?>" rel="stylesheet" type="text/css" />


<script src="<?php echo base_url('assets/js/plugins/datatables/jquery.ajax.dataTables.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.js')?>" type="text/javascript"></script>



            
            <div class="row">
            <div class="col-md-12">
                <a href="<?php echo site_url();?>/profiles/add">Add New Profiles </a>
            </div>
            <div class="col-md-12">
            <table id="datatable"  class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th>Sr</th>
                    <th>Name</th>
                    <th>Compny Name</th>
                    <th>Total Debit</th>
                    <th>Total Credit</th>
                    <th>Balance</th>
                    <th>Mobile</th>
                    <th>Email ID</th>
                    <th>City</th>
                    <th>Action</th>
                </tr>
            <thead>
            </table>
            </div>
        </div>
    </div>
<script>
jQuery(document).ready(function() {
    jQuery("#datatable").DataTable( {
        "processing": true,
        "serverSide": true,
        "paging": true,
        "iDisplayLength": 10,
        "bPaginate": true,
        "bServerSide": true,
        "bSort": false,
        "ajax": "<?php echo site_url();?>/account/ajax_list"
    } );
} );
</script>
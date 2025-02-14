
<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
      
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-table/bootstrap-table.min.css">


<style type="text/css">
.admin_menu .keep-open ul.dropdown-menu, .admin_menu .export ul.dropdown-menu {
    position: absolute;
    box-shadow: 5px 5px rgb(102 102 102 / 10%)!important;
    right: 0; 
    min-width: 175px;
    z-index: 9999;
    border: 1px solid #ccc!important;
    left: auto!important;
}
</style>


                      
<div class="row">
    <div class="col-lg-12">
        <div class="portlet light bordered">
        	<div class="portlet-title tabbable-line">
                <div class="caption caption-md">
                    <i class="icon-globe font-brown "></i>
                    <span class="caption-subject font-brown bold uppercase"> <?=$title?> - <?=$institutes_details['INST_NAME'] ?>  (<?= $institutes_details['INST_SHORTNAME']?>)</span>
                </div>
            </div><?php $institute = $_SESSION['inst_id'] ?>
            <form class="" action="">
                <div class="form-body">
                    <div class="portlet-body">   
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- <span class="custorange"> <a href="<?php echo base_url();?>arigel_general_admin_replica/edituser_replica"><button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New
                                    </button></a></span> -->
                              
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url().'admin/extensions/'.$page_id; ?>">Back </a></span>
                            </div>                                                         
                        </div>                     
                        
                        <!-- <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>User Name</label>
                                    <div class="user_username_wrap">
                                        <select class="select2 form-control custom-select" name="user_username" id="user_username" data-placeholder="-- Select User Username --" multiple style="width: 100%;">
                                            <option value="">-- Select User Username --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>                            
                        </div> -->

                        <!-- <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success" onclick="filterTable();">Filter</button>
                                <button type="button" class="btn btn-dark" onclick="clearTable();">Clear</button>
                            </div>
                            
                        </div> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="portlet light bordered pt2 pb0">
            <div class="portlet-body">
                <div id="dataTableWrap">
                    <div class="table-responsive">
                        <table id="dataTableId"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-table/bootstrap-table.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-table/tableExport.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-table/extensions/export/bootstrap-table-export.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/js/select2.full.min.js"></script>
<!-- <script src="<?php //echo base_url(); ?>assets/ckeditor/ckeditor.js" type="text/javascript"></script> -->



<script type="text/javascript">



    /*function filterTable() {
        $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');
        initTable();
    }

    function clearTable() {
        //showLoader();
        $('.status_wrap').html('<select class="select2 form-control custom-select" name="status" id="status" data-placeholder="-- Select Status --" multiple style="width: 100%;"><option value="">-- Select Status --</option><option value="1">Active</option><option value="0">In-Active</option></select>');
        $('#status').select2();
        $('#status').val();

        $('.login_type_wrap').html('<select class="select2 form-control custom-select" name="login_type_id" id="login_type_id" data-placeholder="-- Select Login Type --" multiple style="width: 100%;"><option value="">-- Select Login Type --</option><option value="1">By CMS</option><option value="2">By Email</option></select>');
        $('#login_type_id').select2();
        $('#login_type_id').val();

        // $("#is_featured").prop("checked", false);
       $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');

        get_user_groups_options();
        get_user_institute_options();
        get_all_username_options();
        get_all_user_fullname_options();
        get_all_user_email_options();

        setTimeout(function(){
            initTable();
            //hideLoader();
        }, 500);
    }*/

    function initTable() {

        $('#dataTableId').bootstrapTable({
            //url: base_url+'<?php //echo event_management_constants::get_events_url; ?>',
            url: base_url+'admin/page_content_history_ajax_list',
            method: 'GET',                
            queryParams: function (params) {
                q = {
                	page_id         : <?php echo $page_id; ?>,
                	content_id      : <?php echo $contents_id; ?>,
                    limit           : params.limit,
                    offset          : params.offset,
                    search          : params.search,
                    sort            : (params.sort ? params.sort : ''),
                    order           : (params.order ? params.order : ''),
                    custom_search   : {
                                        // login_type              : $('#login_type_id').val(),
                                        // user_group              : $('#user_group').val(),
                                        // user_institute          : $('#user_institute').val(),
                                        // status                  : $('#status').val(),
                                        // user_username           : $('#user_username').val(),
                                        // user_fullname           : $('#user_fullname').val(),
                                        // user_email              : $('#user_email').val(),
                                      }
                }
                return q;
            },
            cache: false,
            // height: 580,
            striped: true,
            toolbar: true,
            search: true,
            showRefresh: true,
            showToggle: true,
            showColumns: true,
            // detailView: true,
            // exportOptions: { ignoreColumn: [0] },
            detailView: false,
            // detailFormatter: detailFormatter,
            exportOptions: { ignoreColumn: ['action'], fileName: 'Page_content_history' },
            showExport: true,
            exportDataType: 'all',
            minimumCountColumns: 2,
            showPaginationSwitch: true,
            pagination: true,
            sidePagination: 'server',
            idField: 'id',
            pageSize: 10,
            pageList: [10, 25, 50, 100, 200],
            showFooter: false,
            // responseHandler: responseHandler,
            clickToSelect: false,
            columns: [
                [
                    {
                        field: 'sr_no',
                        title: 'Sr No.',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'language_name',
                        title: 'Language',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'name',
                        title: 'Name',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    /* {
                        field: 'description',
                        title: 'Description',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'meta_title',
                        title: 'Meta Title',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'meta_description',
                        title: 'Meta Description',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'meta_keywords',
                        title: 'Meta Keywords',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    }, */
					{
                        field: 'userfullname',
                        title: 'Editor Name',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'created_on',
                        title: 'Updated On',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'type',
                        title: 'Type',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'action',
                        title: 'Action',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    }
                ]
            ]
        });
    }

    
    initTable();

</script>
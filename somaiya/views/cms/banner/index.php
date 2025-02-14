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
.filtersBar{
     margin-top:30px; 
}
.filtersBar  label{
    font-weight: 600;
}
.actionBUtttons{
    margin-top:24px; 
}
.background-green {
        color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
}
</style>


                      
<div class="row">
   <!--  <div class="col-lg-12">
        <div class="portlet light bordered">
            <form id="banner_filters" class="" action="">
                <div class="form-body">
                    <div class="portlet-body">   
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custorange"> <a class="sizebtn btn sbold orange" href="<?php echo base_url(); ?>cms/banner/edit/">Add New</a></span>
                              
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                            </div>                                                         
                        </div>                     
                        <div class="row">
                            <?php
                            if($this->session->userdata('user_id') == 1 && $this->session->userdata['sess_institute_id'] == 50)
                            {
                            ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Institutes</label>
                                        <div class="banner_institute_wrap">
                                            <select class="select2 form-control custom-select" name="banner_institute" id="banner_institute" data-placeholder="-- Select Institute --" multiple style="width: 100%;">
                                                <option value="">-- Select Institute --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Valid Upto</label>
                                    <div class="valid_upto_wrap">
                                        <input type="text" id="valid_upto" name="valid_upto" placeholder="Please Select Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="status_wrap">
                                        <select class="select2 form-control custom-select" name="status" id="status" data-placeholder="-- Select Status --" multiple style="width: 100%;">
                                            <option value="">-- Select Status --</option>
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success" onclick="filterTable();">Filter</button>
                                <button type="button" class="btn btn-dark" onclick="clearTable();">Clear</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div> -->
    <div class="col-lg-12">
        <div class="portlet light bordered pt2 pb0">
            <form id="banner_filters" class="" action="">
                <div class="form-body">
                    <div class="portlet-body">   
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custorange"> <a class="sizebtn btn sbold orange" href="<?php echo base_url(); ?>cms/banner/edit/">Add New</a></span>
                              
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                            </div>                                                         
                        </div>                     
                        <div class="row filtersBar">
                            <?php
                            if($this->session->userdata('user_id') == 1 && $this->session->userdata['sess_institute_id'] == 50)
                            {
                            ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Institutes</label>
                                        <div class="banner_institute_wrap">
                                            <select class="select2 form-control custom-select" name="banner_institute" id="banner_institute" data-placeholder="-- Select Institute --" multiple style="width: 100%;">
                                                <option value="">-- Select Institute --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Valid Upto</label>
                                    <div class="valid_upto_wrap">
                                        <input type="text" id="valid_upto" class="form-control" name="valid_upto" placeholder="Please Select Date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <div class="status_wrap">
                                        <select class="select2 form-control custom-select" name="status" id="status" data-placeholder="-- Select Status --" multiple style="width: 100%;">
                                            <option value="">-- Select Status --</option>
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group actionBUtttons">
                                    <button type="button" class="btn btn-success" onclick="filterTable();">Filter</button>
                                    <button type="button" class="btn btn-dark" onclick="clearTable();">Clear</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
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
<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>



<script type="text/javascript">

    $('#valid_upto').datetimepicker({
        format:'Y-m-d',
        minDate:new Date()
    });

    $('#status').select2();

    function filterTable() {
        $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');
        initTable();
    }

    function clearTable() {
        //showLoader();
        $('.status_wrap').html('<select class="select2 form-control custom-select" name="status" id="status" data-placeholder="-- Select Status --" multiple style="width: 100%;"><option value="">-- Select Status --</option><option value="1">Active</option><option value="0">In-Active</option></select>');
        $('#status').select2();
        $('#status').val();
        
        $('#banner_filters input[type="text"]').val('');

        
        // $("#is_featured").prop("checked", false);
       $('#dataTableWrap').html('<div class="table-responsive"><table id="dataTableId"></table></div>');

       get_banner_institute_options();

        setTimeout(function(){
            initTable();
            //hideLoader();
        }, 500);
    }

    function initTable() {

        $('#dataTableId').bootstrapTable({
            //url: base_url+'<?php //echo event_management_constants::get_events_url; ?>',
            url: base_url+'cms/banner/banner_ajax_list',
            method: 'GET',                
            queryParams: function (params) {
                q = {
                    limit           : params.limit,
                    offset          : params.offset,
                    search          : params.search,
                    sort            : (params.sort ? params.sort : ''),
                    order           : (params.order ? params.order : ''),
                    custom_search   : {
                                        valid_upto              : $('#valid_upto').val(),
                                        status                  : $('#status').val(),
                                        banner_institute          : $('#banner_institute').val(),
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
            exportOptions: { ignoreColumn: ['action'], fileName: 'Banners' },
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
                        field: 'banner_text',
                        title: 'Banner Title',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'banner_image',
                        title: 'Banner Image',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'valid_upto',
                        title: 'Valid Upto',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'row_order',
                        title: 'Order By',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'status',
                        title: 'Publish',
                        align: 'center',
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

    get_banner_institute_options();
    initTable();

    function change_status(id, change_to) {

        if(id != '')
        {
            var message = '';
            if(change_to == 1)
            {
                var message = 'Do you really want to activate this banner?';
                var btn_text = 'Yes, Activate it!';
            }
            else if(change_to == 0)
            {
                var message = 'Do you really want to in-activate this banner?';
                var btn_text = 'Yes, In-Activate it!';
            }
            else if(change_to == '-1')
            {
                var message = 'Do you really want to delete this banner?';
                var btn_text = 'Yes, Delete it!';
            }

            swal({
                title: "Are you sure?",
                text: message,
                type: "warning",
                showCancelButton: true,
                confirmButtonText: btn_text,
            }).then(function (result) {
                //if(result.value)
                if(result)
                {
                    window.location.href = base_url+'cms/banner/banner_change_status/'+id+'/'+change_to;
                }
            }, function(dismiss) {});
        }
    }

    function get_banner_institute_options() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url : base_url+'cms/banner/get_banner_institute_options/',
            data: {},
            success: function(response) {
                $("#banner_institute").removeAttr('disabled');
                $('.banner_institute_wrap').html('<select class="select2 form-control custom-select" name="banner_institute" id="banner_institute" data-placeholder="-- Select Institute --" multiple style="width: 100%;">'+response+'</select>');
                $('#banner_institute').select2();
            }
        });
    }
</script>
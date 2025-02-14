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
            <form class="" action="">
                <div class="form-body">
                    <div class="portlet-body">   
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custorange"> <a href="<?php echo base_url();?>arigel_general_admin_replica/edituser_replica" class="sizebtn btn orange">Add New</a></span>
                              
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('arigel_general_admin_replica/'); ?>">Back </a></span>
                            </div>                                                         
                        </div>                     
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Login Type</label>
                                    <div class="login_type_wrap">
                                        <select class="select2 form-control custom-select" name="login_type_id" id="login_type_id" multiple data-placeholder="-- Select Login Type --" style="width: 100%;">
                                            <option value="">-- Select Login Type --</option>
                                            <option value="1">By CMS</option>
                                            <option value="2">By Email</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>User Groups</label>
                                    <div class="user_group_wrap">
                                        <select class="select2 form-control custom-select" name="user_group" id="user_group" data-placeholder="-- Select User Groups --" multiple style="width: 100%;">
                                            <option value="">-- Select User Groups --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Institutes</label>
                                    <div class="user_institute_wrap">
                                        <select class="select2 form-control custom-select" name="user_institute" id="user_institute" data-placeholder="-- Select Institute --" multiple style="width: 100%;">
                                            <option value="">-- Select Institute --</option>
                                        </select>
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
                        </div>
                        <div class="row">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>User Fullname</label>
                                    <div class="user_fullname_wrap">
                                        <select class="select2 form-control custom-select" name="user_fullname" id="user_fullname" data-placeholder="-- Select User Fullname --" multiple style="width: 100%;">
                                            <option value="">-- Select User Fullname --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>User Email</label>
                                    <div class="user_email_wrap">
                                        <select class="select2 form-control custom-select" name="user_email" id="user_email" data-placeholder="-- Select User Email --" multiple style="width: 100%;">
                                            <option value="">-- Select User Email --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success" onclick="filterTable();">Filter</button>
                                <button type="button" class="btn btn-dark" onclick="clearTable();">Clear</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success" onclick="send_email();">Send Email</button>
                            </div>
                        </div>
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

<div class="modal" id="UserSendEmailModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Email Form</h4>
          <button type="button" class="close closeusersendemailform" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" id="ForgotformModalBody">
            
            <form id="user_send_email_form" name="user_send_email_form" class="user_send_email_form" action="javascript:;" method="post">
                <div class="form-group">
                    <input type="hidden" name="send_email_ids" id="send_email_ids" value="">
                </div>
                <div class="form-group ">
                    <label for="send_email_subject" class="control-label col-lg-2">Email Subject<span class="asterisk">*</span></label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="send_email_subject" name="send_email_subject" maxlength="250" required>
                        
                        <div class="send_email_subject_error error_msg error"><?php echo form_error('send_email_subject', '<label class="error">', '</label>'); ?></div>
                    </div>
                </div>
                <div class="form-group ">
                    <?php //mk_hWYSItexteditor("send_email_body", 'Email Body', '', ''); 
                    mk_hWYSItexteditor("send_email_body",_l('Email Body',$this),'','');?>

                    <div class="send_email_body_error error_msg error"><?php echo form_error('send_email_body', '<label class="error">', '</label>'); ?></div>
                </div>
                <!-- <div class="form-group ">
                    <label for="send_email_body" class="control-label col-lg-2">Email Body</label>
                    <div class="col-lg-10">
                        <textarea id="send_email_body" name="send_email_body" type="text" class="form-control input-md" rows="8"></textarea>
                    </div>
                </div> -->

                

                <div class="form-actions">
                    <!-- <button type="button" id="back-btn" class="btn green btn-outline">Back</button> -->
                    <button type="submit" id="user_send_email_form_submit" class="btn btn-success uppercase pull-right">Submit</button>
                </div>
                
            </form>
            <div class="user_send_email_form_success_msg">
            </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-danger closethis" data-dismiss="modal">Close</button> -->
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

    $('#status').select2();

    $(document).ready(function(){

        $(".closeusersendemailform").click(function(){
            $('#user_send_email_form').trigger("reset");
            //reset ckeditor content
            CKEDITOR.instances['send_email_body'].setData('');
            $("#UserSendEmailModal").hide();
        });

        $('#user_send_email_form_submit').click(function(event){ 
            event.preventDefault(); //your ajax gets here: 
            
            //var formData = $('#user_send_email_form').serializeArray();
            var send_email_ids = $("#send_email_ids").val();
            var email_subject = $("#send_email_subject").val();
            var email_body = CKEDITOR.instances['send_email_body'].getData();
            
            var formData = [{name: "send_email_ids", value: send_email_ids},{name: "send_email_subject", value: email_subject},{name: "send_email_body", value: email_body}];

            jQuery.ajax({
                type:"post",
                dataType:"json",
                url: '<?php echo base_url(); ?>arigel_general_admin_replica/user_send_email_form_submit/',
                //data: {action: 'submit_data', info: 'test'},
                data: formData,
                success: function(response, textStatus, jqXHR)
                {
                    var fetchResponse = JSON.parse(JSON.stringify(response));

                    if(fetchResponse.status == "failure")
                    {
                        $.each(fetchResponse.error, function (i, v)
                        {
                            $('.'+i+'_error').html(v);
                        });
                        $(".user_send_email_form_success_msg").html('');
                    }
                    else
                    {
                        $(".error").html('');
                        $('#user_send_email_form').trigger("reset");
                        //reset ckeditor content
                        CKEDITOR.instances['send_email_body'].setData('');
                        $(".user_send_email_form_success_msg").html(fetchResponse.message);
                        $("#UserSendEmailModal").hide();

                    }
                }
            });
        });
    });

    function send_email()
    {

        var selected_login_type=[];
        $. each($('select#login_type_id option:selected'), function(){          
          selected_login_type.push($(this).val());       
        });
        selected_login_type=selected_login_type.toString();

        var selected_user_group=[];
        $. each($('select#user_group option:selected'), function(){          
          selected_user_group.push($(this).val());       
        });
        selected_user_group=selected_user_group.toString();

        var selected_institute=[];
        $. each($('select#user_institute option:selected'), function(){          
          selected_institute. push($(this).val());       
        });
        selected_institute=selected_institute.toString();

        var selected_status=[];
        $. each($('select#status option:selected'), function(){          
          selected_status. push($(this).val());       
        });
        selected_status=selected_status.toString();

        var selected_username=[];
        $. each($('select#user_username option:selected'), function(){          
          selected_username. push($(this).val());       
        });
        selected_username=selected_username.toString();

        var selected_fullname=[];
        $. each($('select#user_fullname option:selected'), function(){          
          selected_fullname. push($(this).val());       
        });
        selected_fullname=selected_fullname.toString();

        var selected_email=[];
        $. each($('select#user_email option:selected'), function(){          
          selected_email. push($(this).val());       
        });
        selected_email=selected_email.toString();
        
        $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>arigel_general_admin_replica/get_filtered_user_email_id/',
        data:'selected_login_type='+selected_login_type+'&selected_user_group='+selected_user_group+'&selected_institute='+selected_institute+'&selected_status='+selected_status+'&selected_username='+selected_username+'&selected_fullname='+selected_fullname+'&selected_email='+selected_email,
        
        beforeSend: function () {
            $('.loading').show();
            $('.refined').html('');
        },
        success: function (html) {
            $("#send_email_ids").val(html);
            $("#UserSendEmailModal").show();
            $(".user_send_email_form_success_msg").html('');
        }
    });


    }
    function get_user_groups_options() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url : base_url+'arigel_general_admin_replica/get_user_groups/',
            data: {},
            success: function(response) {
                $("#user_group").removeAttr('disabled');
                $('.user_group_wrap').html('<select class="select2 form-control custom-select" name="user_group" id="user_group" data-placeholder="-- Select User Groups --" multiple style="width: 100%;">'+response+'</select>');
                $('#user_group').select2();
            }
        });
    }

    function get_user_institute_options() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url : base_url+'arigel_general_admin_replica/get_user_institute_options/',
            data: {},
            success: function(response) {
                $("#user_institute").removeAttr('disabled');
                $('.user_institute_wrap').html('<select class="select2 form-control custom-select" name="user_institute" id="user_institute" data-placeholder="-- Select Institute --" multiple style="width: 100%;">'+response+'</select>');
                $('#user_institute').select2();
            }
        });
    }

    function get_all_username_options() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url : base_url+'arigel_general_admin_replica/get_all_username_options/',
            data: {},
            success: function(response) {
                $("#user_username").removeAttr('disabled');
                $('.user_username_wrap').html('<select class="select2 form-control custom-select" name="user_username" id="user_username" data-placeholder="-- Select Username --" multiple style="width: 100%;">'+response+'</select>');
                $('#user_username').select2();
            }
        });
    }

    function get_all_user_fullname_options() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url : base_url+'arigel_general_admin_replica/get_all_user_fullname_options/',
            data: {},
            success: function(response) {
                $("#user_fullname").removeAttr('disabled');
                $('.user_fullname_wrap').html('<select class="select2 form-control custom-select" name="user_fullname" id="user_fullname" data-placeholder="-- Select User Fullname --" multiple style="width: 100%;">'+response+'</select>');
                $('#user_fullname').select2();
            }
        });
    }

    function get_all_user_email_options() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url : base_url+'arigel_general_admin_replica/get_all_user_email_options/',
            data: {},
            success: function(response) {
                $("#user_email").removeAttr('disabled');
                $('.user_email_wrap').html('<select class="select2 form-control custom-select" name="user_email" id="user_email" data-placeholder="-- Select User Email --" multiple style="width: 100%;">'+response+'</select>');
                $('#user_email').select2();
            }
        });
    }

    function filterTable() {
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
    }

    function initTable() {

        $('#dataTableId').bootstrapTable({
            //url: base_url+'<?php //echo event_management_constants::get_events_url; ?>',
            url: base_url+'arigel_general_admin_replica/user_ajax_list',
            method: 'GET',                
            queryParams: function (params) {
                q = {
                    limit           : params.limit,
                    offset          : params.offset,
                    search          : params.search,
                    sort            : (params.sort ? params.sort : ''),
                    order           : (params.order ? params.order : ''),
                    custom_search   : {
                                        login_type              : $('#login_type_id').val(),
                                        user_group              : $('#user_group').val(),
                                        user_institute          : $('#user_institute').val(),
                                        status                  : $('#status').val(),
                                        user_username                  : $('#user_username').val(),
                                        user_fullname                  : $('#user_fullname').val(),
                                        user_email                  : $('#user_email').val(),
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
            exportOptions: { ignoreColumn: ['action'], fileName: 'Users' },
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
                        field: 'fullname',
                        title: 'Name',
                        align: 'left',
                        valign: 'middle',
                        sortable: true,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'institute_name',
                        title: 'Institute',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'email',
                        title: 'Email',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'username',
                        title: 'User Name',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'group_name',
                        title: 'Group Name',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'permission',
                        title: 'Group Permission',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'login_type',
                        title: 'Login Type',
                        align: 'left',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'status',
                        title: 'Status',
                        align: 'center',
                        valign: 'middle',
                        sortable: false,
                        editable: false,
                        footerFormatter: false,
                    },
                    {
                        field: 'send_credential_to_user',
                        title: 'Send Credential to user',
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

    get_user_groups_options();
    get_user_institute_options();
    get_all_username_options();
    get_all_user_fullname_options();
    get_all_user_email_options();

    initTable();

    function change_status(id, change_to) {

        if(id != '')
        {
            var message = '';
            if(change_to == 1)
            {
                var message = 'Do you really want to activate this user?';
                var btn_text = 'Yes, Activate it!';
            }
            else if(change_to == 0)
            {
                var message = 'Do you really want to in-activate this user?';
                var btn_text = 'Yes, In-Activate it!';
            }
            else if(change_to == '-1')
            {
                var message = 'Do you really want to delete this user?';
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
                    window.location.href = base_url+'arigel_general_admin_replica/user_change_status/'+id+'/'+change_to;
                }
            }, function(dismiss) {});
        }
    }

    function send_credential_to_user(user_id) {

        if(user_id != '')
        {
            swal({
                title: "Are you sure?",
                text: "Do you really want to send credential to this user?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Send it!",
            }).then(function (result) {
                //if(result.value)
                if(result)
                {
                    window.location.href = base_url+'arigel_general_admin_replica/send_credential_to_user/'+user_id;
                }
            }, function(dismiss) {});
        }
    }
</script>
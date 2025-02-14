<?php mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
    <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['user_id'])) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit User</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add New User</span>
                    <?php } ?>
                </div> 
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('arigel_general_admin_replica/user_replica/'); ?>">Back </a></span>
            </div>
            <?php error_reporting(0); $institute = $_SESSION['inst_id'] ?>
            <?php //echo  base_url(); exit();?>
            <div class="portlet-body form">
                <div class="form-body">
                    <!-- <form id="user_manipulate" class="cmxform form-horizontal tasi-form" method="post" action="<?php //echo $base_url.'edituser'.(isset($data['user_id'])?'/'.$data['user_id']:"") ?>"> -->
                        <form id="user_manipulate" class="cmxform form-horizontal tasi-form" method="post" action="<?php echo base_url().'arigel_general_admin_replica/edituser_replica'.(isset($data['user_id'])?'/'.$data['user_id']:"") ?>">
                        <input type="hidden" id="user_id" name="user_id" value="<?php echo isset($data['user_id']) ? $data['user_id'] : ''; ?>">
                        <div class="form-group">
                            <label for="login_type" class="control-label col-lg-2">Login Type</label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="login_type" class="form-control select2" name="login_type" data-placeholder="Select Login Type" required data-error=".logintypeerror">
                                    <option value="">Select Login Type</option>
                                    <option value="1" <?php if(isset($data['login_type']) && $data['login_type'] == '1'){ echo 'selected="selected"'; } ?>>CMS</option>
                                    <option value="2" <?php if(isset($data['login_type']) && $data['login_type'] == '2'){ echo 'selected="selected"'; } ?>>Google</option>
                                </select>
                                <div class="logintypeerror error_msg"><?php echo form_error('login_type', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <?php if ($data['user_id'] == 1) {} else { ?>
                        <div class="boxform">
                            <table style="width: 100%;">
                                <?php if(isset($uservalue) && count($uservalue)!=0){ ?>
                                    <input type="hidden" name="user_array_check" value="2">
                                    <?php
                                        $in = 0;
                                        foreach ($uservalue as $key5 => $data5) {
                                    ?>
                                            <tr class="group_wrap">
                                                <td class="group_td">
                                                    <div class="p10">
                                                        <select id="singlegrp<?php echo $i++; ?>" class="form-control select2" name="group_array[]" data-placeholder="Select Group">
                                                            <option value="">Select Group</option>
                                                            <?php if(isset($groups) && count($groups)!=0){ ?>
                                                            <?php foreach ($groups as $key3 => $data3) { ?>
                                                                <option value="<?=$data3['group_id']?>" <?php if($data5['group_id'] == $data3['group_id']) echo"selected"; ?>><?=$data3['group_name']?></option>
                                                            <?php $i++; } } ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="institute_td">
                                                    <div class="p10">
                                                        <select id="singleinst<?php echo $i++; ?>" class="form-control select2" name="institute_array[]" data-placeholder="Select Institute">
                                                            <option value="">Select Institute</option>
                                                            <?php
                                                                if(isset($institutes_list) && count($institutes_list)!=0){
                                                                foreach ($institutes_list as $key2 => $data2) {
                                                            ?>
                                                                <option value="<?=$data2['INST_ID']?>" <?php if($data5['institute_id'] == $data2['INST_ID']) echo ' selected';?>><?=$data2['INST_NAME']?></option>
                                                            <?php $i++; }} ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="add_remove_td">
                                                    <div class="p10">
                                                        <?php if($in == 0){ ?>
                                                            <a class="add" href="javascript:void(0);" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                        <?php }else{ ?>
                                                            <a class="removeMore" data-id="<?php echo $data5['ugiid'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <input type='hidden' name='ugiid[]' value='<?php echo $data5['ugiid'] ?>' />
                                                <input type='hidden' name='relation_id' value='<?php echo $data['user_id'] ?>' />
                                            </tr>
                                    <?php ++$in;}} else { ?>
                                        <input type="hidden" name="user_array_check" value="1">
                                        <tr class="group_wrap">
                                            <td class="group_td">
                                                <div class="p10">
                                                    <select id="singlegrp0" class="form-control select2" name="group_array[]" data-placeholder="Select Group" required>
                                                        <option value="">Select Group</option>
                                                        <?php if(isset($groups) && count($groups)!=0){ ?>
                                                        <?php foreach ($groups as $key3 => $data3) { ?>
                                                            <option value="<?=$data3['group_id']?>"><?=$data3['group_name']?></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="institute_td">
                                                <div class="p10">
                                                    <select id="singleinst0" class="form-control select2" name="institute_array[]" data-placeholder="Select Institute">
                                                        <option value="">Select Institute</option>
                                                        <?php
                                                            if(isset($institutes_list) && count($institutes_list)!=0){
                                                            foreach ($institutes_list as $key2 => $data2) {
                                                        ?>
                                                            <option value="<?=$data2['INST_ID']?>"><?=$data2['INST_NAME']?></option>
                                                        <?php $i++; }} ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="add_remove_td">
                                                <div class="p10">
                                                    <a class="add" href="javascript:void(0);" title="Add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                            </table>
                        </div>
                        <?php } ?>
                    
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="000"></div>
                            </div>
                        </div>

                        <div class="fields_wrap">
                            <div class="form-group ">
                                <label for="username" class="control-label col-lg-2">Username</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="username" name="username" value="<?php echo isset($data['username'])?$data['username']:''; ?>" required="" data-error=".usernameerror" type="text">
                                    <div class="usernameerror error_msg"><?php echo form_error('username', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="email" class="control-label col-lg-2">Email</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="email" name="email" value="<?php echo isset($data['email'])?$data['email']:''; ?>" required="" data-error=".emailerror" type="email">
                                <div class="emailerror error_msg"><?php echo form_error('email', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="fullname" class="control-label col-lg-2">Name</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="fullname" name="fullname" value="<?php echo isset($data['fullname'])?$data['fullname']:''; ?>" type="text">
                            </div>
                        </div>

                        <!-- <div class="fields_wrap">
                            <div class="form-group ">
                                <label for="password" class="control-label col-lg-2">Password</label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="password" name="password" value="" type="password">
                                </div>
                            </div>
                        </div> -->
                        
                        <div class="form-group">
                            <label for="active" class="control-label col-lg-2">Active&nbsp;<span><a title="Click checkbox to active this user else it will be in-active." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($data['status']) && $data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($data['status']) ? $data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit" id="submit_user">
                                <a href="<?php echo base_url('arigel_general_admin_replica/user_replica'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <?php
                    //if(isset($data['user_id']) && !empty($data['user_id']))
                    //{
                        //$this->load->view('arigel_general_admin/get_user_authtoken_using_patch');
                    //}
                    
                    ?>
                </div>
            </div>
        </div>
    <!-- END SAMPLE FORM PORTLET-->                                
    </div>
</div>
<?php mk_popup_uploadfile(_l('Upload Avatar',$this),"avatar",$base_url."upload_image/20/"); ?>

<script type="text/javascript">
    $(document).ready(function() {
        /* status */

        if ($('#status_checkbox').is(':checked')) {
            $('#status').val(1);
        }else{
            $('#status').val(0);
        }

        $('#status_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#status').val(1);
            }else{
                $('#status').val(0);
            }
        });

        var login_type = '<?php echo isset($data["login_type"]) ? $data["login_type"] : ""; ?>';
        var user_id = $('#user_id').val();
        handle_fields(login_type);
    });

    $(document).on('change', '#login_type', function (e) {
        var login_type = $("#login_type option:selected").val();
        handle_fields(login_type);
    });

    function handle_fields(login_type) {
        if(login_type == '1')
        {
            $('.fields_wrap').removeClass('hidden');
            $('#email').removeAttr('required');
            $('#username').attr('required', 'required');
        }
        else if(login_type == '2')
        {
            $('.fields_wrap').addClass('hidden');
            $('#email').attr('required', 'required');
            $('#username').removeAttr('required');
        }
    }

    var logintyperequired   = 'Please select login type';
    var usernamerequired    = 'Please enter username';
    var usernameexist       = 'Username already exist';
    var emailrequired       = 'Please enter email';
    var emailvalid          = 'Please enter valid email';
    var emailexist          = 'Email already exist';

    var email_regex         = /^[^@\s]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)+$/i;

    $.validator.addMethod("email_regex", function(value, element) {
        if(value == '')
        {
            return true;
        }
        else
        {
            return email_regex.test(value);
        }
    }, '');

    $.validator.addMethod("check_unique_username", function(value) {
        var username           = $('#username').val();
        var user_id             = '<?php echo isset($data["user_id"]) ? $data["user_id"] : ""; ?>';
        var check_result        = true;

        $.ajax({
            type: "POST",
            url: base_url+"arigel_general_admin/ajax_check_username",
            async: false,
            data: {username : username, user_id : user_id},
            success: function(response){
                check_result = response;
            }
        });
        return check_result;
    }, '');

    $.validator.addMethod("check_unique_email", function(value) {
        var email               = $('#email').val();
        var user_id             = '<?php echo isset($data["user_id"]) ? $data["user_id"] : ""; ?>';
        var check_result        = true;

        $.ajax({
            type: "POST",
            url: base_url+"arigel_general_admin/ajax_check_email",
            async: false,
            data: {email : email, user_id : user_id},
            success: function(response){
                check_result = response;
            }
        });
        return check_result;
    }, '');

    $("#user_manipulate").validate({
        rules: {
            login_type: {
                required: true
            },
            username: {
                // required: true,
                // check_unique_username: '#username',
            },
            email: {
                // required: true,
                email_regex: '#email',
                // check_unique_email: '#email',
            },
        },
        messages: {
            login_type: {
                required: logintyperequired
            },
            username:{
                required: usernamerequired,
                // check_unique_username: usernameexist
            },
            email:{
                required: emailrequired,
                email_regex: emailvalid,
                // check_unique_email: emailexist
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form){
            $("#submit_user").val("Please Wait...");
            $("#submit_user").attr('disabled', 'disabled');

            $('.usernameerror').html('');
            $('.emailerror').html('');

            function check_unique_username() {
                var username           = $('#username').val();
                var user_id             = '<?php echo isset($data["user_id"]) ? $data["user_id"] : ""; ?>';
                var check_username_result        = true;

                if($('#login_type').val() == 1)
                {
                    $.ajax({
                        type: "POST",
                        url: base_url+"arigel_general_admin/ajax_check_username",
                        async: false,
                        data: {username : username, user_id : user_id},
                        success: function(response){
                            check_username_result = response;
                        }
                    });
                }
                return check_username_result;
            }

            function check_unique_email() {
                var email               = $('#email').val();
                var user_id             = '<?php echo isset($data["user_id"]) ? $data["user_id"] : ""; ?>';
                var check_email_result  = true;

                $.ajax({
                    type: "POST",
                    url: base_url+"arigel_general_admin/ajax_check_email",
                    async: false,
                    data: {email : email, user_id : user_id},
                    success: function(response){
                        check_email_result = response;
                    }
                });
                return check_email_result;
            }

            var username_res = check_unique_username();
            var email_res = check_unique_email();
            var submit_form = true;

            if(username_res == false)
            {
                $('.usernameerror').html(usernameexist);
                submit_form = false;
            }
            if(email_res == false)
            {
                $('.emailerror').html(emailexist);
                submit_form = false;
            }

            if(submit_form == true)
            {
                form.submit();
            }
            else
            {
                $("#submit_user").val("SUBMIT");
                $("#submit_user").removeAttr('disabled');
                return false;
            }
        }
    });





function select_institute(id) {
    $.ajax({
      url: '<?php echo site_url("admin/appendinstitute");?>',
      success: function(data) {
        $('#singleinst'+id).html(data);
        $('#singleinst'+id).select2();
      }
    });
}

function select_group(id) {
    $.ajax({
      url: '<?php echo site_url("admin/appendgroups");?>',
      success: function(data) {
        $('#singlegrp'+id).html(data);
        $('#singlegrp'+id).select2();
      }
    });
}


// i=$('.group_wrap').length;
i=1;
$(document).on('click', 'a.add', function (e) {
    e.preventDefault();
    $(".group_wrap:last").after('<tr class="group_wrap"><td class="group_td"><div class="p10"><select id="singlegrp'+i+'" class="form-control select2" name="group_array[]" data-placeholder="Group Name"><option value="">Select Group</option><option value=""></option></select></div></td><td class="institute_td"><div class="p10"><select id="singleinst'+i+'" class="form-control select2" name="institute_array[]" data-placeholder="Select Institute"><option value="">Select Institute</option><option value=""></option></select></div></td><td class="add_remove_td"><div class="p10"><a class="removeMore'+i+'" data-id="'+i+'"><i title="<?=_l("Delete",$this)?>" class="fa fa-trash-o"></i></a></div></td></tr>');
    // removeMore();
    $(".removeMore"+i).click(function(){
        var ugiid = $(this).attr("data-id");
        var answer = confirm ("Are you sure you want to delete?");
        if(answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/deleteusergroup');?>",
                data: "ugiid="+ugiid,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+ugiid).remove(".imagelocation"+ugiid);
                  };
                }
            });
        }
        $(this).parent().parent().parent().fadeOut("slow", function() {
            // $(this).parent().parent().parent().remove();
            $(this).remove();
        });
    });
    select_institute(i);
    select_group(i);
    i++;
});

$(".removeMore").click(function(){
    var ugiid = $(this).attr("data-id");
    var answer = confirm ("Are you sure you want to delete?");
    if(answer)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/deleteusergroup');?>",
            data: "ugiid="+ugiid,
            success: function (response) {
              if (response == 1) {
                $(".imagelocation"+ugiid).remove(".imagelocation"+ugiid);
              };
            }
        });
    }
    $(this).parent().parent().parent().fadeOut("slow", function() {
        // $(this).parent().parent().parent().remove();
        $(this).remove();
    });
});
</script>

<style>
div.boxform{
    border: 1px solid lightgrey;
    padding: 25px;
    margin: 25px;
}
</style>
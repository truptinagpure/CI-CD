<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Semester Long Internship</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Semester Long Internship</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/semester_long_internship/'); ?>">Back</a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <div class="form-group ">
                            <label for="branch" class="control-label col-lg-2">Branch <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <select id="branch" class="form-control select2" name="branch" data-error=".brancherror" data-placeholder="Select Branch" aria-required="true" tabindex="-1" aria-hidden="true" required>
                                    <option value="">Select Branch</option>
                                    <option value="COMP" <?php if(isset($post_data['branch']) && $post_data['branch'] == 'COMP') echo"selected"; ?>>COMP</option>
                                    <option value="ETRX" <?php if(isset($post_data['branch']) && $post_data['branch'] == 'ETRX') echo"selected"; ?>>ETRX</option>
                                    <option value="EXTC" <?php if(isset($post_data['branch']) && $post_data['branch'] == 'EXTC') echo"selected"; ?>>EXTC</option>
                                    <option value="IT" <?php if(isset($post_data['branch']) && $post_data['branch'] == 'IT') echo"selected"; ?>>IT</option>
                                    <option value="MECH" <?php if(isset($post_data['branch']) && $post_data['branch'] == 'MECH') echo"selected"; ?>>MECH</option>
                                </select>
                                <div class="brancherror error_msg"><?php echo form_error('branch', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="case1" class="control-label col-lg-2">Case 1 (Through College) <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="case1" name="case1" value="<?php echo set_value('case1', (isset($post_data['case1']) ? $post_data['case1'] : '')); ?>" required data-error=".case1error" maxlength="255">
                                <div class="case1error error_msg"><?php echo form_error('case1', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="case2" class="control-label col-lg-2">Case 2 (By Student) <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="case2" name="case2" value="<?php echo set_value('case2', (isset($post_data['case2']) ? $post_data['case2'] : '')); ?>" required data-error=".case2error" maxlength="255">
                                <div class="case2error error_msg"><?php echo form_error('case2', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/semester_long_internship/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
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
    });

    $("#manage_form").validate({
        rules: {
            branch: {
                required: true,
            },
            case1: {
                required: true,
            },
            case2: {
                required: true,
            },
        },
        messages: {
            branch: {
                required: 'Please select branch',
            },
            case1: {
                required: 'Please enter Case 1 students',
            },
            case2: {
                required: 'Please enter Case 2 students',
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
                <?php if(isset($id) && !empty($id)) { ?>
                    var id                       = '<?php echo $post_data[id]; ?>';
                <?php } else { ?>
                    var id                       = '';
                <?php } ?>
                var branch                      = $('#branch').val();
                //var academic_year               = $('#academic_year').val();
                var check_result                = true;
                $('.brancherror').html('');

                function check_graph(id,branch) {
                    var check_mmg_result   = true;
                    $.ajax({
                        type: "POST",
                        url: base_url+"cms/semester_long_internship/ajax_check_graph",
                        async: false,
                        data: { id : id, branch : branch},
                        success: function(response){
                            if(response == '')
                            {
                                check_mmg_result = false;
                            }
                        }
                    });
                    return check_mmg_result;
                }

                check_result = check_graph(id,branch);

                if(check_result == false)
                {
                    $('.brancherror').html('data for this branch is already exist.');
                    return false;
                }
                else
                {
                    form.submit();
                }
            }
    });
</script>
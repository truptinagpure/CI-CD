<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Students Placed Branchwise</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Students Placed Branchwise</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/students_placed_branchwise/'); ?>">Back</a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <div class="form-group ">
                            <label for="academic_year" class="control-label col-lg-2">Academic Year <span class="asterisk">*</span></label>&nbsp;&nbsp;
                            <div class="col-lg-10">
                                <select id="academic_year" class="form-control select2 select2-hidden-accessible" name="academic_year" data-error=".academic_yearerror" data-placeholder="-- Please Select Academic Year --" aria-required="true" tabindex="-1" aria-hidden="true" required>
                                        <option value="">-- Please Select Academic Year --</option>
                                        <?php               
                                            foreach ($academic_year as $key => $value) {
                                            ?>
                                               <option value="<?php echo $value['academic_year_name']; ?>" <?php if(isset($post_data['academic_year']) && $value['academic_year_name'] == $post_data['academic_year']){ echo 'selected="selected"'; } ?>><?php echo $value['academic_year_name']; ?></option>
                                            <?php
                                            
                                            }
                                        ?>
                                </select>
                                <div class="academic_yearerror error_msg"><?php echo form_error('academic_year', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="branch" class="control-label col-lg-2">Branch <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <select id="branch" class="form-control select2" name="branch" data-placeholder="Select Branch" required>
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
                            <label for="placed_number" class="control-label col-lg-2">Number of Placed <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="placed_number" name="placed_number" value="<?php echo set_value('placed_number', (isset($post_data['placed_number']) ? $post_data['placed_number'] : '')); ?>" required data-error=".placed_numbererror" maxlength="255">
                                <div class="placed_numbererror error_msg"><?php echo form_error('placed_number', '<label class="error">', '</label>'); ?></div>
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
                                <a href="<?php echo base_url('cms/students_placed_branchwise/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            academic_year: {
                required: true,
            },
            branch: {
                required: true,
            },
            placed_number: {
                required: true,
            },
        },
        messages: {
            academic_year: {
                required: 'Please select academic year',
            },
            branch: {
                required: 'Please select branch',
            },
            placed_number: {
                required: 'Please enter placed number',
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
                var academic_year               = $('#academic_year').val();
                var check_result                = true;
                $('.academic_yearerror').html('');

                function check_graph(id,academic_year,branch) {
                    var check_mmg_result   = true;
                    $.ajax({
                        type: "POST",
                        url: base_url+"cms/students_placed_branchwise/ajax_check_graph",
                        async: false,
                        data: { id : id, academic_year : academic_year, branch : branch},
                        success: function(response){
                            if(response == '')
                            {
                                check_mmg_result = false;
                            }
                        }
                    });
                    return check_mmg_result;
                }

                check_result = check_graph(id,academic_year,branch);

                if(check_result == false)
                {
                    $('.academic_yearerror').html('Academic year data for this branch is already exist.');
                    return false;
                }
                else
                {
                    form.submit();
                }
            }
    });
</script>
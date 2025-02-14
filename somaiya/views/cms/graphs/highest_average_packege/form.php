<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Highest & Average Package</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Highest & Average Package</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/highest_average_packege/'); ?>">Back</a></span>
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
                            <label for="highest_package" class="control-label col-lg-2">Highest Package <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="highest_package" name="highest_package" value="<?php echo set_value('highest_package', (isset($post_data['highest_package']) ? $post_data['highest_package'] : '')); ?>" required data-error=".highest_packageerror" maxlength="255">
                                <div class="highest_packageerror error_msg"><?php echo form_error('highest_package', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="average_package" class="control-label col-lg-2">Average Package <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="average_package" name="average_package" value="<?php echo set_value('average_package', (isset($post_data['average_package']) ? $post_data['average_package'] : '')); ?>" required data-error=".average_packageerror" maxlength="255">
                                <div class="average_packageerror error_msg"><?php echo form_error('average_package', '<label class="error">', '</label>'); ?></div>
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
                                <a href="<?php echo base_url('cms/highest_average_packege/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            highest_package: {
                required: true,
            },
            average_package: {
                required: true,
            },
        },
        messages: {
            academic_year: {
                required: 'Please select academic year',
            },
            highest_package: {
                required: 'Please enter highest package',
            },
            average_package: {
                required: 'Please enter average package',
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
                var academic_year                = $('#academic_year').val();
                var check_result                 = true;
                $('.academic_yearerror').html('');

                function check_graph(id,academic_year) {
                    var check_mmg_result   = true;
                    $.ajax({
                        type: "POST",
                        url: base_url+"cms/highest_average_packege/ajax_check_graph",
                        async: false,
                        data: { id : id, academic_year : academic_year},
                        success: function(response){
                            if(response == '')
                            {
                                check_mmg_result = false;
                            }
                        }
                    });
                    return check_mmg_result;
                }

                check_result = check_graph(id,academic_year);

                if(check_result == false)
                {
                    $('.academic_yearerror').html('Academic year data for this institute is already exist.');
                    return false;
                }
                else
                {
                    form.submit();
                }
            }
    });
</script>
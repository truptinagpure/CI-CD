<?php mk_use_uploadbox($this); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($speaker_id) && !empty($speaker_id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Speaker</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Speaker</span>
                       <?php } ?>
                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/speakers/speakers/'); ?>">Back </a></span>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                            <div class="form-group ">
                                <label for="first_name" class="control-label col-lg-2">First Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo set_value('first_name', (isset($post_data['first_name']) ? $post_data['first_name'] : '')); ?>" required data-error=".firstnameerror" maxlength="250">
                                    <div class="firstnameerror error_msg"><?php echo form_error('first_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="middle_name" class="control-label col-lg-2">Middle Name</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo set_value('middle_name', (isset($post_data['middle_name']) ? $post_data['middle_name'] : '')); ?>" data-error=".middlenameerror" maxlength="250">
                                    <div class="middlenameerror error_msg"><?php echo form_error('middle_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="last_name" class="control-label col-lg-2">Last Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo set_value('last_name', (isset($post_data['last_name']) ? $post_data['last_name'] : '')); ?>" required data-error=".lastnameerror" maxlength="250">
                                    <div class="lastnameerror error_msg"><?php echo form_error('last_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="designation_id" class="control-label col-lg-2">Designation <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="designation_id" class="form-control" name="designation_id" required data-error=".designationiderror">
                                        <option value="">Select Designation</option>
                                        <?php foreach ($designations as $key => $value) { ?>
                                            <option value="<?php echo $value['designation_id']; ?>" <?php if(isset($post_data['designation_id']) && $post_data['designation_id'] == $value['designation_id']){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="designationiderror error_msg"><?php echo form_error('designation_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="description" class="control-label col-lg-2">Profile</label>
                                <div class="col-lg-10 tooltipText">
                                    <textarea class="form-control" id="description" name="description" data-error=".descriptionerror"><?php echo isset($post_data['description']) ? $post_data['description'] : ''; ?></textarea>
                                    <div class="descriptionerror error_msg"><?php echo form_error('description', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <?php mk_hurl_upload("profile_image", _l('Profile Image', $this), isset($post_data['profile_image']) ? $post_data['profile_image'] : '',"avatar"); ?>

                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this speakers on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input type="hidden" name="insta_id" value="<?php echo $insta_id; ?>">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/speakers/speakers/') ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>

    <?php mk_popup_uploadfile(_l('Upload Avatar',$this), "avatar", $base_url."upload_image/21/"); ?>

    <script type="text/javascript">
        $(document).ready(function() {
            if ($('#public_checkbox').is(':checked')) {
                $('#public').val(1);
            }else{
                $('#public').val(0);
            }

            $('#public_checkbox').click(function() {
                if($(this).is(':checked')){
                    $('#public').val(1);
                }else{
                    $('#public').val(0);
                }
            });
        });

        $("#manage_form").validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                designation_id: {
                    required: true,
                },
            },
            messages: {
                first_name: {
                    required: 'Please enter first name',
                },
                last_name: {
                    required: 'Please enter last name',
                },
                designation_id: {
                    required: 'Please select designation',
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
        });
    </script>
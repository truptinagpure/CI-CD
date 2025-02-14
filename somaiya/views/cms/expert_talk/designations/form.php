    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($designation_id) && !empty($designation_id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Designation</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Designation</span>
                       <?php } ?>                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/designations/designations/'); ?>">Back </a></span>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="designation_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                            <div class="form-group ">
                                <label for="name" class="control-label col-lg-2">Designation <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                    <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="short_name" class="control-label col-lg-2">Designation Short Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="short_name" name="short_name" value="<?php echo set_value('short_name', (isset($post_data['short_name']) ? $post_data['short_name'] : '')); ?>" required data-error=".shortnameerror" maxlength="50">
                                    <div class="shortnameerror error_msg"><?php echo form_error('short_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="description" class="control-label col-lg-2">Description</label>
                                <div class="col-lg-10 tooltipText">
                                    <textarea class="form-control" id="description" name="description" data-error=".descriptionerror"><?php echo isset($post_data['description']) ? $post_data['description'] : ''; ?></textarea>
                                    <div class="descriptionerror error_msg"><?php echo form_error('description', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this designations on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input type="hidden" name="insta_id" value="<?php echo $insta_id; ?>">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/designations/designations/') ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>

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

        $("#designation_form").validate({
            rules: {
                name: {
                    required: true,
                },
                short_name: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Please enter designation',
                },
                short_name: {
                    required: 'Please enter designation short name',
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
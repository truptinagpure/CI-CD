<?php error_reporting(0); ?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Whats New</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Whats New</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/whats_new/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="title" class="control-label col-lg-2">Title <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', (isset($post_data['title']) ? $post_data['title'] : '')); ?>" required data-error=".titleerror" maxlength="255">
                                    <div class="titleerror error_msg"><?php echo form_error('title', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="publish_date" class="control-label col-lg-2">Publish Date <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="datetimepicker" name="publish_date" value="<?php echo set_value('publish_date', (isset($post_data['publish_date']) ? $post_data['publish_date'] : '')); ?>" />
                                    <div class="from_dateerror error_msg"><?php echo form_error('publish_date', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="whats_new_expiry_date" class="control-label col-lg-2">What's New Expiry Date <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="datetimepicker2" name="whats_new_expiry_date" value="<?php echo set_value('whats_new_expiry_date', (isset($post_data['whats_new_expiry_date']) ? $post_data['whats_new_expiry_date'] : '')); ?>" />
                                    <div class="to_dateerror error_msg"><?php echo form_error('whats_new_expiry_date', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="url" class="control-label col-lg-2">URL <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="url" name="url" value="<?php echo set_value('url', (isset($post_data['url']) ? $post_data['url'] : '')); ?>" required data-error=".urlerror" maxlength="255">
                                    <div class="urlerror error_msg"><?php echo form_error('url', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Status</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('status', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="newtab" class="control-label col-lg-2">New Tab</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="newtab_checkbox" type="checkbox" <?php if(isset($post_data['newtab']) && $post_data['newtab'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('newtab', (isset($post_data['newtab']) ? $post_data['newtab'] : '')); ?>" style="display: none;" id="newtab" name="newtab" checked="" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/whats_new/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
        if ($('#newtab_checkbox').is(':checked')) {
            $('#newtab').val(1);
        }else{
            $('#newtab').val(0);
        }

        $('#newtab_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#newtab').val(1);
            }else{
                $('#newtab').val(0);
            }
        });
    });

    $("#manage_form").validate({
        rules: {
            title: {
                required: true,
            },
            publish_date: {
                required: true,
            },
            whats_new_expiry_date: {
                required: true,
            },
            url: {
                required: true,
            },
        },
        messages: {
            title: {
                required: 'Please enter title',
            },
            publish_date: {
                required: 'Please select publish date',
            },
            whats_new_expiry_date: {
                required: 'Please select whats new expiry date',
            },
            url: {
                required: 'Please enter url',
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

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">
    $('#datetimepicker').datetimepicker({
        format:'Y-m-d H:i:m',
        // minDate:new Date()
    });
    $('#datetimepicker2').datetimepicker({
        format:'Y-m-d H:i:m',
        // minDate:new Date()
    });
</script>
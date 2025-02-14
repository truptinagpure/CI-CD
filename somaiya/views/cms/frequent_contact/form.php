<?php error_reporting(0); ?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Frequent Contact</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Frequent Contact</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/frequent_contact/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="type" class="control-label col-lg-2">Contact Type <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="type" name="type" value="<?php echo set_value('type', (isset($post_data['type']) ? $post_data['type'] : '')); ?>" required data-error=".typeerror" maxlength="255">
                                    <div class="typeerror error_msg"><?php echo form_error('type', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="email" class="control-label col-lg-2">Email <span class="asterisk">*</span></label>
                                <div class="col-lg-10" id="email">
                                    <input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email', (isset($post_data['email']) ? $post_data['email'] : '')); ?>" required data-error=".emailerror">
                                    <div class="emailerror error_msg"><?php echo form_error('email', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="extention" class="control-label col-lg-2">Extention Number </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="extention" name="extention" value="<?php echo set_value('extention', (isset($post_data['extention']) ? $post_data['extention'] : '')); ?>" maxlength="255">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="contact_number" class="control-label col-lg-2">Contact Number </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo set_value('contact_number', (isset($post_data['contact_number']) ? $post_data['contact_number'] : '')); ?>" maxlength="255">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="order_by" class="control-label col-lg-2">Order By</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="order_by" name="order_by" value="<?php echo set_value('order_by', (isset($post_data['order_by']) ? $post_data['order_by'] : '')); ?>">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this Frequent contact on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('status', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/frequent_contact/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    });

    $("#manage_form").validate({
        rules: {
            type: {
                required: true,
            },
            email: {
                required: true,
            },
        },
        messages: {
            type: {
                required: 'Please enter type',
            },
            email: {
                required: 'Please enter email',
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
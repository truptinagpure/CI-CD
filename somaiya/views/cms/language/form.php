<?php mk_use_uploadbox($this); ?>
<?php error_reporting(0); ?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Language</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Language</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/language/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="language_name" class="control-label col-lg-2">Language Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="language_name" name="language_name" value="<?php echo set_value('language_name', (isset($post_data['language_name']) ? $post_data['language_name'] : '')); ?>" required data-error=".language_nameerror" maxlength="255">
                                    <div class="language_nameerror error_msg"><?php echo form_error('language_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="code" class="control-label col-lg-2">Language Code <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="code" name="code" value="<?php echo set_value('code', (isset($post_data['code']) ? $post_data['code'] : '')); ?>" required data-error=".codeerror" maxlength="255">
                                    <div class="codeerror error_msg"><?php echo form_error('code', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sort_order" class="control-label col-lg-2">Sort Order <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="sort_order" name="sort_order" value="<?php echo set_value('sort_order', (isset($post_data['sort_order']) ? $post_data['sort_order'] : '')); ?>" required data-error=".sort_ordererror" maxlength="255">
                                    <div class="sort_ordererror error_msg"><?php echo form_error('sort_order', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="default" class="control-label col-lg-2">Default</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="default_checkbox" type="checkbox" <?php if(isset($post_data['default']) && $post_data['default'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('default', (isset($post_data['default']) ? $post_data['default'] : '')); ?>" style="display: none;" id="default" name="default" checked="" type="text">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="control-label col-lg-2">Status</label>
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
                                <a href="<?php echo base_url('cms/language/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<?php
    mk_popup_uploadfile(_l('Upload Image',$this),"image",$base_url."upload_image/20/");
?>

<script type="text/javascript">
    $(document).ready(function() {

        /* Status */
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

        /* Default */
        if ($('#default_checkbox').is(':checked')) {
            $('#default').val(1);
        }else{
            $('#default').val(0);
        }

        $('#default_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#default').val(1);
            }else{
                $('#default').val(0);
            }
        });

    });

    $("#manage_form").validate({
        rules: {
            language_name: {
                required: true,
            },
            code: {
                required: true,
            },
            sort_order: {
                required: true,
            },
        },
        messages: {
            language_name: {
                required: 'Please enter language name',
            },
            code: {
                required: 'Please select language code',
            },
            sort_order: {
                required: 'Please select sort order',
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
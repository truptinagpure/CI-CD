<?php mk_use_uploadbox($this); ?>
<?php error_reporting(0); ?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Location</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Location</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/locations/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="location_name" class="control-label col-lg-2">Location Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="location_name" name="location_name" value="<?php echo set_value('location_name', (isset($post_data['location_name']) ? $post_data['location_name'] : '')); ?>" required data-error=".location_nameerror" maxlength="255">
                                    <div class="location_nameerror error_msg"><?php echo form_error('location_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="location_description" class="control-label col-lg-2">Location Description </label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" name="location_description" value="" maxlength="255"><?php echo $post_data['location_description']; ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this Location on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
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
                                <a href="<?php echo base_url('cms/locations/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            location_name: {
                required: true,
            },
        },
        messages: {
            location_name: {
                required: 'Please enter location name',
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
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Sub Type</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Sub Type</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/donation_sub_type/'); ?>">Back</a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label for="donation_type" class="control-label col-lg-2">Type <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="donation_type" class="form-control select2" name="donation_type" required data-error=".parentiderror" data-placeholder="-- Select Type --">
                                    <option value="">-- Select Type --</option>
                                    <?php foreach ($type_list as $key => $value) { ?>
                                        <option value="<?php echo $value['dontype_id']; ?>" <?php if(isset($post_data['donation_type']) && $post_data['donation_type'] == $value['dontype_id']){ echo 'selected="selected"'; } ?>><?php echo $value['parent_name']; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="parentiderror error_msg"><?php echo form_error('donation_type', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="sub_donation_type" class="control-label col-lg-2">Sub Type Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="sub_donation_type" name="sub_donation_type" value="<?php echo set_value('sub_donation_type', (isset($post_data['sub_donation_type']) ? $post_data['sub_donation_type'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                <div class="nameerror error_msg"><?php echo form_error('sub_donation_type', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="public" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this donation sub type on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/donation_sub_type/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            donation_type: {
                required: true,
            },
            sub_donation_type: {
                required: true,
            },
        },
        messages: {
            donation_type: {
                required: 'Please select type',
            },
            sub_donation_type: {
                required: 'Please enter sub type',
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
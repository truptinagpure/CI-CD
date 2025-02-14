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
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/awards_sub_type/'); ?>">Back</a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label for="parent_id" class="control-label col-lg-2">Type <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="parent_id" class="form-control select2" name="parent_id" required data-error=".parentiderror" data-placeholder="-- Select Category Type --">
                                    <option value="">-- Select Type --</option>
                                    <?php foreach ($type_list as $key => $value) { ?>
                                        <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['parent_id']) && $post_data['parent_id'] == $value['id']){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="parentiderror error_msg"><?php echo form_error('parent_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-2">Sub Type Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this awards sub type on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/awards_sub_type/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            parent_id: {
                required: true,
            },
            name: {
                required: true,
            },
        },
        messages: {
            parent_id: {
                required: 'Please select type',
            },
            name: {
                required: 'Please enter sub type name',
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
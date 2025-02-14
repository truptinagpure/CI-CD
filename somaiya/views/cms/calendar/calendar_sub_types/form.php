<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Sub Calendar Type</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Sub Calendar Type</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/calendar_sub_types/'); ?>">Back</a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <div class="form-group">
                            <label for="calendar_type_id" class="control-label col-lg-2">Calendar Type <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="calendar_type_id" class="form-control select2" name="calendar_type_id" required data-error=".calendar_type_iderror" data-placeholder="-- Select Calendar Type --">
                                    <option value="">-- Select Calendar Type --</option>
                                    <?php foreach ($calendar_type_list as $key => $value) { ?>
                                        <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['calendar_type_id']) && $post_data['calendar_type_id'] == $value['id']){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="calendar_type_iderror error_msg"><?php echo form_error('calendar_type_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-2">Sub Calendar Type <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish <span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this calendar type on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/calendar_sub_types/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            calendar_type_id: {
                required: true,
            },
            name: {
                required: true,
            },
        },
        messages: {
            calendar_type_id: {
                required: 'Please enter calendar type',
            },
            name: {
                required: 'Please enter calendar sub type',
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
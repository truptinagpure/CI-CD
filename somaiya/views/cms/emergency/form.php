<?php error_reporting(0); ?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Emergency</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Emergency</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/emergency/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="emergency_name" class="control-label col-lg-2">Emergency Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="emergency_name" name="emergency_name" value="<?php echo set_value('emergency_name', (isset($post_data['emergency_name']) ? $post_data['emergency_name'] : '')); ?>" required data-error=".emergency_nameerror" maxlength="255">
                                    <div class="emergency_nameerror error_msg"><?php echo form_error('emergency_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="location_id" class="control-label col-lg-2">Location <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="location_id" class="form-control select2" name="location_id" required data-error=".location_iderror" data-placeholder="-- Select Location --">
                                        <option value="">-- Select Location --</option>
                                        <?php foreach ($location as $key => $value) { ?>
                                            <option value="<?php echo $value['location_id']; ?>" <?php if(isset($post_data['location_id']) && $post_data['location_id'] == $value['location_id']){ echo 'selected="selected"'; } ?>><?php echo $value['location_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="location_iderror error_msg"><?php echo form_error('location_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="from_date" class="control-label col-lg-2">Start Date <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="datetimepicker" name="from_date" value="<?php echo set_value('from_date', (isset($post_data['from_date']) ? $post_data['from_date'] : '')); ?>" />
                                    <div class="from_dateerror error_msg"><?php echo form_error('from_date', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="to_date" class="control-label col-lg-2">End Date <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="datetimepicker2" name="to_date" value="<?php echo set_value('to_date', (isset($post_data['to_date']) ? $post_data['to_date'] : '')); ?>" />
                                    <div class="to_dateerror error_msg"><?php echo form_error('to_date', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="severity" class="control-label col-lg-2">Severity Level <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="single" class="form-control select2" name="severity" data-placeholder="-- Select Severity Level --" required>
                                        <option value="">-- Select Severity Level --</option>
                                        <option value="High" <?php if($post_data['severity'] == 'High') echo"selected"; ?>>High</option>
                                        <option value="Medium" <?php if($post_data['severity'] == 'Medium') echo"selected"; ?>>Medium</option>
                                        <option value="Low" <?php if($post_data['severity'] == 'Low') echo"selected"; ?>>Low</option>
                                    </select>
                                    <div class="severityerror error_msg"><?php echo form_error('severity', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <?php mk_hWYSItexteditor("description", 'Description', isset($post_data['description']) ? $post_data['description'] : '', 'description'); ?>

                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Status</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/emergency/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            emergency_name: {
                required: true,
            },
            location_id: {
                required: true,
            },
            severity: {
                required: true,
            },
            from_date: {
                required: true,
            },
            to_date: {
                required: true,
            },
        },
        messages: {
            emergency_name: {
                required: 'Please enter emergency name',
            },
            location_id: {
                required: 'Please select location',
            },
            severity: {
                required: 'Please select severity level',
            },
            from_date: {
                required: 'Please select start date',
            },
            to_date: {
                required: 'Please select end date',
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
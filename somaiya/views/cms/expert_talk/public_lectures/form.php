<?php mk_use_uploadbox($this); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <?php //$institute = $_SESSION['inst_id'];
            $institute = $this->session->userdata['sess_institute_id'];
             ?>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($lecture_id) && !empty($lecture_id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit <?php echo $pub_lect_title; ?> </span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New <?php echo $pub_lect_title; ?> </span>
                       <?php } ?>
                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/public_lectures/lectures/'); ?>">Back </a></span>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                            <div class="form-group ">
                                <label for="title" class="control-label col-lg-2"> Title <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', (isset($post_data['title']) ? $post_data['title'] : '')); ?>" required data-error=".titleerror" maxlength="250">
                                    <div class="titleerror error_msg"><?php echo form_error('title', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="designation_id" class="control-label col-lg-2">Speaker <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="speaker_id" class="form-control" name="speaker_id" required data-error=".speakeriderror">
                                        <option value="">-- Select Speaker --</option>
                                        <?php foreach ($speakers as $key => $value) { ?>
                                            <option value="<?php echo $value['speaker_id']; ?>" <?php if(isset($post_data['speaker_id']) && $post_data['speaker_id'] == $value['speaker_id']){ echo 'selected="selected"'; } ?>><?php echo $value['speaker_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="speakeriderror error_msg"><?php echo form_error('speaker_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <?php if($institute == 22) { ?>
                            <div class="form-group">
                                <label for="department" class="control-label col-lg-2">Department </label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="department_id" class="form-control" name="department_id">
                                        <option value="">-- Select Department --</option>
                                        <?php foreach ($departments as $key => $value) { ?>
                                            <option value="<?php echo $value['Department_Id']; ?>" <?php if(isset($post_data['department_id']) && $post_data['department_id'] == $value['Department_Id']){ echo 'selected="selected"'; } ?>><?php echo $value['Department_Name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group ">
                                <label for="start_date_time" class="control-label col-lg-2">Start Date & Time <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="datetimepicker1" name="start_date_time" value="<?php echo set_value('start_date_time', (isset($post_data['start_date_time']) ? $post_data['start_date_time'] : '')); ?>" required data-error=".startdatetimeerror" />
                                    <div class="startdatetimeerror error_msg"><?php echo form_error('start_date_time', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="end_date_time" class="control-label col-lg-2">End Date & Time <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="datetimepicker2" name="end_date_time" value="<?php echo set_value('end_date_time', (isset($post_data['end_date_time']) ? $post_data['end_date_time'] : '')); ?>" required data-error=".enddatetimeerror" />
                                    <div class="enddatetimeerror error_msg"><?php echo form_error('end_date_time', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="venue" class="control-label col-lg-2">Venue <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="venue" name="venue" value="<?php echo set_value('venue', (isset($post_data['venue']) ? $post_data['venue'] : '')); ?>" data-error=".venueerror" maxlength="250">
                                    <div class="venueerror error_msg"><?php echo form_error('venue', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="data[category_id]" class="control-label col-lg-2">Area of Interest</label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" multiple name="area_of_interest[]" data-placeholder="Select Area Of Interest">
                                        <option value="">-- Select Area Of Interest --</option>
                                        <?php
                                            if(isset($categories) && count($categories)!=0){
                                                foreach ($categories as $key => $value) {
                                        ?>
                                                    <option value="<?=$value['category_id']?>" <?php if(in_array($value['category_id'], $area_of_interest_array)) echo "selected"; ?>><?=$value['category_name']?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="abstract_to_talk" class="control-label col-lg-2">Abstract of the talk</label>
                                <div class="col-lg-10 tooltipText">
                                    <textarea class="form-control" id="abstract_to_talk" name="abstract_to_talk" data-error=".abstracttotalkerror"><?php echo isset($post_data['abstract_to_talk']) ? $post_data['abstract_to_talk'] : ''; ?></textarea>
                                    <div class="abstracttotalkerror error_msg"><?php echo form_error('abstract_to_talk', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            
                            <?php mk_hurl_upload("image", _l('Image', $this), isset($post_data['image']) ? $post_data['image'] : '',"avatar"); ?>

                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Publish <span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this public lecture on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input type="hidden" name="insta_id" value="<?php echo $insta_id; ?>">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/public_lectures/lectures/') ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>

    <?php mk_popup_uploadfile(_l('Upload Image',$this), "avatar", $base_url."upload_image/22/"); ?>

    <link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

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

        $('#datetimepicker1, #datetimepicker2').datetimepicker({
            format:'Y-m-d H:i:s',
        });

        jQuery.validator.addMethod("greaterThan", 
        function(value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) 
                || (Number(value) > Number($(params).val())); 
        },'Must be greater than start date & time.');

        $("#manage_form").validate({
            rules: {
                title: {
                    required: true,
                },
                start_date_time: {
                    required: true,
                },
                end_date_time: {
                    required: true,
                    greaterThan: "#datetimepicker1"
                },
                venue: {
                    required: true,
                },
            },
            messages: {
                title: {
                    required: 'Please enter title',
                },
                start_date_time: {
                    required: 'Please select start date & time',
                },
                end_date_time: {
                    required: 'Please select end date & time',
                },
                venue: {
                    required: 'Please enter venue',
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
<?php mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php $institute = $insta_id; ?>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Industrial Visit</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Industrial Visit</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/industrial_visits/'); ?>">Back </a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group">
                                <label for="department_id" class="control-label col-lg-2">Department Name<span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
								<?php /*
                                    <select id="department_id" class="form-control select2" name="department_id" required data-error=".departmentiderror" data-placeholder="-- Select Derpartment --">
                                        <option value="">-- Select Department --</option>
                                        <?php foreach ($industrial_department as $key => $value) { ?>
                                            <option value="<?php echo $value['Department_Id']; ?>" <?php if(isset($post_data['department_id']) && $post_data['department_id'] == $value['Department_Id']){ echo 'selected="selected"'; } ?>><?php echo $value['Department_Name']; ?></option>
                                        <?php } ?>
                                    </select>
									*/ ?>
									<?php if(isset($post_data['department_id']) && !empty($post_data['department_id']) && is_string($post_data['department_id']))
                                    {
										$post_data['department_id'] = explode(',', $post_data['department_id']);

									}
									?>
									<select id="department_id" class="form-control select2-multiple" multiple name="department_id[]" required data-error=".departmentiderror" data-placeholder="-- Select Derpartment --">
                                        <option value="">-- Select Department --</option>
                                        <?php foreach ($industrial_department as $key => $value) { ?>
                                            <option value="<?php echo $value['department_id']; ?>" <?php if(isset($post_data['department_id']) && !empty($post_data['department_id']) && in_array($value['department_id'], $post_data['department_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['Department_Name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="departmentiderror error_msg"><?php echo form_error('department_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                        <div class="form-group ">
                                <label for="industry_name" class="control-label col-lg-2">Industry Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="industry_name" name="industry_name" value="<?php echo set_value('industry_name', (isset($post_data['industry_name']) ? $post_data['industry_name'] : '')); ?>" required data-error=".industry_nameerror" maxlength="250">
                                    <div class="industry_nameerror error_msg"><?php echo form_error('industry_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                        <div class="form-group ">
                                <label for="location" class="control-label col-lg-2">Location <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="location" name="location" value="<?php echo set_value('location', (isset($post_data['location']) ? $post_data['location'] : '')); ?>" required data-error=".locationerror" maxlength="250">
                                    <div class="locationerror error_msg"><?php echo form_error('location', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                        <div class="form-group ">
                                <label for="contact_perso" class="control-label col-lg-2">Contact Person </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo set_value('contact_person', (isset($post_data['contact_person']) ? $post_data['contact_person'] : '')); ?>" data-error=".contact_personerror" maxlength="250">
                                    <div class="contact_personerror error_msg"><?php echo form_error('contact_person', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>                        

                        <div class="form-group ">
                                <label for="contact_number" class="control-label col-lg-2">Contact Number</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo set_value('contact_number', (isset($post_data['contact_number']) ? $post_data['contact_number'] : '')); ?>" data-error=".contact_numbererror" maxlength="250">
                                    <div class="contact_numbererror error_msg"><?php echo form_error('contact_number', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                        <div class="form-group ">
                                <label for="email_id" class="control-label col-lg-2">Email id</label>
                                <div class="col-lg-10">
                                    <input type="email" class="form-control" id="email_id" name="email_id" value="<?php echo set_value('email_id', (isset($post_data['email_id']) ? $post_data['email_id'] : '')); ?>" data-error=".email_iderror" maxlength="250">
                                    <div class="email_iderror error_msg"><?php echo form_error('email_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                        <div class="form-group ">
                                <label for="website_url" class="control-label col-lg-2">Website url</label>
                                <div class="col-lg-10">
                                    <input type="url" class="form-control" id="website_url" name="website_url" value="<?php echo set_value('website_url', (isset($post_data['website_url']) ? $post_data['website_url'] : '')); ?>" data-error=".website_urlerror" maxlength="250">
                                    <div class="website_urlerror error_msg"><?php echo form_error('website_url', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                        <div class="form-group ">
                                <label for="organise_by" class="control-label col-lg-2">Organise by</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="organise_by" name="organise_by" value="<?php echo set_value('organise_by', (isset($post_data['organise_by']) ? $post_data['organise_by'] : '')); ?>" data-error=".website_urlerror" maxlength="250">
                                    <div class="organise_byerror error_msg"><?php echo form_error('organise_by', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                        <div class="form-group ">
                                <label for="description" class="control-label col-lg-2">Description</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="description" name="description" data-error=".description_error"><?php echo (isset($post_data['description']) ? $post_data['description'] : ''); ?></textarea>
                                    <div class="description_error error_msg"><?php echo form_error('description', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                        <div class="form-group ">
                                <label for="start_date" class="control-label col-lg-2">Visit From <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="visit_from" name="visit_from" data-error=".visit_fromerror" value="<?php echo set_value('visit_from', (isset($post_data['visit_from']) ? $post_data['visit_from'] : '')); ?>" required />
                                    <div class="visit_fromerror error_msg"><?php echo form_error('visit_from', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                        <div class="form-group ">
                                <label for="end_date" class="control-label col-lg-2">Visit To <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="visit_to" name="visit_to" data-error=".visit_toerror" value="<?php echo set_value('visit_to', (isset($post_data['visit_to']) ? $post_data['visit_to'] : '')); ?>" required />
                                    <div class="visit_toerror error_msg"><?php echo form_error('visit_to', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                        <!-- <div class="form-group ">
                            <label for="data[visit_to]" class="control-label col-lg-2">Visit To <span class="asterisk">*</span></label>&nbsp;&nbsp;
                            <input type="text" id="visit_to" name="visit_to" value="<?php //if(isset($post_data['visit_to'])) { echo $post_data['visit_to']; } ?>" required />
                        </div> -->

                        <!-- <div class="form-group ">
                            <label for="data[from_date]" class="control-label col-lg-2">End Date <span class="asterisk">*</span></label>&nbsp;&nbsp;
                            <input type="text" id="datetimepicker2" name="from_date" value="<?php //if(isset($data['from_date'])) { echo $data['from_date']; } ?>" required />
                        </div> -->
                           
                           <div class="row">
                                <div class="col-md-12">
                                    <?php $this->load->view('cms/industrial_visits/industry_image'); ?>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="gallery_url" class="control-label col-lg-2">Gallery url </label>
                                <div class="col-lg-10">
                                    <input type="url" class="form-control" id="gallery_url" name="gallery_url" value="<?php echo set_value('gallery_url', (isset($post_data['gallery_url']) ? $post_data['gallery_url'] : '')); ?>" data-error=".gallery_urlerror" maxlength="250">
                                    <div class="gallery_urlerror error_msg"><?php echo form_error('gallery_url', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>


                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this industrial visit on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                                </div>
                            </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/industrial_visits/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->                                
    </div>
</div>


<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">
    $('#visit_from').datetimepicker({
        format:'Y-m-d H:i',
    });

    $('#visit_to').datetimepicker({
        format:'Y-m-d H:i',
    });

    // $('#datetimepicker3').datetimepicker({
    //     format:'Y-m-d',
    //     minDate:new Date()
    // });
</script>


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
            department_id: {
                required: true,
            },
            industry_name: {
                required: true,
            },
            location: {
                required: true,
            },
            /* contact_person: {
                required: true,
            },
            contact_number: {
                required: true,
            },
            email_id: {
                required: true,
            },
            website_url: {
                required: true,
            },
            organise_by: {
                required: true,
            },
            description: {
                required: true,
            }, */
            visit_from: {
                required: true,
            },
            visit_to: {
                required: true,
            },
            // image: {
            //     required: true,
            // },
        },
        messages: {
            department_id: {
                required: 'Please select department',
            },
            industry_name: {
                required: 'Please enter industry name',
            },
            location: {
                required: 'Please enter location',
            },
            /* contact_person: {
                required: 'Please enter contact person',
            },
            contact_number: {
                required: 'Please enter contact number',
            },
            email_id: {
                required: 'Please enter email id',
            },
            website_url: {
                required: 'Please enter website url',
            },
            organise_by: {
                required: 'Please enter organise by',
            },
            description: {
                required: 'Please enter description',
            }, */
            visit_from: {
                required: 'Please enter Visit From Date',
            },
            visit_to: {
                required: 'Please enter Visit To Date',
            },
            // image: {
            //     required: 'Please enter image',
            // },
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


    (function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());

    $('.cross-btn').click(function(){
        $(this).parent().parent().remove();
    });

</script>
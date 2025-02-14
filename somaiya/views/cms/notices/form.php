
                                
<?php //mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Notice</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Notice</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/notices/'); ?>">Back </a></span>
            </div>
            <?php
            // echo "<pre>";
            // print_r($post_data);
            // echo "<br>----------<br>";

            // echo "<pre>";
            // print_r($all_notice_category);

            
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="notices_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="notice_name" class="control-label col-lg-2">Notice Title <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="notice_name" name="notice_name" value="<?php echo set_value('notice_name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".notice_nameerror" maxlength="250">
                                <div class="notice_nameerror error_msg"><?php echo form_error('notice_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>  

                        <?php /*
                        <div class="form-group ">
                            <label for="institute_id" class="control-label col-lg-2">Institute Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <select id="institute_id" name="institute_id[]" required>
                                    <option value="<?php echo $sess_institute_id; ?>" selected="selected"><?php echo $sess_institute_name; ?></option>
                                </select>
                                
                                <div class="institute_iderror error_msg"><?php echo form_error('institute_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
						<?php
						*/
                        if(isset($post_data['department_id']))
                        {
                           $department_id = explode(",", $post_data['department_id']);
                        }

						?>
						<div class="form-group ">
                            <label for="department" class="control-label col-lg-2">Department</label>
                            <div class="col-lg-10">

                                <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" name="department[]" data-placeholder="Please select notice department" multiple>
                                    <option value="">-- Please select department --</option>
                                    <?php               
                                        foreach ($all_department as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['Department_Id']; ?>" <?php if(isset($post_data['department_id']) && in_array($value['Department_Id'], $department_id)) { echo 'selected="selected"'; } ?>><?php echo $value['Department_Name']; ?></option>
                                        <?php
                                        
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
						<?php

                        // echo "<pre>";
                        // print_r($post_data['notices_cat_id']);
                        // echo "<br>-------------<br>";
                        // echo "<pre>";
                        // print_r($all_notice_category);
                        // echo "<br>-------------<br>";
                        // exit();
                            if(isset($post_data['notices_cat_id']))
                            {
                                $notices_cat_id = explode(",", $post_data['notices_cat_id']);
                            }
                        ?>
                        <div class="form-group ">
                            <label for="notice_category" class="control-label col-lg-2">Notice Category<span class="asterisk">*</span></label>
                            <div class="col-lg-10">

                                <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" name="notice_category[]" data-placeholder="Please select notice category" multiple required>
                                    <!-- <option value="">-- Please select notice category --</option> -->
                                    <?php               
                                        foreach ($all_notice_category as $key => $value) {
                                        ?> 
                                           
                                           <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['notices_cat_id']) && in_array($value['id'], $notices_cat_id)) { echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                            if(array_key_exists("sub_category", $value)) 
                                            { 
                                                foreach ($value['sub_category'] as $key1 => $value1) {
                                                    ?>
                                                    <option value="<?php echo $value1['id']; ?>" <?php if(isset($post_data['notices_cat_id']) && in_array($value1['id'], $notices_cat_id)) { echo 'selected="selected"'; } ?>>&nbsp;&nbsp;&nbsp;<?php echo $value1['name']; ?></option>
                                                    <?php
                                                }  
                                            }
                                            
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="form-group ">
                            <label for="url" class="control-label col-lg-2">Notice URL <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="url" name="url" value="<?php //echo set_value('url', (isset($post_data['url']) ? $post_data['url'] : '')); ?>" required data-error=".urlerror" maxlength="250">
                                <div class="urlerror error_msg"><?php //echo form_error('url', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div> -->

                        <?php $this->load->view('cms/notices/notices_links'); ?>

                        <div class="form-group ">
                            <label for="date" class="control-label col-lg-2">Notice Date <span class="asterisk">*</span></label>&nbsp;&nbsp;
                            <div class="col-lg-10">
                                <input type="text" id="date" name="date" value="<?php if(isset($post_data['date'])) { echo $post_data['date']; } ?>" required />
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="expiry_date" class="control-label col-lg-2">Expiry Date </label>&nbsp;&nbsp;
                            <div class="col-lg-10">
                                <input type="text" id="expiry_date" name="expiry_date" value="<?php if(isset($post_data['expiry_date'])) { echo $post_data['expiry_date']; } ?>" />
                            </div>
                        </div>
                        <?php
                        // echo "<pre>";
                        // print_r($academic_year);
                        ?>
                        <div class="form-group ">
                            <label for="academic_year" class="control-label col-lg-2">Academic Year <span class="asterisk">*</span></label>&nbsp;&nbsp;
                            <div class="col-lg-10">
                                <select id="academic_year" class="form-control select2 select2-hidden-accessible" name="academic_year" data-error=".academic_yearerror" data-placeholder="-- Please Select Academic Year --" aria-required="true" tabindex="-1" aria-hidden="true" required>
                                        <option value="">-- Please Select Academic Year --</option>
                                        <?php               
                                            foreach ($academic_year as $key => $value) {
                                            ?>
                                               <option value="<?php echo $value['academic_year_name']; ?>" <?php if(isset($post_data['academic_year']) && $value['academic_year_name'] == $post_data['academic_year']){ echo 'selected="selected"'; } ?>><?php echo $value['academic_year_name']; ?></option>
                                            <?php
                                            
                                            }
                                        ?>
                                </select>
                                <div class="academic_yearerror error_msg"><?php echo form_error('academic_year', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <?php
                            if(isset($post_data['applicable_for']))
                            {
                                $applicable_for = explode(",", $post_data['applicable_for']);
                            }

                            $all_applicable_for = array(array( "name" => "student"), array( "name" => "faculty"), array( "name" =>"staff"), array( "name" => "public"), array( "name" => "alumni"));

                        ?>
                        <div class="form-group ">
                            <label for="applicable_for" class="control-label col-lg-2">Applicable for <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                            <select id="applicable_for" class="form-control input-lg select2-multiple" name="applicable_for[]" data-placeholder="Please select Applicable For" multiple required>
                                <option value="">Please Select Applicable For</option>
                                <?php
                                foreach ($all_applicable_for as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['name']; ?>" <?php if(isset($post_data['applicable_for']) && in_array($value['name'], $applicable_for)) { echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                        
                                        }
                                ?>
                                
                            </select>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label for="whats_new" class="control-label col-lg-2">What's New</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control whats_new" id="whats_new_checkbox" type="checkbox" <?php if(isset($post_data['whats_new']) && $post_data['whats_new'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('whats_new', (isset($post_data['whats_new']) ? $post_data['whats_new'] : '')); ?>" style="display: none;" id="whats_new" name="whats_new" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group expiry_wrap hidden">
                            <label for="data[whats_new_expiry_date]" class="control-label col-lg-2">What's New Expiry Date</label>
                            <div class="col-lg-10">
                                <input type="text" id="whats_new_expiry_date" name="whats_new_expiry_date" value="<?php echo set_value('data[whats_new_expiry_date]', (isset($post_data['whats_new_expiry_date']) ? $post_data['whats_new_expiry_date'] : '')); ?>" />
                            </div>
                        </div>
						
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/notices/') ?>" class="btn btn-default" type="button">Cancel</a>
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
    $('#date').datetimepicker({
        format:'Y-m-d H:i',
    });

    $('#expiry_date').datetimepicker({
        format:'Y-m-d H:i',
    });
	
	$('#whats_new_expiry_date').datetimepicker({
        format:'Y-m-d',
        minDate:new Date()
    });

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
		
		/* whats new */

        if ($('#whats_new_checkbox').is(':checked')) {
            $('#whats_new').val(1);
        }else{
            $('#whats_new').val(0);
        }

        $('#whats_new_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#whats_new').val(1);
            }else{
                $('#whats_new').val(0);
            }
        });
		

    });

    $("#notices_form").validate({
        rules: {
            notice_name: {
                required: true,
            },
            // department: {
            //     required: true,
            // },
            notice_category: {
                required: true,
            },
            // url: {
            //     required: true,
            // },
            date: {
                required: true,
            },
            //expiry_date: {
            //    required: true,
            //},
            academic_year: {
                required: true,
            },
            applicable_for: {
                required: true,
            },
            // institute_id: {
            //     required: true,
            // },
            
        },
        messages: {
            notice_name: {
                required: 'Please Enter Notice Title',
            },
            // department: {
            //     required: 'Please select Department',
            // },
            notice_category: {
                required: 'Please Select Notice Category',
            },
            // url: {
            //     required: 'Please Enter URL',
            // },
            date: {
                required: 'Please Select Notice Date',
            },
            //expiry_date: {
            //    required: 'Please Select Expiry Date',
            //},
            academic_year: {
                required: 'Please Enter Academic Year',
            },
            applicable_for: {
                required: 'Please Select Applicable For',
            },
            // institute_id: {
            //     required: 'Please select institute name',
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

</script>

<script type="text/javascript">
    $(document).ready(function(event) 
    {
        if($('.whats_new').is(':checked')) 
        {
            $('.expiry_wrap').removeClass('hidden');
            $('#whats_new1').val(1);
        }else{
            $('.expiry_wrap').addClass('hidden');
            $('#whats_new1').val(0);
        }
            
        $('.whats_new').click(function() 
        {
            if($(this).is(':checked'))
            {
                $('.expiry_wrap').removeClass('hidden');
                $('#whats_new1').val(1);
            }else{
                $('.expiry_wrap').addClass('hidden');
                $('#whats_new1').val(0);
            }
        });

        $('.cmxform').submit(function(event)
        {
            if($('.whats_new').is(':checked')) 
            {
                if($('#whats_new_expiry_date').val() == '' || $('#whats_new_expiry_date').val() == '0000-00-00')
                {
                    swal({
                        title: "Oops...",
                        text: "Please select expiry date for what's new section",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonClass: "btn btn-success mr10",
                        cancelButtonClass: "btn btn-danger",
                        buttonsStyling: false,
                        confirmButtonText: "Ok"
                    }).then(function () {
                    }, function(dismiss) {});
                    event.preventDefault();
                }
            }
        });
    });
</script>
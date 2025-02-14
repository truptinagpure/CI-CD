<link href="<?php echo base_url(); ?>assets/layouts/layout/image_upload/styles.imageuploader.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/layouts/layout/image_upload/jquery.imageuploader.js"></script>


<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Industrial Visit</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Industrial Visit</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('kjsieit_bk/industrial_visits/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link active" id="generalinfo-tab" data-toggle="tab" href="#generalinfotab" role="tab" aria-controls="generalinfotab" aria-selected="true">General Info</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="benefits-tab" data-toggle="tab" href="#benefitstab" role="tab" aria-controls="benefitstab" aria-selected="false">Benefits</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="verses-tab" data-toggle="tab" href="#versestab" role="tab" aria-controls="versestab" aria-selected="false">Verses</a>
                        </li> -->
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade active in" id="generalinfotab" role="tabpanel" aria-labelledby="generalinfo-tab">
                            <div class="form-group">
                                <label for="department_id" class="control-label col-lg-2">Department Name<span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="department_id" class="form-control select2" name="department_id" required data-error=".departmentiderror" data-placeholder="-- Select Derpartment --">
                                        <option value="">-- Select Department --</option>
                                        <?php foreach ($industrial_department as $key => $value) { ?>
                                            <option value="<?php echo $value['Department_Id']; ?>" <?php if(isset($post_data['department_id']) && $post_data['department_id'] == $value['Department_Id']){ echo 'selected="selected"'; } ?>><?php echo $value['Department_Name']; ?></option>
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
                                <label for="location" class="control-label col-lg-2">Locationt <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="location" name="location" value="<?php echo set_value('location', (isset($post_data['location']) ? $post_data['location'] : '')); ?>" required data-error=".locationerror" maxlength="250">
                                    <div class="locationerror error_msg"><?php echo form_error('location', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="contact_perso" class="control-label col-lg-2">Contact Person <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contact_person" name="contact_person" value="<?php echo set_value('contact_person', (isset($post_data['contact_person']) ? $post_data['contact_person'] : '')); ?>" required data-error=".contact_personerror" maxlength="250">
                                    <div class="contact_person error_msg"><?php echo form_error('contact_person', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="contact_number" class="control-label col-lg-2">Contact Number <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="<?php echo set_value('contact_number', (isset($post_data['contact_number']) ? $post_data['contact_number'] : '')); ?>" required data-error=".contact_numbererror" maxlength="250">
                                    <div class="contact_numbererror error_msg"><?php echo form_error('contact_number', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="email_id" class="control-label col-lg-2">Email id <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="email_id" name="email_id" value="<?php echo set_value('email_id', (isset($post_data['email_id']) ? $post_data['email_id'] : '')); ?>" required data-error=".email_iderror" maxlength="250">
                                    <div class="email_iderror error_msg"><?php echo form_error('email_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="website_url" class="control-label col-lg-2">Website url <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="website_url" name="website_url" value="<?php echo set_value('website_url', (isset($post_data['website_url']) ? $post_data['website_url'] : '')); ?>" required data-error=".website_urlerror" maxlength="250">
                                    <div class="website_urlerror error_msg"><?php echo form_error('website_url', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="organise_by" class="control-label col-lg-2">Organise by <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="organise_by" name="organise_by" value="<?php echo set_value('organise_by', (isset($post_data['organise_by']) ? $post_data['organise_by'] : '')); ?>" required data-error=".website_urlerror" maxlength="250">
                                    <div class="organise_byerror error_msg"><?php echo form_error('organise_by', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="description" class="control-label col-lg-2">Description <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="description" name="description" required data-error=".description_error"><?php echo (isset($post_data['description']) ? $post_data['description'] : ''); ?></textarea>
                                    <div class="description_error error_msg"><?php echo form_error('description', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="start_date" class="control-label col-lg-2">visit From <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="visit_from" name="visit_from" data-error=".visit_fromerror" value="<?php echo set_value('visit_from', (isset($post_data['visit_from']) ? $post_data['visit_from'] : '')); ?>" required />
                                    <div class="visit_fromerror error_msg"><?php echo form_error('visit_from', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            
                            <div class="form-group ">
                                <label for="end_date" class="control-label col-lg-2">visit To <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="visit_to" name="visit_to" data-error=".visit_toerror" value="<?php echo set_value('visit_to', (isset($post_data['visit_to']) ? $post_data['visit_to'] : '')); ?>" required />
                                    <div class="visit_toerror error_msg"><?php echo form_error('visit_to', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <?php /*
                            <!-- <div class="form-group">
                                <label class="control-label col-lg-2">Image</label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <input type="text" id="croppie-profile" class="croppie-input" name="profile_pic" accept=".png,.jpg,.jpeg,.gif">
                                            <?php if(isset($post_data['image']) && !empty($post_data['image'])){ ?>
                                                <img id="croppie-image" class="croppie-img" src="<?php echo base_url(); ?>upload_file/kjsieit/industrial_visits/images/<?php echo $post_data['image']; ?>" height="170px" width="170px" />
                                                <input id="croppie_upload_image" type="file" class="croppie-input" placeholder="Photo" capture>
                                            <?php } else { ?>
                                                <input id="croppie_upload_image" type="file" class="croppie-input cc" placeholder="Photo" capture>
                                            <?php } ?>
                                            <input type="hidden" id="croppie-thumbnail" name="image" class="croppie-input">
                                        </div>
                                    </div>
                                
                                    <div id="uploadimageModal" class="modal" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Crop Image</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 text-center">
                                                            <div id="profile_image_demo"  style=""></div>
                                                        </div>
                                                        <div class="col-md-4" style="padding-top:0px;">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="skip" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn green crop_image">Crop</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            */ ?>

                            <?php /*
                            <!-- <div class="form-group">
                                <label class="control-label col-lg-2">Industry Image</label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="uploader__box js-uploader__box l-center-box">
                                                <div class="uploader__contents">
                                                    <label class="button button--secondary" for="fileinput">Industry Images</label>
                                                    <input id="fileinput" class="uploader__file-input" type="file" multiple value="Select Files">
                                                </div>
                                                <input class="button button--big-bottom" type="submit" value="Upload Selected Files">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(isset($industry_images) && !empty($industry_images)){ ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="gallerybg" id="sortable" style="padding-left: 0;">
                                                    <?php foreach ($industry_images as $key => $value) { ?>
                                                        <li class="imagelocation<?php echo $value['id']; ?>" style="display: inline-block;margin-right: 20px;">
                                                            <img src="<?php echo base_url(); ?>upload_file/kjsieit/industrial_visits/images/<?php echo $value['image']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                            <span class="close" style="cursor:pointer;" onclick="delete_image('<?php echo $value['id']; ?>');">X</span>
                                                        </li>
                                                    <?PHP } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div> -->
                            */ ?>

                            <div class="row">
                                <div class="col-md-12">
                                    <?php $this->load->view('kjsieit/industrial_visits/industry_image'); ?>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Publish</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                                </div>
                            </div>
                        </div>
                        <!-- General Info Tab -->
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('kjsieit_bk/industrial_visits/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>

<link href="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>





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

        $('#visit_from').datetimepicker({
            format:'Y-m-d',
            minDate:new Date()
        });

        $('#visit_to').datetimepicker({
            format:'Y-m-d',
            minDate:new Date()
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
            contact_person: {
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
            },
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
            contact_person: {
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
            },
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

    /*var i=$('.verses_length').length;

    $('#add').click(function(){
        i++;
        console.log(i);
        $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" class="form-control" name="moreverses[]"></td><td><input type="text" class="form-control" name="morereference[]"></td><td><input type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" value="X"></td></tr>');
        $(document).on('click','.btn_remove',function(){
            var button_id=$(this).attr("id");
            $('#row'+button_id+'').remove();
        });
    });*/

    /*function delete_image(id) {
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php //echo site_url('kjsieit_bk/industrial_visits/deleteimage');?>",
                data: "id="+id,
                success: function (response) {
                    if(response == 1)
                    {
                        $(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                    }
                }
            });
        }
    }*/

    /*function delete_thumbnail() {
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            var plant_id = '<?php //echo $id; ?>';
            $.ajax({
                type: "POST",
                url: "<?php //echo site_url('vanaspatyam/plants/deletethumbnail');?>",
                data: "plant_id="+plant_id,
                success: function (response) {
                    if(response == 1)
                    {
                        $(".imagethumbnail").remove();
                    }
                }
            });
        }
    }*/
</script>




<script type="text/javascript">
    /*$(document).ready(function() {
        $image_crop = $('#profile_image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 263,
                height: 352,
                // type: 'circle',
            },
            boundary: {
                width: 263,
                height: 352
            }
        });

        $('#croppie_upload_image').on('change', function() {
            var reader = new FileReader();
            var nam;
            if (event.target.value.length > 0) {
                nam = event.target.files[0].name;
                document.getElementById("croppie-profile").value = nam;
                // console.log(nam);

                reader.onload = function(event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function() {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                console.log(this.files);
                $('#uploadimageModal').appendTo("body").modal('show');
            }
        });

        $('.crop_image').click(function(event) {
            $image_crop.croppie('result', {
                circle: false,
                type: 'canvas',
                size: 'viewport'
            }).then(function(response) {
                $('#uploadimageModal').modal('hide');
                $('#croppie-image').attr('src', response);
                $('#croppie_upload_image').attr('value', response);
                $('#croppie-thumbnail').attr('value', response);
            })
        });
    });

    $("#croppie-image").click(function(e) {
        $("#croppie_upload_image").click();
    });*/
</script>

<style type="text/css">.cc{display: block!important;}</style>
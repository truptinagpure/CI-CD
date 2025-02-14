<link href="<?php echo base_url(); ?>assets/layouts/layout/image_upload/styles.imageuploader.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/layouts/layout/image_upload/jquery.imageuploader.js"></script>

<?php error_reporting(0); ?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Student Council</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Student Council</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/student_council/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="student_name" class="control-label col-lg-2">Student Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo set_value('student_name', (isset($post_data['student_name']) ? $post_data['student_name'] : '')); ?>" required data-error=".student_nameerror" maxlength="255">
                                    <div class="student_nameerror error_msg"><?php echo form_error('student_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="designation" class="control-label col-lg-2">Designation <span class="asterisk">*</span></label>&nbsp;&nbsp;
                                <div class="col-lg-10">
                                    <select id="designation" class="form-control select2 select2-hidden-accessible" name="designation" data-error=".designationerror" data-placeholder="-- Please Select Designation --" aria-required="true" tabindex="-1" aria-hidden="true" required>
                                            <option value="">-- Please Select Designation --</option>
                                            <?php               
                                                foreach ($designation as $key => $value) {
                                                ?>
                                                   <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['designation_id']) && $value['id'] == $post_data['designation_id']){ echo 'selected="selected"'; } ?>><?php echo $value['designation']; ?></option>
                                                <?php
                                                
                                                }
                                            ?>
                                    </select>
                                    <div class="designationerror error_msg"><?php echo form_error('designation', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
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
                            <div class="form-group">
                                <label class="control-label col-lg-2">Photo </label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <input type="text" id="croppie-profile" class="croppie-input" name="profile_pic" accept=".png,.jpg,.jpeg,.gif">
                                            <?php if(isset($post_data['photo']) && !empty($post_data['photo'])){ ?>
                                                <img id="croppie-image" class="croppie-img" src="<?php echo base_url(); ?>upload_file/student_council/<?php echo $post_data['photo']; ?>" height="170px" width="170px" />
                                                <input id="croppie_upload_image" type="file" class="croppie-input" placeholder="Photo" capture>
                                            <?php } else { ?>
                                                <input id="croppie_upload_image" type="file" class="croppie-input cc" placeholder="Photo" capture>
                                            <?php } ?>
                                            <input type="hidden" id="croppie-thumbnail" name="thumbnail" class="croppie-input">
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
                            </div>
                            <div class="form-group">
                                <label for="order_by" class="control-label col-lg-2">Order By</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="order_by" name="order_by" value="<?php echo set_value('order_by', (isset($post_data['order_by']) ? $post_data['order_by'] : '')); ?>">
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
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/student_council/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            student_name: {
                required: true,
            },
            designation: {
                required: true,
            },
            academic_year: {
                required: true,
            },
        },
        messages: {
            student_name: {
                required: 'Please enter student name',
            },
            designation: {
                required: 'Please select designation',
            },
            academic_year: {
                required: 'Please select academic year',
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

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/croppie/croppie.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/croppie/custom_croppie.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/croppie/croppie.js"></script> 

<script type="text/javascript">
    $(document).ready(function() {
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
    });
</script>

<style type="text/css">.cc{display: block!important;}</style>

<script type="text/javascript">
    function delete_thumbnail() 
    {
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            var plant_id = '<?php echo $id; ?>';
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/student_council/deletethumbnail');?>",
                data: "plant_id="+plant_id,
                success: function (response) {
                    if(response == 1)
                    {
                        $(".imagethumbnail").remove();
                    }
                }
            });
        }
    }
</script>
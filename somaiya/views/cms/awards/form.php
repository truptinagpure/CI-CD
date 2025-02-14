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
                        <span class="caption-subject font-brown bold uppercase">Edit Awards</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Awards</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/awards/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <?php 
                            $departments = $post_data['department_id']; 
                            $departments_list = explode(',' , $departments);
                        ?>
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="award_title" class="control-label col-lg-2">Award Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="award_title" name="award_title" value="<?php echo set_value('award_title', (isset($post_data['award_title']) ? $post_data['award_title'] : '')); ?>" required data-error=".award_titleerror" maxlength="255">
                                    <div class="award_titleerror error_msg"><?php echo form_error('award_title', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="awarded_by" class="control-label col-lg-2">Awarded By <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="awarded_by" name="awarded_by" value="<?php echo set_value('awarded_by', (isset($post_data['awarded_by']) ? $post_data['awarded_by'] : '')); ?>" required data-error=".awarded_byerror" maxlength="255">
                                    <div class="awarded_byerror error_msg"><?php echo form_error('awarded_by', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type_id" class="control-label col-lg-2">Type <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="type_id" class="form-control select2" name="type_id" required data-error=".typeiderror" data-placeholder="-- Select Type --">
                                        <option value="">-- Select Type --</option>
                                        <?php foreach ($awards_type as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['type_id']) && $post_data['type_id'] == $value['id']){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="typeiderror error_msg"><?php echo form_error('type_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Sub Type</label>
                                <div class="col-lg-10 col-sm-10 sub_type_wrap">
                                    <select class="form-control select2" name="sub_type_id" id="sub_type_id" data-placeholder="-- Select Sub Type --">
                                        <option value="">-- Select Sub Type --</option>
                                    </select>
                                </div>
                                <div class="sub_type_id_error error_msg"><?php echo form_error('sub_type_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                            <div class="form-group">
                                <label for="data[department_id]" class="control-label col-lg-2">Department <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" multiple name="department_id[]" data-placeholder="Select Department" required data-error=".department_codeeerror">
                                        <option value="">Select Department</option>
                                        <?php if(isset($department) && count($department)!=0){ ?>
                                        <?php foreach ($department as $key3 => $data3) { ?>
                                            <option value="<?=$data3['department_id']?>" <?php if(in_array($data3['department_id'],$departments_list)) echo ' selected';?>><?=$data3['Department_Name']?></option>
                                        <?php } } ?>
                                    </select>
                                    <div class="department_codeeerror error_msg"><?php echo form_error('department_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="date" class="control-label col-lg-2">Date <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="datetimepicker" name="date" value="<?php echo set_value('date', (isset($post_data['date']) ? $post_data['date'] : '')); ?>" />
                                    <div class="dateerror error_msg"><?php echo form_error('date', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="award_badge" class="control-label col-lg-2">Award Badge </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="award_badge" name="award_badge" value="<?php echo set_value('award_badge', (isset($post_data['award_badge']) ? $post_data['award_badge'] : '')); ?>" maxlength="255">
                                </div>
                            </div>

                            <?php mk_hWYSItexteditor("description", 'Description', isset($post_data['description']) ? $post_data['description'] : '', 'description'); ?>

                            <div class="form-group">
                                <label class="control-label col-lg-2">Thumbnail Image </label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <input type="text" id="croppie-profile" class="croppie-input" name="profile_pic" accept=".png,.jpg,.jpeg,.gif">
                                            <?php if(isset($post_data['thumbnail']) && !empty($post_data['thumbnail'])){ ?>
                                                <img id="croppie-image" class="croppie-img" src="<?php echo base_url(); ?>upload_file/awards/thumbnail/<?php echo $post_data['thumbnail']; ?>" height="170px" width="170px" />
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
                                <label class="control-label col-lg-2">Multiple Image</label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="uploader__box js-uploader__box l-center-box">
                                                <div class="uploader__contents">
                                                    <label class="button button--secondary" for="fileinput">Plant Images</label>
                                                    <input id="fileinput" class="uploader__file-input" type="file" multiple value="Select Files">
                                                </div>
                                                <input class="button button--big-bottom" type="submit" value="Upload Selected Files">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(isset($award_images) && !empty($award_images)){ ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="gallerybg" id="sortable" style="padding-left: 0;">
                                                    <?php foreach ($award_images as $key => $value) { ?>
                                                        <li class="imagelocation<?php echo $value['id']; ?>" style="display: inline-block;margin-right: 20px;">
                                                            <img src="<?php echo base_url(); ?>upload_file/awards/images/<?php echo $value['image']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                            <span class="close" style="cursor:pointer;" onclick="delete_image('<?php echo $value['id']; ?>');">X</span>
                                                        </li>
                                                    <?PHP } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this awards on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
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
                                <a href="<?php echo base_url('cms/awards/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            type_id: {
                required: true,
            },
            award_title: {
                required: true,
            },
            awarded_by: {
                required: true,
            },
            department_id: {
                required: true,
            },
            date: {
                required: true,
            },
        },
        messages: {
            type_id: {
                required: 'Please select type',
            },
            award_title: {
                required: 'Please enter award name',
            },
            awarded_by: {
                required: 'Please enter awarded by',
            },
            department_id: {
                required: 'Please select department',
            },
            date: {
                required: 'Please select date',
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

    function sub_type_options() {
        var type_id = $("#type_id option:selected").val();
        if(type_id == '')
        {
            $('.sub_type_wrap').html('<select class="form-control select2" name="sub_type_id" id="sub_type_id" data-placeholder="-- Select Sub Type --"><option value="">-- Select Sub Type --</option></select>');
            // $('#sub_category_id').select2();
        }
        else
        {
            $("#zone_id").attr('disabled', 'disabled');
            $.ajax({
                type: "POST",
                dataType: "json",
                url : base_url+"cms/awards/get_subtype_options",
                data: {parent_id : type_id, sub_type_id : '<?php echo (isset($post_data["sub_type_id"]) ? $post_data["sub_type_id"] : ""); ?>'},
                success: function(response) {
                    $("#sub_type_id").removeAttr('disabled');
                    $('.sub_type_wrap').html('<select class="form-control select2" name="sub_type_id" id="sub_type_id" data-error=".sub_type_id_error" data-placeholder="-- Select Sub Type --">'+response+'</select>');
                    $('#sub_type_id').select2();
                }
            });
        }
    }

    $(document).on('change', '#type_id', function (e) {
        sub_type_options();
    });

    sub_type_options();

    (function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());

    $('.cross-btn').click(function(){
        $(this).parent().parent().remove();
    });
</script>

<script type="text/javascript">
    function delete_thumbnail() 
    {
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            var plant_id = '<?php echo $id; ?>';
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/awards/deletethumbnail');?>",
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

    function delete_image(image_id) 
    {
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/awards/deleteimage');?>",
                data: "image_id="+image_id,
                success: function (response) {
                    if(response == 1)
                    {
                        $(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                    }
                }
            });
        }
    }

</script>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">
    $('#datetimepicker').datetimepicker({
        format:'Y-m-d H:i:m',
        // minDate:new Date()
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
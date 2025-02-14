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
                        <span class="caption-subject font-brown bold uppercase">Edit MOU's</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New MOU's</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/mou/'); ?>">Back</a></span>
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
                                <label for="organization_name" class="control-label col-lg-2">Organization Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="organization_name" name="organization_name" value="<?php echo set_value('organization_name', (isset($post_data['organization_name']) ? $post_data['organization_name'] : '')); ?>" required data-error=".organization_nameerror" maxlength="255">
                                    <div class="organization_nameerror error_msg"><?php echo form_error('organization_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="location" class="control-label col-lg-2">Location <span class="asterisk">*</span> <span><a title="Please enter City, State." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="location" name="location" value="<?php echo set_value('location', (isset($post_data['location']) ? $post_data['location'] : '')); ?>" required data-error=".locationerror" maxlength="30">
                                    <div class="locationerror error_msg"><?php echo form_error('location', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="data[department_id]" class="control-label col-lg-2">Department <span><a title="Please select the department from the dropdown, inacse if the MOU belong to any particular department." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" multiple name="department_id[]" data-placeholder="Select Department">
                                        <option value="">Select Department</option>
                                        <?php if(isset($department) && count($department)!=0){ ?>
                                        <?php foreach ($department as $key3 => $data3) { ?>
                                            <option value="<?=$data3['Department_Id']?>" <?php if(in_array($data3['Department_Id'],$departments_list)) echo ' selected';?>><?=$data3['Department_Name']?></option>
                                        <?php } } ?>
                                    </select>
                                    <!-- <div class="department_codeeerror error_msg"><?php echo form_error('department_id', '<label class="error">', '</label>'); ?></div> -->
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="website_link" class="control-label col-lg-2">Website Link</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="website_link" name="website_link" value="<?php echo set_value('website_link', (isset($post_data['website_link']) ? $post_data['website_link'] : '')); ?>" maxlength="255">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="tenure" class="control-label col-lg-2">Tenure </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="tenure" name="tenure" value="<?php echo set_value('tenure', (isset($post_data['tenure']) ? $post_data['tenure'] : '')); ?>" maxlength="255">
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="date" class="control-label col-lg-2">Signed Date <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="datetimepicker" name="date" value="<?php echo set_value('date', (isset($post_data['date']) ? $post_data['date'] : '')); ?>" />
                                    <div class="dateerror error_msg"><?php echo form_error('date', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <?php mk_hWYSItexteditor("description", 'About MOU', isset($post_data['description']) ? $post_data['description'] : '', 'description'); ?>

                            <div class="form-group">
                                <label class="control-label col-lg-2">Thumbnail Image </label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <input type="text" id="croppie-profile" class="croppie-input" name="profile_pic" accept=".png,.jpg,.jpeg,.gif">
                                            <?php if(isset($post_data['thumbnail']) && !empty($post_data['thumbnail'])){ ?>
                                                <img id="croppie-image" class="croppie-img" src="<?php echo base_url(); ?>upload_file/mou/thumbnail/<?php echo $post_data['thumbnail']; ?>" height="170px" width="170px" />
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
                                <label for="chknogoal" class="control-label col-lg-2">Signed Document <span><a title="Please provide S3 URL" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input type="text" class="form-control" id="document" name="document" value="<?php echo set_value('document', (isset($post_data['document']) ? $post_data['document'] : '')); ?>"   >
                                    <?php //if($post_data["document"] == '') { ?>
                                        <!-- <input type="file" class="form-control" name="document" id="document" /> -->
                                    <?php //} else { ?>
                                        <!-- <input type="file" class="form-control" name="document" id="document" /> -->
                                        <!-- <input class="form-control valid" id="image" name="image" type="text" value="<?=base_url()?>upload_file/mou/document/<?=$post_data["document"]?>" aria-invalid="false" readonly> -->
                                    <?php //} ?>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this MOU on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
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
                                <a href="<?php echo base_url('cms/mou/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            organization_name: {
                required: true,
            },
            location: {
                required: true,
            },
            // department_id: {
            //     required: true,
            // },
            date: {
                required: true,
            },
        },
        messages: {
            organization_name: {
                required: 'Please enter organization name',
            },
            location: {
                required: 'Please enter location',
            },
            // department_id: {
            //     required: 'Please select department',
            // },
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
                url: "<?php echo site_url('cms/mou/deletethumbnail');?>",
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
                url: "<?php echo site_url('cms/mou/deletedocument');?>",
                data: "document_id="+image_id,
                success: function (response) {
                    if(response == 1)
                    {
                        $(".document"+image_id).remove(".document"+image_id);
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
                height: 300,
                // type: 'circle',
            },
            boundary: {
                width: 263,
                height: 300
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

    $('#files').change(function()
    {
        var relation_id =  "<?php echo $data['contents_id']; ?>";
        var files = $('#files')[0].files;
        var error = '';
        var form_data = new FormData();
        for(var count = 0; count<files.length; count++)
        {
            var name = files[count].name;
            var extension = name.split('.').pop().toLowerCase();
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','pdf', 'doc', 'docx']) == -1)
            {
                error += "Invalid " + count + " Image File"
            }
            else
            {
                form_data.append("files[]", files[count]);
            }
        }
        if(error == '')
        { 
            $.ajax({
                url:"<?php echo base_url(); ?>admin/upload_donationdoc/"+relation_id, //base_url() return http://localhost/tutorial/codeigniter/
                method:"POST",
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                beforeSend:function()
                {
                    $('#uploaded_images').html("<label class='text-success'>Uploading...</label>");
                },
                success:function(data)
                {
                    $('#uploaded_images').html(data);
                    $('#files').val('');
                }
            })
        }
        else
        {
            alert(error);
        }
    });
</script>

<style type="text/css">.cc{display: block!important;}</style>
<link href="<?php echo base_url(); ?>assets/layouts/layout/image_upload/styles.imageuploader.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/layouts/layout/image_upload/jquery.imageuploader.js"></script>


<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Plant</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Plant</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/plants/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link active" id="generalinfo-tab" data-toggle="tab" href="#generalinfotab" role="tab" aria-controls="generalinfotab" aria-selected="true">General Info</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="benefits-tab" data-toggle="tab" href="#benefitstab" role="tab" aria-controls="benefitstab" aria-selected="false">Benefits</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="verses-tab" data-toggle="tab" href="#versestab" role="tab" aria-controls="versestab" aria-selected="false">Verses</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- General Info Tab -->
                        <div class="tab-pane fade active in" id="generalinfotab" role="tabpanel" aria-labelledby="generalinfo-tab">
                            <div class="form-group">
                                <label for="category_id" class="control-label col-lg-2">Category <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="category_id" class="form-control select2" name="category_id" required data-error=".categoryiderror" data-placeholder="-- Select Category --">
                                        <option value="">-- Select Category --</option>
                                        <?php foreach ($plant_categories as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['category_id']) && $post_data['category_id'] == $value['id']){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="categoryiderror error_msg"><?php echo form_error('category_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Sub Category</label>
                                <div class="col-lg-10 col-sm-10 sub_category_wrap">
                                    <select class="form-control select2" name="sub_category_id" id="sub_category_id" data-error=".sub_category_id_error" data-placeholder="-- Select Sub Category --">
                                        <option value="">-- Select Sub Category --</option>
                                    </select>
                                </div>
                                <div class="sub_category_id_error error_msg"><?php echo form_error('sub_category_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                            <div class="form-group">
                                <label for="color_id" class="control-label col-lg-2">Color</label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="color_id" class="form-control select2" name="color_id" data-error=".color_iderror" data-placeholder="-- Select Color --">
                                        <option value="">-- Select Color --</option>
                                        <?php foreach ($plant_colors as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['color_id']) && $post_data['color_id'] == $value['id']){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="color_iderror error_msg"><?php echo form_error('color_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="botanical_name" class="control-label col-lg-2">Botanical Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="botanical_name" name="botanical_name" value="<?php echo set_value('botanical_name', (isset($post_data['botanical_name']) ? $post_data['botanical_name'] : '')); ?>" required data-error=".botanical_nameerror" maxlength="250">
                                    <div class="botanical_nameerror error_msg"><?php echo form_error('botanical_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="plant_name_in_sanskrit" class="control-label col-lg-2">Name in Sanskrit <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="plant_name_in_sanskrit" name="plant_name_in_sanskrit" value="<?php echo set_value('plant_name_in_sanskrit', (isset($post_data['plant_name_in_sanskrit']) ? $post_data['plant_name_in_sanskrit'] : '')); ?>" required data-error=".plant_name_in_sanskriterror" maxlength="250">
                                    <div class="plant_name_in_sanskriterror error_msg"><?php echo form_error('plant_name_in_sanskrit', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="plant_name_in_english" class="control-label col-lg-2">Name in English <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="plant_name_in_english" name="plant_name_in_english" value="<?php echo set_value('plant_name_in_english', (isset($post_data['plant_name_in_english']) ? $post_data['plant_name_in_english'] : '')); ?>" required data-error=".plant_name_in_englisherror" maxlength="250">
                                    <div class="plant_name_in_englisherror error_msg"><?php echo form_error('plant_name_in_english', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="plant_name_in_marathi" class="control-label col-lg-2">Name in Marathi <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="plant_name_in_marathi" name="plant_name_in_marathi" value="<?php echo set_value('plant_name_in_marathi', (isset($post_data['plant_name_in_marathi']) ? $post_data['plant_name_in_marathi'] : '')); ?>" required data-error=".plant_name_in_marathierror" maxlength="250">
                                    <div class="plant_name_in_marathierror error_msg"><?php echo form_error('plant_name_in_marathi', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="plant_name_in_hindi" class="control-label col-lg-2">Name in Hindi <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="plant_name_in_hindi" name="plant_name_in_hindi" value="<?php echo set_value('plant_name_in_hindi', (isset($post_data['plant_name_in_hindi']) ? $post_data['plant_name_in_hindi'] : '')); ?>" required data-error=".plant_name_in_hindierror" maxlength="250">
                                    <div class="plant_name_in_hindierror error_msg"><?php echo form_error('plant_name_in_hindi', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="plant_name_in_gujarati" class="control-label col-lg-2">Name in Gujarati <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="plant_name_in_gujarati" name="plant_name_in_gujarati" value="<?php echo set_value('plant_name_in_gujarati', (isset($post_data['plant_name_in_gujarati']) ? $post_data['plant_name_in_gujarati'] : '')); ?>" required data-error=".plant_name_in_gujaratierror" maxlength="250">
                                    <div class="plant_name_in_gujaratierror error_msg"><?php echo form_error('plant_name_in_gujarati', '<label class="error">', '</label>'); ?></div>
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
                                <label for="verses" class="control-label col-lg-2">Verses</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="verses" name="verses" value="<?php echo set_value('verses', (isset($post_data['verses']) ? $post_data['verses'] : '')); ?>" data-error=".verseserror">
                                    <div class="verseserror error_msg"><?php echo form_error('verses', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="reference" class="control-label col-lg-2">Reference</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="reference" name="reference" value="<?php echo set_value('reference', (isset($post_data['reference']) ? $post_data['reference'] : '')); ?>" data-error=".referenceerror">
                                    <div class="referenceerror error_msg"><?php echo form_error('reference', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <!-- <label class="control-label col-lg-2">Thumbnail Image</label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="file" name="thumbnail" id="thumbnail" accept=".png,.jpg,.jpeg,.gif">
                                        </div>
                                    </div>
                                    <?php if(isset($post_data['thumbnail']) && !empty($post_data['thumbnail'])){ ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="gallerybg" style="padding-left: 0; margin-top: 20px;">
                                                    <li class="imagethumbnail" style="display: inline-block;">
                                                        <img src="<?php echo base_url(); ?>upload_file/vanaspatyam/plants/thumbnail/<?php echo $post_data['thumbnail']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                        <span class="close" style="cursor:pointer;" onclick="delete_thumbnail();">X</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div> -->

                                <label class="control-label col-lg-2">Thumbnail Image</label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <input type="text" id="croppie-profile" class="croppie-input" name="profile_pic" accept=".png,.jpg,.jpeg,.gif">
                                            <?php if(isset($post_data['thumbnail']) && !empty($post_data['thumbnail'])){ ?>
                                                <img id="croppie-image" class="croppie-img" src="<?php echo base_url(); ?>upload_file/vanaspatyam/plants/thumbnail/<?php echo $post_data['thumbnail']; ?>" height="170px" width="170px" />
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
                                    <?php if(isset($plant_images) && !empty($plant_images)){ ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="gallerybg" id="sortable" style="padding-left: 0;">
                                                    <?php foreach ($plant_images as $key => $value) { ?>
                                                        <li class="imagelocation<?php echo $value['id']; ?>" style="display: inline-block;margin-right: 20px;">
                                                            <img src="<?php echo base_url(); ?>upload_file/vanaspatyam/plants/images/<?php echo $value['image']; ?>" style="vertical-align:middle;" width="80" height="80">
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
                                <label for="latitude" class="control-label col-lg-2">Latitude</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo set_value('latitude', (isset($post_data['latitude']) ? $post_data['latitude'] : '')); ?>" data-error=".latitudeerror">
                                    <div class="latitudeerror error_msg"><?php echo form_error('latitude', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="longitude" class="control-label col-lg-2">Longitude</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo set_value('longitude', (isset($post_data['longitude']) ? $post_data['longitude'] : '')); ?>" data-error=".longitudeerror">
                                    <div class="longitudeerror error_msg"><?php echo form_error('longitude', '<label class="error">', '</label>'); ?></div>
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
                        <!-- Benefits Tab -->
                        <div class="tab-pane fade" id="benefitstab" role="tabpanel" aria-labelledby="benefits-tab">
                            <div class="form-group ">
                                <label for="en" class="control-label col-lg-2">In English</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="en" name="en" data-error=".en_error"><?php echo (isset($post_data['en']) ? $post_data['en'] : ''); ?></textarea>
                                    <div class="en_error error_msg"><?php echo form_error('en', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="hi" class="control-label col-lg-2">In Hindi</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="hi" name="hi" data-error=".hi_error"><?php echo (isset($post_data['hi']) ? $post_data['hi'] : ''); ?></textarea>
                                    <div class="hi_error error_msg"><?php echo form_error('hi', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="mr" class="control-label col-lg-2">In Marathi</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="mr" name="mr" data-error=".mr_error"><?php echo (isset($post_data['mr']) ? $post_data['mr'] : ''); ?></textarea>
                                    <div class="mr_error error_msg"><?php echo form_error('mr', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="gu" class="control-label col-lg-2">In Gujarati</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="gu" name="gu" data-error=".gu_error"><?php echo (isset($post_data['gu']) ? $post_data['gu'] : ''); ?></textarea>
                                    <div class="gu_error error_msg"><?php echo form_error('gu', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>
                        <!-- Benefits Tab -->
                        <!-- Verses Tab -->
                        <div class="tab-pane fade" id="versestab" role="tabpanel" aria-labelledby="verses-tab">
                            <table class="table table-bordered col-md-6" id="dynamic_field">
                                <thead>
                                    <tr>
                                        <th>Verses</th>
                                        <th>References</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($plant_verses) && !empty($plant_verses))
                                        {
                                            foreach ($plant_verses as $key => $value) {
                                    ?>
                                                <tr class="verses_length" id="row<?php echo $key;?>">
                                                    <td>
                                                        <input type="text" class="form-control" value="<?php echo $value['verses']; ?>" name="moreverses[]">
                                                    </td>
                                                    <td>
                                                        <input type="text" value="<?php echo $value['reference']; ?>" class="form-control" name="morereference[]">
                                                    </td>
                                                    <td>
                                                        <input type="button" name="remove" id="cross<?php echo $key;?>" class="btn btn-danger btn_remove cross-btn" value="X">
                                                    </td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    ?>
                                    <tr class="verses_length">
                                        <td>
                                            <input type="text" class="form-control"  name="moreverses[]">
                                        </td>
                                        <td>
                                            <input type="text"  class="form-control" name="morereference[]">
                                        </td>
                                        <td>
                                            <input type="button" name="add" id="add" class="btn btn-primary" value="+">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Verses Tab -->
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/plants/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            category_id: {
                required: true,
            },
            botanical_name: {
                required: true,
            },
            plant_name_in_sanskrit: {
                required: true,
            },
            plant_name_in_english: {
                required: true,
            },
            plant_name_in_marathi: {
                required: true,
            },
            plant_name_in_hindi: {
                required: true,
            },
            plant_name_in_gujarati: {
                required: true,
            },
			latitude: {
                required: true,
            },
            longitude: {
                required: true,
            },
        },
        messages: {
            category_id: {
                required: 'Please select category',
            },
            botanical_name: {
                required: 'Please enter botanical name',
            },
            plant_name_in_sanskrit: {
                required: 'Please enter plant name in sanskrit',
            },
            plant_name_in_english: {
                required: 'Please enter plant name in english',
            },
            plant_name_in_marathi: {
                required: 'Please enter plant name in marathi',
            },
            plant_name_in_hindi: {
                required: 'Please enter plant name in hindi',
            },
            plant_name_in_gujarati: {
                required: 'Please enter plant name in gujarati',
            },
			latitude: {
                required: 'Please enter plant latitude',
            },
            longitude: {
                required: 'Please enter plant longitude',
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

    function sub_category_options() {
        var category_id = $("#category_id option:selected").val();
        if(category_id == '')
        {
            $('.sub_category_wrap').html('<select class="form-control select2" name="sub_category_id" id="sub_category_id" data-error=".sub_category_id_error" data-placeholder="-- Select Sub Category --"><option value="">-- Select Sub Category --</option></select>');
            // $('#sub_category_id').select2();
        }
        else
        {
            $("#zone_id").attr('disabled', 'disabled');
            $.ajax({
                type: "POST",
                dataType: "json",
                url : base_url+"cms/plants/get_subcategory_options",
                data: {parent_id : category_id, sub_category_id : '<?php echo (isset($post_data["sub_category_id"]) ? $post_data["sub_category_id"] : ""); ?>'},
                success: function(response) {
                    $("#sub_category_id").removeAttr('disabled');
                    $('.sub_category_wrap').html('<select class="form-control select2" name="sub_category_id" id="sub_category_id" data-error=".sub_category_id_error" data-placeholder="-- Select Sub Category --">'+response+'</select>');
                    $('#sub_category_id').select2();
                }
            });
        }
    }

    $(document).on('change', '#category_id', function (e) {
        sub_category_options();
    });

    sub_category_options();

    (function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());

    $('.cross-btn').click(function(){
        $(this).parent().parent().remove();
    });

    var i=$('.verses_length').length;

    $('#add').click(function(){
        i++;
        console.log(i);
        $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" class="form-control" name="moreverses[]"></td><td><input type="text" class="form-control" name="morereference[]"></td><td><input type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" value="X"></td></tr>');
        $(document).on('click','.btn_remove',function(){
            var button_id=$(this).attr("id");
            $('#row'+button_id+'').remove();
        });
    });

    function delete_image(image_id) {
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/plants/deleteimage');?>",
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

    function delete_thumbnail() {
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            var plant_id = '<?php echo $id; ?>';
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/plants/deletethumbnail');?>",
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


<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/global/plugins/croppie/croppie.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/global/plugins/croppie/custom_croppie.css" />
<script type="text/javascript" src="<?=base_url()?>assets/global/plugins/croppie/croppie.js"></script> 

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
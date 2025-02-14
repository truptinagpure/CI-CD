<div class="row">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($banner_data['image_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Banner</span>
                    <?php
                    // $img_error = $this->session->flashdata('banner_image');
                    // $banner_data['error'] = $img_error['error'];
                     } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Banner</span>
                    <?php
                        //$banner_data = $this->session->flashdata('banner_image');
                     } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/banner/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php
                        if($this->session->userdata('user_id') == 1 && $this->session->userdata['sess_institute_id'] == 50)
                        {
                            $selected_institute    = array();

                            if(!empty($banner_data['institute_id']))
                            {
                                $selected_institute = explode(',' , $banner_data['institute_id']);
                            }

                            ?>
                            <div class="form-group">
                                <label for="institute" class="control-label col-lg-2">Institute </label>
                                <div class="col-lg-10">
                                    <select id="institute" class="form-control select2" name="institute[]" data-placeholder="Please Select Institute" multiple>
                                        <?php if(isset($institute_list) && count($institute_list)!=0){ ?>
                                        <?php foreach ($institute_list as $key => $value) { ?>
                                            <option value="<?php echo $value['INST_ID']; ?>" <?php if( isset($selected_institute) && in_array($value['INST_ID'], $selected_institute)) echo"selected"; ?> > <?php echo $value['INST_NAME']; ?></option>
                                        <?php } } ?>
                                    </select>
                                    <div class="instituteerror error_msg"><?php echo form_error('institute', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        
                        <div class="form-group ">
                            <label for="banner_text" class="control-label col-lg-2">Banner Title&nbsp;<span><a title="This is used to add text title on banner" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="banner_text" name="banner_text" value="<?php echo set_value('banner_text', (isset($banner_data['banner_text']) ? $banner_data['banner_text'] : '')); ?>" data-error=".banner_texterror" maxlength="250">
                                <div class="banner_texterror error_msg"><?php echo form_error('banner_text', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <?php //mk_hWYSItexteditor("banner_text", 'banner_text', isset($banner_data['banner_text']) ? $banner_data['banner_text'] : '', 'banner_text'); ?>

                        <div class="form-group ">
                            <label for="banner_sub_text" class="control-label col-lg-2">Banner Sub Text&nbsp;<span><a title="This is used to add sub text on banner" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="banner_sub_text" name="banner_sub_text" value="<?php echo set_value('banner_sub_text', (isset($banner_data['banner_sub_text']) ? $banner_data['banner_sub_text'] : '')); ?>" data-error=".banner_sub_texterror" maxlength="250">
                                <div class="banner_sub_texterror error_msg"><?php echo form_error('banner_sub_text', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <?php
                        // echo "<pre>";
                        // print_r($banner_data);
                        // exit();
                        ?>
                        <?php if($institute_id == 50) { ?>
                            <div class="form-group ">
                            <label for="banner_sub_title" class="control-label col-lg-2">Banner Sub Title </label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="banner_sub_title" name="banner_sub_title" value="<?php echo set_value('banner_sub_title', (isset($banner_data['banner_sub_title']) ? $banner_data['banner_sub_title'] : '')); ?>" data-error=".banner_sub_titleerror" maxlength="250">
                                <div class="banner_sub_titleerror error_msg"><?php echo form_error('banner_sub_title', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="form-group ">
                            <label for="banner_alt_text" class="control-label col-lg-2">Banner Alt Text </label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="banner_alt_text" name="banner_alt_text" value="<?php echo set_value('banner_alt_text', (isset($banner_data['banner_alt_text']) ? $banner_data['banner_alt_text'] : '')); ?>" data-error=".banner_alt_texterror" maxlength="250">
                                <div class="banner_alt_texterror error_msg"><?php echo form_error('banner_alt_text', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="banner_url" class="control-label col-lg-2">Banner Url </label>
                            <div class="col-lg-10">
                                <input type="url" class="form-control" id="banner_url" name="banner_url" value="<?php echo set_value('banner_url', (isset($banner_data['banner_url']) ? $banner_data['banner_url'] : '')); ?>" data-error=".banner_urlerror" maxlength="250">
                                <div class="banner_urlerror error_msg"><?php echo form_error('banner_url', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="banner_url_button_text" class="control-label col-lg-2">Banner Url Button Text</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="banner_url_button_text" name="banner_url_button_text" value="<?php echo set_value('banner_url_button_text', (isset($banner_data['banner_url_button_text']) ? $banner_data['banner_url_button_text'] : '')); ?>" data-error=".banner_url_button_texterror" maxlength="250">
                                <div class="banner_url_button_texterror error_msg"><?php echo form_error('banner_url_button_text', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="banner_url_target" class="control-label col-lg-2">Banner Url Target</label>
                            <div class="col-lg-10">
                                <select name="banner_url_target" id="banner_url_target" class="form-control">
                                    <option value="">Please Select</option>
                                    <option value="_self" <?php if(isset($banner_data['banner_url_target']) && $banner_data['banner_url_target'] == '_self'){ echo 'selected';}  ?>>Self</option>
                                    <option value="_blank" <?php if(isset($banner_data['banner_url_target']) && $banner_data['banner_url_target'] == '_blank'){ echo 'selected';}  ?>>Blank</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="banner_image" class="control-label col-lg-2">Banner image<span class="asterisk">*</span>&nbsp;<span><a title="Upload image dimensions are 1024 pixels (width) x 450 pixels (height). And size of file should be less than 2mb." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10">
                                <?php //$this->load->view('cms/banner/banner_image'); ?>
                                <?php 
                                    $banner_image_url         = $banner_default_image_url = "";
                                    $delete_image                = false;
                                    $banner_id                   = isset($banner_data['image_id']) ? $banner_data['image_id'] : '';
                                    if(isset($banner_data['image']) && !empty($banner_data['image'])) 
                                    {
                                        $delete_image        = true;
                                        $banner_image_url = base_url().'upload_file/banner_images/'.$banner_data['image']; 
                                        ?>
                                        <img id="banner-uploaded-image" src="<?php echo base_url().'upload_file/banner_images/'.$banner_data['image']; ?>" style="vertical-align:middle;" width="100px" height="100px">
                                        <?php
                                            if($delete_image){ ?>
                                                <a class="btn btn-sm btn-danger" id="delete_image" href="javascript:void(0);" title="Delete" onclick="delete_image('<?php echo $banner_id; ?>');" ><i class="icon-trash"></i></a>
                                        <?php }
                                    }

                                    ?>
                                        <input type="file" class="form-control" id="banner_image" name="banner_image" value="<?php echo set_value('banner_image', (isset($banner_image_url) ? $banner_image_url : '')); ?>" data-error=".banner_imageerror" maxlength="250" accept=".png,.jpg,.jpeg,.gif" <?php if(isset($banner_data['image']) && !empty($banner_data['image'])) { echo 'style = "display:none;"';} ?> onchange="ValidateSize(this)" >
                                    
                                    <div class="banner_imageerror error_msg"><?php echo form_error('banner_image', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mobile_banner_image" class="control-label col-lg-2">Mobile Banner image<span><a title="Upload image dimensions are 320 pixels (width) x 150 pixels (height). And size of file should be less than 2mb." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10">
                                <?php 
                                    $mobile_banner_image_url         = $mobile_banner_default_image_url = "";
                                    $mobile_delete_image             = false;
                                    $mobile_banner_id                = isset($banner_data['image_id']) ? $banner_data['image_id'] : '';
                                    if(isset($banner_data['mobile_image']) && !empty($banner_data['mobile_image'])) 
                                    {
                                        $mobile_delete_image        = true;
                                        $mobile_banner_image_url    = base_url().'upload_file/banner_images/'.$banner_data['mobile_image']; 
                                        ?>
                                        <img id="mobile_banner-uploaded-image" src="<?php echo base_url().'upload_file/banner_images/'.$banner_data['mobile_image']; ?>" style="vertical-align:middle;" width="100px" height="100px">
                                        <?php
                                            if($mobile_delete_image){ ?>
                                                <a class="btn btn-sm btn-danger" id="mobile_delete_image" href="javascript:void(0);" title="Delete" onclick="delete_mobile_image('<?php echo $mobile_banner_id; ?>');" ><i class="icon-trash"></i></a>
                                        <?php }
                                    }

                                    ?>
                                        <input type="file" class="form-control" id="mobile_banner_image" name="mobile_banner_image" value="<?php echo set_value('mobile_banner_image', (isset($mobile_banner_image_url) ? $mobile_banner_image_url : '')); ?>" data-error=".mobile_banner_imageerror" maxlength="250" accept=".png,.jpg,.jpeg,.gif" <?php if(isset($banner_data['mobile_image']) && !empty($banner_data['mobile_image'])) { echo 'style = "display:none;"';} ?> onchange="ValidatemobileSize(this)" >


                                    
                                    <div class="mobile_banner_imageerror error_msg"><?php echo form_error('mobile_banner_image', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="valid_upto" class="control-label col-lg-2">Valid Upto<span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" id="valid_upto" name="valid_upto" class="form-control" required value="<?php if(isset($banner_data['valid_upto'])) { echo $banner_data['valid_upto']; } ?>"/>
                                
                                <div class="valid_uptoerror error_msg"><?php echo form_error('valid_upto', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="row_order" class="control-label col-lg-2">Order By</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="row_order" name="row_order" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo set_value('row_order', (isset($banner_data['row_order']) ? $banner_data['row_order'] : '')); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this banner on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($banner_data['public']) && $banner_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($banner_data['public']) ? $banner_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/banner/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="banner_demo">
                    <div class="row">
                        <div class="form-group ">
                            <label for="banner_demo" class="control-label col-lg-2">View Sample Banner</label>
                            <div class="col-lg-10">
                                <!-- <img src="<?php //echo base_url(); ?>upload_file/banner_images/sample_banner.jpg" class="img-responsive"> -->
                                <img src="<?php echo base_url(); ?>assets/somaiya_com/img/homeBanners/sample_banner.jpg" class="img-responsive">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                           
    </div>
</div>

<script type="text/javascript">
    // $('#chooseFile').bind('change', function() {
    //     alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
    // });
    
    function ValidateSize(file) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        var fileName = document.getElementById("banner_image").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
            $("#banner_image-error").css("display","none");
        }else{
            alert("Only jpg, jpeg and png files are allowed!");
            $(file).val('');
        }   
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
            $(file).val(''); //for clearing with Jquery
        } else {

        }
    }

    function ValidatemobileSize(file) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        var fileName = document.getElementById("mobile_banner_image").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
            $("#mobile_banner_image-error").css("display","none");
        }else{
            alert("Only jpg, jpeg and png files are allowed!");
            $(file).val('');
        }   
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
            $(file).val(''); //for clearing with Jquery
        } else {

        }
    }
</script>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">

    $('#valid_upto').datetimepicker({
        format:'Y-m-d',
        minDate:new Date()
    });

</script>

<script type="text/javascript">
    $(document).ready(function() 
    {
        /* public */
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
</script>

<script type="text/javascript">
    $("#formval").validate({
        rules: {
            //banner_text: {
            //    required: true,
            //},
            banner_image: {
                required: true,
            },
            valid_upto: {
                required: true,
            },
        },
        messages: {
            //banner_text: {
            //    required: 'Please enter banner title',
            //},
            banner_image: {
                required: 'Please add banner image',
            },
            valid_upto: {
                required: 'Please select valid upto date',
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                //$(placement).append(error)
                $(placement).html(error)
            } else {
                error.insertAfter(element);
            }
        },
    });
</script>

<script type="text/javascript">
    
/*$(document).ready(function(){
    $("#delete_image").click(function(){
        alert("The paragraph was clicked.");
    });
});*/


    function delete_image(banner_id) {
        var banner_default_image_url = '<?php echo $banner_default_image_url; ?>';
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/banner/deleteimage');?>",
                data: "banner_id="+banner_id,
                success: function (response) {
                    if(response == 1)
                    {
                        $('#delete_image').addClass('hidden');
                        $('#banner-uploaded-image').addClass('hidden');
                        $('#banner_image').css('display','block');
                        
                        //$('#banner_image_src').attr('src', banner_default_image_url);
                        //$(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                    }
                }
            });
        }
    }

    function delete_mobile_image(banner_id) {
        var mobile_banner_default_image_url = '<?php echo $mobile_banner_default_image_url; ?>';
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/banner/deletemobileimage');?>",
                data: "banner_id="+banner_id,
                success: function (response) {
                    if(response == 1)
                    {
                        $('#mobile_delete_image').addClass('hidden');
                        $('#mobile_banner-uploaded-image').addClass('hidden');
                        $('#mobile_banner_image').css('display','block');
                        
                    }
                }
            });
        }
    }

</script>
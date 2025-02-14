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
                        <span class="caption-subject font-brown bold uppercase">Edit MMG Fields</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New MMG Fields</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/mmg/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mmg_name" class="control-label col-lg-2">MMG Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="mmg_name" class="form-control select2" name="mmg_name" required data-error=".mmg_nameerror" data-placeholder="-- Select MMG --">
                                        <option value="">-- Select MMG --</option>
                                        <?php foreach ($mmg_fields as $key => $value) { ?>
                                            <option value="<?php echo $value['mmg_id']; ?>" <?php if(isset($post_data['MMG_Fied_Id']) && $post_data['MMG_Fied_Id'] == $value['mmg_id']){ echo 'selected="selected"'; } ?>><?php echo $value['MMG_Fied_Name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="mmg_nameerror error_msg"><?php echo form_error('mmg_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group" style="display:none">
                                <label class="control-label col-lg-2">Grid Image <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <input type="text" id="croppie-profile" class="croppie-input" name="grid_image" accept=".png,.jpg,.jpeg,.gif">
                                            <?php if(isset($post_data['grid_image']) && !empty($post_data['grid_image'])){ ?>
                                                <img id="croppie-image" class="croppie-img" src="<?php echo base_url(); ?>upload_file/mmg/images/<?php echo $post_data['grid_image']; ?>" height="170px" width="170px" />
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
                                <label class="control-label col-lg-2">Banner Image / Video <span class="asterisk">*</span></label>
                                    <div class="col-lg-10 col-sm-10">
                                    <?php error_reporting(0);
                                        if(isset($post_data) && is_array($post_data) && count($post_data)){ $i=1; 
                                            $ext = pathinfo($post_data['banner_image_video'], PATHINFO_EXTENSION);
                                            if($ext!='mp4' and $post_data['banner_image_video']!='') {  //echo "m here in img";
                                    ?>
                                        <ul class="image_banner_<?php echo $post_data['id'] ?>">
                                            <li id="item-<?php echo $post_data['id'] ?>">
                                                <img src="<?php echo base_url(); ?>upload_file/mmg/images/<?php echo $post_data['banner_image_video']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/mmg/delete_banner_image/'.$post_data["id"]); ?>');">X</a>
                                            </li>
                                        </ul>
                                    <?php } elseif($ext=='mp4') { //echo "m here in video";?>

                                        <ul class="image_banner_<?php echo $post_data['id'] ?>">
                                            <li id="item-<?php echo $post_data['id'] ?>">
                                                <!-- <img src="<?php echo base_url(); ?>upload_file/video_icon.png" style="vertical-align:middle;" width="80" height="80"> -->
                                                <video class="respimg" width="320" height="240" controls>
                                                    <source src="<?php echo base_url(); ?>upload_file/mmg/images/<?=$post_data['banner_image_video']?>" type="video/<?=$ext?>"></source>
                                                </video>
                                                <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/mmg/delete_banner_image/'.$post_data["id"]); ?>');">X</a>
                                            </li>
                                        </ul>
                                    <?php } ?>

                                    <?php if($post_data['banner_image_video']=='') {?>

                                    <div class="form-group">
                                        <div class="col-lg-10 col-sm-10">
                                            <input type="file" name="banner_image_video" id="banner_image_video" accept=".png,.jpg,.jpeg,.gif,.mp4,.mpeg,.mpg,.avi,.mov" required>
                                        </div>
                                    </div>

                                    <?php } } ?>
                                </div>
                            </div>

                            <?php $this->load->view('cms/mmg/mmg_links'); ?>

                            <?php mk_hWYSItexteditor("introduction", 'Introduction', isset($post_data['introduction']) ? $post_data['introduction'] : '', 'introduction'); ?>
                            <?php mk_hWYSItexteditor("content", 'Content', isset($post_data['content']) ? $post_data['content'] : '', 'content'); ?>
                            <input type="hidden" name="mmg_id" value="<?php echo $id; ?>">
                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this MMG on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
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
                                <a href="<?php echo base_url('cms/mmg/') ?>" class="btn btn-default" type="button">Cancel</a>
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
                mmg_name: {
                    required: true,
                },
            },
            messages: {
                mmg_name: {
                    required: 'Please select MMG',
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
            submitHandler: function(form){
                var mmgid                       = '<?php echo $post_data[id]; ?>';
                var mmg_field_id                = $('#mmg_name').val();
                var check_result                = true;
                $('.mmg_nameerror').html('');

                function check_mmg(mmgid, mmg_field_id) {
                    var check_mmg_result   = true;
                    $.ajax({
                        type: "POST",
                        url: base_url+"cms/mmg/ajax_check_mmg",
                        async: false,
                        data: { mmgid : mmgid, mmg_field_id : mmg_field_id},
                        success: function(response){
                            if(response == '')
                            {
                                check_mmg_result = false;
                            }
                        }
                    });
                    return check_mmg_result;
                }

                check_result = check_mmg(mmgid, mmg_field_id);

                if(check_result == false)
                {
                    $('.mmg_nameerror').html('MMG for this institute is already exist.');
                    return false;
                }
                else
                {
                    form.submit();
                }
            }
        });

    (function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());

    $('.cross-btn').click(function(){
        $(this).parent().parent().remove();
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
                width: 350,
                height: 200,
                // type: 'circle',
            },
            boundary: {
                width: 350,
                height: 200
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

<style type="text/css">
.cc{display: block!important;}
.croppie-input {
    overflow: visible;
     font-size: 14px!important; 
     background: none!important; 
     padding: 0px!important; 
     border-radius: 0px!important; 
     margin: 0px!important; 
}
</style>
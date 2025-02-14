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
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/mmgfields/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="mmg_name" class="control-label col-lg-2">MMG_Fied_Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="MMG_Fied_Name" name="MMG_Fied_Name" value="<?php echo set_value('MMG_Fied_Name', (isset($post_data['MMG_Fied_Name']) ? $post_data['MMG_Fied_Name'] : '')); ?>" required data-error=".MMG_Fied_Nameerror" maxlength="255">
                                    <div class="MMG_Fied_Nameerror error_msg"><?php echo form_error('MMG_Fied_Name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
<div class="form-group ">
                            <label class="control-label col-lg-2">Keywords</label>
                            <div class="col-lg-10"><br />
                                <input type="text" name ="programme_keywords" value="<?=$post_data['programme_keywords']?>" data-role="tagsinput" />
                            </div>
                        </div>
                            <div class="form-group">
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
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/mmgfields/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

    $("#manage_form").validate({
            rules: {
                MMG_Fied_Name: {
                    required: true,
                },
            },
            messages: {
                MMG_Fied_Name: {
                    required: 'Please enter MMG name',
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
                form.submit();
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
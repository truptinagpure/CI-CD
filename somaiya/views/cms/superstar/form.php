<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php //$institute = $_SESSION['inst_id'] ?>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php 
                        if(isset($data['superstar_id'])) {      ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Superstar</span>
                        <?php } else { ?>
                            <span class="caption-subject font-brown bold uppercase">Add Superstar</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/superstar/'); ?>">Back </a></span>
            </div>  
            
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="superstar_name" class="control-label col-lg-2">Superstar Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="superstar_name" name="superstar_name" value="<?php echo set_value('superstar_name', (isset($post_data['superstar_name']) ? $post_data['superstar_name'] : '')); ?>" required data-error=".superstar_nameerror" maxlength="255">
                                    <div class="superstar_nameerror error_msg"><?php echo form_error('superstar_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="designation" class="control-label col-lg-2">Designation <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="designation" name="designation" value="<?php echo set_value('designation', (isset($post_data['designation']) ? $post_data['designation'] : '')); ?>" required data-error=".designationerror" maxlength="255">
                                    <div class="designationerror error_msg"><?php echo form_error('designation', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <!-- <div class="form-group ">
                                <label for="year" class="control-label col-lg-2">Year <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="datepicker" name="year" value="<?php echo set_value('year', (isset($post_data['year']) ? $post_data['year'] : '')); ?>" />
                                    <div class="dateerror error_msg"><?php echo form_error('year', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div> -->

                            <div class="form-group ">
                                <label for="achievements" class="control-label col-lg-2">Achievements <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="achievements" name="achievements" value="<?php echo set_value('achievements', (isset($post_data['achievements']) ? $post_data['achievements'] : '')); ?>" required data-error=".achievementserror" maxlength="255">
                                    <div class="achievementserror error_msg"><?php echo form_error('achievements', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-lg-2">Thumbnail Image </label>
                                <div class="col-lg-10 col-sm-10">
                                    <div class="row"> 
                                        <div class="col-md-12">
                                            <input type="text" id="croppie-profile" class="croppie-input" name="profile_pic" accept=".png,.jpg,.jpeg,.gif">
                                            <?php if(isset($post_data['thumbnail']) && !empty($post_data['thumbnail'])){ ?>
                                                <img id="croppie-image" class="croppie-img" src="<?php echo base_url(); ?>upload_file/superstar/<?php echo $post_data['thumbnail']; ?>" height="170px" width="170px" />
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

                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this superstar on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
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
                                <a href="<?php echo base_url('cms/superstar/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>                           
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

<script type="text/javascript">
    $("#datepicker").datepicker({
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        /* public */

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
</script>

<script type="text/javascript">
    $("#manage_form").validate({
            rules: {
                superstar_name: {
                    required: true,
                },
                designation: {
                    required: true,
                },
                achievements: {
                    required: true,
                },
            },
            messages: {
                superstar_name: {
                    required: 'Please enter superstar name',
                },
                designation: {
                    required: 'Please enter designation',
                },
                achievements: {
                    required: 'Please enter achievements',
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



    function delete_thumbnail() 
    {
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            var plant_id = '<?php echo $id; ?>';
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/superstar/delete_superstar');?>",
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
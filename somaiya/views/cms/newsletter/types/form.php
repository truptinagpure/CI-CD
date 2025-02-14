<?php mk_use_uploadbox($this); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($id) && !empty($id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Newsletter Type</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Newsletter Type</span>
                       <?php } ?>
                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/newsletter_type/listing/'); ?>">Back </a></span>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                            <div class="form-group ">
                                <label for="title" class="control-label col-lg-2">Title <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', (isset($post_data['title']) ? $post_data['title'] : '')); ?>" required data-error=".titleerror" maxlength="250">
                                    <div class="titleerror error_msg"><?php echo form_error('title', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="description" class="control-label col-lg-2">Description</label>
                                <div class="col-lg-10 tooltipText">
                                    <textarea class="form-control" id="description" name="description" data-error=".descriptionerror"><?php echo isset($post_data['description']) ? $post_data['description'] : ''; ?></textarea>
                                    <div class="descriptionerror error_msg"><?php echo form_error('description', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
							
							<?php mk_hWYSItexteditor("team_voice",_l('Team voice ',$this),isset($post_data['team_voice'])?$post_data['team_voice']:'','required'); ?>
							
                            <?php mk_hurl_upload("image", _l('Image', $this), isset($post_data['image']) ? $post_data['image'] : '',"avatar"); ?>

                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Publish <span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this newsletter type on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input type="hidden" name="insta_id" value="<?php echo $insta_id; ?>">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/newsletter_type/listing/'); ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>

    <?php mk_popup_uploadfile(_l('Upload Avatar',$this), "avatar", $base_url."upload_image/20/"); ?>

    <script type="text/javascript">
        $(document).ready(function() {
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

        $("#manage_form").validate({
            rules: {
                title: {
                    required: true,
                },
            },
            messages: {
                title: {
                    required: 'Please enter title',
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
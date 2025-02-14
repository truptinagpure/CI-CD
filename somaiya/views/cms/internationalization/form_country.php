<?php mk_use_uploadbox($this); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($id) && !empty($id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Country</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Country</span>
                       <?php } ?>
                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/internationalization/countries/'); ?>">Back </a></span>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                            <div class="form-group">
                                <label for="university_for" class="control-label col-lg-2">University For <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="university_for" class="form-control" name="university_for" required data-error=".university_forerror">
                                        <option value="">Select University For</option>
                                        <option value="SVV" <?php if($post_data['university_for'] == 'SVV') echo"selected"; ?>>Somaiya Vidyavihar</option>
                                        <option value="SVU" <?php if($post_data['university_for'] == 'SVU') echo"selected"; ?>>Somaiya Vidyavihar University</option>
                                        <!-- <option value="SAV" <?php //if($post_data['university_for'] == 'SAV') echo"selected"; ?>>Consultancy</option> -->
                                    </select>
                                    <div class="university_forerror error_msg"><?php echo form_error('university_for', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            
                            <div class="form-group ">
                                <label for="country" class="control-label col-lg-2">Country <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="country" name="country" value="<?php echo set_value('country', (isset($post_data['country']) ? $post_data['country'] : '')); ?>" required data-error=".countryerror" maxlength="300">
                                    <div class="countryerror error_msg"><?php echo form_error('country', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <?php mk_hurl_upload("marker", _l('Marker', $this), isset($post_data['marker']) ? $post_data['marker'] : '',"avatar"); ?>

                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Publish</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/internationalization/countries') ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>

    <?php mk_popup_uploadfile(_l('Marker',$this), "avatar", $base_url."upload_image/20/"); ?>

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
                country: {
                    required: true,
                }
            },
            messages: {
                country: {
                    required: 'Please enter country name',
                }
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
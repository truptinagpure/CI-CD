<?php mk_use_uploadbox($this); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($id) && !empty($id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit University</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New University</span>
                       <?php } ?>
                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/internationalization/universities/'); ?>">Back </a></span>
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
                            <div class="form-group">
                                <label for="country_id" class="control-label col-lg-2">Country <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="country_id" class="form-control" name="country_id" required data-error=".countryerror">
                                        <option value="">Select Country</option>
                                        <?php foreach ($countries as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['country_id']) && $post_data['country_id'] == $value['id']){ echo 'selected="selected"'; } ?>><?php echo $value['country']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="countryerror error_msg"><?php echo form_error('country_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="university_name" class="control-label col-lg-2">University Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="university_name" name="university_name" value="<?php echo set_value('university_name', (isset($post_data['university_name']) ? $post_data['university_name'] : '')); ?>" required data-error=".universitynameerror">
                                    <div class="universitynameerror error_msg"><?php echo form_error('university_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="university" class="control-label col-lg-2">University Address <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="university" name="university" value="<?php echo set_value('university', (isset($post_data['university']) ? $post_data['university'] : '')); ?>" required data-error=".universityerror">
                                    <div class="universityerror error_msg"><?php echo form_error('university', '<label class="error">', '</label>'); ?></div>

                                    <!-- <button type="button" id="getCords" onClick="codeAddress();">getLat&Long</button> -->
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="lat" class="control-label col-lg-2">Latitude <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="lat" name="lat" value="<?php echo set_value('lat', (isset($post_data['lat']) ? $post_data['lat'] : '')); ?>" required data-error=".laterror">
                                    <div class="laterror error_msg"><?php echo form_error('lat', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="long" class="control-label col-lg-2">Longitude <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="long" name="long" value="<?php echo set_value('long', (isset($post_data['long']) ? $post_data['long'] : '')); ?>" required data-error=".longerror">
                                    <div class="longerror error_msg"><?php echo form_error('long', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="url" class="control-label col-lg-2">Url</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="url" name="url" value="<?php echo set_value('url', (isset($post_data['url']) ? $post_data['url'] : '')); ?>" data-error=".urlerror">
                                    <div class="urlerror error_msg"><?php echo form_error('url', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <?php mk_hurl_upload("logo", _l('Logo', $this), isset($post_data['logo']) ? $post_data['logo'] : '',"avatar"); ?>

                            <div class="form-group ">
                                <label for="url" class="control-label col-lg-2">Description</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" id="description" name="description" data-error=".descriptionerror"><?php echo (isset($post_data['description']) ? $post_data['description'] : ''); ?></textarea>
                                    <div class="descriptionerror error_msg"><?php echo form_error('description', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

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
                                    <a href="<?php echo base_url('cms/internationalization/universities') ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>

    <?php mk_popup_uploadfile(_l('Logo',$this), "avatar", $base_url."upload_image/20/"); ?>

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjMjMfnJpwkdfMv6g4duCMHGlrx0SBqGQ&libraries=places"></script>

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
                country_id: {
                    required: true,
                },
                university_for: {
                    required: true,
                },
                university_name: {
                    required: true,
                },
                university: {
                    required: true,
                },
                lat: {
                    required: true,
                },
                long: {
                    required: true,
                }
            },
            messages: {
                country_id: {
                    required: 'Please select country',
                },
                university_for: {
                    required: 'Please select University for',
                },
                university_name: {
                    required: 'Please enter university name',
                },
                university: {
                    required: 'Please enter university address',
                },
                lat: {
                    required: 'Please enter proper university name to get latitude',
                },
                long: {
                    required: 'Please enter proper university name to get longitude',
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

        function initialize() {
            var input = document.getElementById('university');
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                var lat = place.geometry.location.lat();
                var long = place.geometry.location.lng();
               
                // alert('latitude'+' '+lat+','+ 'longitude'+' '+long);
                // document.getElementById('university').value = place.name;
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('long').value = place.geometry.location.lng();
                //alert("This function is working!");
                //alert(place.name);
               // alert(place.address_components[0].long_name);

            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
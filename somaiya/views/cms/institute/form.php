<?php error_reporting(0); ?>
<?php mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Institute</span>
                    <?php } else { ?>
                         <!-- <span class="caption-subject font-brown bold uppercase">Add New Institute</span> -->
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/institute/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="INST_NAME" class="control-label col-lg-2">Institute Name </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="INST_NAME" name="INST_NAME" value="<?php echo set_value('INST_NAME', (isset($post_data['INST_NAME']) ? $post_data['INST_NAME'] : '')); ?>" maxlength="255" readonly>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="INST_SHORTNAME" class="control-label col-lg-2">Institute Shortname </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="INST_SHORTNAME" name="INST_SHORTNAME" value="<?php echo set_value('INST_SHORTNAME', (isset($post_data['INST_SHORTNAME']) ? $post_data['INST_SHORTNAME'] : '')); ?>" maxlength="255" readonly>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="institute_url" class="control-label col-lg-2">Institute URL </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="institute_url" name="institute_url" value="<?php echo set_value('institute_url', (isset($post_data['institute_url']) ? $post_data['institute_url'] : '')); ?>" maxlength="255">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="INSTITUTE_LOCATION" class="control-label col-lg-2">Institute Location </label>
                                <div class="col-lg-10 col-sm-10">
                                    <input type="text" class="form-control" id="INSTITUTE_LOCATION" name="INSTITUTE_LOCATION" value="<?php echo set_value('INSTITUTE_LOCATION', (isset($post_data['INSTITUTE_LOCATION']) ? $post_data['INSTITUTE_LOCATION'] : '')); ?>" maxlength="255" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="INSTITUTE_TYPE" class="control-label col-lg-2">Institute Type </label>
                                <div class="col-lg-10 col-sm-10">
                                    <select class="form-control" id="INSTITUTE_TYPE" name="INSTITUTE_TYPE">
                                        <option value="">-- Select Type --</option>
                                        <option value="COLLEGE" <?php if(!empty($post_data['INSTITUTE_TYPE'] && $post_data['INSTITUTE_TYPE'] == 'COLLEGE')) { echo "selected"; } ?>>COLLEGE</option>
                                        <option value="SCHOOL" <?php if(!empty($post_data['INSTITUTE_TYPE'] && $post_data['INSTITUTE_TYPE'] == 'SCHOOL')) { echo "selected"; } ?>>SCHOOL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="INSTITUTE_CATEGORY" class="control-label col-lg-2">Institute Category </label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="INSTITUTE_CATEGORY" class="form-control select2" name="INSTITUTE_CATEGORY" data-placeholder="-- Select Category --">
                                        <option value="">-- Select Category --</option>
                                        <?php foreach ($areaofstudy as $key => $value) { ?>
                                            <option value="<?php echo $value['AREA_OF_STUDY_ID']; ?>" <?php if(isset($post_data['INSTITUTE_CATEGORY']) && $post_data['INSTITUTE_CATEGORY'] == $value['AREA_OF_STUDY_ID']){ echo 'selected="selected"'; } ?>><?php echo $value['AREA_OF_STUDY_NAME']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="grievance_user_access" class="control-label col-lg-2">Grievance user access</label>
                                <div class="col-lg-10 col-sm-10">
                                    <select class="form-control" id="grievance_user_access" name="grievance_user_access">
                                        <option value="">-- Select Option --</option>
                                        <option value="Y" <?php if(!empty($post_data['grievance_user_access'] && $post_data['grievance_user_access'] == 'Y')) { echo "selected"; } ?>>Public</option>
                                        <option value="N" <?php if(!empty($post_data['grievance_user_access'] && $post_data['grievance_user_access'] == 'N')) { echo "selected"; } ?>>Only active member</option>
                                    </select>
                                </div>
                            </div>
                            
                            <?php 

                                mk_hurl_upload("institute_campus_image",_l('Image',$this),isset($post_data['institute_campus_image'])?$post_data['institute_campus_image']:'',"institute_campus_image", '');
                                mk_hWYSItexteditor("institute_description", 'Description', isset($post_data['institute_description']) ? $post_data['institute_description'] : '', 'institute_description'); 
                            ?>

                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Institute Enabled</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/institute/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<?php
    mk_popup_uploadfile(_l('Upload Image',$this),"institute_campus_image",$base_url."upload_image/20/");
?>
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
</script>
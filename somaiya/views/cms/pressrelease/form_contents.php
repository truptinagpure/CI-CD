<?php mk_use_uploadbox($this); ?>
   <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($contents_id) && !empty($contents_id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Pressrelease Content</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Pressrelease Content</span>
                       <?php } ?>
                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/pressrelease_content/pressreleasecontents/'.$relation_id); ?>">Back </a></span>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                            <?php error_reporting(0); ?>
                            <input type="hidden" name="contents_id" value="<?php echo $data['contents_id']; ?>">
                            <input type="hidden" name="data_type" value="pressrelease">                                
                            <div class="form-group">
                                <label for="language_id" class="control-label col-lg-2">Language <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="language_id" class="form-control" name="language_id" required data-error=".languageerror">
                                        <option value="">-- Select Language --</option>
                                        <?php foreach ($languages as $key => $value) { ?>
                                        <option value="<?php echo $value['language_id']; ?>" <?php if(isset($data['language_id']) && $data['language_id'] == $value['language_id']){ echo 'selected="selected"'; } ?>><?php echo $value['language_name']; ?></option>
                                        <?php } ?>
                                    </select><?php //echo $value['language_id']; ?>
                                    <div class="languageerror error_msg"><?php echo form_error('language_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="title" class="control-label col-lg-2">Title <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', (isset($data['title']) ? $data['title'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                    <div class="nameerror error_msg"><?php echo form_error('title', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <?php
                                mk_hWYSItexteditor("description",_l('Description',$this),isset($data['description'])?$data['description']:'','');

                                mk_hidden("relation_id",isset($relation_id)?$relation_id:0);
                            ?>



                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Publish</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($data['public']) && $data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($data['public']) ? $data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div> 

                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/pressrelease_content/pressreleasecontents/'.$relation_id) ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>
<?php
    mk_popup_uploadfile(_l('Upload Image',$this),"image",$base_url."upload_image/20/");
?>


<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">
    $('#datetimepicker1').datetimepicker({
        format:'Y-m-d H:i',
    });
</script>

<script type="text/javascript">
    $('#datetimepicker2').datetimepicker({
        format:'Y-m-d H:i',
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
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
        $("#formval").validate({ 
            rules: {
                language_id: {
                    required: true,
                },
                title: {
                    required: true,
                },
            },
            messages: {
                language_id: {
                    required: 'Please select language',
                },
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
            submitHandler: function(form){
                var contents_id                 = '<?php echo $data[contents_id]; ?>';
                var relation_id                 = '<?php echo $relation_id; ?>';
                var language_id                 = $('#language_id').val();
                var formname                    = "pressrelease";
                var check_result                = true;
                $('.languageerror').html('');

                function check_language(contents_id, language_id) {
                    var check_language_result   = true;
                    $.ajax({
                        type: "POST",
                        url: base_url+"admin/ajax_check_common_language",
                        async: false,
                        data: {contents_id : contents_id, relation_id : relation_id, language_id : language_id, formname : formname},
                        success: function(response){
                            if(response == '')
                            {
                                check_language_result = false;
                            }
                        }
                    });
                    return check_language_result;
                }

                check_result = check_language(contents_id, language_id);

                if(check_result == false)
                {
                    $('.languageerror').html('Pressrelease content for this language is already exist.');
                    return false;
                }
                else
                {
                    form.submit();
                }
            }
        });
</script>
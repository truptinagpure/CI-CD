<link href="<?php echo base_url(); ?>assets/layouts/layout/image_upload/styles.imageuploader.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/layouts/layout/image_upload/jquery.imageuploader.js"></script>


<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Faq</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Faq</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/faq/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="category_id" class="control-label col-lg-2">Category <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="category_id" class="form-control select2" name="category_id" required data-error=".categoryiderror" data-placeholder="-- Select Category --">
                                        <option value="">-- Select Category --</option>
                                        <?php foreach ($faq_categories as $key => $value) { ?>
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
                            <div class="form-group ">
                                <label for="question" class="control-label col-lg-2">Question <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="question" name="question" value="<?php echo set_value('question', (isset($post_data['question']) ? $post_data['question'] : '')); ?>" required data-error=".questionerror" maxlength="255">
                                    <div class="questionerror error_msg"><?php echo form_error('question', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <?php mk_hWYSItexteditor_required("answer", 'Answer <span class="asterisk">*</span>', isset($post_data['answer']) ? $post_data['answer'] : '', 'answer'); ?>
                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this FAQ on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
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
                                <a href="<?php echo base_url('cms/faq/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            question: {
                required: true,
            },
            answer: {
                required: true,
            },
        },
        messages: {
            category_id: {
                required: 'Please select category',
            },
            question: {
                required: 'Please enter question',
            },
            answer: {
                required: 'Please enter answer',
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
                url : base_url+"cms/faq/get_subcategory_options",
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
</script>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($review_id) && !empty($review_id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit <?php echo $pub_lect_title; ?> Review</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New <?php echo $pub_lect_title; ?> Review</span>
                       <?php } ?>
                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/public_lectures/reviews/'.$lecture_id); ?>">Back </a></span>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                            <input type="hidden" name="review_id" value="<?php echo $review_id; ?>">
                            <input type="hidden" name="lecture_id" value="<?php echo $lecture_id; ?>">
                            <?php /* ?>
                            <div class="form-group ">
                                <label for="name" class="control-label col-lg-2">Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                    <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <?php */ ?>
                            <div class="form-group ">
                                <label for="review" class="control-label col-lg-2">Review <span class="asterisk">*</span></label>
                                <div class="col-lg-10 tooltipText">
                                    <textarea class="form-control" id="review" name="review" data-error=".reviewerror" required><?php echo isset($post_data['review']) ? $post_data['review'] : ''; ?></textarea>
                                    <div class="reviewerror error_msg"><?php echo form_error('review', '<label class="error">', '</label>'); ?></div>
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
                                    <a href="<?php echo base_url('cms/public_lectures/reviews/'.$lecture_id) ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>

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
                name: {
                    required: false,
                },
                review: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Please enter name',
                },
                review: {
                    required: 'Please enter review',
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
            }
        });
    </script>
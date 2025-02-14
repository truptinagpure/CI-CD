
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($id) && !empty($id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Newsletter</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Newsletter</span>
                       <?php } ?>
                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/newsletter/listing/'); ?>">Back </a></span>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                            <div class="form-group">
                                <label for="designation_id" class="control-label col-lg-2">Newsletter Type <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="newsletter_type_id" class="form-control select2" name="newsletter_type_id" required data-error=".newslettertypeiderror" data-placeholder="-- Select Newsletter Type --">
                                        <option value="">-- Select Newsletter Type --</option>
                                        <?php foreach ($newsletter_types as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['newsletter_type_id']) && $post_data['newsletter_type_id'] == $value['id']){ echo 'selected="selected"'; } ?>><?php echo $value['title']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="newslettertypeiderror error_msg"><?php echo form_error('newsletter_type_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="start_date_time" class="control-label col-lg-2">Year <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="year" name="year" value="<?php echo set_value('year', (isset($post_data['year']) ? $post_data['year'] : '')); ?>" required data-error=".yearerror" />
                                    <div class="yearerror error_msg"><?php echo form_error('year', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="heading" class="control-label col-lg-2">Heading <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="heading" name="heading" value="<?php echo set_value('heading', (isset($post_data['heading']) ? $post_data['heading'] : '')); ?>" required data-error=".headingerror" maxlength="250">
                                    <div class="headingerror error_msg"><?php echo form_error('heading', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <?php mk_hWYSItexteditor("content",_l('Content',$this),isset($post_data['content'])?$post_data['content']:'','required'); ?>
                            <div class="form-group ">
                                <label for="document" class="control-label col-lg-2">PDF Link</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="document" name="document" value="<?php echo set_value('document', (isset($post_data['document']) ? $post_data['document'] : '')); ?>" data-error=".documenterror">
                                    <div class="documenterror error_msg"><?php echo form_error('document', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Publish <span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this newsletter on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input type="hidden" name="insta_id" value="<?php echo $insta_id; ?>">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/newsletter/listing/') ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>

    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet"/>
    <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

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


        $("#year").datepicker( {
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years"
        }).on('changeDate', function(e){
            $(this).datepicker('hide');
        });

        $("#manage_form").validate({
            rules: {
                newsletter_type_id: {
                    required: true,
                },
                year: {
                    required: true,
                },
                heading: {
                    required: true,
                },
            },
            messages: {
                newsletter_type_id: {
                    required: 'Please select newsletter type',
                },
                year: {
                    required: 'Please select year',
                },
                heading: {
                    required: 'Please enter heading',
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
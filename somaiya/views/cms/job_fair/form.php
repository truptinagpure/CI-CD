<?php //mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php $institute = $insta_id; ?>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Jobs Fair</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Jobs Fair</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/job_fair/'); ?>">Back </a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="jobs_fair_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group">
                            <label for="department_id" class="control-label col-lg-2">Title<span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
								<input type="text" class="form-control" id="job_fair_title" name="job_fair_title" value="<?php echo set_value('job_fair_title', (isset($post_data['title']) ? $post_data['title'] : '')); ?>" required data-error=".job_fair_titleerror" maxlength="250">
                                <div class="job_fair_titleerror error_msg"><?php echo form_error('job_fair_title', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="description" class="control-label col-lg-2">Description<span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="description" required name="description" data-error=".description_error"><?php echo (isset($post_data['description']) ? $post_data['description'] : ''); ?></textarea>
                                <div class="description_error error_msg"><?php echo form_error('description', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
             
                       <div class="row">
                            <div class="col-md-12">
                                <?php $this->load->view('cms/job_fair/jobs_fair_image'); ?>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="pdf_url" class="control-label col-lg-2">Pdf url<span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="url" class="form-control" id="pdf_url" name="pdf_url" value="<?php echo set_value('pdf_url', (isset($post_data['pdf_url']) ? $post_data['pdf_url'] : '')); ?>" data-error=".pdf_urlerror" maxlength="250" required>
                                <div class="pdf_urlerror error_msg"><?php echo form_error('pdf_url', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="jobs_fair_year" class="control-label col-lg-2">Year<span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="jobs_fair_year" name="jobs_fair_year" value="<?php echo set_value('jobs_fair_year', (isset($post_data['year']) ? $post_data['year'] : '')); ?>" data-error=".jobs_fair_yearerror" maxlength="250" required>
                                <div class="jobs_fair_yearerror error_msg"><?php echo form_error('jobs_fair_year', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this job fair on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/job_fair/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    $("#jobs_fair_form").validate({
        rules: {
            job_fair_title: {
                required: true,
            },
            description: {
                required: true,
            },
            pdf_url: {
                required: true,
            },
            jobs_fair_year: {
                required: true,
            },
            // image: {
            //     required: true,
            // },
        },
        messages: {
            job_fair_title: {
                required: 'Please enter title',
            },
            description: {
                required: 'Please enter description',
            },
            pdf_url: {
                required: 'Please enter pdf url',
            },
            jobs_fair_year: {
                required: 'Please enter year',
            },
            // image: {
            //     required: 'Please enter image',
            // },
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


    /*(function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());

    $('.cross-btn').click(function(){
        $(this).parent().parent().remove();
    });*/

</script>
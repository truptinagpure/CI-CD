
                                
<?php //mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($smh_dir_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Social Media</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Social Media</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/smh_dir/'); ?>">Back </a></span>
            </div>
            
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="smh_dir_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <input type="hidden" id="smh_dir_id" name="smh_dir_id" value="<?php if(isset($smh_dir_data['smh_dir_id'])){ echo $smh_dir_data['smh_dir_id']; }?>">

                        <div class="form-group ">
                            <label for="smh_dir_name" class="control-label col-lg-2">Platform Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="smh_dir_name" name="smh_dir_name" value="<?php echo set_value('smh_dir_name', (isset($smh_dir_data['smh_dir_name']) ? $smh_dir_data['smh_dir_name'] : '')); ?>" required data-error=".smh_dir_nameerror" maxlength="250" onchange="check_social_name()">
                                <div class="smh_dir_nameerror error_msg"><?php echo form_error('smh_dir_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="smh_dir_name" class="control-label col-lg-2">Social Icon <span class="asterisk">*</span><span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Copy Social Icon code from Note as per required social media"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="social_icon" name="social_icon" value="<?php echo set_value('social_icon', (isset($smh_dir_data['social_icon']) ? $smh_dir_data['social_icon'] : '')); ?>" required data-error=".social_iconerror" maxlength="250">
                                <div class="social_iconerror error_msg"><?php echo form_error('social_icon', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>  

                        <div class="row notes">
                            <div class="col-md-2"></div>
                            <div class="col-md-9">
                                <p class="notes-heading">Note:</p>
                                <ul class="notes-list">
                                    <li>For Youtube  use 
                                        <code>&lt;i class="fa fa-youtube-play" aria-hidden="true"&gt;&lt;/i&gt;</code> as icon
                                    </li>
                                     <li>For Google use <code>&lt;i class="fa fa-google" aria-hidden="true"&gt;&lt;/i&gt;</code> as icon
                                    </li>
                                     <li>For Instagram use <code>&lt;i class="fa fa-instagram" aria-hidden="true"&gt;&lt;/i&gt;</code> as icon
                                    </li>
                                     <li>For Facebook use <code>&lt;i class="fa fa-facebook" aria-hidden="true"&gt;&lt;/i&gt;</code> as icon</li>
                                     <li>For Linkedin use <code>&lt;i class="fa fa-linkedin" aria-hidden="true"&gt;&lt;/i&gt;</code> as icon
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="public" class="control-label col-lg-2">Publish&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this social media platform on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($smh_dir_data['public']) && $smh_dir_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($smh_dir_data['public']) ? $smh_dir_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/smh_dir/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    function check_social_name()
    {

        var smh_dir_name = $("#smh_dir_name").val();
        var smh_dir_id = $("#smh_dir_id").val();

        if(smh_dir_name != "")
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'cms/smh_dir/check_social_name'; ?>",
                //async: false,
                data: {smh_dir_name : smh_dir_name, smh_dir_id : smh_dir_id},
                success: function(response){

                    var fetchResponse = JSON.parse(response);
                    if(fetchResponse.status == "failure")
                    {
                        $('.smh_dir_nameerror').html(fetchResponse.message);
                        $('.smh_dir_nameerror').addClass("error");
                        $('.smh_dir_nameerror').css("display", "block");
                        var check_social_name_result = "false";
                    }
                    else
                    {
                        $('.smh_dir_nameerror').html('');
                        $('.smh_dir_nameerror').removeClass("error");
                        //$('.smh_dir_nameerror').css("display", "none");
                        var check_social_name_result = "true";
                    }
                    return check_social_name_result;
                }
            });
        }
    }

    $("#smh_dir_form").validate({
        rules: {
            smh_dir_name: {
                required: true,
            },
            social_icon: {
                required: true,
            },
        },
        messages: {
            smh_dir_name: {
                required: 'Please enter Social Media Name',
            }, 
            social_icon: {
                required: 'Please enter Social Icon',
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
            var smh_dir_name = $("#smh_dir_name").val();
            var smh_dir_id = $("#smh_dir_id").val();

            if(smh_dir_name != "")
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'cms/smh_dir/check_social_name'; ?>",
                    //async: false,
                    data: {smh_dir_name : smh_dir_name, smh_dir_id : smh_dir_id},
                    success: function(response){

                        var fetchResponse = JSON.parse(response);
                        if(fetchResponse.status == "failure")
                        {
                            $('.smh_dir_nameerror').html(fetchResponse.message);
                            $('.smh_dir_nameerror').addClass("error");
                            $('.smh_dir_nameerror').css("display", "block");
                            var check_social_name_result = "false";
                        }
                        else
                        {
                            form.submit();
                        }
                    }
                });
            }
        }
    });

</script>
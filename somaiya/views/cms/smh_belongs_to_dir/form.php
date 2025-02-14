<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($smh_subcategory_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Social Media Subcategory</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Social Media Subcategory</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/smh_belongs_to_dir/'); ?>">Back </a></span>
            </div>
            
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="social__media_subcategory_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">

                        <input type="hidden" id="smh_belongs_to_id" name="smh_belongs_to_id" value="<?php if(isset($smh_subcategory_data['smh_belongs_to_id'])){ echo $smh_subcategory_data['smh_belongs_to_id']; }?>">

                        <div class="form-group ">
                            <label for="smh_belongs_to_name" class="control-label col-md-3">Subcategory Name <span class="asterisk">*</span>&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="This will be linked with the category under institute. (Example, under KJSCE - Category: Student Team, Subcategory: Bloombox)"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="smh_belongs_to_name" name="smh_belongs_to_name" value="<?php echo set_value('smh_belongs_to_name', (isset($smh_subcategory_data['smh_belongs_to_name']) ? $smh_subcategory_data['smh_belongs_to_name'] : '')); ?>" required data-error=".smh_belongs_to_nameerror" maxlength="250" onchange="check_subcategory_name()">
                                <div class="smh_belongs_to_nameerror error_msg"><?php echo form_error('smh_belongs_to_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="smh_belongs_to_type_name" class="control-label col-md-3">Category Name <span class="asterisk">*</span></label>
                            <div class="col-md-5">
                                <select id="smh_belongs_to_type_name" name="smh_belongs_to_type_name" required data-error=".smh_belongs_to_type_nameerror" class="form-control">
                                    <option value="">-- Please select category --</option>
                                    <?php

                                    


                                        if(!empty($smh_subcategory_data['smh_belongs_to_type']))
                                        {
                                            $smh_subcategory_data['smh_belongs_to_type'] = explode(',', $smh_subcategory_data['smh_belongs_to_type']);
                                        }

                                        foreach ($smh_type_list_by_institute as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['smh_belongs_to_type_id']; ?>" <?php if(isset($smh_subcategory_data['smh_belongs_to_type']) && !empty($smh_subcategory_data['smh_belongs_to_type']) && in_array($value['smh_belongs_to_type_id'], $smh_subcategory_data['smh_belongs_to_type'])){ echo 'selected="selected"'; } ?>><?php echo $value['smh_belongs_to_type_name']; ?></option>
                                        <?php
                                        
                                        }
                                    ?>
                                </select>
                                <div class="smh_belongs_to_type_nameerror error_msg"><?php echo form_error('smh_belongs_to_type_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>  

                        <div class="form-group ">
                            <label for="public" class="control-label col-md-3">Publish&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this subcategory on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-md-5">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($smh_subcategory_data['public']) && $smh_subcategory_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($smh_subcategory_data['public']) ? $smh_subcategory_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/smh_belongs_to_dir/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    function check_subcategory_name()
    {

        var smh_belongs_to_name = $("#smh_belongs_to_name").val();
        var smh_belongs_to_id = $("#smh_belongs_to_id").val();

        if(smh_belongs_to_name != "")
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'cms/smh_belongs_to_dir/check_subcategory_name'; ?>",
                //async: false,
                data: {smh_belongs_to_name : smh_belongs_to_name, smh_belongs_to_id : smh_belongs_to_id},
                success: function(response){

                    var fetchResponse = JSON.parse(response);
                    if(fetchResponse.status == "failure")
                    {
                        $('.smh_belongs_to_nameerror').html(fetchResponse.message);
                        $('.smh_belongs_to_nameerror').addClass("error");
                        $('.smh_belongs_to_nameerror').css("display", "block");
                        var check_smh_belongs_to_name_result = "false";
                    }
                    else
                    {
                        $('.smh_belongs_to_nameerror').html('');
                        $('.smh_belongs_to_nameerror').removeClass("error");
                        //$('.smh_dir_nameerror').css("display", "none");
                        var check_smh_belongs_to_name_result = "true";
                    }
                    return check_smh_belongs_to_name_result;
                }
            });
        }
    }

    $("#social__media_subcategory_form").validate({
        rules: {
            smh_belongs_to_name: {
                required: true,
            },
            smh_belongs_to_type_name: {
                required: true,
            },
        },
        messages: {
            smh_belongs_to_name: {
                required: 'Please enter Sub Category name',
            },
            smh_belongs_to_type_name: {
                required: 'Please enter Category name',
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
            var smh_belongs_to_name = $("#smh_belongs_to_name").val();
            var smh_belongs_to_id = $("#smh_belongs_to_id").val();

            

            if(smh_belongs_to_name != "")
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'cms/smh_belongs_to_dir/check_subcategory_name'; ?>",
                    //async: false,
                    data: {smh_belongs_to_name : smh_belongs_to_name, smh_belongs_to_id : smh_belongs_to_id},
                    success: function(response){

                        var fetchResponse = JSON.parse(response);
                        if(fetchResponse.status == "failure")
                        {
                            $('.smh_belongs_to_nameerror').html(fetchResponse.message);
                            $('.smh_belongs_to_nameerror').addClass("error");
                            $('.smh_belongs_to_nameerror').css("display", "block");
                            var check_smh_belongs_to_name_result = "false";
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
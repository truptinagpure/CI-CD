<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($smh_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Map Social Media Handle</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Map Social Media Handle</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/smh/'); ?>">Back </a></span>
            </div>
            
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="smh_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="hidden" id="smh_id" name="smh_id" value="<?php if(isset($smh_data['id'])){ echo $smh_data['id']; }?>">

                            <div class="form-group ">
                                <label for="admin_member" class="control-label col-lg-4">Admin Member Name <span class="asterisk">*</span></label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="admin_member" name="admin_member" value="<?php if(isset($smh_data['admin_member'])){ echo $smh_data['admin_member']; }?>">

                                    <div class="admin_membererror error_msg"><?php echo form_error('admin_member', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>

                    <?php
                        $smh_member_type = array(array( "name" => "student"), array( "name" =>"staff"), array( "name" =>"faculty"));
                    ?>

                    <div class="col-lg-6">
                        <div class="form-group ">
                            <label for="admin_member_type" class="control-label col-lg-4">Admin Member Type <span class="asterisk">*</span></label>
                            <div class="col-lg-8">
                                <select id="admin_member_type" name="admin_member_type" required data-error=".admin_member_typeerror" class="form-control">
                                    <option value="">-- Please select member type --</option>
                                    <?php
                                        if(!empty($smh_data['admin_member_type']))
                                        {
                                            $smh_data['admin_member_type'] = explode(',', $smh_data['admin_member_type']);
                                        }

                                        foreach ($smh_member_type as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['name']; ?>" <?php if(isset($smh_data['admin_member_type']) && !empty($smh_data['admin_member_type']) && in_array($value['name'], $smh_data['admin_member_type'])){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                        
                                        }
                                    ?>
                                </select>
                                <div class="admin_member_typeerror error_msg"><?php echo form_error('admin_member_type', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>

                    </div>

                <div class="row ">
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="contact_number" class="control-label col-lg-4">Contact Number <span class="asterisk">*</span></label>
                                <div class="col-lg-8">
                                    <input type="tel" id="contact_number" name="contact_number" maxlength="10" minlength="10" pattern="[0-9]+" value="<?php if(isset($smh_data['contact_number'])){ echo $smh_data['contact_number']; }?>" class="form-control">

                                    <div class="contact_numbererror error_msg"><?php echo form_error('contact_number', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div> 
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="email_id" class="control-label col-lg-4">Email Id <span class="asterisk">*</span></label>
                                <div class="col-lg-8">
                                    <input type="email" id="email_id" name="email_id" value="<?php if(isset($smh_data['email_id'])){ echo $smh_data['email_id']; }?>" class="form-control">

                                    <div class="email_iderror error_msg"><?php echo form_error('email_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="row ">
                           
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="smh_belongs_to_type_id" class="control-label col-lg-4">Category Name <span class="asterisk">*</span></label>
                                <div class="col-lg-8">
                                    <select id="smh_belongs_to_type_id" name="smh_belongs_to_type_id" required data-error=".smh_belongs_to_type_iderror" class="form-control">
                                        <option value="">-- Please select category --</option>
                                        <?php
                                            if(!empty($smh_data['smh_belongs_to_type_id']))
                                            {
                                                $smh_data['smh_belongs_to_type_id'] = explode(',', $smh_data['smh_belongs_to_type_id']);
                                            }

                                            foreach ($smh_type_list_by_institute as $key => $value) {
                                            ?>
                                               <option value="<?php echo $value['smh_belongs_to_type_id']; ?>" <?php if(isset($smh_data['smh_belongs_to_type_id']) && !empty($smh_data['smh_belongs_to_type_id']) && in_array($value['smh_belongs_to_type_id'], $smh_data['smh_belongs_to_type_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['smh_belongs_to_type_name']; ?></option>
                                            <?php
                                            
                                            }
                                        ?>
                                    </select>
                                    <div class="smh_belongs_to_type_iderror error_msg"><?php echo form_error('smh_belongs_to_type_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div> 
                        </div>

                         <div class="col-lg-6">
                        <div class="form-group ">
                            <label for="smh_belongs_to_id" class="control-label col-lg-4">Subcategory Name <span class="asterisk">*</span></label>
                            <div class="col-lg-8">
                                <select id="smh_belongs_to_id" name="smh_belongs_to_id" required data-error=".smh_belongs_to_iderror" class="form-control">
                                    <?php
                                    $smh_belongs_to_type_id = '';
                                    if(isset($smh_data['smh_belongs_to_type_id'][0]))
                                    {
                                        $smh_belongs_to_type_id = $smh_data['smh_belongs_to_type_id'][0];
                                    }
                                    
                                    if($smh_belongs_to_type_id == 1) // 1 for institute, its get data from master tables
                                    {
                                        ?>
                                        <option value="">-- Please select Institute --</option>
                                        <?php
                                        foreach ($smh_belongs_to_list_by_type as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['institute_id']; ?>" <?php if(isset($smh_data['smh_belongs_to_id']) && !empty($smh_data['smh_belongs_to_id']) && $value['institute_id'] == $smh_data['smh_belongs_to_id']) { echo 'selected="selected"'; } ?>><?php echo $value['institute_name']; ?></option>
                                            <?php

                                        }
                                    }
                                    elseif($smh_belongs_to_type_id == 2) // 2 for department, its get data from master tables
                                    {
                                        ?>
                                        <option value="">-- Please select Department --</option>
                                        <?php
                                        foreach ($smh_belongs_to_list_by_type as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['Department_Id']; ?>" <?php if(isset($smh_data['smh_belongs_to_id']) && !empty($smh_data['smh_belongs_to_id']) && $value['Department_Id'] == $smh_data['smh_belongs_to_id']) { echo 'selected="selected"'; } ?>><?php echo $value['Department_Name']; ?></option>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        ?>
                                        <option value="">-- Please select Subcategory --</option>
                                        <?php
                                        foreach ($smh_belongs_to_list_by_type as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value['smh_belongs_to_id']; ?>" <?php if(isset($smh_data['smh_belongs_to_id']) && !empty($smh_data['smh_belongs_to_id']) && $value['smh_belongs_to_id'] == $smh_data['smh_belongs_to_id']) { echo 'selected="selected"'; } ?>><?php echo $value['smh_belongs_to_name']; ?></option>
                                            <?php
                                        }
                                    }

                                    ?>
                                    <?php
                                    /*                                        ?>
                                    <option value="">-- Please select Subcategory --</option>
                                    <?php
                                        if(!empty($smh_data['smh_belongs_to_id']))
                                        {
                                            $smh_data['smh_belongs_to_id'] = explode(',', $smh_data['smh_belongs_to_id']);
                                        }

                                        foreach ($smh_belongs_to_list_by_type as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['smh_belongs_to_id']; ?>" <?php if(isset($smh_data['smh_belongs_to_id']) && !empty($smh_data['smh_belongs_to_id']) && in_array($value['smh_belongs_to_id'], $smh_data['smh_belongs_to_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['smh_belongs_to_name']; ?></option>
                                        <?php
                                        
                                        } */
                                    ?>
                                </select>
                                <div class="smh_belongs_to_iderror error_msg"><?php echo form_error('smh_belongs_to_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                    </div>


                        <?php
                        // echo "<pre>";
                        //                 print_r($smh_data);

                        //                 echo "<br>================<br>";
                        //                 echo "belongs to type id = ".$smh_data['smh_belongs_to_type_id'][0]."<br>";
                        //                 print_r($smh_belongs_to_list_by_type);
                        //                 exit();
                        ?>

                     <div class="row ">
                        <div class="col-lg-6">
                                <div class="form-group ">
                                    <label for="smh_dir_id" class="control-label col-lg-4">Social Media <span class="asterisk">*</span></label>
                                    <div class="col-lg-8">
                                        <select id="smh_dir_id" name="smh_dir_id" required data-error=".smh_dir_iderror" class="form-control">
                                            <option value="">-- Please select social media --</option>
                                            <?php
                                                if(!empty($smh_data['smh_dir_id']))
                                                {
                                                    $smh_data['smh_dir_id'] = explode(',', $smh_data['smh_dir_id']);
                                                }

                                                foreach ($smh_social_list as $key => $value) {
                                                ?>
                                                   <option value="<?php echo $value['smh_dir_id']; ?>" <?php if(isset($smh_data['smh_dir_id']) && !empty($smh_data['smh_dir_id']) && in_array($value['smh_dir_id'], $smh_data['smh_dir_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['smh_dir_name']; ?></option>
                                                <?php
                                                
                                                }
                                            ?>
                                        </select>
                                        <div class="smh_dir_iderror error_msg"><?php echo form_error('smh_dir_id', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="social_url" class="control-label col-lg-4">Social Url <span class="asterisk">*</span></label>
                                <div class="col-lg-8">
                                    <input type="url" id="social_url" name="social_url" value="<?php if(isset($smh_data['social_url'])){ echo $smh_data['social_url']; }?>" class="form-control">

                                    <div class="social_urlerror error_msg"><?php echo form_error('social_url', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>

                    </div>
                        <!-- <div class="form-group ">
                            <label for="purpose" class="control-label col-lg-4">purpose<span class="asterisk">*</span></label>
                            <div class="col-lg-8">
                                <textarea rows="5" cols="10" name="purpose" id="purpose" value="<?php // if(isset($smh_data['purpose'])){ echo $smh_data['purpose']; }?>"></textarea>                                
                                <div class="purposeerror error_msg"><?php //echo form_error('purpose', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div> -->

                        <?php mk_hWYSItexteditor("purpose", 'Purpose <span><a title="Please explain it in 4 to 5 lines, why do you need this platform and purpose of it ?" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>', isset($smh_data['purpose']) ? $smh_data['purpose'] : '', 'purpose'); ?>

                        <div class="form-group ">
                            <label for="public" class="control-label col-lg-4">Publish&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this social media handles on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-8">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($smh_data['public']) && $smh_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($smh_data['public']) ? $smh_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/smh/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    
    $("#smh_form").validate({
        rules: {
            admin_member: {
                required: true,
            },
            admin_member_type: {
                required: true,
            },
            contact_number: {
                required: true,
            },
            email_id: {
                required: true,
            },
            smh_dir_id: {
                required: true,
            },
            smh_belongs_to_type_id: {
                required: true,
            },
            smh_belongs_to_id: {
                required: true,
            },
            social_url: {
                required: true,
            },
        },
        messages: {
            admin_member: {
                required: 'Please enter admin name',
            },
            admin_member_type: {
                required: 'Please select admin member type',
            },
            contact_number: {
                required: 'Please enter contact number',
            },
            email_id: {
                required: 'Please enter email id',
            },
            smh_dir_id: {
                required: 'Please select social media',
            },
            smh_belongs_to_type_id: {
                required: 'Please select category',
            },
            smh_belongs_to_id: {
                required: 'Please select subcategory',
            },
            social_url: {
                required: 'Please enter social media url',
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
           
            var smh_category    = $("#smh_belongs_to_type_id").val();
            var smh_subcategory = $("#smh_belongs_to_id").val();
            var smh_platform    = $("#smh_dir_id").val();
            var smh_id          = $("#smh_id").val();

            //console.log("on submit function called");
            //return false;
            //if(smh_category != "" && smh_subcategory != "" && smh_platform != "")
            //{
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'cms/smh/check_cat_subcat_socialplatform_rel'; ?>",
                    //async: false,
                    data: {smh_id : smh_id, smh_category : smh_category, smh_subcategory : smh_subcategory, smh_platform : smh_platform},
                    success: function(response){
                        //console.log(response);
                        //return false;

                        var fetchResponse = JSON.parse(response);
                        if(fetchResponse.status == "failure")
                        {
                            // $('.smh_belongs_to_nameerror').html(fetchResponse.message);
                            // $('.smh_belongs_to_nameerror').addClass("error");
                            // $('.smh_belongs_to_nameerror').css("display", "block");
                            alert(fetchResponse.message);
                            var check_cat_subcat_socialplatform_rel = "false";
                        }
                        else
                        {
                            form.submit();
                        }
                    }
                });
            //}
        }
    });

    $(document).on('change','#smh_belongs_to_type_id',function(e){
        console.log("onchange category called");
        // var selected_category=[];
        // $. each($('select#smh_belongs_to_type_id option:selected'), function(){
        //     selected_category. push($(this).val());
        // });

        // used for single selection
        var selected_category = $(this).children("option:selected").val();

        $.ajax({
            url : "<?php echo base_url(); ?>cms/smh/get_smh_subcategory_by_cat_id",
            type: "POST",
            data: {category_id : selected_category},
            success: function(data, textStatus, jqXHR)
            {
                //console.log(data);
                // var obj = $.parseJSON(data);
                // // obj =  JSON.parse(JSON.stringify(data));
                // console.log(obj);
                // var subcategorylisthtml = '<option value="">--- Please Select Subcategory ---</option>';
                // $.each( obj, function( key, value ) {
                //     subcategorylisthtml += '<option value="'+value['smh_belongs_to_id']+'">'+value['smh_belongs_to_name']+'</option>';
                // });
                // $("#smh_belongs_to_id").html(subcategorylisthtml);
                $("#smh_belongs_to_id").html(data);
                //$(".loader").hide();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $(".loader").hide();
            }
        });
            
    });
</script>
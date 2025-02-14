

<style type="text/css">
.cust_disable select  {
    position: relative;
}
.cust_disable select:before, .cust_disable .select2:before  {
  content: "";
  position: absolute;
  left: 0px;
  top: 1px;
  width: 100%;
  background: #e3cece4a;
  z-index: 99;
  height: 32px;
}

</style>
                                
<?php mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Document</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Document</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/documents/'); ?>">Back </a></span>
            </div>
            <?php
            // echo "<pre>";
            // print_r($post_data);
            
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="document_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="department_name" class="control-label col-lg-2">Department name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <select id="department_name" class="form-control select2" name="department_name" data-placeholder="Please Select Department" required>
                                    <option value="">-- Please select Department --</option>
                                    <?php
                                    $post_data['document_department_id'] = explode(',', $post_data['document_department_id']);
                                    
                                    foreach ($document_department as $key => $value) {
                                        ?>
                                         <!-- <option value="<?php //echo $value['id']; ?>"><?php// echo $value['name']; ?></option> -->
                                         <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['document_department_id']) && !empty($post_data['document_department_id']) && in_array($value['id'], $post_data['document_department_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                        
                                    }
                                    
                                    ?>
                                </select>
                            </div>
                        </div>  

                        <div class="form-group ">
                            <label for="document_category" class="control-label col-lg-2">Document category</label>
                            <div class="col-lg-10">
                                <select id="document_category" class="form-control select2" name="document_category" data-placeholder="Please Select Category">
                                    <option value="">-- Please select Category --</option>
                                    <?php
                                    $post_data['document_category_id'] = explode(',', $post_data['document_category_id']);

                                    foreach ($document_category as $key => $value) {
                                        ?>
                                         <!-- <option value="<?php //echo $value['id']; ?>"><?php// echo $value['name']; ?></option> -->
                                         <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['document_category_id']) && !empty($post_data['document_category_id']) && in_array($value['id'], $post_data['document_category_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                        
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="document_name" class="control-label col-lg-2">Document Name<span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="document_name" name="document_name" value="<?php echo set_value('document_name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".document_nameerror" maxlength="250">
                                <div class="document_nameerror error_msg"><?php echo form_error('document_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="institute_id" class="control-label col-lg-2">Institute Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">      
                            <?php
                                if(!empty($sub_institute_ids))
                                {
                                    // print_r($sub_institute_ids);
                                    // echo "<br>-------------<br>";
                                   

                                    //print_r($post_data['institute_id']);
                                    // print_r($post_data);

                                    // exit();
                                    if(!empty($post_data['institute_id']))
                                    {
                                        $post_data['institute_id'] = explode(',', $post_data['institute_id']);
                                    }
                                    
                                    ?>
                                    <select id="institute_id" class="form-control select2-multiple" multiple name="institute_id[]" required data-error=".institute_iderror" data-placeholder="-- Please Select Institute --">
                                    <option value="<?php echo $sess_institute_id; ?>" selected="selected"><?php echo $sess_institute_name; ?></option>
                                        <?php

                                                foreach ($sub_institute_ids as $key => $value) { ?>
                                                <option value="<?php echo $value['INST_ID']; ?>" <?php if(isset($post_data['institute_id']) && !empty($post_data['institute_id']) && in_array($value['INST_ID'], $post_data['institute_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['INST_NAME']; ?></option>
                                            <?php } ?>
                                    </select>

                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="cust_disable">
                                    <select id="institute_id" class="form-control select2-multiple " name="institute_id[]" required data-error=".institute_iderror" data-placeholder="-- Please Select Institute --" >
                                        <option value="<?php echo $sess_institute_id; ?>" selected="selected"><?php echo $sess_institute_name; ?></option>
                                    </select></div>
                                    <?php
                                }
                            ?>
                                
                                <div class="institute_iderror error_msg"><?php echo form_error('institute_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        

                                              

                        <div class="form-group ">
                            <label for="document_url" class="control-label col-lg-2">Document url<span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="url" class="form-control" id="document_url" name="document_url" value="<?php echo set_value('document_url', (isset($post_data['document_url']) ? $post_data['document_url'] : '')); ?>" data-error=".document_urlerror" maxlength="250" required>
                                <div class="document_urlerror error_msg"><?php echo form_error('document_url', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="description" class="control-label col-lg-2">Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="description" name="description" data-error=".description_error"><?php echo (isset($post_data['description']) ? $post_data['description'] : ''); ?></textarea>
                                <div class="description_error error_msg"><?php echo form_error('description', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        
						<div class="form-group">
                            <label for="order_by" class="control-label col-lg-2">Order By</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="order_by" name="order_by" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo set_value('order_by', (isset($post_data['order_by']) ? $post_data['order_by'] : '')); ?>">
                            </div>
                        </div>
						
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this document on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/documents/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    $("#document_form").validate({
        rules: {
            document_name: {
                required: true,
            },
            institute_id: {
                required: true,
            },
            // document_category: {
            //     required: true,
            // },
            department_name: {
                required: true,
            },
            document_url: {
                required: true,
            },
            
        },
        messages: {
            document_name: {
                required: 'Please enter document name',
            },
            institute_id: {
                required: 'Please enter institute name',
            },
            // document_category: {
            //     required: 'Please select document category',
            // },
            department_name: {
                required: 'Please select department name',
            },
            document_url: {
                required: 'Please enter document url',
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


    /*(function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());

    $('.cross-btn').click(function(){
        $(this).parent().parent().remove();
    });*/


    $(document).on('change','#department_name',function(e){
        console.log("onchange department_name called");
        var selected_department=[];
        $. each($('select#department_name option:selected'), function(){
            selected_department. push($(this).val());
        });
        
        
        //$(".loader").show();
        $.ajax({
            url : "<?php echo base_url(); ?>cms/documents/get_document_category_by_department_id",
            type: "POST",
            data : 'department_id='+selected_department,
            success: function(data, textStatus, jqXHR)
            {
                //console.log(data);
                var obj = $.parseJSON(data);
                // obj =  JSON.parse(JSON.stringify(data));
                console.log(obj);
                var categorylisthtml = '<option value="">--- Please Select Category ---</option>';
                $.each( obj, function( key, value ) {
                    //categorylisthtml += '<option value="'+key+'">'+value+'</option>';
                    categorylisthtml += '<option value="'+value['id']+'">'+value['name']+'</option>';
                    // console.log("key : "+value['id']);
                    // console.log("value : "+value['name']);
                });
                $("#document_category").html(categorylisthtml);
                //$(".loader").hide();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $(".loader").hide();
            }
        });
            
    });
</script>
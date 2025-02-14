

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
                        <span class="caption-subject font-brown bold uppercase">Edit Disclosure</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Disclosure</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/mandatory_disclosure/'); ?>">Back </a></span>
            </div>
            <?php
            // echo "<pre>";
            // print_r($post_data);
            
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="document_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="department_name" class="control-label col-lg-2">Category name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <select id="department_name" name="department_name" class="form-control select2" data-placeholder="Please Select Category" required>
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

                        <div class="form-group ">
                            <label for="document_category" class="control-label col-lg-2">Sub-category name</label>
                            <div class="col-lg-10">
                                <select id="document_category" name="document_category" class="form-control select2" data-placeholder="Please Select Sub-category">
                                    <option value="">-- Please select Sub-category --</option>
                                    <?php
                                    $post_data['document_subcategory_id'] = explode(',', $post_data['document_subcategory_id']);

                                    foreach ($document_subcategory as $key => $value) {
                                        ?>
                                         <!-- <option value="<?php //echo $value['id']; ?>"><?php// echo $value['name']; ?></option> -->
                                         <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['document_subcategory_id']) && !empty($post_data['document_subcategory_id']) && in_array($value['id'], $post_data['document_subcategory_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                        
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="document_name" class="control-label col-lg-2">Disclosure Name<span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="document_name" name="document_name" value="<?php echo set_value('document_name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".document_nameerror" maxlength="250">
                                <div class="document_nameerror error_msg"><?php echo form_error('document_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="document_url" class="control-label col-lg-2">Disclosure url<span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="url" class="form-control" id="document_url" name="document_url" value="<?php echo set_value('document_url', (isset($post_data['document_url']) ? $post_data['document_url'] : '')); ?>" data-error=".document_urlerror" maxlength="250" required>
                                <div class="document_urlerror error_msg"><?php echo form_error('document_url', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="weblink_or_pdf" class="control-label col-lg-2">Disclosure url type<span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <select id="weblink_or_pdf" class="form-control select2" name="weblink_or_pdf" data-placeholder="Select Type" required>
                                    <option value="">Select Disclosure url type</option>
                                    <option value="Weblink" <?php if(isset($post_data['weblink_or_pdf']) && $post_data['weblink_or_pdf'] == 'Weblink') echo"selected"; ?>>Weblink</option>
                                    <option value="PDF" <?php if(isset($post_data['weblink_or_pdf']) && $post_data['weblink_or_pdf'] == 'PDF') echo"selected"; ?>>PDF</option>
                                </select>
                                <div class="weblink_or_pdferror error_msg"><?php echo form_error('weblink_or_pdf', '<label class="error">', '</label>'); ?></div>
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
                                <input type="text" class="form-control" id="order_by" name="order_by" value="<?php echo set_value('order_by', (isset($post_data['order_by']) ? $post_data['order_by'] : '')); ?>">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this mandatory disclosure on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/mandatory_disclosure/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            department_name: {
                required: true,
            },
            document_url: {
                required: true,
            },
            weblink_or_pdf: {
                required: true,
            },
        },
        messages: {
            document_name: {
                required: 'Please enter disclosure name',
            },
            department_name: {
                required: 'Please select category name',
            },
            document_url: {
                required: 'Please enter disclosure url',
            },
            weblink_or_pdf: {
                required: 'Please select URL type',
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
            url : "<?php echo base_url(); ?>cms/mandatory_disclosure/get_document_category_by_department_id",
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
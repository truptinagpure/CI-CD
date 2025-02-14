
                                
<?php //mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Category</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Category</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/documents_category/'); ?>">Back </a></span>
            </div>
            <?php
            // echo "<pre>";
            // print_r($post_data);
            
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="document_category_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="category_name" class="control-label col-lg-2">Category name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo set_value('category_name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".category_nameerror" maxlength="250">
                                <div class="category_nameerror error_msg"><?php echo form_error('category_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>  

                        <div class="form-group ">
                            <label for="institute_id" class="control-label col-lg-2">Institute Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                            <?php /*      
                                  <select id="institute_id" name="institute_id[]" required>
                                    <option value="">-- Please select Institute --</option>
                                    <?php
                                        if(!empty($post_data['institute_id']))
                                        {
                                            $post_data['institute_id'] = explode(',', $post_data['institute_id']);
                                        }

                                        foreach ($all_institute as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['INST_ID']; ?>" <?php if(isset($post_data['institute_id']) && !empty($post_data['institute_id']) && in_array($value['INST_ID'], $post_data['institute_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['INST_NAME']; ?></option>
                                        <?php
                                        
                                    } 
                                    ?>
                                </select> */?>

                                <select id="institute_id" name="institute_id[]" class="form-control select2-multiple" data-placeholder="-- Please Select Institute --" data-error=".institute_iderror" required>
                                    <option value="<?php echo $sess_institute_id; ?>" selected="selected"><?php echo $sess_institute_name; ?></option>
                                </select>
                                
                                <div class="institute_iderror error_msg"><?php echo form_error('institute_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
						<?php
						      
							// print_r($documents_department_list_by_session_institute);
       //                      echo "<br>---------------<br>";
       //                      print_r($post_data);
						?>
						<div class="form-group ">
                            <label for="department_id" class="control-label col-lg-2">Department Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                            <?php /*  
                                  <select id="department_id" name="department_id[]" required>
                                    <option value="">-- Please select department --</option>
                                    <?php
									
										
                                        if(!empty($post_data['document_department_id']))
                                        {
                                            $post_data['document_department_id'] = explode(',', $post_data['document_department_id']);
                                        }

                                        foreach ($post_department_data as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['document_department_id']) && !empty($post_data['document_department_id']) && in_array($value['id'], $post_data['document_department_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                        
										}
                                    ?>
                                </select> */ ?>

                                <select id="department_id" name="department_id[]" class="form-control select2" data-placeholder="Please Select Department" required>
                                    <option value="">-- Please select department --</option>
                                    <?php
                                    
                                        
                                        if(!empty($post_data['document_department_id']))
                                        {
                                            $post_data['document_department_id'] = explode(',', $post_data['document_department_id']);
                                        }

                                        foreach ($documents_department_list_by_session_institute as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['document_department_id']) && !empty($post_data['document_department_id']) && in_array($value['id'], $post_data['document_department_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                        
                                        }
                                    ?>
                                </select>
                                
                                <div class="department_iderror error_msg"><?php echo form_error('department_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label for="order_by" class="control-label col-lg-2">Order By</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="order_by" name="order_by" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo set_value('order_by', (isset($post_data['order_by']) ? $post_data['order_by'] : '')); ?>">
                            </div>
                        </div>
						
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this document category on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/documents_category/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    $("#document_category_form").validate({
        rules: {
            category_name: {
                required: true,
            },
            institute_id: {
                required: true,
            },
            department_id: {
                required: true,
            },
            
        },
        messages: {
            category_name: {
                required: 'Please enter Category name',
            },
            institute_id: {
                required: 'Please select institute name',
            },
            department_id: {
                required: 'Please select institute name',
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


    $(document).on('change','#institute_id',function(e){
        console.log("onchange institute called");
        var selected_institute=[];
        $. each($('select#institute_id option:selected'), function(){
            selected_institute. push($(this).val());
        });
        
        
        //$(".loader").show();
        $.ajax({
            url : "<?php echo base_url(); ?>cms/documents_category/get_document_department_by_institute_id",
            type: "POST",
            data : 'institute_id='+selected_institute,
            success: function(data, textStatus, jqXHR)
            {
                //console.log(data);
                var obj = $.parseJSON(data);
                // obj =  JSON.parse(JSON.stringify(data));
                console.log(obj);
                var departmentlisthtml = '<option value="">--- Please Select Department ---</option>';
                $.each( obj, function( key, value ) {
                    //departmentlisthtml += '<option value="'+key+'">'+value+'</option>';
                    departmentlisthtml += '<option value="'+value['id']+'">'+value['name']+'</option>';
                    // console.log("key : "+value['id']);
                    // console.log("value : "+value['name']);
                });
                $("#department_id").html(departmentlisthtml);
                //$(".loader").hide();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $(".loader").hide();
            }
        });
            
    });
</script>
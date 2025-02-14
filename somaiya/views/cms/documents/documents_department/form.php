
                                
<?php //mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Department</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Department</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/documents_department/'); ?>">Back </a></span>
            </div>
            <?php
            // echo "<pre>";
            // print_r($post_data);
            
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="document_department_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="department_name" class="control-label col-lg-2">Department name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="department_name" name="department_name" value="<?php echo set_value('department_name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".department_nameerror" maxlength="250">
                                <div class="department_nameerror error_msg"><?php echo form_error('department_name', '<label class="error">', '</label>'); ?></div>
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
                                </select> */ ?>
                                <select id="institute_id" name="institute_id[]" class="form-control select2-multiple" data-placeholder="-- Please Select Institute --" data-error=".institute_iderror" required>
                                    <option value="<?php echo $sess_institute_id; ?>" selected="selected"><?php echo $sess_institute_name; ?></option>
                                </select>
                                
                                <div class="institute_iderror error_msg"><?php echo form_error('institute_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
						
						<div class="form-group">
                            <label for="order_by" class="control-label col-lg-2">Order By</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="order_by" name="order_by" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo set_value('order_by', (isset($post_data['order_by']) ? $post_data['order_by'] : '')); ?>">
                            </div>
                        </div>
						
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this document department on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/documents_department/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    $("#document_department_form").validate({
        rules: {
            department_name: {
                required: true,
            },
            institute_id: {
                required: true,
            },
            
        },
        messages: {
            department_name: {
                required: 'Please enter Department name',
            },
            institute_id: {
                required: 'Please enter institute name',
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


    /*$(document).on('change','#institute_id',function(e){
        console.log("onchange institute called");
        var selected_institute=[];
        $. each($('select#institute_id option:selected'), function(){
            selected_institute. push($(this).val());
        });
        
        
        //$(".loader").show();
        $.ajax({
            url : "<?php //echo base_url(); ?>cms/documents/get_document_category_by_institute_id",
            type: "POST",
            data : 'institute_id='+selected_institute,
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
            
    });*/
</script>
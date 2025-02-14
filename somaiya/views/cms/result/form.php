
<div class="row">
    <div class="col-md-12">
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Result</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Result</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/result/'); ?>">Back </a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="result_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="result_name" class="control-label col-lg-2">Result Title <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="result_name" name="result_name" value="<?php echo set_value('result_name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".result_nameerror" maxlength="250">
                                <div class="result_nameerror error_msg"><?php echo form_error('result_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>  

                        <?php
                        if(isset($post_data['result_category_id']))
                        {
                           $result_category_id = explode(",", $post_data['result_category_id']);
                        }

						?>
						<div class="form-group ">
                            <label for="result_category_id" class="control-label col-lg-2">Result Category<span class="asterisk">*</span></label>
                            <div class="col-lg-10">

                                <!-- <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" name="result_category_id[]" data-placeholder="Please select result category" required> -->
                                <select id="result_category_id" class="form-control input-lg select2-multiple" name="result_category_id" data-placeholder="Please select result category" required>
                                    <option value="">-- Please select result category --</option>
                                    <?php               
                                        foreach ($all_result_category as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['result_category_id']) && in_array($value['id'], $result_category_id)) { echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                        
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
						<?php
                            if(isset($post_data['result_sub_category_id']))
                            {
                                $result_sub_category_id = explode(",", $post_data['result_sub_category_id']);
                            }
                        ?>
                        <div class="form-group ">
                            <label for="result_sub_category_id" class="control-label col-lg-2">Result Subcategory<span class="asterisk">*</span></label>
                            <div class="col-lg-10">

                                <select id="result_sub_category_id" class="form-control input-lg select2-multiple" name="result_sub_category_id[]" data-placeholder="Please select result subcategory" multiple required>
                                    <!-- <option value="">-- Please select result subcategory --</option> -->
                                    <?php               
                                        foreach ($result_subcategory as $key => $value) {
                                        ?> 
                                           
                                           <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['result_sub_category_id']) && in_array($value['id'], $result_sub_category_id)) { echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php                                            
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <?php $this->load->view('cms/result/result_links'); ?>

                        
                        <div class="form-group ">
                            <label for="academic_year" class="control-label col-lg-2">Academic Year <span class="asterisk">*</span></label>&nbsp;&nbsp;
                            <div class="col-lg-10">
                                <select id="academic_year" class="form-control select2 select2-hidden-accessible" name="academic_year" data-error=".academic_yearerror" data-placeholder="-- Please Select Academic Year --" aria-required="true" tabindex="-1" aria-hidden="true" required>
                                        <option value="">-- Please Select Academic Year --</option>
                                        <?php               
                                            foreach ($academic_year as $key => $value) {
                                            ?>
                                               <option value="<?php echo $value['academic_year_name']; ?>" <?php if(isset($post_data['academic_year']) && $value['academic_year_name'] == $post_data['academic_year']){ echo 'selected="selected"'; } ?>><?php echo $value['academic_year_name']; ?></option>
                                            <?php
                                            
                                            }
                                        ?>
                                </select>
                                <div class="academic_yearerror error_msg"><?php echo form_error('academic_year', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        
						
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this result on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/result/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    $("#result_form").validate({
        rules: {
            result_name: {
                required: true,
            },
            result_category_id: {
                required: true,
            },
            result_sub_category_id: {
                required: true,
            },
            academic_year: {
                required: true,
            },
            
        },
        messages: {
            result_name: {
                required: 'Please enter result title',
            },
            result_category_id: {
                required: 'Please select result category',
            },
            result_sub_category_id: {
                required: 'Please select result subcategory',
            },
            academic_year: {
                required: 'Please select academic year',
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


    // get result subcategory base on category

    $(document).on('change','#result_category_id',function(e){
        console.log("onchange result_category_id called");
        var selected_result_category_id=[];
        $. each($('select#result_category_id option:selected'), function(){
            selected_result_category_id. push($(this).val());
        });
        
        
        //$(".loader").show();
        $.ajax({
            url : "<?php echo base_url(); ?>cms/result/get_result_subcategory_by_cat_id",
            type: "POST",
            data : 'category_id='+selected_result_category_id,
            success: function(data, textStatus, jqXHR)
            {
                //console.log(data);
                var obj = $.parseJSON(data);
                // obj =  JSON.parse(JSON.stringify(data));
                console.log(obj);
                var categorylisthtml = '<option value="">--- Please Select Subcategory ---</option>';
                $.each( obj, function( key, value ) {
                    categorylisthtml += '<option value="'+value['id']+'">'+value['name']+'</option>';                    
                });
                $("#result_sub_category_id").html(categorylisthtml);
                //$(".loader").hide();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $(".loader").hide();
            }
        });
            
    });
</script>


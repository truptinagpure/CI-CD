
                                
<?php //mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($result_subcategory_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Subcategory</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Subcategory</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/result_sub_category/'); ?>">Back </a></span>
            </div>
            <?php
            // echo "<pre>";
            // print_r($result_subcategory_data);
            
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="result_subcategory_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="sub_category_name" class="control-label col-lg-2">Subcategory name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="sub_category_name" name="sub_category_name" value="<?php echo set_value('sub_category_name', (isset($result_subcategory_data['name']) ? $result_subcategory_data['name'] : '')); ?>" required data-error=".sub_category_nameerror" maxlength="250">
                                <div class="sub_category_nameerror error_msg"><?php echo form_error('sub_category_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>  
						
                        <div class="form-group ">
                            <label for="result_category_id" class="control-label col-lg-2">Category <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <select id="result_category_id" name="result_category_id" class="form-control select2" data-placeholder="Please Select Category" required>
                                    <option value="">Please select category</option>
                                <?php
                                    if(!empty($result_subcategory_data['result_category_id']))
                                    {
                                        $selected_category_id = explode(',', $result_subcategory_data['result_category_id']);
                                    }

                                    if(isset($category_list) && count($category_list)!=0){ ?>
                                    <?php foreach ($category_list as $key => $value) { ?>
                                        <option value="<?php echo $value['id']; ?>" <?php if( isset($selected_category_id) && in_array($value['id'], $selected_category_id)) echo"selected"; ?> > <?php echo $value['name']; ?></option>
                                    <?php } }

                                    
                                ?>
                            </select>
                                <div class="result_category_iderror error_msg"><?php echo form_error('result_category_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

						<div class="form-group">
                            <label for="order_by" class="control-label col-lg-2">Order By</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="order_by" name="order_by" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo set_value('order_by', (isset($result_subcategory_data['order_by']) ? $result_subcategory_data['order_by'] : '')); ?>">
                            </div>
                        </div>
						
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this result category on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($result_subcategory_data['status']) && $result_subcategory_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($result_subcategory_data['status']) ? $result_subcategory_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/result_sub_category/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    $("#result_subcategory_form").validate({
        rules: {
            sub_category_name: {
                required: true,
            },
            result_category_id: {
                required: true,
            },
            
        },
        messages: {
            sub_category_name: {
                required: 'Please enter subcategory name',
            },
            result_category_id: {
                required: 'Please select category',
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
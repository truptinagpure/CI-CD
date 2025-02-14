
                                
<?php //mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($result_category_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Result Category</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add Result Category</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/result_category/'); ?>">Back </a></span>
            </div>
            <?php
            // echo "<pre>";
            // print_r($result_category_data);
            
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="result_category_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="category_name" class="control-label col-lg-2">Category name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo set_value('category_name', (isset($result_category_data['name']) ? $result_category_data['name'] : '')); ?>" required data-error=".category_nameerror" maxlength="250">
                                <div class="category_nameerror error_msg"><?php echo form_error('category_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>  
						
						<div class="form-group">
                            <label for="order_by" class="control-label col-lg-2">Order By</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="order_by" name="order_by" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo set_value('order_by', (isset($result_category_data['order_by']) ? $result_category_data['order_by'] : '')); ?>">
                            </div>
                        </div>
						
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this result category on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($result_category_data['status']) && $result_category_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($result_category_data['status']) ? $result_category_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/result_category/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    $("#result_category_form").validate({
        rules: {
            category_name: {
                required: true,
            },
            
        },
        messages: {
            category_name: {
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
    });


    
</script>
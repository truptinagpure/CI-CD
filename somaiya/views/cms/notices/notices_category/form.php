
                                
<?php //mk_use_uploadbox($this); ?>

<?php
$previous_year = date("Y",strtotime("-1 year"));
$prev_previous_year = date("Y",strtotime("-2 year"));
$current_year = date("Y");
$next_year = date('Y', strtotime('+1 year'));

$default_academic_year = array($prev_previous_year."-".$previous_year,$previous_year."-".$current_year,$current_year."-".$next_year);
?>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Notice Category</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Notice Category</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/notices_category/'); ?>">Back </a></span>
            </div>
            <?php
            // echo "<pre>";
            // print_r($post_data);
            
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="notices_category_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="category_name" class="control-label col-lg-2">Notice Category Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo set_value('category_name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".category_nameerror" maxlength="250">
                                <div class="category_nameerror error_msg"><?php echo form_error('category_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>  

                        <?php /*
                        <div class="form-group ">
                            <label for="institute_id" class="control-label col-lg-2">Institute Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <select id="institute_id" name="institute_id[]" required>
                                    <option value="<?php echo $sess_institute_id; ?>" selected="selected"><?php echo $sess_institute_name; ?></option>
                                </select>
                                
                                <div class="institute_iderror error_msg"><?php echo form_error('institute_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
						<?php
						*/
                        // echo "<pre>"; 
				        // print_r($post_data);
                        // echo "<br>---------------------------<br>";
                        // echo "<pre>";
                        // print_r($parents_notices_category);

						?>
						<div class="form-group ">
                            <label for="comes_under" class="control-label col-lg-2">Comes Under</label>
                            <div class="col-lg-10">

                                <!-- <select id="comes_under" name="comes_under"> -->
                                    <select id="comes_under" class="form-control select2 select2-hidden-accessible" name="comes_under" data-error=".comes_undererror" data-placeholder="-- Please Select Comes Under --" aria-required="true" tabindex="-1" aria-hidden="true">
                                    <option value="">-- Please select Comes Under --</option>
                                    <?php               
                                        foreach ($parents_notices_category as $key => $value) {
                                        ?>
                                           
                                           <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['comes_under']) && !empty($post_data['comes_under']) && $value['id'] == $post_data['comes_under']){ echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                        
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="comes_under" class="control-label col-lg-2">Academic Year</label>
                            <div class="col-lg-10">

                                    <select id="cat_academic_year" class="form-control select2 select2-hidden-accessible" name="cat_academic_year" data-error=".cat_academic_yearerror" data-placeholder="-- Please Select Academic Year --" aria-required="true" tabindex="-1" aria-hidden="true">
                                    <option value="">-- Please select Academic Year --</option>
                                    <?php               
                                        foreach ($default_academic_year as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value; ?>" <?php if(isset($post_data['academic_year']) && !empty($post_data['academic_year']) && $value == $post_data['academic_year']) { echo "selected"; } ?>><?php echo $value; ?></option>
                                        <?php
                                        
                                        }
                                    ?>
                                </select>
                                <div class="cat_academic_yearerror error_msg"><?php echo form_error('cat_academic_year', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
						
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/notices_category/') ?>" class="btn btn-default" type="button">Cancel</a>
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

    $("#notices_category_form").validate({
        rules: {
            category_name: {
                required: true,
            },
            cat_academic_year: {
                 required: true,
            },
            
        },
        messages: {
            category_name: {
                required: 'Please enter Category name',
            },
            cat_academic_year: {
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

</script>

                                
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
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/disclosure_category/'); ?>">Back </a></span>
            </div>
            <?php
            // echo "<pre>";
            // print_r($post_data);
            
            ?>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="document_department_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="category_name" class="control-label col-lg-2">Category name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo set_value('category_name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".category_nameerror" maxlength="250">
                                <div class="category_nameerror error_msg"><?php echo form_error('category_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>  

                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this category on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/disclosure_category/') ?>" class="btn btn-default" type="button">Cancel</a>
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
            category_name: {
                required: true,
            },
            
        },
        messages: {
            category_name: {
                required: 'Please enter Department name',
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
            url : "<?php //echo base_url(); ?>document_management/documents/get_document_category_by_institute_id",
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
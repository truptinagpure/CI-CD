<div class="row">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($source_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Media Source</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Media Source</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/source/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php
                        // echo "<pre>";
                        // print_r($source_data);
                        // echo "<br>------------<br>";
                        // print_r($mediacoverage_type);
                        //exit();
                        ?>

                        <div class="form-group ">
                            <label for="source_name" class="control-label col-lg-2">Source Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="source_name" name="source_name" value="<?php echo set_value('source_name', (isset($source_data['source_name']) ? $source_data['source_name'] : '')); ?>" required data-error=".source_nameerror" maxlength="250" required>
                                <div class="source_nameerror error_msg"><?php echo form_error('source_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <?php //$this->load->view('cms/mediacoverage/source/source_image'); ?>
                            </div>
                        </div> -->
                        
                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this media source type on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($source_data['public']) && $source_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($source_data['public']) ? $source_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/source/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>
<?php
    // mk_popup_uploadfile(_l('Upload Image',$this),"image",$base_url."upload_image/20/");
    // mk_popup_uploadfile(_l('Upload Meta Image',$this),"imagemeta",$base_url."upload_image/20/");
?>

<script type="text/javascript">
    $(document).ready(function() 
    {
        /* public */

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
</script>

<script type="text/javascript">
    $("#formval").validate({
        rules: {
            source_name: {
                required: true,
            },
        },
        messages: {
            source_name: {
                required: 'Please Enter Source Name',
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
<div class="row">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($covid_data['image_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Covid</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Covid</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/covid/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php
                        // echo "<pre>";
                        // print_r($covid_data);
                        // exit(); 
                        ?>
                        <input type="hidden" id="covid_id" name="covid_id" value="<?php if(isset($covid_data['id'])){ echo $covid_data['id']; }?>">

                        <div class="form-group ">
                            <label for="covid_title" class="control-label col-lg-2">Title<span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="covid_title" name="covid_title" value="<?php echo set_value('covid_title', (isset($covid_data['title']) ? $covid_data['title'] : '')); ?>" data-error=".covid_titleerror" maxlength="250" required onchange="check_covid_title()">

                                <div class="covid_titleerror error_msg"><?php echo form_error('covid_title', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <!-- <div class="form-group ">
                            <label for="covid_description" class="control-label col-lg-2">Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="covid_description" name="covid_description" data-error=".covid_description" cols="10" rows="5"><?php //echo set_value('covid_description', (isset($covid_data['description']) ? $covid_data['description'] : '')); ?></textarea>
                                <div class="covid_descriptionerror error_msg"><?php //echo form_error('covid_description', '<label class="error">', '</label>'); ?></div>

                            </div>
                        </div> -->
                        <?php mk_hWYSItexteditor("description", 'Description', isset($covid_data['description']) ? $covid_data['description'] : '', 'description'); ?>
                         

                        

                        <div class="form-group ">
                            <label for="date" class="control-label col-lg-2">Published Date<span class="asterisk">*</span></label>&nbsp;&nbsp;
                            <input type="text" id="date" name="date" value="<?php if(isset($covid_data['date'])) { echo $covid_data['date']; } ?>" />
                            <div class="dateerror error_msg"><?php echo form_error('date', '<label class="error">', '</label>'); ?></div>
                        </div>

                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this covid title on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($covid_data['public']) && $covid_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($covid_data['public']) ? $covid_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/covid/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">

    $('#date').datetimepicker({
        format:'Y-m-d',
        //minDate:new Date()
    });

</script>

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
            covid_title: {
                required: true,
            },
            date: {
                required: true,
            },
        },
        messages: {
            covid_title: {
                required: 'Please Enter Title',
            },
            date: {
                required: 'Please Enter Date',
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            if (placement) {
                //$(placement).append(error);
                $(placement).html(error);
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form){
            form.submit();
        }
    });
</script>
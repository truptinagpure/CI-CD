<div class="row">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($researchers_corner_data['image_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Researcher</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Researcher</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/researchers_corner/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php
                        // echo "<pre>";
                        // print_r($researchers_corner_data);
                        // exit(); 
                        ?>
                        <input type="hidden" id="researcher_id" name="researcher_id" value="<?php if(isset($researchers_corner_data['id'])){ echo $researchers_corner_data['id']; }?>">

                        <div class="form-group ">
                            <label for="researcher_member_id" class="control-label col-lg-2">Member Id <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="researcher_member_id" name="researcher_member_id" value="<?php echo set_value('researcher_member_id', (isset($researchers_corner_data['researcher_member_id']) ? $researchers_corner_data['researcher_member_id'] : '')); ?>" data-error=".researcher_member_iderror" maxlength="250" required onchange="check_member_id()">
								<div class="researcher_member_name" id="researcher_member_name"></div>
                                <div class="researcher_member_iderror error_msg"><?php echo form_error('researcher_member_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <!-- <div class="form-group ">
                            <label for="researcher_introduction" class="control-label col-lg-2">Introduction&nbsp;<span><a title="Maximum Character Limit is 1000" data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="researcher_introduction" name="researcher_introduction" maxlength="1000" data-error=".researcher_introductionerror" cols="10" rows="5"><?php //echo set_value('researcher_introduction', (isset($researchers_corner_data['researcher_introduction']) ? $researchers_corner_data['researcher_introduction'] : '')); ?></textarea>
                                <div class="researcher_introductionerror error_msg"><?php //echo form_error('researcher_introduction', '<label class="error">', '</label>'); ?></div>

                            </div>
                        </div> -->
						
						<?php mk_hWYSItexteditor("researcher_introduction", 'researcher_introduction', isset($researchers_corner_data['researcher_introduction']) ? $researchers_corner_data['researcher_introduction'] : '', 'researcher_introduction'); ?>
                        
                        <div class="form-group ">
                            <label for="researcher_valid_date" class="control-label col-lg-2">Valid Date</label>&nbsp;&nbsp;
                            <input type="text" id="researcher_valid_date" name="researcher_valid_date" value="<?php if(isset($researchers_corner_data['researcher_valid_date'])) { echo $researchers_corner_data['researcher_valid_date']; } ?>" />
                            <div class="researcher_valid_dateerror error_msg"><?php echo form_error('researcher_valid_date', '<label class="error">', '</label>'); ?></div>
                        </div>

                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this Researcher on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($researchers_corner_data['public']) && $researchers_corner_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($researchers_corner_data['public']) ? $researchers_corner_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/researchers_corner/'); ?>" class="btn btn-default" type="button">Cancel</a>
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

    $('#researcher_valid_date').datetimepicker({
        format:'Y-m-d',
        minDate:new Date()
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

    function check_member_id()
    {

        var member_id = $("#researcher_member_id").val();
        var researcher_id = $("#researcher_id").val();

        if(member_id != "")
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'cms/researchers_corner/check_member_id'; ?>",
                //async: false,
                data: {member_id : member_id, researcher_id : researcher_id},
                success: function(response){
					
					var fetchResponse = JSON.parse(response);
                    if(fetchResponse.status == "failure")
                    {
                        $('.researcher_member_iderror').html(fetchResponse.message);
                        $('.researcher_member_iderror').addClass("error");
                        $('.researcher_member_iderror').css("display", "block");
                        var check_member_id_result = "false";
                    }
                    else
                    {
                        $('.researcher_member_iderror').html(fetchResponse.message);
                        console.log(fetchResponse);
                        $('#researcher_member_name').html(fetchResponse.data[0].member_name);
                        $('.researcher_member_name').css("display", "block");
                        $('.researcher_member_iderror').removeClass("error");
                        //$('.researcher_member_iderror').css("display", "none");
                        var check_member_id_result = "true";
                    }
                    return check_member_id_result;
                    
                }
            });
        }
    }

    $("#formval").validate({
        rules: {
            researcher_member_id: {
                required: true,
            },
        },
        messages: {
            researcher_member_id: {
                required: 'Please enter Researcher Member Id',
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
            var member_id = $("#researcher_member_id").val();
            var researcher_id = $("#researcher_id").val();
            //if(member_id != "")
            //{
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'cms/researchers_corner/check_member_id'; ?>",
                    //async: false,
                    data: {member_id : member_id, researcher_id : researcher_id},
                    success: function(response){

                        var fetchResponse = JSON.parse(response);
                        if(fetchResponse.status == "failure")
                        {
                            $('.researcher_member_iderror').html(fetchResponse.message);
                            $('.researcher_member_iderror').addClass("error");
                            $('.researcher_member_iderror').css("display", "block");
                            var check_member_id_result = "false";
                        }
                        else
                        {
                            
                            form.submit();
                        }
                    }
                });
            //}
        }
    });
</script>
<div class="row">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($research_support_team_data['image_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Research Support Team</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Research Support Team</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/research_support_team/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php
                        // echo "<pre>";
                        // print_r($research_support_team_data);
                        // exit(); 
                        ?>
                        <input type="hidden" id="researcher_id" name="researcher_id" value="<?php if(isset($research_support_team_data['id'])){ echo $research_support_team_data['id']; }?>">

                        <div class="form-group ">
                            <label for="researcher_member_id" class="control-label col-lg-2">Member Id <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="researcher_member_id" name="researcher_member_id" value="<?php echo set_value('researcher_member_id', (isset($research_support_team_data['researcher_member_id']) ? $research_support_team_data['researcher_member_id'] : '')); ?>" data-error=".researcher_member_iderror" maxlength="250" required onchange="check_member_id()">
								<div class="researcher_member_name" id="researcher_member_name"></div>
                                <div class="researcher_member_iderror error_msg"><?php echo form_error('researcher_member_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="researcher_role" class="control-label col-lg-2">Role <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="researcher_role" name="researcher_role" value="<?php echo set_value('researcher_role', (isset($research_support_team_data['role']) ? $research_support_team_data['role'] : '')); ?>" data-error=".researcher_roleerror" required>
                                <div class="researcher_roleerror error_msg"><?php echo form_error('researcher_role', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="order_by" class="control-label col-lg-2">Order By</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="order_by" name="order_by" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo set_value('order_by', (isset($research_support_team_data['order_by']) ? $research_support_team_data['order_by'] : '')); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Publish&nbsp;<span><a title="Click checkbox to display this Researcher on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($research_support_team_data['public']) && $research_support_team_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($research_support_team_data['public']) ? $research_support_team_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/research_support_team/'); ?>" class="btn btn-default" type="button">Cancel</a>
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
                url: "<?php echo base_url().'cms/research_support_team/check_member_id'; ?>",
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
            researcher_role: {
                required: true,
            },
        },
        messages: {
            researcher_member_id: {
                required: 'Please Enter Researcher Member Id',
            },
            researcher_role: {
                required: 'Please Enter Researcher Role',
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
                    url: "<?php echo base_url().'cms/research_support_team/check_member_id'; ?>",
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
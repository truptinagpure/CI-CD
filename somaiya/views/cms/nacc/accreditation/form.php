
<div class="row">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($accreditation_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Accreditation</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Accreditation</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/accreditation/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        
                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-2">Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($accreditation_data['name']) ? $accreditation_data['name'] : '')); ?>" data-error=".nameerror" maxlength="250" required>
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-6">
                                 <div class="form-group">
                                    <label for="start_date" class="control-label col-lg-4">Start Date </label>&nbsp;&nbsp;
                                    <input type="text" class="datetextbox wid60date col-lg-8" autocomplete="off" id="start_date" name="start_date" value="<?php if(isset($accreditation_data['start_date']) && $accreditation_data['start_date'] != '0000-00-00 00:00:00') { echo date('Y-m-d',strtotime($accreditation_data['start_date'])); } ?>"  />
                                    <!-- <div class="start_dateerror error_msg"><?php //echo form_error('start_date', '<label class="error">', '</label>'); ?></div> -->
                                </div>
                            </div>

                            <div class="col-lg-6">
                                 <div class="form-group">
                                    <label for="end_date" class="control-label col-lg-2">End Date </label>&nbsp;&nbsp;
                                    <input type="text" class="datetextbox col-lg-10" id="end_date" autocomplete="off" name="end_date" value="<?php if(isset($accreditation_data['end_date']) && $accreditation_data['start_date'] != '0000-00-00 00:00:00') { echo date('Y-m-d',strtotime($accreditation_data['end_date'])); } ?>"  />
                                    <div class="end_dateerror error_msg"><?php echo form_error('end_date', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                         </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <?php
                                    mk_hWYSItexteditor("description",_l('Description',$this),isset($accreditation_data['description'])?$accreditation_data['description']:'','');
                                ?>
                            </div>
                         </div>

                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Public&nbsp;<span><a title="Click checkbox to display this accreditation on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($accreditation_data['status']) && $accreditation_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($accreditation_data['status']) ? $accreditation_data['status'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/accreditation/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>

<!-- <link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script> 
 -->


<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet"/> -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>




<script type="text/javascript">

           

   /* $('#start_date').datetimepicker({
        format:'Y-m-d H:i',
        //minDate:new Date()

    });

    $('#end_date').datetimepicker({
        format:'Y-m-d H:i',
        //minDate:new Date()
        minDate:new Date()
        //dateFormat: 'Y-m-d H:i',
    }); */




// working


$(document).ready(function(){
   $("#start_date").datepicker({
       format: 'yyyy-mm-dd',
       autoclose: true,
   }).on('changeDate', function (selected) {
    console.log(selected);
       var minDate = new Date(selected.date.valueOf());
       $('#end_date').datepicker('setStartDate', minDate);
       $('#end_date').datepicker('setDate',minDate);
   });

   $("#end_date").datepicker({
       format: 'yyyy-mm-dd',
       autoclose: true,
   }).on('changeDate', function (selected) {
           var minDate = new Date(selected.date.valueOf());
           //$('#start_date').datepicker('setEndDate', minDate);
   });
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
            name: {
                required: true,
            },
        },
        messages: {
            name: {
                required: 'Please enter name',
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

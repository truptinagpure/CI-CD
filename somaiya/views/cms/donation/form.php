<link href="<?php echo base_url(); ?>assets/layouts/layout/image_upload/styles.imageuploader.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>assets/layouts/layout/image_upload/jquery.imageuploader.js"></script>


<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($donation_id) && !empty($donation_id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Donation</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Donation</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/donation/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="project_name" class="control-label col-lg-2">Project Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo set_value('project_name', (isset($donation_data['project_name']) ? $donation_data['project_name'] : '')); ?>" required data-error=".project_nameerror" maxlength="255">
                                    <div class="project_nameerror error_msg"><?php echo form_error('project_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="type_id" class="control-label col-lg-2">Type <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="type_id" class="form-control select2" name="type_id" required data-error=".type_iderror" data-placeholder="-- Select Type --">
                                        <option value="">-- Select Type --</option>
                                        <?php foreach ($donation_type as $key => $value) { ?>
                                            <option value="<?php echo $value['dontype_id']; ?>" <?php if(isset($donation_data['dontype_id']) && $donation_data['dontype_id'] == $value['dontype_id']){ echo 'selected="selected"'; } ?>><?php echo $value['parent_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="type_iderror error_msg"><?php echo form_error('type_id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-lg-2">Sub Type</label>
                                <div class="col-lg-10 col-sm-10 sub_type_wrap">
                                    <select class="form-control select2" name="sub_donation_type" id="sub_donation_type" data-placeholder="-- Select Sub Type --">
                                        <option value="">-- Select Sub Type --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="contents_id" value="<?php echo set_value('contents_id', (isset($donation_data['contents_id']) ? $donation_data['contents_id'] : '')); ?>" >
                            <input type="hidden" name="data_type" value="donation">
                            <input type="hidden" name="language_id" value="1">

                            <div class="form-group">
                                <label for="start_date" class="control-label col-lg-2">Start Date <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input type="text" class="datetextbox" id="start_date" name="start_date" value="<?php if(isset($donation_data['start_date'])) { echo $donation_data['start_date']; } ?>" required data-error=".start_dateerror" />
                                    <div class="start_dateerror error_msg"><?php echo form_error('start_date', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="never_ending" class="control-label col-lg-2">Never Ending</label>
                                <div class="col-lg-2 col-sm-2">
                                    <input class="checkbox form-control" name="never_ending" id="never_ending_checkbox" value="1" type="radio" <?php if(isset($donation_data['never_ending']) && $donation_data['never_ending'] == 1){ echo 'checked="checked"'; } ?> onclick="javascript:yesnoCheck();" required checked>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-md-2"><b>OR</b></div> -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="never_ending" class="control-label col-lg-2">With Ending</label>
                                <div class="col-lg-2 col-sm-2">
                                    <input class="checkbox form-control" name="never_ending" id="ending_checkbox" value="2" type="radio" <?php if(isset($donation_data['never_ending']) && $donation_data['never_ending'] == 2){ echo 'checked="checked"'; } ?> onclick="javascript:yesnoCheck();">
                                </div>
                                <div class="col-lg-8 col-sm-8" id="end_date" <?php if(isset($donation_data['never_ending']) && $donation_data['never_ending'] == 2){ ?>style="display: block"<?php } else { ?> style="display: none" <?php } ?>>
                                    <input type="text" class="datetextbox col-lg-10" id="end_date_new" name="end_date" value="<?php if(isset($donation_data['never_ending']) && $donation_data['never_ending'] == 2){ echo $donation_data['end_date']; } else { ?><?php } ?>" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="chkgoalamt" class="control-label col-lg-2">Amount(s)</label>
                            </div>
                        </div>
                    <div> -->

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="chknogoal" class="control-label col-lg-2">No Goal</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input id="chknogoal_checkbox" name="radio_amount" value="3" class="checkbox form-control" type="radio" <?php if(isset($donation_data['radio_amount']) && $donation_data['radio_amount'] == 3){ echo 'checked="checked"'; }?> onclick="javascript:yesnoCheck();" checked>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="col-md-1"><b>OR</b></div> -->

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="chkgoalamt" class="control-label col-lg-2">Goal</label>
                                <div class="col-lg-2 col-sm-2">
                                    <input id="chkgoalamt_checkbox" name="radio_amount" value="1" class="checkbox form-control" type="radio" <?php if(isset($donation_data['radio_amount']) && $donation_data['radio_amount'] == 1){ echo 'checked="checked"'; }?> onclick="javascript:yesnoCheck();">
                                </div>
                                <div class="col-lg-8 col-sm-8" id="dvgoalamt" <?php if(isset($donation_data['radio_amount']) && $donation_data['radio_amount'] == 1){ ?>style="display: block"<?php } else { ?> style="display: none" <?php } ?>>
                                    <input type="number" name="goal_amount" required value="<?php if(isset($donation_data['radio_amount']) && $donation_data['radio_amount'] == 1){ echo $donation_data['goal_amount']; } else { ?>'0'<?php } ?>" id="dvgoalamt" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- <div class="col-md-1"><b>OR</b></div> -->

                        <div class="col-md-4">                        
                            <div class="form-group">
                                <label for="chkquanty" class="control-label col-lg-2">Quantity (Each)</label>
                                <div class="col-lg-2 col-sm-2">
                                    <input id="chkquanty_checkbox" name="radio_amount" value="2" class="checkbox form-control" type="radio" <?php if(isset($donation_data['radio_amount']) && $donation_data['radio_amount'] == 2){ echo 'checked="checked"'; }?> onclick="javascript:yesnoCheck();">
                                </div>
                                <div class="col-lg-8 col-sm-8" id="dvquanty" <?php if(isset($donation_data['radio_amount']) && $donation_data['radio_amount'] == 2){ ?>style="display: block"<?php } else { ?> style="display: none" <?php } ?>>
                                    <input type="number" name="quantity_amount" required id="dvquanty" value="<?php if(isset($donation_data['radio_amount']) && $donation_data['radio_amount'] == 2){ echo $donation_data['quantity_amount']; } else { ?>'0'<?php } ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <?php mk_hWYSItexteditor_required("description", 'Project Description', isset($donation_data['description']) ? $donation_data['description'] : '', 'description'); ?>

                            <div class="form-group ">
                                <label for="email_doc" class="control-label col-lg-2">Recepient Email <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="email_doc" name="email_doc" type="text" value="<?php if(isset($donation_data['email_doc'])) { echo $donation_data['email_doc']; } ?>" required data-error=".email_docerror">
                                    <div class="email_docerror error_msg"><?php echo form_error('email_doc', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <?php
                                // mk_htext("email_doc",_l('Recepient Email',$this),isset($donation_data['email_doc'])?$donation_data['email_doc']:'','');
                                // mk_hidden("relation_id",isset($relation_id)?$relation_id:0);
                            ?>

                            <div class="row margin0">
                                <div class="col-md-12">
                                    <?php $this->load->view('cms/donation/donation_image'); ?>
                                </div>
                            </div>

                            <?php $this->load->view('cms/donation/donation_documents'); ?>

                            <div class="form-group ">
                                <label for="tax_benefit" class="control-label col-lg-2">Tax Benifit <span><a title="Click checkbox to display this Donation on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="tax_checkbox" type="checkbox" <?php if(isset($donation_data['tax_benefit']) && $donation_data['tax_benefit'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('tax_benefit', (isset($donation_data['tax_benefit']) ? $donation_data['tax_benefit'] : '')); ?>" style="display: none;" id="tax_benefit" name="tax_benefit" checked="" type="text">
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="featured" class="control-label col-lg-2">Featured <span><a title="Click checkbox to display this Donation on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="featured_checkbox" type="checkbox" <?php if(isset($donation_data['featured']) && $donation_data['featured'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('featured', (isset($donation_data['featured']) ? $donation_data['featured'] : '')); ?>" style="display: none;" id="featured" name="featured" checked="" type="text">
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this Donation on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($donation_data['public']) && $donation_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($donation_data['public']) ? $donation_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/donation/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>


<script type="text/javascript">
    function sub_type_options() {
        var type_id = $("#type_id option:selected").val();
        if(type_id == '')
        {
            $('.sub_type_wrap').html('<select class="form-control select2" name="sub_donation_type" id="sub_donation_type" data-placeholder="-- Select Sub Type --"><option value="">-- Select Sub Type --</option></select>');
            // $('#sub_category_id').select2();
        }
        else
        {
            $("#zone_id").attr('disabled', 'disabled');
            $.ajax({
                type: "POST",
                dataType: "json",
                url : base_url+"cms/donation/get_subtype_options",
                data: {parent_id : type_id, sub_donation_type : '<?php echo (isset($donation_data["sub_dontype_id"]) ? $donation_data["sub_dontype_id"] : ""); ?>'},
                success: function(response) {
                    $("#sub_donation_type").removeAttr('disabled');
                    $('.sub_type_wrap').html('<select class="form-control select2" name="sub_donation_type" id="sub_donation_type" data-placeholder="-- Select Sub Type --">'+response+'</select>');
                    $('#sub_donation_type').select2();
                }
            });
        }
    }

    $(document).on('change', '#type_id', function (e) {
        sub_type_options();
    });

    sub_type_options();

    (function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());

    $('.cross-btn').click(function(){
        $(this).parent().parent().remove();
    });
</script>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">

    $('#start_date').datetimepicker({
        format:'Y-m-d H:i',
        //minDate:new Date()
    });

    $('#end_date_new').datetimepicker({
        format:'Y-m-d H:i',
        //minDate:new Date()
    });

    $(document).ready(function() {
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

        /* tax */

            if ($('#tax_checkbox').is(':checked')) {
                $('#tax_benefit').val(1);
            }else{
                $('#tax_benefit').val(0);
            }

            $('#tax_checkbox').click(function() {
                if($(this).is(':checked')){
                    $('#tax_benefit').val(1);
                }else{
                    $('#tax_benefit').val(0);
                }
            });

        /* featured */

            if ($('#featured_checkbox').is(':checked')) {
                $('#featured').val(1);
            }else{
                $('#featured').val(0);
            }

            $('#featured_checkbox').click(function() {
                if($(this).is(':checked')){
                    $('#featured').val(1);
                }else{
                    $('#featured').val(0);
                }
            });
            
        });


    $("#manage_form").validate({
        rules: {
            type_id: {
                required: true,
            },
            project_name: {
                required: true,
            },
            start_date: {
                required: true,
            },
            email_doc: {
                required: true,
            },
        },
        messages: {
            type_id: {
                required: 'Please select type',
            },
            project_name: {
                required: 'Please enter project name',
            },
            start_date: {
                required: 'Please select start date',
            },
            email_doc: {
                required: 'Please select email id',
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

<script type="text/javascript">

    function yesnoCheck() {
        if (document.getElementById('chkgoalamt_checkbox').checked) {
            document.getElementById('dvgoalamt').style.display = 'block';
        }
        else document.getElementById('dvgoalamt').style.display = 'none';

        if (document.getElementById('chkquanty_checkbox').checked) {
            document.getElementById('dvquanty').style.display = 'block';
        }
        else document.getElementById('dvquanty').style.display = 'none';

        if (document.getElementById('ending_checkbox').checked) {
            document.getElementById('end_date').style.display = 'block';
        }
        else document.getElementById('end_date').style.display = 'none';
    }

</script>


<style type="text/css">
    .checkbox{width: 20px;}
</style>

                                
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data['id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Category</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Category</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/nacc_category/'); ?>">Back </a></span>
            </div>
            
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="nacc_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-2">Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>  

                        <?php 
                        
                        if(isset($post_data['accreditation_id']) && !empty($post_data['accreditation_id']))
                        {
                           $accreditation_id = explode(",", $post_data['accreditation_id']);
                        }

						?>
						<div class="form-group ">
                            <label for="accreditation" class="control-label col-lg-2">Accreditation <span class="asterisk">*</span></label>
                            <div class="col-lg-10">

                                <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" name="accreditation_id[]" data-placeholder="Please select accreditation" required>
                                    <option value="">-- Please select accreditation --</option>
                                    <?php               
                                        foreach ($all_accreditation as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['id']; ?>" <?php if(isset($post_data['accreditation_id']) && in_array($value['id'], $accreditation_id)) { echo 'selected="selected"'; } ?>><?php echo $value['name']; ?></option>
                                        <?php
                                        
                                        }
                                    ?>
                                </select>
                                <div class="accreditation_iderror error_msg"><?php echo form_error('accreditation_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <?php 

                        // if(isset($post_data['parent_id']) && !empty($post_data['parent_id']))
                        // {
                        //    $parent_id = explode(",", $post_data['parent_id']);
                        // }

                        ?>
                        <!-- <div class="form-group ">
                            <label for="parent_id" class="control-label col-lg-2">Category</label>
                            <div class="col-lg-10">

                                <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" name="parent_id[]" data-placeholder="Please select category" >
                                    <option value="">-- Please select category --</option>
                                    <?php               
                                        foreach ($all_nacc_list as $key => $value) {
                                        ?>
                                           <option value="<?php //echo $value['id']; ?>" <?php //if(isset($post_data['parent_id']) && in_array($value['id'], $parent_id)) { echo 'selected="selected"'; } ?>><?php //echo $value['name']; ?></option>
                                        <?php
                                        
                                        }
                                    ?>
                                </select>
                            </div>
                        </div> -->

                        <div class="form-group ">
                            <label for="metric_number" class="control-label col-lg-2">Metric Number</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="metric_number" name="metric_number" value="<?php echo set_value('metric_number', (isset($post_data['metric_number']) ? $post_data['metric_number'] : '')); ?>" data-error=".metric_numbererror" maxlength="250">
                                <div class="metric_numbererror error_msg"><?php echo form_error('metric_number', '<label class="error">', '</label>'); ?></div>         
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <?php
                                    mk_hWYSItexteditor("description",_l('Description',$this),isset($post_data['description'])?$post_data['description']:'','');
                                ?>
                            </div>
                         </div>

                         <div class="form-group">
                            <label for="order_by" class="control-label col-lg-2">Order By</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="order_by" name="order_by" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo set_value('order_by', (isset($post_data['order_by']) ? $post_data['order_by'] : '')); ?>">
                            </div>
                        </div>
                        
                        <?php $this->load->view('cms/nacc/nacc_category/nacc_files'); ?>

                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this nacc on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/nacc_category/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->                                
    </div>
</div>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">
    $('#date').datetimepicker({
        format:'Y-m-d H:i',
    });

    $('#expiry_date').datetimepicker({
        format:'Y-m-d H:i',
    });
	
	$('#whats_new_expiry_date').datetimepicker({
        format:'Y-m-d',
        minDate:new Date()
    });

</script>


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

    $("#nacc_form").validate({
        rules: {
            name: {
                required: true,
            },
            accreditation_id: {
                required: true,
            },
            
        },
        messages: {
            name: {
                required: 'Please Enter Name',
            },
            accreditation_id: {
                required: 'Please Select Accreditation',
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

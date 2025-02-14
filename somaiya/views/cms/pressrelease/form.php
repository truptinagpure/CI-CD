<?php mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php $institute = $this->session->userdata('sess_institute_id') ?>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['pressrelease_id'])) {      ?>
                            <span class="caption-subject font-brown bold uppercase">Edit  Pressrelease</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add  Pressrelease</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/pressrelease/'); ?>">Back </a></span>
            </div>       
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php error_reporting(0);
                            $permissions = $data['institute_id']; 
                            $arr1 = explode(',' , $permissions);
                        if($institute == 50){ 
                        ?>
                        <div class="form-group">
                            <label for="span_small" class="control-label col-lg-2">Institute Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" multiple name="institute_id[]" data-placeholder="Select an Institute" required data-error=".Insterror">
                                    <?php if(isset($institutes_list) && count($institutes_list)!=0){ ?>
                                    <?php foreach ($institutes_list as $key2 => $data2) { ?>
                                        <option value="<?=$data2['INST_ID']?>" <?php if(in_array($data2['INST_ID'],$arr1)) echo ' selected';?>><?=$data2['INST_NAME']?></option>
                                    <?php } } ?>
                                </select>
                                 <div class="Insterror error_msg"><?php echo form_error('institute_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <?php } else if($institute != 50){
                            mk_hidden("institute_id[]",$institute);
                           print_r($instituteIDtest);
                        }?>
                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-2">Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($data['name']) ? $data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="control-label col-lg-2">Area of Interest <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="single" class="form-control select2" required name="category_id" data-placeholder="Select Area Of Interest" data-error=".catagoryerror">
                                <option value="">Select Area Of Interest</option>
                                    <?php if(isset($category) && count($category)!=0){ ?>
                                    <?php foreach ($category as $key3 => $data3) { ?>
                                        <option value="<?=$data3['category_id']?>" <?php if($data['category_id'] == $data3['category_id']) echo"selected"; ?>><?=$data3['category_name']?></option>
                                    <?php } } ?>
                                </select>


                                <div class="catagoryerror error_msg"><?php echo form_error('category_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="date" class="control-label col-lg-2">Publish  Date <span class="asterisk">*</span></label>&nbsp;&nbsp;
                            <input type="text" id="datetimepicker2" name="date" value="<?php if(isset($data['date'])) { echo $data['date']; } ?>" required />
                        </div>

                        <input type="hidden" name="contents_id" value="<?php echo $data['contents_id']; ?>">
                        <input type="hidden" name="data_type" value="pressrelease">
                        <input type="hidden" name="language_id" value="1">                                


                        <?php
                            mk_hWYSItexteditor("description",_l('Description',$this),isset($data['description'])?$data['description']:'','');

                            mk_hidden("relation_id",isset($relation_id)?$relation_id:0);
                        ?>

                        <div class="form-group ">
                            <label for="whats_new" class="control-label col-lg-2">What's New</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control whats_new" id="whats_new_checkbox" type="checkbox" <?php if(isset($data['whats_new']) && $data['whats_new'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('whats_new', (isset($data['whats_new']) ? $data['whats_new'] : '')); ?>" style="display: none;" id="whats_new" name="whats_new" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group expiry_wrap hidden">
                            <label for="data[whats_new_expiry_date]" class="control-label col-lg-2">What's New Expiry Date</label>
                            <div class="col-lg-10">
                                <input type="text" id="datetimepicker3" name="whats_new_expiry_date" value="<?php echo set_value('data[whats_new_expiry_date]', (isset($data['whats_new_expiry_date']) ? $data['whats_new_expiry_date'] : '')); ?>" />
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="public" class="control-label col-lg-2">Publish</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($data['public']) && $data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($data['public']) ? $data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/pressrelease/'); ?>"
                                 class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>
<?php
    mk_popup_uploadfile(_l('Upload Avatar',$this),"avatar",$base_url."upload_image/20/");
?>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">
    $('#datetimepicker1').datetimepicker({
        format:'Y-m-d',
        // minDate:new Date()
    });

    $('#datetimepicker2').datetimepicker({
        format:'Y-m-d',
        // minDate:new Date()
    });

    $('#datetimepicker3').datetimepicker({
        format:'Y-m-d',
        // minDate:new Date()
    });
</script>

<script type="text/javascript">
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

        /* whats new */

            if ($('#whats_new_checkbox').is(':checked')) {
                $('#whats_new').val(1);
            }else{
                $('#whats_new').val(0);
            }

            $('#whats_new_checkbox').click(function() {
                if($(this).is(':checked')){
                    $('#whats_new').val(1);
                }else{
                    $('#whats_new').val(0);
                }
            });
            
        });
</script>


<script type="text/javascript">
    $(document).ready(function(event) {
        if($('.whats_new').is(':checked')) {
            $('.expiry_wrap').removeClass('hidden');
            $('#whats_new1').val(1);
        }else{
            $('.expiry_wrap').addClass('hidden');
            $('#whats_new1').val(0);
        }
            
        $('.whats_new').click(function() {
            if($(this).is(':checked')){
                $('.expiry_wrap').removeClass('hidden');
                $('#whats_new1').val(1);
            }else{
                $('.expiry_wrap').addClass('hidden');
                $('#whats_new1').val(0);
            }
        });

        $('.cmxform').submit(function(event){
            if($('.whats_new').is(':checked')) {
                if($('#datetimepicker1').val() == '' || $('#datetimepicker1').val() == '0000-00-00')
                {
                    swal({
                        title: "Oops...",
                        text: "Please select expiry date for what's new section",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonClass: "btn btn-success mr10",
                        cancelButtonClass: "btn btn-danger",
                        buttonsStyling: false,
                        confirmButtonText: "Ok"
                    }).then(function () {
                    }, function(dismiss) {});
                    event.preventDefault();
                }
            }
        });
    });
</script>

<script type="text/javascript">
    $("#formval").validate({
            rules: {
                language_id: {
                    required: true,
                },
                name: {
                    required: true,
                },
                 category_id: {
                    required: true,
                },
                institute_id:{
                    required: true,
                },
            },
            messages: {
                language_id: {
                    required: 'Please select language',
                },
                name: {
                    required: 'Please enter name',
                },
                category_id:{
                    required: 'Please select Area of Interest',
                },
                institute_id:{
                    required:'Please select Institute Name',
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
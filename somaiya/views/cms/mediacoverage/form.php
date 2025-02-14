<div class="row cardwrappers">
    <div class="col-md-12 ">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($mediacoverage_data['mediacoverage_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Mediacoverage</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add mediacoverage</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/mediacoverage/'); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php
                        // echo "<pre>";
                        // print_r($mediacoverage_data);
                        // echo "<br>------------<br>";
                        // print_r($mediacoverage_type);
                        // exit();
                        ?>
                    <div class="row margin0">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="mediacoverage_name" class="control-label col-lg-2">Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="mediacoverage_name" name="mediacoverage_name" value="<?php echo set_value('mediacoverage_name', (isset($mediacoverage_data['title']) ? $mediacoverage_data['title'] : '')); ?>" required data-error=".mediacoverage_nameerror" maxlength="250" required>
                                    <div class="mediacoverage_nameerror error_msg"><?php echo form_error('mediacoverage_name', '<label class="error">', '</label>'); ?></div>
                                </div> 
                            </div>
                        </div>

                    </div>
                        <?php
                        if(isset($mediacoverage_data['category_id']))
                        {
                            $mediacoverage_cat_id = explode(',', $mediacoverage_data['category_id']);
                        }
                        ?>
                        <div class="row margin0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="area_of_interest" class="control-label col-lg-2">Area of Interest <span class="asterisk">*</span></label>
                                    <div class="col-lg-10 col-sm-10">
                                        <select id="" class="form-control select2-multiple" name="area_of_interest[]" data-placeholder="Please Select area of interest" multiple required>
                                            <option value="">Select Area of interest</option>
                                            <?php if(isset($category) && count($category)!=0){ ?>
                                            <?php foreach ($category as $key => $value) { ?>
                                                <option value="<?php echo $value['category_id']; ?>" <?php if( isset($mediacoverage_cat_id) && in_array($value['category_id'], $mediacoverage_cat_id)) echo"selected"; ?> > <?php echo $value['category_name']; ?></option>
                                            <?php } } ?>
                                        </select>

                                        <div class="area_of_interesterror error_msg"><?php echo form_error('area_of_interest', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row margin0">
                            <div class="col-lg-6">
                                 <div class="form-group">
                                    <label for="type" class="control-label col-lg-4">Type <span class="asterisk">*</span></label>
                                    <div class="col-lg-8">
                                        <select id="type" class="form-control select2" name="type" data-placeholder="Select Type" required>
                                        <option value="">Select Type</option>
                                            <option value="Print" <?php if(isset($mediacoverage_data['type']) && $mediacoverage_data['type'] == 'Print') echo"selected"; ?>>Print</option>
                                            <option value="Online" <?php if(isset($mediacoverage_data['type']) && $mediacoverage_data['type'] == 'Online') echo"selected"; ?>>Online</option>
                                            <option value="Electronic" <?php if(isset($mediacoverage_data['type']) && $mediacoverage_data['type'] == 'Electronic') echo"selected"; ?>>Electronic</option>
                                        </select>

                                        <div class="typeerror error_msg"><?php echo form_error('type', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div>
                            </div>
                           <div class="col-lg-6">
                            <div class="form-group">
                                <label for="source" class="control-label col-lg-2">Source <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="single" class="form-control select2" name="source" data-placeholder="Select Source" required>
                                    <option value="">Select Source</option>
                                        <?php if(isset($source) && count($source)!=0){ ?>
                                        <?php foreach ($source as $key => $value) { ?>
                                            <option value="<?=$value['id']?>" <?php if(isset($mediacoverage_data['source']) && $mediacoverage_data['source'] == $value['id']) echo"selected"; ?>><?=$value['source_name']?></option>
                                        <?php } } ?>
                                    </select>
                                    <div class="sourceerror error_msg"><?php echo form_error('source', '<label class="error">', '</label>'); ?></div>
                                </div> 
                            </div>
                        </div>
                        </div>

                        <?php
                            // echo "<pre>";
                            // print_r($source);
                            // echo "<br>------------<br>";
                            // echo "<pre>";
                            // print_r($mediacoverage_data);
                            // exit();
                        ?>  

                         <div class="row margin0">
                     

                        <?php
                        
                        // echo "<pre>";
                        // print_r($mediacoverage_data);
                        // exit();
                        // $selected_department_id    = array();

                        // if(!empty($mediacoverage_data['department_id']))
                        // {
                        //     $selected_department_id = explode(',' , $mediacoverage_data['department_id']);
                        // }
                        ?>
                        <!-- <div class="col-lg-6">
                             <div class="form-group">
                            <label for="department_id" class="control-label col-lg-4">Departments</label>
                            <div class="col-lg-8">
                                <select id="select2-multiple-input-lg" class="form-control select2" name="department_id[]" data-placeholder="Please Select Department" multiple><option value="">Select Departments</option>
                                    <?php //if(isset($departments) && count($departments)!=0){ ?>
                                    <?php //foreach ($departments as $key => $value) { ?>
                                        <option value="<?php //echo $value['Department_Id']; ?>" <?php //if( isset($selected_department_id) && in_array($value['Department_Id'], $selected_department_id)) echo"selected"; ?> > <?php //echo $value['Department_Name']; ?></option>
                                    <?php //} } ?>
                                </select>
                            </div>
                            </div>
                        </div> -->

                           <div class="col-lg-12">
                            <div class="form-group">
                                <label for="link_to_epaper" class="control-label col-lg-2">link to epaper</label>
                                <div class="col-lg-10">
                                    <input type="url" class="form-control" id="link_to_epaper" name="link_to_epaper" value="<?php echo set_value('link_to_epaper', (isset($mediacoverage_data['link_to_epaper']) ? $mediacoverage_data['link_to_epaper'] : '')); ?>" data-error=".link_to_epapererror" maxlength="250">
                                    <div class="link_to_epapererror error_msg"><?php echo form_error('link_to_epaper', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>  
                    </div>

                     <div class="row margin0">
                       

                        <div class="col-lg-6">
                             <div class="form-group">
                                <label for="related_person" class="control-label col-lg-4">Related Person&nbsp;<span><a title="specify the concern person for this mediacoverage." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="related_person" name="related_person" value="<?php echo set_value('related_person', (isset($mediacoverage_data['person']) ? $mediacoverage_data['person'] : '')); ?>" data-error=".related_personerror" maxlength="250">
                                    <div class="related_personerror error_msg"><?php echo form_error('related_person', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                                    <div class="form-group">
                                    <label for="start_date" class="control-label col-lg-2">Date <span class="asterisk">*</span></label>&nbsp;&nbsp;
                                    <input type="text" class="datetextbox col-lg-10" id="start_date" name="start_date" value="<?php if(isset($mediacoverage_data['date'])) { echo $mediacoverage_data['date']; } ?>" required />
                                    <!-- <div class="start_dateerror error_msg"><?php //echo form_error('start_date', '<label class="error">', '</label>'); ?></div> -->
                                 </div>
                            </div>
                    </div>

                        <input type="hidden" name="contents_id" value="<?php echo set_value('contents_id', (isset($mediacoverage_data['contents_id']) ? $mediacoverage_data['contents_id'] : '')); ?>" >
                        <input type="hidden" name="data_type" value="mediacoverage">
                        <input type="hidden" name="language_id" value="1"> <!-- 1=english lang -->   

                       
                        <div class="row margin0">
                            <div class="col-lg-12">
                                <?php
                                    mk_hWYSItexteditor("description",_l('Description',$this),isset($mediacoverage_data['description'])?$mediacoverage_data['description']:'','');
                                    //mk_hurl_upload("image",_l('Image',$this),isset($mediacoverage_data['image'])?$mediacoverage_data['image']:'',"image");
                                ?>
                            </div>
                        </div>

                        <div class="row margin0">
                            <div class="col-md-12">
                                <?php $this->load->view('cms/mediacoverage/media_image'); ?>
                            </div>
                        </div>
                        
                        <div class="row margin0">
                        <div class=" col-lg-12">
                            <div class="form-group">
                                <label for="whats_new" class="control-label col-lg-2">What's New&nbsp;<span><a title="Click checkbox to display this mediacoverage on homepage What’s New section." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control whats_new" id="whats_new_checkbox" type="checkbox" <?php if(isset($mediacoverage_data['whats_new']) && $mediacoverage_data['whats_new'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('whats_new', (isset($mediacoverage_data['whats_new']) ? $mediacoverage_data['whats_new'] : '')); ?>" style="display: none;" id="whats_new" name="whats_new" checked="" type="text">
                                </div>
                            </div>
                        </div>
                         </div>

                        <div class="row margin0">
                            <div class="expiry_wrap hidden col-lg-12">
                                <div class="form-group">
                                    <label for="data[whats_new_expiry_date]" class="control-label col-lg-2">What's New Expiry Date</label>
                                    <div class="col-lg-10">
                                        <input type="text" id="whats_new_expiry_date" name="whats_new_expiry_date" value="<?php echo set_value('data[whats_new_expiry_date]', (isset($mediacoverage_data['whats_new_expiry_date']) ? $mediacoverage_data['whats_new_expiry_date'] : '')); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row margin0">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="public" class="control-label col-lg-2">Publish</label>
                                    <div class="col-lg-10 col-sm-10">
                                        <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($mediacoverage_data['public']) && $mediacoverage_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                        <input value="<?php echo set_value('public', (isset($mediacoverage_data['public']) ? $mediacoverage_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>

                          <div class="row margin0">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/mediacoverage/'); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>                           
    </div>
</div>
<?php
    mk_popup_uploadfile(_l('Upload Image',$this),"image",$base_url."upload_image/20/");
    mk_popup_uploadfile(_l('Upload Meta Image',$this),"imagemeta",$base_url."upload_image/20/");
?>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script type="text/javascript">

    $('#start_date').datetimepicker({
        format:'Y-m-d H:i',
        //minDate:new Date()
    });

    $('#whats_new_expiry_date').datetimepicker({
        format:'Y-m-d H:i',
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
    $(document).ready(function(event) 
    {
        if($('.whats_new').is(':checked')) 
        {
            $('.expiry_wrap').removeClass('hidden');
            $('#whats_new1').val(1);
        }else{
            $('.expiry_wrap').addClass('hidden');
            $('#whats_new1').val(0);
        }
            
        $('.whats_new').click(function() 
        {
            if($(this).is(':checked'))
            {
                $('.expiry_wrap').removeClass('hidden');
                $('#whats_new1').val(1);
            }else{
                $('.expiry_wrap').addClass('hidden');
                $('#whats_new1').val(0);
            }
        });

        $('.cmxform').submit(function(event)
        {
            if($('.whats_new').is(':checked')) 
            {
                if($('#whats_new_expiry_date').val() == '' || $('#whats_new_expiry_date').val() == '0000-00-00')
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
            mediacoverage_name: {
                required: true,
            },
            area_of_interest: {
                required: true,
            },
            type: {
                required: true,
            },
            source: {
                required: true,
            },
            // department_id: {
            //     required: true,
            // },
            start_date: {
                required: true,
            },
        },
        messages: {
            mediacoverage_name: {
                required: 'Please Enter Mediacoverage Name',
            },
            area_of_interest: {
                required: 'Please Select Area of Interest',
            },
            type: {
                required: 'Please Select Type',
            },
            source: {
                required: 'Please Select Source',
            },
            // department_id: {
            //     required: 'Please Select Departments',
            // },
            start_date: {
                required: 'Please Select Date',
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
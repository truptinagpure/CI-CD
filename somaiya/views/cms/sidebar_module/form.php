    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($data['module_id'])) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Module</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Module</span>
                       <?php } ?>
                    </div>
                    &nbsp;&nbsp;
                    <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/Sidebar_module/index/'); ?>">Back</a></span>
                </div>

            <div class="panel-body">
                <div class=" form">
                    <?php error_reporting(0);
                    mk_hpostform(base_url().'cms/Sidebar_module'."/edit".(isset($data['module_id'])?"/".$data['module_id']:""));
                    ?>
                    <div class="form-group">
                            <label for="testimonial_type" class="control-label col-lg-2"> Module <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="main_module" class="form-control select2" required name="main_module" data-placeholder="Select Module" data-error=".typeerror">
                                 
                                  <?php if(isset($data['main_module'])){ ?>

                                    
                                        <option value="<?=$data['main_module']?>" selected><?=$data['main_module']?></option>
                                    <?php } ?>
                                    <option value="">Select Module </option>
                                    <option value="module">Institute Module</option>
                                    <option value="master">Master</option>
                                    <option value="vanaspatyam">Vanaspatyam</option>
                                    <option value="developer">Only for Developer</option>
                                    
                                </select>
                                <div class="typeerror error_msg"><?php echo form_error('main_module', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                    <div class="form-group">
                        <label for="data[parent_id]" class="control-label col-lg-2">Parent Module</label>
                        <div class="col-lg-10 col-sm-10">
                            <select id="group" class="form-control select2" name="data[parent_id]" data-placeholder="Select Parent Module">
                                <option value="">Select Parent Module</option>
                                <?php if(isset($module) && count($module)!=0){ ?>
                                <?php foreach ($module as $key2 => $data2) { ?>
                                    <option value="<?=$data2['module_id']?>" <?php if($data['parent_id'] == $data2['module_id']) echo"selected"; ?>><?=$data2['module_name']?>  <?php if($data2['parent_id'] == 0){ echo " - (Parent)"; }else{ echo " - (Child)"; } ?> </option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>
 
                    <?php

                    mk_htext("data[module_name]",_l('Module Name',$this),isset($data['module_name'])?$data['module_name']:'','required');
                    mk_htext("data[url]",_l('URL',$this),isset($data['url'])?$data['url']:'','');
                    ?>
                     <div class="form-group ">
                            <label for="Institute_id_check" class="control-label col-lg-2">Institute ID(for URL)</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="Institute_id_checkbox" type="checkbox" <?php if(isset($data['url_id']) && $data['url_id'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('url_id', (isset($data['url_id']) ? $data['url_id'] : '')); ?>" style="display: none;" id="url_id" name="url_id" checked="" type="text">
                            </div>
                        </div>
                        <?php
                    mk_htext("data[sort_order]",_l('Sort Order',$this),isset($data['sort_order'])?$data['sort_order']:'','');
                     mk_htext("data[icon]",_l('Icon',$this),isset($data['icon'])?$data['icon']:'','');
                      mk_htext("data[cums_under_menu]",_l('Comes under menu',$this),isset($data['cums_under_menu'])?$data['cums_under_menu']:'','');
 mk_htext("data[classname]",_l('Parent Module Class',$this),isset($data['classname'])?$data['classname']:'','');
                      ?>
                         <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Status</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($data['status']) && $data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($data['status']) ? $data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>
                        <?php
                    mk_hsubmit(_l('Submit',$this),base_url().'cms/sidebar_module',_l('Cancel',$this));
                    mk_closeform();
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>
<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">

    $(document).ready(function() 
    {
        /* status */
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
        

        /* status */
        if ($('#Institute_id_checkbox').is(':checked')) {
            $('#url_id').val(1);
        }else{
            $('#url_id').val(0);
        }

        $('#Institute_id_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#url_id').val(1);
            }else{
                $('#url_id').val(0);
            }
        });


    });

</script>
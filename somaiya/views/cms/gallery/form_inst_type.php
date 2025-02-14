<?php mk_use_uploadbox($this); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($data['ig_id'])) {      ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Institute Gallery Type</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Institute Gallery Type</span>
                       <?php } ?>    
                    </div>  
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/gallery_inst_type/'); ?>">Back </a></span>
                                   
                </div>
            <div class="panel-body">
                <div class=" form">
                    <?php error_reporting(0); //echo"<pre>";print_r($data);
                    mk_hpostform( base_url('cms/gallery_inst_type/edit').(isset($data['ig_id'])?"/".$data['ig_id']:"")); 

                    $permissions = $data['type_id']; 
                    $arr1 = explode(',' , $permissions);
                    //print_r($arr1);
                    ?>
                    <input type="hidden" id="institute_type_rel_id" name="institute_type_rel_id" value="<?php if(isset($data['ig_id']) && !empty($$data['ig_id'])) { echo $data['ig_id']; } ?>">

                    <div class="form-group">
                        <label for="span_small" class="control-label col-lg-2">Institute Name</label>
                        <div class="col-lg-10 col-sm-10">
                            <select id="single" class="form-control select2" name="data[institute_id]" data-placeholder="Select an Institute" data-placeholder="Select Institute" required data-error=".institute_iderror" onchange="check_institute_by_type_exit()">
                                <option value="">-- Select Institute --</option>
                                <?php if(isset($institutes_list) && count($institutes_list)!=0){ ?>
                                <?php foreach ($institutes_list as $key2 => $data2) { ?>
                                    <option value="<?=$data2['INST_ID']?>" <?php if($data['institute_id'] == $data2['INST_ID']) echo "selected"; ?>><?=$data2['INST_NAME']?></option>
                                <?php } } ?>
                            </select>
                            <div class="institute_iderror error_msg"><?php echo form_error('data[institute_id]', '<label class="error">', '</label>'); ?></div>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label for="span_small" class="control-label col-lg-2">Gallery Type</label>
                        <div class="col-lg-10 col-sm-10">
                            <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" multiple name="data[type_id][]" data-placeholder="Select Gallery Type" required>
                                <?php if(isset($type_list) && count($type_list)!=0){ ?>
                                <?php foreach ($type_list as $key3 => $data3) { ?>
                                    <option value="<?=$data3['id']?>" <?php if(in_array($data3['id'],$arr1)) echo 'selected';?>><?=$data3['type_name']?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>

                     <div class="form-group ">
                            <label for="public" class="control-label col-lg-2">Publish<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this gallery institute type on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($data['public']) && $data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($data['public']) ? $data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                    <?php mk_hsubmit(_l('Submit',$this),base_url('cms/gallery_inst_type/'),_l('Cancel',$this));
                    mk_closeform();

                    ?>


                </div>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript">

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

            $('.green').click(function() {
                //console.log("clicked");
                var error = $(".institute_iderror").text();
                //console.log(error);

                if(error == "")
                {
                    return true;
                }
                else
                {
                    return false;
                }
            });
            
        });
</script>

<script type="text/javascript">
    

    function check_institute_by_type_exit()
    {
        var institute_id = $("#single").val();
        var institute_type_rel_id = $("#institute_type_rel_id").val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'cms/gallery_inst_type/check_institute_by_type_exit'; ?>",
            //async: false,
            data: {institute_id : institute_id, institute_type_rel_id : institute_type_rel_id},
            success: function(response){
                //console.log("response : "+response);

                //if(response == "false")
                if(response > 0)
                {

                    console.log("false");

                    $('.institute_iderror').html('Institute and Type relation for this institute is already exist.');
                    $('.institute_iderror').addClass("error");
                    $('.institute_iderror').css("display", "block");
                    var check_institute_type_result = "false";
                    //return false;
                }
                else
                {
                    console.log("true");
                    $('.institute_iderror').html('');
                    $('.institute_iderror').removeClass("error");
                    $('.institute_iderror').css("display", "none");
                    var check_institute_type_result = "true";
                    // $("#submitId").html("Please Wait...");
                    // $("#submitId").attr('disabled', 'disabled');
                    // showLoader();
                    // form.submit();                    
                }

                return check_institute_type_result;
            }
        });
    }

</script>

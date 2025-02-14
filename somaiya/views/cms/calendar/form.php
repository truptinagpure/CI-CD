<div class="row">
    <div class="col-md-12">
        <?php $institute = $this->session->userdata('sess_institute_id'); ?>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Calendar</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Calendar</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/manage_calendar/'); ?>">Back</a></span>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php error_reporting(0);
                            $permissions = $post_data['institute_id']; 
                            $arr1 = explode(',' , $permissions);
                            $calendar_type_id = $post_data['calendar_type_id']; 
                            $arr2 = explode(',' , $calendar_type_id);
                            $calendar_sub_id = $post_data['calender_sub_type_id']; 
                            $arr3 = explode(',' , $calendar_sub_id);
                            $string_version = implode(',', $arr3);
                        /*if($institute == 50){ 
                        ?>
                            <div class="form-group">
                                <label for="span_small" class="control-label col-lg-2">Institute Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" multiple name="institute_id[]" data-placeholder="Select an Institute" required>
                                        <?php if(isset($institutes_list) && count($institutes_list)!=0){ ?>
                                        <?php foreach ($institutes_list as $key2 => $data2) { ?>
                                            <option value="<?=$data2['INST_ID']?>" <?php if(in_array($data2['INST_ID'],$arr1)) echo ' selected';?>><?=$data2['INST_NAME']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } else if($institute != 50){
                            mk_hidden("institute_id[]",$institute); 
                        } */?>
                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-2">Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($post_data['name']) ? $post_data['name'] : '')); ?>" required data-error=".nameerror" maxlength="255">
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <?php if($institute == '21') { ?>
                            <div class="form-group ">
                                <label for="pattern" class="control-label col-lg-2">Pattern </label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="pattern" name="pattern" value="<?php echo set_value('pattern', (isset($post_data['pattern']) ? $post_data['pattern'] : '')); ?>" maxlength="255">
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="calendar_type_id" class="control-label col-lg-2">Calendar Type <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="calendar_type_id" class="form-control input-lg select2-multiple" multiple name="calendar_type_id[]" data-error=".calendar_type_iderror" data-placeholder="-- Select Calendar Type --" required onChange="getSubtype();">
                                    <option value="">-- Select Calendar Type --</option>
                                    <?php foreach ($calendar_types as $key => $value) { ?>
                                        <option value="<?php echo $value['id']; ?>" <?php if(in_array($value['id'],$arr2)) echo ' selected';?>><?php echo $value['name']; ?></option>
                                    <?php } ?>
                                </select>
                                <div class="calendar_type_iderror error_msg"><?php echo form_error('calendar_type_iderror', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Calendar Sub Type</label>
                            <div class="col-lg-10 col-sm-10 sub_category_wrap">
                                <select class="form-control input-lg select2-multiple" name="calendar_sub_type_id[]" multiple id="calendar_sub_type_id" data-placeholder="-- Select Calendar Sub Type --">
                                    <option value="">-- Select Calendar Sub Type --</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="description" class="control-label col-lg-2">Description</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="description" name="description"><?php echo (isset($post_data['description']) ? $post_data['description'] : ''); ?></textarea>
                                <!-- <div class="description_error error_msg"><?php echo form_error('description', '<label class="error">', '</label>'); ?></div> -->
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="start_date" class="control-label col-lg-2">Start Date <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" id="start_date" name="start_date" data-error=".startdateerror" value="<?php echo set_value('start_date', (isset($post_data['start_date']) ? $post_data['start_date'] : '')); ?>" required />
                                <div class="startdateerror error_msg"><?php echo form_error('start_date', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="end_date" class="control-label col-lg-2">End Date <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" id="end_date" name="end_date" data-error=".enddateerror" value="<?php echo set_value('end_date', (isset($post_data['end_date']) ? $post_data['end_date'] : '')); ?>" required />
                                <div class="enddateerror error_msg"><?php echo form_error('end_date', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="chknogoal" class="control-label col-lg-2">Select Multiple Files</label>
                            <div class="col-lg-10 col-sm-10">
                                <input type="file" class="form-control" name="files" id="files" accept="application/pdf" multiple />
                            </div>

                            <br />  <br />

                            <?php
                                if(isset($document) && count($document)!=0){ 
                                foreach ($document as $key3 => $data3) { 
                            ?>  
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <a href='<?php echo base_url().'assets/calendar/'.$data3["document"]?>'>
                                        <img src="<?php echo base_url()?>assets/calendar/pdf.png" height="200">
                                    </a>

                                    <span class="close" style="cursor:pointer;" onclick="javascript:deletedocument(<?php echo $data3['id'] ?>)">X</span>
                                </div>
                            <?php
                                } }
                            ?>
                            <div style="clear:both"></div>
                            <br />
                            <br />
                            <div id="uploaded_images"></div>
                        </div>
                        <div class="form-group ">
                            <label for="status" class="control-label col-lg-2">Publish <span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this calendar type on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/manage_calendar/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<link href="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

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

    $('#start_date').datetimepicker({
        format:'Y-m-d',
        // minDate:new Date()
    });

    $('#end_date').datetimepicker({
        format:'Y-m-d',
        // minDate:new Date()
    });

    $("#manage_form").validate({
        rules: {
            // institute_id: {
            //     required: true,
            // },
            calendar_type_id: {
                required: true,
            },
            name: {
                required: true,
            },
            start_date: {
                required: true,
            },
            end_date: {
                required: true,
            },
        },
        messages: {
            // institute_id: {
            //     required: 'Please select institute',
            // },
            calendar_type_id: {
                required: 'Please select calendar type',
            },
            name: {
                required: 'Please enter name',
            },
            start_date: {
                required: 'Please select start date',
            },
            end_date: {
                required: 'Please select end date',
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


<script src="https://code.jquery.com/jquery-2.1.1.min.js"
    type="text/javascript"></script>
<script>
function getSubtype() {
        var str='';
        var val=document.getElementById('calendar_type_id');
        for (i=0;i< val.length;i++) { 
            if(val[i].selected){
                str += val[i].value + ','; 
            }
        }         
        var str=str.slice(0,str.length -1);
        console.log(str);

    $.ajax({          
            type: "POST",
            dataType: "json",
            url: base_url+"cms/manage_calendar/get_sub_options",
            data: {calendar_type_id : str, calendar_sub_type_id : '<?php echo $string_version; ?>'},
            // data:'calendar_type_id='+str,
            success: function(data){
                $("#calendar_sub_type_id").html(data);
            }
    });
} getSubtype();
</script>

<script type="text/javascript">
    function deletedocument(id)
    {
    var answer = confirm ("Are you sure you want to delete from this document?");
    if (answer)
    {
        $.ajax({
                type: "POST",
                url: "<?php echo site_url('calendar/manage_calendar/deletedocument');?>",
                data: "id="+id,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+id).remove(".imagelocation"+id);
                  };
                  
                }
            });
        window.location.reload();
    }
    }
</script>

<script type="text/javascript">
    $('#files').change(function(){
      var relation_id =  "<?php echo $post_data['id']; ?>";
      var files = $('#files')[0].files;
      var error = '';
      var form_data = new FormData();
      for(var count = 0; count<files.length; count++)
      {
       var name = files[count].name;
       var extension = name.split('.').pop().toLowerCase();
       if(jQuery.inArray(extension, ['pdf']) == -1)
       {
        error += "Invalid " + count + " Image File"
       }
       else
       {
        form_data.append("files[]", files[count]);
       }
      }
      if(error == '')
      { 
       $.ajax({
        url:"<?php echo base_url(); ?>calendar/manage_calendar/upload_document/"+relation_id, //base_url() return http://localhost/tutorial/codeigniter/
        method:"POST",
        data:form_data,
        contentType:false,
        cache:false,
        processData:false,
        beforeSend:function()
        {
         $('#uploaded_images').html("<label class='text-success'>Uploading...</label>");
        },
        success:function(data)
        {
         $('#uploaded_images').html(data);
         $('#files').val('');
        }
       })
      }
      else
      {
       alert(error);
      }
    });
</script>
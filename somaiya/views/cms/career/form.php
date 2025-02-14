<?php error_reporting(0); ?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($id) && !empty($id)) { ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Job</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Job</span>
                   <?php } ?>
                </div>
                &nbsp;&nbsp;
                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/career/'); ?>">Back</a></span>
            </div>
            <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">
                <div class="portlet-body form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group ">
                                <label for="job_name" class="control-label col-lg-2">Job Name <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="job_name" name="job_name" value="<?php echo set_value('job_name', (isset($post_data['job_name']) ? $post_data['job_name'] : '')); ?>" required data-error=".job_nameerror" maxlength="250">
                                    <div class="job_nameerror error_msg"><?php echo form_error('job_name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="job_code" class="control-label col-lg-2">Job Code <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="job_code" name="job_code" value="<?php echo set_value('job_code', (isset($post_data['job_code']) ? $post_data['job_code'] : '')); ?>" required data-error=".job_codeerror" maxlength="250">
                                    <div class="job_codeerror error_msg"><?php echo form_error('job_code', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="job_cat" class="control-label col-lg-2">Job Category <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="job_cat" class="form-control select2" name="job_cat" required data-error=".job_caterror" data-placeholder="-- Select Category --">
                                        <option value="">-- Select Category --</option>
                                        <?php foreach ($category as $key => $value) { ?>
                                            <option value="<?php echo $value['cat_id']; ?>" <?php if(isset($post_data['job_cat']) && $post_data['job_cat'] == $value['cat_id']){ echo 'selected="selected"'; } ?>><?php echo $value['category_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="job_caterror error_msg"><?php echo form_error('job_cat', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="data[Department_Id]" class="control-label col-lg-2">Department <span class="asterisk">*</span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="single" class="form-control select2" name="Department_Id" data-placeholder="Select Department" required data-error=".department_codeeerror">
                                        <option value="">Select Department</option>
                                        <?php if(isset($department) && count($department)!=0){ ?>
                                        <?php foreach ($department as $key3 => $data3) { ?>
                                            <option value="<?=$data3['Department_Id']?>" <?php if($post_data['job_department'] == $data3['Department_Id']) echo"selected"; ?>><?=$data3['Department_Name']?></option>
                                        <?php } } ?>
                                    </select>
                                    <div class="department_codeeerror error_msg"><?php echo form_error('Department_Id', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="email" class="control-label col-lg-2">Email <span class="asterisk">*</span> <span><a title="This field will get email id if it is predefined for institute. Also, you can add additional email ids separated by comma, on which applicant's details will be sent." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10" id="email">
                                    <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($email[0]['CAREER_MODULE_EMAIL_LIST']) && count($email[0]['CAREER_MODULE_EMAIL_LIST'])!=0){ echo $email[0]['CAREER_MODULE_EMAIL_LIST']; } else { ?><?php echo set_value('job_email', (isset($post_data['job_email']) ? $post_data['job_email'] : '')); } ?>" required data-error=".emailerror">
                                    <div class="emailerror error_msg"><?php echo form_error('email', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="application_type" class="control-label col-lg-2">Walk-in</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="application_type_checkbox" type="checkbox" <?php if(isset($post_data['application_type']) && $post_data['application_type'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('application_type', (isset($post_data['application_type']) ? $post_data['application_type'] : '')); ?>" style="display: none;" id="application_type" name="application_type" checked="" type="text">
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="valid_till" class="control-label col-lg-2">Valid Till <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" id="datetimepicker2" name="valid_till" value="<?php if(isset($post_data['valid_till'])) { echo $post_data['valid_till']; } ?>" required data-error=".valid_tillerror"/>
                                    <div class="valid_tillerror error_msg"><?php echo form_error('valid_till', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="control-label col-lg-2">Keywords</label>
                                <div class="col-lg-10"><br />
                                    <input type="text" name ="career_keywords" value="<?=$post_data['career_keywords']?>" data-role="tagsinput" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="chknogoal" class="control-label col-lg-2">Select Multiple Files</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input type="file" class="form-control" name="files" id="files" multiple />
                                </div>

                                <br />  <br />

                                <?php
                                    if(isset($career_documents) && count($career_documents)!=0){ 
                                    foreach ($career_documents as $key3 => $data3) { 
                                ?>  
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <?php $ext = pathinfo($data3["document"], PATHINFO_EXTENSION); //echo $ext;
                                        if($ext=='jpg' or $ext=='jpeg' or $ext=='png') { ?>
                                            <img src=<?php echo base_url().'assets/career_upload/'.$data3["document"]?> class="img-responsive img-thumbnail" height="200" />                                         
                                        <?php } elseif($ext=='doc' OR $ext=='docx') { ?>
                                            <a href='<?php echo base_url().'assets/career_upload/'.$data3["document"]?>'><img src="<?php echo base_url()?>assets/career_upload/doc.png" height="200"></a>
                                        <?php } elseif($ext=='pdf') { ?>
                                            <a href='<?php echo base_url().'assets/career_upload/'.$data3["document"]?>'><img src="<?php echo base_url()?>assets/career_upload/pdf.png" height="200"></a>
                                        <?php } ?>

                                        <span class="close" style="cursor:pointer;" onclick="javascript:deletedocument(<?php echo $data3['doc_id'] ?>)">X</span>
                                    </div>
                                <?php
                                    } }
                                ?>
                                <div style="clear:both"></div>
                                <br />
                                <br />
                                <div id="uploaded_images"></div>
                            </div>

                            <?php $predifined_description = "<div><p></p></div><div class='crgreybox'><h3 class='jbsubheading'>Qualification:</h3><ul class='Llist-main jb-list'><li><b>UG:</b></li><li><b>PG:</b></li></ul><h3 class='jbsubheading'>Required Experience:</h3><h3 class='jbsubheading'>Salary:</h3></div>";?>
                            <?php
                                mk_hWYSItexteditor("job_description",_l('Job Description <span><a title="In this field, headings are available to add Qualification, Experience, Salary etc. You can also add additional information like Time and other details. If any heading is not required you can delete it." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span>',$this),isset($post_data['job_description'])?$post_data['job_description']:$predifined_description,'required');

                                mk_hWYSItexteditor("job_keyskills",_l('Key Skills',$this),isset($post_data['job_keyskills'])?$post_data['job_keyskills']:'','');
                            ?>

                            <div class="form-group ">
                                <label for="status" class="control-label col-lg-2">Publish <span><a title="Click checkbox to display this event on live website or else it will be saved in CMS draft." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="status_checkbox" type="checkbox" <?php if(isset($post_data['status']) && $post_data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('status', (isset($post_data['status']) ? $post_data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/career/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
<style type="text/css">.fa-info-circle{font-size: 18px;}</style>
<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />

<script type="text/javascript">
    $('#datetimepicker2').datetimepicker({
        format:'Y-m-d H:i:s',
        minDate:new Date()
    });
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
       if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','pdf', 'doc', 'docx']) == -1)
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
        url:"<?php echo base_url(); ?>cms/career/career_documents/"+relation_id, //base_url() return http://localhost/tutorial/codeigniter/
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

        if ($('#application_type_checkbox').is(':checked')) {
                $('#application_type').val(1);
        }else{
            $('#application_type').val(0);
        }

        $('#application_type_checkbox').click(function() {
            if($(this).is(':checked')){
                $('#application_type').val(1);
            }else{
                $('#application_type').val(0);
            }
        }); 
    });


    $("#manage_form").validate({
        rules: {
            job_name: {
                required: true,
            },
            job_cat: {
                required: true,
            },
            Department_Id: {
                required: true,
            },
            job_code: {
                required: true,
            },
            email: {
                required: true,
            },
            valid_till: {
                required: true,
            },
        },
        messages: {
            job_name: {
                required: 'Please enter job name',
            },
            job_cat: {
                required: 'Please select job category',
            },
            Department_Id: {
                required: 'Please select department',
            },
            job_code: {
                required: 'Please enter job code',
            },
            email: {
                required: 'Please enter email',
            },
            valid_till: {
                required: 'Please select valid till',
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
    function deletedocument(image_id)
    {
    var answer = confirm ("Are you sure you want to delete from this document?");
    if (answer)
    {
        $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/career/deletedocument');?>",
                data: "image_id="+image_id,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                  };
                  
                }
            });
        window.location.reload();
    }
    }
</script>
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
                            <span class="caption-subject font-brown bold uppercase">Edit  Testimonial</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add  Testimonial</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/testimonial/'); ?>">Back </a></span>
            </div>       
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="" enctype="multipart/form-data"> 
                        <?php error_reporting(0);
                            $permissions = $data['institute_id']; 
                            $arr1 = explode(',' , $permissions);
                        ?>

                         <div class="form-group">
                            <label for="testimonial_type" class="control-label col-lg-2"> Tesimonial Type <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="testimonial_type" class="form-control select2" required name="testimonial_type" data-placeholder="Select Tesimonial Type" data-error=".typeerror">
                                <option value="">Select Tesimonial Type</option>    
                                  <?php if(isset($data['testimonial_type'])){ ?>
                                    
                                        <option value="<?=$data['testimonial_type']?>" selected><?=$data['testimonial_type']?></option>
                                    <?php } ?>
                                    <option value="Faculty">Faculty</option>
                                    <option value="Staff">Staff</option>
                                    <option value="Corporate">Corporate</option>
                                    <option value="Student">Student</option>
                                    <option value="Alumni">Alumni</option>
                                </select>
                                <div class="typeerror error_msg"><?php echo form_error('testimonial_type', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-2">Title <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($data['name']) ? $data['name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_id" class="control-label col-lg-2">Category <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="single" class="form-control select2" required name="category_id" data-placeholder="Select Category" data-error=".catagoryerror">
                                <option value="">Select Category</option>
                                    <?php if(isset($category) && count($category)!=0){ ?>
                                    <?php foreach ($category as $key3 => $data3) { ?>
                                        <option value="<?=$data3['id']?>" <?php if($data['category_id'] == $data3['id']) echo"selected"; ?>><?=$data3['category_name']?></option>
                                    <?php } } ?>
                                </select>
                                <div class="catagoryerror error_msg"><?php echo form_error('category_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                       <div class="form-group ">
                            <label for="batch" class="control-label col-lg-2">Batch <span class="asterisk"></span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="batch" name="batch" value="<?php echo set_value('batch', (isset($data['batch']) ? $data['batch'] : '')); ?>"  maxlength="250">
                                <div class="batcherror error_msg"> </div>
                            </div>
                        </div>
                      
                       
<!-- start display image video -->

<?php
if(isset($data['image']) && !empty($data['image'])){?>

    <div class="form-group">  <label class="control-label col-lg-2">uploaded Image / Videod <span class="asterisk"></span></label>
                                   
                                    <div class="col-lg-10 col-sm-10">
    <?php
$extarray = array("jpeg", "jpg", "png", "svg");
$extarray1 = array("wmv", "mp4", "avi", "mov","mp3");
$ext = pathinfo($data['image'], PATHINFO_EXTENSION);
 if( in_array($ext, $extarray) and $data['image']!='') {  //echo "m here in img";
                                    ?>
                                        <ul class="imagelocation<?php echo $data['id'] ?> gallerybg" id="sortable">
                                            <li id="item-<?php echo $data['id'] ?>">
                                                <img src="<?php echo base_url(); ?>upload_file/kjsieit/testimonial/<?php echo $data['image']; ?>" style="vertical-align:middle;" width="80" height="80">
                                               <!--  <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('projects/deletefeaimage/'.$post_data["project_id"]); ?>');">X</a> -->

                                                <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/testimonial/deletefeaimage/'.$data["id"]); ?>');">X</a>
                                            </li>
                                        </ul>
                                    <?php } elseif(in_array($ext, $extarray1)) { //echo "m here in video";?>

                                        <ul class="imagelocation<?php echo $data['id'] ?> gallerybg" id="sortable">
                                            <li id="item-<?php echo $data['id'] ?>">
                                                <!-- <img src="<?php echo base_url(); ?>upload_file/video_icon.png" style="vertical-align:middle;" width="80" height="80"> -->
                                                <video class="respimg" width="320" height="240" controls>
                                                    <source src="<?php echo base_url(); ?>upload_file/kjsieit/testimonial/<?=$data['image']?>" type="video/<?=$ext?>"></source>
                                                </video>
                                              <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/testimonial/deletefeaimage/'.$data["id"]); ?>');">X</a>
                                            </li>
                                        </ul>
                                    <?php } ?>

</div>
                        </div>
<?php
}else{
?>

 <div class="form-group ">
                           
                       <label class="control-label col-lg-2">uploaded Image / Videod <span class="asterisk"></span></label>

<div class="col-lg-10 col-sm-10">
                                    <input type="file" id="upload_image" name="upload_image" size="33" />
                            </div>      
                        </div>


                        <?php } ?>


<!-- end display image video -->

 <div class="form-group ">
                            <label for="video_url" class="control-label col-lg-2">Video URL </label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="video_url" name="video_url" value="<?php echo set_value('video_url', (isset($data['video_url']) ? $data['video_url'] : '')); ?>"  data-error=".video_urlerror" maxlength="250">
                                <div class="video_urlerror error_msg"><?php echo form_error('video_url', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
  <div class="form-group ">
                            <label for="embed_code" class="control-label col-lg-2">Embed Code</label>
                            <div class="col-lg-10">
                                <textarea class="form-control" id="embed_code" name="embed_code"  data-error=".embed_codeerror"><?php echo set_value('embed_code', (isset($data['embed_code']) ? $data['embed_code']:''  )); ?></textarea>
                                <div class="embed_codeerror error_msg"><?php echo form_error('embed_code', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <?php
        mk_hWYSItexteditor("description",_l('Description',$this),isset($data['description'])?$data['description']:'','');
        mk_hidden("relation_id",isset($relation_id)?$relation_id:0);
                        ?>
                            <div class="form-group ">
                            <label for="public" class="control-label col-lg-2">Status</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($data['status']) && $data['status'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($data['status']) ? $data['status'] : '')); ?>" style="display: none;" id="status" name="status" checked="" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('cms/testimonial/'); ?>"
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
                $('#status').val(1);
            }else{
                $('#status').val(0);
            }

            $('#public_checkbox').click(function() {
                if($(this).is(':checked')){
                    $('#status').val(1);
                }else{
                    $('#status').val(0);
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
$(document).ready(function() { 
       $("#video_url").focusout(function() { 
        
        var image='<?php echo $data['image'];?>';

        if( typeof(image) != "undefined" && image !== null && image.length>1)
        {console.log(image);

             alert("Image or video already selected ");
            $(this).val('');
              $('#embed_code').val('');
        }
        else{

        var value = $('#upload_image').val();
        var name = value.split(/[\\/]/);
        var uploadfilename=name[name.length - 1];
        console.log(uploadfilename);
        if(uploadfilename!=='' && uploadfilename!== null  && uploadfilename.length>1){
 alert("Image or video already selected sasa");
            $(this).val('');
              $('#embed_code').val('');
        }else{
           
        }

            }

     }); 


              $("#embed_code").focusout(function() { 
        
       var image='<?php echo $data['image'];?>';

        if( typeof(image) != "undefined" && image !== null && image.length>1)
        {console.log(image);

             alert("Image or video already selected ");
            $(this).val('');
              $('#embed_code').val('');
        }
        else{

        var value = $('#upload_image').val();
        var name = value.split(/[\\/]/);
        var uploadfilename=name[name.length - 1];
        console.log(uploadfilename);
        if(uploadfilename!=='' && uploadfilename!== null  && uploadfilename.length>1){
 alert("Image or video already selected sasa");
            $(this).val('');
              $('#video_url').val('');
        }else{
           
        }

            }


     }); 

 }); 
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
                type_id:{
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
 required: 'Please select Category',

                },
                institute_id:{
required:'Please select Institute Name',

                },
                type_id:{
required:'Please select Testimonial Type',

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
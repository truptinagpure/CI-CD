<link href="<?php echo base_url(); ?>assets/layouts/layout/image_upload/styles.imageuploader.css" rel="stylesheet" type="text/css">

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <?php error_reporting(0); ?>
            <?php $abc = $_SESSION['sess_institute_id'] ?>
            <?php $inst_name = $_SESSION['sess_institute_name'] ?>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                            <?php 
                             if(isset($data['g_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Gallery</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Gallery</span>
                    <?php } ?>
                    </div>   
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/gallery'); ?>">Back </a></span>
                                  
                </div>
            <div class="panel-body">
                <div class=" form">
                    <form method="POST" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' id="formval">
                    
                      

                        <div class="form-group">
                            <label for="span_small" class="control-label col-lg-2">Title <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input type="text" name="title"  value="<?php echo set_value('title', (isset($data['title']) ? $data['title'] : '')); ?>" class="form-control" required id="title" />
                                <input type="hidden" name="g_id"  value="<?php echo set_value('g_id', (isset($data['g_id']) ? $data['g_id'] : '')); ?>" id="file" placeholder="class">
                                <input type="hidden" name="name"  value="<?php echo set_value('name', (isset($data['name']) ? $data['name'] : '')); ?>" class="form-control" required id="name" readonly>
                                <!-- <input type="hidden" name="name" value="<?php //echo $data['name']; ?>" class="form-control" required id="name" readonly> -->
                            </div>
                        </div>

                        <?php if($abc == 50){ ?>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Institute <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="gallery_for" class="form-control select2" name="gallery_for" data-placeholder="Select Institute" required>
                                <option value="">Select Institute</option>
                                    <?php if(isset($institute) && count($institute)!=0){?>
                                    <?php foreach ($institute as $key2 => $data2) { ?>
                                        <option value="<?=$data2['INST_ID']?>" <?php if(isset($data['gallery_for']) && !empty($data['gallery_for'])){if($data['gallery_for'] == $data2['INST_ID']) echo"selected";} ?>><?=$data2['INST_NAME']?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <?php } else if($abc != 50){ ?>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Institute <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="gallery_for" class="form-control select2" name="gallery_for" data-placeholder="Select Institute" required>
                                    <option value="<?=$abc?>" selected="selected"><?=$inst_name?></option>
                                </select>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="form-group" id="newgaltype">
                            <label class="control-label col-lg-2">Type</label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="single2" class="form-control select2" name="type_id" data-placeholder="Select Type">
                                    <option value="">Select Type</option>
                                </select>
                            </div>
                        </div>

                        <?php if($abc == 50) { ?>
                        <div class="form-group" id="galtype">
                            <label class="control-label col-lg-2">Type</label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="single" class="form-control select2" name="type_id" data-placeholder="Select Type">
                                <option value="">Select Type</option>
                                    <?php if(isset($type) && count($type)!=0){ ?>
                                    <?php foreach ($type as $key3 => $data3) { ?>
                                        <option value="<?=$data3['id']?>" <?php if(isset($data['gallery_for']) && !empty($data['gallery_for'])){ if($data['type_id'] == $data3['id']) echo"selected"; } ?>><?=$data3['type_name']?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <?php } else if($abc != 50){ ?>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Type</label>
                                <div class="col-lg-10 col-sm-10">
                                    <select class="form-control select2" name="type_id" data-placeholder="Select Type">
                                        <option value="">Select Type</option>
                                        <?php if(isset($gallerytype) && count($gallerytype)!=0){ ?>
                                        <?php foreach ($gallerytype as $key => $data6) { ?>
                                            <option value="<?=$data6['id']?>" <?php if($data['type_id'] == $data6['id']) echo"selected"; ?>><?=$data6['type_name']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group ">
                            <label for="date" class="control-label col-lg-2">Date <span class="asterisk">*</span></label>&nbsp;&nbsp;&nbsp;
                            <input type="text" id="datetimepicker2" name="date" value="<?php if(isset($data['date'])) { echo $data['date']; } ?>" required />
                        </div>

                        

                      
                            <?php 
                            //comment feature image code as per requirement
                            /*error_reporting(0);if(isset($data['featured_img']) && !empty($data['featured_img'])){ ?>
                            
                            <?php
                                if($data['featured_img']!='')
                                { ?>
                                      <div class="form-group">
                                    <label class="control-label col-lg-2">Featured Image</label>
                            <div class="col-lg-10 col-sm-10">
                                <ul class="imagelocation<?php echo $data33['g_id'] ?> gallerybg" id="sortable">
                                  <li id="item-<?php echo $data33['g_id'] ?>">
                                    <img src="<?php echo base_url(); ?>upload_file/images20/<?php echo $data33['name']; ?>/<?php echo $data33['featured_img']; ?>" style="vertical-align:middle;" width="80" height="80">
                                    <span class="close" style="cursor:pointer;" onclick="javascript:deletefeaimage(<?php echo $data33['g_id'] ?>)">X</span>
                                  </li>
                                </ul>
                                </div>
                                </div>
                            <?php  } 
                                 }
                           else{?>

                        <div class="form-group">
                            <label class="control-label col-lg-2">Featured Image <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input type="file" name="featured" id="featured" accept=".png,.jpg,.jpeg,.gif" >
                            </div>
                        </div>

                        <?php } */ ?>
                            
                        

						<div class="row">
                            <div class="col-lg-12">
                                <?php if(isset($gallery_data_image) && is_array($data) && count($data)): $i=1; ?>
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Uploaded Images</label>
                                    <div class="col-lg-10 col-sm-10">
                                        <?php 
                                        foreach ($gallery_data_image as $key => $data1) { 
                                        ?>
                                            <ul class="imagelocation<?php echo $data1['id'] ?> gallerybg" id="sortable">
                                              <li>
                                                <img src="<?php echo base_url(); ?>upload_file/images20/<?php echo $data1['name']; ?>/<?php echo $data1['image']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                <span class="close" style="cursor:pointer;" onclick="javascript:deleteimage(<?php echo $data1['id'] ?>)">X</span>
                                                    
                                                <input class="form-control" type="hidden" name="existing_image_id[]" value="<?php echo $data1['id'] ?>">
                                                <input class="form-control" type="text" name="existing_image_name[]" value="<?php echo $data1['image_name']; ?>">
                                                <input class="form-control" type="text" name="existing_image_description[]" value="<?php echo $data1['image_description']; ?>">
                                              </li>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Multiple Image</label>
                                    <div class="col-lg-10 col-sm-10">
                                        <div class="uploader__box js-uploader__box l-center-box">
                                            <div class="uploader__contents">
                                                <label class="button button--secondary" for="fileinput">Multiple Images</label>
                                                <input id="fileinput" class="uploader__file-input" type="file" multiple value="Select Files">
                                            </div>
                                            <input class="button button--big-bottom" type="submit" value="Upload Selected Files">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="form-group ">
                            <label for="public" class="control-label col-lg-2">Publish&nbsp;<span><a title="" data-toggle="tooltip" data-placement="right" data-original-title="Click checkbox to display this gallery on live website or else it will be saved in CMS draft."><i class="fa fa-info-circle" aria-hidden="true"></i></a></span></label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($data['public']) && $data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($data['public']) ? $data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <div class="col-lg-offset-2 col-lg-10">
                             <input class="btn green" type="submit" value="Submit">
                            <a href="<?=base_url()?>cms/gallery/" class="btn btn-default" type="button">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

<link href="<?=base_url()?>assets/js-date/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/js-date/jquery.datetimepicker.full.js"></script>

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
        });
</script>

<script type="text/javascript">

    $('#datetimepicker2').datetimepicker({
        format:'Y-m-d',
        minDate:new Date()
    });

</script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/layouts/layout/image_upload/jquery.imageuploader.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>


<script type="text/javascript">
function deleteimage(image_id)
{
var answer = confirm ("Are you sure you want to delete from this post?");
if (answer)
{
        $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/deleteimage');?>",
                data: "image_id="+image_id,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                  };
                  
                }
            });
      }
}


function deletefeaimage(image_id)
{ 
var answer = confirm ("Are you sure you want to delete from this post?");
window.location.reload();
if (answer)
{
        $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/deletefeaimage');?>",
                data: "image_id="+image_id,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                  };
                  
                }
            });
      }
}

</script>

<style type="text/css">
 .gallerybg li{float:left;list-style-type: none;    width: 29%; margin-left: 10px;}
 .close{position: absolute;margin-left: 10px;}
 .gallerybg li input {
    margin-top: 20px;
}
</style>


<script type="text/javascript">
    $(function() {
    $('#name').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});


    $.fn.copyTo = function(selector) {
    $(selector).val($(this[0]).val().replace(/[^A-Z0-9]+/ig, "_"));
};

<?php if(empty($data['g_id'])) {?>
    $(document).ready(function () {


        $("#title").keyup(function() {
            $("#title").copyTo("#name");
        });
    });
    <?php } ?>
(function(){
    var options = {};
    $('.js-uploader__box').uploader(options);
}());
</script>

<!-- <script type="text/javascript">
    $(function() {
    $('#name').on('keypress', function(e) {
        if (e.which == 32)
            return false;
    });
});


$("#sortable").sortable();
</script> -->

<style type="text/css">#newgaltype{display: none;}</style>
<script type="text/javascript">

<?php 
    if(empty($data['g_id']))
    {
    ?>
        $(document).ready(function(){
            $('#gallery_for').on('change',function(){
                var countryID = $(this).val();
                 document.getElementById("galtype").style.display = "block";
                document.getElementById("newgaltype").style.display = "none";

                if(countryID){
                    $.ajax({
                        type:'POST',
                        url:"<?php echo site_url('admin/appendgaltype');?>",
                        data:'institute_id='+countryID,
                        success:function(html){
                            //$('#galtype').html(html);
                            $('#single2').html(html);
                        }
                    }); 
                }else{
                    //$('#galtype').html('<option value="">Select Institute First</option>');
                    $('#single2').html('<option value="">Select Institute First</option>');
                }
            });
            
        });
    <?php 
    }
    else
    {
        ?>
        $(document).ready(function(){
            $("#gallery_for").on("change", function(){
                document.getElementById("galtype").style.display = "none";
                document.getElementById("newgaltype").style.display = "block";
                  var countryID = $(this).val();
                    if(countryID){
                        $.ajax({
                            type:'POST',
                            url:"<?php echo site_url('admin/appendgaltype');?>",
                            data:'institute_id='+countryID,
                            success:function(html){
                                $('#single2').html(html);
                            }
                        }); 
                    }else{
                        $('#single2').html('<option value="">Select Institute First</option>');
                    }
            });
        });
        <?php
    }

    ?>

</script>

<script type="text/javascript">
    $("#formval").validate({
            rules: {
                gallery_for: {
                    required: true,
                },
                title: {
                    required: true,
                },
                date: {
                    required: true,
                },
            },
            messages: {
                gallery_for: {
                    required: 'Please select institute',
                },
                title: {
                    required: 'Please enter name',
                },
                date: {
                    required: 'Please select date',
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
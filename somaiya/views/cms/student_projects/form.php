    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <?php $institute = $_SESSION['inst_id'] ?>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <?php if(isset($project_id) && !empty($project_id)) { ?>
                            <span class="caption-subject font-brown bold uppercase">Edit Student Project</span>
                        <?php } else { ?>
                             <span class="caption-subject font-brown bold uppercase">Add New Student Project</span>
                       <?php } ?>                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/studentprojects/index/'); ?>">Back </a></span>
                </div> <?php //print_r($post_data); exit();?>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="project_form" class="cmxform form-horizontal tasi-form" method="post" action="" enctype='multipart/form-data'>
                            <div class="form-group ">
                                <label for="name" class="control-label col-lg-2">Student Project Title <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name', (isset($post_data['title']) ? $post_data['title'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                    <div class="nameerror error_msg"><?php echo form_error('name', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>

                            <?php error_reporting(0);
                            $permissions = $post_data['institute_id']; 
                            $arr1 = explode(',' , $permissions); 
                            if($institute == 50){
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
                            <?php } else if($institute == 22 OR $institute == 35 OR $institute == 16){
                                mk_hidden("institute_id[]",$institute); 
                            }?>

                            <?php
                                // echo "<pre>";
                                // print_r($post_data);
                                // exit();
                            ?>
                            
                            <?php if($institute == 16) { ?>
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Student Team Logo </label>
                                    <div class="col-lg-10 col-sm-10">
                                        <?php error_reporting(0);
                                            if(isset($post_data['team_logo']) && !empty($post_data['team_logo']) && count($post_data['team_logo']) > 0){ 
                                        ?>
                                            <ul class="imagelocation<?php echo $post_data['student_project_id'] ?> gallerybg" id="sortable">
                                                <li id="item-<?php echo $post_data['student_project_id'] ?>">
                                                    <img src="<?php echo base_url(); ?>upload_file/images20/<?php echo $post_data['team_logo']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                    <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/studentprojects/deletefeaimage/'.$post_data["student_project_id"]); ?>');">X</a>
                                                </li>
                                            </ul>                        

                                        <?php 
                                            } 
                                        ?> 
                                        <div class="form-group">
                                            <div class="col-lg-10 col-sm-10">
                                                <input type="file" name="image" id="image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Student Team Logo</label>
                                    <div class="col-lg-10 col-sm-10">
                                    <?php error_reporting(0);
                                        if(isset($post_data) && is_array($post_data) && count($post_data)){ $i=1; 
                                            $ext = pathinfo($post_data['team_logo'], PATHINFO_EXTENSION);
                                            if($ext!='mp4' and $post_data['team_logo']!='') {  //echo "m here in img";
                                    ?>
                                        <ul class="imagelocation<?php echo $post_data['student_project_id'] ?> gallerybg" id="sortable">
                                            <li id="item-<?php echo $post_data['student_project_id'] ?>">
                                                <img src="<?php echo base_url(); ?>upload_file/images20/<?php echo $post_data['team_logo']; ?>" style="vertical-align:middle;" width="80" height="80">
                                                <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/studentprojects/deletefeaimage/'.$post_data["student_project_id"]); ?>');">X</a>
                                            </li>
                                        </ul>
                                    <?php } elseif($ext=='mp4') { //echo "m here in video";?>
                                        <?php /*
                                        <ul class="imagelocation<?php echo $post_data['project_id'] ?> gallerybg" id="sortable">
                                            <li id="item-<?php echo $post_data['project_id'] ?>">
                                                <!-- <img src="<?php echo base_url(); ?>upload_file/video_icon.png" style="vertical-align:middle;" width="80" height="80"> -->
                                                <video class="respimg" width="320" height="240" controls>
                                                    <source src="<?php echo base_url(); ?>upload_file/images20/<?=$post_data['image']?>" type="video/<?=$ext?>"></source>
                                                </video>
                                                <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('projects/deletefeaimage/'.$post_data["project_id"]); ?>');">X</a>
                                            </li>
                                        </ul> */ ?>
                                    <?php } ?>

                                    <?php if($post_data['team_logo']=='') {?>

                                    <div class="form-group">
                                        <div class="col-lg-10 col-sm-10">
                                            <input type="file" name="image" id="image"   accept=".png,.jpg,.jpeg,.gif,.mp4,.mpeg,.mpg,.avi,.mov">
                                        </div>
                                    </div>

                                    <?php } } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            // echo "<pre>";
                            // print_r($data_image);
                            // exit();
                            ?>
                            <?php if(isset($data_image) && is_array($post_data) && count($post_data)): $i=1; ?>
                            <div class="form-group">
                                <label class="control-label col-lg-2">Uploaded Images</label>
                                <div class="col-lg-10 col-sm-10 row_position">
                                <?php
                                    foreach ($data_image as $key => $data) { 
                                        $ext = pathinfo($data['image'], PATHINFO_EXTENSION);
                                ?>
                                    <ul class="imagelocation<?php echo $data['id'] ?> gallerybg" id="sortable">
                                        <li style="list-style: none;" data-id="<?php echo $data['id'] ?>">
                                            <?php if($ext == 'mp4') { ?>
                                                <video class="respimg" width="200" height="200" controls>
                                                    <source src="<?php echo base_url(); ?>upload_file/images20/<?=$data['image']?>" type="video/<?=$ext?>"></source>
                                                </video>
                                            <?php } else { ?>
                                                <img src="<?php echo base_url(); ?>upload_file/images20/<?php echo $data['image']; ?>" style="vertical-align:middle;" width="200" height="200">
                                            <?php } ?>
                                            <a href="javascript:void(0);" class="btn btn_bg_custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/studentprojects/deleteimage/'.$data["id"].'?student_project_id='.$data["student_project_id"]); ?>');">X</a>
                                        </li>
                                    </ul>
                                <?php } ?>
                                </div>
                            </div>

                            <?php endif; ?>

                       
                                <div class="form-group">
                                    <label class="control-label col-lg-2">Upload Images </label>
                                    <div class="col-lg-10 col-sm-10">
                                        <input type="file" name="userfile[]" id="image_file" data-max-size="8192‬" accept=".png,.jpg,.jpeg,.gif,.mp4,.mpeg,.mpg,.avi,.mov" multiple <?php if($data_image == '') {?> <?php } else { ?> <?php } ?>>
                                    </div>
                                </div>
                          
                            <?php
                            // echo "<pre>";
                            // print_r($post_data);
                            // exit();
                            ?>
                            <input type="hidden" name="student_project_content_id" value="<?php echo $post_data['content_id']; ?>">
                            <input type="hidden" name="student_project_id" value="<?php echo $post_data['student_project_id']; ?>">
                            <input type="hidden" name="language_id" value="1">

                            <?php 
                                mk_hWYSItexteditor("description",_l('Description',$this),isset($post_data['description'])?$post_data['description']:'','required');
                                //mk_hWYSItexteditor("content",_l('Content',$this),isset($post_data['content'])?$post_data['content']:'','required');
                            ?>

                            <div class="form-group ">
                                <label for="featured_project" class="control-label col-lg-2">Featured</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="featured_project_checkbox" type="checkbox" <?php if(isset($post_data['featured_project']) && $post_data['featured_project'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('featured_project', (isset($post_data['featured_project']) ? $post_data['featured_project'] : '')); ?>" style="display: none;" id="featured_project" name="featured_project" checked="" type="text">
                                </div>
                            </div>

                            <div class="form-group ">
                                <label for="public" class="control-label col-lg-2">Publish</label>
                                <div class="col-lg-10 col-sm-10">
                                    <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($post_data['public']) && $post_data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                    <input value="<?php echo set_value('public', (isset($post_data['public']) ? $post_data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/studentprojects/index/') ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>


    <style>
div.boxform{
    border: 1px solid lightgrey;
    padding: 25px;
    margin: 25px;
}
</style>


<script type="text/javascript">
    // i=$('.group_wrap').length;
/*i=1;
$(document).on('click', 'a.add', function (e) {
    e.preventDefault();
    $(".group_wrap:last").after('<tr class="group_wrap"><td class="group_td"><div class="p10"><input type="text" id="singlegrp'+i+'" name="pname[]" Placeholder="Name"></div></td><td class="institute_td"><div class="p10"><input type="text" id="singleinst'+i+'" name="amount[]" Placeholder="Amount"></div></td><td class="institute_td"><div class="p10"></div><input type="file" name="logo[]" id="singleimg'+i+'" accept=".png,.jpg,.jpeg,.gif" multiple></td><td class="add_remove_td"><div class="p10"><a class="removeMore'+i+'" data-id="'+i+'"><i title="<?=_l("Delete",$this)?>" class="fa fa-trash-o"></i></a></div></td></tr>');
    // removeMore();
    $(".removeMore"+i).click(function(){
        var pid = $(this).attr("data-id");
        var answer = confirm ("Are you sure you want to delete?");
        if(answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php //echo site_url('projects/deletedonor');?>",
                data: "pid="+pid,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+pid).remove(".imagelocation"+pid);
                  };
                }
            });
        }
        $(this).parent().parent().parent().fadeOut("slow", function() {
            // $(this).parent().parent().parent().remove();
            $(this).remove();
        });
    });
    i++;
});

$(".removeMore").click(function(){
    var pid = $(this).attr("data-id");
    var answer = confirm ("Are you sure you want to delete?");
    if(answer)
    {
        $.ajax({
            type: "POST",
            url: "<?php //echo site_url('projects/deletedonor');?>",
            data: "pid="+pid,
            success: function (response) {
              if (response == 1) {
                $(".imagelocation"+pid).remove(".imagelocation"+pid);
              };
            }
        });
    }
    $(this).parent().parent().parent().fadeOut("slow", function() {
        // $(this).parent().parent().parent().remove();
        $(this).remove();
    });
});*/
</script>


    <script type="text/javascript">
        $(document).ready(function() {


             $('#image_file').on('change', function() { 
            const size =  
               (this.files[0].size / 1024 / 1024).toFixed(2); 
  
            if (size > 8 || size == 8 ) { 
                alert("File size must be less than 8 MB"); 
               
            } else { 
               
            } 
        });  


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

            if ($('#featured_project_checkbox').is(':checked')) {
                $('#featured_project').val(1);
            }else{
                $('#featured_project').val(0);
            }

            $('#featured_project_checkbox').click(function() {
                if($(this).is(':checked')){
                    $('#featured_project').val(1);
                }else{
                    $('#featured_project').val(0);
                }
            });
            
        });

        $("#project_form").validate({
            rules: {
                name: {
                    required: true,
                },
                
            },
            messages: {
                name: {
                    required: 'Please enter student project title',
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $( ".row_position" ).sortable({
            placeholder : "ui-state-highlight",
            update  : function(event, ui)
            {
                var programme_id_array = new Array();
                $('.row_position>ul li').each(function(){
                    programme_id_array.push($(this).attr("data-id"));
                });
                $.ajax({
                    type: "POST",
                    //url: "<?php //echo site_url('admin/save_projectimg_order');?>",
                    url: "<?php echo site_url('cms/studentprojects/save_student_projectimg_order');?>",
                    data: {programme_id_array:programme_id_array},
                    success:function(data)
                    {
                        alert(data);
                    }
                });
            }
        });
    });
</script>
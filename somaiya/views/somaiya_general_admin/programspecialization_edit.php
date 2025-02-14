<?php mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
    <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php error_reporting(0); $institute = $_SESSION['inst_id'] ?>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <span class="caption-subject font-brown bold uppercase"><?=isset($data['title'])?_l("Edit",$this)." ".'':_l("Add",$this)?> Content</span>
                </div> 
                <!-- &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php //echo base_url('admin/programspecialization/'.(isset($data["data_type"])?$data["data_type"]."/":"").(isset($data["data_type"])?$data["relation_id"]."/":"")); ?>">Back </a></span> -->
            </div>
            <div class="portlet-body form" id="drag">
                    <div class="form-body">
                    <form id="user_manipulate" class="cmxform form-horizontal tasi-form" method="post" action="<?=$base_url.$page."_manipulate".(isset($data['contents_id'])?"/".$data['contents_id']:"")?>">
                        <div class="form-group ">
                            <label for="specialization_name" class="control-label col-lg-2">Specialization Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="specialization_name" name="specialization_name" value="<?php echo isset($data['specialization_name'])?$data['specialization_name']:''; ?>" required="" data-error=".specialization_nameerror" type="text">
                                <div class="specialization_nameerror error_msg"><?php echo form_error('specialization_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        <?php
                            //mk_htext("specialization_name",_l('Specialization Name',$this),isset($data['specialization_name'])?$data['specialization_name']:'','required');
                            if(isset($data['contents_id']))
                            {
                        ?>
                                <!-- <div class="form-group"> -->
                                    <!-- <label for="data[language_id]" class="control-label col-lg-2">Language</label> -->
                                    <!-- <div class="col-lg-10 col-sm-10"> -->
                                        <?php
                                            // if(isset($languages) && count($languages)!=0)
                                            // {
                                            //     foreach ($languages as $key22 => $data22) {
                                        ?>
                                                    <!-- <input value="<?=$data22['language_id']?>" type="hidden" name="language_id" /><?=$data22['language_name']?> -->
                                        <?php
                                            //     }
                                            // }
                                        ?>
                                        <?php 
                                            //foreach ($lang_name as $key => $value) { ?>
                                                <!-- <input value="<?=$value['language_id']?>" type="hidden" name="language_id" /><?=$value['language_name']?> -->
                                        <?php     //}
                                        ?>
                                    <!-- </div> -->
                                <!-- </div> -->
                        <?php
                            // }
                            // else
                            // { 
                        ?>
                                <!-- <div class="form-group">
                                    <label for="language_id" class="control-label col-lg-2">Language <span class="asterisk">*</span></label>
                                    <div class="col-lg-10 col-sm-10">
                                        <select id="language_id" class="form-control" name="language_id" required data-error=".languageerror">
                                            <option value="">-- Select Language --</option>
                                            <?php foreach ($languages as $key => $value) { ?>
                                            <option value="<?php echo $value['language_id']; ?>" <?php if(isset($data['language_id']) && $data['language_id'] == $value['language_id']){ echo 'selected="selected"'; } ?>><?php echo $value['language_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="languageerror error_msg"><?php echo form_error('language_id', '<label class="error">', '</label>'); ?></div>
                                    </div>
                                </div> -->
                        <?php
                            }
                        ?>
                        <input type="hidden" value="1" name="language_id" />
                        <?php 
                            if(isset($data['contents_id']))
                            {
                        ?>
                                <div class="form-group ">
                                    <label for="Key Information" class="control-label col-lg-2">Key Information</label>
                                    <div class="col-lg-10">
                                        <?php
                                            if(isset($courseshortcode) && count($courseshortcode)!=0)
                                            {
                                                mk_htext("program_code",_l('Program Code',$this),isset($courseshortcode['program_code'])?$courseshortcode['program_code']:'','readonly');
                                                mk_htext("LOCATION_ID",_l('Campus',$this),isset($courseshortcode['location_name'])?$courseshortcode['location_name']:'','readonly');
                                                mk_htext("DURATION",_l('Duration',$this),isset($courseshortcode['DURATION'])?$courseshortcode['DURATION']." ".$courseshortcode['UOM_OF_DURATION']:'','readonly');
                                                mk_htext("COURSE_TYPE",_l('Course Type',$this),isset($courseshortcode['COURSE_TYPE'])?$courseshortcode['COURSE_TYPE']:'','readonly');
                                                mk_htext("MODE_OF_STUDY",_l('Mode of Study',$this),isset($courseshortcode['MODE_OF_STUDY'])?$courseshortcode['MODE_OF_STUDY']:'','readonly');
                                                mk_htext("AREA_OF_STUDY_NAME",_l('Area Of Study',$this),isset($courseshortcode['AREA_OF_STUDY_NAME'])?$courseshortcode['AREA_OF_STUDY_NAME']:'','readonly');
                                                mk_htext("LEVEL_OF_STUDY_NAME",_l('Level of Study',$this),isset($courseshortcode['LEVEL_OF_STUDY_NAME'])?$courseshortcode['LEVEL_OF_STUDY_NAME']:'','readonly');
                                                mk_htext("DISCIPLINE_NAME",_l('Discipline',$this),isset($courseshortcode['DISCIPLINE_NAME'])?$courseshortcode['DISCIPLINE_NAME']:'','readonly');
                                            }
                                        ?>
                                    </div>
                                </div>
                        <?php
                            }
                        ?>

                        <!-- <div class="form-group ">
                            <label class="control-label col-lg-2">Keywords</label>
                            <div class="col-lg-10"><br />
                                <input type="text" name ="programme_keywords" value="<?=$data['programme_keywords']?>" data-role="tagsinput" />
                            </div>
                        </div> -->

                        <?php $user_id = $this->session->userdata['user_id']; 
                            if($user_id == 1) {
                        ?>
                        <div class="fields_wrap">
                            <div class="form-group ">
                                <label for="url" class="control-label col-lg-2">Program URL <span class="asterisk">*</span></label>
                                <div class="col-lg-10">
                                    <input class=" form-control" id="url" name="url" value="<?php echo isset($data['url'])?$data['url']:''; ?>" required="" data-error=".urlerror" type="text">
                                    <div class="urlerror error_msg"><?php echo form_error('url', '<label class="error">', '</label>'); ?></div>
                                </div>
                            </div>
                        </div>
                        <?php } else { ?>
                            <input class=" form-control" id="url" name="url" value="<?php echo isset($data['url'])?$data['url']:''; ?>" type="hidden">
                        <?php } ?>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">Read More IN</label>
                            <div class="col-lg-10"><br />
                                <textarea class="ckeditor" name="read_more_in"><?php if(isset($data['read_more_in'])) { echo $data['read_more_in']; } ?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="control-label col-lg-2">Introduction</label>
                            <div class="col-lg-10"><br />
                                <textarea class="ckeditor" name="description"><?php if(isset($data['description'])) { echo $data['description']; } ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="row_position">
                                        <?php
                                            if(isset($widgetvalue) && count($widgetvalue)!=0)
                                            {
                                        ?>
                                                <input type="hidden" name="widgets_array_check" value="2">
                                                <?php
                                                    $i=20;
                                                    foreach ($widgetvalue as $key3 => $data3) {
                                                ?>
                                                        <div data-id="<?php echo $data3['p_id'] ?>" id="<?=$key3;?>" class="col-lg-12 widget_wrap">
                                                            <div class="col-lg-12 dragicon">
                                                                <!-- <i class="fa fa-ellipsis-h" aria-hidden="true"></i> -->
                                                                <img alt="" src="http://stage.somaiya.edu/assets/arigel_general/img/Drag-icon.png"/>
                                                            </div>
                                                            <div class="panel-heading" role="tab" id="heading<?=$key3;?>">
                                                                <label class="control-label col-lg-2">Widget Name</label>
                                                                <div class="col-lg-10 form-group">
                                                                    <div id="widget_name_wrap_<?php echo $key3; ?>">
                                                                        <input id="widget_name_<?php echo $key3; ?>" class="form-control" name="widget_name[]" type="text" value="<?php if(isset($data3['name'])) { echo $data3['name']; } ?>" required="" />
                                                                    </div>
                                                                </div>
                                                                <h4 class="panel-title">
                                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$key3;?>" aria-expanded="true" aria-controls="collapse<?=$key3;?>">
                                                                        <i class="more-less glyphicon glyphicon-plus"></i>
                                                                       
                                                                    </a>
                                                                </h4>
                                                            </div>
                                                            <div id="collapse<?=$key3;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$key3;?>">
                                                                <div class="panel-body">
                                                                    <div id="ckeditor_wrap_<?php echo $key3; ?>">
                                                                        <?php mk_hWYSItexteditor_v1("widgets[]",_l('Description',$this),isset($data3['desvalue'])?$data3['desvalue']:'','des-'.$key3); ?>
                                                                    </div>
                                                                    
                                                                    <div class="form-group ">
                                                                        <label for="publish" class="control-label col-lg-2">Publish</label>
                                                                        <div class="col-lg-10 col-sm-10">
                                                                            <input style="width: 20px" class="checkbox form-control publish_checkbox" id="publish_checkbox_<?php echo $key3; ?>" data-id="<?php echo $key3; ?>" onclick="publish_checkbox('<?php echo $key3; ?>');" type="checkbox" <?php if(isset($data3['publish']) && $data3['publish'] == 1){ echo 'checked="checked"'; } ?>>
                                                                            <input value="<?php echo (isset($data3['publish'])?$data3['publish']:'0') ?>" style="display: none;" id="publish_<?php echo $key3; ?>" name="publish[]" type="text">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <label for="widget_title_display" class="control-label col-lg-2">Widget title not display on bar</label>
                                                                        <div class="col-lg-10 col-sm-10">
                                                                            <input style="width: 20px" class="checkbox form-control widget_checkbox" id="widget_checkbox_<?php echo $key3; ?>" data-id="<?php echo $key3; ?>" onclick="widget_checkbox('<?php echo $key3; ?>');" type="checkbox" <?php if(isset($data3['widget_title_display']) && $data3['widget_title_display'] == 1){ echo 'checked="checked"'; } ?>>
                                                                            <input value="<?php echo (isset($data3['widget_title_display'])?$data3['widget_title_display']:'0') ?>" style="display: none;" id="widget_<?php echo $key3; ?>" name="widget_title_display[]" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                             <div class="col-lg-12 panel-footer" role="tab">
                                                                    <div class="bgrow">
                                                                        <div class="col-lg-8"></div>
                                                                        <div class="col-lg-4">
                                                                            <ul class="googlepro">
                                                                                <li>
                                                                                    <a onclick="javascript:deletewidgets(<?php echo $data3['p_id'] ?>)" class="circle" title="<?=_l('Delete',$this)?>"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                   <a class="reset circle" title="Reset" onclick="reset_widget('<?php echo $key3; ?>');"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                                                                </li>
                                                                                <li>
                                                                                    <a class="circle add" href="#" title="Add Widget"><i class="fa fa-plus" aria-hidden="true"></i>
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <a title="Duplicate" class="circle" href="javascript:void(0);" onclick="duplicate_widget('<?php echo $key3; ?>');"><i class="fa fa-refresh" aria-hidden="true"></i>
                                                                                    </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <input type='hidden' name='p_id[]' value='<?php echo $data3['p_id'] ?>' />
                                                            <input type='hidden' name='widget_order[]' value='<?php echo $data3['widget_order'] ?>' />
                                                        </div>  
                                                <?php
                                                        $i++;
                                                    }
                                            }
                                            else
                                            {
                                        ?>
                                                <input type="hidden" name="widgets_array_check" value="1">
                                                <div id="0" class="widget_wrap widget_wrap ui-sortable-handle col-lg-12">
                                                    <div class="panel-heading" role="tab" id="heading0">
                                                        <label for="widget_name[]" class="control-label col-lg-2">Widget Name</label>
                                                        <div class="col-lg-10 form-group">
                                                            <div id="widget_name_wrap_0">
                                                                <input class=" form-control" name="widget_name[]" type="text" value="<?php if(isset($data3['name'])) { echo $data3['name']; } ?>" id="widget_name_0" required="">
                                                            </div>
                                                        </div>
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse0" aria-expanded="true" aria-controls="collapse0">
                                                                <i class="more-less glyphicon glyphicon-plus"></i>
                                                               
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapse0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading0">
                                                        <div class="panel-body">
                                                            <div id="ckeditor_wrap_0">
                                                                <?php mk_hWYSItexteditor_v1("widgets[]",_l('Description',$this),isset($data3['desvalue'])?$data3['desvalue']:'','des-0'); ?>
                                                            </div>
                                                            <div class="form-group ">
                                                                <label for="publish" class="control-label col-lg-2">Publish</label>
                                                                <div class="col-lg-10 col-sm-10">
                                                                    <input style="width: 20px" class="checkbox form-control publish_checkbox" id="publish_checkbox_<?php echo $key3; ?>" data-id="<?php echo $key3; ?>" onclick="publish_checkbox('<?php echo $key3; ?>');" type="checkbox" <?php if(isset($data3['publish']) && $data3['publish'] == 1){ echo 'checked="checked"'; } ?>>
                                                                    <input value="<?php echo (isset($data3['publish'])?$data3['publish']:'0') ?>" style="display: none;" id="publish_<?php echo $key3; ?>" name="publish[]" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <label for="widget_title_display" class="control-label col-lg-2">Widget title not display on bar</label>
                                                                <div class="col-lg-10 col-sm-10">
                                                                    <input style="width: 20px" class="checkbox form-control widget_checkbox" id="widget_checkbox_<?php echo $key3; ?>" data-id="<?php echo $key3; ?>" onclick="widget_checkbox('<?php echo $key3; ?>');" type="checkbox" <?php if(isset($data3['widget_title_display']) && $data3['widget_title_display'] == 1){ echo 'checked="checked"'; } ?>>
                                                                    <input value="<?php echo (isset($data3['widget_title_display'])?$data3['widget_title_display']:'0') ?>" style="display: none;" id="widget_<?php echo $key3; ?>" name="widget_title_display[]" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                      
                                                    </div>
                                                    <div style="clear:both;"></div>
                                                      <div class="panel-footer" role="tab">
                                                            <div class="row bgrow">
                                                                <div class="col-lg-8"></div>
                                                                <div class="col-lg-4">
                                                                    <ul class="googlepro">
                                                                        <li>
                                                                            <a onclick="javascript:deletewidgets(<?php echo $data3['p_id'] ?>)" class="circle" title="<?=_l('Delete',$this)?>"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                           <a class="reset circle" title="Reset" onclick="reset_widget('<?php echo $key3; ?>');"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                                                        </li>
                                                                        <li>
                                                                            <a class="circle add" href="#" title="Add Widget"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                        </li>
                                                                        <li>
                                                                            <a title="Duplicate" class="circle" href="javascript:void(0);" onclick="duplicate_widget('<?php echo $key3; ?>');"><i class="fa fa-refresh" aria-hidden="true"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <div class="col-lg-12">
                                <div class="000"></div>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div class="form-group">
                            <label class="control-label col-lg-3" style="font-size:16px;font-weight:bold;">Apply Now</label>&nbsp;&nbsp;
                            <hr />
                        </div>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <?php mk_hWYSItexteditor("apply",_l('Apply Now',$this),isset($data['apply'])?$data['apply']:'','required'); ?>
                            </div>
                        </div>

                        <?php //mk_hnumber("order",_l('Order Number',$this),isset($data['order'])?$data['order']:''); ?>
                        
                        <div class="form-group ">
                            <label for="meta_title" class="control-label col-lg-2">Meta Title</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="meta_title" name="meta_title" type="text" value="<?=$data['meta_title']?>" maxlength="80">
                                (Maximum Character Limit is 80)
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="meta_description" class="control-label col-lg-2">Meta Description</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="meta_description" name="meta_description" type="text" value="<?=$data['meta_description']?>" maxlength="180">
                                (Maximum Character Limit is 180)
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="meta_keywords" class="control-label col-lg-2">Meta keywords</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="meta_keywords" name="meta_keywords" type="text" value="<?=$data['meta_keywords']?>">
                            </div>
                        </div>

                        <?php
                            mk_hurl_upload("meta_image",_l('Meta Image',$this),isset($data['meta_image'])?$data['meta_image']:'',"imagemeta");
                            //mk_hcheckbox("public",_l('Publish',$this),(isset($data['public']) && $data['public']==1)?1:null);
                        ?>

                        <div class="form-group">
                            <label for="public" class="control-label col-lg-2">Publish</label>
                            <div class="col-lg-10 col-sm-10">
                                <input style="width: 20px" class="checkbox form-control" id="public_checkbox" type="checkbox" <?php if(isset($data['public']) && $data['public'] == 1){ echo 'checked="checked"'; } ?>>
                                <input value="<?php echo set_value('public', (isset($data['public']) ? $data['public'] : '')); ?>" style="display: none;" id="public" name="public" checked="" type="text">
                            </div>
                        </div>

                        <?php
                            mk_hsubmit(_l('Submit',$this),$base_url.$page.(isset($data_type)?"/".$data_type:'').(isset($relation_id)?"/".$relation_id:""),_l('Cancel',$this));
                            mk_hidden("relation_id",isset($relation_id)?$relation_id:0);
                            mk_hidden("data_type",isset($data_type)?$data_type:'');
                            mk_closeform();
                        ?>

                        <!-- <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('admin/programcontents/'.$relation_id); ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div> -->
                    <!-- </form> -->
                </div>
            </div>
        </div>
    <!-- END SAMPLE FORM PORTLET-->                                
    </div>
</div>
<?php 
    mk_popup_uploadfile(_l('Upload Meta Image',$this),"imagemeta",$base_url."upload_image/20/");
?>

<style type="text/css">
.fa-plus{text-indent:4px;}
    .row_position{cursor:move;}

.portlet .form-group { margin-bottom: 20px;}
    .add{color: #fff;font-size: 12px; font-weight: 600; text-transform: uppercase;}
    .btn{border-radius:0;}
    .form-horizontal .control-label { font-size: 16px; text-align: left;}
    .green,.btn-default{margin: 0 auto; width: 16%;}
    .center{text-align: center;}
    .googlepro .circle{ padding: 7px; background: #fff; color: #000;  width: 28px; height: 30px; text-align: center; border: transparent;
    margin-left: 10px;}
    .circle:hover{ background: #9a9999;}
    .googlepro li{ display: inline;}
    .googlepro{margin-bottom: 4px; text-align: right; margin-top: 4px;}
    .bgrow{background:#F0F0F0; margin-top: 0px;}
    a:hover{ color: #ff2283;  position: relative;}

    a[title]:hover:after{
    content: attr(title);
    padding: 6px 12px;
    color: #fff;font-size: 10px;
    position: absolute;
    right: 0;
    top: 100%;
    white-space: nowrap;
    z-index: 20;
    -moz-border-radius: 3px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    -moz-box-shadow: 0px 0px 2px #c0c1c2;
    -webkit-box-shadow: 0px 0px 2px #c0c1c2;
    box-shadow: 0px 0px 2px #c0c1c2;
    background-image: -moz-linear-gradient(top, #ffffff, #eeeeee);
    background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0, #ffffff),color-stop(1, #eeeeee));
    background-image: -webkit-linear-gradient(top, #9a9999, #716767);
    background-image: -moz-linear-gradient(top, #ffffff, #eeeeee);
    background-image: -ms-linear-gradient(top, #ffffff, #eeeeee);
    background-image: -o-linear-gradient(top, #ffffff, #eeeeee);
    }
    .dragicon{text-align: center; margin: 0 auto 20px;}
    .ui-sortable-handle{padding: 10px 0 0;
    margin-bottom: 40px;
    border-left: 3px solid #33c6d4;
    border-right: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    border-top: 1px solid #ccc;
    box-shadow: 0 1px 10px rgba(0,0,0,0.25), 0 1px 1px rgba(0,0,0,0.22);}
    .form-horizontal .control-label { font-size: 16px;}
    #drag{margin-top:0px;}
    .form-group {margin-bottom: 50px;}
    .more-less {  float: right;    font-weight: normal;  font-size: 10px; color: #676464; margin-top: 8px; margin-right: 4px;}
#drag .panel-heading { background: transparent; color: #000;}
.panel-footer { padding: 10px 15px;  background-color: #f0f0f0; border-top: 1px solid #f0f0f0;  border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;}
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
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
    });
    
    function publish_checkbox(no) {
        if($('#publish_checkbox_'+no).is(":checked"))
        {
          $('#publish_'+no).val(1);
        }
        else
        {
          $('#publish_'+no).val(0);
        }
      }

      function widget_checkbox(no) {
        if($('#widget_checkbox_'+no).is(":checked"))
        {
          $('#widget_'+no).val(1);
        }
        else
        {
          $('#widget_'+no).val(0);
        }
      }

     function reset_widget(no) {
        //alert(no);
        $('#widget_name_wrap_'+no).html('<input class=" form-control" name="widget_name[]" type="text" id="widget_name_'+no+'" value="" required>');
        $('#ckeditor_wrap_'+no).html('<div id="ckeditor_wrap_'+no+'"><div class="col-lg-12"><label class="control-label col-lg-2">Description</label><div class="col-lg-10"><br /><textarea class="ckeditor" name="widgets[]" id="des-'+no+'"></textarea></div></div></div>')
        $('#publish_checkbox_'+no).removeAttr('checked');
        $('#publish_'+no).val('0');
        $('#widget_checkbox'+no).removeAttr('checked');
        $('#widget_'+no).val('0');
        CKEDITOR.replace( 'des-'+no );
      }

      function duplicate_widget(no) {
         // var value = CKEDITOR.instances['#des-'+no].getData();//$('#des-'+no).val();
         // var editor = CKEDITOR.replace( 'des-'+no );//CKEDITOR.editor.replace('des-'+no);
         // var value = editor.getData();
         var editor_content = CKEDITOR.instances['des-'+no].getData();
        var cw = $('.widget_wrap').length;
        // e.preventDefault();
        $('.000').append('<div id="'+cw+'" class="widget_wrap col-lg-12 ui-sortable-handle"><div class="col-lg-12 dragicon"><img src="http://stage.somaiya.edu/assets/arigel_general/img/Drag-icon.png"/></div><div class="panel-heading" role="tab" id="heading'+cw+'"><label class="control-label col-lg-2">Widget Name</label><div class="col-lg-10 form-group"><div id="widget_name_wrap_'+cw+'"><input class="form-control" name="widget_name[]" type="text" id="widget_name_'+cw+'" value="" required></div></div><h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+cw+'" aria-expanded="true" aria-controls="collapse'+cw+'"><i class="more-less glyphicon glyphicon-plus"></i></a></h4></div><div id="collapse'+cw+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+cw+'"><div class="panel-body"><div id="ckeditor_wrap_'+cw+'"><label class="control-label col-lg-2">Description</label><div class="col-lg-10 form-group"><br /><textarea class="ckeditor" name="widgets" id="des-'+cw+'">'+editor_content+'</textarea></div></div><div class="form-group "><label for="publish" class="control-label col-lg-2">Publish</label><div class="col-lg-10 col-sm-10"><input style="width: 20px" class="checkbox form-control" id="publish_checkbox_'+cw+'" type="checkbox" data-id="'+cw+'" onclick="publish_checkbox('+cw+');"><input value="0" style="display: none;" id="publish_'+cw+'" name="publish[]" type="text"></div></div><div class="form-group "><label for="widget_title_display" class="control-label col-lg-2">Widget title not display on bar</label><div class="col-lg-10 col-sm-10"><input style="width: 20px" class="checkbox form-control" id="widget_checkbox_'+cw+'" type="checkbox" data-id="'+cw+'" onclick="widget_checkbox('+cw+');"><input value="0" style="display: none;" id="widget_'+cw+'" name="widget_title_display[]" type="text"></div></div></div></div><div class="col-lg-12 panel-footer" role="tab"><div class="bgrow"><div class="col-lg-8"></div><div class="col-lg-4"><ul class="googlepro"><li><a onclick="javascript:deletewidgets('+cw+')" class="circle"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li><li><a class="reset circle" title="Reset" onclick="reset_widget('+cw+');"><i class="fa fa-refresh" aria-hidden="true"></i></a></li><li><a class="circle add" href="#" title="Add Widget"><i class="fa fa-plus" aria-hidden="true"></i></a></li><li><a title="Duplicate" class="circle" href="javascript:void(0);" onclick="duplicate_widget('+cw+');"><i class="fa fa-refresh" aria-hidden="true"></i></a></li></ul></div></div></div></div>');
        CKEDITOR.replace( 'des-'+cw );
      }

    i=$('.widget_wrap').length;
    //i=1;
    $(document).on('click', 'a.add', function (e) {
        e.preventDefault();
        $('.000').append('<div id="'+i+'" class="widget_wrap col-lg-12 ui-sortable-handle"><div class="col-lg-12 dragicon"><img src="http://stage.somaiya.edu/assets/arigel_general/img/Drag-icon.png"/></div><div class="panel-heading" role="tab" id="heading'+i+'"><label class="control-label col-lg-2">Widget Name</label><div class="col-lg-10 form-group"><div id="widget_name_wrap_'+i+'"><input class="form-control" name="widget_name[]" type="text" id="widget_name_'+i+'" value="" required></div></div><h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'+i+'" aria-expanded="true" aria-controls="collapse'+i+'"><i class="more-less glyphicon glyphicon-plus"></i></a></h4></div><div id="collapse'+i+'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'+i+'"><div class="panel-body"><div id="ckeditor_wrap_'+i+'"><label class="control-label col-lg-2">Description</label><div class="col-lg-10 form-group"><br /><textarea class="ckeditor" name="widgets[]" id="des-'+i+'"></textarea></div></div><div class="form-group "><label for="publish" class="control-label col-lg-2">Publish</label><div class="col-lg-10 col-sm-10"><input style="width: 20px" class="checkbox form-control" id="publish_checkbox_'+i+'" type="checkbox" data-id="'+i+'" onclick="publish_checkbox('+i+');"><input value="0" style="display: none;" id="publish_'+i+'" name="publish[]" type="text"></div></div><div class="form-group "><label for="widget_title_display" class="control-label col-lg-2">Widget title not display on bar</label><div class="col-lg-10 col-sm-10"><input style="width: 20px" class="checkbox form-control" id="widget_checkbox_'+i+'" type="checkbox" data-id="'+i+'" onclick="widget_checkbox('+i+');"><input value="0" style="display: none;" id="widget_'+i+'" name="widget_title_display[]" type="text"></div></div></div></div><div class="col-lg-12 panel-footer" role="tab"><div class="bgrow"><div class="col-lg-8"></div><div class="col-lg-4"><ul class="googlepro"><li><a onclick="javascript:deletewidgets('+i+')" class="circle"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li><li><a class="reset circle" title="Reset" onclick="reset_widget('+i+');"><i class="fa fa-refresh" aria-hidden="true"></i></a></li><li><a class="circle add" href="#" title="Add Widget"><i class="fa fa-plus" aria-hidden="true"></i></a></li><li><a title="Duplicate" class="circle" href="javascript:void(0);" onclick="duplicate_widget('+i+');"><i class="fa fa-refresh" aria-hidden="true"></i></a></li></ul></div></div></div></div>');
      CKEDITOR.replace( 'des-'+i );
      i++;
    })
</script>

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
 $('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".glyphicon-plus").removeClass("glyphicon-plus").addClass("glyphicon-minus");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".glyphicon-minus").removeClass("glyphicon-minus").addClass("glyphicon-plus");
});
</script>

<script type="text/javascript">
function deletewidgets(image_id)
{
    if(image_id <=10)
    {
        $('#'+image_id+'').remove();
    } else 
    { 
        var answer = confirm ("Are you sure you want to delete?");
        if (answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('admin/deletewidgets');?>",
                data: "image_id="+image_id,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                  };
                  
                }
            });
        }
        window.location.reload(); 
    }
} 

</script>

<script type="text/javascript">

$(document).ready(function(){
 $( ".row_position" ).sortable({
  placeholder : "ui-state-highlight",
  update  : function(event, ui)
  {
   var programme_id_array = new Array();
   $('.row_position>div').each(function(){
    programme_id_array.push($(this).attr("data-id"));
   });
   $.ajax({
    type: "POST",
    url: "<?php echo site_url('admin/save_programme_order');?>",
    data: {programme_id_array:programme_id_array},
    success:function(data)
    {
     alert(data);
    }
   });
  }
 });

});


// $(function() {
//   $( ".row_position" ).sortable({
//         delay: 150,
//         containment: '#drag',
//         change: function() {
//     var selectedLanguage = new Array();
//     // alert(selectedLanguage);
//     $('.row_position>div').each(function() {
//     selectedLanguage.push($(this).attr("id"));
//     });
//     document.getElementById("row_order").value = selectedLanguage;
//     }
//     });
//   });

//     function myFunction() {
//         document.getElementById("myForm").reset();
//     }



    $(function() {
        $('#url').on('keypress', function(e) {
            if (e.which == 32)
                return false;
        });
    });

    var specialization_namerequired    = 'Please enter Specialization name';
    var urlrequired    = 'Please enter url';
    var urlexist       = 'url already exist';

    $.validator.addMethod("check_unique_url", function(value) {
        var url           = $('#url').val();
        var contents_id             = '<?php echo isset($data["contents_id"]) ? $data["contents_id"] : ""; ?>';
        var check_result        = true;

        $.ajax({
            type: "POST",
            url: base_url+"admin/ajax_check_url",
            async: false,
            data: {url : url, contents_id : contents_id},
            success: function(response){
                check_result = response;
            }
        });
        return check_result;
    }, '');

$("#user_manipulate").validate({
        rules: {
            url: {
                required: true,
                check_unique_url: '#url',
            },
            specialization_name: {
                required: true
            },
        },
        messages: {
            url:{
                required: urlrequired,
                check_unique_url: urlexist
            },
            specialization_name:{
                required: specialization_namerequired
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
        submitHandler: function(form){
                var contents_id                 = '<?php echo $data[contents_id]; ?>';
                var relation_id                 = '<?php echo $relation_id; ?>';
                var language_id                 = $('#language_id').val();
                var formname                    = "programme";
                var check_result                = true;
                $('.languageerror').html('');

                function check_language(contents_id, language_id) {
                    var check_language_result   = true;
                    $.ajax({
                        type: "POST",
                        url: base_url+"admin/ajax_check_common_language",
                        async: false,
                        data: {contents_id : contents_id, relation_id : relation_id, language_id : language_id, formname : formname},
                        success: function(response){
                            if(response == '')
                            {
                                check_language_result = false;
                            }
                        }
                    });
                    return check_language_result;
                }

                check_result = check_language(contents_id, language_id);

                if(check_result == false)
                {
                    $('.languageerror').html('programme content for this language is already exist.');
                    return false;
                }
                else
                {
                    form.submit();
                }
            }
    });
</script>
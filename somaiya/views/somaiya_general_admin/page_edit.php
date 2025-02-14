<?php mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php $institute = $_SESSION['inst_id'] ?>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($data['page_id'])) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Page</span>
                    <?php } else { ?>
                        <span class="caption-subject font-brown bold uppercase">Add Page</span>
                    <?php } ?>
                </div>    
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('admin/page/'.$institute); ?>">Back </a></span>
            </div>   
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="formval" class="cmxform form-horizontal tasi-form" method="post" action="">
                        <?php error_reporting(0); ?>
                        <?php mk_hidden("institute_id",$_SESSION['inst_id']); ?>
                        <div class="form-group">
                            <label for="page_type" class="control-label col-lg-2">Page Type <span class="asterisk">*</span></label>
                            <div class="col-lg-10 col-sm-10">
                                <select id="single" class="form-control select2" name="page_type" data-placeholder="Select Page Type" required>
                                <option value="">Select Page Type</option>
                                    <?php if(isset($page_type) && count($page_type)!=0){ ?>
                                    <?php foreach ($page_type as $key4 => $data4) { ?>
                                        <option value="<?=$data4['id']?>" <?php if($data['page_type'] == $data4['id']) echo"selected"; ?>><?=$data4['name']?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="page_name" class="control-label col-lg-2">Page Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="page_name" name="page_name" value="<?php echo set_value('page_name', (isset($data['page_name']) ? $data['page_name'] : '')); ?>" required data-error=".nameerror" maxlength="250">
                                <div class="nameerror error_msg"><?php echo form_error('page_name', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>

                        <?php 
                            foreach ($languages as $item) { 
                                if($item['language_id']==1){ ?>
                                    <input class=" form-control" id="titles[1]" name="titles[1]" type="hidden" value="<?php echo $data['page_name']; ?>">
                                <?php } else {
                                //mk_htext("titles[".$item["language_id"]."]",_l('Page Name',$this)." (".$item["language_name"].")",isset($titles[$item["language_id"]])?$titles[$item["language_id"]]["title_caption"]:"",'required');
                                }
                            }

                            mk_htext("slug",_l("Slug <span class='asterisk'>*</span>",$this),isset($data['slug'])?$data['slug']:'','required');
                        ?>

                        <input type="hidden" name="extension_id" value="<?php echo $data['extension_id']; ?>">
                        <input type="hidden" name="data_type" value="page">
                        <input type="hidden" name="language_id" value="1">


                        <?php if($institute == 54) { ?>
                            <div class="form-group">
                                <label for="gallery" class="control-label col-lg-2">Gallery</label>
                                <div class="col-lg-10 col-sm-10">
                                    <select id="single" class="form-control select2" name="gallery_id" data-placeholder="Select Page Type">
                                    <option value="">Select Gallery</option>
                                        <?php if(isset($gallery) && count($gallery)!=0){ ?>
                                        <?php foreach ($gallery as $key6 => $data6) { ?>
                                            <option value="<?=$data6['g_id']?>" <?php if($data['gallery_id'] == $data6['g_id']) echo"selected"; ?>><?=$data6['title']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        <?php } ?> 

                        
                        <?php
                            mk_hWYSItexteditor("description",_l('Description',$this),isset($data['description'])?$data['description']:'','');
                            if($institute == 54) {
                                mk_hurl_upload("image",_l('Image',$this),isset($data['image'])?$data['image']:'',"image");
                            }
                            mk_hidden("relation_id",isset($relation_id)?$relation_id:0);
                        ?>
						
						<div class="form-group ">
                            <label for="video_url" class="control-label col-lg-2">Video url </label>
                            <div class="col-lg-10">
                                <input type="url" class="form-control" id="video_url" name="video_url" value="<?php echo set_value('video_url', (isset($data['video_url']) ? $data['video_url'] : '')); ?>" data-error=".video_urlerror" maxlength="250">
                                <div class="video_urlerror error_msg"><?php echo form_error('video_url', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
						
                        <div class="form-group ">
                            <label for="meta_title" class="control-label col-lg-2">Meta Title</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="meta_title" name="meta_title" type="text" value="<?=$data['meta_title']?>" maxlength="80">
                                (Maximum Character Limit is 80)
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label for="data[meta_description]" class="control-label col-lg-2">Meta Description</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="meta_description" name="meta_description" type="text" value="<?=$data['meta_description']?>" maxlength="180">
                                (Maximum Character Limit is 180)
                            </div>
                        </div>

                        <?php
                            // mk_htext("meta_title",_l('Meta Title',$this),isset($data['meta_title'])?$data['meta_title']:'');
                            // mk_htextarea("meta_description",_l('Meta Description',$this),isset($data['meta_description'])?$data['meta_description']:'');
                            mk_htextarea("meta_keywords",_l('Meta keywords',$this),isset($data['meta_keywords'])?$data['meta_keywords']:'');
                            mk_hurl_upload("meta_image",_l('Meta Image',$this),isset($data['meta_image'])?$data['meta_image']:'',"imagemeta");
                        ?>

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
                                <a href="<?php echo base_url('admin/page/'.$_SESSION['inst_id']) ?>" class="btn btn-default" type="button">Cancel</a>
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
    $("#formval").validate({
            rules: {
                language_id: {
                    required: true,
                },
                name: {
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
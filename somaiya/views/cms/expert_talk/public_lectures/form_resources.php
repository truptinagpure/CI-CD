
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                        <span class="caption-subject font-brown bold uppercase"><?php echo $pub_lect_title; ?> Resources</span>
                    </div>      
                    &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('cms/public_lectures/lectures/'); ?>">Back </a></span>
                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <form id="manage_form" class="cmxform form-horizontal tasi-form" method="post" action="" enctype="multipart/form-data">
                            <?php
                                if(isset($post_data['videos']) && !empty($post_data['videos']))
                                {
                                    $i = 1;
                                    foreach ($post_data['videos'] as $key => $value) {
                            ?>
                                        <div class="form-group video_wrap">
                                            <label for="videos" class="control-label col-lg-2"><?php if($i == 1){ ?>Video Url<?php } ?></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control videos" name="videos[]" value="<?php echo $value; ?>">
                                            </div>
                                            <div class="col-lg-2">
                                                <?php if($i == 1){ ?>
                                                    <a href="javascript:void(0);" class="btn btn-icon-only bg_green addMore"><i class="fa fa-plus-square"></i></a>
                                                <?php }else{ ?>
                                                    <a href="javascript:void(0);" class="btn btn-icon-only red removeMore"><i class="fa fa-minus-square"></i></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                            <?php
                                        ++$i;
                                    }
                                }
                                else
                                {
                            ?>
                                    <div class="form-group video_wrap">
                                        <label for="videos" class="control-label col-lg-2">Video Url</label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control videos" name="videos[]" value="">
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="javascript:void(0);" class="btn btn-icon-only bg_green addMore"><i class="fa fa-plus-square"></i></a>
                                        </div>
                                    </div>
                            <?php } ?>

                            <div class="form-group">
                                <label for="albums" class="control-label col-lg-2">Albums</label>
                                <div class="col-lg-8 col-sm-8">
                                    <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple" multiple name="albums[]" data-placeholder="Select Album">
                                        <option value="">-- Select Album --</option>
                                        <?php
                                            if(isset($gallery) && count($gallery)!=0) {
                                                foreach ($gallery as $key => $value) {
                                        ?>
                                                    <option value="<?=$value['g_id']?>" <?php if(in_array($value['g_id'], $post_data['albums'])) echo "selected"; ?>><?=$value['name']?></option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="albums" class="control-label col-lg-2">Presentations</label>
                                <div class="col-lg-8 col-sm-8">
                                    <?php
                                        if(isset($post_data['presentations']) && !empty($post_data['presentations']))
                                        {
                                            foreach ($post_data['presentations'] as $key => $value) {
                                    ?>
                                                <div class="row presentation_wrap">
                                                    <div class="col-lg-12">
                                                        <a href="<?php echo base_url('/'.$value->path); ?>" target="_blank"><?php echo $value->name; ?></a>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                    ?>
                                                <div class="row presentation_wrap mt20 mb20">
                                                    <div class="col-lg-12">
                                                        <a href="javascript:void(0);" class="btn btn-default change_presentation">Remove above files & upload new</a>
                                                    </div>
                                                </div>
                                    <?php
                                        }
                                    ?>
                                    <input type="file" class="form-control presentation_file" name="presentations[]" value="" multiple <?php if(isset($post_data['presentations']) && !empty($post_data['presentations'])){ echo 'style="display: none;"'; } ?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10">
                                    <input class="btn green" value="Submit" type="submit">
                                    <a href="<?php echo base_url('cms/public_lectures/lectures/') ?>" class="btn btn-default" type="button">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END SAMPLE FORM PORTLET-->                                
        </div>
    </div>

    <script type="text/javascript">
        $('.change_presentation').click(function() {
            $('.presentation_wrap').hide();
            $('.presentation_file').show();
        });

        function remove_more() {
            $(".removeMore").click(function(){
                $(this).parent().parent().fadeOut("slow", function() {
                    $(this).remove();
                });
                return false;
            });
        }

        remove_more();

        $('.addMore').on('click', function(){
            var no = $(".video_wrap").length + 1;
            var more_item = $('<div class="form-group video_wrap"><label for="videos" class="control-label col-lg-2"></label><div class="col-lg-8"><input type="text" class="form-control videos" name="videos[]" value="" data-error=".videoserror"></div><div class="col-lg-2"><a href="javascript:void(0);" class="btn btn-icon-only red removeMore"><i class="fa fa-minus-square"></i></a></div></div>');
            more_item.hide();
            $(".video_wrap:last").after(more_item);
            more_item.fadeIn("slow");

            remove_more();
        });

        $('#manage_form').validate({
            rules: {
                "presentations[]": {
                    extension: "pdf|doc|docx|odt|txt|json|csv|pptx|xls|xlsx",
                }
            },
            messages: {
                "presentations[]": {
                    extension: 'Allowed file types are pdf, doc, docx, odt, txt, json, csv, pptx, xls, xlsx',
                }
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
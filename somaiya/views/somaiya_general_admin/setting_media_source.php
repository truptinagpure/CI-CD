    <?php mk_use_uploadbox($this); ?>
    <!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown "></i>
                            <span class="caption-subject font-brown bold uppercase">Settings</span>
                        </div>
                        &nbsp;&nbsp;<span class="custpurple"><button class="brownsmall btn brown" onclick="history.go(-1);">Back</button> </span>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <ul class="nav nav-tabs">
                                    <li role="presentation"><a href="<?php echo base_url()?>admin/settings/general"><?php echo _l('General settings',$this)?></a></li>
                                    <li role="presentation"><a href="<?php echo base_url()?>admin/settings/seo"><?php echo _l('SEO optimise',$this)?></a></li>
                                    <li role="presentation"><a href="<?php echo base_url()?>admin/settings/contact"><?php echo _l('Contact settings',$this)?></a></li>
                                    <li role="presentation"><a href="<?php echo base_url()?>admin/settings/mail"><?php echo _l('Send mail settings',$this)?></a></li>
                                    <li role="presentation" class="active"><a href="javascript:void(0);"><?php echo _l('Media source settings',$this)?></a></li>
                                </ul>                                                   
                            </div>
                        </div>
                        <?php
                            mk_hpostform();
                            mk_hurl_upload("data[default_media_source]",_l('Media source',$this),isset($settings['default_media_source'])?$settings['default_media_source']:'',"default_media_source");
                            mk_hsubmit(_l('Submit',$this),$base_url,_l('Cancel',$this));
                            mk_closeform();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LIST CONTENT -->
    <?php mk_popup_uploadfile(_l('Upload',$this), "default_media_source", $base_url."upload_image/20/"); ?>

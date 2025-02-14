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
                                    <li role="presentation" class="active"><a href="javascript:;"><?php echo _l('General settings',$this)?></a></li>
                                    <li role="presentation"><a href="<?php echo base_url()?>admin/settings/seo"><?php echo _l('SEO optimise',$this)?></a></li>
                                    <li role="presentation"><a href="<?php echo base_url()?>admin/settings/contact"><?php echo _l('Contact settings',$this)?></a></li>
                                    <!-- <li role="presentation"><a href="<?php //echo base_url()?>admin/settings/mail"><?php //echo _l('Send mail settings',$this)?></a></li>
                                    <li role="presentation"><a href="<?php //echo base_url()?>admin/settings/media_source"><?php //echo _l('Media source settings',$this)?></a></li> -->
                                </ul>                                                   
                            </div>
                        </div>
                        <?php
                            mk_hpostform();
                            mk_hselect("data[language_id]",_l('Admin language',$this),$languages,"language_id","language_name",isset($settings['language_id'])?$settings['language_id']:null,null,'style="width:200px"');
                            $option = "style='max-width:600px;'";
                            mk_htext("data[company]",_l('Company Name',$this),isset($settings['company'])?$settings['company']:'',$option);
                            foreach ($languages as $item) {
                                mk_htext("data[options][".$item["language_id"]."][company]",_l('company name',$this)." (".$item["language_name"].")",isset($options[$item["language_id"]])?$options[$item["language_id"]]["company"]:"",$option);
                            }
                            mk_hurl_upload("data[logo]",_l('Logo',$this),isset($settings['logo'])?$settings['logo']:'',"logo");
                            mk_hurl_upload("data[fav_icon]",_l('Fav Icon',$this),isset($settings['fav_icon'])?$settings['fav_icon']:'',"fav_icon");
                            mk_hsubmit(_l('Submit',$this),$base_url,_l('Cancel',$this));
                            mk_closeform();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LIST CONTENT -->

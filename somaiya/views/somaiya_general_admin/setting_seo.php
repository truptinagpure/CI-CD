    <!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-blue-madison "></i>
                            <span class="caption-subject font-blue-madison bold uppercase">Settings</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <ul class="nav nav-tabs">
                                    <li role="presentation"><a href="<?php echo base_url()?>admin/settings/general"><?php echo _l('General settings',$this)?></a></li>
                                    <li role="presentation" class="active"><a href="javascript:;"><?php echo _l('SEO optimise',$this)?></a></li>
                                    <li role="presentation"><a href="<?php echo base_url()?>admin/settings/contact"><?php echo _l('Contact settings',$this)?></a></li>
                                    <!-- <li role="presentation"><a href="<?php //echo base_url()?>admin/settings/mail"><?php //echo _l('Send mail settings',$this)?></a></li>
                                    <li role="presentation"><a href="<?php //echo base_url()?>admin/settings/media_source"><?php //echo _l('Media source settings',$this)?></a></li> -->
                                </ul>                                                   
                            </div>
                        </div>
                        <?php
                            mk_hpostform();
                            $option = "style='max-width:600px;'";
                            foreach ($languages as $item) {
                                mk_htext("data[options][".$item["language_id"]."][site_title]",_l('site title',$this)." (".$item["language_name"].")",isset($options[$item["language_id"]])?$options[$item["language_id"]]["site_title"]:"",$option);
                                mk_htextarea("data[options][".$item["language_id"]."][site_description]",_l('Site Description',$this)." (".$item["language_name"].")",isset($options[$item["language_id"]])?$options[$item["language_id"]]["site_description"]:"",$option);
                                mk_htextarea("data[options][".$item["language_id"]."][site_keyword]",_l('site keywords',$this)." (".$item["language_name"].")",isset($options[$item["language_id"]])?$options[$item["language_id"]]["site_keyword"]:"",$option);
                            }
                            mk_hsubmit(_l('Submit',$this),$base_url,_l('Cancel',$this));
                            mk_closeform();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END LIST CONTENT -->

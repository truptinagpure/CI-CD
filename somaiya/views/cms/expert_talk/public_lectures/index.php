<!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown bold"></i>
                            <span class="caption-subject font-brown bold uppercase"><?php echo $pub_lect_title; ?></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="custorange">
                                        <a href="<?php echo base_url('cms/public_lectures/manage'.$page); ?>">
                                            <button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New</button>
                                        </a>
                                    </span>
                                    <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back</a> </span>
                                </div>                                                         
                            </div>
                        </div> 

                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_id">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Speaker</th>
                                    <th>Start Date & Time</th>
                                    <th>End Date & Time</th>
                                    <th>Public</th>
                                    <!-- <th>Venue</th>
                                    <th>Image</th>
                                    <th>Created On</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($data_list) > 0){
                                        foreach($data_list as $data){
                                ?>
                                            <tr class="gradeX table_tr">
                                                <td><?=$data["title"]?></td>
                                                <td><?=$data["speaker_name"]?></td>
                                                <td><?=$data["start_date_time"]?></td>
                                                <td><?=$data["end_date_time"]?></td>
                                                <td class="chwidth center"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                                <?php /* ?>
                                                <td><?=$data["venue"]?></td>
                                                <td>
                                                    <?php if(!empty($data["image"])){ ?>
                                                        <img src="<?php echo base_url($data["image"]); ?>" class="wd100">
                                                    <?php } ?>
                                                </td>
                                                <td class="chwidth center"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                                <td>
                                                    <?php
                                                        if(isset($data['created_on']) && !empty($data['created_on']) && $data['created_on'] !== '0000-00-00 00:00:00')
                                                        {
                                                          echo date('d F, Y H:i:s', strtotime($data['created_on']));
                                                        }
                                                        else
                                                        {
                                                          echo 'NA';
                                                        }
                                                    ?>
                                                </td>
                                                <?php */ ?>
                                                <td>
                                                    <div class="wd200 text-center">
                                                        <a href="<?php echo base_url('cms/public_lectures/lecture_content/'.$data["lecture_id"]); ?>" class="btn orange" title="<?=_l('Content Edit',$this)?>"><i title="<?=_l('Content Edit',$this)?>" class="icon-note"></i></a>
                                                        <a href="<?php echo base_url('cms/public_lectures/manage'.$page.'/'.$data["lecture_id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                                        <a href="<?php echo base_url('cms/public_lectures/reviews/'.$data["lecture_id"]); ?>" class="btn btn_bg_seagreen" title="<?=_l('Reviews',$this)?>"><i title="<?=_l('Reviews',$this)?>" class="icon-speech"></i></a>
                                                        <a href="<?php echo base_url('cms/public_lectures/resources/'.$data["lecture_id"]); ?>" class="btn btn_bg_bluehoki" title="<?=_l('Resources',$this)?>"><i title="<?=_l('Resources',$this)?>" class="icon-paper-clip"></i></a>
                                                        <a href="<?php echo base_url('cms/public_lectures/interests/'.$data["lecture_id"]); ?>" class="btn btn_bg_purple_seance" title="<?=_l('Interested People',$this)?>"><i title="<?=_l('Interested People',$this)?>" class="fa fa-thumbs-up"></i></a>
                                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/public_lectures/delete'.$page.'/'.$data["lecture_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                    else
                                    {
                                ?>
                                        <tr class="gradeX">
                                            <td class="text-center" colspan="6">No <?php echo $pub_lect_title; ?> Available</td>
                                        </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_id').DataTable({
                "order": []
            });
        });
    </script>


    <style type="text/css">
    .gradeX .btn_bg_seagreen, .gradeX .btn_bg_bluehoki, .gradeX .btn_bg_purple_seance 
    {
        height: 34px;
        width: 50px;
    }
    </style>
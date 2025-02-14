<!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown bold"></i>
                            <span class="caption-subject font-brown bold uppercase"><?php echo $pub_lect_title; ?> Lecture Reviews</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="custorange">
                                        <a href="<?php echo base_url('cms/public_lectures/manage'.$page.'/'.$lecture_id); ?>">
                                            <button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New</button>
                                        </a>
                                    </span>
                                    <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/public_lectures/lectures/'); ?>">Back</a> </span>
                                </div>                                                         
                            </div>
                        </div> 

                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_id">
                            <thead>
                                <tr>
                                    <!-- <th>Name</th> -->
                                    <th>Review</th>
                                    <th>Public</th>
                                    <th>Created On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($data_list) > 0){
                                        foreach($data_list as $data){
                                ?>
                                            <tr class="gradeX table_tr">
                                                <?php /* ?><td><?=$data["name"]?></td><?php */ ?>
                                                <td><?=$data["review"]?></td>
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
                                                <td>
                                                    <div class="wd100 text-center">
                                                        <a href="<?php echo base_url('cms/public_lectures/manage'.$page.'/'.$lecture_id.'/'.$data["review_id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/public_lectures/delete'.$page.'/'.$lecture_id.'/'.$data["review_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
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
                                            <td class="text-center" colspan="4">No <?php echo $pub_lect_title; ?> Lecture Review Available</td>
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
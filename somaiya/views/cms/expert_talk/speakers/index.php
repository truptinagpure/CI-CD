<!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown bold"></i>
                            <span class="caption-subject font-brown bold uppercase">Speakers</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="custorange">
                                        <a href="<?php echo base_url('cms/speakers/managespeaker'); ?>">
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
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <!-- <th>Profile</th> -->
                                    <th>Public</th>
                                    <!-- <th>Profile Image</th>
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
                                                <td><?=$data["first_name"]?></td>
                                                <td><?=$data["middle_name"]?></td>
                                                <td><?=$data["last_name"]?></td>
                                                <!-- <td><?=$data["description"]?></td> -->
                                                <td class="chwidth center"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                                <?php /* ?>
                                                <td>
                                                    <?php if(!empty($data["profile_image"])){ ?>
                                                        <img src="<?php echo base_url($data["profile_image"]); ?>" class="wd100">
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
                                                    <div class="wd100 text-center">
                                                        <a href="<?php echo base_url('cms/speakers/managespeaker/'.$data["speaker_id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/speakers/deletespeaker/'.$data["speaker_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
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
                                            <td class="text-center" colspan="6">No Speakers Available</td>
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
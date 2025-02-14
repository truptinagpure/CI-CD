 <div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="fa fa-list-alt font-brown"></i>
                        <span class="caption-subject font-brown bold uppercase">Student Council Designation</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custorange">
                                    <a class="sizebtn btn sbold orange" href="<?php echo base_url(); ?>cms/student_council_designation/edit/">Add New</a>
                                </span>
                                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back</a> </span>
                            </div>                                                         
                        </div>
                    </div>

                    <table  class="table table-striped table-bordered table-hover table-checkable order-column" id="tableId">
                        <thead>
                            <tr>
                                <th>Designation</th>
                                <th>Publish</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(count($data_list) > 0){
                                    foreach($data_list as $data){
                            ?>
                                        <tr class="gradeX">
                                            <td><?=$data["designation"]?></td>
                                            <td class="chwidth center"><i class="fa <?=$data["status"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                            <td>
                                                <a href="<?php echo base_url('cms/student_council_designation/edit/'.$data["id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                                <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/student_council_designation/delete/'.$data["id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                }
                                else
                                {
                            ?>
                                    <tr class="gradeX">
                                        <td class="text-center" colspan="3">No Designation Available</td>
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
        $('#tableId').DataTable( {
            "order": [[ 1, "desc" ]],
            "iDisplayLength": 10
        } );
    } );

    window.alert = function() {};
</script>
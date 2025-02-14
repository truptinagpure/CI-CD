 <div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">Donation</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custorange">
                                    <a class="sizebtn btn sbold orange" href="<?php echo base_url(); ?>cms/donation/edit/">Add New</a>
                                </span>
                                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back</a> </span>
                            </div>                                                         
                        </div>
                    </div>

                    <table  class="table table-striped table-bordered table-hover table-checkable order-column" id="tableId">
                        <thead>
                            <tr>
                                <th>Project Name</th>
                                <th>Tax Benefit</th>
                                <th>Featured</th>
                                <th>Publish</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(count($data_list) > 0){
                                    $i = 1;
                                    foreach($data_list as $data){
                            ?>
                                        <tr class="gradeX">
                                            <td><?=$data["project_name"]?></td>
                                            <td class="chwidth center"><i class="fa <?=$data["tax_benefit"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                            <td class="chwidth center"><i class="fa <?=$data["featured"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                            <td class="chwidth center"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                            <td>
                                                <a href="<?php echo base_url('cms/donation/edit/'.$data["donation_id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                                <a href="<?php echo base_url('cms/donation_content/contents/'.$data["donation_id"]); ?>" class="btn orange" title="<?=_l('Edit Contents',$this)?>"><i title="<?=_l('Edit Contents',$this)?>" class="fa fa-edit"></i></a>
                                                <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/donation/delete/'.$data["donation_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                            <?php
                                        ++$i;
                                    }
                                }
                                else
                                {
                            ?>
                                    <tr class="gradeX">
                                        <td class="text-center" colspan="7">No Donation Available</td>
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
            // "order": [[ 1, "desc" ]],
            "iDisplayLength": 10
        } );
    } );

    window.alert = function() {};
</script>
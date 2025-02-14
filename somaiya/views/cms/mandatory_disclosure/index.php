<div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase"> Mandatory Disclosure</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custorange"> <a href="<?php echo base_url('cms/mandatory_disclosure/edit'); ?>"><button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New</button></a></span>
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                            </div>                                                         
                        </div>
                    </div>
                    <table  class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                            <tr>
                                <th>Disclosure Name</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <!-- <th>Disclosure Url</th> -->
                                <th>Order</th>
                                <th>Public</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data_list as $data){ ?>
                                <tr class="gradeX">
                                    <td><?=$data["name"]?></td>
                                    <td><?=$data["catname"]?></td>
                                    <td><?=$data["subname"]?></td>
                                    <td><?=$data["order"]?></td>
                                    <!-- <td><?=$data["document_url"]?></td> -->
                                    <td><i class="fa <?=$data["status"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td><a href="<?php echo base_url('cms/mandatory_disclosure/edit/');?>/<?=$data["id"]?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                        <a href="<?php echo base_url('cms/mandatory_disclosure/delete/');?>/<?=$data["id"]?>" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                    </td>
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
        $('#sample_1').DataTable( {
            "order": [[ 1, "desc" ]],
            "iDisplayLength": 25
        } );
    } );
    window.alert = function() {};
</script>
 <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown "></i>
                            <span class="caption-subject font-brown bold uppercase">Sidebar Module</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                         <span class="custorange"> <a href="<?php echo base_url(); ?>cms/sidebar_module/edit"><button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New<!-- <i class="fa fa-plus"></i> -->
                                        </button></a></span>
                                     <span class="custpurple">&nbsp;&nbsp;<button class="sizebtn btn brown" onclick="history.go(-1);">Back </button> </span>
                                </div>                                                         
                            </div>
                        </div>

                        <table  class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Module Name</th>
                                    <th>Status</th>
                                    <th>Module Type</th>
                                    <th>Parent Module</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data_list as $data){ ?>
                                <tr class="gradeX">
                                    <td><?=$data["module_name"]?></td>
                                    <td><i class="fa <?=$data["status"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td><?php if($data["parent_id"]=='0'){echo "Parent";}else{echo "Child";}?></td>
                                    <td><?php if($data["parent_id"]=='0'){echo "-";}
                                      else{ 
                                        foreach($data_list as $data1){ 
                                        if($data["parent_id"]==$data1["module_id"])
                                        {
                                            echo $data1["module_name"];
                                        }
                                        } }?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>cms/sidebar_module/edit/<?=$data["module_id"]?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                        <a href="<?php echo base_url(); ?>cms/sidebar_module/delete/<?=$data["module_id"]?>" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
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
function doconfirm()
{
    job=confirm("Are you sure to delete permanently?");
    if(job!=true)
    {
        return false;
    }
}
</script>

<script type="text/javascript">
        $(document).ready(function() {
            $('#sample_1').DataTable( {
                "order": [[ 1, "desc" ]],
                "iDisplayLength": 25
            } );
        } );

        window.alert = function() {};
    </script>
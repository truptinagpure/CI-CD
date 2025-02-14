    <!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown "></i>
                            <span class="caption-subject font-brown bold uppercase">Institute Gallery Types</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="custorange"> <a href="<?php echo base_url(); ?>cms/gallery_inst_type/edit/"><button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New<!-- <i class="fa fa-plus"></i> -->
                                        </button></a></span>
                                  
                                    <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                                </div>                                                         
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Institute</th>
                                    <th>Gallery Types</th>
                                    <th>Publish</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data_list as $data){ ?>
                                <tr class="gradeX">
                                    <td><?=$data["INST_NAME"]?></td>
                                    <?php $typename = explode(",", $data['type_name']); $typename1 = implode(', ', $typename);?>
                                    <td><?=$typename1?></td>                                    
                                    <td><i class="fa <?=$data["status"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td>
                                        <a href="<?php echo base_url(); ?>cms/gallery_inst_type/edit/<?php echo $data['ig_id']; ?>"  class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/gallery_inst_type/delete/'.$data["ig_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
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
                "order": [[ 2, "desc" ]],
                "iDisplayLength": 25
            } );
        } );

        window.alert = function() {};
    </script>
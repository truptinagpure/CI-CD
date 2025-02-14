    <!-- BEGIN LIST CONTENT -->
    <?php error_reporting(0); $institute = $_SESSION['inst_id'] ?>
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown "></i>
                            <span class="caption-subject font-brown bold uppercase"> <?=$data_list[0]['name']?></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="">
                                        <?php if(isset($data_type) && isset($relation_id)){ ?>
                                          <span class="custorange"><a href="<?=$base_url?>edit<?=$page?>/0<?=isset($data_type)?"/".$data_type:""?><?=isset($relation_id)?"/".$relation_id:""?>" class="sizebtn btn sbold orange"><?=_l("Add New",$this)?> <!-- <i class="fa fa-plus"></i> -->
                                            </a> </span>
                                        <?php } ?> 
                                        <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/programspecialization/program/'.$data_list[0]['bkid']); ?>">Back </a> </span>                                       
                                    </div>
                                </div>                                                         
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>                                                               
                                    <th>Language</th>
                                    <th>Publish</th>
                                    <th>Action</th>                                       
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data_list as $data){ ?>
                                    <tr class="gradeX">
                                        <td><?=$data["language_name"]?></td>
                                        <td class="chwidth center"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                        <td>
                                            <a href="<?=$base_url?>edit<?=$page?>/<?=$data["contents_id"]?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="icon-pencil"></i></a>
                                            <a href="<?=$base_url?>delete<?=$page?>/<?=$data["contents_id"]?>/<?=isset($data_type)?"/".$data_type:""?><?=isset($relation_id)?"/".$relation_id:""?>" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();"><i title="<?=_l('Delete',$this)?>" class="icon-trash"></i></a>
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
    <!-- END LIST CONTENT -->
    


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
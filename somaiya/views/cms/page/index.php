<!-- BEGIN LIST CONTENT -->
<div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">Pages - <?=$institutes_details['INST_NAME']  ?>  (<?= $institutes_details['INST_SHORTNAME']?>)</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php 
                                    $instituteId=$this->uri->segment(4);
                                    $_SESSION['inst_id']=$this->uri->segment(4);
                                    if(isset($instituteId) AND $instituteId!="") {
                                        $_SESSION['inst_id']=$instituteId;                                        
                                    } else {
                                        $_SESSION['inst_id']=50;
                                    }
                                    $instname = preg_replace("/[^a-zA-Z]+/", "", $institutes_details['INST_SHORTNAME']);
                                ?>
                                <span class="custorange"> <a href="<?php echo base_url('cms/page/edit/'); ?>"><button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New</button></a></span>
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                            </div>                                                         
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                            <tr>    
                                <th>Page Name</th>
                                <th>Template Name</th>
                                <th>Created Date</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Action</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data_list as $data){ ?>
                                <tr class="gradeX">
                                    <td><?=$data["page_name"]?></td>
                                    <td class="tempn"><?=_l($page_type[$data["page_type"]]["name"],$this)?></td>
                                    <td><?=$data["created_date"]?></td>
                                    <td><?=$data["fullname"]?></td>
                                    <td class="chwidth"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td class="actbtn">
                                        <a href="<?php echo base_url('cms/page_extensions/extensions/'.$data["page_id"]); ?>" class="btn orange" title="<?=_l('Edit Contents',$this)?>"><i title="<?=_l('Edit Contents',$this)?>" class="fa fa-edit"></i></a>
                                        
                                        <a href=" <?php echo base_url('cms/page/edit/'.$data["page_id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                         <?php if ($_SESSION['inst_id']==50) { ?>
                                            <a href="https://svv.somaiya.edu/en/<?=$data["slug"]?>" class="btn custblue btn-sm" title="<?=_l('Preview',$this)?>" target="_blank"><i title="<?=_l('Preview',$this)?>" class="icon-eye"></i></a>
                                        <?php } else if ($_SESSION['inst_id']==33) { ?>
                                            <a href="https://president.somaiya.edu/en/<?=$data["slug"]?>" class="btn custblue btn-sm" title="<?=_l('Preview',$this)?>" target="_blank"><i title="<?=_l('Preview',$this)?>" class="icon-eye"></i></a>
                                        <?php } else if ($_SESSION['inst_id']==72) { ?>
                                            <a href="https://physiotherapy.somaiya.edu/en/<?=$data["slug"]?>" class="btn custblue btn-sm" title="<?=_l('Preview',$this)?>" target="_blank"><i title="<?=_l('Preview',$this)?>" class="icon-eye"></i></a>
                                        <?php } else if ($_SESSION['inst_id']!=50 && $_SESSION['inst_id']!=33) { ?>
                                            <a href="https://<?php echo strtolower($instname)?>.somaiya.edu/en/<?=$data["slug"]?>" class="btn custblue btn-sm" title="<?=_l('Preview',$this)?>" target="_blank"><i title="<?=_l('Preview',$this)?>" class="icon-eye"></i></a>
                                        <?php } ?>

                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/page/delete/'.$data["page_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
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
    $(document).ready(function() {
        $('#sample_1').DataTable( {
            "order": [[ 3, "desc" ]],
            "iDisplayLength": 25
        } );
    } );
    window.alert = function() {};
</script>
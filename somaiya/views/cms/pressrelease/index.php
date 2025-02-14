<!-- BEGIN LIST CONTENT -->
<div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">Pressrelease - <?=$institutes_details['INST_NAME']  ?>  (<?= $institutes_details['INST_SHORTNAME']?>)</span>
                    </div>
                </div>   <!--comment -->                 
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php 
                                 $instituteId=$this->uri->segment(4);
                                 $_SESSION['inst_id']=$this->uri->segment(4);
                                    if(isset($instituteId) AND $instituteId!="") 
                                    {
                                        $_SESSION['inst_id']=$instituteId;                                        
                                    } else {
                                        $_SESSION['inst_id']=50;
                                    }
                                ?>
                                <span class="custorange"> <a   href="<?php echo base_url(); ?>cms/pressrelease/edit/"> <button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New</button></a></span>
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($data_list) && count($data_list)!=0){ ?>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Institute</th>
                                    <th>Publish</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data_list as $data){//echo $data["INST_NAME"]; ?>


                                <tr class="gradeX">
                                    <td><?=$data["title"]?></td>
                                    <td><?=$data["category_name"]?></td>

                                    <?php if(isset($data['institute_namenew']))
                                           {
                                             $instiiname = explode(",", $data['institute_namenew']);
                                             $instiname = implode(', ', $instiiname);
                                            }else
                                            {
                                                $instiname=$data["INST_NAME"];
                                            }
                                    ?>
                                    <td><?=$instiname?></td>                        
                                    <td><i class="fa <?=$data["publish"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td>
                                        <a  href="<?php echo base_url('cms/pressrelease/edit/'.$data["pressrelease_id"]); ?>"
                                        class="btn custblue btn-sm" title="<?=_l('Edit English Content',$this)?>"><i title="<?=_l('Edit English Content',$this)?>" class="fa fa-pencil"></i></a>

                                        <a href="<?php echo base_url('cms/pressrelease_content/pressreleasecontents/'.$data["pressrelease_id"]); ?>"  class="btn orange" title="<?=_l('Edit Other language Contents',$this)?>"><i title="<?=_l('Edit Other language Contents',$this)?>" class="fa fa-edit"></i></a>

                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/pressrelease/delete/'.$data["pressrelease_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#sample_1').DataTable( {
            "order": [[ 3, "desc" ]],
            "iDisplayLength": 25
        } );
    } );

    window.alert = function() {};
</script>
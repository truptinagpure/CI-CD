<!-- BEGIN LIST CONTENT -->
<div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">Announcements - <?=$institute_name  ?>  (<?= $institute_short_name?>)</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custorange"> <a class="sizebtn btn sbold orange" href="<?php echo base_url(); ?>cms/announcement/edit/">Add New</a></span>
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                            </div>                                                         
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                            <tr>    
                                <th>Announcement Name</th>
                                <!-- <th>Category</th> -->
                                <th>Publish</th>
                                <th>Action</th>                                
                            </tr>
                        </thead>
                        <?php 
                        // echo"<pre>";
                        // print_r($data_list);
                        ?>
                        <tbody class="list-unstyled" id="page_list">
                            <?php foreach($data_list as $data){ ?>
                                <tr class="gradeX" id="<?=$data['announcement_id']?>">
                                    <td><?=$data["title"]?></td>
                                    <!-- <td><?=$data["category_id"]?></td> -->
                                    <td class="chwidth"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td class="actbtn">
                                        <?php /*<a href="<?=$base_url?>contents/<?=//$data["announcement_id"]?>" class="btn orange" title="<?=//_l('Edit Contents',$this)?>"><i title="<?=//_l('Edit Contents',$this)?>" class="fa fa-edit"></i></a> */ ?>
                                        <a href="<?php echo base_url('cms/announcement_content/contents/'.$data["announcement_id"]); ?>" class="btn orange" title="<?=_l('Edit Contents',$this)?>"><i title="<?=_l('Edit Contents',$this)?>" class="fa fa-edit"></i></a>
                                        <a href="<?php echo base_url('cms/announcement/edit/'.$data["announcement_id"]); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/announcement/delete/'.$data["announcement_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
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
            "order": [[ 1, "desc" ]],
            "iDisplayLength": 25
        } );
    } );
    window.alert = function() {};
</script>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

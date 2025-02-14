 <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line"><?php error_reporting(1);?>
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown "></i>
                            <span class="caption-subject font-brown bold uppercase">Progammes - 
                                <?=$data_list[0]['INST_NAME']?>  (<?=$data_list[0]['INST_SHORTNAME']?>)
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                        <?php $institute = $this->uri->segment(3); $_SESSION['inst_id']=$institute;?>
                                  
                                     <span class="custpurple">&nbsp;&nbsp;<button class="sizebtn btn brown" onclick="history.go(-1);">Back </button> </span>
                                </div>                                                         
                            </div>
                        </div>

                        <table  class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Programme Name</th>
                                    <th>Short Name</th>
                                    <th>Code</th>
                                    <th>Publish</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                 foreach($data_list as $data){ ?>
                                <tr class="gradeX">
                                    <td><?=$data['COURSE_NAME']?></td>
                                    <td><?=$data['COURSE_SHORT_NAME']?></td>
                                    <td><?=$data['coursecode']?></td>
                                    <td><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                    <td>
                                        <!-- <a href="<?=$base_url?>programcontents/<?=$page?>/<?=$data["MAP_COURSE_ID"]?>" class="btn btn-warning btn-sm" title="<?=_l('Contents Edit',$this)?>"><i title="<?=_l('Contents Edit',$this)?>" class="fa fa-edit"></i></a> -->
                                        
                                        <!-- <a href="<?=$base_url?>edit<?=$page?>/<?=$data["MAP_COURSE_ID"]?>" class="btn btn-primary btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a> -->
                                        
                                        <!-- <a href="<?=$base_url?>delete<?=$page?>/<?=$data["MAP_COURSE_ID"]?>" class="btn btn-danger btn-sm btn-delete" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a> -->

                                        <div class="form-check">
                                            <input type="checkbox" id="special" class="special form-check-input" name="special[]" value="<?=$data["MAP_COURSE_ID"]?>" <?php if(isset($data['Specialization_parent']) && $data['Specialization_parent'] == 1){ echo 'checked="checked"'; } ?>/>
                                            <label class="form-check-label" for="materialUnchecked">Specialization ?</label>
                                        </div>
                                        <?php //if(isset($data['Specialization_parent']) && $data['Specialization_parent'] != 1){ ?>
                                            <a href="<?=$base_url?>programcontents/<?=$page?>/<?=$data["MAP_COURSE_ID"]?>" class="btn orange" title="<?=_l('Edit Contents',$this)?>"><i title="<?=_l('Edit Contents',$this)?>" class="fa fa-edit"></i></a>
                                        <?php //} ?>
                                        <?php if(isset($data['Specialization_parent']) && $data['Specialization_parent'] == 1){ ?>
                                            <a href="<?=$base_url?>programspecialization/<?=$page?>/<?=$data["MAP_COURSE_ID"]?>" class="btn custblue btn-sm" title="<?=_l('Add Specialization',$this)?>"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                                        <?php } ?>
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



<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script> -->
<script type="text/javascript">

$(".special").bind('click', function() { 
    if($(this).prop('checked'))
    {
        $.get("<?php echo site_url('admin/save_specialization');?>", { checked: 1, msgId: $(this).prop('value') } );
        location.reload();
    }
    else
    {
        $.get("<?php echo site_url('admin/save_specialization');?>", { checked: 0, msgId: $(this).prop('value') } );
        location.reload();
    }
}); 
</script>


<script type="text/javascript">
        $(document).ready(function() {
            $('#sample_1').DataTable( {
                "order": [[ 4, "desc" ]],
                "iDisplayLength": 25
            } );
        } );

        window.alert = function() {};
    </script>
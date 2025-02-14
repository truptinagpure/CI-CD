<!-- BEGIN LIST CONTENT -->
<div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">Most Searched Programmes</span>
                    </div>
                </div>                    
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php 
                                    $instituteId=$this->uri->segment(3);
                                    $_SESSION['inst_id']=$this->uri->segment(3);
                                    if(isset($instituteId) AND $instituteId!="") {
                                        $_SESSION['inst_id']=$instituteId;                                        
                                    } else {
                                        $_SESSION['inst_id']=50;
                                    }
                                ?>
                                <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($data_list) && count($data_list)!=0){ ?>     
                        <table   class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <!-- <th>Institute</th> -->
                                    <!-- <th>Course Name</th> -->
                                    <th>Created Date</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data_list as $data){ ?>
                                <tr class="gradeX">
                                    <td><?=$data["first_name"]?></td>
                                    <td><?=$data["last_name"]?></td>
                                    <td><?=$data["mobile_number"]?></td>
                                    <td><?=$data["email_id"]?></td>  
                                    <td><?=$data["city"]?></td>
                                    <td><?=$data["state"]?></td>
                                    <!-- <td><?=$data["institute_id"]?></td> -->
                                    <!-- <td><?=$data["course_name"]?></td> -->
                                    <td><?=$data["created_on"]?></td>                      
                                    <!-- <td>
                                        <a href="<?=$base_url?>edit<?=$page?>/<?=$data["announcement_id"]?>" class="btn custblue btn-sm" title="<?=_l('Edit English Content',$this)?>"><i title="<?=_l('Edit English Content',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                        <a href="<?=$base_url?>announcementcontents/<?=$data["announcement_id"]?>" class="btn orange" title="<?=_l('Edit Other language Contents',$this)?>"><i title="<?=_l('Edit Other language Contents',$this)?>" class="fa fa-edit"></i></a>
                                        
                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('admin/deleteannouncement/'.$data["announcement_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                    </td> -->
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
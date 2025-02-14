<div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">Departments</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('/cms/department/edit'); ?>">Add Departments</a> </span>
                            </div>                                                         
                        </div>
                    </div>

                    <table  class="table table-striped table-bordered table-hover table-checkable order-column">
                        <thead>
                            <tr>
                                <th>Departments</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $values = array_map('array_pop', $department_by_institute);
                            $imploded = implode(',', $values); 
                            //echo "department = ".$imploded;
                            //exit();
                                if(count($department_by_institute) > 0){
                                    $i = 1;
                                    //foreach($department_by_institute as $data){
                            ?>
                                        <tr class="gradeX">
                                            <td><?php echo $imploded; ?></td>
                                            <td>
                                                <a href="<?php echo base_url('cms/department/edit/'); ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                            </td>
                                        </tr>
                            <?php
                                        ++$i;
                                    //}
                                }
                                else
                                {
                            ?>
                                    <tr class="gradeX">
                                        <td class="text-center" colspan="7">No Department Available</td>
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
            "order": [[ 3, "desc" ]],
            "iDisplayLength": 25
        } );
    } );

    window.alert = function() {};
</script>
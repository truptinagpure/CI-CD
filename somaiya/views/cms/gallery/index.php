    <!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown "></i>
                            <span class="caption-subject font-brown bold uppercase">Galleries</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span class="custorange"> <a href="<?php echo base_url(); ?>cms/gallery/edit"><button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New
                                        </button></a></span>
                                  
                                     <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>
                                </div>                                                         
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>    
                                    <th>Title</th>
                                    <th>Institute</th>
                                    <th>Type</th>
                                    <th>Date</th> 
                                    <!-- <th>Publish</th>  -->
                                    <th>Action</th>                             
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(isset($view_data) && is_array($view_data) && count($view_data)): //$i=1;
                                    foreach ($view_data as $key => $data) {
                                ?>
                                <tr class="gradeX">
                                    <td><?php echo $data['title']; ?></td>
                                    <?php if ($data['INST_ID']!='') { ?>
                                        <td><?php echo $data['INST_NAME']; ?></td>
                                    <?php } else { ?>
                                        <td><?php echo "SVV"; ?></td>
                                    <?php } ?>
                                    <td><?php echo $data['type_name']; ?></td>
                                    <td><?php echo $data['date']; ?></td>
                                    <!-- <td class="chwidth center"><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td> -->
                                    <td>
                                        <a href="<?php echo base_url();?>en/gallery-view/<?php echo $data['g_id']; ?>" class="btn custblue btn-sm" title="<?=_l('Preview',$this)?>" target="_blank"><i title="<?=_l('Preview',$this)?>" class="fa fa-eye"></i></a>

                                        <a href="<?php echo base_url(); ?>cms/gallery/edit/<?php echo $data['g_id']; ?>" class="btn custblue btn-sm" title="<?=_l('Edit',$this)?>"><i title="<?=_l('Edit',$this)?>" class="fa fa-pencil"></i></a>
                                        
                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/gallery/delete/'.$data["g_id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                                <?php } endif; ?>
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
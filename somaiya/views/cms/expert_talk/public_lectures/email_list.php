<!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown bold"></i>
                            <span class="caption-subject font-brown bold uppercase"><?php echo $pub_lect_title; ?> Email List</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if(count($data_list) > 0){ ?>
                                        <span class="custorange pull-right"><a href="<?php echo base_url('cms/public_lectures/export_email_list/'); ?>" class="btn sbold orange">Export</a></span>
                                    <?php } ?>
                                </div>                                                         
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="table_id">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Joined On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($data_list) > 0){
                                        foreach($data_list as $data){
                                ?>
                                            <tr class="gradeX table_tr">
                                                <td><?=$data["email"]?></td>
                                                <td>
                                                    <?php
                                                        if(isset($data['created_on']) && !empty($data['created_on']) && $data['created_on'] !== '0000-00-00 00:00:00')
                                                        {
                                                          echo date('d F, Y H:i:s', strtotime($data['created_on']));
                                                        }
                                                        else
                                                        {
                                                          echo 'NA';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="wd100 text-center">
                                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/public_lectures/delete'.$page.'/'.$data["id"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                    else
                                    {
                                ?>
                                        <tr class="gradeX">
                                            <td class="text-center" colspan="3">No Expert Talk Email List Available</td>
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
            $('#table_id').DataTable({
                "order": []
            });
        });
    </script>
<!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown bold"></i>
                            <span class="caption-subject font-brown bold uppercase">Newsletter Subscribers</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if(count($data_list) > 0){ ?>
                                        <span class="custorange pull-right"><a href="<?php echo base_url('cms/newsletter/newsletter_export/'); ?>" class="btn sbold orange">Export</a></span>
                                    <?php } ?>
                                </div>                                                         
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Newsletter</th>
                                    <th>Joined On</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(count($data_list) > 0){
                                        foreach($data_list as $data){
                                ?>
                                            <tr class="gradeX table_tr">
                                                <td><?=$data["email"]?></td>
                                                <td><?=$data["type"]?></td>
                                                <td><?=$data["newsletter_type"]?></td>
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
                                                        <!-- <a href="<?=$base_url?>delete<?=$page?>/<?=$data["id"]?>" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="return doconfirm();"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a> -->
                                                        <a href="javascript:void(0);" class="btn custred" title="<?=_l('Delete',$this)?>" onClick="confirmdelete('<?php echo base_url('cms/newsletter/delete_newsletter/'.$data["subid"]); ?>');"><i title="<?=_l('Delete',$this)?>" class="fa fa-trash-o"></i></a>
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
                                            <td class="text-center" colspan="3">No Newsletter Subscribers Available</td>
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
                "order": [[ 2, "desc" ]],
                "iDisplayLength": 25
            } );
        } );

        window.alert = function() {};
    </script>

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
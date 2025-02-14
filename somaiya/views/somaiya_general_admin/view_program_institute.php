    <!-- BEGIN LIST CONTENT -->
    <div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown"></i>
                            <span class="caption-subject font-brown bold uppercase">Prgrommes</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- <span class="custorange"> <a href="<?php echo base_url(); ?>admin/banner"><button id="sample_editable_1_new" class="sizebtn btn sbold orange">Add New<!-- <i class="fa fa-plus"></i> --> 
                                        <!-- </button></a></span> -->
                                  
                                     <span class="custpurple">&nbsp;&nbsp;<button class="sizebtn btn brown" onclick="history.go(-1);">Back </button> </span>
                                </div>                                                         
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>    
                                    <th>Institute Name</th>
                                    <th>Institute Shortname</th>
                                    <th>Institute Code</th>
                                    <th>Programmes List</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(isset($institutes_list_program) && is_array($institutes_list_program) && count($institutes_list_program)): //$i=1;
                                    foreach ($institutes_list_program as $key => $data) {                            
                                ?>
                                <tr class="gradeX">
                                    <td><?php echo $data['INST_NAME']; ?></td>
                                    <td><?php echo $data['INST_SHORTNAME']; ?></td>
                                    <td><?php echo $data['institute_id']; ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url(); ?>admin/program/<?php echo $data['institute_id']; ?>" class="btn custblue btn-sm"><i title="<?=_l('Edit',$this)?>" class="fa fa-arrow-circle-right"></i></a>
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

<link href="<?=base_url()?>assets/somaiya_com/css/select2.min.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/somaiya_com/js/select2.min.js"></script>
<script type="text/javascript">
 $(document).ready(function() {
    $('.js-institute-multiple').select2();

    $('#btn_clear').click(function(e){ 
      $('#searchkeyword').val('');     
    $("#single").val('').trigger('change');
    });

}); 
 </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sample_1').DataTable( {
                "order": [[ 3, "desc" ]],
                "iDisplayLength": 25
            } );
        } );

        window.alert = function() {};
    </script>
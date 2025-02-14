<div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">Progammes</span>
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
                                <th>URL</th>
                                <th>Institute Short Name</th>
                                <th>Code</th>
                                <th>Publish</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach($data_list as $data)
                                { 
                                    //echo "<pre>";print_r($data);exit;?>
                                    <tr class="gradeX">
                                        <?php if ($data['Specialization_parent'] == 1) {?>
                                            <td><?=$data['specialization_name']?></td>
                                            <td><?=$data['specialurl']?></td>
                                            <td><?=$data['INST_SHORTNAME']?></td>
                                            <td><?=$data['coursecode']?></td>
                                            <td><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                            <td>
                                                <!-- Button to trigger modal -->
                                            <button class="btn btn-success btn-lg" onclick="showSpecialUrlPopup('<?php echo $data["MAP_COURSE_ID"]; ?>' , '<?php echo $data["specialurl"]; ?>', '<?php echo $data["contents_id_special"]; ?>');">Update URL</button>
                                            </td>
                                        <?php } else { ?>
                                            <td><?=$data['COURSE_NAME']?></td>
                                            <td><?=$data['url']?></td>
                                            <td><?=$data['INST_SHORTNAME']?></td>
                                            <td><?=$data['coursecode']?></td>
                                            <td><i class="fa <?=$data["public"]==1?"fa-check":"fa-minus-circle"?>"></i></td>
                                            <td>
                                                <!-- Button to trigger modal -->
                                            <button class="btn btn-success btn-lg" onclick="showUrlPopup('<?php echo $data["MAP_COURSE_ID"]; ?>' , '<?php echo $data["url"]; ?>', '<?php echo $data["contents_id"]; ?>');">Update URL</button>
                                            </td>
                                        <?php } ?>
                                    </tr>




                                    


                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalForm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Update URL</h4>
            </div>
            <form id="user_manipulate" role="form" method="post" action="<?php echo base_url('admin/'.$page."_url_manipulate"); ?>">
                <input type="hidden" name="map_course_id" id="map_course_id" value="" />
                <input type="hidden" name="contents_id" id="contents_id" value="" />
                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <div class="fields_wrap">
                        <div class="form-group ">
                            <label for="data[url]" class="control-label col-lg-2">Program URL</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="url" name="url" value="" required="" data-error=".urlerror" type="text">
                                <div class="urlerror error_msg"><?php echo form_error('url', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" value="Update" class="btn btn-warning" name="submit" id="submit">
                </div>
             </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormSpecial" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Update URL</h4>
            </div>
            <form id="user_manipulate" role="form" method="post" action="<?php echo base_url('admin/'.$page."_specialurl_manipulate"); ?>">
                <input type="hidden" name="map_course_id_special" id="map_course_id_special" value="" />
                <input type="hidden" name="contents_id_special" id="contents_id_special" value="" />
                <!-- Modal Body -->
                <div class="modal-body">
                    <p class="statusMsg"></p>
                    <div class="fields_wrap">
                        <div class="form-group ">
                            <label for="data[specialurl]" class="control-label col-lg-2">Specialization URL</label>
                            <div class="col-lg-10">
                                <input class=" form-control" id="specialurl" name="specialurl" value="" required="" data-error=".urlerror" type="text">
                                <div class="urlerror error_msg"><?php echo form_error('specialurl', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" value="Update" class="btn btn-warning" name="submit" id="submit">
                </div>
             </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showUrlPopup(map_course_id,url,contents_id) {
        $('#modalForm').modal('show');
        $('#map_course_id').val(map_course_id);
        $('#url').val(url);
        $('#contents_id').val(contents_id);
    }

    function showSpecialUrlPopup(map_course_id_special,specialurl,contents_id_special) {
        $('#modalFormSpecial').modal('show');
        $('#map_course_id_special').val(map_course_id_special);
        $('#specialurl').val(specialurl);
        $('#contents_id_special').val(contents_id_special);
    }

$().ready(function() {

    $.validator.addMethod("check_unique_url", 
        function(value, element) {
            var result = false;
            $.ajax({
                type:"POST",
                async: false,
                url: "ajax_check_pro_url", // script to validate in server side
                data: {url: value},
                success: function(data) {
                    result = (data == true) ? true : false;
                }
            });
            // return true if username is exist in database
            return result; 
        }, 
        "This url is already taken! Try another."
    );

    // validate signup form on keyup and submit
    $("#user_manipulate").validate({
        rules: {
            "url": {
                required: true,
                check_unique_url: true
            }
        }
    });
}); 
</script>
<div class="app-ticket app-ticket-list">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe font-brown "></i>
                            <span class="caption-subject font-brown bold uppercase">Media</span>
                        </div>
                        <span class="custpurple">&nbsp;&nbsp;<a class="sizebtn btn brown" href="<?php echo base_url('admin/'); ?>">Back </a></span>                                  

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php mk_use_uploadbox($this); ?>
                                    <?php 
                                        mk_hpostform();
                                        mk_hurl_upload("data[image]",_l('Upload Image',$this),isset($settings['image'])?$settings['image']:'',"image",'required');
                                        mk_hsubmit(_l('Submit',$this),$base_url,_l('Cancel',$this));
                                        mk_closeform(); 
                                    ?>
                                </div>                                                         
                            </div>
                        </div>
                        <?php if(isset($data_list) && count($data_list)!=0){ ?>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>                                                               
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Image Path</th>
                                    <th>Edit</th>
                                    <th>Delete</th>                                           
                                </tr>
                            </thead>
                            <tbody>
                              <?php foreach($data_list as $data){ ?>
                                <tr>
                                  <td><img class="img-rounded" src="<?=base_url().image($data['image'],$settings['default_image'],300,200)?>" style="width:70px;height:70px;" alt="Image">
                                  </td>
                                  <td><p class=""><?=$data["name"]?></p></td>
                                  <td><p class=""><?php echo base_url(); ?><?=$data['image']?></p></td>
                                  <td><p class="">
                                  <a href="<?=$base_url?>edit_image/<?=$data['image_id'];?>" class="btn yellow-crusta"><i class="icon-note"></i> </a>
                                  </p>
                                  </td>
                                  <td><p class="">
                                  <a href="<?=$base_url?>delete_image/<?=$data['image_id'];?>" onclick="return doconfirm();" class="btn red-mint"><i class="icon-trash"></i></a>
                                  </p></td>
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
<?php mk_popup_uploadfile(_l('Upload Image',$this),"image",$base_url."upload_image/20/"); ?>

<script>
function doconfirm()
{
    job=confirm("Are you sure to delete permanently?");
    if(job!=true)
    {
        return false;
    }
}
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
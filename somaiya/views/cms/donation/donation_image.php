<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 

$donation_image_url         = $donation_default_image_url = base_url()."upload_file/donation_upload/default.png";
$delete_image            = false;
    if(isset($donation_data['image']) && !empty($donation_data['image']))
    {
        $delete_image       = true;
        $donation_image_url    = base_url()."upload_file/donation_upload/".$donation_data['image'];
    }

    $donation_id           = isset($donation_data['donation_id']) ? $donation_data['donation_id'] : '';
    //$contents_id        = isset($donation_data['contents_id']) ? $donation_data['contents_id'] : '';
    //echo "contents id : ".$contents_id;
?>

<div class="form-group">
    <label class="control-label col-lg-2">Image&nbsp;&nbsp;<span><a title="Upload image dimensions are 621 pixels (width) x 352 pixels (height). And size of file should be less than 2mb." data-toggle="tooltip" data-placement="right"><i class="fa fa-info-circle" aria-hidden="true"></i></a></span> </label>
    <div class="col-lg-10 col-sm-10">
        <div class="row"> 
            <div class="col-md-12">
                <input type="text" id="croppie-profile" class="croppie-input" name="profile_pic" accept=".png,.jpg,.jpeg,.gif">
                <?php if(isset($donation_data['image']) && !empty($donation_data['image'])){ ?>
                    <img id="croppie-image" class="croppie-img" src="<?php echo $donation_image_url; ?>" height="170px" width="170px" />
                    <input id="croppie_upload_image" type="file" class="croppie-input" placeholder="Photo" capture>
                <?php } else { ?>
                    <input id="croppie_upload_image" type="file" class="croppie-input cc" placeholder="Photo" capture>
                <?php } ?>
                <input type="hidden" id="croppie-thumbnail" name="image" class="croppie-input">
            </div>
        </div>
        
        <div class="col-md-1">
            <?php if($delete_image){ ?>
                <a class="btn btn-sm btn-danger" id="delete_image" href="javascript:void(0);" title="Delete" onclick="delete_image('<?php echo $donation_id; ?>');"><i class="icon-trash"></i></a>
            <?php } ?>
        </div>

        <div id="uploadimageModal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Crop Image</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div id="donation_image_demo"  style=""></div>
                            </div>
                            <div class="col-md-4" style="padding-top:0px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="skip" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                        <button type="button" class="btn green crop_image">Crop</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

	function delete_image(donation_id) {
		var donation_default_image_url = '<?php echo $donation_default_image_url; ?>';
        var answer = confirm ("Are you sure you want to delete from this image?");
        if (answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/donation/deleteimage');?>",
                data: "donation_id="+donation_id,
                success: function (response) {
                    if(response == 1)
                    {
                    	$('#delete_image').addClass('hidden');
                        $('#croppie-image').addClass('hidden');
                        $('#croppie_upload_image').css('display','block');
                        
                    	$('#donation_image_src').attr('src', donation_default_image_url);
                        //$(".imagelocation"+image_id).remove(".imagelocation"+image_id);
                    }
                }
            });
        }
    }


(function(){
        var options = {};
        $('.js-uploader__box').uploader(options);
    }());

    $('.cross-btn').click(function(){
        $(this).parent().parent().remove();
    });
</script>


<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/croppie/croppie.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/global/plugins/croppie/custom_croppie.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/croppie/croppie.js"></script> 

<script type="text/javascript">
    $(document).ready(function() {
        $image_crop = $('#donation_image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 621,
                height: 352,
                // type: 'circle',
            },
            boundary: {
                width: 621,
                height: 352
            }
        });

        var fileTypes = ['jpg', 'jpeg', 'png'];

        $('#croppie_upload_image').on('change', function() {
            var reader = new FileReader();

            var file = this.files[0]; // Get your file here
            var fileExt = file.type.split('/')[1]; // Get the file extension
            if (fileTypes.indexOf(fileExt) !== -1) {
                var nam;
                if (event.target.value.length > 0) {
                    nam = event.target.files[0].name;
                    document.getElementById("croppie-profile").value = nam;
                    // console.log(nam);

                    reader.onload = function(event) {
                        $image_crop.croppie('bind', {
                            url: event.target.result
                        }).then(function() {
                            console.log('jQuery bind complete');
                        });
                    }
                    reader.readAsDataURL(this.files[0]);
                    console.log(this.files);
                    $('#uploadimageModal').appendTo("body").modal('show');
                }

            } else {
                        alert('File not supported');
                        var donation_default_image_url = '<?php echo $donation_default_image_url; ?>';

                        $('#delete_image').addClass('hidden');
                        $('#croppie-image').addClass('hidden');
                        $('#croppie_upload_image').css('display','block');
                        $('#croppie_upload_image').val('');
                        $('#donation_image_src').attr('src', donation_default_image_url);
                        
                    }
        });

        $('.crop_image').click(function(event) {
            $image_crop.croppie('result', {
                circle: false,
                type: 'canvas',
                size: 'viewport'
            }).then(function(response) {
                $('#uploadimageModal').modal('hide');
                $('#croppie-image').attr('src', response);
                $('#croppie_upload_image').attr('value', response);
                $('#croppie-thumbnail').attr('value', response);
            })
        });
    });

    $("#croppie-image").click(function(e) {
        $("#croppie_upload_image").click();
    });
</script>

<style type="text/css">.cc{display: block!important;}</style>
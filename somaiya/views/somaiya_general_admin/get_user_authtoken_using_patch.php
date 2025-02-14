<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

?>
<div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">User AWS Bucket List</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('admin/user'); ?>">Back</a> </span>
                            </div>                                                         
                        </div>
                    </div>

<?php 
// start AWS S3 code

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// define('AWS_KEY', 'AKIAZLQRW7NLXI5HKQ7H');
// define('AWS_SECRET_KEY', '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');
//define('AWS_KEY', 'AKIAZLQRW7NLRK5FW4S4');
//define('AWS_SECRET_KEY', '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');

define('AWS_KEY', 'AKIAZLQRW7NLUQAW34EA');
define('AWS_SECRET_KEY', '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');

//$ENDPOINT = 'http://objects.dreamhost.com';
$ENDPOINT = 's3-website.ap-south-1.amazonaws.com';

// require the amazon sdk from your composer vendor dir
//require_once 'C:/xampp/htdocs/edu/vendor/autoload.php';
require_once '/var/www/html/somaiya.com/vendor/autoload.php';

try {

// Instantiate the S3 client with your AWS credentials
$s3Client = S3Client::factory(array(
    'region' => 'ap-south-1',
    'version' => '2006-03-01',
    'credentials' => array(
        'key'    => AWS_KEY,
        'secret' => AWS_SECRET_KEY,
    )
));

$buckets = $s3Client->listBuckets();

$all_s3_bucket_list = array();

foreach ($buckets['Buckets'] as $bucket){
    $all_s3_bucket_list[] = $bucket['Name'];
    }

}
catch(Exception $e) {

   exit($e->getMessage());
} 


// End AWS S3 code


$bucket_list_data 			= $this->session->flashdata('bucket_list_data');
$empty_bucket_list_mesage 	= $this->session->flashdata('empty_bucket_list_mesage');
$user_permission 			= $this->session->flashdata('user_permission');

	if(isset($user_permission) && !empty($user_permission))
	{
		echo $user_permission;
	}
	else
	{
		if(isset($empty_bucket_list_mesage) && !empty($empty_bucket_list_mesage))
		{
			
			?>
			<!-- <form name="selected_bucket_form" method="post" action="<?php //echo base_url();?>arigel_general_admin_replica/selected_bucket_form"> -->
				<form name="selected_bucket_form" method="post" action="<?php echo base_url();?>admin/selected_bucket_form">
				<input type="hidden" name="user_email_id" id="user_email_id" value="<?php echo isset($user_email_id)?$user_email_id:''; ?>"/>		
				<input type="hidden" name="user_unique_id" id="user_unique_id" value="<?php echo isset($user_id)?$user_id:''; ?>"/>		
				<div class="form-group">
					<label for="aws_bucket" class="control-label col-lg-2">AWS Bucket <!-- <span class="asterisk">*</span> --></label>
					<div class="col-lg-10">
						<select id="bucket_check" class="form-control select2" name="bucket_check[]" data-placeholder="Please Select Bucket" multiple >
							<!-- <option value="">Select Event Type</option> -->
							<?php if(isset($all_s3_bucket_list) && count($all_s3_bucket_list)!=0){ ?>
							<?php foreach ($all_s3_bucket_list as $key => $value) { ?>
								<option value="<?php echo $value; ?>" <?php if( isset($bucket_list_data) && in_array($value, $bucket_list_data)) echo"selected"; ?> > <?php echo $value; ?></option>
							<?php } } ?>
						</select>
						<input id="chkall" type="checkbox" >Select All
					</div>
				</div>
				<input type="submit" name="selected_bucket_form_submit" id="selected_bucket_form_submit" value="submit"/>
			</form>

			<?php
		}
		else
		{
			?>
			<!-- <form name="get_aws_token_list_form" method="post" action="<?php //echo base_url();?>arigel_general_admin_replica/user_authtoken_using_patch" id="get_aws_token_list_form" style="display: none;"> -->
				<form name="get_aws_token_list_form" method="post" action="<?php echo base_url();?>admin/user_authtoken_using_patch" id="get_aws_token_list_form" style="display: none;">
				<input type="hidden" name="user_email_id" id="user_email_id" value="<?php echo isset($user_email_id)?$user_email_id:''; ?>"/>		
				<input type="hidden" name="user_unique_id" id="user_unique_id" value="<?php echo isset($user_id)?$user_id:''; ?>"/>		
				<input type="submit" name="get_aws_token_list" id="get_aws_token_list" value="Get AWS buckets list"/>
			</form>
			<?php
		}
	}
	
?>
		
</div>
</div>
</div>
</div>	

<script type="text/javascript">

$(document).ready(function() {

	$('#bucket_check').select2();

	$("#chkall").click(function(){
        if($("#chkall").is(':checked')){
            $("#bucket_check > option").prop("selected", "selected");
            $("#bucket_check").trigger("change");
        } else {
            $("#bucket_check > option").removeAttr("selected");
            $("#bucket_check").trigger("change");
        }
    });

});

// on page load 'get_aws_token_list_form' submitted

jQuery(function(){
	console.log("page load form submitted");
   //jQuery('#get_aws_token_list').click();
        $("#get_aws_token_list_form").submit();

});


</script>     

                            
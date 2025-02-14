<?php //echo "department form file is loaded"; exit(); ?>
                                
<?php //mk_use_uploadbox($this); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php
            // echo "<pre>";
            // print_r($post_data);
            // exit();
        ?>
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-brown"></i>
                    <?php if(isset($post_data)) {      ?>
                        <span class="caption-subject font-brown bold uppercase">Edit Deparment list</span>
                    <?php } else { ?>
                         <span class="caption-subject font-brown bold uppercase">Add New Department</span>
                   <?php } ?>    
                </div>  
                &nbsp;&nbsp;<span class="custpurple"><a class="brownsmall btn brown" href="<?php echo base_url('/cms/department/'); ?>">Back </a></span>
            </div>
            
            <div class="portlet-body form">
                <div class="form-body">
                    <form id="department_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="">

                        <div class="form-group ">
                            <label for="department_id" class="control-label col-lg-2">Department Name <span class="asterisk">*</span></label>
                            <div class="col-lg-10">
                                <!-- <select id="department_id" name="department_id[]" required> -->
                                    <?php /*
                                    <select id="select2-multiple-input-lg" class="form-control input-lg select2-multiple department_id" name="department_id[]" data-placeholder="Please select department" multiple>
                                    <option value="">-- Please select department --</option>
                                    <?php
                                        
                                        if(!empty($post_data['department_id']))
                                        {
                                            $post_data['department_id'] = explode(',', $post_data['department_id']);
                                        }

                                        foreach ($all_departments as $key => $value) {
                                        ?>
                                           <option value="<?php echo $value['Department_Id']; ?>" <?php if(isset($post_data['department_id']) && !empty($post_data['department_id']) && in_array($value['Department_Id'], $post_data['department_id'])){ echo 'selected="selected"'; } ?>><?php echo $value['Department_Name']; ?></option>
                                        <?php
                                        
                                        }
                                    ?>
                                </select> */ ?>
                                <?php
                                if(!empty($post_data['department_id']))
                                        {
                                            $post_data['department_id'] = explode(',', $post_data['department_id']);
                                        }

                                        $numOfCols = 4;
                                        $rowCount = 0;
                                        $bootstrapColWidth = 12 / $numOfCols;

                                        foreach ($all_departments as $key => $value) {
                                            if($rowCount % $numOfCols == 0) { ?> 
                                                <div class="row"> 
                                            <?php }
                                                $rowCount++;
                                            ?>
                                            <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                                                <input type="checkbox" required minlength ="1" name="department_id[]" id="department_id" value="<?php echo $value['Department_Id'] ?>" <?php if(isset($post_data['department_id']) && !empty($post_data['department_id']) && in_array($value['Department_Id'], $post_data['department_id'])){ echo 'checked'; } ?>> <?php echo $value['Department_Name']; ?>
                                            </div>
                                            <?php
                                            if($rowCount % $numOfCols == 0) { ?> </div> <?php }
                                        }
                                 ?>
                                <div class="department_iderror error_msg"><?php echo form_error('department_id', '<label class="error">', '</label>'); ?></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <input class="btn green" value="Submit" type="submit">
                                <a href="<?php echo base_url('/cms/department/') ?>" class="btn btn-default" type="button">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->                                
    </div>
</div>


<script type="text/javascript">
    
    $("#department_form").validate({
        rules: {
            department_id: {
                required: true,
                minlength: 1
            },
            
        },
        messages: {
            department_id: {
                required: 'Please Select Department',
            },
                        
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            alert("please select atleast one checkbox.");
            // var placement = $(element).data('error');
            
            // if (placement) {
            //     $(placement).append(error)
            // } else {
            //     error.insertAfter(element);
            // }
        },
    });


</script>

<script type="text/javascript">
    // following code used to open select tag when we select multiple option

    // $(".department_id").select2({
    //         closeOnSelect : false,
    //         placeholder : "Placeholder",
    //         allowHtml: true,
    //         allowClear: true,
    //         tags: true // создает новые опции на лету
    //     });


</script>

<style type="text/css">
    /*body { 
    font-family: 'Ubuntu', sans-serif;
    font-weight: bold;
}
.select2-container {
  min-width: 400px;
}

.select2-results__option {
  padding-right: 20px;
  vertical-align: middle;
}
.select2-results__option:before {
  content: "";
  display: inline-block;
  position: relative;
  height: 20px;
  width: 20px;
  border: 2px solid #e9e9e9;
  border-radius: 4px;
  background-color: #fff;
  margin-right: 20px;
  vertical-align: middle;
}
.select2-results__option[aria-selected=true]:before {
  font-family:fontAwesome;
  content: "\f00c";
  color: #fff;
  background-color: #f77750;
  border: 0;
  display: inline-block;
  padding-left: 3px;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #fff;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #eaeaeb;
    color: #272727;
}
.select2-container--default .select2-selection--multiple {
    margin-bottom: 10px;
}
.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
    border-radius: 4px;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #f77750;
    border-width: 2px;
}
.select2-container--default .select2-selection--multiple {
    border-width: 2px;
}
.select2-container--open .select2-dropdown--below {
    
    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0,0,0,0.5);

}
.select2-selection .select2-selection--multiple:after {
    content: 'hhghgh';
}
.select-icon .select2-selection__placeholder .badge {
    display: none;
}
.select-icon .placeholder {
    display: none;
}
.select-icon .select2-results__option:before,
.select-icon .select2-results__option[aria-selected=true]:before {
    display: none !important;
}
.select-icon  .select2-search--dropdown {
    display: none;
}*/
</style>
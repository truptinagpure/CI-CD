<div class="portlet light ">
    <div class="portlet-title tabbable-line">
        <div class="caption caption-md">
            <span class="caption-subject font-brown bold uppercase">Page Permissions</span>
        </div>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-checkable order-column">
            <tbody>
                <tr>
                    <td>Select All</td>
                    <td>
                        <input id="all_permission" name="all_permission" data-id="all_permission" data-selid="all_permission" class="all_permission_select_all method-checkbox" type="checkbox" <?php if(in_array('all_permission', $select_all_data)){ echo 'checked="checked"'; } ?>>
                        <input id="select-all-all_permission" name="selectall[]" value="<?php if(in_array('all_permission', $select_all_data)){ echo 'all_permission'; }else{ echo ''; } ?>" type="hidden">
                    </td>
                </tr>
            </tbody>
        </table>
      
 <table  class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Module Name</th>
                                    <th>Action</th>
                                    <th>Sub module Name</th>
                                    <th>Action</th>
                                    <th>child module Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $j=0 ;?>
                                <?php foreach($data_list as $data){  ?>
                                <?php if($data["parent_id"]==0){  $count=1;$j++; ?>
                                <?php foreach($data_list as $data2){ ?>
                                <?php if($data["module_id"]==$data2["parent_id"]){$count++;}}?>
                                <tr class="gradeX">
                                    <td  rowspan="<?php echo $count?>"> <?php echo $data["module_name"]?></td>
                                    <td rowspan="<?php echo $count?>">
                                       <?php //echo $pagedata["permission"];?>
 <input type="checkbox" id="checkbox-view-<?php echo $data["module_id"]; ?>" name="module_id[]" data-id="view-child-<?php echo $data["module_id"]; ?>"  value= "<?php echo $data["module_id"]; ?>" class="all_permission method-checkbox checkclass<?php echo $j;?>" onchange="checksibling(this.id,'checkclass<?php echo $j;?>')"
 <?php $key = array_search($data["module_id"],$view_permissions);//get key of matched result
    if($key !== false )//check not falsy
    {echo 'checked="checked"';  
        }?>> </td>  

    </tr>



<!-- strat sub module-->
<?php 
foreach($data_list as $data1){ $count2=1 ?>

<?php 
foreach($data_list as $data2c){ ?>

<?php if($data1["module_id"]==$data2c["parent_id"]){ 
 $count2++;}}?>

<?php if($data["module_id"]==$data1["parent_id"]){ 
 ?>
                             
                               <tr>
      
        <td rowspan=" <?php //echo $count2; ?>"><?php echo $data1["module_name"];?></td>
         <td rowspan="<?php // echo $count2; ?>"> <?php //echo $pagedata["permission"];?>
 <input type="checkbox" id="checkbox-view-<?php echo $data1["module_id"]; ?>" name="module_id[]" data-id="view-child-<?php echo $data1["module_id"]; ?>"  value= "<?php echo $data1["module_id"]; ?>" class="all_permission method-checkbox checkclass<?php echo $j;?>" 
 <?php $key = array_search($data1["module_id"],$view_permissions);//get key of matched result
    if($key !== false )//check not falsy
    {
    echo 'checked="checked"';  
        }?>> </td>
<!-- strat sub module-->
<?php 
foreach($data_list as $data3){ $count2=1 ?>

<?php 
foreach($data_list as $data2c){ ?>

<?php if($data1["module_id"]==$data2c["parent_id"]){ 
 $count2++;}}?>

<?php if($data1["module_id"]==$data3["parent_id"]){ 
 ?>                     
                           
        <td rowspan=" <?php //echo $count2; ?>"><?php echo $data3["module_name"];?></td>
         <td rowspan="<?php // echo $count2; ?>"> <?php //echo $pagedata["permission"];?>
 <input type="checkbox" id="checkbox-view-<?php echo $data3["module_id"]; ?>" name="module_id[]" data-id="view-child-<?php echo $data3["module_id"]; ?>"  value= "<?php echo $data3["module_id"]; ?>" class="all_permission method-checkbox checkclass<?php echo $j;?>" 
 <?php $key = array_search($data3["module_id"],$view_permissions);//get key of matched result
    if($key !== false )//check not falsy
    {
    echo 'checked="checked"';  
        }?>> </td>

  <?php } ?>

  <?php } ?>

<!-- end sub module -->

    </tr>
   
  <?php } ?>

  <?php } ?>

<!-- end sub module -->

<?php } ?>



 

                          <?php } ?>
                     
        
                            </tbody>
    </div>
</div>

<script type="text/javascript">

    
     function checksibling(id,obj)
{
if($('#'+id).prop("checked") == true){
 $("."+obj).each(function(){
         $(this).prop("checked",true);
       });
            }
  else if($('#'+id).prop("checked") == false){
                 $("."+obj).each(function(){
         $(this).prop("checked",false);
       });
                
            }
}


    $(document).ready(function() {
        $('.method-checkbox').click(function() {
            var page_id = $(this).data('id');
            if($(this).is(':checked')){
                $('#method-'+page_id).val(1);
            }else{
                $('#method-'+page_id).val(0);
            }
        });

        $('#all_permission').click(function() {
            var selid = $(this).data('selid');
            if($(this).is(':checked')){
                todo = 'check';
                $('#select-all-'+selid).val(selid);
            }else{
                todo = 'uncheck';
                $('#select-all-'+selid).val('');
            }

            $('.all_permission').each(function(index, obj) {
                var page_id = $(this).data('id');
                var data_type = $(this).data('type');
                
                if(todo == 'check')
                {
                    $(this).prop('checked', true);
                    $('#method-'+page_id).val(1);
                }
                else
                {
                    $(this).prop('checked', false);
                    $('#method-'+page_id).val(0);
                }
            });

            $('.all_permission_select_all').each(function(index, obj) {
                var selid = $(this).data('selid');
                var data_type = $(this).data('type');

                if(todo == 'check')
                {
                    $(this).prop('checked', true);
                    $('#select-all-'+selid).val(selid);
                }
                else
                {
                    $(this).prop('checked', false);
                    $('#select-all-'+selid).val('');
                }
            });
        });
    });

    function selectall(type, menuclass, submenuclass, childmenuclass, chk) {
        var todo = '';
        var selclass = '';
        var avoid1 = '';
        var avoid2 = '';
        var selid = $(this).data('selid');

        if(chk.checked == true)
        {
            todo = 'check';
            $('#select-all-'+selid).val(selid);
        }
        else
        {
            todo = 'uncheck';
            $('#select-all-'+selid).val('');
        }

        if(type == 'menu')
        {
            selclass = menuclass;
        }
        else if(type == 'submenu')
        {
            selclass = submenuclass;
            // avoid1 = 'menu_select_all';
        }
        else if(type == 'childmenu')
        {
            selclass = childmenuclass;
            // avoid1 = 'menu_select_all';
            // avoid2 = 'submenu_select_all';
        }
        
        $('.'+selclass).each(function(index, obj) {
            var page_id = $(this).data('id');
            var data_type = $(this).data('type');

            if(todo == 'check')
            {
                $(this).prop('checked', true);
                $('#method-'+page_id).val(1);
            }
            else
            {
                $(this).prop('checked', false);
                $('#method-'+page_id).val(0);
            }
        });

        $('.select-all').each(function(index, obj) {
            if($(this).is(':checked'))
            {
                $('#select-all-'+$(this).data('selid')).val($(this).data('selid'));
            }
            else
            {
                $('#select-all-'+$(this).data('selid')).val('');
            }
        });
    }
</script>
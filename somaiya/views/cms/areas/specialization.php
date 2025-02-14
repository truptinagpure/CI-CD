<div class="form-group ">
    <label for="status" class="control-label col-lg-2">Area Specialization</label>
    <div class="col-lg-10 col-sm-10">
        <div class="boxform">
            <table style="width: 100%;">
                <tbody id="">
            <?php if(isset($specialization) && count($specialization)!=0){ ?>
                <input type="hidden" name="specialization_array_check" value="2">
                <?php
                    $in = 0;
                    foreach ($specialization as $key5 => $data5) { 
                ?>
                        <tr class="group_wrap_special" data-id="<?php echo $data5['id'] ?>">
                            <td class="specialization">
                                <div class="p10">
                                    <input type="text" id="linkname<?php echo $key5; ?>" name="specialization[]" value="<?php if(isset($data5['specialization'])) { echo $data5['specialization']; } ?>" Placeholder="Specialization">
                                </div>
                            </td>
                            <td class="add_remove_td">
                                <div class="p10">
                                    <?php if($key5 == 0){ ?>
                                    <?php }else{ ?>
                                        <a class="removeMore_new" data-id="<?php echo $data5['id'] ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </div>
                            </td>
                            <input type='hidden' name='id_new[]' value='<?php echo $data5['id'] ?>' />
                        </tr>
                        <?php if($key5 == 0){ ?> 
                            <div style="padding-bottom:20px;">
                                <a style="font-weight: bold;border: 1px solid #337ab7;padding: 5px 10px;" class="addspecial btn btn-secondary" href="javascript:void(0);">ADD MULTIPLE SPECIALIZATION</a>
                            </div>
                        <?php } ?>
                <?php $in++;}} else { ?>
                    <input type="hidden" name="specialization_array_check" value="1">
                    <tr class="group_wrap_special">
                        <td class="specialization">
                            <div class="p10">
                                <input type="text" id="linkname0" name="specialization[]" Placeholder="Specialization">
                            </div>
                        </td>
                    </tr>
                    <div style="padding-bottom:20px;">
                        <a style="font-weight: bold;border: 1px solid #337ab7;padding: 5px 10px;" class="addspecial btn btn-secondary" href="javascript:void(0);">ADD MULTIPLE SPECIALIZATION</a>
                    </div>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
span.select2.select2-container.select2-container--bootstrap.select2-container--focus {
    width: auto!important;
    margin-right: 20px;
}
span.select2.select2-container.select2-container--bootstrap{  width: auto!important;
    margin-right: 20px;}
.fa-info-circle{font-size: 18px;}
tr.group_wrap_special
{
    position:relative;
    float:left;
    margin-bottom:12px; 
    width:100%;
    padding: 10px; 
    border: 1px dotted #ccc;
}
td.link_url, td.specialization 
{
    width: 90%;
    float: left;
}
td.add_remove_td
{
    width: 4%;
}
input[type=text] 
{
    padding: 12px;
    margin: 3px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 90%;
}
.all-scroll {cursor: all-scroll;}
</style>


<script type="text/javascript">
    // i=$('.group_wrap_special').length;
i=1;
$(document).on('click', 'a.addspecial', function (e) {
    e.preventDefault();
    $(".group_wrap_special:last").after('<tr class="group_wrap_special"><td class="specialization"><div class="p10"><input type="text" id="linkname'+i+'" name="specialization[]" Placeholder="Specialization"></div></td><td class="add_remove_td"><div class="p10"><a class="removeMore'+i+'" data-id=""><i title="<?=_l("Delete",$this)?>" class="fa fa-trash-o"></i></a></div></td></tr>');
    // removeMore();
    $(".removeMore_new"+i).click(function(){
        var pid = $(this).attr("data-id");
        var answer = confirm ("Are you sure you want to delete?");
        if(answer)
        {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('cms/areas/delete_specialization');?>",
                data: "pid="+pid,
                success: function (response) {
                  if (response == 1) {
                    $(".imagelocation"+pid).remove(".imagelocation"+pid);
                  };
                }
            });
        }
        $(this).parent().parent().parent().fadeOut("slow", function() {
            // $(this).parent().parent().parent().remove();
            $(this).remove();
        });
    });
    //select_institute(i);
    i++;
});

$(".removeMore_new").click(function(){
    var pid = $(this).attr("data-id");
    var answer = confirm ("Are you sure you want to delete?");
    if(answer)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('cms/areas/delete_specialization');?>",
            data: "pid="+pid,
            success: function (response) {
              if (response == 1) {
                $(".imagelocation"+pid).remove(".imagelocation"+pid);
              };
            }
        });
    }
    $(this).parent().parent().parent().fadeOut("slow", function() {
        // $(this).parent().parent().parent().remove();
        $(this).remove();
    });
});
</script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $( "#page_list" ).sortable({
            placeholder : "ui-state-highlight",
            update  : function(event, ui)
            {
                var programme_id_array = new Array();
                $('#page_list tr').each(function(){
                    programme_id_array.push($(this).attr("data-id"));
                });
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('cms/mmg/save_mmglinks_order');?>",
                    data: {programme_id_array:programme_id_array},
                    success:function(data)
                    {
                        alert(data);
                    }
                });
            }
        });
    });
</script>
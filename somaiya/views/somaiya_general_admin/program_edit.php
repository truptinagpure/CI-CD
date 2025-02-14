<?php mk_use_uploadbox($this); ?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-brown"></i>
                            <span class="caption-subject font-brown bold uppercase">Edit Program</span>
                          </div>
                         &nbsp;&nbsp;<span class="custpurple"><button class="brownsmall btn brown" onclick="history.go(-1);">Back</button> </span>
                                                      
                </div>
<?php error_reporting(0); ?>
            <div class="panel-body">
                <div class=" form"><?php $institute = $_SESSION['inst_id'] ?>
                    <?php 
                    mk_hpostform($base_url.$page."_manipulate".(isset($data['MAP_CO_ID'])?"/".$data['MAP_CO_ID']:""));
                    // mk_hidden("data[institute_id]",$institute);
                    // if($institute==0){
                    mk_hselect("data[MAP_CO_INST_ID]",_l('Institute Name',$this),$institutepro,"INST_ID","INST_NAME",isset($data['MAP_CO_INST_ID'])?$data['MAP_CO_INST_ID']:null,null,'style="width:200px required"');
                    // }
                    mk_hselect("data[MAP_CO_STREAM_ID]",_l('Stream Name',$this),$stream,"STREAM_ID","STREAM_NAME",isset($data['MAP_CO_STREAM_ID'])?$data['MAP_CO_STREAM_ID']:null,null,'style="width:200px required"'); 

                    mk_hselect("data[MAP_CO_COURSE_ID]",_l('Course Name',$this),$course,"COURSE_ID","COURSE_NAME",isset($data['MAP_CO_COURSE_ID'])?$data['MAP_CO_COURSE_ID']:null,null,'style="width:200px required"'); 

                    mk_hselect("data[MAP_CO_CLASS_ID]",_l('Class Name',$this),$class,"CLASS_ID","CLASS_NAME",isset($data['MAP_CO_CLASS_ID'])?$data['MAP_CO_CLASS_ID']:null,null,'style="width:200px required"'); 

                    ?>
                <?php

                    mk_htext("data[program_name]",_l('Program Name',$this),isset($data['program_name'])?$data['program_name']:'','required');
                    foreach ($languages as $item) {
                        mk_htext("data[titles][".$item["language_id"]."]",_l('Program Name',$this)." (".$item["language_name"].")",isset($titles[$item["language_id"]])?$titles[$item["language_id"]]["title_caption"]:"",'required');
                    }
                    mk_hcheckbox("data[public]",_l('Publish',$this),(isset($data['public']) && $data['public']==1)?1:null);
                    mk_hsubmit(_l('Submit',$this),$base_url.$page,_l('Cancel',$this));
                    mk_closeform();
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
mk_popup_uploadfile(_l('Upload Avatar',$this),"avatar",$base_url."upload_image/20/");
?>

<script src="ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script language="javascript" type="text/javascript">  
$(document).ready(function(){
    //let's create arrays
    var ABC = [
        {display: "abc1", value: "abc1" }, 
        {display: "abc2", value: "abc2" }, 
        {display: "abc3", value: "abc3" },
        {display: "abc4", value: "abc4" }];
        
    var PQR = [
        {display: "pqr1", value: "pqr1" }, 
        {display: "pqr2", value: "pqr2" }, 
        {display: "pqr3", value: "pqr3" },
        {display: "pqr4", value: "pqr4" }];
        
    var STU = [
        {display: "stu1", value: "stu1" }, 
        {display: "stu2", value: "stu2" }, 
        {display: "stu3", value: "stu3" },
        {display: "stu4", value: "stu4" }];

    //If parent option is changed
    $("#parent_selection").change(function() {
        var parent = $(this).val(); //get option value from parent 
        
        switch(parent){ //using switch compare selected option and populate child
              case 'ABC':
                list(ABC);
                break;
              case 'PQR':
                list(PQR);
                break;              
              case 'STU':
                list(STU);
                break;  
            default: //default child option is blank
                $("#child_selection").html('');  
                break;
        }
    });

    //function to populate child select box
    function list(array_list)
    {
        $("#child_selection").html(""); //reset child options
        $(array_list).each(function (i) { //populate child options 
            $("#child_selection").append('<option value='+array_list[i].value+'>'+array_list[i].display+'</option>');
        });
    }

});
</script>

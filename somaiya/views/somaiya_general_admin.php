<?php
    $select_institute = '';
    $select_institute_fun = '';
    $sess_institute_id = '';
    $sess_institute_name = 'Select Institute';
    $sess_institute_short_name = '';
    
    if($this->session->userdata['user_id'] == 1)
    {
        if(isset($_SESSION['sess_institute_id']) && !empty($_SESSION['sess_institute_id']))
        {
            $sess_institute_id = $_SESSION['sess_institute_id'];
            $sess_institute_name = $_SESSION['sess_institute_name'];
            $sess_institute_short_name = $_SESSION['sess_institute_short_name'];
        }
        else
        {
            $sess_institute_id = $_SESSION['sess_institute_id'] = 1;
            $sess_institute_name = $_SESSION['sess_institute_name'] = 'Somaiya Com';
            $sess_institute_short_name = $_SESSION['sess_institute_short_name'] = 'somaiyacom';
        }
    }
    else
    {
        if(isset($_SESSION['sess_institute_id']) && !empty($_SESSION['sess_institute_id']))
        {
            $sess_institute_id = $_SESSION['sess_institute_id'];
            $sess_institute_name = $_SESSION['sess_institute_name'];
            $sess_institute_short_name = $_SESSION['sess_institute_short_name'];
        }
        else
        {
            if(count($institutes_dropdown_list) == 1)
            {
                $sess_institute_id = $_SESSION['sess_institute_id'] = $institutes_dropdown_list[0]['INST_ID'];
                $sess_institute_name = $_SESSION['sess_institute_name'] = $institutes_dropdown_list[0]['INST_NAME'];
                $sess_institute_short_name = $_SESSION['sess_institute_short_name'] = $institutes_dropdown_list[0]['INST_SHORTNAME'];
            }
            else
            {
                $sess_institute_id = $_SESSION['sess_institute_id'] = '';
                $sess_institute_name = $_SESSION['sess_institute_name'] = 'Select Institute';
                $sess_institute_short_name = $_SESSION['sess_institute_short_name'] = '';
                $select_institute = 'select_institute';
                $select_institute_fun = 'onclick="select_institute();"';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="<?=$_SESSION["language"]["code"]?>">
    <head>
        <meta charset="utf-8" />        
        <title><?=_l('Administration',$this)?> <?=isset($settings["company"])?$settings["company"]:""?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Preview page of Metronic Admin Theme #1 for statistics, charts, recent events and reports" name="description" />
        <meta content="" name="author" />

        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" />
        <link rel="shortcut icon" href="<?php echo base_url(); ?><?=isset($settings["fav_icon"])?$settings["fav_icon"]:""?>">

        <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo base_url(); ?>assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/toastr/toastr.css" rel="stylesheet" type="text/css" />
        <?php if($_SESSION["language"]["rtl"]==1){ ?>
            <link href="<?php echo base_url(); ?>assets/flatlab/css/rtl.css" rel="stylesheet">
        <?php } ?>

        <link href="<?php echo base_url(); ?>assets/layouts/layout/css/app.css" rel="stylesheet" type="text/css" />
        
        <script src="<?php echo base_url(); ?>assets/global/js/jquery-1.8.3.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/additional-methods.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/sweetalert2/sweetalert2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/toastr/toastr.js"></script>
        
        <script type="text/javascript">
        
            var base_url = "<?php echo base_url(); ?>";

            function confirmdelete(url)
            {
                swal({
                    title: "Are you sure?",
                    text: 'Do you really want to delete this permanently?',
                    type: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonClass: "btn btn-success mr10",
                    cancelButtonClass: "btn btn-danger",
                    buttonsStyling: false,
                    confirmButtonText: "Yes, Delete!"
                }).then(function () {
                    window.location.href = url;
                }, function(dismiss) {});
            }

            $(document.body).on('click', '.select_institute' ,function(){
                alert("The paragraph was clicked.");
            });

            function select_institute() {
                $('#sessInstituteModal').modal('show');
            }

            function setInstitute(sel) {
                var sel_inst = sel.value;
                var sel_inst_short_name = sel.selectedOptions[0].getAttribute('data-shortname');
                $('#inst_short_name').val(sel_inst_short_name);
                $('#setInstituteForm').submit();
            }
        </script>

        <?php
            $requeststatus = $this->session->flashdata('requeststatus');
            if(isset($requeststatus['error']) && $requeststatus['message'] != ''){
        ?>
            <script type="text/javascript">
                $(function () {
                    var errorstatus = '<?php echo $requeststatus["error"]; ?>';
                    var message = '<?php echo $requeststatus["message"]; ?>';

                    if(errorstatus == 1)
                    {
                        var status = 'error';
                    }
                    else
                    {
                        var status = 'success';
                    }

                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": true,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "10000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }

                    toastr[status](message, "")
                })
            </script>
        <?php } ?>
        <style type="text/css">
            
            .page-sidebar-menu li.start{margin-top:8px!important;}
            .page-header.navbar .menu-toggler.sidebar-toggler {
                float: right;
                margin: 16.5px 0 0;
            }
            .gradeX td{width:12%;}
            .center{text-align: center!important;}
            .table-checkable tr>td:first-child, .table-checkable tr>th:first-child{text-align: left;padding-left:10px;width:20%;}
            .chwidth { width: 2%!important; text-align: center;}
            .actbtn{text-align: center;}
            .gradeX .btn{padding: 7px 2px 7px 2px!important; margin-bottom: 10px; border-radius: 0!important;}
            td.tempn{width:10%;}
            .wdth15{width:15%;}
            .sizebtn{width:16%;}
            .portlet-body .custred{background: #D73C38;color: #fff;border:1px solid #D73C38; }
            .custpurple .brown{background:#680C25;border:1px solid #680C25;color: #fff; border-radius: 0!important;}
            .custorange .orange,.portlet-body .orange{background: #F79518;border:1px solid #F79518;color: #fff; border-radius: 0!important;}
            .gradeX .orange{background: #F79518;border:1px solid #F79518;color: #fff; height: 34px; width: 50px;}
            .gradeX .custblue, .custblue{background: #2b3643;color:#fff;border: 1px solid #2b3643; height: 34px; width: 50px;border-radius:0!important;}
            .gradeX .custred, .custred{background: #D73C38;color: #fff;border:1px solid #D73C38; height: 34px; width: 50px;border-radius:0!important;}
            .clear{clear:both;}
            .font-brown { color: #690D25!important;}
            .custpurple .brownsmall{width: 8%;}
            .portlet-body label{text-align: left!important;}
            .btn.green:not(.btn-outline),.btn.green:not(.btn-outline):hover{background: #F79518;border:1px solid #F79518;color: #fff;border-radius:0!important;}
            .actioncol{width:20%;}
            .btable tr>td:first-child, .btable tr>th:first-child{width: 10%;}
            .mtop{margin-top:30px;}
            .white{border-radius: 0!important;}
            .videotb .videstatus{width: 7%;}
            .form-horizontal .control-label {
                text-align: left;
                
                font-size: 15px;
            }
            .panel-heading {
                background: #680C25;
                color: #fff;
            }
        </style>
    </head>

    <body>
    <?php
        $user_id                    = $this->session->userdata['user_id'];
        $_SESSION['institute_id']   = $this->uri->segment(3);
    ?>

        <div class="modal fade" id="sessInstituteModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Select Institute</h4>
                    </div>
                    <div class="modal-body">
                        <form id="setInstituteForm" method="POST" action="<?php echo base_url('ajax_cnt/set_institute'); ?>">
                            <div class="form-group mb0">
                                <select class="form-control select2" data-placeholder="-- Select Institute --" name="sess_inst_val" onchange="setInstitute(this);">
                                    <option value="">-- Select Institute --</option>
                                    <?php
                                        foreach ($institutes_dropdown_list as $instkey => $instvalue) {
                                    ?>
                                            <option value="<?php echo $instvalue['INST_ID']; ?>" data-shortname="<?php echo $instvalue['INST_SHORTNAME']; ?>" <?php if(isset($sess_institute_id) && $sess_institute_id == $instvalue['INST_ID']){ echo 'selected="selected"'; } ?>><?php echo $instvalue['INST_NAME']; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                                <input type="hidden" name="inst_short_name" id="inst_short_name" value="<?php echo $sess_institute_name; ?>">
                                <div id="sel_inst_error"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer pt0">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin_menu page-wrapper">
            <div class="page-header navbar navbar-fixed-top">
                <div class="page-header-inner ">
                    <div class="page-logo">
                        <a href="<?php echo $base_url; ?>">
                            <h4 style="color: #fff;" class="bold"><?=isset($settings["company"])?$settings["company"]:""?></h4>
                        </a>
                        <div class="menu-toggler sidebar-toggler"><span></span></div>
                    </div>
                    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"><span></span></a>
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown dropdown-user">
                                <a style="text-align: center;" href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="username username-hide-on-mobile">
                                        <?php
                                            if(isset($_SESSION['login_type']) && !empty($_SESSION['login_type']) && $_SESSION['login_type'] == 2)
                                            {
                                                echo $this->session->userdata('email');
                                            }
                                            else
                                            {
                                                echo $this->session->userdata('username');
                                            }
                                        ?>
                                    </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <!-- <li>
                                        <a href="<?php //echo base_url(); ?>admin/viewprofile">
                                            <i class="icon-user"></i> View Profile
                                        </a>
                                    </li> -->                                  
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin/edituser/<?php echo $user_id; ?>">
                                            <i class="icon-rocket"></i> Edit Profile                                            
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>admin-sign/logout">
                                            <i class="icon-key"></i> Log Out
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="svvlink">
                        <a href="javascript:void(0);" onclick="select_institute();"><?php echo strtoupper($sess_institute_name); ?></a>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
            
            <div class="page-container">
                <div class="page-sidebar-wrapper">
                   <div class="page-sidebar">
                        <ul class="sidebar-menu <?php echo $select_institute; ?>" <?php echo ucfirst($select_institute_fun); ?>>
                            <li class="<?php if(isset($main_menu_type) && $main_menu_type == 'dashboard'){ echo 'open active'; } ?>">
                                <a href="<?php echo base_url('admin/'); ?>">
                                    <i class="fa fa-dashboard"></i>
                                    <span class="">Dashboard</span>
                                </a>
                            </li>
                            <li class="custom_caret <?php if(isset($main_menu_type) && $main_menu_type == 'institute_menu'){ echo 'open active'; } ?>">
                                <a data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-university"></i>
                                    <span class=""><?php echo ucfirst($sess_institute_short_name); ?> Menu </span>
                                    <span></span>
                                </a>
                                <ul class="sidebar-submenu <?php if(isset($main_menu_type) && $main_menu_type == 'institute_menu'){ echo 'menu-open'; } ?>">
                                   <!-- start dynamic menu-->
                                        <?php foreach($select  as $key =>  $modulename): //all menu ?>
                                            <?php if($modulename['main_module'] == 'module') :
                                                if($modulename['parent_id'] == 0) :?>
                                                    <?php $key = array_search($modulename["module_id"],$view_permissions);//get key of matched result
                                                    if($key !== false )//check not falsy
                                                    { ?>
                                                        <li class="<?php echo $modulename['classname'] ;?>  <?php if(isset($sub_menu_type) && $sub_menu_type == $modulename['cums_under_menu'] ){ echo 'open active'; }?>">
                                                            <a  href="<?php  if(isset($modulename['url']) && !empty($modulename['url'])){echo base_url().$modulename['url'];}?><?php if($modulename['url_id']==1){echo $sess_institute_id;}?>">
                                                                <i class="<?php echo $modulename['icon']?>"></i>
                                                                <span class=""><?php echo $modulename['module_name'];?></span>
                                                            </a>
                                                            <!-- -start child -->
                                                            <?php foreach($select  as $key =>  $modulename1): //all menu ?>
                                                                <?php if($modulename['module_id'] == $modulename1['parent_id']):?>
                                                                    <?php $key = array_search($modulename1["module_id"],$view_permissions);//get key of matched result
                                                                    if($key !== false )//check not falsy
                                                                    { ?>
                                                                        <ul class= "sidebar-submenu <?php if(isset($sub_menu_type) && $sub_menu_type == $modulename['cums_under_menu']){ echo 'menu-open'; } ?>"> 
                                                                            <li class=" <?php echo $modulename1['classname'] ;?>  <?php if(isset($child_menu_type) && $child_menu_type == $modulename1['cums_under_menu']){ echo 'active'; } ?>">
                                                                                <a class="" href="<?php if(isset($modulename1['url']) && !empty($modulename1['url'])){echo base_url().$modulename1['url'];} ?><?php if($modulename1['url_id']==1){echo $sess_institute_id;}?>">
                                                                                        <i class="<?php echo $modulename1['icon']?>"></i>
                                                                                        <span class=""><?php echo $modulename1['module_name']?></span>
                                                                                </a>
                                                                                <!-- start of second sub menu-->
                                                                                <?php foreach($select  as $key =>  $modulename2): //all menu ?>
                                                                                    <?php if($modulename1['module_id'] == $modulename2['parent_id']):?>
                                                                                        <?php $key = array_search($modulename2["module_id"],$view_permissions);//get key of matched result
                                                                                            if($key !== false )//check not falsy
                                                                                            { ?>
                                                                                                <ul class=sidebar-submenu <?php if(isset($child_menu_type) && $child_menu_type == $modulename1['cums_under_menu']){ echo 'menu-open'; } ?>> 
                                                                                                    <li class="<?php echo $modulename2['classname'] ;?>  <?php if(isset($sub_child_menu_type) && $sub_child_menu_type ==$modulename2['cums_under_menu']){ echo 'active'; } ?>">
                                                                                                        <a class="" href="<?php echo base_url().$modulename2['url']?><?php if($modulename1['url_id']==1){echo $sess_institute_id;}?>">
                                                                                                            <i class="<?php echo $modulename2['icon']?>"></i>
                                                                                                            <span class=""><?php echo $modulename2['module_name']?></span>  
                                                                                                        </a>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            <?php } ?>
                                                                                    <?php endif?>
                                                                                <?php endforeach?>
                                                                                <!-- end of 2nd sub menu-->
                                                                            </li>
                                                                        </ul>
                                                                    <?php } ?>
                                                                <?php endif?>
                                                            <?php endforeach?>
                                                        </li>
                                                        <!-- end child-->
                                                    <?php }?>
                                                <?php endif?>   
                                            <?php endif?>   
                                        <?php endforeach?>
                                    <!--end dynamic menu -->
                                </ul>
                            </li>
                            
                            <li class="custom_caret <?php if(isset($main_menu_type) && $main_menu_type == 'masters'){ echo 'open active'; } ?>">
                                <a data-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-settings"></i>
                                    <span class="">Masters </span>
                                    <span class=""></span>
                                </a>
                                <ul class="sidebar-submenu <?php if(isset($main_menu_type) && $main_menu_type == 'masters'){ echo 'menu-open'; } ?>">
                                    <!-- start dynamic menu-->
                                    <?php foreach($select  as $key =>  $modulename): //all menu ?>
                                        <?php if($modulename['main_module'] == 'master') :
                                            if($modulename['parent_id'] == 0) :?>
                                                <?php $key = array_search($modulename["module_id"],$view_permissions);//get key of matched result
                                                if($key !== false )//check not falsy
                                                { ?>
                                                    <li class="<?php echo $modulename['classname'] ;?>  <?php if(isset($sub_menu_type) && $sub_menu_type == $modulename['cums_under_menu'] ){ echo 'open active'; } ?>">
                                                        <a  href="<?php if(isset($modulename['url']) && !empty($modulename['url'])){echo base_url().$modulename['url'];}?><?php if($modulename['url_id']==1){echo $sess_institute_id;}?>">
                                                            <i class="<?php echo $modulename['icon']?>"></i>
                                                            <span class=""><?php echo $modulename['module_name'];?></span>
                                                        </a>
                                                        <!-- -start child -->
                                                        <?php foreach($select  as $key =>  $modulename1): //all menu ?>
                                                            <?php if($modulename['module_id'] == $modulename1['parent_id']):?>
                                                                <?php $key = array_search($modulename1["module_id"],$view_permissions);//get key of matched result
                                                                if($key !== false )//check not falsy
                                                                { ?>
                                                                    <ul class= "sidebar-submenu <?php if(isset($sub_menu_type) && $sub_menu_type == $modulename['cums_under_menu']){ echo 'menu-open'; } ?>">
                                                                        <li class=" <?php echo $modulename1['classname'] ;?>  <?php if(isset($child_menu_type) && $child_menu_type == $modulename1['cums_under_menu']){ echo 'active'; } ?>">
                                                                            <a class="" href="<?php if(isset($modulename1['url']) && !empty($modulename1['url'])){echo base_url().$modulename1['url'];}?><?php if($modulename1['url_id']==1){echo $sess_institute_id;}?>">
                                                                                <i class="<?php echo $modulename1['icon']?>"></i>
                                                                                <span class=""><?php echo $modulename1['module_name']?></span>
                                                                            </a>
                                                                            <!-- start of second sub menu-->
                                                                            <?php foreach($select  as $key =>  $modulename2): //all menu ?>
                                                                                <?php if($modulename1['module_id'] == $modulename2['parent_id']):?>
                                                                                    <?php $key = array_search($modulename2["module_id"],$view_permissions);//get key of matched result
                                                                                    if($key !== false )//check not falsy
                                                                                    { ?>
                                                                                        <ul class=sidebar-submenu <?php if(isset($child_menu_type) && $child_menu_type == $modulename1['cums_under_menu']){ echo 'menu-open'; } ?>> 
                                                                                            <li class="<?php echo $modulename2['classname'] ;?>  <?php if(isset($sub_child_menu_type) && $sub_child_menu_type ==$modulename2['cums_under_menu']){ echo 'active'; } ?>">
                                                                                                <a class="" href="<?php echo base_url().$modulename2['url']?><?php if($modulename2['url_id']==1){echo $sess_institute_id;}?>">
                                                                                                        <i class="<?php echo $modulename2['icon']?>"></i>
                                                                                                        <span class=""><?php echo $modulename2['module_name']?></span>  
                                                                                                </a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    <?php } ?>
                                                                                <?php endif?>
                                                                            <?php endforeach?>
                                                                            <!-- end of 2nd sub menu-->
                                                                        </li>
                                                                    </ul>
                                                                <?php }?>
                                                            <?php endif?>
                                                        <?php endforeach?>
                                                    </li>
                                                    <!-- end child-->
                                                <?php }?>
                                            <?php endif ?>   
                                        <?php endif?>   
                                    <?php endforeach?>
                                    <!-- end of dynamic menu-->                                      
                                </ul>
                            </li>

                            <li class="custom_caret <?php if(isset($main_menu_type) && $main_menu_type == 'user_management'){ echo 'open active'; } ?>">
                                <a data-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-users"></i>
                                    <span class="">User Management </span>
                                    <span class=""></span>
                                </a>
                                <ul class="sidebar-submenu <?php if(isset($main_menu_type) && $main_menu_type == 'user_management'){ echo 'menu-open'; } ?>">
                                    <li class="<?php if(isset($sub_menu_type) && $sub_menu_type == 'groups'){ echo 'open active'; } ?>">
                                        <a href="<?php echo base_url('admin/groups/'); ?>">
                                            <i class="icon-arrow-right"></i>
                                            <span class="">Groups</span>
                                        </a>
                                    </li>
                                    <li class="<?php if(isset($sub_menu_type) && $sub_menu_type == 'users'){ echo 'open active'; } ?>">
                                        <a href="<?php echo base_url('admin/user/'); ?>">
                                            <i class="icon-arrow-right"></i>
                                            <span class="">Users</span>
                                        </a>
                                    </li>
                                    <li class="<?php if(isset($sub_menu_type) && $sub_menu_type == 'modules'){ echo 'open active'; } ?>">
                                        <a href="<?php echo base_url('usermanagement_module/view_module/'); ?>">
                                            <i class="icon-arrow-right"></i>
                                            <span class="">Module</span>
                                        </a>
                                    </li>
                                    <li class="<?php if(isset($sub_menu_type) && $sub_menu_type == 'methods'){ echo 'open active'; } ?>">
                                        <a href="<?php echo base_url('permission_method/view_permission_method/'); ?>">
                                            <i class="icon-arrow-right"></i>
                                            <span class="">Permission Method</span>
                                        </a>
                                    </li>

                                    <li class="<?php if(isset($sub_menu_type) && $sub_menu_type == 'sidebar_modules'){ echo 'open active'; } ?>">
                                        <a href="<?php echo base_url('cms/Sidebar_module/index/'); ?>">
                                            <i class="icon-arrow-right"></i>
                                            <span class="">Sidebar Module</span>
                                        </a>
                                    </li>
                                    <li class="<?php if(isset($sub_menu_type) && $sub_menu_type == 'Sidemodlue_permissions'){ echo 'open active'; } ?>">
                                        <a href="<?php echo base_url('cms/sidebarmenu_permissions/index/'); ?>">
                                            <i class="icon-arrow-right"></i>
                                            <span class="">Sidebar Module Permission </span>
                                        </a>
                                    </li>


                                    <li class="<?php if(isset($sub_menu_type) && $sub_menu_type == 'application_permissions'){ echo 'open active'; } ?>">
                                        <a href="<?php echo base_url('permissions/view_permissions/'); ?>">
                                            <i class="icon-arrow-right"></i>
                                            <span class="">Application Permissions</span>
                                        </a>
                                    </li>
                                    <li class="<?php if(isset($sub_menu_type) && $sub_menu_type == 'page_permissions'){ echo 'open active'; } ?>">
                                        <a href="<?php echo base_url('permissions/view_page_permissions/'); ?>">
                                            <i class="icon-arrow-right"></i>
                                            <span class="">Page Permissions</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="<?php if(isset($main_menu_type) && $main_menu_type == 'settings'){ echo 'open active'; } ?>">
                                <a href="<?php echo base_url('admin/settings/'); ?>">
                                    <i class="icon-settings"></i>
                                    <span class="">Settings</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="page-content-wrapper">
                    <div class="page-content">
                    <br /><br />
                          <?php echo $content; ?>                      
                    </div>
                </div>
            </div>

            <div class="page-footer">
                <div class="page-footer-inner"> <?php echo date('Y'); ?> &copy; CMS By
                    <a target="_blank" href="https://www.somaiya.com/">Somaiya Trust</a> 
                </div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
        </div>
        
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/js/sidebar-menu.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap-submenu.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-wysihtml5/ui-modals-compose.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/profile.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/profile.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/table-datatables-buttons.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js" type="text/javascript"></script>
        
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function() {
                    $('#radio1003').attr('checked', 'checked');
                });

                $('[data-toggle="tooltip"]').tooltip();

            });

            function doconfirm()
            {
                job=confirm("Are you sure to delete permanently?");
                if(job!=true)
                {
                    return false;
                }
            }

            $.sidebarMenu($('.sidebar-menu'));
        </script>
    </body>
</html>
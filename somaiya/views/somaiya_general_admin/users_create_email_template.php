<html lang="en">
<head>
  <meta charset="UTF-8">
  <title> </title>
  <style type="text/css">
  a:hover{text-decoration:none!important;}
  .a-link:hover{
    text-decoration:none!important;
  }
</style>
</head>
<body>
  <table style="max-width: 600px;border: 1px solid #b7b7b7;width: 100%;font-family:sans-serif;margin:0 auto;border-bottom:1px solid #ccc;margin-bottom: -10px;" cellpadding=" 0" cellspacing="0">
    <tbody>
      <tr style="width: 93.5%;float: left;padding: 20px 20px;">
        <td style="width: 49%;float: left;text-align: left;position: relative; top: 2px;">
          <!-- <img src="https://svv-public-data.s3.ap-south-1.amazonaws.com/emailer-images/university-logo.png" style="width: 75%;position: relative; top:0;" alt=""/> -->
          <img src="https://somaiya.com/assets/somaiya_com/img/logo.png" style="width: 75%;position: relative; top:0;" alt=""/>
        </td>
        <td style="width: 49%;float: right;text-align: right;">
          <!-- <img src="https://svv-public-data.s3.ap-south-1.amazonaws.com/emailer-images/somaiya_logo.jpg" style="width:30%;right:20px;position: relative;"> -->
        </td>
      </tr>
      <tr style="width: 100%;float: left;border: none;display: block;border-spacing: 0;height: 197px!important; max-height: 196px!important;">
        <td style="width: 100%;float: left;">
          <a href="#" style="cursor:default;">
            <img src="https://svv-public-data.s3.ap-south-1.amazonaws.com/emailer-images/management-banner.png"  >
          </a>
        </td>
      </tr>
	  <tr></tr>
      <tr>
        <td>Name : <?php echo $fullname; ?></td>
      </tr>
      <tr>
        <td>Username : <?php echo $username; ?></td>
      </tr>
      <tr>
        <td>Password : <?php echo $default_pwd; ?></td>
      </tr>
      <tr>
        <td>Login Link : <a href="<?php echo base_url().'admin-sign/'; ?>"><?php echo base_url().'admin-sign/'; ?></a></td>
      </tr>
    </tbody>
  </table>

  <?php
  foreach ($users_application_permissions as $permissions_key => $permissions_value) {
    if(isset($permissions_value[0]['permissions']) && !empty($permissions_value[0]['permissions']))
    {
      $permissions = explode(',', $permissions_value[0]['permissions']);
      echo  "<br><br>we are assign you <b>".$permissions_value[0]['group_name']."</b> group under <b>".$permissions_value[0]['INST_NAME']."</b> Institute and This group has followings <b>Application</b> permissions In <b>CMS</b><br><br>";
      ?>
      <table class="table table-striped table-bordered table-hover table-checkable order-column" id="permissions" border="1">
        <thead>
            <th>Module</th>
            <th style="display:none;">Select All</th>
            <th>Sub Module</th>
            <th style="display:none;">Select All</th>
            <th>Add</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>View</th>
            <th>Export</th>
        </thead>
        <tbody>
        <?php
          if(isset($methods) && !empty($methods))
          {
            $mi = 0;
            $si = 0;
            $module_class       = '';
            $sub_module_class   = '';
            $pm_order_arr       = [];

            foreach ($methods as $key => $value) {
                $module_class = 'menuclass-'.$mi;
                if(isset($value['sub_module']) && !empty($value['sub_module']))
                {
                    foreach ($value['sub_module'] as $smkey => $sub_module) {
                        $sub_module_class = 'submenuclass-'.$mi.$si;
                        $rowspan = ($smkey < 1) ? count($value['sub_module']) : '';
                    ?>
                      <tr class="gradeX">
                        <?php if($rowspan){ ?>
                          <td rowspan="<?php echo $rowspan; ?>">
                            <?php
                                if($smkey < 1)
                                {
                                    echo $value['module_name'];
                                }
                            ?>
                          </td>
                          <td rowspan="<?php echo $rowspan; ?>" style="display:none;">
                              <input type="checkbox" name="module_select_all[]" data-selid="module-<?php echo $value['module_id']; ?>" data-id="<?php echo $value['module_id']; ?>" class="all_permission_select_all select-all <?php echo $module_class; ?>" onchange="selectall('module', '<?php echo $module_class; ?>', '<?php echo $sub_module_class; ?>', this);" <?php if(in_array('module-'.$value['module_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                              <input type="hidden" id="select-all-module-<?php echo $value['module_id']; ?>" name="selectall[]" value="<?php if(in_array('module-'.$value['module_id'], $select_all_data)){ echo 'module-'.$value['module_id']; }else{ echo ''; } ?>">
                          </td>
                        <?php } ?>
                          <td><?php echo $sub_module['module_name']; ?></td>
                          <td style="display:none;">
                              <input type="checkbox" name="" data-selid="submodule-<?php echo $value['module_id'].$sub_module['module_id']; ?>" data-id="<?php echo $value['module_id'].$sub_module['module_id']; ?>" class="all_permission_select_all select-all <?php echo $module_class.' '.$sub_module_class; ?>" onchange="selectall('submodule', '<?php echo $module_class; ?>', '<?php echo $sub_module_class; ?>', this);" <?php if(in_array('submodule-'.$value['module_id'].$sub_module['module_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                              <input type="hidden" id="select-all-submodule-<?php echo $value['module_id'].$sub_module['module_id']; ?>" name="selectall[]" value="<?php if(in_array('submodule-'.$value['module_id'].$sub_module['module_id'], $select_all_data)){ echo 'submodule-'.$value['module_id'].$sub_module['module_id']; }else{ echo ''; } ?>">
                          </td>
                          <?php
                          if(isset($sub_module['methods']) && !empty($sub_module['methods']))
                          {
                            $pm_order_arr   = array_column($sub_module['methods'], 'pm_order');
                            $i              = 0;
                            foreach ($this->config->item('method_for') as $mfkey => $mfvalue) {
                              if(in_array($mfkey, $pm_order_arr)){
                                $okey = array_search($mfkey, array_column($sub_module['methods'], 'pm_order'));
                              ?>
                                <td>
                                  <?php if(isset($sub_module['methods'][$okey]) && !empty($sub_module['methods'][$okey])){ ?>
                                    <input type="checkbox" id="checkbox-<?php echo $sub_module['methods'][$okey]['pm_id']; ?>" name="<?php echo $sub_module['methods'][$okey]['pm_id']; ?>" data-id="sub-<?php echo $sub_module['methods'][$okey]['pm_id']; ?>" class="all_permission method-checkbox <?php echo $module_class.' '.$sub_module_class; ?>" <?php if(in_array($sub_module['methods'][$okey]['pm_id'], $permissions)){ echo 'checked="checked"'; } ?>>
                                    <input type="hidden" id="method-sub-<?php echo $sub_module['methods'][$okey]['pm_id']; ?>" name="method-<?php echo $sub_module['methods'][$okey]['pm_id']; ?>" value="<?php if(in_array($sub_module['methods'][$okey]['pm_id'], $permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                  <?php } ?>
                                </td>
                                <?php
                              }
                              else
                              {
                              ?>
                                <td>--</td>
                                <?php
                              }
                              ++$i;
                            }
                          }
                          else
                          {
                            echo '<td>--</td>
                                  <td>--</td>
                                  <td>--</td>
                                  <td>--</td>
                                  <td>--</td>
                                  ';
                            
                          }
                          ?>
                      </tr>
                      <?php
                      ++$si;
                    }
                }
                else
                {
                ?>
                  <tr class="gradeX">
                      <td><?php echo $value['module_name']; ?></td>
                      <td style="display:none;">
                          <input type="checkbox" name="module_select_all[]" data-selid="module-<?php echo $value['module_id']; ?>" data-id="<?php echo $value['module_id']; ?>" class="all_permission_select_all select-all <?php echo $module_class; ?>" onchange="selectall('module', '<?php echo $module_class; ?>', '', this);" <?php if(in_array('module-'.$value['module_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                          <input type="hidden" id="select-all-module-<?php echo $value['module_id']; ?>" name="selectall[]" value="<?php if(in_array('module-'.$value['module_id'], $select_all_data)){ echo 'module-'.$value['module_id']; }else{ echo ''; } ?>">
                      </td>
                      <td></td>
                      <td style="display:none;"></td>
                      <?php
                          if(isset($value['methods']) && !empty($value['methods']))
                          {
                              $pm_order_arr   = array_column($value['methods'], 'pm_order');
                              $j              = 0;
                              foreach ($this->config->item('method_for') as $mfkey => $mfvalue) {
                                  if(in_array($mfkey, $pm_order_arr)){
                                      $okey = array_search($mfkey, array_column($value['methods'], 'pm_order'));
                      ?>
                                      <td>
                                          <?php if(isset($value['methods'][$okey]) && !empty($value['methods'][$okey])){ ?>
                                              <input type="checkbox" id="checkbox-<?php echo $value['methods'][$okey]['pm_id']; ?>" name="<?php echo $value['methods'][$okey]['pm_id']; ?>" data-id="meth-<?php echo $value['methods'][$okey]['pm_id']; ?>" class="all_permission method-checkbox <?php echo $module_class.' '.$sub_module_class; ?>" <?php if(in_array($value['methods'][$okey]['pm_id'], $permissions)){ echo 'checked="checked"'; } ?>>
                                              <input type="hidden" id="method-meth-<?php echo $value['methods'][$okey]['pm_id']; ?>" name="method-<?php echo $value['methods'][$okey]['pm_id']; ?>" value="<?php if(in_array($value['methods'][$okey]['pm_id'], $permissions)){ echo '1'; }else{ echo '0'; } ?>">
                                          <?php } ?>
                                      </td>
                      <?php
                                  }
                                  else
                                  {
                      ?>
                                      <td>--</td>
                      <?php
                                  }
                                  ++$j;
                              }
                          }
                          else
                          {
                              echo '
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                      <td>--</td>
                                  ';
                            
                          }
                      ?>
                  </tr>
                <?php
                }
                ++$mi;
            }
          }
        ?>
        </tbody>
      </table>
      <?php
    }
    else
    {
      echo "No Application Permissions Found.";
    }
  }

  //echo "following code used for page permissions";
  //echo "<br>================================<br>";

  // echo "<pre>";
  // print_r($user_page_permissions);
  // exit();
      
  if(!empty($user_page_permissions))
  {
    foreach ($user_page_permissions as $userpagekey => $userpagevalue) {

      if(isset($userpagevalue[0]['group_name']) && !empty($userpagevalue[0]['group_name']))
      {
        
      echo  "<br><br>we are assign you <b>".$userpagevalue[0]['group_name']."</b> group under <b>".$userpagevalue[0]['INST_NAME']."</b> Institute and This group has followings <b>Page</b> permissions In <b>CMS</b><br><br>";

      $add_permissions      = isset($userpagevalue[0]['add_permissions']) ? $userpagevalue[0]['add_permissions'] : 0;

      if(isset($userpagevalue[0]['edit_permissions']) && !empty($userpagevalue[0]['edit_permissions']))
      {
          $edit_permissions = explode(',', $userpagevalue[0]['edit_permissions']);
      }

      if(isset($userpagevalue[0]['view_permissions']) && !empty($userpagevalue[0]['view_permissions']))
      {
          $view_permissions = explode(',', $userpagevalue[0]['view_permissions']);
      }

      if(isset($userpagevalue[0]['delete_permissions']) && !empty($userpagevalue[0]['delete_permissions']))
      {
          $delete_permissions = explode(',', $userpagevalue[0]['delete_permissions']);
      }
      $select_all_data      = array();

      
      $menu_data = $userpagevalue[0]['menu_data'];
      $otherpage = $userpagevalue[0]['otherpage'];
      // echo "<pre>";
      // print_r($view_permissions);
      // exit();
      

      
      ?>
      <!-- create table for page permissions -->
      <table class="table table-striped table-bordered table-hover table-checkable order-column" border="1">
      <thead>
          <th>Menu</th>
          <th style="display:none;">Select All</th>
          <th style="display:none;">Sub Menu</th>
          <th style="display:none;">Select All</th>
          <th style="display:none;">Child Menu</th>
          <th style="display:none;">Select All</th>
          <th>Edit</th>
          <th>Delete</th>
          <th>View</th>
      </thead>
      <tbody>
      <?php
      if(isset($menu_data['main_menu_data']) && !empty($menu_data['main_menu_data']))
      {
          $menu_class         = '';
          $sub_menu_class     = '';
          $child_menu_class   = '';

          $mi = 0;
          $si = 0;
          $ci = 0;
          foreach ($menu_data['main_menu_data'] as $mkey => $menu) {
            $menu_class = 'menuclass-'.$mi;
            $rowspan = ($menu['rowspan'] > 0) ? $menu['rowspan'] : '';
            if(isset($menu['sub_menu_data']) && !empty($menu['sub_menu_data'])) // When there is sub menu
            {
              $sub_menu_data = $menu['sub_menu_data'];
              foreach ($sub_menu_data as $smkey => $submenu) {
                $sub_menu_class = 'submenuclass-'.$mi.$si;
                if(isset($submenu['child_menu_data']) && !empty($submenu['child_menu_data'])) // When there is child menu
                {
                  $child_menu_data = $submenu['child_menu_data'];
                  $smrowspan = (count($child_menu_data) > 0) ? count($child_menu_data) : '';
                  foreach ($child_menu_data as $cmkey => $childmenu) {
                      $child_menu_class = 'childmenuclass-'.$mi.$si.$ci;
                      // echo "<pre>";print_r($childmenu);//exit;
               ?>
                  <tr class="gradeX">
                  <?php if($smkey < 1 && $cmkey < 1){ ?>
                      <td rowspan="<?php echo $rowspan; ?>">
                          <?php echo $menu['menu_name']; ?>
                      </td>
                      <td rowspan="<?php echo $rowspan; ?>" style="display:none;">
                          <input name="menu_select_all[]" data-selid="menu-<?php echo $menu['page_id']; ?>" data-id="<?php echo $menu['page_id']; ?>" data-type="menu_select_all" value="<?php echo $menu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class; ?>" onchange="selectall('menu', '<?php echo $menu_class; ?>', '<?php echo $sub_menu_class; ?>', '<?php echo $child_menu_class; ?>', this);" <?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                          <input type="hidden" id="select-all-menu-<?php echo $menu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'menu-'.$menu['page_id']; }else{ echo ''; } ?>">
                      </td>
                  <?php }if($cmkey < 1){ ?>
                      <td rowspan="<?php echo $smrowspan; ?>"><?php echo $submenu['menu_name']; ?></td>
                      <td rowspan="<?php echo $smrowspan; ?>" style="display:none;">
                          <input name="submenu_select_all[]" data-selid="submenu-<?php echo $menu['page_id'].$submenu['page_id']; ?>" data-id="<?php echo $submenu['page_id']; ?>" data-type="submenu_select_all" value="<?php echo $submenu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class.' '.$sub_menu_class; ?>" onchange="selectall('submenu', '<?php echo $menu_class; ?>', '<?php echo $sub_menu_class; ?>', '<?php echo $child_menu_class; ?>', this);" <?php if(in_array('submenu-'.$menu['page_id'].$submenu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                          <input type="hidden" id="select-all-submenu-<?php echo $menu['page_id'].$submenu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('submenu-'.$menu['page_id'].$submenu['page_id'], $select_all_data)){ echo 'submenu-'.$menu['page_id'].$submenu['page_id']; }else{ echo ''; } ?>">
                      </td>
                  <?php } ?>
                  <td style="display:none;"><?php echo $childmenu['menu_name']; ?></td>
                  <td style="display:none;">
                      <?php if($childmenu['page_id'] > 0){ ?>
                          <input name="child_select_all[]" data-selid="childmenu-<?php echo $menu['page_id'].$submenu['page_id'].$childmenu['page_id']; ?>" data-id="<?php echo $childmenu['page_id']; ?>" data-type="child_select_all" value="<?php echo $childmenu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class.' '.$sub_menu_class.' '.$child_menu_class; ?>" onchange="selectall('childmenu', '<?php echo $menu_class; ?>', '<?php echo $sub_menu_class; ?>', '<?php echo $child_menu_class; ?>', this);" <?php if(in_array('childmenu-'.$menu['page_id'].$submenu['page_id'].$childmenu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                          <input type="hidden" id="select-all-childmenu-<?php echo $menu['page_id'].$submenu['page_id'].$childmenu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('childmenu-'.$menu['page_id'].$submenu['page_id'].$childmenu['page_id'], $select_all_data)){ echo 'childmenu-'.$menu['page_id'].$submenu['page_id'].$childmenu['page_id']; }else{ echo ''; } ?>">
                      <?php } ?>
                  </td>
                  <?php
                      if($childmenu['page_id'] > 0)
                      {
                      ?>
                        <input type="hidden" name="page_id[]" value="<?php echo $childmenu['page_id']; ?>">
                        <td>
                            <input type="checkbox" id="checkbox-edit-<?php echo $childmenu['page_id']; ?>" name="edit-<?php echo $childmenu['page_id']; ?>" data-id="edit-child-<?php echo $childmenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class.' '.$child_menu_class; ?>" <?php if(in_array($childmenu['page_id'], $edit_permissions)){ echo 'checked="checked"'; } ?>>
                            <input type="hidden" id="method-edit-child-<?php echo $childmenu['page_id']; ?>" name="editval-<?php echo $childmenu['page_id']; ?>" value="<?php if(in_array($childmenu['page_id'], $edit_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                        </td>
                        <td>
                            <input type="checkbox" id="checkbox-delete-<?php echo $childmenu['page_id']; ?>" name="delete-<?php echo $childmenu['page_id']; ?>" data-id="delete-child-<?php echo $childmenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class.' '.$child_menu_class; ?>" <?php if(in_array($childmenu['page_id'], $delete_permissions)){ echo 'checked="checked"'; } ?>>
                            <input type="hidden" id="method-delete-child-<?php echo $childmenu['page_id']; ?>" name="deleteval-<?php echo $childmenu['page_id']; ?>" value="<?php if(in_array($childmenu['page_id'], $delete_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                        </td>
                        <td>
                            <input type="checkbox" id="checkbox-view-<?php echo $childmenu['page_id']; ?>" name="view-<?php echo $childmenu['page_id']; ?>" data-id="view-child-<?php echo $childmenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class.' '.$child_menu_class; ?>" <?php if(in_array($childmenu['page_id'], $view_permissions)){ echo 'checked="checked"'; } ?>>
                            <input type="hidden" id="method-view-child-<?php echo $childmenu['page_id']; ?>" name="viewval-<?php echo $childmenu['page_id']; ?>" value="<?php if(in_array($childmenu['page_id'], $view_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                        </td>
                    <?php
                    }
                    else
                    {
                        echo '
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                        ';
                    }
            ++$ci;
        }
      }
      else
      {
      ?>
        <tr class="gradeX">
        <?php if($smkey < 1){ ?>
          <td rowspan="<?php echo $rowspan; ?>">
              <?php echo $menu['menu_name']; ?>
          </td>
          <td rowspan="<?php echo $rowspan; ?>" style="display:none;">
              <input name="menu_select_all[]" data-selid="menu-<?php echo $menu['page_id']; ?>" data-id="<?php echo $menu['page_id']; ?>" data-type="menu_select_all" value="<?php echo $menu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class; ?>" onchange="selectall('menu', '<?php echo $menu_class; ?>', '<?php echo $sub_menu_class; ?>', '', this);" <?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
              <input type="hidden" id="select-all-menu-<?php echo $menu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'menu-'.$menu['page_id']; }else{ echo ''; } ?>">
          </td>
        <?php } ?>
          <td style="display:none;"><?php echo $submenu['menu_name']; ?></td>
          <td style="display:none;">
              <?php if($submenu['page_id'] > 0){ ?>
                  <input name="submenu_select_all[]" data-selid="submenu-<?php echo $menu['page_id'].$submenu['page_id']; ?>" data-id="<?php echo $submenu['page_id']; ?>" data-type="submenu_select_all" value="<?php echo $submenu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class.' '.$sub_menu_class; ?>" onchange="selectall('submenu', '<?php echo $menu_class; ?>', '<?php echo $sub_menu_class; ?>', '', this);" <?php if(in_array('submenu-'.$menu['page_id'].$submenu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                  <input type="hidden" id="select-all-submenu-<?php echo $menu['page_id'].$submenu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('submenu-'.$menu['page_id'].$submenu['page_id'], $select_all_data)){ echo 'submenu-'.$menu['page_id'].$submenu['page_id']; }else{ echo ''; } ?>">
              <?php } ?>
          </td>
          <td style="display:none;"></td>
          <td style="display:none;"></td>
          <?php
              if($submenu['page_id'] > 0)
              {
          ?>
                  <input type="hidden" name="page_id[]" value="<?php echo $submenu['page_id']; ?>">
                  <td>
                      <input type="checkbox" id="checkbox-edit-<?php echo $submenu['page_id']; ?>" name="edit-<?php echo $submenu['page_id']; ?>" data-id="edit-submenu-<?php echo $submenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class; ?>" <?php if(in_array($submenu['page_id'], $edit_permissions)){ echo 'checked="checked"'; } ?>>
                      <input type="hidden" id="method-edit-submenu-<?php echo $submenu['page_id']; ?>" name="editval-<?php echo $submenu['page_id']; ?>" value="<?php if(in_array($submenu['page_id'], $edit_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                  </td>
                  <td>
                      <input type="checkbox" id="checkbox-delete-<?php echo $submenu['page_id']; ?>" name="delete-<?php echo $submenu['page_id']; ?>" data-id="delete-submenu-<?php echo $submenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class; ?>" <?php if(in_array($submenu['page_id'], $delete_permissions)){ echo 'checked="checked"'; } ?>>
                      <input type="hidden" id="method-delete-submenu-<?php echo $submenu['page_id']; ?>" name="deleteval-<?php echo $submenu['page_id']; ?>" value="<?php if(in_array($submenu['page_id'], $delete_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                  </td>
                  <td>
                      <input type="checkbox" id="checkbox-view-<?php echo $submenu['page_id']; ?>" name="view-<?php echo $submenu['page_id']; ?>" data-id="view-submenu-<?php echo $submenu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class.' '.$sub_menu_class; ?>" <?php if(in_array($submenu['page_id'], $view_permissions)){ echo 'checked="checked"'; } ?>>
                      <input type="hidden" id="method-view-submenu-<?php echo $submenu['page_id']; ?>" name="viewval-<?php echo $submenu['page_id']; ?>" value="<?php if(in_array($submenu['page_id'], $view_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                  </td>
          <?php
              }
              else
              {
                  echo '
                      <td>--</td>
                      <td>--</td>
                      <td>--</td>
                  ';
              }
          }
        ++$si;
        }
      ?>
        </tr>
      <?php
      }
      else // When there is no sub menu
      {
        ?>
        <tr class="gradeX">
          <td><?php echo $menu['menu_name']; ?></td>
          <td style="display:none;">
              <?php if($menu['page_id'] > 0){ ?>
                  <input name="menu_select_all[]" data-selid="menu-<?php echo $menu['page_id']; ?>" data-id="<?php echo $menu['page_id']; ?>" data-type="menu_select_all" value="<?php echo $menu['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $menu_class; ?>" onchange="selectall('menu', '<?php echo $menu_class; ?>', '', '', this);" <?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                  <input type="hidden" id="select-all-menu-<?php echo $menu['page_id']; ?>" name="selectall[]" value="<?php if(in_array('menu-'.$menu['page_id'], $select_all_data)){ echo 'menu-'.$menu['page_id']; }else{ echo ''; } ?>">
              <?php } ?>
          </td>
          <td style="display:none;"></td>
          <td style="display:none;"></td>
          <td style="display:none;"></td>
          <td style="display:none;"></td>
          <?php
              if($menu['page_id'] > 0)
              {
                ?>
                  <input type="hidden" name="page_id[]" value="<?php echo $menu['page_id']; ?>">
                  <td>
                      <input type="checkbox" id="checkbox-edit-<?php echo $menu['page_id']; ?>" name="edit-<?php echo $menu['page_id']; ?>" data-id="edit-menu-<?php echo $menu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class; ?>" <?php if(in_array($menu['page_id'], $edit_permissions)){ echo 'checked="checked"'; } ?>>
                      <input type="hidden" id="method-edit-menu-<?php echo $menu['page_id']; ?>" name="editval-<?php echo $menu['page_id']; ?>" value="<?php if(in_array($menu['page_id'], $edit_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                  </td>
                  <td>
                      <input type="checkbox" id="checkbox-delete-<?php echo $menu['page_id']; ?>" name="delete-<?php echo $menu['page_id']; ?>" data-id="delete-menu-<?php echo $menu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class; ?>" <?php if(in_array($menu['page_id'], $delete_permissions)){ echo 'checked="checked"'; } ?>>
                      <input type="hidden" id="method-delete-menu-<?php echo $menu['page_id']; ?>" name="deleteval-<?php echo $menu['page_id']; ?>" value="<?php if(in_array($menu['page_id'], $delete_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                  </td>
                  <td>
                      <input type="checkbox" id="checkbox-view-<?php echo $menu['page_id']; ?>" name="view-<?php echo $menu['page_id']; ?>" data-id="view-menu-<?php echo $menu['page_id']; ?>" class="all_permission method-checkbox <?php echo $menu_class; ?>" <?php if(in_array($menu['page_id'], $view_permissions)){ echo 'checked="checked"'; } ?>>
                      <input type="hidden" id="method-view-menu-<?php echo $menu['page_id']; ?>" name="viewval-<?php echo $menu['page_id']; ?>" value="<?php if(in_array($menu['page_id'], $view_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                  </td>
              <?php
                  }
                  else
                  {
                      echo '
                              <td>--</td>
                              <td>--</td>
                              <td>--</td>
                          ';
                  }
              ?>
        </tr>
        <?php
      }
      ++$mi;
    }
  }
  else
  {
    ?>
           <!--  <tr class="gradeX">
                <td colspan="6" class="text-center">No Data Found</td>
            </tr> -->
    <?php
  }
  if(isset($otherpage) && !empty($otherpage))
  {
    foreach ($otherpage as $okey => $ovalue) {
      $page_class = 'page_'.$okey.$ovalue['page_id'];
    ?>
      <tr class="gradeX">
          <td><?php echo $ovalue['page_name']; ?></td>
          <td style="display:none;">
              <?php if($ovalue['page_id'] > 0){ ?>
                  <input name="menu_select_all[]" data-selid="method-<?php echo $ovalue['page_id']; ?>" data-id="<?php echo $ovalue['page_id']; ?>" data-type="menu_select_all" value="<?php echo $ovalue['page_id']; ?>" type="checkbox" class="all_permission_select_all select-all <?php echo $page_class; ?>" onchange="selectall('menu', '<?php echo $page_class; ?>', '', '', this);" <?php if(in_array('method-'.$ovalue['page_id'], $select_all_data)){ echo 'checked="checked"'; } ?>>
                  <input type="hidden" id="select-all-method-<?php echo $ovalue['page_id']; ?>" name="selectall[]" value="<?php if(in_array('method-'.$ovalue['page_id'], $select_all_data)){ echo 'method-'.$ovalue['page_id']; }else{ echo ''; } ?>">
              <?php } ?>
          </td>
          <td style="display:none;"></td>
          <td style="display:none;"></td>
          <td style="display:none;"></td>
          <td style="display:none;"></td>
          <?php
              if($ovalue['page_id'] > 0)
              {
          ?>
                  <input type="hidden" name="page_id[]" value="<?php echo $ovalue['page_id']; ?>">
                  <td>
                      <input type="checkbox" id="checkbox-edit-<?php echo $ovalue['page_id']; ?>" name="edit-<?php echo $ovalue['page_id']; ?>" data-id="edit-page-<?php echo $ovalue['page_id']; ?>" class="all_permission method-checkbox <?php echo $page_class; ?>" <?php if(in_array($ovalue['page_id'], $edit_permissions)){ echo 'checked="checked"'; } ?>>
                      <input type="hidden" id="method-edit-page-<?php echo $ovalue['page_id']; ?>" name="editval-<?php echo $ovalue['page_id']; ?>" value="<?php if(in_array($ovalue['page_id'], $edit_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                  </td>
                  <td>
                      <input type="checkbox" id="checkbox-delete-<?php echo $ovalue['page_id']; ?>" name="delete-<?php echo $ovalue['page_id']; ?>" data-id="delete-page-<?php echo $ovalue['page_id']; ?>" class="all_permission method-checkbox <?php echo $page_class; ?>" <?php if(in_array($ovalue['page_id'], $delete_permissions)){ echo 'checked="checked"'; } ?>>
                      <input type="hidden" id="method-delete-page-<?php echo $ovalue['page_id']; ?>" name="deleteval-<?php echo $ovalue['page_id']; ?>" value="<?php if(in_array($ovalue['page_id'], $delete_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                  </td>
                  <td>
                      <input type="checkbox" id="checkbox-view-<?php echo $ovalue['page_id']; ?>" name="view-<?php echo $ovalue['page_id']; ?>" data-id="view-page-<?php echo $ovalue['page_id']; ?>" class="all_permission method-checkbox <?php echo $page_class; ?>" <?php if(in_array($ovalue['page_id'], $view_permissions)){ echo 'checked="checked"'; } ?>>
                      <input type="hidden" id="method-view-page-<?php echo $ovalue['page_id']; ?>" name="viewval-<?php echo $ovalue['page_id']; ?>" value="<?php if(in_array($ovalue['page_id'], $view_permissions)){ echo '1'; }else{ echo '0'; } ?>">
                  </td>
          <?php
              }
              else
              {
                  echo '
                          <td>--</td>
                          <td>--</td>
                          <td>--</td>
                      ';
              }
          ?>
      </tr>
    <?php
    }
  }
  ?>
    </tbody>
  </table>
  <?php
}// isset($userpagevalue['group_name']) close

}
  
}
else
{
echo "No Page Permissions Found";
}

?>
  
</body>
</html>


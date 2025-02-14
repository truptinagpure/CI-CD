<?php $faculty_institute = $this->uri->segment(4); ?>
 <div class="app-ticket app-ticket-list">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-globe font-brown "></i>
                        <span class="caption-subject font-brown bold uppercase">Configuration - <?=$institutes_details['INST_NAME']  ?>  (<?= $institutes_details['INST_SHORTNAME']?>)</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="custpurple"><a class="sizebtn btn brown" href="<?php echo base_url('cms/institute'); ?>">Back</a> </span>
                            </div>                                                         
                        </div>
                    </div>

                    <?php
                      $selected_designation_id    = array();

                      if(!empty($data_list[0]['excluded_faculty_designation_id']))
                      {
                        $selected_designation_id = explode(',' , $data_list[0]['excluded_faculty_designation_id']);
                      }


                      $selected_faculty_name    = array();

                      if(!empty($data_list[0]['excluded_faculty_id']))
                      {
                        $selected_faculty_name = explode(',' , $data_list[0]['excluded_faculty_id']);
                      }

                    ?>

                  <div class="row">
                    <div class="col-md-4">
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs tabs-left sideways">
                        <li class="active"><a href="#faculty-directory" data-toggle="tab">Faculty Directory</a></li>
                        <!-- <li><a href="#profile-v" data-toggle="tab">Profile</a></li>
                        <li><a href="#messages-v" data-toggle="tab">Messages</a></li>
                        <li><a href="#settings-v" data-toggle="tab">Settings</a></li> -->
                      </ul>
                    </div>

                    <div class="col-md-8">
                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div class="tab-pane active" id="faculty-directory">
                          <form id="manage_form" class="cmxform form-horizontal tasi-form" enctype='multipart/form-data' method="post" action="<?php echo site_url('cms/institute/excluded_faculty');?>">
                              <div class="portlet-body form">
                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="designation_id" class="control-label col-md-12 mb20">Excluded Designations </label>
                                              <div class="col-md-12">
                                                  <select id="designation_id" class="form-control select2" name="designation_id[]" data-placeholder=" Exclude Designations" multiple ><option value="">Exclude Designations</option>
                                                    <?php if(isset($designation) && count($designation)!=0){ ?>
                                                      <?php foreach ($designation as $key => $value) { ?>
                                                          <option value="<?php echo $value['Designation_Id']; ?>" <?php if( isset($selected_designation_id) && in_array($value['Designation_Id'], $selected_designation_id)) echo"selected"; ?>> <?php echo $value['Designation_Name']; ?></option>
                                                    <?php } } ?>
                                                  </select>

                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="row">
                                      <div class="col-md-12">
                                          <div class="form-group">
                                              <label for="faculty_name" class="control-label col-md-12 mb20"> Excluded Faculty by Name </label>
                                              <div class="col-md-12">
                                                  <select id="faculty_name" class="form-control select2" name="faculty_name[]" data-placeholder="Excluded Faculty by Name" multiple ><option value="">Excluded Faculty by Name</option>
                                                    <?php if(isset($faculty_name) && count($faculty_name)!=0){ ?>
                                                      <?php foreach ($faculty_name as $key => $value) { ?>
                                                          <option value="<?php echo $value['MEMBER_ID']; ?>" <?php if( isset($selected_faculty_name) && in_array($value['MEMBER_ID'], $selected_faculty_name)) echo"selected"; ?>> <?=$value['SALUTATION']?> <?php echo ucwords(strtolower($value['FIRST_NAME'])); ?> <?php echo ucwords(strtolower($value['MIDDLE_NAME'])); ?> <?php echo ucwords(strtolower($value['LAST_NAME'])); ?></option>
                                                    <?php } } ?>
                                                  </select>

                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <input type="hidden" name="institute_id" value="<?=$faculty_institute?>" />
                                  <input type="hidden" name="id" value="<?php if(!empty($data_list)){echo $data_list[0]['id']; }?>" />
                                  <div class="form-body">
                                      <div class="form-group">
                                          <div class="col-md-10">
                                              <input class="btn green" value="Submit" type="submit">
                                              <a href="<?php echo base_url('cms/institute') ?>" class="btn btn-default" type="button">Cancel</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </form>
                        </div>
                        <!-- <div class="tab-pane" id="profile-v">Profile Tab.</div>
                        <div class="tab-pane" id="messages-v">Messages Tab.</div>
                        <div class="tab-pane" id="settings-v">Settings Tab.</div> -->
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
.tabs-left {
  border-bottom: none;
  border-right: 1px solid #ddd;
}

.tabs-left>li {
  float: none;
 margin:0px;
  
}
.tabs-left.nav-tabs>li>a{font-family: "Open Sans",sans-serif;
    font-weight: bold;}

.tabs-left>li.active>a,
.tabs-left>li.active>a:hover,
.tabs-left>li.active>a:focus {
  border-bottom-color: #ddd;
  border-right-color: transparent;
  background:#eeefef;
  border:none;
  border-radius:0px;
  margin:0px;
}
.nav-tabs>li>a:hover {
    /* margin-right: 2px; */
    line-height: 1.42857143;
    border: 1px solid transparent;
    /* border-radius: 4px 4px 0 0; */
}
.tabs-left>li.active>a::after{content: "";
    position: absolute;
    top: 10px;
    right: -10px;
    border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
  
  border-left: 10px solid #eeefef;
    display: block;
    width: 0;}

.mb20{padding-bottom: 10px;}
.select2-container--bootstrap .select2-selection--multiple .select2-selection__choice
{
  font-family: "Open Sans",sans-serif;
}
</style>
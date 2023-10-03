<?php include('header.php') ?>

<?php include('sidebar.php') ?>

<script src="<?=base_url('admintheme')?>/ckeditor/ckeditor.js"></script>

<script src="<?=base_url('admintheme')?>/ckeditor/samples/js/sample.js"></script>

<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {

        $('#blah')
          .attr('src', e.target.result);

      };
      reader.readAsDataURL(input.files[0]);
    } else {

      $('#blah')
        .attr('src', '');


    }
  }

  function readURL1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {

        $('#blah2')
          .attr('src', e.target.result);

      };
      reader.readAsDataURL(input.files[0]);
    } else {

      $('#blah2')
        .attr('src', '');


    }
  }
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
  integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
  integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style type="text/css">
  .draggable .unlimited_draggable {

    cursor: move;

  }

  /* Style the tab */
  .tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
  }

  /* Style the buttons inside the tab */
  .tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
  }

  /* Change background color of buttons on hover */
  .tab button:hover {
    background-color: #ddd;
  }

  /* Create an active/current tablink class */
  .tab button.active {
    background-color: #ccc;
  }

  /* Style the tab content */
  .tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
  }
</style>

<!-- content -->

<div id="content" class="app-content" role="main">

  <div class="app-content-body ">

    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="

    app.settings.asideFolded = false; 

    app.settings.asideDock = false;

  ">

    </div>

    <!-- main -->

    <div class="col">





      <div class="bg-light lter b-b wrapper-md">

        <h1 class="m-n font-thin h3"><?php echo  isset($lession) ? 'Update' : 'Add' ?></h1>

      </div>

      <div class="wrapper-md" ng-controller="FlotChartDemoCtrl">

        <div class="row">

          <div class="col-sm-12">

            <div class="panel panel-default">

              <div class="panel-heading font-bold">Form</div>

              <div class="panel-body">

                <?php

        if ($this->session->flashdata('error')) {
            echo '<div class="alert alert-danger">';

            echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

            echo $this->session->flashdata('error');

            echo '</div>';
        }

        if ($this->session->flashdata('warning')) {
            echo '<div class="alert alert-warning">';

            echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

            echo $this->session->flashdata('warning');

            echo '</div>';
        }

        if ($this->session->flashdata('success')) {
            echo '<div class="alert alert-success">';

            echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

            echo $this->session->flashdata('success');

            echo '</div>';
        }

?>

                <?php

    if (validation_errors() != null) {
        echo '<div class="alert alert-danger">';

        echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

        echo validation_errors();

        echo '</div>';
    }

        

    if (isset($custome_error) && $custome_error != null) {
        echo '<div class="alert alert-warning">';

        echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

        echo $custome_error;

        echo '</div>';
    }

?>

                <form name="lessions" id="lessions" action="<?=base_url().'Lession/'?><?php if ($this->uri->segment('2') == "editLession") {
                      echo "editLession/".$this->uri->segment('3');
                  } else {
                      echo "addLession";
                  } ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

                  <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

                  <?php

                                if ($this->uri->segment('2') == "editLession"):

                                    ?>

                  <input type="hidden" name="lession_id" value="<?=$lession['id']?>">

                  <?php endif;?>
                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Course<span class="text-primary"
                        style="color:#a94442;">*</span></label>

                    <div class="col-sm-10">
                      <select class="form-control" name="course_id" required>
                        <?php if (!empty($course)) : $i=1;
                            foreach ($course as $row) : ?>
                        <option value="<?= $row['id'] ?>"
                          <?= isset($lession)&&$lession['course_id'] == $row['id']?'selected':'' ?>><?= $row['name'] ?>
                        </option>
                        <?php $i++; endforeach; endif; ?>
                      </select>
                    </div>

                  </div>
                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Name<span class="text-primary"
                        style="color:#a94442;">*</span></label>

                    <div class="col-sm-10">

                      <input type="text" placeholder="Name" class="form-control" required name="name" value="<?php  if (set_value('name') == null) {
                            echo (!empty($lession))?$lession['name']:'';
                        } else {
                            echo set_value('name');
                        }?>" />

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Image (for pro user)<span class="text-primary"
                        style="color:#a94442;">*</span></label>

                    <div class="col-sm-10">
                      <img src="<?php  if (set_value('image') == null) {
                            echo (!empty($lession))?$chapter_url.$lession['image']:'';
                        } else {
                            echo set_value('image');
                        }?>" id="blah" style="width: 300px;height: 300px;">
                      <input type="file" onchange="readURL(this);" class="form-control" name="image" />

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Image (for free user)<span class="text-primary"
                        style="color:#a94442;">*</span></label>

                    <div class="col-sm-10">
                      <img src="<?php  if (set_value('image_free') == null) {
                            echo (!empty($lession))?$chapter_url.$lession['image_free']:'';
                        } else {
                            echo set_value('image_free');
                        }?>" id="blah2" style="width: 300px;height: 300px;">
                      <input type="file" onchange="readURL1(this);" class="form-control" name="image_free" />

                    </div>

                  </div>
                  <!-- <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Coming Soon</label>

                    <div class="col-sm-10">
                      <input type="checkbox" name="coming_soon" value="1" style="margin-top: 10px;"
                        <?= isset($lession) && $lession['coming_soon'] == 1 ?'checked':'' ?>>
                    </div>
                  </div> -->

                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Speed training</label>

                    <div class="col-sm-10">
                      <input type="checkbox" name="speed_training" id="speed_training" value="0" onchange="myFunction()"
                        style="margin-top: 10px;"
                        <?= isset($lession) && $lession['speed_training'] == 1 ?'checked':'' ?>>
                    </div>

                  </div>
                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Unlimited key training</label>

                    <div class="col-sm-10">
                      <input type="checkbox" name="unlimited_key_training" id="unlimited_key_training" value="0" onchange="myFunction()"
                        style="margin-top: 10px;"
                        <?= isset($lession) && $lession['unlimited_key_training'] == 1 ?'checked':'' ?>>
                    </div>

                  </div>
                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Ear training</label>

                    <div class="col-sm-10">
                      <input type="checkbox" name="ear_training" id="ear_training" value="0" onchange="myFunction()"
                        style="margin-top: 10px;"
                        <?= isset($lession) && $lession['ear_training'] == 1 ?'checked':'' ?>>
                    </div>

                  </div>

                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Major Minor</label>

                    <div class="col-sm-10">
                      <input type="checkbox" name="recognizing" id="recognizing" value="0" onchange="myFunction()"
                        style="margin-top: 10px;"
                        <?= isset($lession) && $lession['recognizing'] == 1 ?'checked':'' ?>>
                    </div>

                  </div>
                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Make it free for all users</label>

                    <div class="col-sm-10">
                        <input type="radio" name="free_for_all" value="1" <?= isset($lession) && $lession['free_for_all'] == 1 ?'checked':'' ?>>    Yes 
                          <input type="radio" name="free_for_all" value="0" <?= isset($lession) && $lession['free_for_all'] == 0 ?'checked':'' ?> style="margin-left: 15px;margin-top: 10px" <?php if(!isset($lession)){?> checked <?php }?>>    No
                    </div>

                  </div>

                  <!-- Start Speed Section -->
                  <div class="form-group is_speed_training" id="is_speed_training" style="display:none">
                    <div class="panel-body">
                      <div class="row">
                        <input type="hidden" name="section_count" id="section_count" value="1" />

                        <!--start Add media -->
                        <div class="form-group">
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-sm-12">
                                <a href="javascript:void(0);" onclick="add_new_section(1,'after','media','no','no');"><span
                                    class="label label-success"
                                    style="font-size: 14px;background-color: #00c053;float: right;margin-right: 12px;">Add
                                    Media</span>&nbsp;&nbsp;&nbsp;</a>
                                <a href="javascript:void(0);" onclick="add_new_section(1,'after','button','no','no');"><span
                                    class="label label-success"
                                    style="font-size: 14px;background-color: #00c053;float: right;margin-right: 12px;">Add
                                    Button</span></a>
                              </div>
                            </div>
                            <div class="section droppable" id="section_html">

                              <?php
                              if ($this->uri->segment('2') == "editLession" && $lession['speed_training'] == 1) {
                                  if (empty($lession_detail)) { ?>
                              <div id="sec_1" class="addpianospace draggable"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="col-sm-6">
                                      <input type="file" name="media[]" accept="image/*,video/*" id="1">
                                      <input type="hidden" name="check_value" id="check_value" value="">
                                    </div>
                                    <div class="col-md-6">
                                      <img src="" class="img-thumbnail"
                                        style="display: none;margin-top: 10px;height: 100px;width: 150px;" />

                                    </div>
                                  </div>
                                </div>
                              </div>
                              <?php }
                                  $first = true;
                                  foreach ($lession_detail as $key => $value) {
                                      if ($value['type'] == 'image' || $value['type'] == 'video') {
                                          ?>
                                          <!-- testing=> <?php //echo $lession['speed_training']; ?> -->
                              <div id="sec_<?= $key + 1 ?>" class="addpianospace draggable"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="col-sm-6">
                                      <input type="file" name="media[]" src="<?php echo $value['media']; ?>"
                                        accept="image/*,video/*" id="<?= $key + 1 ?>">
                                      <input type="hidden" name="check_value" id="check_value"
                                        value="<?php echo $value['media']; ?>">
                                      <input type="hidden" name="old_media[]" value="<?php echo $value['media']; ?>">

                                    </div>
                                    <div class="col-sm-6">

                                      <?php if ($value['type'] == 'image') { ?>

                                      <img src="<?php echo $chapter_url . $value['media']; ?>"
                                        style="margin-top: 10px;height: 100px;width: 150px;" ALT
                                        class="img-thumbnail sec_<?= $key + 1 ?>" />

                                      <?php   } elseif ($value['type'] == 'video') { ?>

                                      <video controls width="150">
                                        <source src="<?php echo $chapter_url . $value['media']; ?>" type="video/mp4">
                                      </video>
                                      <?php } ?>


                                      <a href="javascript:void(0);" id="remove_section_<?= $key + 1 ?>"
                                        onclick="remove_new_section(<?= $key + 1 ?>);" style="float: right;"><span
                                          class="label label-danger" style="font-size: 15px;">Remove Section</span></a>

                                    </div>

                                  </div>
                                </div>
                              </div>
                              <?php
                              $first = false;
                                      } else { ?>
                              <div id="sec_<?= $key + 1 ?>" class="addpianospace draggable"
                                style="border: 2px solid #000000;padding: 50px;margin: 15px;">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="col-sm-4">
                                      <input type="text" value="<?php echo $value['media']; ?>" name="button"
                                        class="form-control" placeholder="Button Name" required>
                                    </div>
                                    <div class="col-sm-4">
                                      <input type="text" name="note" value="<?php echo $value['note']; ?>"
                                        class="form-control" placeholder="Note" required>
                                    </div>
                                    <input type="hidden" name="button_at" id="button_sec_<?= $key + 1 ?>"
                                      value="<?= $key + 1 ?>">
                                    <div class="col-sm-4" style="margin-top: 5px;">
                                      <a href="javascript:void(0);" id="remove_section_<?= $key + 1 ?>"
                                        onclick="remove_new_section(<?= $key + 1 ?>);" style="float: right;"><span
                                          class="label label-danger" style="font-size: 15px;">Remove Section</span></a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <?php

                                      }
                                  }
                              } else { ?>

                              <div id="sec_1" class="addpianospace draggable"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="col-sm-6">
                                      <input type="file" name="media[]" accept="image/*,video/*" id="1">
                                      <input type="hidden" name="check_value" id="check_value" value="">
                                    </div>
                                    <div class="col-md-6">
                                      <img src="" class="img-thumbnail"
                                        style="display: none;margin-top: 10px;height: 100px;width: 150px;" />
                                      <!-- <video id="video1" controls width="200" style="display: none;">
                                  <source src="blank.mp4" type="video/mp4">
                                </video>
                                <canvas id="canvas1" width="100" height="100"></canvas> -->
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <!--End Add media -->

                        <!--Start Display Speed Training -->
                        <div class="col-sm-12">
                          <a data-toggle="modal" data-target="#myModal"><span class="label label-success"
                              style="font-size: 14px;background-color: #00c053;float: right;">Add
                              Training</span>&nbsp;&nbsp;&nbsp;</a> <br><br>

                          <div class="tab">
                            <button type="button" class="tablinks" onclick="openPattern(event, 'left_hand')"
                              id="defaultOpen">Left
                              hand</button>
                            <button type="button" class="tablinks" onclick="openPattern(event, 'right_hand')">Right
                              hand</button>
                            <button type="button" class="tablinks" onclick="openPattern(event, 'both_hand')">Both
                              hands</button>
                          </div>

                          <input type="hidden" name="patterns_id" id="patterns_id" value="">

                          <div id="left_hand" class="tabcontent">
                            <table id="left_hand_table" class="ui celled table" style="width:100%">
                              <thead>
                                <tr>
                                  <th>SrNo.</th>
                                  <th>Title</th>
                                  <th>Created At</th>
                                  <th>Action</th>
                                </tr>
                              </thead>

                              <?php if ($this->uri->segment('2') == "editLession") { ?>
                              <tbody>
                                <?php if (!empty($patterns)) : $i = 1;
                                    foreach ($patterns as $row) :;
                                        if ($row['category'] == 1) : ?>
                                <tr id="tr_<?php echo $row["id"]; ?>">
                                  <td><?= $i; ?></td>
                                  <td><?= $row['title']; ?></td>
                                  <td><?= $row['created_at']; ?></td>
                                  <td>
                                    <a data-toggle="modal" data-target="#editTraining" class="btn btn-xs btn-warning"
                                      title="Edit" data-id="<?= $row['id'] ?>"
                                      onclick="get_training_details(<?=$row['id']?>)"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger"
                                      onclick="areyousure(<?= $row['id'] ?>)"><i class="fa fa-times"></i></a>
                                    <a href="javascript:void(0);" title="View" data-toggle="modal"
                                      data-target="#viewspeedTraining" class="btn btn-xs btn-danger"
                                      onclick="viewspeedTraining(<?= $row['id'] ?>)"><i class="fa fa-eye"></i></a>
                                  </td>
                                </tr>
                                <?php $i++;
                                        endif;
                                    endforeach;
                                endif; ?>
                              </tbody>
                              <?php } else { ?>
                              <tbody>
                              </tbody>

                              <?php } ?>
                            </table>
                          </div>

                          <div id="right_hand" class="tabcontent">
                            <table id="right_hand_table" class="ui celled table" style="width:100%">
                              <thead>
                                <tr>
                                  <th>SrNo.</th>
                                  <th>Title</th>
                                  <th>Created At</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <?php if ($this->uri->segment('2') == "editLession") { ?>
                              <tbody>
                                <?php if (!empty($patterns)) : $i = 1;
                                    foreach ($patterns as $row) :;
                                        if ($row['category'] == 2) : ?>
                                <tr id="tr_<?php echo $row["id"]; ?>">
                                  <td><?= $i; ?></td>
                                  <td><?= $row['title']; ?></td>
                                  <td><?= $row['created_at']; ?></td>
                                  <td>
                                    <a data-toggle="modal" data-target="#editTraining" class="btn btn-xs btn-warning"
                                      title="Edit" data-id="<?= $row['id'] ?>"
                                      onclick="get_training_details(<?=$row['id']?>)"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger"
                                      onclick="areyousure(<?= $row['id'] ?>)"><i class="fa fa-times"></i></a>
                                    <a href="javascript:void(0);" title="View" data-toggle="modal"
                                      data-target="#viewspeedTraining" class="btn btn-xs btn-danger"
                                      onclick="viewspeedTraining(<?= $row['id'] ?>)"><i class="fa fa-eye"></i></a>
                                  </td>
                                </tr>
                                <?php $i++;
                                        endif;
                                    endforeach;
                                endif; ?>
                              </tbody>
                              <?php } else { ?>

                              <tbody>
                              </tbody>

                              <?php } ?>
                            </table>
                          </div>

                          <div id="both_hand" class="tabcontent">
                            <table id="both_hand_table" class="ui celled table" style="width:100%">
                              <thead>
                                <tr>
                                  <th>SrNo.</th>
                                  <th>Title</th>
                                  <th>Created At</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <?php if ($this->uri->segment('2') == "editLession") { ?>
                              <tbody>
                                <?php if (!empty($patterns)) : $i = 1;
                                    foreach ($patterns as $row) :;
                                        if ($row['category'] == 3) : ?>
                                <tr id="tr_<?php echo $row["id"]; ?>">
                                  <td><?= $i; ?></td>
                                  <td><?= $row['title']; ?></td>
                                  <td><?= $row['created_at']; ?></td>
                                  <td>
                                    <a data-toggle="modal" data-target="#editTraining" class="btn btn-xs btn-warning"
                                      title="Edit" data-id="<?= $row['id'] ?>"
                                      onclick="get_training_details(<?=$row['id']?>)"><i class="fa fa-pencil"></i></a>
                                    <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger"
                                      onclick="areyousure(<?= $row['id'] ?>)"><i class="fa fa-times"></i></a>
                                    <a href="javascript:void(0);" title="View" data-toggle="modal"
                                      data-target="#viewspeedTraining" class="btn btn-xs btn-danger"
                                      onclick="viewspeedTraining(<?= $row['id'] ?>)"><i class="fa fa-eye"></i></a>
                                  </td>
                                </tr>
                                <?php $i++;
                                        endif;
                                    endforeach;
                                endif; ?>
                              </tbody>
                              <?php } else { ?>

                              <tbody>

                              </tbody>

                              <?php } ?>
                            </table>
                          </div>
                        </div>
                        <!--End Display Speed Training -->
                      </div>
                      <div class="section droppable" id="section_html">
                      </div>
                    </div>

                  </div>
                  <!-- End Speed Section -->

                  <!-- Start Unlimited key training Section -->
                  <div class="form-group is_unlimited_key_training" id="is_unlimited_key_training" style="display:none">
                    <div class="panel-body">
                      <div class="row">
                        <input type="hidden" name="unlimited_section_count" id="unlimited_section_count" value="1" />
                        <input type="hidden" name="last_unlimited_id" id="last_unlimited_id" value="1" />

                        <!--start Add media -->
                        <div class="form-group">
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-sm-12">
                                <a href="javascript:void(0);" onclick="add_new_section(1,'after','media','yes','no');"><span
                                    class="label label-success"
                                    style="font-size: 14px;background-color: #00c053;float: right;margin-right: 12px;">Add Key
                                    Media</span>&nbsp;&nbsp;&nbsp;</a>
                              </div>
                            </div>
                            <div class="section droppable" id="unlimited_section_html">

                              <?php
                              if ($this->uri->segment('2') == "editLession" && $lession['unlimited_key_training'] == 1) {
                                  if (empty($lession_detail)) { ?>
                              <div id="sec_unlimited_1" class="addpianospace unlimited_draggable"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="col-sm-4">
                                      <input type="file" name="key_media[]" accept="image/*,video/*" id="1">
                                      <input type="hidden" name="check_value" id="check_value" value="">
                                    </div>
                                    <div class="col-md-2">
                                      <img src="" class="img-thumbnail"
                                        style="display: none;margin-top: 10px;height: 100px;width: 150px;" />
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Type<span class="text-primary"
                                            style="color:#a94442;">*</span></label>

                                        <div class="col-sm-10">
                                          <select class="form-control" name="image_type[]" id="image_type" style="width:70%">
                                            <option value="">Select</option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <?php }
                                  $first = true;
                                  foreach ($lession_detail as $key => $value) {
                                      if ($value['type'] == 'image' || $value['type'] == 'video') {
                                          ?>
                              <div id="sec_unlimited_<?= $key + 1 ?>" class="addpianospace unlimited_draggable"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <div class="row">

                                  <div class="col-sm-12">
                                    <div class="col-sm-4">
                                      <input type="file" name="key_media[]" src="<?php echo $value['media']; ?>"
                                        accept="image/*,video/*" id="<?= $key + 1 ?>">
                                      <input type="hidden" name="check_value" id="check_value"
                                        value="<?php echo $value['media']; ?>">
                                      <input type="hidden" name="old_key_media[]" value="<?php echo $value['media']; ?>">
                                    </div>
                                    <div class="col-sm-8" style="margin-top: 5px;">
                                      <div class="col-sm-2">
                                        <?php if ($value['type'] == 'image') { ?>
                                        <img src="<?php echo $chapter_url . $value['media']; ?>"
                                          style="margin-top: 10px;height: 100px;width: 150px;" ALT
                                          class="img-thumbnail sec_<?= $key + 1 ?>" />
                                        <?php   } elseif ($value['type'] == 'video') { ?>
                                        <video controls width="150">
                                          <source src="<?php echo $chapter_url . $value['media']; ?>" type="video/mp4">
                                        </video>
                                        <?php } ?>
                                      </div>
                                      <div class="col-sm-7">
                                            <label for="title" class="col-sm-3 control-label">Type<span class="text-primary"
                                                            style="color:#a94442;">*</span></label>
                                            <select class="form-control" name="image_type[]" style="width:55%">
                                                <option value="">Select</option>
                                                <option value="minor" <?= $value['image_type'] == 'minor'?'selected':'' ?> >Minor</option>
                                            <option value="major" <?= $value['image_type'] == 'major'?'selected':'' ?> >Major</option>
                                            </select>
                                      </div>
                                        <a href="javascript:void(0);" id="remove_section_<?= $key + 1 ?>"
                                          onclick="remove_unlimited_new_section(<?= $key + 1 ?>);" style="float: right;"><span
                                            class="label label-danger" style="font-size: 15px;">Remove Section</span></a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <?php
                              $first = false;
                                      } else { ?>
                              <div id="sec_unlimited_<?= $key + 1 ?>" class="addpianospace unlimited_draggable"
                                style="border: 2px solid #000000;padding: 50px;margin: 15px;">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="col-sm-4">
                                      <input type="text" value="<?php echo $value['media']; ?>" name="button"
                                        class="form-control" placeholder="Button Name" required>
                                    </div>
                                    <div class="col-sm-4">
                                      <input type="text" name="note" value="<?php echo $value['note']; ?>"
                                        class="form-control" placeholder="Note" required>
                                    </div>
                                    <input type="hidden" name="button_at" id="button_sec_<?= $key + 1 ?>"
                                      value="<?= $key + 1 ?>">
                                    <div class="col-sm-4" style="margin-top: 5px;">
                                      <a href="javascript:void(0);" id="remove_section_<?= $key + 1 ?>"
                                        onclick="remove_unlimited_new_section(<?= $key + 1 ?>);" style="float: right;"><span
                                          class="label label-danger" style="font-size: 15px;">Remove Section</span></a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <?php
                                      }
                                  }
                              } else { ?>
                              <div id="sec_unlimited_1" class="addpianospace unlimited_draggable"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="col-sm-4">
                                      <input type="file" name="key_media[]" accept="image/*,video/*" id="1">
                                      <input type="hidden" name="check_value" id="check_value" value="">
                                    </div>
                                    <div class="col-md-2">
                                      <img src="" class="img-thumbnail"
                                        style="display: none;margin-top: 10px;height: 100px;width: 150px;" />
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Type<span class="text-primary"
                                            style="color:#a94442;">*</span></label>

                                        <div class="col-sm-10">
                                          <select class="form-control" name="image_type[]" id="image_type" style="width:70%">
                                            <option value="">Select</option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <!--End Add media -->
                      </div>
                      <div class="section droppable" id="unlimited_section_html">
                      </div>
                    </div>

                  </div>
                  <!-- End Unlimited key training Section -->

                  <!-- Start recognizing major_minor Section -->
                  <div class="form-group is_reco_major_minor" id="is_reco_major_minor" style="display:none">
                    <div class="panel-body">
                      <div class="row">
                        <input type="hidden" name="reco_major_minor_count" id="reco_major_minor_count" value="1" />
                        <input type="hidden" name="last_unlimited_id" id="last_unlimited_id" value="1" />

                        <!--start Add media -->
                        <div class="form-group">
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-sm-12">
                                <a href="javascript:void(0);" onclick="add_new_section(1,'after','media','no','yes');"><span
                                    class="label label-success"
                                    style="font-size: 14px;background-color: #00c053;float: right;margin-right: 12px;">Add
                                    Media</span>&nbsp;&nbsp;&nbsp;</a>
                              </div>
                            </div>
                            <div class="section droppable" id="reco_major_minor_html">
                                <!-- Edit Section Start-->
                              <?php
                              if ($this->uri->segment('2') == "editLession" && $lession['recognizing'] == 1) {
                                  if (empty($lession_detail)) { ?>
                                  <div id="sec_reco_1" class="addpianospace reco_draggable"
                                    style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <div class="col-sm-6">
                                          <input type="file" name="reco_media[]" accept="image/*,video/*" id="1">
                                          <input type="hidden" name="check_value" id="check_value" value="">
                                        </div>
                                        <div class="col-md-6">
                                          <img src="" class="img-thumbnail"
                                            style="display: none;margin-top: 10px;height: 100px;width: 150px;" />

                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <?php }
                                      $first = true;
                                      foreach ($lession_detail as $key => $value) {
                                          if ($value['type'] == 'image' || $value['type'] == 'video') {
                                              ?>
                                  <div id="sec_reco_<?= $key + 1 ?>" class="addpianospace reco_draggable" style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                    <div class="row">
                                      <div class="col-sm-12">
                                        <div class="col-sm-6">
                                          <input type="file" name="reco_media[]" src="<?php echo $value['media']; ?>"
                                            accept="image/*,video/*" id="<?= $key + 1 ?>">
                                          <input type="hidden" name="check_value" id="check_value"
                                            value="<?php echo $value['media']; ?>">
                                          <input type="hidden" name="old_reco_media[]" value="<?php echo $value['media']; ?>">

                                        </div>
                                        <div class="col-sm-6">

                                          <?php if ($value['type'] == 'image') { ?>

                                          <img src="<?php echo $chapter_url . $value['media']; ?>"
                                            style="margin-top: 10px;height: 100px;width: 150px;" ALT
                                            class="img-thumbnail sec_<?= $key + 1 ?>" />

                                          <?php   } elseif ($value['type'] == 'video') { ?>

                                          <video controls width="150">
                                            <source src="<?php echo $chapter_url . $value['media']; ?>" type="video/mp4">
                                          </video>
                                          <?php } ?>


                                          <a href="javascript:void(0);" id="remove_section_<?= $key + 1 ?>"
                                            onclick="remove_reco_section(<?= $key + 1 ?>);" style="float: right;"><span
                                              class="label label-danger" style="font-size: 15px;">Remove Section</span></a>

                                        </div>

                                      </div>
                                    </div>
                                  </div>
                                  <?php
                                  $first = false;
                                          } else { ?>
                                                <div id="sec_reco_<?= $key + 1 ?>" class="addpianospace reco_draggable"
                                              style="border: 2px solid #000000;padding: 50px;margin: 15px;">
                                              <div class="row">
                                                <div class="col-sm-12">
                                                  <div class="col-sm-4">
                                                    <input type="text" value="<?php echo $value['media']; ?>" name="button"
                                                      class="form-control" placeholder="Button Name" required>
                                                  </div>
                                                  <div class="col-sm-4">
                                                    <input type="text" name="note" value="<?php echo $value['note']; ?>"
                                                      class="form-control" placeholder="Note" required>
                                                  </div>
                                                  <input type="hidden" name="button_at" id="button_sec_<?= $key + 1 ?>"
                                                    value="<?= $key + 1 ?>">
                                                  <div class="col-sm-4" style="margin-top: 5px;">
                                                    <a href="javascript:void(0);" id="remove_section_<?= $key + 1 ?>"
                                                      onclick="remove_reco_section(<?= $key + 1 ?>);" style="float: right;"><span
                                                        class="label label-danger" style="font-size: 15px;">Remove Section</span></a>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                  <!-- Edit Section End-->
                                  <?php
                                          }
                                      }
                              } else { ?>
                              <!-- Add Section Start-->
                              <div id="sec_reco_1" class="addpianospace reco_draggable"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <div class="col-sm-6">
                                      <input type="file" name="reco_media[]" accept="image/*,video/*" id="1">
                                      <input type="hidden" name="check_value" id="check_value" value="">
                                    </div>
                                    <div class="col-md-6">
                                      <img src="" class="img-thumbnail"
                                        style="display: none;margin-top: 10px;height: 100px;width: 150px;" />
                                      <!-- <video id="video1" controls width="200" style="display: none;">
                                  <source src="blank.mp4" type="video/mp4">
                                </video>
                                <canvas id="canvas1" width="100" height="100"></canvas> -->
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- Add Section End-->
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <!--End Add media -->
                      </div>
                      <div class="section droppable" id="reco_major_minor_html">
                      </div>
                    </div>

                  </div>
                  <!-- End recognizing major_minor Section -->

                  <input type="submit" name="submit" class="btn btn-sm btn-primary" />

                  <button type="button" name="cancel" class="btn btn-sm btn-primary"
                    onClick="window.location.href='<?=base_url().'Lession'?>'">Cancel</button>

                </form>

                <!-- pop-up start Add Speed Training-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                  aria-hidden="true">

                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="submit" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add Speed Training</h4>
                      </div>

                      <form name="add_speed_training" id="add_speed_training" method="post" class="form-horizontal"
                        role="form" enctype="multipart/form-data">

                        <?php
                          if ($this->uri->segment('2') == "editLession") :
                              ?>
                        <input type="hidden" name="lession_id" id="lession_id" value="<?=$lession['id']?>">
                        <?php endif; ?>

                        <div class="modal-body">
                          <div class="form-group">
                            <label for="st_title" class="col-sm-2 control-label">Title<span class="text-primary"
                                style="color:#a94442;">*</span></label>

                            <div class="col-sm-10">
                              <input type="text" placeholder="Title" value="" class="form-control" name="st_title"
                                id="st_title" required />
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="st_category" class="col-sm-2 control-label">Category <span class="text-primary"
                                style="color:#a94442;">*</span></label>

                            <div class="col-sm-10">
                              <select class="form-control" name="st_category" id="st_category" required>
                                <option selected disabled value="">Select category</option>
                                <option value="1">Left hand</option>
                                <option value="2">Right hand</option>
                                <option value="3">Both hand</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="st_img" class="col-sm-2 control-label">Image<span class="text-primary"
                                style="color:#a94442;">*</span></label>

                            <div class="col-sm-10">
                              <img src="" id="view_add_image" name="view_add_image" style="width: 300px;height: 300px;">
                              <input type="file" onchange="AddimagereadURL(this);" class="form-control" name="st_image"
                                id="st_image" required />
                              <?php // if(isset($upload_error)) { echo $upload_error ; }?>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="st_audio" class="col-sm-2 control-label">Audio<span class="text-primary"
                                style="color:#a94442;">*</span></label>

                            <div class="col-sm-10">
                              <audio controls id="add_audio">
                                <source src="" id="add_audio_source" name="add_audio_source">
                              </audio>
                              <input type="file" class="form-control" name="st_audio" id="st_audio" required />
                              <!-- onchange="audioaddreadURL(this);" -->
                            </div>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <!-- <button type="button" class="btn btn-primary" onclick="submit_st_form()">Add
                                      Training</button> -->
                          <button type="submit" class="btn btn-success btn-submit" name="st_form_submit_btn"
                            id="st_form_submit_btn">Submit</button>
                          <button class="btn btn-default" id="model_close"
                            data-dismiss="modal">Close</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- pop-up end add Speed Training-->

                <!-- pop-up start Edit Speed Training-->
                <div class="modal fade" id="editTraining" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                  aria-hidden="true">

                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="submit" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel">Update Speed Training</h4>
                      </div>

                      <form name="edit_speed_training" id="edit_speed_training" method="post" class="form-horizontal"
                        role="form" enctype="multipart/form-data">

                        <?php if ($this->uri->segment('2') == "editLession") {  ?>
                        <input type="hidden" name="lession_id" id="lession_id" value="<?= $lession['id'] ?>">
                        <?php } else { ?>
                        <input type="hidden" name="lession_id" id="lession_id" value="">
                        <?php } ?>


                        <input type="hidden" name="training_id" id="training_id" value="">

                        <div class="modal-body">
                          <div class="form-group">
                            <label for="edit_st_title" class="col-sm-2 control-label">Title<span class="text-primary"
                                style="color:#a94442;">*</span></label>

                            <div class="col-sm-10">
                              <input type="text" placeholder="Title" value="" class="form-control" name="edit_st_title"
                                id="edit_st_title" required />
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="edit_st_category" class="col-sm-2 control-label">Category <span
                                class="text-primary" style="color:#a94442;">*</span></label>

                            <div class="col-sm-10">
                              <select class="form-control" name="edit_st_category" id="edit_st_category" required>
                                <option selected disabled value="">Select category</option>
                                <option value="1">Left hand</option>
                                <option value="2">Right hand</option>
                                <option value="3">Both hand</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="edit_st_image" class="col-sm-2 control-label">Image<span class="text-primary"
                                style="color:#a94442;">*</span></label>

                            <div class="col-sm-10">
                              <img src="" id="view_edit_image" name="view_edit_image"
                                style="width: 300px;height: 300px;">
                              <input type="file" onchange="EditimagereadURL(this);" class="form-control"
                                name="edit_st_image" id="edit_st_image" />
                              <input type="hidden" name="old_img" id="old_img" value="">
                              <?php // if(isset($upload_error)) { echo $upload_error ; }?>
                            </div>
                          </div>

                          <div class="form-group">
                            <label for="st_audio" class="col-sm-2 control-label">Audio<span class="text-primary"
                                style="color:#a94442;">*</span></label>

                            <div class="col-sm-10">
                              <audio controls="" id="edit_audio">
                                <source src="" id="edit_audio_source" name="edit_audio_source" type="audio/mpeg">
                              </audio>
                              <input type="file" class="form-control" name="edit_st_audio" id="edit_st_audio" />
                              <input type="hidden" name="old_audio" id="old_audio" value="">
                            </div>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <!-- <button type="button" class="btn btn-primary" onclick="submit_st_form()">Add
                                      Training</button> -->
                          <button type="submit" class="btn btn-success btn-submit" name="st_form_submit_btn"
                            id="st_form_submit_btn">Update</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- pop-up end Edit Speed Training-->

                <!-- pop-up start view Speed Training -->
                <div class="modal fade" id="viewspeedTraining" role="dialog">
                  <div class="modal-dialog modal-lg">

                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Detail</h4>
                      </div>

                      <div class="modal-body">
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- pop-up end view Speed Training-->

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>



<!-- /content -->
<script type="text/javascript">
  $(document).ready(function () {
    $(".droppable").sortable({
      update: function (event, ui) {

        Dropped(event, ui);
        /*console.log(event);
        console.log(ui);*/
      }
    });

    // valueChanged();

    // $('#myModal').on('shown.bs.modal', function() {
    //   $('#add_audio_source').attr('src', '');
    //   document.getElementById('add_audio').load();
    // })

    myFunction();
    document.getElementById("defaultOpen").click();

      $(document).on('click', 'input[type="checkbox"]', function() {      
        $('input[type="checkbox"]').not(this).prop('checked', false);      
      });
  });

  function myFunction() {
    var speed_training = document.getElementById("speed_training");
    var speed_training_form = document.getElementById("is_speed_training");

    var unlimited_key_training = document.getElementById("unlimited_key_training");
    var unlimited_key_training_form = document.getElementById("is_unlimited_key_training");

    var ear_training = document.getElementById("ear_training");

    var recognizing = document.getElementById("recognizing");
    var is_reco_major_minor_form = document.getElementById("is_reco_major_minor");

    if (speed_training.checked == true) {
      speed_training_form.style.display = "block";
      unlimited_key_training_form.style.display = "none";
      document.getElementById("speed_training").value = '1';
      document.getElementById("unlimited_key_training").value = '0';
    }else{
      speed_training_form.style.display = "none";
      document.getElementById("speed_training").value = '0';
    } 

    if (ear_training.checked == true) {
      document.getElementById("ear_training").value = '1';
    }else{
      document.getElementById("ear_training").value = '0';
    }

    if (recognizing.checked == true) {
      is_reco_major_minor_form.style.display = "block";
      speed_training_form.style.display = "none";
      unlimited_key_training_form.style.display = "none";
      document.getElementById("recognizing").value = '1';
    }else{
      document.getElementById("recognizing").value = '0';
      is_reco_major_minor_form.style.display = "none";
    }

    if (unlimited_key_training.checked == true) {
      unlimited_key_training_form.style.display = "block";
      speed_training_form.style.display = "none";
      // document.getElementById("image_type").required = true;
      document.getElementById("unlimited_key_training").value = '1';
      document.getElementById("speed_training").value = '0';
    }else{
      unlimited_key_training_form.style.display = "none";
      document.getElementById("unlimited_key_training").value = '0';
    } 
  }

  function openPattern(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  function viewspeedTraining(id) {
    var training_url = 'http://localhost/piano_admin/upload/chapter/'; //Local
    // var training_url = 'http://18.235.99.234/piano_test/APIs/uploads/chapter/'; //Live 
    $.ajax({
      type: "GET",
      url: '<?= base_url() ?>Lession/speedtrainingview/' + id,
      data: {},
      cache: false,
      'Content-Type': "application/json",
      success: function (data) {
        // console.log(data)

        var result = (JSON.parse(data));
        var category = '';
        if (result.training.category == 1) {
          category = "Left hand";
        } else if (result.training.category == 2) {
          category = "Right hand";
        } else {
          category = "Both hand";
        }

        var html = ''
        $('#viewspeedTraining .modal-body').html('');

        html += `<div id="sec_2" class="addpianospace draggable" style="border: 2px solid #000000;padding: 10px;margin: 25px;">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="col-sm-4">
                        <lable>Title</lable>
                        
                          <input type="text" readonly value="${result?.training?.title}"  class="form-control" >
                      </div>
                      <div class="col-sm-3">
                        <lable>Category</lable>
                        
                          <input type="text" readonly value="${category}"  class="form-control" >
                      </div>
                      
                      <div class="col-sm-4">
                        <lable>Audio</lable>
                        <audio controls="" id="view_audio">
                                <source src="${training_url + result?.training?.audio}"
                                  id="view_audio_source" name="view_audio_source" type="audio/mpeg">
                              </audio>
                      </div>
                  </div>
                  <div class="col-sm-12">
                      <div class="col-sm-4">
                        <lable>Image</lable>
                          <img src="${training_url + result?.training?.image}" id="view_img" name="view_img"
                                style="width: 250px;height: 250px;">
                      </div>
                  </div>
                  
              </div>
          </div> `;

        $('#viewspeedTraining .modal-body').html(html);

      }
    });
  }

  function areyousure(id) {
    var lession_id = document.getElementById('lession_id').value

    $.confirm({
      title: 'Delete Speed Training',
      content: 'Are you sure you want to delete?',
      buttons: {
        confirm: function () {
          $.ajax({
            url: '<?= base_url() ?>Lession/deletespeedtraining/' + id,
            type: 'DELETE',
            data: {
              "id": id,
            },
            success: function (data) {
              // console.log(data);
              toastr.success('Speed Training deleted successfully.');
              
              var row = $(document.getElementById("tr_" + id));
              var siblings = row.siblings();
              document.getElementById("tr_" + id).remove();
              siblings.each(function (index) {
                $(this).children('td').first().text(index + 1);
              });


            }
          });
        },
        cancel: function () {
          return true;
        },
      }
    });
  }

  function AddimagereadURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#view_add_image').attr('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      $('#view_add_image').attr('src', '');
    }
  }

  function EditimagereadURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#view_edit_image').attr('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    } else {
      $('#view_edit_image').attr('src', '');
    }
  }

  

  $('#myModal').on('hidden.bs.modal', function (e) {
    $(this)
    document.getElementById("add_speed_training").reset();
    $('#view_add_image').attr('src', '');
    $('#add_audio_source').attr('src', '');
    
    document.getElementById('add_audio').load();
  })
  
  $('#editTraining').on('hidden.bs.modal', function (e) {
    $(this)   
    document.getElementById("add_speed_training").reset(); 
    document.getElementById('edit_audio').load();
  })
  
  $('#viewspeedTraining').on('hidden.bs.modal', function (e) {
    $(this)    
    document.getElementById('view_audio').load();
  })

  var super_array = [];

  $("#add_speed_training").on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: '<?= base_url() ?>Lession/add_speed_tranining',
      type: 'POST',
      async: false,
      data: new FormData(this),
      processData: false,
      cache: false,
      dataType: 'json',
      contentType: false,
      success: function (data) {
        // console.log(data);

        document.getElementById("add_speed_training").reset();
        
        $('#add_audio_source').attr('src', '');
        $('#view_add_image').attr('src', '');
        $('#myModal').modal('hide');

        toastr.success('Speed training added successfully.');

        var add_training = '';

        var abc = data.result;
        super_array.push(abc);
        console.log(super_array);

        document.getElementById("patterns_id").value = super_array;

        // console.log(super_array);

        if (data.result_details.category == 1) {

          var rowCount = $('#left_hand_table tr').length;
          // console.log(rowCount);

          add_training += '<tr id="tr_' + data.result_details.id + '">';
          add_training += '<td>' + rowCount + '</td>';
          add_training += '<td>' + data.result_details.title + '</td>';
          add_training += '<td>' + data.result_details.created_at + '</td>';
          add_training +=
            '<td> <a data-toggle="modal" data-target="#editTraining" data-id="' + data.result_details.id +
            '" onclick="get_training_details(' + data.result_details.id +
            ')" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>  <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(' +
            data.result_details.id +
            ')"><i class="fa fa-times"></i></a> <a href="javascript:void(0);" title="View" data-toggle="modal" data-target="#viewspeedTraining" class="btn btn-xs btn-danger" onclick="viewspeedTraining(' +
            data.result_details.id + ')"><i class="fa fa-eye"></i></a></td>';
          add_training += '</tr>';

          $('#left_hand_table').append(add_training);

        } else if (data.result_details.category == 2) {
          // console.log("Right hand");

          var rowCount = $('#right_hand_table tr').length;
          // console.log(data.result_details.id);

          add_training += '<tr id="tr_' + data.result_details.id + '">';
          add_training += '<td>' + rowCount + '</td>';
          add_training += '<td>' + data.result_details.title + '</td>';
          add_training += '<td>' + data.result_details.created_at + '</td>';
          add_training +=
            '<td> <a data-toggle="modal" data-target="#editTraining" data-id="' + data.result_details.id +
            '" onclick="get_training_details(' + data.result_details.id +
            ')" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>  <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(' +
            data.result_details.id +
            ')"><i class="fa fa-times"></i></a> <a href="javascript:void(0);" title="View" data-toggle="modal" data-target="#viewspeedTraining" class="btn btn-xs btn-danger" onclick="viewspeedTraining(' +
            data.result_details.id + ')"><i class="fa fa-eye"></i></a></td>';
          add_training += '</tr>';

          $('#right_hand_table').append(add_training);

        } else {
          // console.log("Both hand");

          var rowCount = $('#both_hand_table tr').length;
          // console.log(rowCount);

          add_training += '<tr id="tr_' + data.result_details.id + '">';
          add_training += '<td>' + rowCount + '</td>';
          add_training += '<td>' + data.result_details.title + '</td>';
          add_training += '<td>' + data.result_details.created_at + '</td>';
          add_training +=
            '<td> <a data-toggle="modal" data-target="#editTraining" data-id="' + data.result_details.id +
            '" onclick="get_training_details(' + data.result_details.id +
            ')" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>  <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(' +
            data.result_details.id +
            ')"><i class="fa fa-times"></i></a> <a href="javascript:void(0);" title="View" data-toggle="modal" data-target="#viewspeedTraining" class="btn btn-xs btn-danger" onclick="viewspeedTraining(' +
            data.result_details.id + ')"><i class="fa fa-eye"></i></a></td>';
          add_training += '</tr>';

          $('#both_hand_table').append(add_training);
        }
      }
    });
  });

  $("#edit_speed_training").on('submit', function (e) {
    e.preventDefault();
    var edit_training = '';
    $.ajax({
      url: '<?= base_url() ?>Lession/editspeedTraining',
      type: 'POST',
      async: false,
      data: new FormData(this),
      processData: false,
      cache: false,
      dataType: 'json',
      contentType: false,
      success: function (data) {
        // console.log(data);
        $('#editTraining').modal('hide');

        document.getElementById("edit_audio").load();

        toastr.success('Speed training Updated successfully.');

        $('#tr_' + data.id).find("td").eq(1).html(data.title);

        if (data.category == 1) {

          var row = $(document.getElementById("tr_" + data.id));
          var siblings = row.siblings();
          siblings.each(function (index) {
            $(this).children('td').first().text(index + 1);
          });

          var rowCount = $('#left_hand_table tr').length;
          // console.log(rowCount);
          document.getElementById("tr_" + data.id).remove();

          edit_training += '<tr id="tr_' + data.id + '">';
          edit_training += '<td>' + rowCount + '</td>';
          edit_training += '<td>' + data.title + '</td>';
          edit_training += '<td>' + data.created_at + '</td>';
          edit_training +=
            '<td> <a data-toggle="modal" data-target="#editTraining" data-id="' + data.id +
            '" onclick="get_training_details(' + data.id +
            ')" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>  <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(' +
            data.id +
            ')"><i class="fa fa-times"></i></a> <a href="javascript:void(0);" title="View" data-toggle="modal" data-target="#viewspeedTraining" class="btn btn-xs btn-danger" onclick="viewspeedTraining(' +
            data.id + ')"><i class="fa fa-eye"></i></a></td>';
          edit_training += '</tr>';

          $('#left_hand_table').append(edit_training);
        } else if (data.category == 2) {

          var row = $(document.getElementById("tr_" + data.id));
          var siblings = row.siblings();
          siblings.each(function (index) {
            $(this).children('td').first().text(index + 1);
          });

          var rowCount = $('#right_hand_table tr').length;
          // console.log(rowCount);
          document.getElementById("tr_" + data.id).remove();

          edit_training += '<tr id="tr_' + data.id + '">';
          edit_training += '<td>' + rowCount + '</td>';
          edit_training += '<td>' + data.title + '</td>';
          edit_training += '<td>' + data.created_at + '</td>';
          edit_training +=
            '<td> <a data-toggle="modal" data-target="#editTraining" data-id="' + data.id +
            '" onclick="get_training_details(' + data.id +
            ')" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>  <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(' +
            data.id +
            ')"><i class="fa fa-times"></i></a> <a href="javascript:void(0);" title="View" data-toggle="modal" data-target="#viewspeedTraining" class="btn btn-xs btn-danger" onclick="viewspeedTraining(' +
            data.id + ')"><i class="fa fa-eye"></i></a></td>';
          edit_training += '</tr>';

          $('#right_hand_table').append(edit_training);

        } else {
          var row = $(document.getElementById("tr_" + data.id));
          var siblings = row.siblings();
          siblings.each(function (index) {
            $(this).children('td').first().text(index + 1);
          });

          var rowCount = $('#both_hand_table tr').length;
          // console.log(rowCount);
          document.getElementById("tr_" + data.id).remove();

          edit_training += '<tr id="tr_' + data.id + '">';
          edit_training += '<td>' + rowCount + '</td>';
          edit_training += '<td>' + data.title + '</td>';
          edit_training += '<td>' + data.created_at + '</td>';
          edit_training +=
            '<td> <a data-toggle="modal" data-target="#editTraining" data-id="' + data.id +
            '" onclick="get_training_details(' + data.id +
            ')" class="btn btn-xs btn-warning" title="Edit"><i class="fa fa-pencil"></i></a>  <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(' +
            data.id +
            ')"><i class="fa fa-times"></i></a> <a href="javascript:void(0);" title="View" data-toggle="modal" data-target="#viewspeedTraining" class="btn btn-xs btn-danger" onclick="viewspeedTraining(' +
            data.id + ')"><i class="fa fa-eye"></i></a></td>';
          edit_training += '</tr>';

          $('#both_hand_table').append(edit_training);

        }
        // }

      }
    });

  });

  function get_training_details(id) {
    $.ajax({
      type: "GET",
      url: '<?= base_url() ?>Lession/training_details/' + id,
      cache: false,
      success: function (data) {
        // console.log(data);
        var obj = JSON.parse(data);
        // console.log(obj);
        var training_url = 'http://localhost/piano_admin/upload/chapter/'; //Local
        // var training_url = 'http://18.235.99.234/piano_test/APIs/uploads/chapter/'; //Live
        // alert(training_url);
        document.getElementById("edit_st_title").value = obj.title;
        document.getElementById("edit_st_category").value = obj.category;
        document.getElementById("training_id").value = obj.id;
        document.getElementById("old_img").value = obj.image;
        document.getElementById("old_audio").value = obj.audio;
        $('#view_edit_image').attr('src', training_url + obj.image);

        var audio = $("#edit_audio");
        $('#edit_audio_source').attr('src', training_url + obj.audio);

        audio[0].pause();
        audio[0].load();
        // audio[0].oncanplaythrough = audio[0].play();
      }
    });
  }

  function manage_add_edit_audio_Files(event) {
    
    // console.log(event.target.files)
    var files = event.target.files;
    // console.log(files)
    console.log(URL.createObjectURL(files[0]))
    $("#add_audio_source").attr("src", URL.createObjectURL(files[0]));
    document.getElementById("add_audio").load();

    $("#edit_audio_source").attr("src", URL.createObjectURL(files[0]));
    document.getElementById("edit_audio").load();
  }

  document.getElementById("st_audio").addEventListener("change", manage_add_edit_audio_Files, false);
  document.getElementById("edit_st_audio").addEventListener("change", manage_add_edit_audio_Files, false);

  function add_new_section(section, position, type,is_unlimited,is_reco_major_minor) {
    if(is_unlimited == 'no' && is_reco_major_minor == 'no'){
        if (type == 'button') {
        var jobValue = $("input[name=button_at]").val();
        if (jobValue != '' && jobValue != undefined) {
          alert("Already button is exist");
          return false;
        }
      }
      var count = $('#section_count').val();
      var cnt_div = $('.draggable').length
      var last_id = $(".draggable:last").attr("id");
      if(last_id){
        divid = last_id;
      }else{
        divid = "0";
      }
      console.log(divid);
      // var divid = "sec_"+count;
    }
    if(is_unlimited == 'yes'){
      var count = $('#unlimited_section_count').val();
      var cnt_div = $('.unlimited_draggable').length
      var last_id = $(".unlimited_draggable:last").attr("id");
      if(last_id){
        divid = last_id;
      }else{
        divid = "0";
      }
      console.log(divid);
      // var divid = "sec_unlimited_"+count;
    }
    if(is_reco_major_minor == 'yes'){
      var count = $('#reco_major_minor_count').val();
      var cnt_div = $('.reco_draggable').length
      var last_id = $(".reco_draggable:last").attr("id");
      if(last_id){
        divid = last_id;
      }else{
        divid = "0";
      }
      console.log(divid);
    }
    
    // alert(count);
    // alert(cnt_div);
    // alert(count);
    // alert(divid);

    $.ajax({
      url: '<?= base_url() ?>Lession/add_section',
      type: "POST",
      data: {
        'count': count,
        'cnt_div': cnt_div,
        'divid': divid,
        'unlimited': is_unlimited,
        'reco': is_reco_major_minor,
        position,
        'type': type
      },
      success: function (html) {
        // if (is_unlimited == 'no') {
        //     if (section > 0) {
        //     $("#section_html").append(html);

        //   } else {
        //     debugger;
        //     $("#section_html").append(html);
        //   }
        //   $('#section_count').val(parseInt(count) + 1);
        // }else{
        //   if (section > 0) {
        //     $("#unlimited_section_html").append(html);
        //   } else {
        //     debugger;
        //     $("#unlimited_section_html").append(html);
        //   }
        //   $('#unlimited_section_count').val(parseInt(count) + 1);
        //   // $('#last_unlimited_id').val(parseInt(count) + 1);
        // }
        if (is_unlimited == 'yes') {
          if (section > 0) {
            $("#unlimited_section_html").append(html);
          } else {
            debugger;
            $("#unlimited_section_html").append(html);
          }
          $('#unlimited_section_count').val(parseInt(count) + 1);
          // $('#last_unlimited_id').val(parseInt(count) + 1);
        }else if (is_reco_major_minor == 'yes') {
          if (section > 0) {
            $("#reco_major_minor_html").append(html);
          } else {
            debugger;
            $("#reco_major_minor_html").append(html);
          }
          $('#reco_major_minor_count').val(parseInt(count) + 1);

        }else{
          if (section > 0) {
            $("#section_html").append(html);

          } else {
            debugger;
            $("#section_html").append(html);
          }
          $('#section_count').val(parseInt(count) + 1);
        }
        
      }
    });
  }

  function remove_new_section(section) {
    // var count = $('#section_count').val();
    $('#sec_' + section).remove();

  }
  function remove_unlimited_new_section(section) {
    // var count = $('#section_count').val();
    $('#sec_unlimited_' + section).remove();

  }
  function remove_reco_section(section) {
    // var count = $('#section_count').val();
    $('#sec_reco_' + section).remove();

  }

  function Dropped(event, ui) {
    $(".draggable").each(function (e) {
      var $elem = $(this);
      var menu = this.id;

      $('#button_' + this.id).val(e + 1);

    });
    $(".unlimited_draggable").each(function (e) {
      var $elem = $(this);
      var menu = this.id;

      $('#button_' + this.id).val(e + 1);

    });
  }

  $(document).delegate(':file', 'change', function () {

    var fileName = $(this).val().split(/\\/).pop();
    var fileExt = fileName.split('.').pop().toLowerCase();
    var fileInput = this.files[0];
    // console.log(fileExt)

    var image_ext = ['gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm'];
    var video_ext = ['mp4', 'mp3', 'mov', 'm4v', 'avi'];

    if (image_ext.includes(fileExt)) {

      // console.log("sssss")

      

      var sec = $(this).attr('id');
      // alert(sec); 
      var reader = new FileReader();

      var speed_training = document.getElementById("speed_training").value;
      var reco_major_minor = document.getElementById("recognizing").value;
      // alert(speed_training);

      if (speed_training == '1') {
          reader.onloadend = function () {
          imagebase64 = reader.result;
          $(`#sec_${sec} img`).attr('src', imagebase64);
          $(`#sec_${sec} img`).show();
        }
      }else if (reco_major_minor == '1') {
          reader.onloadend = function () {
          imagebase64 = reader.result;
          $(`#sec_reco_${sec} img`).attr('src', imagebase64);
          $(`#sec_reco_${sec} img`).show();
        }
      }else{
          reader.onloadend = function () {
          imagebase64 = reader.result;
          $(`#sec_unlimited_${sec} img`).attr('src', imagebase64);
          $(`#sec_unlimited_${sec} img`).show();
        }
      }
      

      reader.readAsDataURL(fileInput);

    } else if (video_ext.includes(fileExt)) {

      // console.log("Loading...");


      // if (video.objectURL && video.src) {
      //   URL.revokeObjectURL(video.src);
      // }

      // video.pleload = "metadata";
      // video.objectURL = true;
      // video.src = URL.createObjectURL(fileInput);

      // setTimeout(() => {
      //   snapPicture();
      // }, 2000);
    }


  });
</script>

<?php include('footer.php') ?>
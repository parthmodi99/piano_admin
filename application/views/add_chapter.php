<?php include('header.php') ?>

<?php include('sidebar.php') ?>

<script src="<?= base_url('admintheme') ?>/ckeditor/ckeditor.js"></script>

<script src="<?= base_url('admintheme') ?>/ckeditor/samples/js/sample.js"></script>



<style type="text/css">
  .draggable {

    cursor: move;

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


      <!-- <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3"></h1>
      </div> -->

      <div class="wrapper-md" ng-controller="FlotChartDemoCtrl">

        <div class="row">

          <div class="col-sm-12">

            <div class="panel panel-default">

              <div class="panel-heading font-bold"><?php echo (!empty($chapter)) ? 'Update' : 'Add';   ?></div>

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

              <form name="chapters" id="chapters"
                  action="<?= base_url() . 'Chapter/' ?><?php if ($this->uri->segment('2') == "editChapter") {
                      echo "editChapter/" . $this->uri->segment('3');
                  } else {
                      echo "addChapter";
                  } ?>"
                  method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

                  <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />

                  <?php
                  //if ($this->uri->segment('2') == "editChapter") :
                      ?>

                  <input type="hidden" name="chapter_id" id="chapter_id" value="<?= $this->uri->segment('2') == "editChapter" ? $chapter['id'] : "0" ?>">

                  <?php //endif; ?>
                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Chapter <span class="text-primary"
                        style="color:#a94442;">*</span></label>

                    <div class="col-sm-10">
                      <select class="form-control" name="lession_id" id="lession_id" onchange="check_chapter(0)" required>
                      <option disabled value="" selected> Select Chapter </option>
                        <?php if (!empty($lession)) : $i = 1;
                            foreach ($lession as $row) : ?>
                        <option <?php if (!empty($chapter) && $chapter['lession_id'] == $row['id']) {
                            echo "selected";
                        } ?> value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                        <?php $i++;
                            endforeach;
                        endif; ?>
                      </select>
                    </div>

                  </div>

                  <!-- Normal Chapter Title -->
                  <div class="form-group" id="normal_chapter_title" style="display: none;">
                    <label for="title" class="col-sm-2 control-label">Lesson<span class="text-primary"
                        style="color:#a94442;">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" placeholder="Title"
                        value="<?php echo (!empty($chapter) && $chapter['title']) ? $chapter['title'] : '';   ?>"
                        class="form-control" name="title" id="title" />
                    </div>
                  </div>

                  <!-- Ear chapter Latter name -->
                  <div class="form-group" id="ear_chapter_letter_name" style="display: none;">
                    <label for="title" class="col-sm-2 control-label">Letter Name<span class="text-primary"
                        style="color:#a94442;">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" placeholder="Letter Name"
                        value="<?php echo (!empty($chapter) && $chapter['title']) ? $chapter['title'] : '';   ?>"
                        class="form-control" name="letter_name" id="letter_name" />
                    </div>
                  </div>

                  <input type="hidden" name="section_count" id="section_count" value="1" />
                  <input type="hidden" name="is_ear_training_type" id="is_ear_training_type" value="<?php if ($this->uri->segment('2') == "editChapter") { echo $is_ear_training_type; }?>" />
                  <input type="hidden" name="is_ear_chapter" id="is_ear_chapter" value="<?php if ($this->uri->segment('2') == "editChapter") { echo $is_ear_chapter; }else {echo "0"; }?>" />
                  <input type="hidden" name="is_recognizing" id="is_recognizing" value="<?php if ($this->uri->segment('2') == "editChapter") { echo $is_recognizing; }else {echo "0"; }?>" />

                  <!--start Normal chapter -->
                    <div class="form-group" id="normal_chapter" 
                      <?php if ($this->uri->segment('2') == "editChapter") {?> style="display: block;" <?php } else {?> style="display: none;" <?php } ?>>
                      <div class="panel-body">
                        <div class="row">
                          <div class="col-sm-12">
                              <a href="javascript:void(0);" onclick="add_new_section(1,'after','lession_question');"><span
                                      class="label label-success"
                                      style="font-size: 14px;background-color: #00c053;float: right;" id="add_question">Add Question</span>&nbsp;&nbsp;&nbsp;</a>

                              <a href="javascript:void(0);" onclick="add_new_section(1,'after','metronome');"><span
                                class="label label-success"
                                style="font-size: 14px;background-color: #00c053;float: right;margin-right: 12px;" id="add_metronome">Add Metronome</span>&nbsp;&nbsp;&nbsp;</a>

                            <a href="javascript:void(0);" onclick="add_new_section(1,'after','media');"><span
                                class="label label-success"
                                style="font-size: 14px;background-color: #00c053;float: right;margin-right: 12px;">Add
                                Media</span>&nbsp;&nbsp;&nbsp;</a>

                            <a href="javascript:void(0);" onclick="add_new_section(1,'after','button');"><span
                                class="label label-success"
                                style="font-size: 14px;background-color: #00c053;float: right;margin-right: 12px;">Add
                                Button</span></a>
                          </div>
                        </div>
                        <div class="section droppable" id="section_html">

                          <?php
                        if ($this->uri->segment('2') == "editChapter") {
                              $first = true;
                              foreach ($chapter_detail as $key => $value) {
                                  if ($value['type'] == 'image' || $value['type'] == 'video') {
                                      ?>
                          <div id="sec_<?= $key + 1 ?>" class="addpianospace draggable"
                            style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="col-sm-6">
                                  <input type="file" name="media[]" src="<?php echo $value['media']; ?>"
                                    accept="image/*,video/*" id="<?= $key + 1 ?>">
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
                                  } elseif ($value['type'] == 'metronome') { ?>
                              <div id="sec_<?= $key + 1 ?>" class="addpianospace draggable"
                            style="border: 2px solid #000000;padding: 50px;margin: 15px;">
                            <div class="row">
                              <div class="col-sm-12">
                                <div class="col-sm-6">
                                  <!-- <input type="text" value="<?php //echo $value['media'];?>" name="metronome"
                                    class="form-control" placeholder="Metronome Name" required> -->
                                    <span name="metronome" value="Metronome inside">Metronome inside</span>
                                </div>
                                <input type="hidden" name="metronome_at" id="metronome_sec_<?= $key + 1 ?>"
                                  value="<?= $key + 1 ?>">
                                <div class="col-sm-6" style="margin-top: 5px;">
                                  <a href="javascript:void(0);" id="remove_section_<?= $key + 1 ?>"
                                    onclick="remove_new_section(<?= $key + 1 ?>);" style="float: right;"><span
                                      class="label label-danger" style="font-size: 15px;" onclick="someFunction('metronome')">Remove Section</span></a>
                                </div>
                              </div>
                            </div>
                          </div>

                          <?php
                                    $first = false;
                                  } elseif($value['type'] == 'lession_question') { ?>
                                  <div id="sec_<?= $key + 1 ?>" class="addpianospace draggable"
                                      style="border: 2px solid #000000;padding: 50px;margin: 15px;">
                                      <div class="row">
                                          <div class="col-sm-12">
                                              <div class="col-sm-6">
                                                  <!-- <input type="text" value="<?php //echo $value['media'];?>" name="metronome"
                                    class="form-control" placeholder="Metronome Name" required> -->
                                                  <span name="metronome" value="Question inside">Question inside</span>
                                              </div>
                                              <input type="hidden" name="question_at" id="question_sec_<?= $key + 1 ?>"
                                                    value="<?= $key + 1 ?>">
                                              <div class="col-sm-6" style="margin-top: 5px;">
                                                  <a href="javascript:void(0);" id="remove_section_<?= $key + 1 ?>"
                                                    onclick="remove_new_section(<?= $key + 1 ?>);" style="float: right;"><span
                                                          class="label label-danger" style="font-size: 15px;" onclick="someFunction('question')">Remove Section</span></a>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                            <?php  } else { ?>
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
                                    <input type="file" name="media[]"  accept="image/*,video/*" id="1">
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
                  <!--End Normal chapter -->

                  <!--Start Ear chapter -->
                  <div class="form-group" id="ear_chapter" <?php if ($this->uri->segment('2') == "editChapter") {?> style="display: block;" <?php } else {?> style="display: none;" <?php } ?>>
                    <div class="panel-body">
                      <div class="section droppable" id="section_html">
                        <?php
                          if ($this->uri->segment('2') == "editChapter" && $is_ear_chapter == 1) { 
                        ?> 
                          <!-- Edit Ear training  -->
                              <div id="ear_sec_1" class="addpianospace draggable1"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <?php 
                                  // foreach ($chapter_detail as $key => $value) {
                                ?>
                                  <div class="row">
                                    <div class="col-sm-12">
                                      <!-- <div class="col-sm-4">
                                        <input type="text" placeholder="Letter Name" class="form-control" name="letter_name" id="letter_name" value="<?php //echo (!empty($ear_chapter_detail) && $ear_chapter_detail[0]['letter_name']) ? $ear_chapter_detail[0]['letter_name'] : '';   ?>"/>
                                      </div> -->

                                      <!-- <div class="col-sm-4" style="width: 20%;"> -->
                                      <div class="col-sm-4">
                                        <input type="file" name="letter_image"  id="letter_image" accept="image/*,video/*">
                                        <input type="hidden" name="old_letter_image[]" id="old_letter_image[]" value="<?php if($chapter_detail){echo $chapter_detail[0]['media']; } ?>">
                                        
                                      </div>
                                      
                                      <div class="col-md-2">
                                        <img src="<?php if($chapter_detail){ echo $chapter_url . $chapter_detail[0]['media']; } ?>"
                                          style="margin-top: 10px;height: 100px;width: 150px;" ALT
                                          class="img-thumbnail" />
                                      </div>
                                      <!-- <div class="col-md-2" style="width: 30%;"> -->
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label for="title" class="col-sm-2 control-label">Type<span class="text-primary"
                                              style="color:#a94442;">*</span></label>

                                          <div class="col-sm-10">
                                            <select class="form-control" name="image_type" id="image_type" style="width:70%" onchange="chk_img_type(null)">
                                              <!-- <option value="">Select</option> -->
                                              <option disabled value="" selected> Select </option>
                                              <option value="minor" <?= $ear_chapter_detail[0]['image_type'] == 'minor'?'selected':'' ?>>Minor</option>
                                              <option value="major" <?= $ear_chapter_detail[0]['image_type'] == 'major'?'selected':'' ?>>Major</option>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                <?php    
                                  // } 
                                ?>
                                
                                <div id="audio_list" style="display: none;">
                                  <div style="border: 2px solid #f0f0f0;margin: 15px;">
                                    <h3 style="text-align: center;">1st audio playing in exercise</h3>
                                    <div class="row" style="margin-bottom: 15px">
                                      <div class="col-sm-12">
                                        <div class="col-sm-12" id="all_ear_training" style="display: none;">
                                          <button type="button" class="btn btn-secondary" style="width: 100%;font-size: 20px;pointer-events: none">All notes up and down</button>
                                          <div class="row" style="margin-top: 15px">
                                            <div class="col-sm-12">
                                              <div class="col-sm-3">
                                                <input type="file" class="all_ear_type_audio" id="all_slow" style="display:none;" class="audio_required" /> 
                                                <input type="button" class="btn btn-secondary" onClick="all_slow.click();" value="Slow" style="width: 100%;"/>
                                                <span id="all_slow_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[0]['audio'], 10, ' ') ; ?></span>
                                                <input type="hidden" class="edit_all_old_audio" id="all_slow_old_audio" value="<?php echo $ear_chapter_detail[0]['audio']; ?>">
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="all_ear_type_audio" id="all_medium" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="all_medium.click();" value="Medium" style="width: 100%;"/>
                                                <span id="all_medium_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[1]['audio'], 10, ' ') ; ?></span>
                                                <input type="hidden" class="edit_all_old_audio" id="all_medium_old_audio" value="<?php echo $ear_chapter_detail[1]['audio']; ?>">
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="all_ear_type_audio" id="all_fast" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="all_fast.click();" value="Fast" style="width: 100%;"/>
                                                <span id="all_fast_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[2]['audio'], 10, ' ') ; ?></span>
                                                <input type="hidden" class="edit_all_old_audio" id="all_fast_old_audio" value="<?php echo $ear_chapter_detail[2]['audio']; ?>">
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="all_ear_type_audio" id="all_extreme" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="all_extreme.click();" value="Extreme" style="width: 100%;"/>
                                                <span id="all_extreme_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[3]['audio'], 10, ' ') ; ?></span>
                                                <input type="hidden" class="edit_all_old_audio" id="all_extreme_old_audio" value="<?php echo $ear_chapter_detail[3]['audio']; ?>">
                                              </div>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="col-sm-12" id="four__ear_training" style="display: none;">
                                          <button type="button" class="btn btn-secondary" style="width: 100%;font-size: 20px;pointer-events: none">4 chords (1,5,6,4)</button>
                                          <div class="row" style="margin-top: 15px">
                                            <div class="col-sm-12">
                                              <div class="col-sm-3">
                                                <input type="file" class="four_ear_type_audio" id="four_slow" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="four_slow.click();" value="Slow" style="width: 100%;"/>
                                                <span id="four_slow_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[0]['audio'], 10, ' ') ; ?></span>
                                                <input type="hidden" class="edit_four_old_audio" id="four_slow_old_audio" value="<?php echo $ear_chapter_detail[0]['audio']; ?>">
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="four_ear_type_audio" id="four_medium" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="four_medium.click();" value="Medium" style="width: 100%;"/>
                                                <span id="four_medium_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[1]['audio'], 10, ' ') ; ?></span>
                                                <input type="hidden" class="edit_four_old_audio" id="four_medium_old_audio" value="<?php echo $ear_chapter_detail[1]['audio']; ?>">
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="four_ear_type_audio" id="four_fast" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="four_fast.click();" value="Fast" style="width: 100%;"/>
                                                <span id="four_fast_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[2]['audio'], 10, ' ') ; ?></span>
                                                <input type="hidden" class="edit_four_old_audio" id="four_fast_old_audio" value="<?php echo $ear_chapter_detail[2]['audio']; ?>">
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="four_ear_type_audio" id="four_extreme" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="four_extreme.click();" value="Extreme" style="width: 100%;"/>
                                                <span id="four_extreme_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[3]['audio'], 10, ' ') ; ?></span>
                                                <input type="hidden" class="edit_four_old_audio" id="four_extreme_old_audio" value="<?php echo $ear_chapter_detail[3]['audio']; ?>">
                                              </div>
                                            </div>
                                          </div>                                        
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div style="border: 2px solid #f0f0f0;margin: 15px;">
                                    <h3 style="text-align: center;">2nd audio playing in exercise1</h3>
                                    <!-- Major row -->
                                    <div class="row" id="major" style="margin-bottom: 15px; display: none;">
                                      <div class="col-sm-12" style="margin-left: 10%;">
                                        <div class="col-sm-1">
                                          <input type="file" id="five_point_five_minus_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="five_point_five_minus_major.click();" value="5.5-" style="width: 100%;"/>
                                          <span id="five_point_five_minus_major_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[4]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" class="edit_major_audio_file" id="five_point_five_minus_major_old_audio" value="<?php echo $ear_chapter_detail[4]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="six_point_five_minus_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six_point_five_minus_major.click();" value="6.5-" style="width: 100%;"/>
                                          <span id="six_point_five_minus_major_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[5]['audio'], 10, ' ') ;?></span>
                                          <input type="hidden" class="edit_major_audio_file" id="six_point_five_minus_major_old_audio" value="<?php echo $ear_chapter_detail[5]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="one_point_five_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one_point_five_major.click();" value="1.5" style="width: 100%;"/>
                                          <span id="one_point_five_major_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[6]['audio'], 10, ' ') ;?></span>
                                          <input type="hidden" class="edit_major_audio_file" id="one_point_five_major_old_audio" value="<?php echo $ear_chapter_detail[6]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="two_point_five_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="two_point_five_major.click();" value="2.5" style="width: 100%;"/>
                                          <span id="two_point_five_major_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[7]['audio'], 10, ' ') ;?></span>
                                          <input type="hidden" class="edit_major_audio_file" id="two_point_five_major_old_audio" value="<?php echo $ear_chapter_detail[7]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="four_point_five_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="four_point_five_major.click();" value="4.5" style="width: 100%;"/>
                                          <span id="four_point_five_major_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[8]['audio'], 10, ' ') ;?></span>
                                          <input type="hidden" class="edit_major_audio_file" id="four_point_five_major_old_audio" value="<?php echo $ear_chapter_detail[8]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="five_point_five_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="five_point_five_major.click();" value="5.5" style="width: 100%;"/>
                                          <span id="five_point_five_major_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[9]['audio'], 10, ' ') ;?></span>
                                          <input type="hidden" class="edit_major_audio_file" id="five_point_five_major_old_audio" value="<?php echo $ear_chapter_detail[9]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="six_point_five_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six_point_five_major.click();" value="6.5" style="width: 100%;"/>
                                          <span id="six_point_five_major_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[10]['audio'], 10, ' ') ;?></span>
                                          <input type="hidden" class="edit_major_audio_file" id="six_point_five_major_old_audio" value="<?php echo $ear_chapter_detail[10]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="one_point_five_plus_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one_point_five_plus_major.click();" value="1.5+" style="width: 100%;"/>
                                          <span id="one_point_five_plus_major_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[11]['audio'], 10, ' ') ;?></span>
                                          <input type="hidden" class="edit_major_audio_file" id="one_point_five_plus_major_old_audio" value="<?php echo $ear_chapter_detail[11]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="two_point_five_plus_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="two_point_five_plus_major.click();" value="2.5+" style="width: 100%;"/>
                                          <span id="two_point_five_plus_major_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[12]['audio'], 10, ' ') ;?></span>
                                          <input type="hidden" class="edit_major_audio_file" id="two_point_five_plus_major_old_audio" value="<?php echo $ear_chapter_detail[12]['audio']; ?>">
                                        </div>
                                      </div>
                                    </div>
                                    <!-- Major End -->
                                    <!-- Minor Row -->
                                    <div class="row" id="minor" style="margin-bottom: 15px; display: none;">
                                      <div class="col-sm-12" style="margin-left: 10%;">
                                        <div class="col-sm-1">
                                          <input type="file" id="six_point_five_minus_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six_point_five_minus_minor.click();" value="6.5-" style="width: 100%;"/>
                                          <span id="six_point_five_minus_minor_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[4]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" class="edit_minor_audio_file" id="six_point_five_minus_minor_old_audio" value="<?php echo $ear_chapter_detail[4]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="seven_point_five_minus_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="seven_point_five_minus_minor.click();" value="7.5-" style="width: 100%;"/>
                                          <span id="seven_point_five_minus_minor_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[5]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" class="edit_minor_audio_file" id="seven_point_five_minus_minor_old_audio" value="<?php echo $ear_chapter_detail[5]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="one_point_five_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one_point_five_minor.click();" value="1.5" style="width: 100%;"/>
                                          <span id="one_point_five_minor_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[6]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" class="edit_minor_audio_file" id="one_point_five_minor_old_audio" value="<?php echo $ear_chapter_detail[6]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="three_point_five_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="three_point_five_minor.click();" value="3.5" style="width: 100%;"/>
                                          <span id="three_point_five_minor_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[7]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" class="edit_minor_audio_file" id="three_point_five_minor_old_audio" value="<?php echo $ear_chapter_detail[7]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="four_point_five_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="four_point_five_minor.click();" value="4.5" style="width: 100%;"/>
                                          <span id="four_point_five_minor_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[8]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" class="edit_minor_audio_file" id="four_point_five_minor_old_audio" value="<?php echo $ear_chapter_detail[8]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="six_point_five_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six_point_five_minor.click();" value="6.5" style="width: 100%;"/>
                                          <span id="six_point_five_minor_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[9]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" class="edit_minor_audio_file" id="six_point_five_minor_old_audio" value="<?php echo $ear_chapter_detail[9]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="seven_point_five_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="seven_point_five_minor.click();" value="7.5" style="width: 100%;"/>
                                          <span id="seven_point_five_minor_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[10]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" class="edit_minor_audio_file" id="seven_point_five_minor_old_audio" value="<?php echo $ear_chapter_detail[10]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="one_point_five_plus_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one_point_five_plus_minor.click();" value="1.5+" style="width: 100%;"/>
                                          <span id="one_point_five_plus_minor_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[11]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" class="edit_minor_audio_file" id="one_point_five_plus_minor_old_audio" value="<?php echo $ear_chapter_detail[11]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="three_point_five_plus_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="three_point_five_plus_minor.click();" value="3.5+" style="width: 100%;"/>
                                          <span id="three_point_five_plus_minor_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[12]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" class="edit_minor_audio_file" id="three_point_five_plus_minor_old_audio" value="<?php echo $ear_chapter_detail[12]['audio']; ?>">
                                        </div>
                                      </div>
                                    </div>
                                    <!-- Minor End -->
                                    <div class="row" style="margin-bottom: 15px">
                                      <div class="col-sm-12" style="margin-left: 1%;">
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="five_minus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="five_minus.click();" value="5-" style="width:100%;"/>
                                          <span id="five_minus_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[13]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="five_minus_old_audio" value="<?php echo $ear_chapter_detail[13]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="six_minus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six_minus.click();" value="6-" style="width:100%;"/>
                                          <span id="six_minus_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[14]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="six_minus_old_audio" value="<?php echo $ear_chapter_detail[14]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="seven_minus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="seven_minus.click();" value="7-" style="width:100%;"/>
                                          <span id="seven_minus_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[15]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="seven_minus_old_audio" value="<?php echo $ear_chapter_detail[15]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="one" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one.click();" value="1" style="width:100%;"/>
                                          <span id="one_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[16]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="one_old_audio" value="<?php echo $ear_chapter_detail[16]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="two" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="two.click();" value="2" style="width:100%;"/>
                                          <span id="two_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[17]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="two_old_audio" value="<?php echo $ear_chapter_detail[17]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="three" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="three.click();" value="3" style="width:100%;"/>
                                          <span id="three_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[18]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="three_old_audio" value="<?php echo $ear_chapter_detail[18]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="four" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="four.click();" value="4" style="width:100%;"/>
                                          <span id="four_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[19]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="four_old_audio" value="<?php echo $ear_chapter_detail[19]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="five" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="five.click();" value="5" style="width:100%;"/>
                                          <span id="five_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[20]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="five_old_audio" value="<?php echo $ear_chapter_detail[20]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="six" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six.click();" value="6" style="width:100%;"/>
                                          <span id="six_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[21]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="six_old_audio" value="<?php echo $ear_chapter_detail[21]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="seven" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="seven.click();" value="7" style="width:100%;"/>
                                          <span id="seven_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[22]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="seven_old_audio" value="<?php echo $ear_chapter_detail[22]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="one_plus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one_plus.click();" value="1+" style="width:100%;"/>
                                          <span id="one_plus_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[23]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="one_plus_old_audio" value="<?php echo $ear_chapter_detail[23]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="two_plus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="two_plus.click();" value="2+" style="width:100%;"/>
                                          <span id="two_plus_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[24]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="two_plus_old_audio" value="<?php echo $ear_chapter_detail[24]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="three_plus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="three_plus.click();" value="3+" style="width:100%;"/>
                                          <span id="three_plus_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[25]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="three_plus_old_audio" value="<?php echo $ear_chapter_detail[25]['audio']; ?>">
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="four_plus" style="display:none;" class="audio_required"/>    
                                          <input type="button" class="btn btn-secondary" onClick="four_plus.click();" value="4+" style="width:100%;"/>
                                          <span id="four_plus_filename" onclick="manage_add_edit_audio_Files(this)" style="cursor: pointer;"><?php echo chunk_split($ear_chapter_detail[26]['audio'], 10, ' ') ; ?></span>
                                          <input type="hidden" name="old_audio[]" id="four_plus_old_audio" value="<?php echo $ear_chapter_detail[26]['audio']; ?>">
                                        </div>
                                        
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <audio controls id="play_edit_audio">
                                  <source src="" id="play_edit_audio_source" type="audio/mpeg">
                                </audio>
                              </div>
                          <!-- End Edit Ear training  -->
                        <?php 
                          }else{ 
                        ?> 
                        <!-- Add Ear training  -->
                            <div id="ear_sec_1" class="addpianospace draggable1"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <div class="row">
                                  <div class="col-sm-12">
                                    <!-- <div class="col-sm-4">
                                      <input type="text" placeholder="Letter Name"
                                      value="" class="form-control" name="letter_name" id="letter_name"/>
                                    </div> -->

                                    <!-- <div class="col-sm-4" style="width: 20%;"> -->
                                    <div class="col-sm-4">
                                      <input type="file" name="letter_image"  id="letter_image">
                                      <input type="hidden" name="check_value" id="check_value" value="">
                                    </div>
                                    
                                    <div class="col-md-2">
                                      <img src="" class="img-thumbnail"
                                        style="display: none;margin-top: 10px;height: 100px;width: 150px;" />
                                    </div>

                                    <!-- <div class="col-md-2" style="width: 30%;"> -->
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Type<span class="text-primary"
                                            style="color:#a94442;">*</span></label>

                                        <div class="col-sm-10">
                                          <select class="form-control" name="image_type" id="image_type" style="width:70%" onchange="chk_img_type(null)">
                                            <option disabled value="" selected> Select </option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div id="audio_list" style="display: none;">
                                  <div style="border: 2px solid #f0f0f0;margin: 15px;">
                                    <h3 style="text-align: center;">1st audio playing in exercise</h3>
                                    <div class="row" style="margin-bottom: 15px">
                                      <div class="col-sm-12">
                                        <div class="col-sm-12" id="all_ear_training" style="display: none;">
                                          <button type="button" class="btn btn-secondary" style="width: 100%;font-size: 20px;pointer-events: none">All notes up and down</button>
                                          <div class="row" style="margin-top: 15px">
                                            <div class="col-sm-12">
                                              <div class="col-sm-3">
                                                <input type="file" class="all_ear_type_audio" id="all_slow" style="display:none;" class="audio_required" /> 
                                                <input type="button" class="btn btn-secondary" onClick="all_slow.click();" value="Slow" style="width: 100%;"/>
                                                <span id="all_slow_filename"></span>
                                                <!-- <input type="hidden" name="old_audio[]" id="all_slow_old_audio" value=""> -->
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="all_ear_type_audio" id="all_medium" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="all_medium.click();" value="Medium" style="width: 100%;"/>
                                                <span id="all_medium_filename"></span>
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="all_ear_type_audio" id="all_fast" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="all_fast.click();" value="Fast" style="width: 100%;"/>
                                                <span id="all_fast_filename"></span>
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="all_ear_type_audio" id="all_extreme" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="all_extreme.click();" value="Extreme" style="width: 100%;"/>
                                                <span id="all_extreme_filename"></span>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-12" id="four__ear_training" style="display: none;">
                                          <button type="button" class="btn btn-secondary" style="width: 100%;font-size: 20px;pointer-events: none">4 chords (1,5,6,4)</button>
                                          <div class="row" style="margin-top: 15px">
                                            <div class="col-sm-12">
                                              <div class="col-sm-3">
                                                <input type="file" class="four_ear_type_audio" id="four_slow" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="four_slow.click();" value="Slow" style="width: 100%;"/>
                                                <span id="four_slow_filename"></span>
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="four_ear_type_audio" id="four_medium" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="four_medium.click();" value="Medium" style="width: 100%;"/>
                                                <span id="four_medium_filename"></span>
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="four_ear_type_audio" id="four_fast" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="four_fast.click();" value="Fast" style="width: 100%;"/>
                                                <span id="four_fast_filename"></span>
                                              </div>
                                              <div class="col-sm-3">
                                                <input type="file" class="four_ear_type_audio" id="four_extreme" style="display:none;" class="audio_required"/> 
                                                <input type="button" class="btn btn-secondary" onClick="four_extreme.click();" value="Extreme" style="width: 100%;"/>
                                                <span id="four_extreme_filename"></span>
                                              </div>
                                            </div>
                                          </div>                                        
                                        </div>
                                      </div>
                                    </div>
                                  </div>

                                  <div style="border: 2px solid #f0f0f0;margin: 15px;">
                                    <h3 style="text-align: center;">2nd audio playing in exercise2</h3>
                                    <!-- Major row -->
                                    <div class="row" id="major" style="margin-bottom: 15px; display: none;">
                                      <div class="col-sm-12" style="margin-left: 10%;">
                                        <div class="col-sm-1">
                                          <input type="file" id="five_point_five_minus_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="five_point_five_minus_major.click();" value="5.5-" style="width: 100%;"/>
                                          <span id="five_point_five_minus_major_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="six_point_five_minus_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six_point_five_minus_major.click();" value="6.5-" style="width: 100%;"/>
                                          <span id="six_point_five_minus_major_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="one_point_five_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one_point_five_major.click();" value="1.5" style="width: 100%;"/>
                                          <span id="one_point_five_major_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="two_point_five_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="two_point_five_major.click();" value="2.5" style="width: 100%;"/>
                                          <span id="two_point_five_major_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="four_point_five_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="four_point_five_major.click();" value="4.5" style="width: 100%;"/>
                                          <span id="four_point_five_major_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="five_point_five_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="five_point_five_major.click();" value="5.5" style="width: 100%;"/>
                                          <span id="five_point_five_major_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="six_point_five_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six_point_five_major.click();" value="6.5" style="width: 100%;"/>
                                          <span id="six_point_five_major_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="one_point_five_plus_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one_point_five_plus_major.click();" value="1.5+" style="width: 100%;"/>
                                          <span id="one_point_five_plus_major_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file" id="two_point_five_plus_major" style="display:none;" class="major_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="two_point_five_plus_major.click();" value="2.5+" style="width: 100%;"/>
                                          <span id="two_point_five_plus_major_filename"></span>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- Minor Row -->
                                    <div class="row" id="minor" style="margin-bottom: 15px; display: none;">
                                      <div class="col-sm-12" style="margin-left: 10%;">
                                        <div class="col-sm-1">
                                          <input type="file"  id="six_point_five_minus_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six_point_five_minus_minor.click();" value="6.5-" style="width: 100%;"/>
                                          <span id="six_point_five_minus_minor_filename" ></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file"  id="seven_point_five_minus_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="seven_point_five_minus_minor.click();" value="7.5-" style="width: 100%;"/>
                                          <span id="seven_point_five_minus_minor_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file"  id="one_point_five_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one_point_five_minor.click();" value="1.5" style="width: 100%;"/>
                                          <span id="one_point_five_minor_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file"  id="three_point_five_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="three_point_five_minor.click();" value="3.5" style="width: 100%;"/>
                                          <span id="three_point_five_minor_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file"  id="four_point_five_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="four_point_five_minor.click();" value="4.5" style="width: 100%;"/>
                                          <span id="four_point_five_minor_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file"  id="six_point_five_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six_point_five_minor.click();" value="6.5" style="width: 100%;"/>
                                          <span id="six_point_five_minor_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file"  id="seven_point_five_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="seven_point_five_minor.click();" value="7.5" style="width: 100%;"/>
                                          <span id="seven_point_five_minor_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file"  id="one_point_five_plus_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one_point_five_plus_minor.click();" value="1.5+" style="width: 100%;"/>
                                          <span id="one_point_five_plus_minor_filename"></span>
                                        </div>
                                        <div class="col-sm-1">
                                          <input type="file"  id="three_point_five_plus_minor" style="display:none;" class="minor_audio_file"/> 
                                          <input type="button" class="btn btn-secondary" onClick="three_point_five_plus_minor.click();" value="3.5+" style="width: 100%;"/>
                                          <span id="three_point_five_plus_minor_filename"></span>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="row" style="margin-bottom: 15px">
                                      <div class="col-sm-12" style="margin-left: 1%;">
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="five_minus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="five_minus.click();" value="5-" style="width:100%;"/>
                                          <span id="five_minus_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="six_minus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six_minus.click();" value="6-" style="width:100%;"/>
                                          <span id="six_minus_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="seven_minus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="seven_minus.click();" value="7-" style="width:100%;"/>
                                          <span id="seven_minus_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="one" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one.click();" value="1" style="width:100%;"/>
                                          <span id="one_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="two" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="two.click();" value="2" style="width:100%;"/>
                                          <span id="two_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="three" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="three.click();" value="3" style="width:100%;"/>
                                          <span id="three_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="four" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="four.click();" value="4" style="width:100%;"/>
                                          <span id="four_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="five" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="five.click();" value="5" style="width:100%;"/>
                                          <span id="five_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="six" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="six.click();" value="6" style="width:100%;"/>
                                          <span id="six_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="seven" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="seven.click();" value="7" style="width:100%;"/>
                                          <span id="seven_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="one_plus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="one_plus.click();" value="1+" style="width:100%;"/>
                                          <span id="one_plus_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="two_plus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="two_plus.click();" value="2+" style="width:100%;"/>
                                          <span id="two_plus_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="three_plus" style="display:none;" class="audio_required"/> 
                                          <input type="button" class="btn btn-secondary" onClick="three_plus.click();" value="3+" style="width:100%;"/>
                                          <span id="three_plus_filename"></span>
                                        </div>
                                        <div class="col-sm-1" style="width: 7%;">
                                          <input type="file" name="audio[]" id="four_plus" style="display:none;" class="audio_required"/>    
                                          <input type="button" class="btn btn-secondary" onClick="four_plus.click();" value="4+" style="width:100%;"/>
                                          <span id="four_plus_filename"></span>
                                        </div>
                                        
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- <audio controls id="play_add_audio">
                                  <source src="" id="play_add_audio_source" type="audio/mpeg">
                                </audio> -->
                            </div>
                          <!-- End add Ear training  -->
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <!-- </div> -->
                  <!--End Ear chapter -->

                  <!--Start Recognizing chapter -->
                  <div class="form-group" id="recognizing_chapter" <?php if ($this->uri->segment('2') == "editChapter") {?> style="display: block;" <?php } else {?> style="display: none;" <?php } ?>>
                    <div class="panel-body">
                      <div class="section droppable" id="section_html">
                        <?php
                          if ($this->uri->segment('2') == "editChapter" && $is_recognizing == 1) { 
                        ?> 
                          <!-- Start Edit Recognizing training  -->
                          <div id="recognizing_sec_1" class="addpianospace draggable1"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <?php
                                  for ($i = 0; $i < 24; $i+=2) {
                                    $j=$i+1; 
                                ?>
                                <div class="row">
                                  <div class="col-sm-12" style="display: flex;">
                                    <div class="col-sm-6" style="border: 2px solid #f0f0f0;margin: 15px;width: 50%">
                                      <div class="row" style="margin-top: 15px;">
                                        <div class="col-sm-12">
                                          <div class="col-sm-3">
                                            <div class="col-sm-10">
                                              <input type="text" placeholder="Letter Name" value="<?php echo $recognizing_detail[$i]['letter_name'];?>" class="form-control reco_letter_name" name="reco_letter_name[]" id="reco_letter_name_1" />
                                            </div>
                                          </div>

                                          <div class="col-md-3">
                                            <div class="form-group">
                                              <div class="col-sm-10">
                                                <select class="form-control reco_audio_type" name="audio_type[]" id="audio_type">
                                                  <option disabled value="" selected> Select </option>
                                                  <option value="minor" <?= $recognizing_detail[$i]['audio_type'] == 'minor' ? 'selected' : '' ?>>Minor</option>
                                                  <option value="major" <?= $recognizing_detail[$i]['audio_type'] == 'major' ? 'selected' : '' ?>>Major</option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          
                                          <div class="col-md-3">
                                            <div class="form-group">
                                              <input type="file" name="reco_audio_file[]" id="reco_audio_file">
                                            </div>
                                            <input type="hidden" name="old_reco_audio_file[]" id="old_reco_audio_file" value="<?php echo $recognizing_detail[$i]['audio'];?>">
                                          </div>
                                          <div class="col-md-2">
                                            <span class="reco_audio_file" onclick="manage_reco_audio_Files('<?php echo $recognizing_detail[$i]['audio'];?>')" style="cursor: pointer;"><?php echo $recognizing_detail[$i]['audio'];?></span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6" style="border: 2px solid #f0f0f0;margin: 15px;width: 50%">
                                      <div class="row" style="margin-top: 15px;">
                                        <div class="col-sm-12">
                                          <div class="col-sm-3">
                                            <div class="col-sm-10">
                                              <input type="text" placeholder="Letter Name" value="<?php echo $recognizing_detail[$j]['letter_name']; ?>" class="form-control reco_letter_name" name="reco_letter_name[]" id="reco_letter_name[]" />
                                            </div>
                                          </div>

                                          <div class="col-md-3">
                                            <div class="form-group">
                                              <div class="col-sm-10">
                                                <select class="form-control reco_audio_type" name="audio_type[]" id="audio_type[]" >
                                                  <option disabled value="" selected> Select </option>
                                                  <option value="minor" <?= $recognizing_detail[$j]['audio_type'] == 'minor'?'selected':'' ?>>Minor</option>
                                                  <option value="major" <?= $recognizing_detail[$j]['audio_type'] == 'major'?'selected':'' ?>>Major</option>
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                          
                                          <div class="col-md-3">
                                            <div class="form-group">
                                              <input type="file" name="reco_audio_file[]" id="reco_audio_file" >
                                            </div>
                                            <input type="hidden" name="old_reco_audio_file[]" id="old_reco_audio_file" value="<?php echo $recognizing_detail[$j]['audio'];?>">
                                          </div>
                                          <div class="col-md-2">
                                            <span class="reco_audio_file" onclick="manage_reco_audio_Files('<?php echo $recognizing_detail[$j]['audio'];?>')" style="cursor: pointer;"><?php echo $recognizing_detail[$j]['audio'];?></span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <?php  }
                                ?>
                                <audio controls id="play_reco_edit_audio">
                                  <source src="" id="play_reco_edit_audio_source" type="audio/mpeg">
                                </audio>
                          </div>
                          <!-- End Edit Recognizing training  -->
                        <?php 
                          }else{ 
                        ?> 
                        <!-- Start Add Recognizing training  -->
                            <div id="recognizing_sec_1" class="addpianospace draggable1"
                                style="border: 2px solid #000000;padding: 30px;margin: 15px;">
                                <div class="row">
                                  <div class="col-sm-12" style="display: flex;">
                                      <div class="col-sm-6" style="border: 2px solid #f0f0f0;margin: 15px;width: 50%;">
                                        <div class="row" style="margin-top: 15px;">
                                          <div class="col-sm-12">
                                            <div class="col-sm-4">
                                              <div class="col-sm-10">
                                                <input type="text" placeholder="Letter Name" value="" class="form-control reco_letter_name" name="reco_letter_name[]" id="reco_letter_name" />
                                              </div>
                                            </div>

                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <!-- <label for="title" class="col-sm-2 control-label">Type<span class="text-primary"
                                                    style="color:#a94442;">*</span></label> -->

                                                <div class="col-sm-10">
                                                  <select class="form-control reco_audio_type" name="audio_type[]" id="audio_type" style="width:70%">
                                                    <option disabled value="" selected> Select </option>
                                                    <option value="minor">Minor</option>
                                                    <option value="major">Major</option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <input type="file" name="reco_audio_file[]" id="reco_audio_file" class="reco_audio_file">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-sm-6" style="border: 2px solid #f0f0f0;margin: 15px;width: 50%;">
                                        <div class="row" style="margin-top: 15px;">
                                          <div class="col-sm-12">
                                            <div class="col-sm-4">
                                              <div class="col-sm-10">
                                                <input type="text" placeholder="Letter Name" value="" class="form-control reco_letter_name" name="reco_letter_name[]" id="reco_letter_name[]" />
                                              </div>
                                            </div>

                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <div class="col-sm-10">
                                                  <select class="form-control reco_audio_type" name="audio_type[]" id="audio_type[]" style="width:70%">
                                                    <option disabled value="" selected> Select </option>
                                                    <option value="minor">Minor</option>
                                                    <option value="major">Major</option>
                                                  </select>
                                                </div>
                                              </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                              <div class="form-group">
                                                <input type="file" name="reco_audio_file[]" id="reco_audio_file" class="reco_audio_file">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                <div id="container1">
                                </div>
                            </div>
                        <!-- End add Recognizing training  -->
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <!--End Recognizing chapter -->

                  <input type="submit" name="submit" class="btn btn-sm btn-primary"/>
                  <button type="button" name="cancel" class="btn btn-sm btn-primary"
                    onClick="window.location.href='<?= base_url() . 'Chapter' ?>'">Cancel</button>
              </form>

                

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
  // var video = document.querySelector('#video1');
  // var canvas = document.querySelector('#canvas1');
  // var context = canvas.getContext('2d');
  // var w, h, ratio;

  // video.addEventListener('loadedmetadata', function() {
  //   // console.log(videow.value,"Metadata loaded");
  //   video.videoWidth = 150;

  //   video.objectURL = false;
  //   video.play();
  //   video.pause();
  //   resize();
  // }, false);

  // function resize() {
  //   ratio = video.videoWidth / video.videoHeight;
  //   w = 250;
  //   h = parseInt(w / ratio, 10);
  //   canvas.width = w;
  //   canvas.height = h;
  // }

  // function snapPicture() {

  //   context.fillRect(0, 0, w, h);
  //   context.drawImage(video, 0, 0, w, h);

  //   setTimeout(() => {
  //     var canvas1 = document.querySelector('#canvas1');
  //     var jpegUrl = canvas1.toDataURL("image/jpeg");
  //     var pngUrl = canvas1.toDataURL();
  //     console.log(jpegUrl);
  //   }, 2000);

  // }

  function manage_add_edit_audio_Files(object) {
    
    alert("Audio loaded successfully... You can play audio now")

    // var chapter_url = 'http://18.235.99.234/piano_test/APIs/uploads/chapter/'; //Live 
    var chapter_url = 'http://localhost/piano_admin/upload/chapter/'; //Local
    
    var span = document.getElementById(object.id).innerText;
    var new_span = chapter_url + span.replace(/ +/g, "");
      $("#play_edit_audio_source").attr('src', new_span);
      document.getElementById("play_edit_audio").load();
    
  }

  function manage_reco_audio_Files(value) {
    alert("Audio loaded successfully... You can play audio now")

    // var chapter_url = 'http://18.235.99.234/piano_test/APIs/uploads/chapter/'; //Live 
    var chapter_url = 'http://localhost/piano_admin/upload/chapter/'; //Local

    var new_span = chapter_url + value;
      $("#play_reco_edit_audio_source").attr('src', new_span);
      document.getElementById("play_reco_edit_audio").load();
  }

  function chk_img_type(type) {
    if(type != null){
      var chk_img = type;
      // console.log(chk_img);
    }else{
      var img_type = document.getElementById("image_type");
      var chk_img = img_type.value;
      // console.log(chk_img);
    }
    
    document.getElementById('audio_list').style.display = "block";

    if(chk_img == 'minor'){
      document.getElementById('minor').style.display = "block";
      $('.minor_audio_file').attr('name', 'audio[]');
      $('.edit_minor_audio_file').attr('name', 'old_audio[]');
      document.getElementById('major').style.display = "none";  
      $(".major_audio_file").removeAttr('name');   
      $(".edit_major_audio_file").removeAttr('name');   
    }else{
      document.getElementById('major').style.display = "block";
      $('.major_audio_file').attr('name', 'audio[]');
      $('.edit_major_audio_file').attr('name', 'old_audio[]');
      document.getElementById('minor').style.display = "none";
      $(".minor_audio_file").removeAttr('name');
      $(".edit_minor_audio_file").removeAttr('name');
    }
  }

  function check_chapter(lession_id) {

    if(lession_id == 0){
      var lession = document.getElementById("lession_id");
      var lession_id = lession.options[lession.selectedIndex].value;
    }else{
      var lession_id = lession_id;
    }
    
    // alert(lession_id)
    $.ajax({
      type: "GET",
      url: '<?= base_url() ?>Chapter/ear_chapter_view/' + lession_id,
      data: {},
      cache: false,
      'Content-Type': "application/json",
      success: function (data) {
        var result = (JSON.parse(data));
        var normal_chapter_title = document.getElementById("normal_chapter_title");
        var ear_chapter_letter_name = document.getElementById("ear_chapter_letter_name");
        var ear_chapter_form = document.getElementById("ear_chapter");
        var normal_chapter_form = document.getElementById("normal_chapter");
        var recognizing_chapter_form = document.getElementById("recognizing_chapter");

        if (result.ear_training == 1) {
          if(result.ear_training_type == 'all'){
            $("#all_ear_training").show();
            $("#four__ear_training").hide();
            $('.all_ear_type_audio').attr('name', 'audio[]');
            $(".four_ear_type_audio").removeAttr('name');
            $('.edit_all_old_audio').attr('name', 'old_audio[]');
            $(".edit_four_old_audio").removeAttr('name');
          }else if(result.ear_training_type == 'four'){
            $("#four__ear_training").show();
            $("#all_ear_training").hide();
            $('.four_ear_type_audio').attr('name', 'audio[]');
            $(".all_ear_type_audio").removeAttr('name');
            $('.edit_four_old_audio').attr('name', 'old_audio[]');
            $(".edit_all_old_audio").removeAttr('name');
          }
          $("#is_ear_training_type").val(result.ear_training_type);
          ear_chapter_letter_name.style.display = "block";
          ear_chapter_form.style.display = "block";
          normal_chapter_form.style.display = "none";
          normal_chapter_title.style.display = "none";
          recognizing_chapter_form.style.display = "none";
          document.getElementById("is_ear_chapter").value = "1";
          document.getElementById("is_recognizing").value = "0";
          document.getElementById("letter_name").required = true;
          document.getElementById("image_type").required = true;      
          document.getElementById("title").required = false; 
          $(".reco_letter_name").removeAttr("required");   
          $(".reco_audio_type").removeAttr("required");   
          $(".reco_audio_file").removeAttr("required");   
            
        }else if (result.recognizing == 1) {
          normal_chapter_title.style.display = "block";
          ear_chapter_letter_name.style.display = "none";    
          ear_chapter_form.style.display = "none";
          normal_chapter_form.style.display = "none";
          recognizing_chapter_form.style.display = "block";
          document.getElementById("is_ear_chapter").value = "0";
          document.getElementById("is_recognizing").value = "1";
          document.getElementById("letter_name").required = false;
          document.getElementById("image_type").required = false;
          document.getElementById("title").required = true;
          $(".reco_letter_name").attr("required", "true");
          $(".reco_audio_type").attr("required", "true");
          $(".reco_audio_file").attr("required", "true");
        } else{
          ear_chapter_form.style.display = "none";
          ear_chapter_letter_name.style.display = "none";
          normal_chapter_form.style.display = "block";
          normal_chapter_title.style.display = "block";
          recognizing_chapter_form.style.display = "none";
          document.getElementById("is_ear_chapter").value = "0";
          document.getElementById("is_recognizing").value = "0";
          document.getElementById("letter_name").required = false;
          document.getElementById("image_type").required = false;
          document.getElementById("title").required = true;
          $(".reco_letter_name").removeAttr("required");   
          $(".reco_audio_type").removeAttr("required");   
          $(".reco_audio_file").removeAttr("required");   
        }
      }
    });
  }

  $("#letter_image").change(function() {
    var fileName = $(this).val().split(/\\/).pop();
    var fileExt = fileName.split('.').pop().toLowerCase();
    var fileInput = this.files[0];

    var image_ext = ['gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm'];
    // var video_ext = ['mp4', 'mp3', 'mov', 'm4v', 'avi'];

    if (image_ext.includes(fileExt)) {
      var sec = $(this).attr('id');
      var reader = new FileReader();

      reader.onloadend = function () {
        imagebase64 = reader.result;
        $(`#ear_sec_1 img`).attr('src', imagebase64);
        $(`#ear_sec_1 img`).show();
      }

      reader.readAsDataURL(fileInput);
    }
  });

  

  $(document).delegate(':file', 'change', function () {

    var fileName = $(this).val().split(/\\/).pop();
    // alert(fileName)
    var fileExt = fileName.split('.').pop().toLowerCase();
    var fileInput = this.files[0];    
    var is_ear_chapter = document.getElementById("is_ear_chapter").value;
    // alert(is_ear_chapter)


    var image_ext = ['gif', 'jpeg', 'svg', 'png', 'jpg', 'bmp', 'webm'];
    var audio_video_ext = ['mp4', 'mp3', 'mov', 'm4v', 'avi'];

    if (image_ext.includes(fileExt)) {
      var sec = $(this).attr('id');
      var reader = new FileReader();

      reader.onloadend = function () {
        imagebase64 = reader.result;
        // alert(imagebase64)
        $(`#sec_${sec} img`).attr('src', imagebase64);
        $(`#sec_${sec} img`).show();
      }

      reader.readAsDataURL(fileInput);

    } 

    if (is_ear_chapter == 1 && audio_video_ext.includes(fileExt)) {
      var btn_click = $(this).attr('id');
      // alert()
      
      let joy=fileName.match(/.{1,5}/g);
      var btn_filename = btn_click + "_filename";
      const span = document.getElementById(btn_filename);
      // span.textContent = fileName;
      span.textContent = joy.join(' ');
    }
  });

  /* 
    // var imagebase64 = "";

    // function encodeImageFileAsURL(element, sec) {
    //   var file = element.files[0];

    //   console.log(file.value.split('.')[1]);

    //   var reader = new FileReader();
    //   reader.onloadend = function() {
    //     imagebase64 = reader.result;
    //     console.log(imagebase64);
    //     $(`#${sec} img`).attr('src', imagebase64);
    //     $(`#${sec} img`).show();
    //   }
    //   reader.readAsDataURL(file);
    // }
  */


  $(document).ready(function () {
    $(".droppable").sortable({
      update: function (event, ui) {

        Dropped(event, ui);
        console.log(event);
        console.log(ui);
      }
    }); 

    var getValue= $("input[name=metronome_at]").val();

    if (getValue == undefined) {
      $("#add_metronome").css("display","block");
    }else{
      $("#add_metronome").css("display","none");      
    }

    var getValue= $("input[name=question_at]").val();
    if (getValue == undefined) {
        $("#add_question").css("display","block");
    }else{
        $("#add_question").css("display","none");
    }

    var img_type = $("#image_type").val();

    if(img_type != null){
      chk_img_type(img_type);
    }

    var lession_id = $("#lession_id").val();

    if(lession_id != null){
      check_chapter(lession_id);
    }else{
      var htmlElements = "";

      for (var i = 0; i < 11; i++) {
        htmlElements += '<div class="row">';
        htmlElements += ' <div class="col-sm-12" style="display: flex;">';
        htmlElements += '   <div class="col-sm-6" style="border: 2px solid #f0f0f0;margin: 15px;">';
        htmlElements += '     <div class="row" style="margin-top: 15px;">';
        htmlElements += '	      <div class="col-sm-12">';
        htmlElements += '	        <div class="col-sm-4">';
        htmlElements += '		        <div class="col-sm-10">';
        htmlElements += '		          <input type="text" placeholder="Letter Name" value="" class="form-control reco_letter_name" name="reco_letter_name[]"  id="reco_letter_name[]"/>';
        htmlElements += '		        </div>';
        htmlElements += '	        </div>';
        htmlElements += '	        <div class="col-md-4">';
        htmlElements += '		        <div class="form-group">';
        htmlElements += '		          <div class="col-sm-10">';
        htmlElements += '			          <select class="form-control reco_audio_type" name="audio_type[]" id="audio_type[]" style="width:70%">';
        htmlElements += '			            <option disabled value="" selected> Select </option>';
        htmlElements += '			            <option value="minor">Minor</option>';
        htmlElements += '			            <option value="major">Major</option>';
        htmlElements += '			          </select>';
        htmlElements += '		          </div>';
        htmlElements += '		        </div>';
        htmlElements += '	        </div>';
        htmlElements += '	        <div class="col-md-4">';
        htmlElements += '		        <div class="form-group">';
        htmlElements += '		          <input type="file" name="reco_audio_file[]" id="reco_audio_file[]" class="reco_audio_file">';
        htmlElements += '		        </div>';
        htmlElements += '	        </div>';
        htmlElements += '	      </div>';
        htmlElements += '     </div>';
        htmlElements += '   </div>';
        htmlElements += '   <div class="col-sm-6" style="border: 2px solid #f0f0f0;margin: 15px;">';
        htmlElements += '     <div class="row" style="margin-top: 15px;">';
        htmlElements += '	      <div class="col-sm-12">';
        htmlElements += '	        <div class="col-sm-4">';
        htmlElements += '		        <div class="col-sm-10">';
        htmlElements += '		          <input type="text" placeholder="Letter Name" value="" class="form-control reco_letter_name" name="reco_letter_name[]" id="reco_letter_name[]" />';
        htmlElements += '		        </div>';
        htmlElements += '	        </div>';
        htmlElements += '	        <div class="col-md-4">';
        htmlElements += '		        <div class="form-group">';
        htmlElements += '		          <div class="col-sm-10">';
        htmlElements += '			          <select class="form-control reco_audio_type" name="audio_type[]" id="audio_type[]" style="width:70%">';
        htmlElements += '			            <option disabled value="" selected> Select </option>';
        htmlElements += '			            <option value="minor">Minor</option>';
        htmlElements += '			            <option value="major">Major</option>';
        htmlElements += '			          </select>';
        htmlElements += '		          </div>';
        htmlElements += '		        </div>';
        htmlElements += '	         </div>';
        htmlElements += '	        <div class="col-md-4">';
        htmlElements += '		        <div class="form-group">';
        htmlElements += '		          <input type="file" name="reco_audio_file[]" id="reco_audio_file[]" class="reco_audio_file">';
        htmlElements += '		        </div>';
        htmlElements += '	        </div>';
        htmlElements += '	      </div>';
        htmlElements += '     </div>';
        htmlElements += '   </div>';
        htmlElements += ' </div>';
        htmlElements += '</div>';
      }

      var container = document.getElementById("container1");
      container.innerHTML = htmlElements;
    }



    $("form").submit(function(){
      var is_ear_chapter = document.getElementById('is_ear_chapter').value
      var is_ear_training_type = document.getElementById('is_ear_training_type').value
      var img_type = document.getElementById("image_type");
      var chk_img = img_type.value;
      console.log(is_ear_training_type);
      // let chk_page = document.getElementsByName("old_name");
      // alert(chk_page)
      if(is_ear_chapter == 1){ 
        // var all_slow_old = $("#all_slow_old_audio").val();
        // alert(all_slow_old)
        if(is_ear_training_type == 'all'){ 
          if($("#all_slow").val() == '' && $("#all_slow_old_audio").val() == undefined) { 
            alert("Please Select slow file");
            return false;
          }
          if($("#all_medium").val() == '' && $("#all_medium_old_audio").val() == undefined) { 
              alert("Please Select medium file");
              return false;
          }
          if($("#all_fast").val() == '' && $("#all_fast_old_audio").val() == undefined) { 
              alert("Please Select fast file");
              return false;
          }
          if($("#all_extreme").val() == '' && $("#all_extreme_old_audio").val() == undefined) { 
              alert("Please Select extreme file");
              return false;
          }
        }
        if(is_ear_training_type == 'four'){ 
          if($("#four_slow").val() == '' && $("#four_slow_old_audio").val() == undefined) { 
              alert("Please Select slow file");
              return false;
          }
          if($("#four_medium").val() == '' && $("#four_medium_old_audio").val() == undefined) { 
              alert("Please Select medium file");
              return false;
          }
          if($("#four_fast").val() == '' && $("#four_fast_old_audio").val() == undefined) { 
              alert("Please Select fast file");
              return false;
          }
          if($("#four_extreme").val() == '' && $("#four_extreme_old_audio").val() == undefined) { 
              alert("Please Select extreme file");
              return false;
          }
        }
        if(chk_img == 'minor'){
          if($("#six_point_five_minus_minor").val() == '' && $("#six_point_five_minus_minor_old_audio").val() == undefined) { 
            alert("Please Select 6.5- file");
            return false;
          }
          if($("#seven_point_five_minus_minor").val() == '' && $("#seven_point_five_minus_minor_old_audio").val() == undefined) { 
              alert("Please Select 7.5- file");
              return false;
          }
          if($("#one_point_five_minor").val() == '' && $("#one_point_five_minor_old_audio").val() == undefined) { 
              alert("Please Select 1.5 file");
              return false;
          }
          if($("#three_point_five_minor").val() == '' && $("#three_point_five_minor_old_audio").val() == undefined) { 
              alert("Please Select 3.5 file");
              return false;
          }
          if($("#four_point_five_minor").val() == '' && $("#four_point_five_minor_old_audio").val() == undefined) { 
              alert("Please Select 4.5 file");
              return false;
          }
          if($("#six_point_five_minor").val() == '' && $("#six_point_five_minor_old_audio").val() == undefined) { 
              alert("Please Select 6.5 file");
              return false;
          }
          if($("#seven_point_five_minor").val() == '' && $("#seven_point_five_minor_old_audio").val() == undefined) { 
              alert("Please Select 7.5 file");
              return false;
          }
          if($("#one_point_five_plus_minor").val() == '' && $("#one_point_five_plus_minor_old_audio").val() == undefined) { 
              alert("Please Select 1.5+ file");
              return false;
          }
          if($("#three_point_five_plus_minor").val() == '' && $("#three_point_five_plus_minor_old_audio").val() == undefined) { 
              alert("Please Select 3.5+ file");
              return false;
          }
        }else{
          if($("#five_point_five_minus_major").val() == '' && $("#five_point_five_minus_major_old_audio").val() == undefined) { 
            alert("Please Select 5.5- file");
            return false;
          }
          if($("#six_point_five_minus_major").val() == '' && $("#six_point_five_minus_major_old_audio").val() == undefined) { 
              alert("Please Select 6.5- file");
              return false;
          }
          if($("#one_point_five_major").val() == '' && $("#one_point_five_major_old_audio").val() == undefined) { 
              alert("Please Select 1.5 file");
              return false;
          }
          if($("#two_point_five_major").val() == '' && $("#two_point_five_major_old_audio").val() == undefined) { 
              alert("Please Select 2.5 file");
              return false;
          }
          if($("#four_point_five_major").val() == '' && $("#four_point_five_major_old_audio").val() == undefined) { 
              alert("Please Select 4.5 file");
              return false;
          }
          if($("#five_point_five_major").val() == '' && $("#five_point_five_major_old_audio").val() == undefined) { 
              alert("Please Select 5.5 file");
              return false;
          }
          if($("#six_point_five_major").val() == '' && $("#six_point_five_major_old_audio").val() == undefined) { 
              alert("Please Select 6.5 file");
              return false;
          }
          if($("#one_point_five_plus_major").val() == '' && $("#one_point_five_plus_major_old_audio").val() == undefined) { 
              alert("Please Select 1.5+ file");
              return false;
          }
          if($("#two_point_five_plus_major").val() == '' && $("#two_point_five_plus_major_old_audio").val() == undefined) { 
              alert("Please Select 2.5+ file");
              return false;
          }
        }
        
        if($("#five_minus").val() == '' && $("#five_minus_old_audio").val() == undefined) { 
            alert("Please Select 5- file");
            return false;
        }
        if($("#six_minus").val() == '' && $("#six_minus_old_audio").val() == undefined) { 
            alert("Please Select 6- file");
            return false;
        }
        if($("#seven_minus").val() == '' && $("#seven_minus_old_audio").val() == undefined) { 
            alert("Please Select 7- file");
            return false;
        }
        if($("#one").val() == '' && $("#one_old_audio").val() == undefined) { 
            alert("Please Select 1 file");
            return false;
        }
        if($("#two").val() == '' && $("#two_old_audio").val() == undefined) { 
            alert("Please Select 2 file");
            return false;
        }
        if($("#three").val() == '' && $("#three_old_audio").val() == undefined) { 
            alert("Please Select 3 file");
            return false;
        }
        if($("#four").val() == '' && $("#four_old_audio").val() == undefined) { 
            alert("Please Select 4 file");
            return false;
        }
        if($("#five").val() == '' && $("#five_old_audio").val() == undefined) { 
            alert("Please Select 5 file");
            return false;
        }
        if($("#six").val() == '' && $("#six_old_audio").val() == undefined) { 
            alert("Please Select 6 file");
            return false;
        }
        if($("#seven").val() == '' && $("#seven_old_audio").val() == undefined) { 
            alert("Please Select 7 file");
            return false;
        }
        if($("#one_plus").val() == '' && $("#one_plus_old_audio").val() == undefined) { 
            alert("Please Select 1+ file");
            return false;
        }
        if($("#two_plus").val() == '' && $("#two_plus_old_audio").val() == undefined) { 
            alert("Please Select 2+ file");
            return false;
        }
        if($("#three_plus").val() == '' && $("#three_plus_old_audio").val() == undefined) { 
            alert("Please Select 3+ file");
            return false;
        }
        if($("#four_plus").val() == '' && $("#four_plus_old_audio").val() == undefined) { 
            alert("Please Select 4+ file");
            return false;
        }
      }
      
    });
  });

  function Dropped(event, ui) {
    $(".draggable").each(function (e) {
      var $elem = $(this);
      var menu = this.id;

      $('#button_' + this.id).val(e + 1);

      $('#metronome_' + this.id).val(e + 1);

    });
  }
 
  function someFunction(type = '') {
      if(type == 'metronome'){
          $("#add_metronome").css("display","block");
      }else if(type == 'question'){
          $("#add_question").css("display","block");
      }else{
          $("#add_metronome").css("display","block");
      }

  }


  function add_new_section(section, position, type) {
    if (type == 'button') {
      var jobValue = $("input[name=button_at]").val();
      if (jobValue != '' && jobValue != undefined) {
        alert("Already button is exist");
        return false;
      }
    }
    if (type == 'metronome') {
        $("#add_metronome").css("display","none");      
    }

      if (type == 'lession_question') {
          $("#add_question").css("display","none");
      }

    var count = $('#section_count').val();
    var cnt_div = $('.draggable').length
    // alert(cnt_div)
    var last_id = $(".draggable:last").attr("id");
    // alert(last_id);
    if(last_id){
        divid = last_id;
      }else{
        divid = "0";
      }
    $.ajax({
      url: '<?= base_url() ?>Chapter/add_section',
      type: "POST",
      data: {
        'count': count,
        'cnt_div': cnt_div,
        'divid': divid,
        'unlimited': 'no',
        position,
        'type': type
      },
      success: function (html) {
        if (section > 0) {
          $("#section_html").append(html);
        } else {
          debugger;
          $("#section_html").append(html);
        }
        $('#section_count').val(parseInt(count) + 1);
      }
    });
  }

  function remove_new_section(section) {
    var count = $('#section_count').val();
    $('#sec_' + section).remove();
  }
</script>

<?php include('footer.php') ?>
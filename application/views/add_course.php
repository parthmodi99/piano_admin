<?php include('header.php') ?>

<?php include('sidebar.php') ?>

<script src="<?=base_url('admintheme')?>/ckeditor/ckeditor.js"></script>

<script src="<?=base_url('admintheme')?>/ckeditor/samples/js/sample.js"></script>

<script type="text/javascript">
  function readURL(input) {
    // console.log($(input).attr("test_id"));
    var img_id = $(input).attr("img_id")
    // console.log(img_id);
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {

        $('#' + img_id)
          .attr('src', e.target.result);

      };
      reader.readAsDataURL(input.files[0]);
    } else {

      $('#' + img_id)
        .attr('src', '');


    }
  }

</script>

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

    <h1 class="m-n font-thin h3">Course</h1>

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

		if( validation_errors() != null)

    		{

    			echo '<div class="alert alert-danger">';

				echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

				echo validation_errors();

				echo '</div>';

			}

		

		if(isset($custome_error) && $custome_error != null)

    		{

    			echo '<div class="alert alert-warning">';

				echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

				echo $custome_error;

				echo '</div>';

		}			

	 ?>

              <form name="courses" id="courses" action="<?=base_url().'Course/'?><?php if($this->uri->segment('2') == "editCourse"){echo "editCourse/".$this->uri->segment('3');}else{echo "addCourse";} ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

      		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

      		 <?php

		       	if($this->uri->segment('2') == "editCourse"):

				?>

                    <input type="hidden" name="course_id" value="<?=$course['id']?>">

				<?php endif;?>
             <div class="form-group">

              <label for="title" class="col-sm-2 control-label">Name<span class="text-primary" style="color:#a94442;">*</span></label>

               <div class="col-sm-10">

                  <input type="text" placeholder="Name" class="form-control" required name="name" value="<?php  if(set_value('name') == null){echo (!empty($course))?$course['name']:''; }else{echo set_value('name'); }?>" />

               </div>

            </div>    
			
			<div class="form-group">

                    <label for="image_pro_user" class="col-sm-2 control-label">Image (for pro user)<span class="text-primary"
                        style="color:#a94442;">*</span></label>

                    <div class="col-sm-10">
                      <img src="<?php  if (set_value('image') == null) {
                            echo (!empty($course))?$course_url.$course['image']:'';
                        } else {
                            echo set_value('image');
                        }?>" id="blah" style="width: 300px;height: 300px;">
                      <input type="file" onchange="readURL(this);" class="form-control" name="image" img_id="blah"/>

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="image_free_user" class="col-sm-2 control-label">Image (for free user)<span class="text-primary"
                        style="color:#a94442;">*</span></label>

                    <div class="col-sm-10">
                      <img src="<?php  if (set_value('image_free') == null) {
                            echo (!empty($course))?$course_url.$course['image_free']:'';
                        } else {
                            echo set_value('image_free');
                        }?>" id="blah2" style="width: 300px;height: 300px;">
                      <input type="file" onchange="readURL(this);" class="form-control" name="image_free" img_id="blah2"/>

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Course Icon<span class="text-primary"
                        style="color:#a94442;">*</span></label>

                    <div class="col-sm-10">
                      <img src="<?php  if (set_value('course_icon') == null) {
                            echo (!empty($course))?$course_url.$course['course_icon']:'';
                        } else {
                            echo set_value('course_icon');
                        }?>" id="blah3" style="width: 300px;height: 300px;">
                      <input type="file" onchange="readURL(this);" class="form-control" name="course_icon" img_id="blah3"/>

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="image_feature" class="col-sm-2 control-label">Feature Image<span class="text-primary"
                        style="color:#a94442;">*</span></label>

                    <div class="col-sm-10">
                      <img src="<?php  if (set_value('feature_image') == null) {
                            echo (!empty($course))?$course_url.$course['feature_image']:'';
                        } else {
                            echo set_value('feature_image');
                        }?>" id="blah4" style="width: 300px;height: 300px;">
                      <input type="file" onchange="readURL(this);" class="form-control" name="feature_image" img_id="blah4"/>

                    </div>

                  </div>

                  <div class="form-group">
                    <label for="course_type" class="col-sm-2 control-label">Course Type </label>

                    <div class="col-sm-10">
                      <select class="form-control" name="course_type">
                        <option value="hearing" <?= isset($course) && $course['course_type'] == 'hearing' ? 'selected':'' ?> selected>Hearing</option>
                        <option value="playing" <?= isset($course) && $course['course_type'] == 'playing' ? 'selected':'' ?>>Playing</option>
                      </select>

                    </div>

                  </div>

                  <div class="form-group">

                    <label for="title" class="col-sm-2 control-label">Coming Soon</label>

                    <div class="col-sm-10">
                      <input type="checkbox" name="coming_soon" value="1" style="margin-top: 10px;"
                        <?= isset($course) && $course['coming_soon'] == 1 ?'checked':'' ?>>
                    </div>
                  </div>

                  

             <input type="submit" name="submit" class="btn btn-sm btn-primary"/>

             <button type="button" name="cancel" class="btn btn-sm btn-primary" onClick="window.location.href='<?=base_url().'Course'?>'">Cancel</button>

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

<?php include('footer.php') ?>
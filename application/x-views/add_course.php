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
  function readURL2(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {

        $('#blah3')
          .attr('src', e.target.result);

      };
      reader.readAsDataURL(input.files[0]);
    } else {

      $('#blah3')
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

                    <label for="title" class="col-sm-2 control-label">Image (for pro user)<span class="text-primary"
                        style="color:#a94442;">*</span></label>

                    <div class="col-sm-10">
                      <img src="<?php  if (set_value('image') == null) {
                            echo (!empty($course))?$course_url.$course['image']:'';
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
                            echo (!empty($course))?$course_url.$course['image_free']:'';
                        } else {
                            echo set_value('image_free');
                        }?>" id="blah2" style="width: 300px;height: 300px;">
                      <input type="file" onchange="readURL1(this);" class="form-control" name="image_free" />

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
                      <input type="file" onchange="readURL2(this);" class="form-control" name="course_icon" />

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
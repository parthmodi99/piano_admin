<?php include('header.php') ?>

<?php include('sidebar.php') ?>

<script src="<?=base_url('admintheme')?>/ckeditor/ckeditor.js"></script>

<script src="<?=base_url('admintheme')?>/ckeditor/samples/js/sample.js"></script>

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

    <h1 class="m-n font-thin h3">Monday Quote</h1>

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

              <form name="quotes" id="quotes" action="<?=base_url().'quote/'?><?php if($this->uri->segment('2') == "editQuote"){echo "editQuote/".$this->uri->segment('3');}else{echo "addQuote";} ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

      		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />

      		 <?php

		       	if($this->uri->segment('3') == "editQuote"):

				?>

                    <input type="hidden" name="quote_id" value="<?=$quoteedit['id']?>">

				<?php endif;?>

           

             <div class="form-group">

              <label for="title" class="col-sm-2 control-label">Quote<span class="text-primary" style="color:#a94442;">*</span></label>

               <div class="col-sm-10">

               <input type="text" placeholder="Quote" class="form-control" name="quote" value="<?php  if(set_value('quote') == null){echo (!empty($quoteedit))?$quoteedit['quote']:''; }else{echo set_value('quote'); }?>" />

            </div>

            </div>

            <div class="form-group">

              <label for="title" class="col-sm-2 control-label">Author<span class="text-primary" style="color:#a94442;">*</span></label>

               <div class="col-sm-10">

               <input type="text" placeholder="Author" class="form-control" required name="author" value="<?php  if(set_value('author') == null){echo (!empty($quoteedit))?$quoteedit['author']:''; }else{echo set_value('author'); }?>" />

            </div>

            </div>

             <input type="submit" name="submit" class="btn btn-sm btn-primary"/>

             <button type="button" name="cancel" class="btn btn-sm btn-primary" onClick="window.location.href='<?=base_url().'quote'?>'">Cancel</button>

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
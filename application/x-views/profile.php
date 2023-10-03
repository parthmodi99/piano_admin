<?php include('header.php') ?>
<?php include('sidebar.php') ?>
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
    <h1 class="m-n font-thin h3">Profile</h1>
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
              <form name="pages" id="pages" action="<?=base_url().'/profile'?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data" autocomplete="false">
      		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
		    		<div class="form-group">
          				<label class="col-sm-2 control-label">Name<span class="text-primary">*</span></label>
			          <div class="col-sm-10">
			            <input type="text" name="fname" class="form-control" readonly="true" value="<?php  if(set_value('fname') == null){echo (!empty($admin))?$admin['name']:''; }else{echo set_value('fname'); }?>"/>
			          </div>
        			</div>
        			<!-- <div class="form-group">
          				<label class="col-sm-2 control-label">Last Name<span class="text-primary">*</span></label>
			          <div class="col-sm-10">
			            <input type="text" name="lname" class="form-control" value="<?php  if(set_value('lname') == null){echo (!empty($admin))?$admin['last_name']:''; }else{echo set_value('lname'); }?>"/>
			          </div>
        			</div> -->
        			<div class="form-group">
          				<label class="col-sm-2 control-label">Email Id<span class="text-primary">*</span></label>
			          <div class="col-sm-10">
			            <input type="text" name="email_id" class="form-control" value="<?php  if(set_value('emailid') == null){echo (!empty($admin))?$admin['email_id']:''; }else{echo set_value('emailid'); }?>"/>
			          </div>
        			</div>	
        			<div class="form-group">
          				<label class="col-sm-2 control-label">Password<span class="text-primary">*</span></label>
			          <div class="col-sm-10">
			            <input type="password" name="password" class="form-control" value="<?php  if(set_value('pwd') == null){echo (!empty($admin))?$admin['password']:''; }else{echo set_value('pwd'); }?>" />
			          </div>
        			</div>
        			<div class="form-group">
          				<label class="col-sm-2 control-label">Confirm Password<span class="text-primary">*</span></label>
			          <div class="col-sm-10">
			            <input type="password" name="conpassword" class="form-control" />
			          </div>
        			</div>
			
             <input type="submit" name="submit" class="btn btn-sm btn-primary"/>
             <button type="button" name="cancel" class="btn btn-sm btn-primary" onClick="window.location.href='<?=base_url().'profile'?>'">Cancel</button>
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
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
    <h1 class="m-n font-thin h3">Cms Page</h1>
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
              <form name="pages" id="pages" action="<?=base_url().'/page/'?><?php if($this->uri->segment('2') == "editPage"){echo "editPage/".$this->uri->segment('3');}else{echo "addPage";} ?>" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
      		<input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
      		 <?php
		       	if($this->uri->segment('3') == "editPage"):
				?>
                    <input type="hidden" name="cat_id" value="<?=$pageedit['page_id']?>">
				<?php endif;?>
           
             <div class="form-group">
              <label for="title" class="col-sm-2 control-label">Page Title<span class="text-primary" style="color:#a94442;">*</span></label>
               <div class="col-sm-10">
               <input type="text" placeholder="Page Title" class="form-control" required name="qtitle" value="<?php  if(set_value('qtitle') == null){echo (!empty($pageedit))?$pageedit['page_title']:''; }else{echo set_value('qtitle'); }?>" />
            </div>
            </div>
             <div class="form-group">
              <label for="title" class="col-sm-2 control-label">Page Slug <span class="text-primary" style="color:#a94442;">*</span></label>
               <div class="col-sm-10">
               <input type="text" placeholder="Page Slug" class="form-control"  name="stitle" value="<?php  if(set_value('stitle') == null){echo (!empty($pageedit))?$pageedit['page_slug']:''; }else{echo set_value('stitle'); }?>" />
            </div>
            </div>
             <div class="form-group">
              <label for="title"  class="col-sm-2 control-label">Page Content <span class="text-primary">*</span></label>
              <div class="col-sm-10">
              <textarea class="form-control" id="editor" name="description"><?php  if(set_value('description') == null){echo (!empty($pageedit))?$pageedit['content']:''; }else{echo set_value('description'); }?>
              </textarea>
              <script type="text/javascript">
              	CKEDITOR.replace( 'editor', {
  						fullPage: false,
  						allowedContent: true,
						filebrowserImageUploadUrl: "/admintheme/ckeditor/plugins/imgupload.php"
						});
              </script>
              </div>
            </div>
           
            <!-- <div class="form-group">
              <label for="title"  class="col-sm-2 control-label">Safety Procedure Description <span class="text-primary">*</span></label>
              <div class="col-sm-10">
              <textarea class="form-control" id="editor1" name="description1">
              	<?php  if(set_value('description1') == null){echo (!empty($pageedit))?$pageedit['safety_pro_desc']:''; }else{echo set_value('description1'); }?>

              </textarea>
              <script type="text/javascript">
              	CKEDITOR.replace( 'editor1', {
  						fullPage: false,
  						allowedContent: true,
						filebrowserImageUploadUrl: "/admintheme/ckeditor/plugins/imgupload.php"
						});
              </script>
              </div>
            </div> -->
             <input type="submit" name="submit" class="btn btn-sm btn-primary"/>
             <button type="button" name="cancel" class="btn btn-sm btn-primary" onClick="window.location.href='<?=base_url().'page'?>'">Cancel</button>
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
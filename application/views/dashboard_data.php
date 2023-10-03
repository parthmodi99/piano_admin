<?php

$CI =& get_instance();
$CI->load->model('Admin_model');

?>
<style type="text/css">
	.refferalc{
		    margin-left: 10.5%;
	}

	@media only screen and (max-width: 768px) {
	  .refferalc{
		    margin-left: 0%;
	}
}
</style>
<div class="col-md-8">
	          <div class="row row-sm text-center">
<a href="<?=base_url()?>Filter/<?=$type ?>?type=new_user">
		            <div class="col-xs-4">
		              <div class="panel padder-v bg-primary item"  style="background-color: #14CC64;">
		                <div class="h1 text-warning font-thin h1" style="color: #FFFF;"><?php echo $new_user ?></div>
		                <span class="text-muted text-xs" style="color: #009938 !important;"><strong>New Users Who Worked out</strong></span>
		              </div>
		            </div>
	            </a>

	            	<a href="<?=base_url()?>Filter/<?=$type ?>?type=old_user">
		            <div class="col-xs-4">
		              <div class="panel padder-v bg-primary item" style="background-color: #14CC64;">
		                <div class="h1 text-warning font-thin h1" style="color: #FFFF;"><?php echo $old_user ?></div>
		                <span class="text-muted text-xs" style="color: #009938 !important;"><strong>Old Users Who Worked out</strong></span>
		              </div>
		            </div>
	            </a>
	        </div>
	    </div>
	            <div class="col-md-8 refferalc">
	          <div class="row row-sm text-center">
	            <a href="<?=base_url()?>Filter/generated?type=all_user">
		            <div class="col-xs-4">
		              <div class="panel padder-v bg-primary item" style="background-color: #14CC64;">
		                <div class="h1 text-warning font-thin h1" style="color: #FFFF;"><?php echo $user = $CI->Admin_model->getAllUserwhogeneratecode(); ?></div>
		                <span class="text-muted text-xs" style="color: #009938 !important;"><strong>Total number of users who generated their code</strong></span>
		              </div>
		            </div>
	            </a>
	            <a href="<?=base_url()?>Filter/used?type=all_user">
		            <div class="col-xs-4">
		              <div class="panel padder-v bg-primary item" style="background-color: #14CC64;">
		                <div class="h1 text-warning font-thin h1" style="color: #FFFF;"><?php echo $user = $CI->Admin_model->getAllUserwhousecode(); ?></div>
		                <span class="text-muted text-xs" style="color: #009938 !important;"><strong>Total Users who signed in using a valid code</strong></span>
		              </div>
		            </div>
	            </a>
	          </div>
	      </div>
	            <div class="col-md-8 refferalc">
	          <div class="row row-sm text-center">
	            <a href="<?=base_url()?>Filter/generated?type=<?=$type ?>">
		            <div class="col-xs-4">
		              <div class="panel padder-v bg-primary item" style="background-color: #14CC64;">
		                <div class="h1 text-warning font-thin h1" style="color: #FFFF;"><?php echo $generated_user ?></div>
		                <span class="text-muted text-xs" style="color: #009938 !important;"><strong>Users who generated their code</strong></span>
		              </div>
		            </div>
	            </a>

	            <a href="<?=base_url()?>Filter/used?type=<?=$type ?>">
		            <div class="col-xs-4">
		              <div class="panel padder-v bg-primary item" style="background-color: #14CC64;">
		                <div class="h1 text-warning font-thin h1" style="color: #FFFF;"><?php echo $used_user ?></div>
		                <span class="text-muted text-xs" style="color: #009938 !important;"><strong>Users who signed in using a valid code</strong></span>
		              </div>
		            </div>
	            </a>
	        </div>
	    </div>
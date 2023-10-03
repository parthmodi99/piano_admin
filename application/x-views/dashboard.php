<?php include('header.php') ?>

<?php include('sidebar.php') ?>

<?php

$CI =& get_instance();
$CI->load->model('Admin_model');

?>

<!-- <script src="<?=base_url('admintheme')?>/ckeditor/ckeditor.js"></script>

<script src="<?=base_url('admintheme')?>/ckeditor/samples/js/sample.js"></script> -->



<!-- content -->

 



   

<div class="col">

	<div class="bg-light lter b-b wrapper-md" style="display: flex;">

		<div class="col-sm-10">  <h1 class="m-n font-thin h3">&nbsp;&nbsp;&nbsp;&nbsp;Dashboard</h1></div>
		<!-- <div class="col-sm-2">
			<select name="type" class="form-control" id="times" onchange="show_duration();" required=""> 
				<option value="Day">Last Day</option> 
				<option value="Week">Last Week (Last 7 Days)</option> 
				<option value="Month">Last Month (Last 30 Days)</option>
			</select>
		</div> -->

	</div>

<div class="wrapper-md" ng-controller="FlotChartDemoCtrl">
		<div class="row">
	        <div class="col-md-8">
	          <div class="row row-sm text-center">

	          	<a href="<?=base_url()?>/User/userlist">
		            <div class="col-xs-4">
		              <div class="panel padder-v bg-primary item" style="background-color: #14CC64;">
		                <div class="h1 text-warning font-thin h1" style="color: #FFFF;"><b><?php echo $user = $CI->Admin_model->getAllUser(); ?></b></div>
		                <span class="text-muted text-xs" style="color: #009938 !important;"><strong>Free users</strong></span>
		              </div>
		            </div>
	            </a>
	            <a href="<?=base_url()?>/User?filter=pro">
		            <div class="col-xs-4">
		              <div class="panel padder-v bg-primary item" style="background-color: #14CC64;">
		                <div class="h1 text-warning font-thin h1" style="color: #FFFF;"><b><?php echo $user = $CI->Admin_model->getAllRecordscountById('tbl_user',array('is_pro_user' => 1)); ?></b></div>
		                <span class="text-muted text-xs" style="color: #009938 !important;"><strong>Paid users</strong></span>
		              </div>
		            </div>
	            </a>
	          </div>
	        </div>
	            
	            	<div id="filter">
	            	<!-- <a href="<?=base_url()?>/User">
		            <div class="col-xs-4">
		              <div class="panel padder-v bg-primary item">
		                <div class="h1 text-warning font-thin h1"><?php echo $user = $CI->Admin_model->getAllUser(); ?></div>
		                <span class="text-muted text-xs"><strong>Total number of user</strong></span>
		              </div>
		            </div>
	            </a>

	            	<a href="<?=base_url()?>/User">
		            <div class="col-xs-4">
		              <div class="panel padder-v bg-primary item">
		                <div class="h1 text-warning font-thin h1"><?php echo $user = $CI->Admin_model->getAllUser(); ?></div>
		                <span class="text-muted text-xs"><strong>Total number of user</strong></span>
		              </div>
		            </div>
	            </a> -->
	        </div>
	        
	          <!-- </div> -->
	        <!-- </div> -->
	    </div>
	</div>    



</div>

  <script type="text/javascript">
  	function show_duration() 
  	{
  		var duration = document.getElementById('times').value;
  		console.log(duration);
  		if(duration == 'Day')
		{
			$.ajax({
			url:'<?=base_url()?>Filter/getdashboarddata',
			type: "POST",
			data: 'duration='+duration,
			dataType:"html",
			success: function(html){
				//$(".loader").fadeOut(500);
				/*$('html,body').animate({
					scrollTop: $("#dattta").offset().top},
					'slow');*/
				$("#filter").html(html);



			}
		});
		}
		if(duration == 'Week')
		{
			$.ajax({
			url:'<?=base_url()?>Filter/getdashboarddata',
			type: "POST",
			data: 'duration='+duration,
			dataType:"html",
			success: function(html){
				//$(".loader").fadeOut(500);
				/*$('html,body').animate({
					scrollTop: $("#dattta").offset().top},
					'slow');*/
				$("#filter").html(html);



			}
		});
		}
		if(duration == 'Month')
		{
			//month display
			$.ajax({
			url:'<?=base_url()?>Filter/getdashboarddata',
			type: "POST",
			data: 'duration='+duration,
			dataType:"html",
			success: function(html){
				//$(".loader").fadeOut(500);
				/*$('html,body').animate({
					scrollTop: $("#dattta").offset().top},
					'slow');*/
				$("#filter").html(html);



			}
		});
		}
  	}

  	show_duration();
  </script>

  

<!-- /content -->

<?php include('footer.php') ?>
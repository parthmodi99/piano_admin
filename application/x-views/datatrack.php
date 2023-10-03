<?php include('header.php') ?>
<?php include('sidebar.php') ?>

<script src="<?=base_url('admintheme')?>/ckeditor/ckeditor.js"></script>
<script src="<?=base_url('admintheme')?>/ckeditor/samples/js/sample.js"></script>
<style type="text/css">
	.week .bootstrap-datetimepicker-widget tr:hover {
		background-color: #808080;
	}
	.table-responsive {
		min-height: 74vh;
		/* overflow-x: auto; */
	}
	.panel {
		margin-bottom: 0px;
	}



</style>
<style type="text/css">
.loader 
{
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('https://gifimage.net/wp-content/uploads/2018/04/page-loading-gif-2.gif') 50% 50% no-repeat rgb(249,249,249);
  opacity: .8;
  }
</style>
<script type="text/javascript">
	function areyousure(id)
	{
		$.confirm({
			title: 'Delete User',
			content: 'Are you sure you want to delete?',
			buttons: {
				confirm: function () {
					window.location='<?=base_url()?>index.php/User/delete_user/'+id;
				},
				cancel: function () {
					return true;
				},
			}

		});
	}
	function areyousurepdel(id)
	{
		$.confirm({
			title: 'Delete Post',
			content: 'Are you sure you want to delete?',
			buttons: {
				confirm: function () {
					window.location='<?=base_url()?>index.php/Post/delete_post/'+id;
				},
				cancel: function () {
					return true;
				},
			}

		});
	}

	function areyousure1(id,status)
	{
		$.confirm({
			title: 'Block Post',
			content: 'Are you sure you want to Block?',
			buttons: {
				confirm: function () {
					$.ajax({
						url:'<?=base_url()?>index.php/Post/post_block',
						type: "POST",

						data: {
							"<?=$this->security->get_csrf_token_name();?>" : "<?=$this->security->get_csrf_hash();?>",
							'id':id,
							'status':status
						},
						success: function(html){
							window.location.reload();

						}
					});
				},
				cancel: function () {
					return true;
				},
			}

		});
	}
	function areyousure2(id,status)
	{
		$.confirm({
			title: 'Unblock User',
			content: 'Are you sure you want to Unblock?',
			buttons: {
				confirm: function () {
					$.ajax({
						url:'<?=base_url()?>index.php/Post/post_block',
						type: "POST",

						data: {
							"<?=$this->security->get_csrf_token_name();?>" : "<?=$this->security->get_csrf_hash();?>",
							'id':id,
							'status':status
						},
						success: function(html){
							window.location.reload();

						}
					});
				},
				cancel: function () {
					return true;
				},
			}

		});
	}


	function get_post_details(id)
	{

		var po_id=id+'post_popup';

		document.getElementById(po_id).innerHTML='';
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById(po_id).innerHTML=this.responseText;            
			}
		};
		xhttp.open("GET", "Post/postview/"+id, true);
		xhttp.send();

	}

</script>

<div id="content" class="app-content" role="main">

	<div class="app-content-body ">
		<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="
		app.settings.asideFolded = false; 
		app.settings.asideDock = false;
		">
		<div class="col">
			<div class="bg-light lter b-b wrapper-md" style="padding: 15px;">
				<h1 class="m-n font-thin h3">Workout Data tracking</h1>
			</div>
			<div class="panel panel-default">
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
				<div class="loader"></div>


				<div class="table-responsive"><br>

					<div class="form-group">
						<label class="col-sm-2 control-label">Select Duration <span class="text-primary">*</span></label>
						<div class="col-sm-6">
							<select name="type" class="form-control" id="time" onchange="show_duration();" required=""> 
								<option value="Day">Day</option> 
								<option value="Week">Week</option> 
								<option value="Month">Month</option>
								<option value="Year">Year</option>
							</select>
						</div>
					</div><br><br>
					<div class="form-group" id="show_day" style="display: block;">
						<label class="col-sm-2 control-label">Select Day <span class="text-primary">*</span></label>
						<div class="col-sm-6">								
							<input type='text' class="form-control" id='dayDatePicker' placeholder="Select Day" />									
						</div>
						<br><br>

					</div>
					<div class="form-group week" id="show_week" style="display: none;">
						<label class="col-sm-2 control-label">Select Week <span class="text-primary">*</span></label>
						<div class="col-sm-6">								
							<input type='text' class="form-control" id='weeklyDatePicker' placeholder="Select Week" />									
						</div>
						<br><br>
					</div>
					<div class="form-group" id="show_month" style="display: none;">
						<label class="col-sm-2 control-label">Select Month <span class="text-primary">*</span></label>
						<div class="col-sm-6">								
							<input type='text' class="form-control" id='demo-1' placeholder="Select Month" />									
						</div>
						<br><br>
					</div>
					<div class="form-group" id="show_year" style="display: none;">
						<label class="col-sm-2 control-label">Select Year <span class="text-primary">*</span></label>
						<div class="col-sm-6">								
							<select name="type" class="form-control" id="year" required=""> 
								<option value="2019">2019</option> 
								<option value="2020">2020</option> 
								<option value="2021">2021</option>
								<option value="2022">2022</option>
								<option value="2023">2023</option>
								<option value="2024">2024</option>
								<option value="2025">2025</option>
								<option value="2026">2026</option>
								<option value="2027">2027</option>
								<option value="2028">2028</option>
								<option value="2029">2029</option>
								<option value="2030">2030</option>
								<option value="2031">2031</option>
								<option value="2032">2032</option>
								<option value="2033">2033</option>



							</select>							
						</div>
						<br><br>
					</div>


					<div>
						<div class="col-sm-10" style="text-align: center;">
							<input type="submit" onclick="get_data();" name="submit" class="btn btn-sm btn-primary">
						</div>
					</div><br><br>


					<div id="dattta" class="form-group" style="padding-left: 15px;padding-right: 15px;">

					</div>
				</div> 

				<div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog modal-lg">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<div class="modal fade" id="myModal12" role="dialog">
	<div class="modal-dialog"> 

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Image</h4>
			</div>
			<div class="modal-body user" id="" style="height: 77vh;overflow-x: hidden;overflow-y: scroll;">
				<img id="fancybox" src="" width="100%" height="auto">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#example').dataTable({
			destroy: true,
			serverSide: true,
			language: { 
				emptyTable: "There are currently no records."
			},
			columnDefs: [
			{
				targets: [ 0 ],
				orderable: true
			},
			{
				targets: [ 1 ],
				orderable: true
			},
			{
				targets: [ 2 ],
				orderable: false
			},
			{
				targets: [ 3 ],
				orderable: false
			},
			{
				targets: [ 4 ],
				orderable: false
			},
			{
				targets: [ 5 ],
				orderable: false
			},


			],
			ajax : {
				url : "<?=base_url().'Post/getAllData'?>",
				type : "POST"
			},
			columns: [
			{ data: "id" },
			{ data: "user_name" },
			{ data: "hashtag" },
			{ data: "location" },
			{ data: "post_type" },
			{ data: "action" }
			]
		});
	} );
</script>  

<script type="text/javascript">
	function get_data()
	{
		$(".loader").fadeIn(500);
		var time = document.getElementById('time').value;
		if(time == 'Day')
		{
			var duration = document.getElementById('dayDatePicker').value;
			if(duration == '')
			{
				alert("Please Select Day");
				$(".loader").fadeOut(500);
				return false;
			}
		}
		if(time == 'Week')
		{
			var duration = document.getElementById('weeklyDatePicker').value;
			if(duration == '')
			{
				alert("Please Select Week");
				$(".loader").fadeOut(500);
				return false;
			}
		}
		if(time == 'Month')
		{
			var duration = document.getElementById('demo-1').value;
			if(duration == '')
			{
				alert("Please Select Month");
				$(".loader").fadeOut(500);
				return false;
			}
		}
		if(time == 'Year')
		{	
			var duration = document.getElementById('year').value;
			if(duration == '')
			{
				alert("Please Select Year");
				$(".loader").fadeOut(500);
				return false;
			}
		}

		if(time == 'all')
		{	
			var duration = 'all';
			if(duration == '')
			{
				alert("Please Select option");
				$(".loader").fadeOut(500);
				return false;
			}
		}
		
		$.ajax({
			url:'<?=base_url()?>Filter/getuserdata',
			type: "POST",
			data: 'time='+time+'&duration='+duration,
			dataType:"html",
			success: function(html){
				$(".loader").fadeOut(500);
				$('html,body').animate({
					scrollTop: $("#dattta").offset().top},
					'slow');
				$("#dattta").html(html);



			}
		});
		
		
	}

</script>
<!-- /content -->
<?php include('footer.php') ?>
<script type="text/javascript">
	$("#weeklyDatePicker").datetimepicker({
		format: 'YYYY-MM-DD'
	});

	$("#dayDatePicker").datetimepicker({
		format: 'YYYY-MM-DD'
	});

//Get the value of Start and End of Week
$('#weeklyDatePicker').on('dp.change', function (e) {
	value = $("#weeklyDatePicker").val();
	firstDate = moment(value, "YYYY-MM-DD").day(0).format("YYYY-MM-DD");
	lastDate =  moment(value, "YYYY-MM-DD").day(6).format("YYYY-MM-DD");
	$("#weeklyDatePicker").val(firstDate + " - " + lastDate);
});

/*$('#demo-1').monthpicker(); */

$("#demo-1").datetimepicker({
	format: 'MM/YYYY'

});

//========================
function show_duration() 
{
	var duration = document.getElementById('time').value;
	if(duration == 'Day')
	{
	//day display
	var d = document.getElementById('show_day');
	d.style.display = 'block';

	//hide other
	var w = document.getElementById('show_week');
	w.style.display = 'none';

	var m = document.getElementById('show_month');
	m.style.display = 'none';

	var y = document.getElementById('show_year');
	y.style.display = 'none';
}
if(duration == 'Week')
{
	//week display
	var w = document.getElementById('show_week');
	w.style.display = 'block';

	//hide other
	var d = document.getElementById('show_day');
	d.style.display = 'none';

	var m = document.getElementById('show_month');
	m.style.display = 'none';

	var y = document.getElementById('show_year');
	y.style.display = 'none';
}
if(duration == 'Month')
{
	//month display
	var m = document.getElementById('show_month');
	m.style.display = 'block';

	//hide other
	var w = document.getElementById('show_week');
	w.style.display = 'none';

	var d = document.getElementById('show_day');
	d.style.display = 'none';

	var y = document.getElementById('show_year');
	y.style.display = 'none';
}
if(duration == 'Year')
{
	//year display
	var y = document.getElementById('show_year');
	y.style.display = 'block';

	//hide other
	var w = document.getElementById('show_week');
	w.style.display = 'none';

	var m = document.getElementById('show_month');
	m.style.display = 'none';

	var d = document.getElementById('show_day');
	d.style.display = 'none';
}

if(duration == 'all')
{
	//year display
	var y = document.getElementById('show_year');
	y.style.display = 'none';

	//hide other
	var w = document.getElementById('show_week');
	w.style.display = 'none';

	var m = document.getElementById('show_month');
	m.style.display = 'none';

	var d = document.getElementById('show_day');
	d.style.display = 'none';
}

console.log(duration); 
}
</script>
<script type="text/javascript">
	$(window).load(function() 
	{
		$(".loader").fadeOut(500);
	});
</script>
<script>
	function openImageModal(img_url)
	{
		document.getElementById("fancybox").src=img_url;
		$('#myModal12').modal('toggle');
		$('#myModal12').modal('show');
	}
</script>
<html lang="en" class="">

<head>

  <meta charset="utf-8" />

  <title>Piano Admin Panel</title>

  <link rel="icon" type="image/png" sizes="56x56" href="/uploads/fav.png">

  <meta name="description" content="app, web app, responsive, responsive layout, admin, admin panel, admin dashboard, flat, flat ui, ui kit, AngularJS, ui route, charts, widgets, components" />

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

  <link rel="stylesheet" href="<?=base_url('admintheme')?>/libs/assets/animate.css/animate.css" type="text/css" />

  <link rel="stylesheet" href="<?=base_url('admintheme')?>/libs/assets/font-awesome/css/font-awesome.min.css" type="text/css" />

  <link rel="stylesheet" href="<?=base_url('admintheme')?>/libs/assets/simple-line-icons/css/simple-line-icons.css" type="text/css" />

  <link rel="stylesheet" href="<?=base_url('admintheme')?>/libs/jquery/bootstrap/dist/css/bootstrap.css" type="text/css" />

  <link rel="stylesheet" href="<?=base_url('admintheme')?>/css/font.css" type="text/css" />

  <link rel="stylesheet" href="<?=base_url('admintheme')?>/css/app.css" type="text/css" />

</head>

<body>

<div class="app app-header-fixed ">

<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;">

  <a href class="navbar-brand block m-t">Piano</a>

  <div class="m-b-lg">

    <div class="wrapper text-center">

      <strong>Sign in to get in touch</strong>

    </div>

    

     

	

      <div class="text-danger wrapper text-center" ng-show="authError">

          <?php

	        	if ($this->session->flashdata('error')) {

					echo '<div class="alert alert-danger">';

					echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

					echo $this->session->flashdata('error');

					echo '</div>';

				}

				if ($this->session->flashdata('message')) {

					echo '<div class="alert alert-success">';

					echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

					echo $this->session->flashdata('message');

					echo '</div>';

				}

			?>

      </div>

      <form action="<?=base_url()?>login" method="post" enctype='multipart/form-data'>

     

      <div class="list-group list-group-sm">

        <div class="list-group-item">

          <input type="email" placeholder="Email" class="form-control no-border"  required name="admin_name">

        </div>

        <div class="list-group-item">

           <input type="password" placeholder="Password" class="form-control no-border"  required  name="admin_password">

        </div>

      </div>

      <input type="submit" value="submit" name="submit" class="btn btn-lg btn-primary btn-block">

     <!--  <div class="text-center m-t m-b"><a ui-sref="access.forgotpwd">Forgot password?</a></div> -->

      

    </form>

  </div>

  <div class="text-center">

    <p>

  <small class="text-muted">Piano<br>&copy; 2021</small>

</p>

  </div>

</div>

</div>

<script src="<?=base_url('admintheme')?>/libs/jquery/jquery/dist/jquery.js"></script>

<script src="<?=base_url('admintheme')?>/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>

<script src="<?=base_url('admintheme')?>/js/ui-load.js"></script>

<script src="<?=base_url('admintheme')?>/js/ui-jp.config.js"></script>

<script src="<?=base_url('admintheme')?>/js/ui-jp.js"></script>

<script src="<?=base_url('admintheme')?>/js/ui-nav.js"></script>

<script src="<?=base_url('admintheme')?>/js/ui-toggle.js"></script>

<script src="<?=base_url('admintheme')?>/js/ui-client.js"></script>

<script type="text/javascript">
  $(function() {
// setTimeout() function will be fired after page is loaded
// it will wait for 5 sec. and then will fire
// $("#successMessage").hide() function
var timeout = 3000;
$('.alert').delay(timeout).fadeOut(300);

});
</script>



</body>

</html>


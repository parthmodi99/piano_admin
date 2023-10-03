<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->model('Setting_model','setting_model');
$CI->load->model('Admin_model','admin_model');
 $admin = $this->session->userdata('admin');
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.1.1/jquery-confirm.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
  <script src="<?=base_url('admintheme')?>/libs/jquery/jquery/dist/jquery.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.1.1/jquery-confirm.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css">

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript">
    jQuery.browser = {};
    (function () {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    })();
</script>
</head>
<body>
<div class="app app-header-fixed <?= ($this->uri->segment(1) == 'Track' && ($this->uri->segment(2) == 'addTrack' || $this->uri->segment(2) == 'editTrack')) ? 'app-aside-folded' : '' ?>" id="sidebar_app">
  

    <!-- header -->
  <header id="header" class="app-header navbar" role="menu">
      <!-- navbar header -->
      <div class="navbar-header bg-dark">
        <button class="pull-right visible-xs dk" ui-toggle-class="show" target=".navbar-collapse">
          <i class="glyphicon glyphicon-cog"></i>
        </button>
        <button class="pull-right visible-xs" ui-toggle-class="off-screen" target=".app-aside" ui-scroll="app">
          <i class="glyphicon glyphicon-align-justify"></i>
        </button>
        <!-- brand -->
        
        <a href="<?=base_url().'Dashboard'?>" class="navbar-brand text-lt">
          <!--<i class="fa fa-btc"></i>-->
        <!--   <img src="" alt="Dalel" > --><!-- class="hide" -->
          <span class="hidden-folded m-l-xs">Piano</span>
        </a>
        <!-- / brand -->
      </div>
      <!-- / navbar header -->

      <!-- navbar collapse -->
      <div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
        <!-- buttons -->
        <div class="nav navbar-nav hidden-xs">
          <a href="#" class="btn no-shadow navbar-btn <?= ($this->uri->segment(1) == 'Track' && ($this->uri->segment(2) == 'addTrack' || $this->uri->segment(2) == 'editTrack')) ? 'active' : '' ?>" id="sidebar_app_icon" ui-toggle-class="app-aside-folded" target=".app">
            <i class="fa fa-dedent fa-fw text"></i>
            <i class="fa fa-indent fa-fw text-active"></i>
          </a>
          
        </div>
        <!-- / buttons -->
        

        <span id="time" style="display: none"></span>

        <!-- nabar right -->
        <ul class="nav navbar-nav navbar-right">

         <!-- <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
              <i class="icon-bell fa-fw"></i>
              <span class="visible-xs-inline">Notifications</span>
              <span class="badge badge-sm up bg-danger pull-right-xs" id="noti_count"></span>
            </a> -->
            <!-- dropdown -->
            <!-- <div class="dropdown-menu w-xl animated fadeInUp">
              <div class="panel bg-white">
                <div class="panel-heading b-light bg-light">
                  <strong>You have <span id="noti_count_on"></span> notifications</strong>
                </div>
                <div class="panel-footer text-sm">
                  <a href class="pull-right"><i class="fa fa-cog"></i></a>
                  <a href="<?php echo base_url()."notification/"; ?>" data-toggle="class:show animated fadeInRight">See all the notifications</a>
                </div>
              </div>
            </div> -->
            <!-- / dropdown -->
         <!--  </li> -->
        <!-- <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
              <i class="icon-envelope fa-fw"></i>
              <span class="visible-xs-inline">Messages</span>
              <span class="badge badge-sm up bg-danger pull-right-xs" id="noti_countmsg"></span>
            </a> -->
            <!-- dropdown -->
        <!--     <div class="dropdown-menu w-xl animated fadeInUp">
              <div class="panel bg-white">
                <div class="panel-heading b-light bg-light">
                  <strong>You have <span id="noti_count_onmsg"></span> New Massages</strong>
                </div>
                <div class="panel-footer text-sm">
                  <a href class="pull-right"><b style="color:red;"><span id='guardmessagecount'></span></b></a>
                  <a href="<?php echo base_url()."notification/Guardnotification"; ?>" data-toggle="class:show animated fadeInRight">See all the Massages from Guard</a>
                </div>
                  <div class="panel-footer text-sm">
                  <a href class="pull-right"><b style="color:red;"><span id='clientmessagecount'></span></b></a>
                  <a href="<?php echo base_url()."notification/Clientnotification"; ?>" data-toggle="class:show animated fadeInRight">See all the Massages from Client</a>
                </div>
              </div>
            </div> -->
            <!-- / dropdown -->
         <!--  </li> -->
            
          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle clear">
             <!--  <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
                <img src="" alt="admin">
                <i class="on md b-white bottom"></i>
              </span> -->
              <?php  $admin = $CI->admin_model->getSingleRecordById('tbl_admin',array('id' => $admin['id'])); 
              ?>
              <span class="hidden-sm hidden-md"><?=$admin['name']?></span> <b class="caret"></b>
            </a>
            <!-- dropdown -->
            <ul class="dropdown-menu animated fadeInRight w">
              
              <li>
                <a href="<?=base_url().'profile'?>">Profile</a>
              </li>
             
              <li class="divider"></li>
              <li>
                <a href="<?=base_url().'logout'?>">Logout</a>
              </li>
            </ul>
            <!-- / dropdown -->
          </li>
        </ul>
        <!-- / navbar right -->
      </div>
      <!-- / navbar collapse -->
  </header>
<!-- <script>
$(document).ready(function() {
    execComc();
    execComc_count();
    execComc_countmsg();
    execComc_ratting();
    execComcGuardMove();
    execComc_preattand();
    execComc_shiftstart();
//    execComc_changereq();
});
function execComc()
{
    setTimeout(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText)
            {
//                document.getElementById("txtHint").innerHTML = this.responseText;
                var e =document.getElementById("txtHint");
                e.innerHTML = this.responseText;
                while(e.firstChild) {
                    element.appendChild(e.firstChild);
                }
            }
        }
    };
    xmlhttp.open("GET",'<?php echo base_url()."notification/getguardinout"; ?>', true);
    xmlhttp.send();
        
    //client msges    
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText)
            {
//                document.getElementById("txtHint").innerHTML = this.responseText;
                var e =document.getElementById("txtHint");
                e.innerHTML = this.responseText;
                while(e.firstChild) {
                    element.appendChild(e.firstChild);
                }
            }
        }
    };
    xmlhttp.open("GET",'<?php echo base_url()."notification/getclientMsg"; ?>', true);
    xmlhttp.send();   
        
        
    execComc();
  }, 5000);
    
}
function execComcGuardMove()
{
    setTimeout(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText)
            {
//                document.getElementById("txtHint").innerHTML = this.responseText;
                var e =document.getElementById("txtHint");
                e.innerHTML = this.responseText;
                while(e.firstChild) {
                    element.appendChild(e.firstChild);
                }
            }
        }
    };
    xmlhttp.open("GET",'<?php echo base_url()."notification/getguardMove"; ?>', true);
    xmlhttp.send();   
        
    execComcGuardMove();
  }, 5000);
    
}
function execComc_ratting()
{
    setTimeout(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText)
            {
//                document.getElementById("txtHint").innerHTML = this.responseText;
                var e =document.getElementById("txtHint");
                e.innerHTML = this.responseText;
                while(e.firstChild) {
                    element.appendChild(e.firstChild);
                }
            }
        }
    };
    xmlhttp.open("GET",'<?php echo base_url()."notification/getRattingReview"; ?>', true);
    xmlhttp.send();   
    execComc_ratting();
  }, 5000);
    
}
function execComc_preattand()
{
    setTimeout(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText)
            {
//                document.getElementById("txtHint").innerHTML = this.responseText;
                var e =document.getElementById("txtHint");
                e.innerHTML = this.responseText;
                while(e.firstChild) {
                    element.appendChild(e.firstChild);
                }
            }
        }
    };
    xmlhttp.open("GET",'<?php echo base_url()."notification/getpreatt"; ?>', true);
    xmlhttp.send();   
    execComc_preattand();
  }, 5000);
    
}
function execComc_shiftstart()
{
    setTimeout(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText)
            {
//                document.getElementById("txtHint").innerHTML = this.responseText;
                var e =document.getElementById("txtHint");
                e.innerHTML = this.responseText;
                while(e.firstChild) {
                    element.appendChild(e.firstChild);
                }
            }
        }
    };
    xmlhttp.open("GET",'<?php echo base_url()."notification/shiftstart"; ?>', true);
    xmlhttp.send();   
    execComc_shiftstart;
  }, 5000);
    
}

function execComc_count()
{
    //noti_count-----    
    setTimeout(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText)
            {
                document.getElementById("noti_count").innerHTML = this.responseText;
                document.getElementById("noti_count_on").innerHTML = this.responseText;
            }
        }
    };
    xmlhttp.open("GET",'<?php echo base_url()."notification/getguardinout_count"; ?>', true);
    xmlhttp.send();  
    execComc_count();
  }, 5000);
}
function execComc_countmsg()
{
    //noti_count-----    
    setTimeout(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText)
            {
                document.getElementById("noti_countmsg").innerHTML = this.responseText;
                document.getElementById("noti_count_onmsg").innerHTML = this.responseText;
            }
        }
    };
    xmlhttp.open("GET",'<?php echo base_url()."notification/getguardinout_countmsg"; ?>', true);
    xmlhttp.send();
        
    //get guard message count

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText)
            {
                document.getElementById("guardmessagecount").innerHTML = this.responseText;
            }
        }
    };
    xmlhttp.open("GET",'<?php echo base_url()."notification/getguardonlycount"; ?>', true);
    xmlhttp.send();
        
    //get client message count
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText)
            {
                document.getElementById("clientmessagecount").innerHTML = this.responseText;
            }
        }
    };
    xmlhttp.open("GET",'<?php echo base_url()."notification/getclientonlycount"; ?>', true);
    xmlhttp.send();  
        
    execComc_countmsg();
  }, 5000);
}
    </script> -->
    <script>
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script type="text/javascript">


    window.onload = setInterval(clock,1000);

    function clock()
    {

     
    var aestTime = new Date().toLocaleString("en-US", {timeZone: "Europe/Paris"});
    var d = new Date(aestTime);
    //console.log(d);
    var date = d.getDate();
    
    var month = d.getMonth();
    var montharr =["Jan","Feb","Mar","April","May","June","July","Aug","Sep","Oct","Nov","Dec"];
    month=montharr[month];
    
    var year = d.getFullYear();
    
    var day = d.getDay();
    var dayarr =["Sun","Mon","Tues","Wed","Thurs","Fri","Sat"];
    day=dayarr[day];
    
    var hour =d.getHours();
      var min = d.getMinutes();
    var sec = d.getSeconds();
  
    //document.getElementById("date").innerHTML=day+" "+date+" "+month+" "+year;
    document.getElementById("time").innerHTML=day+" "+date+" "+month+" "+year+'  '+hour+":"+min;
    }
  </script>
    <style>
        #alert_noti{
            z-index: 1050;
            position: fixed;
            margin-left:75%;
        }
    </style>
    <div id='txtHint'></div>
  <!-- / header -->
<?php include('header.php') ?>

<?php include('sidebar.php') ?>
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>

<script type="text/javascript">

function areyousure(id)

{

  $.confirm({

    title: 'Delete Goal',

     content: 'Are you sure you want to delete?',

    buttons: {

        confirm: function () {

            window.location='<?=base_url()?>Goal/destroy/'+id;

        },

        cancel: function () {

            return true;

        },

    }



  });

}

function change_status(page_id,status){

  $.ajax({

    url:'<?=base_url()?>users/update_user_status',

    type: "POST",

    //data: 'page_id='+page_id+'&status='+status,

    data: {

          "<?=$this->security->get_csrf_token_name();?>" : "<?=$this->security->get_csrf_hash();?>",

          'user_id':page_id,

          'status':status

        },

    success: function(html){

      if(html == 1){



        if(status == 'Active')

        {

          var but = '<a href="javascript:;" title="Unapprove User" class="btn btn-xs btn-default" onclick="change_status('+"'"+page_id+"'"+','+"'Inactive'"+');"><i class="fa fa fa-thumbs-o-up" style="color:#090;"></i></a>';

          var sp = '<span class="label label-success">Active</span>';

        }

        if(status == 'Inactive')

        {

          var but = '<a href="javascript:;" title="Approve User" class="btn btn-xs btn-default" onclick="change_status('+"'"+page_id+"'"+','+"'Active'"+');"><i class="fa fa-thumbs-o-down" style="color:#F00;"></i></a>';

          var sp = '<span class="label label-danger">Inactive</span>';

        }

        $('#status_'+page_id).html(but);

        $('#status_sp_'+page_id).html(sp);

        //window.location.reload();

      }

    }

   });

}

function verify(id,status){

  //alert(status);

  $.ajax({

    url:'<?=base_url()?>User/update_user_status',

    type: "POST",

    //data: 'page_id='+page_id+'&status='+status,

    data: {

          "<?=$this->security->get_csrf_token_name();?>" : "<?=$this->security->get_csrf_hash();?>",

          'user_id':id,

          'status':status

        },

    success: function(html){

        window.location.reload();



    }

   });

}

function block(id,status){


  if(status == 0)
  {
      var tt = "Unblock User";
      var msg = "Are you sure you want to unblock user?";
  }
  else
  {
    var tt = "Block User";
    var msg = "Are you sure you want to block user?";
  }
   $.confirm({

    title: tt,

    content: msg,

    buttons: {

        confirm: function () {

              $.ajax({

                url:'<?=base_url()?>User/user_block',

                type: "POST",

                //data: 'page_id='+page_id+'&status='+status,

                data: {

                      "<?=$this->security->get_csrf_token_name();?>" : "<?=$this->security->get_csrf_hash();?>",

                      'user_id':id,

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

function pro_user(id,status,name){

  console.log(name);
  if(status == 0)
  {
      var tt = "Normal User";
      var msg = "Are you sure you want to make "+ name +" to normal user?";
  }
  else
  {
    var tt = "Pro User";
    var msg = "Are you sure you want to make "+ name +" to pro user?";
  }
   $.confirm({

    title: tt,

    content: msg,

    buttons: {

        confirm: function () {

              $.ajax({

                url:'<?=base_url()?>User/pro_user',

                type: "POST",

                //data: 'page_id='+page_id+'&status='+status,

                data: {

                      "<?=$this->security->get_csrf_token_name();?>" : "<?=$this->security->get_csrf_hash();?>",

                      'user_id':id,

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


function get_user_details(user_id)

{

  var modal = document.getElementById("myModal_"+user_id);


  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close "+user_id)[0];

  // When the user clicks the button, open the modal 

    modal.style.display = "block";

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

    var po_id=user_id+'user_pop';

    document.getElementById(po_id).innerHTML='';

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById(po_id).innerHTML=this.responseText;

            }

        };

      xhttp.open("GET", "userview/"+user_id, true);

      xhttp.send();
}


function get_refferal_details(user_id)

{

  var modal = document.getElementById("refferal_"+user_id);


  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close refferal_"+user_id)[0];

  // When the user clicks the button, open the modal 

    modal.style.display = "block";

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

    var po_id=user_id+'_referral_pop';

    document.getElementById(po_id).innerHTML='';

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById(po_id).innerHTML=this.responseText;

            }

        };

      xhttp.open("GET", "refferalview/"+user_id, true);

      xhttp.send();
}



</script>


<!-- content -->

  <div id="content" class="app-content" role="main">



    <div class="app-content-body ">

<div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="

    app.settings.asideFolded = false;

    app.settings.asideDock = false;

  ">

<div class="col">

<div class="bg-light lter b-b wrapper-md">

    <h1 class="m-n font-thin h3">Users</h1>

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

   <!-- <div class="row">

      <div class="col-md-12">

        <a href="<?=base_url()?>clients/addClient" class="btn btn-default " style="float: right;margin-top:15px;margin-right:15px;  ">Add Client</a>

      </div>

    </div> -->

     <div class="table-responsive">



      <table id="examples" class="ui celled table" style="width:100%">

        <thead>

        <tr>

        <th> Sr No.</th>

        <th> Name </th>

        <th> Created By  </th>

        <th> Action </th>

        </tr>

        </thead>

      <tbody>

          <!-- <?php if(!empty($user)) : $i=1;foreach($user as $row) : ?>
            <?php
            $CI =& get_instance();
            $CI->load->model('Admin_model');
            $seven_day = $CI->Admin_model->getlast7dayworkout($row['id'],$row['timezone']);
            $all_day = $CI->Admin_model->getallworkout($row['id']);
            ?>

            <tr>

            <td>

               <?=$i;?>

              </td>

              <td>

                <?=$row['name'];?>

              </td>

              <td>

                <?=$row['email'];?>

              </td>

              <td>
                <?php
                if($row['is_pro_user'] == 1)
                {
                  $typ = 'Pro User';
                }
                else
                {
                  $typ = 'Normal User';
                }
                ?>
                <?=$typ;?>

              </td>

              <td>
                  <?=$all_day;?>
              </td>
              <td>
                  <?=$seven_day;?>
              </td>




             <td>





              <a class="btn btn-info btn-xs clickuserbtn" title="User Profile"  data-toggle="modal" data-target="#<?=$row['id']?>" data-id="<?=$row['id']?>" onclick="get_user_details(<?=$row['id']?>)"><i class="fa fa-eye"></i></a>

              <?php

              if($row['is_block'] == 0)

              {

              ?>

              <a href="javascript:;" title="Block" class="btn btn-xs btn-default" onclick="block('<?=$row['id']?>','1');" > <B style="color:#090;size:40px;">Block</B></a>

                <?php

              }

              else

              {

              ?>

              <a href="javascript:;" title="Unblock" class="btn btn-xs btn-default" onclick="block('<?=$row['id']?>','0');" ><B style="color:#F00;">Unblock</B></a>

              <?php

              }

              ?>



             <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(<?=$row['id']?>)"><i class="fa fa-times"></i></a>

                </td>

            </tr>

            <div class="modal fade" id="<?=$row['id']?>" role="dialog">

                <div class="modal-dialog">





                  <div class="modal-content">

                    <div class="modal-header">

                      <button type="button" class="close" data-dismiss="modal">&times;</button>

                      <h4 class="modal-title">User Detail</h4>

                    </div>

                    <div class="modal-body user" id="<?=$row['id']?>user_pop" style="height: 400px;overflow: scroll;">



                    </div>

                    <div class="modal-footer">

                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>

                  </div>



                </div>

              </div>

            <?php $i++; endforeach; endif; ?> -->

      </tbody>

      </table>

    </div>

     <!-- Modal -->



  </div>

</div>

  </div>

  </div>

  </div>


      <script>
  /*$(document).ready(function() {
    $('#examples').DataTable({
      "pageLength": 100
    });
} );*/

  $(document).ready(function() {
           $('#examples').dataTable({
            destroy: true,
            serverSide: true,
            "lengthChange": true,
            "pageLength": 100,
            "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('offersDataTables', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('offersDataTables'));
            },
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
              orderable: true
            },
            {
              targets: [ 3 ],
              orderable: false
            },
            ],
            ajax : {
              url : "<?=base_url().'Goal/getAllgoalsData'?>",
              type : "POST"
            },
            columns: [
            { data: "id" },
            { data: "name" },
            { data: "is_created_by_admin" },
            { data: "action" }
            ]
          });
         } );
</script>


<!-- /content -->

<?php include('footer.php') ?>

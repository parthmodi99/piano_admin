<?php include('header.php') ?>

<?php include('sidebar.php') ?>

<script src="<?=base_url('admintheme')?>/ckeditor/ckeditor.js"></script>

<script src="<?=base_url('admintheme')?>/ckeditor/samples/js/sample.js"></script>

<script type="text/javascript">

function areyousure(id)

{

  $.confirm({

    title: 'Delete Admin',

     content: 'Are you sure you want to delete?',

    buttons: {

        confirm: function () {

            window.location='<?=base_url()?>SubAdmin/delete_subadmin/'+id;

        },

        cancel: function () {

            return true;

        },

    }



  });

}

/*function clientMail(email,fullname,password)

{

    $.confirm({

    title: 'Send Mail',

     content: 'Are you sure you want to Send Credential on Mail?',

    buttons: {

        confirm: function () {

            window.location='<?=base_url()?>clients/sendMail/'+email+'/'+fullname+'/'+password;

        },

        cancel: function () {

            return true;

        },

    }



  });

      

}*/

function clientMail(id)
{
    $.confirm({

    title: 'Send Credential',

     content: 'Are you sure you want to send credential on mail?',

    buttons: {

        confirm: function () {

            window.location='<?=base_url()?>SubAdmin/sendMail/'+id;

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
      var tt = "Unblock Admin";
      var msg = "Are you sure you want to unblock Admin?";
  }
  else
  {
    var tt = "Block Admin";
    var msg = "Are you sure you want to block Admin?";
  }
   $.confirm({

    title: tt,

    content: msg,

    buttons: {

        confirm: function () {

              $.ajax({

                url:'<?=base_url()?>SubAdmin/admin_block',

                type: "POST",

                //data: 'page_id='+page_id+'&status='+status,

                data: {

                      "<?=$this->security->get_csrf_token_name();?>" : "<?=$this->security->get_csrf_hash();?>",

                      'admin_id':id,

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

    var po_id=user_id+'user_pop';

    document.getElementById(po_id).innerHTML='';

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById(po_id).innerHTML=this.responseText;            

            }

        };

      xhttp.open("GET", "User/userview/"+user_id, true);

      xhttp.send();

    

}

function pro_user(id,status,name){


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

    <h1 class="m-n font-thin h3">Sub Admin</h1>

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

   <div class="row">

      <div class="col-md-12">

        <a href="<?=base_url()?>SubAdmin/addAdmin" class="btn btn-default " style="float: right;margin-top:15px;margin-right:15px;  ">Add Sub Admin</a>

      </div>

    </div>

     <div class="table-responsive">



      <table id="examples" class="ui celled table" style="width:100%">

        <thead>

        <tr>

        <th> Sr No.</th>

        <th> Name</th>

        <th> Email  </th>

        <th> Password  </th>

        <th> Total Uploaded Track  </th>

        <th> Created At  </th>

        <th> Action </th>

        </tr>

        </thead>

      <tbody>

        <?php 
            $CI =& get_instance();
            $CI->load->model('Admin_model');
            ?>
          <?php if(!empty($admins)) : $i=1;foreach($admins as $row) : ?>

            <?php 
            $track = $CI->Admin_model->getAllRecordscountById('tbl_track',array('sub_admin_id' => $row['id']));
            ?>


            <tr>

            <td>

               <?=$i;?>

              </td>

              <td>

                <?=$row['name'];?>

              </td>

              <td>

                <?=$row['email_id'];?>

              </td>

              <td>

                <?= base64_decode($row['base_password']);?>

              </td>

              <td><?= $track ?></td>

              <td>
                  <?=$row['created_at'];?>
              </td>
          
             <td>  

              <a href="<?= base_url() ?>SubAdmin/getprofile/<?= $row['id'] ?>" class="btn btn-info btn-xs clickuserbtn" title="Sub Admin Profile" id="myBtn" data-id="24"><i class="fa fa-eye"></i></a>

              <?php 

              if($row['status'] == 1)

              {

              ?>

              <a href="javascript:;" title="Block" class="btn btn-xs btn-default" onclick="block('<?=$row['id']?>','0');" > <B style="color:#090;size:40px;">Block</B></a>

                <?php 

              }

              else

              {

              ?>

              <a href="javascript:;" title="Unblock" class="btn btn-xs btn-default" onclick="block('<?=$row['id']?>','1');" ><B style="color:#F00;">Unblock</B></a>

              <?php

              }

              ?>

              <a class="btn btn-xs btn-warning" title="Edit" href="<?=base_url().'SubAdmin/editAdmin/'.base64_encode($row['id'])?>"><i class="fa fa-pencil"></i></a> 

             

             <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(<?=$row['id']?>)"><i class="fa fa-times"></i></a>

             <a href="javascript:;" title="Send Credential Mail" class="btn btn-xs btn-info" onclick="clientMail(<?=$row['id']?>);"><i class="fa fa-share-square"></i></a>

                </td>

            </tr>

            <?php $i++; endforeach; endif; ?>

      </tbody>

      </table>

    </div> 

     <!-- Modal -->

  <div class="modal fade" id="myModal" role="dialog">

    <div class="modal-dialog modal-lg">

    

      <!-- Modal content-->

      <!-- <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">User Detail</h4>

        </div>

        <div class="modal-body">

          <table class="table table-striped b-t b-b">

            <thead>

              <tr>

                <th> Sr No.</th>

                <th> Name  </th>

                <th> Email </th>

                <th> Age </th>

                <th> Mobile </th>

              </tr>

            </thead>

            <tbody class="GuardLocatinDetail">

              

            </tbody>

          </table>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>

      </div> -->

      

    </div>

  </div>

  </div>

</div>

  </div>

  </div>

  </div>

      <script>
  $(document).ready(function() {
    $('#examples').DataTable({
      "pageLength": 100,
      "bStateSave": true,
      "fnStateSave": function (oSettings, oData) {
          localStorage.setItem('offersDataTables', JSON.stringify(oData));
      },
      "fnStateLoad": function (oSettings) {
          return JSON.parse(localStorage.getItem('offersDataTables'));
      }
    });
} );
</script>

<!-- /content -->

<?php include('footer.php') ?>
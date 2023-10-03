<?php include('header.php') ?>

<?php include('sidebar.php') ?>

<script src="<?=base_url('admintheme')?>/ckeditor/ckeditor.js"></script>

<script src="<?=base_url('admintheme')?>/ckeditor/samples/js/sample.js"></script>

<script type="text/javascript">

  function areyousure(id)

  {

    $.confirm({

      title: 'Delete User',

      content: 'Are you sure you want to delete?',

      buttons: {

        confirm: function () {

          window.location='<?=base_url()?>User/delete_client/'+id;

        },

        cancel: function () {

          return true;

        },

      }



    });

  }

  function clientMail(email,fullname,password)

  {

    $.confirm({

      title: 'Send Mail',

      content: 'Are you sure you want to Send Mail?',

      buttons: {

        confirm: function () {

          window.location='<?=base_url()?>clients/sendMail/'+email+'/'+fullname+'/'+password;

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

function UserDetail(user_id)

{

  // $('.GuardLocatinDetail').html('');



  $.ajax({

   type: "POST",

     url: '<?=base_url()?>User/UserDetail', // the method we are calling

     data: {"<?=$this->security->get_csrf_token_name();?>" : "<?=$this->security->get_csrf_hash();?>",

     "id" : user_id},

     success: function (result) {

      let guardShidtDetail = JSON.parse(result);

      var response_html = ``;



      sr_no = 1;

      for(let i = 0; i < guardShidtDetail.length; i++) {

        let guard = guardShidtDetail[i];

        response_html += `<tr>`;

        response_html += `<td>`;              

        response_html +=  sr_no++;              

        response_html += `</td>`;              

        response_html += `<td>`;              

        response_html += guard.name;              

        response_html += `</td>`;              

        response_html += `<td>`;              

        response_html += guard.email;            

        response_html += `</td>`;              

        response_html += `<td>`;              

        response_html += guard.age;            

        response_html += `</td>`;              

        response_html += `<td>`;              

        response_html += guard.mobile;           

        response_html += `</td>`;                           

        response_html += `</tr>`;

      }

      $('.GuardLocatinDetail').html(response_html);

    },

    error: function (result) {

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

        <h1 class="m-n font-thin h3">Notification Management</h1>

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

        <div class="table-responsive">
          <form method="POST" action="<?php echo base_url(); ?>notification/notificationsend" enctype= "multipart/form-data">
          <div class="form-group col-md-12">
            <label style="padding-top:15px;">Select Type</label>
            <select name="usertype" onChange="deactive(this.value)" class="form-control">
              <option value="">Select Type</option>
              <option value="all">All User</option>
              <option value="specific" selected>Specific User</option>

            </select>


            <div id="specifi_user" style="display: block;">
              <div id="search_option" style="padding-top:15px;">
                <label style="padding-top:15px;">Select Specific User</label>
                <select class="chosen2" id="gh" multiple="true" style="width: 100%;" name="user_id[]" >
                 <?php foreach ($user as $show) { ?>
                  <?php 

                  $js = $show['name'].' - '.$show['email'];
                  ?>
                  <option  value="<?php echo $show['id']; ?>"><?php echo trim($js); ?></option>
                <?php } ?>
              </select>

            </div>
          </div>

          <label style="padding-top:15px;">Title</label>
          <input type="text" name="title" class="form-control" required>

          <label style="padding-top:15px;">Message box</label>
          <textarea rows="4" cols="50" name="message" class="form-control" required="required"></textarea>



          <input type="submit" style="margin-top:15px;" class="btn btn-primary" value="Send">
          <!-- <input type="submit" style="margin-top:15px;" class="btn btn-primary" value="send to all" name="all_email"> -->
        </div>
      </form>
      </div>



    </div>

  </div>

</div>

</div>

</div>



<?php include('footer.php') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.6.2/chosen.jquery.js"></script>

<script type="text/javascript">


  function deactive(type) {

    if(type == 'all')
    {
      var d = document.getElementById('specifi_user');
      d.style.display = 'none';
    }
    else
    {
      var d = document.getElementById('specifi_user');
      d.style.display = 'block';
    }

  }

</script>
<script type="text/javascript">
  $(document).ready(function(){
    $(".chosen2").chosen();
  });
</script>

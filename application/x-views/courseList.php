<?php include('header.php') ?>

<?php include('sidebar.php') ?>

<script src="<?= base_url('admintheme') ?>/ckeditor/ckeditor.js"></script>
<script src="<?= base_url('admintheme') ?>/ckeditor/samples/js/sample.js"></script>
<style>
  .ui-sortable tr {
    cursor: pointer;
  }
</style>

<!-- content -->

<div id="content" class="app-content" role="main">



  <div class="app-content-body ">

    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="

    app.settings.asideFolded = false; 

    app.settings.asideDock = false;

  ">

      <div class="col">

        <div class="bg-light lter b-b wrapper-md">

          <h1 class="m-n font-thin h3"> List</h1>

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

          if (validation_errors() != null) {

            echo '<div class="alert alert-danger">';

            echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

            echo validation_errors();

            echo '</div>';
          }



          if (isset($custome_error) && $custome_error != null) {

            echo '<div class="alert alert-warning">';

            echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

            echo $custome_error;

            echo '</div>';
          }

          ?>

          <div class="row">
            <div class="col-md-10" style="margin-top:15px;">
              <form name="courses" id="courses"
                action="<?=base_url().'Course/'?><?php if(!empty($course_title)){echo "updateCoursetitle/";}else{echo "addCoursetitle";} ?>"
                method="post" class="form-horizontal" role="form">
                <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">Title<span class="text-primary"
                      style="color:#a94442;">*</span></label>

                  <div class="col-sm-2">
                    <input type="text" placeholder="Title" class="form-control" name="title"
                      value="<?php  if (!empty($course_title)){ echo $course_title[0]["title"]; } ?>" required />
                  </div>

                  <label for="description" class="col-sm-2 control-label" style="width: 7%;">Description<span
                      class="text-primary" style="color:#a94442;">*</span></label>

                  <div class="col-sm-2">
                    <input type="text" placeholder="Description" class="form-control" name="description"
                      value="<?php  if (!empty($course_title)){ echo $course_title[0]["description"]; } ?>" required />
                  </div>

                  <input type="submit" name="submit" class="btn btn-sm btn-primary"
                    value="<?php if (!empty($course_title)){ echo "Update"; }else{ echo "Save"; }?>" />
                </div>
              </form>
            </div>

            <div class="col-md-2">
              <a href="#" class="btn btn-default updatePosition" style="float: right;margin:15px;margin-right:15px; "> Update </a>
              <a href="<?= base_url() ?>/course/addCourse" class="btn btn-default " style="float: right;margin-top:15px"> Add </a>
            </div>

          </div>

          <div class="table-responsive">
            <table id="examples" class="ui celled table" style="width:100%">
              <thead>
                <tr>
                  <th> Sr No.</th>
                  <th> Level Name</th>
                  <th> Coming Soon </th>
                  <th> Created At </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>

                <?php

                ?>
                <?php if (!empty($course)) : $i = 1;
                  foreach ($course as $row) : ?>


                <tr id="<?= $row['id']; ?>">
                  <td> <?= $i; ?> </td>

                  <td>
                    <?= $row['name']; ?>
                  </td>

                  <td>
                    <?php if($row['coming_soon'] == 1){echo "Yes";}else{echo "No";}?>
                  </td>

                  <td>
                    <?= $row['created_at']; ?>
                  </td>

                  <td>
                    <a class="btn btn-xs btn-warning" title="Edit"
                      href="<?= base_url() . 'Course/editCourse/' . base64_encode($row['id']) ?>"><i
                        class="fa fa-pencil"></i></a>

                    <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger"
                      onclick="areyousure(<?= $row['id'] ?>)"><i class="fa fa-times"></i></a>
                  </td>
                </tr>

                <?php $i++;
                  endforeach;
                endif; ?>

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
  function areyousure(id)
  {
    $.confirm({
      title: 'Delete  ',
      content: 'Are you sure you want to delete?',
      buttons: {
        confirm: function () {
          window.location = '<?= base_url('course/delete/') ?>' + id
        },

        cancel: function () {
          return true;
        },
      }
    });
  }

  function get_user_details(user_id)
  {
    var po_id = user_id + 'user_pop';

    document.getElementById(po_id).innerHTML = '';
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(po_id).innerHTML = this.responseText;
      }
    };

    xhttp.open("GET", "User/userview/" + user_id, true);

    xhttp.send();
  }

  $(document).ready(function () {
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

    $("#examples tbody").sortable({
      cursor: "move",
      placeholder: "sortable-placeholder",
      helper: function(e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();
        $helper.children().each(function(index) {
          // Set helper cell sizes to match the original sizes
          $(this).width($originals.eq(index).width());
        });
        return $helper;
      }
    }).disableSelection();

    $('.updatePosition').click(function () {

      let data = []

      $('#examples tbody tr').each(function (index) {
        var id = $(this).attr('id');
        data.push({
          id: id,
          position: index
        });
      });

      $.ajax({
        type: "POST",
        url: "Course/updatePosition",
        data: {
          data: data
        },
        cache: false,
        'Content-Type': "application/json",
        success: function (result) {

          var data = (JSON.parse(result));
          console.log(data);

          if (data.status) {
            window.location.reload(true);
          }

        }
      });

    });
  });  
</script>

<!-- /content -->

<?php include('footer.php') ?>
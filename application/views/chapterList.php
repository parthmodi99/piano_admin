<?php include('header.php') ?>

<?php include('sidebar.php') ?>

<script src="<?= base_url('admintheme') ?>/ckeditor/ckeditor.js"></script>
<script src="<?= base_url('admintheme') ?>/ckeditor/samples/js/sample.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<style>
  .ui-sortable tr {
    cursor: pointer;
  }
</style>



<div id="content" class="app-content" role="main">

  <div class="app-content-body ">
    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="app.settings.asideFolded = false;app.settings.asideDock = false;">
      <div class="col">

        <div class="bg-light lter b-b wrapper-md">
          <h1 class="m-n font-thin h3">List</h1>
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
            <div class="col-md-12">
            <a href="#" class="btn btn-default updatePosition" style="float: right;margin:15px;margin-right:15px; ">Update</a>
              <a href="<?= base_url() ?>Chapter/addChapter" class="btn btn-default " style="float: right;margin-top:15px;">Add </a>
            </div>
          </div>

          <div class="table-responsive">
            <table id="examples" class="ui celled table" style="width:100%">
              <thead>
                <tr>
                  <th> Sr No.</th>
                  <th> Chapter Name</th>
                  <th> Lesson Name</th>
                  <th> Created At </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  if (!empty($chapter)) : $i = 1;
                  foreach ($chapter as $row) : 
                  ?>
                    <tr id="<?= $row['id']; ?>">
                      <td><?= $i; ?></td>
                      <td><?= $row['lession_name']; ?></td>
                      <td><?= $row['title']; ?></td>
                      <td><?= $row['created_at']; ?></td>
                      <td>
                        <a class="btn btn-xs btn-warning" title="Edit" href="<?= base_url() . 'Chapter/editChapter/' . base64_encode($row['id']) ?>"><i class="fa fa-pencil"></i></a>
                        <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(<?= $row['id'] ?>)"><i class="fa fa-times"></i></a>
                        <a href="javascript:void(0);" title="View" data-toggle="modal" data-target="#viewChapter" class="btn btn-xs btn-danger" onclick="viewChapter(<?= $row['id'] ?>)"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>

                <?php $i++;
                  endforeach;
                endif; ?>

              </tbody>
            </table>
          </div>

          <!-- <div class="row">
            <div class="col-md-12 mt-4 mb-4">
              <a href="#" class="btn btn-default updatePosition" style="float: right;margin:15px;margin-right:15px; ">Update</a>
            </div>
          </div> -->

        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="viewChapter" role="dialog">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail</h4>
      </div>

      <div class="modal-body">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function viewChapter(id) {
    $.ajax({
      type: "GET",
      url: "Chapter/chapterview/" + id,
      data: {},
      cache: false,
      'Content-Type': "application/json",
      success: function(data) {

        var result = (JSON.parse(data));
        var html = ''
        $('#viewChapter .modal-body').html('');

        html += `<div id="sec_2" class="addpianospace draggable" style="border: 2px solid #000000;padding: 10px;margin: 25px;">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="col-sm-4">
                        <lable>Lession Name</lable>
                          <input type="text" readonly value="${result?.lession?.name}"  class="form-control" >
                      </div>
                      <div class="col-sm-4">
                        <lable>Title</lable>
                          <input type="text" readonly value="${result?.chapter?.title}"  class="form-control" >
                      </div>
                  </div>
              </div>
          </div> `;

        result.chapter_detail.forEach(element => {

          if (element.type == 'media') {

            var fileName = element.media.split(/\\/).pop();
            var fileExt = fileName.split('.').pop().toLowerCase();
            var video_ext = ['mp4', 'mp3', 'mov', 'm4v', 'avi'];

            if (video_ext.includes(fileExt)) {

              html += `<div class="panel-body">
                      <div class="section droppable ui-sortable" id="section_html">
                          <div id="sec_1" class="addpianospace draggable" style="border: 2px solid #000000;padding: 10px;margin: 15px;">
                              <div class="row">
                                  <div class="col-sm-12">
                                      <div class="col-sm-6">
                                        <video id="video1" controls width="400" >
                                            <source src="http://18.235.99.234/piano_test/APIs/uploads/chapter/${element.media}" type="video/mp4">
                                        </video>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>`;

            } else {

              html += `<div class="panel-body">
                      <div class="section droppable ui-sortable" id="section_html">
                          <div id="sec_1" class="addpianospace draggable" style="border: 2px solid #000000;padding: 10px;margin: 15px;">
                              <div class="row">
                                  <div class="col-sm-12">
                                      <div class="col-sm-6">
                                          <img src="http://18.235.99.234/piano_test/APIs/uploads/chapter/${element.media}"
                                              style="margin-top: 10px;height: 100px;width: 150px;" alt="" class="img-thumbnail sec_1">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>`;
            }


          } else if (element.type == 'button') {

            html += `<div id="sec_2" class="addpianospace draggable" style="border: 2px solid #000000;padding: 10px;margin: 25px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-4">
                                  <lable>Button Name</lable>
                                    <input type="text" readonly value="${element.media}"  class="form-control" >
                                </div>
                                <div class="col-sm-4">
                                  <lable>Button Note</lable>
                                    <input type="text" readonly value="${element.note}"  class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div> `;

          }else if (element.type == 'metronome') {

              html += `<div id="sec_2" class="addpianospace draggable" style="border: 2px solid #000000;padding: 10px;margin: 25px;">
                          <div class="row">
                              <div class="col-sm-12">
                                  <div class="col-sm-4">
                                      <input type="text" readonly value="${element.media}"  class="form-control" >
                                  </div>
                              </div>
                          </div>
                      </div> `;

              }

        });


        $('#viewChapter .modal-body').html(html);

      }
    });


  }


  function areyousure(id) {
    $.confirm({
      title: 'Delete Chapter',
      content: 'Are you sure you want to delete?',
      buttons: {
        confirm: function() {
          window.location = '<?= base_url() ?>Chapter/delete/' + id;
        },
        cancel: function() {
          return true;
        },
      }
    });

  }


  function get_user_details(user_id) {

    var po_id = user_id + 'user_pop';
    document.getElementById(po_id).innerHTML = '';
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById(po_id).innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "User/userview/" + user_id, true);
    xhttp.send();
  }

  $(document).ready(function() {

    // $('table').each(function() {
    //   var table = $(this);
    //   var dataTable = $(this).DataTable({
    //     "aaSorting": [
    //       [1, "asc"]
    //     ],
    //     stateSave: true,
    //     "lengthMenu": [
    //       [10, 25, 50, 100, -1],
    //       [10, 25, 50, 100, "All"]
    //     ],
    //     rowReorder: true
    //   });
    //   var thead = table.find('thead');
    //   var tbody = table.find('tbody');
    //   var dataTable = table.DataTable();
    //   var page_length = null;
    // });

    $('#examples').DataTable({
      "pageLength": 100,
      "bStateSave": true,
      "fnStateSave": function(oSettings, oData) {
        localStorage.setItem('offersDataTables', JSON.stringify(oData));
      },
      "fnStateLoad": function(oSettings) {
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

    $('.updatePosition').click(function() {

      let data = []

      $('#examples tbody tr').each(function(index) {
        var id = $(this).attr('id');
        // alert(id);
        data.push({
          id: id,
          position: index
        });
      });

      $.ajax({
        type: "POST",
        url: "Chapter/updatePosition",
        data: {
          data: data
        },
        cache: false,
        'Content-Type': "application/json",
        success: function(result) {

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


<?php include('footer.php') ?>
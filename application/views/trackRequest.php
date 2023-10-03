<?php include('header.php') ?>

<?php include('sidebar.php') ?>

<script src="<?= base_url('admintheme') ?>/ckeditor/ckeditor.js"></script>

<script src="<?= base_url('admintheme') ?>/ckeditor/samples/js/sample.js"></script>

<script type="text/javascript">

function areyousure(id)

{

  $.confirm({

    title: 'Reject Track Request',

     content: 'Are you sure you want to reject?',

    buttons: {

        confirm: function () {
            window.location='<?=base_url()?>TrackRequest/editRequest/'+id+'/2';

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

                    <h1 class="m-n font-thin h3">Track Request</h1>

                </div>

                <div class="panel panel-default">

                    <?php

    if ($this->session->flashdata('error')) {

      echo '<div class="alert alert-danger">';

      echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

      echo $this->session->flashdata('error');

      echo '</div>';

    }

    if ($this->session->flashdata('success')) {

      echo '<div class="alert alert-success">';

      echo '<a class="close" data-dismiss="alert" href="#" aria-hidden="true">×</a>';

      echo $this->session->flashdata('success');

      echo '</div>';

    }

  ?>


                    <br>

                    <div class="table-responsive">



                        <table id="examples" class="ui celled table" style="width:100%">

                            <thead>

                                <tr>

                                    <th> Sr No.</th>

                                    <th> User name</th>

                                    <th> Track title</th>

                                    <th> Status </th>

                                    <th> Created At </th>

                                    <th> Action </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php 
           
            ?>
                                <?php if(!empty($track_request)) : $i=1;foreach($track_request as $row) : ?>


                                <tr>

                                    <td>

                                        <?=$i;?>

                                    </td>

                                    <td>

                                        <?=$row['name'];?>

                                    </td>

                                    <td>

                                        <?=$row['track_title'];?>

                                    </td>

                                    <td>

                                        <?php
                                            if($row['status'] == 0)
                                            {
                                                //pending
                                                ?>
                                        <!-- <span class="label label-success">Active</span> -->
                                        <span class="label label-warning">Pending</span>
                                        <?php
                                            }
                                            elseif($row['status'] == 1){
                                                //active
                                                ?>
                                        <!-- <span class="label label-default">Draft</span> -->
                                        <span class="label label-success">Active</span>
                                        <?php
                                            }
                                            else{
                                                //rejected
                                                ?>
                                        <span class="label label-danger">Reject</span>

                                        <?php
                                            }
                                            ?>

                                    </td>

                                    <td>
                                        <?=$row['created_at'];?>
                                    </td>

                                    <td>
                                    <?php
                                            if($row['status'] == 0)
                                            {
                                     ?>
                                     <a class="btn btn-xs btn-success" title="Accept"
                                            href="<?=base_url().'TrackRequest/editRequest/'.$row['id'].'/1'?>">Accept</a>

                                        <a class="btn btn-xs btn-danger" title="Reject"
                                            href="javascript:;"
                                            onclick="areyousure(<?=$row['id']?>)">Reject</a>

                                        <?php
                                            }
                                            ?>

                                    </td>

                                </tr>

                                <?php $i++; endforeach; endif; ?>

                            </tbody>

                        </table>

                    </div>

                    <!-- Modal -->

                    <div class="modal fade" id="myModal" role="dialog">

                        <div class="modal-dialog modal-lg">





                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
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
    });
</script>

<!-- /content -->

<?php include('footer.php') ?>
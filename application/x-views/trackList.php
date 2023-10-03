<?php include('header.php') ?>

<?php include('sidebar.php') ?>

    <script src="<?=base_url('admintheme')?>/ckeditor/ckeditor.js"></script>

    <script src="<?=base_url('admintheme')?>/ckeditor/samples/js/sample.js"></script>

    <script type="text/javascript">

        function areyousure(id)

        {

            $.confirm({

                title: 'Delete Track',

                content: 'Are you sure you want to delete?',

                buttons: {

                    confirm: function () {

                        window.location='<?=base_url()?>Track/delete_track/'+id;

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

                        <h1 class="m-n font-thin h3">Tracks List</h1>

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

                                    <th> Track Title</th>

                                    <th> Artist </th>

                                    <th> Type  </th>

                                    <th> Original Key  </th>

                                    <th> Status  </th>

                                    <?php 
                                        if($admin_type == 1) {
                                            ?>
                                        <th> Created By  </th>
                                    <?php } ?>

                                    <th> Total Mistake  </th>

                                    <th> Action </th>

                                </tr>

                                </thead>

                                <tbody>

                                <?php if(!empty($track)) : $i=1;foreach($track as $row) : ?>


                                    <tr>

                                        <td>

                                            <?=$i;?>

                                        </td>

                                        <td>

                                            <?=$row['title'];?>

                                        </td>

                                        <td>

                                            <?=$row['artist'];?>

                                        </td>

                                        <td>

                                            <?=$row['type'];?>

                                        </td>

                                        <td>

                                            <?=$row['original_key'];?>

                                        </td>

                                        <td>

                                            <?php
                                            if($row['status'] == 1)
                                            {
                                                //active
                                                ?>
                                                    <span class="label label-success">Active</span>
                                                <?php
                                            }
                                            elseif($row['status'] == 2){
                                                //draft
                                                ?>
                                                <span class="label label-default">Draft</span>
                                                <?php
                                            }
                                            else{
                                                //deactive
                                                ?>
                                                <span class="label label-danger">Deactive</span>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                        <?php 
                                        if($admin_type == 1)
                                        {
                                            ?>      
                                            <td>
                                                <?php
                                                if($row['name'] != '')
                                                {
                                                    ?>
                                                    <a href="<?= base_url() ?>SubAdmin/getprofile/<?= $row['admin_id'] ?>"><?= $row['name'] ?></a>
                                                    <?php
                                                } 
                                                else{
                                                    ?>
                                                    You
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                        <td>
                                            <?php 
                                            if($row['total_mistake'] != ''){
                                                $mistake = $row['total_mistake'];
                                            }
                                            else{
                                                $mistake = 0;
                                            }
                                            echo $mistake;
                                            ?>

                                        </td>
                                        <td>
                                            <a href="<?= base_url() ?>Track/editTrack/<?= $row['id'] ?>" class="btn btn-info btn-xs clickuserbtn" title="Edit"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;
                                            <?php 
                                            if($admin_type == 1)
                                            {
                                            ?>
                                                <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="areyousure(<?=$row['id']?>)"><i class="fa fa-times"></i></a>
                                            <?php } ?>

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
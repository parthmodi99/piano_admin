<?php include('header.php') ?>
<?php include('sidebar.php') ?>
<script src="<?=base_url('admintheme')?>/ckeditor/ckeditor.js"></script>
<script src="<?=base_url('admintheme')?>/ckeditor/samples/js/sample.js"></script>
<script type="text/javascript">
function areyousure(id)
{
  $.confirm({
    title: 'Delete Cms Page',
     content: 'Are you sure you want to delete?',
    buttons: {
        confirm: function () {
            window.location='<?=base_url()?>page/delete_page/'+id;
        },
        cancel: function () {
            return true;
        },
    }

  });
}

function get_content_details(id)

{

    var po_id=id+'user_pop';

    document.getElementById(po_id).innerHTML='';

        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById(po_id).innerHTML=this.responseText;            

            }

        };

      xhttp.open("GET", "Page/contentview/"+id, true);

      xhttp.send();

    

}

function change_status(page_id,status){
  $.ajax({
    url:'<?=base_url()?>page/update_page_status',
    type: "POST",
    //data: 'page_id='+page_id+'&status='+status,
    data: {
          "<?=$this->security->get_csrf_token_name();?>" : "<?=$this->security->get_csrf_hash();?>",
          'cms_id':page_id,
          'status':status
        },
    success: function(html){
      if(html == 1){
        
        if(status == 'Active')
        {
          var but = '<a href="javascript:;" title="Inactive Page" class="btn btn-xs btn-default" onclick="change_status('+"'"+page_id+"'"+','+"'Inactive'"+');"><i class="fa fa fa-thumbs-o-up" style="color:#090;"></i></a>';
          var sp = '<span class="label label-success">Active</span>';
        }
        if(status == 'Inactive')
        {
          var but = '<a href="javascript:;" title="Active Page" class="btn btn-xs btn-default" onclick="change_status('+"'"+page_id+"'"+','+"'Active'"+');"><i class="fa fa-thumbs-o-down" style="color:#F00;"></i></a>'; 
          var sp = '<span class="label label-danger">Inactive</span>';
        }
        $('#status_'+page_id).html(but);  
        $('#status_sp_'+page_id).html(sp);  
        
      }
      window.location.reload();
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
    <h1 class="m-n font-thin h3">Cms Page</h1>
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
     <table id="examples" class="display" style="width:100%">
        <thead>
        <tr>
         <th> Sr No.</th>
        <th> Page Title</th>
        <th> Page Slug</th>
        <th> Created Date</th>
        <th> Action </th>
        </tr>
        </thead>
      <tbody>
      <?php if(!empty($page)) : 
      $i=1;
          foreach ($page as $row) {
            ?>
            <tr id="del_<?=$row['id']?>">
              <td>
                <?=$i?>
              </td>
              <td>
                <?=$row['page_title']?>
              </td>
               <td>
                <?=$row['page_slug']?>
              </td>
              <td>
                <?=$row['created_at']?>
              </td>
              <td>  
                <a class="btn btn-info btn-xs clickuserbtn" title="Content"  data-toggle="modal" data-target="#<?=$row['id']?>" data-id="<?=$row['id']?>" onclick="get_content_details(<?=$row['id']?>)"><i class="fa fa-eye"></i></a>

             <a class="btn btn-xs btn-warning" title="Edit" href="<?=base_url().'page/editPage/'.base64_encode($row['id'])?>"><i class="fa fa-pencil"></i></a>  

                <a href="javascript:;" title="Delete" class="btn btn-xs btn-danger" onclick="return areyousure('<?=$row['id']?>');"><i class="fa fa-times"></i></a> 
                <!-- <span id="status_<?=$row['cms_id']?>">
                <?php if($row['status']=='0'):?>
                    <a href="javascript:;" title="Inactive Page" class="btn btn-xs btn-default" onclick="change_status('<?=$row['cms_id']?>','Active');"><i class="fa fa-thumbs-o-down" style="color:#F00;"></i></a>
                <?php endif; ?>
                <?php if($row['status']=='1'):?>
                    <a href="javascript:;" title="Active Page" class="btn btn-xs btn-default" onclick="change_status('<?=$row['cms_id']?>','Inactive');"><i class="fa fa-thumbs-o-up" style="color:#090;"></i></a>
                <?php endif; ?>
                </span> -->
                </td>
            </tr>
            <div class="modal fade" id="<?=$row['id']?>" role="dialog">

                <div class="modal-dialog">

                

                  <!-- Modal content-->

                  <div class="modal-content">

                    <div class="modal-header">

                      <button type="button" class="close" data-dismiss="modal">&times;</button>

                      <h4 class="modal-title">Content Detail</h4>

                    </div>

                    <div class="modal-body user" id="<?=$row['id']?>user_pop" style="height: 400px;overflow: scroll;background-color: black;" >

                    

                    </div>

                    <div class="modal-footer">

                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>

                  </div>

                  

                </div>

              </div>
            <?php  $i++;  
      } endif;?>
      </tbody>
      </table>
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


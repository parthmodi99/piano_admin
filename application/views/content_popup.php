<?php

$server_path="http://".$_SERVER['SERVER_NAME'].'/APIs/uploads/';

if(isset($cms))

{

   // $ci=get_instance();

   // $ci->load->model('admin_model');

   // $cat=$ci->admin_model->getcatname($user['cat_id']);

    

//    echo json_encode($user);

    ?>

    <style type="text/css">

        td, th {

           padding: 5px;

        }

        border-top: #ddd;

    </style>

    <table>

        <tr>

            <td>Content :</td><td><?php echo $cms['content'];?></td>

        </tr>

        

      
    

    </table>

    <?php

}

?>

               
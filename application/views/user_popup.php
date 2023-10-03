<?php

$server_path="http://".$_SERVER['SERVER_NAME'].'/APIs/';

if(isset($user))

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

            <td>Name:</td><td><?php echo $user['name'];?></td>

        </tr>

        

        <tr>

            <td>Email:</td><td><?php echo $user['email'];?></td>

        </tr>

        

        <!-- <tr>

            <td>Age:</td><td><?php echo $user['age'];?></td>

        </tr> -->

      <!--   <tr>

            <td>Contact Number:</td><td><?php echo $user['mobile'];?></td>

        </tr> -->

        <!-- <tr>

            <td>Profile Photo:</td><td>

            <?php

            if($user['profile_pic']!='')

            {

                if(strpos($user['profile_pic'],'http')!==false)

                {

                ?>

                    <img src='<?php echo $user['profile_pic'];?>' height="200px" width="200px">

                <?php

                }

                else{

                    ?>

                    <img src='<?php echo $server_path.$user['profile_pic'];?>' height="200px" width="200px">

                <?php

                }

            }

            ?>

            </td>

        </tr>

        <tr>

            <td>Identity Photo:</td><td>

            <?php

            if($user['identity_pic']!='')

            {

                if(strpos($user['identity_pic'],'http')!==false)

                {

                ?>

                    <img src='<?php echo $user['identity_pic'];?>' height="200px" width="200px">

                <?php

                }

                else{

                    ?>

                    <img src='<?php echo $server_path.$user['identity_pic'];?>' height="200px" width="200px">

                <?php

                }

            }

            ?>

            </td>

        </tr> -->

        <tr>

            <td>Gender:</td><td><?php echo $user['gender'];?></td>

        </tr>

        <!-- <tr>

            <td>latitude/longitude:</td><td><?php echo $user['latitude'].'/'.$user['longitude'];?></td>

        </tr> -->
<!-- 
        <tr>

            <td>About_me:</td><td><?php echo $user['about_me'];?></td>

        </tr> -->

         <tr>

            <td>Is_Block:</td><td style="width: 84px; color: red;"><?php if($user['is_block']==0) echo 'UNBLOCK';

            else

                echo 'BLOCK';

            ?></td>

        </tr>

        <tr>

            <td>Login Type:</td><td style="width: 84px; color: red;"><?php if($user['login_type']==0) echo 'Normal Login';

            else

                echo 'Facebook Login';

            ?></td>

        </tr>

          <tr>

            <td>Profile Photo:</td><td>

            <?php

            if($user['profile_pic']!='')

            {

                if(strpos($user['profile_pic'],'https')!==false)

                {

                ?>

                    <img src='<?php echo $user['profile_pic'];?>' height="200px" width="200px">

                <?php

                }

                else{

                    ?>

                    <img src='<?php echo $server_path.$user['profile_pic'];?>' height="200px" width="200px">

                <?php

                }

            }

            ?>

            </td>

        </tr>

        <!--  <tr>

            <td>Verify:</td><td style="width: 84px; color: red;"><?php if($user['verify'] == 0) echo 'unverified'; else echo 'verify';?></td>

        </tr> -->

    

    </table>

    <?php

}

?>

               
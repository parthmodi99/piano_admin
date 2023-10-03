   <style type="text/css">

        td, th {

           padding: 5px;

        }

        border-top: #ddd;

    </style>
    <?php
    if(!empty($user))
    { ?>
        <h4>Referral User :- </h4>
        <div class="row">
                <div class="col-md-12">
                   <div class="panel panel-default">
                     <div class="panel-heading">
                      <h3 class="panel-title" style="font-weight: 700;"><?= $user['name'] ?></h3>


                   </div>
                   <div class="panel-body"> 
                      <table>
                        <tr>
                           <td><strong>Email : </strong></td><td><?= $user['email']; ?></td>
                        </tr>
                            <?php 
                            if($user['referral_generate_date'] != '')
                            {
                                ?>
                                <tr>
                                   <td><strong>Referral Code : </strong></td><td><?= $user['referral_code']; ?></td>
                                </tr> 
                                <?php
                            }
                            else{
                                ?>
                                <tr>
                                   <td><strong>Referral Code : </strong></td><td>-</td>
                                </tr> 
                                <?php
                            }
                            ?>                    
                      </table>                      
                   </div>
                </div>
             </div>

          </div>
   <?php } 
    ?>
    <h4>Referred User :- <?= count($userslist); ?> </h4>
    <?php 
    if(!empty($userslist))
    {
        ?>
        <?php
        foreach ($userslist as  $value) 
        { ?>
            <div class="row">
                <div class="col-md-12">
                   <div class="panel panel-default">
                     <div class="panel-heading">
                      <h3 class="panel-title" style="font-weight: 700;"><?= $value['name'] ?></h3>


                   </div>
                   <div class="panel-body"> 
                      <table>
                        <tr>
                           <td><strong>Email : </strong></td><td><?= $value['email']; ?></td>
                        </tr>
                         <?php 
                            if($value['referral_generate_date'] != '')
                            {
                                ?>
                                <tr>
                                   <td><strong>Referral Code : </strong></td><td><?= $value['referral_code']; ?></td>
                                </tr> 
                                <?php
                            }
                            else{
                                ?>
                                <tr>
                                   <td><strong>Referral Code : </strong></td><td>-</td>
                                </tr> 
                                <?php
                            }
                            ?>                         
                      </table>
                      
                   </div>
                </div>
             </div>

          </div>
       <?php }
    }
    ?>
   
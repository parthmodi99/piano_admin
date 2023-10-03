
<table id="example2" class="display" style="width:100%">
  <thead>
    <tr>
      <th style="width:5%"> Sr no.</th>
      <th style="width:15%"> Name </th>
      <th style="width:15%"> Email </th>
      <th style="width:15%"> User Type </th>
      <th style="width:15%"> selected Year Total workout count </th>
      <th style="width:15%"> New / old User </th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $i = 1; 
    if(!empty($user))
    {
      foreach ($user as $row)
      { 

        ?>
        <tr>
          <td>

               <?=$i;?>

              </td>

              <td>

                <?=$row['name'];?>

              </td>

              <td>

                <?=$row['email'];?>

              </td>

              <td>
                <?php 
                if($row['is_pro_user'] == 1)
                {
                  $typ = 'Pro User';
                }
                else
                {
                  $typ = 'Normal User';
                }
                ?>
                <?=$typ;?>

              </td>
              <td><?= $row['total_workouts'] ?></td>
              <td>
                <?php 
                if($row['new_user'] == 1)
                {
                  $typ = 'New User';
                }
                else
                {
                  $typ = 'Old User';
                }
                ?>
                <?=$typ;?>

              </td>
          
          
        </tr>
        <?php
        $i++;
      }
    }
    ?>
  </tbody>
</table>
<script type="text/javascript">

  $(function () {
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,


    });
  });
</script>
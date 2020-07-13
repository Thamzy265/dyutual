<?php
$users = new Admin();
$data = $users->fetchAdmin();
?>


<div class="pt-3">
    <h3>ADMIN USERS</h3>
    <div class="pb-2">
        <a href="?page=admin_password" class="btn btn-info">Change Password</a>
        <a href="?page=admin_user" class="btn btn-success">Add User</a>
    </div>
    <div class="col-sm-7">
    <?php
        if ($msg != null){
            echo "<p class='alert alert-danger'>$msg</p>";
        }
        ?>

        <?php
        if ($success != null){
            echo "<p class='alert alert-success'>$success</p>";
        }
        ?>


    </div>
    <table class="table">
        <thead>
        <tr>
            <th class="cus-color">#</th>
            <th class="cus-color">First Name</th>
            <th class="cus-color">Last Name</th>
            <th class="cus-color">Gender</th>
            <th class="cus-color">Email</th>
            <th class="cus-color">Action</th>

        </tr>
        </thead>
        <tbody class="white-grey">
        <?php
        $i= 1;
        foreach ($data as $user) {

            echo "<tr>";
            echo "<td class='cus-color'>$i</td>";
            echo "<td class='cus-color'>{$user['fname']}</td>";
            echo "<td class='cus-color'>{$user['sname']}</td>";
            echo "<td class='cus-color'>{$user['Gender']}</td>";
            echo "<td class='cus-color'>{$user['Email']}</td>";

            echo "<td><a class='text-primary' href='?page=admin_editUser&&id={$user['id']}'>Edit</a>|<a class='text-danger' href='../route/route.php?deleteAdmin&&id={$user['id']}'>Delete</a></td>";
        
            echo "</tr>";
            $i ++;
        }
        ?>
        </tbody>
    </table>
   
  
</div>



    
</div>
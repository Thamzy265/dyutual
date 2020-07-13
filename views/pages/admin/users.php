<?php
$users = new adminUsers();
$data = json_decode($users->fetchUsers(),true);
?>

<div class="pt-3">
    <p class="alert text-light nav-side-select">Showing registered users in the system</p>

    <table class="table">
        <thead>
        <tr>
            <th class='cus-color'>#</th>
            <th class='cus-color'>First Name</th>
            <th class='cus-color'>Last Name</th>
            <th class='cus-color'>Email</th>
            <th class='cus-color'>Phone number</th>
        </tr>
        </thead>
        <tbody class="white-grey">
        <?php
        $i= 1;
        foreach ($data as $user) {

            echo "<tr>";
            echo "<td class='cus-color'>$i</td>";
            echo "<td class='cus-color'>{$user['fname']}</td>";
            echo "<td class='cus-color'>{$user['lname']}</td>";
            echo "<td class='cus-color'>{$user['email']}</td>";
            echo "<td class='cus-color'>{$user['pnumber']}</td>";
            echo "<td><a class='btn btn-danger' href='../route/route.php?deleteUser=true&&user_id={$user['id']}'>Delete</a></td>";
            echo "</tr>";
            $i ++;
        }
        ?>
        </tbody>
    </table>
</div>


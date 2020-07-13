<?php
$lecturersAll = new lecturer();
if(isset($_GET['id']) || isset($_GET['name']) || isset($_GET['email'])){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
       
     }else {
         $id = null;
     }

    
     if(isset($_GET['name'])){
         $name = $_GET['name'];
     }else {
         $name  = null;
     }
     if(isset($_GET['email'])){
         $email = $_GET['email'];
     }else {
         $email  = null;
     }
     $lecturers= json_decode($lecturersAll->searchLecturers($id,$name,$email),true);
}else{
    $lecturers = json_decode($lecturersAll->getLecturers(),true);
}


$lecturerCount = count($lecturers);
?>
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
<div class="pt-3">
<div class="d-flex"><img class="icons pr-2" src="../images/icons/images (23).png" alt=""><h5>Lecturer Administration</h5></div>
        <div class="d-flex"><img class="icons pr-2" src="../images/icons/images (24).png" alt=""><h5>Find Lecture</h5></div>
        <table>
           
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            
            <tbody>
                <tr>
                <form action="" method="get">
                    <input type="hidden" name="page" value="admin_lecturers">
                    <td><input type="text" placeholder="Enter Name" name="name" ></td>
                    <td><input type="text" placeholder="Enter Email" name="email" ></td>
                    
                    <td><button type="submit" name="searchClass" class="btn btn-primary">Search</button></td>                  
                </form>
                <td><a href="?page=admin_lecturers" class="btn text-light bg-grey">Clear</a></td>
            </tr>
            <tr>
                <td>1 All</td>
                <td></td>
                <td><h5>Rows:All</h5></td>
                <td><h5>Pages:All</h5></td>
                <td><h5 class="text-danger">Total:<?php echo $lecturerCount;?></h5></td>
            </tr>
            </tbody>
        </table>
        <table class="table table-inverse pt-3">
            <thead class="">
                <tr>
                    <th>#ID</th>
                    <th>F.name</th>
                    <th>S.Name</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($lecturers as $lecturer) {

                        echo "<tr>";
                        
                        echo "<td >{$lecturer['id']}</td>";
                        echo "<td >{$lecturer['fname']}</td>";
                        echo "<td >{$lecturer['lname']}</td>";
                        echo "<td >{$lecturer['gender']}</td>";
                        echo "<td >{$lecturer['email']}</td>";
                        echo "<td >{$lecturer['class']}</td>";
                    
                        echo "<td><a class='text-primary' href='?page=edit_lecturer&&id={$lecturer['id']}'>Edit</a>|<a class='text-danger' href='../route/route.php?deleteLecturer&&id={$lecturer['id']}'>Delete</a></td>";
                        echo "</tr>";
                    
                    }
                    ?>
                </tbody>
        </table>

        <a href="?page=admin_lecturer" class="btn btn-success">Add Lecturer</a>
</div>


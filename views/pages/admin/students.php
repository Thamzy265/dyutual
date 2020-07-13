<?php
$studentAll = new student();
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
     $students= json_decode($studentAll->searchStudents($id,$name,$email),true);
}else{
    $students = json_decode($studentAll->getStudents(),true);
}

$studentCount = count($students);
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
<div class="d-flex"><img class="icons pr-2" src="../images/icons/images (23).png" alt=""><h5>Students Administration</h5></div>
        <div class="d-flex"><img class="icons pr-2" src="../images/icons/images (24).png" alt=""><h5>Find Student</h5></div>
        <table>
           
                <tr>
                    
                    <th>Student Name</th>
                    <th>Email</th>
                </tr>
            
            <tbody>
                <tr>
                <form action="" method="get">
                    <input type="hidden" name="page" value="admin_students">
                    <td><input type="text" placeholder="Enter Name" name="name" ></td>
                    <td><input type="text" placeholder="Enter Email" name="email" ></td>
                    
                    <td><button type="submit" name="searchClass" class="btn btn-primary">Search</button></td>                  
                </form>
                <td><a href="?page=admin_students" class="btn text-light bg-grey">Clear</a></td>
            </tr>
            <tr>
                <td>1 All</td>
                <td></td>
                <td><h5>Rows:All</h5></td>
                <td><h5>Pages:All</h5></td>
                <td><h5 class="text-danger">Total:<?php echo $studentCount;?></h5></td>
            </tr>
            </tbody>
        </table>
        <table class="table table-inverse pt-3">
            <thead class="">
                <tr>
                    <th>#ID</th>
                    <th>F.Name</th>
                    <th>S.Name</th>
                    <th>Gender</th>
                    <th>Course</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($students as $student) {

                        echo "<tr>";
                        
                        echo "<td >{$student['id']}</td>";
                        echo "<td >{$student['fname']}</td>";
                        echo "<td >{$student['lname']}</td>";
                        echo "<td >{$student['gender']}</td>";
                        echo "<td >{$student['course']}</td>";
                    
                        echo "<td><a class='text-primary' href='?page=edit_student&&id={$student['id']}'>Edit</a>|<a class='text-danger' href='../route/route.php?deleteStudent&&id={$student['id']}'>Delete</a></td>";
                        echo "</tr>";
                    
                    }
                    ?>
                </tbody>
        </table>

        <a href="?page=admin_student" class="btn btn-success">Add Student</a>
</div>


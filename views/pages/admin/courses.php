<?php
$coursesAll = new Courses();
if(isset($_GET['id']) || isset($_GET['name'])){
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
     $courses  = json_decode($coursesAll->searchClass($id,$name),true);
}else{
    $courses = json_decode($coursesAll->getCourses(),true);
}

$coursesCount = count($courses);
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
<div class="d-flex"><img class="icons pr-2" src="../images/icons/images (23).png" alt=""><h5>Course Administration</h5></div>
        <div class="d-flex"><img class="icons pr-2" src="../images/icons/images (24).png" alt=""><h5>Find Course</h5></div>
        <table>
           
                <tr>
                    <th>#ID</th>
                    <th>Course Name</th>
                    
                </tr>
            
            <tbody>
                <tr>
                <form action="" method="get">
                    <input type="hidden" name="page" value="admin_courses">
                    <td><input type="text" placeholder="Enter ID" name="id" ></td>
                    <td><input type="text" placeholder="Enter Name" name="name" ></td>
                    
                    <td><button type="submit" name="searchCourse" class="btn btn-primary">Search</button></td>                  
                </form>
                <td><a href="?page=admin_courses" class="btn text-light bg-grey">Clear</a></td>
            </tr>
            <tr>
                <td>1 All</td>
                <td></td>
                <td><h5>Rows:All</h5></td>
                <td><h5>Pages:All</h5></td>
                <td><h5 class="text-danger">Total:<?php echo $coursesCount;?></h5></td>
            </tr>
            </tbody>
        </table>
        <table class="table table-inverse pt-3">
            <thead class="">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>

                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($courses as $course) {

                        echo "<tr>";
                        
                        echo "<td >{$course['code']}</td>";
                        echo "<td >{$course['title']}</td>";
                       
                    
                        echo "<td><a class='text-primary' href='?page=edit_course&&course_id={$course['id']}'>Edit</a>|<a class='text-danger' href='../route/route.php?deleteCourse=true&&id={$course['id']}'>Delete</a></td>";
                        echo "</tr>";
                    
                    }
                    ?>
                </tbody>
        </table>

        <a href="?page=admin_course" class="btn btn-success">Add Course</a>
</div>


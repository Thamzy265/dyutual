<?php
$coursesAll = new lecturer();
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
    $courses = json_decode($coursesAll->searchCourse($id,$name,'lecturer'),true);
}else{
    $courses = json_decode($coursesAll->getCourse(),true);
}

$coursesCount = count($courses);
$p ="lecture"
?>

<div class="pt-3">
<div class="d-flex"><img class="icons pr-2" src="../images/icons/images (23).png" alt=""><h5>Courses</h5></div>
        <div class="d-flex"><img class="icons pr-2" src="../images/icons/images (24).png" alt=""><h5>Find Course</h5></div>
        <table>
           
                <tr>
                    <th>#Course Code</th>
                    <th>Course Name</th>
                    
                </tr>
            
            <tbody>
                <tr>
                <form action="" method="get">
                    <input type="hidden" name="page" value="lecturer_Course">
                    <td><input type="text" placeholder="Enter ID" name="id"></td>
                    <td><input type="text" placeholder="Enter Name" name="name"></td>
                    
                    <td><button type="submit" name="searchCourse" class="btn btn-primary">Search</button></td>                  
                </form>
                <td><a href="?page=lecturer_Course" class="btn text-light bg-grey">Clear</a></td>
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
                   
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($courses as $course) {

                        echo "<tr>";
                        
                        echo "<td >{$course['code']}</td>";
                        echo "<td >{$course['title']}</td>";
                       
                    
                        echo "</tr>";
                    
                    }
                    ?>
                </tbody>
        </table>

        
</div>


<?php
$classesAll = new student();
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
     $classesAll = new lecturer();
     $classes = json_decode($classesAll->searchClass($id,$name,'student'),true);
}else{
    $id = $_SESSION['schedule_id'] ?? '0';
    $class = new classes();
    $classes = $class->getClassesWithLec($id);
}

$classCount = count($classes);
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
<div class="d-flex"><img class="icons pr-2" src="../images/icons/images (23).png" alt=""><h5>Classes</h5></div>
        <div class="d-flex"><img class="icons pr-2" src="../images/icons/images (24).png" alt=""><h5>Find Course</h5></div>
        <table>
           
                <tr>
                    <th>#ClassID</th>
                    <th>Course Name</th>
                  
                </tr>
            
            <tbody>
                <tr>
                <form action="" method="get">
                    <input type="hidden" name="page" value="classes">
                    <td><input type="text" placeholder="Enter ID" name="id"></td>
                    <td><input type="text" placeholder="Enter Name" name="name"></td>
                    
                    <td><button type="submit" name="searchClass" class="btn btn-primary">Search</button></td>                  
                </form>
                <td><a href="?page=classes" class="btn text-light bg-grey">Clear</a></td>
            </tr>
            <tr>
                <td>1 All</td>
                <td></td>
                <td><h5>Rows:All</h5></td>
                <td><h5>Pages:All</h5></td>
                <td><h5 class="text-danger">Total:<?php echo $classCount;?></h5></td>
            </tr>
            </tbody>
        </table>
        <table class="table table-inverse pt-3">
            <thead class="">
                <tr>
                    <th>ClassID</th>
                    <th>Course</th>
                    <th>Classname</th>
                    <th>Lecture</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($classes as $class) {

                        echo "<tr>";
                        
                        echo "<td >{$class['id']}</td>";
                        echo "<td >{$class['course']}</td>";
                        echo "<td >{$class['name']}</td>";
                        echo "<td >{$class['lecturer']}</td>";
                        echo "<td >{$class['startTime']}</td>";
                        echo "<td >{$class['endTime']}</td>";
                    
                        echo "</tr>";
                    
                    }
                    ?>
                </tbody>
        </table>

        
</div>


<?php
$classesAll = new classes();
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
     
     $classes = json_decode($classesAll->searchClass($id,$name,'student'),true);
}else{
    $classes = json_decode($classesAll->getClasses(),true);
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
<div class="d-flex"><img class="icons pr-2" src="../images/icons/images (23).png" alt=""><h5>Class Administration</h5></div>
        <div class="d-flex"><img class="icons pr-2" src="../images/icons/images (24).png" alt=""><h5>Find Class</h5></div>
        <table>
           
                <tr>
                    <th>#ClassID</th>
                    <th>Classame</th>
                
                </tr>
            
            <tbody>
                <tr>
                <form action="" method="get">
                    <input type="hidden" name="page" value="admin_classes">
                    <td><input type="text" placeholder="Enter ID" name="id"></td>
                    <td><input type="text" placeholder="Enter Name" name="name" ></td>
                    
                    <td><button type="submit" name="searchClass" class="btn btn-primary">Search</button></td>                  
                </form>
                <td><a href="?page=admin_classes" class="btn text-light bg-grey">Clear</a></td>
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
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($classes as $class) {

                        echo "<tr>";
                        
                        echo "<td >{$class['id']}</td>";
                        echo "<td >{$class['course']}</td>";
                        echo "<td >{$class['name']}</td>";
                        echo "<td >{$class['startTime']}</td>";
                        echo "<td >{$class['endTime']}</td>";
                    
                        echo "<td><a class='text-primary' href='?page=edit_class&&class_id={$class['id']}'>Edit</a>|<a class='text-danger' href='../route/route.php?deleteClass=true&&id={$class['id']}'>Delete</a></td>";
                        echo "</tr>";
                    
                    }
                    ?>
                </tbody>
        </table>

        <a href="?page=admin_class" class="btn btn-success">Add Class</a>
</div>


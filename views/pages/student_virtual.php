<?php  
 $classID = $_GET['code'];
 $name = $_GET['name'];

$vClasses = new student();
$classes = json_decode($vClasses->selectClass($classID),true);
?>
<div class="">
    <h3>Class Name : <?php echo $name ;?></h3>
    <?php
       foreach($classes as $class){
           echo "<a href='../route/route.php?enter_class=true&&vclass_id={$class['id']}'>Enter class : time{$class['time']}</a></br>";
       }
        
    ?>
</div>
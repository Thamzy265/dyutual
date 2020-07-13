<?php
$id = $_SESSION['schedule_id'] ?? '0';
$classesAll = new classes();
$classes = $classesAll->getClassesByCourse($id);
?>
<div class="bg-optimus pt-2">
  
<div class="pt-5 pl-3">

        <?php
            foreach($classes as $class){
                echo "<a class='' href='?page=student_virtual_class&&name={$class['name']}&&code={$class['id']}'>";
                echo "<div class='card w-25 bg-success border-0'>";
                echo "<div class='card-body'></div>";
                echo "<div class='card-footer bg-light text-muted'>";
                echo  $class['name'];
                echo "</div>";
                echo "</a>";
            }
        ?>
    </div>
   
</div>
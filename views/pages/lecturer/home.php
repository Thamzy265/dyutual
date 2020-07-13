<?php
$coursesAll = new lecturer();
$courses = json_decode($coursesAll->getClasses(),true);
?>
<div class="bg-optimus">
    <div class="pt-5 pl-3">

        <?php
            foreach($courses as $course){
                echo "<a class='' href='?page=lecturer_virtual_class&&name={$course['name']}&&code={$course['id']}'>";
                echo "<div class='card w-25 bg-success border-0'>";
                echo "<div class='card-body'></div>";
                echo "<div class='card-footer bg-light text-muted'>";
                echo  $course['name'];
                echo "</div>";
                echo "</a>";
            }
        ?>
    </div>
   
   
</div>
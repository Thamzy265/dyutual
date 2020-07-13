<?php  
 $classID = $_GET['code'];
 $name = $_GET['name'];
?>
<div class="">
    <h4>Start Class: <?php echo $name;?></h4>

    <form method="post" action="../route/route.php" enctype="multipart/form-data">
        <input type="file" name="file" class="form-control">
        <input type="text" name="file_name" class="form-control">
        <button class="btn btn-info" name="lecturerStart">Start class</button>
    </form>
</div>
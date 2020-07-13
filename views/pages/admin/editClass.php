<?php
if(isset($_GET['class_id'])){
    $id = $_GET['class_id'];
}else {
    $id = 0;
}

$class = new classes();
$class = json_decode($class->getClass($id),true);


?>
<div class="col-md-6">
<h5 class="text-info">Edit Class</h5>
<form action="../route/route.php" method="post">
<div class="form-group">
    <input type="hidden" name="id" value="<?php echo $class[0]['id'] ;?>">
    <label for="">Class Name</label>
         <input class="form-control" name="classname" placeholder="Classname" type="text"  value="<?php echo $class[0]['name'] ;?>" required>
    </div>
    <div class="row">
        <div class="form-group col-sm-6">
        <label for="">Start Time</label>
              <input class="form-control" name="startTime" placeholder="Duration" type="time" value="<?php echo $class[0]['startTime'] ;?>" required>
        </div>
        <div class="form-group col-sm-6">
        <label for="">End Time</label>
            <input class="form-control" name="endTime" placeholder="Duration" type="time" value="<?php echo $class[0]['endTime'] ;?>" required>
        </div>
    </div>
  
    <button type="submit" name="editClass" class="btn btn-primary">Edit Class</button>
</form>
</div>
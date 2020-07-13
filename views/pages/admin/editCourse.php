<?php
if(isset($_GET['course_id'])){
    $id = $_GET['course_id'];
}else {
    $id = 0;
}
$coursesAll = new Courses();
$courses = $coursesAll->getCourse($id);

?>
<div class="col-md-6">
<h5 class="text-info">Edit Course</h5>
<form action="../route/route.php" method="post">
    <input type="hidden" name="id" value="<?php echo $courses[0]['id'] ;?>">
    <div class="form-group">
    <input class="form-control" name="courseTitle" placeholder="Course title" type="text" value="<?php echo $courses[0]['title'] ;?>" required>
    </div>
    <div class="form-group">
    <input class="form-control" name="courseCode" placeholder="Code" type="text" value="<?php echo $courses[0]['code'] ;?>" required>
    </div>
   
    <button type="submit" name="editCourse" class="btn btn-primary">Edit course</button>
</form>
</div>
<?php

$coursesAll = new Courses();
$courses = json_decode($coursesAll->getCourses(),true);

?>
<div class="col-md-6">
<h5 class="text-info">Add Class</h5>
<form action="../route/route.php">
            <div class="form-group ">
                 <label for="Class">Course</label>
                <select id="gender" class="custom-select" name="course">
                <?php
                    foreach($courses as $course){
                        echo "<option value='{$course['id']}'>{$course['title']}</option>";
                    }
                ;?>
                        
                </select>
            </div>
    <div class="form-group">
         <input class="form-control" name="classname" placeholder="Classname" type="text" required>
    </div>

    <div class="row">
        <div class="form-group col-sm-6">
            <label for="">Start Time</label>
            <input class="form-control" name="startTime" placeholder="startTime" type="time">
        </div>
        <div class="form-group col-sm-6">
            <label for="">End Time</label>
            <input class="form-control" name="endTime" placeholder="endTime" type="time">
        </div>
    </div>

    <button type="submit" name="addClass" class="btn btn-primary">Add Class</button>
</form>
</div>
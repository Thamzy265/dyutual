<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else {
    $id = 0;
}

$coursesAll = new Courses();
$courses = json_decode($coursesAll->getCourses(),true);


$student = new student();
$data =  $student->getStudent($id);
?>
<div class="col-md-10">
<h5 class="text-info">Edit Student</h5>
<form action="../route/route.php" method="post">
        <div class="row">
            <div class="form-group col-sm-6">
                <input class="form-control" name="fname" placeholder="Firstname" type="text" value="<?php echo $data[0]['fname'] ;?>" required>
            </div>
            <div class="form-group col-sm-6">
                <input class="form-control" name="sname" placeholder="Surname" type="text" value="<?php echo $data[0]['lname'] ;?>" required>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="gender">Gender</label>
                <select id="gender" class="custom-select" name="gender">
                    <option value="male" <?php if ($data[0]['gender']=='male'){ echo 'selected';} ?> >Male</option>
                    <option value="female" <?php if ($data[0]['gender']=='female'){ echo 'selected';} ?> >Female</option>
                </select>
            </div>
       
            <div class="form-group col-sm-6">
                <label for="schedule">Course</label>
                <select id="gender" class="custom-select" name="schedule">
                <?php
                    foreach($courses as $course){
                        echo "<option value='{$course['id']}' "; 
                        if($course['id']==$data[0]['course']){ echo "selected"; } ;
                        echo " >{$course['title']}</option>";
                    }
                ;?>
                        
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
            <input class="form-control" name="email" placeholder="Email" type="email"  value="<?php echo $data[0]['email'] ;?>" required>
            </div>
        
            <div class="form-group col-sm-6">
            <input class="form-control" name="username" placeholder="Username" type="text"  value="<?php echo $data[0]['username'] ;?>" required>
            </div>
        </div>
       
       <div class="pt-3">
            <a href="?page=admin_stPass&&id=<?php echo $data[0]['id'];?>" name="studentPass" class="btn btn-warning">Change Password</a>
            <button type="submit" name="editStudent" class="btn btn-primary">Update Student</button>
       </div>
        
        
    </form>

</div>
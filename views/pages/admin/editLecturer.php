<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else {
    $id = 0;
}
$classesAll = new classes();
$classes = json_decode($classesAll->getClasses(),true);
$coursesAll = new Courses();
$courses = json_decode($coursesAll->getCourses(),true);

$lecturer = new lecturer();
$data = $lecturer->getLecturer($id);
?>
<div class="col-md-10">
<h5 class="text-info">Edit Lecturer</h5>
<form class="pt-3" action="../route/route.php" method="post">
    <input type="hidden" name="id" value="<?php echo $data[0]['id'] ;?>">
        <div class="row">
            <div class="form-group col-sm-6">
            <label for="gender">First Name</label>
                <input class="form-control" name="fname" placeholder="Firstname" type="text" value="<?php echo $data[0]['fname'] ;?>" required>
            </div>
            <div class="form-group col-sm-6">
            <label for="gender">Last Name</label>
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
                <label for="Class">Class</label>
                <select id="class" class="custom-select" name="class">
                <?php
                    foreach($classes as $class){
                        echo "<option value='{$class['id']}'";
                        if($class['id']==$data[0]['class']){ echo "selected"; } ;
                        echo" >{$class['name']}</option>";
                    }
                ;?>
                </select>
            </div>
        
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
            <label for="gender">Email</label>
                <input class="form-control" name="email" placeholder="Email" type="email" value="<?php echo $data[0]['email'] ;?>" required>
            </div>

            <div class="form-group col-sm-6">
            <label for="gender">Username</label>
                 <input class="form-control" name="username" placeholder="Username" type="text" value="<?php echo $data[0]['fname'] ;?>" required>
            </div>       
        </div>
       
      
        
        <div class="pt-3">
            <a href="?page=admin_lecPass&&id=<?php echo $data[0]['id'];?>" name="lecturePass" class="btn btn-warning">Change Password</a>
            <button type="submit" name="editLecturer" class="btn btn-primary">Update Lecturer</button>
        </div>
       
    </form>

</div>
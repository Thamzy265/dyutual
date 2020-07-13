<?php
if(isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id'];
}else {
    $id = 0;
}

$lec = new lecturer();
$data = $lec->getLecturer($id);

?>
<div class="col-md-10">
<h5 class="text-info">Edit Admin</h5>
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
       
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" class="custom-select" name="gender">
                    <option value="male" <?php if ($data[0]['gender']=='male'){ echo 'selected';} ?> >Male</option>
                    <option value="female" <?php if ($data[0]['gender']=='female'){ echo 'selected';} ?> >Female</option>
                </select>
            </div>
            
       
        <div class="row">
            <div class="form-group col-sm-6">
            <label for="gender">Email</label>
                <input class="form-control" name="email" placeholder="Email" type="email" value="<?php echo $data[0]['email'] ;?>" required>
            </div>

            <div class="form-group col-sm-6">
            <label for="gender">Username</label>
                 <input class="form-control" name="username" placeholder="Username" type="text" value="<?php echo $data[0]['username'] ;?>" required>
            </div>       
        </div>
       
      
        
        <div class="pt-3">
            <a href="?page=lecturer_pass&&id=<?php echo $data[0]['id'];?>" name="lecturePass" class="btn btn-warning">Change Password</a>
            <button type="submit" name="editLecturer" class="btn btn-primary">Update Profile</button>
        </div>
       
    </form>

</div>
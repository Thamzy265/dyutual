<?php
$classesAll = new classes();
$classes = json_decode($classesAll->getClasses(),true);
$coursesAll = new Courses();
$courses = json_decode($coursesAll->getCourses(),true);
?>
<div class="col-md-10">
<h5 class="text-info">Add Lecturer</h5>
<?php
    if(isset($_GET['msg'])){
        echo "<p class='alert alert-info'>{$_GET['msg']}</p>";
    }  
?>
<form class="pt-3" action="../route/route.php" method="post">
        <div class="row">
            <div class="form-group col-sm-6">
            <label for="gender">First Name</label>
            <input class="form-control" name="fname" placeholder="Firstname" type="text" required>
            </div>
            <div class="form-group col-sm-6">
            <label for="gender">Last Name</label>
            <input class="form-control" name="sname" placeholder="Surname" type="text" required>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="gender">Gender</label>
                <select id="gender" class="custom-select" name="gender">
                    <option value="male" select>Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group col-sm-6">
                <label for="Class">Class</label>
                <select id="gender" class="custom-select" name="class">
                <?php
                    foreach($classes as $class){
                        echo "<option value='{$class['id']}'>{$class['name']}</option>";
                    }
                ;?>
                        
                </select>
            </div>
      
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
            <label for="gender">Username</label>
                <input class="form-control" name="username" placeholder="Username" type="text" required>
            </div>
            <div class="form-group col-sm-6">
            <label for="gender">Email</label>
                  <input class="form-control" name="email" placeholder="Email" type="email" required>
             </div>
        </div>
       

       
        <div class="row">
            <div class="form-group col-sm-6">
                 <input class="form-control" name="password" placeholder="Password" type="password" required>
            </div> 
            <div class="form-group col-sm-6">
                  <input class="form-control" name="re_pass" placeholder="Re: Password" type="password" required>
            </div> 
        </div>
     
        
        <button type="submit" name="addLecturer" class="btn btn-primary">Add Lecturer</button>
    </form>

</div>
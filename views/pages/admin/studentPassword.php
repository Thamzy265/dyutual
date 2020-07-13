<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else {
    $id = 0;
}
$admin = new Admin();
$data = $admin->getAdmin($id);
?>
<div class="col-md-10">
<h5 class="text-info">Edit Password</h5>
<form class="pt-3" action="../route/route.php" method="post">
    <input type="hidden" name="id" value="<?php echo $data[0]['id'] ;?>">
            <div class="form-group col-sm-6">
            <label for="gender">Password</label>
                <input class="form-control" name="password" placeholder="password" type="password" required>
            </div>

        <div class="pt-3">
            <button type="submit" name="passStudent" class="btn btn-primary">Update Password</button>
        </div>
       
    </form>

</div>
<h4 class=".cus-color">Change your student Password</h4>
<div class="col-sm-7">
    <?php
    if ($msg != null){
        echo "<p class='alert alert-danger'>$msg</p>";
    }
    ?>

    <?php
    if ($success != null){
        echo "<p class='alert alert-success'>$success</p>";
    }
    ?>
    <form method="post" action="../route/route.php">
        <div class="form-group">
            <label for="old-password">Current Password</label>
            <input id="old-password" class="form-control" type="password" name="oldpass" required>
        </div>
        <div class="form-group">
            <label for="new-pass">New Password</label>
            <input id="new-pass" class="form-control" type="password" name="new_pass" required>
        </div>
        <div class="form-group">
            <label for="re-pass">re-Password</label>
            <input id="re-pass" class="form-control" type="password" name="re_pass" required>
        </div>
        <button type="submit" name="passUpdateSt" class="btn btn-primary">Change Password</button>
    </form>
</div>

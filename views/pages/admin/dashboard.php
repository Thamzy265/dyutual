

<h3 class="text-primary">Add Entity:</h3>
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
<div class="container row pl-5 pt-5">
    <div class="col-md-10">
    <div class="card-deck">
        <a href="?page=admin_course">
            <div class="card admin-card border-0 rounded-0 bg-info">
                <div class="card-body">
                    <h5 class="card-title text-light">Add Courses</h5>
                    
                </div>
            </div>
        </a>
        <a href="?page=admin_class">
            <div class="card admin-card border-0 rounded-0 bg-success">
                <div class="card-body">
                    <h5 class="card-title text-light">Add Classes</h5>
                    
                </div>
            </div>
        </a>
    </div>
    <div class="card-deck pt-5">
        <a href="?page=admin_lecturer">
            <div class="card admin-card border-0 rounded-0 bg-grey">
                <div class="card-body">
                    <h5 class="card-title text-light">Add Lecturers</h5>
                    
                </div>
            </div>
        </a>
        <a href="?page=admin_student">
            <div class="card admin-card border-0 rounded-0 bg-grey">
                <div class="card-body">
                    <h5 class="card-title text-light">Add Students</h5>
                    
                </div>
            </div>
        </a>
    </div>
    </div>
 
</div>


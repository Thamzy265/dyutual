<?php

if (isset($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = '';
}

if (isset($_GET['msg'])){
    $msg = $_GET['msg'];
}else{
    $msg = null;
}

if (isset($_GET['success'])){
    $success = $_GET['success'];
}else{
    $success = null;
}
?>
<?php require_once "../helpers/sessionHelper.php"?>
<?php require_once "../model/lecturer.php"?>
<?php require_once "../model/class.php"?>
<?php require_once "../model/students.php"?>
<?php require_once "../model/adminUsers.php"?>
<?php require_once "../model/Admin.php"?>
<?php require_once "../model/courses.php"?>

<?php
//if session is not set will direct user to login page
$sesHelper = new sessionHelper();
$sesHelper->isNotLogged();
?>

<?php include_once "./components/head.php"?>

<div class="row">

    <?php include_once "components/sidebar.php"?>

    <div class="main-content container pt-3">

        <?php
        /**if user is admin will have access to the admin pages
         *if user is normal user will have access to the normal pages
         *session admin will be used to verify if user is admin or not
         *
        **/
        if (sessionHelper::getSession('admin')==1){
            switch ($page){
                case "admin":
                    include_once "pages/admin/dashboard.php";
                    break;
                case "admin_accounts":
                    include_once "pages/admin/accounts.php";
                    break;
                case "admin_account":
                    include_once "pages/admin/account.php";
                    break;
                case "admin_students":
                    include_once "pages/admin/students.php";
                    break;
                case "admin_student":
                    include_once "pages/admin/student.php";
                    break;
                case "edit_student":
                    include_once "pages/admin/editStudent.php";
                    break;
                case "admin_stPass":
                    include_once "pages/admin/studentPassword.php";
                    break;
                case "admin_lecturers":
                    include_once "pages/admin/lecturers.php";
                    break;
                case "admin_lecturer":
                    include_once "pages/admin/lecturer.php";
                    break;
                case "admin_lecPass":
                    include_once "pages/admin/lecturerPassword.php";
                    break;
                case "admin_classes":
                    include_once "pages/admin/classes.php";
                    break;
                case "admin_class":
                    include_once "pages/admin/class.php";
                    break;
                case "admin_courses":
                    include_once "pages/admin/courses.php";
                    break;
                case "edit_course":
                    include_once "pages/admin/editCourse.php";
                    break;
                case "edit_class":
                    include_once "pages/admin/editClass.php";
                    break;
                case "edit_lecturer":
                    include_once "pages/admin/editLecturer.php";
                    break;
                case "admin_user":
                    include_once "pages/admin/user.php";
                    break;
                case "admin_editUser":
                    include_once "pages/admin/editUser.php";
                    break;
                case "admin_password":
                    include_once "pages/admin/adminPassword.php";
                    break;
                case "admin_course":
                    include_once "pages/admin/course.php";
                    break;
                default:
                    include_once "pages/home.php";
            }
        }elseif(sessionHelper::getSession('lecturer')==1){
            switch ($page){
                case "lecturer_home":
                    include_once "pages/lecturer/home.php";
                    break;
                case "lecturer_classes":
                    include_once "pages/lecturer/classes.php";
                    break;
                case "lecturer_Course":
                    include_once "pages/lecturer/courses.php";
                    break;
                case "lecturer_class_materials":
                    include_once "pages/lecturer/class-materials.php";
                    break;
                case "lecturer_timetable":
                    include_once "pages/lecturer/timetable.php";
                    break;
                case "lecturer_account":
                    include_once "pages/lecturer/editLecturer.php";
                    break;
                case "lecturer_pass":
                    include_once "pages/lecturer/lecturerPass.php";
                    break;
              
                case "lecturer_virtual_class":
                    include_once "pages/lecturer/lecturer_virtual.php";
                    break;
                case "lecturer_virtual":
                    include_once "pages/lecturer/virtual.php";
                    break;
            }
        }else {
            switch($page){
                case "home":
                    include_once "pages/home.php";
                    break;
                case "courses":
                    include_once "pages/courses.php";
                    break;
                case "classes":
                    include_once "pages/classes.php";
                    break;
                case "timetable":
                    include_once "pages/timetable.php";
                    break;
               
                case "account":
                    include_once "pages/editStudent.php";
                    break;
                case "pass":
                    include_once "pages/studentPass.php";
                    break;
                case 'student_virtual_class':
                    include_once "pages/student_virtual.php";
                    break;
            }
        }



        ?>

        </div>
    </div>
</div>

<?php include_once "./components/footer.php"?>

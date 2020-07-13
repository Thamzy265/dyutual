<?php
/**
 * Requiring the necessary files
 */
require('../helpers/sessionHelper.php');

require('../model/register.php');
require('../model/login.php');
require('../model/user.php');
require('../model/class.php');
require('../model/Courses.php');
require('../model/Admin.php');
require('../model/VirtualClass.php');
require('../model/Chat.php');
require('../model/lecturer.php');
require('../model/students.php');
require('../model/adminUsers.php');

$sesHelper = new sessionHelper();

if(isset($_POST['register'])){
    //when registering user
    $reg = new RegisterUser();
    $reg->register();
}elseif (isset($_POST['login'])) {
    //logging in student user
    $user = new User();
    $user->Login("student");
}elseif (isset($_POST['message'])) {
    //sending chat messages
    $chat = new chat();
    $chat->createMessages();

}elseif (isset($_GET['messages'])) {
    //Getting chat messages
    $chat = new chat();
    $chat->displayText();

}elseif (isset($_GET['enter_class'])) {
    //Getting chat messages
    $student= new student();
    $student->enterClass();

}elseif (isset($_GET['participants'])) {
    //Getting chat participants
    $chat = new chat();
    $chat->getParticipantList();

}elseif (isset($_POST['lecturerStart'])) {
    //START CLASS
    $lecturer = new lecturer();
    $lecturer->startClass();

}elseif (isset($_POST['passUpdateSt'])){
    //updating password
    $pass = $_POST['new_pass'];
    $rePass = $_POST['re_pass'];

    $users = new user();
    //verifying if the passwords are correct before going further
    if ($pass==$rePass){
         $users->changePassword($_POST['oldpass'],$pass,'student');
    }else{
        //if the pass doesnt match with re entered password
        header('location: /dyuni/views/?page=deactivate&&msg=The passwords do not match');
    }

}elseif (isset($_POST['passUpdateLec'])){
    //updating password
    $pass = $_POST['new_pass'];
    $rePass = $_POST['re_pass'];

    $users = new user();
    //verifying if the passwords are correct before going further
    if ($pass==$rePass){
         $users->changePassword($_POST['oldpass'],$pass,'lecturer');
    }else{
        //if the pass doesnt match with re entered password
        header('location: /dyuni/views/?page=lecturer_account&&msg=The passwords do not match');
    }

}elseif (isset($_POST['passUpdate'])){
    //updating password
    $pass = $_POST['new_pass'];
    $rePass = $_POST['re_pass'];

    $users = new user();
    //verifying if the passwords are correct before going further
    if ($pass==$rePass){
         $users->changePassword($_POST['oldpass'],$pass,'admin');
    }else{
        //if the pass doesnt match with re entered password
        header('location: /dyuni/views/?page=admin_account&&msg=The passwords do not match');
    }

}
elseif (isset($_GET['addCourse'])){
    //this route is to a new course
    $admin = new Admin();
    $admin->AddCourse();
}elseif (isset($_POST['editCourse'])){
    //this route is to a new course 
    $course = new Courses();
    $course->updateCourse();
}elseif (isset($_GET['deleteCourse'])){
    //this route is to a new course 
    $course = new Courses();
    $course->deleteCourse();
}elseif (isset($_POST['addAdmin'])){
    //this will add a new user
    $admin = new Admin();
    $admin->AddUser();
}elseif (isset($_GET['deleteAdmin'])){
    //this route is to a delete Admin 
    $admin = new Admin();
    $admin->deleteAdmin();
}elseif (isset($_POST['passAdmin'])){
    //this route is to a update user Admin password
    $id = $_POST['id'];
    $pass = $_POST['password'];
    $admin = new Admin();
    $admin->upadtePassword($id,$pass);
}elseif (isset($_POST['editAdmin'])){
    //this route is to a edit Admin 
    $admin = new Admin();
    $admin->updateAdmin();
}elseif (isset($_GET['addClass'])){
    //this will add a new class
    $class = new classes();
    $class->AddClass();
}elseif (isset($_POST['editClass'])){
    //this route is to a new course 
    $class = new classes();
    $class->updateClass();
}elseif (isset($_GET['deleteClass'])){
    //this route is to a new course 
    $class = new classes();
    $class->deleteClass();
}elseif (isset($_POST['addLecturer'])){
   //adding a lecturer
   $admin = new Admin();
   $admin->addLecturer();
}elseif (isset($_POST['editLecturer'])){
    //adding a lecturer
    $lec = new lecturer();
    $lec->updateLecturer();
 }elseif (isset($_GET['deleteLecturer'])){
    //adding a lecturer
    $lec = new lecturer();
    $lec->deleteLecturer();
 }elseif (isset($_POST['passLecturer'])){
    //this route is to a update user Admin password
    $id = $_POST['id'];
    $pass = $_POST['password'];
    $lec = new lecturer();
    $lec->upadtePassword($id,$pass);
}elseif (isset($_POST['addStudent'])){
    //adding student
    $admin = new Admin();
    $admin->addStudent();
}elseif (isset($_POST['editStudent'])){
    //adding student
    $student = new student();
    $student->updateStudent();
}elseif (isset($_GET['deleteStudent'])){
    //adding student
    $student = new student();
    $student->deleteStudent();
}elseif (isset($_POST['passStudent'])){
    //this route is to a update user Admin password
    $id = $_POST['id'];
    $pass = $_POST['password'];
    $student = new student();
    $student->upadtePassword($id,$pass);
}elseif (isset($_POST['lecturerLogin'])){
      //logging in LECTURER user
      $user = new User();
      $user->Login("lecturer");
} elseif (isset($_POST['admin_reg'])) {
    //Registering new admin user
    $admin = new Admin();
    $admin->AddUser();
} elseif (isset($_POST['adminLogin'])) {
    //logging in admin user
    $user = new User();
    $user->Login("admin");
}elseif (isset($_GET['logout'])) {
    //when logging out clear sessions and direct user to login
    $sesHelper->clearAllSessions();
    header('location: /dyuni/index.php');
}
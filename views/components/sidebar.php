<div class="side-menu col-md-2 pt-2 id=">
    <ul>

        <?php
            if (sessionHelper::getSession('admin')==1){
                include "adminNav.php";
            }elseif(sessionHelper::getSession('lecturer')==1){
                include "lecturerNav.php";
            }else{
                include "userNav.php";
            }
        ?>

  </ul>
</div>
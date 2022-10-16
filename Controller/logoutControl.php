<?php
class LogoutController{

    public  static function logOut(){
        session_unset();

        session_destroy();
        header("location:../authontification.php?style=bg-success&message=Aurevoir");
    }
}
?>
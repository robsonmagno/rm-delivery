<?php
if(!empty($_SESSION['usuario_email'])) {
    //session_start();
    echo "OK".$_SESSION['usuario_email'];
}else{
    header("location: login");
}
    
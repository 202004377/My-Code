<?php

    $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $ext = pathinfo($url, PATHINFO_EXTENSION);

    if(!empty($ext)){
        echo '<script type="text/javascript">window.location="./?p=404"; </script>';
    }

    if(!isset($_SESSION['slogged']) && !isset($_SESSION['tlogged'])){ 
        if(isset($_COOKIE['tlogged'])){
            $_SESSION['tuser_id'] = $_COOKIE['tuser_id'];
            $_SESSION['tlogged'] = $_COOKIE['tlogged'];
            $_SESSION['tusername'] = $_COOKIE['tusername'];
            $_SESSION['utype'] = $_COOKIE['utype'];
        }elseif(isset($_COOKIE['slogged'])){
            $_SESSION['suser_id'] = $_COOKIE['suser_id'];
            $_SESSION['slogged'] = $_COOKIE['slogged'];
            $_SESSION['susername'] = $_COOKIE['susername'];
            $_SESSION['utype'] = $_COOKIE['utype'];
        }else{
            //header("location: ./?p=profile/logout");
            echo '<script type="text/javascript">window.location="./?p=homepage"; </script>';
        }
    }
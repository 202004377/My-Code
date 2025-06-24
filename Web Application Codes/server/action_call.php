<?php
    include 'action.php';

    $action_name = $_GET['action'];
    $action = new Action();
    
    
    if($action_name === "signin"){
        $resp = $action->signin();

        echo $resp;
    }else if($action_name === "signup"){
        $resp = $action->signup();

        echo $resp;
    }else if($action_name === "verify"){
        $resp = $action->verify();

        echo $resp;
    }else if($action_name === "checkout"){
        $resp = $action->checkout();

        echo $resp;
    }else if($action_name === "update-user"){
        $resp = $action->update_user();

        echo $resp;
    }else if($action_name === "manage-vehicle"){
        $resp = $action->manage_vehicle();

        echo $resp;
    }else{
        header("location: ../404.html");
        echo '<script> window.location = "../404.html</script>';
    }
    
    
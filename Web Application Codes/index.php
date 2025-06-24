<?php include_once './server/dbconnect.php' ?>

<body>    
    <?php 
        $page = isset($_GET['p']) ? $_GET['p'] : 'home'; 
    
        if(!file_exists($page.".php") && !is_dir($page)){
            include '404.php';
        }else{
            if(is_dir($page)){
                include $page.'/index.php';
            }
        else{
            include $page.'.php';
        }
      }
    ?>

</body>
</html>
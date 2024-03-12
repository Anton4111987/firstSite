
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Site</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
</head>
<body>
    <div class="container">
        <div class="row">
        <?php include_once("pages/functions.php") ?>
            <header class="col-sm-12 col-md-12 col lg-12">
                <?
                    session_start();
                    if(empty($_SESSION["name"]) && empty($_SESSION["error"])) //  добавить проверку есть ли в локал сторадже имя такое
                    {      
                        echo "<h3 class='text-danger'>Вы не авторизованы, пожалуйста авторизуйтесь! </h3>";   
                        if (!isset($_POST["authbtn"])) 
                        {
                ?>  
                        <form action="" method="post">
                        <div class="form-group my-2">
                            <label for="name" class="form-label">Login: </label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>           
                        <div class="form-group my-2">
                            <label for="password" class="form-label">Password: </label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-outline-primary mt-3" name="authbtn">Log in</button>
                        <br/> <br/>
                    </form>
                
                <?
                        }
                        else 
                        {
                            if(login($_POST["name"], $_POST["password"]))
                            {
                                echo "<h3  class='text-succes'> Вы авторизовались под пользователем - " . ($_SESSION['name']) . " </h3>";
                            }
                            else
                            {
                               // echo "<h3 class='text-danger'>Пользователя с таким именем и паролем не существует!!!</h3>";
                                header('Location: index.php?page=4');
                                $_SESSION["error"]="Пользователя с таким именем и паролем не существует, пожалуста зарегистрируйтесь!!!";
                            }
                        }
                    }
                    
                    ?>
                


                
                
            </header>
        </div>
        <div class="row">
            <nav class="col-sm-12 col-md-12 col lg-12">
                <?php include_once("pages/menu.php") ?>
                <?php include_once("pages/functions.php") ?>
            </nav>
        </div>
        <div class="row">
            <section class="col-sm-12 col-md-12 col lg-12">
                <?
                    if(isset($_GET["page"]))
                    {
                        $page=$_GET["page"];
                        if($page==1) include_once("pages/home.php");
                        if($page==2 && !empty($_SESSION["name"])) include_once("pages/upload.php");
                        if($page==3) include_once("pages/gallery.php"); 
                        if($page==4) include_once("pages/registration.php");
                    }

                ?>
            </section>
        </div>
       
    </div>



    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

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
        <?php include_once("pages/functions.php"); 
        include_once("pages/functionsfordb.php") 
        ?>
            <header class="col-sm-12 col-md-12 col lg-12">
                <?php
                    session_start();
                    if(empty($_SESSION["name"]) && empty($_SESSION["error"])) //  добавить проверку есть ли в локал сторадже имя такое
                    {      
                        if (!isset($_POST["authbtn"]) && !isset($_POST["authbtnfordb"])) 
                        {
                            echo "<h3 class='text-danger'>Вы не авторизованы, пожалуйста авторизуйтесь! </h3>";   

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
                        <button type="submit" class="btn btn-outline-primary mt-3" name="authbtnfordb">Log in via DataBase</button>

                        <br/> <br/>
                    </form>
                
                <?php
                        }     
                        else
                        {
                            if (isset($_POST["authbtn"])) 
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
                            if(isset($_POST["authbtnfordb"]))  // если нажата кнопка авторизации через базу данных
                            {                           
                                createdb();
                                if(loginindb($_POST["name"], $_POST["password"]))
                                {
                                    echo "<h3  class='text-succes'> Вы авторизовались в базе данных под пользователем - " . ($_SESSION['name']) . 
                                    "! Теперь можете перейти на страницу загрузки картинок </h3>";

                                }
                                else
                                {
                                    header('Location: index.php?page=4');
                                    $_SESSION["error"]="Пользователя с таким именем и паролем не существует в базе данных, пожалуста зарегистрируйтесь!!!";
                                }
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
                <?php include_once("pages/functionsfordb.php") ?>
            </nav>
        </div>
        <div class="row">
            <section class="col-sm-12 col-md-12 col lg-12">
                <?php
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
        <?php
        if(!isset($_POST["exitbtn"])) 
        {
        ?>
        <form action="" method="post">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-secondary" name="exitbtn">Log out</button>
            </div>
        </form>
        <?php
        }
        else
        {
            unset($_SESSION["name"]);
            header('Location: index.php');
            
        }
        
        ?>
    </div>



    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
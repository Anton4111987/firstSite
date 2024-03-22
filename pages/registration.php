<h1>Registration  Form</h1>
<?php
if(!empty($_SESSION["error"])) //  добавить проверку есть ли в локал сторадже имя такое
{   
    echo "<h3  class='text-danger'> " . ($_SESSION['error']) . " </h3>";
}
?>
<!-- если кнопка регистрации еще не нажималась, то выводим форму регистрации -->
<?
if (!isset($_POST["regbtn"]) && !isset($_POST["regbtnfordb"])) 
{
    ?>
    
        <form action="index.php?page=4" method="post">
            <div class="form-group my-2">
                <label for="login" class="form-label">Login: </label>
                <input type="text" name="login" id="login" class="form-control">
            </div>
            <div class="form-group my-2">
                <label for="email" class="form-label">Email: </label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group my-2">
                <label for="password1" class="form-label">Password: </label>
                <input type="password" name="password1" id="password1" class="form-control">
            </div>
            <div class="form-group my-2">
                <label for="password2" class="form-label">Confirm Password: </label>
                <input type="password" name="password2" id="password2" class="form-control">
            </div>
            <button type="submit" class="btn btn-outline-primary mt-3" name="regbtn">Register</button>
            <button type="submit" class="btn btn-outline-primary mt-3" name="regbtnfordb" value='2'>Register in DataBase</button>

        </form>
    
    <?
} 
else
{
    if(isset($_POST["regbtn"]))
    {
        if(register($_POST["login"], $_POST["email"], $_POST["password1"]))
        {
            echo "<h3 class='text-success'>Новый пользователь добавлен!</h3>";
            //unset($_SESSION["error"]);
            login($_POST["login"], $_POST["password1"]);
        }
    }
    if(isset($_POST["regbtnfordb"])) 
    {    
        createdb();        
        if(registerindb($_POST["login"], $_POST["password1"], $_POST["email"]))
        {
            echo "<h3 class='text-success'>Новый пользователь" . $_POST["login"]  .
            "успешно добавлен в базу данных ! Теперь вы можете успешно добавлять картинки
            в галерею</h3>";
            //unset($_SESSION["error"]);
            //loginindb($_POST["login"], $_POST["password1"]);
            $_SESSION["name"] = $_POST["login"];
            //header('Location: index.php?page=2');
        }
    }
}

?>
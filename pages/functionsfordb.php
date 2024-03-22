<?
function connect(
    $host = "localhost",
    $user = "root",
    $pass = "laant312",
    $dbname = "firstsite"
) {
    $link = new mysqli($host, $user, $pass, $dbname);
    if ($link->connect_error) {
        die("Ошибка: " . $link->connect_error);
    }
    return $link;
}

function loginindb($name, $pass) // авторизация вчерез бд
{
    $name=trim(htmlspecialchars($name));
    $pass=trim(htmlspecialchars($pass));
    if($name=="" || $pass=="")
    {
        echo "<h3  class='text-danger'> Заполните все обязательные поля! </h3>"; 
        return false;
    }
    if(strlen($name)<2 || strlen($name)>15)
    {
        echo "<h3  class='text-danger'> Длина имени должна быть не менее 2х и не более 15 символов! </h3>"; 
        return false;
    }
    if(strlen($pass)<5 || strlen($pass)>15)
    {
        echo "<h3  class='text-danger'> Длина пароля должна быть не менее 5 и не более 15 символов! </h3>"; 
        return false;
    }
    $hashpass=md5($pass);
    $link = connect();
    $sel = "select * from users where name='$name' and pass='$hashpass'";
    //query возвращает объект, который кроме данных хранит служебную информацию о выполнении запроса(кол-во обработанных строк, нумерацию строк и т.д.)
    //чтобы извлечь данные, необходимо использовать метод fetch_assoc, который возвращает данные в виде ассоциативного масива
    $res = $link->query($sel);
    if ($res->fetch_assoc()) {
        $_SESSION["name"] = $name;
        unset($_SESSION["error"]);
        //header('Location: index.php?page=2');
        return true;
    } else {
        echo "<h3><span style='color: red;'>Пользователь не найден!</span></h3>";
        return false;
    }

}

function createdb()
{
    $link = connect();
    $resultusers = $link->query("SHOW TABLES LIKE 'users'");
    $resultimages = $link->query("SHOW TABLES LIKE 'images'");
    if ($resultusers && $resultimages) 
    {
        if($resultusers->num_rows == 1  && $resultimages->num_rows == 1) 
        {
            echo "Таблицы имеются в базе данных";
        } 
        else  // добавляем таблицы
        {
            $createusers = "create table users( 
                id int not null auto_increment primary key,
                name varchar(32) unique,
                pass varchar(128),
                email varchar(128)            
            )";
            $createimages =  "create table images(
                id int not null auto_increment primary key,
                imagepath varchar(255)
            )";
            
            if ($link->query($createusers)) {
                echo "Таблица Users успешно создана";
            } else {
                echo "Ошибка: " . $link->error;
            }

            if ($link->query($createimages)) {
                echo "Таблица Images успешно создана";
            } else {
                echo "Ошибка: " . $link->error;
            }
        }
}
}

function registerindb($name, $pass, $email)
{
    $name=trim(htmlspecialchars($name));
    $email=trim(htmlspecialchars($email));
    $pass=trim(htmlspecialchars($pass));
    if($name=="" || $email=="" || $pass=="")
    {
        echo "<h3  class='text-danger'> Заполните все обязательные поля! </h3>"; 
        return false;
    }
    if(strlen($name)<2 || strlen($name)>15)
    {
        echo "<h3  class='text-danger'> Длина имени должна быть не менее 2х и не более 15 символов! </h3>"; 
        return false;
    }
    if(strlen($pass)<5 || strlen($pass)>15)
    {
        echo "<h3  class='text-danger'> Длина пароля должна быть не менее 5 и не более 15 символов! </h3>"; 
        return false;
    }

    $hashpass=md5($pass);
    $ins = "insert into users(name, pass, email) values('$name', '$hashpass', '$email')";
    $link = connect();
    $link->query($ins);
    $link->close();
    unset($_SESSION["error"]);
    return true;
} 




?>
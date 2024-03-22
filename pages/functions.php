<?php

// файл для хранения пользователей
$users="pages/users.txt"; 

function register($name, $email, $pass)
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

    // получаем глобальную переменную
    global $users;
    //открываем файл users.txt 
    $file = fopen($users, "a+");
    // считываем построчно содержимое файла, считываем по 128 символов
    while($line=fgets($file, 128))
    {
        // из строки извлекаем подстроку которая содержит логин до знака :
        $readname = substr($line, 0, strpos($line, ":"));
        if($readname==$name)
        {
            echo  "<h3>  class='text-danger'> Данное имя пользователя уже занято! </h3>"; 
            return false;
        }
    }
    // формируем строку для нового пользователя
    $line= $name.":".md5($pass).":".$email."\n";
    // записываем файл
    fputs($file, $line);
    fclose($file);
    return true;
} 

function login($name, $pass)
{
    //echo "<h3  class='text-danger'> DJJJJJN! </h3>"; 
    //session_start();
   
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
   // получаем глобальную переменную
    global $users;
   //открываем файл users.txt 
    $file = fopen($users, "a+");
  // считываем построчно содержимое файла, считываем по 128 символов
    while($line=fgets($file, 128))
    {
      // из строки извлекаем подстроку которая содержит логин до знака :
        $readname = substr($line, 0, strpos($line, ":"));
        $data=explode(':', $line);
        $readpass=$data[1];
        if($readname===$name && $readpass===md5($pass))
        {
            $_SESSION["name"]=$readname; // сохранение значений в sessionstorage
            unset($_SESSION["error"]);
            header('Location: index.php?page=2');
            return true;     
        }
    
    }
    return false;
} 

?>

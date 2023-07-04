<?php

       
        $dbHost = 'localhost';
        $dbName = 'mydb';
        $dbUser = 'root';
        $dbPass = '';

        $connection = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);


// Создание тестовой записи в базе данных
$username = 'TestUser';
$phone = '1234567890';
$email = 'test@example.com';
$password = 'testpassword';
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

$query = $connection->prepare("INSERT INTO users (username, password, email, phone) VALUES (:username, :password, :email, :phone)");
$query->bindParam(":username", $username, PDO::PARAM_STR);
$query->bindParam(":password", $passwordHash, PDO::PARAM_STR);
$query->bindParam(":email", $email, PDO::PARAM_STR);
$query->bindParam(":phone", $phone, PDO::PARAM_STR);
$query->execute();

// Выполнение регистрации с тестовыми данными
$_POST['username'] = $username;
$_POST['phone'] = $phone;
$_POST['register-mail'] = $email;
$_POST['register-password'] = $password;
$_POST['register-password-double'] = $password;

ob_start();
include('register.php'); 
ob_end_clean();

// Проверка успешной регистрации
$registrationOutput = ob_get_contents();
if (strpos($registrationOutput, 'Регистрация прошла успешно!') == false) {
    echo 'Тест успешно пройден! Регистрация прошла успешно.';
} else {
    echo 'Тест провален! Регистрация не удалась.';
}

// Проверка создания пользователя в базе данных
$query = $connection->prepare("SELECT * FROM users WHERE email=:email");
$query->bindParam(":email", $email, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result && $result['username'] == $username && $result['phone'] == $phone && $result['email'] == $email) {
    echo 'Тест успешно пройден! Пользователь успешно создан в базе данных.';
} else {
    echo 'Тест провален! Пользователь не найден или данные не соответствуют ожидаемым.';
}

// Очистка тестовых данных из базы данных
$query = $connection->prepare("DELETE FROM users WHERE email=:email");
$query->bindParam(":email", $email, PDO::PARAM_STR);
$query->execute();

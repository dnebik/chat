<?php

/* @var $db PDO */

session_start();
require_once 'scripts/database.php';
//session_destroy();
//session_abort();
//session_reset();
$uri = explode('/', $_SERVER['REDIRECT_URL']);

error_log(date("Y-m-d H:i:s",strtotime('+1 month')));

$render = 'view/error/index.php';
$title = '';

switch ($uri[1]) {

    case 'chat':
        $title = 'Чат';
        if (!$_SESSION['nickname'])
        {
            header("Location: http://chat.dneb.site/login");
            die();
        }
        $render = 'view/chat/index.php';
        break;

    case 'menue':
        $title = 'Меню';
        if (!$_SESSION['nickname'])
        {
            header("Location: http://chat.dneb.site/login");
            die();
        }
        $render = 'view/menue/index.php';
        break;

    case 'login':

//      [ЧЕКАЕ КУКИ]
        if ($_COOKIE['nickname'] && $_COOKIE['color'] && !$_SESSION['nickname'])
        {
            $_SESSION['nickname'] = $_COOKIE['nickname'];
            $_SESSION['color'] = $_COOKIE['color'];

            header("Location: http://chat.dneb.site/menue");
            die();
        }

//      [ЧЕКАЕМ ПОСТ ЗАПРОС]
        if ($_POST['nickname'])
        {
            $_SESSION['nickname'] = $_POST['nickname'];
            $_SESSION['color'] = $_POST['color'];

            setcookie('user[nickname]', $_POST['nickname'], strtotime('+1 month'));
            setcookie('user[color]', $_POST['color'], strtotime('+1 month'));

            $query = $db->prepare("INSERT INTO user (nickname, color) VALUES ('{$_POST['nickname']}', '{$_POST['color']}')");
            $query->execute();
            error_log($query->queryString);

            header("Location: http://chat.dneb.site/menue");
            die();
        }
        $title = 'Вход';
        $render = 'view/login/index.php';
        break;

    case '':
        header("Location: http://chat.dneb.site/menue");
        die();
        break;

    default:
        $render = 'view/error/index.php';
        break;
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/fonts/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/css/reset.css">
    <link rel="stylesheet" href="http://<?= $_SERVER['HTTP_HOST'] ?>/css/style.css">
    <title><?=$title?></title>
</head>
<body>

<?
require_once $render;
?>

</body>
</html>

<script src="http://<?= $_SERVER['HTTP_HOST'] ?>/js/jquery-3.5.1.min.js"></script>
<script src="https://kit.fontawesome.com/d331940b91.js" crossorigin="anonymous"></script>
<script src="http://<?= $_SERVER['HTTP_HOST'] ?>/js/main.js"></script>
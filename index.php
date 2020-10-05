<?php

/* @var $db PDO */

session_start();
require_once 'scripts/database.php';
//session_destroy();
//session_abort();
//session_reset();
$uri = explode('/', $_SERVER['REDIRECT_URL']);

//error_log(print_r($_COOKIE, true));
//error_log(print_r($_SESSION, true));

$render = 'view/error/index.php';
$title = '';

switch ($uri[1]) {

    case 'logout':
//      На кой выходить коли не вошел?
        if (!$_SESSION['nickname']) {
            header("Location: http://chat.dneb.site/login");
            die();
        }

//      Подтирание сессии
        session_reset();
        session_destroy();

//      Чистка куки
        setcookie('user[nickname]', '', 1);
        setcookie('user[color]', '', 1);
        setcookie('user[id]', '', 1);

        header("Location: http://chat.dneb.site/login");
        break;

    case 'chat':
        $title = 'Чат';
//      Без входа ходу нет
        if (!$_SESSION['nickname']) {
            header("Location: http://chat.dneb.site/login");
            die();
        }
        if (!$_GET['id']) {
            header("Location: http://chat.dneb.site");
            die();
        } else {
            $uuid = $_GET['id'];
        }
        $id = $db->query("SELECT id FROM room WHERE uuid = '$uuid'", PDO::FETCH_ASSOC);
        $id->execute();
        $id = $id->fetch()['id'];
        if ($id) {
            $query = "SELECT
                            m.text as text, 
                            u.id as id,
                            u.nickname as nickname,
                            u.color as color
                        FROM message AS m
                        INNER JOIN user AS u ON u.id = m.id_user
                        WHERE id_room = $id
                        ORDER BY publish_date
                        LIMIT 50";
            $messages = $db->query($query, PDO::FETCH_ASSOC);
            $messages->execute();
            $messages = $messages->fetchAll();
            error_log(print_r($messages, true));
            $render = 'view/chat/index.php';
        } else {
            $render = 'view/error/index.php';
        }
        break;

    case 'menue':
        $title = 'Меню';
//      Сначчала войди
        if (!$_SESSION['nickname']) {
            header("Location: http://chat.dneb.site/login");
            die();
        }

//      Нажал на 'создать чат-комнату'
        if ($_POST['create']) {
            $uuid = strtoupper(uniqid($_SESSION['id']));
            $query = $db->prepare("INSERT INTO room (uuid, id_creater) VALUE ('$uuid', '{$_SESSION['id']}')");
            $query->execute();

            header("Location: http://chat.dneb.site/chat?id=$uuid");
            die();
        }
//      Нажал на 'присоединиться'
        if ($_POST['connect']) {
            $uuid = $_POST['uuid'];
            header("Location: http://chat.dneb.site/chat?id=$uuid");
            die();
        }

        $render = 'view/menue/index.php';
        break;

    case 'login':
//      если ты вошел зачем входить??
        if ($_SESSION['nickname']) {
            header("Location: http://chat.dneb.site/menue");
            die();
        }

//      проверяем куки для автовхода
        if (
            $_COOKIE['user']['nickname'] &&
            $_COOKIE['user']['color'] &&
            $_COOKIE['user']['id'] &&
            !$_SESSION['nickname']
        ) {
            $_SESSION['nickname'] = $_COOKIE['user']['nickname'];
            $_SESSION['color'] = $_COOKIE['user']['color'];
            $_SESSION['id'] = $_COOKIE['user']['id'];

            header("Location: http://chat.dneb.site/menue");
            die();
        }

//      чекаем что пришло из формы
        if ($_POST['nickname']) {
            $_SESSION['nickname'] = $_POST['nickname'];
            $_SESSION['color'] = $_POST['color'];

//          создаем данного пользователя
            $query = $db->prepare("INSERT INTO user (nickname, color) VALUES ('{$_POST['nickname']}', '{$_POST['color']}')");
            $query->execute();
            $_SESSION['id'] = $db->lastInsertId();

//          сохроняемся в куках
            setcookie('user[nickname]', $_SESSION['nickname'], strtotime('+1 month'));
            setcookie('user[color]', $_SESSION['color'], strtotime('+1 month'));
            setcookie('user[id]', $_SESSION['id'], strtotime('+1 month'));

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
    <title><?= $title ?></title>
</head>
<body>

<? if ($_SESSION['nickname']) { ?>
    <div class="nav">
        <div>Nickname: <?=$_SESSION['nickname']?></div>
        <div>Color: <div class="user-color" style="background-color: <?=$_SESSION['color']?>"></div></div>
        <div class="btn-logout"><a style="text-decoration: none" href="http://chat.dneb.site/logout">
                <button class="btn-success">Выйти</button>
            </a></div>
    </div>
<? } ?>

<?
require_once $render;
?>

</body>
</html>

<script src="http://<?= $_SERVER['HTTP_HOST'] ?>/js/jquery-3.5.1.min.js"></script>
<script src="https://kit.fontawesome.com/d331940b91.js" crossorigin="anonymous"></script>
<script src="http://<?= $_SERVER['HTTP_HOST'] ?>/js/main.js"></script>
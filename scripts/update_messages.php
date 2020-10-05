<?php
/* @var $db PDO*/

//require 'database.php';
if ($_POST['room']) {
    $query = "SELECT
                            m.text as text, 
                            m.publish_date as time,
                            u.id as id,
                            u.nickname as nickname,
                            u.color as color
                        FROM message AS m
                        INNER JOIN user AS u ON u.id = m.id_user
                        WHERE id_room = {$_POST['room']}";
    if ($_POST['time'])
        $query .= " AND publish_date > '{$_POST['time']}'";
    $query .= " ORDER BY publish_date";
    $messages = $db->query($query, PDO::FETCH_ASSOC);
//    error_log(print_r($messages, true));
    $messages->execute();
    $messages = $messages->fetchAll();

    if ($messages) {
        foreach ($messages as $message)
            require "{$_SERVER['CONTEXT_DOCUMENT_ROOT']}/templates/message.php";
    }
}
?>
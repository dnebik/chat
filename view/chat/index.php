<?php
/* @var $uuid */
/* @var $messages array */
/* @var $id_room */
//error_log("server: " . print_r($_SERVER, true));
?>
<div id="chat-box" class="chat-box")">
    <div class="info-box">
        <p>Код: <?=$_GET['id']?></p>
        <input id="id-room" type="hidden" value="<?=$id_room?>">
    </div>
    <div class="panel">
        <div class="messeges-fild">
            <?foreach ($messages as $message) {?>
                <?require "{$_SERVER['CONTEXT_DOCUMENT_ROOT']}/templates/message.php"?>
            <? } ?>
        </div>
    </div>

    <div class="caht-fild">
        <textarea id="text" class="input-text" rows="1"></textarea>
        <a class="btn" onclick="sendMessege(<?=$id_room?>)"> Отправить </a>
    </div>
</div>
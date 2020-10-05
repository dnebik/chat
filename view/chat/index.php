<?php
/* @var $uuid */
/* @var $messages array */
?>


<div class="chat-box">
    <div class="info-box">
        <p>Код: <?=$_GET['id']?></p>
    </div>
    <div class="panel">
        <div class="messeges-fild">
            <?foreach ($messages as $message) {?>
                <div class="messege-box" style="
                        <?= ($_SESSION['id'] == $message['id'] ?
                            'align-self: end; background-color: aquamarine;' : '')?>
                        ">
                    <div class="sender" style="color: <?=$message['color']?>"><?=$message['nickname']?>:</div>
                    <div class="messege">
                        <?=$message['text']?>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>

    <div class="caht-fild">
        <textarea class="input-text" rows="1"></textarea>
        <a class="btn"> Отправить </a>
    </div>
</div>
<?php
/* @var $message array*/
?>
<div class="messege-box" style="
<?= ($_SESSION['id'] == $message['id'] ?
    'align-self: end; background-color: aquamarine;' : '')?>
        ">
    <div class="sender" style="color: <?=$message['color']?>"><?=$message['nickname']?>:</div>
    <div class="messege">
        <?=htmlentities($message['text'])?>
    </div>
    <input type="hidden" value="<?=$message['time']?>">
</div>
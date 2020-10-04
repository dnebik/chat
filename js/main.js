autosize();
function autosize(){
    var text = $('.input-text');
    var box = $('.chat-box');

    text.each(function(){
        $(this).attr('rows',1);
        resize($(this));
    });

    text.on('input', function(){
        resize($(this));
    });

    function resize ($text) {
        $text.css('height', 'auto');
        var height = box.height() / 3;
        if ($text[0].scrollHeight < height) {
            $text.css('height', $text[0].scrollHeight+'px');
        } else {
            $text.css('height', height + 'px');
        }
    }
}

$(document).ready(function(){
    var elem = $('.messeges-fild')[0];
    console.log(elem);
    elem.scrollTop = elem.scrollHeight;
});
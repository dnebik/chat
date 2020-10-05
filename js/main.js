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
    if (elem)
        elem.scrollTop = elem.scrollHeight;
});

if ($('.color-select')) {
    var color = getRandomColor();
    $(".color-select")[0].value = color;
}

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
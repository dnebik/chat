autosize();
function autosize(){
    var text = $('.input-text');

    text.each(function(){
        $(this).attr('rows',1);
        resize($(this));
    });

    text.on('input', function(){
        resize($(this));
    });

    function resize ($text) {
        $text.css('height', 'auto');
        if ($text[0].scrollHeight < 200) {
            $text.css('height', $text[0].scrollHeight+'px');
        } else {
            $text.css('height', '200px');
        }
    }
}
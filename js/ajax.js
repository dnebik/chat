function sendMessege(id){
    var messege_fild = $('.messeges-fild')[0];
    var text = $('#text').val();
    $.ajax({
        type: "POST",
        url: "http://chat.dneb.site/message",
        data: {text:text, room:id},
        success: function (res) {
            $('#text').val('');
            messege_fild.insertAdjacentHTML('beforeend', res);
            var elem = $('.messeges-fild')[0];
            elem.scrollTop = elem.scrollHeight;
        },
        error: function () {
            alert("Сообщение не отправлено.");
        }
    });
}

function update(id)
{
    var messege_fild = $('.messeges-fild')[0];
    var messege_box = messege_fild.lastElementChild;
    var time = messege_box.lastElementChild.attributes['value'].value
    $.ajax({
        type: "POST",
        url: "http://chat.dneb.site/update",
        data: {room:id, time:time},
        success: function(res){
            messege_fild.insertAdjacentHTML('beforeend', res);
            var elem = $('.messeges-fild')[0];
            if (res)
                elem.scrollTop = elem.scrollHeight;
        }
    });
}

$(document).ready(function () {
    var id_room = $('#id-room')[0].attributes['value'].value;
    if (id_room)
        setInterval('update(' + $('#id-room')[0].attributes['value'].value + ')',3000);
});
$(function () {


    $('.vote-up').on('click', function(event){
        event.stopPropagation();
        event.stopImmediatePropagation();
        //(... rest of your JS code)
        let up = $(this);
        up.next().submit();

    });

    $('.vote-down').on('click', function(event){
        event.stopPropagation();
        event.stopImmediatePropagation();
        //(... rest of your JS code)
        let down = $(this);
        down.next().submit();

    });
});
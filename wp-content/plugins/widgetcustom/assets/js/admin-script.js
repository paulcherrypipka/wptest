jQuery(function($) {
    var $container = '';

    function sendToEditorCust(object) {
        var $newElementCust = $container.find('.ex-custom-attached-wrapper .default').clone();

        console.log('object => ', object);

        var objectDataCust = {
            'name': object.name,
            'link': object.url,
            'description': object.description
        };

        var jsonStr = JSON.stringify(objectDataCust);

        $newElementCust.find('.a-link').text(objectDataCust.name);
        $newElementCust.find('.a-link').attr('href', objectDataCust.link);
        $newElementCust.find('.desk-text').text(objectDataCust.description);
        $newElementCust.find('input').val(jsonStr);
        $newElementCust.removeClass('default');

        $container.find('.ex-custom-attached-wrapper').append($newElementCust);
    }

    $('#wpbody .ex-custom-add').click(function() {
        $container = $(this).parents('.widget');

        var frame = wp.media({
            title:WidgetExCustom.frame_title,
            multiple: true,
            button: { text:WidgetExCustom.button_title }
        });

        frame.on('close', function() {
            var attached = frame.state().get('selection').toJSON();
            $.each(attached, function (key, value) {
                sendToEditorCust(value);
            });
        });

        frame.open();
        return false;
    });

    $("#wpbody").on('click', '.ex-custom-attached-wrapper .remove', function (event) {
        $(this).parents('li').remove();
        return false;
    });
});
// JavaScript Document

jQuery(function ($) {

  var $container = '';

  function sendToEditor(object) {
    var $newElement = $container.find('.ex-attachments .default').clone();

    var objectData = {
      'name' : object.title,
      'link' : object.url,
      'description' : object.description
    };

    var jsonString = JSON.stringify(objectData);

    $newElement.find('.a-link').text(objectData.name);
    $newElement.find('.a-link').attr('href', objectData.link);
    $newElement.find('.desc-text').text(objectData.description);
    $newElement.find('input').val(jsonString);
    $newElement.removeClass('default');

    $container.find('.ex-attachments').append($newElement);
  }

  $("#wpbody").on('click', '.ex-attachment-add-fieldset', function (event) {

    $container = $(this).parents('.widget');

    var frame = wp.media({
      title:WidgetExAttachments.frame_title,
      multiple:true,
      button:{ text:WidgetExAttachments.button_title }
    });

    // Handle results from media manager.
    frame.on('close', function () {
      var attachments = frame.state().get('selection').toJSON();
      $.each(attachments, function (key, value) {
        sendToEditor(value);
      });

    });

    frame.open();
    return false;
  });

  $("#wpbody").on('click', '.ex-attachments .remove', function (event) {
    $(this).parents('li').remove();
    return false;
  });

  $("#wpbody").on('click', '.ex-attachments li .up', function (event) {
    var $container = $(this).parents('li');
    var $prev = $container.prev('li:not(.default)');

    if ($prev.length) {
      var $element = $container.clone();
      $element.insertBefore($prev);
      $container.remove();
    }

    return false;
  });

  $("#wpbody").on('click', '.ex-attachments li .down', function (event) {
    var $container = $(this).parents('li');
    var $next = $container.next('li');

    if ($next.length) {
      var $element = $container.clone();
      $element.insertAfter($next);
      $container.remove();
    }

    return false;
  });

});

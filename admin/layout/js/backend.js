$(function () {
    'use strict';

    $('[placeholder]').focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
        
            $(this).attr('placeholder', $(this).attr('data-text'));
    });

    // add asterisk on required field

    $('input').each(function () {
        if($(this).attr('required') === 'required') {
            $(this).after('<span class="asterisk">*</span>');
        }
    });

    // convert password field to text field on hover

    var passField = $('.password');

    $('.show-pass').hover(function() {
        passField.attr('type', 'text');
    }, function() {
        passField.attr('type', 'password');
    });

    // botun for confirmation delete member
    $('.confirm').click(function(){
        return confirm("are you sure?");
    });
});

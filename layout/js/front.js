$(function () {
    'use strict';



	// Switch Between Login & Signup
	$('.login-page h1 span').click(function () {

		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login-page form').hide();

		$('.' + $(this).data('class')).fadeIn(100);

	});



    // trigger the selectbox
    $("select").selectBoxIt({
        autoWidth: false
    });



    // hid placeholder on form focus
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



    // botun for confirmation delete member
    $('.confirm').click(function(){
        return confirm("are you sure?");
    });

    $('.live').keyup(function(){
            $($(this).data('class')).text($(this).val());
    });

});

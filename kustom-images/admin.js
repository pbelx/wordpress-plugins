jQuery(document).ready(function ($) {
    $('.cci-upload-button').click(function (e) {
        e.preventDefault();
        const targetInput = $('#' + $(this).data('target'));
        const mediaFrame = wp.media({
            title: 'Select or Upload an Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });
        mediaFrame.on('select', function () {
            const attachment = mediaFrame.state().get('selection').first().toJSON();
            targetInput.val(attachment.url);
        });
        mediaFrame.open();
    });
});

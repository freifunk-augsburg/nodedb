// @ToDo: Include as asset and change femanagers function to only match inside femanager
jQuery(document).ready(function($) {
    {
        $('.nodedb *[data-confirm]').click(function (e) {
            e.preventDefault();
            var message = $(this).data('confirm');
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    }
}
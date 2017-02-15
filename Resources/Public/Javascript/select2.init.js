$('select.select2').select2({
});

function setPlaceholder(select) {
    // re-apply placeholder to the search input field
    var fakeelement = $(select).next().first();
    var input = fakeelement.find('.select2-search__field');
    input.attr('placeholder', select.data('placeholder'));
}

$('select.select2').on("select2:selecting", function(e) {
    // id of the selected option
    var id = e.params.args.data.id;

});

$('select.select2').on("select2:close", function(e) {
    setPlaceholder($(this));
});

setPlaceholder($('select.select2').first());


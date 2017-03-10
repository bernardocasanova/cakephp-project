$(function()
{
    $('.check-all').on('click', checkAll);
    $('.uncheck-all').on('click', uncheckAll);
});

function checkAll()
{
    var className = $(this).data('class');

    $(className).prop('checked', true);
}

function uncheckAll()
{
    var className = $(this).data('class');

    $(className).prop('checked', false);
}
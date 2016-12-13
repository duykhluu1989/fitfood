function formatMoney(money)
{
    if(money !== '')
    {
        money = money.split('.').join('');

        var formatted = '';
        var sign = '';

        if(money < 0)
        {
            money = -money;
            sign = '-';
        }

        while(money >= 1000)
        {
            var mod = money % 1000;

            if(formatted != '')
                formatted = '.' + formatted;
            if(mod == 0)
                formatted = '000' + formatted;
            else if(mod < 10)
                formatted = '00' + mod + formatted;
            else if(mod < 100)
                formatted = '0' + mod + formatted;
            else
                formatted = mod + formatted;

            money = parseInt(money / 1000);
        }

        if(formatted != '')
            formatted = sign + money + '.' + formatted;
        else
            formatted = sign + money;

        return formatted;
    }

    return '';
}

function showLoadingScreen()
{
    $('#LoadingModal').modal({

        backdrop: 'static',
        keyboard: false

    });
}

function closeLoadingScreen()
{
    $('#LoadingModal').modal('hide');
}

function showConfirmMessage()
{
    return confirm('Are you sure ?');
}

$('[data-toggle="tooltip"]').tooltip();

$('.InputMoney').keyup(function() {

    $(this).val(formatMoney($(this).val()));

});

$('.DropDownFilterForm').change(function() {

    $('#FilterForm').submit();

});

$('.CheckboxAllControlForm').click(function() {

    if($(this).prop('checked'))
        $('.ControlButtonControlForm').removeAttr('disabled');
    else
        $('.ControlButtonControlForm').prop('disabled', 'disabled');

    $('.CheckboxControlForm').prop('checked', $(this).prop('checked'));

});

$('.CheckboxControlForm').click(function() {

    if($(this).prop('checked'))
    {
        var allChecked = true;

        $('.CheckboxControlForm').each(function() {

            if(!$(this).prop('checked'))
            {
                allChecked = false;
                return false;
            }

        });

        $('.ControlButtonControlForm').removeAttr('disabled');

        if(allChecked)
            $('.CheckboxAllControlForm').prop('checked', $(this).prop('checked'));
    }
    else
    {
        var noneChecked = true;

        $('.CheckboxControlForm').each(function() {

            if($(this).prop('checked'))
            {
                noneChecked = false;
                return false;
            }

        });

        if(noneChecked)
            $('.ControlButtonControlForm').prop('disabled', 'disabled');

        $('.CheckboxAllControlForm').prop('checked', $(this).prop('checked'));
    }

});

$('.ControlButtonControlForm').click(function() {

    if(showConfirmMessage())
    {
        var form = $('#ControlForm');

        $('<input />').attr('type', 'hidden').attr('name', 'control').attr('value', $(this).val()).appendTo(form);
        form.submit();
    }

});
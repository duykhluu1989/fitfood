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


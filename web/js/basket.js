$(document).ready(function() {
    var basket = Cookies.getJSON('basket');
    console.log(basket);
    if(!basket) {
        basket = [];
    }
    var updateTotal = function () {
        var total = 0;
        $('.input_count').each(function (k,i) {
            var $item = $(i);
            total = total + $item.val() * $item.data('cost');
        });
        $('#totalAmount').html(total + ' руб');
    }
    updateTotal();
    $('#basketCounter').html(basket.length);


    $('.buyBtn').on('click', function(e) {
        $btn = $(e.target);
        basket.push($btn.data('pid'));
        Cookies.set('basket',basket);
        $('#basketCounter').html(basket.length);
        $btn.text('Добавлено');
    });

    $('.deleteFromBasketBtn').on('click', function (e) {
        e.preventDefault();
        var pid = $(e.target).data('pid');
        if (!pid) {
            pid = $(e.target).parent().data('pid');
        }
        var nb = [];
        for (var i in basket) {
            console.log(basket[i]);
            if (basket[i] != pid) {
                nb.push(basket[i]);
            }
        }
        Cookies.set('basket',nb);
        window.location.reload();
    });
    
    $('.input_count').on('change', function () {
        updateTotal();
    });


});


$(document).ready(function() {
    var basket = Cookies.getJSON('basket');
    console.log(basket);
    if(!basket) {
        basket = [];
    }
    $('#basketCounter').html(basket.length);
});


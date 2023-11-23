$(document).ready(function () {
    $('.remove-from-cart').click(function (e) {
        e.preventDefault();

        var index = $(this).data('index');

        $.ajax({
            type: 'GET',
            url: '/remove-from-cart/' + index,
            success: function (data) {
                if (data.success) {
                    location.reload();
                } else {
                    $('#error-alert').text(data.message).show();
                }
            },
            error: function () {
                $('#error-alert').text('Une erreur s\'est produite lors du traitement de la demande.').show();
            }
        });
    });

    $('#checkout-button').click(function (e) {
        e.preventDefault();

        $.ajax({
            type: 'GET',
            url: '/checkout', 
            success: function (data) {
                $('#success-alert').text(data.message).show();
                setTimeout(function () {
                    location.reload();
                }, 2000);
                
                
            },
            error: function () {
                $('#error-alert').text('Une erreur s\'est produite lors du traitement de la demande.').show();
            }
        });
    });

    $('.add-to-cart').click(function (e) {
        e.preventDefault();

        var productId = $(this).data('product-id');

        $.ajax({
            type: 'GET',
            url: '/add-to-cart/' + productId,
            success: function (data) {
                if (data.success) {
                    $('#success-alert').text(data.message).show();

                    $('#cart-count').text(data.cartCount);
                    setTimeout(function () {
                        $('#success-alert').hide();
                    }, 3000);
                } else {
                    $('#error-alert').text(data.message).show();
                }
            },
            error: function () {
                $('#error-alert').text('Une erreur s\'est produite lors du traitement de la demande.').show();
            }
        });
    });
});

function openCart(event) {
    event.preventDefault();
    $.ajax({
        url: '/cart/open',
        type: 'GET',
        success: function (res) {
            $('#cart .modal-content').html(res);
            $('#cart').modal('show');
        },
        error: function () {
            alert ('error');
        }
    });
}

function clearCart(event) {
    if (confirm('Точно очистить корзину?')){
        event.preventDefault();
        $.ajax({
            url: '/cart/clear',
            type: 'GET',
            success: function (res) {
                $('#cart .modal-content').html(res);
                $('.menu-quantity').html('(0)');
            },
            error: function () {
                alert ('error');
            }
        });
    }
}

$('.product-button__add').on('click', function (e) {
    e.preventDefault();
    let name = $(this).data('name');
    $.ajax({
        url: '/cart/add',
        data: {name: name},
        type: 'GET',
        success: function (res) {
            $('#cart .modal-content').html(res);
            $('.menu-quantity').html('('+ $('.total-quantity').html() +')');
        },
        error: function () {
            alert ('error');
        }
    });
});

$('.modal-content').on('click', '.btn-close', function () {
    $('#cart').modal('hide');
});

$('.modal-content').on('click', '.delete', function () {
    let id = $(this).data('id');
    $.ajax({
        url: '/cart/delete',
        data: {id: id},
        type: 'GET',
        success: function (res) {
            $('#cart .modal-content').html(res);
            if ( $('.total-quantity').html()) {
                $('.menu-quantity').html('('+ $('.total-quantity').html() +')');
            } else {
                $('.menu-quantity').html('(0)');
            }
        },
        error: function () {
            alert ('error');
        }
    });
});

$('.modal-content').on('click', '.btn-next', function () {
    $.ajax({
        url: '/cart/order',
        type: 'GET',
        success: function (res) {
            $('#order .modal-content').html(res);
            $('#cart').modal('hide');
            $('#order').modal('show');
        },
        error: function () {
            alert ('error');
        }
    });
});

let split = window.location.href.split('/'),
    id = split[split.length - 1],
    nav = document.querySelectorAll('.nav-link');

for (let i=0; i<nav.length; i++) {
    if (nav[i].getAttribute('data-id') == id) {
        nav[i].classList.add('active');
        break;
    } else if (!id) {
        nav[0].classList.add('active');
        break;
    }
}
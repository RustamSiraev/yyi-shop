<h3>Ваш заказ №<?= $order->id ?> принят</h3>
Ваш телефон: <?= $order->phone ?>

<div class="table-responsive">
    <table>
        <thead>
        <tr>
            <th>Наименование</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Сумма</th>
        </tr>
        </thead>

        <tbody>

        <? foreach ($session['cart'] as $id=>$item) { ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $item['goodQuantity'] ?></td>
                <td><?= $item['price'] ?></td>
                <td><?= $item['goodQuantity'] * $item['price'] ?></td>
            </tr>
        <?}?>
        <tr>
            <td colspan="3">Итого:</td>
            <td><?= $session['cart.totalQuantity'] ?> шт.</td>
        </tr>
        <tr>
            <td colspan="3">На сумму:</td>
            <td><?= $session['cart.totalPrice'] ?> рублей</td>
        </tr>

        </tbody>
    </table>
</div>

<?php
    if(isset($cart)) { ?>
        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>QUANTITY</th>
                <th>PRICE</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($cart['items'] as $item) { ?>
                    <tr>
                        <td><?= $item['id']; ?></td>
                        <td><?= $item['name']; ?></td>
                        <td><?= $item['quantity']; ?></td>
                        <td><?= $item['price']; ?> €</td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td><?= $cart['count']; ?></td>
                    <td><?= $cart['total']; ?> €</td>
                </tr>
            </tfoot>
        </table>
    <?php } else { ?>
            <div class="container d-flex justify-content-center">
                <div class="h1">😭 MON PANIER IL EST VIDE, MDR 😭</div>
            </div>
    <?php } ?>
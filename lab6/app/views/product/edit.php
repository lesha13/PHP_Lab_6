<p>
    <?= \Core\Url::getLink('/product/list', 'Повернутись до списку товарів'); ?>
</p>

<?php
$product =  $this->get('product');
?>

<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    <input name="id" value="<?php echo $product['id'] ?>" hidden>
    <label>
        Код товару
        <input name="sku" required value="<?php echo $product['sku'] ?>">
    </label>
    </br>
    <label>
        Назва товару
        <input name="name" required value="<?php echo $product['name'] ?>">
    </label>
    </br>
    <label>
        Ціна товару
        <input name="price" type="number" step="0.01" min="0" value="<?php echo $product['price'] ?>">
    </label>
    </br>
    <label>
        Кількість товару
        <input name="qty" type="number" step="0.001" min="0" value="<?php echo $product['qty'] ?>">
    </label>
    </br>
    <label>
        Опис товару
        </br>
        <textarea name="description" cols="80" rows="5"> <?php echo htmlspecialchars_decode( $product['description']) ?> </textarea>
    </label>
    </br>
    <input type="submit" value="Зберегти">
</form>

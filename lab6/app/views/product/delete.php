<p>
    <?= \Core\Url::getLink('/product/list', 'Повернутись до списку товарів'); ?>
</p>

<?php
$product =  $this->get('product');
?>

<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    <input name="id" type="hidden" value="<?php echo $product['id'] ?>">
    <input type="submit" value="Вилучити">
</form>

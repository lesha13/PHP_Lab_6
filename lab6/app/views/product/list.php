<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
    <select name='sortfirst'>
        <option <?php echo filter_input(INPUT_POST, 'sortfirst') === 'price_ASC' ? 'selected' : ''; ?>
                value="price_ASC">від дешевших до дорожчих
        </option>
        <option <?php echo filter_input(INPUT_POST, 'sortfirst') === 'price_DESC' ? 'selected' : ''; ?>
                value="price_DESC">від дорожчих до дешевших
        </option>
    </select>
    <select name='sortsecond'>
        <option <?php echo filter_input(INPUT_POST, 'sortsecond') === 'qty_ASC' ? 'selected' : ''; ?> value="qty_ASC">по
            зростанню кількості
        </option>
        <option <?php echo filter_input(INPUT_POST, 'sortsecond') === 'qty_DESC' ? 'selected' : ''; ?> value="qty_DESC">
            по спаданню кількості
        </option>
    </select>
    <input type="submit" value="Submit">
</form>

<div class="product">
    <p><?= \Core\Url::getLink('/product/add', 'Додати товар'); ?></p>
</div>

<?php
$products =  $this->get('products');

foreach($products as $product)  :
?>
    <div class="product">
        <p class="sku">Код: <?php echo $product['sku']?></p>
        <h4><?php echo $product['name']?></h4>
        <p> Ціна: <span class="price"><?php echo $product['price']?></span> грн</p>
        <p> Кількість: <?php echo $product['qty']?></p>
        <p><?php if(!($product['qty'] > 0)) { echo 'Нема в наявності'; } ?></p>
        <p>
            <?= \Core\Url::getLink('/product/edit', 'Редагувати', array('id'=>$product['id'])); ?>
        </p>
    </div>
<?php endforeach; ?>


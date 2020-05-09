<?php
$this->registerCss("
.product-container { margin-bottom: 10px; }
")
?>
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-md-6">
            <div class="row product-container">
                <div class="col-md-6">
                    <input class="form-check-input support-checkbox" type="checkbox" value="<?= $product->id ?>" id="product-<?= $product->id ?>">
                    <label class="form-check-label" for="product-<?= $product->id ?>">
                        <?= $product->name_uz . ' (' . number_format($product->amount, 2, ',', ' ') . ' ' . $product->unit . ') ' ?>
                    </label>
                </div>
                <div class="col-md-6">
                    <input class="form-control product-qty" data-product="<?= $product->id ?>" type="number" placeholder="Mahsulot miqdorini kiriting" readonly>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

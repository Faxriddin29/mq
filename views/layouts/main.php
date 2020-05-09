<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/toastr.min.css">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container-fluid" style="padding-top: 20px!important;">
        <div class="row">
            <div class="col-md-2">
                <?php
                echo Nav::widget([
                    'options' => ['class' => 'nav-pills nav-stacked'],
                    'items' => [
                        ['label' => 'Arizachilarni qabul qilish', 'url' => ['/']],
                        ['label' => 'Tasdiqlanganlar', 'url' => ['/support/index']],
                        ['label' => 'Qabul qilganlarni tasdiqlash', 'url' => ['/delivery/index']],
                        ['label' => 'Ombor', 'url' => ['/product/index']],
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-10">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Mehrli qo'llar <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
<script>
    // toastr.options.timeOut = 1500;
</script>
</body>
</html>
<?php $this->endPage() ?>

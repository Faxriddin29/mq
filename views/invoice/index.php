<?php
use app\models\SupportProduct;
/* @var $this yii\web\View */
/* @var $supportings app\models\Support */
?>
<style>
    .mq-invoice {
        padding: 30px 30px 60px 30px;
        border-bottom: 1px dashed;
        width: 992px;
    }
    .mq-title {
        text-align: center;
        margin-bottom: 45px;
    }
    .mq-date {
        width: 100%;
        height: 20px;
        margin: 0 0 20px 0;
        position: relative;
    }
    .mq-date u {
        width: 150px;
        height: 20px;
        display: block;
        float: right;
        position: absolute;
        right: 0;
        padding-bottom: 9px;
        bottom: 0;
        font-size: 14px;
    }
    .mq-top-description {
        text-indent: 50px;
        font-size: 14px;
        margin-bottom: 25px;
    }
    .mq-top-description span {
        text-transform: uppercase;
    }
    .mq-row .mq-label {
        font-size: 14px;
        margin-bottom: 10px;
        float: left;
    }

    .mq-row {
        border-bottom: 1px solid #444;
        margin-bottom: 25px;
        overflow: hidden;
        text-align: center;
        font-size: 14px;
    }

    .mq-row span {
        width: 70%;
        display: inline-block;
        float: right;
        text-align: left;
    }
    .mq-description {
        width: 85%;
        text-align: center;
        margin: 0 auto;
        font-size: 14px;
    }
    .mq-description span {
        display: block;
    }
    .mq-table {
        width: 100%;
        margin: 30px auto;
    }
    .mq-table th, .mq-table td {
        text-align: center;
        font-weight: normal;
        font-size: 16px;
        padding-top: 7px;
    }
    .mq-table .number {
        width: 5%;
    }

    .mq-table .name {
        width: 35%;
    }

    .mq-table .measure,
    .mq-table .weight,
    .mq-table .extra
    {
        width: 15%;
    }

    .mq-footer {
        overflow: hidden;
    }
    .mq-footer-left {
        width: 50%;
        float: left;
    }
    .mq-footer-right {
        width: 50%;
        float: right;
    }
    .mq-footer-left p u {
        width: 150px;
        display: inline-block;
        height: 5px;
        border-bottom: 1px solid #444;
        margin-right: 5px;
        margin-left: 50px;
    }
    .mq-footer-left > span {
        margin-bottom: 10px;
        display: block;
    }
    .mq-footer-left p:last-child {
        width: 225px;
        height: 1px;
        background-color: #444;
        margin-left: 50px;
        margin-top: 35px;
    }

    .mq-footer-right p {
        margin-left: 50px;
    }
    .mq-footer-right span {
        display: inline-block;
        width: 250px;
        height: 1px;
        background-color: #444;
    }
    table.mq-table {
        border:solid #000 !important;
        border-width:1px 0 0 1px !important;
    }
    table.mq-table th, table.mq-table td {
        border:solid #000 !important;
        border-width:0 1px 1px 0 !important;
    }

    table.user-info {
        width: 100%;
        border: none!important;
        margin-bottom: 20px;
    }
    table.user-info td {
        border: none!important;
        font-size: 14px;
        padding: 10px 0 7px;
    }
    table.user-info tr {
        border-bottom:solid #000 !important;
        border-width:0 0 1px 0 !important;
    }
</style>
<div id="print__container">
    <?php foreach ($supportings as $item): $indigent = $item->indigent; ?>
        <div class="mq-invoice">
            <h4 class="mq-title">АКТ ПРИЁМА-ПЕРЕДАЧИ ТОВАРА от</h4>
            <p class="mq-date"><u><?= date('d.m.Y') //date('d.m.Y', strtotime($item->date)) ?></u></p>
            <p class="mq-top-description">ННО Центр молодёжи и детей с ограниченнымы (<span>Меҳрли қўллар</span>) именуемое в дальнейшем Благодаритель, с одной строны и</p>
            <div class="mq-applicant-info">
                <table class="user-info">
                    <tr>
                        <td>ФИО:</td>
                        <td><?= $indigent->last_name . ' ' . $indigent->first_name . ' ' . $indigent->middle_name ?></td>
                    </tr>
                    <tr>
                        <td>Адрес:</td>
                        <td><?= $indigent->address ?></td>
                    </tr>
                    <tr>
                        <td>Телефон:</td>
                        <td><?= $indigent->phone ?></td>
                    </tr>
                </table>
                <p class="mq-description"> именуемое в дальнейшем Благополучатель, с другой стороны, составили настоящий акт о нижеследующем: <span>Благодаритель передаёт Благопалучателю на безвозмездной основе:</span></p>
            </div>
            <table class="mq-table">
                <thead>
                <tr>
                    <th class="number">№</th>
                    <th class="name">Наименование товара</th>
                    <th class="measure">Единица измерения</th>
                    <th class="weight">Вес</th>
                    <th class="extra"></th>
                    <th class="extra"></th>
                </tr>
                </thead>
                <tbody>
                <?php $support_products = $item->supportProducts; foreach ($support_products as $no => $product): ?>
                    <tr>
                        <td class="number">
                            <?= ($no+1) ?>
                        </td>
                        <td class="name">
                            <?= $product->product->name_uz ?>
                        </td>
                        <td class="measure">
                            <?= $product->product->unit ?>
                        </td>
                        <td class="weight">
                            <?= $product->product->amount ?>
                        </td>
                        <td class="extra"></td>
                        <td class="extra"></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            <div class="mq-footer">
                <div class="mq-footer-left">
                    <span>Сдан</span>
                    <p>
                        <u></u>
                        <span>Алимов Б.</span>
                    </p>
                    <p></p>
                </div>
                <div class="mq-footer-right">
                    <p>Приняли:</p>
                    <span></span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

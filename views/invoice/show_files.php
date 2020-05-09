<?php
use mihaildev\elfinder\ElFinder;
use yii\web\JsExpression;
$this->registerCss(".container-fluid > div.row > div.col-md-10 > div {height: 100vh;}");
echo ElFinder::widget([
    'language'         => 'ru',
    'controller'       => 'elfinder',
    'filter'           => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
    'callbackFunction' => new JsExpression('function(file, id){}') // id - id виджета
]);

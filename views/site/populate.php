<?php

/* @var $this yii\web\View */

$this->title = 'NPI Scraper';
$this->registerJsFile(Yii::getAlias('@web/js/populate.js'), ['depends' => 'yii\web\YiiAsset']);
$this->registerCssFile(Yii::getAlias('@web/css/site.css'));
?>

<h1>Populate DB</h1>
<p>Pressing of Start button will launch process of:</p>
<ul>
    <li>deleting all data from DB if exists</li>
    <li>scraping monthly file from page: <a href="<?= $npiPage ?>" target="_blank"><?= $npiPage ?></a></li>
    <li>populating database</li>
</ul>
<a class="btn btn-primary start" href="#" onclick="return ">Start</a>

<div class="result"></div>
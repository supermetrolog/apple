<?php

/* @var $this yii\web\View */

$this->title = 'Apple';
?>

<div class="apple">
    <div class="row main-apple text-center">
        <?= $this->render('generate', ['apples' => $apples]); ?>
    </div>
    <div class="row func-apple">
        <div class="col-lg-12">
            <button class="btn btn-success" id="generateApples">
                Сгенерировать
            </button>
        </div>
    </div>
</div>
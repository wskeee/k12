<?php

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php 
    $params = [
        [
            'label' => Html::img(['/filedata/site/image/words.png']),
            'options' => ['class' => 'pull-right'],
            'childs' => [
                [
                    'label' => Html::a(Html::img(['/filedata/site/image/feedback.png'], ['style' => 'margin-left: 10px;']), "javascript:;", ['title' => '反馈信息']),
                ]
            ],
        ],
    ];
    
    echo $this->render('_header', ['params' => $params]); 
?>
    
<div class="wrap k12">
        
    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php echo $this->render('_footer'); ?>   
    
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php
/* @var $data News */
?>
<h4><?= CHtml::link(CHtml::encode($data->title), $data->getUrl()); ?></h4>
<p> <?= $data->short_text; ?></p>

<p class="text-right"><?= CHtml::link(Yii::t('NewsModule.news', 'read...'), ['/news/news/view/', 'slug' => $data->slug], ['class' => 'btn btn-default']); ?></p>
<hr/>

<?php

/**
 * @var yii\web\View $this
 * @var common\models\User $user
 * @var common\models\Task $task
 */


?>
<?= yii::t('user', 'dear') ?><strong><?= $user->realname ?></strong>:

<br><br>
<span style="text-indent: 2em"><?= yii::t('task', 'task') ?><?= yii::t('w', 'cross') ?><?= $task->title ?>
    <?= yii::t('conf', 'has') ?>  <?= \Yii::t('w', 'task_status_' . $task['status']) ?></span>
<br><br>
<?= yii::t('w', 'w notice1') ?><a href='http://devops.m.qiyi.domain/'><?= yii::t('w', 'w') ?> </a><?= yii::t('w', 'w notice2') ?>

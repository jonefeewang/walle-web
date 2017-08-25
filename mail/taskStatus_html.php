<?php
use yii\helpers\Url;
/**
 * @var yii\web\View $this
 * @var common\models\User $user
 * @var common\models\Task $task
 */


?>
<?= yii::t('user', 'dear') ?><strong><?= $user->realname ?></strong>:

<br><br>
<span style="font-size: 11px;font-family: 'Microsoft YaHei';"><?= $task->title ?>
    <?= yii::t('conf', 'has') ?>  <?= \Yii::t('w', 'task_status_' . $task['status']) ?></span>
<br>
<table style="font-size: 11px;font-family: 'Microsoft YaHei';width:100%;table-layout:fixed;border-collapse: collapse;border-spacing: 0;">
    <tbody>
    <tr style="height:20px;line-height: 20px;">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'submit title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
       <a href="<?= Url::to('@web' . '/task',true) ?>"> <?= $task->title ?> </a>
    </td>
    </tr>

    <tr style="height:20px;line-height:20px;">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'reqm_type title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= \Yii::t('task', $task->reqm_type) ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'reqm_source title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= $task->reqm_source ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'content title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= str_replace(PHP_EOL, "<br>", $task->content) ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'temp_theme title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= str_replace(PHP_EOL, "<br>", $task->temp_theme) ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'baselib_config title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= $task->baselib_config ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'developer title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= implode('<br>', $taskUserModel->developer) ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'deployer title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= implode('<br>', $taskUserModel->deployer) ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'reviewer title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= implode('<br>', $taskUserModel->reviewer) ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'tester title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= implode('<br>', $taskUserModel->tester) ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'pass_review title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?php
        if ($task->pass_review) {
            ?>
            <i>是</i>
        <?php } else { ?>
            <i ">否</i>
        <?php } ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'pass_test title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?php
        if ($task->pass_test) {
            ?>
            <i>是</i>
        <?php } else { ?>
            <i ">否</i>
        <?php } ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'rollback_time title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= str_replace(PHP_EOL, "<br>", $task->rollback_time) ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'deploy_time title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= str_replace(PHP_EOL, "<br>", $task->deploy_time) ?>
    </td>
    </tr>


    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'regular_check title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= str_replace(PHP_EOL, "<br>", $task->regular_check) ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'select branch') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= $task->branch ?>
    </td>
    </tr>

    <tr style="height:20px;line-height: 20px;
    ">
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box;word-wrap: break-word;word-break: break-all;vertical-align: middle;background-color: #f9fbfc;width:80px;">
        <?= yii::t('task', 'apply_template title') ?>
    </td>
    <td style="border:1px solid #e6e9ea;padding:5px 10px;box-sizing: border-box=;word-wrap: break-word;word-break: break-all;vertical-align: middle;width:600px;">
        <?= \Yii::t('w', 'conf_apply_template_' . $conf->apply_template) ?>
    </td>
    </tr>


    </tbody>
</table>


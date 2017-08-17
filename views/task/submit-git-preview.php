<?php
/**
 * @var yii\web\View $this
 */
$this->title = $conf->name;

?>

<div class="profile-user-info">
    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'submit title') ?> </div>

        <div class="profile-info-value">
            <span><?= $task->title ?></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'reqm_type title') ?> </div>

        <div class="profile-info-value">
            <span><?= \Yii::t('task', $task->reqm_type) ?></span>
        </div>
    </div>
    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'reqm_source title') ?> </div>

        <div class="profile-info-value">
            <span><?= $task->reqm_source ?></span>
        </div>
    </div>


    <h4 class="lighter"><i class="icon-file orange"></i><?= yii::t('task', 'content title') ?></h4>
    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'content title') ?> </div>

        <div class="profile-info-value">
            <span><?= str_replace(PHP_EOL, "<br>", $task->content) ?></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'temp_theme title') ?> </div>

        <div class="profile-info-value">
            <span><?= str_replace(PHP_EOL, "<br>", $task->temp_theme) ?></span>
        </div>
    </div>
    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'baselib_config title') ?> </div>

        <div class="profile-info-value">
            <span><?= $task->baselib_config ?></span>
        </div>
    </div>


    <h4 class="lighter"><i class="icon-group orange"></i><?= yii::t('task', 'members') ?></h4>

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'developer title') ?> </div>

        <div class="profile-info-value">
            <span><?= $task->developer ?></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'deployer title') ?> </div>

        <div class="profile-info-value">
            <span><?= $task->deployer ?></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'reviewer title') ?> </div>

        <div class="profile-info-value">
            <span><?= str_replace(PHP_EOL, "<br>", $task->reviewer) ?></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name">  <?= yii::t('task', 'tester title') ?></div>

        <div class="profile-info-value">
            <span><?= $task->tester ?></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'pass_review title') ?> </div>

        <div class="profile-info-value">
            <span>
                <?php
                if ($task->pass_review) {
                    ?>
                    <i class="icon-check-square-o orange"></i>
                <?php } else { ?>
                    <i class="icon-close orange"></i>
                <?php } ?>
            </span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'pass_test title') ?> </div>

        <div class="profile-info-value">
            <span>
                  <?php
                  if ($task->pass_test) {
                      ?>
                      <i class="icon-check-square-o orange"></i>
                  <?php } else { ?>
                      <i class="icon-close orange"></i>
                  <?php } ?>
            </span>
        </div>
    </div>
    <!-- 目标机器 配置 end-->

    <!-- 任务配置-->

    <h4 class="lighter"><i class="icon-list-ol orange"></i><?= yii::t('task', 'other') ?></h4>


    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'rollback_time title') ?> </div>

        <div class="profile-info-value">
            <span><?= str_replace(PHP_EOL, "<br>", $task->rollback_time) ?></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'deploy_time title') ?> </div>

        <div class="profile-info-value">
            <span><?= str_replace(PHP_EOL, "<br>", $task->deploy_time) ?></span>
        </div>
    </div>
    <!-- 目标机器 配置 end-->

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'regular_check title') ?> </div>

        <div class="profile-info-value">
            <span><?= str_replace(PHP_EOL, "<br>", $task->regular_check) ?></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'select branch') ?> </div>

        <div class="profile-info-value">
            <span><?= $task->branch ?></span>
        </div>
    </div>

    <div class="profile-info-row">
        <div class="profile-info-name"> <?= yii::t('task', 'apply_template title') ?> </div>

        <div class="profile-info-value">
            <span><?= \Yii::t('w', 'conf_apply_template_' . $conf->apply_template) ?></span>
        </div>
    </div>


</div>

<?php
/**
 * @var yii\web\View $this
 */
$this->title = yii::t('task', 'list title');

use \app\models\Task;
use yii\widgets\LinkPager;
use yii\helpers\Url;

?>
<div class="box">
    <div class="box-header">
        <form action="/task/" method="POST">
            <input type="hidden" value="<?= \Yii::$app->request->getCsrfToken(); ?>" name="_csrf">
            <div class="col-xs-2 col-sm-2">
                <div class="form-group">
                    <select name="project_id" class="form-control">
                        <option value="0"><?= yii::t('task', 'list project') ?></option>
                        <?php foreach ($projects as $project) { ?>
                            <option value="<?= $project['id'] ?>"<?= ($projectId == $project['id'] ? ' selected' : '') ?>><?= $project['name'] ?>
                                - <?= \Yii::t('w', 'conf_level_' . $project['level']) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-8" style="padding-left: 0;margin-bottom: 10px;">
                <div class="input-group">
                    <input type="text" name="kw" class="form-control search-query"
                           placeholder="<?= yii::t('task', 'list placeholder') ?>" value="<?= $kw ?>">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default btn-sm">
                            Search
                            <i class="icon-search icon-on-right bigger-110"></i>
                        </button>
                    </span>
                </div>
            </div>
        </form>
        <?php if (\app\models\Group::isDeveloper(\Yii::$app->getUser()->id)) { ?>
            <a class="btn btn-default btn-sm" href="<?= Url::to('@web/task/submit/') ?>">
                <i class="icon-pencil align-top bigger-125"></i>
                <?= yii::t('task', 'create task') ?>
            </a>
        <?php } ?>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive no-padding clearfix">
        <table class="table table-striped table-bordered table-hover">
            <tbody>
            <tr>
                <?php if ($audit) { ?>
                    <th><?= yii::t('task', 'l_user') ?></th>
                <?php } ?>
                <th><?= yii::t('task', 'l_project') ?></th>
                <th><?= yii::t('task', 'l_title') ?></th>
                <th><?= yii::t('task', 'l_time') ?></th>
                <th><?= yii::t('task', 'l_branch') ?></th>
                <th><?= yii::t('task', 'l_commit') ?></th>
                <th><?= yii::t('task', 'l_status') ?></th>
                <th><?= yii::t('task', 'l_opera') ?></th>
            </tr>
            <?php foreach ($list as $item) { ?>
                <tr>
                    <?php if ($audit) { ?>
                        <td><?= $item['user']['realname'] ?></td>
                    <?php } ?>
                    <td><?= $item['project']['name'] ?> - <?= \Yii::t('w',
                            'conf_level_' . $item['project']['level']) ?></td>
                    <td><?= $item['title'] ?></td>
                    <td><?= $item['updated_at'] ?></td>
                    <td><?= $item['branch'] ?></td>
                    <td><?= $item['commit_id'] ?></td>
                    <td class="<?= \Yii::t('w', 'task_status_' . $item['status'] . '_color') ?>">
                        <?= \Yii::t('w', 'task_status_' . $item['status']) ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= Url::to("@web/task/submit/?taskId={$item['id']}&projectId={$item['project']['id']}&action=preview") ?>"
                               data-toggle="modal" data-target="#myModal">
                                <i class="icon-zoom-in bigger-130"></i>
                                <?= yii::t('conf', 'p_preview') ?>
                            </a>

                            <?php if ($audit && in_array($item['status'],
                                    [Task::STATUS_SUBMIT])
                            ) { ?>
                                <label>
                                    <input class="ace ace-switch ace-switch-5 task-operation"
                                        <?= $item['status'] == Task::STATUS_PASS ? 'checked' : '' ?>
                                           type="checkbox" data-id="<?= $item['id'] ?>">
                                    <span class="lbl"></span>
                                </label>
                            <?php } ?>
                            <?php if ($item['user_id'] == \Yii::$app->user->id) { ?>
                                <!-- 通过审核可以上线的任务-->
                                <?php if (Task::canDeploy($item['status'])) { ?>

                                    <a data-id="<?= $item['id'] ?>"
                                       onclick="deployOnline(<?= $item['id'] ?>,<?= $item['project']['id'] ?>)"
                                       href="javascript:;">
                                        <i class="icon-cloud-upload text-success bigger-130"></i>
                                        <?= yii::t('task', 'deploy') ?>
                                    </a>
                                <?php }
                            }
                            ?>
                            <!-- 任务回测-->
                            <?php if ($item['status'] == Task::STATUS_DONE && \app\models\TaskUser::isTester($item['id'], \Yii::$app->user->id)) { ?>
                                <a href="javascript:;" class="brown" data-id="<?= $item['id'] ?>"
                                   onclick="reTest(<?= $item['id'] ?>,<?= $item['project']['id'] ?>)">
                                    <i class="icon-reply bigger-130"></i>
                                    <?= yii::t('task', 'retest ok') ?>
                                </a>
                            <?php } ?>
                            <?php if ($item['status'] != Task::STATUS_DONE && $item['user_id'] == \Yii::$app->user->id) { ?>
                                <a class="red btn-delete" href="javascript:;" data-id="<?= $item['id'] ?>">
                                    <i class="icon-trash bigger-130"></i>
                                    <?= yii::t('task', 'delete') ?>
                                </a>
                            <?php } ?>

                        </div>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div><!-- /.box-body -->
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<script type="text/javascript">
    function deployOnline(taskId, projectId) {
        $.get("<?= Url::to('@web/task/submit') ?>", {
                taskId: taskId,
                projectId: projectId,
                action: 'deploy',
            },
            function (data) {
                if (data.code == 0) {
                    window.location.reload();
                } else {
                    alert(data.msg);
                }
            }
        );
    }

    // 上线回测
    function reTest(taskId, projectId) {
        $.get("<?= Url::to('@web/task/submit') ?>", {
                taskId: taskId,
                projectId: projectId,
                action: 'retest',
            },
            function (data) {
                if (data.code == 0) {
                    window.location.reload();
                } else {
                    alert(data.msg);
                }
            }
        );
    }

    $(function () {
        // 发起上线
        $('.task-operation').click(function () {
            $this = $(this);
            $.get("<?= Url::to('@web/task/task-operation') ?>", {
                    id: $this.data('id'),
                    operation: $this.is(':checked') ? 1 : 0
                },
                function (data) {
                    if (data.code == 0) {
                        window.location.reload();
                    } else {
                        alert(data.msg);
                    }
                }
            );
        });

        // 垃圾任务删除
        $('.btn-delete').click(function (e) {
            $this = $(this);
            if (confirm('<?= yii::t('w', 'js delete confirm') ?>')) {
                $.get('<?= Url::to('@web/task/delete') ?>', {taskId: $this.data('id')}, function (o) {
                    if (!o.code) {
                        $this.closest("tr").remove();
                    } else {
                        alert('<?= yii::t('task', 'js delete failed') ?>' + o.msg);
                    }
                })
            }
        })
    })
</script>
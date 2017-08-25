<?php

namespace app\controllers;

use app\components\Command;
use app\models\forms\TaskUserModel;
use app\models\TaskUser;
use app\models\User;
use yii;
use yii\data\Pagination;
use yii\helpers\Url;
use app\components\Controller;
use app\models\Task;
use app\models\Project;
use app\models\Group;

class TaskController extends Controller
{

    protected $task;

    /**
     * 我的上线列表
     *
     * @param int $page
     * @param int $size
     * @return string
     */
    public function actionIndex($page = 1, $size = 15)
    {
        $size = $this->getParam('per-page') ?: $size;
        $list = Task::find()
            ->with('user')
            ->with('project')
            ->leftJoin("group", "task.project_id=group.project_id")
            ->where(['group.user_id' => $this->uid]);

        $projectTable = Project::tableName();
        $groupTable = Group::tableName();
        $projects = Project::find()
            ->leftJoin(Group::tableName(), "`$groupTable`.`project_id` = `$projectTable`.`id`")
            ->where([
                "`$projectTable`.status" => Project::STATUS_VALID,
                "`$groupTable`.`user_id`" => $this->uid
            ])
            ->asArray()
            ->all();

        // 有审核权限的任务
        $auditProjects = Group::getAuditProjectIds($this->uid);
        if ($auditProjects) {
            $list->orWhere(['task.project_id' => $auditProjects]);
        }

        $kw = \Yii::$app->request->post('kw');
        if ($kw) {
            $list->andWhere(['or', "commit_id like '%" . $kw . "%'", "title like '%" . $kw . "%'"]);
        }

        $projectId = (int)\Yii::$app->request->post('project_id');
        if (!empty($projectId)) {
            $list->andWhere(['=', 'task.project_id', $projectId]);
        }

        $tasks = $list->orderBy('id desc');
        $list = $tasks->offset(($page - 1) * $size)
            ->limit($size)
            ->asArray()
            ->all();

        $pages = new Pagination(['totalCount' => $tasks->count(), 'pageSize' => $size]);

        return $this->render('list', [
            'list' => $list,
            'pages' => $pages,
            'audit' => $auditProjects,
            'projects' => $projects,
            'kw' => $kw,
            'projectId' => $projectId
        ]);
    }

    /**
     * 提交任务
     *
     * @param integer $projectId 没有projectId则显示列表
     * @return string
     * @throws
     */
    public function actionSubmit($projectId = null, $taskId = null, $action = "new")
    {

        // 为了方便用户更改表名，避免表名直接定死
        $projectTable = Project::tableName();
        $groupTable = Group::tableName();
        if (!$projectId) {
            // 显示所有项目列表
            $projects = Project::find()
                ->leftJoin(Group::tableName(), "`$groupTable`.`project_id` = `$projectTable`.`id`")
                ->where([
                    "`$projectTable`.status" => Project::STATUS_VALID,
                    "`$groupTable`.`user_id`" => $this->uid
                ])
                ->asArray()
                ->all();

            return $this->render('select-project', [
                'projects' => $projects,
            ]);
        }

        $task = new Task();
        $taskUserModel = new TaskUserModel();

        $conf = Project::getConf($projectId);
        if (!$conf) {
            throw new \Exception(yii::t('task', 'unknown project'));
        }

        if (\Yii::$app->request->getIsPost()) {

            $group = Group::find()
                ->where(['user_id' => $this->uid, 'project_id' => $projectId])
                ->count();
            if (!$group) {
                throw new \Exception(yii::t('task', 'you are not the member of project'));
            }

            if ($task->load(\Yii::$app->request->post()) && $taskUserModel->load(\Yii::$app->request->post())) {
                // 是否需要审核
                // 添加上线申请单
                $status = $conf->audit == Project::AUDIT_YES ? Task::STATUS_SUBMIT : Task::STATUS_PASS;
                $task->user_id = $this->uid;
                $task->project_id = $projectId;
                $task->status = $status;


                if ($task->save()) {
                    $taskUserList = array();

                    //上线单保存成功后,将上线单涉及的人全部保存起来,


                    //开发者
                    foreach ($taskUserModel->developer as $userId) {
                        $taskUser = new TaskUser();
                        $taskUser->user_id = $userId;
                        $taskUser->task_id = $task->id;
                        $taskUser->role = 1;
                        $taskUserList[] = $taskUser;
                    }

                    //review人员
                    foreach ($taskUserModel->reviewer as $userId) {
                        $taskUser = new TaskUser();
                        $taskUser->user_id = $userId;
                        $taskUser->task_id = $task->id;
                        $taskUser->role = 2;
                        $taskUserList[] = $taskUser;
                    }
                    //上线人员
                    foreach ($taskUserModel->deployer as $userId) {
                        $taskUser = new TaskUser();
                        $taskUser->user_id = $userId;
                        $taskUser->task_id = $task->id;
                        $taskUser->role = 3;
                        $taskUserList[] = $taskUser;
                    }
                    //测试人员
                    foreach ($taskUserModel->tester as $userId) {
                        $taskUser = new TaskUser();
                        $taskUser->user_id = $userId;
                        $taskUser->task_id = $task->id;
                        $taskUser->role = 4;
                        $taskUserList[] = $taskUser;
                    }

                    $taskUser = new TaskUser();

                    //批量插入
                    if (count($taskUserList) > 0)
                        Yii::$app->db->createCommand()->batchInsert(TaskUser::tableName(), $taskUser->attributes(), $taskUserList)->execute();

                    $this->sendEmailUpdate($task, $projectId, $status);
                    return $this->redirect('@web/task/');
                }
            }
        }

        if ($conf->repo_type == Project::REPO_GIT) {
            $tpl = Project::$APPLY_TEMPLATE[$conf->apply_template];
        } else
            $tpl = 'submit-svn';

        $userAry = array();
        if ($action == "new") {
            // 列出项目相关的所有用户
            $users = User::find()
                ->select(['id', 'email', 'realname'])
                ->where(['is_email_verified' => 1])
                ->asArray()->all();
            foreach ($users as $user) {
                $userAry[$user['id']] = $user['email'] . '-' . $user['realname'];
            }
        } else if ($action == "deploy") {
            $this->actionTaskDeploy($taskId);
            return $this->redirect('@web/task/');

        } else if ($action == "retest") {
            $this->actionTaskRetest($taskId);
            return $this->redirect('@web/task/');

        } else if ($action == "preview") { //是否为预览模式
            $task = Task::getTask($taskId);
            $tpl .= '-preview';
            $this->layout = 'modal';


            $taskUserModel = $this->getUserModel($taskId, $taskUserModel);

        }

        return $this->render($tpl, [
            'task' => $task,
            'conf' => $conf,
            'users' => $userAry,
            'taskUserModel' => $taskUserModel,
        ]);
    }


    /**
     * 任务删除
     *
     * @return string
     * @throws \Exception
     */
    public function actionDelete($taskId)
    {
        $task = Task::findOne($taskId);
        if (!$task) {
            throw new \Exception(yii::t('task', 'unknown deployment bill'));
        }
        if ($task->user_id != $this->uid) {
            throw new \Exception(yii::t('w', 'you are not master of project'));
        }
        if ($task->status == Task::STATUS_DONE) {
            throw new \Exception(yii::t('task', 'can\'t delele the job which is done'));
        }
        if (!$task->delete()) {
            throw new \Exception(yii::t('w', 'delete failed'));
        }
        $this->renderJson([]);
    }

    /**
     * 生成回滚任务
     *
     * @return string
     * @throws \Exception
     */
    public function actionRollback($taskId)
    {
        $this->task = Task::findOne($taskId);
        if (!$this->task) {
            throw new \Exception(yii::t('task', 'unknown deployment bill'));
        }
        if ($this->task->user_id != $this->uid) {
            throw new \Exception(yii::t('w', 'you are not master of project'));
        }
        if ($this->task->ex_link_id == $this->task->link_id) {
            throw new \Exception(yii::t('task', 'no rollback twice'));
        }
        $conf = Project::find()
            ->where(['id' => $this->task->project_id, 'status' => Project::STATUS_VALID])
            ->one();
        if (!$conf) {
            throw new \Exception(yii::t('task', 'can\'t rollback the closed project\'s job'));
        }

        // 是否需要审核
        $status = $conf->audit == Project::AUDIT_YES ? Task::STATUS_SUBMIT : Task::STATUS_PASS;

        $rollbackTask = new Task();
        $rollbackTask->attributes = $this->task->attributes;
        $rollbackTask->commit_id = $this->task->getRollbackCommitId();
        $rollbackTask->status = $status;
        $rollbackTask->action = Task::ACTION_ROLLBACK;
        $rollbackTask->link_id = $this->task->ex_link_id;
        $rollbackTask->title = $this->task->title . ' - ' . yii::t('task', 'rollback');
        if ($rollbackTask->save()) {
            $url = $conf->audit == Project::AUDIT_YES ? Url::to('@web/task/') : Url::to('@web/walle/deploy?taskId=' . $rollbackTask->id);
            $this->renderJson([
                'url' => $url,
            ]);
        } else {
            $this->renderJson([], -1, yii::t('task', 'create a rollback job failed'));
        }
    }


    /**
     * 任务上线
     *
     * @param $id
     * @param $operation
     */
    public function actionTaskDeploy($id)
    {
        $task = Task::findOne($id);
        if (!$task) {
            static::renderJson([], -1, yii::t('task', 'unknown deployment bill'));
        }
        $task->status = Task::STATUS_DONE;
        $task->save();
        $this->sendEmailUpdate($task, $task->project_id, $task->status);
        static::renderJson(['status' => \Yii::t('w', 'task_status_' . $task->status)]);
    }

    /**
     * 线上回测
     *
     * @param $id
     * @param $operation
     */
    public function actionTaskRetest($id)
    {
        $task = Task::findOne($id);
        if (!$task) {
            static::renderJson([], -1, yii::t('task', 'unknown deployment bill'));
        }

        $task->status = Task::STATUS_PASS_ONLINE_TEST;
        $task->save();
        $this->sendEmailUpdate($task, $task->project_id, $task->status);
        static::renderJson(['status' => \Yii::t('w', 'task_status_' . $task->status)]);
    }


    /**
     * 任务审核
     *
     * @param $id
     * @param $operation
     */
    public function actionTaskOperation($id, $operation)
    {
        $task = Task::findOne($id);
        if (!$task) {
            static::renderJson([], -1, yii::t('task', 'unknown deployment bill'));
        }
        // 是否为该项目的审核管理员（超级管理员可以不用审核，如果想审核就得设置为审核管理员，要不只能维护配置）
        if (!Group::isAuditAdmin($this->uid, $task->project_id)) {
            throw new \Exception(yii::t('w', 'you are not master of project'));
        }

        $task->status = $operation ? Task::STATUS_PASS : Task::STATUS_REFUSE;
        $task->save();
        $this->sendEmailUpdate($task, $task->project_id, $task->status);
        static::renderJson(['status' => \Yii::t('w', 'task_status_' . $task->status)]);
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmailUpdate($task, $projectId, $status)
    {

//        //开发人员-1,reviewer-2,deployer-3,tester-4
//        $role=0;
//        switch ($status){
//            case 0: //申请单刚提交
//
//
//
//        }
//
        ##找出参与项目的所有人的email
        $users = User::oriFind()
            ->select('user.*')
            ->leftJoin('`group`', '`group`.user_id=user.id')
            ->where(['`group`.project_id' => $projectId])
            ->with('group')
            ->all();

        $taskUserModel = new TaskUserModel();
        $taskUserModel = $this->getUserModel($task->id, $taskUserModel);

        foreach ($users as $user) {
            Command::log('send email --' . Yii::$app->mail->compose(['html' => 'taskStatus_html'],
                    ['user' => $user, 'task' => $task, 'conf' => Project::getConf($projectId), 'taskUserModel' => $taskUserModel])
                    ->setFrom(Yii::$app->mail->messageConfig['from'])
                    ->setTo($user->email)
                    ->setSubject('【' . Yii::t('w', 'w') . Yii::t('w', 'cross')
                        . Yii::t('w', 'task_status_' . $task['status']) . '】' . Yii::t('w', 'cross') . $task->title)
                    ->send());
        }


        return true;
    }

    /**
     * @param $taskId
     * @param $taskUserModel
     */
    public function getUserModel($taskId, $taskUserModel)
    {
        $taskUsers = (new \Yii\db\Query())
            ->select('user.realname,user.email,taskuser.role')
            ->from('taskuser')
            ->leftJoin('user', '`taskuser`.user_id=user.id')
            ->where(['`taskuser`.task_id' => $taskId])
            ->all();

//            unset($taskUserModel->developer, $taskUserModel->reviewer, $taskUserModel->deployer, $taskUserModel->tester);
        $taskUserModel->developer = null;
        $taskUserModel->reviewer = null;
        $taskUserModel->deployer = null;
        $taskUserModel->tester = null;
        foreach ($taskUsers as $taskUser) {
            switch ($taskUser['role']) {
                case 1:
                    $taskUserModel->developer[] = $taskUser['realname'] . '-' . $taskUser['email'];
                    break;
                case 2:
                    $taskUserModel->reviewer[] = $taskUser['realname'] . '-' . $taskUser['email'];
                    break;
                case 3:
                    $taskUserModel->deployer[] = $taskUser['realname'] . '-' . $taskUser['email'];
                    break;
                case 4:
                    $taskUserModel->tester[] = $taskUser['realname'] . '-' . $taskUser['email'];
                    break;
            }

        }
        return $taskUserModel;
    }

}

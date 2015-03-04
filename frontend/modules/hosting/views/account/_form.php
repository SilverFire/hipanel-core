<?php

/* @var $this frontend\components\View */
/* @var $model frontend\modules\hosting\models\Account */
/* @var $type string */

use \frontend\widgets\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use Yii;

$action = [
    'user'    => 'create',
    'ftponly' => 'create-ftp'
]

?>
<?php if ($model->scenario == 'insert_user') { ?>
    <h4><?= Yii::t('app', 'Created account will have access via SSH and FTP to the server') ?></h4>
<?php } ?>

    <div class="ticket-form" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        <?php $form        = ActiveForm::begin([
            'action' => in_array($type, $model->getKnownTypes()) ? Url::toRoute($action[$type]) : Url::toRoute(['update', 'id' => $model->id]),
        ]);
        $model->sshftp_ips = $model->getSshFtpIpsList();
        print Html::activeHiddenInput($model, 'type', ['value' => 'user']);
        ?>
        <!-- Properties -->
        <div class="row">
            <div class="col-md-4">
                <?php
                print $form->field($model, 'server_id')->widget(Select2::classname(), [
                    'attribute' => 'server_id',
                    'model'     => $model,
                    'url'       => Url::to(['/server/server/list'])
                ]);
                print $form->field($model, 'login');

                $spell = [
                    'random'   => Yii::t('app', 'Random'),
                    'good'     => Yii::t('app', 'Good'),
                    'better'   => Yii::t('app', 'Better'),
                    'the best' => Yii::t('app', 'The best'),
                ];

                print $form->field($model, 'password')->widget(\frontend\widgets\PasswordInput::className());

                print $form->field($model, 'sshftp_ips')
                           ->hint(Yii::t('app', 'Access to the account is opened by default. Please input the IPs, for which the access to the server will be granted'))
                           ->input('text', [
                               'data' => [
                                   'title'   => Yii::t('app', 'IP restrictions'),
                                   'content' => Yii::t('app', 'Text about IP restrictions'),
                               ]
                           ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div><!-- ticket-_form -->


<?php

$this->registerJs("
    $('#account-sshftp_ips').popover({placement: 'top', trigger: 'focus'});
");
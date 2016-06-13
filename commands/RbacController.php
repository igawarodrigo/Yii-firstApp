<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $author = $auth->createRole('author');
        $reader = $auth->createRole('reader');
        $editor = $auth->createRole('editor');
        $admin = $auth->createRole('admin');

        $auth->add($author);
        $auth->add($reader);
        $auth->add($editor);
        $auth->add($admin);

        $auth->addChild($author, $reader);
        $auth->addChild($editor, $author);
        $auth->addChild($admin,$editor);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        // $auth->assign($author, 2);
        // $auth->assign($admin, 1);
    }
}

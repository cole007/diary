<?php
/**
 * Diary plugin for Craft CMS 3.x
 *
 * Plugin to monitor mood and diet
 *
 * @link      http://cole007.net
 * @copyright Copyright (c) 2018 cole007
 */

namespace cole007\diary\controllers;

use cole007\diary\Diary;
use cole007\diary\records\User AS UserRecord;
use cole007\diary\models\User AS UserModel;

use Craft;
use craft\web\Controller;

/**
 * @author    cole007
 * @package   Diary
 * @since     0.0.1
 */
class UserController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'register', 'validate'];
    protected $fields = ['name', 'email', 'sms', 'password'];


    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the UserController actionIndex() method';

        return $result;
    }

    /**
     * @return mixed
     */
    public function actionValidate()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();
        $email = $request->getBodyParam('email');
        $sms = $request->getBodyParam('sms');

        $response = [
            'user' => [
                'sms' => $sms,
                'email' => $email
            ]
        ];     
        if (strlen($email) == 0 && strlen($sms) == 0) {
            $response['errors'][] = 'Email or SMS incomplete';
            return $this->renderTemplate('validate', $response);
        } else {
            $query = [];
            if (strlen($email) > 0) $query['email'] = $email;
            if (strlen($sms) > 0) $query['sms'] = $sms;
            $userRecord = UserRecord::find()->where($query)->one();
            if (count($userRecord) == 0) {
                $response['errors'][] = 'Email or SMS not registered';
                return $this->renderTemplate('validate', $response);    
            } else {
                $email = Diary::getInstance()->user->sendEmail( $userRecord );
                return $this->redirectToPostedUrl();
            }
        }

    }
    
    public function actionLogin()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();
        $email = $request->getBodyParam('email');
        $password = $request->getBodyParam('password');
        $password = Craft::$app->security->hashData($password);
        $userRecord = UserRecord::find()->where([
            'email' => $email,
            'password' => $password
        ])->one();
        
        $response = [
            'user' => [
                'email' => $email
            ],            
        ];

        // Craft::dd($response);
        if (count($userRecord) == 0) {
            $response['errors'] = ['No account found with these details'];
            return $this->renderTemplate('signin', $response);
        }
        // check here if account is validated (eg not draft)
        if ($userRecord->status == 'draft') {
            $response['errors']['activate'] = 'Your account has not yet been activated';
            return $this->renderTemplate('signin', $response);
        }
        Craft::dd($userRecord);
        // set user session
    }
    public function actionRegister()
    {
        $this->requirePostRequest();
        $success = true;
        $request = Craft::$app->getRequest();
        $user = new UserModel;
        foreach ($this->fields AS $field) {
            $user->$field = $request->getBodyParam($field);
        }
        $user->status = 'draft';
        // check exists ??
        $email = UserRecord::find()->where(['email'=>$user->email])->all();
        $sms = UserRecord::find()->where(['sms'=>$user->sms])->all();
        $response = [
            'user' => $user
        ];        
        
        if (count($email) > 0 OR count($sms) > 0) {
            $valid = false;
            $success = false;
            $response['errors'] = [];
            if (count($email) > 0) $response['errors']['email'][] = 'Email already registered';
            if (count($sms) > 0) $response['errors']['sms'][] = 'SMS already registered';
        } else {
            $valid = $user->validate();
        }
        
        if (!$valid) {
            $success = false;
            if (count($response['errors']) == 0) $response['errors'] = $user->getErrors();            
            return $this->renderTemplate('register', $response);    
        } else {
            // save record
            $hash = Craft::$app->security->hashData($user->password);
            $user->password = $hash;
            $saved = Diary::getInstance()->user->saveUser( $user );
            // Craft::dd($user);
            // send validation email
            // $success
        }
        return $this->redirectToPostedUrl();
    }
}

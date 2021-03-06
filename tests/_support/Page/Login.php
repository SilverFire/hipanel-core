<?php
/**
 * HiPanel core package
 *
 * @link      https://hipanel.com/
 * @package   hipanel-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2019, HiQDev (http://hiqdev.com/)
 */

namespace hipanel\tests\_support\Page;

use hipanel\tests\_support\AcceptanceTester;

class Login
{
    /**
     * @var \AcceptanceTester
     */
    protected $tester;

    public function __construct(AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    public function login($login, $password)
    {
        $I = $this->tester;

        $I->amGoingTo('Login with Hiam');
        $I->amOnPage('/site/login');
        $I->waitForElement('#loginform-username');
        $I->fillField('#loginform-username', $login);
        $I->fillField('#loginform-password', $password);
        $I->click('#login-form button[type=submit]');
        $I->wait(3);
        $I->see($login);

        return $this;
    }
}

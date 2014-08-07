<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	// added the debug toolkit
	// sessions support
	// authorization for login and logut redirect
	public $components = array(
		'DebugKit.Toolbar',
		'RequestHandler',
		'Session',
		'Security',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
			'authError' => 'You must be logged in to view this page.',
			'loginError' => 'Invalid Username or Password entered, please try again.',
			            'authenticate' => array(
						'Form' => array( 'passwordHasher' => 'Blowfish'),
						'Basic' => array( 'passwordHasher' => 'Blowfish'),
						
            )

 
        ));
	
	// only allow the login controllers only
	public function beforeFilter() {
        $this->Auth->allow('login');
        
        /*
//Force us to use SSL
         $this->Security->blackHoleCallback = 'forceSSL';
            $this->Security->requireSecure();
           
*/
       
    }
    function forceSSL() {
    //Redirect non-secure calls to SSL
       // $this->redirect('https://' . env('SERVER_NAME') . $this->here);
    }
	
	public function isAuthorized($user) {
		// Here is where we should verify the role and give access based on role
		
		return true;
	}
	
}

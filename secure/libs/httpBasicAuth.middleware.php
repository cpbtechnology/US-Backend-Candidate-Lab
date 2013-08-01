<?php

require_once 'idiorm.php';
require_once 'cryptastic.php';
 
class HttpBasicAuth extends \Slim\Middleware
{
    /**
     * @var string
     */
    protected $realm;

    /**
     * @var array
     */
    protected $exclude;
 
    /**
     * Constructor
     *
     * @param   array  $exclude      The HTTP Authentication realm
     * @param   string  $realm      The HTTP Authentication realm
     */
    public function __construct($exclude = array(), $realm = 'Protected Area')
    {
        $this->realm = $realm;
        $this->exclude = $exclude;
    }
 
    /**
     * Deny Access
     *
     */   
    public function deny_access() {
        $res = $this->app->response();
        $res->status(401);
        $res->header('WWW-Authenticate', sprintf('Basic realm="%s"', $this->realm));        
    }
 
    /**
     * Authenticate 
     *
     * @param   string  $username   The HTTP Authentication username
     * @param   string  $password   The HTTP Authentication password     
     *
     */
    public function authenticate($username, $password) {         
        if(isset($username) && isset($password)) {
            $user = ORM::for_table('users')
                ->where('user_name', $username)
                ->where('password', crypt($password, CRYPT_SALT))
                ->find_one();
            return !empty($user) ? $user->id : false;
        }
        else
            return false;
    }
 
    /**
     * Call
     *
     * This method will check the HTTP request headers for previous authentication. If
     * the request has already authenticated, the next middleware is called. Otherwise,
     * a 401 Authentication Required response is returned to the client.
     */
    public function call()
    {
        $req = $this->app->request();
        $uri = $req->getPathInfo();
        $res = $this->app->response();
        $authUser = $req->headers('PHP_AUTH_USER');
        $authPass = $req->headers('PHP_AUTH_PW');
        $userId = $this->authenticate($authUser, $authPass);
        if (!in_array($uri, $this->exclude) || !!$userId) {
            // Setup Encryption
            $cryptastic = new cryptastic;
            $this->app->cryptastic = $cryptastic;
            $this->app->cryptKey = $cryptastic->pbkdf2($authPass, CRYPT_SALT, 1000, 32);
            // Setup Userid
            $this->app->userId = $userId;
            $this->next->call();
        } else {
            $this->deny_access();
        }
    }
}
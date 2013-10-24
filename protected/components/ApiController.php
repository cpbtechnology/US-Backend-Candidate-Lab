<?php
/**
 * ApiController class file
 * 
 * @author Ryp Walters <ryp@overcoffee.com>  
 */
class ApiController extends Controller
{
    const APPLICATION_ID = 'LAB';
    
    /**
     * Before Action: All action need to be authenticated
     *
     * @param CAction $action
     */
    protected function beforeAction( $action )
    {
        // Check the authentication
        // Check if we have the USERNAME and PASSWORD HTTP headers set?
        if( !isset( $_SERVER[ 'HTTP_X_' . self::APPLICATION_ID . '_USERNAME'] ) OR
            !isset( $_SERVER[ 'HTTP_X_' . self::APPLICATION_ID . '_KEY'] ) ) 
        {

Yii::log( 'here with server: ' . print_r( $_SERVER, 1 ) );

            // Error: Unauthorized and end nicely
            JsonHandler::_sendResponse(401);
        }
        
Yii::log( 'here with user: ' . $_SERVER[ 'HTTP_X_' . self::APPLICATION_ID . '_USERNAME'] . ' and ' .
            ' key: ' . $_SERVER[ 'HTTP_X_' . self::APPLICATION_ID . '_KEY'] );

        // Get the fields
        $username = $_SERVER[ 'HTTP_X_' . self::APPLICATION_ID . '_USERNAME'];
        $api_key = $_SERVER[ 'HTTP_X_' . self::APPLICATION_ID . '_KEY'];
        
        // Check via Identity
        $identity = new UserIdentity( $username, $api_key );
        $identity->authenticateByApiKey( $api_key );
        switch( $identity->errorCode )
        {
            case UserIdentity::ERROR_NONE:
                //$duration=$this->rememberMe ? Yii::app()->controller->module->rememberMeTime : 0;
                $duration = 0;
                Yii::app()->user->login( $identity, $duration );
                break;

            case UserIdentity::ERROR_EMAIL_INVALID:
            case UserIdentity::ERROR_USERNAME_INVALID:
            case UserIdentity::ERROR_STATUS_NOTACTIV:
            case UserIdentity::ERROR_STATUS_BAN:
                // Error: Unauthorized
                // Send and End nicely
                JsonHandler::_sendResponse(401, 'Error: User Name is invalid');
                break;

            case UserIdentity::ERROR_PASSWORD_INVALID:
                // Error: Unauthorized
                JsonHandler::_sendResponse( 401, 'Error: User Password is invalid' );
                break;
        }

        // Call the parent to check its stuff too
        return parent::beforeAction( $action );
    }
}

?>

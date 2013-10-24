<?php
/**
 * NotesApiController class file: Handles adding and removing notes
 * 
 * @author Ryp Walters <ryp@overcoffee.com>  
 */
class JsonHandler
{
    /**
     * Local vars
     **/

    /**
     * Sends the API response 
     * 
     * @param int $status 
     * @param string $body 
     * @param string $content_type 
     * @access private
     * @return void
     */
    public function _sendResponse( $status = 200, $body = '', $content_type = 'text/html' )
    {
    $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        // Get the status message
        $sStatusMessage = ( ( isset( $codes[ $status ] ) ) ? $codes[ $status ] : '' );
        
        // Set the header
        // Set the status
        header( 'HTTP/1.1 ' . $status . ' ' . $sStatusMessage );
        
        // Set the content type
        header('Content-type: ' . $content_type);

        // If we don't have a body, make it
        if( $body == '' )
        {
            // create some body messages
            $message = '';

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch( $status )
            {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;

                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;

                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;

                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // Generate the body
            $body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
                        <html>
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                                <title>' . $status . ' ' . $sStatusMessage . '</title>
                            </head>
                            <body>
                                <h1>' . $sStatusMessage . '</h1>
                                <p>' . $message . '</p>
                                <hr />
                            </body>
                        </html>';

        }

        // Send the body
        echo $body;
        
        // Exit nicely
        Yii::app()->end();
    }

    /**
     * Returns the json or xml encoded array
     * 
     * @param mixed $model 
     * @param mixed $array Data to be encoded
     * @access private
     * @return void
     */
    public function _getObjectEncoded( $model, $array )
    {
        return CJSON::encode( $array );
    }
}
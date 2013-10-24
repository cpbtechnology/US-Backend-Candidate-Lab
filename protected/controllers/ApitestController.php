<?php
/**
 * ApitestControler.php: Test features for the API
 *
 * @author Ryp Walters <ryp@overcoffee.com>
 **/

class ApitestController extends Controller
{
    const APPLICATION_ID = 'LAB';

    /**
     * Index Action: Show the tests
     *
     * @access public
     * @return void
     **/
    public function actionIndex()
    {
        // Make sure that they are logged in
		if( !Yii::app()->user->id )
        {
            // Nope...  send them to the login page
            $this->redirect( '/' );
        }

        // render the index page
        $this->render( 'index' );
    }
    
    /**
     * List Action: Show all notes for this person
     *
     * @access public
     * @return void
     **/
    public function actionList()
    {
        // Make sure that they are logged in
		if( !Yii::app()->user->id )
        {
            // Nope...  send them to the login page
            $this->redirect( '/' );
        }

        // Get the user info
        $oUser = User::model()->findByPk( Yii::app()->user->id );
        
        // Create the request
        // URL on which we have to post data
        $url = "http://c-p-and-b-lab.overcoffee.com/api/notes";
        
        // Any other field you might want to post
//        $json_data = json_encode(array("name"=>"PHP Rockstart", "age"=>29));
//        $post_data['json_data'] = $json_data;
//        $post_data['secure_hash'] = mktime();
        
        // Initialize cURL
        $ch = curl_init();

//echo 'password = ' . $oUser->profile->api_key;
//print_r( $oUser );
        // Set the customer headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'HTTP_X_' . self::APPLICATION_ID . '_PASSWORD: ' . $oUser->password,
            'X_' . self::APPLICATION_ID . '_USERNAME: ' . $oUser->username,
            'X_' . self::APPLICATION_ID . '_KEY: ' . $oUser->profile->api_key
            ));

        // enable tracking
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        
        // Set URL on which you want to post the Form and/or data
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // Data+Files to be posted
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        
        // Pass TRUE or 1 if you want to wait for and catch the response against the request made
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // For Debug mode; shows up any error encountered during the operation
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        
        // Execute the request
        $response = curl_exec($ch);
        
        // Grab out request, too
        $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT );
        
        // render the index page
        $this->render( 'results',
                      array( 'type' => 'list',
                             'request' => $headerSent,
                             'response' => $response ) );
    }
    
    /**
     * Create Action: Show all notes for this person
     *
     * @access public
     * @return void
     **/
    public function actionCreate()
    {
        // Make sure that they are logged in
		if( !Yii::app()->user->id )
        {
            // Nope...  send them to the login page
            $this->redirect( '/' );
        }

        // Get the user info
        $oUser = User::model()->findByPk( Yii::app()->user->id );
        
        // Create the request
        // URL on which we have to post data
        $url = "http://c-p-and-b-lab.overcoffee.com/api/notes";
        
        // Any other field you might want to post
//        $json_data = json_encode(array("name"=>"PHP Rockstart", "age"=>29));
        $post_data[ 'title' ] = $_POST[ 'title' ];
        $post_data[ 'description' ] = $_POST[ 'description' ];
        
        // Initialize cURL
        $ch = curl_init();

//echo 'password = ' . $oUser->profile->api_key;
//print_r( $oUser );
        // Set the customer headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'HTTP_X_' . self::APPLICATION_ID . '_PASSWORD: ' . $oUser->password,
            'X_' . self::APPLICATION_ID . '_USERNAME: ' . $oUser->username,
            'X_' . self::APPLICATION_ID . '_KEY: ' . $oUser->profile->api_key
            ));

        // enable tracking
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        
        // Set URL on which you want to post the Form and/or data
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // Data+Files to be posted
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        
        // Pass TRUE or 1 if you want to wait for and catch the response against the request made
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // For Debug mode; shows up any error encountered during the operation
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        
        // Execute the request
        $response = curl_exec($ch);
        
        // Grab out request, too
        $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT );
        
        // render the index page
        $this->render( 'results',
                      array( 'type' => 'create',
                             'request' => $headerSent,
                             'response' => $response ) );
    }
    
    /**
     * Read Action: Pull a note
     *
     * @access public
     * @return void
     **/
    public function actionRead()
    {
        // Make sure that they are logged in
		if( !Yii::app()->user->id )
        {
            // Nope...  send them to the login page
            $this->redirect( '/' );
        }

        // Get the user info
        $oUser = User::model()->findByPk( Yii::app()->user->id );
        
        // Create the request
        // URL on which we have to post data
        $url = 'http://c-p-and-b-lab.overcoffee.com/api/notes/' . $_POST[ 'id' ];
        
        // Initialize cURL
        $ch = curl_init();

//echo 'password = ' . $oUser->profile->api_key;
//print_r( $oUser );
        // Set the customer headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X_' . self::APPLICATION_ID . '_USERNAME: ' . $oUser->username,
            'X_' . self::APPLICATION_ID . '_KEY: ' . $oUser->profile->api_key
            ));

        // enable tracking
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        
        // Set URL on which you want to post the Form and/or data
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // Pass TRUE or 1 if you want to wait for and catch the response against the request made
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // For Debug mode; shows up any error encountered during the operation
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        
        // Execute the request
        $response = curl_exec($ch);
        
        // Grab out request, too
        $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT );
        
        // render the index page
        $this->render( 'results',
                      array( 'type' => 'read',
                             'request' => $headerSent,
                             'response' => $response ) );
    }
    
    /**
     * Delete Action: Delete a note
     *
     * @access public
     * @return void
     **/
    public function actionDelete()
    {
        // Make sure that they are logged in
		if( !Yii::app()->user->id )
        {
            // Nope...  send them to the login page
            $this->redirect( '/' );
        }

        // Get the user info
        $oUser = User::model()->findByPk( Yii::app()->user->id );
        
        // Create the request
        // URL on which we have to post data
        $url = 'http://c-p-and-b-lab.overcoffee.com/api/notes/' . $_POST[ 'id' ];
        
        // Initialize cURL
        $ch = curl_init();

//echo 'password = ' . $oUser->profile->api_key;
//print_r( $oUser );
        // Set the customer headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'X_' . self::APPLICATION_ID . '_USERNAME: ' . $oUser->username,
            'X_' . self::APPLICATION_ID . '_KEY: ' . $oUser->profile->api_key
            ));

        // enable tracking
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        
        // Set our type
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        // Set URL on which you want to post the Form and/or data
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // Pass TRUE or 1 if you want to wait for and catch the response against the request made
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // For Debug mode; shows up any error encountered during the operation
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        
        // Execute the request
        $response = curl_exec($ch);
        
        // Grab out request, too
        $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT );
        
        // render the index page
        $this->render( 'results',
                      array( 'type' => 'delete',
                             'request' => $headerSent,
                             'response' => $response ) );
    }

    /**
     * Update Action: Update a note
     *
     * @access public
     * @return void
     **/
    public function actionUpdate()
    {
        // Make sure that they are logged in
		if( !Yii::app()->user->id )
        {
            // Nope...  send them to the login page
            $this->redirect( '/' );
        }

        // Get the user info
        $oUser = User::model()->findByPk( Yii::app()->user->id );
        
        // Create the request
        // URL on which we have to post data
        $url = "http://c-p-and-b-lab.overcoffee.com/api/notes/" . $_POST[ 'id' ];
        
        // Any other field you might want to post
//        $json_data = json_encode(array("name"=>"PHP Rockstart", "age"=>29));
        $post_data[ 'title' ] = $_POST[ 'title' ];
        $post_data[ 'description' ] = $_POST[ 'description' ];
        
        // Initialize cURL
        $ch = curl_init();

//echo 'password = ' . $oUser->profile->api_key;
//print_r( $oUser );
        // Set the customer headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'HTTP_X_' . self::APPLICATION_ID . '_PASSWORD: ' . $oUser->password,
            'X_' . self::APPLICATION_ID . '_USERNAME: ' . $oUser->username,
            'X_' . self::APPLICATION_ID . '_KEY: ' . $oUser->profile->api_key
            ));

        // enable tracking
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        
        // Set URL on which you want to post the Form and/or data
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // Set our type
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

        // Data+Files to be posted
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        
        // Pass TRUE or 1 if you want to wait for and catch the response against the request made
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // For Debug mode; shows up any error encountered during the operation
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        
        // Execute the request
        $response = curl_exec($ch);
        
        // Grab out request, too
        $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT );
        
        // render the index page
        $this->render( 'results',
                      array( 'type' => 'update',
                             'request' => $headerSent,
                             'response' => $response ) );
    }
    
}
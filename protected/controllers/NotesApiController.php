<?php
/**
 * NotesApiController class file: Handles adding and removing notes
 * 
 * @author Ryp Walters <ryp@overcoffee.com>  
 */
class NotesApiController extends ApiController
{
    /**
     * Private vars
     */
    public $sThisComponent = 'Notes';
    
    /**
     * @return array action filters
     */
    public function filters()
    {
            return array();
    }

    /**
     * Before Action: All action need to be authenticated
     * No need for auth here, because it is handled in the parent class
     */
//    protected boolean beforeAction( $action )
//    {}
    
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array( 'index' , 'list' ),
				'users'=>array('*'),
			),
		);
	}

    /**
     * Index Action
     * 
     * @access public
     * @return void
     */
    public function actionIndex()
    {
        // Odd user request.  Assume they want a list
        $this->actionList();
    }

    /**
     * List Action: list all notes assigned to this user
     * 
     * @access public
     * @return void
     */
    public function actionList()
    {
        // Get the results
        $models = Notes::model()->findAll( 'creator_id = ' . Yii::app()->user->id );

        // Detect if we have none...
        if( !count( $models ) )
        {
            // Send response and end nicely
            JsonHandler::_sendResponse( 200, sprintf( 'No items where found for API component <b>%s</b>', $this->sThisComponent ) );
        }
        else
        {
            // Result
            $aRows = array();
            
            // Load them
            foreach( $models as $aThisModel )
            {
                $aRows[] = $aThisModel->attributes;
            }

            // Send response and end nicely
            JsonHandler::_sendResponse( 200, CJSON::encode( $aRows ) );
        }
    }

    /**
     * View Action: Shows a single item
     * 
     * @access public
     * @return void
     */
    public function actionView()
    {
        // Check if an id was submitted via GET
        if( !isset( $_GET[ 'id' ] ) )
        {
            // Send response and end nicely
            JsonHandler::_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
        }

        // Simplify
        $iItemId = $_GET['id'];
        
        // Attempt to get it
        $model = Notes::model()->find( 'creator_id = ' . Yii::app()->user->id .
                                         ' AND tbl_notes_id = ' . $iItemId );

        // Did we find it?
        if( is_null( $model ) )
        {
            // Nope
            // Send response and end nicely
            JsonHandler::_sendResponse(404, 'No Item found with id ' . $iItemId );
        }
        else
        {
            // Yep
            // Send response and end nicely
            JsonHandler::_sendResponse(200, CJSON::encode( $model->attributes ) );
        }
    }
    
    
    /**
     * Create Action: Creates a new item
     * 
     * @access public
     * @return void
     */
    public function actionCreate()
    {
        // Setup our model
        $model = new Notes;                    

        // Try to assign POST values to attributes
        foreach( $_POST as $var=>$value )
        {
            // Does the model have this attribute?
            if( $model->hasAttribute( $var ) )
            {
                $model->$var = $value;
            }
            else
            {
                // No, raise an error
                // Send response and end nicely
                JsonHandler::_sendResponse(500,
                    sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var, $this->sThisComponent ) );
            }
        }
        
        // Load the creator id
        $model->creator_id = Yii::app()->user->id;
        
        // Try to save the model
        if( $model->save() )
        {
            // Saving was OK
            // Send response and end nicely
            JsonHandler::_sendResponse(200, CJSON::encode( $model->attributes ) );
        }
        else
        {
            // Errors occurred
            $msg = "<h1>Error</h1>";
            $msg .= sprintf( "Couldn't create model <b>%s</b>", $this->sThisComponent );
            $msg .= "<ul>";
            foreach( $model->errors as $attribute=>$attr_errors )
            {
                $msg .= "<li>Attribute: $attribute</li>";
                $msg .= "<ul>";
                
                // Spin through them
                foreach($attr_errors as $attr_error)
                {
                    $msg .= "<li>$attr_error</li>";
                }        
                $msg .= "</ul>";
            }
            
            $msg .= "</ul>";

            // Send response and end nicely
            JsonHandler::_sendResponse(500, $msg );
        }
    }

    /**
     * Update Action: Update a single item
     * 
     * @access public
     * @return void
     */
    public function actionUpdate()
    {
        // Check if an id was submitted via GET
        if( !isset( $_GET[ 'id' ] ) )
        {
            // Send response and end nicely
            JsonHandler::_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
        }

        // Simplify
        $iItemId = $_GET['id'];
        
        // Get PUT parameters
//        parse_str( file_get_contents( 'php://input' ), $put_vars );

        // See if we have this item to update?
        $model = Notes::model()->find( 'creator_id = ' . Yii::app()->user->id .
                                         ' AND tbl_notes_id = ' . $iItemId );

        // Do we?
        if( is_null( $model ) )
        {
            // Nope!
            // Send response and end nicely
            JsonHandler::_sendResponse(400,
                sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.", $this->sThisComponent, $iItemId ) );
            
        }
        
        // Try to assign PUT parameters to attributes
        foreach( $_POST as $var=>$value )
        {
            // Does model have this attribute?
            if( $model->hasAttribute( $var ) )
            {
                // Yep, so load it
                $model->$var = $value;
            }
            else
            {
                // No, raise error
                // Send response and end nicely
                JsonHandler::_sendResponse(500,
                    sprintf('Parameter <b>%s</b> is not allowed for model <b>%s</b>', $var, $this->sThisComponent ) );
            }
        }
        
        // Try to save the model
        if( $model->save() )
        {
            // Send response and end nicely
            JsonHandler::_sendResponse(200,
                sprintf('The model <b>%s</b> with id <b>%s</b> has been updated.', $this->sThisComponent, $iItemId ) );
        }
        else
        {
            $msg = "<h1>Error</h1>";
            $msg .= sprintf( "Couldn't update model <b>%s</b>", $this->sThisComponent );
            $msg .= "<ul>";
            
            // Spin through the errors
            foreach($model->errors as $attribute=>$attr_errors)
            {
                $msg .= "<li>Attribute: $attribute</li>";
                $msg .= "<ul>";

                // Spin through the error attributes
                foreach($attr_errors as $attr_error)
                {
                    $msg .= "<li>$attr_error</li>";
                }        
                $msg .= "</ul>";
            }
            $msg .= "</ul>";

            // Send response and end nicely
            JsonHandler::_sendResponse(500, $msg );
        }
    }
    
    
    /**
     * Deletes a single item
     * 
     * @access public
     * @return void
     */
    public function actionDelete()
    {
        // Check if an id was submitted via GET
        if( !isset( $_GET[ 'id' ] ) )
        {
            // Send response and end nicely
            JsonHandler::_sendResponse(500, 'Error: Parameter <b>id</b> is missing' );
        }

        // Simplify
        $iItemId = $_GET['id'];
        
        // See if we have this item
        $model = Notes::model()->find( 'creator_id = ' . Yii::app()->user->id .
                                         ' AND tbl_notes_id = ' . $iItemId );

        // Was a model found?
        if( is_null( $model ) )
        {
            // No, raise an error
            JsonHandler::_sendResponse(400,
                sprintf("Error: Didn't find any model <b>%s</b> with ID <b>%s</b>.",$this->sThisComponent, $iItemId ) );
        }

        // Delete the model
        $num = $model->delete();

        // Did it work?
        if( $num > 0 )
        {
            // Yep
            JsonHandler::_sendResponse(200,
                sprintf("Model <b>%s</b> with ID <b>%s</b> has been deleted.", $this->sThisComponent, $iItemId ) );
        }
        else
        {
            // Nope
            JsonHandler::_sendResponse(500,
                sprintf("Error: Couldn't delete model <b>%s</b> with ID <b>%s</b>.", $this->sThisComponent, $iItemId ) );
        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Notes API v1 Documentation</title>
        <style type="text/css">
            body {
                font-family: "Helvetica Neue Light", "HelveticaNeue-Light", "Helvetica Neue", Calibri, Helvetica, Arial;
            }

            li, li p, li p span {
                font-size: 13px;
            }

            li p span {
                color: green;
            }
        </style>
    </head>
    <body>
        <h1>Notes API v1 Documentation</h1>
        <p>Welcome to the super duper fun Notes API - an API that lets you... manage notes!</p>



        <h3>HTTP Basic Auth</h3>
        <p>This API uses HTTP Basic Authentication.</p>
        <p>Start by creating a user account, then remember to pass in your login credentials through HTTP Basic Auth.</p>



        <h3>Response Codes</h3>
        <ul>
            <li><strong>200</strong> - Success</li>
            <li><strong>400</strong> - Bad request, double check your API request call.</li>
            <li><strong>401</strong> - Unauthorized, you don't have access to make the request call.</li>
            <li><strong>500</strong> - Server error, something bad happened on the server - sorry about that.</li>
        </ul>



        <h3>Error Messages</h3>
        <p>If a request doesn't return a 200 HTTP status, then the response will send back a JSON array with two keys:</p>
        <ul>
            <li>error: This will be set to "true"</li>
            <li>error_message: A helpful error message for developers to figure out what went wrong.</li>
        </ul>



        <h3>User API Methods</h3>
        <ul>
            <li>
                <h4>Create User</h4>
                <p><strong>URL: </strong>/users</p>
                <p>HTTP Method: POST</p>
                <p>POST Data:</p>
                <ul>
                    <li>username</li>
                    <li>password</li>
                    <li>confirm_password</li>
                </ul>

            </li>
            <li>
                <h4>Update User</h4>
                <p><strong>URL: </strong>/users/<span class="arg">$userID</span></p>
                <p>HTTP Method: PUT</p>
                <p>POST DATA:</p>
                <ul>
                    <li>username</li>
                    <li>password</li>
                    <li>confirm_password</li>
                </ul>
            </li>
        </ul>



        <h3>Note API Methods</h3>
        <ul>
            <li>
                <h4>Get Notes</h4>
                <p><strong>URL: </strong>/users/<span class="arg">$userID</span>/notes</p>
                <p>HTTP Method: GET</p>
            </li>
            <li>
                <h4>Get Note</h4>
                <p><strong>URL: </strong>/users/<span class="arg">$userID</span>/notes/<span class="arg">$noteID</span></p>
                <p>HTTP Method: GET</p>
            </li>
            <li>
                <h4>Create Note</h4>
                <p><strong>URL: </strong>/users/<span class="arg">$userID</span>/notes/</p>
                <p>HTTP Method: POST</p>
                <p>POST DATA:</p>
                <ul>
                    <li>title</li>
                    <li>description</li>
                </ul>
            </li>
            <li>
                <h4>Update Note</h4>
                <p><strong>URL: </strong>/users/<span class="arg">$userID</span>/notes/<span class="arg">$noteID</span></p>
                <p>HTTP Method: PUT</p>
                <p>POST DATA:</p>
                <ul>
                    <li>title</li>
                    <li>description</li>
                </ul>
            </li>
            <li>
                <h4>Delete Note</h4>
                <p><strong>URL: </strong>/users/<span class="arg">$userID</span>/notes/<span class="arg">$noteID</span></p>
                <p>HTTP Method: DELETE</p>
            </li>
        </ul>



    </body>
</html>
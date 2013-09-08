# CP+B Backend Candidate Lab

## Documentation

List of developed web services:

Import API to Postman from: https://www.getpostman.com/collections/d0df7f91c54bfa38598a

* Create user / register
** URL: http://localhost:3000/users | http://lab-notes.aws.af.cm/users
** Method: POST
** Headers: Content-Type: application/json
** Data: {"username": "UserName", "password": "PassWord12234"}
** Returns 201 on success, 400 if data fails validation, or 500 otherwise

* User authorization
** URL: http://localhost:3000/users/login | http://lab-notes.aws.af.cm/users/login
** Method: POST
** Headers: Content-Type: application/json
** Data: {"username": "john", "password": "1234"}
** Returns 201 on success, 400 if data fails validation, or 500 otherwise

* Create a new note
** URL: http://localhost:3000/users/notes | http://lab-notes.aws.af.cm/users/notes
** Method: POST
** Headers: Content-Type: application/json
** Data: {"title" : "Title", "description" : "Description"}
** Returns 401 if unauthorized access, 201 on success, 400 if data fails validation, or 500 otherwise

* Update a note
** URL: http://localhost:3000/users/notes/1 | http://lab-notes.aws.af.cm/users/notes/1
** Method: PUT
** Headers: Content-Type: application/json
** Data: {"title" : "Title", "description" : "Description"}
** Returns 401 if unauthorized access, 201 on success, 400 if data fails validation, or 500 otherwise

* Get a note
** URL: http://localhost:3000/users/notes/1 | http://lab-notes.aws.af.cm/users/notes/1
** Method: GET
** Headers: Content-Type: application/json
** Returns 200 on success, 401 if unathorized access, 400 if data fails validation, or 500 otherwise

* Get the list of notes
** URL: http://localhost:3000/users/notes | http://lab-notes.aws.af.cm/users/notes
** Method: GET
** Headers: Content-Type: application/json
** Returns 200 on success, 401 if unathorized access, or 500 otherwise

## Notes

Use this area to communicate any thought processes, ideas, or challenges you encountered.  If you had more time, what would you enhance or do differently?

The RESTful API has been developed using NodeJS. The API is built over the Express web application framework. We have organized the code into three main layers: models, routes, and services.
* The models layer is used to declare entities and their realationships. Models are defined using Sequelize, which is an ORM framework. Data is persisted into a MySQL database. We haven't defined any database constraint like foreign keys.
* The routes layer is used to sanitize, and validate input. The response is constructed using services defined in the service layer.
* The service layer is on top of of the model layer, and provides a set of services to manipulate models defined in the model layer.

In order to authenticate a user we rely on the Passport framework. The authentication mechanism used can be considered as convenient or easy to implement, but has two main disadvantages: 1) mantains the session in the server, 2) can be regarded as weak. A better approach is to use a token-based authentication. Where upon logon the client gets a token which is then used to sign the next request. The response for each response will contain an updated token; tokens can expire in a given time-frame.
A true RESTful API never maintains state in the server.

Passwords are hashed before persisting them. Bcrypt is used to hash them.



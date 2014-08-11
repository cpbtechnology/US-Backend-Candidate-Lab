##########################################
#            !! HI GUYS !!               #
##########################################

First off, thanks for giving me a chance to prove myself, this exercise was a bunch of fun!

It took about 5 to 6 hours to complete, and that includes the time it took to setup vagrant, an AWS production server, and this documentation.

To get this project up and running locally, take a look at /docs/local-setup-instructions.txt. 
I'm using vagrant to setup a centos vm, you can check out my provisioning script under: /dev/vagrant/scripts/setup.sh.

The production address is: http://23.23.119.248/

So, if I had another day to work on this, here's what I would do:

1) Implement Caching
Cache the database results per user.
I would also consider caching the full response (HTTP caching), either on the app side (via PHP) or directly within NGINX.
That would shave off a considerable amount of ms. 

2) Move user and note security checks to a filter.
Right now there are several methods that check if a user can access the specified resource.
That repeating code needs be moved out of the controllers and put somewhere else, such as a new security class.

3) Testing
This was a fast exercise and I would have loved to spend more time with testing.


Scaling?

If this API started to get a fair amount of attention, then we'd have to consider some scaling techniques.
Lets say we were still using AWS, here's what I would do:

1) Setup a load balancer (elb) that points to a few ec2 servers.
2) Right now the mysql server exists in the app server, that would have to be moved out to a seperate replicated db server (RDS + slave).
3) Consider setting up an in memory cache server for all the app servers to connect to, either using memcached or redis.
4) Of course cache everything.

We're already using Nginx, PHP-FPM, Zend Opcode caching, and I've tweaked the server (up'd max connections). So we're off to a good start.



##########################################
#      Notes API v1 Documentation        #
##########################################

This documentation can also viewed online:

http://23.23.119.248/v1


#
# HTTP Basic Auth
#

This API uses HTTP Basic Authentication.
Start by creating a user account, then remember to pass in your login credentials through HTTP Basic Auth.



#
# Response Codes
#

200 - Success
400 - Bad request, double check your API request call.
401 - Unauthorized, you don't have access to make the request call.
500 - Server error, something bad happened on the server - sorry about that.



#
# Error Messages
#

If a request doesn't return a 200 HTTP status, then the response will send back a JSON array with two keys:

error: This will be set to "true"
error_message: A helpful error message for developers to figure out what went wrong.



#
# User API Methods
#

# Create User

	URL: /users

	HTTP Method: POST

	POST Data:

		username
		password
		confirm_password

# Update User

	URL: /users/$userID

	HTTP Method: PUT

	POST DATA:

		username
		password
		confirm_password



#
# Note API Methods
#

# Get Notes

	URL: /users/$userID/notes

	HTTP Method: GET

# Get Note

	URL: /users/$userID/notes/$noteID

	HTTP Method: GET

# Create Note

	URL: /users/$userID/notes/

	HTTP Method: POST

	POST DATA:	

		title
		description

# Update Note

	URL: /users/$userID/notes/$noteID

	HTTP Method: PUT

	POST DATA:

		title
		description

# Delete Note

	URL: /users/$userID/notes/$noteID

	HTTP Method: DELETE
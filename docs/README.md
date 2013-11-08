# CP+B Backend Candidate Lab

# Documentation

## Notes API


###Create User

PUT /api/user

Body:
{
    "email" : String
    "username" : String
    "password" : String
}

Returns 201

=================

###Get User

Basic Auth

GET /api/user

Returns 200

=================

###Create Note

Basic Auth

PUT /api/notes

Body:
{
    "title" : String
    "body" : String
}

Returns 201

=================

###Get Note(s)

Basic Auth

GET /api/notes(/:id)

Returns 200

=================

###Update Note

Basic Auth

POST /api/notes/:id

Body:
{
    "title" : String
    "body" : String
}

Returns 204

=================

###Delete Note

Basic Auth

GET /api/notes/:id

Returns 204

=================


# Notes

I decided to make this using 3 frameworks that I have never used before and to use some methodology that I needed to research. Libraries like passport will make it very easy to build upon with new authentication strategies which seem to be quite useful these days when we have all sorts of social media outlets people like to use. Mongoose is a pretty neat ODM library for mongo, however thanks to Mavericks it was a pain getting it to build and mongo to install. Finally I chose restify for the basic server framework since the idea was this to be purely an API I opted to have something as lean as possible.

In terms of current authentication, I feel that the user should reauth per request when connecting to an API. I wouldn't argue that basic auth is the most secure way to do this. I weighed using challange/request strategies but opted to use a self-signed SSL cert since I think using SSL has the most impact on http security. Ideally I would implement service based auth with FB or Twitter. Passport even has a custom OAuth implementation to generate your own tokens to pass around (probably most secure way) to authenticate users.

###I noticed that my commits are coming from two accounts. I think it may have something to do with my rsa keys on various machines. 


# Setup

Install MongoDB - http://www.mongodb.org/downloads

Install node 0.10.21 - http://nodejs.org

configure db.url field in package.js to match your mongodb server


###In project root 

install packages

    npm install

make mongo db folder

    mkdir data/db

give ownership to folder

    sudo chown `id -u` data/db




# Run 

###In project root 

run mongo
    
    mongod -dbpath data/db

run server
    
    node server





# Test

I am not very familiar with the ins and outs of unit testing but I did save out a collection for postman. It is called tests.json and you can just import them into it through the UI.



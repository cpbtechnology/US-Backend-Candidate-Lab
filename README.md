# CP+B Backend Candidate Lab

Congratulations! If you've made it this far, we like you already.
This lab is an opportunity for us to have a conversation about practices, conventions, and workflow.
It will also help us better understand you as a developer. 
Please use this as a way to communicate through your craft.

## Your Task

One of the most common tasks for a backend developer is to create an API that can be used by a "client".  That "client" might be a website, mobile app, kiosk, etc.  Your task is to create a RESTful API that can be used to store, retrieve, update, and delete notes.

**In lieu of creating something new, you may also submit existing code you've created (that you own) which demonstrates your back-end awesomeness.**

*This lab is meant to take no more than 4 hours to complete.*  If you run out of time you may explain where you left off and any work that would still need to be done.

## Language / DB

Here at CP+B most of our work is in: Node.js, PHP, C#/.NET.  However, you may use any language and/or framework you'd like to create the API.

Most of our DBs are typically one of: MongoDB, MySQL, SQL Server.  Again, you may choose any DB that you'd like.

## Considerations

Some things you may want to consider when designing how your API will function:

* Maintainability
* Security
* Scalability

## API Requirements

These are the most basic requirements that the API should fulfill.  Feel free to expand on this feature set as you see fit or as time permits.

### Response format

Responses from the API will be JSON

### Login/User management

You may create your own system or tie in to existing login solutions (Google, Facebook, Twitter, etc.)

Users will be able to:

1. Create accounts
2. Login with their accounts

### Notes

1. Notes will contain at minimum 2 text fields - a 'title', and 'description'
2. Notes will have CRUD capabilities (Create, Read, Update, Delete)
3. Notes are specific to and can only be accessed by the user that creates them (One 'user' to Many 'notes')
4. Notes may contain PII (personally identifiable information) or other sensitive information

## Setup

1. Fork this repo and clone to your computer
2. Setup the project in your prefered IDE
3. Create the API
4. When finished, submit a Pull Request back to the 'master' branch of this repository

## Documentation

Place documentation in the [docs/](docs) folder

### API Specs

When creating an API it's important for the consumer of your services to understand how they work.  Create some documentation for your services so that another developer could create a website based on your API using only this document.

### Project Setup

Include any steps that need to be taken in order to set up this project and run it on a new server.

## Workflow

Please make atomic commits (commit often) as you progress. 
Be sure to provide useful commit messages to illustrate milestones and workflow.
Submit a pull request when you are finished and satisfied with your work.

## Bonus

1. Prove that your API works as expected by writing unit tests around your services.
2. Put your services up on a server where they can be actively tested and include the link with your pull request.
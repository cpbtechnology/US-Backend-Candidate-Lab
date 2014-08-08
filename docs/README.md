# CP+B Backend Candidate Lab

## Documentation

Place any related documentation in this folder.

## Notes

Use this area to communicate any thought processes, ideas, or challenges you encountered.  If you had more time, what would you enhance or do differently?

There's a few things I should probably point out.  Creating a REST API at a base level to support CRUD isn't anything overly difficult.  Where I started to notice challenges was around Authentication.  Other frameworks may have better support and documentation for it, but CakePHP's tutorial seemed to miss one or two vital lines of code.  Once I had those things seemed to go smoother, however if I had more time I'd test things more and really evaluate some of the work flow to make sure things are locked down as well as they should be.  I'd also like to add some support for OAuth from thrid party providers.


The assignment mentioned that PII might be stored in the notes.  This brings a few thoughts to mind.
1) We need encrypted transport.
2) We need to consider encrypting the actual data in the database.

For encrypted transport CakePHP has a mechanism to require SSL.  It's a few lines of code that I've commented out for now.  SSL requires additional server configuration and I wanted to more focus on the API then on the server architecture.  You can see it commented out in the AppController.php's beforeFilter() function.  You also have to add 'Security' into the components array.
 
I chose to spend time on the second part, encrypting the actual data in the database.  Which I was succesfull during some testing.  However I couldn't decrypt.  Then when I got encrypt and decrypt to work it would only do it for html and json views...If I had more time I'd out to the CakePHP development team to solve this definitely.  

In terms of what else I'd like to do. You'll notice this file is updated...I decided to spend sometime today to create a quick iPhone app to test everything and demonstrate it works.  The app isn't perfect but I just fine tuned a few things so it's working pretty good.  

For testing I also posted the code to
http://104.131.225.142/cpbbackend/cakephp/
You can user the username user3 with a pw of 123 or create your own.  

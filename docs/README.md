# CP+B Backend Candidate Lab

## Documentation

Place any related documentation in this folder.

## Notes

Use this area to communicate any thought processes, ideas, or challenges you encountered.  If you had more time, what would you enhance or do differently?

There's a few things I should probably point out.  Creating a REST API at a base level to support CRUD isn't anything overly difficult.  Where I started to notice challenges was around Authentication.  Other frameworks may have better support and documentation for it, but CakePHP's tutorial seemed to miss one or two vital lines of code.  Once I had those things seemed to go smoother, however if I had more time I'd test things more and really evaluate some of the work flow to make sure things are locked down as well as they should be.  


The assignment mentioned that PII might be stored in the notes.  This brings a few thoughts to mind.
1) We need encrypted transport.
2) We need to consider encrypting the actual data in the database.

For encrypted transport CakePHP has a mechanism to require SSL.  It's a few extra settings.  I chose to spend time on the second part, encrypting the actual data in the database.  Which I was succesfull during some testing.  However I couldn't decrypt.  Then when I got encrypt and decrypt to work it would only do it for html and json views...If I had more time I'd out to the CakePHP development team to solve this difinitevly.  

For SSL I feel like I could set that up if I had an extra 30 minutes.  I like not having it for demo purposes but I know the assignment called for securty.  

In terms of what else I'd like to do.  I wanted to create an iOS app that showed the API in action.  Unfortuantly this started to take up a little more time then I had to spend on it.  If I had another hour or two I could probably have something rudimentary prototyped.  


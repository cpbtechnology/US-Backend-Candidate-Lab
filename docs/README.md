# CP+B Backend Candidate Lab

## Documentation

There are two files documenting respective methods:
1. USERS.md - user creation,
2. NOTES.md - notes management.

## Notes

I decided to write the code all by myself to show that we really do know about programming. 
The general idea was to build a simple framework to handle JSON APIs. The structure was inspired a little by Ruby on Rails and Django frameworks. The request flow is as follows:
1. Everything is redirected to index.php,
2. There, an application object is built, using a settings object defined by settings.php,
3. Application object uses URLResolver to determine which controller and action should be used to handle the request,
4. It then calls the appropriate method, passing any additional parameters,
5. Controller's method (action) proccesses the data (fetches objects from database, saves them etc.) and returns a Response object,
6. The response object is then casted to string in order to send the contents as HTTP response.

If I had more time, I'd do the following things:
1. Add an autoloader for classes,
2. Add more abstraction to Model class (getting/saving data should be moved to parent class),
3. Implement better login system (including possibility to use OpenAuth),
4. Add unit tests.

# CP+B Backend Candidate Lab

## Creating users

Users can be created using /users/create/ method. It requires two POST fields:
1. login
2. password
The method saves user in database and generates a token. Returned value is a dictionary-like object with this token:
{"token": "SOME-RANDOM-TOKEN"}

## Logging in

User does not use his password to call API methods. Instead of logging in, creating session etc. I decided it's wiser to use a token passed in each method. This way the user can log in with his username and password on the site/portal and use a token for less sensitive data that's exposed via API.

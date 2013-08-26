# CP+B Backend Candidate Lab

## General info

All note methods require user credentials passed as GET parameters:
1. login,
2. token.

## Adding notes

To add a note, the /notes/create/ method should be used. It requires two POST parameters:
1. title,
2. description.
The method return a JSON containing note''s id:
{"id": 123}

## Reading notes

To read notes, a /notes/get/<id>/ method should be used.
The method returns a JSON containing note''s fields:
{"id": 123, "title": "Sample title", "description: "Sample description"}

## Updating notes

Similar to /notes/create/, but the method also has id in the URL: /notes/update/<id>/.
This method returns a JSON confirming operation success:
{"status": "success"}

## Deleting notes

User can delete notes by calling /notes/delete/<id>/.
This method returns a JSON confirming operation success:
{"status": "success"}

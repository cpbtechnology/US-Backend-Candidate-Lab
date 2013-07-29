# Phillip Epstein Note API 

## Stuff to note (no pun intended):
* Authentication is done over basic HTTP
* Notes stored securely using a RIJNDAEL-256 block cipher

## TO DO:
* Implment OAuth for a more robust authentication layer
* Abstract/Refactor business logic from controllers to models
* Abstract cryptastic from httpbasicauth into it's own middleware
* Implement over SSL vs normal http
* Abstract controller return value so you no longer have to set headers, do json etc.


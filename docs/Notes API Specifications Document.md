**Notes API**
=======

The Notes API is a RESTful API that can be used to store, retrieve, update, and delete notes.

Read All
 -----------

* **URL**

  /notes.json

* **Method:**
  
  `GET` 
  
*  **URL Params**

	None 

 

* **Data Params**

  HTTP Basic Authentication including
  username
  password

* **Success Response:**
  


  * **Code:** 200 <br />
    **Content:** `  {
    "notes": [
        {
            "Note": {
                "id": "54",
                "title": "My First Note",
                "description": "This is a note",
                "user_id": "9"
            }
        }
    ]
}`
 
* **Error Response:**


  * **Code:** 401 UNAUTHORIZED <br />
    **Content:** `{
    "name": "Unauthorized",
    "message": "Unauthorized",
    "url": "\/US-Backend-Candidate-Lab\/cakephp\/notes.json"
}`

* **Sample Call:**

  http://104.131.225.142/cpbbackend/cakephp/notes.json 

* **Notes:**

  None 
  
Create
 -----------

* **URL**

  /notes.json

* **Method:**
  
  `POST` 
  
*  **URL Params**

	None 

 

* **Data Params**

  HTTP Basic Authentication including
  
  username
  
  password
  
  `data[Note][title]=[string]`
  
  `data[Note][description]=[string]`

* **Success Response:**
  

  * **Code:** 200 <br />
    **Content:** `{ "message": "Saved" }`
 
* **Error Response:**


  * **Code:** 401 UNAUTHORIZED <br />
    **Content:** `{
    "name": "Unauthorized",
    "message": "Unauthorized",
    "url": "\/US-Backend-Candidate-Lab\/cakephp\/notes.json"
}`


* **Sample Call:**

  http://104.131.225.142/cpbbackend/cakephp/notes.json
  
  Post Body
  
  _method=POST&data%5BNote%5D%5Btitle%5D=Note+Title&data%5BNote%5D%5Bdescription%5D=Description+of+a+note 

* **Notes:**

  None   
  
READ
 -----------

* **URL**

  /notes/(123).json

* **Method:**
  
  `GET` 
  
*  **URL Params**

	Just the ID of the note and .json in the URL 

 

* **Data Params**

  HTTP Basic Authentication including
  
  username
  
  password
  
  `data[Note][title]=[string]`
  
  `data[Note][description]=[string]`

* **Success Response:**
  

  * **Code:** 200 <br />
    **Content:** `{
    "note": {
        "Note": {
            "id": "60",
            "title": "names",
            "description": "Cyclops and Wolverine",
            "user_id": "3"
        }
    }
}`
 
* **Error Response:**

  { "message": "Error" }

  * **Code:** 401 UNAUTHORIZED <br />
    **Content:** `{
    "name": "Unauthorized",
    "message": "Unauthorized",
    "url": "\/US-Backend-Candidate-Lab\/cakephp\/notes.json"
}`

 
* **Sample Call:**

  http://104.131.225.142/cpbbackend/cakephp/notes/32.json
  
* **Notes:**

  None
  
Update
 -----------

* **URL**

  /notes.json

* **Method:**
  
  `POST` 
  
*  **URL Params**

	None 

 

* **Data Params**

  HTTP Basic Authentication including
  
  username
  
  password
  
  `data[Note][title]=[string]`
  
  `data[Note][description]=[string]`
  
  `data[Note][id]=[integer]`

* **Success Response:**
  

  * **Code:** 200 <br />
    **Content:** `{ "message": "Saved" }`
 
* **Error Response:**


  * **Code:** 401 UNAUTHORIZED <br />
    **Content:** `{
    "name": "Unauthorized",
    "message": "Unauthorized",
    "url": "\/US-Backend-Candidate-Lab\/cakephp\/notes.json"
}`


* **Sample Call:**

  http://104.131.225.142/cpbbackend/cakephp/notes.json
  
  Post Body
  
  _method=PUT&data%5BNote%5D%5Bid%5D=42&data%5BNote%5D%5Btitle%5D=Update+The+Title&data%5BNote%5D%5Bdescription%5D=Update+The+Description

* **Notes:**

  None   

Delete
 -----------

* **URL**

  /notes/(123).json

* **Method:**
  
  `DELETE` 
  
*  **URL Params**

	Just the ID of the note followed by .json 

 

* **Data Params**

  HTTP Basic Authentication including
  
  username
  
  password
  
  `data[Note][title]=[string]`
  
  `data[Note][description]=[string]`
  
  `data[Note][id]=[integer]`

* **Success Response:**
  

  * **Code:** 200 <br />
    **Content:** `{ "message": "Deleted" }`
 
* **Error Response:**


  * **Code:** 401 UNAUTHORIZED <br />
    **Content:** `{
    "name": "Unauthorized",
    "message": "Unauthorized",
    "url": "\/US-Backend-Candidate-Lab\/cakephp\/notes.json"
}`


   * **Code:** 404 UNAUTHORIZED <br />
    **Content:**    `{ "name": "Invalid note", "message": "Invalid note", "url": "\/cpbbackend\/cakephp\/notes\/60.json" }`

* **Sample Call:**

  http://104.131.225.142/cpbbackend/cakephp/notes/60.json
  
* **Notes:**

  The HTML Request Method must be DELETE   
  
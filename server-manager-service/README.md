# Server Manager Service
This service allows users to perform several accounts to manager an inventory of server connections. 

## REST API details
A REST API which is validated via JWT tokens using the Lumen Framework. 
The API supports the following requests:
* Register to the service: 
  * Method: POST
  * URL: /api/register
  * Parameters:
    * name: name of the user (required)
    * username: username used to login (required)
    * password: password used to login (required)
  * Responses:
    * 201: Register successfully
    * 409: Error registering
* Log into the server and this generates a JWT token needed for future requests:
  * Method: POST
  * URL: /api/login
  * Parameters:
    * username: username used to login (required)
    * password: password used to login (required)
  * Responses:
    * 200: Login successfully
      * token: used to be able to make future API calls
    * 400: Error with login where email does not exist or email and password are wrong
* Create server connections
  * Method: POST
  * URL: /api/create?token=your token
  * Parameters:
    * connection_name: name of the connection (ex: 'Test Connection')(required)
    * connection_method: how to login to the server (ex: 'SSH') (required)
    * hostname: hostname of server (ex: 'test.test.com') (required)
    * port: port for the server (ex: 3556) (required)
    * username: username to login to server ('user') required)
    * password: password used to login to server ('password') (required)
  * Responses:
    * 201: Server created successfully
      * server: holding values of the server except password
    * 401: Unauthorized
    * 409: Error registering server
* Get a list of all the server connection of an authenticated user
  * Method: GET
  * URL: /api/list?token=your token
  * Responses:
    * 200: Server created successfully
      * servers: holding an array of all the servers
    * 401: Unauthorized
    * 500: Error getting servers
* Read details of a server connection
  * Method: GET
  * URL: /api/server/details/{id}?token=your token
  * {id}: The id of the server in question
  * Responses:
    * 200: Server created successfully
      * server: holding details of the server
    * 401: Unauthorized
    * 403: Forbidden to access server since it does not belong to user
    * 404: Server does not exist
    * 500: Error getting server
* Update details of a server connection
  * Method: PUT
  * URL: /api/server/update/{id}?token=your token
  * {id}: The id of the server in question
  * Parameters:
    * connection_name: name of the connection (ex: 'Test Connection')(required if no other values)
    * connection_method: how to login to the server (ex: 'SSH') (required if no other values)
    * hostname: hostname of server (ex: 'test.test.com') (required if no other values)
    * port: port for the server (ex: 3556) (required if no other values)
    * username: username to login to server ('user') (required if no other values)
    * password: password used to login to server ('password') (required if no other values)
  * Responses:
    * 200: Server updated successfully
      * server: holding details of the server now updated
    * 401: Unauthorized
    * 403: Forbidden to access server since it does not belong to user
    * 404: Server does not exist
    * 409: Error updatting server
* Delete a server connection
  * Method: DELETE
  * URL: /api/server/delete/{id}?token=your token
  * {id}: The id of the server in question
  * Responses:
    * 200: Server deleted successfully
    * 401: Unauthorized
    * 403: Forbidden to access server since it does not belong to user
    * 404: Server does not exist
    * 500: Error deleting server

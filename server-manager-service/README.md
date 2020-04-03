# Server Manager Service
This service allows users to perform several accounts to manager an inventory of server connections. 

## REST API details
A REST API which is validated via JWT tokens using the Lumen Framework. 
The API supports the following requests:
* Register to the service: 
  * Method: POST
  * URL: /api/register
  * Paramaters:
    * name: name of the user (required)
    * username: username used to login (required)
    * password: password used to login (required)
  *Responses:
    * 201: Register successfully
    * 409: Error registering
* Log into the server and this generates a JWT token needed for future requests
* create server connections
* get a list of all the server connection of an authenticated user
* read details of a server connection
* update details of a server connection
* delete a server connection

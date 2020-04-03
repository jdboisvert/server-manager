# Server Manager
A simple PHP application which allows users to list, change, add, delete an inventory of servers. 

## Server Connection API (server-manager-service)
A REST API which is validated via JWT tokens using the Lumen Framework. 
With this API users are able to:
* Register to the service
* Log into the server and this generates a JWT token needed for future requests
* create server connections
* get a list of all the server connection of an authenticated user
* read details of a server connection
* update details of a server connection
* delete a server connection

## Adminstration zone (TODO)
A user interface for a user to be able to log into and be able to manage their server connections.
This service uses the Server Connection API. 

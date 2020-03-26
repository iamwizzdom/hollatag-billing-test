# hollatag-billing-test

For the task I created 3 classes namely Network, Request and Response.
Network
The network class is an abstract class which has a method called 'fetch', which I used to initiate a curl request. The method takes 4 params:URL - (string): Defines url to endpointPOST - (array): Defines data being sent to endpointHEADERS - (array): Defines headers (if any) being sent to endpointTIMEOUT - (int): Defines a timeout for the requestThe fetch method also has a protocol to retry a failed request 3 times before giving up on that request.The fetch method return an associative array with keys 'status' and 'response'.Status - (boolean): Defines the status of the request,  true = success, false = failureReponse - (string): Defines reponse from the requested endpoint
Request
The request class extends the Network class and is used to setup a request before initiating it. This class has 2 important properties:amount - (string): Defines the billing amountusername - (int): Defines the username to the account being billedThere are getter and setters methods for these two properties.However, the request class has yet another important method:Initiate - (method): This method calls the fetch method from its parent class (Network) and passes the 'amount' and 'username' in an array to the post param of the fetch method. It then instantiates the Response class and passes the returned value from the fetch method to the response class and returns an instance on the response class.
Response
The reponse class has a constructor which takes an array as it's response. This class has 3 public methodsgetStatus: This returns the value of the status key in the response array if found, otherwise 'false'getResponseRaw: This returns the value of the response key found in the response array if found, otherwise 'null'getResponseArray: This tries to json decode the value of the response key found in the response array, if it fails an empty array is returned
--------------------------------------------------------------------------------------------------
Now, there are two php files 'request.php' and 'scaled_request.php' which both require the above classes.
request.php
In this file I assume we have a list of users to be billed and assigned to a variable called $users.My approach was to iterate throught these users, instantiate the Request class and set the amount and username, then I add the instance of the request object to an SPL doubly linked list, afterwards I iterate through the SPL queue and run the initiate method for each request then I test for a successful request and handle the response.
scaled_request.php  

This file scales the approach of request.php by eliminating the SPL doubly linked list and intiates the request on the first iteration, which make it 50% faster than request.php

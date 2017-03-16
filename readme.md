___Fake Rest Server Bundle___

[![Build Status](https://travis-ci.org/rpodwika/FakeRestServerBundle.svg)](https://travis-ci.org/rpodwika/FakeRestServerBundle)
[![Coverage Status](https://coveralls.io/repos/github/rpodwika/FakeRestServerBundle/badge.svg?branch=master)](https://coveralls.io/github/rpodwika/FakeRestServerBundle?branch=master)

FakeRestServerBundle is a bundle to create a fully working API based on YAML schema definition.

# How it works?

It parsers a YAML file with the database schema and based on that it creates the endpoints with possibility 
to perform requests such as GET, POST, PUT, HEAD, DELETE and OPTIONS

## Schema definition
    
Given following schema defined in YAML 
    
```
    user:
        - {id: 5, name: "John", surname: "Doe"}
        - {id: 6, name: "Jane", surname: "Doe"}
        - {id: 7, name: "Jack", surname: "Daniels"}
        
    pictures:
        - {id: 1, name: "A", src: "images/img.jpg"}
        - {id: 2, name: "B", src: "images/213.png"}
        - {id: 3, name: "C", src: "images/12.jpg"}
```          

Following endpoints will be created
  
```
  ➜  fakeserver php bin/console debug:router
   ------------------------------ --------- -------- ------ ----------------------------------- 
    Name                           Method    Scheme   Host   Path                               
   ------------------------------ --------- -------- ------ ----------------------------------- 
    FAKE_SERVER_GET_user           GET       ANY      ANY    /user/{user}                       
    FAKE_SERVER_POST_user          POST      ANY      ANY    /user                              
    FAKE_SERVER_PUT_user           PUT       ANY      ANY    /user/{user}                       
    FAKE_SERVER_DELETE_user        DELETE    ANY      ANY    /user/{user}                       
    FAKE_SERVER_PATCH_user         PATCH     ANY      ANY    /user/{user}                       
    FAKE_SERVER_HEAD_user          HEAD      ANY      ANY    /user/{user}                       
    FAKE_SERVER_OPTIONS_user       OPTIONS   ANY      ANY    /user/{user}                       
    FAKE_SERVER_GET_pictures       GET       ANY      ANY    /pictures/{pictures}               
    FAKE_SERVER_POST_pictures      POST      ANY      ANY    /pictures                          
    FAKE_SERVER_PUT_pictures       PUT       ANY      ANY    /pictures/{pictures}               
    FAKE_SERVER_DELETE_pictures    DELETE    ANY      ANY    /pictures/{pictures}               
    FAKE_SERVER_PATCH_pictures     PATCH     ANY      ANY    /pictures/{pictures}               
    FAKE_SERVER_HEAD_pictures      HEAD      ANY      ANY    /pictures/{pictures}               
    FAKE_SERVER_OPTIONS_pictures   OPTIONS   ANY      ANY    /pictures/{pictures}  
```
    
# Plans
    
   * Adding JSON schema definition
   * Adding PHP array schema definition
   * Creating schema definition which connects definitions in different type
   * Setting FakeServerApiController as a service and adding it to DI
   * Other?
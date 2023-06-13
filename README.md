# Checkout page with subscriptions for paypal and stripe

Explore a full, working code sample of an integration with Stripe Checkout and Customer Portal. 
Also Paypal wallet Checkout with card options.

This all has been made using php, paypal sdk and stripe-php

## Installation Guide

### For Paypal

#### You need

- paypal client id
- paypal plan id
- go to paypal https://www.sandbox.paypal.com/mep/dashboard 
- set all your business details 
- go to https://www.sandbox.paypal.com/billing/subscriptions
- add plans

#### go to paypal folder inside project
1. open .env file
2. add below details to .env

~~~
PAYPAL_CLIENT_ID = #paypal client key
PLAN_ID = #plan if for a product which needs subsription
ORDER_ID= {any integer number}
CANCEL_URL= {http://localhost}
RETURN_URL= {http://localhost}
~~~

3. save .env file

### For Stripe

1. Open terminal (command prompt)
2. CD to stripe folder inside project 

~~~
run composer update
~~~

#### You need

- stripe api key
- stripe lookup_key of product
- go to [https://dashboard.stripe.com/test/apikeys] for api keys
- go to https://dashboard.stripe.com/test/products?active=true to create products
- go to below url to get plan lookup id
- [https://dashboard.stripe.com/test/products?active=true]
- then select product 
- select pricing 
- find Lookup Key there 

#### go to stripe folder inside project
1. open .env file
2. add below details to .env

~~~
API_KEY=#stripe api key
LOOKUP_KEY=#look up key for a product which needs subsription
RETURN_URL= {http://localhost}
~~~

3. save .env file

### Run the server

~~~
php -S 127.0.0.1:4242
~~~

~~~
3. Go to [http://localhost:4242](http://localhost:4242)
~~~
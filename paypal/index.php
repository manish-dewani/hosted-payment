<?php

require_once 'paypal_autoload.php';

$PAYPAL_CLIENT_ID = $_ENV['PAYPAL_CLIENT_ID'];
$plan_id = $_ENV['PLAN_ID'];
$order_id = $_ENV['ORDER_ID'];
$cancel_url = $_ENV['CANCEL_URL'];
$return_url = $_ENV['RETURN_URL'];
?>
<!DOCTYPE html>
  <html lang="en">
  
  <head>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <title> PayPal Standard Payments Integration | Client Demo </title>
      <style>
        body {
          display: flex;
          direction: 'column';
        }

        #smart-button-container {
          margin: auto;
          padding: 1%;
          width: 50%;
        }

        .column {
          border: 1px solid #ccc;
          margin: 20px;
          padding: 20px;
        }

        p {
          text-align: center;
          margin-bottom: 30px;
        }

        a,a:link,a:visited {
            color: #1072eb;
            font-family: pp-sans-big-medium,Helvetica Neue,Arial,sans-serif;
            font-variant: normal;
            font-weight: 400;
            text-decoration: none;
            -webkit-transition: color .2s ease-out;
            -moz-transition: color .2s ease-out;
            -o-transition: color .2s ease-out;
            transition: color .2s ease-out
        }

        a:hover,a:focus {
            text-decoration: underline;
            outline: 0
        }
        .p-class {
          font-style: normal;
          font-weight: 500;
          font-size: 14px;
          line-height: 20px;
          letter-spacing: -0.154px;
          color: #242d60;
          height: 100%;
          width: 100%;
          padding: 0 20px;
          display: flex;
          align-items: center;
          justify-content: center;
          box-sizing: border-box;
        }        

        /* Media query for mobile viewport */
        @media screen and (max-width: 400px) {
            #paypal-button-container {
                width: 100%;
            }
        }
        
        /* Media query for desktop viewport */
        @media screen and (min-width: 400px) {
            #paypal-button-container {
                width: 100%;
            }
        }
      </style>
  </head>
  
  <body>
    <div id="smart-button-container">
    <div class="column">
        <p>
          PREMIUM PLAN <b>$2000 per year</b>
        </p>
        <div id="paypal-button-container"></div>
    </div> <!-- Replace with your plan ID -->
    <p><a href="http://localhost/hosted_payment">back to subscription</a></p>    
    </div>    

    <?php
        $url = "https://www.paypal.com/sdk/js";
        $url .= "?client-id=" . $PAYPAL_CLIENT_ID;
        $url .= "&vault=true";
        $url .= "&intent=subscription";
        $url .= "&currency=USD";
        $url .= "&locale=en_US";     
        echo '<script src="' . $url . '" data-sdk-integration-source="button-factory"></script>' . PHP_EOL;
    ?>

      <script>
          var plan = '<?php echo $plan_id; ?>';
          var order = '<?php echo $order_id; ?>';
          var cancel_url = '<?php echo $cancel_url; ?>';
          var return_url = '<?php echo $return_url; ?>';
          const paypalButtonsComponent = paypal.Buttons({
              // optional styling for buttons
              // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
              style: {
                  color: "gold",
                  shape: "rect",
                  height: 50,
                  label: "paypal",
                  layout: "vertical"
              },
  
              // set up the recurring transaction
              createSubscription: (data, actions) => {
                  // replace with your subscription plan id
                  // https://developer.paypal.com/docs/subscriptions/#link-createplan
                  return actions.subscription.create({
                      plan_id: plan,
                      application_context: {
                        cancel_url: cancel_url,
                        return_url: return_url,
                        brand_name: "MakeShip Enterprises",
                        locale: "en-US",
                        shipping_preference: "NO_SHIPPING",
                        user_action: "SUBSCRIBE_NOW"
                      },
                      custom_id: "order_id :"+order
                  });

              },
  
              // notify the buyer that the subscription is successful
              onApprove: (data, actions) => {
                    // Show a success message within this page, e.g.
                    /*const element = document.getElementById('paypal-button-container');
                    element.innerHTML = '';*/
                    

                    const element = document.getElementById('paypal-button-container');
                    element.innerHTML = '<h3 style="text-align: center;">Thank you for your payment!</h3>';
                    //window.location.href = 'thank_you.html';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                    //window.location = "https://dev.axsmb.com/#order-items/"+item+"/edit";                
                    //alert('You have successfully created subscription ' + data.subscriptionID);
              },
  
              // handle unrecoverable errors
              onError: (err) => {

                  alert("An error prevented the buyer from checking out with PayPal! Payment unsuccessful");
                  //window.history.go(-1);
                  console.error('An error prevented the buyer from checking out with PayPal');
              },

              onCancel: function (data) {
                window.location = cancel_url;
                // Show a cancel page, or return to cart
              }              
          });
  
          paypalButtonsComponent
              .render("#paypal-button-container")
              .catch((err) => {
                  console.error('PayPal Buttons failed to render');
              });
      </script>
  </html>
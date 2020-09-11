<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//we are going to use session variables so we need to enable sessions
session_start();

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

whatIsHappening();

//your products with their price.

if (isset($_GET["food"]) && $_GET['food'] == 1) {
 $products = [
    ['name' => 'Kombucha', 'price' => 2],
    ['name' => 'Gimber', 'price' => 2],
    ['name' => 'Matcha Latte', 'price' => 3],
    ['name' => 'Golden Mylk', 'price' => 3], 
];
} else {
$products = [
    ['name' => 'Mediterranean Goodness', 'price' => 3],
    ['name' => 'BBQ Tofu', 'price' => 3],
    ['name' => 'Meatless Loaf', 'price' => 4],
    ['name' => 'Pesto Vegetable Grill', 'price' => 4],
    ['name' => 'Roasted Portobello', 'price' => 5]
];
};

$totalValue = 0;

// Clean input data
function sanitizeData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Form validation
$email = (isset($_POST["email"])) ? sanitizeData($_POST['email']) : '';

// Address SESSION setting
$street = (isset($_SESSION["stored_street"])) ? $_SESSION ['stored_street'] : '';
$streetnumber = (isset($_SESSION["stored_streetnumber"])) ? $_SESSION ['stored_streetnumber'] : '';
$city = (isset($_SESSION["stored_city"])) ? $_SESSION ['stored_city'] : '';
$zipcode = (isset($_SESSION["stored_zipcode"])) ? $_SESSION ['stored_zipcode'] : '';

if (isset($_POST["street"])) {
    $street = sanitizeData($_POST["street"]); 
}else {
    $street = "";
}

if (isset($_POST["streetnumber"])) {
    $streetnumber = sanitizeData($_POST["streetnumber"]); 
}else {
    $streetnumber = "";
}

if (isset($_POST["city"])) {
    $city = sanitizeData($_POST["city"]); 
}else {
    $city = "";
}

if (isset($_POST["zipcode"])) {
    $zipcode = sanitizeData($_POST["zipcode"]); 
}else {
    $zipcode = "";
}

// Error Alert Message
$error_message_email = "";
$error_message_street = "";
$error_message_streetnumber = "";
$error_message_city = "";
$error_message_zipcode = "";
$error_message_products = "";
$error_message_delivery = "";

// Success Alert Message
$success_message_email = "";
$success_message_street = "";
$success_message_streetnumber = "";
$success_message_city = "";
$success_message_zipcode = "";
$success_message_products = "";
$success_message_delivery = "";

// Warning style alert
$style_warning_email = "";
$style_warning_street = "";
$style_warning_streetnumber = "";
$style_warning_city = "";
$style_warning_zipcode = "";
$style_warning_products ="";
$style_warning_delivery ="";

// Success style alert
$style_success_email = "";
$style_success_street = "";
$style_success_streetnumber = "";
$style_success_city = "";
$style_success_zipcode = "";
$style_success_products ="";
$style_success_delivery ="";

// Validate true or false
$return_email = "";
$return_street = "";
$return_streetnumber = "";
$return_city = "";
$return_zipcode = "";
$return_products ="";
$return_delivery ="";

/* $style_warning_show= "";
$style_warning = array();
array_push($style_warning, $_POST['email'], $_POST["street"], $_POST["streetnumber"], $_POST["city"], $_POST["zipcode"]);
print_r($style_warning);

foreach ( $style_warning as $style_warning_message ) {
  if ($style = false) {   
    $style_warning_show= $style_success_zipcode = "style='display:none;'";
  } else {
    $style = "";
  }
} */

// Form invalid
$style_success = "";
if (empty($_POST['email']) || empty($_POST["street"]) || empty($_POST["streetnumber"]) || empty($_POST["city"]) || empty($_POST["zipcode"])|| empty($_POST["products"])) {
    $style_success = "style='display:none;'";
};

// Form empty
if (empty($_POST['email']) && empty($_POST["street"]) && empty($_POST["streetnumber"]) && empty($_POST["city"]) && empty($_POST["zipcode"]) && empty($_POST["products"])) {
    $style_warning_email =  "style='display:none;'";
    $style_success_email = "style='display:none;'";
    $style_warning_street =  "style='display:none;'";
    $style_success_street = "style='display:none;'";
    $style_warning_streetnumber =  "style='display:none;'";
    $style_success_streetnumber = "style='display:none;'";
    $style_warning_city =  "style='display:none;'";
    $style_success_city = "style='display:none;'";
    $style_warning_zipcode =  "style='display:none;'";
    $style_success_zipcode = "style='display:none;'";

};

//Form filled
if (isset($_POST['email']) && isset($_POST["street"]) && isset($_POST["streetnumber"]) && isset($_POST["city"]) && isset($_POST["zipcode"])) {

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
     $success_message_email .= "Valid";
     $style_warning_email = "style='display:none;'";
     $return_email = true;
    } else {
     $error_message_email .= 'The email you entered is invalid.<br>';
     $style_success_email = "style='display:none;'";
     $return_email = false;
     $email="";
    }

    // Validate address
    $string_exp = "/^[A-Za-z .'-]+$/";
    $numbers_exp = "/^[0-9]+$/";
    $house_numbers_exp= "/^\d+[a-zA-Z]*$/";

    if (!preg_match($string_exp, $street)) {
        $error_message_street .= 'The street you entered is invalid.<br>';
        $style_success_street = "style='display:none;'";
        $return_street = false;
        $street= "";
    } else {
        $style_warning_street = "style='display:none;'";
        $success_message_street .= "Valid";
        $return_street = true;
        $_SESSION["stored_street"] = $street;
    }

    if (!preg_match($house_numbers_exp, $streetnumber)) {
        $error_message_streetnumber .= 'The streetnumber you entered is invalid.<br>';
        $style_success_streetnumber = "style='display:none;'";
        $return_streenumber = false;
        $streetnumber ="";
    }
    else {
        $style_warning_streetnumber = "style='display:none;'";
        $success_message_streetnumber .= "Valid";
        $return_streetnumber = true;
        $_SESSION["stored_streetnumber"] = $streetnumber;
    }
    
    if (!preg_match($string_exp, $city)) {
        $error_message_city .= 'The city you entered is invalid.<br>';
        $style_success_city = "style='display:none;'";
        $return_city = false;
        $city = "";
    }
    else {
       $style_warning_city = "style='display:none;'";
       $success_message_city .= "Valid";
       $return_city = true;
       $_SESSION["stored_city"] = $city;
    }

    if (!preg_match($numbers_exp, $zipcode)) {
        $error_message_zipcode .= 'The zipcode you entered is invalid.<br>';
        $style_success_zipcode = "style='display:none;'";
        $return_zipcode = false;
        $zipcode="";
    }
    else {
       $style_warning_zipcode= "style='display:none;'";
       $success_message_zipcode .= "Valid";
       $return_zipcode = true;
       $_SESSION["stored_zipcode"] = $zipcode;
    }

};

// Product choice validate 
 if(isset($_POST['products']) == 0) {
        $return_products = false; 
        $style_success_products = "style='display:none;'";
        $error_message_products .= 'Please make a choice.<br>';
    } else {
        $return_products = true;
        $style_warning_products = "style='display:none;'";
        $success_message_products .= "Valid Choice!";
    };

// Delivery time
 if(isset($_POST['normaldelivery']) || isset($_POST['expressdelivery']) ) {
        $return_delivery = true; 
        $style_warning_delivery = "style='display:none;'";
        $success_message_delivery .= "Valid!";
    } else {
        $return_delivery = false;
        $style_success_delivery = "style='display:none;'";
        $error_message_delivery .= 'Please make a choice.<br>';
    };


// Message for user if form is validated
    $thankyou_message = "";

 if ($return_email == true && $return_street == true && $return_streetnumber == true && $return_city == true && $return_zipcode == true && $return_products == true && $return_delivery == true )  
 {
  
    // Save time in SESSION
    $_SESSION['timeOfOrdering'] = date('H:i');
    $timeOfOrdering = (null !== $_SESSION['timeOfOrdering']) ? $_SESSION ['timeOfOrdering'] : '';

    $_SESSION['expectedDeliveryNormal'] = date('H:i',strtotime('+2 hour',strtotime($timeOfOrdering)));
    $expectedDeliveryNormal = (null !== $_SESSION['expectedDeliveryNormal']) ? $_SESSION ['expectedDeliveryNormal'] : '';

    $_SESSION['expectedDeliveryExpress'] = date('H:i',strtotime('+45 minutes',strtotime($timeOfOrdering)));
    $expectedDeliveryExpress = (null !== $_SESSION['expectedDeliveryExpress']) ? $_SESSION ['expectedDeliveryExpress'] : '';

    if(isset($_POST['normaldelivery'])){
        $thankyou_message = 'Thank you for placing an order! The estimated delivery time is ' . $_SESSION['expectedDeliveryNormal'] . '.';
    } else {
        $thankyou_message = 'Thank you for placing an order! The estimated delivery time is ' . $_SESSION['expectedDeliveryExpress'] . '.';
    }

    $style_warning_email = "style='display:none;'";
    $style_warning_street = "style='display:none;'";
    $style_warning_streetnumber = "style='display:none;'";
    $style_warning_city = "style='display:none;'";
    $style_warning_zipcode = "style='display:none;'";
    $style_warning_products = "style='display:none;'";
    $style_warning_delivery = "style='display:none;'";

    $style_success_email = "style='display:none;'";
    $style_success_street = "style='display:none;'";
    $style_success_streetnumber ="style='display:none;'";
    $style_success_city = "style='display:none;'";
    $style_success_zipcode = "style='display:none;'";
    $style_success_products = "style='display:none;'";
    $style_success_delivery = "style='display:none;'";
    
    $email = $street = $streetnumber = $city = $zipcode = "";
}; 

// Form invalidated
if ($return_email == false || $return_street == false || $return_streetnumber == false || $return_city == false || $return_zipcode == false || $return_products == false || $return_delivery == false )  
 {   $style_success = "style='display:none;'";
 };

// Total revenue counter


 // Email order to yourself
    $email_to = "nicol.saha@gmail.com";
    $email_subject = "New form submissions";
    $email_message = "Form details below.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Email: " . clean_string($email) . "\n";
    @mail($email_to, $email_subject, $email_message);

    
require 'form-view.php'; 
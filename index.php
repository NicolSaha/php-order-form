<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);

//PHPmailer Dependencies + Autoloader
require 'mail.php';
require 'vendor/autoload.php';

//Enable sessions
session_start();

//Debugging function
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

//Meals & Drinks + Pricing
$drinks = [
    ['name' => 'Kombucha', 'price' => 2],
    ['name' => 'Gimber', 'price' => 2],
    ['name' => 'Matcha Latte', 'price' => 3],
    ['name' => 'Golden Mylk', 'price' => 3], 
];

$meals = [
    ['name' => 'Mediterranean Goodness', 'price' => 3],
    ['name' => 'BBQ Tofu', 'price' => 3],
    ['name' => 'Meatless Loaf', 'price' => 4],
    ['name' => 'Pesto Vegetable Grill', 'price' => 4],
    ['name' => 'Roasted Portobello', 'price' => 5]
];

if (isset($_GET['food']) && $_GET['food'] == 'switchToMeals') {
    $products = $drinks;
} else {
    $products = $meals;
};
 
$totalValue=0;
//Get price of products + add to total value
if (isset ($_POST['products'])) {
  $totalValue= calculateTotal($totalValue);
}
 else{
    $totalValue=0;
};

//Calculate total value 
function calculateTotal($totalValue) {
    $item = $_POST['products'];
    foreach ($item as $price) {
    $totalValue += $price;   
    }
    return $totalValue;
};

//Clean input data
function sanitizeData($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

//FORM VALIDATION
//Setting variables
$email = (isset($_POST["email"])) ? sanitizeData($_POST['email']) : '';

//Setting address SESSIONS
$street = (isset($_SESSION["stored_street"])) ? $_SESSION ['stored_street'] : '';
$streetnumber = (isset($_SESSION["stored_streetnumber"])) ? $_SESSION ['stored_streetnumber'] : '';
$city = (isset($_SESSION["stored_city"])) ? $_SESSION ['stored_city'] : '';
$zipcode = (isset($_SESSION["stored_zipcode"])) ? $_SESSION ['stored_zipcode'] : '';

//Clean data & set
if (isset($_POST["street"])) {
    $street = sanitizeData($_POST["street"]); 
}

if (isset($_POST["streetnumber"])) {
    $streetnumber = sanitizeData($_POST["streetnumber"]); 
}

if (isset($_POST["city"])) {
    $city = sanitizeData($_POST["city"]); 
}

if (isset($_POST["zipcode"])) {
    $zipcode = sanitizeData($_POST["zipcode"]); 
}

//Error Alert Message
$error_message_email = "";
$error_message_street = "";
$error_message_streetnumber = "";
$error_message_city = "";
$error_message_zipcode = "";
$error_message_products = "";

//Success Alert Message
$success_message_email = "";
$success_message_street = "";
$success_message_streetnumber = "";
$success_message_city = "";
$success_message_zipcode = "";
$success_message_products = "";
$success_message_delivery = "";

//Warning style alert
$style_warning_email = "";
$style_warning_street = "";
$style_warning_streetnumber = "";
$style_warning_city = "";
$style_warning_zipcode = "";
$style_warning_products ="";

//Success style alert
$style_success_email = "";
$style_success_street = "";
$style_success_streetnumber = "";
$style_success_city = "";
$style_success_zipcode = "";
$style_success_products ="";
$style_success_delivery ="";

//Validate input TRUE||FALSE
$return_email = "";
$return_street = "";
$return_streetnumber = "";
$return_city = "";
$return_zipcode = "";
$return_products ="";
$return_delivery ="";

//IF FORM INVALID
$style_success = "";
if (empty($_POST['email']) || empty($_POST["street"]) || empty($_POST["streetnumber"]) || empty($_POST["city"]) || empty($_POST["zipcode"])|| empty($_POST["products"])) {
    $style_success = "style='display:none;'";
};

//IF FORM EMPTY
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
    $style_success_delivery = "style='display:none;'";
    $style_warning_delivery= "style='display:none;'";
};

//FILLED FORM --> START DATA CHECKING
if (isset($_POST['email']) && isset($_POST["street"]) && isset($_POST["streetnumber"]) && isset($_POST["city"]) && isset($_POST["zipcode"]) && isset($_POST["delivery"])) {

    //Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $success_message_email = "Valid";
        $style_warning_email = "style='display:none;'";
        $return_email = true;
    } else {
        $error_message_email = 'The email you entered is invalid.<br>';
        $style_success_email = "style='display:none;'";
        $return_email = false;
        $email="";
    }

    //Validate address
    $string_exp = "/^[A-Za-z .'-]+$/";
    $numbers_exp = "/^[0-9]+$/";
    $house_numbers_exp= "/^\d+[a-zA-Z]*$/";

    //Street
    if (!preg_match($string_exp, $street)) {
        $error_message_street = 'The street you entered is invalid.<br>';
        $style_success_street = "style='display:none;'";
        $return_street = false;
        $street= "";
    } else {
        $style_warning_street = "style='display:none;'";
        $success_message_street = "Valid";
        $return_street = true;
        $_SESSION["stored_street"] = $street;
    }

    //Streetnumber
    if (!preg_match($house_numbers_exp, $streetnumber)) {
        $error_message_streetnumber = 'The streetnumber you entered is invalid.<br>';
        $style_success_streetnumber = "style='display:none;'";
        $return_streenumber = false;
        $streetnumber ="";
    }
    else {
        $style_warning_streetnumber = "style='display:none;'";
        $success_message_streetnumber = "Valid";
        $return_streetnumber = true;
        $_SESSION["stored_streetnumber"] = $streetnumber;
    }
    
    //City
    if (!preg_match($string_exp, $city)) {
        $error_message_city = 'The city you entered is invalid.<br>';
        $style_success_city = "style='display:none;'";
        $return_city = false;
        $city = "";
    }
    else {
       $style_warning_city = "style='display:none;'";
       $success_message_city = "Valid";
       $return_city = true;
       $_SESSION["stored_city"] = $city;
    }

    //Zipcode
    if (!preg_match($numbers_exp, $zipcode)) {
        $error_message_zipcode = 'The zipcode you entered is invalid.<br>';
        $style_success_zipcode = "style='display:none;'";
        $return_zipcode = false;
        $zipcode="";
    }
    else {
       $style_warning_zipcode= "style='display:none;'";
       $success_message_zipcode = "Valid";
       $return_zipcode = true;
       $_SESSION["stored_zipcode"] = $zipcode;
    }

    // Validate delivery time
    if(isset($_POST['delivery'])) {
        $return_delivery = true; 
        $success_message_delivery .= "Valid!";

        if(isset($_POST['delivery']) === "normal")  {
            $_SESSION['deliveryType'] = 'normal';
            } else {
            $_SESSION['deliveryType'] = 'express';
        };
    };

};

// Validate product choice
 if(empty($_POST['products'])) {
        $return_products = false; 
        $style_success_products = "style='display:none;'";
        $error_message_products .= 'Please make a choice.<br>';
    } else {
        $return_products = true;
        $style_warning_products = "style='display:none;'";
        $success_message_products .= "Valid Choice!";
    };

// Validation message customer
$thankyou_message = "";
if ($return_email == true && $return_street == true && $return_streetnumber == true && $return_city == true && $return_zipcode == true && $return_products == true && $return_delivery == true )  {
    $style_warning_email = "style='display:none;'";
    $style_warning_street = "style='display:none;'";
    $style_warning_streetnumber = "style='display:none;'";
    $style_warning_city = "style='display:none;'";
    $style_warning_zipcode = "style='display:none;'";
    $style_warning_products = "style='display:none;'";

    $style_success_email = "style='display:none;'";
    $style_success_street = "style='display:none;'";
    $style_success_streetnumber ="style='display:none;'";
    $style_success_city = "style='display:none;'";
    $style_success_zipcode = "style='display:none;'";
    $style_success_products = "style='display:none;'";
    $style_success_delivery = "style='display:none;'";
    
    // Save ordertime in SESSION
    $_SESSION['timeOfOrdering'] = date('H:i');
    $timeOfOrdering = (null !== $_SESSION['timeOfOrdering']) ? $_SESSION ['timeOfOrdering'] : '';
    
    //Send mail
    $emailSentMessage = sendEmail($totalValue);
    $email = "";
    //$street = $streetnumber = $city = $zipcode = 
    
   
    if(isset($_POST['delivery'])){
        if ($_SESSION['deliveryType'] == 'normal') {
            $_SESSION['expectedDeliveryTime'] = date('H:i',strtotime('+2 hour',strtotime($timeOfOrdering)));
            $expectedDeliveryTime= $_SESSION['expectedDeliveryTime'];
            $thankyou_message = $emailSentMessage . ' <br/>Thank you for placing an order! The estimated delivery time is ' .  $expectedDeliveryTime  . '. <br/> Total order value = €' . number_format($totalValue);
            addToTotal($totalValue);
        } else {
            $_SESSION['expectedDeliveryTime'] = date('H:i',strtotime('+45 minutes',strtotime($timeOfOrdering)));
            $expectedDeliveryTime=  $_SESSION['expectedDeliveryTime'];
            (int)$totalValue += 5;
            $thankyou_message = $emailSentMessage . ' <br/>Thank you for placing an order! <br/> The estimated delivery time is ' .   $expectedDeliveryTime . '. <br/> Total order value = €' . number_format($totalValue);
            addToTotal($totalValue);
        }
    }
   
}; 

// Form invalidated
if ($return_email == false || $return_street == false || $return_streetnumber == false || $return_city == false || $return_zipcode == false || $return_products == false || $return_delivery == false )  {   
    $style_success = "style='display:none;'";
};

function addToTotal($total_value){
    if (isset($_COOKIE['total_value'])) {
        $current_value = $_COOKIE['total_value'];
    } else {
        $current_value = 0;
    }
    $new_value = (int)$current_value + (int)$total_value;
    
    setcookie('total_value', strval($new_value), time() + (86400 * 30));
    echo $total_value;
}
 
require 'form-view.php'; 
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1 style='text-align: center;';>Rawrrrrr Food & Drinks</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order drinks</a>
            </li>
            
        </ul>
    </nav>
    <div class="alert alert-success" role="alert" <?php echo $style_success ?>> <?php echo $thankyou_message ?> </div>
    <form method="post" action="index.php">
        <div class="form-row">
    
            <div class="form-group col-md-6">
                <div class="alert alert-danger" id="email-alert" role="alert" <?php echo $style_warning_email?> > <?php echo $error_message_email; ?> </div>
                <div class="alert alert-success" id="email-alert" role="alert" <?php echo $style_success_email?> > <?php echo $success_message_email; ?> </div>
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php echo $email;  ?>" required/> 
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                <div class="alert alert-danger" id="street-alert" role="alert" <?php echo $style_warning_street?> > <?php echo $error_message_street; ?> </div>
                <div class="alert alert-success" id="street-alert" role="alert" <?php echo $style_success_street?> > <?php echo $success_message_street; ?> </div>
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" value="<?php echo ucfirst($street); ?>" required>
                </div>
                <div class="form-group col-md-6">
                <div class="alert alert-danger" id="streetnumber-alert" role="alert" <?php echo $style_warning_streetnumber?> > <?php echo $error_message_streetnumber; ?> </div>
                <div class="alert alert-success" id="streetnumber-alert" role="alert" <?php echo $style_success_streetnumber?> > <?php echo $success_message_streetnumber; ?> </div>
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control" value="<?php echo $streetnumber; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <div class="alert alert-danger" id="city-alert" role="alert" <?php echo $style_warning_city?> > <?php echo $error_message_city; ?> </div>
                <div class="alert alert-success" id="city-alert" role="alert" <?php echo $style_success_city?> > <?php echo $success_message_city; ?> </div>
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?php echo ucfirst($city); ?>" required>
                </div>
                <div class="form-group col-md-6">
                <div class="alert alert-danger" id="zipcode-alert" role="alert" <?php echo $style_warning_zipcode?> > <?php echo $error_message_zipcode; ?> </div>
                <div class="alert alert-success" id="zipcode-alert" role="alert" <?php echo $style_success_zipcode?> > <?php echo $success_message_zipcode; ?> </div>
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo $zipcode; ?>" required>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <div class="alert alert-danger" id="products-alert" role="alert" <?php echo $style_warning_products?> > <?php echo $error_message_products; ?> </div>
            <div class="alert alert-success" id="products-alert" role="alert" <?php echo $style_success_products?> > <?php echo $success_message_products; ?> </div>
            <?php foreach ($products AS $i => $product): ?>
                <label>
                    <input type="checkbox" value="<?= $product['price'] ?>" name="products[<?php echo $i ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br />
            <?php endforeach; ?>
        </fieldset> <br />

        <fieldset>
            <legend>Delivery</legend>
            <div class="alert alert-danger" id="products-alert" role="alert" <?php echo $style_warning_delivery?> > <?php echo $error_message_delivery; ?> </div>
            <div class="alert alert-success" id="products-alert" role="alert" <?php echo $style_success_delivery?> > <?php echo $success_message_delivery; ?> </div>
                <input type="checkbox" value="0" name="normaldelivery"/>
                    <label for="normaldelivery">Normal (2h) - Free </label>  <br />
                <input type="checkbox" value="1" name="expressdelivery" />
                    <label for="expressdelivery">Express (45min) - €5.00 </label> <br />
        </fieldset> <br />

        <button type="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer><br /><br /><br />
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>
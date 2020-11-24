<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    if(!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] == 0){
        header("Location: login.php");
        exit;
    }
    require_once('database-connection.php');

    $addresses = $db->query("SELECT * FROM address WHERE fk_address_user=$_SESSION[id]");
    $cards = $db->query("SELECT * FROM card WHERE fk_card_user=$_SESSION[id]");
    $orders = $db->query("SELECT * FROM orders WHERE fk_orders_user=$_SESSION[id]");
?>

<?php
    include('base.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
    
<body>


    <h1 class = "account-header">Account Overview</h1>

<!-- contact info -->
    <div class="left-c">
        <h2 class="blue-colorizer" >Contact Information</h2>
        <br>
        <p class="blue-colorizer">Username: <?php echo $_SESSION['name']; ?></p>
        <p class="blue-colorizer">Email: <?php echo $_SESSION['email']; ?></p>
        <br>
        <button type="button" class="submit_b2"><a href="">Edit</a></button>
        <br>
        <button type="button" class="submit_b2"><a href="">Change Password</a></button>
    </div>


    <div class="right-c">
        <h2 class="blue-colorizer">Address</h2>
        <h3 class="blue-colorizer">Address Book</h3>
    
        <?php foreach ($addresses as $address):?>
        <div>
            <p><?php echo $address['name'];?></p>
            <p><?php echo $address['line1'];?></p>
            <p><?php echo $address['line2'];?></p>
            <p><?php echo $address['city'];?>, <?php echo $address['state'];?> <?php echo $address['zip'];?></p>
            <form action="addr-delete.php" method="post">
                <input type="hidden" name="addr_id" value=<?php echo $address['id'];?>>
                <input type="submit" value="Delete Address">
            </form>
        </div>
        <?php endforeach;?>
        <button type="button" class="submit_b2"><a href="">Add New Address</a></button>
        <!-- <a href="address-form.php" class="link-colors">Add New Address</a> -->

        <div>
            <h3 class="blue-colorizer">Payment Information</h3>
            <?php foreach ($cards as $card):?>
                <div>
                <p>**** **** **** <?php echo substr ($card['number'], -4);?></p>
                <form action="card-delete.php" method="post">
                    <input type="hidden" name="card_id" value=<?php echo $card['id'];?>>
                    <input type="submit" value="Delete Card">
                </form>
                </div>
            <?php endforeach;?>
            <button type="button" class="submit_b2"><a href="">Add New Card</a></button> 
            <!-- <a href="card-form.php" class="link-colors">Add New Card</a> -->
        </div>

        <div>
            <h3 class="blue-colorizer">Orders</h3>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Amount</th>
                </tr>
                <?php foreach ($orders as $order):?>
                    <tr>
                        <td><?php echo $order['id'];?></td>
                        <td><?php echo $address['ordertotal'];?></td>
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
    </body>
</html>
<?php
include 'config/database.php';
include_once "object/product.php";
include_once "object/pro_image.php";
include_once "object/cart_items.php";
$page_title="check_out";

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);
$pro_image = new ProductImage($db);
$cart_items = new CartItem($db);
include 'layout_head.php';
if($cart_count>0){
 
    $cart_items->user_id="1";
    $stmt=$cart_items->read();
 
    $total=0;
    $item_count=0;
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $sub_total=$price*$Quantity;
        echo "<div class='cart-row'>";
            echo "<div class='col-md-8'>";
                echo "<div class='product-name m-b-10px'><h4>{$Pro_name}</h4></div>";
                echo $Quantity>1 ? "<div>{$Quantity} items</div>" : "<div>{$Quantity} item</div>";
            echo "</div>";
            echo "<div class='col-md-4'>";
                echo "<h4>&#36;" . number_format($price, 2, '.', ',') . "</h4>";
            echo "</div>";
        echo "</div>";
        $item_count += $Quantity;
        $total+=$sub_total;
    }
    echo "<div class='col-md-12 text-align-center'>";
        echo "<div class='cart-row'>";
            if($item_count>1){
                echo "<h4 class='m-b-10px'>Total ({$item_count} items)</h4>";
            }else{
                echo "<h4 class='m-b-10px'>Total ({$item_count} item)</h4>";
            }
            echo "<h4>&#36;" . number_format($total, 2, '.', ',') . "</h4>";
 
            echo "<a href='place_order.php' class='btn btn-lg btn-success m-b-10px'>";
                echo "<span class='glyphicon glyphicon-shopping-cart'></span> Place Order";
            echo "</a>";
        echo "</div>";
    echo "</div>";
}
else{
    echo "<div class='col-md-12'>";
        echo "<div class='alert alert-danger'>";
            echo "OOPS! No products found in your cart! :(";
        echo "</div>";
    echo "</div>";
}
include 'layout_foot.php';
?>
<?php 
function getFinalPrice($price, $discount) {
    if (!empty($discount) && $discount > 0) {
        return $price - ($price * $discount / 100);
    }
    return $price;
}
?>
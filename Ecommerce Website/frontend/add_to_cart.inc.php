<?php
class add_to_cart{
    function addProduct($pid, $qty){      //Add Product
        $_SESSION['cart'][$pid]['qty'] = $qty;
    }

    function updateProduct($pid, $qty){   //Update Product
        if(isset($_SESSION['cart'][$pid])){
            $_SESSION['cart'][$pid]['qty'] = $qty;
        }
    }

    function removeProduct($pid, $qty){   //Delete product
        if(isset($_SESSION['cart'][$pid])){
            unset($_SESSION['cart'][$pid]);
        }
    }

    function emptyProduct(){   //Empty Product
        unset($_SESSION['cart'][$pid]);
    }

    function totalProduct(){   //Total Product
        if(isset($_SESSION['cart'])){
        return count($_SESSION['cart']);
        }
        else{
        return 0;
        }
    }
}
?>
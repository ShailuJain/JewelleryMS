<?php
//localhost/JewellerMS/helpers/query-redirects/product.php?op=select&category_id=1
function getConditionString($conditions)
{
    $i = 0;
    $str = "";
    foreach ($conditions as $key => $value)
    {
        $str .= htmlspecialchars($key)."='".htmlspecialchars($value)."'";
        $i++;
        if($i != sizeof($conditions)){
            $str .= " AND ";
        }
    }
    return $str;
}
if(isset($_POST['op']))
{
    $field = $_POST['field'];
    unset($_POST['field']);
    switch ($field){
        case 'product':
            if($_POST['op'] === "select")
            {
                $conditions = $_POST;
                unset($conditions['op']);
                unset($conditions['field']);
                $str = getConditionString($conditions);
                if(empty($str)){
                    $str = 1;
                }
                require_once('db/models/Product.class.php');
                $res = Product::select("product_id,product_name,product_label", 0, $str . "AND product_quantity > 0");
                echo json_encode($res->fetchAll());
            }
            break;
        case 'product_quantity':
            if($_POST['op'] === "select")
            {
                $conditions = $_POST;
                unset($conditions['op']);
                $str = getConditionString($conditions);
                if(empty($str)){
                    $str = 1;
                }
                require_once('db/models/Product.class.php');
                $res = Product::select("product_quantity", 0, $str);
                echo json_encode($res->fetchAll());
            }
            break;
    }
}
<?php
//localhost/JewellerMS/helpers/query-redirects/product.php?op=select&category_id=1
if(isset($_POST['op']))
{
    if($_POST['op'] === "select")
    {
        $conditions = $_POST;
        unset($conditions['op']);
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
        if(empty($str)){
            $str = 1;
        }
        require_once('db/models/Product.class.php');
        $res = Product::select("product_id,product_name", 0, $str);
        echo json_encode($res->fetchAll());
    }
}
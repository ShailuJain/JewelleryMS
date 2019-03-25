
<div class="container-fluid">
    <div class="row">
        <table id="tables" class="display" style="width:100%">
            <thead>
            <tr>

                <th>category_id</th>
                <th>category_name</th>
                <th>category_quantity</th>
                <th>hsn_code</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require_once 'db/models/Category.class.php';
            //$c = new Category();
            //$c->category_name="ismeDATA5";
            //$c->category_quantity=11;
            //$c->hsn_code=7113;
            //$c->deleted=0;
            //$c->insert();

            $rs=CRUD::select("categories");
            while($row = $rs->fetch()) {

//
                echo<<<ROW
<tr>
    <td>$row->category_id;</td>
    <td>$row->category_name;</td>
    <td>$row->category_quantity;</td>
    <td>$row->hsn_code;</td>
</tr>
ROW;


            }
            ?>
            </tfoot>
        </table></div>

</div>
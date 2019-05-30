var count = 0;
var index = 0;
var deleteProduct;
var productIndex = 0;
var categoryIndex = 0;
var quantityIndex = 0;
var edit = false;
let global = this;
var rates = new Set();
document.onreadystatechange = function () {

    //alert( yourSelect.options[ yourSelect.selectedIndex ].value );
    if (document.readyState == "interactive") {

        /**
         * This code deals with the dynamic addition and deletion of the products in the product form
         */
        let addProduct = $('.add-product');
        addProduct.click(function (event) {
            newEntry();
        });
        if(typeof global.defaultEntries === "undefined"){
            global.defaultEntries = {};
        }
        if(!$.isEmptyObject(global.defaultEntries)){
            edit = true;
            for (let prop in global.defaultEntries) {
                rates.add(global.defaultEntries[prop][3]);
                newEntry();
            }
        }else{
            newEntry();
        }
    }
}
function adjustDeleteButtonVisibility() {
    if(count === 1){
        deleteProduct.hide();
    }else{
        deleteProduct.show();
    }
}

function generateNewProductEntry() {
    count++;
    index++;
    var val = '', val2 = '';
    var append_string = "<div class='form-row' id='list-product-"+index+"'>\n" +
        "        <div class='form-group col-md-6'>\n" +
        "            <select name='category_id[]' id='category-"+index+"' class='form-control' required>\n" +
        "                <option value=''>"+global.label_texts[0]+"</option>\n" +
        "            </select>\n" +
        "        </div>\n" +
        "        <div class='form-group col-md-6'>\n" +
        "            <select name='product_id[]' id='product-"+index+"' class='form-control' data-unique='product-select' required>\n" +
        "                <option value=''>"+global.label_texts[1]+"</option>\n" +
        "            </select>\n" +
        "        </div>\n" +
        "        <div class='form-group col-md-4'>\n" +
        "            <input type='number' class='form-control' name='product_quantity[]' id='product_quantity-"+index+"' required  min='0.001' step='any' value='"+ val + "' placeholder='"+global.label_texts[2]+"'>\n" +
        "        </div>\n" +
        "<div class='form-group col-md-4'>\n" +
        "            <div class='input-group'>\n" +
        "                <input type='number' class='form-control' name='product_rate[]' id='product_rate' placeholder='"+global.label_texts[3]+"' required min='0.001' step='any' value='"+ val2 + "' step='any'>\n" +
        "            </div>\n" +
        "        </div>";
    /*
    If the page is invoice page then we have to add extra column that is making charges column.
     */
    /*********************************************/
    if(page === "invoice"){
        append_string += "<div class='form-group col-md-3'>\n" +
            "            <div class='input-group'>\n" +
            "                <input type='number' class='form-control' name='making_charges[]' id='making_charges' placeholder='"+global.label_texts[4]+"' required min='0.001' step='any' value='"+ val2 + "' step='any'>\n" +
            "            </div>\n" +
            "        </div>";
    }
    /*********************************************/

    append_string += "<button id='delete-product-" + index + "' class='btn btn-danger delete-product' role='button' type='button' data-value='"+index+"'><i class='fa fa-trash'></i></button>\n" +
        "    </div>";
    if(edit){
        val = global.defaultEntries[quantityIndex][2];
        val2 = global.defaultEntries[quantityIndex++][3];
    }
    $('#list-of-products').append(append_string);
}
function removeProductEntry(id) {
    if(count > 1){
        count--;
    }
    $(id).remove();
}
/**
 *
 * @param select_obj
 * @param url
 * @param alertText
 */
function loadCategory(select_obj, url, alertText = ""){
    var xhr;
    select_obj.load(function (callback) {
        xhr && xhr.abort();
        xhr = $.post({
            url: url,
            data: {op: 'select'},
            success: function (result) {
                let res = JSON.parse(result);
                if($.isEmptyObject(res)){
                    if(alertText !== "")
                        alert(alertText);
                    return;
                }
                callback(res);
                if(edit){
                    select_obj.setValue(global.defaultEntries[categoryIndex++][0]);
                }
            },
            error: function () {
                callback();
            }
        });
    });
}

/**
 * Selectize.js
 * this code will fetch all the products belonging to a particular category selected in the category selectize field.
 * It makes an ajax call and loads all the products
 * @param category_selector
 * @param product_selector
 */
function initSelectizeOn(category_selector, product_selector) {
    var xhr;
    var select_category, $select_category;
    var select_product, $select_product;
    $select_category = $(category_selector).selectize({
        valueField: 'category_id',
        labelField: 'category_name',
        searchField: 'category_name',
        onChange: function (value) {
            if (!value.length) return;
            select_product.disable();
            select_product.clear();
            select_product.clearOptions();
            select_product.load(function (callback) {
                xhr && xhr.abort();
                xhr = $.post({
                    url: "query-redirect.php?query=product",
                    data: {op: 'select', field: 'product', category_id: value},
                    success: function (result) {
                        select_product.enable();
                        let res = JSON.parse(result);
                        if($.isEmptyObject(res)){
                            alert("No Products Available");
                            select_product.disable();
                            return;
                        }
                        callback(res);
                        if(edit){
                            select_product.setValue(global.defaultEntries[productIndex++][1]);
                        }
                    },
                    error: function () {
                        callback();
                    }
                });
            });
        },
        onItemRemove: function (value, item) {
            // console.log($(item));
            // alert(item['ownerDocument']['activeElement']['id']);
            select_product.disable();
            select_product.clear();
            select_product.clearOptions();
        },
    });

    $select_product = $(product_selector).selectize({
        valueField: 'product_id',
        labelField: 'product_name',
        searchField: ['product_name', 'product_label'],
        onChange: function (value) {
            var id = this.$input.attr('id');
            var currSelect = this;
            var uniqueValue = true;
            $("[data-unique='product-select']").each(function (index, old_value) {
                if(!($(this).attr('id') === id)){
                    if($(this).val() === value){
                        alert("Already selected");
                        currSelect.clear();
                        uniqueValue = false;
                    }
                }
            });
            if (!value.length || !uniqueValue) return;
            //This code will find the underlying input field of the selectize select

            //*****************
            xhr && xhr.abort();
            xhr = $.post({
                url: "query-redirect.php?query=product",
                data: {op: 'select', field: 'product_quantity', product_id: value},
                success: function (result) {
                    let res = JSON.parse(result);
                    if ($.isEmptyObject(res)) {
                        alert("Invalid");
                        return;
                    }
                    id = id.substring(id.lastIndexOf('-')+1, id.length);
                    // alert();
                    $('#product_quantity-'+id).val(res[0].product_quantity);
                },
            });
        },
        render: {
            option: function(item, escape) {
                return '<div class="pl-3 pr-3 pt-1 pb-1">'
                    + '<strong>'
                    + escape(item.product_name) + ' - '
                    + '</strong>'
                    + escape(item.product_label)
                    + '</div>';
            },
            item: function(item, escape){
                return '<div>'
                    + escape(item.product_name) + ' - '
                    + escape(item.product_label)
                    + '</div>';
            }
        }
    });
    select_product = $select_product[0].selectize;
    select_category = $select_category[0].selectize;

    select_product.disable();
    /**
     * loading categories in category selectize
     */
    loadCategory(select_category,"query-redirect.php?query=category","No Categories Available");
}

/**
 * Generates a new entry for dynamic form. Adds html for single product.
 */
function newEntry() {
    generateNewProductEntry();
    initSelectizeOn('#category-'+index, "#product-"+index);
    deleteProduct = $('.delete-product');
    $('#delete-product-' + index).click(function () {
        removeProductEntry("#list-product-"+$(this).data('value'));
        adjustDeleteButtonVisibility();
    });
    adjustDeleteButtonVisibility();
}
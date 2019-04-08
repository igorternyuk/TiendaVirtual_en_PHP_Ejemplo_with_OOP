function addProduct(id){
    let postData = {};
    postData['productId'] = id;
    console.log("postData['productId'] = " + postData['productId']);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: postData,
        url: "cart/add/" + id,
        success: function (data){
           console.log("Data received: ");
           console.log(data);
           $("#cartCount").html(data['cartCount']);
           $("#cartTotal").html("$" + data['cartTotalSum']);
        }
    });
}

function removeProduct(id){
    let postData = {};
    postData['productId'] = id;
    console.log("postData['productId'] = " + postData['productId']);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: postData,
        url: "cart/remove/" + id,
        success: function (data){
           console.log("Data received: ");
           console.log(data);
           $("#product_" + id).hide();
           $("#cartCount").html(data['cartTotalItems']);
           $("#cartTotal").html(data['cartTotalSum']);
           $("#cartTotalSum").html("$" + data['cartTotalSum']);
        }
    });
}

function changeProductCount(id){
    let newCount = $("#productCount_" + id).val();
    let postData = {'productID' : id, 'newCount' : newCount};
    console.log("postData: ");
    console.log(postData);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        data: postData,
        url: 'cart/changecount/' + id + '/' + newCount,
        success: function(data){
            $("#cartCount").html(data['totalItems']);
            $("#cartTotal").html("$" + data['totalSum']);
            $("#cartTotalSum").html("$" + data['totalSum']);
            $("#subtotal_" + id).html("$" + data['subtotal']);
        }
    });
}

function toggleOrderProductsView(orderId){
    if($("#orderProducts_" + orderId).is(":visible")){
        $("#orderProducts_" + orderId).hide();
        $("#toggleProduct_" + orderId).html("Показать товары заказа");
    } else {
        $("#orderProducts_" + orderId).show();
        $("#toggleProduct_" + orderId).html("Скрыть товары заказа");
    } 
}

function fetchProductsByName(){
    let searchPattern = $("#searchBox").val();
    let postData = {'searchPattern' : searchPattern};
    console.log("postData: ");
    console.log(postData);
    
    $.ajax({
        type: 'POST',
        async: false,
        url: "/admin/product/search-" + searchPattern + "/page-1",
        data: postData,
        dataType: 'json',
        success: function(data){
            if(data['success']){
                console.log("Data received: ");
                console.log(data);
               let resPage = data['results'];
               $("#productTable").html(resPage);
            } else {
               $("#productTable").html("<h4>Ни одного товара не найдено</h4>");               
            }
        }
    }); 
}

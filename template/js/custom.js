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

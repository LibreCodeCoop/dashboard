Customer = {
    
    find : function() {
 
        $.ajax({
            method: "get",
            url: "/customer/find/" + $("#consultCode").val(),
            dataType: "json",
            success: function(data) {
                
                console.log(data);
            }
        });
    }    
};
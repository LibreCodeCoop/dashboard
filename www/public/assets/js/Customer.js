Customer = {
    
    find : function(){
        $.ajax({
            method: "get",
            url: "/customer/find",
            data: $('form').serialize() ,
            dataType: "html",
            success: function(data) {
                
            }
        });
    }    
}
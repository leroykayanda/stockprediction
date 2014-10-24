$('#select-wrapper').find('.x,.y').css('height', $('#select-wrapper').innerHeight()-30 );

$('#wrapper').on('click','#stocks-list li',function()
                 {//alert('click');
    $("#stocks-list li i").css({"display":"none"}); 
    $(this).find("i").css({"display":"block"}); 
    var txt=$(this).text(); 
    $("#insert-stock").html( txt );

    $("#rt-chart").html("<div style='font-family:lato,papyrus;text-align:center;margin-top:15%;'><img src='img/ajax-loader.gif'/> <br/> fetching latest price for "+txt+"</div>");

    $.get('driver.php?call=getStockName&stock='+$(this).text() );
    updatePrice();
    displayRt(); 
    //console.log(data);


});

function updatePrice( callback )
{
    $.get('driver.php?call=getStockPrice',function(resp)
          {
        if(resp!="")
        {
            $('#price').html(resp);
        }

    });

}
function enterNumber(obj)
{
    obj.value=obj.value.replace(/[^\d]/g,'');
} 


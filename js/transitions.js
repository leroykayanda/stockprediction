$(document).ready(function()
                  {
    $.get('driver.php?call=getStockPrice',function(resp)
          {                  
        $('#price').html(resp);
    }); 

    $.get("driver.php?call=getSelectStock", function(data){
        $("#wrapper").html(data);

        $("#rt-chart").html("<div style='font-family:lato,papyrus;text-align:center;margin-top:15%;'><img src='img/ajax-loader.gif'/> <br/> loading</div>");

        displayRt();
        $('#select-wrapper').find('.x,.y').css('height', $('#select-wrapper').innerHeight()-30 );
    });

    $("#sstock").click(function()
                       {
        $("#wrapper").html("<div style='text-align:center;font-family:lato;'><img src='img/loader3.gif'/> loading</div>");

        $.get("driver.php?call=getSelectStock", function(data){
            $("#wrapper").css({"display":"none"});
            $("#wrapper").html(data);
            $("#wrapper").fadeIn();

            $("#rt-chart").html("<div style='font-family:lato,papyrus;text-align:center;margin-top:15%;'><img src='img/ajax-loader.gif'/> <br/> loading</div>");

            displayRt();
            $('#select-wrapper').find('.x,.y').css('height', $('#select-wrapper').innerHeight()-30 );
        });

    });

    $("#click-history").click(function()
                              {
        $("#wrapper").html("<div style='text-align:center;font-family:lato;'><img src='img/loader3.gif'/> loading</div>");

        $.get("driver.php?call=getHistoryPage", function(data){
            $("#wrapper").css({"display":"none"});
            $("#wrapper").html(data);
            $("#wrapper").fadeIn();
        });

    });

    $("#click-train").click(function()
                            {
        $("#wrapper").html("<div style='text-align:center;font-family:lato;'><img src='img/loader3.gif'/> loading</div>");

        $.get("driver.php?call=getTrainPage", function(data){
            $("#wrapper").css({"display":"none"});
            $("#wrapper").html(data);
            $("#wrapper").fadeIn();
        });

    });

    $("#click-evaluate").click(function()
                               {
        $("#wrapper").html("<div style='text-align:center;font-family:lato;'><img src='img/loader3.gif'/> loading</div>");

        $.get("driver.php?call=getEvaluatePage", function(data){
            $("#wrapper").css({"display":"none"});
            $("#wrapper").html(data);
            $("#wrapper").fadeIn();
        });

    });

    $("#click-predictions").click(function()
                                  {
        $("#wrapper").html("<div style='text-align:center;font-family:lato;'><img src='img/loader3.gif'/> loading</div>"); 

        $.get("driver.php?call=getPredictPage", function(data){
            $("#wrapper").css({"display":"none"});
            $("#wrapper").html(data);                                                         
            $("#wrapper").fadeIn(); 

            $('#predict-graphs').html("<div style='font-family:lato,papyrus;text-align:center;margin-top:15%;'><img src='img/ajax-loader.gif'/> <br/> loading prediction graphs</div>");
            prediction_graph(7);

        }); 

    });

    $('#wrapper').on('click','.pbutton',function()
                     {
        $(".pbutton").css({"color":"#00BFFF"});
        $(this).css({"color":"crimson"});
    });

    $('#wrapper').on('click','.week',function()
                     {
        $('#predict-graphs').css({"border":"none"});
        
        $('#predict-graphs').html("<div style='font-family:lato,papyrus;text-align:center;margin-top:15%;'><img src='img/ajax-loader.gif'/> <br/> loading prediction graphs</div>");
        
        prediction_graph(7);
    });

    $('#wrapper').on('click','.month',function()
                     {
        $('#predict-graphs').css({"border":"none"});
        
        $('#predict-graphs').html("<div style='font-family:lato,papyrus;text-align:center;margin-top:15%;'><img src='img/ajax-loader.gif'/> <br/> loading prediction graphs</div>");
        
        prediction_graph(30);
    });

    $('#wrapper').on('click','.year',function()
                     {
        $('#predict-graphs').css({"border":"none"});
        
        $('#predict-graphs').html("<div style='font-family:lato,papyrus;text-align:center;margin-top:15%;'><img src='img/ajax-loader.gif'/> <br/> loading prediction graphs</div>");
        
        prediction_graph(365);
    });

});



  $(document).ready(function(){
      $("#search").on("keyup", function(){
        var search = $(this).val();
        //console.log(search);
        if (search !=="") {
          $.ajax({
            url:"actionajax.php",
            type:"POST",
            cache:false,
            data:{search:search},
            success:function(data){
             console.log(data);
              $("#citylist").html(data);
              $("#citylist").fadeIn();
            }  
          });
        }else{
          $("#citylist").html("");  
          $("#citylist").fadeOut();
        }
      });

      // click one particular city name it's fill in textbox
    //   $(document).on("click","li", function(){
    //     $('#city').val($(this).text());
    //     $('#citylist').fadeOut("fast");
    //   });
  });
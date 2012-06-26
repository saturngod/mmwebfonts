$(document).ready(function(){
    
    //init
    prettyPrint();
    $('#navbarTop').scrollspy();

    $("#codeImport").hide();
    
    // $(".menu_click").click(function(){
       
    //    $(".menu_click").removeClass('active');
    //    $(this).addClass('active');
        
    // });
   $(".tabs_code").click(function(){
      $(".tabs_code").removeClass('active');
      $(this).addClass('active');
      
      console.log($(this).attr('id'));
      
      if($(this).attr('id')=="standard_click") {
          $("#codeNormal").show();
          $("#codeImport").hide();
      }
      else {
          $("#codeNormal").hide();
          $("#codeImport").show();
      }
      return false;
   });
   
   $(".fontselect").change(function(){
      
      $("#codeNormal").html("&lt;link href='http://mmwebfonts.comquas.com/fonts/?font="+$(this).val()+"' rel='stylesheet' type='text/css'/&gt;");
      $("#codeImport").html("@import url('http://mmwebfonts.comquas.com/fonts/?font="+$(this).val()+"');");
      
      font_family="";
      if($(this).val()=="myanmar3") {
          font_family="Myanmar3,Yunghkio,'Masterpiece Uni Sans'";
      }
    else if($(this).val()=="masterpiece") {
        font_family="'Masterpiece Uni Sans',Yunghkio,Myanmar3";
    }
      else if($(this).val()=="yunghkio") {
          font_family="Yunghkio,Myanmar3,'Masterpiece Uni Sans'";
      }
      else if($(this).val()=="padauk") {
          font_family="padauk,Yunghkio,Myanmar3,'Masterpiece Uni Sans'";
      }
      else if($(this).val()=="mymyanmar") {
            font_family="'MyMyanmar Universal',Myanmar3,Yunghkio,'Masterpiece Uni Sans'";
      }
      else if($(this).val()=="zawgyi") {
          font_family="Zawgyi-One"
      }
      else if($(this).val()=="imon") {
          font_family="iMon"
      }
      else if($(this).val()=="unimon") {
          font_family="'Uni Mon'"
      }
      
      $("#fontfamily").html("font-family:"+font_family+";");
       
      prettyPrint();
   });
});
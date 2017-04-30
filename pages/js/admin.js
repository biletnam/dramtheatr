<script>  
 $(document).ready(function(){  
      $("#country").change(function(){  
           var country_id = $(this).val();  
           $.ajax({  
                url:"fetch_state.php",  
                method:"POST",  
                data:{countryId:country_id},  
                dataType:"html",  
                success:function(data)  
                {  
                     $("#state").html(data);  
                }
           });  
      });  
      $("#state").change(function(){  
           var znach = $(this).val();  
           $.ajax({  
                url:"vivod.php",  
                method:"POST",  
                data:{zminna:znach},  
                dataType:"html",  
                success:function(data)  
                {  
                     $("#otp").html(data);  
                } 
           });  
      });  

 $("#sub").click(function(){
          var znachids=$("#ids").val();           
           var znachname=$("#nam").val(); 
           var znachposada=$("#posada").val();
           var znachphoto=$("#photo").val();
           var znachtxt=$("#txt").val();                     
           $.ajax({  
                url:"din_up.php",  
                method:"POST",  
                data:{zminnaids:znachids,zminnaname:znachname, zminnaposada:znachposada,zminnaphoto:znachphoto,zminnatxt:znachtxt},  
                dataType:"html",  
                success:function(data)  
                {  
                    $("#ot1p").html(data); 
                } 
           });  
      });  


 });  
 </script>
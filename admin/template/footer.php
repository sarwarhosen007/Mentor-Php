 <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

     <script>
       jQuery(document).ready(function($){                                   
            
           setTimeout(function() {
              $("div.notification").fadeOut("slow");
           }, 3000); 
        });
    </script>
    <script>
       jQuery(document).ready(function($){
         $(".delete_data").click(function(){
           var del_id = $(this).attr('id');
           $.ajax({
              type:'POST',
              //url:'features.php',
              data:'delete_id='+del_id,
              success:function(data) { 
              }
           });
         });
        });
    </script>

    <script>
       jQuery(document).ready(function($){
         $(".btn-status").click(function(){
           var btn_status = $(this).attr('id');
           alert(btn_status);
           $.ajax({
              type:'POST',
              //url:'features.php',
               data: { btn_status : btn_status }
              success:function(data) { 
              }
           });
         });
        });
    </script>
    
    <script>
      var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
      };
    </script>
   

</body>

</html>

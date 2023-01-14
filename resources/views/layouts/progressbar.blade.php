<style>
        .container .progress2 {
            width: 100%;
        }

        .progress2 {
            padding: 1px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 6px;
           
        }

        .progress-bar {
            height: 0.7em;
            border-radius: 4px; 
            width: 4%;
            background-color: #80ba24;
         
        }
        .progress-bar {
            width: 10%;
        }
</style>

<div class="progress2 my-8">
    <div class="progress-bar" id="progressbar"></div>
</div>
  <script>
        let progressbar = document.getElementById("progressbar");
         var amount = <?php echo json_encode(session()->get('bottle')->amount); ?>;
         var aktamount = <?php echo json_encode(Gloudemans\Shoppingcart\Facades\Cart::count()); ?>;
         if(amount > 0){
            var count = 100 / amount;
            progressbar.style.width = (aktamount * count)+"%";
          
        } else {
            progressbar.style.width = "0%";
        }
       
  </script>
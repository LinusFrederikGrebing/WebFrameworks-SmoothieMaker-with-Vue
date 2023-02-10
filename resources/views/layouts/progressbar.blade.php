<div class="progress2 my-8">
    <div class="progress-bar" id="progressbar"></div>
</div>

  <script>
    function progress(aktamount, amount){
         let progressbar = document.getElementById("progressbar");
         if(amount > 0){
            var count = 100 / amount;
            progressbar.style.width = (aktamount * count)+"%";
          
        } else {
            progressbar.style.width = "0%";
        }
    };
  </script>
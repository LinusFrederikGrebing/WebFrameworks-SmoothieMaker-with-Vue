<style>
        .flex{
                display: flex;
         }
         .mt-05{
                margin-top: 0.5em;
                margin-left: 1em;
                scale: 1.2;
        }
</style>


<hr class="w-75">
<div class="flex"><h4> Smoothie-Größe: {{ session()->get('bottle')->name }}</h4> <a href="{{ route('showBottleSizes') }} " class="showBottleSizes mt-05"> <i class="fa fa-pencil"></i></a></div>
<p> Aktuell hast du <b>{{ Gloudemans\Shoppingcart\Facades\Cart::count() }}</b> von <b>{{ session()->get('bottle')->amount }}</b> für Größe {{ session()->get('bottle')->name }} benötigte Zutaten ausgewählt. </p>
<hr class="w-75">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
        $(".showBottleSizes").on("click", function(e){
      e.preventDefault();
      var self = $(this);
      console.log(self.data('name')); 
      Swal.fire({
        title: 'Bist du Dir sicher?',
        text: "Deine komplette Zusammenstellung wird bei Größenänderung unwiederruflich gelöscht!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6D9E1F',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Andere Größe wählen!',
        cancelButtonText: 'Abbrechen!'
      }).then((result) => {
        if (result.isConfirmed) {
          location.href = self.attr('href');
        }
      })
    }); 
</script>


<style>
  .flex{
    display: flex;
  }
  .tableformat { 
    width: 60%; 
    overflow: auto;
  }
  td, th {
    padding-left: 1.5em;
    padding-right: 1.5em;
    padding-top: 1em;
    padding-bottom: 1em;
  }
  .pl-1{
    padding-left: 1.6em;
  }
  .mixer {
    margin-top: 3em;
  }
  #progressbar>div 
  {
      background-color: #80ba24;
            width: 80%;
            /* Adjust with JavaScript */
            height: 20px;
            border-radius: 10px;
           
  }      
  .mb2em{
    margin-bottom: 2em;
  }


/* CSS */
.button-87 {
  margin-right: 1em;
  padding: 0.75em 1.25em;
  text-align: center;
  text-transform: uppercase;
  transition: 0.5s;
  background-size: 200% auto;
  color: white;
  border-radius: 10px;
  display: block;
  border: 0px;
  font-weight: 700;
  box-shadow: 0px 0px 14px -7px #f09819;
  cursor: pointer;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
}

.button-87:hover {
  background-position: right center;
  /* change the direction of the change here */
  color: #fff;
  text-decoration: none;
}

.button-87:active {
  transform: scale(1.5);
}
.redbg{
  background-image: linear-gradient(45deg, #BC0000 0%, #FF0000  51%, #E26363  100%);
}

.greenbg{
  background-image: linear-gradient(45deg, #6D9E1F 0%, #80ba24  51%, #96D82B  100%);
}

</style>

<x-guest-layout>
<div class="container">
  <div class="mb2em">
    @include('layouts.progressbar')
  </div>

  @include('layouts.groesse')

<div class="flex container">
  <div class="container">
    <div class="flex">
      <div>
       <button class="button-87 greenbg" onclick="window.location='{{ route('showFruits')}}'" >
       <i  class="fa fa-plus"></i> Weitere Zutaten hinzufügen
       
      </button>
      </div>
     
       <button href="{{ route('removeAll') }} " class="button-87 redbg removeAll"> <i  class="fa fa-trash"></i> Alles aus dem Warenkorb entfernen</button>
    
</div>

<table class="tableformat">
  <thead>
    <tr>
        <th scope="col">Image</th>
        <th scope="col">Name</th>
        <th scope="col">Preis</th>
        <th scope="col">Menge</th>
        <th scope="col">Remove</th>
    </tr>
  </thead>
 
  <tbody>
    @if(Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
    @foreach(Gloudemans\Shoppingcart\Facades\Cart::content() as $item)
    <tr>
      <td class=""><img src="/images/{{ $item->options->image }}" class="w-50"></td>
      <td><span class="text-dark">{{ $item->name }}</span></td>
      <td> <span class="font-weight-bold"> {{ $item->price }}€</span></td>
      <td class="text-center" data-title="stock">
        <div class="flex">
          <form action="/increaseCardQty/{{ $item->rowId }}" enctype="multipart/form-data" method="post">
                 @csrf
                 <button class="btn"><i class="fa fa-plus"></i></button>
        </form> 
           <span class="val"> {{ $item->qty }}</span>
        <form action="/decreaseCardQty/{{ $item->rowId }}" enctype="multipart/form-data" method="post">
                 @csrf
                 <button class="btn"><i class="fa fa-minus"></i></button>
         </form> 
        </div>
        
      </td>
      <td class="action" data-title="remove"> 
      <form action="/deleteCart/{{ $item->rowId }}" enctype="multipart/form-data" method="post">
                 @csrf
                 <button class="btn"><i class="fa fa-trash"></i></button>
    </form> </td>
    </tr>
   
    @endforeach
  </tbody>
</table>
<hr class="w-75">
    <p>Total: <b>{{ Gloudemans\Shoppingcart\Facades\Cart::subtotal()}}</b></p>
    <h5>Total inkl. MwSt: <b>{{ Gloudemans\Shoppingcart\Facades\Cart::total()}}</b></h5>
  
    <button class="button-87 greenbg" role="button"> Jetzt kaufen </button>
    @else     
  </tbody>
</table>
    <p class="pl-1">Keine Zutat ausgewählt!</p>
    <hr class="w-75">

    @endif 
</div>
<div>
      <img src="/images/kitchen-mixer-icon.svg" class="w-100 mixer ">
    </tbody>
</table>
</div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
    $(".removeAll").on("click", function(e){
      e.preventDefault();
      var self = $(this);
      console.log(self.data('name')); 
      Swal.fire({
        title: 'Bist du Dir sicher?',
        text: "Deine komplette Zusammenstellung wird unwiederruflich gelöscht!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6D9E1F',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Zusammenstellung löschen!',
        cancelButtonText: 'Abbrechen!'
      }).then((result) => {
        if (result.isConfirmed) {
          location.href = self.attr('href');
        }
      })
    });
   
</script>
</x-guest-layout>
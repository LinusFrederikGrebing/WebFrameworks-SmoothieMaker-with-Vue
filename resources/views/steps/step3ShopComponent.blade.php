

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
     
       <button href="{{ route('removeAll') }} " class="button-87 redbg removeAll d-flex"> 
      
        Alles aus dem Warenkorb entfernen
      </button>
    
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
                 <button class="btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
              </button>
        </form> 
           <span class="val"> {{ $item->qty }}</span>
        <form action="/decreaseCardQty/{{ $item->rowId }}" enctype="multipart/form-data" method="post">
                 @csrf
                 <button class="btn"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
</svg>
</button>
         </form> 
        </div>
        
      </td>
      <td class="action" data-title="remove"> 
      <form action="/deleteCart/{{ $item->rowId }}" enctype="multipart/form-data" method="post">
                 @csrf
                 <button class="btn">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
         <path  d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>
                 </button>
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
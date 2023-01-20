<div class="flex  text-right text-white ">
    <button wire:click ="increment"></button>
     @if(Gloudemans\Shoppingcart\Facades\Cart::count() > 0)
        <h1>{{ Gloudemans\Shoppingcart\Facades\Cart::count() }}</h1>
        @endif 
</div>

			
   

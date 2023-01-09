
<style>
/* fruits stuff */

    .button-fr {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 50px;
        width: 150px;
        position: relative;
        background: black;
        clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 15% 50%, 0% 0%); 
    }
    .button-fr:before {
        content: "";
        background: white;
        height: calc(100% - 2px);
        width: calc(100% - 3px);
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        clip-path: polygon(75% 0%, 100% 50%, 75% 100%, 0% 100%, 15% 50%, 0% 0%);
    }

    div span {
        z-index: 2;
        position: relative;
    }
 /*basic*/
    .mr-40{
        margin-top: 2em;
        margin-left: 65.5em;
    }
    .imagemargin{
        margin-top: -25em;
        margin-left: 2em;
        width: 20em;
    }
    #progressbar>div {
            background-color: #80ba24;
            width: 50%;
            /* Adjust with JavaScript */
            height: 20px;
            border-radius: 10px;
        }

    .buttonsBottom {
        display: flex;
        justify-content: space-between;
    }

    /* button animation */

    .center-con {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .arrcontainer {
        position: relative;
       
    }

    #cta .arrow{left: 30%;}
    .arrow {position: absolute; bottom: 0;  margin-left:3.5em; width: 12px; height: 12px; background-size: contain; top:16px; left: 0em;}
    .arrow-left { margin-left:-1.5em }
    .segunda{margin-left: 3em;}
    .segunda-left { margin-left:-2em }
    .next {
        background-image: url(/images/arrow-right.png);
    }
    .prev {
        background-image: url(/images/arrow-left.png);
    }
    @keyframes bounceAlpha {
    0% {opacity: 1; transform: translateX(0px) scale(1);}
    25%{opacity: 0; transform:translateX(10px) scale(0.9);}
    26%{opacity: 0; transform:translateX(-10px) scale(0.9);}
    55% {opacity: 1; transform: translateX(0px) scale(1);}
    }

    .bounceAlpha {
        animation-name: bounceAlpha;
        animation-duration:1.4s;
        animation-iteration-count:infinite;
        animation-timing-function:linear;
    }

    .arrow.primera.bounceAlpha {
        animation-name: bounceAlpha;
        animation-duration:1.4s;
        animation-delay:0.2s;
        animation-iteration-count:infinite;
        animation-timing-function:linear;
    }

    .arrcontainer:hover .arrow{
        animation-name: bounceAlpha;
        animation-duration:1.4s;
        animation-iteration-count:infinite;
        animation-timing-function:linear;
    }
    .arrcontainer:hover .arrow.primera{
        animation-name: bounceAlpha;
        animation-duration:1.4s;
        animation-delay:0.2s;
        animation-iteration-count:infinite;
        animation-timing-function:linear;
    }

    /* CSS */

        .button-right {
            margin-right: 1em;
            padding: 0.75em 1.25em;
            padding-right: 2.5em;
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

        .button-left {
            margin-right: 1em;
            padding: 0.75em 1.25em;
            padding-left: 2.5em;
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
@include('layouts.progressbar')
@include('layouts.groesse')
<div class=" mt-5">
    <button  onclick="window.location='{{ route('showFruits') }}'" class="buttonGrey">
        Fruits
    </button>
    <button  onclick="window.location='{{ route('showVeggie') }}'" class="buttonGrey">
        Veggie
    </button>
    <button  onclick="window.location='{{ route('showLiquids') }}'" class="buttonGrey">
        Liquid
    </button>

    @auth
    <button  onclick="window.location='{{ route('create') }}'" class="buttonGreen">
        Zutat hinzufügen
    </button>
    @endauth

</div>

<div class="row flex">
    
    <div class="row flex w-75 h-75">
        
    @foreach($zutaten as $zutat)

        <div class="col-3 pb-3">
        @auth
        
                 <form class="box" action="/update/ingrediente/{{  $zutat['id'] }}" enctype="multipart/form-data" method="post">
                 @csrf
                  <button class="btn"><i class="fa fa-pencil"></i></button>
                </form>
                
                <form action="/delete/ingrediente/{{  $zutat['id'] }}" enctype="multipart/form-data" method="post">
                 @csrf
                      <button class="btn"><i class="fa fa-trash"></i></button>
                </form>
       
        @endauth
            <img src="/images/{{  $zutat['image'] }}" class="w-25">


            <div>
                <span class="text-dark">Zutat: {{  $zutat['name'] }}</span>
                <div>
                    <span class="font-weight-bold"> Preis: {{ $zutat['price'] }}€</span>
                </div>
            </div>

            <form action="/addCart/{{ $zutat['id'] }}" enctype="multipart/form-data" method="post">
                 @csrf
                 <div class="flex">
                 <input id="amount" type="number"  step="1" min="1" max="20"
                        name="amount" value="1">
                 <button class="btn wkorb"> <svg class="flex-1 w-8 h-8 fill-current" viewbox="0 0 24 24">
      <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5.5C20.95,5.34 21,5.17 21,5A1,1 0 0,0 20,4H5.21L4.27,2M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"/>
      </svg></button>
                 </div>
              
            </form>
        </div>
        @endforeach
    </div>
    <div class="w-75 buttonsBottom">
        <div class="center-con">
        <div class="arrcontainer">
                <div id="cta">
                <button class="button-left redbg back" href="{{ route('showBottleSizes') }} ">
                    <span class="arrow prev arrow-left"></span>
                    <span class="arrow segunda prev arrow-left segunda-left  "></span>
                    Zurück!
                   
                </button>
                   
                </div>
            </div>
        </div>
        <div class="center-con">
            <div class="arrcontainer">
                <div id="cta">
                <button class="button-right greenbg" onclick="window.location='{{ route('showCard') }}'">
                   Weiter!
                    <span class="arrow next "></span>
                    <span class="arrow segunda next "></span>
                </button>
                   
                </div>
            </div>
        </div>

   </div>
     <img src="/images/kitchen-mixer-icon.svg" class="imagemargin">

   </div>

</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
    $('.arrcontainer').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('.arrow').toggleClass('bounceAlpha');
    });
    $(".back").on("click", function(e){
      e.preventDefault();
      var self = $(this);
      console.log(self.data('name')); 
      Swal.fire({
        title: 'Bist du Dir sicher?',
        text: "Wenn du zurückgehst wird deine bisherige Zusammenstellung unwiederruflich gelöscht!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6D9E1F',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Weiter zurück!',
        cancelButtonText: 'Abbrechen!'
      }).then((result) => {
        if (result.isConfirmed) {
          location.href = self.attr('href');
        }
      })
    });
  
    
    
</script>
</x-guest-layout>
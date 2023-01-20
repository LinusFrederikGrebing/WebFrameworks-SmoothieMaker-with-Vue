
<style>
        .rotating-map {
            background-color: transparent;
            width: 30em;
            height: 12em;
            margin-top: 1em;
        }

        .rotating-map-content {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.8s;
            transform-style: preserve-3d;
        }

        .rotating-map:hover .rotating-map-content {
            transform: rotateY(180deg);
        }

        .rotating-map-content--front,
        .rotating-map-content--back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            /* Safari */
            backface-visibility: hidden;
            border-radius: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .rotating-map-content--front {
            background: linear-gradient(-229deg, #80ba24, #9FB779);

        }

        .rotating-map-content--back {
            background: linear-gradient(229deg, #80ba24, #9FB779);
            backdrop-filter: blur(2px);
            color: black;
            transform: rotateY(180deg);
        }

        .rotating-map-content--back h1,
        .rotating-map-content--back p {
            margin: 0;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .rotating-map-content--back h1 {
            font-size: 1.7rem;
        }

        .logo {
            width: 10em;
            height: 10em;
            opacity: 1;
        }
        .logosmall {
            width: 5em;
            height: 5em;
            filter: drop-shadow(2px 2px 5px black);
            opacity: 0.7;
        }
        .flex-row{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }

        .flex-col{
            display: flex;
            flex-direction: column-reverse;
        }
        .mixer {
            width: 35em;
            height: 40em;
            opacity: 1;
        }

        #progressbar>div {
            background-color: #80ba24;
            width: 1%;
            /* Adjust with JavaScript */
            height: 20px;
            border-radius: 10px;
        }

        .water {
            margin: auto;
            position: relative;
            width: 10vw;
            height: 22vh;
            background-color: #ececec80;
            background-size: 18em;
            transform: scale(1.15, 1.7);
            clip-path: polygon(0 0, 100% 0, 95% 100%, 5% 100%)
        }

        .water::before {
            border-radius: 10em;
            content: "";
            width: 210%;
            height: 200%;
            background: #ff4040;
            
            position: absolute;
            top: 20%;
            left: -50%;
            border-radius: 40%;
            animation: anim 12s linear infinite;
        }

        .water::after {
            border-radius: 10em;
            content: "";
            width: 204%;
            
            height: 200%;
            background: #e61919;
            position: absolute;
            left: -50%;
            top: 25%;
            border-radius: 40%;
            animation: anim 12s linear infinite;
            animation-delay: 0.5s;
        }
        #halm{
            margin-top: -27em;
            margin-left: 8em;
        }
        .step1{
            overflow: hidden;
        }

        @keyframes anim {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
        }
</style>


<x-guest-layout>
 
<div class="container step1">
    <div class="flex-row">
        <div class="flex-col">
       
        @foreach($bottles as $bottle)
        <a id="{{$bottle['id']}}" type="button" onclick="window.location='{{ route('showInhalt', ['bottle' => $bottle])}}'" class="bottle">
        <div class="rotating-map">
            <div class=" rotating-map-content">
                <div class="rotating-map-content--front">
                    <img src="/images/{{ $bottle['image'] }}" alt="" class="logo">
                </div>
                <div class="rotating-map-content--back">
                    <h1>Größe: {{ $bottle['name'] }} </h1>
                    <p>{{ $bottle['description'] }} </p>
                </div>
            </div>
         </div>
       </a>
        
        @endforeach
    </div>
    <!-- <img id="mixerLogo" src="/images/kitchen-mixer-icon.png" class="mixer mt-2"> -->
    <div>
        <div class="water waterbefore waterafter" id="mixerLogo"> </div>
        <img src="/images/strohalm.png" alt="" id="halm">
    </div> 
    <h1 id="text">Größe: S</h1>
    </div>
</div>
<script> 
 
let water = document.getElementById("mixerLogo");
let halm = document.getElementById("halm");

let bottle = document.getElementsByClassName("bottle");
for(let i = 0; i<bottle.length; i++){
    bottle[i].addEventListener("mouseenter", (event) => {
        if(bottle[i].id == 1){
            water.style.transform = "scale(1.15, 1.6)";
            halm.style.marginTop = "-50vh";
            console.log(bottle[i]);
            document.getElementById("text").innerHTML = "Größe: S";
        }  
        else if(bottle[i].id == 2){
            water.style.transform = "scale(1.20, 1.9)";
            halm.style.marginTop = "-55vh";
            document.getElementById("text").innerHTML = "Größe: M";
        }
        else if(bottle[i].id == 3){
            water.style.transform = "scale(1.30, 2.25)";
            halm.style.marginTop = "-61vh";
            document.getElementById("text").innerHTML =  "Größe: L";
        }
        else{ 
            water.style.transform = "scale(1.35, 2.6)";
            halm.style.marginTop = "-67vh";
           
            document.getElementById("text").innerHTML =  "Größe: XL";
        } 
    })
}


</script>
</x-guest-layout>
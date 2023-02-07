<style>
    #canvas {
      border: 2px solid black;
    }

    #mixerLogo {
        position: relative;
        top: -460;
        width: 450px;
        height: 750px;
        right: 65;
    }
    .test {
        width: 100em;
    }
</style>
<script>
	$(document).ready(function() {
		setup();
	});
</script>
<div>
     <canvas id="myCanvas" width="265" height="350"></canvas>
    <img id="mixerLogo" src="/images/mixerV2.png" class="mixer mt-2"> 
</div>
		
<script src="{{ asset('js/mixer.js') }}"></script>
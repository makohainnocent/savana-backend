<html>
    <head></head>
    <body>
        <h1><center>STREAM TEST</center></h1>
        <p><button onclick="start()">start</button></p>
        <p><button onclick="stop()">stop</button></p>
        <br>
        <div class="flexChild" id="camera-container">
  <div class="camera-box">
    <video id="received_video" controls autoplay style="width:300px;height:300px;border-color:blue;border-style:solid"></video>
    <video id="local_video" controls autoplay muted style="width:300px;height:300px;border-color:green;border-style:solid"></video>
    <button id="hangup-button" onclick="hangUpCall();" disabled>Hang Up</button>
  </div>
</div>
        
    </body>
   
</html>
<script src="{{URL::asset('assets/js/jquery.js')}}"></script>
<script src="{{URL::asset('assets/js/stream.js')}}"></script>


var computer_serial="26A1A74C-5C67-AE16-4983-289838DF98AD";
var userId=1;
var streamingMediaType="S";
var myPeerConnection;

const mediaConstraintsCamera = {
    audio: true, // We want an audio track
    video: true // And we want a video track
};

const mediaConstraintsScreen={
    video:{
        cursor:"never"
    },
    audio:false
}

const mediaConstraintsMicrophone = {
  audio: true, // We want an audio track
};

window.onload=function(){
    loadStreamingMediaType()
    setInterval(messagePolling,5000);
}

function start(){
    
    fetch("/createCommand/computer_serial/"+computer_serial+"/userId/"+userId+"/command/STARTSTREAMSERVER")
        .then(response=>response.text())
        .then(data=>{
            //alert(data)
            console.log(data)
        })
        .catch(error=>{
            //alert(error)
        })
}

function stop(){
    fetch("/createCommand/computer_serial/"+computer_serial+"/userId/"+userId+"/command/STOPSTREAMSERVER")
    .then(response=>response.text())
    .then(data=>{
        //alert(data)
        console.log(data)
    })
    .catch(error=>{
        //alert(error)
    })
}

function loadStreamingMediaType(){
    $.ajax({
        url:"/putMessage",
        method:"post",
        async:false,
        data:{
            to:computer_serial,
            from:userId,
            message:streamingMediaType,
            attachements:0,
            sdp:0,
            ice:0,
            text:0,
            files:0,
            read:0,
            mediaStreamType:1,

        },
        success:function(data){
          console.log(data)
        },
        error:function(error){
          //abortSession("could not get command details")
        }
    })
}

function messagePolling(){
    $.ajax({
      url:"/getMessage",
      method:"post",
      async:false,
      data:{for:userId},
      success:function(data){
        console.log(data)
        if(data[0].ice=="1"){
          handleNewICECandidateMsg(data[0].message)
        }
        if(data[0].sdp=="1"){
          handleVideoOfferMsg(data[0].message)
        }
      },
      error:function(error){
        //abortSession("could not get command details")
      }
     })
  }


  function handleVideoOfferMsg(msg) {
    let localStream = null;
    
    createPeerConnection();
  
    const desc = new RTCSessionDescription(JSON.parse(msg));

    if (streamingMediaType=="C"){
        //alert("camera")
        myPeerConnection.setRemoteDescription(desc)
      .then(() => navigator.mediaDevices.getUserMedia(mediaConstraintsCamera))
      .then((stream) => {
        localStream = stream;
        document.getElementById("local_video").srcObject = localStream;
  
        localStream.getTracks().forEach((track) => myPeerConnection.addTrack(track, localStream));
      })
      .then(() => myPeerConnection.createAnswer())
      .then((answer) => myPeerConnection.setLocalDescription(answer))
      .then(() => {
        const msg = {
          type: "video-answer",
          sdp: myPeerConnection.localDescription
        };
  
        sendToServer(msg);
      })
      .catch(handleGetUserMediaError);
    }

    if (streamingMediaType=="M"){
        myPeerConnection.setRemoteDescription(desc)
      .then(() => navigator.mediaDevices.getUserMedia(mediaConstraintsMicrophone))
      .then((stream) => {
        localStream = stream;
        document.getElementById("local_video").srcObject = localStream;
  
        localStream.getTracks().forEach((track) => myPeerConnection.addTrack(track, localStream));
      })
      .then(() => myPeerConnection.createAnswer())
      .then((answer) => myPeerConnection.setLocalDescription(answer))
      .then(() => {
        const msg = {
          type: "video-answer",
          sdp: myPeerConnection.localDescription
        };
  
        sendToServer(msg);
      })
      .catch(handleGetUserMediaError);
    }

    if (streamingMediaType=="S"){
        myPeerConnection.setRemoteDescription(desc)
      .then(() => navigator.mediaDevices.getDisplayMedia(mediaConstraintsScreen))
      .then((stream) => {
        localStream = stream;
        document.getElementById("local_video").srcObject = localStream;
  
        localStream.getTracks().forEach((track) => myPeerConnection.addTrack(track, localStream));
      })
      .then(() => myPeerConnection.createAnswer())
      .then((answer) => myPeerConnection.setLocalDescription(answer))
      .then(() => {
        const msg = {
          type: "video-answer",
          sdp: myPeerConnection.localDescription
        };
  
        sendToServer(msg);
      })
      .catch(handleGetUserMediaError);
    }
  
    
  }


  function handleNewICECandidateMsg(msg) {
    const candidate = new RTCIceCandidate(JSON.parse(msg));
  
    myPeerConnection.addIceCandidate(candidate)
      .catch(reportError);
  }


  function createPeerConnection() {
    myPeerConnection = new RTCPeerConnection({
        iceServers: [     // Information about ICE servers - Use your own!
          {
            urls: "stun:stun.stunprotocol.org"
          },
          {
            urls: "stun:openrelay.metered.ca:80",
          },
          {
            urls: "turn:openrelay.metered.ca:80",
            username: "openrelayproject",
            credential: "openrelayproject",
          },
          {
            urls: "turn:openrelay.metered.ca:443",
            username: "openrelayproject",
            credential: "openrelayproject",
          },
          {
            urls: "turn:openrelay.metered.ca:443?transport=tcp",
            username: "openrelayproject",
            credential: "openrelayproject",
          }
        ]
    });
  
    myPeerConnection.onicecandidate = handleICECandidateEvent;
    myPeerConnection.ontrack = handleTrackEvent;
    myPeerConnection.onnegotiationneeded = handleNegotiationNeededEvent;
    myPeerConnection.onremovetrack = handleRemoveTrackEvent;
    myPeerConnection.oniceconnectionstatechange = handleICEConnectionStateChangeEvent;
    myPeerConnection.onicegatheringstatechange = handleICEGatheringStateChangeEvent;
    myPeerConnection.onsignalingstatechange = handleSignalingStateChangeEvent;
  }

  function handleSignalingStateChangeEvent(event) {
    switch(myPeerConnection.signalingState) {
      case "closed":
        closeVideoCall();
        break;
    }
  };

  function handleICEGatheringStateChangeEvent(event) {
    // Our sample just logs information to console here,
    // but you can do whatever you need.
  }

  function handleICEConnectionStateChangeEvent(event) {
    switch(myPeerConnection.iceConnectionState) {
      case "closed":
      case "failed":
        closeVideoCall();
        break;
    }
  }

  function handleRemoveTrackEvent(event) {
    const stream = document.getElementById("received_video").srcObject;
    const trackList = stream.getTracks();
  
    if (trackList.length === 0) {
      closeVideoCall();
    }
  }

  function handleTrackEvent(event) {
    document.getElementById("received_video").srcObject = event.streams[0];
    document.getElementById("hangup-button").disabled = false;
  }

  function handleICECandidateEvent(event) {
    if (event.candidate) {
      sendToServer({
        type: "new-ice-candidate",
        candidate: event.candidate
      });
    }
  }

  function handleNegotiationNeededEvent() {
    myPeerConnection.createOffer()
      .then((offer) => myPeerConnection.setLocalDescription(offer))
      .then(() => {
        sendToServer({
          type: "video-offer",
          sdp: myPeerConnection.localDescription
        });
      })
      .catch(reportError);
  }

  function sendToServer(msg){
    if(msg.type=="video-offer"){
      sendVideoOffer(msg.sdp)
    }

    if(msg.type=="video-answer"){
      sendVideoAnswer(msg.sdp)
    }

    if(msg.type=="new-ice-candidate"){
      sendIceCandidate(msg.candidate)
    }
  }

  function sendVideoOffer(sdp){
    $.ajax({
      url:"/putMessage",
      method:"post",
      async:false,
      data:{
          to:computer_serial,
          from:userId,
          message:JSON.stringify(sdp),
          attachements:0,
          sdp:1,
          ice:0,
          text:0,
          files:0,
          read:0,
          mediaStreamType:0,

      },
      success:function(data){
        console.log(data)
      },
      error:function(error){
        //abortSession("could not get command details")
      }
  })
  }

  function sendVideoAnswer(sdp){
    $.ajax({
      url:"/putMessage",
      method:"post",
      async:false,
      data:{
          to:computer_serial,
          from:userId,
          message:JSON.stringify(sdp),
          attachements:0,
          sdp:1,
          ice:0,
          text:0,
          files:0,
          read:0,
          mediaStreamType:0,

      },
      success:function(data){
        console.log(data)
      },
      error:function(error){
        //abortSession("could not get command details")
      }
  })
  }


  function sendIceCandidate(candidate){
    $.ajax({
      url:"/putMessage",
      method:"post",
      async:false,
      data:{
          to:computer_serial,
          from:userId,
          message:JSON.stringify(candidate),
          attachements:0,
          sdp:0,
          ice:1,
          text:0,
          files:0,
          read:0,
          mediaStreamType:0,

      },
      success:function(data){
        console.log(data)
      },
      error:function(error){
        //abortSession("could not get command details")
      }
  })
  }

  function closeVideoCall() {
    const remoteVideo = document.getElementById("received_video");
    const localVideo = document.getElementById("local_video");
  
    if (myPeerConnection) {
      myPeerConnection.ontrack = null;
      myPeerConnection.onremovetrack = null;
      myPeerConnection.onremovestream = null;
      myPeerConnection.onicecandidate = null;
      myPeerConnection.oniceconnectionstatechange = null;
      myPeerConnection.onsignalingstatechange = null;
      myPeerConnection.onicegatheringstatechange = null;
      myPeerConnection.onnegotiationneeded = null;
  
      if (remoteVideo.srcObject) {
        remoteVideo.srcObject.getTracks().forEach((track) => track.stop());
      }
  
      if (localVideo.srcObject) {
        localVideo.srcObject.getTracks().forEach((track) => track.stop());
      }
  
      myPeerConnection.close();
      myPeerConnection = null;
    }
  
    remoteVideo.removeAttribute("src");
    remoteVideo.removeAttribute("srcObject");
    localVideo.removeAttribute("src");
    remoteVideo.removeAttribute("srcObject");
  
    document.getElementById("hangup-button").disabled = true;
    targetUsername = null;
  }

  function hangUpCall() {
    closeVideoCall();
    sendToServer({
      type: "hang-up"
    });
  }

  function handleGetUserMediaError(e) {
    switch(e.name) {
      case "NotFoundError":
        alert("Unable to open your call because no camera and/or microphone" +
              "were found.");
        break;
      case "SecurityError":
      case "PermissionDeniedError":
        // Do nothing; this is the same as the user canceling the call.
        break;
      default:
        alert(`Error opening your camera and/or microphone: ${e.message}`);
        break;
    }
  
    closeVideoCall();
  }
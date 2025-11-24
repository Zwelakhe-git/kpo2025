
async function readDb(){
    let response = await fetch('/php/dbReader.php?r=stream');
    let data = await response.json();
    return data;
    /*return new Promise((resolve, reject) => {
        let xhr = null;
        if(window.ActiveXMLObject){
            xhr = new ActiveXMLObject();
        } else {
            xhr = new XMLHttpRequest();
        }

        if(!xhr){
            console.log("failed to initialise xhr object");
            return;
        }

        xhr.open('GET', '/php/dbReader.php?r=stream');
        xhr.responseType = 'json';
        xhr.onreadystatechange = () => {
            if(xhr.readyState === 4){
                if(xhr.status >= 200 && xhr.status < 300){
                    let jsonResponse = xhr.response;
                    if(jsonResponse){
                        resolve(jsonResponse);
                    } else {
                        reject({ data: "error", message: "received null response from server: " + jsonResponse})
                    }
                }
            }
        }

        xhr.send(null);
    });*/
}

function streamingPageHtml(streamData){
    let today = new Date().toISOString();
    let currentlyPlaying = streamData.stream_date.split(" ")[0] === today.split("T")[0] ? streamData : null;
    console.log(streamData.stream_date.split(" ")[0], today.split("T")[0])
    return `<div id="body">
        
        <div class="stream-container">
            <!-- Neon animated lines -->
            <div class="neon-line"></div>
            <div class="neon-line"></div>
            <div class="neon-line"></div>
            <div class="neon-line"></div>

            <div class="stream-content">
            <div class="play-button" data-streamid="${currentlyPlaying ? currentlyPlaying.id : 'none'}"></div>
            <h2>${currentlyPlaying ? `${currentlyPlaying.stream_title}` : 'stream offline'}</h2>
            <p>Press the play button to start viewing the current stream</p>
            </div>
        </div>

		${streamData.stream_date.split(" ")[0] === today.split("T")[0] ?
        `<div class="next-stream">
            <div class="info">
            <p style="color:#d9d9d9; margin:0;">📅 Current Stream</p>
            <h3>${streamData.stream_title}</h3>
            <p>📍 ${streamData.stream_date.split(" ")[0]}</p>
            </div>
            <div class="link watch-link" data-streamKey="${streamData.stream_key}" data-streamid="${streamData.id}">Watch</div>
        </div>`: ""}
		
        <!-- Next stream card -->
        <div class="next-stream">
            <div class="info">
            <p style="color:#d9d9d9; margin:0;">📅 Next Stream</p>
                ${streamData.stream_date.split(" ")[0] > today.split("T")[0] ?
                `<h3>${streamData.stream_title}</h3>
                <p>📍 ${streamData.stream_date}</p>` :
                `<h3>No scheduled streams</h3>
                <p>📍 Follow for updates</p>`
                 }
            </div>
            <button class="notify-btn">🔔 Get Notified</button>
        </div>
        
    </div>
`
}
function streamingPgStyle(){
    let styleTag = document.querySelector("#root-style");
    if(!styleTag){
        console.log("streamingPgStyle: style tag not found");
        return;
    }

    styleTag.innerHTML = `
*{
	box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
@media (min-width: 768px){
.nav-link {
    color: #aee739;
}
div#nav-panel {
        box-shadow: none !important;
        background-color: transparent;
    }
    .nav-link:hover,
    .nav-link:focus{
    	background-color: #aee739;
        color: black;
    }
}

.search-bar .input{
            border: none;
            outline: none;
        }
        body{
            margin: 0;
            font-family: Arial, sans-serif;
            background: #0c0f1d;
            color: #fff;
        }
        #body {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
          }

          /* Stream section */
          .stream-container {
            width: 100%;
            max-width: 900px;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            background: #0b0e1f;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
              margin-top: 20px;
          }
          .btn-div{
          	padding: 9px;
            border-radius: 10px;
            color: white;
          }
          .blu{
          	background-color: #089ee6;
            outline: #91cfee;
          }
          .grn{
          	background-color: #06e152;
            outline: #c1fcd5;
          }

          /* Animated neon lines */
          .neon-line {
            position: absolute;
            width: 200%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ff007f, #00f0ff, transparent);
            opacity: 0.8;
            animation: moveLines 6s linear infinite;
          }

          .neon-line:nth-child(1) {
            top: 20%;
            animation-delay: 0s;
          }
          .neon-line:nth-child(2) {
            top: 40%;
            animation-delay: 2s;
          }
          .neon-line:nth-child(3) {
            top: 60%;
            animation-delay: 4s;
          }
          .neon-line:nth-child(4) {
            top: 80%;
            animation-delay: 1s;
          }

          @keyframes moveLines {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
          }

          /* Stream content */
          .stream-content {
            z-index: 2;
            text-align: center;
          }

          .stream-content h2 {
            font-size: 28px;
            margin: 10px 0;
          }

          .stream-content p {
            font-size: 16px;
            opacity: 0.8;
          }

          .play-button {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            border: 2px solid #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            cursor: pointer;
            transition: background 0.3s;
          }

          .play-button:hover {
            background: rgba(255,255,255,0.3);
          }

          .play-button:before {
            content: '';
            display: block;
            width: 0;
            height: 0;
            border-left: 18px solid #fff;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
            margin-left: 5px;
          }

          /* Next stream card */
          .next-stream {
            margin-top: 20px;
            width: 100%;
            max-width: 900px;
            background: #111a2e;
            border-radius: 12px;
            padding: 20px 0px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-direction: column;
            align-content: flex-start;
          }

          .next-stream .info {
            display: flex;
            flex-direction: column;
            align-items: center;
          }

          .next-stream .info h3 {
            margin: 0;
            font-size: 20px;
          }

          .next-stream .info p {
            margin: 5px 0;
            opacity: 0.8;
          }

          .notify-btn {
            background: #d9d9d9;
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            color: #000;
            transition: background 0.3s;
          }

          .notify-btn:hover {
            background: #d4ff4d;
          }
          .video-container{
              width: 100%;
              height: 100%;
          }
          .html5-vid.stream-vid{
              width: 100%;
              height: 100%;
              border-radius: 10px;
          }
          .stream-bar{
              display: flex;
              flex-direction: row;
              width: 100%;
              border-bottom: 1px solid white;
              padding: 5px 0px;
          }

          .stream-bar-nav{
              width: 100%;
              padding: 5px;
              display: flex;
              flex-direction: row;
              justify-content: flex-end;
              gap: 10px;
          }
          .link{
              gap: 3px;
              color: #d9d9d9;
              width: fit-content;
              transition: background-color 0.3ms linear;
              padding: 5px;
              border-radius: 3px;
              background-color: transparent;
              outline: 2px solid #d9d9d9;
          }

          .link:hover{
              background-color: #d9d9d9;
              color: black;
          }
          #reg-page{
              position: absolute;
              top: 0;
              left: 0;
              width: 100%;
              box-sizing: border-box;
              z-index: 105;
              background-color:#0c0f1d;
              min-height: 100%;
          }
          #regForm, #accessForm{
              width: 85%;
              padding: 10px;
              box-sizing: border-box;
              margin: auto;
          }
          #regForm *{
              box-sizing: border-box;
          }
          #accessForm > *{
          	margin-bottom: 5px;
          }
          #accessForm button {
            padding: 5px;
            border-radius: 6px;
            border: none;
          }
          .field{
              display: flex;
              flex-direction: column;
              gap: 5px;
          }
          .field input{
              border: none;
              border-radius: 5px;
              padding: 8px;
              caret-color: currentColor;
              font-weight: 600;
              margin-bottom: 10px;
          }

          .controls{
              display: flex;
              flex-direction: row;
              gap: 5px;
              width: 100%;
          }
          ` +
        `
          @media (max-width: 480px){
      .pop-form {
          width: 60%;   
      }
    }
    
    @media (min-width: 480px){
      .pop-form {
        width: 100%;   
      }
    }
    @media (orientation: landscape){
    	.streamWin-container{
        	height: 100svh;
        }
    }
    @media (orientation: portrait){
    	.streamWin-container{
        	height: 100lvh;
        }
    }
    
    #stream-frame{
      width: 100%;
      height: 100%;
    }
    .btn{
      color: red;
      font-size: 40px;
    }
    .play-btn{
      color: rgb(5, 180, 5);
      margin: auto;
      font-size: 75px;
    }
    .stream-close-btn{
      position: absolute;
      bottom: 40px;
    }
    .frame-control{
      width: 100%;
      height: 100%;
      display: flex;
    }
    .marg-aut{
      margin: auto;
    }
    .streamWin-container{
      position: absolute;
      top: 0px;
      z-index: 110;
      width: 100%;
      display: flex;
      flex-direction: column;
      background-color: #ffffff65;
    }

    #stream-frame{
      border: none;
      margin: auto;
    }
    .stream-win{
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      place-items: center;
    }
    .undlr{
      text-decoration: underline;
    }
    .rd-clr{
      color: red;
    }
    .pop-up-prompt {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        background-color: #ffffffbf;
        padding: 20px;
        z-index: 114;
    }
    
    .pop-form {
        border-radius: 8px;
        box-shadow: 0px 0px 5px grey;
        background-color: #1d1d1d;
        padding: 30px;
        transform: scale(0);
        transition: transform 0.3s ease-in-out;
        font-size: 16px;
        color: #82ca0e;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }
    .pop-form.open{
      transform: scale(1.0);
    }
    .pop-form button {
        padding: 8px;
        border-radius: 8px;
        background-color: #82ca0e;
        color: white;
        font-weight: 600;
        border: none;
        font-size: inherit;
    }
    .rd-bg{
      background-color: red !important;
    }`;
}

function loadExternalScripts(){
    let scripts = [
        {
            type: "module",
        	src: "/JS/streamingReg.js"
        }
    ]
    
    scripts.forEach( script => {
        let scriptTag = document.createElement("script");
        scriptTag.type = script.type;
        scriptTag.src = script.src;
        document.head.appendChild(scriptTag);
    })
}

function streamingScript(){
   document.querySelector(".notify-btn").addEventListener("click", function() {
      window.location.href = "/?p=emailsubscribtion";
    });

    let defaultStreamContent = `
    <div class="neon-line"></div>
    <div class="neon-line"></div>
    <div class="neon-line"></div>
    <div class="neon-line"></div>

    <div class="stream-content">
    <div class="play-button"></div>
    <h2>Stream Offline</h2>
    <p>Press the play button to start viewing the current stream</p>
    </div>`;

     let sc = document.querySelector(".stream-container");
     if(!sc){
            console.log("initStreamContainer: stream container not found");
            return;
     }

     //sc.innerHTML = defaultStreamContent;

}

export default async function streaming(){
    let title = document.querySelector("title");
  if(!title){
      title = document.createElemnt("title");
      document.head.insertAdjacentElement("afterbegin", title);
  }
  title.textContent = "Konektem Stream";
  let root = document.querySelector("#root");
    if(!root){
        console.log("actuality: root element not found");
        return;
    }
    streamingPgStyle();
    
    readDb()
    .then( response => {
        console.log(response);
        root.innerHTML = streamingPageHtml(response[0]);
        setTimeout( ()=>{
            streamingScript();
            loadExternalScripts();
        }, 200);
    })
    .catch( reason => {
        console.log(reason.message);
    } ) 
}
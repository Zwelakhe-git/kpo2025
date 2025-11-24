import slideContainer from '/JS/bottomscroll.js';
import {setEventHandlers} from '/JS/audScript.js';

const scriptIndx = () => {
    //giveSecsClasses();
    //setRightPanel();
    //setPartnersAnimation();
    //configureAbsConatinerSizes();
    //bottomImageSlide();
    setEventHandlers();
};

// scroll buttons
function setScrollButtons(headDiv){
    headDiv.querySelectorAll(".scroll-btn").forEach(
        btn => {
            if(btn.classList.contains("right")){
                btn.innerHTML = "<ion-icon name='arrow-forward-outline' class='icon'></ion-icon>";
            }
            else if(btn.classList.contains("left")){
                btn.innerHTML = "<ion-icon name='arrow-back-outline' class='icon'></ion-icon>";
            }
            
        }
    );
}

// sections
function giveSecsClasses(){
    document.querySelectorAll(".app > div").forEach(
        secDiv => {
            if(secDiv.id !== "footer" && secDiv.id !== "top-bar"){
                if(secDiv.id !== "head" && secDiv.id !== "nav-panel"){
                    secDiv.classList.add("opt-width-marg", "margin-rl-1");
                }
                else if(secDiv.id === "navPanel"){
                    secDiv.classList.add("opt-width-nomarg");
                }
            }
        }
    );
}
function configureAbsConatinerSizes(){
  
  const waitForArticles = new Promise(resolve =>{
      let observer = new MutationObserver(() => {
          let firstArticleItem = document.querySelector(".artcl-itm");
          if(firstArticleItem){
              resolve(firstArticleItem);
          }
      });
      
      observer.observe( document.body, { childList: true, subtree: true} );
  });
  waitForArticles
  .then( ele => {
      let newsarticles = document.querySelector(".articles");
      if(!newsarticles){
          console.log("news articles not found");
          return;
      }
      
      let artclItemStyles = window.getComputedStyle(ele);
      let optHeight = ele.scrollHeight;
      newsarticles.style.minHeight = `${optHeight + 10}px`;
  });
  
}

function bottomImageSlide(){
  let imgUrls = [
    {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_4657.JPG.jpg"
    },
    {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_4658.JPG.jpg"
    },
    {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_4659.JPG.jpg"
    },
    {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_4656.JPG.jpg"
    },
    {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_4660.JPG.jpg"
    },
    {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_4661.JPG.jpg"
    },
    {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_4662.JPG.jpg"
    },
      {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_4664.JPG.jpg"
    },
      {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_4665.JPG.jpg"
    },
      {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_5227.JPG.jpg"
    },
   {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_5244.JPG.jpg"
    },
   {
      mime_type : "image/jpeg",
      src : "/media/images/bottom/IMG_5245.JPG.jpg"
    },
      
  ]
  let linkTag = document.createElement("link");
    linkTag.rel = "stylesheet";
    linkTag.type = "text/css";
    linkTag.href = "/CSS/bottomScrollstyle.css";
    document.head.appendChild(linkTag);
  let container = document.querySelector(".bottom-slide");
  if(!container){
    console.log("bottomImageSlide: container not found");
    return;
  }
  let inlineHtml = "";
  imgUrls.forEach(imgObj => {
    inlineHtml += `
    <div class="slide-container">
      <img type="${imgObj.mime_type}" src="${imgObj.src}"/>
    </div>`;
    
  });
    
    setTimeout(() => {
        container.innerHTML = inlineHtml;
        slideContainer()
    }, 350);

}

function stylemiddlePanelCharts(){
    // installing classes
    document.querySelectorAll(".music-track p").forEach( p => {
        p.classList.add("no-margin");
    })
    
    document.querySelectorAll(".music-track").forEach( p => {
        p.classList.add("flxDisp");
    })
    document.querySelectorAll(".audio-charts").forEach( p => {
        p.classList.add("flxDisp");
    })
}

function setRightPanel(){
    // right panel
    const rpDiv = document.querySelector("#link-portrait-video");
    rpDiv.classList.add("flxDisp");

    let rpCont =  `<div class="vid-container">
    <div class="icon-bg abs-pos vid-cvr flxDisp cntr">
        <ion-icon name="play" class="vid-ctrl"></ion-icon>
    </div>
        <video class="html5-vid" poster="https://avatars.mds.yandex.net/i?id=abb9204e9617046cb07b2d7343a99d178fa22085-8514130-images-thumbs&n=13" src="" muted></video>
    </div>`;
    rpDiv.innerHTML += rpCont;
}

// subscription
function setSubscriptionPanel(vidBG, pos, showTitle){
    const div = document.createElement("div");
    div.id = `sub-section-${pos}`;
    //"opt-width-marg","margin-rl-1"
    div.classList.add("margin-rl-1","flxDisp");
    let inlineHtml = `${ showTitle ? `<div class="section-info">
        <h1>ABONE</h1>
        </div>` : ""
        }
        <div class="sub flxDisp full-w-h" ${pos === "top" ? "style='background-color: #d2cccc; border-radius: 10px'" : ""}>
        ${vidBG ? `<div class="sub-bg flxDisp full-w-h">
            <video class="html-bg-vid full-w-h"
             type="video/mp4" src="/media/videos/file.mp4" 
              
              autoPlay
              muted
              loop>
            </video>
        </div>` : ""}
        <div class="flxDisp contnform">
            <div class="sub-text flxDisp">
                <p class="p-big">
                    Abone pou resevwa kontni eksklizif nou yo.
                </p>
                <p class="p-sml">
                "Kelkeswa gwose biznis ou a oswa domen w ap evolye a, 
                    nou gen konpetans ak ekspetiz nesese pou n ede
                    w reyisi nan mond dijital la."
                </p>
            </div>
            <form class="subform flxDisp" method="POST">
                <div class="sub-inpF flxDisp">
                    <label>Email*</label>
                    <input type="email" name="clientemail" required=""/>
                </div>
                <div class="mail-sub flxDisp">
                    <input type="checkbox" name="emailSub"/>
                    <label for="emailSub">yes, subscribe me to your newsletters</label>
                </div>
                <div class="form-btns flxDisp">
                    <button type="send" id="emailSndBtn" class="full-w">Send</button>
                </div>
            </form>
        </div>
      </div>
      
      <div class="gap" id="sub-gap-${pos}"></div>`;

      div.innerHTML = inlineHtml;

    switch(pos){
        case "top":
            let partnersDiv = document.querySelector("#events-section");
            
            if(partnersDiv){
                try{
                    document.body.insertBefore(div, partnersDiv);
                }catch(error){
                    console.log(error.message);
                }
            }
            else{
                console.log("partners div not found");
            }
            break;
        case "btm":
            let pDiv = document.querySelector("#partners-panel");
            if(pDiv){
                try{
                    pDiv.parentElement.insertBefore(div, pDiv);
                }catch(error){
                    console.log(error.message);
                }
            }
            else{
                console.log("partners div not found");
            }
            
            break;
    }
}

function setPartnersAnimation(){

    let animationInterval = null;
    let partnerImages = document.querySelectorAll(".partners img");
    if(partnerImages.length > 0){
        animationInterval = setInterval( () => {
            partnerImages.forEach( img => {
                img.classList.toggle("beep");
            });
        }, 1000);
    }
}

export default scriptIndx;
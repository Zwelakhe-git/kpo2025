import slideContainer from '/JS/bottomscroll.js';

const MAX_NEWS_SLIDES = 10;
function head(newsData){
    let slides = ``;
  for( let i = 0; i <= MAX_NEWS_SLIDES && i < newsData.length; ++i){
      slides += `<div class="slide-image-container full-w-h" data-id="${newsData[i].id}">
        <img alt="news image"  src="${newsData[i].image_location}" class="slide-image cvr full-w" />
        <p class="slide-img-desc">${newsData[i].newsTitle}</p>
      </div>`;
  }
  return `
  <div id="head" class="container-outer pad-20 white-bg bdr-box">
    <div id="news-slides">
      ${slides}
    </div>
    <div class="scroll-btn right">
      <ion-icon name='arrow-forward-outline' class='icon'></ion-icon>
    </div>
    <div class="scroll-btn left">
      <ion-icon name='arrow-back-outline' class='icon'></ion-icon>
    </div>
    <a href="/?p=actuality&id=${newsData[0].id}" id="slide-link" class="link no-dec">
        <div class="more-actions beep-anim">
        	<span>Wè Plis</span>
        	<ion-icon name="arrow-forward-outline"></ion-icon>
        </div>
      </a>
  </div>
  `;
}

function lastNews(newsData){
  const MAX_NEWS_FADE_CONTENT = 20;
  let newsList = '';
  for(let index = 0; index <= MAX_NEWS_FADE_CONTENT && index < newsData.length; ++index){
      newsList += `<div class='artcl-itm full-wh pad-5' data-newsid="${newsData[index].id}">
        <div class='artcl-cont full-wh'>
          <div class='artcl-info full-wh'>
            <a href="/?p=actuality&id=${newsData[index].id}" class='img-link'>
                <div class='artcl-img'>
                <img alt='article img' class="full-wh" src='${newsData[index].image_location}'/>
              </div>
            </a>
            <div class="artcl-text">
              <div class="artcl-text-content" style="overflow: hidden">
              	<h1>${newsData[index].newsTitle}</h1>
              	<p >${newsData[index].newsHeadline}</p>
              </div>
              <div class="artcl-media-stats flx-disp row">
              	    <div class="artcl-date">
                        <ion-icon class="news-tm" name="time-outline"></ion-icon>
                        <span>${newsData[index].newsDate}</span>
                    </div>
                    <div class="artcl-read">
                        <i class="fa-regular fa-eye" data-artclid="${newsData[index].id}" ></i>
                        <span>${newsData[index].read_count ?? 0}</span>
                    </div>
                    <div class="artcl-like">
                        <i class="fa-regular fa-heart media-ico" data-artclid="${newsData[index].id}"></i>
                        <span>${newsData[index].like_count ?? 0}</span>
                    </div>
                    <div class="artcl-share">
                        <i class="fa-regular fa-paper-plane media-ico" data-artclid="${newsData[index].id}"></i>
                        <span>${newsData[index].share_count ?? 0}</span>
                    </div>
              </div>
            </div>
          </div>
        </div>
      </div>`;
  }
  return `
  <div id="last-news" class="shelf-anim margin-rl-1 container-outer pad-20 white-bg bdr-box">
    <div class="section-info">
      <a href="/?p=actuality">
      	<h1>DENYÈ NOUVEL</h1>
      </a>
    </div>
    <div class="container-inner full-w" style="padding-top: 0px;padding-left:0px;padding-right:0px">
    	<div class="articles white-bg bdr-box">
    	${newsList}
        <div id="shareMenu" class="share-menu">
            <a id="shareVK" class="share-item">ВКонтакте</a>
        	<a id="shareTG" class="share-item">Telegram</a>
            <a id="shareWA" class="share-item">WhatsApp</a>
        </div>
        </div>
        <a id='fade-news-link' href="/?p=actuality&id=${newsData[0].id}" style="padding-left: 15px">
          <div class="more-actions beep-anim">
            <span>Wè Plis</span>
            <ion-icon name="arrow-forward-outline"></ion-icon>
          </div>
        </a>
    </div>
  </div>`;
}

function eventsSection(eventsData){
  let eventsList = '';
  for(let index = 0; index < eventsData.length; ++index){
      eventsList += `<div class="event-card">
    <div class="ev-container">
        <img src="${eventsData[index].image_location}" alt="${eventsData[index].title}" class="event-image" />
        <div class="event-content">
            <div class="ticket-info">
                <span>Ticket Price</span>
                <span class="ticket-price">\$${eventsData[index].price}</span>
            </div>
            <a href="/?p=payments&f=event&id=${eventsData[index].id}" class="buy-btn">Buy Ticket</a>
        </div>
    </div>
</div>`;
  }
  return `
  <div id="events-section" class="shelf-anim margin-rl-1 colDir container-outer pad-20 white-bg bdr-box">
          <div id="events-section-bg" class="full-h"></div>
          <div class="section-info">
            <a href="/?p=events"><h1>EVENEMAN</h1></a>
          </div>
          <div id="events-list" class="container-inner">
          	${eventsList}
          </div>
          <a href="/?p=events">
            <div class="more-actions beep-anim">
              <span>Wè Plis</span>
              <ion-icon name="arrow-forward-outline"></ion-icon>
          </div>
          </a>
        </div>`;
}

function middlePanel(content){
    const MAX_MUSIC_CONTENT = 5;
    let count = 0;
    let tracksList = '';
    for(let index = 0; index < content.length; ++index){
        if(count >= MAX_MUSIC_CONTENT){
            break;
        }
        let formattedName = content[index].track_name.replaceAll(" ","_");
        tracksList += `<div class="track"
        id="track-${content[index].id}"
        ${content[index].location.length > 0 && `data-src="${content[index].location}"`  }
        data-trackid="${content[index].id}">
            <div class="track-img">
                <img class="full-w-h" alt="track image" src="${content[index].image_location}" />
            </div>
            <div class="music-info">
                <div class="music-title">${content[index].track_name}</div>
                <div class="music-artist">${content[index].artist_name}</div>
                <div class="player-controls">
                    <div class="play-btn" data-trackid="${content[index].id}">
                        <i class="fas fa-play media-ico play"
                        data-trackid="${content[index].id}"
                        ${content[index].location.length > 0 && `data-src="${content[index].location}"`  }
                        data-tracktitle=${formattedName}></i>
                    </div>
                    <div class="progress-bar">
                        <div class="progress track-${content[index].id}"></div>
                    </div>
                    <div class="music-duration track-${content[index].id}"></div>
                </div>
                <div class="media-actions">
                    <div class="action-btn download-btn">
                        <i class="fas fa-download media-ico" data-trackid="${content[index].id}" data-tracktitle="${formattedName}"></i>
                        <span>${content[index].downloads}</span>
                    </div>
                    <div class="action-btn like-btn">
                        <i class="fa-regular fa-heart media-ico" data-trackid="${content[index].id}" data-tracktitle="${formattedName}"></i>
                        <span>${content[index].likes}</span>
                    </div>
                    <div class="action-btn plays-btn">
                        <ion-icon name="eye-outline" class="media-ico" data-trackid="${content[index].id}" data-tracktitle=${formattedName}></ion-icon>
                        <span>${content[index].plays}</span>
                    </div>
                    <div class="action-btn share-btn">
                        <i class="fa-regular fa-paper-plane media-ico" data-trackid="${content[index].id}"></i>
                        <span>${content[index].share ?? 0}</span>
                    </div>
                </div>
            </div>                                            
        </div>`  
        ++count;
    }
  return `
  <div id="middle-panel" class="shelf-anim margin-rl-1 colDir container-outer pad-20 white-bg bdr-box">
          <div class="section-info">
              <a href="/?p=music">
                <h1>
                  PLEYLIS
                </h1>
              </a>
            </div>
          <div id="music-charts-video" class="flxDisp colDir container-inner">
            <!-- new update: combine charts and videos -->
            
            <div class="media-row-content charts">
              <!-- this space should be automatically filled in JS -->
               <div class="section-info charts-title">
                <h2>TOP CHARTS</h2>
               </div>
              <div class="audio-charts flxDisp">
              	${tracksList}
              </div>
              <a href="/?p=music">
              <div class="more-actions beep-anim">
                <span>Wè Plis</span>
                <ion-icon name="arrow-forward-outline"></ion-icon>
              </div>
              </a>
            </div>
          </div>
          <audio id="audio-player"></audio>
        </div>
        `;
}

function rightPanel(){
  return `
  <div id="right-panel" class="shelf-anim margin-rl-1 container-outer pad-20 white-bg bdr-box">
          <div id="essentials-section">
            <div class="section-info">
              <a href="/?p=actuality"><h1>VIDEYO</h1></a>
            </div>
            <div id="link-portrait-video">
                <div class="vid-container">
                    <div id="rp-vid-container" class="html5-vid"></div>
                </div>
            </div>
          </div>
        </div>`;
}

function servicesPanel(servicesData){
  let servicesList = '';
  for(let index = 0; index < servicesData.length; ++index){
      servicesList += `<div class="serv-container">
        <div class="service-desc">
            <span>${servicesData[index].name}</span>
        </div>
        <div class="service-img">
            <div class="service-img-cont">
                <img alt="service-img" src="${servicesData[index].image_location}"/>
            </div>
        </div>
    </div>`;
  }
  return `
  <div id="services-panel" class="shelf-anim margin-rl-1 container-outer pad-20 white-bg bdr-box">
          <div class="section-info">
            <a href="/?p=services"><h1>SÈVIS</h1></a>
          </div>
          <!-- preparing containers for pasting -->
          <div class='services-container container-inner'>
          	<div id="services-list">
                ${servicesList}
              </div>
              <button class='svc-scroll-btn left' type='button'>
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button class='svc-scroll-btn right' type='button'>
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
          </div>
          <a href="/?p=services">
          <div class="more-actions beep-anim">
            <span>Wè Plis</span>
            <ion-icon name="arrow-forward-outline"></ion-icon>
          </div>
          </a>
        </div>`;
}

export async function partnersPanel(){
      let response = await fetch('/php/dbReader.php?r=partners');
      let partnersData = await response.json();
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
      let slides = "";
      imgUrls.forEach(imgObj => {
        slides += `
        <div class="slide-container">
          <img type="${imgObj.mime_type}" src="${imgObj.src}"/>
        </div>`;

      });

        setTimeout(() => {
            slideContainer()
        }, 350);
    let partnersList = '';
    let i = 0;
    partnersData.forEach(partner => {
        partnersList += `<div class='partner-img-cont ${i < 2 && 'small'}'><img src="${partner.image_location}" ${i == 1 && "style='width: 63%; height: 63%'"}/></div>`;
        ++i;
    })
  return `
<div id="partners-panel" class="shelf-anim margin-rl-1 container-outer pad-20 white-bg bdr-box">
  <div class="section-info">
    <h1>
      PATNÈ NOU YO
    </h1>
  </div>
  <div id="partners-list" class="partners">
  	${partnersList}
  </div>
</div>
<div class="bottom-slide container-outer" style="padding: 0px">${slides}</div>`;
}

function cookieForm(){
    return `
  <div class='cookie-form-contnent'>
    <div class='cookie-msg'>
      Nou pran angajman pou nou respekte vi prive w avèk pèmisyon w, nou itilize COOKIES ak lòt trasè ankò nan lide pou kontwole odyans nou yo, pataje sou rezo sosyal yo, pèsonalize kontni yo ak piblisite pèsonalize sou sèvis nou yo.
      <a class='wht-clr' href='https://www.konektem.net/privacyandlegalinfo'>Politique de confidentialité</a>
    </div>
    <div class='btns'>
      <button type='button' class='wht-bg' id='cookie-allow'>Accept</button>
      <button type='button' class='transp' id='cookie-deny'>Reject</button>
    </div>
  </div>
`;
}

function cookieClickHandler(){
    let form = document.querySelector('.cookie-form');
    if(form){
        let btns = form.querySelectorAll('button');
        if(btns.length > 0){
            btns.forEach( btn => {
                btn.addEventListener('click', () => {
                    form.classList.add('close');
                    setTimeout(() => {
                        document.body.removeChild(form);
                    },500);
                });
            })
        }
    }
}

function whatsappWidget(whatsappData) {
    let countryOptions = '';
    for(let index = 0; index < whatsappData.countryCodes.length; ++index) {
        countryOptions += `<option value="${whatsappData.countryCodes[index].code}" ${whatsappData.countryCodes[index].country === "US" ? 'selected' : ''}>${whatsappData.countryCodes[index].code} (${whatsappData.countryCodes[index].country})</option>`;
    }
    
    return `
    <div class="whatsapp-widget">
        <div class="whatsapp-button" id="whatsappToggle">
            <i class="fab fa-whatsapp"></i>
        </div>
        
        <div class="whatsapp-popup" id="whatsappPopup">
            <div class="whatsapp-header">
                <h3>Contact Us on WhatsApp</h3>
                <button class="close-whatsapp" id="closeWhatsapp">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="whatsapp-content">
                <p>Send us a message directly on WhatsApp. We typically respond within minutes.</p>
                
                <div class="whatsapp-number">
                    <select id="countryCode">
                        ${countryOptions}
                    </select>
                    <input type="text" id="phoneNumber" placeholder="Phone number" value="${whatsappData.phoneNumber}">
                </div>
                
                <div class="whatsapp-actions">
                    <button class="whatsapp-btn whatsapp-primary" id="sendWhatsapp">
                        <i class="fab fa-whatsapp"></i> Send Message
                    </button>
                    <button class="whatsapp-btn whatsapp-secondary" id="cancelWhatsapp">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>`;
}

function initWhatsappWidget() {
    // WhatsApp widget data
    const whatsappData = {
        phoneNumber: "7282143510", // Replace with your WhatsApp number
        welcomeMessage: "Hello! I'm interested in your services.",
        countryCodes: [
            { code: "+1", country: "US" },
            { code: "+44", country: "UK" },
            { code: "+91", country: "IN" },
            { code: "+33", country: "FR" },
            { code: "+49", country: "DE" },
            { code: "+7", country: "RU" }
            // Add more country codes as needed
        ]
    };
    
    // Add the widget to the page
    document.body.insertAdjacentHTML('beforeend', whatsappWidget(whatsappData));
    
    // Get elements
    const whatsappToggle = document.getElementById('whatsappToggle');
    const whatsappPopup = document.getElementById('whatsappPopup');
    const closeWhatsapp = document.getElementById('closeWhatsapp');
    const sendWhatsapp = document.getElementById('sendWhatsapp');
    const cancelWhatsapp = document.getElementById('cancelWhatsapp');
    const countryCode = document.getElementById('countryCode');
    const phoneNumber = document.getElementById('phoneNumber');
    
    // Toggle WhatsApp popup
    if (whatsappToggle) {
        whatsappToggle.addEventListener('click', function() {
            whatsappPopup.style.display = 'flex';
        });
    }
    
    // Close WhatsApp popup
    if (closeWhatsapp) {
        closeWhatsapp.addEventListener('click', function() {
            whatsappPopup.style.display = 'none';
        });
    }
    
    // Cancel button
    if (cancelWhatsapp) {
        cancelWhatsapp.addEventListener('click', function() {
            whatsappPopup.style.display = 'none';
        });
    }
    
    // Send WhatsApp message
    if (sendWhatsapp) {
        sendWhatsapp.addEventListener('click', function() {
            const fullNumber = countryCode.value + phoneNumber.value.replace(/\D/g, '');
            const message = encodeURIComponent(whatsappData.welcomeMessage);
            const whatsappUrl = `https://wa.me/${fullNumber}?text=${message}`;
            
            // Open WhatsApp in a new tab
            window.open(whatsappUrl, '_blank');
            
            // Close the popup
            whatsappPopup.style.display = 'none';
        });
    }
    
    // Auto-open WhatsApp popup after 3 seconds
    /*setTimeout(function() {
        if (whatsappPopup && whatsappPopup.style.display !== 'flex') {
            whatsappPopup.style.display = 'flex';
        }
    }, 3000);*/
}

function slideAnimation(){
  let slideContainer = document.querySelector('#services-list');
  let leftScrollBtn = document.querySelector('.svc-scroll-btn.left')
  let rightScrollBtn = document.querySelector('.svc-scroll-btn.right')
  var direction = 'right';
  let resumeTO = null;
  let scrollDelay = 3000;
  let numScrolls = 4;
    
  if(!slideContainer){
    console.log('container not found');
    return;
  }
  let scrollEdge = slideContainer.scrollWidth - slideContainer.clientWidth;
  let scrollStep = scrollEdge / numScrolls;

  rightScrollBtn.addEventListener('click', ()=>{
    let initDirection = direction;
    direction = 'right';
    BtnScrollHandler(initDirection);
  });
  leftScrollBtn.addEventListener('click', ()=>{
    let initDirection = direction;
    direction = 'left';
    BtnScrollHandler(initDirection);
  });

  let scrollInterval = setInterval( run, scrollDelay);

  function run(){
    if(slideContainer.scrollLeft === scrollEdge) direction = 'left';
    else if(slideContainer.scrollLeft === 0) direction = 'right';
    
    if(direction === 'right') slideContainer.scrollLeft += scrollStep;
    else if(direction === 'left') slideContainer.scrollLeft -= scrollStep;
  }

  function BtnScrollHandler(initDirection){
    clearInterval(scrollInterval);
    clearTimeout(resumeTO);
    slideContainer.scrollLeft += direction === 'right' ? scrollStep : -scrollStep;

    resumeTO = setTimeout(()=>{
      direction = initDirection;
      scrollInterval = setInterval(run, scrollDelay);
    }, 1000);
  }
}

function shelfAnimation(){
    const containerElements = document.querySelectorAll('.shelf-anim');
    containerElements.forEach((container) => {
        container.addEventListener('click', () => {
            containerElements.forEach((cont) => {
                cont.classList.toggle('focus', cont === container);
            });
        });
    });
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.shelf-anim')) {
            containerElements.forEach((cont) => {
                cont.classList.remove('focus');
            });
        }
    });

    window.addEventListener('scroll', () => {
        const scrollPosition = window.scrollY;
        containerElements.forEach((container) => {
            const containerPosition = container.offsetTop;
            const containerHeight = container.offsetHeight;
            const containerBottom = containerPosition + containerHeight;

            /*if(containerBottom < scrollPosition){
                container.classList.remove('focus');
                container.style.opacity = '0.2';
                //container.style.transform = 'translateY(-50px)';
            }*/
            if (scrollPosition + window.innerHeight > containerPosition + 100) {
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';

            }
            else{
                container.classList.remove('focus');
                container.style.opacity = '0.2';
                container.style.transform = 'translateY(50px)';
            }

        });
    })
}
function handleShare(){
    const newsShareIcons = document.querySelectorAll('.artcl-share .media-ico');
    const musicShareIcons = document.querySelectorAll('.share-btn .media-ico');
    const shareMenu = document.getElementById('shareMenu');
    let url = "https://konektem.net/";
    if(newsShareIcons.length > 0 && musicShareIcons.length){
        newsShareIcons.forEach( icon => {
            icon.addEventListener('click', async ()=>{
                if(!icon.dataset.artclid){
                    console.log("no id information about the shared news item");
                    return;
                }
                url += `?p=actuality&id=${icon.dataset.artclid}`;
                share();
            })
        });
        
        musicShareIcons.forEach( icon => {
            icon.addEventListener('click', async ()=>{
                if(!icon.dataset.trackid){
                    console.log("no id information about the shared news item");
                    return;
                }
                url += `?p=music&id=${icon.dataset.trackid}`;
                share();
            })
        })
        document.addEventListener('click', (e) => {
          if (!shareMenu.contains(e.target)) {
            shareMenu.style.display = "none";
          } else {
              console.log(e.target, shareMenu);
          }
        });
        
        async function share(){
            if (navigator.share){
                
                try{
                    await navigator.share({
                        title: document.title,
                        text: 'Konektem news',
                        url: url
                    });
                    return;
                } catch(error){
                    console.log('error while sharing: ' + icon.dataset.artclid, error);
                }
            } else {
                shareMenu.style.display = (shareMenu.style.display === "flex") ? "none" : "flex";
            }
        }

        // Каждая соцсеть
        document.getElementById('shareVK').onclick = () =>
          window.open(`https://vk.com/share.php?url=${encodeURIComponent(location.href)}`);

        document.getElementById('shareTG').onclick = () =>
          window.open(`https://t.me/share/url?url=${encodeURIComponent(location.href)}&text=${encodeURIComponent(document.title)}`);

        document.getElementById('shareWA').onclick = () =>
          window.open(`https://wa.me/?text=${encodeURIComponent(location.href)}`);
    } else {
        console.log("no share icons found");
    }
}

function pageInnerStyle(){
    return `.cookie-form{
  position: fixed;
  margin: auto;
  max-height: fit-content;
  background-color: #05152e;
  color: white;
  transition: max-height 0.5s ease-in-out, transform 0.5s ease-in-out;
  text-align: center;
  bottom: 0%;
  overflow: hidden;
  z-index: 10;
  box-sizing: border-box;
}
.cookie-form-contnent{
  padding: 10px;
}
.wht-clr{
  color: white;
}

.cookie-form .btns{
  display: flex;
  flex-direction: column;
  padding: 5px;
  gap: 10px;
  margin-top: 10px;
}
.cookie-form.close{
  transform: scale(0);
}


.cookie-form .btns button{
  color: white;
  height: 2rem;
}
.cookie-form .wht-bg{
  background-color: white;
  color: #05152e !important;
}
.transp{
  background-color: transparent;
}
.svc-scroll-btn{
  width: 45px;
  height: 100%;
  position: absolute;
  top: 0;
  background: transparent;
  border: none;
}
.svc-scroll-btn.left{
  left: 0px;
}
.svc-scroll-btn.right{
  right: 0px;
}
`;
}

let styles = ["/experimental/CSS/mobileStyle.css",
  "/experimental/CSS/globalStyle.css",
  "/experimental/CSS/sectionsStyle.css",
  "/experimental/CSS/desktop.css",
  "/CSS/bottomScrollstyle.css",
  "/experimental/CSS/customWindows.css"
             ]

let scripts = [
  {
    type : "module",
    src : "/experimental/JS/mainDOMEventListener_1.js"
  }
]

export default function Index(resourcesLoaded){
  let title = document.querySelector("title");
  if(!title){
      title = document.createElemnt("title");
      document.head.insertAdjacentElement("afterbegin", title);
  }
  title.textContent = "Konetkem";
  let root = document.querySelector("#root");
  let rootStyleTag = document.querySelector('#root-style');

  if( !resourcesLoaded ){
      for(const src of styles){
        let linkTag = document.createElement("link");
        linkTag.rel = "stylesheet";
        linkTag.type = "text/css";
        linkTag.href = src;
        document.head.appendChild(linkTag);
      }

      for( const script of scripts ){
        let scriptTag = document.createElement("script");
        scriptTag.type = script.type;
        scriptTag.src = script.src;
        document.head.appendChild(scriptTag);
      }
      if(rootStyleTag){
          rootStyleTag.innerHTML += pageInnerStyle();
      }
  }
  

  if(!root){
    console.log("Index: content container not found");
    return;
  }
  setTimeout( async () => {
      let response = await fetch('/php/dbReader.php?r=news');
      let newsData = await response.json();
      response = await fetch('/php/dbReader.php?r=musicContent');
      let musicData = await response.json();
      response = await fetch('/php/dbReader.php?r=services');
      let servicesData = await response.json();
      response = await fetch('/php/dbReader.php?r=events');
      let eventsData = await response.json();
      
      let content = ( head(newsData) + lastNews(newsData) + 
                         middlePanel(musicData) + eventsSection(eventsData) + rightPanel() +
                         servicesPanel(servicesData) + await partnersPanel());
      root.innerHTML = content;
      setTimeout( () => {
          if(!window.currentUser || window.currentUser === 'guest'){
              let div = document.createElement('div');
              div.classList.add('cookie-form');
              div.innerHTML += cookieForm();
              root.parentElement.appendChild(div);
              cookieClickHandler();
          } else {
              console.log("cookie form not rendered: " + window.currentUser )
          }
          
          slideAnimation();
          handleShare();
          initWhatsappWidget();
          shelfAnimation();
      }, 2000)
  }, 200);
}
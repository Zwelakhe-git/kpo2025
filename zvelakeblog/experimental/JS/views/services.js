import {partnersPanel} from './index.js';

function serviceCards(servicesData){
  let content = '';
  servicesData.forEach( service => {
    content += `
    <div
      class="bg-white rounded-2xl shadow hover:shadow-lg transition-all duration-300 overflow-hidden"
    ><div class="service-img-cont">
      <img class="service-img"
        src="${service.image_location}"
        alt="Brand Identity"
        class="w-full object-cover"
      />
      </div>
      <div class="p-5">
        <h2 class="text-lg font-semibold mb-1">${service.name}</h2>
        <p class="text-sm text-purple-600 mb-2">By ...</p>

        <div class="flex justify-between items-center mt-4">
          <span class="text-xl font-bold text-purple-600">\$</span>
          <button id="service-${service.id}"
            class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition"
          >
            Learn More
          </button>
        </div>
      </div>
    </div>`
  });
  return content;
}

async function servicesSection(){
  return fetch('/php/dbReader.php?r=services')
  .then(response => response.json())
  .then( async (data) => {
    return `
    <section class="min-h-screen px-4 py-10">
      <h1 class="text-3xl md:text-5xl font-bold text-center mb-10">
        Eksplore Sevis
      </h1>

      <div
        class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 max-w-7xl mx-auto"
      >${serviceCards(data)}
      </div>
      ${konektemWorks()}
      <br/>
      
    </section>`
  }).catch( error => {
    console.log('services: ' + error.message);
  })
  ;
}

function konektemWorks(){
    let worksData = [
        
    ];
    for(let i = 0; i < 12; ++i){
        if( i === 8 ) continue;
        let ext = '';
        if(i == 0 || i === 1 || i === 2 || i === 4){
            ext = 'jpg';
        } else { ext = 'png'; }
        worksData[i] = `/media/images/pictures/m${i+1}.${ext}`;
    }
    let images = ``;
    worksData.forEach( work => {
        images += `<div class='works-l1'>
        	<div class='works-img-container'>
            	<img type='image/png' src='${work}'/>
            </div>
        </div>`
    });
    let content = `<div class='works-container'>
    <div class='section-title'>
    	<h1>Travay Nou Yo</h1>
    </div>
    <div class='works-list'>
    ${images}
    </div>
    </div>`;
    return content;
}
function addInlineStyles(){
    let styleTag = document.head.querySelector('#root-style');
    if(!styleTag){
        console.log("services: style tag not found");
        return;
    }
    let styles = `
    @media (max-width: 480px){
    	.works-l1{
        	width: 90px;
        }
    }
    @media (min-width: 480px){
    	.works-l1{
        	width: 160px;
        }
        .works-container {
            width: 100%;
        }
    }
    @media (min-width: 768px){
    	.works-container {
            width: 80%;
            margin: auto;
            margin-top: 20px;
        }
    	.works-l1{
        	width: 256px;
        }
    }
    .works-container{
    margin-top: 15px;
    }
    .section-info{
        width: 95% !important;
        margin: auto;
    }
    .section-title{
    	margin-bottom: 15px;
        font-size: 27px;
        text-align: center;
    }
    .works-list {
        display: flex;
        flex-direction: row;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        width: 90%;
        margin: auto;
    }
    .works-l1{
    	flex: 0 0 auto;
    }
    .works-l1 img{
    	width: 100%;
        height: 100%;
    }
    
    .duration-300{
    	padding: 20px;
    }
    .service-img-cont{
    	height: 167px;
    }
    .service-img{
    	height: 100%;
    }
    `;
    
    styleTag.innerHTML = styles;
    
}

const scripts = [
    {
        type: "",
        src: "https://cdn.tailwindcss.com"
    }
]

const styles = [
    "/experimental/CSS/sectionsStyle.css",
    "/experimental/CSS/partners.css",
    "/CSS/bottomScrollstyle.css"
];
const pageTitle = 'Sevis nou yo';

export default function servicesPage(){
    scripts.forEach( script => {
        let scriptTag = document.createElement("script");
        script.type && (scriptTag.type = script.type);
        scriptTag.src = script.src;
        document.head.appendChild(scriptTag);
    })
    
    styles.forEach( style => {
        let linkTag = document.createElement("link");
        linkTag.rel = 'stylesheet';
        linkTag.type = 'text/css';
        linkTag.href = style;
        document.head.appendChild(linkTag);
    })

    let title = document.querySelector("title");
    if(!title){
        title = document.createElemnt("title");
        document.head.insertAdjacentElement("afterbegin", title);
    }
    title.textContent = pageTitle;
    addInlineStyles();
    document.body.classList.add('bg-gray-50','text-gray-900'); 
    let root = document.querySelector("#root");
    if(!root){
      console.log("Events: root element not found");
      return;
    }

    servicesSection()
    .then( async (content) => {
        content += await partnersPanel();
        setTimeout( ()=>{
            root.innerHTML = content;
        },600);
    }) 
}
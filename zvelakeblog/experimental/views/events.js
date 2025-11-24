
function eventCards(eventsData){
  let content = '';
  eventsData.forEach( event => {
    content += `
    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden"
    style="width: 70%; margin: auto">
    <div class='evnt-img-container'>
        <img
          src="${event.image_location}"
          alt="Bandana Party"
          class="h-48 w-full"
        />
    </div>
    <div class="p-5">
      <div class="flex justify-between text-sm text-gray-500 mb-3">
        <span><i class="fa-regular fa-calendar-days mr-1"></i>${event.eventDate}</span>
        <span><i class="fa-regular fa-clock mr-1"></i></span>
        <span><i class="fa-regular fa-clock mr-1"></i></span>
      </div>
      <p class="text-purple-600 text-sm font-medium mb-1">${event.host ?? "unknown host"}</p>
      <h2 class="text-lg font-semibold mb-2">${event.title}</h2>
      <p class="text-gray-600 text-sm mb-4">${event.location}</p>
      <div class="flex justify-between items-center">
        <span class="text-purple-600 font-bold">\$${event.price}</span>
        <a href="/?p=payments&f=event&id=${event.id}"><button
          class="bg-purple-600 text-white px-3 py-2 rounded-lg hover:bg-purple-700 transition"
        >
          Peye
        </button></a>
      </div>
    </div>
  </div>`
  });
  return content;
}

async function eventsSection(){
  return fetch('/php/dbReader.php?r=events')
  .then(response => response.json())
  .then( data => {
    return `
    <section class="min-h-screen px-4 py-10">
      <h1 class="text-3xl md:text-5xl font-bold text-center mb-10">
        Eksplore eveneman
      </h1>

      <!-- Filter Tabs -->
      <div class="flex justify-center mb-8 gap-4 flex-wrap">
        <button class="px-5 py-2 rounded-full bg-purple-600 text-white font-semibold hover:bg-purple-700 transition">All</button>
       
      
      </div>

      <!-- Events Grid -->
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 max-w-7xl mx-auto">
      ${eventCards(data)}
      </div>
    </section>`
  }).catch( error => {
    console.log('events: ' + error.message);
  })
  ;
}

const scripts = [
  {
    type: "",
    src: "https://cdn.tailwindcss.com"
  }
]
const pageTitle = 'Eveneman kap vini';

export default function eventsPage(){
  scripts.forEach( script => {
    let scriptTag = document.createElement("script");
    script.type && (scriptTag.type = script.type);
    scriptTag.src = script.src;
    document.head.appendChild(scriptTag);
  })
  
  let title = document.querySelector("title");
  document.body.classList.add
  if(!title){
      title = document.createElemnt("title");
      document.head.insertAdjacentElement("afterbegin", title);
  }
  title.textContent = pageTitle;
  let root = document.querySelector("#root");
  if(!root){
    console.log("Events: root element not found");
    return;
  }

  eventsSection()
  .then( content => {
    setTimeout( ()=>{
        root.innerHTML = content;
    },500);
  }) 
}
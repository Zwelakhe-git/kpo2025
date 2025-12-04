const max_slide_news= 10;

const newsCategories = [
    {
        name: "technology",
        content: `<section id="technology" class="news-section">
                    <div class="section-header">
                        <h2 class="section-title">Технология</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="news-grid">
                    `
    },
    {
        name: "business",
        content: `<section id="business" class="news-section">
                    <div class="section-header">
                        <h2 class="section-title">Бизнес</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="news-grid">
                    `
    },
    {
        name: "politics",
        content: `<section id="politics" class="news-section">
                    <div class="section-header">
                        <h2 class="section-title">Политика</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="news-grid">
                    `
    },
    {
        name: "entertainment",
        content: `<section id="entertainment" class="news-section">
                    <div class="section-header">
                        <h2 class="section-title">Развлечение</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="news-grid">
                    `
    },
    {
        name: "sports",
        content: `<section id="sports" class="news-section">
                    <div class="section-header">
                        <h2 class="section-title">Спорт</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="news-grid">
                    `
    },
    {
        name: "health",
        content: `<section id="health" class="news-section">
                    <div class="section-header">
                        <h2 class="section-title">Здравоохранение</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="news-grid">
                    `
    },
    {
        name: "science",
        content: `<section id="science" class="news-section">
                    <div class="section-header">
                        <h2 class="section-title">Наука</h2>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="news-grid">
                    `
    }
];
// do not edit this function
// function actualityHtml(newsContent){
//     let result = `<div class='container' id='current-news-root'></div>
//     <div class="container all-N">
//     <div class="breaking-news">
//         <h2><i class="fas fa-bolt"></i> BREAKING NEWS</h2>
//         <a href='#'><p class='wht-clr'>TOP STORY</p></a>
//     </div>

//     <div class="section-nav">
//         <div class="container">
//             <ul>
//                 <li><a href="#politics" class="active">Политика</a></li>
//                 <li><a href="#business">Бизнес</a></li>
//                 <li><a href="#technology">Технология</a></li>
//                 <li><a href="#sports">Спорт</a></li>
//                 <li><a href="#entertainment">Развлечение</a></li>
//                 <li><a href="#health">Здравоохранение</a></li>
//                 <li><a href="#science">Наука</a></li>
//             </ul>
//         </div>
//     </div>
//     ${newsContent}
//     </div>`;
    
//     return result; 
// }

function combineContentWithTemplate(newsData){
    let newsContent = groupNewsByCategory(newsData);
    return `<div class='container' id='current-news-root'></div>
    <div class="container all-N">
    <div class="breaking-news">
        <h2><i class="fas fa-bolt"></i> BREAKING NEWS</h2>
        <a href='#'><p class='wht-clr'>TOP STORY</p></a>
    </div>

    <div class="section-nav">
        <div class="container">
            <ul>
                <li><a href="#politics" class="active">Политика</a></li>
                <li><a href="#business">Бизнес</a></li>
                <li><a href="#technology">Технология</a></li>
                <li><a href="#sports">Спорт</a></li>
                <li><a href="#entertainment">Развлечение</a></li>
                <li><a href="#health">Здравоохранение</a></li>
                <li><a href="#science">Наука</a></li>
            </ul>
        </div>
    </div>
    ${newsContent}
    </div>`;
}

function groupNewsByCategory(newsData){
    let result = '';
    
    newsData.forEach( item => {
        switch(item.source){
            case 'local':
                getLocalNewsContent(item.content);
                break;
            case 'api':
                getApiNewsContent(item.content);
                break;
            default:
                result += getLocalNewsContent(item.content);
        }
    });
    
    newsCategories.forEach(category => {
        category.content += `</div>
                    </section>`
        result += category.content;
    });
    return result;
}

function getLocalNewsContent(newsData){
    for(let i = 0; i < newsData.length; ++i){
        let newsCard = `<div class="news-card" id="${newsData[i].id}">
                <div class="news-img">
                    <img src="${newsData[i].image_location}" alt="news image">
                </div>
                <div class="news-content">
                    <div class="news-date">${newsData[i].newsDate}</div>
                    <div class="news-meta-info">
                        <span class="news-author">author: ${newsData[i].author ?? ''}</span>
                    </div>
                    <h3 class="news-title">${newsData[i].newsTitle}</h3>
                    <p class="news-excerpt">${newsData[i].newsHeadline}</p>
                    <div class="full-content">
                        <p>${newsData[i].fullContent}</p>
                    </div>
                    <a class="read-more" data-state="more">читать дальше <i class="fas fa-chevron-down"></i></a>
                </div>
            </div>`;
        	for(let j = 0; j < newsCategories.length; ++j){
                let category = newsCategories[j];
                if(newsData[i].newsCategory == category.name){
                    category.content += newsCard;
                    break;
                }
            }
    }
}

function getApiNewsContent(newsData){
    for(let i = 0; i < newsData.length; ++i){
        let newsCard = `<div class="news-card" id="api-${i}">
                <div class="news-img">
                    <img src="${newsData[i].urlToImage}" alt="news image">
                </div>
                <div class="news-content">
                    <div class="news-date">${new Date(newsData[i].publishedAt).toLocaleDateString()}</div>
                    <h3 class="news-title" data-newsid="api-${i}">${newsData[i].title}</h3>
                    <p class="news-author" style="
                        font-size: 12px;
                        color: #555;
                        margin-bottom: 8px;
                    ">Автор: ${newsData[i].author ?? 'Неизвестен'}</p>
                    <p class="news-source-name" style="
                        font-size: 12px;
                        color: #555;
                        margin-bottom: 8px;
                    ">Источник: ${newsData[i].source.name}</p>
                    <a class="news-source" href="${newsData[i].url}" target="_blank" style="
                        font-size: 12px;
                        color: #0c3ab9ff;
                        text-decoration: underline;
                    ">Источник</a>
                    <p class="news-excerpt">${newsData[i].description}</p>
                    <div class="full-content">
                        <p>${newsData[i].content ?? ''}</p>
                    </div>
                    <a class="read-more" data-state="more">читать дальше <i class="fas fa-chevron-down"></i></a>
                </div>
            </div>`;
        	for(let j = 0; j < newsCategories.length; ++j){
                let category = newsCategories[j];
                if(newsData[i].category == category.name){
                    category.content += newsCard;
                    break;
                }
            }
    }
}


function showMainNewsContent(newsId){
    let container = document.querySelector('#root');
    let allNewsContainer = document.querySelector('.all-N');
    if(!container){
        console.log('container not found');
        return;
    }
    
    let newsData = globNewsData.find(itm => itm.id == Number(newsId));
    let paragraphs = '';
        newsData.fullContent.split('\n').forEach(p => {
            if(p.trim().length > 0) paragraphs += `<p>${p}</p>`;
        });
    let content = `<div class='container main-news' style='color: black'>
                <div class="news-content">
                	<h3 class="news-title" data-newsid=${newsData.id} style="
                            color: black;
                            text-align: center;
                            font-size: 20px;
                        ">${newsData.newsTitle}</h3>
                	<div class="news-img" style="
                            margin-bottom: 10px;
                            border-radius: 8px;
                        ">
                        <img src="${newsData.image_location}" alt="Politics news">
                    </div>
                	<div class="news-date">${newsData.newsDate}</div>
                    <p class="news-excerpt" style="color: inherit;
                        max-height: fit-content;
                        ">${newsData.newsHeadline}</p>
                    <div class="main-Ncontent">
                    ${paragraphs}
                    </div>
                </div>
                </div>`;
    container.innerHTML = content;
}

function newsPageContentHandler(event){
    let n_id = event.CurrentTarget.dataset.newsid;
    showMainNewsContent(n_id);
}

function actualityPageStyle(){
    let styleTag = document.querySelector("#root-style");
    if(!styleTag){
        console.log("actualityPageStyle: style tag not found");
        return;
    }
    styleTag.innerHTML = `
/* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
}

html, body, #root {
    width: 100%;
    font-family: Roboto, Arial, sans-serif;
    margin: 0;
    background: whitesmoke;
}

body {
    background-color: #f8f9fa;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.flxDisp {
    display: flex;
}

.full-h {
    height: 100%;
}

.close-nav {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 22px;
    cursor: pointer;
}

/* News Portal Styles */
.section-nav {
    background-color: white;
    padding: 12px 0;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 8;
}

.section-nav ul {
    display: flex;
    justify-content: center;
    list-style: none;
    flex-wrap: wrap;
}

.section-nav ul li {
    margin: 4px 8px;
}

.section-nav ul li a {
    text-decoration: none;
    color: #2b6cb0;
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 20px;
    transition: all 0.3s;
    font-size: 14px;
}

.section-nav ul li a:hover,
.section-nav ul li a.active {
    background-color: #2b6cb0;
    color: white;
}

.news-section {
    margin-bottom: 30px;
    padding: 15px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid #eaeaea;
}

.section-title {
    font-size: 18px;
    color: #1a4b8c;
}

.view-all {
    color: #2b6cb0;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
}

.news-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

.news-card {
    background: white;
    border-radius: 6px;
    overflow: hidden;
    transition: transform 0.3s;
    box-shadow: 0 2px 8px #0000001a;
}

.news-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.news-img {
    height: 160px;
    overflow: hidden;
}

.news-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.news-card:hover .news-img img {
    transform: scale(1.05);
}

.news-content {
    padding: 15px;
    position: relative;
}

.news-date {
    color: #666;
    font-size: 12px;
    margin-bottom: 8px;
}

.news-title {
    font-size: 16px;
    margin-bottom: 8px;
    color: #333;
    line-height: 1.4;
}

.news-excerpt {
    color: #666;
    margin-bottom: 12px;
    max-height: 50px;
    overflow: hidden;
    transition: max-height 0.5s ease;
    font-size: 14px;
    line-height: 1.4;
}

.news-excerpt.expanded {
    max-height: 400px;
}

.read-more {
    display: inline-block;
    color: #2b6cb0;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    margin-top: 8px;
    font-size: 14px;
}

.read-more:hover {
    text-decoration: underline;
}
.main-Ncontent{
	font-size: 14px;
    color: black;
}
.main-news p{
	margin-bottom: 8px;
    font-size: 16px;
}
.full-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease;
    color: #444;
    font-size: 14px;
}

.full-content.expanded {
    max-height: 800px;
}

.breaking-news {
    background-color: #ec0505bb;
    color: white;
    padding: 12px;
    margin-top: 20px;
    margin-bottom: 20px;
    border-radius: 6px;
}

.breaking-news h2 {
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    font-size: 16px;
}

.breaking-news h2 i {
    margin-right: 8px;
}

.breaking-news p {
    font-size: 14px;
    line-height: 1.4;
}

/* Desktop Layout */
@media (min-width: 480px){
	.main-news .news-img{
    	height: 350px;
    }
    .main-news.container{
    	width: 80%;
    }
}

@media (max-width: 480px){
	.main-news .news-img{
    	height: 180px;
    }
}
@media (min-width: 768px) {
    .main-news .container{
            width: 80%;
        }
    .container {
        padding: 0 20px;
    }

    .section-nav {
        padding: 15px 0;
    }

    .section-nav ul li a {
        padding: 8px 15px;
        font-size: 16px;
    }

    .news-section {
        padding: 20px;
        margin-bottom: 40px;
    }

    .section-header {
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 22px;
    }

    .view-all {
        font-size: 16px;
    }

    .news-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .news-img {
        height: 180px;
    }

    .news-content {
        padding: 20px;
    }

    .news-date {
        font-size: 14px;
    }

    .news-title {
        font-size: 18px;
    }

    .news-excerpt {
        font-size: 15px;
    }

    .read-more {
        font-size: 15px;
    }

    .breaking-news {
        padding: 15px;
    }

    .breaking-news h2 {
        font-size: 18px;
    }

    .breaking-news p {
        font-size: 16px;
    }
}

/* Large Desktop */
@media (min-width: 1024px) {
    .news-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}`;

}


function actualityPageScript(){
    // Smooth scrolling for section navigation
    document.querySelectorAll('.section-nav a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            window.scrollTo({
                top: targetSection.offsetTop - 70,
                behavior: 'smooth'
            });
            
            // Update active class
            document.querySelectorAll('.section-nav a').forEach(a => a.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Update active nav link based on scroll position
    window.addEventListener('scroll', function() {
        const sections = document.querySelectorAll('.news-section');
        const navLinks = document.querySelectorAll('.section-nav a');
        
        let currentSection = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            
            if (pageYOffset >= (sectionTop - 100)) {
                currentSection = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + currentSection) {
                link.classList.add('active');
            }
        });
    });
    
    // Read More functionality
    document.querySelectorAll('.read-more').forEach(button => {
        button.addEventListener('click', function() {
            const fullContent = this.previousElementSibling;
            const excerpt = fullContent.previousElementSibling;
            
            if (this.getAttribute('data-state') === 'more') {
                // Expand content
                fullContent.classList.add('expanded');
                excerpt.classList.add('expanded');
                this.innerHTML = 'читать меньше <i class="fas fa-chevron-up"></i>';
                this.setAttribute('data-state', 'less');
            } else {
                // Collapse content
                fullContent.classList.remove('expanded');
                excerpt.classList.remove('expanded');
                this.innerHTML = 'читать дальше <i class="fas fa-chevron-down"></i>';
                this.setAttribute('data-state', 'more');
            }
        });
    });
}

var globNewsData = [];

export default function actuality(){
    let title = document.querySelector("title");
      if(!title){
          title = document.createElemnt("title");
          document.head.insertAdjacentElement("afterbegin", title);
      }
      title.textContent = "Medihub - Новости";
    
    let root = document.querySelector("#root");
    if(!root){
        console.log("actuality: root element not found");
        return;
    }
    actualityPageStyle();
    
    setTimeout( async () => {
        const [localNewsResponse, globalNewsResponse] = await Promise.all([
            fetch('/php/dbReader.php?r=news&source=local'),
            fetch('/php/dbReader.php?r=news&source=api')
        ]);
        const [localNewsData, globalNewsData] = await Promise.all([
            localNewsResponse.json(),
            globalNewsResponse.json()
        ]);

        const newsData = [
            {source: 'local', content: localNewsData},
            {source: 'api', content: globalNewsData}
        ];

        root.innerHTML = combineContentWithTemplate(newsData);
        actualityPageScript();
        const searchParams = new URLSearchParams(window.location.search);
        let url = new URL(window.location.href);
        let hash = url.hash;
        if(searchParams.get("id")){
            let n_id = hash.substr(1);
            showMainNewsContent(searchParams.get("id"));
            /*
            let targetitem = document.createElement("a");
            targetitem.href = hash;
            document.body.appendChild(targetitem);
            targetitem.click();
            document.body.removeChild(targetitem);
            */
        }
        //root.innerHTML = actualityHtml();
        
    },200);
}
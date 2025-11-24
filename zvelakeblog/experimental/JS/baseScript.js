import Index from './views/index.js';
import actuality from './views/actualityPage.js';
import musicAndVids from './views/musicPage.js';
import streaming from './views/streamingPage.js';
import emailSubPage from './views/emailSubPage.js';
import servicesPage from './views/services.js'; 
import eventsPage from './views/events.js';
import {profLinkClickHandle} from '/account/profile.js';
import  contactsPage from './views/contactsPage.js';
import ticketFormPage from './views/ticketForm.js';

function setTopBar(){
    let optsIcon = document.querySelector(".opts-icon");
    if(!optsIcon){
        console.log("Options icon not found");
        return;
    }

    optsIcon.addEventListener("click", event => {
      const navPanel = document.querySelector("#nav-panel");
        if( !navPanel ){
            console.log("nav-panel not found");
            return;
        }

        navPanel.classList.toggle("open");
        if(navPanel.classList.contains("open")){
            navPanel.style.display = "block";
            navPanel.style.maxHeight = `${navPanel.scrollHeight}px`;
        }
        else{
            navPanel.style.maxHeight = "0px";
            setTimeout(() => {
                navPanel.style.display = "none";
            }, 350);
        }
    });
    
    return;
}

function footer(){
  let footerEl = document.createElement("footer");
  footerEl.id = "footer";
  footerEl.innerHTML = `
  <footer id="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Konsenan KonektemNews</h3>
                    <p>N ap bay nouvèl ki egzak ak alè soti toupatou nan mond lan. Misyon nou se enfòme, edike, epi angaje lektè nou yo.</p>
                </div>
                <div class="footer-section">
                    <h3>Kategori</h3>
                    <ul>
                        <li><a href="#">Politik</a></li>
                        <li><a href="#">Biznis</a></li>
                        <li><a href="#">Teknoloji</a></li>
                        <li><a href="#">Spo</a></li>
                        <li><a href="#">Divetisman</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Konekte m</h3>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/Konektempageofficielle?mibextid=LQQJ4d"><i class="fab fa-facebook"></i></a>
                        <a href="https://x.com/konektemtv?s=21"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/konektem?igsh=MTBsdWQ0dXl4ZXY5Mg=="><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Abòne ak Bilten Nouvel la</h3>
                    <p>Rete enfòme ak dènye nouvèl ak istwa nou yo lè ou abòne ak bilten enfòmasyon nou an.</p>
                    <form>
                        <input type="email" placeholder="konektemtv@gmail.com" style="padding:10px; width:100%; margin-top:10px; border-radius:4px; border:none;">
                        <button type="submit" style="background:#ffcc00; color:#1a4b8c; border:none; padding:10px 15px; margin-top:10px; border-radius:4px; font-weight:bold; cursor:pointer;">Abone</button>
                    </form>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 KonektemNews. All rights reserved.</p>
            </div>
        </div>
    </footer>`;

    document.body.insertAdjacentElement("beforeend", footerEl);
}

// Mobile navigation functionality
function initMobileNavigation() {
    const navLinks = document.querySelectorAll('#nav-panel .nav-link');
    const navPanel = document.querySelector('#nav-panel');
    
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            // For internal navigation links, close the panel after click
            if (link.getAttribute('href') && link.getAttribute('href') !== '#') {
                if (navPanel.classList.contains('open')) {
                    navPanel.classList.remove('open');
                    navPanel.style.maxHeight = '0px';
                    setTimeout(() => {
                        navPanel.style.display = 'none';
                    }, 350);
                }
            }
            
            // Handle profile link separately
            if (link.id === 'prof-link') {
                e.preventDefault();
                // Profile link handling is done in profLinkClickHandle
                return;
            }
        });
    });
}

// Search functionality
function initSearchFunctionality() {
    const searchInput = document.getElementById('tb-inp-el');
    const searchButton = document.querySelector('.fa-magnifying-glass');
    const navSearchLink = document.getElementById('nav-search-link');
    
    // Top bar search functionality
    if (searchInput && searchButton) {
        searchButton.addEventListener('click', performSearch);
        
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }
    
    // Navigation panel search link functionality
    if (navSearchLink) {
        navSearchLink.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Close mobile navigation panel if open
            const navPanel = document.querySelector('#nav-panel');
            if (navPanel && navPanel.classList.contains('open')) {
                navPanel.classList.remove('open');
                navPanel.style.maxHeight = '0px';
                setTimeout(() => {
                    navPanel.style.display = 'none';
                }, 350);
            }
            
            // Focus on search input
            if (searchInput) {
                searchInput.focus();
                // Scroll to top to ensure search input is visible
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }
}

function performSearch() {
    const searchInput = document.getElementById('tb-inp-el');
    if (!searchInput) return;
    
    const searchTerm = searchInput.value.trim();
    
    if (searchTerm === '') {
        alert('Please enter a search term');
        return;
    }
    
    // Show loading state
    const root = document.getElementById('root');
    if (root) {
        root.innerHTML = `
            <div class="search-results-container">
                <div class="search-loading">
                    Searching for "${searchTerm}"...
                </div>
            </div>
        `;
    }
    
    const currentPage = new URLSearchParams(window.location.search).get('p') || 'index';
    
    switch(currentPage) {
        case 'actuality':
            searchNews(searchTerm);
            break;
        case 'music':
            searchMusic(searchTerm);
            break;
        case 'events':
            searchEvents(searchTerm);
            break;
        default:
            searchAllContent(searchTerm);
            break;
    }
}

async function searchNews(searchTerm) {
    try {
        const response = await fetch(`/php/dbReader.php?r=news`);
        const newsData = await response.json();
        
        const filteredNews = newsData.filter(news => 
            news.newsTitle.toLowerCase().includes(searchTerm.toLowerCase()) ||
            news.newsHeadline.toLowerCase().includes(searchTerm.toLowerCase()) ||
            (news.fullContent && news.fullContent.toLowerCase().includes(searchTerm.toLowerCase()))
        );
        
        displaySearchResults(filteredNews, 'news', searchTerm);
    } catch (error) {
        console.error('Search error:', error);
        alert('Error performing search');
    }
}

async function searchMusic(searchTerm) {
    try {
        const response = await fetch(`/php/dbReader.php?r=musicContent`);
        const musicData = await response.json();
        
        const filteredMusic = musicData.filter(track => 
            track.track_name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            track.artist_name.toLowerCase().includes(searchTerm.toLowerCase())
        );
        
        displaySearchResults(filteredMusic, 'music', searchTerm);
    } catch (error) {
        console.error('Search error:', error);
        alert('Error performing search');
    }
}

async function searchEvents(searchTerm) {
    try {
        const response = await fetch(`/php/dbReader.php?r=events`);
        const eventsData = await response.json();
        
        const filteredEvents = eventsData.filter(event => 
            event.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
            event.location.toLowerCase().includes(searchTerm.toLowerCase()) ||
            (event.host && event.host.toLowerCase().includes(searchTerm.toLowerCase()))
        );
        
        displaySearchResults(filteredEvents, 'events', searchTerm);
    } catch (error) {
        console.error('Search error:', error);
        alert('Error performing search');
    }
}

async function searchAllContent(searchTerm) {
    try {
        const [newsResponse, musicResponse, eventsResponse] = await Promise.all([
            fetch(`/php/dbReader.php?r=news`),
            fetch(`/php/dbReader.php?r=musicContent`),
            fetch(`/php/dbReader.php?r=events`)
        ]);
        
        const [newsData, musicData, eventsData] = await Promise.all([
            newsResponse.json(),
            musicResponse.json(),
            eventsResponse.json()
        ]);
        
        const allResults = {
            news: newsData.filter(news => 
                news.newsTitle.toLowerCase().includes(searchTerm.toLowerCase()) ||
                news.newsHeadline.toLowerCase().includes(searchTerm.toLowerCase())
            ),
            music: musicData.filter(track => 
                track.track_name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                track.artist_name.toLowerCase().includes(searchTerm.toLowerCase())
            ),
            events: eventsData.filter(event => 
                event.title.toLowerCase().includes(searchTerm.toLowerCase()) ||
                event.location.toLowerCase().includes(searchTerm.toLowerCase())
            )
        };
        
        displayCombinedSearchResults(allResults, searchTerm);
    } catch (error) {
        console.error('Search error:', error);
        alert('Error performing search');
    }
}

function displaySearchResults(results, contentType, searchTerm) {
    const root = document.getElementById('root');
    if (!root) return;
    
    let resultsHTML = '';
    
    switch(contentType) {
        case 'news':
            resultsHTML = generateNewsResultsHTML(results);
            break;
        case 'music':
            resultsHTML = generateMusicResultsHTML(results);
            break;
        case 'events':
            resultsHTML = generateEventsResultsHTML(results);
            break;
    }
    
    root.innerHTML = `
        <div class="search-results-container">
            <div class="search-results-header">
                <h2>Search Results for "${searchTerm}" <span class="results-count">${results.length} found</span></h2>
                <button class="close-search-btn" id="close-search-results">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            ${resultsHTML}
            ${results.length === 0 ? `
                <div class="no-results">
                    <p>No results found for "${searchTerm}"</p>
                    <p>Try different keywords or browse our categories.</p>
                </div>
            ` : ''}
        </div>
    `;
    
    // Add event listener for close button
    const closeBtn = document.getElementById('close-search-results');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeSearchResults);
    }
}

function displayCombinedSearchResults(results, searchTerm) {
    const root = document.getElementById('root');
    if (!root) return;
    
    const totalResults = results.news.length + results.music.length + results.events.length;
    
    root.innerHTML = `
        <div class="search-results-container">
            <div class="search-results-header">
                <h2>Search Results for "${searchTerm}" <span class="results-count">${totalResults} found</span></h2>
                <button class="close-search-btn" id="close-search-results">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            
            ${results.news.length > 0 ? `
                <div class="results-section">
                    <h3>News <span class="results-count">${results.news.length}</span></h3>
                    ${generateNewsResultsHTML(results.news)}
                </div>
            ` : ''}
            
            ${results.music.length > 0 ? `
                <div class="results-section">
                    <h3>Music <span class="results-count">${results.music.length}</span></h3>
                    ${generateMusicResultsHTML(results.music)}
                </div>
            ` : ''}
            
            ${results.events.length > 0 ? `
                <div class="results-section">
                    <h3>Events <span class="results-count">${results.events.length}</span></h3>
                    ${generateEventsResultsHTML(results.events)}
                </div>
            ` : ''}
            
            ${totalResults === 0 ? `
                <div class="no-results">
                    <p>No results found for "${searchTerm}"</p>
                    <p>Try different keywords or browse our categories.</p>
                </div>
            ` : ''}
        </div>
    `;
    
    // Add event listener for close button
    const closeBtn = document.getElementById('close-search-results');
    if (closeBtn) {
        closeBtn.addEventListener('click', closeSearchResults);
    }
}

function generateNewsResultsHTML(news) {
    return news.map(item => `
        <div class="search-result-item news-item">
            <a href="/?p=actuality&id=${item.id}" class="result-link">
                <div class="result-image">
                    <img src="${item.image_location || '/media/images/default-news.jpg'}" alt="${item.newsTitle}" onerror="this.src='/media/images/default-news.jpg'">
                </div>
                <div class="result-content">
                    <h4>${item.newsTitle || 'Untitled News'}</h4>
                    <p>${item.newsHeadline || 'No description available'}</p>
                    <div class="result-meta">
                        <span class="result-date">${item.newsDate || 'Date not available'}</span>
                    </div>
                </div>
            </a>
        </div>
    `).join('');
}

function generateMusicResultsHTML(music) {
    return music.map(track => `
        <div class="search-result-item music-item">
            <a href="/?p=music&id=${track.id || track.track_id}" class="result-link">
                <div class="result-image">
                    <img src="${track.image_location || '/media/images/default-music.jpg'}" alt="${track.track_name}" onerror="this.src='/media/images/default-music.jpg'">
                </div>
                <div class="result-content">
                    <h4>${track.track_name || 'Untitled Track'}</h4>
                    <p>${track.artist_name || 'Unknown Artist'}</p>
                    <div class="result-meta">
                        <div class="track-stats">
                            <span>Plays: ${track.plays || 0}</span>
                            <span>Likes: ${track.likes || 0}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    `).join('');
}

function generateEventsResultsHTML(events) {
    return events.map(event => `
        <div class="search-result-item event-item">
            <a href="/?p=events&id=${event.id || event.event_id}" class="result-link">
                <div class="result-image">
                    <img src="${event.image_location || '/media/images/default-event.jpg'}" alt="${event.title}" onerror="this.src='/media/images/default-event.jpg'">
                </div>
                <div class="result-content">
                    <h4>${event.title || 'Untitled Event'}</h4>
                    <p>${event.location || 'Location not specified'}</p>
                    <div class="result-meta">
                        <span class="event-date">${event.eventDate || 'Date not available'}</span>
                        <span class="event-price">$${event.price || '0'}</span>
                    </div>
                </div>
            </a>
        </div>
    `).join('');
}

// Add this function to handle closing search results
function closeSearchResults() {
    const root = document.getElementById('root');
    if (!root) return;
    
    // Clear the search results and return to the original page content
    const currentPage = new URLSearchParams(window.location.search).get('p') || 'index';
    
    if (currentPage === 'index') {
        // Return to welcome page
        Index(true);
    } else {
        // Return to the current page (actuality, music, events, etc.)
        try {
            availablePages[currentPage]();
        } catch(error) {
            console.log("Error returning to page: " + error);
            // Fallback to welcome page
            Index(true);
        }
    }
    
    // Clear the search input
    const searchInput = document.getElementById('tb-inp-el');
    if (searchInput) {
        searchInput.value = '';
    }
}

// global variables
let innerW = window.innerWidth;
let currentDisplay = innerW <= 768 ? "mobile" : "desktop";
let indexContentLoaded = false;
let profileLinkHandleSet = false;

var searchParams = new URLSearchParams(window.location.search);
let availablePages =
{
    "actuality" : actuality,
    "music": musicAndVids,
    "streaming" : streaming,
    "emailsubscribtion" : emailSubPage,
    "payments" : function (){
        try{
            let id = searchParams.get('id');
            window.location.href = `https://konektem.net/paymentApplication/?f=${searchParams.get('f')}${id ? `&id=${id}` : ''}`;
        } catch(error) {
            console.log("failed to redirect to payment page: ", error);
        }
    },
    "services": servicesPage,
    "events": eventsPage,
    "contacts": contactsPage,
    "buy_tickets": function (){
        const id = searchParams.get('id');
        ticketFormPage(id);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    setTopBar();
    profLinkClickHandle(profileLinkHandleSet);
    profileLinkHandleSet = true;
    
    // Initialize mobile navigation
    initMobileNavigation();
    
    // Initialize search functionality
    initSearchFunctionality();
    
    if(searchParams.get("p")){
        try{
            availablePages[searchParams.get("p")]();
        } catch(error){
            console.log("invalid page name: " + error);
        }
        
    } else {
        Index(indexContentLoaded);
        indexContentLoaded = true;
    }
    footer();
})
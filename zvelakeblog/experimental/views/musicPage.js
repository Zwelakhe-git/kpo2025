import Index from './index.js';
import {setEventHandlers} from '/JS/audScript.js';
import mediaStat from '/JS/mediaStat.js';

function tmpFunc(){
    return `
<div class="container">
    <header>
        <div class="logo">
            <i class="fas fa-play-circle"></i>
            <span>MediaNews</span>
        </div>
        <a href="/" class="back-to-news nav-link" style="color: white">
            <i class="fas fa-arrow-left"></i>
            <span>Back to News</span>
        </a>
    </header>
    
    <h1>Galri Mizik</h1>
    <p class="subtitle">Amizew avek bel mizik sa yo</p>
    
    <div class="media-container">
        <div class="music-section">
            <h2 class="section-title">
                <i class="fas fa-music"></i>
                Trak Popile
            </h2>
            
            <div class="music-item" data-src="https://assets.codepen.io/217233/kwabs-lost-in-the-zone.mp3" data-title="Lost in the Zone" data-artist="Kwabs">
                <div class="music-thumbnail">
                    <i class="fas fa-music"></i>
                </div>
                <div class="music-info">
                    <div class="music-title">Lost in the Zone</div>
                    <div class="music-artist">Kwabs</div>
                    <div class="player-controls">
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="progress-bar">
                            <div class="progress"></div>
                        </div>
                        <div class="music-duration">3:45</div>
                    </div>
                    <div class="media-actions">
                        <button class="action-btn download-btn" onclick="downloadMedia('https://assets.codepen.io/217233/kwabs-lost-in-the-zone.mp3', 'Kwabs-LostInTheZone.mp3')">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="music-item" data-src="https://assets.codepen.io/217233/ketsa-guidance.mp3" data-title="Guidance" data-artist="Ketsa">
                <div class="music-thumbnail">
                    <i class="fas fa-music"></i>
                </div>
                <div class="music-info">
                    <div class="music-title">Guidance</div>
                    <div class="music-artist">Ketsa</div>
                    <div class="player-controls">
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: 65%;"></div>
                        </div>
                        <div class="music-duration">4:20</div>
                    </div>
                    <div class="media-actions">
                        <button class="action-btn download-btn" onclick="downloadMedia('https://assets.codepen.io/217233/ketsa-guidance.mp3', 'Ketsa-Guidance.mp3')">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="music-item" data-src="https://assets.codepen.io/217233/sample-track-3.mp3" data-title="Mountain Echo" data-artist="Nature Sounds">
                <div class="music-thumbnail">
                    <i class="fas fa-music"></i>
                </div>
                <div class="music-info">
                    <div class="music-title">Mountain Echo</div>
                    <div class="music-artist">Nature Sounds</div>
                    <div class="player-controls">
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="progress-bar">
                            <div class="progress" style="width: 15%;"></div>
                        </div>
                        <div class="music-duration">5:10</div>
                    </div>
                    <div class="media-actions">
                        <button class="action-btn download-btn" onclick="downloadMedia('https://assets.codepen.io/217233/sample-track-3.mp3', 'NatureSounds-MountainEcho.mp3')">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="video-section">
            <h2 class="section-title">
                <i class="fas fa-video"></i>
                Trending Videos
            </h2>
            
            <div class="video-item" data-src="https://assets.codepen.io/217233/sample-video-1.mp4" data-title="Mountain Timelapse">
                <div class="video-thumbnail">
                    <i class="fas fa-film"></i>
                    <div class="play-overlay">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
                <div class="video-info">
                    <div class="video-title">Mountain Timelapse</div>
                    <div class="video-duration">0:45</div>
                    <div class="media-actions">
                        <button class="action-btn download-btn" onclick="downloadMedia('https://assets.codepen.io/217233/sample-video-1.mp4', 'MountainTimelapse.mp4')">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="video-item" data-src="https://assets.codepen.io/217233/sample-video-2.mp4" data-title="Ocean Waves">
                <div class="video-thumbnail">
                    <i class="fas fa-film"></i>
                    <div class="play-overlay">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
                <div class="video-info">
                    <div class="video-title">Ocean Waves</div>
                    <div class="video-duration">0:30</div>
                    <div class="media-actions">
                        <button class="action-btn download-btn" onclick="downloadMedia('https://assets.codepen.io/217233/sample-video-2.mp4', 'OceanWaves.mp4')">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="video-item" data-src="https://assets.codepen.io/217233/sample-video-3.mp4" data-title="City Life">
                <div class="video-thumbnail">
                    <i class="fas fa-film"></i>
                    <div class="play-overlay">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
                <div class="video-info">
                    <div class="video-title">City Life</div>
                    <div class="video-duration">1:05</div>
                    <div class="media-actions">
                        <button class="action-btn download-btn" onclick="downloadMedia('https://assets.codepen.io/217233/sample-video-3.mp4', 'CityLife.mp4')">
                            <i class="fas fa-download"></i> Download
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="now-playing">
        <div class="now-playing-info">
            <div class="music-thumbnail">
                <i class="fas fa-music"></i>
            </div>
            <div class="now-playing-text">
                <div class="now-playing-title">Select a track to play</div>
                <div class="now-playing-artist">MediaHub Player</div>
            </div>
        </div>
        <div class="controls">
            <div class="control-btn">
                <i class="fas fa-step-backward"></i>
            </div>
            <div class="control-btn" id="main-play">
                <i class="fas fa-play"></i>
            </div>
            <div class="control-btn">
                <i class="fas fa-step-forward"></i>
            </div>
        </div>
    </div>
    
    <!-- Audio Player -->
    <audio id="audio-player" controls style="display: none;"></audio>
    
    <!-- Video Modal -->
    <div class="modal" id="video-modal">
        <div class="modal-content">
            <span class="close-modal" id="close-modal">&times;</span>
            <h3 id="modal-title">Video Player</h3>
            <video id="modal-video" controls>
                Your browser does not support the video tag.
            </video>
        </div>
    </div>`;
}

// content is for music tracks

function musicPageHtml(content, videoData){
    let result = `<div class="container">
    <header>
        <div class="logo">
            <i class="fas fa-play-circle"></i>
            <span>MediaNews</span>
        </div>
        <a href="/" class="back-to-news nav-link" style="color: white">
            <i class="fas fa-arrow-left"></i>
            <span>Retounen</span>
        </a>
    </header>
    
    <h1>Galri Mizik</h1>
    <p class="subtitle">Amize w avek bel mizik sa yo</p>
    
    <div class="media-container">`;
    
    let category = [
        {
            name: "tracks",
            content: `<div class="music-section">
            <h2 class="section-title">
                <i class="fas fa-music"></i>
                Trak Popile
            </h2>`
        },
        {
            name: "videos",
            content: `<div class="video-section">
            <h2 class="section-title">
                <i class="fas fa-video"></i>
                Trending Videos
            </h2>
            
            `
        }
    ];
    let music_items = ``;
    let video_items = ``;
    
    for(let index = 0; index < content.length; ++index){
        let formattedName = content[index].track_name.replace(/[^A-Za-z0-9]/g, "_");
        music_items += `<div class="track"
        id="track-${content[index].id}"
        ${content[index].location.length > 0 && `data-src="${content[index].location}"`}>
            <div class="track-img">
                <img class="full-w-h" alt="track image" src="${content[index].image_location}" />
            </div>
            <div class="music-info">
                <div class="music-title">${content[index].track_name}</div>
                <div class="music-artist">${content[index].artist_name}</div>
                <div class="player-controls">
                    <div class="play-btn" data-trackid="track-${content[index].id}">
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
                </div>
            </div>
        </div>`;
    }
    
    if(videoData){
        for(let index = 0; index < videoData.length; ++index){
            let formattedName = videoData[index].vidTitle.replaceAll(" ", "_");
            video_items += `<div class="video-item" data-src="${videoData[index].location}" data-title="${formattedName}">
                    <div class="video-thumbnail ">
                        <img class="thumbnail full-w-h" src="${videoData[index].image_location}">
                        <div class="play-overlay">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                    <div class="video-info">
                        <div class="video-title">${videoData[index].vidTitle}</div>
                        <div class="video-duration"></div>
                        <div class="media-actions">
                            <button class="action-btn download-btn" onclick="">
                                <i class="fas fa-download"></i> Download
                            </button>
                            <div class="action-btn plays-btn">
                                <ion-icon name="eye-outline" class="media-ico" data-vidtitle=${formattedName}></ion-icon>
                                <span>0</span>
                            </div>
                        </div>
                    </div>
                </div>`;
        }
        category[1].content += video_items;
    }
    
    category[0].content += music_items;
    // ${category[1].content}</div>
    result += `${category[0].content}</div>
    </div>
    <div class="now-playing">
        <div class="now-playing-info">
            <div class="music-thumbnail">
                <i class="fas fa-music"></i>
            </div>
            <div class="now-playing-text">
                <div class="now-playing-title">Select a track to play</div>
                <div class="now-playing-artist">MediaHub Player</div>
            </div>
        </div>
        <div class="controls">
            <div class="control-btn">
                <i class="fas fa-step-backward"></i>
            </div>
            <div class="control-btn" id="main-play">
                <i class="fas fa-play"></i>
            </div>
            <div class="control-btn">
                <i class="fas fa-step-forward"></i>
            </div>
        </div>
    </div>
    
    <!-- Audio Player -->
    <audio id="audio-player" class="html-aud"></audio>
    
    <!-- Video Modal -->
    <div class="modal" id="video-modal">
        <div class="modal-content">
            <span class="close-modal" id="close-modal">&times;</span>
            <h3 id="modal-title">Video Player</h3>
            <video id="modal-video" controls>
                Your browser does not support the video tag.
            </video>
        </div>
    </div>`;
    return result;
}

function musicPageStyle(){
    let styleTag = document.querySelector("#root-style");
    if(!styleTag){
        console.log("musicPageStyle: style tag not found");
    }
    styleTag.innerHTML = `
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.full-w-h{
width: 100%;
height: 100%;
}
body {
    background-color: #f5f7fa;
    color: #333;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 0;
    margin-bottom: 30px;
    border-bottom: 2px solid #e1e4e8;
}

.logo {
    font-size: 20px;
    font-weight: 700;
    color: #2c3e50;
    display: flex;
    align-items: center;
}

.logo i {
    margin-right: 10px;
    color: #3498db;
}

.back-to-news {
    background-color: #3498db;
    color: white;
    padding: 6px 6px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    transition: background-color 0.3s;
    display: flex;
    align-items: center;
}

.back-to-news i {
    margin-right: 8px;
}

.back-to-news:hover {
    background-color: #2980b9;
}

h1 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 10px;
    font-size: 24px;
}

.subtitle {
    text-align: center;
    color: #7f8c8d;
    margin-bottom: 40px;
    font-size: 16px;
}

.media-container {
    display: flex;
    gap: 30px;
    margin-bottom: 40px;
}

@media (max-width: 768px) {
    .media-container {
        flex-direction: column;
    }
}

.music-section, .video-section {
    flex: 1;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    padding: 25px;
    transition: transform 0.3s;
}

.music-section:hover, .video-section:hover {
    transform: translateY(-5px);
}

.section-title {
    font-size: 20px;
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e1e4e8;
    display: flex;
    align-items: center;
}

.section-title i {
    margin-right: 10px;
    color: #3498db;
}

.music-item, .video-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    background: #f8fafc;
    transition: background-color 0.3s;
    cursor: pointer;
}

.music-item:hover, .video-item:hover {
    background: #e8f4fc;
}

.music-thumbnail {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    margin-right: 15px;
    background: #3498db;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.video-thumbnail {
    width: 100px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    margin-right: 15px;
    background: #2c3e50;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.play-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.video-thumbnail:hover .play-overlay {
    opacity: 1;
}

.music-info, .video-info {
    flex: 1;
}

.music-title, .video-title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
}

.music-artist, .video-duration {
    font-size: 14px;
    color: #7f8c8d;
}

.music-duration, .video-duration {
    font-size: 14px;
    color: #7f8c8d;
    margin-left: 10px;
}

.player-controls {
    display: flex;
    align-items: center;
    margin-top: 10px;
}

.play-btn {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #3498db;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    cursor: pointer;
}

.progress-bar {
    flex: 1;
    height: 4px;
    background: #e1e4e8;
    border-radius: 2px;
    overflow: hidden;
}

.progress {
    height: 100%;
    background: #3498db;
    width: 0%;
}

.now-playing {
    background: #2c3e50;
    color: white;
    padding: 15px;
    border-radius: 8px;
    margin-top: 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.now-playing-info {
    display: flex;
    align-items: center;
}

.now-playing-text {
    margin-left: 15px;
}

.now-playing-title {
    font-weight: 600;
    margin-bottom: 5px;
}

.now-playing-artist {
    font-size: 14px;
    opacity: 0.8;
}

.controls {
    display: flex;
    gap: 15px;
}

.control-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.3s;
}

.control-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Media controls */
.media-actions {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.action-btn {
    padding: 5px 10px;
    background: #e1e4e8;
    border: none;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
    transition: background 0.3s;
    display: flex;
    align-items: center;
}

.action-btn i {
    margin-right: 5px;
}

.action-btn:hover {
    background: #d1d9e0;
}

.download-btn {
    background: #27ae60;
    color: white;
}

.download-btn:hover {
    background: #219653;
}

/* Video player modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    max-width: 800px;
    width: 90%;
}

.close-modal {
    float: right;
    font-size: 24px;
    cursor: pointer;
}

video {
    width: 100%;
    border-radius: 4px;
    margin-top: 15px;
}

/* Audio player */
audio {
    width: 100%;
    margin-top: 10px;
}`;
}

function musicPageScript(){
    // DOM elements
    const audioPlayer = document.getElementById('audio-player');
    const videoModal = document.getElementById('video-modal');
    const modalVideo = document.getElementById('modal-video');
    const modalTitle = document.getElementById('modal-title');
    const closeModal = document.getElementById('close-modal');
    const mainPlayButton = document.getElementById('main-play');
    
    //

    let availablePages =
    {
        "index" : Index,
    }
    let links = Array.from(document.querySelectorAll(".nav-link"));
    links.forEach( link => {
        link.addEventListener("click", handleLinkClick);
    });

    // управляем ссылками
    function handleLinkClick(event){
        let clickedLink = event.currentTarget;

        if(clickedLink.dataset.pattern){
            try{
                availablePages[clickedLink.dataset.pattern](true);
            }catch(error){
                console.log(error.message);
                console.log(availablePages[clickedLink.dataset.pattern]);
            }
        }
    }
    // State variables
    let currentlyPlaying = null;
    let currentAudio = null;
    
    // Initialize media players
    function initMediaPlayers() {
        // Music item click handling
        const musicItems = document.querySelectorAll('.music-item');
        musicItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Don't trigger if download button was clicked
                if (e.target.closest('.download-btn')) return;
                
                const src = this.getAttribute('data-src');
                const title = this.getAttribute('data-title');
                const artist = this.getAttribute('data-artist');
                
                playAudio(src, title, artist, this);
            });
        });
        
        // Video item click handling
        const videoItems = document.querySelectorAll('.video-item');
        videoItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // Don't trigger if download button was clicked
                if (e.target.closest('.download-btn')) return;
                
                const src = this.getAttribute('data-src');
                const title = this.getAttribute('data-title');
                
                playVideo(src, title);
            });
        });
        
        // Close modal event
        closeModal.addEventListener('click', function() {
            videoModal.style.display = 'none';
            modalVideo.pause();
        });
        
        // Main play button event
        mainPlayButton.addEventListener('click', function() {
            if (currentAudio) {
                if (audioPlayer.paused) {
                    audioPlayer.play();
                    this.querySelector('i').classList.remove('fa-play');
                    this.querySelector('i').classList.add('fa-pause');
                    if (currentlyPlaying) {
                        currentlyPlaying.querySelector('.play-btn i').classList.remove('fa-play');
                        currentlyPlaying.querySelector('.play-btn i').classList.add('fa-pause');
                    }
                } else {
                    audioPlayer.pause();
                    this.querySelector('i').classList.remove('fa-pause');
                    this.querySelector('i').classList.add('fa-play');
                    if (currentlyPlaying) {
                        currentlyPlaying.querySelector('.play-btn i').classList.remove('fa-pause');
                        currentlyPlaying.querySelector('.play-btn i').classList.add('fa-play');
                    }
                }
            }
        });
        
        // Audio player events
        audioPlayer.addEventListener('play', function() {
            if (currentlyPlaying) {
                currentlyPlaying.querySelector('.play-btn i').classList.remove('fa-play');
                currentlyPlaying.querySelector('.play-btn i').classList.add('fa-pause');
            }
            mainPlayButton.querySelector('i').classList.remove('fa-play');
            mainPlayButton.querySelector('i').classList.add('fa-pause');
        });
        
        audioPlayer.addEventListener('pause', function() {
            if (currentlyPlaying) {
                currentlyPlaying.querySelector('.play-btn i').classList.remove('fa-pause');
                currentlyPlaying.querySelector('.play-btn i').classList.add('fa-play');
            }
            mainPlayButton.querySelector('i').classList.remove('fa-pause');
            mainPlayButton.querySelector('i').classList.add('fa-play');
        });
        
        audioPlayer.addEventListener('timeupdate', function() {
            if (currentlyPlaying) {
                const progress = (audioPlayer.currentTime / audioPlayer.duration) * 100;
                currentlyPlaying.querySelector('.progress').style.width = `${progress}%`;
            }
        });
    }
    
    // Play audio function
    function playAudio(src, title, artist, element) {
        // If clicking the same track that's currently playing
        if (currentlyPlaying === element && !audioPlayer.paused) {
            audioPlayer.pause();
            return;
        }
        
        // Reset previous track UI
        if (currentlyPlaying && currentlyPlaying !== element) {
            currentlyPlaying.querySelector('.play-btn i').classList.remove('fa-pause');
            currentlyPlaying.querySelector('.play-btn i').classList.add('fa-play');
        }
        
        // Update current track
        currentlyPlaying = element;
        currentAudio = src;
        
        // Set audio source and play
        audioPlayer.src = src;
        audioPlayer.play();
        
        // Update UI
        element.querySelector('.play-btn i').classList.remove('fa-play');
        element.querySelector('.play-btn i').classList.add('fa-pause');
        
        // Update now playing section
        document.querySelector('.now-playing-title').textContent = title;
        document.querySelector('.now-playing-artist').textContent = artist;
        
        // Show the audio player (though it's hidden for UI, we keep it for functionality)
        audioPlayer.style.display = 'none'; // Still hidden but functional
    }
    
    // Play video function
    function playVideo(src, title) {
        modalVideo.src = src;
        modalTitle.textContent = title;
        videoModal.style.display = 'flex';
        modalVideo.play();
    }
    
    // Download media function
    function downloadMedia(url, filename) {
        // Create a temporary anchor element
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        
        // In a real application, you might want to track downloads here
        console.log(`Downloading: ${filename}`);
    }
    
    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', initMediaPlayers);
}

let styles = [
  "/experimental/CSS/globalStyle.css",
]

let externalScripts = [
]

export default function musicAndVids(){
    let title = document.querySelector("title");
      if(!title){
          title = document.createElemnt("title");
          document.head.insertAdjacentElement("afterbegin", title);
      }
    title.textContent = "Music";
    musicPageStyle();
    let root = document.querySelector("#root");
    if(!root){
        console.log("Music: root element not found");
        return;
    }
    
    externalScripts.forEach(script => {
        let scriptTag = document.createElement("script");
        scriptTag.type = script.type;
        scriptTag.src = script.src;
        document.head.appendChild(scriptTag);
    });
    
    styles.forEach(style => {
        let linkTag = document.createElement("link");
        linkTag.rel = "stylesheet";
        linkTag.href = style;
        document.head.appendChild(linkTag);
    });
    
    setTimeout( async ()=>{
        let data = await fetch('/php/dbReader.php?r=musicContent');
        let musicData = await data.json();        
        mediaStat();
        setEventHandlers();
        let content = musicPageHtml(musicData, null);
        root.innerHTML = content;
        
    },250);
}
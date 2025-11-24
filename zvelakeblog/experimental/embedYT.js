let container = null;
let player;
export default function embedYTVid() {
    container = document.querySelector("#rp-vid-container");
    if (!container) {
        console.log("embedYTVid: vid container not found");
        return;
    }

    const firstScriptTag = document.querySelectorAll("script")[0];
    let scriptTag = document.createElement("script");
    scriptTag.src = "https://www.youtube.com/iframe_api";

    document.body.insertAdjacentElement("beforeend", scriptTag);
    if (firstScriptTag) {
        firstScriptTag.parentElement.insertBefore(scriptTag, firstScriptTag);
    } else {
        document.body.insertAdjacentElement("beforeend", scriptTag);
    }
}

window.onYouTubeIframeAPIReady = function() {
    const container = document.querySelector("#rp-vid-container");
    player = new YT.Player(container, {
        videoId: "qUfA_j2weEI",
        playerVars: {
            muted: 1,
            autoplay: 0,
            controls: 1,
            playsinline: 1
        },
        events: {
            onReady: onPlayerReady
        }
    });
}

function onPlayerReady() {
    const playButton = document.querySelector("#play-button");
    if (playButton) {
        playButton.addEventListener('click', () => {
            player.playVideo();
        });
    } else {
        console.log("Play button not found");
    }
}
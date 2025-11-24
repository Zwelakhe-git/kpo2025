import embedYTVid from './embedYT.js'

const rpVidScript = () => {
    let waitForVidContainer = new Promise((resolve) => {
        const observer = new MutationObserver(() => {
            let container = document.querySelector(".vid-container");
            if(container !== null){
                observer.disconnect();
                resolve(container);
            }
        });
        observer.observe(document.body, {childList : true, subtree : true});
    });

    waitForVidContainer.then(container => {
        setTimeout(embedYTVid(), 350);
    });
};

export default rpVidScript;
import userAuthPage from '/experimental/JS/views/authentication.js ';

async function recordMediaStats(activity, id, user){
    try{
        //const id = element.dataset.trackid;
        const url = `/php/dbReader.php?q=mediaActivity&activity=${activity}&id=${id}&user=${user}`;
        if(activity === 'like' || activity === 'dislike') activity = 'like';
        
        let selector = `.${activity}-btn .media-ico[data-trackid='${id}']`;
        console.log(selector);
        let parent = document.querySelector(`${selector}`).parentElement;
        let spanTag = parent.querySelector("span");
        if(!spanTag){
            console.log(`${activity} span tag not found`);
            return;
        }
        let response = await fetch(url);
        let data = await response.json();
        if(data.response != 'fail'){
            spanTag.textContent = data.response.count;
        } else {
            console.log(JSON.stringify(data));
        }
    } catch(error){
        console.log('media stat error: ' + error.message);
        console.log(id);
    }
}

export default async function mediaStat(){
    const waitForBtns = new Promise(resolve => {
        let observer = new MutationObserver( () => {
            let downdloadBtns = document.querySelectorAll(".download-btn");
            let likeBtns = document.querySelectorAll(".like-btn");
            let playBtns = document.querySelectorAll(".play-btn");
            let shareBtns = document.querySelectorAll(".share-btn");
            
            if(downdloadBtns.length > 0 &&
                likeBtns.length > 0 &&
                playBtns.length > 0 &&
                shareBtns.length > 0
            ){
                observer.disconnect();
                resolve([downdloadBtns, likeBtns, playBtns, shareBtns]);
                return;
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    })

    waitForBtns
    .then( buttons => {
        let [downdloadBtns, likeBtns, playBtns, shareBtns] = buttons;
        let formResourcesLoaded = false;
        shareBtns.forEach( btn => {
            let shareicon = btn.querySelector(".media-ico");
            if(shareicon){
                shareicon.addEventListener("click", async (event) => {
                    let userRegistered = false;
                    let response = await fetch('/php/dbReader.php?r=userlogin');
                    let data = await response.json();
                    
                    if(data.response === 'success'){
                        userRegistered = true;
                    }
                    
                    if(!userRegistered){
                        userAuthPage(formResourcesLoaded);
                        formResourcesLoaded = true;
                        return;
                    }
                    /*if(!allowUserAction()){
                        return;
                    }*/
                    let activity = "";
                    
                    if(!shareicon.classList.contains("shared")){
                        shareicon.classList.add("shared");
                        shareicon.classList.add("fa-solid");
                        shareicon.classList.remove("fa-regular");
                        recordMediaStats('share', shareicon.dataset.trackid, window.currentUser);
                    }
                });
            }
            else {
                console.log("like share not found");
            }
        } );
        likeBtns.forEach( btn => {
            let likeicon = btn.querySelector(".media-ico");
            if(likeicon){
                likeicon.addEventListener("click", async (event) => {
                    let userRegistered = false;
                    let response = await fetch('/php/dbReader.php?r=userlogin');
                    let data = await response.json();
                    
                    if(data.response === 'success'){
                        userRegistered = true;
                    }
                    
                    if(!userRegistered){
                        userAuthPage(formResourcesLoaded);
                        formResourcesLoaded = true;
                        return;
                    }
                    /*if(!allowUserAction()){
                        return;
                    }*/
                    let activity = "";
                    
                    if(!likeicon.classList.contains("liked")){
                        likeicon.classList.add("liked");
                        likeicon.classList.add("fa-solid");
                        likeicon.classList.remove("fa-regular");
                        recordMediaStats('like', likeicon.dataset.trackid, window.currentUser);
                    }
                });
            }
            else {
                console.log("like icon not found");
            }
        } );

        downdloadBtns.forEach( btn => {
            let downloadIcon = btn.querySelector(".media-ico");
            if(downloadIcon){
                downloadIcon.addEventListener("click", async (event) => {
                    let userRegistered = false;
                    let response = await fetch('/php/dbReader.php?r=userlogin');
                    let data = await response.json();
                    
                    if(data.response === 'success'){
                        userRegistered = true;
                    }
                    
                    if(!userRegistered){
                        userAuthPage(formResourcesLoaded);
                        formResourcesLoaded = true;
                        return;
                    }
                    /*if(!allowUserAction()){
                        return;
                    }*/
                    
                    let audEle = document.querySelector(`#track-${downloadIcon.dataset.trackid}`);
                    if(audEle && audEle.dataset.src){
                        let a = document.createElement("a");
                        a.href = audEle.dataset.src;
                        a.download = downloadIcon.dataset.tracktitle;
                        a.click();
                        recordMediaStats('download', downloadIcon.dataset.trackid, window.currentUser);
                    } else {
                        alert("Failed to download. item has no link");
                        
                    }

                });
            } else {
                console.log("download icon not found");
            }
        });
        
        playBtns.forEach( (btn) => {
            let playIcon = btn.querySelector(".media-ico");
            if(playIcon){
                playIcon.addEventListener("click", (event) => {
                    if(event.currentTarget.classList.contains("play")){
                        recordMediaStats('plays', playIcon.dataset.trackid, window.currentUser);
                    }
                })
            } else {
                console.log("play icon not found");
            }
        });
        
        async function allowUserAction(){
            let userRegistered = false;
            let response = await fetch('/php/dbReader.php?r=userlogin');
            let data = await response.json();

            if(data.response === 'success'){
                userRegistered = true;
                return true;
            }

            if(!userRegistered){
                userAuthPage(formResourcesLoaded);
                formResourcesLoaded = true;
                return false;
            }
        }
    })
}

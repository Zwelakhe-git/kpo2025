const searchPg = () => {
    const blnkPg = document.createElement("div");
    blnkPg.setAttribute("id", "search-pg");
     blnkPg.classList.add("srch","full-vh","blk-bg","white-clr","flxDisp", "no-margin");

    const inlineHtml = `<div class="crcl"><ion-icon name="close-outline" class="fnt32" id="close-srch-win"></ion-icon></div>
    <div class="search-bar search-pg-bar flxDisp">
    <input class="no-outln no-bdr full-w" type="text" name="searchInp" placeholder="search"/>
    <ion-icon name="search-outline" class="grey-clr"></ion-icon>
    </div>`;
    blnkPg.innerHTML = inlineHtml;
    
    const waitForSrchBr = new Promise((resolve) => {
        const observer = new MutationObserver(() => {
            let srchBar = document.querySelector("#top-bar-content .search-bar .input");
            if(srchBar !== null){
                observer.disconnect();
                resolve(srchBar);
            }
        });
        observer.observe(document.body, {childList : true, subtree : true});
    });

    document.body.insertAdjacentElement("afterbegin", blnkPg);

    waitForSrchBr.then( srchBar => {
        
        srchBar.addEventListener("click", () => {
            blnkPg.style.display = "flex";
            blnkPg.classList.toggle("open");
            // setTimeout(() => {
            //     document.querySelector(".search-pg-bar input");
            // }, 200);
        });
    } );
    
    document.querySelector("#close-srch-win").addEventListener("click", () => {
        blnkPg.style.display = "none";
    });
};

export default searchPg;
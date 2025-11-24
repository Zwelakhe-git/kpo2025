
const slideScript = () => {
    let currentIndex = 0;
    let timer = null;
    let resumeTimer = null;
    let anyTimer = null;
    let allSlides = null;
    let slideCount = null;
    let slidesLink = null;
    const waitForNewsSlides = () => {
        return new Promise((resolve) => {
            let observer = new MutationObserver(() => {
                let slidesCont = document.querySelector("#news-slides");
                if(slidesCont && slidesCont.children.length > 0){
                    observer.disconnect();
                    resolve(slidesCont);
                }
            });
            observer.observe(document.body, { childList : true, subtree : true });
        });
    }
    waitForNewsSlides()
    .then( slidesCont => {
        const Loccontainer = slidesCont;
        const slides = Array.from(document.querySelector("#news-slides").children);
        slideCount = slides.length;

        slides.slice(0, 2).forEach(slide => {
            document.querySelector("#news-slides").appendChild(slide.cloneNode(true));
        });

        allSlides = Array.from(document.querySelector("#news-slides").children);
        slidesLink = document.querySelector("#slide-link");
        if(!slidesLink){
            console.log("slides link not found");
        }
        
        
        timer = setInterval(nextSlide, 4000);

        document.querySelector(".scroll-btn.right").addEventListener("click", rightScroll);
        document.querySelector(".scroll-btn.left").addEventListener("click", leftScroll);
    })
    function rightScroll() {
        clearInterval(timer);
        timer = null;

        if(resumeTimer){
            clearTimeout(resumeTimer);
            resumeTimer = null;
        }

        if(anyTimer){
            clearTimeout(anyTimer);
            anyTimer = null;
        }

        currentIndex = (currentIndex + 1) % allSlides.length;
        
        document.querySelector("#news-slides").scrollTo({
            left: allSlides[currentIndex].offsetLeft,
            behavior: "smooth"
        });
        updateLink();

        if (currentIndex >= slideCount) {
            
            currentIndex = currentIndex - slideCount;
            anyTimer = setTimeout(() => {
                document.querySelector("#news-slides").scrollLeft = allSlides[currentIndex].offsetLeft;
            },500);
        }

        resumeSlideTimer();
    }

    function leftScroll() {
        clearInterval(timer);
        timer = null;

        if(resumeTimer){
            clearTimeout(resumeTimer);
            resumeTimer = null;
        }
        if(anyTimer){
            clearTimeout(anyTimer);
            anyTimer = null;
        }

        if (currentIndex === 0) {
            currentIndex = slideCount - 1;
            document.querySelector("#news-slides").scrollLeft = allSlides[slideCount].offsetLeft;
            document.querySelector("#news-slides").scrollTo({
                left: allSlides[currentIndex].offsetLeft,
                behavior: "smooth"
            })
        } else {
            currentIndex--;
            document.querySelector("#news-slides").scrollTo({
                left: allSlides[currentIndex].offsetLeft,
                behavior: "smooth"
            });
        }
        updateLink();

        resumeSlideTimer();
    }

    function resumeSlideTimer() {
        
        resumeTimer = setTimeout(() => {
            timer = setInterval(nextSlide, 4000);
        }, 4000);
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % allSlides.length;
        document.querySelector("#news-slides").scrollTo({
            left: allSlides[currentIndex].offsetLeft,
            behavior: "smooth"
        });
        updateLink();

        if (currentIndex >= slideCount) {
            anyTimer = setTimeout(() => {
                const realIndex = currentIndex - slideCount;
                document.querySelector("#news-slides").scrollLeft = allSlides[realIndex].offsetLeft;
                currentIndex = realIndex;
            }, 1000);
        }
    }
    function updateLink(){
        if(slidesLink){
            slidesLink.href = `/?p=actuality&id=${allSlides[currentIndex].dataset.id}`;
        } else {
            console.log("news slide link not found");
        }
    }
};

//slideScript();
export default slideScript;
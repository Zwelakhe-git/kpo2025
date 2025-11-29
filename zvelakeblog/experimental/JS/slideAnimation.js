
function slideAnimation(containerId){
    let currentIndex = 0;
    let timer = null;
    let resumeTimer = null;
    let anyTimer = null;
    let allSlides = null;
    let slideCount = null;
    let slidesLink = null;
    let id = containerId;
    const sw = document.querySelector("#"+id).scrollWidth;
    const cw = document.querySelector("#"+id).clientWidth;
    const slides = Array.from(document.querySelector("#"+id).children);
    slideCount = slides.length;
    if(sw <= cw || slideCount < 2) return;

    slides.slice(0, 2).forEach(slide => {
        document.querySelector("#"+id).appendChild(slide.cloneNode(true));
    });

    allSlides = Array.from(document.querySelector("#"+id).children);
    slidesLink = document.querySelector("#slides-link");
    if(!slidesLink){
        console.log("slides link not found");
    }


    timer = setInterval(nextSlide, 4000);

    let rs = document.querySelector(`#${id} .scroll-btn.right`);
    let ls = document.querySelector(`#${id} .scroll-btn.left`);
    if(rs) rs.addEventListener("click", rightScroll);
    if(ls) ls.addEventListener("click", leftScroll);
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
        
        document.querySelector("#"+id).scrollTo({
            left: allSlides[currentIndex].offsetLeft,
            behavior: "smooth"
        });
        updateLink();

        if (currentIndex >= slideCount) {
            
            currentIndex = currentIndex - slideCount;
            anyTimer = setTimeout(() => {
                document.querySelector("#"+id).scrollLeft = allSlides[currentIndex].offsetLeft;
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
            document.querySelector("#"+id).scrollLeft = allSlides[slideCount].offsetLeft;
            document.querySelector("#"+id).scrollTo({
                left: allSlides[currentIndex].offsetLeft,
                behavior: "smooth"
            })
        } else {
            currentIndex--;
            document.querySelector("#"+id).scrollTo({
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
        document.querySelector("#"+id).scrollTo({
            left: allSlides[currentIndex].offsetLeft,
            behavior: "smooth"
        });
        updateLink();
        if (currentIndex >= slideCount) {
            anyTimer = setTimeout(() => {
                const realIndex = currentIndex - slideCount;
                document.querySelector("#"+id).scrollLeft = allSlides[realIndex].offsetLeft;
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

export default slideAnimation;

const newsFadeAnimation = () => {
  let globContainers = null;
  let current = null;
  let running = true;
  let animationTimer = null;
  let positionTimerId = null;
  let timeoutForNextItemId = null;
  const animationDelay = 10000;
  const fadeDuration = 1800;
  const positioningDelay = 80;
  let link = null;

  const waitForNewsContent = () => {
    return new Promise((resolve) => {
      
      let observer = new MutationObserver(() => {
        let containers = document.querySelectorAll(".artcl-itm");
        if(containers.length > 0){
          observer.disconnect();
          resolve(containers);
        }
      });
      observer.observe(document.body, {childList : true, subtree : true});
    });
  }
  waitForNewsContent()
  .then(containers => {
    globContainers = containers;
    link = document.querySelector('#fade-news-link');
    if(!link) console.log('link not found');
    containers.forEach(container => {
      container.addEventListener("mouseenter",(event)=>{
        event.target.classList.add("mouseHover");
        try{
          if(timeoutForNextItemId){
            clearTimeout(timeoutForNextItemId);
            timeoutForNextItemId = null;
          }
          if(positionTimerId){
            clearTimeout(positionTimerId);
            positionTimerId = null;
          }
        }catch(Error){
          console.log("Error");
        }
        stop();
        
        index = Array.from(containers).indexOf(event.target) + 1;
        event.target.classList.add("selected");
      });
      
      container.addEventListener("mouseleave",(event)=>{
        event.target.classList.remove("mouseHover");
        setTimeout(() => {
            start();
        }, 2000)
      });
    })

    runFadeAnimation();
    animationTimer = setInterval(runFadeAnimation, animationDelay);
  });
  
  function start(){
    if(!running){
      running = true;
      runFadeAnimation();
      animationTimer = setInterval(runFadeAnimation,animationDelay);
    }
  }
  function stop(){
    if(running){
      running = false;
      clearInterval(animationTimer);
      animationTimer = null;
    }
  }

  let index = 0;
  function runFadeAnimation(){
    try{
      repositionItem();
    }catch(TypeError){
      console.log("An error occured");
      console.log(index);
    }
    
  }

  function repositionItem(){
    if(index > globContainers.length - 1) index = 0;
    current = globContainers[index++];
      //console.log(current.dataset);
     link.href = link && `/?p=actuality&id=${current.dataset.newsid}`;

    globContainers.forEach(other => {
      other.classList.toggle("selected", other === current);
    })
  //   current.style.display  = "flex";

  //   positionTimerId = setTimeout(()=>{
  //     current.classList.toggle("selected");
  //   }, positioningDelay);
  }
};
//newsFadeAnimation();
export default newsFadeAnimation;
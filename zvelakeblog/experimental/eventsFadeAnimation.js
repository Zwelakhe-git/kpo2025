export default function eventsFadeAnimation(){
    let cards = null;
    let current = null;
    let index = 0;
    let animationTimer = null;
    let numCards = 0;
    const animationDelay = 10000;
    
    const waitForEventCards = () => {
        return new Promise((resolve) => {
            const observer = new MutationObserver(() => {
                const eventCards = document.querySelectorAll(".event-card");
                if(eventCards.length > 0){
                    observer.disconnect();
                    resolve(eventCards);
                }
            });

            observer.observe(document.body, {childList : true, subtree : true});
        });
    }

    waitForEventCards()
    .then(eventCards => {
        cards = eventCards;
        numCards = eventCards.length;
        runFadeAnimation();
        animationTimer = setInterval(runFadeAnimation, animationDelay);
    })

    function runFadeAnimation(){
        try{
            showNext();
        }catch(error){
            console.log("An error occured:", error.message);
            console.log(index);
        }
        
    }

    function showNext(){
        if(index > numCards - 1) index = 0;
        if(index + 1 > numCards - 1){
            current = [cards[0], cards[index]];
        }
        else{
            current = [cards[index], cards[index + 1]];
        }
        cards.forEach(card => {
            card.classList.toggle("selected", current.includes(card));
        }); 

        index += 2;
    }
}

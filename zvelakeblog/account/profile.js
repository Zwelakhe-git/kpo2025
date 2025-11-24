
function updateProfileUI(){
    try{
        let icon = document.querySelector('#nav-panel .user-prof');
        let profileText = document.querySelector('#nav-panel .user-id');
        if(!window.currentUser || window.currentUser === 'guest'){
            icon.classList.remove('fa-arrow-right-from-bracket');
            icon.classList.add('fa-user-plus');
            profileText.textContent = 'login/register';
        } else {
            icon.classList.remove('fa-user-plus');
            icon.classList.add('fa-arrow-right-from-bracket');
            profileText.textContent = 'logout';
        }
    } catch(error){
        console.log(error.message);
    }
}

export async function profLinkClickHandle(handleSet){
    if(handleSet) return;
    try{
        let response = await fetch('/php/dbReader.php?q=uid');
        let uid = await response.json();
        window.currentUser = uid.name;
        updateProfileUI();
        let profileLink = document.querySelector('#prof-link');
        profileLink.addEventListener('click', async () => {
            if(!window.currentUser || window.currentUser === 'guest'){
                window.location.href = '/account/login.html';
            } else{
                response = await fetch('/php/dbReader.php?q=userlogout');
                window.currentUser = 'guest';
                updateProfileUI();
            }
        });
    } catch(error){
        console.log(error.message);
    }
}

function updateProfile(username){}

export default updateProfileUI;

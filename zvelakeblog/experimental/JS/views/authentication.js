import updateProfileUI from '/account/profile.js';

function signForm(){
    return `<form class='regForm'>
        <div class='form-close'>
            <i class="fa-solid fa-xmark close-icon"></i>
        </div>
        
        <div class="form-header">
            <h2>Log in to your account</h2>
            <p class="form-subtitle">Welcome back! Please enter your details.</p>
        </div>
        
        <div id="social-login-container"></div>
        
        <div class="divider">
            <span>Or</span>
        </div>
        
        <div class="email-login-section">
            <div class='field'>
                <label for='login'>USERNAME</label>
                <input id='login' type='text' name='login' placeholder='Enter your username'/>
            </div>
            
            <div class='field'>
                <label for='email'>EMAIL ADDRESS</label>
                <input id='email' type='email' name='email' placeholder='Enter your email'/>
            </div>
            
            <div class='field'>
                <label for='password'>PASSWORD</label>
                <input id='password' type='password' name='password' placeholder='Enter your password'/>
            </div>
            
            <div class='field row remember-me'>
                <input id='show-pswd' type='checkbox' name='show-pswd'/>
                <label for='show-pswd'>SHOW PASSWORD</label>
            </div>
            
            <div class='form-btns'>
                <button id='send-btn' type='button'>SIGN IN</button>
            </div>
        </div>
        
        <p id='form-btm-text'></p>
       </form>
        `;
}

function createSocialLoginButtons() {
    return `
        <div class="social-login-options">
            <button type="button" id="google-login-btn" class="social-btn google-btn">
                <i class="fa-brands fa-google"></i>
                <span>Continue with Google</span>
            </button>
        </div>
    `;
}

export function renderForm(formtype, closeOnLog = true){
    if(document.querySelector('.form-container')){
        return;
    }
    let formContainer = document.createElement('div');
    formContainer.classList.add('form-container');
    formContainer.innerHTML = signForm();
    document.body.appendChild(formContainer);
    
    let form = formContainer.querySelector('form');
    renderFormUI();
    form.style.display = 'block';
    let timer1 = null;
    let timer2 = null;

    timer1 = setTimeout(()=>{
      form.classList.add('open');
      let pswdField = form.querySelector('#password');
      let loginField = form.querySelector('#login');
      let emailField = form.querySelector('#email');
      let closeIcon = form.querySelector('.close-icon');
      let sendBtn = form.querySelector('#send-btn');
      let socialLoginContainer = form.querySelector('#social-login-container');
        
      // Add social login buttons to the form
      socialLoginContainer.innerHTML = createSocialLoginButtons();
        
      loginField.addEventListener('input', (event) => {
          loginField.value = loginField.value.replace(/[^A-Za-z0-9]/g, '');
      });
        
      if(closeOnLog){
          closeIcon.addEventListener('click', ()=>{
            form.classList.remove('open');
            timer2 = setTimeout(()=>{
              formContainer.style.display = 'none';
              document.body.removeChild(formContainer);
            }, 500);
          });
      }
      
      // Google login button event listener
      let googleLoginBtn = form.querySelector('#google-login-btn');
      googleLoginBtn.addEventListener('click', async () => {
          googleLoginBtn.disabled = true;
          googleLoginBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Loading...</span>';
          
          try {
              let response = await fetch('/php/dbReader.php?q=googleAuthUrl');
              let data = await response.json();
              
              if (data.auth_url) {
                  window.location.href = data.auth_url;
              } else if (data.error) {
                  throw new Error(data.error);
              } else {
                  throw new Error('No authentication URL received from server');
              }
          } catch (error) {
              console.error('Google login error:', error);
              let errorMessage = 'Google authentication is not available at the moment.';
              
              if (error.message.includes('not configured') || error.message.includes('configuration missing')) {
                  errorMessage = 'Google authentication is not configured. Please contact administrator.';
              } else if (error.message.includes('config file missing')) {
                  errorMessage = 'Google authentication setup incomplete. Please contact administrator.';
              }
              
              showAlert(errorMessage, 'error', formContainer);
              
              // Reset button
              googleLoginBtn.disabled = false;
              googleLoginBtn.innerHTML = '<i class="fa-brands fa-google"></i><span>Continue with Google</span>';
          }
      });
      
      sendBtn.addEventListener('click', async (e)=>{
    try{
        let formData = new FormData(form);
        let hasEmptyFields = false;
        
        // Check only visible fields for login, all fields for signup
        if(formtype === 'login') {
            // For login, only check email and password
            const email = form.querySelector('#email').value.trim();
            const password = form.querySelector('#password').value.trim();
            
            if(email.length === 0 || password.length === 0) {
                showAlert('Please fill in all required fields', 'error', formContainer);
                return;
            }
        } else {
            // For signup, check all fields including username
            for(const [key, value] of formData.entries()){
                if(value.trim().length === 0){
                    showAlert('Please fill in all required fields', 'error', formContainer);
                    return;
                }
            }
        }
        
        const params = new URLSearchParams(formData);

        let response = (formtype === 'login') ? await fetch('/php/dbReader.php?r=userlogin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: params.toString()
        }) : await fetch('/php/dbReader.php?r=userRegister', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: params.toString()
        });
        let data = await response.json();
        console.log(data);
        
        if(data.response === 'success'){
            showAlert('Success! Redirecting...', 'success', formContainer);
            window.currentUser = formtype === 'login' ? data.message : 'guest';
            updateProfileUI();
            
            if(closeOnLog){
                setTimeout(()=>{
                    closeIcon.click();
                }, 1000);
            } else {
                window.location.href = "/";
            }
            
        } else if(data.response === 'fail'){
            console.log('showing alert on login')
            showAlert(data.message, 'error', formContainer);
        }
        
    } catch(error){
        console.log(error.message);
        showAlert('An error occurred. Please try again.', 'error', formContainer);
    }
});

      let showPswdCheckBx = form.querySelector('#show-pswd');
      showPswdCheckBx.addEventListener('change', (e)=>{
        pswdField.type = e.currentTarget.checked ? 'text' : 'password';
      });
    }, 500);
    
    function renderFormUI(){
        let sendBtn = form.querySelector('#send-btn');
        let formBtmParag = form.querySelector('#form-btm-text');
        let formHeader = form.querySelector('.form-header h2');
        let formSubtitle = form.querySelector('.form-subtitle');
        let usernameField = form.querySelector('.field:first-child');
        
        if(formtype === 'login') {
            formHeader.textContent = 'Log in to your account';
            formSubtitle.textContent = 'Welcome back! Please enter your details.';
            sendBtn.textContent = 'SIGN IN';
            formBtmParag.innerHTML = "Don't have an account? <a id='sign-link'>Sign up</a>";
            // Hide username field for login
            usernameField.style.display = 'none';
        } else {
            formHeader.textContent = 'Create your account';
            formSubtitle.textContent = 'Join us today! Enter your details to get started.';
            sendBtn.textContent = 'SIGN UP';
            formBtmParag.innerHTML = "Already have an account? <a id='reg-link'>Sign in</a>";
            // Show username field for signup
            usernameField.style.display = 'block';
        }
        
        let formLink = form.querySelector('a');
        formLink.addEventListener('click', ()=>{
            formtype = formtype === 'login' ? 'register' : 'login';
            renderFormUI();
        });
    }
}

function showAlert(message, type, container) {
    // Remove existing alerts
    const existingAlerts = container.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'ok' : 'err'}`;
    alertDiv.innerHTML = `
        <i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i>
        <span>${message}</span>
    `;
    
    container.appendChild(alertDiv);
    
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

function pageInnerStyle(){
    return `
@media (min-width: 480px){
    .regForm{
        width: 400px;
        top: 10%;
    }
}

@media (max-width: 480px){
    .regForm{
        width: 95%;
        top: 5%;
    }
}

.form-container{
position: fixed;
z-index: 105;
width: 100%;
height: 100%;
top: 0;
background-color: #f5f5f591;
}
.regForm{
  box-sizing: border-box;
	position: relative;
    border-radius: 12px;
	padding: 30px 25px;
    transform: scale(0);
    margin: auto;
    display: none;
    transition: transform 0.5s ease-in-out;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    background-color: white;
    max-height: 90vh;
    overflow-y: auto;
}
.regForm.open{
	transform: scale(1);
}
.regForm a{
  color: #10a37f;
  text-decoration: none;
  cursor: pointer;
  font-weight: 500;
}
.regForm a:hover {
    text-decoration: underline;
}

.regForm > div{
	margin-bottom: 15px;
}

/* Form Header */
.form-header {
    text-align: center;
    margin-bottom: 25px;
}

.form-header h2 {
    color: #202123;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 8px;
}

.form-subtitle {
    color: #6e6e80;
    font-size: 14px;
    line-height: 1.4;
}

/* Social Login Styles */
.social-login-options {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 25px;
}

.social-btn {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 12px;
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #d9d9e3;
    border-radius: 8px;
    background: white;
    color: #374151;
    font-size: 14px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: left;
}

.social-btn:hover {
    background: #f7f7f8;
    border-color: #c5c5d2;
}

.social-btn:active {
    background: #ececf1;
}

.social-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.social-btn i {
    width: 18px;
    text-align: center;
    font-size: 16px;
}

/* Google button styles */
.google-btn i {
    background: conic-gradient(from -45deg, #ea4335 110deg, #4285f4 90deg 180deg, #34a853 180deg 270deg, #fbbc05 270deg) 73% 55%/150% 150% no-repeat;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    -webkit-text-fill-color: transparent;
}

/* Divider - Centered */
.divider {
    display: flex;
    align-items: center;
    margin: 25px 0;
    color: #6e6e80;
    font-size: 14px;
}

.divider::before,
.divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #e5e5e7;
}

.divider span {
    padding: 0 12px;
    background: white;
}

/* Email Login Section */
.email-login-section {
    margin-bottom: 20px;
}

.field, .form-btns{
	display: flex;
    flex-direction: column;
    gap: 8px;
}

.field {
    margin-bottom: 20px;
}

.field label {
    color: #374151;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.field input:not([type='checkbox']) {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #d9d9e3;
    border-radius: 8px;
    font-size: 14px;
    background: white;
    transition: border-color 0.2s ease;
}

.field input:not([type='checkbox']):focus {
    outline: none;
    border-color: #10a37f;
    box-shadow: 0 0 0 3px rgba(16, 163, 127, 0.1);
}

.field input::placeholder {
    color: #9ca3af;
}

.field.row{
	flex-direction: row;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.field.row label {
    margin-bottom: 0;
    font-weight: 400;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
    cursor: pointer;
}

input[type='checkbox'] {
    width: 16px;
    height: 16px;
    cursor: pointer;
}

#send-btn{
	padding: 12px 16px;
    border-radius: 8px;
    border: none;
    background-color: #10a37f;
    color: white;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.2s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
#send-btn:hover {
    background-color: #0d8c6c;
}

/* Form Footer */
#form-btm-text {
    text-align: center;
    color: #6e6e80;
    font-size: 14px;
    margin-top: 20px;
    margin-bottom: 0;
}

.fa-spin {
    animation: fa-spin 1s infinite linear;
}

@keyframes fa-spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.alert {
    position: relative;
    width: 90%;
    margin: 10px auto;
    text-align: center;
    font-weight: 600;
    padding: 12px;
    border-radius: 8px;
    font-size: 14px;
    z-index: 106;
}
.alert.alert-ok {
    color: #065f46;
    background-color: #d1fae5;
    border: 1px solid #a7f3d0;
}
.alert.alert-err {
    color: #991b1b;
    background-color: #fee2e2;
    border: 1px solid #fecaca;
}

/* Close Icon */
.form-close {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 10;
}

.close-icon {
    font-size: 20px;
    color: #6e6e80;
    cursor: pointer;
    padding: 5px;
    border-radius: 4px;
    transition: background-color 0.2s ease;
}

.close-icon:hover {
    background-color: #f7f7f8;
    color: #374151;
}`;
}
    
function userAuthPage(resourcesLoaded){
    let styleTag = document.querySelector('#root-style');
    if(!resourcesLoaded){
        styleTag.innerHTML += pageInnerStyle();
    }
    var formtype = 'register';
    renderForm(formtype);
}
export default userAuthPage;

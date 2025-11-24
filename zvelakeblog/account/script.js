import {renderForm} from '/experimental/JS/views/authentication.js';
import updateProfileUI from '/account/profile.js';

document.addEventListener('DOMContentLoaded', ()=>{
    // Use the authentication.js render function instead of static form
    renderForm('login', false);
    
    // Handle Google auth callback parameters
    const urlParams = new URLSearchParams(window.location.search);
    const googleSuccess = urlParams.get('google_success');
    const googleError = urlParams.get('google_error');
    const user = urlParams.get('user');
    
    if (googleSuccess === '1' && user) {
        // Update UI to show logged in state
        window.currentUser = user;
        updateProfileUI();
        
        // Show success message
        showAlert('Successfully logged in with Google!', 'success');
        
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
        
        // Redirect to home page after successful login
        setTimeout(() => {
            window.location.href = '/';
        }, 2000);
    }
    
    if (googleError === '1') {
        const message = urlParams.get('message') || 'Google authentication failed';
        showAlert(message, 'error');
        
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'ok' : 'err'}`;
    alertDiv.innerHTML = `
        <i class="fa-solid ${type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'}"></i>
        <span>${message}</span>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
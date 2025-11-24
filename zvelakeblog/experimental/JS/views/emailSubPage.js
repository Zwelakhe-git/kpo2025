export function pageHtml(){
    return `
 <div class="container">
    <h2>ABONNEZ-VOUS</h2>
    <p class="subtitle">
      Inscrivez-vous pour recevoir nos actualités et rester connecté !
    </p>
    <form id="subscribeForm">
      <div>
        <label for="nom">Nom</label>
        <input type="text" id="nom" required>
      </div>
      <div>
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" required>
      </div>
      <div>
        <label for="email">Adresse électronique *</label>
        <input type="email" id="email" required>
      </div>
      <div>
        <label for="message">Message</label>
        <textarea id="message" placeholder="Votre message..."></textarea>
      </div>
      <button type="submit">S'abonner</button>
    </form>
  </div>`;
}

export function pageStyle(){
    let styleTag = document.querySelector("#root-style");
    if(!styleTag){
        console.log("pageStyle: style tag not found");
        return;
    }
    styleTag.innerHTML = ` body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f5f9fc;
      color: #222;
    }
     body * {
        box-sizing: border-box;
    }

    #root .container {
      max-width: 700px;
      margin: 50px auto;
      padding: 30px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #003366;
      margin-bottom: 10px;
    }

    p.subtitle {
      text-align: center;
      color: #444;
      font-size: 15px;
      margin-bottom: 30px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 18px;
    }

    label {
      font-weight: bold;
      margin-bottom: 5px;
      display: block;
    }

    form input, form textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 14px;
    }

    textarea {
      resize: vertical;
      min-height: 100px;
    }

    button {
      padding: 14px;
      border: none;
      background: #003366;
      color: #fff;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #0055aa;
    }`
}

function emailSubScript(){
    document.getElementById("subscribeForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const nom = document.getElementById("nom").value;
      const prenom = document.getElementById("prenom").value;
      const email = document.getElementById("email").value;
      const message = document.getElementById("message").value;

      if (nom && prenom && email) {
        alert("Merci " + prenom + "! Votre souscription a été envoyée.");
        document.getElementById("subscribeForm").reset();
      } else {
        alert("Veuillez remplir tous les champs obligatoires.");
      }
    });
}

export default function emailSubPage(){
    let title = document.querySelector("title");
      if(!title){
          title = document.createElemnt("title");
          document.head.insertAdjacentElement("afterbegin", title);
      }
      title.textContent = "Email Subscription";
    let root = document.querySelector("#root");
     if(!root){
        console.log("Index: content container not found");
        return;
      }
    root.innerHTML = pageHtml();
    pageStyle();
    setTimeout(emailSubScript, 350);
}
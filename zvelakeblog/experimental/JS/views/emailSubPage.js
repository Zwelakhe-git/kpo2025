export function pageHtml(){
    return `
 <div class="container">
 <p>
    Оставайтесь на связи!
Хотите быть в курсе всех новостей нашего сайта? Подпишитесь на уведомления и получайте самые интересные материалы первыми!

Мы обещаем присылать только действительно важное и интересное.</p>
<div class="onesignal-customlink-container" data-onesignal-customlink="true"></div>`;
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
      max-width: 80%;
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
  window.OneSignalDeferred = window.OneSignalDeferred || [];
  OneSignalDeferred.push(async function() {
    await OneSignal.init({
      appId: "39dd8a55-2ec8-4667-9dec-c35358ecb56c",
    });
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
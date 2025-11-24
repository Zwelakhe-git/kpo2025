
const contactData = {
    companyName: "Kontak",
    description: "Kontakte nou nan youn nan fòm sa yo",
    contactInfo: [
        {
            type: "address",
            icon: "fas fa-map-marker-alt",
            title: "Adrès:",
            content: "14, Delmas 79, Village Daniel Roy., Delmas,HT6120<br>Haiti",
            link: "#"
        },
        {
            type: "telefòn",
            icon: "fas fa-phone",
            title: "telefòn",
            content: "+1 (728)2143510",
            link: "tel:+1 7282143510"
        },
        {
            type: "imèl",
            icon: "fas fa-envelope",
            title: "imèl",
            content: "konektemtv@gmail.com",
            link: "mailto:konektemtv@gmail.com"
        },
        {
            type: "website",
            icon: "fas fa-globe",
            title: "sit nou",
            content: "https://konektem.net",
            link: "https://Konektem.net"
        }
    ],
    mapText: "Interaktif Map - Lokalizasyon nou"
};

// Contact section function
function contactSection(contactData) {
    let contactCards = '';
    for(let index = 0; index < contactData.contactInfo.length; ++index) {
        contactCards += `
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="${contactData.contactInfo[index].icon}"></i>
                    </div>
                    <h3>${contactData.contactInfo[index].title}</h3>
                    <p>${contactData.contactInfo[index].content}</p>
                </div>`;
    }

    return `<div id="contact-section-container">
            <div id="contact-section" class="margin-rl-1 colDir container-outer pad-20 white-bg bdr-box">
                <div id="contact-section-bg" class="full-h"></div>
                <div class="section-info">
                    <h1> ${contactData.companyName.toUpperCase()}</h1>
                    <p>${contactData.description}</p>
                </div>
                <div id="contact-cards" class="container-inner">
                    ${contactCards}
                </div>
                <div class="map-container">
                    <div class="map-placeholder">
                        ${contactData.mapText}
                    </div>
                </div>
                <a href="/?p=home">
                    <div class="more-actions">
                        <span>Back to Home</span>
                        <ion-icon name="arrow-back-outline"></ion-icon>
                    </div>
                </a>
            </div>
            </div>`;
}

function pageInnerStyle(){
    const rootPageStyle = document.querySelector("#root-style");
    if(!rootPageStyle){
        console.log("contact page: no style container");
        return;
    }
    rootPageStyle.innerHTML = `
    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            color: #333;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .margin-rl-1 {
            margin: 0 1rem;
        }
        
        .colDir {
            flex-direction: column;
        }
        
        .container-outer {
            display: flex;
        }
        
        .pad-20 {
            padding: 20px;
        }
        
        .white-bg {
            background-color: white;
        }
        
        .bdr-box {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .full-h {
            height: 100%;
        }
        
        .section-info {
            margin-bottom: 30px;
            text-align: center;
        }
        
        .section-info h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .section-info p {
            color: #7f8c8d;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .container-inner {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        
        .contact-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            width: 100%;
            max-width: 350px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .contact-icon {
            width: 70px;
            height: 70px;
            background: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .contact-icon i {
            font-size: 30px;
            color: white;
        }
        
        .contact-card h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .contact-card p {
            color: #7f8c8d;
            line-height: 1.6;
        }
        
        .contact-link {
            color: #3498db;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .contact-link:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        
        .map-container {
            margin-top: 30px;
            width: 100%;
            height: 400px;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .map-placeholder {
            width: 100%;
            height: 100%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 1.2rem;
        }
        
        .more-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 30px;
            padding: 15px 30px;
            background: #3498db;
            color: white;
            border-radius: 30px;
            cursor: pointer;
            transition: background 0.3s ease;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
        
        .more-actions:hover {
            background: #2980b9;
        }
        
        .more-actions span {
            margin-right: 10px;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .container-inner {
                flex-direction: column;
                align-items: center;
            }
            
            .contact-card {
                max-width: 100%;
            }
            
            .section-info h1 {
                font-size: 2rem;
            }
        }`;
}


// Initialize contact section
export default function contactsPage() {
    let root = document.querySelector("#root");
    if(!root){
        console.log("contacts: root element not found");
        return;
    }
    pageInnerStyle();
    root.innerHTML = contactSection(contactData);
}

function ticketForm(eventData) {
    return `
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Хлебные крошки -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-600">
                    <li><a href="/" class="hover:text-purple-600">Главная</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="/?p=events" class="hover:text-purple-600">События</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-purple-600 font-medium">Покупка билетов</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Основная форма -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Оформление заказа</h2>
                        
                        <!-- Информация о событии -->
                        <div class="bg-purple-50 rounded-xl p-4 mb-6">
                            <div class="flex items-start space-x-4">
                                <img src="${eventData.image_location || '/images/event-placeholder.jpg'}" 
                                     alt="${eventData.title}" 
                                     class="w-20 h-20 rounded-lg object-cover">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-lg text-gray-800">${eventData.title}</h3>
                                    <p class="text-gray-600 text-sm mt-1">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        ${new Date(eventData.eventDate).toLocaleDateString('ru-RU')}
                                    </p>
                                    <p class="text-gray-600 text-sm">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        ${eventData.location}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-purple-600">$${eventData.price}</p>
                                    <p class="text-sm text-gray-500">за билет</p>
                                </div>
                            </div>
                        </div>

                        <form id="ticketOrderForm" class="space-y-6">
                            <!-- Количество билетов -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Количество билетов
                                </label>
                                <div class="flex items-center space-x-4">
                                    <button type="button" id="decrease-tickets-btn"
                                            class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                        <i class="fas fa-minus text-gray-500"></i>
                                    </button>
                                    <input type="number" id="ticketCount" name="ticket_count" 
                                           value="1" min="1" max="10"
                                           class="w-20 text-center border-0 text-xl font-semibold focus:ring-0">
                                    <button type="button" id="increase-tickets-btn" 
                                            class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                        <i class="fas fa-plus text-gray-500"></i>
                                    </button>
                                    <span class="text-gray-500">
                                        × $${eventData.price} = 
                                        <span id="totalAmount" class="text-purple-600 font-bold text-lg">
                                            $${eventData.price}
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <!-- Информация о покупателе -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">
                                        Имя *
                                    </label>
                                    <input type="text" id="firstName" name="first_name" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                                <div>
                                    <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">
                                        Фамилия *
                                    </label>
                                    <input type="text" id="lastName" name="last_name" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email *
                                    </label>
                                    <input type="email" id="email" name="email" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Телефон
                                    </label>
                                    <input type="tel" id="phone" name="phone"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                </div>
                            </div>

                            <!-- Способ оплаты -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Способ оплаты
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="relative flex cursor-pointer">
                                        <input type="radio" name="payment_method" value="card" checked 
                                               class="sr-only peer">
                                        <div class="w-full p-4 border-2 border-gray-200 rounded-lg peer-checked:border-purple-500 peer-checked:bg-purple-50">
                                            <div class="flex items-center">
                                                <i class="fas fa-credit-card text-purple-600 mr-3"></i>
                                                <span class="font-medium">Банковская карта</span>
                                            </div>
                                        </div>
                                    </label>
                                    <label class="relative flex cursor-pointer">
                                        <input type="radio" name="payment_method" value="paypal" 
                                               class="sr-only peer">
                                        <div class="w-full p-4 border-2 border-gray-200 rounded-lg peer-checked:border-purple-500 peer-checked:bg-purple-50">
                                            <div class="flex items-center">
                                                <i class="fab fa-paypal text-blue-600 mr-3"></i>
                                                <span class="font-medium">PayPal</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Соглашения -->
                            <div class="space-y-3">
                                <label class="flex items-start space-x-3">
                                    <input type="checkbox" required
                                           class="mt-1 w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <span class="text-sm text-gray-600">
                                        Я соглашаюсь с 
                                        <a href="/terms" class="text-purple-600 hover:underline">условиями обслуживания</a>
                                        и 
                                        <a href="/privacy" class="text-purple-600 hover:underline">политикой конфиденциальности</a>
                                    </span>
                                </label>
                                <label class="flex items-start space-x-3">
                                    <input type="checkbox" required
                                           class="mt-1 w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <span class="text-sm text-gray-600">
                                        Я подтверждаю, что мне исполнилось 18 лет
                                    </span>
                                </label>
                            </div>

                            <!-- Кнопка оплаты -->
                            <button type="submit" 
                                    class="w-full bg-purple-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:bg-purple-700 transition duration-200 flex items-center justify-center">
                                <i class="fas fa-lock mr-3"></i>
                                Перейти к оплате 
                                <span id="finalAmount" class="ml-2">$${eventData.price}</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Боковая панель -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ваш заказ</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Билеты</span>
                                <span id="orderTicketCount">1 × $${eventData.price}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Сбор за обслуживание</span>
                                <span id="serviceFee">$2.00</span>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Итого</span>
                                <span id="orderTotal">$${(parseFloat(eventData.price) + 2).toFixed(2)}</span>
                            </div>
                        </div>

                        <!-- Гарантии -->
                        <div class="border-t pt-4 space-y-3">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-shield-alt text-green-500 mt-1"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Безопасная оплата</p>
                                    <p class="text-xs text-gray-500">Ваши данные защищены</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-ticket-alt text-blue-500 mt-1"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Мгновенная доставка</p>
                                    <p class="text-xs text-gray-500">Билеты придут на email</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-undo text-orange-500 mt-1"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Возврат средств</p>
                                    <p class="text-xs text-gray-500">За 48 часов до события</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;
}

function updatePrices(ticketPrice, serviceFee) {
    const ticketCount = parseInt(document.getElementById('ticketCount').value) || 1;
    const subtotal = ticketCount * ticketPrice;
    const total = subtotal + serviceFee;

    document.getElementById('totalAmount').textContent = '\\$' + subtotal.toFixed(2);
    document.getElementById('finalAmount').textContent = '\\$' + total.toFixed(2);
    document.getElementById('orderTicketCount').textContent = ticketCount + ' × \\$' + ticketPrice;
    document.getElementById('orderTotal').textContent = '\\$' + total.toFixed(2);
}
function increaseTickets() {
    const input = document.getElementById('ticketCount');
    if (parseInt(input.value) < 10) {
        input.value = parseInt(input.value) + 1;
        updatePrices();
    }
}

function decreaseTickets() {
    const input = document.getElementById('ticketCount');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        updatePrices();
    }
}
function pageScript(eventData){
    	let ticketPrice = eventData.price;
        let serviceFee = 2.00;
    	const ticketDecreaseBtn = document.getElementById("decrease-tickets-btn");
    	const ticketIncreaseBtn = document.getElementById("increase-tickets-btn");
    	ticketDecreaseBtn.addEventListener("click", decreaseTickets);
    	ticketIncreaseBtn.addEventListener("click", increaseTickets);

		updatePrices(ticketPrice, serviceFee);

        // Обработка формы
        document.getElementById('ticketOrderForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const orderData = {
                event_id: eventData.id,
                ticket_count: parseInt(formData.get('ticket_count')),
                first_name: formData.get('first_name'),
                last_name: formData.get('last_name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                payment_method: formData.get('payment_method'),
                total_amount: (parseInt(formData.get('ticket_count')) * ticketPrice + serviceFee).toFixed(2)
            };

            try {
                const response = await fetch('/php/dbReader.php?q=createOrder&action=createOrder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(orderData)
                });

                const result = await response.json();
                
                if (result.success) {
                    // Перенаправление на страницу оплаты
                    window.location.href = '/?p=payments&f=event&id=' + result.order_id;
                } else {
                    alert('Ошибка при создании заказа: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error.message, response);
                alert('Произошла ошибка при отправке формы');
            }
        });

        // Инициализация
        document.getElementById('ticketCount').addEventListener('change', updatePrices);
        document.getElementById('ticketCount').addEventListener('input', updatePrices);
}

const styles = [
    "/experimental/CSS/ticketform.css",
]
export default async function ticketFormPage(event_id){
      try{
          let title = document.querySelector("title");
          if(!title){
              title = document.createElemnt("title");
              document.head.insertAdjacentElement("afterbegin", title);
          }
          title.textContent = "Konetkem";
          let root = document.querySelector("#root");
          if(!root){
              console.log("")
              return;
          }
          for(const src of styles){
            let linkTag = document.createElement("link");
            linkTag.rel = "stylesheet";
            linkTag.type = "text/css";
            linkTag.href = src;
            document.head.appendChild(linkTag);
          }
          let respone = await fetch('/php/dbReader.php?r=events');
          let data = await respone.json();
          const eventData = data.find(event => event.id === Number(event_id) );

          if(eventData){
              root.innerHTML = ticketForm(eventData);
              setTimeout(()=>{
                  pageScript(eventData);
              },200);
          } else {
              console.log("target event not found: " + event_id, eventData)
          }
      } catch (error){
          console.log("error processing event information");
      }
}
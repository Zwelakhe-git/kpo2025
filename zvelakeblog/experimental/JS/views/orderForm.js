
function serviceOrderForm(serviceData) {
    return `
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-8">
        <div class="max-w-3xl mx-auto px-4">
            <!-- Хлебные крошки -->
            <nav class="mb-8" style="margin-bottom: 35px;">
                <ol class="flex items-center space-x-2 text-sm text-gray-600" style="justify-content: space-evenly;">
                    <li><a href="/" class="hover:text-purple-600">Главная</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li><a href="/?p=services" class="hover:text-purple-600">Услуги</a></li>
                    <li><i class="fas fa-chevron-right text-xs"></i></li>
                    <li class="text-purple-600 font-medium">Заказ услуги</li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Основная форма -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl p-8 form-section-custom">
                        <div class="flex items-center mb-6">
                            <div class="bg-purple-100 p-3 rounded-lg mr-4">
                                <i class="fas fa-concierge-bell text-purple-600 text-2xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Заказ услуги</h2>
                                <p class="text-gray-600">Заполните форму и мы свяжемся с вами</p>
                            </div>
                        </div>

                        <form id="serviceOrderForm" class="space-y-6">
                            <input type="hidden" name="service_id" value="${serviceData.id}">
                            
                            <!-- Информация о услуге -->
                            <div class="bg-blue-50 rounded-xl p-4 mb-6">
                                <div class="flex items-start space-x-4">
                                    ${serviceData.image_location ? `
                                    <img src="${serviceData.image_location}" 
                                         alt="${serviceData.name}" 
                                         class="w-20 h-20 rounded-lg object-cover shadow">
                                    ` : `
                                    <div class="w-20 h-20 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-concierge-bell text-purple-600 text-2xl"></i>
                                    </div>
                                    `}
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-lg text-gray-800">${serviceData.name}</h3>
                                        <p class="text-gray-600 text-sm mt-1 line-clamp-2">${serviceData.description}</p>
                                        ${serviceData.price > 0 ? `
                                        <div class="mt-2">
                                            <span class="text-2xl font-bold text-purple-600">$${serviceData.price}</span>
                                            <span class="text-gray-500 text-sm ml-2">от</span>
                                        </div>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>

                            <!-- Информация о клиенте -->
                            <div class="form-group-custom">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-user-circle text-purple-600 mr-2"></i>
                                    Ваши контактные данные
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">
                                            ФИО *
                                        </label>
                                        <input type="text" id="full_name" name="full_name" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 form-input-custom"
                                               placeholder="Иванов Иван Иванович">
                                    </div>
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                            Телефон *
                                        </label>
                                        <input type="tel" id="phone" name="phone" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 form-input-custom"
                                               placeholder="+7 (999) 999-99-99">
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email *
                                    </label>
                                    <input type="email" id="email" name="email" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 form-input-custom"
                                           placeholder="example@email.com">
                                </div>
                            </div>

                            <!-- Дополнительная информация -->
                            <div class="form-group-custom">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                                    Дополнительная информация
                                    <span class="text-gray-400 text-xs font-normal ml-1">(необязательно)</span>
                                </label>
                                <textarea id="message" name="message" rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 form-input-custom resize-none"
                                          placeholder="Опишите детали заказа, особенности или требования..."></textarea>
                            </div>

                            <!-- Соглашения -->
                            <div class="form-group-custom">
                                <div class="space-y-3">
                                    <label class="flex items-start space-x-3">
                                        <input type="checkbox" name="privacy_policy" required
                                               class="mt-1 w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                        <span class="text-sm text-gray-600">
                                            Я соглашаюсь с обработкой персональных данных и 
                                            <a href="/privacy" class="text-purple-600 hover:underline">политикой конфиденциальности</a>
                                        </span>
                                    </label>
                                    <label class="flex items-start space-x-3">
                                        <input type="checkbox" name="contact_agree" required
                                               class="mt-1 w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                        <span class="text-sm text-gray-600">
                                            Я согласен на получение информации по указанным контактам
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- Кнопка отправки -->
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:from-purple-700 hover:to-blue-700 transition duration-200 flex items-center justify-center payment-btn-custom shadow-lg hover:shadow-xl">
                                <i class="fas fa-paper-plane mr-3"></i>
                                Отправить заявку
                            </button>

                            <div id="formMessage" class="hidden"></div>
                        </form>
                    </div>
                </div>

                <!-- Боковая панель -->
                <div class="lg:col-span-1" style="padding: 20px;">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-6 sidebar-enhanced"
                    style="padding: 20px;
                    margin: 0px auto;
                    "
                    >
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            Как это работает?
                        </h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex items-start space-x-3">
                                <div class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                    <span class="font-bold">1</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Заполните форму</p>
                                    <p class="text-sm text-gray-600">Укажите контактные данные и детали заказа</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                    <span class="font-bold">2</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Мы связываемся с вами</p>
                                    <p class="text-sm text-gray-600">В течение 1-2 часов в рабочее время</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                    <span class="font-bold">3</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Уточняем детали</p>
                                    <p class="text-sm text-gray-600">Обсуждаем сроки, стоимость и требования</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0">
                                    <span class="font-bold">4</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Выполняем работу</p>
                                    <p class="text-sm text-gray-600">Приступаем к выполнению услуги</p>
                                </div>
                            </div>
                        </div>

                        <!-- Контактная информация -->
                        <div class="border-t pt-4">
                            <h4 class="font-semibold text-gray-800 mb-3">Контакты для вопросов</h4>
                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-phone text-purple-600 mr-2 w-4"></i>
                                    <span>+7 (995) 953-16-11</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-envelope text-purple-600 mr-2 w-4"></i>
                                    <span>zwelakhemaseko02@gmail.com</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-clock text-purple-600 mr-2 w-4"></i>
                                    <span>Пн-Пт: 9:00-18:00</span>
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

export function initServiceOrderForm(serviceData) {
    const styles = [
        "/experimental/CSS/ticketform.css",
    ];
    
    // Загрузка стилей
    styles.forEach(src => {
        const linkTag = document.createElement("link");
        linkTag.rel = "stylesheet";
        linkTag.type = "text/css";
        linkTag.href = src;
        document.head.appendChild(linkTag);
    });

    // Установка заголовка
    let title = document.querySelector("title");
    if (!title) {
        title = document.createElement("title");
        document.head.insertAdjacentElement("afterbegin", title);
    }
    title.textContent = "MediaHub - Заказ услуги";

    // Функция для показа сообщений
    function showMessage(message, type = 'error') {
        const messageDiv = document.getElementById('formMessage');
        if (!messageDiv) return;
        
        messageDiv.className = type === 'success' 
            ? 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative' 
            : 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative';
        
        messageDiv.innerHTML = `
            <span class="font-medium">${type === 'success' ? '✓ Успешно!' : '✗ Ошибка!'}</span>
            <span class="block sm:inline ml-2">${message}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.classList.add('hidden')">
                <i class="fas fa-times"></i>
            </span>
        `;
        messageDiv.classList.remove('hidden');
        
        setTimeout(() => {
            messageDiv.classList.add('hidden');
        }, 8000);
    }

    // Маска телефона
    function formatPhoneNumber(input) {
        let value = input.value.replace(/\D/g, '');
        
        if (value.length > 0) {
            value = '+7' + value.substring(1);
        }
        
        if (value.length > 2) {
            value = value.substring(0, 2) + ' (' + value.substring(2);
        }
        if (value.length > 7) {
            value = value.substring(0, 7) + ') ' + value.substring(7);
        }
        if (value.length > 12) {
            value = value.substring(0, 12) + '-' + value.substring(12);
        }
        if (value.length > 15) {
            value = value.substring(0, 15) + '-' + value.substring(15, 17);
        }
        
        input.value = value;
    }

    // Анимация появления элементов
    function animateElements() {
        const elements = document.querySelectorAll('.form-section-custom, .sidebar-enhanced');
        elements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(20px)';
            setTimeout(() => {
                element.style.transition = 'all 0.6s ease';
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, index * 150);
        });
    }

    // Обработка формы
    function setupFormHandlers(serviceData) {
        const form = document.getElementById('serviceOrderForm');
        if (!form) return;

        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Отправка...';
            submitBtn.disabled = true;

            const formData = new FormData(this);
            let str = formData.get('full_name');
            const i = str.indexOf(' ');
            let first_name = "", last_name = "";
            if (i === -1) first_name = str;
            else [first_name, last_name] = [str.slice(0, i), str.slice(i + 1)];

            const orderData = {
                item_name: "service",
                item_id: formData.get('service_id'),
                first_name: first_name,
                last_name: last_name,
                email: formData.get('email'),
                phone: formData.get('phone'),
                message: formData.get('message'),
                total_amount: serviceData.price,
                privacy_policy: formData.get('privacy_policy') === 'on',
                contact_agree: formData.get('contact_agree') === 'on'
            };

            try {
                const response = await fetch('/php/dbReader.php?q=createOrder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(orderData)
                });

                const result = await response.json();
                
                if (result.success) {
                    showMessage(result.message, 'success');
                    // Очистка формы после успешной отправки
                    setTimeout(() => {
                        form.reset();
                        // Перенаправление на страницу благодарности или услуг
                        window.location.href = '/?p=payments&f=service&id=' + serviceData.id + '&orderid=' + result.order_id;
                    }, 5000);
                } else {
                    showMessage(result.message || 'Произошла ошибка при отправке формы');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Произошла ошибка при отправке формы. Пожалуйста, попробуйте еще раз.');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Инициализация маски телефона
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                formatPhoneNumber(this);
            });
            
            phoneInput.addEventListener('blur', function() {
                if (this.value && this.value.replace(/\D/g, '').length < 11) {
                    showMessage('Пожалуйста, введите полный номер телефона');
                }
            });
        }
    }

    // Инициализация всех обработчиков
    setTimeout(() => {
        setupFormHandlers(serviceData);
        animateElements();
    }, 100);
}

export default async function serviceForm(id){
    const root = document.querySelector('#root');

    let serviceData = await fetch('/php/dbReader.php?r=services');
    serviceData = await serviceData.json();
    serviceData = serviceData.find(svc => svc.id == id);
    root.innerHTML = serviceOrderForm(serviceData);

    setTimeout(()=>{
        initServiceOrderForm(serviceData);
    },300);
}
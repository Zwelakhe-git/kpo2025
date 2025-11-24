    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Дополнительные скрипты для админ-панели -->
    <script>
        // Автозакрытие алертов через 5 секунд
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Подтверждение удаления
        function confirmDelete(message = 'Вы уверены, что хотите удалить этот элемент?') {
            return confirm(message);
        }

        // Превью изображений перед загрузкой
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const file = input.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.addEventListener('load', function() {
                    preview.src = reader.result;
                    preview.style.display = 'block';
                });
                
                reader.readAsDataURL(file);
            }
        }

        // Инициализация превью для всех file input
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const previewId = this.getAttribute('data-preview');
                if (previewId) {
                    previewImage(this, previewId);
                }
            });
        });

        // Динамическое обновление счетчиков символов для textarea
        document.querySelectorAll('textarea[data-max-length]').forEach(textarea => {
            const maxLength = textarea.getAttribute('data-max-length');
            const counterId = textarea.getAttribute('data-counter');
            
            if (counterId) {
                const counter = document.getElementById(counterId);
                if (counter) {
                    textarea.addEventListener('input', function() {
                        const remaining = maxLength - this.value.length;
                        counter.textContent = remaining + ' символов осталось';
                        counter.className = remaining < 50 ? 'form-text text-danger' : 'form-text text-muted';
                    });
                }
            }
        });
    </script>
</body>
</html>
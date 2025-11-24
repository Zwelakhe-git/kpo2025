<?php require_once ROOT_PATH . '/views/layout/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Управление заказами</h2>
    <div class="btn-group">
        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
            <i class="fas fa-download me-2"></i>Экспорт
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
            <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
        </ul>
    </div>
</div>

<!-- Фильтры и статистика -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= count($orders) ?></h4>
                        <small>Всего заказов</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= count(array_filter($orders, fn($order) => $order['payment_status'] === 'paid')) ?></h4>
                        <small>Оплаченные</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= count(array_filter($orders, fn($order) => $order['payment_status'] === 'pending')) ?></h4>
                        <small>Ожидают оплаты</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0"><?= count(array_filter($orders, fn($order) => $order['order_status'] === 'cancelled')) ?></h4>
                        <small>Отмененные</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Фильтры -->
<div class="card mb-4">
    <div class="card-body">
        <form class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Статус заказа</label>
                <select class="form-select" onchange="filterOrders()" id="statusFilter">
                    <option value="">Все статусы</option>
                    <option value="pending">Ожидание</option>
                    <option value="confirmed">Подтвержден</option>
                    <option value="cancelled">Отменен</option>
                    <option value="completed">Завершен</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Статус оплаты</label>
                <select class="form-select" onchange="filterOrders()" id="paymentFilter">
                    <option value="">Все статусы</option>
                    <option value="pending">Ожидает оплаты</option>
                    <option value="paid">Оплачен</option>
                    <option value="failed">Ошибка оплаты</option>
                    <option value="refunded">Возврат</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Дата от</label>
                <input type="date" class="form-control" onchange="filterOrders()" id="dateFrom">
            </div>
            <div class="col-md-3">
                <label class="form-label">Дата до</label>
                <input type="date" class="form-control" onchange="filterOrders()" id="dateTo">
            </div>
        </form>
    </div>
</div>

<div class="card" style="margin-bottom: 20px">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Список заказов</h5>
        <span class="badge bg-primary"><?= count($orders) ?> заказов</span>
    </div>
    <div class="card-body p-0">
        <?php if (empty($orders)): ?>
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Заказы не найдены</h4>
            <p class="text-muted">Здесь будут отображаться заказы на билеты</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="ordersTable">
                <thead class="table-light">
                    <tr>
                        <th width="80">ID</th>
                        <th width="120">Дата</th>
                        <th>Клиент</th>
                        <th>Событие</th>
                        <th width="100" class="text-center">Билеты</th>
                        <th width="120" class="text-center">Сумма</th>
                        <th width="140" class="text-center">Статус заказа</th>
                        <th width="140" class="text-center">Статус оплаты</th>
                        <th width="120" class="text-center">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr class="order-row" 
                        data-status="<?= $order['order_status'] ?>" 
                        data-payment="<?= $order['payment_status'] ?>"
                        data-date="<?= $order['order_date'] ?>">
                        <td class="fw-bold">#<?= $order['id'] ?></td>
                        <td>
                            <small class="text-muted">
                                <?= date('d.m.Y', strtotime($order['order_date'])) ?><br>
                                <?= date('H:i', strtotime($order['order_date'])) ?>
                            </small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3" 
                                     style="width: 40px; height: 40px; font-size: 14px;">
                                    <?= substr($order['first_name'], 0, 1) . substr($order['last_name'], 0, 1) ?>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></h6>
                                    <small class="text-muted"><?= htmlspecialchars($order['email']) ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <h6 class="mb-0"><?= htmlspecialchars($order['event_title']) ?></h6>
                            <small class="text-muted">ID: <?= $order['event_id'] ?></small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border"><?= $order['ticket_count'] ?> шт.</span>
                        </td>
                        <td class="text-center">
                            <strong class="text-success">$<?= number_format($order['total_amount'], 2) ?></strong>
                        </td>
                        <td class="text-center">
                            <?php
                            $statusBadges = [
                                'pending' => ['bg-warning', 'Ожидание'],
                                'confirmed' => ['bg-info', 'Подтвержден'],
                                'cancelled' => ['bg-danger', 'Отменен'],
                                'completed' => ['bg-success', 'Завершен']
                            ];
                            $status = $statusBadges[$order['order_status']] ?? $statusBadges['pending'];
                            ?>
                            <span class="badge <?= $status[0] ?>"><?= $status[1] ?></span>
                        </td>
                        <td class="text-center">
                            <?php
                            $paymentBadges = [
                                'pending' => ['bg-warning', 'Ожидает'],
                                'paid' => ['bg-success', 'Оплачен'],
                                'failed' => ['bg-danger', 'Ошибка'],
                                'refunded' => ['bg-secondary', 'Возврат']
                            ];
                            $payment = $paymentBadges[$order['payment_status']] ?? $paymentBadges['pending'];
                            ?>
                            <span class="badge <?= $payment[0] ?>"><?= $payment[1] ?></span>
                            <?php if ($order['payment_status'] === 'paid' && $order['payment_date']): ?>
                            <br><small class="text-muted"><?= date('d.m.Y', strtotime($order['payment_date'])) ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm w-100">
                                <button type="button" class="btn btn-outline-primary" 
                                        onclick="viewOrder(<?= $order['id'] ?>)" 
                                        title="Просмотреть">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-outline-success" 
                                        onclick="editOrder(<?= $order['id'] ?>)" 
                                        title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" 
                                            data-bs-toggle="dropdown" title="Действия">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php if ($order['payment_status'] === 'pending'): ?>
                                        <li>
                                            <a class="dropdown-item" href="#" 
                                               onclick="updatePaymentStatus(<?= $order['id'] ?>, 'paid')">
                                                <i class="fas fa-check text-success me-2"></i>Отметить оплаченным
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <?php if ($order['order_status'] !== 'cancelled'): ?>
                                        <li>
                                            <a class="dropdown-item" href="#" 
                                               onclick="updateOrderStatus(<?= $order['id'] ?>, 'cancelled')">
                                                <i class="fas fa-times text-danger me-2"></i>Отменить заказ
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item text-danger" href="#" 
                                               onclick="deleteOrder(<?= $order['id'] ?>)">
                                                <i class="fas fa-trash me-2"></i>Удалить
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <div class="card-footer bg-light">
        <div class="row align-items-center">
            <div class="col-md-6">
                <small class="text-muted">
                    Показано <span id="shownCount"><?= count($orders) ?></span> из <?= count($orders) ?> заказов
                </small>
            </div>
            <div class="col-md-6">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm justify-content-end mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Пред.</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">След.</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для просмотра заказа -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Детали заказа #<span id="modalOrderId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderDetails">
                <!-- Детали заказа будут загружены здесь -->
            </div>
        </div>
    </div>
</div>

<script>
// Фильтрация заказов
function filterOrders() {
    const statusFilter = document.getElementById('statusFilter').value;
    const paymentFilter = document.getElementById('paymentFilter').value;
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    
    const rows = document.querySelectorAll('.order-row');
    let shownCount = 0;
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        const payment = row.getAttribute('data-payment');
        const orderDate = row.getAttribute('data-date').split(' ')[0];
        
        let show = true;
        
        if (statusFilter && status !== statusFilter) show = false;
        if (paymentFilter && payment !== paymentFilter) show = false;
        if (dateFrom && orderDate < dateFrom) show = false;
        if (dateTo && orderDate > dateTo) show = false;
        
        row.style.display = show ? '' : 'none';
        if (show) shownCount++;
    });
    
    document.getElementById('shownCount').textContent = shownCount;
}

// Просмотр заказа
function viewOrder(orderId) {
    // Здесь будет AJAX запрос для получения деталей заказа
    document.getElementById('modalOrderId').textContent = orderId;
    document.getElementById('orderDetails').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Загрузка...</span>
            </div>
            <p class="mt-2">Загрузка деталей заказа...</p>
        </div>
    `;
    
    // В реальном проекте здесь будет fetch запрос
    setTimeout(() => {
        document.getElementById('orderDetails').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Информация о клиенте</h6>
                    <p><strong>Имя:</strong> <span id="clientName">Загрузка...</span></p>
                    <p><strong>Email:</strong> <span id="clientEmail">Загрузка...</span></p>
                    <p><strong>Телефон:</strong> <span id="clientPhone">Загрузка...</span></p>
                </div>
                <div class="col-md-6">
                    <h6>Информация о заказе</h6>
                    <p><strong>Событие:</strong> <span id="eventTitle">Загрузка...</span></p>
                    <p><strong>Количество билетов:</strong> <span id="ticketCount">Загрузка...</span></p>
                    <p><strong>Общая сумма:</strong> <span id="totalAmount">Загрузка...</span></p>
                </div>
            </div>
            <div class="mt-3">
                <h6>История статусов</h6>
                <ul class="list-group">
                    <li class="list-group-item">Заказ создан: ${new Date().toLocaleString('ru-RU')}</li>
                </ul>
            </div>
        `;
    }, 1000);
    
    new bootstrap.Modal(document.getElementById('orderModal')).show();
}

// Редактирование заказа
function editOrder(orderId) {
    window.location.href = `?action=orders&method=edit&id=${orderId}`;
}

// Обновление статуса заказа
function updateOrderStatus(orderId, status) {
    if (confirm('Вы уверены, что хотите изменить статус заказа?')) {
        // AJAX запрос для обновления статуса
        fetch(`/php/dbReader.php?q=updateOrderStatus&action=updateOrderStatus`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Ошибка при обновлении статуса');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка');
        });
    }
}

// Обновление статуса оплаты
function updatePaymentStatus(orderId, status) {
    if (confirm('Отметить заказ как оплаченный?')) {
        // AJAX запрос для обновления статуса оплаты
        fetch(`/php/dbReader.php?q=updatePaymentStatus&action=updatePaymentStatus`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Ошибка при обновлении статуса оплаты');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка');
        });
    }
}

// Удаление заказа
function deleteOrder(orderId) {
    if (confirm('Вы уверены, что хотите удалить этот заказ? Это действие нельзя отменить.')) {
        // AJAX запрос для удаления заказа
        fetch(`/php/dbReader.php?q=deleteOrder&action=deleteOrder`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Ошибка при удалении заказа');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Произошла ошибка');
        });
    }
}

// Инициализация
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<style>
.order-row:hover {
    background-color: #f8f9fa;
}
.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.badge {
    font-size: 0.75rem;
}
</style>

<?php require_once ROOT_PATH . '/views/layout/footer.php'; ?>
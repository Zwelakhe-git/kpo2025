<?php
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use Mpdf\Mpdf;
use Dompdf\Dompdf;
use setasign\Fpdi\Fpdi;

class Email {
    private $mail;
    private $config;
    
    public function __construct($from_email = SITE_EMAIL, $reply_to = SITE_EMAIL, array $config = []) {
        // Конфигурация по умолчанию
        $this->config = array_merge([
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_secure' => 'tls',
            'smtp_auth' => true,
            'smtp_debug' => SMTP::DEBUG_OFF, // SMTP::DEBUG_SERVER для отладки
            'charset' => 'UTF-8',
            'encoding' => 'base64',
            'timeout' => 30,
            'from_email' => $from_email,
            'from_name' => 'Zwelakhe',
            'reply_to' => $reply_to,
            'reply_to_name' => 'Zwelakhe Support'
        ], $config);
        
        $this->mail = new PHPMailer(true);
        $this->setupSMTP();
    }
    
    private function setupSMTP() {
        $this->mail->isSMTP();
        $this->mail->Host = $this->config['smtp_host'];
        $this->mail->Port = $this->config['smtp_port'];
        $this->mail->SMTPAuth = $this->config['smtp_auth'];
        $this->mail->Username = SITE_EMAIL;
        $this->mail->Password = GOOGLE_EMAIL_PASSWORD;
        $this->mail->SMTPSecure = $this->config['smtp_secure'];
        $this->mail->SMTPDebug = $this->config['smtp_debug'];
        $this->mail->CharSet = $this->config['charset'];
        $this->mail->Encoding = $this->config['encoding'];
        $this->mail->Timeout = $this->config['timeout'];
        
        // Логирование в файл вместо вывода
        if ($this->config['smtp_debug'] > SMTP::DEBUG_OFF) {
            $this->mail->Debugoutput = function($str, $level) {
                $logFile = __DIR__ . '/../logs/email.log';
                file_put_contents($logFile, date('[H:i:s] ') . "[$level] $str\n", FILE_APPEND);
            };
        }
        
        // Отключение проверки SSL для локальной разработки (опционально)
        if (defined('DEV_MODE') && DEV_MODE === true) {
            $this->mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];
        }
    }
    
    /**
     * Подготовка письма
     */
    public function prepare($subject, $to_address, $to_name, $body_html, $body_alt = '') {
        // Валидация email
        if (!$this->validateEmail($to_address)) {
            throw new InvalidArgumentException("Invalid email address: $to_address");
        }
        
        // Безопасное добавление получателя
        $this->mail->setFrom(
            $this->config['from_email'], 
            $this->encodeHeader($this->config['from_name'])
        );
        
        // Reply-To
        $this->mail->addReplyTo(
            $this->config['reply_to'],
            $this->encodeHeader($this->config['reply_to_name'])
        );
        
        // Получатель
        $this->mail->addAddress($to_address, $this->encodeHeader($to_name));
        
        // Тема (безопасно)
        $this->mail->Subject = $this->encodeHeader(htmlspecialchars($subject, ENT_QUOTES, 'UTF-8'));
        
        // HTML тело
        $this->mail->isHTML(true);
        $this->mail->Body = $body_html;
        
        // Альтернативное текстовое тело
        if (empty($body_alt)) {
            $body_alt = $this->htmlToText($body_html);
        }
        $this->mail->AltBody = $body_alt;
        
        // Добавляем встроенные изображения
        $this->addEmbeddedImages($body_html);
        
        return $this;
    }
    
    /**
     * Добавление вложений
     */
    public function addAttachment($path, $name = '', $encoding = 'base64', $type = '') {
        $this->mail->addAttachment($path, $name, $encoding, $type);
        return $this;
    }
    
    /**
     * Добавление CC
     */
    public function addCC($address, $name = '') {
        $this->mail->addCC($address, $this->encodeHeader($name));
        return $this;
    }
    
    /**
     * Добавление BCC
     */
    public function addBCC($address, $name = '') {
        $this->mail->addBCC($address, $this->encodeHeader($name));
        return $this;
    }
    
    /**
     * Отправка письма
     */
    public function send() {
        try {
            $this->mail->send();
            
            // Логирование успешной отправки
            $this->log('SUCCESS', 'Email sent successfully', [
                'to' => $this->mail->getToAddresses(),
                'subject' => $this->mail->Subject
            ]);
            
            return [
                'status' => 'success',
                'message' => 'Email sent successfully!',
                'message_id' => $this->mail->getLastMessageID()
            ];
            
        } catch (Exception $e) {
            // Логирование ошибки
            $this->log('ERROR', 'Email sending failed', [
                'error' => $this->mail->ErrorInfo,
                'exception' => $e->getMessage(),
                'to' => $this->mail->getToAddresses()
            ]);
            
            return [
                'status' => 'error',
                'message' => 'Email could not be sent.',
                'error' => $this->mail->ErrorInfo,
                'error_code' => $e->getCode()
            ];
        } finally {
            // Очистка получателей после отправки
            $this->mail->clearAddresses();
            $this->mail->clearCCs();
            $this->mail->clearBCCs();
            $this->mail->clearAttachments();
            $this->mail->clearReplyTos();
        }
    }
    
    /**
     * Валидация email
     */
    private function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Кодирование заголовков
     */
    private function encodeHeader($str) {
        if (preg_match('/[^\x20-\x7E]/', $str)) {
            return mb_encode_mimeheader($str, 'UTF-8', 'Q');
        }
        return $str;
    }
    
    /**
     * Преобразование HTML в текст
     */
    private function htmlToText($html) {
        $text = strip_tags($html);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        // Удаляем лишние переносы строк
        $text = preg_replace('/(\r\n|\r|\n){2,}/', "\n\n", $text);
        
        return $text;
    }
    
    /**
     * Автоматическое добавление встроенных изображений из HTML
     */
    private function addEmbeddedImages($html) {
        // Ищем все img с src начинающимся на cid:
        preg_match_all('/<img[^>]+src=["\']cid:([^"\']+)["\'][^>]*>/i', $html, $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $cid) {
                // Проверяем существование файла по CID
                $imagePath = $this->findImageByCid($cid);
                if ($imagePath && file_exists($imagePath)) {
                    $this->mail->addEmbeddedImage($imagePath, $cid, basename($imagePath));
                }
            }
        }
        
        // Всегда добавляем логотип, если он существует
        $logoPath = __DIR__ . '/../media/images/favicon.png';
        if (file_exists($logoPath)) {
            $this->mail->addEmbeddedImage($logoPath, 'logo', 'favicon.png');
        }
    }
    
    /**
     * Поиск изображения по CID
     */
    private function findImageByCid($cid) {
        $possiblePaths = [
            __DIR__ . '/../media/images/' . $cid . '.png',
            __DIR__ . '/../media/images/' . $cid . '.jpg',
            __DIR__ . '/../media/images/' . $cid . '.jpeg',
            __DIR__ . '/../media/images/' . $cid . '.gif',
            __DIR__ . '/../uploads/' . $cid,
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }
        
        return null;
    }
    
    /**
     * Логирование
     */
    private function log($level, $message, $context = []) {
        $logDir = __DIR__ . '/../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        $logFile = $logDir . '/email.log';
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? json_encode($context, JSON_UNESCAPED_UNICODE) : '';
        
        $logLine = "[$timestamp] [$level] $message $contextStr\n";
        file_put_contents($logFile, $logLine, FILE_APPEND);
        
        // Также в системный лог PHP
        error_log("Email $level: $message");
    }
    
    /**
     * Получение объекта PHPMailer для расширенного использования
     */
    public function getMailer() {
        return $this->mail;
    }
    
    /**
     * Статический метод для быстрой отправки
     */
    public static function sendQuick($to, $subject, $body_html, $body_alt = '') {
        $email = new self();
        $email->prepare($subject, $to, '', $body_html, $body_alt);
        return $email->send();
    }

    /**
     * Генерация PDF из HTML и прикрепление к письму
     */
    public function addPdfReceipt($html, $filename = 'receipt.pdf', $options = []) {
        $pdf = $this->generatePDFWithDompdf($html, $options);
        
        // Сохраняем временный файл
        $tempFile = sys_get_temp_dir() . '/' . uniqid('receipt_') . '.pdf';
        file_put_contents($tempFile, $pdf);
        
        // Прикрепляем к письму
        $this->mail->addAttachment($tempFile, $filename, 'base64', 'application/pdf');
        
        // Возвращаем путь для возможности удаления
        return $tempFile;
    }
    
    /**
     * Генерация PDF с использованием mPDF (рекомендуется)
     */
    private function generatePDF($html, $options = []) {
        $defaultOptions = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P', // P - portrait, L - landscape
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
            'margin_header' => 9,
            'margin_footer' => 9,
            'default_font' => 'dejavusans' // Поддержка кириллицы
        ];
        
        $config = array_merge($defaultOptions, $options);
        
        try {
            $mpdf = new Mpdf($config);
            
            // Добавляем водяной знак
            if (!empty($options['watermark'])) {
                $mpdf->SetWatermarkText($options['watermark']);
                $mpdf->showWatermarkText = true;
                $mpdf->watermark_font = 'dejavusans';
                $mpdf->watermarkTextAlpha = 0.1;
            }
            
            // Добавляем заголовок и подвал
            if (!empty($options['header'])) {
                $mpdf->SetHTMLHeader($options['header']);
            }
            
            if (!empty($options['footer'])) {
                $mpdf->SetHTMLFooter($options['footer']);
            }
            
            // Записываем HTML
            $mpdf->WriteHTML($html);
            
            return $mpdf->Output('', 'S'); // 'S' - вернуть как строку
            
        } catch (Exception $e) {
            throw new Exception("PDF generation failed: " . $e->getMessage());
        }
    }
    
    /**
     * Альтернатива: Генерация PDF с Dompdf
     */
    private function generatePDFWithDompdf($html, $options = []) {
        $defaultOptions = [
            'defaultFont' => 'DejaVu Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 150
        ];
        
        $dompdf = new Dompdf($defaultOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', $options['orientation'] ?? 'portrait');
        $dompdf->render();
        
        return $dompdf->output();
    }
    
    /**
     * Генерация чека из данных транзакции
     */
    public function createReceiptPDF($html) {
        //$html = $this->getReceiptHTML($transaction_data);
        return $this->addPdfReceipt($html, 'receipt_' . $transaction_data['payment_id'] . '.pdf', [
            'watermark' => 'PAID',
            'header' => $this->getReceiptHeader($transaction_data),
            'footer' => $this->getReceiptFooter()
        ]);
    }
    
    /**
     * HTML шаблон для чека
     */
    
    
    private function getReceiptHeader($data) {
        return '
        <div style="text-align: center; font-size: 10px; color: #666;">
            Invoice #' . htmlspecialchars($data['order_id']) . ' | ' . date('M d, Y', strtotime($data['date'])) . '
        </div>';
    }
    
    private function getReceiptFooter() {
        return '
        <div style="text-align: center; font-size: 8px; color: #999;">
            Page {PAGENO} of {nb} | ' . date('Y-m-d H:i:s') . '
        </div>';
    }
}
?>
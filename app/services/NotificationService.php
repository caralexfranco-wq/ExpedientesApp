<?php

declare(strict_types=1);

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;

class NotificationService
{
    public function sendEmail(string $to, string $subject, string $body): bool
    {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = config('mail.host');
        $mail->Port = (int) config('mail.port');
        $mail->SMTPAuth = config('mail.username') !== '';
        $mail->Username = config('mail.username');
        $mail->Password = config('mail.password');
        $mail->setFrom(config('mail.from_address'), config('mail.from_name'));
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;
        return $mail->send();
    }

    public function sendWhatsapp(string $to, string $message): bool
    {
        $provider = config('whatsapp.provider');
        if ($provider === 'twilio') {
            $sid = config('whatsapp.twilio_sid');
            $token = config('whatsapp.token');
            $from = config('whatsapp.twilio_from');
            $payload = http_build_query(['To' => "whatsapp:$to", 'From' => "whatsapp:$from", 'Body' => $message]);
            $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";
        } else {
            $token = config('whatsapp.token');
            $phoneId = config('whatsapp.phone_id');
            $payload = json_encode([
                'messaging_product' => 'whatsapp',
                'to' => $to,
                'type' => 'text',
                'text' => ['body' => $message],
            ]);
            $url = "https://graph.facebook.com/v21.0/{$phoneId}/messages";
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token, 'Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        return $status >= 200 && $status < 300;
    }
}

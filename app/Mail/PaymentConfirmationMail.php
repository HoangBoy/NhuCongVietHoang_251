<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PaymentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $orderData;
    /**
     *  Khởi tạo một instance mới của `PaymentConfirmationMail`..
     */
    public function __construct($orderData)
    {
        $this->orderData = $orderData;
    }

    /**
     * Định nghĩa tiêu đề email..
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Confirmation Mail',
        );
    }

    /**
     * Định nghĩa nội dung email.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment_confirmation',
        );
    }

    /**
     * Thêm file đính kèm nếu cần.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    /**
     *  Xây dựng email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Payment Confirmation')
                    ->view('emails.payment_confirmation')
                    ->with('orderData', $this->orderData);
    }
}

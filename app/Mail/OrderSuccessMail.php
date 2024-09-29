<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Admin\Models\Order;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderSuccessMail extends Mailable
{
    use Queueable, SerializesModels;
    public $orderID;
    public $billPath;
    /**
     * Create a new message instance.
     */
    public function __construct($orderID, $billPath = null)
    {
        $this->orderID = $orderID;
        $this->billPath = $billPath;  // The path to the bill PDF
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $orderDetails = Order::with([
            'customer',
            'orderProducts',
            'delivaryLocation'
        ])->where('id', $this->orderID)->first();

        return new Content(
            view: 'emails.order-success',  // Referencing the correct view
            with: [
                'order' => $orderDetails,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Generate PDF in-memory and attach it without saving
        $order = Order::with(['customer', 'orderProducts', 'delivaryLocation'])
            ->find($this->orderID)->first();
        $pdf = Pdf::loadView('pdf.bill', compact('order'));
        // download 
        $pdf->download('invoice_order_' . $this->orderID . '.pdf');
        return [
            Attachment::fromData(fn() => $pdf->output(), 'invoice_order_' . $this->orderID . '.pdf')
                ->withMime('application/pdf')
        ];
    }
}

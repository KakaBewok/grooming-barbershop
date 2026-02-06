<?php

namespace App\Services;

use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\Log;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class ReceiptPrinterService
{
    protected $printer;
    protected $connector;

    public function printOrder(Order $order)
    {
        try {
            $this->connect();

            if (!$this->printer) {
                throw new Exception("Could not connect to printer.");
            }

            $barbershop = \App\Models\Barbershop::first();
            $shopName = $barbershop->name ?? config('printer.receipt.shop_name');
            $address = $barbershop->address ?? config('printer.receipt.address');
            $phone = $barbershop->phone ?? config('printer.receipt.phone');

            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            
            // Header
            $this->printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH | Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_EMPHASIZED);
            $this->printer->text($shopName . "\n");
            $this->printer->selectPrintMode();
            $this->printer->text($address . "\n");
            $this->printer->text("Telp/WA: " . $phone . "\n");
            $this->printer->text(str_repeat("-", 32) . "\n");

            // Transaction Info
            $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->printer->text("Invoice: " . $order->order_number . "\n");
            $this->printer->text("Tanggal: " . $order->order_date->format('d/m/Y H:i') . "\n");
            $this->printer->text("Kasir  : " . ($order->creator->name ?? 'Admin') . "\n");
            $this->printer->text(str_repeat("-", 32) . "\n");

            // Items
            foreach ($order->items as $item) {
                $name = $item->item_name;
                $qty = $item->quantity;
                $price = number_format($item->price, 0, ',', '.');
                $subtotal = number_format($item->subtotal, 0, ',', '.');

                $this->printer->text($name . "\n");
                $this->printer->text(sprintf("%dx %s", $qty, $price));
                $this->printer->setJustification(Printer::JUSTIFY_RIGHT);
                $this->printer->text($subtotal . "\n");
                $this->printer->setJustification(Printer::JUSTIFY_LEFT);
            }

            $this->printer->text(str_repeat("-", 32) . "\n");

            // Summary
            $this->printer->setJustification(Printer::JUSTIFY_RIGHT);
            $this->printer->text("Total: Rp " . number_format($order->total_amount, 0, ',', '.') . "\n");
            if ($order->discount > 0) {
                $this->printer->text("Diskon: Rp " . number_format($order->discount, 0, ',', '.') . "\n");
                $this->printer->text("Grand Total: Rp " . number_format($order->final_amount, 0, ',', '.') . "\n");
            }
            
            $this->printer->text(str_repeat("-", 32) . "\n");
            $this->printer->text("Metode: " . strtoupper($order->payment_method->value) . "\n");
            
            // Amount Paid and Change (if fields exist)
            if (isset($order->total_paid) && $order->total_paid > 0) {
                $this->printer->text("Bayar: Rp " . number_format($order->total_paid, 0, ',', '.') . "\n");
                $this->printer->text("Kembali: Rp " . number_format($order->change_amount, 0, ',', '.') . "\n");
            }

            $this->printer->text("\n");

            // Footer
            $this->printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->printer->text(config('printer.receipt.footer') . "\n");
            $this->printer->text(date('Y-m-d H:i:s') . "\n\n");
            
            // Cut paper
            $this->printer->cut();
            $this->printer->close();
            $this->printer = null;

            return true;
        } catch (\Throwable $e) {
            Log::error("Printer Error: " . $e->getMessage());
            
            // Try to close only if it wasn't already closed
            if ($this->printer) {
                try {
                    $this->printer->close();
                } catch (\Throwable $err) {
                    // Silently ignore cleanup errors to prevent crashing the POS
                }
                $this->printer = null;
            }
            
            return false;
        }
    }

    protected function connect()
    {
        $connection = config('printer.connection');

        try {
            switch ($connection) {
                case 'network':
                    $this->connector = new NetworkPrintConnector(
                        config('printer.network.ip'),
                        config('printer.network.port')
                    );
                    break;
                case 'usb':
                    if (PHP_OS_FAMILY === 'Windows') {
                        $this->connector = new WindowsPrintConnector(config('printer.usb.name'));
                    } else {
                        $this->connector = new FilePrintConnector(config('printer.usb.name'));
                    }
                    break;
                default:
                    throw new Exception("Unsupported printer connection: {$connection}");
            }

            if ($this->connector) {
                $this->printer = new Printer($this->connector);
            }
        } catch (Exception $e) {
            Log::error("Failed to connect to printer: " . $e->getMessage());
            $this->printer = null;
        }
    }
}

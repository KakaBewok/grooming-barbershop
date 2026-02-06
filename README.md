# Grooming Barbershop POS & Landing Page

A modern Barbershop Web Application and Point of Sale (POS) system built with Laravel 12. This project provides a stunning public-facing landing page for clients and a robust administrative backend for managing daily barbershop operations, transactions, and thermal receipt printing.

## Features

- **Public Landing Page**: Premium Neo-Brutalist design showcasing grooming services and products with a direct WhatsApp booking CTA.
- **POS System**: Integrated Point of Sale via Filament for manual order creation by cashiers/admin.
- **Transaction Management**: Real-time tracking of orders, payments, and statuses.
- **Inventory Handling**: Management system for both services (e.g., Haircut) and physical products (e.g., Pomade).
- **Thermal Receipt Printing**: Automated and manual ESC/POS receipt printing for completed transactions.
- **Responsive UI**: Mobile-optimized swipeable carousels for clients and a clean grid layout for desktop users.

## Tech Stack

- **Framework**: Laravel 12
- **Admin Panel**: Filament v3
- **Frontend Interactivity**: Livewire
- **Styling**: TailwindCSS
- **Database**: MySQL
- **Printing Engine**: `mike42/escpos-php`
- **Design System**: Neo-Brutalist Aesthetic

## Project Structure

- `app/Filament`: Contains all POS resources (Orders, Services, Products). This is the "brain" of the POS system.
- `app/Models`: Core data structures for Orders, OrderItems, Products, and Services.
- `app/Services`: Contains `ReceiptPrinterService.php` which handles ESC/POS logic.
- `resources/views/components`: Reusable Blade components including `service-card` and `product-card`.
- `resources/views/livewire`: Standard Livewire components for dynamic frontend elements like `ServicesList`.
- `config/printer.php`: Centralized configuration for thermal printer settings.

## Installation & Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd grooming-barbershop
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment Configuration**
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   Configure your database credentials in `.env`, then run:
   ```bash
   php artisan migrate --seed
   ```

5. **Filament Setup**
   Create an admin user to access the POS:
   ```bash
   php artisan make:filament-user
   ```

## POS Workflow Explanation

1. **Create Order**: Admin navigates to the "Orders" module and clicks "Create".
2. **Add Items**: Select services or products. The system automatically fetches prices and calculates the subtotal.
3. **Payment**: Enter the "Amount Paid". The system calculates the "Change" automatically.
4. **Checkout**: Select the status (e.g., Completed) and Payment Method (Cash/Transfer).
5. **Print Receipt**: Upon saving, a receipt is generated and sent to the thermal printer (Automatic printing is configurable).

## Thermal Printer Setup

### Supported Printer Types
The system supports standard 58mm or 80mm thermal printers via:
- **USB**: Local physical connection (requires printer sharing on Windows).
- **Network**: IP-based connection via Ethernet or Wi-Fi.

### Required Library & Extensions
We use the `mike42/escpos-php` library. Ensure your environment has the following PHP extensions enabled:
- `mbstring`
- `gd` (required for image/logo printing if used)

### Configuration
Printer settings are managed via `.env` or `config/printer.php`.

**For USB (Windows Shared Printer):**
1. Share your printer in Windows (e.g., share name: `POS-58`).
2. Set `.env`:
   ```env
   PRINTER_CONNECTION=usb
   PRINTER_USB_NAME=POS-58
   ```

**For Network (Ethernet/Static IP):**
1. Ensure the printer and server are on the same subnet.
2. Set `.env`:
   ```env
   PRINTER_CONNECTION=network
   PRINTER_IP=192.168.1.100
   PRINTER_PORT=9100
   ```

### Usage Flow
- **Auto-Trigger**: Printing is triggered automatically after a successful transaction if `PRINTER_AUTO_PRINT=true`.
- **Manual Trigger**: Admin can re-print receipts from the Order list or View page using the "Print Receipt" button.
- **Fail-Safe**: If the printer is offline or disconnected, the system logs the error and displays a notification without crashing the POS flow.

## Environment Variables Example

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=barbershop
DB_USERNAME=root
DB_PASSWORD=

# Printer Settings
PRINTER_CONNECTION=usb # usb or network
PRINTER_USB_NAME=POS-58
PRINTER_IP=192.168.1.100
PRINTER_PORT=9100
PRINTER_AUTO_PRINT=true

# Shop Details for Receipt Header
PRINTER_SHOP_NAME="Grooming Barber"
PRINTER_SHOP_ADDRESS="Jl. Contoh No. 123, Jakarta"
PRINTER_SHOP_PHONE="0812-3456-7890"
```

## Notes & Best Practices

- **POS Usage**: Always ensure the "Amount Paid" is entered correctly for accurate "Change" calculation on receipts.
- **Printer Limitations**: Standard thermal printers do not support complex colors or styling. Stick to basic text and simple separators included in the `ReceiptPrinterService`.
- **Windows Users**: For USB printers, you MUST share the printer and ensure the printer name in `.env` matches the **Share Name**.
- **Security**: The POS system is only accessible to authenticated users with the `admin` role via Filament.

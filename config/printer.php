<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Printer Connection
    |--------------------------------------------------------------------------
    |
    | Supported: "usb", "network", "windows", "linux"
    |
    */
    'connection' => env('PRINTER_CONNECTION', 'usb'),

    /*
    |--------------------------------------------------------------------------
    | USB Printer Configuration
    |--------------------------------------------------------------------------
    |
    | For Windows: use the printer name (e.g., 'POS-58')
    | For Linux: use the device path (e.g., '/dev/usb/lp0')
    |
    */
    'usb' => [
        'name' => env('PRINTER_USB_NAME', 'POS-58'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Network Printer Configuration
    |--------------------------------------------------------------------------
    */
    'network' => [
        'ip' => env('PRINTER_IP', '192.168.1.100'),
        'port' => env('PRINTER_PORT', 9100),
    ],

    /*
    |--------------------------------------------------------------------------
    | Receipt Header/Footer
    |--------------------------------------------------------------------------
    */
    'receipt' => [
        'shop_name' => env('PRINTER_SHOP_NAME', 'Kaka Bewok Barbershop'),
        'address' => env('PRINTER_SHOP_ADDRESS', 'Jl. Contoh Alamat No. 123'),
        'phone' => env('PRINTER_SHOP_PHONE', '0812-3456-7890'),
        'footer' => env('PRINTER_FOOTER', 'Terima kasih atas kunjungan Anda!'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto Print Configuration
    |--------------------------------------------------------------------------
    */
    'auto_print' => env('PRINTER_AUTO_PRINT', true),
];

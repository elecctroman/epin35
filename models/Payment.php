<?php
namespace Models;

interface PaymentDriver
{
    public function charge(array $payload): array;
}

class ManualPaymentDriver implements PaymentDriver
{
    public function charge(array $payload): array
    {
        return [
            'status' => 'pending',
            'reference' => 'MAN-' . strtoupper(bin2hex(random_bytes(4))),
            'message' => 'Ödeme talimatınız alınmıştır. Yönetici onayı bekleniyor.'
        ];
    }
}

class MockGatewayDriver implements PaymentDriver
{
    private string $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function charge(array $payload): array
    {
        return [
            'status' => 'paid',
            'reference' => $this->prefix . '-' . strtoupper(bin2hex(random_bytes(5))),
            'message' => 'Mock ödeme başarıyla tamamlandı.'
        ];
    }
}

class PaymentManager
{
    private array $drivers = [];

    public function __construct()
    {
        $config = require __DIR__ . '/../config/config.php';
        $drivers = $config['payment']['drivers'];
        $this->drivers['manual'] = new ManualPaymentDriver();
        $this->drivers['iyzico_mock'] = new MockGatewayDriver('IYZ');
        $this->drivers['papara_mock'] = new MockGatewayDriver('PAP');
    }

    public function driver(string $name): PaymentDriver
    {
        if (!isset($this->drivers[$name])) {
            throw new \InvalidArgumentException('Payment driver not found: ' . $name);
        }
        return $this->drivers[$name];
    }
}

<?php

namespace App\Library;

use App\Library\Contracts\PaymentGatewayInterface;
use App\Models\Setting;
use Exception;

class BillingManager
{
    protected $gateways = [];

    /**
     * Enable payment gateway.
     *
     * @var void
     *
     * @param mixed $gatewayType
     */
    public static function enablePaymentGateway($gatewayType)
    {
        $gateways = Setting::get('gateways') ? json_decode(Setting::get('gateways'), true) : [];
        $gateways = array_unique(array_merge($gateways, [$gatewayType]));
        Setting::set('gateways', json_encode($gateways));
    }

    /**
     * Disable payment gateway.
     *
     * @var void
     *
     * @param mixed $gatewayType
     */
    public static function disablePaymentGateway($gatewayType)
    {
        $gateways = Setting::get('gateways') ? json_decode(Setting::get('gateways'), true) : [];
        $gateways = array_diff($gateways, [$gatewayType]);
        Setting::set('gateways', json_encode($gateways));
    }

    public function register(PaymentGatewayInterface $gateway)
    {
        if ($this->isGatewayTypeRegistered($gateway->getType())) {
            throw new Exception(sprintf('Gateways type "%s" is already registered', $gateway->getType()));
        }

        $this->gateways[] = $gateway;
    }

    public function isGatewayTypeRegistered(string $type): bool
    {
        $registered = false;
        foreach ($this->gateways as $gw) {
            if ($gw->getType() == $type) {
                $registered = true;
            }
        }

        return $registered;
    }

    public function getGateways(): array
    {
        return $this->gateways;
    }

    public function isGatewayEnabled($gateway): bool
    {
        foreach ($this->getEnabledPaymentGateways() as $gw) {
            if ($gw->getType() == $gateway->getType()) {
                return true;
            }
        }

        return false;
    }

    public function getEnabledPaymentGateways()
    {
        if (!Setting::get('gateways')) {
            return [];
        }

        $enabledTypes = json_decode(Setting::get('gateways'));
        $list = [];

        foreach ($enabledTypes as $t) {
            if ($this->isGatewayRegistered($t) && $this->getGateway($t)->isActive()) {
                $list[] = $this->getGateway($t);
            }
        }

        return $list;
    }

    public function isGatewayRegistered($type)
    {
        foreach ($this->gateways as $gw) {
            if ($gw->getType() == $type) {
                return true;
            }
        }

        return false;
    }

    public function getGateway(string $type)
    {
        foreach ($this->gateways as $gw) {
            if ($gw->getType() == $type) {
                return $gw;
            }
        }

        return null;
    }
}

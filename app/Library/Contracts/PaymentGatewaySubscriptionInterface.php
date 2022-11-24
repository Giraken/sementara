<?php

namespace App\Library\Contracts;

interface PaymentGatewaySubscriptionInterface
{
	public function createSubscription(array $data): array;

	public function cancelSubscription(array $data): bool;

	public function handleRecurringCharge(array $data): array;

	// public function updateSubscription($data);

	// public function getSubscription($data);

	// public function getSubscriptions($data);
}

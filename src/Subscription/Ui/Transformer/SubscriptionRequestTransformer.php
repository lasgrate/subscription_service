<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Ui\Transformer;

use KiloHealth\Subscription\Application\Dto\Callback\PaymentProviderNotification;
use KiloHealth\Subscription\Application\Dto\Callback\Product;
use KiloHealth\Subscription\Application\Dto\Callback\ProductCollection;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionRequestTransformer
{
    public function transform(Request $request): PaymentProviderNotification
    {
        $parsedBody = \json_decode($request->getContent(), true);
        $products = new ProductCollection();
        $i = 0;

        foreach ($parsedBody['unified_receipt']['pending_renewal_info'] as $product) {
            $products->addItem(
                new Product(
                    $product['original_transaction_id'],
                    $product['product_id'],
                    new \DateTimeImmutable($parsedBody['unified_receipt']['latest_receipt_info'][$i]['expires_date'])
                )
            );
            $i++;
        }

        return new PaymentProviderNotification(
            'applePay',
            $parsedBody['notification_type'],
            $products
        );
    }
}

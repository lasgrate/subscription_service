<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Ui\Http\Api\Subscription;

use KiloHealth\Subscription\Application\Command\SubscriptionCallbackHandler;
use KiloHealth\Subscription\Ui\Transformer\SubscriptionRequestTransformer;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApplePayCallbackAction
{
    public function __construct(
        private SubscriptionRequestTransformer $transformer,
        private SubscriptionCallbackHandler $subscriptionCallbackHandler,
        private ValidatorInterface $validator,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(Request $request): Response
    {
        try {
            $errors = $this->validator->validate($request->query->all(), [
                // describe validation
            ]);

            if ($errors->count() === 0) {
                $requestDto = $this->transformer->transform($request);
                $this->subscriptionCallbackHandler->handle($requestDto);

                return new Response(status: 200);
            } else {
                return new JsonResponse([
                    'payload' => \sprintf(
                        'Param %s is invalid. %s',
                        $errors->get(0)->getPropertyPath(),
                        $errors->get(0)->getMessage(),
                    ),
                ], 402);
            }
        } catch (\Throwable $exception) {
            $this->logger->error('[Subscription\] Failed while process request', [
                'exception' => $exception,
            ]);

            return new Response(status: 500);
        }
    }
}

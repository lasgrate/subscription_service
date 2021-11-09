<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Ui\Http\Api\Subscription;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApplePayCallbackAction
{
    public function __construct(
        private ValidatorInterface $validator,
        private LoggerInterface $logger
    ) {
    }

    public function __invoke(Request $request): Response
    {
        try {
            return new Response('Hello word!');

            $errors = $this->validator->validate($request->query->all(), [
//                new Assert\Collection([
//                    'date' => new Assert\Date(),
//                    'from' => new Assert\Currency(),
//                ]),
            ]);

            if ($errors->count() === 0) {

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

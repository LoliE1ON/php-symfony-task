<?php

declare(strict_types=1);

namespace App\ValueResolver;

use App\Exception\APIValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractValueResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly DenormalizerInterface $serializer,
    ) {
    }

    abstract protected function getDtoClass(): string;

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return iterable<object>
     * @throws ExceptionInterface
     */
    final public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($this->getDtoClass() !== $argument->getType()) {
            return [];
        }

        $dto    = $this->serializer->denormalize($request->toArray(), $this->getDtoClass());
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new APIValidationException($errors);
        }

        return [$dto];
    }
}

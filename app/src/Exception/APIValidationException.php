<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class APIValidationException extends HttpException
{
    private ConstraintViolationListInterface $list;

    public function __construct(ConstraintViolationListInterface $list)
    {
        $this->list = $list;

        parent::__construct(statusCode: Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function getList(): ConstraintViolationListInterface
    {
        return $this->list;
    }
}

<?php

namespace App\Http\Responses;

use App\Domain\Exceptions\DomainException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;

class ApiExceptionRenderer
{
    public function render(Throwable $exception, Request $request): JsonResponse
    {
        [$status, $code, $message, $errors] = $this->map($exception);

        return response()->json([
            'success' => false,
            'data' => null,
            'message' => $message,
            'errors' => $errors,
            'error' => ['code' => $code],
            'meta' => ['api_version' => config('ipshield.api_version', 'v1')],
        ], $status);
    }

    private function map(Throwable $exception): array
    {
        return match (true) {
            $exception instanceof ValidationException => [
                422, 'VALIDATION_ERROR', 'The submitted data is invalid.', $exception->errors(),
            ],
            $exception instanceof AuthenticationException => [
                401, 'AUTHENTICATION_ERROR', 'Authentication is required.', [],
            ],
            $exception instanceof AuthorizationException => [
                403, 'AUTHORIZATION_ERROR', 'You are not authorized to perform this action.', [],
            ],
            $exception instanceof ModelNotFoundException,
            $exception instanceof NotFoundHttpException => [
                404, 'NOT_FOUND', 'The requested resource was not found.', [],
            ],
            $exception instanceof ConflictHttpException => [
                409, 'CONFLICT', 'The request conflicts with the current resource state.', [],
            ],
            $exception instanceof TooManyRequestsHttpException => [
                429, 'RATE_LIMITED', 'Too many requests.', [],
            ],
            $exception instanceof DomainException => [
                422, 'BUSINESS_ERROR', 'The request could not be completed.', [],
            ],
            default => [
                Response::HTTP_INTERNAL_SERVER_ERROR,
                'INTERNAL_ERROR',
                'An internal error occurred.',
                [],
            ],
        };
    }
}

<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Traits\ApiResponser;
use Illuminate\Auth\AuthenticationException;
use Throwable;

class HandlerApiException extends Exception
{
    use ApiResponser;

    /**
     * 
     */
    private $exception;

    public function __construct(Exception $e)
    {
        $this->exception = $e;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render()
    {
        $response = $this->handleException($this->exception);
        return $response;
    }

    /**
     * Handle a Exception
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param Exception $exception
     * 
     * @return array
     */
    public function handleException(Exception $exception)
    {

        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse([], $message = $exception->getMessage(), 401);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse([], $message = 'El metodo es invalido', 405);
        }

        if ($exception instanceof ValidationException) {
            return $this->errorResponse($exception->errors(), 'Error de validación', 422);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse([], 'La url especificada ', 404);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse([], $exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->errorResponse([], 'No hay resultado', 404);
        }

        if ($exception instanceof QueryException) {
            return $this->resolveQueryException($exception);
        }

        if ($exception instanceof InvalidArgumentException) {
            return $this->errorResponse([], $exception->getMessage(), 500);
        }

        if (config('app.debug')) {
            dd($exception);
        }

        return $this->errorResponse([], 'Unexpected Exception. Try later', 500);
    }

    /**
     * 
     * @param \Illuminate\Database\QueryException $exception
     * @return \Illuminate\Http\Response
     */
    private function resolveQueryException(QueryException $e)
    {
        $errorInfo = $e->errorInfo;

        switch ($errorInfo[1]) {
            case 1062:
                return $this->errorResponse([], 'Registro duplicado', 500);
                break;
            default:
                return $this->errorResponse([], 'Error al manipular la base de datos', 500);
                break;
        }
    }
}

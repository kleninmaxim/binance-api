<?php

namespace BinanceApi\Helper\ResponseHandler;

use BinanceApi\Docs\Const\BinanceApi\Endpoint;
use BinanceApi\Docs\Const\BinanceApi\ProcessResponse;
use BinanceApi\Docs\GeneralInfo\GeneralApiInformation;
use BinanceApi\Exception\BinanceResponseException;
use Psr\Http\Message\ResponseInterface;

class CustomResponseHandler implements ResponseHandler
{
    /**
     * @var bool if true, it class will throw exception, another way will not throw exception
     */
    protected bool $isThrowException = true;

    /**
     * @throws BinanceResponseException
     */
    public function get(ResponseInterface $response, ?Endpoint $endpoint): array
    {
        $data = json_decode($response->getBody()->getContents(), true);

        if ($this->isThrowException) {
            $this->handleError($data);
        }

        return [
            'data' => ($endpoint instanceof ProcessResponse && ! $this->isErrorMessage($data)) ? $endpoint->processResponse($data) : $data,
            'info' => [
                'statusCode' => $response->getStatusCode(),
                'reasonPhrase' => $response->getReasonPhrase(),
                'headers' => $response->getHeaders(),
            ],
        ];
    }

    /**
     * Method to disable throw exception
     *
     * @return void
     */
    public function disableException(): void
    {
        $this->isThrowException = false;
    }

    /**
     * Handle response to check is error message and if it does then throw exception
     *
     * @throws BinanceResponseException
     */
    protected function handleError(array $data): void
    {
        if ($this->isErrorMessage($data)) {
            throw new BinanceResponseException(
                $data[GeneralApiInformation::ERROR_CODE_AND_MESSAGES[1]],
                $data[GeneralApiInformation::ERROR_CODE_AND_MESSAGES[0]]
            );
        }
    }

    /**
     * Check that response data is error message or not
     *
     * @param  array  $data
     * @return bool
     */
    protected function isErrorMessage(array $data): bool
    {
        foreach (GeneralApiInformation::ERROR_CODE_AND_MESSAGES as $errorCode) {
            if (! isset($data[$errorCode])) {
                return false;
            }
        }

        return count(GeneralApiInformation::ERROR_CODE_AND_MESSAGES) == count($data);
    }
}

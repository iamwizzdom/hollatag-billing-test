<?php
/**
 * Created by PhpStorm.
 * User: Wisdom Emenike
 * Date: 24/03/2020
 * Time: 2:15 PM
 */

namespace network;


class Response
{

    /**
     * @var array
     */
    private $response = [];

    /**
     * Response constructor.
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->setResponse($response);
    }

    /**
     * @param array $response
     */
    private function setResponse(array $response) {
        $this->response = $response;
    }

    /**
     * @return bool
     */
    public function getStatus(): bool {

        return $this->response['status'] ?? false;

    }

    /**
     * @return string|null
     */
    public function getResponseRaw(): ?string
    {
        return $this->response['response'] ?? null;
    }

    /**
     * @return array
     */
    public function getResponseArray(): array {
        return json_decode($this->response['response'], true) ?: [];
    }

}
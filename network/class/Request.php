<?php
/**
 * Created by PhpStorm.
 * User: Wisdom Emenike
 * Date: 24/03/2020
 * Time: 1:45 PM
 */

namespace network;

class Request extends Network
{
    const SUCCESS = 200;

    /**
     * @var string
     */
    private $url = ""; //URL to third-party api

    /**
     * @var int
     */
    private $amount = 0; //Amount to bill

    /**
     * @var string
     */
    private $username = ""; //Username to bill

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return Response
     */
    public function initiate()
    {
        $response = $this->fetch($this->url, [
            'amount' => $this->getAmount(),
            'username' => $this->getUsername(),
        ], [
            "Authorization: Bearer xxxxxx"
        ]);

        return new Response($response);
    }

}
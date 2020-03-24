<?php
/**
 * Created by PhpStorm.
 * User: Wisdom Emenike
 * Date: 24/03/2020
 * Time: 1:24 PM
 */

namespace network;

abstract class Network {

    public function fetch(string $url, array $post = [],
                          array $headers = [], int $timeout = 60) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if(count($headers) > 0){
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
        }

        if(count($post) > 0){
            curl_setopt($ch,CURLOPT_POST,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS, $post);
        }

        curl_setopt($ch,CURLOPT_TIMEOUT, $timeout);

        $content = curl_exec($ch);

        if ($content === false) {
            curl_close($ch);
            return [
                'status' => false,
                'response' => curl_error($ch)
            ];
        }

        // Initiate Retry
        $retry = 0;

        // Try again if it fails
        while(curl_errno($ch) == 28 && $retry < 3) {
            $content = curl_exec($ch);
            $retry++;
            sleep($timeout);
        }

        if (curl_errno($ch)) {
            curl_close($ch);
            return [
                'status' => false,
                'response' => curl_error($ch)
            ];
        }

        curl_close($ch);
        return [
            'status' => true,
            'response' => $content
        ];
    }

}


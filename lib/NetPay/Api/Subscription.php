<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright 2018 NetPay. All rights reserved.
 */

namespace NetPay\Api;

use Exception;
use \NetPay\Config;
use \NetPay\Api\Curl;
use \NetPay\Exceptions\HandlerHTTP;
use \NetPay\Handlers\SubscriptionDataHandler;

class Subscription
{
    /**
     * Send a post request to Curl to make the cancelled of an order.
     */
    public static function post($jwt, array $input)
    {
        $fields = SubscriptionDataHandler::prepare($input);

        $fields_string = json_encode($fields);

        $curl_result = Curl::post(Config::$ADD_SUBSCRIPTION, $fields_string, $jwt);
        $result = json_decode($curl_result['result'], true);

        if ($curl_result['code'] != 201) {
            throw HandlerHTTP::errorHandler($result, $curl_result['code']);
        }

        return compact('result');
    }

    /**
     * Send a get request to Curl to make the cancelled of an order.
     */
    public static function get($jwt)
    {
        $curl_result = Curl::get(Config::$GET_SUBSCRIPTIONS, $jwt);
        $result = json_decode($curl_result['result'], true);

        if ($curl_result['code'] != 200) {
            throw HandlerHTTP::errorHandler($result, $curl_result['code']);
        }

        return compact('result');
    }

    /**
     * Send a get request to Curl to make the cancelled of an order.
     */
    public static function get_subscription($jwt, $subscription_id)
    {
        $curl_result = Curl::get(sprintf(Config::$GET_SUBSCRIPTION, $subscription_id), $jwt);
        $result = json_decode($curl_result['result'], true);

        if ($curl_result['code'] != 200) {
            throw HandlerHTTP::errorHandler($result, $curl_result['code']);
        }

        return compact('result');
    }


    /**
     * Send a post request to Curl to make the cancelled of an order.
     */
    public static function stop($jwt, $subscription_id)
    {
        $curl_result = Curl::put(sprintf(Config::$STOP_SUBSCRIPTION, $subscription_id), array(), $jwt);
        $result = json_decode($curl_result['result'], true);

        if ($curl_result['code'] != 200) {
            throw HandlerHTTP::errorHandler($result, $curl_result['code']);
        }

        return compact('result');
    }

}
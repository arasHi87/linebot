<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once('./LINEBotTiny.php');

$channelAccessToken = 'w66P7goi1KIXVIgHUEwgS03qcNt6glhcpmaNOVwYDSLAzPQCdoZmprdBc722o+LA6brCOBM9cYYpz+jKiG9Pn35RKECNDEo4ie4wo5nFHBnBfv/57rdMzry0T/A9bE0PLRyAg4GIKkbAQsF2U32r0AdB04t89/1O/w1cDnyilFU=';
$channelSecret = '87a25bedd0dfa44864a7c7f7ea417ac1';

$client = new LINEBotTiny($channelAccessToken, $channelSecret);
foreach ($client->parseEvents() as $event) {
    switch ($event['type']) {
        case 'message':
            $message = $event['message'];
            switch ($message['type']) {
                case 'text':
                    $msg = $message['text'];
                    switch ($msg) {
                        case '/test':
                           $text = 'test successful';
                        break;
                    
                        case '/coda':
                            $a = rand(0,100); //引爆數字
                            $b = true; //開關
                            $c = $event['replyToken']; //確認群組
                            $d = 100; //上限
                            $e = 0; //下限
                            break;

                        default:
                            if ($b) {
                                if ($event['replyToken'] == $c) {
                                    if ($msg == $a) {
                                        $text = 'Bang! 就是你了!!';
                                    } else if ($msg > $a) {
                                        $d = $msg;
                                        $text = '更新範圍: ' . $d . '~' . $e;
                                    } else if ($msg < $a) {
                                        $e = $msg;
                                        $text = '更新範圍: ' . $d . '~' . $e;
                                    }
                                }
                            }
                    }
                    break;

                default:
                    error_log("Unsupporeted message type: " . $message['type']);
                    break;
            }
            break;
        default:
            error_log("Unsupporeted event type: " . $event['type']);
            break;
    }
    if (isset($text) && $text != '') {
    $client->replyMessage(array(
    'replytoken' => $event['replyToken'],
    'messages' => array(
            array(
            'type' => 'text',
            'text' => $text
        )
    )
));
}
};

<?php
    date_default_timezone_set("Asia/Riyadh");
    //sort question by answer count

    function sort_questions_by_answer($x, $y) {
        return $y->answers - $x->answers;
    }
    //convert local time to UTC time
    function localTimeToUTC($localTime) {
        $currentDateTime = date("Y-m-d H:i:s A"); 
        $dateTime = $localTime; 
        $tz_from = 'Asia/Riyadh'; //TODO: replaced to your current timezone of the database
        $newDateTime = new DateTime($dateTime, new DateTimeZone($tz_from)); 
        $newDateTime->setTimezone(new DateTimeZone("UTC")); 
        $dateTimeUTC = $newDateTime->format("Y-m-d h:i:s");

        return $dateTimeUTC;
    }

    //time elapsed human formation
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime();
        $ago = new DateTime(($datetime));
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    function get_request_withcontext($url, $data) {
        $data_string = json_encode($data);
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/json' . "\r\n" .
                            'Content-Length: ' . strlen($data_string) . "\r\n",
                'content' => $data_string
            )
        ));
        $response = file_get_contents($url, false, $context);
        $response_data = json_decode($response);
        return $response_data;
    }
    
    //fetch from api
    function get_request_api($url) {
        $json = file_get_contents($url);
        return $response = json_decode($json);
    }
?>
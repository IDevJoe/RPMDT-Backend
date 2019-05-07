<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App;


class CannedResponse
{
    public static function main($code, $data) {
        if($code == 204) return response(null, 204);
        return response(['code' => $code, 'data' => $data], $code);
    }

    public static function OK($data) {
        return self::main(200, $data);
    }

    public static function Unauthorized() {
        return self::main(401, 'Unauthorized');
    }

    public static function BadRequest() {
        return self::main(400, 'Bad Request');
    }

    public static function NoContent() {
        return self::main(204, null);
    }
}
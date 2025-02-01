<?php
/**
* Service for handling requests
*/

namespace Newscast\Services;

class RequestService extends Service {
    private array $raw_request;

    public function __construct() {
        $this->raw_request = [];
    }

    public static function load( array $data ): RequestService {
        $request = new RequestService();

        $request->raw_request = $data;

        foreach ( $data as $key => $value ) {
            $request->{$key} = $value;
        }

        return $request;
    }

    public static function auth(): bool {
        return true;
    }
}
<?php

namespace Warrant\HttpClient;

interface HttpClientInterface {
    public function get(RequestOptions $requestOptions);
    public function post(RequestOptions $requestOptions);
    public function put(RequestOptions $requestOptions);
    public function delete(RequestOptions $requestOptions);
}

<?php
/**
 * Copyright (c) 2014 Webflavia
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Webflavia\Http;

/**
 * @package \Webflavia\Http
 * @author  Dhyego Fernando <dhyegofernando@gmail.com>
 * @license <https://github.com/Webflavia/webflavia-php-sdk-v1/raw/master/LICENSE> MIT
 */
interface RequestInterface {

  /**
   * Sets an option value
   * This method must implement recursive behavior
   *
   * @param string|mixed[] $name
   * @param null|string    $value
   */
  public function setOption($name, $value = null);

  /**
   * Sets HTTP header
   * This method must implement recursive behavior
   *
   * @param string|mixed[] $name
   * @param null|string    $value
   */
  public function setHeader($name, $value = null);

  /**
   * Sends a GET request
   *
   * @param  string $path
   * @param  array  $params  GET params
   * @param  array  $headers Headers only used for this request
   *
   * @return \GuzzleHttp\Message\ResponseInterface
   */
  public function get($path, array $params = array(), array $headers = array());

  /**
   * Sends a POST request
   *
   * @param  string $path
   * @param  mixed  $body
   * @param  array  $headers Headers only used for this request
   *
   * @return \GuzzleHttp\Message\ResponseInterface
   */
  public function post($path, $body = null, array $headers = array());

  /**
   * Sends a PATCH request
   *
   * @param  string $path
   * @param  mixed  $body
   * @param  array  $headers Headers only used for this request
   *
   * @return \GuzzleHttp\Message\ResponseInterface
   */
  public function patch($path, $body = null, array $headers = array());

  /**
   * Sends a PUT request
   *
   * @param  string $path
   * @param  mixed  $body
   * @param  array  $headers Headers only used for this request
   *
   * @return \GuzzleHttp\Message\ResponseInterface
   */
  public function put($path, $body, array $headers = array());

  /**
   * Sends a DELETE request
   *
   * @param  string $path
   * @param  mixed  $body
   * @param  array  $headers Headers only used for this request
   *
   * @return \GuzzleHttp\Message\ResponseInterface
   */
  public function delete($path, $body = null, array $headers = array());

  /**
   * Sends a request to the server
   *
   * @param  string $path
   * @param  mixed  $body
   * @param  array  $headers Headers only for this request
   *
   * @return \GuzzleHttp\Message\ResponseInterface
   */
  public function request($path, $body = null, $httpMethod = 'GET', array $headers = array());
}

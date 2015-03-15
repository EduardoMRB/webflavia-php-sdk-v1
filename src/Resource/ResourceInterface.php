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
namespace Webflavia\Resource;

use Webflavia\Http\ClientInterface;

/**
 * @package \Webflavia\Resource
 * @author  Dhyego Fernando <dhyegofernando@gmail.com>
 * @license <https://github.com/Webflavia/webflavia-php-sdk-v1/raw/master/LICENSE> MIT
 */
interface ResourceInterface {

  /**
   * @param Webflavia\Http\ClientInterface $httpClient Reference to the HTTP client object
   */
  public function __construct(ClientInterface $httpClient);

  /**
   * Sends a GET request and parses its response
   *
   * @param  string $path
   * @param  array  $params  GET params
   * @param  array  $headers Headers only used for this request
   *
   * @return \Webflavia\Entity\Collection|\Webflavia\Entity\Entity
   */
  public function get($path, array $params = array(), array $headers = array());

  /**
   * Sends a POST request and parses its response
   *
   * @param  string $path
   * @param  mixed  $body
   * @param  array  $headers Headers only used for this request
   *
   * @return \Webflavia\Entity\Collection|\Webflavia\Entity\Entity
   */
  public function post($path, $body = null, array $headers = array());

  /**
   * Sends a PATCH request and parses its response
   *
   * @param  string $path
   * @param  mixed  $body
   * @param  array  $headers Headers only used for this request
   *
   * @return \Webflavia\Entity\Collection|\Webflavia\Entity\Entity
   */
  public function patch($path, $body = null, array $headers = array());

  /**
   * Sends a PUT request and parses its response
   *
   * @param  string $path
   * @param  mixed  $body
   * @param  array  $headers Headers only used for this request
   *
   * @return \Webflavia\Entity\Collection|\Webflavia\Entity\Entity
   */
  public function put($path, $body, array $headers = array());

  /**
   * Sends a DELETE request and parses its response
   *
   * @param  string $path
   * @param  mixed  $body
   * @param  array  $headers Headers only used for this request
   *
   * @return \Webflavia\Entity\Collection|\Webflavia\Entity\Entity
   */
  public function delete($path, $body = null, array $headers = array());
}

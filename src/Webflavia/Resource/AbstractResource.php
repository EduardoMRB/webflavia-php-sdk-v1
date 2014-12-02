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

use Webflavia\Entity\Parser;
use Webflavia\Http\ClientInterface;

/**
 * Every resource must implement this abstract class
 *
 * @package \Webflavia\Resource
 * @author  Dhyego Fernando <dhyegofernando@gmail.com>
 * @license <https://github.com/Webflavia/webflavia-php-sdk-v1/raw/master/LICENSE> MIT
 */
abstract class AbstractResource implements ResourceInterface {

  /**
   * HTTP client's object
   *
   * @var \Webflavia\Http\ClientInterface
   */
  protected $httpClient;

  /**
   * {@inheritDoc}
   */
  public function __construct(ClientInterface $httpClient) {
    $this->httpClient = $httpClient;
  }

  /**
   * {@inheritDoc}
   */
  public final function get($path, array $params = array(), array $headers = array()) {
    return (new Parser($this->httpClient->get($path, $params, $headers), $this))->detect();
  }

  /**
   * {@inheritDoc}
   */
  public final function post($path, $body = null, array $headers = array()) {
    return (new Parser($this->httpClient->post($path, $body, $headers), $this))->detect();
  }

  /**
   * {@inheritDoc}
   */
  public final function patch($path, $body = null, array $headers = array()) {
    return (new Parser($this->httpClient->patch($path, $body, $headers), $this))->detect();
  }

  /**
   * {@inheritDoc}
   */
  public final function put($path, $body, array $headers = array()) {
    return (new Parser($this->httpClient->put($path, $body, $headers), $this))->detect();
  }

  /**
   * {@inheritDoc}
   */
  public final function delete($path, $body = null, array $headers = array()) {
    return (new Parser($this->httpClient->delete($path, $body, $headers), $this))->detect();
  }
}

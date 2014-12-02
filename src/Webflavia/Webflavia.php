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
namespace Webflavia;

use Webflavia\Http\Client;
use Webflavia\Http\ClientInterface;
use Webflavia\Exception\InvalidResourceException;
use Webflavia\Exception\NotImplementedException;
use Webflavia\Resource\Customer;

/**
 * Initializer class
 *
 * @property-read \Webflavia\Resource\Customer $customer
 *
 * @package \Webflavia
 * @author  Dhyego Fernando <dhyegofernando@gmail.com>
 * @license <https://github.com/Webflavia/webflavia-php-sdk-v1/raw/master/LICENSE> MIT
 */
class Webflavia {

  /**
   * HTTP client used to communicate through
   *
   * @var \Webflavia\Http\ClientInterface
   */
  private $httpClient;

  /**
   * Resources storaged that will be called like a cached instances
   *
   * @var \Webflavia\Resource\ResourceInterface[]
   */
  private $resources = array();

  /**
   * @param string                          $tokenOrUsername You can use either token or usename to get logged
   * @param string                          $password        You should put it if you are gonna use authentication through username
   * @param \Webflavia\Http\ClientInterface $httpClient
   */
  public function __construct($tokenOrUsername, $password = null, ClientInterface $httpClient = null) {
    if (null === $httpClient) {
      $httpClient = new Client();
    }

    $this->httpClient = $httpClient;

    $this->httpClient->authenticate($tokenOrUsername, $password);
  }

  /**
   * @return \Webflavia\Http\ClientInterface
   */
  public function getHttpClient() {
    return $this->httpClient;
  }

  /**
   * @param \Webflavia\Http\ClientInterface $httpClient You can set manually the HTTP client
   */
  public function setHttpClient(ClientInterface $httpClient) {
    $this->httpClient = $httpClient;
  }

  /**
   * Returns an resource's instance that will be cached in this object
   *
   * @param  string $resource
   *
   * @return \Webflavia\Resource\ResourceInterface
   *
   * @throws \Webflavia\Exception\InvalidResourceException
   */
  public function api($resource) {
    if (isset($this->resources[$resource])) {
      return $this->resources[$resource];
    }

    switch ($resource) {
      case 'customer':
        return $this->resources[$resource] = new Customer($this->httpClient);
        break;

      default:
        throw new InvalidResourceException($resource);
    }
  }

  /**
   * You can call a resource like a property
   * This is really useful
   *
   * @param string $name
   *
   * @return \Webflavia\Resource\ResourceInterface
   *
   * @throws \Webflavia\Exception\NotImplementedException
   */
  public function __get($name) {
    try {
      return $this->api($name);
    } catch (InvalidResourceException $e) {
      throw new NotImplementedException('Resource');
    }
  }
}

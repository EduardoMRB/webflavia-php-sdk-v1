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

use Webflavia\Http\Message\Response;
use Webflavia\Exception\WebflaviaException;
use Webflavia\Exception\InvalidArgumentException;
use Webflavia\Exception\NotImplementedException;
use Webflavia\Exception\BadCredentialsException;
use Webflavia\Exception\NotFoundException;
use Webflavia\Exception\ValidationFailedException;
use Webflavia\Exception\UnauthorizedException;
use Webflavia\Exception\ServerException;
use Webflavia\Exception\BadResponseException;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\ClientInterface as GuzzleHttpClientInterface;
use GuzzleHttp\Exception\BadResponseException as GuzzleHttpBadResponseException;

/**
 * This class is like an interface to communicate with the real
 * HTTP client which is instantiated in run-time
 *
 * @package \Webflavia\Http
 * @author  Dhyego Fernando <dhyegofernando@gmail.com>
 * @license <https://github.com/Webflavia/webflavia-php-sdk-v1/raw/master/LICENSE> MIT
 */
class Client implements ClientInterface {

  /**
   * The real HTTP client
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $client;

  /**
   * User agent string
   *
   * @const
   */
  const USER_AGENT = 'wf-php-sdk-v1';

  /**
   * Default options that will be sent in every request
   *
   * @var mixed[]
   */
  protected $options = array(
    'base_url' => 'http://api.webflavia.com.br/',
    'timeout'  => 10
  );

  /**
   * Headers that will be sent in requests
   *
   * @var mixed[]
   */
  protected $headers = array();

  /**
   * @param mixed[]                     $options You can override or set default options
   * @param \GuzzleHttp\ClientInterface $client
   */
  public function __construct(array $options = array(), GuzzleHttpClientInterface $client = null) {
    $this->options = array_merge($this->options, $options);

    if (empty($this->options['base_url'])) {
      throw new InvalidArgumentException("The option 'base_url' is required");
    }

    $base_url = $this->options['base_url'];
    unset($this->options['base_url']);

    $options = array(
      'base_url' => $base_url,
      'defaults' => $this->options
    );

    $this->client = $client ? new $client($options) : new GuzzleHttpClient($options);

    $this->resetHeaders();
  }

  /**
   * {@inheritDoc}
   */
  public function getClient() {
    return $this->client;
  }

  /**
   * {@inheritDoc}
   *
   * @throws \Webflavia\Exception\NotImplementedException
   */
  public function authenticate($tokenOrUsername, $password = null) {
    if (null !== $password) {
      throw new NotImplementedException();
    }

    $this->setHeader('Authorization', "Token token=\"{$tokenOrUsername}\"");
  }

  /**
   * {@inheritDoc}
   */
  public function setOption($name, $value = null) {
    if (is_array($name)) {
      $this->options = array_merge($this->options, $name);
      return;
    }

    $this->options[$name] = $value;
  }

  /**
   * {@inheritDoc}
   */
  public function setHeader($name, $value = null) {
    if (is_array($name)) {
      $this->headers = array_merge($this->headers, $name);
      return;
    }

    $this->headers[$name] = $value;
  }

  /**
   * Sets HTTP headers for their original state
   */
  public function resetHeaders() {
    $this->headers = array(
      'Accept'     => 'application/vnd.webflavia.v1',
      'User-Agent' => self::USER_AGENT
    );
  }

  /**
   * {@inheritDoc}
   */
  public function get($path, array $params = array(), array $headers = array()) {
    return $this->request($path, null, 'GET', $headers, array('query' => $params));
  }

  /**
   * {@inheritDoc}
   */
  public function post($path, $body = null, array $headers = array()) {
    return $this->request($path, $body, 'POST', $headers);
  }

  /**
   * {@inheritDoc}
   */
  public function patch($path, $body = null, array $headers = array()) {
    return $this->request($path, $body, 'PATCH', $headers);
  }

  /**
   * {@inheritDoc}
   */
  public function put($path, $body, array $headers = array()) {
    return $this->request($path, $body, 'PUT', $headers);
  }

  /**
   * {@inheritDoc}
   */
  public function delete($path, $body = null, array $headers = array()) {
    return $this->request($path, $body, 'DELETE', $headers);
  }

  /**
   * {@inheritDoc}
   *
   * @throws \Webflavia\Exception\BadCredentialsException
   * @throws \Webflavia\Exception\UnauthorizedException
   * @throws \Webflavia\Exception\NotFoundException
   * @throws \Webflavia\Exception\ValidationFailedException
   * @throws \Webflavia\Exception\BadResponseException
   * @throws \Webflavia\Exception\ServerException
   * @throws \Webflavia\Exception\WebflaviaException
   */
  public function request($path, $body = null, $httpMethod = 'GET', array $headers = array(), array $options = array()) {
    $options = array_merge(
      $options,
      array(
        'headers' => array_merge($this->headers, $headers),
        'body'    => $body
      )
    );

    $request = $this->client->createRequest(
      $httpMethod,
      $path,
      $options
    );

    try {
      return $this->client->send($request);
    } catch (GuzzleHttpBadResponseException $e) {
      $response = $e->getResponse();

      $body   = Response::parseBody($response->getBody());
      $reason = isset($body['message']) ? $body['message'] : 'Unknown response';

      switch ($response->getStatusCode()) {
        case 401:
          throw new BadCredentialsException($body['message']);
          break;

        case 403:
          throw new UnauthorizedException($body['message']);
          break;

        case 404:
          throw new NotFoundException($reason);
          break;

        case 422:
          throw new ValidationFailedException($body);
          break;

        case 500:
        case 501:
        case 502:
        case 503:
        case 504:
        case 505:
        case 507:
        case 510:
          throw new ServerException("Something went wrong in the server, reason: {$reason}");
          break;

        default:
          throw new BadResponseException($reason);
      }
    } catch (Exception $e) {
      throw new WebflaviaException($e->getMessage());
    }
  }
}

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
namespace Webflavia\Entity;

use Webflavia\Resource\ResourceInterface;

use GuzzleHttp\Message\MessageInterface;

/**
 * @package \Webflavia\Entity
 * @author  Dhyego Fernando <dhyegofernando@gmail.com>
 * @license <https://github.com/Webflavia/webflavia-php-sdk-v1/raw/master/LICENSE> MIT
 */
interface ParserInterface {

  /**
   * @param \GuzzleHttp\Message\MessageInterface  $response
   * @param \Webflavia\Resource\ResourceInterface $resource
   */
  public function __construct(MessageInterface $response, ResourceInterface $resource);

  /**
   * Detects the kind of response and returns it
   *
   * @return \Webflavia\Entity\Collection|\Webflavia\Entity\Entity
   */
  public function detect();

  /**
   * Checks whether is a collection
   *
   * @return boolean
   */
  public function isCollection();

  /**
   * Checks whether is a entity
   *
   * @return boolean
   */
  public function isEntity();

  /**
   * Returns the parsed body
   *
   * @return mixed[]
   */
  public function getBody();
}

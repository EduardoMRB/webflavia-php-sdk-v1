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

/**
 * @package \Webflavia\Entity
 * @author  Dhyego Fernando <dhyegofernando@gmail.com>
 * @license <https://github.com/Webflavia/webflavia-php-sdk-v1/raw/master/LICENSE> MIT
 */
abstract class AbstractNavigable implements NavigableInterface {

  /**
   * Resource object reference
   *
   * @var \Webflavia\Resource\ResourceInterface
   */
  protected $resource;

  /**
   * Request's response
   *
   * @var mixed[]
   */
  protected $body;

  /**
   * Hypermedia links of request's resource
   *
   * @var mixed[]
   */
  protected $links = array();

  /**
   * {@inheritDoc}
   */
  public function __construct(ResourceInterface $resource, array $body) {
    $this->resource = $resource;
    $this->body = $body;

    if (isset($this->body['_links'])) {
      $this->links = $this->body['_links'];
    }
  }

  /**
   * {@inheritDoc}
   */
  public function getLinks($offset = null) {
    if (null !== $offset) {
      return isset($this->links[$offset]) ? $this->links[$offset] : null;
    }

    return $this->links;
  }
}

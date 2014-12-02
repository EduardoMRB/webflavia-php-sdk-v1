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
use Webflavia\Exception\BadMethodCallException;

/**
 * This class must behaves like if it were properly the resource
 *
 * @package \Webflavia\Entity
 * @author  Dhyego Fernando <dhyegofernando@gmail.com>
 * @license <https://github.com/Webflavia/webflavia-php-sdk-v1/raw/master/LICENSE> MIT
 */
class Entity extends AbstractNavigable implements EntityInterface {

  /**
   * {@inheritDoc}
   */
  public function __set($name, $value) {
    $this->body[$name] = $value;
  }

  /**
   * {@inheritDoc}
   */
  public function __get($name) {
    if (isset($this->body[$name])) {
      return $this->body[$name];
    }
  }

  /**
   * {@inheritDoc}
   */
  public function __isset($name) {
    return isset($this->body[$name]);
  }

  /**
   * {@inheritDoc}
   */
  public function __unset($name) {
    unset($this->body[$name]);
  }

  /**
   * {@inheritDoc}
   */
  public function save($args = null) {
    if (!is_callable(array($this->resource, 'update'))) {
      throw new BadMethodCallException('Method ' . __METHOD__ . ' is not implemented by this resource: ' . get_class($this->resource));
    }

    if (null === $args) {
      $args = $this->body;
    }

    return $this->resource->update($this->body['id'], $args);
  }

  /**
   * {@inheritDoc}
   */
  public function destroy() {
    if (!is_callable(array($this->resource, 'destroy'))) {
      throw new BadMethodCallException('Method ' . __METHOD__ . ' is not implemented by this resource: ' . get_class($this->resource));
    }

    return $this->resource->destroy($this->body['id']);
  }
}

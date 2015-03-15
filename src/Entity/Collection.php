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
class Collection extends AbstractNavigable implements CollectionInterface {

  /**
   * Array cursor position
   *
   * @var integer
   */
  private $position = 0;

  /**
   * Entities array
   *
   * @var \Webflavia\Entity\Entity[]
   */
  private $entities = array();

  /**
   * {@inheritDoc}
   */
  public function __construct(ResourceInterface $resource, array $data) {
    parent::__construct($resource, $data);

    foreach (reset($this->body) as $entity) {
      $this->entities[] = new Entity($this->resource, $entity);
    }

    unset($this->body);
  }

  /**
   * {@inheritDoc}
   */
  public function current() {
    return $this->entities[$this->position];
  }

  /**
   * {@inheritDoc}
   */
  public function rewind() {
    $this->position = 0;
  }

  /**
   * {@inheritDoc}
   */
  public function key() {
    return $this->position;
  }

  /**
   * {@inheritDoc}
   */
  public function next() {
    ++$this->position;
  }

  /**
   * {@inheritDoc}
   */
  public function valid() {
    return isset($this->entities[$this->position]);
  }

  /**
   * {@inheritDoc}
   */
  public function offsetSet($offset, $value) {
    $this->entities[$offset] = $value;
  }

  /**
   * {@inheritDoc}
   */
  public function offsetExists($offset) {
    return isset($this->entities[$offset]);
  }

  /**
   * {@inheritDoc}
   */
  public function offsetUnset($offset) {
    unset($this->entities[$offset]);
  }

  /**
   * {@inheritDoc}
   */
  public function offsetGet($offset) {
    return $this->entities[$offset];
  }

  /**
   * {@inheritDoc}
   */
  public function count() {
    return count($this->entities);
  }
}

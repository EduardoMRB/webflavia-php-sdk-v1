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

/**
 * The class that implement this interface must behave like if were properly the resource
 *
 * @package \Webflavia\Entity
 * @author  Dhyego Fernando <dhyegofernando@gmail.com>
 * @license <https://github.com/Webflavia/webflavia-php-sdk-v1/raw/master/LICENSE> MIT
 */
interface EntityInterface extends NavigableInterface {

  /**
   * Sets magically the resource's properties
   *
   * @param string $name
   * @param mixed  $value
   */
  public function __set($name, $value);

  /**
   * Gets magically the resource's properties
   *
   * @param  string $name
   *
   * @return mixed
   */
  public function __get($name);

  /**
   * Does verification magically in the resource's properties
   *
   * @param  string  $name
   *
   * @return boolean
   */
  public function __isset($name);

  /**
   * Unsets magically resource's properties
   *
   * @param string $name
   */
  public function __unset($name);

  /**
   * Calls the save method of resource if it was implemented
   *
   * @param mixed[] $args You can override the resource properties only for this method call
   *
   * @return \Webflavia\Entity\Entity
   *
   * @throws \Webflavia\Exception\BadMethodCallException
   */
  public function save($args = null);

  /**
   * Calls the destroy method of resource if it was implemented
   *
   * @return \Webflavia\Entity\Entity
   *
   * @throws \Webflavia\Exception\BadMethodCallException
   */
  public function destroy();
}

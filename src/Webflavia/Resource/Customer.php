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

/**
 * @package \Webflavia\Resource
 * @author  Dhyego Fernando <dhyegofernando@gmail.com>
 * @license <https://github.com/Webflavia/webflavia-php-sdk-v1/raw/master/LICENSE> MIT
 */
class Customer extends AbstractResource {

  /**
   * Gets all of customers
   *
   * @return \Webflavia\Entity\Collection
   */
  public function all() {
    return $this->get('customers');
  }

  /**
   * Gets a specified customer by id
   *
   * @param  int                      $id
   *
   * @return \Webflavia\Entity\Entity
   */
  public function show($id) {
    return $this->get("customers/{$id}");
  }

  /**
   * Creates a new customer
   *
   * @param  mixed[]                  $data
   *
   * @return \Webflavia\Entity\Entity
   */
  public function create(array $data) {
    return $this->post('customers', $data);
  }

  /**
   * Updates a specified customer by id
   *
   * @param  int                      $id
   * @param  mixed[]                  $data
   *
   * @return \Webflavia\Entity\Entity
   */
  public function update($id, array $data) {
    return $this->patch("customers/{$id}", $data);
  }

  /**
   * Destroys a specified customer by id
   *
   * @param  int                      $id
   *
   * @return \Webflavia\Entity\Entity
   */
  public function destroy($id) {
    return $this->delete("customers/{$id}");
  }
}

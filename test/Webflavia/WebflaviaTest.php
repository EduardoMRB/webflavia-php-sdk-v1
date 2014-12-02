<?php

namespace Webflavia\Test;

use Webflavia\Webflavia;

class WebflaviaClientTest extends \PHPUnit_Framework_TestCase {

  private $testClient;

  public function setUp() {
    $this->testClient = new Webflavia('justFakeToken');
  }

  /**
   * @test
   */
  public function shouldBeAuthenticated() {
    $httpClient = $this->getHttpClientMock();
    $httpClient->expects($this->once())
      ->method('authenticate')
      ->with('myToken');

    new Webflavia('myToken', null, $httpClient);
  }

  /**
   * @test
   */
  public function shouldAutoInstantiateHttpClient() {
    $this->assertInstanceOf('Webflavia\Http\Client', $this->testClient->getHttpClient());
  }

  /**
   * @test
   */
  public function shouldPassHttpClientInterfaceToConstructor() {
    $wf = new Webflavia('justFakeToken', null, $this->getHttpClientMock());
    $this->assertInstanceOf('Webflavia\Http\ClientInterface', $wf->getHttpClient());
  }

  /**
   * @test
   * @dataProvider getResourcesProvider
   */
  public function shouldGetResourceInstance($resourceName, $resourceClass) {
    $this->assertInstanceOf($resourceClass, $this->testClient->api($resourceName));
  }

  /**
   * @test
   * @dataProvider getResourcesProvider
   */
  public function shouldGetMagicResourceInstance($resourceName, $resourceClass) {
    $this->assertInstanceOf($resourceClass, $this->testClient->$resourceName);
  }

  /**
   * @test
   */
  public function shouldThrowInvalidResourceException() {
    $this->setExpectedException('Webflavia\Exception\InvalidResourceException');
    $this->testClient->api('is_not_valid_resource');
  }

  /**
   * @test
   */
  public function shouldThrowInvalidMagicResourceException() {
    $this->setExpectedException('Webflavia\Exception\NotImplementedException');
    $this->testClient->isNotValidResource;
  }

  public function getHttpClientMock() {
    return $this->getMock('Webflavia\Http\ClientInterface', array(
      'setOption',
      'setHeader',
      'get',
      'post',
      'patch',
      'put',
      'delete',
      'request',
      'authenticate',
      'getClient'
    ));
  }

  public function getResourcesProvider() {
    return array(
      array('customer', 'Webflavia\Resource\Customer')
    );
  }
}

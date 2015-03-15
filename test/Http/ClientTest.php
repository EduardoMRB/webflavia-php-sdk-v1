<?php

namespace Webflavia\Test\Http;

use Webflavia\Http\Client;

class ClientTest extends \PHPUnit_Framework_TestCase {

  private $testClient;

  public function setUp() {
    $this->testClient = new TestClient();
  }

  /**
   * @test
   */
  public function shouldBeAbleToSetOptionInConstructor() {
    $client = new TestClient(array(
      'foo' => 'bar'
    ));
    $this->assertEquals('bar', $client->getOptions('foo'));
  }

  /**
   * @test
   */
  public function shouldBeAbleToSetOption() {
    $this->testClient->setOption('foo', 'bar');
    $this->assertEquals('bar', $this->testClient->getOptions('foo'));

    $this->testClient->setOption(array(
      'baz' => 'qux'
    ));
    $this->assertEquals('qux', $this->testClient->getOptions('baz'));
  }

  /**
   * @test
   */
  public function shouldThrowExceptionWhenBaseUrlIsEmpty() {
    $this->setExpectedException('Webflavia\Exception\InvalidArgumentException');
    new Client(array('base_url' => ''));
  }

  /**
   * @test
   */
  public function shouldBeAbleToSetClient() {
    $mockClient = $this->getMock('GuzzleHttp\ClientInterface');
    $client = new TestClient(array(), $mockClient);
    $this->assertEquals($mockClient, $client->getClient());
  }

  /**
   * @test
   */
  public function shouldHasMinimumRequiredHeadersInOriginalObject() {
    $this->assertArrayHasKey('Accept', $this->testClient->getHeaders());
    $this->assertArrayHasKey('User-Agent', $this->testClient->getHeaders());
  }

  /**
   * @test
   */
  public function shouldBeAbleToSetHeader() {
    $this->testClient->setHeader('foo', 'bar');
    $this->assertEquals('bar', $this->testClient->getHeaders('foo'));

    $this->testClient->setHeader(array(
      'baz' => 'qux'
    ));
    $this->assertEquals('qux', $this->testClient->getHeaders('baz'));
  }

  /**
   * @test
   */
  public function shouldBeResetHeaders() {
    $this->testClient->resetHeaders();
    $this->assertCount(2, $this->testClient->getHeaders());
  }

  /**
   * @test
   */
  public function shouldSetAuthorizationHeader() {
    $this->testClient->authenticate('justFakeToken');
    $this->assertArrayHasKey('Authorization', $this->testClient->getHeaders());
  }
}

class TestClient extends Client {

  public function getOptions($name = null) {
    return (null === $name) ? $this->options : $this->options[$name];
  }

  public function getHeaders($name = null) {
    return (null === $name) ? $this->headers : $this->headers[$name];
  }
}

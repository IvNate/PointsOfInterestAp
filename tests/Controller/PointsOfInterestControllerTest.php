<?php


namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class PointsOfInterestControllerTest extends WebTestCase
{
    public function testCreateValidPoint()
    {
        $client = static::createClient();
        $data = array(
            'name' => 'Пермский планетарий',
            'description' => 'Описание планетария',
            'latitude' => 58.019068,
            'longitude' => 56.271742,
            'type' => 'Место');
        $client->request('POST', '/point', $data);
        $this->assertContains('{"id":1,"name":"Пермский планетарий","description":"Описание планетария","latitude":58.019068,"longitude":56.271742,"type":"Место"}',
            $client->getResponse()->getContent());
    }

    public function testCreatePointNotFoundType()
    {
        $client = static::createClient();
        $data = array(
            'name' => 'Музей пермских древностей',
            'description' => 'Описание музея',
            'latitude' => 58.013779,
            'longitude' => 56.245398,
            'type' => 'Музей');
        $client->request('POST', '/point', $data);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testCreatePointNotValidTypeLatitude()
    {
        $client = static::createClient();
        $data = array(
            'name' => 'Музей пермских древностей',
            'description' => 'Описание музея',
            'latitude' => 'текст',
            'longitude' => 56.245398,
            'type' => 'Музееей');
        $client->request('POST', '/point', $data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testCreatePointNotValidTypeLongitude()
    {
        $client = static::createClient();
        $data = array(
            'name' => 'Музей пермских древностей',
            'description' => 'Описание музея',
            'latitude' => 58.013779,
            'longitude' => 'текст',
            'type' => 'Музей');
        $client->request('POST', '/point', $data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testCreatePointEmptyLongitude()
    {
        $client = static::createClient();
        $data = array(
            'name' => 'Музей пермских древностей',
            'description' => 'Описание музея',
            'latitude' => 58.013779,
            'type' => 'Музей');
        $client->request('POST', '/point', $data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testCreatePointEmptyLatitude()
    {
        $client = static::createClient();
        $data = array(
            'name' => 'Музей пермских древностей',
            'description' => 'Описание музея',
            'longitude' => 'текст',
            'type' => 'Музей');
        $client->request('POST', '/point', $data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testCreatePointEmptyName()
    {
        $client = static::createClient();
        $data = array(
            'description' => 'Описание музея',
            'latitude' => 58.013779,
            'longitude' => 56.245398,
            'type' => 'Музей');
        $client->request('POST', '/point', $data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testCreatePointEmptyDescription()
    {
        $client = static::createClient();
        $data = array(
            'name' => 'Музей пермских древностей',
            'latitude' => 58.013779,
            'longitude' => 56.245398,
            'type' => 'Музей');
        $client->request('POST', '/point', $data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testGetInRadiusEmptyRequest()
    {
        $client = static::createClient();
        $client->request('GET', '/points?radius=1');
        $this->assertContains('[]', $client->getResponse()->getContent());
    }

    public function testGetInRadiusEmptyRequestDefaultRadius()
    {
        $client = static::createClient();
        $client->request('GET', '/points');
        $this->assertContains('[]', $client->getResponse()->getContent());
    }

    public function testGetInRadiusNotEmpty()
    {
        $client = static::createClient();
        $client->request('GET', '/points?radius=30&ip=::1');
        $this->assertContains('{"id":1,"name":"Пермский планетарий","description":"Описание планетария","latitude":58.019068,"longitude":56.271742,"type":"Место"}',
            $client->getResponse()->getContent());
    }

    public function testValidUpdatePoint()
    {
        $client = static::createClient();
        $data = array(
            'description' => 'Описание',
            'name' => 'Пермяк солёные уши',
            'latitude' => 58.013779,
            'longitude' => 56.245398,
            'type' => 'Памятник');
        $client->request('PUT', '/point/1', $data);
        $this->assertContains('{"id":1,"name":"Пермяк солёные уши","description":"Описание","latitude":58.013779,"longitude":56.245398,"type":"Памятник"}',
            $client->getResponse()->getContent());
    }

    public function testUpdatePointNotFoundType()
    {
        $client = static::createClient();
        $data = array(
            'description' => 'Описание',
            'name' => 'Пермяк солёные уши',
            'latitude' => 58.013779,
            'longitude' => 56.245398,
            'type' => '99');
        $client->request('PUT', '/point/1', $data);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testGetInRadiusNotEmptyModifiedPoint()
    {
        $client = static::createClient();
        $client->request('GET', '/points?radius=13&ip=::1');
        $this->assertContains('{"id":1,"name":"Пермяк солёные уши","description":"Описание","latitude":58.013779,"longitude":56.245398,"type":"Памятник"}',
            $client->getResponse()->getContent());
    }

    public function testGetInRadiusNotEmptyWithRadiusAndIp()
    {
        $client = static::createClient();
        $client->request('GET', '/points?radius=13&ip=::1');
        $this->assertContains('{"id":1,"name":"Пермяк солёные уши","description":"Описание","latitude":58.013779,"longitude":56.245398,"type":"Памятник"}',
            $client->getResponse()->getContent());
    }

    public function testGetInRadiusEmptyWithRadiusAndIp()
    {
        $client = static::createClient();
        $client->request('GET', '/points?radius=13&ip=121');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testUpdateNotExistPoint()
    {
        $client = static::createClient();
        $data = array(
            'description' => 'Описание',
            'name' => 'Пермяк солёные уши',
            'latitude' => 58.013779,
            'longitude' => 56.245398,
            'type' => 'Памятник');
        $client->request('PUT', '/point/1111', $data);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testUpdatePointNotValidLatitude()
    {
        $client = static::createClient();
        $data = array(
            'description' => 'Описание',
            'name' => 'Пермяк солёные уши',
            'latitude' => 'текст',
            'longitude' => 56.245398,
            'type' => 'Памятник');
        $client->request('PUT', '/point/1', $data);
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testUpdatePointNotValidId()
    {
        $client = static::createClient();
        $data = array(
            'description' => 'Описание',
            'name' => 'Пермяк солёные уши',
            'latitude' => 'текст',
            'longitude' => 56.245398,
            'type' => 'Памятник');
        $client->request('PUT', '/point/k', $data);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testGetInRadiusNotValidRadius()
    {
        $client = static::createClient();
        $client->request('GET', '/points?radius=g');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testGetInCityNotValidLimit()
    {
        $client = static::createClient();
        $client->request('GET', '/points/all?limit=g');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testGetInCityNotValidOffset()
    {
        $client = static::createClient();
        $client->request('GET', '/points/all?offset=g');
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testCreateValidPoint2()
    {
        $client = static::createClient();
        $data = array(
            'name' => 'Казанский планетарий',
            'description' => 'Описание планетария',
            'latitude' => 55.798724,
            'longitude' => 49.132724,
            'type' => 'Место');
        $client->request('POST', '/point', $data);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetInRadiusNotEmptyPoint2()
    {
        $client = static::createClient();
        $client->request('GET', '/points?radius=25&ip=127.0.0.1');
        $this->assertContains('"name":"Казанский планетарий","description":"Описание планетария","latitude":55.798724,"longitude":49.132724,"type":"Место"}',
            $client->getResponse()->getContent());
    }

    public function testGetInRadiusNotEmptyPointWithoutIp()
    {
        $client = static::createClient();
        $client->request('GET', '/points?radius=25');
        $this->assertContains('"name":"Казанский планетарий","description":"Описание планетария","latitude":55.798724,"longitude":49.132724,"type":"Место"}',
            $client->getResponse()->getContent());
    }

    public function testGetInCity()
    {
        $client = static::createClient();
        $client->request('GET', '/points/all?city=Пермь');
        $this->assertContains('{"id":1,"name":"Пермяк солёные уши","description":"Описание","latitude":58.013779,"longitude":56.245398,"type":"Памятник"}',
            $client->getResponse()->getContent());
    }

    public function testGetInCityNotExistsCity()
    {
        $client = static::createClient();
        $client->request('GET', '/points/all?city=Пер');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testGetInCityEmpty()
    {
        $client = static::createClient();
        $client->request('GET', '/points/all?city=Пермь&offset=1');
        $this->assertContains('[]', $client->getResponse()->getContent());
    }

    public function testGetInCityEmptyLimit()
    {
        $client = static::createClient();
        $client->request('GET', '/points/all?city=Пермь&limit=0');
        $this->assertContains('[]', $client->getResponse()->getContent());
    }

    public function testGetInCityNewCity()
    {
        $client = static::createClient();
        $client->request('GET', '/points/all?city=Казань');
        $this->assertContains('"name":"Казанский планетарий","description":"Описание планетария","latitude":55.798724,"longitude":49.132724,"type":"Место"}]'
            , $client->getResponse()->getContent());
    }

    public function testGetInCityEmptyIp()
    {
        $client = static::createClient();
        $client->request('GET', '/points/all');
        $this->assertContains('"name":"Казанский планетарий","description":"Описание планетария","latitude":55.798724,"longitude":49.132724,"type":"Место"}]'
            , $client->getResponse()->getContent());
    }
}
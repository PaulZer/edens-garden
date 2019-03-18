<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 15/03/2019
 * Time: 12:11
 */

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityTest extends WebTestCase
{
    public function testLoginPageIsAvailable()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());


    }

    public function testNewVisitorCanRegister()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/register');

        $form = $crawler->selectButton('Register')->form();

        $form['registration_form[firstName]'] = 'Lucas';
        $form['registration_form[lastName]'] = 'Hey there!';
        $random =
        $form['registration_form[email]'] = uniqid().'@test.com';
        $form['registration_form[plainPassword][first]'] = '123456';
        $form['registration_form[plainPassword][second]'] = '123456';

        $crawler = $client->submit($form);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}
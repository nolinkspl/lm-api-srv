<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class WriteCodeRequestsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWriting()
    {
        $this->post('/', [
            'code' => 'en',
        ]);

        $this->assertEquals(
            200, $this->response->getStatusCode()
        );
    }

    public function testWritingResult()
    {
        $this->get('/stats');
        $codes = json_decode($this->response->getContent());
        $testCodeCount = $codes->it ?? 0;

        $this->post('/', [
            'code' => 'it'
        ]);

        $this->get('/stats');
        $newCodes = json_decode($this->response->getContent());

        $this->assertEquals($testCodeCount + 1, $newCodes->it);
    }
}

<?php

namespace SchantlDev\GitWebhook\Tests;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;
use SchantlDev\GitWebhook\GitWebhookServiceProvider;

class WebhookTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('vendor:publish', ['--provider' => 'SchantlDev\GitWebhook\GitWebhookServiceProvider']);
    }

    protected function getPackageProviders($app)
    {
        return [GitWebhookServiceProvider::class];
    }

    /** @test */
    public function deploy_scripts_exists()
    {
        $this->assertFileExists(storage_path('git-webhook/git_deploy.sh'));
    }

    /** @test */
    public function route_exists()
    {
        $response = $this->post(config('git-webhook.route'));
        $response->assertStatus(200);
    }

    /** @test */
    public function try_with_signature_no_secret_set()
    {
        $response = $this->withHeaders([
            'X-Hub-Signature' => 'sha1=7eca2401815c06f1ae0aa2b306fcdec40b1751fa'
        ])->post(config('git-webhook.route'));

        $response->assertStatus(403);
    }

    /** @test */
    public function try_with_signature()
    {
        Config::set('git-webhook.secret', '1234');

        $payload = [
            'content' => 'some_content'
        ];

        $response = $this->withHeaders([
            'X-Hub-Signature' => 'sha1=7eca2401815c06f1ae0aa2b306fcdec40b1751fa'
        ])->post(config('git-webhook.route'), $payload);

        $response->assertStatus(200);
    }
}

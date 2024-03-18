<?php

namespace SchantlDev\GitWebhook\Tests;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    public function deploy_scripts_exists()
    {
        $this->assertFileExists(storage_path('git-webhook/git_deploy.sh'));
    }

    #[Test]
    public function route_exists()
    {
        $response = $this->post(config('git-webhook.route'));
        $response->assertStatus(200);
    }

    #[Test]
    public function try_with_signature_no_secret_set()
    {
        $response = $this->withHeaders([
            'X-Hub-Signature' => 'sha1=7eca2401815c06f1ae0aa2b306fcdec40b1751fa'
        ])->post(config('git-webhook.route'));

        $response->assertStatus(403);
    }

    #[Test]
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

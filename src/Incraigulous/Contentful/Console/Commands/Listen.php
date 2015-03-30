<?php
namespace Incraigulous\Contentful\Console\Commands;

use Illuminate\Console\Command;
use Incraigulous\ContentfulSDK\PayloadBuilders\Webhook;
use Symfony\Component\Console\Input\InputOption;
use URL;
use ContentfulManagement;
use Exception;

/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/29/15
 * Time: 1:56 PM
 */

class Listen extends Command {
    protected $name = 'contentful:listen';
    protected $description = 'Creates a webhook for a contentful URL and removes it when the process ends. Should be ran with Supervisor.';
    protected $processActive = true;

    protected function getWebhookId() {
        return md5($this->option('url'));
    }

    public function fire()
    {
        $this->create();
        $this->listen();
    }

    public function create() {
        try {
            ContentfulManagement::webhooks()->put($this->getWebhookId(), new Webhook($this->option('url')));
        } catch (Exception $ex) {
            echo $ex->getMessage();
            echo PHP_EOL;
            exit;
        }

        echo 'Webhook for url ' . $this->option('url') . ' successfully created';
        echo PHP_EOL;
    }

    public function listen() {
        pcntl_signal(SIGTERM, array($this, 'delete'));
        pcntl_signal(SIGINT, array($this, 'delete'));

        echo 'Listening for process termination';
        echo PHP_EOL;

        do {
            pcntl_signal_dispatch();
            sleep(5);
        } while ($this->processActive);
    }

    public function delete() {
        echo 'Process termination registered';
        echo PHP_EOL;
        try {
            ContentfulManagement::webhooks()->delete($this->getWebhookId());
        } catch (Exception $ex) {
            echo $ex->getMessage();
            echo PHP_EOL;
            exit;
        }
        echo 'Webhook deleted';
        echo PHP_EOL;
        $this->processActive = false;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['url', null, InputOption::VALUE_OPTIONAL, 'Destination URL for the Contentful webhook', URL::to('/') . '/contentful/flush'],
        ];
    }

}
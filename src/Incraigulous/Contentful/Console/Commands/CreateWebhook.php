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

class CreateWebhook extends Command {
    protected $name = 'contentful:create-webhook';

    protected $description = 'Create a webhook in Contentful';

    public function fire()
    {
        echo PHP_EOL;

        try {
            ContentfulManagement::webhook()->post(new Webhook($this->option('url')));
        } catch (Exception $ex) {
            echo $ex->getMessage();
            echo PHP_EOL;
            return;
        }

        echo 'Webhook for url ' . $this->option('url') . ' successfully created.';
        echo PHP_EOL;
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
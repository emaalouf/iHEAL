<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/iHealCMS
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/iHealCMS
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Support\Manager\DatabaseManager;
use Juzaweb\CMS\Support\Manager\FinalInstallManager;
use Juzaweb\CMS\Support\Manager\InstalledFileManager;

class InstallCommand extends Command
{
    protected $signature = 'iHealCMS:install';

    public function handle(
        DatabaseManager $databaseManager,
        InstalledFileManager $fileManager,
        FinalInstallManager $finalInstall
    ): int {
        $this->info('iHealCMS INSTALLER');
        $this->info('-- Database Install');

        $result = $databaseManager->run();
        if (Arr::get($result, 'status') == 'error') {
            throw new Exception($result['message']);
        }

        $this->info('-- Publish assets');
        $result = $finalInstall->runFinal();
        if (Arr::get($result, 'status') == 'error') {
            throw new Exception($result['message']);
        }

        $this->info('-- Create user admin');
        $this->call('iHealCMS:make-admin');

        $this->info('-- Update installed');
        $fileManager->update();

        $this->info('CMS Install Successfully !!!');

        return self::SUCCESS;
    }
}

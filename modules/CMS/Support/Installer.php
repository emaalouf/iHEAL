<?php

/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/iHealCMS
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/iHealCMS
 * @license    GNU V2
*/

namespace Juzaweb\CMS\Support;

class Installer
{
    /**
     * If application is already installed.
     *
     * @return bool
     */
    public static function alreadyInstalled()
    {
        return file_exists(static::installedPath());
    }

    public static function installedPath()
    {
        return storage_path('app/installed');
    }
}

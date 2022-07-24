<?php

namespace  Eliberiosoft\SsoKeyManager\Commands;

use Eliberiosoft\SsoKeyManager\SodiumManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SsoKeyManagerInstall extends Command
{
    protected $signature = 'eliberiosoft:sso-key-manager';

    protected $description = 'Install files with content sso-key-manager';

    public function handle()
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'Eliberiosoft\SsoKeyManager\SsoKeyManagerServiceProvider',
        ]);
        do {
            $application = $this->ask('Digit ID application:');
        } while (trim($application) === '');

        $item = DB::connection(config('database.sso_manager.connection'))
            ->table(config('database.sso_manager.table'))
            ->where('id', '=', $application)->first();

        if (is_null($item)) {
            $this->error('Id application '.$application.' not found');
            throw new NotFoundHttpException('Id application '.$application.' not found');
        }

        $this->warn('Setting Keys in app '.$item->id);
        $ssoManager = new SodiumManager();
        $key = $ssoManager->generatePrivatePublicKey();

        DB::connection(config('database.sso_manager.connection'))
            ->table(config('database.sso_manager.table'))
            ->where('id', '=', $application)->update(
                [
                    'private_key' => $key->privateKey,
                    'public_key' => $key->publicKey,
                    'nonce_key' => $key->randomNonce,
                ]
            );
        $this->info('SSO KEY MANAGER installed successes.');
    }
}

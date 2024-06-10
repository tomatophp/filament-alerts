<?php

namespace TomatoPHP\FilamentAlerts\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use TomatoPHP\ConsoleHelpers\Traits\HandleStub;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;

class FilamentAlertsFCM extends Command
{
    use RunCommand;
    use HandleStub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'filament-alerts:fcm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install fcm worker for filament alerts.';

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Install FCM Worker');
        $this->generateStubs(
            __DIR__ . '/../../stubs/firebase.stub',
            public_path('firebase-messaging-sw.js'),
            [
                'apiKey' => setting('fcm_apiKey'),
                'authDomain' => setting('fcm_authDomain'),
                'databaseURL' => setting('fcm_database_url'),
                'projectId' => setting('fcm_projectId'),
                'storageBucket' => setting('fcm_storageBucket'),
                'messagingSenderId' => setting('fcm_messagingSenderId'),
                'appId' => setting('fcm_appId'),
                'measurementId' => setting('fcm_measurementId'),
                'sound' => setting('notifications_sound') ? "var audio = new Audio('".setting('notifications_sound')."');\n audio.play();": null
            ]
        );
        $this->info('Filament Alerts FCM installed successfully.');
    }
}

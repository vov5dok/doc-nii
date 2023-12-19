<?php

namespace App\Console\Commands;

use App\Models\MoonshineUser;
use App\Services\UserActivateService;
use Illuminate\Console\Command;

class ActivateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:activate {email? : email of } {--all : activate all users, you dont need to set the email parameter if you use this option}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'activate user by email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(UserActivateService $userActivateService): int
    {
        if ($this->hasOption('all')) {
            $this->comment('Активация всех пользователей');
            $userActivateService->activate();
            $this->comment("Все пользователи активированы");
        } else {
            $email = $this->argument('email');
            if ($email === 0) {
                $this->comment('Вы не указали email пользователя');
            } else {
                $this->comment("Активация пользователя $email");
                $activated = MoonshineUser::where('email', $email)->activate();
                if ($activated === 0) {
                    $this->comment("Пользователь с таким email не найден");
                } else {
                    $this->comment('Активация пользователя прошла успешно');
                }
            }
        }

        return Command::SUCCESS;
    }
}

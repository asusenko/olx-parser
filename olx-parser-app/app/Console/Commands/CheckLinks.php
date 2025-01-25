<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'links:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email for price checking';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // // Send a test email
            // Mail::raw('This is a test email from the CheckLinks command.', function ($message) {
            //     $message->to('susenko.andrii@gmail.com')
            //             ->subject('Test Email from Laravel');
            // });
            echo "test \n";
            $this->info('Test email sent successfully!');
        } catch (\Exception $e) {
            $this->error('Failed to send email: ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
}

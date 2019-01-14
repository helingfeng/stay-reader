<?php
/**
 * User: Chester
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class PayloadController
{
    public function index()
    {
        $secret = request()->input('secret', '');
        if ($secret == 'publish_blog') {
            // && /home/wwwroot/StayReader/Laravel/public/hexo-blog/node_modules/.bin/hexo g
            $command = 'cd /home/wwwroot/StayReader/Laravel/public/hexo-blog && git pull && /home/wwwroot/StayReader/Laravel/public/hexo-blog/node_modules/.bin/hexo g';
//            $command = 'id www';
            $process = new Process($command);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            return response()->json(['message' => $process->getOutput()]);
        }
        Log::info("remote request key :{$secret}");
        return response()->json(['message' => 'receive push event.']);
    }


}
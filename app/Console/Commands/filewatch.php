<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Events\NewFrame as Frame;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\Finder\Finder;

class filewatch extends Command {
    protected $signature = 'filewatch';
    protected $description = 'Watches paths for changes.';

    private $mapping = [];
    private $io_instance = null;
    private $semaphore = true;

    public function handle() {
        $directory ='/tmp/ramdisk';
    
        if (!empty($directory)) {
            $this->io_instance = inotify_init();
            stream_set_blocking($this->io_instance, 0);        
            $this->add_watch($directory);

            while ($this->semaphore) {
                //sleep(1);
                $events = inotify_read($this->io_instance);

                if (!empty($events)) {
                    foreach ($events as $event) {
                        $dir = $this->mapping[$event['wd']];
                        $filename = $event['name'];
                        $path = "$dir/$filename";
                        dump($filename);
                        Frame::dispatch(Storage::url('tmp/ramdisk/tmp.jpg'));
                    }
                }
            }

            foreach (array_keys($this->mapping) as $watch) {
                inotify_rm_watch($this->io_instance, $watch);
            }

            fclose($this->io_instance);
        }
    }

    private function add_watch($dir) {
        $watch = inotify_add_watch($this->io_instance, $dir, IN_CREATE | IN_DELETE | IN_MODIFY );
        $this->mapping[$watch] = $dir;
        
    }
}
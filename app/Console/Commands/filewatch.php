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
    private $old = null;

    public function handle() {
        $directory ='/tmp/ramdisk/photos';
    
        if (!empty($directory)) {
            $this->io_instance = inotify_init();
            stream_set_blocking($this->io_instance, 0);        
            $this->add_watch($directory);
            $arr=null;
            $index=0;
            while ($this->semaphore) {
                $events = inotify_read($this->io_instance);
                
                if (!empty($events)) {
 
                    foreach ($events as $event) {
                        $dir = $this->mapping[$event['wd']];
                        $filename = $event['name'];
                        $path = "$dir/$filename";
                        if( $filename != $this->old){
                            
                            $path = 'public/tmp/ramdisk/photos/'.$this->old;
                            $data = Storage::get($path);
                            $base64 = 'data:image/jpg;base64,' . base64_encode($data);
                            //$arr[]=Storage::url($path);
                            $arr[]=$base64;
                            $index= $index+1;
                            if($index==5){
                                Frame::dispatch($arr);
                                $index=0;
                                $arr=[];
                            
                            }
                           
                            $this->old = $filename;
                        
                        }
                        
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
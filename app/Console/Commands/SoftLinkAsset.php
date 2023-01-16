<?php

namespace App\Console\Commands;

use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SoftLinkAsset extends Command
{
    /**
     * 命令名称及签名.
     *
     * @var string
     */
    protected $signature = 'lite-web:link-asset';

    /**
     * 命令描述.
     *
     * @var string
     */
    protected $description = 'Create soft links';

    /**
     * 创建命令.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 执行命令.
     *
     * @throws Exception
     */
    public function handle()
    {
        if ($this->confirm('This operation will hard copy and replace the file are you sure?')) {
            $useTemplatePath = base_path('templates/' . env('TEMPLATE', 'default') . '/public');
            if ($useTemplatePath){

                $files = scandir($useTemplatePath, 1);
                if (!empty($files)) {
                    foreach ($files as $file) {
                        if ($file == 'index.php') {
                            throw new Exception('The template public folder cannot contain index.php');
                        }elseif($file == '.' || $file == '..' || $file == '.gitignore') {
                            continue;
                        }
                        $from = "$useTemplatePath".DIRECTORY_SEPARATOR."$file";
                        $to =  base_path("public/$file");
                        $this->info('Start link...');
                        $this->info('Link from: ' . $from);
                        $this->info('Link to: ' . $to);
//                        $this->info('ln -s ' . $from . ' ' . $to);
                        File::link($from, $to);
//                        shell_exec('ln -s ' . $from . ' ' . $to);
//                        symlink($from, $to);
                    }

                }
            }else{
                $this->error('The template public folder does not exist');
            }

        }
    }
}


<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PublishTemplate extends Command
{
    /**
     * 命令名称及签名.
     *
     * @var string
     */
    protected $signature = 'lite-web:template-publish';

    /**
     * 命令描述.
     *
     * @var string
     */
    protected $description = 'Copy the template public file to the public folder';

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
     * @throws \Exception
     */
    public function handle()
    {
        if ($this->confirm('This operation will hard copy and replace the file are you sure?')) {
            $useTemplatePath = base_path('templates/' . env('TEMPLATE', 'default') . '/public');
            if (File::exists($useTemplatePath)){
                $files = scandir($useTemplatePath, 1);
                if (!empty($files)) {
                    foreach ($files as $file) {
                        if ($file == 'index.php') {
                            throw new \Exception('The template public folder cannot contain index.php');
                        }
                    }
                }
                $this->info('Start copy...');
                $this->info('Copy from: ' . $useTemplatePath);
                $this->info('Copy to: ' . base_path('public'));
                File::copyDirectory($useTemplatePath, base_path('public'));
            }else{
                $this->error('The template public folder does not exist');
            }

        }
    }
}


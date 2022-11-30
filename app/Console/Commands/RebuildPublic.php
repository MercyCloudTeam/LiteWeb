<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RebuildPublic extends Command
{
    /**
     * 命令名称及签名.
     *
     * @var string
     */
    protected $signature = 'lite-web:rebuild-public';

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
        if ($this->confirm('This operation will delete all the files in the public folder!')) {
            $this->info('Start delete...');
            $this->info('Delete from: ' . base_path('public'));
            File::deleteDirectory(base_path('public'));
            $this->info('Make public folder');
            File::makeDirectory(base_path('public'));
            $this->info('Copy from: ' . base_path('stub/public'));
            $this->info('Copy to: ' . base_path('public'));
            File::copyDirectory(base_path('stub/public'), base_path('public'));
        }
    }
}


<?php

namespace Alla\Generator\Tests\Unit\BasicBlocks;

use Alla\Generator\Tests\TestCase;
use Illuminate\Filesystem\Filesystem;
use Alla\Generator\BasicBlocks\DirectoryCreator;

class DirectoryCreatorTest extends TestCase
{

    /** @test */
    function does_it_work()
    {
        $this->assertEquals('It Works', 'It Works');
    }

    /** @test */
    function create_directories()
    {
        $directory_creator = new DirectoryCreator;

        $base_directory = getcwd() . "/tests/Unit/BasicBlocks";
        $directory_creator->setBaseDirectory($base_directory);
        $folders_map = [
            "base_folder" => [
                "here",
                "there",
                "arrayFolder" => [
                    "here",
                    "there"
                ]
            ]
        ];
        $directory_creator->setFoldersMap($folders_map);

        // Test Is Here
        $directory_creator->createFolders();

        $filesystem = new Filesystem;


        $this->assertTrue($filesystem->exists($base_directory . "/base_folder"));
        $this->assertTrue($filesystem->exists($base_directory . "/base_folder/here"));
        $this->assertTrue($filesystem->exists($base_directory . "/base_folder/there"));
        $this->assertTrue($filesystem->exists($base_directory . "/base_folder/arrayFolder"));
        $this->assertTrue($filesystem->exists($base_directory . "/base_folder/arrayFolder/here"));
        $this->assertTrue($filesystem->exists($base_directory . "/base_folder/arrayFolder/there"));

        $filesystem->deleteDirectory($base_directory . "/base_folder");
    }

    /** @test */
    function recreate_directories()
    {
        $directory_creator = new DirectoryCreator;

        $base_directory = getcwd() . "/tests/Unit/BasicBlocks";
        $directory_creator->setBaseDirectory($base_directory);
        $folders_map = [
            "base_folder" => [
                "here",
                "there",
                "arrayFolder" => [
                    "here",
                    "there"
                ]
            ]
        ];
        $directory_creator->setFoldersMap($folders_map);
        $directory_creator->createFolders();

        // Test Is Here
        $directory_creator->createFolders();

        $filesystem = new Filesystem;


        $this->assertTrue($filesystem->exists($base_directory . "/base_folder"));
        $this->assertTrue($filesystem->exists($base_directory . "/base_folder/here"));
        $this->assertTrue($filesystem->exists($base_directory . "/base_folder/there"));
        $this->assertTrue($filesystem->exists($base_directory . "/base_folder/arrayFolder"));
        $this->assertTrue($filesystem->exists($base_directory . "/base_folder/arrayFolder/here"));
        $this->assertTrue($filesystem->exists($base_directory . "/base_folder/arrayFolder/there"));

        $filesystem->deleteDirectory($base_directory . "/base_folder");
    }
}

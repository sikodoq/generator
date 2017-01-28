<?php
/**
 * Created by PhpStorm.
 * User: fernandobritofl
 * Date: 4/22/15
 * Time: 10:34 PM
 */

namespace Laralib\L5scaffold\Makes;

use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Filesystem\Filesystem;
use Laralib\L5scaffold\Commands\ScaffoldMakeCommand;
use Laralib\L5scaffold\Migrations\SchemaParser;
use Laralib\L5scaffold\Migrations\SyntaxBuilder;

class MakeRoute
{
    use AppNamespaceDetectorTrait, MakerTrait;

    /**
     * Create a new instance.
     *
     * @param ScaffoldMakeCommand $scaffoldCommand
     * @param Filesystem $files
     * @return void
     */
    public function __construct(ScaffoldMakeCommand $scaffoldCommand, Filesystem $files)
    {
        $this->files = $files;
        $this->scaffoldCommandObj = $scaffoldCommand;

        $this->start();
    }

    /**
     * Start make controller.
     *
     * @return void
     */
    private function start()
    {
        $name = $this->scaffoldCommandObj->getObjName('Name');
        $path = $this->getPath($name, 'route');

        $stub = $this->compileRouteStub();
        
        if (strpos($this->files->get($path), $stub) === false) {
            $this->files->append($path, $this->compileRouteStub());
            return $this->scaffoldCommandObj->info('+ Routes Updated successfully.');
        }
        
        return $this->scaffoldCommandObj->comment("x Routes Updated Skipped.");
    }

    /**
     * Compile the migration stub.
     *
     * @return string
     */
    protected function compileRouteStub()
    {
        $stub = $this->files->get(substr(__DIR__,0, -5) . 'Stubs/route.stub');

        $this->buildStub($this->scaffoldCommandObj->getMeta(), $stub);

        return $stub;
    }
}
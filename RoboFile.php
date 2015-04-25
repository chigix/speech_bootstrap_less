<?php

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks {

    public function chijiInit() {
        $this->say("BANKAI");
    }

    public function chijiBuild() {
        $this->say("start....");
        $project = new \Chigi\Chiji\Project\Project(__DIR__ . "/demo/src/chiji-conf.php");
        \Chigi\Chiji\Util\ProjectUtil::registerProject($project);
        foreach ($project->getReleaseDirs() as $dir) {
            /* @var $dir \Chigi\Component\IO\File */
            $this->say($dir->getAbsolutePath());
            if (!$dir->exists()) {
                $dir->mkdirs();
            }
            $this->taskCleanDir($dir->getAbsolutePath());
        }
        foreach ($project->getSourceDirs() as $dir) {
            /* @var $dir File */
            $finder = new \Symfony\Component\Finder\Finder();
            foreach ($finder->files()->followLinks()->in($dir->getAbsolutePath()) as $spl_file) {
                $file = new \Chigi\Component\IO\File($spl_file->getPathname());
                if (($road = $project->getMatchRoad($file)) instanceof \Chigi\Chiji\Project\SourceRoad) {
                    $this->say('Registered <' . $road->getName() . '>:' . $file->getAbsolutePath());
                }
            }
        }
        foreach ($project->getRegisteredResources() as $resource) {
            /* @var $resource \Chigi\Chiji\File\AbstractResourceFile */
            if ($resource instanceof Chigi\Chiji\File\Annotation) {
                $resource->analyzeAnnotations();
            }
        }
        foreach ($project->getReleasesCollection() as $resource) {
            /* @var $resource \Chigi\Chiji\File\AbstractResourceFile */
            $project->getMatchRoad($resource->getFile())->releaseResource($resource);
            $this->say("[Released] " . $resource->getRealPath());
        }
        foreach (Chigi\Chiji\Util\StaticsManager::getPostEndFunctionAnnotations() as $function) {
            /* @var $function \Chigi\Chiji\Annotation\FunctionAnnotation */
            $function->execute();
        }
    }

}

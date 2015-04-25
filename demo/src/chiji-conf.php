<?php

class Configuration extends \Chigi\Chiji\Project\ProjectConfig {

    public function getProjectName() {
        return "speech_demo";
    }

    public function getRoadMap() {
        $road_map = new \Chigi\Chiji\Collection\RoadMap();
        $road_map->append(new \Chigi\Chiji\Project\LessRoad("VENDOR_LESS", new \Chigi\Component\IO\File("../../bower_components", $this->getProjectRootPath()), new \Chigi\Component\IO\File("../dist/vendor", $this->getProjectRootPath())));
        $road_map->append(new \Chigi\Chiji\Project\SourceRoad("VENDOR_RC", new \Chigi\Component\IO\File("../../bower_components", $this->getProjectRootPath()), new \Chigi\Component\IO\File("../dist/vendor", $this->getProjectRootPath())));
        $road_map->append(new \Chigi\Chiji\Project\LessRoad("LESS", new \Chigi\Component\IO\File("./styles", $this->getProjectRootPath()), new \Chigi\Component\IO\File("../dist/css", $this->getProjectRootPath())));
        $road_map->append(new \Chigi\Chiji\Project\SourceRoad("ROOT", new \Chigi\Component\IO\File($this->getProjectRootPath()), new \Chigi\Component\IO\File("../dist", $this->getProjectRootPath())));
        return $road_map;
    }

}

return new Configuration();
?>
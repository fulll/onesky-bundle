<?php

namespace OpenClassrooms\Bundle\OneSkyBundle\Model;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
abstract class File
{
    public const FILENAME_SEPARATOR = '__';

    public const PROJECT_ID = 'project_id';

    public const SOURCE_FILE_PATH = 'file';

    /**
     * @var int
     */
    protected $projectId;

    /**
     * @var string
     */
    protected $sourceFilePath;

    /**
     * @var string
     */
    protected $sourceFilePathRelativeToProject;

    public function __construct($projectId, $sourceFilePath, $projectDirectory)
    {
        $this->projectId = $projectId;
        $this->sourceFilePath = realpath($sourceFilePath);
        $this->sourceFilePathRelativeToProject = str_replace(realpath($projectDirectory), '', $this->sourceFilePath);
    }

    /**
     * @return string
     */
    public function getSourceFilePathRelativeToProject()
    {
        return $this->sourceFilePathRelativeToProject;
    }

    /**
     * @return string[]
     */
    abstract public function format();

    /**
     * @return string
     */
    public function getEncodedSourceFileName()
    {
        return str_replace(\DIRECTORY_SEPARATOR, self::FILENAME_SEPARATOR, $this->sourceFilePathRelativeToProject);
    }
}

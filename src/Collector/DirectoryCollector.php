<?php

namespace SensioLabs\Deptrac\Collector;

use SensioLabs\AstRunner\AstMap;
use SensioLabs\AstRunner\AstParser\AstClassReferenceInterface;
use SensioLabs\AstRunner\AstParser\AstParserInterface;
use SensioLabs\AstRunner\AstParser\NikicPhpParser\AstFileReference;

class DirectoryCollector implements CollectorInterface
{
    public function getType(): string
    {
        return 'directory';
    }

    public function satisfy(
        array $configuration,
        AstClassReferenceInterface $abstractClassReference,
        AstMap $astMap,
        Registry $collectorRegistry,
        AstParserInterface $astParser
    ): bool {
        $fileReference = $abstractClassReference->getFileReference();
        assert($fileReference instanceof AstFileReference);

        return 1 === preg_match(
            '#'.$this->getRegexByConfiguration($configuration).'#i',
            $fileReference->getFilepath()
        );
    }

    private function getRegexByConfiguration(array $configuration)
    {
        if (!isset($configuration['regex'])) {
            throw new \LogicException('DirectoryCollector needs the regex configuration.');
        }

        return $configuration['regex'];
    }
}

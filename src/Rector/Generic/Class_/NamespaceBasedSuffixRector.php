<?php

namespace Worksome\CodingStyle\Rector\Generic\Class_;

use PhpParser\Node;
use Rector\Core\Configuration\RenamedClassesDataCollector;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Renaming\NodeManipulator\ClassRenamer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use function dirname;
use const DIRECTORY_SEPARATOR;

class NamespaceBasedSuffixRector extends AbstractRector implements ConfigurableRectorInterface
{
    public const NAMESPACE_AND_SUFFIX = 'namespace_and_suffix';

    /**
     * @var array<string, string>
     */
    private array $namespaceAndSuffix = [];

    public function __construct(
        private ClassRenamer $classRenamer,
        private RenamedClassesDataCollector $renamedClassesDataCollector,
    ) {}

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            "Change events to be suffixed with Event",
            [
                new CodeSample(
                    'class BalanceUpdated {}',
                    'class BalanceUpdatedEvent {}',
                )
            ]
        );
    }

    public function getNodeTypes(): array
    {
        return [Node\Stmt\Class_::class];
    }

    public function refactor(Node $node)
    {
        if (!$node instanceof Node\Stmt\Class_) {
            return;
        }

        $className = $this->getName($node);

        foreach ($this->namespaceAndSuffix as $namespace => $suffix) {
            if (str_ends_with($className, $suffix)) {
                return;
            }

            if (! str_starts_with($className, $namespace)) {
                return;
            }

            $newClassName = "$className$suffix";
            $oldToNewClasses = [
                $className => $newClassName,
            ];

            $this->classRenamer->renameNode($node, $oldToNewClasses);
            $this->renamedClassesDataCollector->addOldToNewClasses($oldToNewClasses);

            $this->moveFile($newClassName);
        }
    }

    /**
     * @param array<string, array<string, string>> $configuration
     */
    public function configure(array $configuration): void
    {
        $this->namespaceAndSuffix = $configuration[self::NAMESPACE_AND_SUFFIX];
    }

    public function moveFile(string $newClassName): void
    {
        $newClassShortName = $this->nodeNameResolver->getShortName($newClassName);
        $currentDirectory = dirname($this->file->getSmartFileInfo()->getRealPath());
        $newFileLocation = $currentDirectory . DIRECTORY_SEPARATOR . $newClassShortName . '.php';

        $this->removedAndAddedFilesCollector->addMovedFile(
            $this->file,
            $newFileLocation
        );
    }
}
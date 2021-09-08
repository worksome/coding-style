<?php

namespace Worksome\CodingStyle\Rector\Generic\Class_;

use Error;
use Exception;
use Illuminate\Support\Arr;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\BetterReflection\Reflector\Exception\IdentifierNotFound;
use PHPStan\Reflection\ClassReflection;
use Rector\Core\Configuration\RenamedClassesDataCollector;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Renaming\NodeManipulator\ClassRenamer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Throwable;
use function dirname;
use const DIRECTORY_SEPARATOR;

class ParentBasedSuffixRector extends AbstractRector implements ConfigurableRectorInterface
{
    public const PARENT_AND_SUFFIX = 'parent_and_suffix';

    /**
     * @var array<string, string>
     */
    private array $parentAndSuffix = [];

    public function __construct(
        private ClassRenamer $classRenamer,
        private RenamedClassesDataCollector $renamedClassesDataCollector,
    ) {}

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            "Suffix a class based on parent class or interface",
            [
                new CodeSample(
                    'class UpdateBalance extends Job {}',
                    'class UpdateBalanceJob {}',
                )
            ]
        );
    }

    public function getNodeTypes(): array
    {
        return [Node\Stmt\Class_::class];
    }

    public function refactor(Node $node): ?Node
    {
        if (!$node instanceof Node\Stmt\Class_) {
            return null;
        }

        $className = $this->getName($node);

        $scope = $node->getAttribute(AttributeKey::SCOPE);
        if (!$scope instanceof Scope) {
            return null;
        }

        $classReflection = $scope->getClassReflection();
        if (!$classReflection instanceof ClassReflection) {
            return null;
        }

        foreach ($this->parentAndSuffix as $parentNameSpace => $suffix) {
            if (! $this->extendsClassOrInterface($classReflection, $parentNameSpace)) {
                continue;
            }

            if (str_ends_with($className, $suffix)) {
                return null;
            }

            $newClassName = "$className$suffix";
            $oldToNewClasses = [
                $className => $newClassName,
            ];

            $renamedNode = $this->classRenamer->renameNode($node, $oldToNewClasses);
            $this->renamedClassesDataCollector->addOldToNewClasses($oldToNewClasses);

            $this->moveFile($newClassName);
            return $renamedNode;
        }

        return null;
    }

    /**
     * @param array<string, array<string, string>> $configuration
     */
    public function configure(array $configuration): void
    {
        $this->parentAndSuffix = $configuration[self::PARENT_AND_SUFFIX];
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

    private function extendsClassOrInterface(ClassReflection $classReflection, string $namespace): bool
    {
        try {
            if ($classReflection->implementsInterface($namespace)) {
                return true;
            }

            return $classReflection->isSubclassOf($namespace);
        } catch (Throwable $e) {
            return false;
        }
    }
}
<?php
declare(strict_types=1);
interface PlaneMesuration {
    public function calculateArea(): float;
}
interface Transformation {
    public function rotate(): void;
}
class Shape {
    
}
class Rectangle extends Shape implements PlaneMesuration, Transformation {
    public function __construct(
        private float $base,
        private float $height
    ){
        Check::greaterThanZero($this->base);
        Check::greaterThanZero($this->height);
    }
    public function calculateArea(): float {
        return $this->base * $this->height;
    }
    public function rotate(): void {

    }
}
$spaces = '  ';
$reflection = new ReflectionClass('Rectangle');
// class ReflectionClass implements Reflector
// public getName(): string
// public isAbstract(): bool
// public getProperties(?int $filter = null): array of ReflectionProperty
echo $reflection->isAbstract() ? 'abstract ' : '';
echo 'class ' . $reflection->getName() . ' ';
echo ($reflection->getParentClass() ? ('extends ' . $reflection->getParentClass()->getName() . ' ') : '');
$interfaceNames = $reflection->getInterfaceNames();
echo (count($interfaceNames) !== 0 ? 'implements ' . implode(', ', $interfaceNames) . ' ': '');
echo '{' . PHP_EOL;
foreach ($reflection->getProperties() as $p) {
	$plantUMLCode = $spaces;
    // class ReflectionProperty implements Reflector
    // public isPrivate(): bool
    // public getName(): string
    // public getType(): ?ReflectionType
	$plantUMLCode .= match(true) {
		$p->isPrivate() => '- ',
		$p->isProtected() => '# ',
		$p->isPublic() => '+ ',
		default => ''
	};
	if ($p->isStatic()) $plantUMLCode .= '{static} ';
    $plantUMLCode .= $p->getName() .
    ($p->getType() !== null ? (': ' . $p->getType()) : '');
	echo $plantUMLCode  . PHP_EOL;
}
// class ReflectionClass implements Reflector
// public getMethods(?int $filter = null): array of ReflectionMethod
foreach ($reflection->getMethods() as $m) {
	$plantUMLCode = $spaces;
    // class ReflectionMethod extends ReflectionFunctionAbstract
    // public isPrivate(): bool
    // public ReflectionFunctionAbstract::getName(): string
    // public ReflectionFunctionAbstract::getParameters(): array of ReflectionParameter
    // public ReflectionFunctionAbstract::getReturnType(): ?ReflectionType

    // ---
    // class ReflectionParameter implements Reflector
    // public getName(): string
    // public getType(): ?ReflectionType

	if ($m->getName() === '__construct') continue;
	$plantUMLCode .= match(true) {
		$m->isPrivate() => '- ',
		$m->isProtected() => '# ',
		$m->isPublic() => '+ ',
		default => ''
	};
	if ($m->isAbstract()) $plantUMLCode .= '{abstract} ';
	if ($m->isStatic()) $plantUMLCode .= '{static} ';
    $parameters = [];
    foreach($m->getParameters() as $p) {
        $parameters[] =
            $p->getName() .
            ($p->getType() !== null ? (': ' . $p->getType()) : '');
    }
    // implode(string $separator, array $prray): string
    $plantUMLCode .=
        $m->getName() . '(' . implode(', ', $parameters) . ')' .
        ($m->getReturnType() !== null ? (': ' . $m->getReturnType()) : '');
	echo $plantUMLCode  . PHP_EOL;
}
echo '}' . PHP_EOL;
<?php
declare(strict_types=1);
trait ToPlantUML {
	function __toString(): string {
        $plantUMLCode = '';
        $spaces = '  ';
        // class ReflectionClass implements Reflector
        // public ReflectionClass::__construct(object|string $objectOrClass)
        // public getName(): string
        // public isAbstract(): bool
        // public getProperties(?int $filter = null): array of ReflectionProperty
        $reflection = new ReflectionClass($this);
        $plantUMLCode .= $reflection->isAbstract() ? 'abstract ' : '';
        $plantUMLCode .= 'class ' . $reflection->getName() . ' ';
        $plantUMLCode .= ($reflection->getParentClass() ? ('extends ' . $reflection->getParentClass()->getName() . ' ') : '');
        $interfaceNames = $reflection->getInterfaceNames();
        $plantUMLCode .= (count($interfaceNames) !== 0 ? 'implements ' . implode(', ', $interfaceNames) . ' ': '');
        $plantUMLCode .= '{' . PHP_EOL;
        foreach ($reflection->getProperties() as $p) {
            $plantUMLCode .= $spaces;
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
            $plantUMLCode .= PHP_EOL;
        }
        // class ReflectionClass implements Reflector
        // public getMethods(?int $filter = null): array of ReflectionMethod
        foreach ($reflection->getMethods() as $m) {
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
            $plantUMLCode .= $spaces;
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
            $plantUMLCode .=
                $m->getName() . '(' . implode(', ', $parameters) . ')' .
                ($m->getReturnType() !== null ? (': ' . $m->getReturnType()) : '');
            $plantUMLCode .= PHP_EOL;
        }
        $plantUMLCode .= '}' . PHP_EOL;
		return $plantUMLCode;
	}
}
<?php
declare(strict_types=1);

require_once('ToPlantUML.php');

interface Identifiable {
    public function getId(): string;
}

interface Workable {
    public function doWork(string $task, int $priority): bool;
}

abstract class Person {
    protected string $name;
    
    public function __construct(string $name) {
        $this->name = $name;
    }

    abstract public function getRole(): string;
}

class Manager extends Person implements Identifiable, Workable {
    use ToPlantUML;

    private float $budget;
    public static string $companyRegion = "EMEA";

    public function __construct(string $name, float $budget) {
        parent::__construct($name);
        $this->budget = $budget;
    }

    public function getId(): string {
        return "MGR-" . spl_object_id($this);
    }

    public function doWork(string $task, int $priority = 1): bool {
        return true;
    }

    public function getRole(): string {
        return "Management";
    }

    private function calculateBonus(?float $percentage): float {
        return $this->budget * ($percentage ?? 0.05);
    }
}

// Execution
$manager = new Manager("Jordi", 50000.0);
echo $manager;
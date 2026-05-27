<?php
namespace App\Model;

use App\Service\Config;

class Car
{
    private ?int $id = null;
    private ?string $brand = null;
    private ?string $model = null;
    private ?int $year = null;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): Car { $this->id = $id; return $this; }

    public function getBrand(): ?string { return $this->brand; }
    public function setBrand(?string $brand): Car { $this->brand = $brand; return $this; }

    public function getModel(): ?string { return $this->model; }
    public function setModel(?string $model): Car { $this->model = $model; return $this; }

    public function getYear(): ?int { return $this->year; }
    public function setYear(?int $year): Car { $this->year = $year; return $this; }

    public static function fromArray($array): Car
    {
        $car = new self();
        $car->fill($array);
        return $car;
    }

    public function fill($array): Car
    {
        if (isset($array['id']) && !$this->id) $this->id = $array['id'];
        if (isset($array['brand'])) $this->brand = $array['brand'];
        if (isset($array['model'])) $this->model = $array['model'];
        if (isset($array['year'])) $this->year = (int)$array['year'];
        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $stmt = $pdo->prepare("SELECT * FROM car ORDER BY id DESC");
        $stmt->execute();

        $cars = [];
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $cars[] = self::fromArray($row);
        }
        return $cars;
    }

    public static function find($id): ?Car
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $stmt = $pdo->prepare("SELECT * FROM car WHERE id = :id");
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row ? self::fromArray($row) : null;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));

        if (!$this->id) {
            $stmt = $pdo->prepare("INSERT INTO car (brand, model, year) VALUES (:brand, :model, :year)");
            $stmt->execute([
                'brand' => $this->brand,
                'model' => $this->model,
                'year' => $this->year,
            ]);
            $this->id = $pdo->lastInsertId();
        } else {
            $stmt = $pdo->prepare("UPDATE car SET brand = :brand, model = :model, year = :year WHERE id = :id");
            $stmt->execute([
                'brand' => $this->brand,
                'model' => $this->model,
                'year' => $this->year,
                'id' => $this->id,
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $stmt = $pdo->prepare("DELETE FROM car WHERE id = :id");
        $stmt->execute(['id' => $this->id]);

        $this->id = null;
        $this->brand = null;
        $this->model = null;
        $this->year = null;
    }
}

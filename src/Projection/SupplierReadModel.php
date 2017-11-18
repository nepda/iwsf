<?php

declare(strict_types=1);

namespace IWantSomeFood\Projection;

final class SupplierReadModel extends \Prooph\EventStore\Projection\AbstractReadModel
{
    /**
     * @var \PDO
     */
    private $connection;

    private $readTableName = 'read_supplier';

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function init(): void
    {
        $sql = <<<EOT
CREATE TABLE `{$this->readTableName}` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name_change_count` int(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
EOT;

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function isInitialized(): bool
    {
        $sql = 'SHOW TABLES LIKE \'' . $this->readTableName . '\';';

        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetch();

        return !($result === false);
    }

    public function reset(): void
    {
        $sql = "TRUNCATE TABLE `{$this->readTableName}`;";
        $this->connection->prepare($sql)->execute();
    }

    public function delete(): void
    {
        $sql = "DROP TABLE `{$this->readTableName}`";
        $this->connection->prepare($sql)->execute();
    }

    protected function insert(array $data): void
    {
        $sql = "INSERT INTO `{$this->readTableName}` (id, name, name_change_count) VALUES(:id, :name, 0)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'name' => $data['name'],
        ]);
    }

    protected function changeName(array $data): void
    {
        $sql = "UPDATE `{$this->readTableName}` SET `name` = :name, name_change_count=name_change_count+1 WHERE `id` = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'name' => $data['name'],
        ]);
    }
}

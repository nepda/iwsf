<?php

declare(strict_types=1);

namespace IWantSomeFood\Projection;

final class MealReadModel extends \Prooph\EventStore\Projection\AbstractReadModel
{
    /**
     * @var \PDO
     */
    private $connection;

    private $readTableName = 'read_meal';

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function init(): void
    {
        $tableName = $this->readTableName;

        $sql = <<<EOT
CREATE TABLE `$tableName` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title_change_count` int(50) COLLATE utf8_unicode_ci NOT NULL,
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
        $sql = "INSERT INTO `{$this->readTableName}` (id, title, title_change_count) VALUES(:id, :title, 0)";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'title' => $data['title'],
        ]);
    }

    protected function changeTitle(array $data): void
    {
        $sql = "UPDATE `{$this->readTableName}` SET `title` = :title, title_change_count=title_change_count+1 WHERE `id` = :id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            'id' => $data['id'],
            'title' => $data['title'],
        ]);
    }
}

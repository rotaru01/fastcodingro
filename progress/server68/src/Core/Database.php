<?php
/**
 * Scanbox.ro - Wrapper PDO pentru operatii cu baza de date
 *
 * Ofera metode simplificate pentru interogari, inserari, actualizari
 * si stergeri. Foloseste intotdeauna prepared statements pentru securitate.
 * Logheaza erorile in logs/error.log.
 *
 * @package Scanbox\Core
 * @version 1.0.0
 */

declare(strict_types=1);

namespace Scanbox\Core;

class Database
{
    /** @var self|null Instanta singleton */
    private static ?self $instance = null;

    /** @var \PDO Instanta conexiunii PDO */
    private \PDO $pdo;

    /** @var string Calea catre fisierul de loguri */
    private string $logFile;

    /**
     * Constructor - obtine conexiunea PDO prin singleton
     *
     * Foloseste clasa DatabaseConnection din config/database.php
     * pentru a obtine instanta unica a conexiunii.
     */
    public function __construct()
    {
        $this->pdo = \DatabaseConnection::getInstance();
        $this->logFile = __DIR__ . '/../../logs/error.log';
    }

    /**
     * Returneaza instanta singleton a clasei Database
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Executa o interogare SQL cu parametri
     *
     * Prepara si executa interogarea cu prepared statements.
     * In caz de eroare, logheaza mesajul si returneaza false.
     *
     * @param string $sql Interogarea SQL cu placeholdere
     * @param array $params Parametrii pentru prepared statement
     * @return \PDOStatement|false Statement-ul executat sau false in caz de eroare
     */
    public function query(string $sql, array $params = []): \PDOStatement|false
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (\PDOException $e) {
            $this->logError('Eroare interogare SQL', $sql, $params, $e);
            return false;
        }
    }

    /**
     * Executa o interogare si returneaza un singur rand
     *
     * @param string $sql Interogarea SQL
     * @param array $params Parametrii pentru prepared statement
     * @return array|null Randul gasit ca array asociativ sau null
     */
    public function fetch(string $sql, array $params = []): ?array
    {
        $stmt = $this->query($sql, $params);
        if ($stmt === false) {
            return null;
        }

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result !== false ? $result : null;
    }

    /**
     * Executa o interogare si returneaza toate randurile
     *
     * @param string $sql Interogarea SQL
     * @param array $params Parametrii pentru prepared statement
     * @return array Lista de randuri ca array-uri asociative (gol daca nu exista rezultate)
     */
    public function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->query($sql, $params);
        if ($stmt === false) {
            return [];
        }

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Insereaza un rand nou intr-un tabel
     *
     * Construieste automat interogarea INSERT din datele furnizate.
     * Returneaza ID-ul randului inserat sau false in caz de eroare.
     *
     * @param string $table Numele tabelului
     * @param array $data Date de inserat (coloana => valoare)
     * @return int|false ID-ul randului inserat sau false
     */
    public function insert(string $table, array $data): int|false
    {
        if (empty($data)) {
            return false;
        }

        $columns = array_keys($data);
        $placeholders = array_map(fn(string $col): string => ':' . $col, $columns);

        $sql = sprintf(
            'INSERT INTO `%s` (`%s`) VALUES (%s)',
            $table,
            implode('`, `', $columns),
            implode(', ', $placeholders)
        );

        $params = [];
        foreach ($data as $key => $value) {
            $params[':' . $key] = $value;
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return (int) $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            $this->logError('Eroare INSERT', $sql, $params, $e);
            return false;
        }
    }

    /**
     * Actualizeaza randuri intr-un tabel
     *
     * Construieste automat interogarea UPDATE. Conditia WHERE este obligatorie
     * pentru a preveni actualizari accidentale pe tot tabelul.
     *
     * @param string $table Numele tabelului
     * @param array $data Date de actualizat (coloana => valoare)
     * @param string $where Conditia WHERE (ex: 'id = :id')
     * @param array $whereParams Parametrii pentru conditia WHERE
     * @return int Numarul de randuri afectate
     */
    public function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        if (empty($data) || empty($where)) {
            return 0;
        }

        $setParts = [];
        $params = [];
        foreach ($data as $key => $value) {
            $paramKey = ':set_' . $key;
            $setParts[] = '`' . $key . '` = ' . $paramKey;
            $params[$paramKey] = $value;
        }

        /** Convertim ? pozitionali in parametri numiti :w0, :w1 etc. pentru a evita mixarea cu :set_* */
        $whereIdx = 0;
        $where = preg_replace_callback('/\?/', function () use (&$whereIdx, $whereParams, &$params) {
            $key = ':w' . $whereIdx;
            $params[$key] = $whereParams[$whereIdx] ?? null;
            $whereIdx++;
            return $key;
        }, $where);

        /** Daca whereParams avea deja chei numite (ex: ':id' => 5), le adaugam direct */
        foreach ($whereParams as $key => $value) {
            if (is_string($key)) {
                $params[$key] = $value;
            }
        }

        $sql = sprintf(
            'UPDATE `%s` SET %s WHERE %s',
            $table,
            implode(', ', $setParts),
            $where
        );

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            $this->logError('Eroare UPDATE', $sql, $params, $e);
            return 0;
        }
    }

    /**
     * Sterge randuri dintr-un tabel
     *
     * Conditia WHERE este obligatorie pentru a preveni stergerea
     * tuturor inregistrarilor din tabel.
     *
     * @param string $table Numele tabelului
     * @param string $where Conditia WHERE (ex: 'id = :id')
     * @param array $params Parametrii pentru conditia WHERE
     * @return int Numarul de randuri sterse
     */
    public function delete(string $table, string $where, array $params = []): int
    {
        if (empty($where)) {
            return 0;
        }

        $sql = sprintf('DELETE FROM `%s` WHERE %s', $table, $where);

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            $this->logError('Eroare DELETE', $sql, $params, $e);
            return 0;
        }
    }

    /**
     * Numara randurile care corespund unei conditii
     *
     * @param string $table Numele tabelului
     * @param string $where Conditia WHERE (optional)
     * @param array $params Parametrii pentru conditia WHERE
     * @return int Numarul de randuri gasite
     */
    public function count(string $table, string $where = '1=1', array $params = []): int
    {
        $sql = sprintf('SELECT COUNT(*) as total FROM `%s` WHERE %s', $table, $where);
        $result = $this->fetch($sql, $params);

        return $result !== null ? (int) $result['total'] : 0;
    }

    /**
     * Incepe o tranzactie
     *
     * @return bool True daca tranzactia a inceput cu succes
     */
    public function beginTransaction(): bool
    {
        try {
            return $this->pdo->beginTransaction();
        } catch (\PDOException $e) {
            $this->logError('Eroare beginTransaction', '', [], $e);
            return false;
        }
    }

    /**
     * Confirma tranzactia curenta
     *
     * @return bool True daca tranzactia a fost confirmata
     */
    public function commit(): bool
    {
        try {
            return $this->pdo->commit();
        } catch (\PDOException $e) {
            $this->logError('Eroare commit', '', [], $e);
            return false;
        }
    }

    /**
     * Anuleaza tranzactia curenta
     *
     * @return bool True daca tranzactia a fost anulata
     */
    public function rollback(): bool
    {
        try {
            return $this->pdo->rollBack();
        } catch (\PDOException $e) {
            $this->logError('Eroare rollback', '', [], $e);
            return false;
        }
    }

    /**
     * Returneaza instanta PDO nativa
     *
     * Utila pentru operatii avansate care necesita acces direct la PDO.
     *
     * @return \PDO Instanta PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    /**
     * Logheaza erorile de baza de date in fisierul de log
     *
     * @param string $context Descrierea contextului erorii
     * @param string $sql Interogarea SQL care a cauzat eroarea
     * @param array $params Parametrii interogarii
     * @param \PDOException $exception Exceptia aruncata
     * @return void
     */
    private function logError(string $context, string $sql, array $params, \PDOException $exception): void
    {
        $message = sprintf(
            "[%s] %s\n  SQL: %s\n  Params: %s\n  Eroare: %s\n  Fisier: %s:%d\n\n",
            date('Y-m-d H:i:s'),
            $context,
            $sql,
            json_encode($params, JSON_UNESCAPED_UNICODE),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );

        $logDir = dirname($this->logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        error_log($message, 3, $this->logFile);
    }
}

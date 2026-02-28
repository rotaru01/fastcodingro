<?php
/**
 * Scanbox.ro - Conexiune singleton la baza de date PDO
 *
 * Clasa wrapper pentru conexiunea PDO care foloseste pattern-ul Singleton
 * pentru a asigura o singura instanta a conexiunii in toata aplicatia.
 *
 * @package Scanbox
 * @version 1.0.0
 */

declare(strict_types=1);

class DatabaseConnection
{
    /** @var PDO|null Instanta unica a conexiunii PDO */
    private static ?PDO $instance = null;

    /**
     * Constructor privat - previne instantierea directa
     */
    private function __construct()
    {
    }

    /**
     * Previne clonarea instantei
     */
    private function __clone()
    {
    }

    /**
     * Previne deserializarea instantei
     *
     * @throws \RuntimeException Intotdeauna aruca exceptie
     */
    public function __wakeup(): never
    {
        throw new \RuntimeException('Nu se poate deserializa un singleton.');
    }

    /**
     * Obtine instanta unica a conexiunii PDO
     *
     * Creeaza conexiunea la prima apelare si o returneaza la apelurile ulterioare.
     * Configureaza PDO cu mod de eroare exceptie, fetch asociativ implicit,
     * si prepararile emulate dezactivate pentru securitate maxima.
     *
     * @return PDO Instanta conexiunii PDO
     * @throws \RuntimeException Daca conexiunea la baza de date esueaza
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                DB_HOST,
                DB_NAME,
                DB_CHARSET
            );

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_STRINGIFY_FETCHES  => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '" . DB_CHARSET . "' COLLATE 'utf8mb4_unicode_ci'",
                PDO::MYSQL_ATTR_FOUND_ROWS   => true,
            ];

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (\PDOException $e) {
                $logFile = __DIR__ . '/../logs/error.log';
                $message = sprintf(
                    "[%s] Eroare conexiune baza de date: %s\n",
                    date('Y-m-d H:i:s'),
                    $e->getMessage()
                );
                error_log($message, 3, $logFile);

                throw new \RuntimeException('Conexiunea la baza de date a esuat. Verificati configurarea.');
            }
        }

        return self::$instance;
    }

    /**
     * Inchide conexiunea la baza de date
     *
     * Seteaza instanta la null pentru a permite garbage collection.
     */
    public static function close(): void
    {
        self::$instance = null;
    }
}

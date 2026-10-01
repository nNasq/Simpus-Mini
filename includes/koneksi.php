<?php
$neon_link = "postgresql://neondb_owner:npg_SM4Ci6RbaqPo@ep-cool-bread-b4akwc0d-pooler.c-6.us-east-2.aws.neon.tech/neondb?sslmode=require&channel_binding=require";

$db_url = parse_url($neon_link);

$host = $db_url['host'];
$port = $db_url['port'] ?? 5432;
$user = $db_url['user'];
$pass = $db_url['pass'];
$db   = ltrim($db_url['path'], '/'); 

$dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => true,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

if (!class_exists('DatabaseSessionHandler')) {

    class DatabaseSessionHandler implements SessionHandlerInterface
    {
        private $pdo;

        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        #[\ReturnTypeWillChange]
        public function open($path, $name)
        {
            return true;
        }

        #[\ReturnTypeWillChange]
        public function close()
        {
            return true;
        }

        #[\ReturnTypeWillChange]
        public function read($id)
        {
            $stmt = $this->pdo->prepare("SELECT data FROM app_sessions WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetchColumn();
            return $data !== false ? $data : '';
        }

        #[\ReturnTypeWillChange]
        public function write($id, $data)
        {
            $waktu = time();
            $stmt = $this->pdo->prepare("INSERT INTO app_sessions (id, data, waktu) VALUES (?, ?, ?) ON CONFLICT (id) DO UPDATE SET data = EXCLUDED.data, waktu = EXCLUDED.waktu");
            return $stmt->execute([$id, $data, $waktu]);
        }

        #[\ReturnTypeWillChange]
        public function destroy($id)
        {
            $stmt = $this->pdo->prepare("DELETE FROM app_sessions WHERE id = ?");
            return $stmt->execute([$id]);
        }

        #[\ReturnTypeWillChange]
        public function gc($max_lifetime)
        {
            $stmt = $this->pdo->prepare("DELETE FROM app_sessions WHERE waktu < ?");
            $stmt->execute([time() - $max_lifetime]);
            return $stmt->rowCount();
        }
    }

    if (session_status() === PHP_SESSION_NONE) {
        session_set_save_handler(new DatabaseSessionHandler($pdo), true);
    }
}

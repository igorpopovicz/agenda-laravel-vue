use Illuminate\Support\Facades\DB;

try {
    DB::connection()->getPdo();
    echo "Conexão bem-sucedida!";
} catch (\Exception $e) {
    die("Erro de conexão: " . $e->getMessage());
}



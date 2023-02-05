<?php namespace Rupertlustosa\Rlustosa;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;

class Rlustosa
{

    protected $connection;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var RlustosaGenerate
     */
    private $rlustosaGenerate;

    protected $template;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem = null)
    {
        $this->files = $filesystem ?: new Filesystem;
        $this->filesystem = $filesystem;
        $this->rlustosaGenerate = new RlustosaGenerate();
        $this->template = config('configuracoes.template');
    }

    public function gerarModel($arquivoModel, $nomeDaClasse, $tabela)
    {
        // Get template for a seed file contents
        $stub = $this->files->get($this->getStubPath() . '/model.stub');
        $camposDaTabela = $this->rlustosaGenerate->describe($tabela);

        foreach ($camposDaTabela as $campo) {
            if ($campo['campo_original'] != 'created_at' and $campo['campo_original'] != 'updated_at' and $campo['campo_original'] != 'deleted_at')
                $fillable[] = $this->gerarFillable($campo['campo_original']);
        }

        $fillableString = implode(", ", $fillable);

        $stub = str_replace('{{class}}', $nomeDaClasse, $stub);
        $stub = str_replace('{{table}}', $tabela, $stub);
        $stub = str_replace('{{fillable}}', $fillableString, $stub);
        $stub = str_replace('{{date}}', date('d-m-Y'), $stub);
        $stub = str_replace('{{time}}', date('H:i:s'), $stub);

        if ($this->files->put($arquivoModel, $stub))
            return true;
        else return false;
    }


    public function gerarController($arquivoController, $nomeDaClasse, $tabela)
    {
        // Get template for a seed file contents
        $stub = $this->files->get($this->getStubPath() . '/controller.stub');

        $stub = str_replace('{{class}}', $nomeDaClasse, $stub);
        $stub = str_replace('{{variavelDaClasse}}', strtolower($nomeDaClasse), $stub);
        $stub = str_replace('{{table}}', $tabela, $stub);
        $stub = str_replace('{{date}}', date('d-m-Y'), $stub);
        $stub = str_replace('{{time}}', date('H:i:s'), $stub);

        if ($this->files->put($arquivoController, $stub))
            return true;
        else return false;
    }


    public function gerarRepositorio($arquivoRepositorio, $nomeDaClasse, $tabela)
    {
        // Get template for a seed file contents
        $stub = $this->files->get($this->getStubPath() . '/repository.stub');

        $camposDaTabela = $this->rlustosaGenerate->describe($tabela);

        foreach ($camposDaTabela as $campo) {
            if ($campo['campo_original'] != 'id' and $campo['campo_original'] != 'created_at' and $campo['campo_original'] != 'updated_at' and $campo['campo_original'] != 'deleted_at')
                $camposParaSalvar[] = $this->gerarCamposParaSalvarNoRepositorio(strtolower($nomeDaClasse), $campo['campo_original']);
        }

        $camposParaSalvarString = implode("\r\n", $camposParaSalvar);

        $stub = str_replace('{{class}}', $nomeDaClasse, $stub);
        $stub = str_replace('{{variavelDaClasse}}', strtolower($nomeDaClasse), $stub);
        $stub = str_replace('{{table}}', $tabela, $stub);
        $stub = str_replace('{{camposParaSalvar}}', $camposParaSalvarString, $stub);
        $stub = str_replace('{{date}}', date('d-m-Y'), $stub);
        $stub = str_replace('{{time}}', date('H:i:s'), $stub);

        if ($this->files->put($arquivoRepositorio, $stub))
            return true;
        else return false;
    }


    public function gerarService($arquivoService, $nomeDaClasse, $tabela)
    {
        // Get template for a seed file contents
        $stub = $this->files->get($this->getStubPath() . '/service.stub');

        $stub = str_replace('{{class}}', $nomeDaClasse, $stub);
        $stub = str_replace('{{variavelDaClasse}}', strtolower($nomeDaClasse), $stub);
        $stub = str_replace('{{table}}', $tabela, $stub);
        $stub = str_replace('{{date}}', date('d-m-Y'), $stub);
        $stub = str_replace('{{time}}', date('H:i:s'), $stub);

        if ($this->files->put($arquivoService, $stub))
            return true;
        else return false;
    }


    public function gerarRequest($arquivRequest, $nomeDaClasse, $tabela, $database)
    {
        // Get template for a seed file contents
        $stub = $this->files->get($this->getStubPath() . '/request.stub');

        $camposDaTabela = $this->rlustosaGenerate->describe($tabela);

        $regrasValidacao = $this->rlustosaGenerate->gerarRules($camposDaTabela, $tabela, $database);
        $regras = implode("\r\n" . '        ', $regrasValidacao['regras']);
        $thisRegras = implode("\r\n" . '            ', $regrasValidacao['rules']);

        $stub = str_replace('{{class}}', $nomeDaClasse, $stub);
        $stub = str_replace('{{variavelDaClasse}}', strtolower($nomeDaClasse), $stub);
        $stub = str_replace('{{table}}', $tabela, $stub);
        $stub = str_replace('{{thisRegras}}', $thisRegras, $stub);
        $stub = str_replace('{{regras}}', $regras, $stub);
        $stub = str_replace('{{date}}', date('d-m-Y'), $stub);
        $stub = str_replace('{{time}}', date('H:i:s'), $stub);

        if ($this->files->put($arquivRequest, $stub))
            return true;
        else return false;
    }


    public function gerarIndexView($arquivoIndexView, $tabela, $camposDaViewDeListagem, $nomeDoLabel, $bloqueios)
    {
        // Get template for a seed file contents
        $stub = $this->files->get($this->getStubPath() . '/index'.(!empty($this->template) ? '-'.$this->template : null).'.stub');

        $camposSearch = NULL;
        foreach ($camposDaViewDeListagem as $campo) {
            $camposSearch .= $this->rlustosaGenerate->gerarIndexSearch($campo);
        }

        $camposList = NULL;
        foreach ($camposDaViewDeListagem as $campo) {
            $retorno = $this->rlustosaGenerate->gerarIndexList($campo, $tabela);
            $camposList['thead'][] = $retorno['thead'];
            $camposList['tbody'][] = $retorno['tbody'];
        }

        $theadString = implode("\r\n", $camposList['thead']);
        $tbodyString = implode("\r\n", $camposList['tbody']);

        $stub = str_replace('{{table}}', $tabela, $stub);
        $stub = str_replace('{{nomeDoLabel}}', $nomeDoLabel, $stub);
        $stub = str_replace('{{camposDeBusca}}', $camposSearch, $stub);
        $stub = str_replace('{{camposTḧ}}', $theadString, $stub);
        $stub = str_replace('{{camposTR}}', $tbodyString, $stub);
        $stub = str_replace('{{date}}', date('d-m-Y'), $stub);
        $stub = str_replace('{{time}}', date('H:i:s'), $stub);

        if($bloqueios['bloquearExclusao']){
            $stub = str_replace('class="link-delete btn btn-danger">', 'class="link-delete btn btn-danger" style="display:none">', $stub);
        }

        if($bloqueios['bloquearBusca']){
            $stub = str_replace('role="form">', 'role="form" style="display:none">', $stub);
        }

        if ($this->files->put($arquivoIndexView, $stub))
            return true;
        else return false;
    }


    public function gerarIndexForm($arquivoFormView, $tabela, $camposDaViewDeCadastro, $nomeDoLabel, $nomeDaClasse, $bloqueios)
    {
        // Get template for a seed file contents
        $stub = $this->files->get($this->getStubPath() . '/form'.(!empty($this->template) ? '-'.$this->template : null).'.stub');

        $camposList = [];
        foreach ($camposDaViewDeCadastro as $campo) {
            $camposList[] = $this->rlustosaGenerate->gerarFormList($campo, $tabela);
        }

        $camposString = implode("\r\n", $camposList);

        $stub = str_replace('{{table}}', $tabela, $stub);
        $stub = str_replace('{{class}}', $nomeDaClasse, $stub);
        $stub = str_replace('{{nomeDoLabel}}', $nomeDoLabel, $stub);
        $stub = str_replace('{{camposString}}', $camposString, $stub);
        $stub = str_replace('{{date}}', date('d-m-Y'), $stub);
        $stub = str_replace('{{time}}', date('H:i:s'), $stub);

        if($bloqueios['bloquearExclusao']){
            $stub = str_replace('id="link-delete"', 'id="link-delete" style="display:none"', $stub);
        }

        if ($this->files->put($arquivoFormView, $stub))
            return true;
        else return false;
    }

    public function gerarDestroy($arquivoFormView, $tabela, $camposDaViewDeCadastro, $nomeDoLabel)
    {
        // Get template for a seed file contents
        $stub = $this->files->get($this->getStubPath() . '/confirm-destroy'.(!empty($this->template) ? '-'.$this->template : null).'.stub');

        $stub = str_replace('{{table}}', $tabela, $stub);
        $stub = str_replace('{{nomeDoLabel}}', $nomeDoLabel, $stub);
        $stub = str_replace('{{date}}', date('d-m-Y'), $stub);
        $stub = str_replace('{{time}}', date('H:i:s'), $stub);

        if ($this->files->put($arquivoFormView, $stub))
            return true;
        else return false;
    }

    public function inicializarRoutes($routePath)
    {
        $needGenesisCode = '| Gênesis Application Routes';
        $conteudoBaseDasRotas = \File::get($this->getStubPath() . '/routes.stub');

        $content = \File::get($routePath);
        if (strpos($content, $needGenesisCode) === false) {
            $content .= $conteudoBaseDasRotas;
            if ($this->files->put($routePath, $content))
                return true;
            else return false;
        }
        return true;
    }

    public function atualizarRoutes($routePath, $tabela, $nomeDaClasse)
    {
        $needGenesisCode = '	/*
	|----------------------------------------------------------------------
	| Novas rotas para o Gestor
	|----------------------------------------------------------------------
	*/';

        $needTableRoute = '/* Routes to /gestor/' . $tabela . ' */';

        $conteudoBaseDasRotas = '    ' . $needTableRoute . '
    $router->resource(\'' . $tabela . '\', \'' . $nomeDaClasse . 'Controller\');
    $router->get(\'' . $tabela . '/{id}/delete\', [
        \'as\' => \'gestor.' . $tabela . '.delete\',
        \'uses\' => \'' . $nomeDaClasse . 'Controller@confirmDestroy\'
    ])->where(\'id\', \'[0-9]+\');';

        $content = \File::get($routePath);
        if (strpos($content, $needGenesisCode) === false) {

        } else {
            if (strpos($content, $needTableRoute) === false) {
                $content = str_replace($needGenesisCode, $conteudoBaseDasRotas . "\n\n" . $needGenesisCode, $content);

                if ($this->files->put($routePath, $content))
                    return true;
                else return false;
            }
        }
        return true;
    }


    private function gerarFillable($nome)
    {
        return "'" . $nome . "'";
    }

    private function gerarCamposParaSalvarNoRepositorio($variavelDaClasse, $campo)
    {
        return '            if(isset($dados[\'' . $campo . '\']))
                $' . $variavelDaClasse . '->' . $campo . ' = trim($dados[\'' . $campo . '\']);';
    }

    /**
     * Generates a seed file.
     * @param  string $table
     * @param  string $database
     * @param  int $max
     * @return bool
     * @throws Rupertlustosa\Rlustosa\TableNotFoundException
     */
    public function generateSeed($table, $database = null, $max = 0)
    {
        if (!$database) {
            $database = config('database.default');
        }

        $this->connection = $database;

        // Check if table exists
        if (!$this->hasTable($table)) throw new TableNotFoundException("Table $table was not found.");

        // Get the data
        $data = $this->getData($table, $max);

        // Repack the data
        $dataArray = $this->repackSeedData($data);

        // Generate class name
        $className = $this->generateClassName($table);

        // Get template for a seed file contents
        $stub = $this->files->get($this->getStubPath() . '/seed.stub');

        // Get a seed folder path
        $seedPath = $this->getSeedPath();

        // Get a app/database/seeds path
        $seedsPath = $this->getPath($className, $seedPath);

        // Get a populated stub file
        $seedContent = $this->populateStub($className, $stub, $table, $dataArray);

        // Save a populated stub
        $this->files->put($seedsPath, $seedContent);

        // Update the DatabaseSeeder.php file
        return $this->updateDatabaseSeederRunMethod($className) !== false;
    }

    /**
     * Get a seed folder path
     * @return string
     */
    public function getSeedPath()
    {
        return base_path() . config('rlustosa::config.path');
    }

    /**
     * Get the Data
     * @param  string $table
     * @return Array
     */
    public function getData($table, $max)
    {
        if (!$max) {
            return \DB::connection($this->connection)->table($table)->get();
        }

        return \DB::connection($this->connection)->table($table)->limit($max)->get();
    }

    /**
     * Repacks data read from the database
     * @param  array|object $data
     * @return array
     */
    public function repackSeedData($data)
    {
        $dataArray = array();
        if (is_array($data)) {
            foreach ($data as $row) {
                $rowArray = array();
                foreach ($row as $columnName => $columnValue) {
                    $rowArray[$columnName] = $columnValue;
                }
                $dataArray[] = $rowArray;
            }
        }
        return $dataArray;
    }

    /**
     * Checks if a database table exists
     * @param string $table
     * @return boolean
     */
    public function hasTable($table)
    {
        return \Schema::connection($this->connection)->hasTable($table);
    }

    /**
     * Generates a seed class name (also used as a filename)
     * @param  string $table
     * @return string
     */
    public function generateClassName($table)
    {
        $tableString = '';
        $tableName = explode('_', $table);
        foreach ($tableName as $tableNameExploded) {
            $tableString .= ucfirst($tableNameExploded);
        }
        return ucfirst($tableString) . 'TableSeeder';
    }

    /**
     * Get the path to the stub file.
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__ . '/Stubs';
    }

    /**
     * Populate the place-holders in the seed stub.
     * @param  string $class
     * @param  string $stub
     * @param  string $table
     * @param  string $data
     * @param  int $chunkSize
     * @return string
     */
    public function populateStub($class, $stub, $table, $data, $chunkSize = null)
    {
        $chunkSize = $chunkSize ?: config('rlustosa::config.chunk_size');
        $inserts = '';
        $chunks = array_chunk($data, $chunkSize);
        foreach ($chunks as $chunk) {
            $inserts .= sprintf("\n\t\t\DB::table('%s')->insert(%s);", $table, $this->prettifyArray($chunk));
        }

        $stub = str_replace('{{class}}', $class, $stub);

        if (!is_null($table)) {
            $stub = str_replace('{{table}}', $table, $stub);
        }

        $stub = str_replace('{{insert_statements}}', $inserts, $stub);

        return $stub;
    }

    /**
     * Create the full path name to the seed file.
     * @param  string $name
     * @param  string $path
     * @return string
     */
    public function getPath($name, $path)
    {
        return $path . '/' . $name . '.php';
    }

    /**
     * Prettify a var_export of an array
     * @param  array $array
     * @return string
     */
    protected function prettifyArray($array)
    {
        $content = var_export($array, true);

        $lines = explode("\n", $content);

        $inString = false;
        $tabCount = 3;
        for ($i = 1; $i < count($lines); $i++) {
            $lines[$i] = ltrim($lines[$i]);

            //Check for closing bracket
            if (strpos($lines[$i], ')') !== false) {
                $tabCount--;
            }

            //Insert tab count
            if ($inString === false) {
                for ($j = 0; $j < $tabCount; $j++) {
                    $lines[$i] = substr_replace($lines[$i], "\t", 0, 0);
                }
            }

            for ($j = 0; $j < strlen($lines[$i]); $j++) {
                //skip character right after an escape \
                if ($lines[$i][$j] == '\\') {
                    $j++;
                } //check string open/end
                else if ($lines[$i][$j] == '\'') {
                    $inString = !$inString;
                }
            }

            //check for openning bracket
            if (strpos($lines[$i], '(') !== false) {
                $tabCount++;
            }
        }

        $content = implode("\n", $lines);

        return $content;
    }

    /**
     * Cleans the iSeed section
     * @return bool
     */
    public function cleanSection()
    {
        $databaseSeederPath = base_path() . config('rlustosa::config.path') . '/DatabaseSeeder.php';

        $content = $this->files->get($databaseSeederPath);

        $content = preg_replace("/(\#rlustosa_start.+?)\#rlustosa_end/us", "#rlustosa_start\n\t\t#rlustosa_end", $content);

        return $this->files->put($databaseSeederPath, $content) !== false;
        return false;
    }

    /**
     * Updates the DatabaseSeeder file's run method (kudoz to: https://github.com/JeffreyWay/Laravel-4-Generators)
     * @param  string $className
     * @return bool
     */
    public function updateDatabaseSeederRunMethod($className)
    {
        $databaseSeederPath = base_path() . config('rlustosa::config.path') . '/DatabaseSeeder.php';

        $content = $this->files->get($databaseSeederPath);
        if (strpos($content, "\$this->call('{$className}')") === false) {
            if (strpos($content, '#rlustosa_start') && strpos($content, '#rlustosa_end') && strpos($content, '#rlustosa_start') < strpos($content, '#rlustosa_end')) {
                $content = preg_replace("/(\#rlustosa_start.+?)\#rlustosa_end/us", "$1\$this->call('{$className}');\n\t\t#rlustosa_end", $content);
            } else {
                $content = preg_replace("/(run\(\).+?)}/us", "$1\t\$this->call('{$className}');\n\t}", $content);
            }
        }

        return $this->files->put($databaseSeederPath, $content) !== false;
    }

}

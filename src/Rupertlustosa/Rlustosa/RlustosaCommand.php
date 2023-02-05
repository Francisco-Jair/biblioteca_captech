<?php namespace Rupertlustosa\Rlustosa;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RlustosaCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'rlustosa:create-crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera estrutura base para os projetos com a pasta Models, Repositories etc';
    private $tabela;
    private $nomeDaClasse;
    private $nomeDoLabel;
    private $database;
    private $nomeBanco;
    private $bloquearVisualizacao;
    private $bloquearExclusao;
    private $bloquearBusca;

    /**
     * Create a new command instance.
     *
     * @return \Rupertlustosa\Rlustosa\RlustosaCommand
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @throws \Exception
     */
    public function fire()
    {
        $pastaControllerGestor = $this->laravel['path.base'] . '/app/Http/Controllers/Gestor';
        $pastaModel = $this->laravel['path.base'] . '/app/Models';
        $pastaRepositorio = $this->laravel['path.base'] . '/app/Repositories';
        $pastaRequest = $this->laravel['path.base'] . '/app/Http/Requests';
        $pastaService = $this->laravel['path.base'] . '/app/Services';
        $pastaViewGestor = $this->laravel['path.base'] . '/resources/views/gestor';
        $arquivoDeRota = $this->laravel['path.base'] . '/app/Http/routes.php';

        $this->output->writeln("");
        $tabela = $this->ask('Qual o nome da tabela que deseja mapear?');
        if (empty($tabela)) {
            $this->error('Abortando...');
            exit;
        }

        $this->database = $this->option('database');
        $this->nomeBanco = \DB::connection($this->database)->getConfig('database');

        if (!app('rlustosa')->inicializarRoutes($arquivoDeRota))
            throw new \Exception("Erro ao inicializarRoutes.");

        if (!app('rlustosa')->hasTable($tabela)) throw new TableNotFoundException("Table $tabela was not found.");

        \DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        $this->tabela = $tabela;

        if ($this->confirm('- Você confirma usar a tabela "' . $tabela . '" com o banco de dados "' . $this->nomeBanco . '""? [yes|no]', true)) {
            $nomePastaDasViews = $tabela;

            if (!isset($nomePastaDasViews) or empty($nomePastaDasViews)) {
                $nomePastaDasViews = $tabela;
            }

            $nomeDaClasse = $this->ask('    > Qual o nome você deseja atribuir para as classes?');
            if (empty($nomeDaClasse)) {
                $this->error('Abortando...');
                exit;
            }

            $nomeDoLabel = $this->ask('    > Como devemos chamar o Label para "' . $tabela . '"?');

            if (empty($nomeDoLabel)) {
                $this->error('Abortando...');
                exit;
            }

            $bloquearVisualizacao = $bloquearExclusao = $bloquearBusca = false;

            /*if ($this->confirm('- Devemos bloquear a visualização? [yes|no]', false)) {
                $bloquearVisualizacao = true;
            }*/

            if ($this->confirm('- Devemos bloquear a busca? [yes|no]', false)) {
                $bloquearBusca = true;
            }

            if ($this->confirm('- Devemos bloquear a exclusão? [yes|no]', false)) {
                $bloquearExclusao = true;
            }

            $nomeDaClasse = studly_case(trim($nomeDaClasse));
            $this->nomeDaClasse = $nomeDaClasse;
            $this->nomeDoLabel = trim($nomeDoLabel);
            $this->bloquearVisualizacao = $bloquearVisualizacao;
            $this->bloquearExclusao = $bloquearExclusao;
            $this->bloquearBusca = $bloquearBusca;

            $bloqueios['bloquearVisualizacao'] = $this->bloquearVisualizacao;
            $bloqueios['bloquearBusca'] = $this->bloquearBusca;
            $bloqueios['bloquearExclusao'] = $this->bloquearExclusao;

            $arquivoModel = $pastaModel . '/' . $nomeDaClasse . '.php';
            $arquivoController = $pastaControllerGestor . '/' . $nomeDaClasse . 'Controller.php';
            $arquivoRepositorio = $pastaRepositorio . '/' . $nomeDaClasse . 'Repository.php';
            $arquivoService = $pastaService . '/' . $nomeDaClasse . 'Service.php';
            $arquivoRequest = $pastaRequest . '/' . $nomeDaClasse . 'Request.php';

            $arquivoIndexView = $pastaViewGestor . '/' . $nomePastaDasViews . '/index.blade.php';
            $arquivoFormView = $pastaViewGestor . '/' . $nomePastaDasViews . '/form.blade.php';
            $arquivoDestroyView = $pastaViewGestor . '/' . $nomePastaDasViews . '/confirm-destroy.blade.php';

            $camposQueNaoAparecemNoFormDeCadastro = ['id', 'created_at', 'updated_at', 'deleted_at'];
            $camposPreFormatadosNoFormDeListagem = ['id', 'created_at', 'updated_at'];
            $camposQueNaoAparecemNoFormDeListagem = ['deleted_at'];

            $columns = \DB::connection($this->database)
                ->getDoctrineSchemaManager()
                ->listTableColumns($tabela);

            $camposDaViewDeCadastro = array();
            $camposDaViewDeListagem = array();

            foreach ($columns as $column) {
                $nomeCampo = $column->getName();
                $tipoDoCampo = $column->getType()->getName();
                $tamanhoDoCampo = $column->getLength();

                if ($nomeCampo != 'deleted_at')

                    if (in_array($nomeCampo, $camposPreFormatadosNoFormDeListagem)) {
                        if ($nomeCampo == 'created_at')
                            $camposDaViewDeListagem[] = ['nomeCampo' => $nomeCampo, 'label' => 'Data de criação'];
                        else if ($nomeCampo == 'updated_at')
                            $camposDaViewDeListagem[] = ['nomeCampo' => $nomeCampo, 'label' => 'Data de atualização'];
                        else if ($nomeCampo == 'id')
                            $camposDaViewDeListagem[] = ['nomeCampo' => $nomeCampo, 'label' => '#ID'];
                    } else if ($this->confirm('- O campo "' . $nomeCampo . '" do tipo "' . $tipoDoCampo . '" vai aparecer na view de listagem ou na de cadastro? [yes|no]', true)) {

                        $label = $this->ask('    > Qual label você deseja usar para esse campo?');

                        if (!in_array($nomeCampo, $camposQueNaoAparecemNoFormDeCadastro)) {
                            if ($this->confirm('- O label "' . $label . '" <' . $nomeCampo . '> vai aparecer na view de cadastro? [yes|no]', true)) {
                                $camposDaViewDeCadastro[] = ['nomeCampo' => $nomeCampo, 'label' => $label, 'tipoDoCampo' => $tipoDoCampo];
                            }
                        }

                        if (!in_array($nomeCampo, $camposQueNaoAparecemNoFormDeListagem) and $tamanhoDoCampo <= 255) {
                            if ($this->confirm('- O label "' . $label . '" <' . $nomeCampo . '> vai aparecer na view de listagem? [yes|no]', true)) {
                                $camposDaViewDeListagem[] = ['nomeCampo' => $nomeCampo, 'label' => $label];
                            }
                        }
                    }

                #print $column->getName();
                #print $column->getType()->getName();
                #print $column->getDefault();
                #print $column->getLength();
            }


            $this->output->writeln('<info>  Tabela: ' . $tabela . '</info>');
            $this->output->writeln('<info>  Pasta das Views: ' . $pastaViewGestor . '/' . $nomePastaDasViews . '</info>');
            $this->output->writeln('<info>  Model ' . $arquivoModel . '</info>');
            $this->output->writeln('<info>  Controller: ' . $arquivoController . '</info>');
            $this->output->writeln('<info>  Repositório: ' . $arquivoRepositorio . '</info>');
            $this->output->writeln('<info>  Service: ' . $arquivoService . '</info>');
            $this->output->writeln('<info>  Request: ' . $arquivoRequest . '</info>');
            $this->output->writeln('<info>  Label das Seções: ' . $nomeDoLabel . '</info>');

            $this->output->writeln('<info>  CAMPOS DA VIEW DE CADASTRO</info>');
            foreach ($camposDaViewDeCadastro as $campo) {
                $this->output->writeln('<comment>    Label: ' . $campo['label'] . ' <' . $campo['nomeCampo'] . '></comment>');
            }

            $this->output->writeln('<info>  CAMPOS DA VIEW DE LISTAGEM</info>');
            foreach ($camposDaViewDeListagem as $campo) {
                $this->output->writeln('<comment>    Label: ' . $campo['label'] . ' <' . $campo['nomeCampo'] . '></comment>');
            }

            // se o model não existe eu o crio
            if (!\File::exists($arquivoModel)) {
                $this->printResult(app('rlustosa')->gerarModel($arquivoModel, $nomeDaClasse, $tabela), $arquivoModel);
            } else if ($this->confirm('O Arquivo ' . $arquivoModel . ' Já existe, posso sobrescrevê-lo? [yes|no]')) {
                $this->printResult(app('rlustosa')->gerarModel($arquivoModel, $nomeDaClasse, $tabela), $arquivoModel);
            }


            // se o controller não existe eu o crio
            if (!\File::exists($arquivoController)) {
                $this->printResult(app('rlustosa')->gerarController($arquivoController, $nomeDaClasse, $tabela), $arquivoController);
            } else if ($this->confirm('O Arquivo ' . $arquivoController . ' Já existe, posso sobrescrevê-lo? [yes|no]')) {
                $this->printResult(app('rlustosa')->gerarController($arquivoController, $nomeDaClasse, $tabela), $arquivoController);
            }

            // se o repositorio não existe eu o crio
            if (!\File::exists($arquivoRepositorio)) {
                $this->printResult(app('rlustosa')->gerarRepositorio($arquivoRepositorio, $nomeDaClasse, $tabela), $arquivoRepositorio);
            } else if ($this->confirm('O Arquivo ' . $arquivoRepositorio . ' Já existe, posso sobrescrevê-lo? [yes|no]')) {
                $this->printResult(app('rlustosa')->gerarRepositorio($arquivoRepositorio, $nomeDaClasse, $tabela), $arquivoRepositorio);
            }

            // se o service não existe eu o crio
            if (!\File::exists($arquivoService)) {
                $this->printResult(app('rlustosa')->gerarService($arquivoService, $nomeDaClasse, $tabela), $arquivoService);
            } else if ($this->confirm('O Arquivo ' . $arquivoService . ' Já existe, posso sobrescrevê-lo? [yes|no]')) {
                $this->printResult(app('rlustosa')->gerarService($arquivoService, $nomeDaClasse, $tabela), $arquivoService);
            }

            // se o Request não existe eu o crio
            if (!\File::exists($arquivoRequest)) {
                $this->printResult(app('rlustosa')->gerarRequest($arquivoRequest, $nomeDaClasse, $tabela, $this->nomeBanco), $arquivoRequest);
            } else if ($this->confirm('O Arquivo ' . $arquivoRequest . ' Já existe, posso sobrescrevê-lo? [yes|no]')) {
                $this->printResult(app('rlustosa')->gerarRequest($arquivoRequest, $nomeDaClasse, $tabela, $this->nomeBanco), $arquivoRequest);
            }

            $pastaDaViewDessaTabela = $pastaViewGestor . '/' . $nomePastaDasViews;
            if (!\File::isDirectory($pastaDaViewDessaTabela)) {
                $this->output->writeln('<error>Não existe a pasta ' . $pastaDaViewDessaTabela . ', ela será criada agora</error>');
                if (!\File::makeDirectory($pastaDaViewDessaTabela, 0755, true, true)) {
                    $this->output->writeln('<error>Não foi possível criar a pasta ' . $pastaDaViewDessaTabela . '</error>');
                } else {
                    $this->output->writeln('<comment>        Pasta ' . $pastaDaViewDessaTabela . ' criada com sucesso!</comment>');
                }
            }

            // se o index não existe eu o crio
            if (!\File::exists($arquivoIndexView)) {
                $this->printResult(app('rlustosa')->gerarIndexView($arquivoIndexView, $tabela, $camposDaViewDeListagem, $nomeDoLabel, $bloqueios), $arquivoIndexView);
            } else if ($this->confirm('O Arquivo ' . $arquivoIndexView . ' Já existe, posso sobrescrevê-lo? [yes|no]')) {
                $this->printResult(app('rlustosa')->gerarIndexView($arquivoIndexView, $tabela, $camposDaViewDeListagem, $nomeDoLabel, $bloqueios), $arquivoIndexView);
            }


            // se o form não existe eu o crio
            if (!\File::exists($arquivoFormView)) {
                $this->printResult(app('rlustosa')->gerarIndexForm($arquivoFormView, $tabela, $camposDaViewDeCadastro, $nomeDoLabel, $nomeDaClasse, $bloqueios), $arquivoFormView);
            } else if ($this->confirm('O Arquivo ' . $arquivoFormView . ' Já existe, posso sobrescrevê-lo? [yes|no]')) {
                $this->printResult(app('rlustosa')->gerarIndexForm($arquivoFormView, $tabela, $camposDaViewDeCadastro, $nomeDoLabel, $nomeDaClasse, $bloqueios), $arquivoFormView);
            }

            // se o confirm-destroy não existe eu o crio
            if (!\File::exists($arquivoDestroyView)) {
                $this->printResult(app('rlustosa')->gerarDestroy($arquivoDestroyView, $tabela, $camposDaViewDeCadastro, $nomeDoLabel), $arquivoDestroyView);
            } else if ($this->confirm('O Arquivo ' . $arquivoDestroyView . ' Já existe, posso sobrescrevê-lo? [yes|no]')) {
                $this->printResult(app('rlustosa')->gerarDestroy($arquivoDestroyView, $tabela, $camposDaViewDeCadastro, $nomeDoLabel), $arquivoDestroyView);
            }

            if (!app('rlustosa')->atualizarRoutes($arquivoDeRota, $tabela, $nomeDaClasse))
                $this->error("Erro ao atualizar " . $arquivoDeRota);
            else $this->info($arquivoDeRota . "  atualizado com sucesso!");

        }

        exit;
        // if clean option is checked empty iSeed template in DatabaseSeeder.php
        if ($this->option('clean')) {
            app('rlustosa')->cleanSection();
        }

        $tables = explode(",", $this->argument('tables'));
        $chunkSize = intval($this->option('max'));

        if ($chunkSize < 1) {
            $chunkSize = null;
        }

        foreach ($tables as $table) {
            $table = trim($table);

            // generate file and class name based on name of the table
            list($fileName, $className) = $this->generateFileName($table);

            // if file does not exist or force option is turned on generate seeder
            if (!\File::exists($fileName) || $this->option('force')) {
                $this->printResult(app('rlustosa')->generateSeed($table, $this->option('database'), $chunkSize), $table);
                continue;
            }

            if ($this->confirm('File ' . $className . ' already exist. Do you wish to override it? [yes|no]')) {
                // if user said yes overwrite old seeder
                $this->printResult(app('rlustosa')->generateSeed($table, $this->option('database'), $chunkSize), $table);
            }
        }

        return;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(//array('tables', InputArgument::REQUIRED, 'comma separated string of table names'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('clean', null, InputOption::VALUE_NONE, 'clean rlustosa section', null),
            array('force', null, InputOption::VALUE_NONE, 'force overwrite of all existing seed classes', null),
            array('database', null, InputOption::VALUE_OPTIONAL, 'database connection', \Config::get('database.default')),
            array('max', null, InputOption::VALUE_OPTIONAL, 'max number of rows', null),
        );
    }

    /**
     * Provide user feedback, based on success or not.
     *
     * @param  boolean $successful
     * @param  string $table
     * @return void
     */
    protected function printResult($successful, $file)
    {
        if ($successful) {
            $this->info("  Arquivo {$file} criado com sucesso!");
            return;
        }

        $this->error("  Não foi possível criar o arquivo {$file}");
    }

    /**
     * Generate file name, to be used in test wether seed file already exist
     *
     * @param  string $table
     * @return string
     */
    protected function generateFileName($table)
    {
        if (!\Schema::hasTable($table)) {
            throw new TableNotFoundException("  Tabela '$table' não foi encontrada.");
        }

        // Generate class name and file name
        $className = app('rlustosa')->generateClassName($table);
        $seedPath = base_path() . config('rlustosa::config.path');
        return [$seedPath . '/' . $className . '.php', $className . '.php'];

    }

    public function getAllColumnsNames()
    {
        switch (\DB::connection()->getConfig('driver')) {
            case 'pgsql':
                $query = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $this->tabela . "'";
                $column_name = 'column_name';
                $reverse = true;
                break;

            case 'mysql':
                //$query = 'SHOW COLUMNS FROM ' . $this->tabela;
                $query = "SELECT * FROM information_schema.columns WHERE table_name = '" . $this->tabela . "' and TABLE_SCHEMA = " . DB::connection()->getConfig('database') . "";
                /*$column_name = 'Field';
				$column_type = 'Type';
				$column_null = 'Null';
				$column_key = 'Key';
				$column_default = 'Default';
				$column_extra = 'Extra';*/
                $column_name = 'COLUMN_NAME';
                $column_type = 'DATA_TYPE';
                $column_null = 'IS_NULLABLE';
                $column_length = 'CHARACTER_MAXIMUN_LENGHT';
                $column_key = 'Key';
                $column_default = 'Default';
                $column_extra = 'Extra';
                $reverse = false;
                break;

            case 'sqlsrv':
                $parts = explode('.', $this->tabela);
                $num = (count($parts) - 1);
                $table = $parts[$num];
                $query = "SELECT column_name FROM " . DB::connection()->getConfig('database') . ".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'" . $table . "'";
                $column_name = 'column_name';
                $reverse = false;
                break;

            default:
                $error = 'Database driver not supported: ' . DB::connection()->getConfig('driver');
                throw new Exception($error);
                break;
        }

        $columns = array();

        foreach (\DB::select($query) as $column) {
            $columns[] = ['name' => $column->$column_name,
                'type' => $column->$column_type,
                'null' => $column->$column_null,
                'key' => $column->$column_key,
                'default' => $column->$column_default,
                'extra' => $column->$column_extra];
            //$columns[] = $column->$column_name;
        }

        if ($reverse) {
            $columns = array_reverse($columns);
        }
        return $columns;
    }
}

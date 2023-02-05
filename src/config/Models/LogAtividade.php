<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 04-11-2015
 * Time: 02:02:16
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogAtividade extends Model {
    use SoftDeletes;

    /**
     * Tabela usada pelo Model.
     *
     * @var string
     */
    protected $table = 'log_atividades';

    /**
     * Os atributos que são permitidos na inserção em massa.
     *
     * @var array
     */
    protected $fillable = ['id', 'gestor_id', 'function', 'url', 'request', 'method'];

    /**
     * Os atributos excluídos da inserção em massa.
     *
     * @var array
     */
    protected $hidden = [];

    # Relações desse model
    /**
	 * Relação: Belongs To
	 *
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function gestor()
	{
		return $this->belongsTo('App\Models\Gestor');
	}
}
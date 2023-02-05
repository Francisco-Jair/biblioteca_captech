<?php
/**
 * Gerado por Rlustosa
 * Rupert Brasil Lustosa rupertlustosa@gmail.com
 * Date: 04-11-2015
 * Time: 02:02:16
 */

namespace App\Models;

use App\Presenters\DatePresenter;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Gestor extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
    use DatePresenter;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gestores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nome', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    # Relações desse model
    /**
     * Relação: One to Many
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function atividades()
    {
        return $this->hasMany('App\Models\LogAtividade');
    }

    public function logins()
    {
        return $this->hasMany('App\Models\LogAtividade');
    }
}

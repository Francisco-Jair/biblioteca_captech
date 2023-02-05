<?php
/**
 * Created by PhpStorm.
 * User: rupertlustosa
 * Date: 01/11/15
 * Time: 01:54
 */

namespace App;


class ImagemUpload
{
    private $caminho;
    private $campo;
    private $antigaImagem;

    /**
     * @param mixed $caminho
     * @return ImagemUpload
     */
    public function caminho($caminho)
    {
        $this->caminho = $caminho;
        return $this;
    }

    /**
     * @param mixed $campo
     * @return ImagemUpload
     */
    public function campo($campo)
    {
        $this->campo = $campo;
        return $this;
    }

    /**
     * @param mixed $antigaImagem
     * @return ImagemUpload
     */
    public function antigaImagem($antigaImagem)
    {
        $this->antigaImagem = $antigaImagem;
        return $this;
    }

    public function build()
    {
        if(is_null($this->caminho))
            throw new \Exception('CaminhoNaoSetado');
        if(is_null($this->campo))
            throw new \Exception('CampoNaoSetado');
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCaminho()
    {
        return $this->caminho;
    }

    /**
     * @return mixed
     */
    public function getCampo()
    {
        return $this->campo;
    }

    /**
     * @return mixed
     */
    public function getAntigaImagem()
    {
        return $this->antigaImagem;
    }

}
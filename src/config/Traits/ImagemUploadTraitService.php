<?php
/**
 * Created by PhpStorm.
 * User: rupertlustosa
 * Date: 01/11/15
 * Time: 12:34
 */

namespace App\Traits;

use App\ImagemUpload;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImagemUploadTraitService
{
    public function enviaImagem(ImagemUpload $imagemUpload)
    {
        $pasta = config('configuracoes.upload.' . $imagemUpload->getCaminho() . '.caminho');
        $pastaOriginal = config('configuracoes.upload.' . $imagemUpload->getCaminho() . '.caminhoOriginal');
        $file = (File::get($imagemUpload->getCampo()) ? File::get($imagemUpload->getCampo()) : null);
        $caminho_imagem1_original = $pastaOriginal . $imagemUpload->getAntigaImagem();
        $caminho_imagem1 = $pasta . $imagemUpload->getAntigaImagem();

        if (!is_null($imagemUpload->getAntigaImagem()) and Storage::exists($caminho_imagem1_original))
            Storage::delete($caminho_imagem1_original);

        if (!is_null($imagemUpload->getAntigaImagem()) and Storage::exists($caminho_imagem1))
            Storage::delete($caminho_imagem1);
        //fb 12196358_909543672434547_5294086987255612381_n
        $nome_imagem1 = Carbon::now('America/Fortaleza')->format('YmdHis') . '_' .
            str_random(14) . '_' .
            rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999) . '_' .
            str_random(14) . '.' .
            $imagemUpload->getCampo()->guessClientExtension();
        //dd($nome_imagem1);
        try {
            Storage::put(
                $pastaOriginal . $nome_imagem1,
                File::get($imagemUpload->getCampo()->getRealPath())
            );

            Storage::put(
                $pasta . $nome_imagem1,
                File::get($imagemUpload->getCampo()->getRealPath())
            );
        } catch (\Exception $e) {
            $nome_imagem1 = null;
        } finally {
            return $nome_imagem1;
        }


    }

    public function updateImageCrop($request, $caminho)
    {
        $pasta = config('configuracoes.upload.' . $caminho . '.caminho');
        $pastaOriginal = config('configuracoes.upload.' . $caminho . '.caminhoOriginal');
        $nome_imagem = $request['imagem'];
        $caminho_imagem_original = $pastaOriginal . $nome_imagem;
        $caminho_imagem = $pasta . $nome_imagem;

        if (Storage::exists($caminho_imagem_original)) {
            // open file a image resource
            $file = Storage::get($caminho_imagem_original);
            $img = Image::make($file);


            $proporcao = $img->width() / config('configuracoes.upload.' . $caminho . '.tamanhoExibicaoDoCrop');

            // crop image
            $dataWidth = round($request->dataWidth * $proporcao);
            $dataHeight = round($request->dataHeight * $proporcao);
            $dataX = round($request->dataX * $proporcao);
            $dataY = round($request->dataY * $proporcao);

            $img->crop($dataWidth, $dataHeight, $dataX, $dataY);

            // prevent possible upsizing
            $img->resize(config('configuracoes.upload.' . $caminho . '.widthSite'), config('configuracoes.upload.' . $caminho . '.heightSite'), function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });


            $payload = (string)$img->encode();  // encode it as string
            Storage::put(
                $caminho_imagem,
                $payload
            );
            return true;
        }
        return false;
    }
}
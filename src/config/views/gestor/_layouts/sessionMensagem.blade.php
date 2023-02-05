@if(Session::has('mensagem'))
    <div class="row">
        <div class="col-md-12">

            <div class="alert alert-{{ Session::get('tipo_mensagem') }} alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">×</span><span class="sr-only">Fechar</span>
                </button>
                <strong>{{ Session::get('mensagem') }}</strong>
            </div>

        </div>
    </div>
@endif
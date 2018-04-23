@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="full-right">
                    <h2>CRUD Ajax Laravel</h2>
                </div>
            </div>
        </div>

        <table id="mytable" class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Titolo</th>
                <th scope="col">Body</th>
                <th scope="col">Handle</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)

            <tr id="{{$post->id}}">
                <td id="id" class="id">{{$post->id}}</td>
                <td id="title">{{$post->title}}</td>
                <td id="body" class="body">{{$post->body}}</td>
                <td id="handle" class="handle">
                        {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <a href="#"  class="edit">edit</a><br />
                    <a href="#"  class="delete">delete</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <!-- THIS FORM SHOULD BE HIDDEN-->
        <div class="form-horizontal" id="my-form">
            <div class="form-body">
                <input type="hidden"  id="record_id">
                <div class="form-group">
                    <label class="col-md-3 control-label">Titolo</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="titolo">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Body</label>
                    <div class="col-md-4">
                        <form type="input">
                            <textarea type="text" name="contenuto" rows="5" cols="60" id="contenuto"></textarea>
                        </form>

                    </div>
                </div>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green btn-save" value="">Save</button>
                        <button type="button" class="btn default btn-cancel">Cancel</button>
                        <input type="hidden" id="record_id" value="" />
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- action Ajax Script -->

        <!-- Library Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

        <script>
        $('document').ready(function(){
            $('#my-form').hide();

            // Inizio DELETE
            $('.delete').click(function(e){
                e.preventDefault();
                var td = $(this).parent('td');  // risalgo all'elemento td (cella) contenente la classe delete
                var tr = td.parents('tr');  //risalgo all'elemento tr (riga) contenente il td (la cella) con la classe delete
                var id = tr.attr('id');     // ottengo l'id della riga interessata
                var token = $('input[name=_token]').val();
                 /* configurazione AJAX */
                $.ajax({
                    type: 'POST',
                    url: '/posts/'+id,
                    data:{
                        'id':        id,
                        '_method': 'delete',
                        '_token':    token
                    },
                    success:function () {
                        console.log('cancellato');
                        tr.remove();
                    },
                    error: function () {
                        console.log('errore, elemento non cancellato');
                    }
                });
                /*fine AJAX*/
            });

            // Inizio SHOW single dato
            $('.edit').click(function(e){
               e.preventDefault(e);

                // recupero i dati //
                var td = $(this).parent('td');  // risalgo all'elemento td (cella) contenente la classe delete
                var tr = td.parents('tr');  //risalgo all'elemento tr (riga) contenente il td (la cella) con la classe delete
                var id = tr.attr('id');     // ottengo l'id della riga interessata
                var token = $('input[name=_token]').val();

                // mostro il form e nascondo la tabella
                $('#my-form').show();
                $('#mytable').hide();

                // imposto la chiamata AJAX Get ai dati selezionati
                $.ajax({
                    type: 'GET',
                    url: '/posts/' + id + '/edit',
                    data: {
                        'id': id,
                        '_method': 'get',
                        '_token': token
                    },
                    success:function(response) {
                        console.log(response);
                       $('#record_id').attr('value',response.id);
                        $('#contenuto').val(response.body);
                        $('#titolo').val(response.title);
                    }
                });
                /* configurazione AJAX */

            });
            // fine SHOW

            // Inizio UPDATE single dato
            $('.btn-save').click(function(e){
                e.preventDefault();

                // raccolgo i dati che mi servono per aggiornare la tabella
                var title = $('#titolo').val();
                var body = $('#contenuto').val();
                var id = $('#record_id').val();
                var token = $('input[name=_token]').val();

                $.ajax({
                    type: 'PUT',
                    url: '/posts/'+id,
                    data: {
                        'id': id,
                        '_token': token,
                        'title': title,
                        'body': body,
                        '_method': 'put'
                    },
                    success:function(response) {
                        console.log(response);
                        $('tr')[id].getElementsByTagName('td')[1].innerHTML = response.title;
                        $('tr')[id].getElementsByTagName('td')[2].innerHTML = response.body;
                        $('#my-form').hide();
                        $('#mytable').show();
                    }
                });

            });
            // fine UPDATE singolo dato

            // Annulla azione tasto Cancel del form
            $('.btn-cancel').click(function(e){
                e.preventDefault();
                $('#my-form').hide();
                $('#mytable').show();
            });
        });
    </script>

    @endsection
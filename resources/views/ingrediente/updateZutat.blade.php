@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/updated/ingrediente/{{ $zutat['id'] }}" enctype="multipart/form-data" method="post">
        @csrf


        <div class="row">
            <div class="col-8 offset-2">

                <div class="row">
                    <h1>Zutat {{ $zutat['name'] }} aktualisieren: </h1>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label">Neuer Name:</label>

                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                        name="name"  value="{{ old('name') ?? $zutat['name'] }}">

                    @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                <!-- <div class="form-group row">
                    <label for="amount" class="col-md-4 col-form-label">amount</label>

                    <input id="amount" type="number" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}"
                        name="amount" autocomplete="amount" required>

                    @if ($errors->has('amount'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('amount') }}</strong>
                    </span>
                    @endif
                </div>
                -->
                <div class="form-group row">
                    <label for="price" class="col-md-4 col-form-label">Neuer Preis:</label>

                    <input id="price" type="number"  step="0.01" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                        name="price" autocomplete="price" value="{{ old('price') ?? $zutat['price'] }}">

                    @if ($errors->has('price'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('price') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label">Neuer Typ:</label>
                    <select name="type" value="{{ old('type') ?? $zutat['type'] }}">
                        <option value="fruits">fruits</option>
                        <option value="vegetables">vegetables</option>
                        <option value="liquid">liquid</option>
                    </select>

                </div>

                <div class="row">
                    <label for="image" class="col-md-4 col-form-label">Neues SVG der Zutat:</label>

                    <input type="file" class="form-control-file" id="image" name="image"  value="{{ old('image') ?? $zutat -> image }}">

                    @if ($errors->has('image'))
                    <strong>{{ $errors->first('image') }}</strong>
                    @endif
                </div>

                <div class="row pt-4">
                    <button class="btn btn-primary">Zutat aktualisieren</button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
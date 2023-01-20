
<x-app-layout>
<div class="container">
    <form action="/create/ingrediente" enctype="multipart/form-data" method="post">
        @csrf


            <div class="col-8 offset-2">

                <div class="row">
                    <h1>Neue Zutat hinzufügen:</h1>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label">Name:</label>

                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                        name="name" required>

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
                    <label for="price" class="col-md-4 col-form-label">Einzelpreis:</label>

                    <input id="price" type="number"  step="0.01" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                        name="price" autocomplete="price" required>

                    @if ($errors->has('price'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('price') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group row">
                    <label for="type" class="col-md-4 col-form-label">Typ:</label>
                    <select name="type" required>
                        <option value="fruits">fruits</option>
                        <option value="vegetables">vegetables</option>
                        <option value="liquid">liquid</option>
                    </select>

                </div>

                <div class="row">
                    <label for="image" class="col-md-4 col-form-label">SVG der Zutat:</label>

                    <input type="file" class="form-control-file" id="image" name="image" required>

                    @if ($errors->has('image'))
                    <strong>{{ $errors->first('image') }}</strong>
                    @endif
                </div>

                <div class="row pt-4">
                    <button class="btn btn-primary">Neue Zutat hinzufügen</button>
                </div>

            </div>
        </div>
    </form>
</div>
</div>
</x-app-layout>
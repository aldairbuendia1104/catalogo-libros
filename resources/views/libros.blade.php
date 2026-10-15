<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros | Catálogo</title>

    <style>
        body {
            margin: 0;
            padding: 35px 20px;
            background: #f8f1e8;
            color: #382b25;
            font-family: Arial, sans-serif;
        }

        main {
            max-width: 1000px;
            margin: auto;
        }

        h1, h2 {
            color: #9a4f32;
        }

        a {
            color: #85452e;
        }

        section {
            margin-top: 22px;
            padding: 24px;
            background: white;
            border-radius: 12px;
        }

        label {
            display: block;
            margin-top: 13px;
        }

        input, textarea, button {
            box-sizing: border-box;
            width: 100%;
            margin-top: 6px;
            padding: 11px;
            border: 1px solid #d8c9bb;
            border-radius: 7px;
            font: inherit;
        }

        textarea {
            min-height: 80px;
        }

        button {
            margin-top: 16px;
            background: #9a4f32;
            color: white;
            border: 0;
            cursor: pointer;
        }

        .secundario {
            background: #77675d;
        }

        .eliminar {
            background: #a43b32;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        th, td {
            padding: 11px;
            border-bottom: 1px solid #eadfd5;
            text-align: left;
            vertical-align: top;
        }

        .mensaje {
            padding: 12px;
            background: #e5f4e5;
            border-radius: 7px;
        }

        .error {
            color: #a32626;
        }

        .acciones {
            display: flex;
            gap: 8px;
        }

        .acciones form {
            flex: 1;
        }

        .acciones a {
            display: inline-block;
            padding: 10px;
        }

        @media (max-width: 650px) {
            table {
                font-size: 14px;
            }

            th, td {
                padding: 8px 5px;
            }

            .acciones {
                display: block;
            }
        }
    </style>
</head>
<body>
    <main>
        <a href="{{ route('inicio') }}">← Inicio</a>
        <h1>Catálogo de libros</h1>
        <p>Agrega, consulta, edita o elimina libros.</p>

        @if (session('mensaje'))
            <p class="mensaje">{{ session('mensaje') }}</p>
        @endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <section>
            <h2>{{ $libroEditar ? 'Editar libro' : 'Agregar libro' }}</h2>

            <form
                action="{{ $libroEditar
                    ? route('libros.update', $libroEditar)
                    : route('libros.store') }}"
                method="POST"
            >
                @csrf

                @if ($libroEditar)
                    @method('PUT')
                @endif

                <label for="titulo">Título</label>
                <input
                    id="titulo"
                    name="titulo"
                    value="{{ old('titulo', $libroEditar->titulo ?? '') }}"
                    required
                >

                <label for="autor">Autor</label>
                <input
                    id="autor"
                    name="autor"
                    value="{{ old('autor', $libroEditar->autor ?? '') }}"
                    required
                >

                <label for="genero">Género</label>
                <input
                    id="genero"
                    name="genero"
                    value="{{ old('genero', $libroEditar->genero ?? '') }}"
                >

                <label for="anio">Año</label>
                <input
                    id="anio"
                    name="anio"
                    type="number"
                    min="1000"
                    max="2100"
                    value="{{ old('anio', $libroEditar->anio ?? '') }}"
                >

                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion">{{ old('descripcion', $libroEditar->descripcion ?? '') }}</textarea>

                <button type="submit">
                    {{ $libroEditar ? 'Guardar cambios' : 'Agregar libro' }}
                </button>

                @if ($libroEditar)
                    <a href="{{ route('libros.index') }}">
                        <button class="secundario" type="button">Cancelar edición</button>
                    </a>
                @endif
            </form>
        </section>

        <section>
            <h2>Libros registrados</h2>

            <table>
                <thead>
                    <tr>
                        <th>Libro</th>
                        <th>Género</th>
                        <th>Año</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($libros as $libro)
                        <tr>
                            <td>
                                <strong>{{ $libro->titulo }}</strong><br>
                                Autor: {{ $libro->autor }}
                                @if ($libro->descripcion)
                                    <br>{{ $libro->descripcion }}
                                @endif
                            </td>
                            <td>{{ $libro->genero ?: '—' }}</td>
                            <td>{{ $libro->anio ?: '—' }}</td>
                            <td>
                                <div class="acciones">
                                    <a href="{{ route('libros.index', ['editar' => $libro->id]) }}">
                                        Editar
                                    </a>

                                    <form
                                        action="{{ route('libros.destroy', $libro) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar este libro?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button class="eliminar" type="submit">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Todavía no hay libros registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
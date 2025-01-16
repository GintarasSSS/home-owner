<div>
    <form action="{{ route('upload-csv') }}" method="POST" enctype="multipart/form-data" class="mb3 p-3 border border-secondary rounded">
        @csrf

        <div class="mb-3">
            <label for="formFileMultiple" class="form-label">Select CSV file</label>
            <input name="file" class="form-control" type="file" required />
        </div>

        <button class="btn btn-outline-secondary w-100" type="submit">Upload File</button>

        @if($errors->any() || session('success'))
            <div class="mt-3">
                @if (session('success'))
                    <div class="alert alert-success mb-0" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mb-0" role="alert">
                        <ul class="list-unstyled mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @endif
    </form>
</div>

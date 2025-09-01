@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Data Rumah Sakit</h3>

        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Rumah Sakit
        </button>

        <hr>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Telp</th>
                <th>Aksi</th>
            </tr>
            @foreach ($hospitals as $h)
                <tr id="row-{{ $h->id }}">
                    <td>{{ $h->id }}</td>
                    <td>{{ $h->name }}</td>
                    <td>{{ $h->address }}</td>
                    <td>{{ $h->email }}</td>
                    <td>{{ $h->telp }}</td>
                    <td>
                        <button class="btn btn-primary btn-edit" data-id="{{ $h->id }}" data-name="{{ $h->name }}"
                            data-address="{{ $h->address }}" data-email="{{ $h->email }}"
                            data-telp="{{ $h->telp }}">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-delete" data-id="{{ $h->id }}">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('hospitals.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Rumah Sakit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <input name="name" value="{{ old('name') }}" placeholder="Nama"
                            class="form-control mb-2 @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input name="address" value="{{ old('address') }}" placeholder="Alamat"
                            class="form-control mb-2 @error('address') is-invalid @enderror">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input name="email" value="{{ old('email') }}" placeholder="Email"
                            class="form-control mb-2 @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input name="telp" value="{{ old('telp') }}" placeholder="Telepon"
                            class="form-control mb-2 @error('telp') is-invalid @enderror">
                        @error('telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEdit">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Rumah Sakit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <input id="edit_name" name="name" class="form-control mb-2 @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <input id="edit_address" name="address"
                            class="form-control mb-2 @error('address') is-invalid @enderror">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <input id="edit_email" name="email"
                            class="form-control mb-2 @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <input id="edit_telp" name="telp" class="form-control mb-2 @error('telp') is-invalid @enderror">
                        @error('telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modalTambah = new bootstrap.Modal(document.getElementById('modalTambah'));
                modalTambah.show();
            });
        </script>
    @endif

    <script>
        $(document).on('click', '.btn-delete', function() {
            if (confirm("Hapus data?")) {
                let id = $(this).data('id');
                $.ajax({
                    url: '/hospitals/' + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: () => $("#row-" + id).remove()
                });
            }
        });

        $(document).on('click', '.btn-edit', function() {
            $("#edit_id").val($(this).data('id'));
            $("#edit_name").val($(this).data('name'));
            $("#edit_address").val($(this).data('address'));
            $("#edit_email").val($(this).data('email'));
            $("#edit_telp").val($(this).data('telp'));
            $("#modalEdit").modal('show');
        });

        $("#formEdit").submit(function(e) {
            e.preventDefault();
            let id = $("#edit_id").val();

            $.ajax({
                url: '/hospitals/' + id,
                type: 'POST',
                data: $(this).serialize() + "&_method=PUT",
                success: () => location.reload(),
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let msg = "<ul>";
                        $.each(errors, function(field, messages) {
                            $.each(messages, function(_, message) {
                                msg += "<li>" + message + "</li>";
                            });
                        });
                        msg += "</ul>";

                        $("#modalEdit .modal-body").prepend(
                            '<div class="alert alert-danger">' + msg + '</div>'
                        );
                    }
                }
            });
        });
    </script>
@endsection

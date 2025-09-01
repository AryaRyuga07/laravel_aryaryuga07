@extends('layout.app')
@section('content')
    <div class="container">
        <h3>Data Pasien</h3>

        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Tambah Pasien
        </button>

        <hr>

        <table class="table" id="patientsTable">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telp</th>
                <th>Rumah Sakit</th>
                <th>Aksi</th>
            </tr>
            @foreach ($patients as $p)
                <tr id="row-{{ $p->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->address }}</td>
                    <td>{{ $p->telp }}</td>
                    <td>{{ $p->hospital->name }}</td>
                    <td>
                        <button class="btn btn-primary btn-edit" data-id="{{ $p->id }}" data-nama="{{ $p->name }}"
                            data-alamat="{{ $p->address }}" data-telepon="{{ $p->telp }}"
                            data-hospital="{{ $p->hospital_id }}">Edit</button>
                        <button class="btn btn-danger btn-delete" data-id="{{ $p->id }}">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('patients.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pasien</h5>
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
                        <input name="nama" value="{{ old('name') }}" placeholder="Nama"
                            class="form-control mb-2 @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input name="alamat" value="{{ old('address') }}" placeholder="Alamat"
                            class="form-control mb-2 @error('address') is-invalid @enderror">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input name="telepon" value="{{ old('telp') }}" placeholder="Telepon"
                            class="form-control mb-2 @error('telp') is-invalid @enderror">
                        @error('telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <select name="hospital_id" class="form-control mb-2  @error('hospital_id') is-invalid @enderror">
                            @foreach ($hospitals as $h)
                                <option value="{{ $h->id }}">{{ $h->name }}</option>
                            @endforeach
                        </select>
                        @error('hospital_id')
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

    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEdit">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pasien</h5>
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
                        <input id="edit_nama" name="nama" class="form-control mb-2 @error('name') is-invalid @enderror">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input id="edit_alamat" name="alamat"
                            class="form-control mb-2 @error('address') is-invalid @enderror">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <input id="edit_telepon" name="telepon"
                            class="form-control mb-2 @error('telp') is-invalid @enderror">
                        @error('telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <select id="edit_hospital" name="hospital_id"
                            class="form-control mb-2 @error('hospital_id') is-invalid @enderror">
                            @foreach ($hospitals as $h)
                                <option value="{{ $h->id }}">{{ $h->name }}</option>
                            @endforeach
                        </select>
                        @error('hospital_id')
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
                    url: '/patients/' + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: () => {
                        $("#row-" + id).remove();
                    }
                });
            }
        });

        $(document).on('click', '.btn-edit', function() {
            $("#edit_id").val($(this).data('id'));
            $("#edit_nama").val($(this).data('nama'));
            $("#edit_alamat").val($(this).data('alamat'));
            $("#edit_telepon").val($(this).data('telepon'));
            $("#edit_hospital").val($(this).data('hospital'));
            const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
            modalEdit.show();
        });

        $("#formEdit").submit(function(e) {
            e.preventDefault();
            let id = $("#edit_id").val();

            $.ajax({
                url: '/patients/' + id,
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

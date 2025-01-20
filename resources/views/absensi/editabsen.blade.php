@extends('template.master')

@section('title')
Absen {{ \Carbon\Carbon::parse($absen->created_at)->format('d-m-Y') }}
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{ route('absen.update', ['id_anggota' => $absen->id_anggota, 'id_absen' => $absen->id_absen]) }}">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Kehadiran</label>
                    <select class="form-control" name="absenshadir" id="kehadiranSelect">
                        <option value="hadir" @if($absen->absenshadir == 'hadir') selected @endif>Hadir</option>
                        <option value="tidak hadir" @if($absen->absenshadir == 'tidak hadir') selected @endif>Tidak Hadir</option>
                        <option value="alasan_lain" @if($absen->absenshadir != 'hadir' && $absen->absenshadir != 'tidak hadir') selected @endif>Alasan Lain</option>
                    </select>
                    <input type="text" name="absenshadir" class="form-control" id="alasanLainInput" value="{{ $absen->absenshadir }}" placeholder="Isi Disini Alasan Lain" @if($absen->absenshadir != 'hadir') style="display: none;" @elseif($absen->absenshadir != 'tidak hadir') style="display: none;" @endif>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>

<script>
    // Add an event listener to the select element
    document.getElementById('kehadiranSelect').addEventListener('change', function() {
        // Get the selected value
        var selectedValue = this.value;

        // Toggle the visibility of the input field based on the selected value
        if (selectedValue === 'alasan_lain') {
            document.getElementById('alasanLainInput').style.display = 'block';
        } else {
            document.getElementById('alasanLainInput').style.display = 'none';
            // If "hadir" is selected, set the input value to "hadir"
            if (selectedValue === 'hadir') {
                document.getElementById('alasanLainInput').value = 'hadir';
            }else if(selectedValue === 'tidak hadir'){
                document.getElementById('alasanLainInput').value = 'tidak hadir';
            }
        }
    });

    // Initially set the display property of the input field based on the default selected value
    var initialSelectedValue = document.getElementById('kehadiranSelect').value;
    if (initialSelectedValue === 'alasan_lain') {
        document.getElementById('alasanLainInput').style.display = 'block';
    }
</script>

@endsection

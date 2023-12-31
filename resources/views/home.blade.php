@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
      <h1 class="card-title">Halo, {{ Auth::user()->name }}</h1>

    </div>
  </div>

  <div class="row my-3">
    <div class="col-md-4">
      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <small class="text-muted mb-1">Jumlah Pengguna</small>
              <h3 class="card-title mb-0">{{count($Users)}}</h3>

            </div>

          </div> <!-- /. row -->
        </div> <!-- /. card-body -->
      </div> <!-- /. card -->
    </div> <!-- /. col -->

    <div class="col-md-4">
        <div class="card shadow mb-3">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col">
                <small class="text-muted mb-1">Jumlah Berita</small>
                <h3 class="card-title mb-0">{{count($Newss)}}</h3>

              </div>

            </div> <!-- /. row -->
          </div> <!-- /. card-body -->
        </div> <!-- /. card -->
      </div> <!-- /. col -->

    <div class="col-md-4">
      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <small class="text-muted mb-1">Jumlah Antrian</small>
              <h3 class="card-title mb-0">{{count($Queues)}}</h3>

            </div>
          </div> <!-- /. row -->
        </div> <!-- /. card-body -->
      </div> <!-- /. card -->
    </div> <!-- /. col -->
    <div class="col-md-4">
      <div class="card shadow mb-3">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <small class="text-muted mb-1">Belum Dilayani</small>
              <h3 class="card-title mb-0">{{count($startQueues)}}</h3>

            </div>
          </div> <!-- /. row -->
        </div> <!-- /. card-body -->
      </div> <!-- /. card -->
    </div> <!-- /. col -->

    <div class="col-md-4">
        <div class="card shadow mb-3">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col">
                <small class="text-muted mb-1">Sedang Dilayani</small>
                <h3 class="card-title mb-0">{{count($progressQueues)}}</h3>

              </div>
            </div> <!-- /. row -->
          </div> <!-- /. card-body -->
        </div> <!-- /. card -->
      </div> <!-- /. col -->


  <div class="col-md-4">
    <div class="card shadow mb-3">
      <div class="card-body">
        <div class="row align-items-center">
          <div class="col">
            <small class="text-muted mb-1">Sudah Dilayani</small>
            <h3 class="card-title mb-0">{{count($finishQueues)}}</h3>

          </div>
        </div> <!-- /. row -->
      </div> <!-- /. card-body -->
    </div> <!-- /. card -->
  </div> <!-- /. col -->
</div>

  <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header w-100">
                @if (session('message'))

                <strong id="msgId" hidden>{{ session('message') }}</strong>


                @endif
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h3">Antrian</h3>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table id="table-data" class="table table-stripped card-table table-vcenter text-nowrap table-data">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="35%">Pengguna</th>
                                <th width="35%">Antrian</th>
                                <th width="15%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($Queues) == 0)
                            <tr>
                                <td colspan="5" align="center">Data kosong</td>
                            </tr>
                            @else
                            @foreach ($Queues as $Queue)
                            <tr>
                                <td width="5%">{{ $loop->iteration }}</td>
                                <td width="35%">
                                    @foreach($Users as $User)
                                    @if ($User->id == $Queue->user_id)
                                    {{ $User->name }}
                                    @endif
                                    @endforeach
                                </td>
                                <td width="35%">{{ $Queue->queue_number }}</td>
                                <td width="15%">
                                    @if($Queue->queue_status == 2)
                                        <span class="btn btn-success text-white">Sudah dilayani</span>
                                    @elseif($Queue->queue_status == 1)
                                        <span class="btn btn-warning text-white">Sedang dilayani</span>
                                    @elseif($Queue->queue_status == 0)
                                        <span class="btn btn-danger text-white">Belum dilayani</span>
                                    @endif
                                </td>
                                <td width="15%">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#user{{$Queue->id}}">
                                        Layani
                                      </button>

                                      <div class="modal fade" id="user{{$Queue->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="staticBackdropLabel">
                                                @foreach($Users as $User)
                                                @if ($User->id == $Queue->user_id)
                                                {{ $User->name }}
                                                @endif
                                                @endforeach
                                              </h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('queue/update-status') }}/{{$Queue->id}}" method="POST" id="addForm">
                                                    @csrf
                                                    <div class="col-md-12" hidden>
                                                        <div class="form-group">
                                                                <label class="form-label">Pengguna</label>
                                                                <input type="text" class="form-control" name="user_id"
                                                                    id="user_id" placeholder="Masukan Pengguna"
                                                                    value="{{$Queue->user_id}}{{ old('user_id') }}">

                                                            </div>
                                                        </div>

                                                        <div class="col-md-12" hidden>
                                                            <div class="form-group">
                                                                    <label class="form-label">Prioritas Antrian</label>
                                                                    <input type="text" class="form-control" name="priority_number"
                                                                        id="priority_number" placeholder="Masukan Prioritas Antrian"
                                                                        value="{{$Queue->priority_number}}{{ old('priority_number') }}">

                                                                </div>
                                                            </div>

                                                    <div class="col-md-12" hidden>
                                                        <div class="form-group">
                                                                <label class="form-label">Posisi Antrian</label>
                                                                <input type="text" class="form-control" name="queue_number"
                                                                    id="queue_number" placeholder="Masukan Posisi Antrian"
                                                                    value="{{$Queue->queue_number}}{{ old('queue_number') }}">

                                                            </div>
                                                        </div>

                                                    <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Pilih Status </label>
                                                        <select class="form-control" name="queue_status" id="queue_status">
                                                            <option value="">- Pilih Status -</option>
                                                            @if($Queue->queue_status == 2)
                                                            <option value="2" selected>Sudah dilayani</option>
                                                            <option value="1">Sedang dilayani</option>
                                                            <option value="0">Belum dilayani</option>
                                                            @elseif($Queue->queue_status == 1)
                                                            <option value="2">Sudah dilayani</option>
                                                            <option value="1" selected>Sedang dilayani</option>
                                                            <option value="0">Belum dilayani</option>
                                                            @elseif($Queue->queue_status == 0)
                                                            <option value="2">Sudah dilayani</option>
                                                            <option value="1">Sedang dilayani</option>
                                                            <option value="0" selected>Belum dilayani</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                                              <button type="submit" class="btn btn-outline-success">Simpan</button>
                                            </div>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

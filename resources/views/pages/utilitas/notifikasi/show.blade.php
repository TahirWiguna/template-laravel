<div class="table-responsive">
  <table class="table table-borderless">
    <tr>
      <td>Kode</td>
      <th>{{ $data->kode }}</th>
    </tr>
    <tr>
      <td>Cabang</td>
      <th>{{ $data->cabang }}</th>
    </tr> 
    <tr>
      <td>Induk</td>
      <th>{{ $data?->induk?->kode }} - {{ $data?->induk?->cabang }}</th>
    </tr>  
    <tr>
      <td>Kota</td>
      <th>{{ $data->kota }}</th>
    </tr>  
    <tr>
      <td>Status</td>
      <th>{{ $data->status ? 'Aktif': 'Tidak Aktif' }}</th>
    </tr>  
    <tr>
      <td>Created By</td>
      <th>{{ $data?->createdBy?->namaDepan}} {{$data?->createdBy?->namaBelakang }}</th>
    </tr>
    <tr>
      <td>Updated By</td>
      <th>{{ $data?->updatedBy?->namaDepan}} {{$data?->updatedBy?->namaBelakang }}</th>
    </tr>
    <tr>
      <td>Created At</td>
      <th>{{ @$data->createdAt ? \Carbon\Carbon::parse($data->createdAt)->format('d-m-Y H:i:s') : '-' }}</th>
    </tr>
    <tr>
      <td>Updated At</td>
      <th>{{ @$data->updatedAt ? \Carbon\Carbon::parse($data->updatedAt)->format('d-m-Y H:i:s') : '-' }}</th>
    </tr>
  </table>
</div>
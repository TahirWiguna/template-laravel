<style>
  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 100%;
  }

  .boxes {
    width: 100%;
    border: dashed 1px #ccc;
    padding: 10px;
  }

  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ccc;
    padding-bottom: 10px;
  }

  .body {
    padding: 5px 0;
  }

  .readed {
    background-color: #eee;
  }

  .container p {
    margin: 0;
  }
</style>

<div class="container">
  @foreach ($data as $d)
    <div class="boxes {{ $d->is_readed ? 'readed' : '' }}">
      <div class="header">
        <span>{{ $d->header }}</span>
        <span style="font-size: 12px">{{ $d->created_at }}</span>
      </div>
      <div class="body">
        <p>{!! $d->body !!}</p>
      </div>
    </div>
  @endforeach
</div>

<div class="row">
    <div class="col">
        <div class="card p-4">
            <div class="row">
                <div class="col">
                    <h4 class="text-info">{{ $nota['title'] }}</h4>
                    <small class="text-secondary"><span class="opacity-75 me-2">Created at:</span><strong>{{ date('d-m-Y H:i:s', strtotime($nota['created_at'])) }}</strong></small>
                    @if ($nota['created_at'] != $nota['updated_at'])
                        <small class="text-secondary ms-5"><span class="opacity-75 me-2">Updated at:</span><strong>{{ date('d-m-Y H:i:s', strtotime($nota['updated_at'])) }}</strong></small>                        
                    @endif
                </div>
                <div class="col text-end">
                    <a href="{{ route('edit',['id' => Crypt::encrypt($nota['id'])]) }}" class="btn btn-outline-secondary btn-sm mx-1"><i class="fa-regular fa-pen-to-square"></i></a>
                    <a href="{{ route('delete',['id' => Crypt::encrypt($nota['id'])]) }}" class="btn btn-outline-danger btn-sm mx-1"><i class="fa-regular fa-trash-can"></i></a>
                </div>
            </div>
            <hr>
            <p class="text-secondary">
                {{ $nota['text']}}
            </p>
        </div>
    </div>
</div>

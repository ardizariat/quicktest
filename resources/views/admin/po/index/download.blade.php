<form target="_blank" action="{{ route('po.download-pdf', $data->id) }}" method="POST">
    @csrf
    <button type="submit" data-toggle="tooltip" data-placement="top" title="Download permintaan PB"
        class="btn btn-sm btn-outline-info">
        <i class="fas fa-download"></i>
    </button>
</form>

<a href="{{ admin_url("permissions/$id/edit") }}" class="btn btn-info"><i class="fa fa-edit"></i></a>
<form action="{{ route('permissions.destroy', $id) }}" method="POST" class="form-delete">
    @method('DELETE')
    @csrf
    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
</form>


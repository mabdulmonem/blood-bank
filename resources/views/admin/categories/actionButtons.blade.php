
<a href="{{ url("category/$id/".str_replace(' ','-',$name)) }}" class="btn btn-info" target="_blank"><i class="fa fa-eye"></i></a>
<a href="{{ admin_url("categories/$id/edit") }}" class="btn btn-info"><i class="fa fa-edit"></i></a>

<form action="{{ route('categories.destroy', $id) }}" method="POST" class="form-delete">
    @method('DELETE')
    @csrf
    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
</form>

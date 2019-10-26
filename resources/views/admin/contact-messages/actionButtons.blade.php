<a href="{{ admin_url("contact-messages/$id") }}" class="btn btn-info"><i class="fa fa-eye"></i></a>
<a href="{{ admin_url("replay/mail/$id") }}" class="btn btn-info" title="الرد على الرسالة"><i class="fa fa-edit"></i></a>
<form action="{{ route('contact-messages.destroy', $id) }}" method="POST" class="form-delete">
    @method('DELETE')
    @csrf
    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
</form>

